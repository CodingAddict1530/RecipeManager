<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? null;
    $cuisine = $_POST['cuisine'] ?? null;
    $dietary_preference = $_POST['dietary_preference'] ?? null;
    $ingredients = $_POST['ingredients'] ?? null;
    $user_id = $_SESSION['user_id'];

    if ($name && $cuisine && $dietary_preference && $ingredients) {
        $sql = "INSERT INTO recipes (name, cuisine, dietary_preference, ingredients, user_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $cuisine, $dietary_preference, $ingredients, $user_id);

        if ($stmt->execute()) {
            echo "Recipe saved!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "All fields are required.";
    }
}
?>

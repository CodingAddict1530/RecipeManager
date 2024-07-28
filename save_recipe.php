<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $cuisine = $_POST['cuisine'];
    $dietary_preference = $_POST['dietary_preference'];
    $ingredients = $_POST['ingredients'];
    $user_id = $_SESSION['user_id'];

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
}
?>

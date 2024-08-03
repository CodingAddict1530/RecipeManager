<?php // add_recipe.php
session_start();
require_once 'db_connection.php'; // Adjust path as needed

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $recipe_name = $_POST['recipe_name'];
    $recipe_details = $_POST['recipe_details'];

    $stmt = $conn->prepare("INSERT INTO recipes (user_id, name, details) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $recipe_name, $recipe_details);
    $stmt->execute();

    // Redirect to homepage with success message
    echo "<script>
        alert('Recipe Added Successfully. Press OK to go back to homepage.');
        window.location.href = 'homepage.php';
    </script>";
}
?>
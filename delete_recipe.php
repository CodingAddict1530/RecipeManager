<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipe_id = $_POST['id'];
    
    if (!empty($recipe_id)) {
        $sql = "DELETE FROM recipes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            die("Error preparing SQL statement: " . $conn->error);
        }
        
        $stmt->bind_param("i", $recipe_id);
        
        if ($stmt->execute()) {
            header("Location: home.php"); // Redirect to homepage after deletion
            exit;
        } else {
            die("Error executing SQL statement: " . $stmt->error);
        }
        
        $stmt->close();
    } else {
        die("No recipe ID provided.");
    }
} else {
    die("Invalid request method.");
}

$conn->close();
?>

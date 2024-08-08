<?php
// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session to manage user login state
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.html");
    exit; // Terminate the script to ensure the redirect happens
}

// Include the database connection file
include 'db.php';

// Check if the form was submitted using POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the recipe ID from the POST data
    $recipe_id = $_POST['id'];
    
    // Check if the recipe ID is not empty
    if (!empty($recipe_id)) {
        // Prepare an SQL statement to delete the recipe from the database
        $sql = "DELETE FROM recipes WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        // Check if the statement preparation was successful
        if ($stmt === false) {
            die("Error preparing SQL statement: " . $conn->error);
        }
        
        // Bind the recipe ID parameter to the SQL query
        $stmt->bind_param("i", $recipe_id);
        
        // Execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to the homepage after successful deletion
            header("Location: home.php");
            exit; // Terminate the script to ensure the redirect happens
        } else {
            // Handle execution errors
            die("Error executing SQL statement: " . $stmt->error);
        }
        
        // Close the prepared statement
        $stmt->close();
    } else {
        // Handle the case where no recipe ID was provided
        die("No recipe ID provided.");
    }
} else {
    // Handle invalid request methods (not POST)
    die("Invalid request method.");
}

// Close the database connection
$conn->close();
?>

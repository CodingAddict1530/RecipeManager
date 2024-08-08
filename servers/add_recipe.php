<?php 
// add_recipe.php

// Start the session to manage user login state
session_start();

// Include the database connection file
require_once 'db.php'; // Adjust path as needed

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.html");
    exit(); // Terminate the script to ensure the redirect happens
}

// Check if the form was submitted using POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];
    
    // Get the recipe name and details from the POST data
    $recipe_name = $_POST['recipe_name'] ?? '';
    $recipe_details = $_POST['recipe_details'] ?? '';

    // Validate inputs
    if (empty($recipe_name) || empty($recipe_details)) {
        echo "<script>
            alert('Both recipe name and details are required.');
            window.history.back();
        </script>";
        exit();
    }

    // Prepare an SQL statement to insert the new recipe into the database
    $stmt = $conn->prepare("INSERT INTO recipes (user_id, name, details) VALUES (?, ?, ?)");

    if ($stmt) {
        // Bind the parameters to the SQL query (user ID, recipe name, and recipe details)
        $stmt->bind_param("iss", $user_id, $recipe_name, $recipe_details);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to the homepage with a success message using JavaScript
            echo "<script>
                alert('Recipe Added Successfully. Press OK to go back to homepage.');
                window.location.href = 'homepage.php';
            </script>";
        } else {
            // Handle SQL execution error
            echo "<script>
                alert('Error adding recipe: " . $stmt->error . "');
                window.history.back();
            </script>";
        }
        $stmt->close();
    } else {
        // Handle preparation error
        echo "<script>
            alert('Error preparing statement: " . $conn->error . "');
            window.history.back();
        </script>";
    }
}
?>

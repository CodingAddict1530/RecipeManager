<?php
// Start the session to manage user login state
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Display a message if the user is not logged in
    echo "User not logged in.";
    exit; // Terminate the script
}

// Include the database connection file
include 'db.php';

// Check if the form was submitted using POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data, using null coalescing operator to handle missing fields
    $name = $_POST['name'] ?? null;
    $cuisine = $_POST['cuisine'] ?? null;
    $dietary_preference = $_POST['dietary_preference'] ?? null;
    $ingredients = $_POST['ingredients'] ?? null;
    
    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];

    // Check if all required fields are filled
    if ($name && $cuisine && $dietary_preference && $ingredients) {
        // Prepare an SQL statement to insert the new recipe into the database
        $sql = "INSERT INTO recipes (name, cuisine, dietary_preference, ingredients, user_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        // Bind the parameters to the SQL query
        $stmt->bind_param("ssssi", $name, $cuisine, $dietary_preference, $ingredients, $user_id);

        // Execute the prepared statement and check for success
        if ($stmt->execute()) {
            echo "Recipe saved!"; // Display a success message
        } else {
            // Display an error message if the execution fails
            echo "Error: " . $stmt->error;
        }

        // Close the prepared statement
        $stmt->close();
        
        // Close the database connection
        $conn->close();
    } else {
        // Display an error message if any required field is missing
        echo "All fields are required.";
    }
}
?>

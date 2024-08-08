<?php
// Start the session to manage user login state
session_start();

// Include the database connection file
include 'db.php';

// Check if the form was submitted using POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the email and password from the POST data
    $email = $_POST['email'];
    $password = $_POST['pass'];

    // Prepare an SQL statement to select the user by email
    $sql = "SELECT id, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    // Bind the email parameter to the SQL query
    $stmt->bind_param("s", $email);
    
    // Execute the prepared statement
    $stmt->execute();
    
    // Store the result of the query
    $stmt->store_result();
    
    // Bind the result to variables
    $stmt->bind_result($id, $hashed_password);
    
    // Fetch the result
    $stmt->fetch();

    // Check if a user was found and the password matches
    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        // Start a new session and store the user ID in the session
        session_start();
        $_SESSION['user_id'] = $id;
        
        // Redirect to the homepage
        header("Location: home.php");
        exit; // Terminate the script to ensure the redirect happens
    } else {
        // Display an error message if the login credentials are invalid
        echo "Invalid email or password.";
    }

    // Close the prepared statement
    $stmt->close();
    
    // Close the database connection
    $conn->close();
}
?>

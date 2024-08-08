<?php
// Start the session to access session variables
session_start();

// Unset all session variables
session_unset();

// Destroy the session to log out the user
session_destroy();

// Redirect to the login page
header("Location: ../html/login.html");
exit(); // Terminate the script to ensure the redirect happens
?>

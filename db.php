<?php
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "recipemanager";

// Create connection
$conn = mysqli_connect($servername, $username, $password);
mysqli_select_db($conn, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

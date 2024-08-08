<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging: Print the POST array
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    // Check if all required fields are set and not empty
    if (isset($_POST['email']) && isset($_POST['login']) && isset($_POST['pass']) && !empty($_POST['email']) && !empty($_POST['login']) && !empty($_POST['pass'])) {
        $email = $_POST['email'];
        $username = $_POST['login'];
        $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (email, username, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $username, $password);

        if ($stmt->execute()) {
            // Redirect to login page
            header("Location: ../html/login.html");
            exit;
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

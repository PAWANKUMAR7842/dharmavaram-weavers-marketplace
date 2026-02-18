<?php
session_start();

// DB connection
$conn = new mysqli("localhost", "root", "", "dmm_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$email = $_POST['login-email'];
$password = $_POST['login-password'];

// Check user
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Password correct, redirect to index.html
        $_SESSION['user_id'] = $user['id'];
        header("Location: ../html/index.html");
        exit();
    } else {
        echo "Incorrect password.";
    }
} else {
    echo "Email not found.";
}

$stmt->close();
$conn->close();
?>

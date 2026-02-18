<?php
// submit_feedback.php

// Database credentials
$host = "localhost";
$username = "root"; // your DB username
$password = "";     // your DB password
$database = "dmm_db";

// Connect to MySQL
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and sanitize
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    // Insert into database
    $sql = "INSERT INTO feedback (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Success
        echo "<script>
                alert('Thank you for your feedback!');
                window.location.href='../html/feedback.html';
              </script>";
    } else {
        // Error
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

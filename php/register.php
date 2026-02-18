<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // PHPMailer

session_start();

// DB connection
$conn = new mysqli("localhost", "root", "", "dmm_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$first_name = $_POST['register-fname'];
$last_name = $_POST['register-lname'];
$email = $_POST['register-email'];
$phone = $_POST['register-phone'];
$password = $_POST['register-password'];
$confirm_password = $_POST['register-confirm-password'];

// Check password match
if ($password !== $confirm_password) {
    die("Passwords do not match");
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into database
$stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $hashed_password);

if ($stmt->execute()) {
    // Send email
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // replace with your SMTP
        $mail->SMTPAuth = true;
       $mail->Username   = 'pawankothavala7842@gmail.com'; // ✔ Gmail
                $mail->Password   = 'your email password';    // your email password / app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('your_email@gmail.com', 'Dharmavaram Weavers');
        $mail->addAddress($email, $first_name);
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to Dharmavaram Weavers Marketplace';
        $mail->Body    = "Hi $first_name,<br><br>Thank you for registering on our website!<br>Happy Shopping!<br><br>Dharmavaram Weavers Marketplace";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    // Redirect to login
    header("Location: ../html/login.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

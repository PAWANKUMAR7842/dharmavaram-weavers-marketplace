<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Composer autoload

session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../index.php");
    exit();
}

// DB connection
$conn = new mysqli("localhost", "root", "", "dmm_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$order_id = $_POST['order_id'];
$new_status = $_POST['status'];

// Get order details
$stmt = $conn->prepare("SELECT customer_name, email FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($customer_name, $customer_email);
$stmt->fetch();

if($stmt->num_rows == 0){
    die("Order not found");
}
$stmt->close();

// Update order status
$update_stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
$update_stmt->bind_param("si", $new_status, $order_id);

if($update_stmt->execute()){
    // Send email to user
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // replace with your SMTP if needed
        $mail->SMTPAuth = true;
        $mail->Username = 'pawankothavala7842@gmail.com'; // your Gmail
        $mail->Password = 'mpktbbyevlavjvrw'; // app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('pawankothavala7842@gmail.com', 'Dharmavaram Weavers');
        $mail->addAddress($customer_email, $customer_name);

        $mail->isHTML(true);
        $mail->Subject = "Order #$order_id Status Updated";
        $mail->Body = "Hi $customer_name,<br><br>Your order #$order_id status has been updated to <b>$new_status</b>.<br><br>Thank you for shopping with us!<br><br>Dharmavaram Weavers Marketplace";

        $mail->send();
        echo "Order status updated and email sent to $customer_email";
    } catch (Exception $e) {
        echo "Order status updated but email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Failed to update order status: " . $update_stmt->error;
}

$update_stmt->close();
$conn->close();
?>

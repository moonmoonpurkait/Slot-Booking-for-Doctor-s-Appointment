<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

session_start();
require_once('./connection.php');

if (!$con) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

if (isset($_POST['email'], $_POST['password'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // Check if the email is already registered
    $stmt = $con->prepare("SELECT * FROM info WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Already registered.']);
        exit;
    } else {
        // Delete existing OTP record if it exists
        $delete_stmt = $con->prepare("DELETE FROM otp WHERE email = ?");
        $delete_stmt->bind_param("s", $email);
        $delete_stmt->execute();
        
        // Generate a 6-digit OTP
        $otp = rand(111111, 999999);

        // Insert the new OTP into the `otp` table
        $insert_stmt = $con->prepare("INSERT INTO otp (email, pass, otp) VALUES (?, ?, ?)");
        $insert_stmt->bind_param("sss", $email, $password, $otp);
        $insert_stmt->execute();

        $msg = "Your OTP verification code is " . $otp;
        $_SESSION['EMAIL'] = $email;

        // Send the OTP email
        if (smtp_mailer($email, 'OTP Verification', $msg)) {
            echo json_encode(['status' => 'success', 'message' => 'OTP sent successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP.']);
        }
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Email and password are required.']);
}

// Function to send the OTP email
function smtp_mailer($to, $subject, $msg) {
    $mail = new PHPMailer(true);
    try {
        $mail->IsSMTP();
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com'; 
        $mail->Port = 465;
        $mail->IsHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Username = 'dummyotp20@gmail.com'; // Use environment variable
        $mail->Password = 'ltmmithvtnjksjuj'; // Use environment variable
        $mail->SetFrom("dummyotp20@gmail.com", "Login verification");
        $mail->Subject = $subject;
        $mail->Body = $msg;
        $mail->AddAddress($to);

        if (!$mail->Send()) {
            error_log("Mailer Error: " . $mail->ErrorInfo);
            return false;
        }
        return true;
    } catch (Exception $e) {
        error_log("Exception in smtp_mailer: " . $e->getMessage());
        return false;
    }
}
?>

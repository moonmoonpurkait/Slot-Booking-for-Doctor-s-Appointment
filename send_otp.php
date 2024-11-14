<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

session_start();
$con = mysqli_connect('localhost', 'root', '', 'teledoc');

if (!$con) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
    
    $stmt = $con->prepare("SELECT * FROM info WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $otp = rand(111111, 999999);
        $update_stmt = $con->prepare("UPDATE info SET otp = ? WHERE email = ?");
        $update_stmt->bind_param("ss", $otp, $email);
        $update_stmt->execute();
        
        $msg = "Your OTP verification code is " . $otp;
        $_SESSION['EMAIL'] = $email;

        if (smtp_mailer($email, 'OTP Verification', $msg)) {
            echo json_encode(['status' => 'success', 'message' => 'OTP sent successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Email is required.']);
}

function smtp_mailer($to, $subject, $msg) {
    $mail = new PHPMailer(true);
    try {
        $mail->IsSMTP();
        $mail->SMTPDebug = 0; // Set to 0 for production
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

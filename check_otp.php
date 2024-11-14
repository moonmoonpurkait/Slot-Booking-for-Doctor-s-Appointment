<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'teledoc');

if (!$con) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

if (isset($_POST['otp']) && isset($_SESSION['EMAIL'])) {
    $otp = trim($_POST['otp']);
    $email = $_SESSION['EMAIL'];

    $stmt = $con->prepare("SELECT * FROM info WHERE email = ? AND otp = ?");
    $stmt->bind_param("ss", $email, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $update_stmt = $con->prepare("UPDATE info SET otp = '' WHERE email = ?");
        $update_stmt->bind_param("s", $email);
        $update_stmt->execute();
        
        $_SESSION['IS_LOGIN'] = $email;
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid OTP.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'OTP is required.']);
}
?>

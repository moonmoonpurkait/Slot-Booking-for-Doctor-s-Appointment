<?php
session_start();
$con = new mysqli('localhost', 'root', '', 'teledoc');

if ($con->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

if (isset($_POST['email'], $_POST['password'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare the statement to prevent SQL injection
    $stmt = $con->prepare("SELECT * FROM info WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password using password_verify()
        if ($password === $user['pass']) {
            // Create session variables upon successful login
            $_SESSION['username'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['validate'] = true;

            echo json_encode(['status' => 'success', 'message' => 'Login successful']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Incorrect password.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email not found.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Email and Password are required.']);
}

$con->close();

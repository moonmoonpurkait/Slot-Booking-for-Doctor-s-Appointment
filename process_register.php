<?php
session_start();
require_once('./connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Reset validation status
    $_SESSION['validate'] = false; 

    $email = $_POST['email'];
    $username = $_POST['username']; // Ensure this is captured from the AJAX call
    $password = trim($_POST['password']);
    $otp = $_POST['otp'];

    // Prepare the SQL statement to fetch user details
    $p = Amwell::connect()->prepare('SELECT * FROM otp WHERE email=:e');
    $p->bindValue(':e', $email);
    $p->execute();
    $user = $p->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $storedOTP = $user['otp'];
        if ($otp == $storedOTP) { 
            // Hash the password before storing it
            // $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = Amwell::connect()->prepare('INSERT INTO info (email, name, pass, user_type) VALUES (:e, :u, :p, 2)');
            // Bind parameters
            $stmt->bindParam(':e', $email);
            $stmt->bindParam(':u', $username);
            $stmt->bindParam(':p', $password); // Use hashed password

            // Execute the query
            if ($stmt->execute()) {
                // Optionally delete the OTP entry from the database
                $delete_stmt = Amwell::connect()->prepare("DELETE FROM otp WHERE email = :e");
                $delete_stmt->bindParam(':e', $email);
                $delete_stmt->execute();
                
                // Prepare a success response
                echo json_encode(['status' => 'success', 'message' => 'Registration successful!']);
                exit; // Ensure you exit after sending a response
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error occurred during registration.']);
                exit;
            }
        } else {  
            echo json_encode(['status' => 'error', 'message' => 'Invalid OTP!']);
            error_log("Invalid OTP entered by user: $email");
            // Optionally delete the OTP entry after failed attempt
            $delete_stmt = Amwell::connect()->prepare("DELETE FROM otp WHERE email = :e");
            $delete_stmt->bindParam(':e', $email);
            $delete_stmt->execute();
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error occurred. Try again later!']);
        error_log("No user found with email: $email");
    }
}
?>

<?php
require_once('./connection.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("You are not logged in. Please login first.");</script>';
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$appointment_date = isset($_POST['appointment_date']) ? $_POST['appointment_date'] : null;
$appointment_time = isset($_POST['appointment_time']) ? $_POST['appointment_time'] : null;
$doctor_id = isset($_POST['doc_id']) ? $_POST['doc_id'] : null;
$charge = isset($_POST['cost']) ? $_POST['cost'] : null;
$username = isset($_POST['username']) ? $_POST['username'] : null;

// Check if appointment details are missing
if (!$appointment_date || !$appointment_time || !$doctor_id || !$charge) {
    echo '<script>alert("Missing appointment information.");</script>';
    header('Location: book_appointment.php'); // Redirect back to booking page if any field is missing
    exit();
}

try {
    // Connect to the database
    $conn = Amwell::connect();

    // Insert the data into the database
    $query = "INSERT INTO doctor_availablity (user_id, doc_id, cost, date, appointment_time) 
              VALUES (:user_id, :doctor_id, :charge, :appointment_date, :appointment_time)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':doctor_id', $doctor_id);
    $stmt->bindParam(':charge', $charge);
    $stmt->bindParam(':appointment_date', $appointment_date);
    $stmt->bindParam(':appointment_time', $appointment_time);
    $stmt->execute();

    $successMessage = "Thank you for booking your appointment. Your appointment is confirmed.";
} catch (PDOException $e) {
    // Handle any errors
    echo 'Error: ' . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Booking Confirmation</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5 text-center">
        <?php if (isset($successMessage)): ?>
            <h1 class="mb-4">Booking Successful!</h1>
            <p class="lead"><?php echo htmlspecialchars($successMessage); ?></p>
            <a href="index.php" class="btn btn-primary">Go to Homepage</a>
        <?php else: ?>
            <h1 class="mb-4">Something went wrong!</h1>
            <p class="lead">Please try again later.</p>
        <?php endif; ?>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

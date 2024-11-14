<?php
session_start();
require_once('./connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    try {

        $pdo = Amwell::connect();
        // Insert form data into the contact_us table
        $stmt = $pdo->prepare("INSERT INTO contact_us (name, email, subject, message) VALUES (:name, :email, :subject, :message)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':message', $message);
        $stmt->execute();

        $successMessage = "Thank you! Your message has been sent successfully.";
    } catch (PDOException $e) {
        $errorMessage = "Failed to send your message. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'template/nav-bar.php'; ?>

    <div class="container text-center mt-5">
        <?php if (isset($successMessage)): ?>
            <h1 class="text-success"><?php echo $successMessage; ?></h1>
        <?php elseif (isset($errorMessage)): ?>
            <h1 class="text-danger"><?php echo $errorMessage; ?></h1>
        <?php endif; ?>
        <a href="index.php" class="btn btn-primary">Go to Homepage</a>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
    
</body>
</html>

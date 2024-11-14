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
$doctor_id = isset($_GET['doc_id']) ? $_GET['doc_id'] : null;
$charge = isset($_GET['charge']) ? $_GET['charge'] : null;

if (!$doctor_id || !$charge) {
    echo '<script>alert("Missing appointment information.");</script>';
    header('Location: search.php'); // Redirect to search page if doctor info is missing
    exit();
}

try {
    // Connect to the database
    $conn = Amwell::connect();

    // Fetch the user's name
    $usernameQuery = "SELECT name FROM info WHERE user_type = 2 AND id = :user_id"; // Assuming 'info' table stores user details
    $usernameStmt = $conn->prepare($usernameQuery);
    $usernameStmt->bindParam(':user_id', $user_id);
    $usernameStmt->execute();
    $userRow = $usernameStmt->fetch(PDO::FETCH_ASSOC);
    $username = $userRow['name'];

    // Fetch doctor's available start and end time from the doctor table
    $doctorQuery = "SELECT name, TimeStart, TimeEnd FROM doctor WHERE IndexNumber = :doctor_id";
    $doctorStmt = $conn->prepare($doctorQuery);
    $doctorStmt->bindParam(':doctor_id', $doctor_id);
    $doctorStmt->execute();
    $doctorData = $doctorStmt->fetch(PDO::FETCH_ASSOC);

    if (!$doctorData) {
        echo '<script>alert("Doctor not found.");</script>';
        header('Location: search.php');
        exit();
    }

    $doctor_name = $doctorData['name'];  // Fetch doctor name
    $start_time = $doctorData['TimeStart'];  // Example: '08:00'
    $end_time = $doctorData['TimeEnd'];      // Example: '16:00'

    // Generate time slots for the doctor based on start and end time
    $available_times = [];
    $current_time = strtotime($start_time);
    $end_time = strtotime($end_time);
    // Subtract 30 minutes from the end time
    $end_time = strtotime('-30 minutes', $end_time);

    // Time interval between slots (e.g., 30 minutes)
    $interval = 30 * 60;  // 30 minutes in seconds
    
    while ($current_time <= $end_time) {
        $available_times[] = date('H:i', $current_time);
        $current_time = strtotime('+30 minutes', $current_time);  // Increment by 30 minutes
    }
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
    <title>Book Appointment</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
<style>
    /* Custom styles */
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        padding: 0 10px; /* Add some padding on smaller screens */
    }

    .payment-form {
        max-width: 400px;
        width: 100%; /* Ensure the form doesn't exceed the container's width */
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    /* Styles for tablet screens (up to 768px) */
    @media (max-width: 768px) {
        .payment-form {
            max-width: 90%; /* Increase form width on tablets */
            padding: 15px; /* Reduce padding for tablet screens */
        }

        input[type="date"],
        select {
            padding: 8px; /* Reduce padding on mobile for compactness */
        }
    }

    /* Styles for mobile screens (up to 576px) */
    @media (max-width: 576px) {
        .payment-form {
            max-width: 100%; /* Make form width 100% on mobile */
            padding: 10px; /* Further reduce padding on mobile */
        }

        input[type="date"],
        select {
            padding: 8px; /* Reduce padding on mobile for compactness */
        }
    }

    /* Styles for laptop screens (min-width 769px and max-width 1024px) */
    @media (min-width: 769px) and (max-width: 1024px) {
        .payment-form {
            max-width: 70%; /* Make the form slightly wider on laptops */
            padding: 20px; /* Maintain comfortable padding on laptops */
        }

        input[type="date"],
        select {
            padding: 10px; /* Comfortable padding on laptops */
        }
    }

    /* Styles for larger laptops/desktops (min-width 1025px) */
    @media (min-width: 1025px) {
        .payment-form {
            max-width: 50%; /* Keep the form narrow on larger screens */
            padding: 25px; /* Increase padding for larger screens */
        }

        input[type="date"],
        select {
            padding: 12px; /* Increase padding on larger devices */
        }
    }

    /* Styles for input fields (date and time picker) */
    input[type="date"],
    select {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    /* Change border color on focus */
    input[type="date"]:focus,
    select:focus {
        border-color: #007bff;
        outline: none;
    }

    /* Custom styles for date picker */
    input[type="date"] {
        background-color: #fff;
    }

    /* Custom styles for the select (time picker) */
    select {
        background-color: #fff;
        cursor: pointer;
    }

    /* Responsive styles for mobile devices */
    @media (max-width: 768px) {
        .payment-form {
            width: 100%;
            padding: 15px;
        }

        input[type="date"],
        select {
            padding: 8px;
        }
    }
</style>


</head>

<body>
    <div class="container my-5">
    <div class="payment-form">
        
        <h1 class="text-center">Book Appointment</h1>
        <form method="POST" action="book_appointment_process.php">
            <ul class="list-unstyled">
                <li><strong>User Name: </strong> <?php echo htmlspecialchars($username); ?></li>
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                <input type="hidden" name="doc_id" value="<?php echo htmlspecialchars($doctor_id); ?>">
                <input type="hidden" name="cost" value="<?php echo htmlspecialchars($charge); ?>">

                <!-- Add a date input field for selecting the preferred appointment date -->
                <li>
                    <label for="appointment_date"><strong>Preferred Appointment Date:</strong></label>
                    <input type="date" id="appointment_date" name="appointment_date" required min="<?php echo date('Y-m-d'); ?>">
                </li>

                <!-- Time Slot Selection -->
                <li>
                    <label for="appointment_time"><strong>Preferred Appointment Time:</strong></label>
                    <select name="appointment_time" id="appointment_time" required>
                        <option value="">Select a time</option>
                        <?php foreach ($available_times as $time): ?>
                            <option value="<?php echo htmlspecialchars($time); ?>"><?php echo htmlspecialchars($time); ?></option>
                        <?php endforeach; ?>
                    </select>
                </li>

                <li><strong>Doctor Name: </strong> <?php echo htmlspecialchars($doctor_name); ?></li>
                <li><strong>Charge:</strong> Rs. <?php echo htmlspecialchars($charge); ?></li>
            </ul>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Confirm Booking</button>
            </div>
        </form>
    </div>
    </div>
</body>

</html>

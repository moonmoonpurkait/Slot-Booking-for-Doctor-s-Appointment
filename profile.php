<?php
require_once('./connection.php');
session_start();

try {
    $conn = Amwell::connect();

    // Fetch user details
    $query = "SELECT * FROM info WHERE user_type = 2 AND id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch appointment details
    $query = "SELECT d.name, da.appointment_time, da.date, da.cost, da.app_id FROM doctor d INNER JOIN doctor_availablity da ON da.doc_id = d.IndexNumber WHERE da.user_id = :user_id";
    $ccstmt = $conn->prepare($query);
    $ccstmt->bindParam(':user_id', $_SESSION['user_id']);
    $ccstmt->execute();

    // Handle delete request
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['app_id'])) {
        // Delete appointment
        $query = "DELETE from doctor_availablity where app_id = :app_id;";
        $appstmt = $conn->prepare($query);
        $appstmt->bindParam(':app_id', $_POST['app_id']);
        $appstmt->execute();

        // Redirect to the same page to refresh
        header('Location: profile.php');
        exit();
    }

} catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <title>Profile</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">  

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
<style>
    .card {
        margin-top: 50px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .card-header {
        background-color: #8ecae6;
        color: white;
        border-radius: 10px 10px 0 0;
    }

    .card-footer {
        background-color: #f8f9fa;
        border-top: none;
        border-radius: 0 0 10px 10px;
    }

    .btn {
        border-radius: 20px;
        padding: 8px 20px;
        font-weight: bold;
    }

    /* Tablet view (up to 768px) */
    @media (max-width: 768px) {
        .card {
            margin-top: 30px; /* Reduce margin on smaller screens */
        }

        .card-header {
            font-size: 18px; /* Adjust font size */
        }

        .btn {
            font-size: 14px; /* Smaller button font size */
            padding: 6px 16px; /* Smaller padding */
        }
    }

    /* Mobile view (up to 576px) */
    @media (max-width: 576px) {
        .card {
            margin-top: 20px; /* Even smaller margin on mobile */
        }

        .card-header {
            font-size: 16px; /* Further reduce header font size */
        }

        .card-footer {
            font-size: 14px; /* Adjust footer font size */
        }

        .btn {
            font-size: 12px; /* Smaller font for mobile */
            padding: 5px 14px; /* Smaller button padding */
        }
    }
</style>

</head>
<body>

<?php include 'template/nav-bar.php'; ?> 

<!-- Navbar Start -->
<div class="container-fluid sticky-top bg-white shadow-sm">
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0">
            <a href="index.php" class="navbar-brand">
                <h1 class="m-0 text-uppercase text-primary"><i class="fa fa-clinic-medical me-2"></i>Medinova</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto py-0">
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="about.php" class="nav-item nav-link">About</a>
                    <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Sitemap</a>
                            <div class="dropdown-menu m-0">
                                <a href="service.php" class="dropdown-item">Service</a>
                                <a href="price.php" class="dropdown-item">Pricing</a>
                                <a href="team.php" class="dropdown-item">The Team</a>
                                <a href="testimonial.php" class="dropdown-item">Testimonial</a>
                                <a href="appointment.php" class="dropdown-item">Appointment</a>
                                <a href="search.php" class="dropdown-item">Search Doctor</a>
                                <a href="help_section.php" class="dropdown-item">Help</a>
                            </div>
                    </div>
                    <?php if(isset($_SESSION['username'])): ?>
                        <div class="nav-item">
                            <a class="nav-link active" href="profile.php">Profile</a>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link" href="logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a>
                        </div>
                    <?php else: ?>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Login / Register</a>
                            <div class="dropdown-menu m-0">
                                <a href="login.php" class="dropdown-item active">Login</a>
                                <a href="register.php" class="dropdown-item">New User</a>
                                <a href="doctor/index.php" class="dropdown-item">Doctor Login</a>
                                <a href="admin/index.php" class="dropdown-item">Admin</a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <a href="contact.php" class="nav-item nav-link">Contact</a>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Profile</h3>
                </div>
                <div class="card-body">
                    <div class="form-group d-flex flex-column">
                        <label for="username" class="font-weight-bold">Username:</label>
                        <input type="text" readonly class="form-control" id="username" value="<?php echo htmlspecialchars($user['name']); ?>">
                    </div>
                    <div class="form-group d-flex flex-column">
                        <label for="email" class="font-weight-bold">Email:</label>
                        <input type="email" readonly class="form-control" id="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                    </div>
                    <!-- Table to display appointment details -->
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Appointment Time</th>
                                    <th>Date</th>
                                    <th>Cost</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($user_details = $ccstmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user_details['name']); ?></td>
                                        <td><?php echo date('g:i A', strtotime($user_details['appointment_time'])); ?></td> <!-- Displaying appointment time -->
                                        <td><?php echo date('j F, Y', strtotime($user_details['date'])); ?></td>
                                        <td><?php echo htmlspecialchars($user_details['cost']); ?></td>
                                        <td>
                                            <form method="post" action="profile.php">
                                                <input type="hidden" name="app_id" value="<?php echo htmlspecialchars($user_details['app_id']); ?>">
                                                <button type="submit" class="btn btn-danger btn-sm">Delete Booking</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

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
    <script src="js/main.js"></script>
    
</body>
</html>

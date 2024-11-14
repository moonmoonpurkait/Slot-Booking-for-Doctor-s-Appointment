<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Help</title>
    <meta charset="utf-8">

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
                            <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Sitemap</a>
                            <div class="dropdown-menu m-0">
                                <a href="service.php" class="dropdown-item">Service</a>
                                <a href="price.php" class="dropdown-item">Pricing</a>
                                <a href="team.php" class="dropdown-item">The Team</a>
                                <a href="testimonial.php" class="dropdown-item">Testimonial</a>
                                <a href="appointment.php" class="dropdown-item">Appointment</a>
                                <a href="search.php" class="dropdown-item">Search Doctor</a>
                                <a href="help_section.php" class="dropdown-item active">Help</a>
                            </div>
                        </div>
                        <?php if(isset($_SESSION['username'])): ?>
                            <div class="nav-item">
                                <a class="nav-link" href="profile.php">Profile</a>
                            </div>
                            <div class="nav-item">
                                <a class="nav-link" href="logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a>
                            </div>
                        <?php else: ?>
                            <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Login / Register</a>
                            <div class="dropdown-menu m-0">
                                <a href="login.php" class="dropdown-item">Login</a>
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

    <div class="container-fluid pt-5">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Help Section</h5>
                <h1 class=" mb-4">For any problem contact here.</h1>
                <h5 class="fw-normal"> Need assistance? Explore our Contact Section for answers to common questions, appointment guidance, and personalized support options. </h5>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width: 500px;">
            <h5 class="mb-4 border-bottom border-5" style="font-size: 2em;">Search a doctor</h5>
            <img src="img/search.jpg" width="800px" height="500px" alt="" style="margin-left: -200px; margin-bottom: 0px">
        </div>
        <div class="text-center mx-auto mb-5" style="max-width: 500px">
            <h5 class="mb-4 border-bottom border-5" style="margin-top: -100px; font-size: 2em;"></h5>
            <h5 class="mb-4 border-bottom border-5" style=" font-size: 2em;">Book Appointment</h5>
            <img src="img/book.jpg" width="800px" height="500px" alt="" style="margin-left: -250px;">
        </div>
    </div>

    <?php include 'template/footer.php' ?>

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
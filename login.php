<?php
session_start();
require('connection.php');

if (isset($_POST['submit_btn'])) {
    $_SESSION['validate'] = false; // Reset validation status
    $username = $_POST['email'];
    $otp = $_POST['otp'];

    // Prepare the SQL statement to fetch user details
    $p = Amwell::connect()->prepare('SELECT * FROM info WHERE email=:u AND user_type=2');
    $p->bindValue(':u', $username);
    $p->execute();
    $user = $p->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        $storedOTP = $user['otp'];
        
        // Debugging information
        error_log("Stored OTP: $storedOTP, Provided OTP: $otp");
        
        if ($otp == $storedOTP) { // Using == to handle both string and integer comparison
            // Set session variables upon successful OTP verification
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['validate'] = true;

            // Debugging: log session variables
            error_log("Session created: username = {$_SESSION['username']}, user_id = {$_SESSION['user_id']}");

            // Redirect to the index page
            header('Location: index.php');
            exit;
        } else {  
            $error_message = "Invalid OTP!";
            error_log("Invalid OTP entered by user: $username");
        }
    } else {
        $error_message = "Error occurred. Try again later!";
        error_log("No user found with email: $username");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
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

    <style>
    .otp_box { 
        display: none; 
    }

    #email_error {
        font-size: large;
        color: #3f51b5;
    }

    /* Tablet view (up to 768px) */
    @media (max-width: 768px) {
        #email_error {
            font-size: medium; /* Slightly smaller font size for tablets */
        }
    }

    /* Mobile view (up to 576px) */
    @media (max-width: 576px) {
        #email_error {
            font-size: small; /* Smaller font size for mobile */
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
                                <a class="nav-link" href="profile.php">Profile</a>
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

    <div class="container mt-5 main-content">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1>Login </h1>
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input required type="text" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="mb-3 hide_label">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </br>
                        <button type="button" class="btn btn-primary" id="login" onclick="verify_password()">Login</button>
                        <button type="button" class="btn btn-primary" id="loginOTP" onclick="sendOtp()">Login using OTP</button>
                        
                    </div>
                    <div class="field_error">
                        <span id="email_error"></span></br> 
                    </div>

                    <div class="mb-3 otp_box">
                        <input type="text" id="otp" name="otp" class="form-control" placeholder="Enter OTP" required></br>
                        <!-- <span id="otp_error" class="field_error"></span></br> -->
                        <button type="submit" class="submit_btn btn btn-primary btn-block" id="submit_btn" name="submit_btn">Submit OTP</button>
                    </div>
                </form>
                <p class="mt-3">Don't have an account? <a href="register.php">Register Here!</a></p>
            </div>
        </div>
    </div>

    <?php include 'template/footer.php' ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        function verify_password() {
            var email = jQuery('#email').val().trim();
            var password = jQuery('#password').val().trim();

            if (email === '') {
                jQuery('#email_error').html('Email cannot be empty');
                return;
            }
            if (password === '') {
                jQuery('#email_error').html('Password cannot be empty');
                return;
            }

            jQuery.ajax({
                url: 'login_verify.php',
                type: 'POST',
                data: { email: email , password: password},
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        window.location.href = 'index.php';
                    } else {
                        jQuery('#email_error').html(response.message);
                    }
                },
                error: function() {
                    jQuery('#email_error').html('An error occurred. Please try again.');
                }
            });
        }

        function sendOtp() {
            var email = jQuery('#email').val().trim();

            if (email === '') {
                jQuery('#email_error').html('Email cannot be empty');
                return;
            }

            jQuery.ajax({
                url: 'send_otp.php',
                type: 'POST',
                data: { email: email },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        jQuery('#email_error').hide();
                        jQuery('.hide_label').hide();
                        jQuery('.otp_box').show();
                    } else {
                        jQuery('#email_error').html(response.message);
                    }
                },
                error: function() {
                    jQuery('#email_error').html('An error occurred. Please try again.');
                }
            });
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

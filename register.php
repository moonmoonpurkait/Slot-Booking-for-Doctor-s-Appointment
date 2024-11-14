<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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

    #passwordRequirements ul {
        list-style-type: none;
        padding: 0;
    }

    .requirement {
        color: red;
    }

    .requirement.met {
        color: green;
    }

    /* Tablet view (up to 768px) */
    @media (max-width: 768px) {
        #email_error {
            font-size: medium; /* Slightly smaller font size */
        }

        #passwordRequirements ul {
            font-size: 14px; /* Smaller font for better readability */
        }

        .otp_box {
            display: block; /* Show otp_box for smaller screens if needed */
            text-align: center; /* Center-align for better readability */
        }
    }

    /* Mobile view (up to 576px) */
    @media (max-width: 576px) {
        #email_error {
            font-size: small; /* Further reduce font size on mobile */
        }

        #passwordRequirements ul {
            font-size: 12px; /* Further reduce font size */
        }

        .otp_box {
            display: block;
            margin: 10px auto; /* Add margin for better spacing */
            width: 90%; /* Ensure it fits well on smaller screens */
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
                                <a href="login.php" class="dropdown-item">Login</a>
                                <a href="register.php" class="dropdown-item active">New User</a>
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
    <div>&nbsp;</div>  
    <h2>Register</h2>
    <form id="registerForm" autocomplete="off">
        <div class="form-group">
            <label for="username">Username</label>
            <input required type="text" class="form-control" id="username" name="username">
            <div id="UserValidity"><small class="error_username"></small></div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input required type="email" class="form-control" id="email" name="email">
            <div id="emailValidity"><small class="error_mail"></small></div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-group">
                <input required type="password" class="form-control" id="password" name="password" autocomplete="new-password">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordVisibility"><i class="bi bi-eye"></i></button>
                </div>
            </div>
            <div id="passwordRequirements">
                <ul>
                    <li id="charLength" class="requirement">At least 6 characters</li>
                    <li id="upperCase" class="requirement">At least one uppercase letter</li>
                    <li id="number" class="requirement">At least one number</li>
                    <li id="specialChar" class="requirement">At least one special character</li>
                </ul>
            </div>
        </div>
        <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <div class="input-group">
                <input required type="password" class="form-control" id="confirmPassword" name="confirmPassword" autocomplete="new-password">
            </div>
            <div id="passwordMatch"></div><br>
        </div>
        <button type="button" class="btn btn-primary" id="registerBtn">Register</button>
        <div class="field_error">
            <span id="email_error"></span><br>
        </div>
        <div class="mb-3 otp_box">
            <input type="text" id="otp" name="otp" class="form-control" placeholder="Enter OTP" required><br>
            <button type="button" class="btn btn-primary btn-block" id="submitOtpBtn">Submit OTP</button>
        </div>
    </form>
    <p>Already Registered? <a href="login.php">Log In Here!</a></p>
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
<script>
    $(document).ready(function() {
        $('#registerBtn').on('click', function() {
            var email = $('#email').val().trim();
            var username = $('#username').val().trim();
            var password = $('#password').val().trim();

            if (email === '' || username === '' || password === '') {
                $('#email_error').html('All fields are required');
                return;
            }

            // AJAX request for OTP
            $.ajax({
                url: 'otp_register.php',
                type: 'POST',
                data: { email: email, password: password },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'error') {
                        $('#email_error').html(response.message);
                    } else {
                        $('#email_error').html('');
                        $('.form-group label, .form-group input').hide();
                        $('#registerBtn').hide();
                        $('.otp_box').show();
                        $('#passwordRequirements').hide();
                        $('#passwordMatch').hide();
                        $('#togglePasswordVisibility').hide();
                        alert('OTP sent successfully.');
                    }
                },
                error: function() {
                    $('#email_error').html('An error occurred. Please try again.');
                }
            });
        });

        $('#submitOtpBtn').on('click', function() {
            var otp = $('#otp').val().trim();
            var email = $('#email').val().trim();
            var username = $('#username').val().trim();
            var password = $('#password').val().trim();

            if (otp === '') {
                alert('Please enter the OTP');
                return;
            }

            $.ajax({
                url: 'process_register.php',
                type: 'POST',
                data: { email: email, username: username, password: password, otp: otp },
                dataType: 'json',
                success: function(response) {
                    alert(response.message);
                    if (response.status === 'success') {
                        window.location.href = "login.php";
                    }
                },
                error: function() {
                    alert('An error occurred during registration. Please try again.');
                }
            });
        });

        $('#togglePasswordVisibility').on('click', function() {
            var passwordField = $('#password');
            var passwordFieldType = passwordField.attr('type');
            var confirmPasswordField = $('#confirmPassword');
            var confirmPasswordFieldType = passwordField.attr('type');

            if (passwordFieldType === 'password' || passwordFieldType === 'confirmPassword') {
                confirmPasswordField.attr('type', 'text');
                $(this).find('i').removeClass('bi-eye').addClass('bi-eye-slash');
                passwordField.attr('type', 'text');
                $(this).find('i').removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                passwordField.attr('type', 'password');
                $(this).find('i').removeClass('bi-eye-slash').addClass('bi-eye');
                confirmPasswordField.attr('type', 'password');
                $(this).find('i').removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });

        $('#password').on('input', function() {
            var password = $(this).val();
            $('#charLength').toggleClass('met', password.length >= 6);
            $('#upperCase').toggleClass('met', /[A-Z]/.test(password));
            $('#number').toggleClass('met', /[0-9]/.test(password));
            $('#specialChar').toggleClass('met', /[!@#$%^&*(),.?":{}|<>]/.test(password));


            checkPasswordMatch(); // Call function to check password match on password input change
        });

        $('#confirmPassword').on('input', function() {
            checkPasswordMatch(); // Call function to check password match on confirmPassword input change
        });

        function checkPasswordMatch() {
            var password = $('#password').val();
            var confirmPassword = $('#confirmPassword').val();
            var passwordMatch = password === confirmPassword;
            var passwordMatchText = passwordMatch ? 'Passwords match' : 'Passwords do not match';
            
            $('#passwordMatch')
                .text(passwordMatchText)
                .css('color', passwordMatch ? 'Black' : 'red');

            // Enable or disable the register button based on password match
            $('#registerBtn').prop('disabled', !passwordMatch);
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

<?php
session_start();
require('../connection.php');

if (isset($_POST['login'])) {
    $_SESSION['validate'] = false;
    $username = $_POST['username'];
    $password = $_POST['password'];

    $p = Amwell::connect()->prepare('SELECT * FROM info WHERE name=:u AND user_type=0');
    $p->bindValue(':u', $username);
    $p->execute();
    $user = $p->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Using password_verify for secure password comparison
        // Instead of using password_verify
        if ($password === $user['pass']) {
            // Your code for successful login
            session_regenerate_id(true); // Session fixation prevention
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['validate'] = true;
            header('location:profile.php');
            exit;
        } else {
            $error_message = "Password mismatch!";
        }
        // if (password_verify($password, $user['pass'])) {
        //     session_regenerate_id(true); // Session fixation prevention
        //     $_SESSION['username'] = $username;
        //     $_SESSION['user_id'] = $user['id'];
        //     $_SESSION['validate'] = true;
        //     header('location:profile.php');
        //     exit;
        // } else {
        //     $error_message = "Password mismatch!";
        // }
    } else {
        $error_message = "User not found!";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MEDINOVA - Hospital Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">  

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">

    <style>
    .container-login {
        width: 400px;
        margin: auto;
    }
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #007bff;
        color: white;
        text-align: center;
        border-radius: 10px 10px 0 0;
    }
    .card-body {
        padding: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .form-label {
        font-weight: bold;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    /* Mobile (max-width: 600px) */
    @media (max-width: 600px) {
        .container-login {
            width: 100%;
            padding: 0 1rem;
        }
        .card {
            margin: 0;
        }
        .card-body {
            padding: 1.5rem;
        }
        .form-label {
            font-size: 14px;
        }
        .btn-primary {
            width: 100%;
        }
    }

    /* Tablet (min-width: 601px and max-width: 1024px) */
    @media (min-width: 601px) and (max-width: 1024px) {
        .container-login {
            width: 80%;
            padding: 0 2rem;
        }
        .card-body {
            padding: 1.8rem;
        }
        .form-label {
            font-size: 16px;
        }
        .btn-primary {
            width: 100%;
        }
    }

    /* Laptop (min-width: 1025px) */
    @media (min-width: 1025px) {
        .container-login {
            width: 400px;
        }
        .card-body {
            padding: 2rem;
        }
        .form-label {
            font-size: 18px;
        }
        .btn-primary {
            width: auto;
        }
    }
</style>

</head>

<body>
    <?php include '../template/nav-bar.php';?> 
    <!-- Navbar Start -->
    <div class="container-fluid sticky-top bg-white shadow-sm">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0">
                <a href="../index.php" class="navbar-brand">
                    <h1 class="m-0 text-uppercase text-primary"><i class="fa fa-clinic-medical me-2"></i>Medinova</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="../index.php" class="nav-item nav-link">Home</a>
                        <a href="../about.php" class="nav-item nav-link">About</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Sitemap</a>
                            <div class="dropdown-menu m-0">
                                <a href="../service.php" class="dropdown-item">Service</a>
                                <a href="../price.php" class="dropdown-item">Pricing</a>
                                <a href="../team.php" class="dropdown-item">The Team</a>
                                <a href="../testimonial.php" class="dropdown-item">Testimonial</a>
                                <a href="../appointment.php" class="dropdown-item">Appointment</a>
                                <a href="../search.php" class="dropdown-item">Search Doctor</a>
                                <a href="../help_section.php" class="dropdown-item">Help</a>
                            </div>
                        </div>
                        <?php if(isset($_SESSION['username'])): ?>
                            <div class="nav-item">
                                <a class="nav-link" href="profile.php">Profile</a>
                            </div>
                            <div class="nav-item">
                                <a class="nav-link" href="../logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a>
                            </div>
                        <?php else: ?>
                            <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Login / Register</a>
                            <div class="dropdown-menu m-0">
                                <a href="../login.php" class="dropdown-item">Login</a>
                                <a href="../register.php" class="dropdown-item">New User</a>
                                <a href="index.php" class="dropdown-item ">Doctor Login</a>
                                <a href="../admin/index.php" class="dropdown-item active">Admin</a>
                            </div>
                        </div>
                        <?php endif; ?>
                        <a href="../contact.php" class="nav-item nav-link">Contact</a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->
     
    <!-- Login Form -->
    <div class="container-login py-5">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Admin Login</h3>
            </div>
            <div class="card-body">
                
                <!-- Display Error Message -->
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>
                
                <form method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input required type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input required type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100" value="login_button" name="login">Login</button>
                </form>
                <p class="text-center mt-3"></p>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+XAOnFdF7Yz1p4pI4mRR6iw5TgFf5" crossorigin="anonymous"></script>

    <?php include 'footer1.php'; ?> 
   
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../lib/tempusdominus/js/moment.min.js"></script>
    <script src="../lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="../lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>
</html>


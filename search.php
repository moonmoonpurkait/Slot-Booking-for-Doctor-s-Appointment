<?php
session_start(); // Start the session to manage user login status
require_once('./connection.php');

// Initialize an empty array for doctors and specialties
$doctors = [];
$specialties = [];
$searchTerm = "";
$department = ""; // Initialize department variable

// Check if the search form was submitted
if (isset($_POST['search'])) {
    $searchTerm = $_POST['search_term']; // Get the original search term
    $department = $_POST['department']; // Get the selected department

    try {
        // Prepare the SQL statement for searching
        $stmt = Amwell::connect()->prepare("SELECT * FROM doctor WHERE 
            (Name LIKE :searchTerm OR Speciality LIKE :searchTerm)
            AND (:department = '' OR Speciality LIKE :department)");
        $searchTermWithWildcards = "%" . $searchTerm . "%"; // Add wildcards for partial matching
        $departmentWithWildcards = "%" . $department . "%"; // Add wildcards for department matching
        $stmt->bindParam(':searchTerm', $searchTermWithWildcards);
        $stmt->bindParam(':department', $departmentWithWildcards);
        $stmt->execute();

        // Fetch all matching doctor records
        $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Fetch all doctors when the page is loaded for the first time
    try {
        $stmt = Amwell::connect()->query("SELECT * FROM doctor");
        $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Fetch unique specialties for the dropdown
try {
    $stmt = Amwell::connect()->query("SELECT DISTINCT Speciality FROM doctor");
    $specialties = $stmt->fetchAll(PDO::FETCH_COLUMN); // Fetch only the first column (Speciality)
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Search</title>
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
    .book-appointment {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        font-size: 16px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .book-appointment:hover {
        background-color: #0056b3;
    }

    .d-flex.flex-column {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .mt-auto {
        margin-top: auto;
    }

    /* Tablet view (max-width: 768px) */
    @media (max-width: 768px) {
        .book-appointment {
            padding: 8px 16px; /* Slightly smaller padding */
            font-size: 15px; /* Slightly smaller font size */
        }

        .d-flex.flex-column {
            height: auto; /* Adjust height to fit content */
        }
    }

    /* Mobile view (max-width: 576px) */
    @media (max-width: 576px) {
        .book-appointment {
            padding: 6px 12px; /* Smaller padding for mobile */
            font-size: 14px; /* Smaller font for mobile */
        }

        .d-flex.flex-column {
            height: auto; /* Ensure content fits without overflow */
            overflow: hidden;
        }
    }
</style>

</head>


<body>
    <?php include 'template/nav-bar.php'; // Include the navigation bar ?> 

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
                                <a href="search.php" class="dropdown-item active">Search Doctor</a>
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

    <!-- Search Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Find A Doctor</h5>
                <h1 class=" mb-4">Find A Healthcare Professional</h1>
                <h5 class="fw-normal">Connecting you with trusted, compassionate healthcare professionals for your needs.</h5>
            </div>
            <div class="mx-auto" style="width: 100%; max-width: 600px;">
                <form method="POST" action="">
                    <div class="input-group">
                        <select name="department" class="form-select border-primary w-25" style="height: 50px;">
                            <option value="">Department</option>
                            <?php foreach ($specialties as $specialty): ?>
                                <option value="<?= htmlspecialchars($specialty); ?>" <?= ($department == $specialty) ? 'selected' : ''; ?>><?= htmlspecialchars($specialty); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="text" name="search_term" class="form-control border-primary w-50" placeholder="Enter Doctor's name" value="<?= htmlspecialchars($searchTerm); ?>">
                        <button type="submit" name="search" class="btn btn-dark border-0 w-25">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Search End -->

    <!-- Search Result Start -->
    <div class="container-fluid py-5">
        <div class="container h-100">
            <div class="row g-4">
                <?php if (count($doctors) > 0): ?>
                    <?php foreach ($doctors as $doctor): ?>
                        <div class="col-lg-6 team-item">
                            <div class="row g-0 bg-light rounded overflow-hidden h-100 team-item">
                                <div class="col-12 col-sm-5 h-100">
                                    <img class="img-fluid h-100" src="<?php echo isset($doctor['Image']) ? htmlspecialchars($doctor['Image']) : 'default-image.jpg'; ?>" alt="Doctor Image" style="object-fit: cover;">
                                </div>
                                <div class="col-12 col-sm-7 h-100 d-flex flex-column">  
                                    <div class="mt-auto p-4">
                                        <h3><?= htmlspecialchars($doctor['Name']); ?></h3>
                                        <h6 class="fw-normal fst-italic text-primary mb-4"><?= htmlspecialchars($doctor['Speciality']); ?></h6>
                                        <p><strong>Hospital:</strong> <?php echo htmlspecialchars($doctor['Hospital']); ?></p>
                                        <p><strong>Email:</strong> <?php echo htmlspecialchars($doctor['Email']); ?></p>
                                        <p><strong>Degree:</strong> <?php echo htmlspecialchars($doctor['Degree']); ?></p>
                                        <p><strong>Timing:</strong> 
                                            <?php 
                                                $timeStart = date("h:i A", strtotime($doctor['TimeStart']));
                                                $timeEnd = date("h:i A", strtotime($doctor['TimeEnd']));
                                                echo htmlspecialchars($timeStart) . " - " . htmlspecialchars($timeEnd);
                                            ?>
                                        </p>
                                        <p><strong>Visit Charge: </strong> Rs. <?php echo htmlspecialchars($doctor['VisitCharge']); ?></p>  
                                    </div>
                                    <div style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;">
                                        <button class="book-appointment w-100" onclick="location.href='book_appointment.php?doc_id=<?php echo $doctor['IndexNumber']; ?>&charge=<?php echo $doctor['VisitCharge']; ?>'">
                                            Book Appointment
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No doctors found. Please try again with different search criteria.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Search Result End -->

    <script src="path_to_your_js.js"></script> <!-- Update this with the correct path -->
    
    <?php include 'template/footer.php' ?>

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <!-- Custom CSS for Carousel Navigation -->
    <style>
        /* Custom CSS for the Owl Carousel buttons */
        .owl-prev,
        .owl-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            font-size: 20px;
            cursor: pointer;
            z-index: 10;
            border-radius: 50%;
            display: none; /* Start hidden */
        }

        .owl-prev {
            left: 10px; /* Position left button */
        }

        .owl-next {
            right: 10px; /* Position right button */
        }

        /* Show buttons when carousel is active */
        .owl-carousel:hover .owl-prev,
        .owl-carousel:hover .owl-next {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Team Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5" style="max-width: 500px;">
                <h5 class="d-inline-block text-primary text-uppercase border-bottom border-5">Our Doctors</h5>
                <h1 class="display-4">Qualified Healthcare Professionals</h1>
            </div>
            <div class="owl-carousel team-carousel position-relative">
                <div class="team-item">
                    <div class="row g-0 bg-light rounded overflow-hidden">
                        <div class="col-12 col-sm-5 h-100">
                            <img class="img-fluid h-100" src="img/team-1.jpg" style="object-fit: cover;">
                        </div>
                        <div class="col-12 col-sm-7 h-100 d-flex flex-column">
                            <div class="mt-auto p-4">
                                <h3>Dr. Arpan Gupta</h3>
                                <h6 class="fw-normal fst-italic text-primary mb-4">Cardiology Specialist</h6>
                                <p class="m-0">A skilled cardiologist at Apollo Gleneagles Hospital, dedicated to heart health with an emphasis on patient care.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="team-item">
                    <div class="row g-0 bg-light rounded overflow-hidden">
                        <div class="col-12 col-sm-5 h-100">
                            <img class="img-fluid h-100" src="img/team-2.jpg" style="object-fit: cover;">
                        </div>
                        <div class="col-12 col-sm-7 h-100 d-flex flex-column">
                            <div class="mt-auto p-4">
                                <h3>Dr. Rajiv Sen</h3>
                                <h6 class="fw-normal fst-italic text-primary mb-4">Dental Specialist</h6>
                                <p class="m-0">An experienced dentist at Fortis Hospital, offering comprehensive dental care in a friendly environment.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="team-item">
                    <div class="row g-0 bg-light rounded overflow-hidden">
                        <div class="col-12 col-sm-5 h-100">
                            <img class="img-fluid h-100" src="img/team-3.jpg" style="object-fit: cover;">
                        </div>
                        <div class="col-12 col-sm-7 h-100 d-flex flex-column">
                            <div class="mt-auto p-4">
                                <h3>Dr. Priya Das</h3>
                                <h6 class="fw-normal fst-italic text-primary mb-4">Orthopedic Specialist</h6>
                                <p class="m-0">An orthopedic surgeon at AMRI Hospital, specializing in bone and joint health with a patient-centered approach.</p>
                            </div>      
                        </div>
                    </div>
                </div>
            </div>
            <!-- Custom navigation buttons -->
            <button class="owl-prev" role="presentation"><i class="fas fa-chevron-left"></i></button>
            <button class="owl-next" role="presentation"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
    <!-- Team End -->

    <!-- jQuery and Owl Carousel JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Initialize Owl Carousel -->
    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                items: 1, // Adjust based on your layout
                loop: true,
                margin: 10,
                nav: true, // Enable navigation
                navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
                navContainer: '.container', // This tells the carousel where to append the nav buttons
            });
        });
    </script>
</body>
</html>

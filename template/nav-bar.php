<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MEDINOVA - Hospital Website</title>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
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

    <!-- Media Queries for Responsive Design -->
    <style>
    /* Base styles */
    .topbar .container {
        padding-left: 20px;
        padding-right: 20px;
    }

    .topbar .d-inline-flex a {
        font-size: 16px;
    }

    /* Mobile Styles (up to 576px) */
    @media (max-width: 576px) {
        .topbar .container {
            padding-left: 10px;
            padding-right: 10px;
        }

        .topbar .d-inline-flex {
            flex-direction: column;
            align-items: center;
        }

        .topbar .d-inline-flex a {
            font-size: 14px;
        }

        .text-center.text-lg-start,
        .text-center.text-lg-end {
            text-align: center !important;
        }
    }

    /* Tablet Styles (576px to 991px) */
    @media (min-width: 577px) and (max-width: 991px) {
        .topbar .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        .topbar .d-inline-flex a {
            font-size: 15px;
        }

        .text-center.text-lg-start,
        .text-center.text-lg-end {
            text-align: center !important;
        }
    }

    /* Laptop Styles (992px and above) */
    @media (min-width: 992px) {
        /* No additional styles needed, base styles will apply */
    }
</style>


</head>
<body>
    <!-- Topbar Start -->
    <div class="container-fluid py-2 border-bottom d-none d-lg-block topbar">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-lg-start mb-2 mb-lg-0">
                    <div class="d-inline-flex align-items-center">
                        <a class="text-decoration-none text-body pe-3" href=""><i class="bi bi-telephone me-2"></i>+91 98300 98300</a>
                        <span class="text-body">|</span>
                        <a class="text-decoration-none text-body px-3" href=""><i class="bi bi-envelope me-2"></i>info@example.com</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->
</body>
</html>

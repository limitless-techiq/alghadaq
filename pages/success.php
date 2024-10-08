<?php
session_start();
if (!isset($_SESSION['url'])) {
  header('Location: https://alghadaqit.tech/');
}
$url = $_SESSION['url'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ALGHADAQ - IT</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i,900" rel="stylesheet">

  <!-- CSS Files -->
  <link href="../assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
  <style>
    .border-alghadaq {
      border-color: var(--pC2) !important;
      border-right-color: transparent !important;
    }
  </style>
</head>

<body>
  <!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">
      <div class="contact-info d-flex align-items-center">
        <i class="bi bi-envelope-fill"></i><a href="mailto:contact@alghadaqit.tech">info@alghadaqit.tech</a>
        <i class="bi bi-phone-fill phone-icon"></i><a href="tel:+971581587300">+971 58 158 7300</a>
      </div>
      <div class="social-links d-none d-md-block">
        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
      </div>
    </div>
  </section>

  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex align-items-center">
      <div class="logo me-auto">
        <!-- <h1><a href="index.html">ALGHADAQ - IT</a></h1> -->
        <a href="index.html"><img src="../assets/img/logo.png" alt="" class="img-fluid"></a>
      </div>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="../index.php#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="../index.php#about">About</a></li>
          <li><a class="nav-link scrollto" href="../index.php#services">Services</a></li>
          <li><a class="nav-link scrollto" href="../index.php#team">Team</a></li>
          <li><a class="nav-link scrollto" href="../index.php#contact">Contact</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
      <!-- .navbar -->
    </div>
  </header>
  <!-- End Header -->
  <main id="main">
    <div class="container">
      <div class="d-flex justify-content-center align-items-center flex-column my-3">
        <div class="d-flex justify-content-center align-items-center pt-2">
          <img src="../assets/img/payment method/visa-master.png" alt="" />
          <img src="../assets/img/payment method/union.png" alt="" />
        </div>
        <div id="progress" class="spinner-border border-alghadaq my-3" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <div id="done" class="d-flex justify-content-center align-items-center flex-column">
          <i class='bx bx-check-circle text-success fs-1 my-3'></i>
          <a class="btn btn-success" href="<?php echo $url; ?>">Buy Now</a>
        </div>
      </div>
    </div>
  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-info">
            <h3>ALGHADAQ - IT</h3>
            <p>
              Abu Bakr Ahmed Obaid Bin Touq Al Marri Building <br>
              Deira Naif Area <br>
              Office No. A 5-406, UAE<br><br>
              <strong>Phone:</strong> +971 58 158 7300<br>
              <strong>Email:</strong> info@alghadaqit.tech<br>
            </p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="../index.php#hero">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="../index.php#about">About us</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="../index.php#services">Services</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="conditions.php">Terms of service</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="privacypolicy.php">Privacy policy</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Our Services</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="../index.php#services">Web Design</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="../index.php#services">Web Development</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="../index.php#services">Product Management</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="../index.php#services">Marketing</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="../index.php#services">Graphic Design</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Our Newsletter</h4>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>

          </div>

        </div>
      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>ALGHADAQ - IT</span></strong>. All Rights Reserved
        <br />
        <a href="privacypolicy.php" target="_blank" rel="noopener noreferrer">Privacy Policy</a>
        <span>-</span>
        <a href="conditions.php" target="_blank" rel="noopener noreferrer">Terms & Conditions</a>
      </div>
    </div>
  </footer>
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- JS Files -->
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
  <script>
    var prog = document.querySelector("#progress"),
      done = document.querySelector("#done");
      done.classList.add("d-none");
    setTimeout(() => {
      prog.classList.add("d-none");
      done.classList.remove("d-none");
    }, 3000);
  </script>
</body>

</html>
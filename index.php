<?php 
session_start();
include 'lib/db.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale="1">
    <title>TEMANSIKO</title>

    <link rel="apple-touch-icon" sizes="180x180" href="Favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="Favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="Favicon/favicon-16x16.png">
    <link rel="manifest" href="Favicon/site.webmanifest">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .navbar-brand img {
            vertical-align: middle;
        }
        .navbar-nav .nav-link, .navbar-brand {
            line-height: 75px;
        }
        .navbar-nav.ms-auto {
            margin-right: 20px;
        }
        .carousel-item h1, .carousel-item p, .carousel-item h4 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 412; /* Make the font bold */
        }
    </style>
</head>
<body>
    
<!--NAVBAR-->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="Assets/logo.png" alt="Bootstrap" width="75" height="75"> TEMANSIKO
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="profile.php">
            Halo, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="member.php">Member</a>
        </li>
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="Dashboard/dashboard.php">Dashboard</a>
        </li>
        <?php } ?>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php if(isset($_SESSION['username'])) { ?>
        <li class="nav-item">
          <a class="nav-link" href="lib/logout.php">Logout</a>
        </li>
        <?php } else { ?>
          
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Login/Register
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="lib/login.php">Login</a></li>
            <li><a class="dropdown-item" href="lib/register.php">Register</a></li>
            <li><a class="dropdown-item" href="member.php">Member</a></li>
          </ul>
        </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
<!--END NAVBAR-->

<!--CONTENT HERE-->
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h6 class="mt-1">        
        <script language="JavaScript">
          var h=(new Date()).getHours();
          var m=(new Date()).getMinutes();
          var s=(new Date()).getSeconds();
          if (h > 3 && h <  10) document.writeln("Selamat Pagi.");
          if (h > 9 && h <  15) document.writeln("Selamat Siang.");
          if (h > 14 && h <  19) document. writeln("Selamat Sore.");
          if (h > 18 && h <  24) document. writeln("Selamat Malam.");
          if (h > 23 || h <  4 ) document. writeln("Hallo." );
        </script>
          <div class="badge bg-danger text-wrap">
            <?php
            date_default_timezone_set('Asia/Jakarta');
            $tanggal_sekarang = date("d-m-Y");
            echo $tanggal_sekarang;
            ?>
          </div>
        </h6>
    </div>
  </div>
</div>
<!--END CONTENT HERE-->

<!--INTRO AND LOGIN-->
<div class="container mt-2">
  <div class="row">
    <div class="col-md-12">
      <div class="card-container" style="height: 300px;">
        <div class="card h-100">
          <div class="card-body h-100">
            <div id="introCarousel" class="carousel slide h-100" data-bs-ride="carousel" data-bs-interval="1500">
              <div class="carousel-inner h-100">
                <div class="carousel-item active h-100">
                  <div class="container h-100">
                    <div class="row h-100">
                      <div class="col-md-12 text-center d-flex flex-column justify-content-center h-100">
                        <h1>Welcome to TEMANSIKO</h1>
                        <p>Selamat datang di TEMANSIKO – karena mengabaikan risiko hanya akan menambah masalah
                          <br>Dengan TEMANSIKO, Anda bisa mengelola risiko secara mudah, terorganisir, dan tanpa ribet.
                          <br>Risiko teratasi, hidup lebih tenang!
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="carousel-item h-100">
                  <div class="container h-100">
                    <div class="row h-100">
                      <div class="col-md-12 text-center d-flex flex-column justify-content-center h-100">
                        <h1>About TEMANSIKO</h1>
                        <p>Aplikasi ini dikerjakan dalam satu malam saja menggunakan teknik SKS (Sistem Kebut Semalam) Hehe:v</p>
                        <h4>Anggota >>>>>></h4>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="carousel-item h-100">
                  <div class="container h-100">
                    <div class="row h-100">
                      <div class="col-md-12 text-center d-flex flex-column justify-content-center h-100">
                        <p>1. Mas Ninip<br>2. Mas Faisal<br>3. Mas Okta<br>4. Mas Rejaus<br>5. Mas Amar</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#introCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#introCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
          <div class="card-footer text-center">
            <img src="Assets/logo.png" alt="Logo" width="75" height="75" style="vertical-align: middle;">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--END INTRO AND LOGIN-->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<footer class="bg-light text-center text-lg-start mt-4 fixed-bottom">
    <div class="text-center p-3">
        &copy; 2024 Temansiko. All rights reserved.
    </div>
</footer>
</body>
</html>
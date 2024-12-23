<?php
session_start();
include 'lib/db.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: lib/login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$query = mysqli_query($connection, "SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($query);

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($connection, "SELECT * FROM users WHERE id='$id'");
    $user_detail = mysqli_fetch_assoc($query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <div class="container mt-1">
        <h2>Profile</h2>
        <p>Username: <?php echo $user['username']; ?></p>
        <p>Role: <?php echo $user['role']; ?></p>
        <p>Register Date: <?php echo $user['register_date']; ?></p>
        <p>Last Login: <?php echo $user['last_login']; ?></p>
        
        <div class="mt-4">
            <a href="add_risk.php" class="btn btn-primary">Tambah Resiko</a>
            <a href="Dashboard/dashboard.php" class="btn btn-secondary">Tampilkan Resiko</a>
        </div>
        <div class="mt-4">
            <a href="index.php" class="btn btn-danger">Kembali ke Menu Utama</a>
        </div>
    </div>

    <?php if(isset($user_detail)) { ?>
    <div class="container mt-5">
        <h2>User Detail</h2>
        <p>Username: <?php echo $user_detail['username']; ?></p>
        <p>Role: <?php echo $user_detail['role']; ?></p>
        <p>Register Date: <?php echo $user_detail['register_date']; ?></p>
        <p>Last Login: <?php echo $user_detail['last_login']; ?></p>
        <p>Login Count: <?php echo $user_detail['login_count']; ?></p>
        <a href="member.php" class="btn btn-primary">Back to Members</a>
    </div>
    <?php } ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
<footer class="bg-light text-center text-lg-start mt-4 fixed-bottom">
    <div class="text-center p-3">
        &copy; 2024 Temansiko. All rights reserved.
    </div>
</footer>
</html>

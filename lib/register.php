<?php
session_start();
include 'db.php';

$showModal = false;
$modalMessage = '';

if(isset($_POST['register'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $role = ($password === 'admin1234') ? 'admin' : 'user'; // Assign admin role if password is 'admin1234'
    
    date_default_timezone_set('Asia/Jakarta'); // Set timezone to Asia/Jakarta
    $register_date = date('Y-m-d H:i:s'); // Current date and time in Asia/Jakarta

    // Check if username already exists
    $check_query = mysqli_query($connection, "SELECT * FROM users WHERE username='$username'");
    if(mysqli_num_rows($check_query) > 0) {
        $showModal = true;
        $modalMessage = "Username sudah digunakan, silahkan pilih username lain.";
    } else {
        $query = mysqli_query($connection, "INSERT INTO users (username, password, role, register_date) VALUES ('$username', '$hashed_password', '$role', '$register_date')");
        
        if($query) {
            $showModal = true;
            $modalMessage = "Berhasil daftar, silahkan login kembali!";
        } else {
            $showModal = true;
            $modalMessage = "Registration failed, please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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
      <img src="../Assets/logo.png" alt="Bootstrap" width="75" height="75"> TEMANSIKO
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../profile.php">
            Halo, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php if(isset($_SESSION['username'])) { ?>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
        <?php } else { ?>
        <li class="nav-item dropdown">
        <a class="dropdown-item" href="login.php">Login</a></li>
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
        <h2>Register</h2>
        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="register">Register</button>
        </form>
        <div class="mt-4">
            <a href="login.php" class="btn btn-danger">Kembali ke Login</a>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Pendaftaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $modalMessage; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <?php if($modalMessage == "Berhasil daftar, silahkan login kembali!") { ?>
                    <a href="login.php" class="btn btn-primary">OK Bang</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        <?php if($showModal) { ?>
            var registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
            registerModal.show();
        <?php } ?>
    </script>
</body>
<footer class="bg-light text-center text-lg-start mt-4 fixed-bottom">
    <div class="text-center p-3">
        &copy; 2024 Temansiko. All rights reserved.
    </div>
</footer>
</html>

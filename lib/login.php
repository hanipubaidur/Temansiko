<?php
session_start();
include 'db.php';

$showModal = false;

if(isset($_POST['login'])) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = $_POST['password'];
    
    $query = mysqli_query($connection, "SELECT * FROM users WHERE username='$username'");
    $user = mysqli_fetch_assoc($query);
    
    if(!$user) {
        $showModal = true;
    } else if($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        // Update last login and increment login count
        date_default_timezone_set('Asia/Jakarta'); // Set timezone to Asia/Jakarta
        $last_login = date('Y-m-d H:i:s'); // Current date and time in Asia/Jakarta
        mysqli_query($connection, "UPDATE users SET last_login='$last_login', login_count=login_count+1 WHERE id=".$user['id']);
        
        header('Location: ../profile.php');
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
        <a class="dropdown-item" href="register.php">Register</a></li>
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
        <h2>Login</h2>
        <?php if(isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
        <form method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="login">Login</button>
        </form>
        <div class="mt-4">
            <a href="../index.php" class="btn btn-danger">Kembali ke Menu Utama</a>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Pendaftaran Diperlukan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Belum punya akun? Silahkan daftar dulu!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="register.php" class="btn btn-primary">OK Bang</a>
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

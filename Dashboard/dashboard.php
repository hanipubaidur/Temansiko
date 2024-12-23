<?php 
session_start();
include '../lib/db.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: ../lib/login.php');
    exit;
}

if(isset($_GET['delete']) && $_SESSION['role'] == 'admin') {
    $id = $_GET['delete'];
    $query = mysqli_query($connection, "DELETE FROM risks WHERE id='$id'");

    if($query) {
        $message = "Risk deleted successfully";
    } else {
        $message = "Failed to delete risk";
    }
}

$risks = mysqli_query($connection, "SELECT * FROM risks");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../member.php">Member</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <?php if(isset($_SESSION['username'])) { ?>
        <li class="nav-item">
          <a class="nav-link" href="../lib/logout.php">Logout</a>
        </li>
        <?php } else { ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Login/Register
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../lib/login.php">Login</a></li>
            <li><a class="dropdown-item" href="../lib/register.php">Register</a></li>
            <li><a class="dropdown-item" href="../member.php">Member</a></li>
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
  <div class="row mt">
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

    <div class="container">
        <h2>Dashboard</h2>
        <?php if(isset($message)) { echo "<div class='alert alert-info'>$message</div>"; } ?>
        
        <a href="../show_chart.php" class="btn btn-primary mb-3">Tampilkan Chart</a>

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Kode Resiko</th>
                    <th>Tujuan</th>
                    <th>Departemen</th>
                    <th>Skor Resiko</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($risk = mysqli_fetch_assoc($risks)) { ?>
                <tr>
                    <td><?php echo $risk['risk_code']; ?></td>
                    <td><?php echo $risk['objective']; ?></td>
                    <td><?php echo $risk['department']; ?></td>
                    <td>
                        <?php 
                        $risk_score = $risk['residual_impact'] * $risk['residual_likelihood'];
                        $color = '';
                        if ($risk_score <= 10) {
                            $color = 'green';
                        } elseif ($risk_score <= 20) {
                            $color = 'yellow';
                        } else {
                            $color = 'red';
                        }
                        ?>
                        <span style="display: inline-block; width: 15px; height: 15px; background-color: <?php echo $color; ?>; border-radius: 50%;"></span>
                        <?php echo $risk_score; ?>
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Aksi
                            </button>
                            <div class="dropdown-menu">
                                <?php if($_SESSION['role'] == 'admin') { ?>
                                <a href="edit.php?id=<?php echo $risk['id']; ?>" class="dropdown-item">Edit</a>
                                <a href="?delete=<?php echo $risk['id']; ?>" class="dropdown-item">Hapus</a>
                                <?php } ?>
                                <a href="../view_risk_detail.php?id=<?php echo $risk['id']; ?>" class="dropdown-item">Lihat Detail</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="mt-4"></div>
            <a href="../index.php" class="btn btn-danger">Kembali ke Menu Utama</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
<footer class="bg-light text-center text-lg-start mt-4 fixed-bottom">
    <div class="text-center p-3">
        &copy; 2024 Temansiko. All rights reserved.
    </div>
</footer>
</html>
<?php
session_start();
include 'lib/db.php';

if(!isset($_SESSION['user_id'])) {
    header('Location: lib/login.php');
    exit;
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($connection, "SELECT * FROM risks WHERE id='$id'");
    $risk = mysqli_fetch_assoc($query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Risk Detail</title>
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

    <div class="container">
        <div class="row">
            <div class="col-md-6">
              <h2>Risk Detail</h2>
                <p><strong>Kode Resiko:</strong> <?php echo $risk['risk_code']; ?></p>
                <p><strong>Tujuan:</strong> <?php echo $risk['objective']; ?></p>
                <p><strong>Proses Bisnis:</strong> <?php echo $risk['business_process']; ?></p>
                <p><strong>Kelompok:</strong> <?php echo $risk['risk_group']; ?></p>
                <p><strong>Sumber:</strong> <?php echo $risk['source']; ?></p>
                <p><strong>Uraian Peristiwa:</strong> <?php echo $risk['event_description']; ?></p>
                <p><strong>Penyebab Resiko:</strong> <?php echo $risk['risk_cause']; ?></p>
                <p><strong>Potensi Kerugian (Qualitative):</strong> <?php echo $risk['potential_loss_qualitative']; ?></p>
                <p><strong>Potensi Kerugian (Finansial):</strong> <?php echo $risk['potential_loss_financial']; ?></p>
                <p><strong>Pemilik Resiko:</strong> <?php echo $risk['risk_owner']; ?></p>
                <p><strong>Departemen:</strong> <?php echo $risk['department']; ?></p>
            </div>
            <div class="col-md-6">
                <div class="card mb-2">
                    <div class="card-header">
                        <h4>Inherent</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Likelihood:</strong> <?php echo $risk['inherent_likelihood']; ?></p>
                        <p><strong>Impact:</strong> <?php echo $risk['inherent_impact']; ?></p>
                        <?php 
                        $inherent_score = $risk['inherent_likelihood'] * $risk['inherent_impact'];
                        $inherent_color = '';
                        if ($inherent_score <= 10) {
                            $inherent_color = 'green';
                        } elseif ($inherent_score <= 20) {
                            $inherent_color = 'yellow';
                        } else {
                            $inherent_color = 'red';
                        }
                        ?>
                        <p><strong>Score:</strong> <span style="display: inline-block; width: 10px; height: 10px; background-color: <?php echo $inherent_color; ?>; border-radius: 50%;"></span> <?php echo $inherent_score; ?></p>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-header">
                        <h4>Residual</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Likelihood:</strong> <?php echo $risk['residual_likelihood']; ?></p>
                        <p><strong>Impact:</strong> <?php echo $risk['residual_impact']; ?></p>
                        <?php 
                        $residual_score = $risk['residual_likelihood'] * $risk['residual_impact'];
                        $residual_color = '';
                        if ($residual_score <= 10) {
                            $residual_color = 'green';
                        } elseif ($residual_score <= 20) {
                            $residual_color = 'yellow';
                        } else {
                            $residual_color = 'red';
                        }
                        ?>
                        <p><strong>Score:</strong> <span style="display: inline-block; width: 10px; height: 10px; background-color: <?php echo $residual_color; ?>; border-radius: 50%;"></span> <?php echo $residual_score; ?></p>
                    </div>
                </div>
                <div class="card mb-2">
                    <div class="card-header">
                        <h4>Mitigasi</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Likelihood:</strong> <?php echo $risk['mitigation_likelihood']; ?></p>
                        <p><strong>Impact:</strong> <?php echo $risk['mitigation_impact']; ?></p>
                        <?php 
                        $mitigation_score = $risk['mitigation_likelihood'] * $risk['mitigation_impact'];
                        $mitigation_color = '';
                        if ($mitigation_score <= 10) {
                            $mitigation_color = 'green';
                        } elseif ($mitigation_score <= 20) {
                            $mitigation_color = 'yellow';
                        } else {
                            $mitigation_color = 'red';
                        }
                        ?>
                        <p><strong>Score:</strong> <span style="display: inline-block; width: 10px; height: 10px; background-color: <?php echo $mitigation_color; ?>; border-radius: 50%;"></span> <?php echo $mitigation_score; ?></p>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</body>
<footer class="bg-light text-center text-lg-start mt-4 fixed-bottom">
    <div class="text-center p-3">
        &copy; 2024 Temansiko. All rights reserved.
    </div>
</footer>
</html>

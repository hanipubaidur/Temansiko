<?php
session_start();
include '../lib/db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../lib/login.php');
    exit;
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($connection, "SELECT * FROM risks WHERE id='$id'");
    $risk = mysqli_fetch_assoc($query);
}

if(isset($_POST['update_risk'])) {
    $risk_code = mysqli_real_escape_string($connection, $_POST['risk_code']);
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $business_process = mysqli_real_escape_string($connection, $_POST['business_process']);
    $risk_group = mysqli_real_escape_string($connection, $_POST['risk_group']);
    $source = mysqli_real_escape_string($connection, $_POST['source']);
    $event_description = mysqli_real_escape_string($connection, $_POST['event_description']);
    $risk_cause = mysqli_real_escape_string($connection, $_POST['risk_cause']);
    $risk_owner = mysqli_real_escape_string($connection, $_POST['risk_owner']);
    $department = mysqli_real_escape_string($connection, $_POST['department']);
    $inherent_likelihood = mysqli_real_escape_string($connection, $_POST['inherent_likelihood']);
    $inherent_impact = mysqli_real_escape_string($connection, $_POST['inherent_impact']);
    $control_exists = mysqli_real_escape_string($connection, $_POST['control_exists']);
    $control_adequate = mysqli_real_escape_string($connection, $_POST['control_adequate']);
    $control_status = mysqli_real_escape_string($connection, $_POST['control_status']);
    $residual_likelihood = mysqli_real_escape_string($connection, $_POST['residual_likelihood']);
    $residual_impact = mysqli_real_escape_string($connection, $_POST['residual_impact']);
    $mitigation_action = mysqli_real_escape_string($connection, $_POST['mitigation_action']);
    $treatment = mysqli_real_escape_string($connection, $_POST['treatment']);
    $mitigation_likelihood = mysqli_real_escape_string($connection, $_POST['mitigation_likelihood']);
    $mitigation_impact = mysqli_real_escape_string($connection, $_POST['mitigation_impact']);
    $objective = mysqli_real_escape_string($connection, $_POST['objective']);
    $potential_loss_qualitative = mysqli_real_escape_string($connection, $_POST['potential_loss_qualitative']);
    $potential_loss_financial = mysqli_real_escape_string($connection, $_POST['potential_loss_financial']);

    $query = mysqli_query($connection, "UPDATE risks SET risk_code='$risk_code', title='$title', description='$description', business_process='$business_process', risk_group='$risk_group', source='$source', event_description='$event_description', risk_cause='$risk_cause', risk_owner='$risk_owner', department='$department', inherent_likelihood='$inherent_likelihood', inherent_impact='$inherent_impact', control_exists='$control_exists', control_adequate='$control_adequate', control_status='$control_status', residual_likelihood='$residual_likelihood', residual_impact='$residual_impact', mitigation_action='$mitigation_action', treatment='$treatment', mitigation_likelihood='$mitigation_likelihood', mitigation_impact='$mitigation_impact', objective='$objective', potential_loss_qualitative='$potential_loss_qualitative', potential_loss_financial='$potential_loss_financial', updated_at=NOW() WHERE id='$id'");

    if($query) {
        header('Location: dashboard.php');
        exit;
    } else {
        $message = "Failed to update risk";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Risk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-header {
            background-color: #f8f9fa;
            color: #333;
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
  <div class="row mt-1">
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
        <h2>Edit Risk</h2>
        <?php if(isset($message)) { echo "<div class='alert alert-info'>$message</div>"; } ?>
        <form method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Informasi Resiko</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="objective" class="form-label">Tujuan</label>
                                <input type="text" class="form-control" id="objective" name="objective" value="<?php echo $risk['objective']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="risk_code" class="form-label">Kode Resiko</label>
                                <input type="number" class="form-control" id="risk_code" name="risk_code" value="<?php echo $risk['risk_code']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo $risk['title']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description" required><?php echo $risk['description']; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="business_process" class="form-label">Proses Bisnis</label>
                                <select class="form-control" id="business_process" name="business_process" required>
                                    <option value="" disabled>Pilih opsi berikut</option>
                                    <option value="Keuangan" <?php if($risk['business_process'] == 'Keuangan') echo 'selected'; ?>>Keuangan</option>
                                    <option value="Akademik" <?php if($risk['business_process'] == 'Akademik') echo 'selected'; ?>>Akademik</option>
                                    <option value="Kepegawaian" <?php if($risk['business_process'] == 'Kepegawaian') echo 'selected'; ?>>Kepegawaian</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="risk_group" class="form-label">Kelompok</label>
                                <select class="form-control" id="risk_group" name="risk_group" required>
                                    <option value="" disabled>Pilih opsi berikut</option>
                                    <option value="Strategi" <?php if($risk['risk_group'] == 'Strategi') echo 'selected'; ?>>Strategi</option>
                                    <option value="Finansial" <?php if($risk['risk_group'] == 'Finansial') echo 'selected'; ?>>Finansial</option>
                                    <option value="Operasional" <?php if($risk['risk_group'] == 'Operasional') echo 'selected'; ?>>Operasional</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="source" class="form-label">Sumber</label>
                                <select class="form-control" id="source" name="source" required>
                                    <option value="" disabled>Pilih opsi berikut</option>
                                    <option value="Eksternal" <?php if($risk['source'] == 'Eksternal') echo 'selected'; ?>>Eksternal</option>
                                    <option value="Internal" <?php if($risk['source'] == 'Internal') echo 'selected'; ?>>Internal</option>
                                    <option value="Eksternal/Intern" <?php if($risk['source'] == 'Eksternal/Intern') echo 'selected'; ?>>Eksternal/Intern</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="event_description" class="form-label">Uraian Peristiwa</label>
                                <textarea class="form-control" id="event_description" name="event_description" required><?php echo $risk['event_description']; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="risk_cause" class="form-label">Penyebab Resiko</label>
                                <textarea class="form-control" id="risk_cause" name="risk_cause" required><?php echo $risk['risk_cause']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Penanganan</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="mitigation_action" class="form-label">Tindakan Mitigasi</label>
                                <textarea class="form-control" id="mitigation_action" name="mitigation_action" required><?php echo $risk['mitigation_action']; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="treatment" class="form-label">Perlakuan</label>
                                <select class="form-control" id="treatment" name="treatment" required>
                                    <option value="" disabled>Pilih opsi berikut</option>
                                    <option value="Acc" <?php if($risk['treatment'] == 'Acc') echo 'selected'; ?>>Acc</option>
                                    <option value="Revoke" <?php if($risk['treatment'] == 'Revoke') echo 'selected'; ?>>Revoke</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="mitigation_likelihood" class="form-label">Mitigasi Likelihood (max 5)</label>
                                <input type="number" class="form-control" id="mitigation_likelihood" name="mitigation_likelihood" value="<?php echo $risk['mitigation_likelihood']; ?>" max="5" required>
                            </div>
                            <div class="mb-3">
                                <label for="mitigation_impact" class="form-label">Mitigasi Impact (max 5)</label>
                                <input type="number" class="form-control" id="mitigation_impact" name="mitigation_impact" value="<?php echo $risk['mitigation_impact']; ?>" max="5" required>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Potensi Kerugian</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="potential_loss_qualitative" class="form-label">Potensi Kerugian (Qualitative)</label>
                                <textarea class="form-control" id="potential_loss_qualitative" name="potential_loss_qualitative" required><?php echo $risk['potential_loss_qualitative']; ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="potential_loss_financial" class="form-label">Potensi Kerugian (Finansial)</label>
                                <input type="number" class="form-control" id="potential_loss_financial" name="potential_loss_financial" value="<?php echo $risk['potential_loss_financial']; ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Informasi Terkait</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="risk_owner" class="form-label">Pemilik Resiko</label>
                                <input type="text" class="form-control" id="risk_owner" name="risk_owner" value="<?php echo $risk['risk_owner']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Departemen</label>
                                <select class="form-control" id="department" name="department" required>
                                    <option value="" disabled>Pilih opsi berikut</option>
                                    <option value="Informatika" <?php if($risk['department'] == 'Informatika') echo 'selected'; ?>>Informatika</option>
                                    <option value="Industri" <?php if($risk['department'] == 'Industri') echo 'selected'; ?>>Industri</option>
                                    <option value="Matematika" <?php if($risk['department'] == 'Matematika') echo 'selected'; ?>>Matematika</option>
                                    <option value="Biologi" <?php if($risk['department'] == 'Biologi') echo 'selected'; ?>>Biologi</option>
                                    <option value="Fisika" <?php if($risk['department'] == 'Fisika') echo 'selected'; ?>>Fisika</option>
                                    <option value="Kimia" <?php if($risk['department'] == 'Kimia') echo 'selected'; ?>>Kimia</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Penilaian Resiko</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="inherent_likelihood" class="form-label">Inherent Likelihood (max 5)</label>
                                <input type="number" class="form-control" id="inherent_likelihood" name="inherent_likelihood" value="<?php echo $risk['inherent_likelihood']; ?>" max="5" required>
                            </div>
                            <div class="mb-3">
                                <label for="inherent_impact" class="form-label">Inherent Impact (max 5)</label>
                                <input type="number" class="form-control" id="inherent_impact" name="inherent_impact" value="<?php echo $risk['inherent_impact']; ?>" max="5" required>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4>Pengendalian</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="control_exists" class="form-label">Control</label>
                                <select class="form-control" id="control_exists" name="control_exists" required>
                                    <option value="" disabled>Pilih opsi berikut</option>
                                    <option value="Ada" <?php if($risk['control_exists'] == 'Ada') echo 'selected'; ?>>Ada</option>
                                    <option value="Tidak" <?php if($risk['control_exists'] == 'Tidak') echo 'selected'; ?>>Tidak</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="control_adequate" class="form-label">Memadai</label>
                                <select class="form-control" id="control_adequate" name="control_adequate" required>
                                    <option value="" disabled>Pilih opsi berikut</option>
                                    <option value="Ya" <?php if($risk['control_adequate'] == 'Ya') echo 'selected'; ?>>Ya</option>
                                    <option value="Tidak" <?php if($risk['control_adequate'] == 'Tidak') echo 'selected'; ?>>Tidak</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="control_status" class="form-label">Status</label>
                                <select class="form-control" id="control_status" name="control_status" required>
                                    <option value="" disabled>Pilih opsi berikut</option>
                                    <option value="Dijalankan 100%" <?php if($risk['control_status'] == 'Dijalankan 100%') echo 'selected'; ?>>Dijalankan 100%</option>
                                    <option value="Belum 100%" <?php if($risk['control_status'] == 'Belum 100%') echo 'selected'; ?>>Belum 100%</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="residual_likelihood" class="form-label">Residual Likelihood (max 5)</label>
                                <input type="number" class="form-control" id="residual_likelihood" name="residual_likelihood" value="<?php echo $risk['residual_likelihood']; ?>" max="5" required>
                            </div>
                            <div class="mb-3"></div>
                                <label for="residual_impact" class="form-label">Residual Impact (max 5)</label>
                                <input type="number" class="form-control" id="residual_impact" name="residual_impact" value="<?php echo $risk['residual_impact']; ?>" max="5" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start"></div>
                        <button type="submit" class="btn btn-primary me-2" name="update_risk">Update Resiko</button>
                        <a href="dashboard.php" class="btn btn-secondary me-2">View Risks</a>
                        <a href="profile.php" class="btn btn-danger">Kembali ke Profil</a>
                    </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<footer class="bg-light text-center text-lg-start mt-4 fixed-bottom">
    <div class="text-center p-3">
        &copy; 2024 Temansiko. All rights reserved.
    </div>
</footer>
</html>

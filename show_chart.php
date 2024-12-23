<?php
session_start();
include 'lib/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: lib/login.php');
    exit;
}

// Fetch risk data
$query = mysqli_query($connection, "SELECT inherent_likelihood, inherent_impact FROM risks");
$data = [];
while ($row = mysqli_fetch_assoc($query)) {
    $data[] = [
        'likelihood' => $row['inherent_likelihood'],
        'impact' => $row['inherent_impact'],
        'score' => $row['inherent_likelihood'] * $row['inherent_impact']
    ];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Scatter Plot Chart</title>
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
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        var h = (new Date()).getHours();
                        if (h > 3 && h < 10) document.writeln("Selamat Pagi.");
                        if (h > 9 && h < 15) document.writeln("Selamat Siang.");
                        if (h > 14 && h < 19) document.writeln("Selamat Sore.");
                        if (h > 18 && h < 24) document.writeln("Selamat Malam.");
                        if (h > 23 || h < 4) document.writeln("Hallo.");
                    </script>
                    <div class="badge bg-danger text-wrap">
                        <?php
                        date_default_timezone_set('Asia/Jakarta');
                        $tanggal_sekarang = date("d-m-Y");
                        echo $tanggal_sekarang;
                        ?>
                        
                    </div><div class="mt-2"></div>
                        <a href="Dashboard/dashboard.php" class="btn btn-danger">Kembali</a>
                    </div>
                    
                </h6>
            </div>
        </div>
    </div>
    <!--END CONTENT HERE-->

    <div style="width: 60%; margin: auto;">
        <h2>Risk Chart</h2>
        <canvas id="scatterChart"></canvas>
    </div>
    <script>
        const ctx = document.getElementById('scatterChart').getContext('2d');
        const data = {
            datasets: [
                <?php foreach ($data as $item) : 
                    $color = '';
                    $size = 10;
                    if ($item['score'] <= 10) {
                        $color = 'green';
                    } elseif ($item['score'] <= 20) {
                        $color = 'yellow';
                    } else {
                        $color = 'red';
                    }
                ?>
                {
                    label: 'Risk Score <?php echo $item['score']; ?>',
                    data: [{ x: <?php echo $item['likelihood']; ?>, y: <?php echo $item['impact']; ?> }],
                    backgroundColor: '<?php echo $color; ?>',
                    pointRadius: <?php echo $size; ?>,
                },
                <?php endforeach; ?>
            ]
        };

        const config = {
            type: 'scatter',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'Risk Score' }
                },
                scales: {
                    x: {
                        title: { display: true, text: 'Inherent Likelihood' },
                        min: 0,
                        max: 8,
                    },
                    y: {
                        title: { display: true, text: 'Inherent Impact' },
                        min: 0,
                        max: 8,
                    }
                }
            }
        };

        new Chart(ctx, config);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
<footer class="bg-light text-center text-lg-start mt-4 fixed-bottom">
    <div class="text-center p-3">
        &copy; 2024 Temansiko. All rights reserved.
    </div>
</footer>
</html>

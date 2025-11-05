<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user'])) {
    header('Location: ../auth/auth.php');
    exit();
}
$role = $_SESSION['user']['user_role'];
$name = $_SESSION['user']['user_nama'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Request Buku & Modul - Home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="../../images/Icon-Perpustakaan.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&subset=devanagari,latin-ext" rel="stylesheet">
    <style>
        .user-role {
            font-weight: bold;
            margin-left: 10px;
        }
    </style>
</head>

<body class="hero-anime">
    <div class="navigation-wrap bg-light start-header start-style">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand" href="navBar.php"><img src="../../images/LogoPCR.png" alt=""></a>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto py-4 py-md-0">
                                <?php if ($role == 'mahasiswa' || $role == 'dosen') : ?>
                                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 active">
                                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Request</a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="../buku/BookFormView.php">Buku</a>
                                            <?php if ($role == 'dosen') : ?>
                                                <a class="dropdown-item" href="../modul/ModulFormView.php">Modul</a>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                <?php endif; ?>
                                <?php if ($role == 'staff') : ?>
                                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 active">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Manage Status</a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="../manage/buku.php">Buku</a>

                                            <a class="dropdown-item" href="../manage/modul.php">Modul</a>

                                        </div>
                                        </li>
                                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 active">
                                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Kurva</a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="../kurva/kurva.php">Buku</a>

                                            <a class="dropdown-item" href="../kurva/kurvamodul.php">Modul</a>

                                        </div>
                                    </li>
                                <?php endif; ?>
                                <?php if ($role == 'staff') : ?>
                                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                        <a class="nav-link" href="../modul/FileModulView.php">File Modul</a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($role == 'mahasiswa' || $role == 'dosen') : ?>
                                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                        <a class="nav-link" href="../status/StatusView.php">Status</a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($role == 'mahasiswa' || $role == 'dosen' || $role == 'staff') : ?>
                                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                        <a class="nav-link" href="../buku/index.php">Daftar Buku</a>
                                    </li>
                                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                        <a class="nav-link profile-link" href="../datadiri/profile.php">
                                            <?php echo ucfirst($name);
                                            echo "\t(";
                                            echo ucfirst($role);
                                            echo ")"; ?>
                                        </a>
                                    </li>
                                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                        <a class="nav-link" href="../profil/logout.php">Logout</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="section full-height">
        <div class="absolute-center">
            <div class="section">
                <div class="container">
                    <div class="col-12">
                        <h1>
                            <span>S</span><span>i</span><span>s</span><span>t</span><span>e</span><span>m</span><span> </span>
                            <span>R</span><span>e</span><span>q</span><span>u</span><span>e</span><span>s</span><span>t</span><br>
                            <span>B</span><span>u</span><span>k</span><span>u</span>
                            <span>&</span><span> </span>
                            <span>M</span><span>o</span><span>d</span><span>u</span><span>l</span>
                        </h1>
                        <p>Pusat Pengajuan Pembelian Buku dan Pencetakan Modul Pembelajaran Politeknik Caltex Riau
                            adalah sebuah sistem yang dirancang untuk memudahkan mahasiswa, dosen, dan staf perpustakaan dalam
                            mengajukan permintaan pembelian buku dan pencetakan modul pembelajaran. Dengan adanya sistem ini,
                            diharapkan proses pengajuan dapat dilakukan dengan lebih efisien dan transparan, serta mampu memenuhi
                            kebutuhan akademik di lingkungan Politeknik Caltex Riau secara optimal. Sistem ini juga dilengkapi dengan
                            fitur pelacakan status permintaan, yang memungkinkan pengguna untuk mengetahui perkembangan dari setiap
                            pengajuan yang telah dilakukan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-5 py-5"></div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="navBar.js"></script>
</body>

</html>
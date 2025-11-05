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
<html>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Request Buku & Modul</title>
    <link rel="icon" href="../../images/Icon-Perpustakaan.png">
    <link rel="stylesheet" href="../profil/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&subset=devanagari,latin-ext" rel="stylesheet">

</head>
<style>
    body {
        padding-top: 120px;
    }
</style>

<body class="hero-anime">
    <div class="navigation-wrap bg-light start-header start-style">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand" href="../profil/navBar.php"><img src="../../images/LogoPCR.png" alt=""></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

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
</body>

</html>
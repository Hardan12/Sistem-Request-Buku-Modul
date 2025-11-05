<?php
// NavbarController.php

$navbarItems = [];

if (isset($_SESSION['user']) && isset($_SESSION['user']['role'])) {
    // Navbar items based on user role
    if ($_SESSION['user']['role'] == 'mahasiswa') {
        $navbarItems = [
            ['label' => 'Home', 'link' => '#'],
            ['label' => 'Request Buku', 'link' => 'request_buku.php'],
            ['label' => 'Logout', 'link' => 'logout.php']
        ];
    } elseif ($_SESSION['user']['role'] == 'dosen') {
        $navbarItems = [
            ['label' => 'Home', 'link' => '#'],
            ['label' => 'Request Buku dan Modul', 'link' => 'request_buku_modul.php'],
            ['label' => 'Logout', 'link' => 'logout.php']
        ];
    } elseif ($_SESSION['user']['role'] == 'staff') {
        $navbarItems = [
            ['label' => 'Home', 'link' => '#'],
            ['label' => 'Manage Modules', 'link' => 'manage_modules.php'],
            ['label' => 'Logout', 'link' => 'logout.php']
        ];
    }
} else {
    // Navbar items for guests (not logged in)
    $navbarItems = [
        ['label' => 'Login', 'link' => '../auth/auth.php']
    ];
}

?>

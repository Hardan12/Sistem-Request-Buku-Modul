<?php
// Konfigurasi database
$host = 'localhost';
$dbname = 'srbm';
$username = 'root';
$password = '';

try {
    // Membuat koneksi ke database menggunakan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Mengatur mode error PDO ke Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Menangkap dan menampilkan error jika koneksi gagal
    echo "Koneksi ke database gagal: " . $e->getMessage();
}
?>

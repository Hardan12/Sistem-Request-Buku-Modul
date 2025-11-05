<?php
// get_buku_details.php
include '../../model/buku_model.php';

if (isset($_GET['judul'])) {
    $judul = $_GET['judul'];
    $buku = getBukuByJudul($pdo, $judul);
    
    if ($buku) {
        echo json_encode($buku);
    } else {
        echo json_encode(['error' => 'No book found']);
    }
}
?>

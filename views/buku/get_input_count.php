<?php
// get_input_count.php
include '../../model/buku_model.php';

if (isset($_GET['judul'])) {
    $judul = $_GET['judul'];
    $count = getInputCountByJudul($pdo, $judul);
    echo json_encode($count);
}
?>

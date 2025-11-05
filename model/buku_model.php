<?php
// buku_model.php
include dirname(__DIR__) . '/core/db.php';

function getAllBuku($pdo) {
    $sql = "SELECT * FROM buku";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getBukuByJudul($pdo, $judul) {
    $sql = "SELECT * FROM buku WHERE buku_judul = :judul";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':judul' => $judul]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getInputCountByJudul($pdo, $judul) {
    $sql = "SELECT COUNT(*) as input_count FROM buku WHERE buku_judul = :judul";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':judul' => $judul]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<?php
class FileModulModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllFiles() {
        $stmt = $this->pdo->prepare("SELECT modul_code, modul_judul, modul_penulis, modul_status, modul_file FROM modul");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFileById($modul_code) {
        $stmt = $this->pdo->prepare("SELECT modul_code, modul_judul, modul_file FROM modul WHERE modul_code = :modul_code");
        $stmt->bindParam(':modul_code', $modul_code, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getFileDetailsById($modul_code) {
        $stmt = $this->pdo->prepare("SELECT modul_code, modul_judul, modul_penulis, modul_status FROM modul WHERE modul_code = :modul_code");
        $stmt->bindParam(':modul_code', $modul_code, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

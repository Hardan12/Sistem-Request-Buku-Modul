<?php
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../model/FileModulModel.php';

class FileModulController {
    private $fileModulModel;

    public function __construct($pdo) {
        $this->fileModulModel = new FileModulModel($pdo);
    }

    public function getAllFiles() {
        return $this->fileModulModel->getAllFiles();
    }

    public function getFileById($modul_code) {
        return $this->fileModulModel->getFileById($modul_code);
    }

    public function getFileDetailsById($modul_code) {
        return $this->fileModulModel->getFileDetailsById($modul_code);
    }
}

if (isset($_GET['modul_code'])) {
    $fileModulController = new FileModulController($pdo);
    if (isset($_GET['details'])) {
        $modul = $fileModulController->getFileDetailsById($_GET['modul_code']);
        echo json_encode($modul);
        exit;
    } else {
        $modul = $fileModulController->getFileById($_GET['modul_code']);
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $modul['modul_judul'] . '.pdf"');
        echo $modul['modul_file'];
        exit;
    }
}
?>

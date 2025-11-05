<?php
session_start();
require_once '../core/db.php';
require_once '../model/ModulModel.php';

class ModulController {
    private $modulModel;

    public function __construct($pdo) {
        $this->modulModel = new ModulModel($pdo);
    }

    public function saveModul() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'modul_judul' => $_POST['modul_judul'],
                'modul_penulis' => $_POST['modul_penulis'],
                'modul_file' => file_get_contents($_FILES['modul_file']['tmp_name']),
                'modul_status' => 'Sedang diproses',
                'nip' => null,
                'staff_id' => null
            ];

            // Set user-specific data based on role
            if ($_SESSION['user']['user_role'] == 'dosen') {
                $data['nip'] = $_SESSION['user']['nip'];
            } elseif ($_SESSION['user']['user_role'] == 'staff') {
                $data['staff_id'] = $_SESSION['user']['staff_id'];
            }

            try {
                $this->modulModel->saveModul($data);
                header('Location: ../views/modul/ModulFormView.php?success=1');
            } catch (Exception $e) {
                header('Location: ../views/modul/ModulFormView.php?error=' . urlencode($e->getMessage()));
            }
            exit();
        }
    }
}

$modulController = new ModulController($pdo);
$modulController->saveModul();
?>

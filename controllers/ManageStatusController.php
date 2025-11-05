<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../model/StatusModel.php';

class ManageStatusController
{
    private $statusModel;

    public function __construct($pdo)
    {
        $this->statusModel = new StatusModel($pdo);
    }

    public function getAllBookRequests($page = 1, $limit = 10, $search = '', $order = 'latest')
    {
        $offset = ($page - 1) * $limit;
        return $this->statusModel->getBookRequests($offset, $limit, $search, $order);
    }

    public function getAllModuleRequests($page = 1, $limit = 10, $search = '', $order = 'latest')
    {
        $offset = ($page - 1) * $limit;
        return $this->statusModel->getModuleRequests($offset, $limit, $search, $order);
    }

    public function countAllBookRequests($search = '')
    {
        return $this->statusModel->countBookRequests($search);
    }

    public function countAllModuleRequests($search = '')
    {
        return $this->statusModel->countModuleRequests($search);
    }

    public function updateStatus($id, $status, $type)
    {
        if ($type === 'buku') {
            $this->statusModel->updateBookStatus($id, $status);
            header('Location: ../views/manage/buku.php'); // Redirect to book management page
        } else if ($type === 'modul') {
            $this->statusModel->updateModuleStatus($id, $status);
            header('Location: ../views/manage/modul.php'); // Redirect to module management page
        }
        exit();
    }
}

$manageStatusController = new ManageStatusController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && isset($_POST['status']) && isset($_POST['type'])) {
        $manageStatusController->updateStatus($_POST['id'], $_POST['status'], $_POST['type']);
    }
}
?>



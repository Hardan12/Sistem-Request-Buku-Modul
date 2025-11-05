<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../core/db.php';
require_once __DIR__ . '/../model/RequestStatusModel.php';

class StatusController
{
    private $statusModel;

    public function __construct($pdo)
    {
        $this->statusModel = new RequestStatusModel($pdo);
    }

    public function getStatusByUser($page = 1, $search = '', $user_id, $user_role)
    {
        $limit = 10; // Jumlah data per halaman
        $offset = ($page - 1) * $limit;

        return $this->statusModel->getStatusByUser($offset, $limit, $search, $user_id, $user_role);
    }

    public function countAllRequests($search = '', $user_id, $user_role)
    {
        return $this->statusModel->countRequests($search, $user_id, $user_role);
    }
}

$statusController = new StatusController($pdo);

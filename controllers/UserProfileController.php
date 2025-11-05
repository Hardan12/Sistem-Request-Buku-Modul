<?php
require_once dirname(__DIR__) . '/model/UserProfileModel.php';

class UserProfileController {
    private $userProfileModel;

    public function __construct($pdo) {
        $this->userProfileModel = new UserProfileModel($pdo);
    }

    public function getUser($user_id, $user_role) {
        return $this->userProfileModel->getUser($user_id, $user_role);
    }

    public function updateUser($user_id, $user_role, $data) {
        $this->userProfileModel->updateUser($user_id, $user_role, $data);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    session_start();

    $user_id = $_SESSION['user']['user_id'];
    $user_role = $_SESSION['user']['user_role'];

    $data = [
        'nama' => $_POST['nama'],
        'email' => $_POST['email'],
        'username' => $_POST['username'],
        'password' => $_POST['password']
    ];

    if ($user_role == 'mahasiswa') {
        $data['prodi'] = $_POST['prodi'];
    }

    $controller = new UserProfileController($pdo);
    $controller->updateUser($user_id, $user_role, $data);

    header('Location: ../views/datadiri/profile.php?success=1');
    exit();
}
?>

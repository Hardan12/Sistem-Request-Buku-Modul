<?php
session_start();
require_once '../core/db.php';
require_once '../model/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct($pdo) {
        $this->userModel = new UserModel($pdo);
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->getUserByEmailAndPassword($email, $password);

            if ($user) {
                $_SESSION['user'] = [
                    'user_id' => $user['user_id'],
                    'user_nama' => $user['user_nama'],
                    'user_email' => $user['user_email'],
                    'user_role' => $user['user_role']
                ];

                if ($user['user_role'] == 'mahasiswa') {
                    $_SESSION['user']['nim'] = $user['nim'];
                } elseif ($user['user_role'] == 'dosen') {
                    $_SESSION['user']['nip'] = $user['nip'];
                } elseif ($user['user_role'] == 'staff') {
                    $_SESSION['user']['staff_id'] = $user['staff_id'];
                }

                // Debugging - Remove these lines after verification
                // echo '<pre>';
                // print_r($_SESSION['user']);
                // echo '</pre>';
                // exit;

                header('Location: ../views/profil/NavBar.php');
                exit();
            } else {
                $_SESSION['login_error'] = "Invalid email or password.";
                header('Location: ../views/auth/auth.php');
                exit();
            }
        }
    }

    public function register() {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
            $data = [
                'role' => $_POST['role'],
                'nama' => $_POST['nama'],
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => $_POST['password']
            ];

            if ($data['role'] == 'mahasiswa') {
                $data['nim'] = $_POST['nim'];
                $data['prodi'] = $_POST['prodi'];
            } elseif ($data['role'] == 'dosen') {
                $data['nip'] = $_POST['nip'];
            } elseif ($data['role'] == 'staff') {
                $data['staff_id'] = $_POST['staff_id'];
            }

            if ($this->userModel->registerUser($data)) {
                $_SESSION['success_message'] = "Registration successful. You can now log in.";
                header('Location: ../views/auth/auth.php');
                exit();
            } else {
                $_SESSION['register_error'] = "Registration failed.";
                header('Location: ../views/auth/auth.php');
                exit();
            }
        }
    }
}

$authController = new AuthController($pdo);

if (isset($_POST['login'])) {
    $authController->login();
} elseif (isset($_POST['register'])) {
    $authController->register();
}
?>

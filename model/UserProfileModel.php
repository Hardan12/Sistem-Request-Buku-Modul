<?php
require_once dirname(__DIR__) . '/core/db.php';

class UserProfileModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getUser($user_id, $user_role) {
        $sql = '';
        if ($user_role == 'mahasiswa') {
            $sql = "SELECT nim AS user_id, mhs_nama AS nama, mhs_email AS email, mhs_username AS username, password, prodi FROM mahasiswa WHERE nim = :user_id";
        } elseif ($user_role == 'dosen') {
            $sql = "SELECT nip AS user_id, dosen_nama AS nama, dosen_email AS email, dosen_username AS username, password FROM dosen WHERE nip = :user_id";
        } elseif ($user_role == 'staff') {
            $sql = "SELECT staff_id AS user_id, staff_nama AS nama, staff_email AS email, staff_username AS username, password FROM staff WHERE staff_id = :user_id";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':user_id' => $user_id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($user_id, $user_role, $data) {
        $sql = '';
        $params = [
            ':nama' => $data['nama'],
            ':email' => $data['email'],
            ':username' => $data['username'],
            ':password' => $data['password'],
            ':user_id' => $user_id
        ];

        if ($user_role == 'mahasiswa') {
            $sql = "UPDATE mahasiswa SET mhs_nama = :nama, mhs_email = :email, mhs_username = :username, password = :password, prodi = :prodi WHERE nim = :user_id";
            $params[':prodi'] = $data['prodi'];
        } elseif ($user_role == 'dosen') {
            $sql = "UPDATE dosen SET dosen_nama = :nama, dosen_email = :email, dosen_username = :username, password = :password WHERE nip = :user_id";
        } elseif ($user_role == 'staff') {
            $sql = "UPDATE staff SET staff_nama = :nama, staff_email = :email, staff_username = :username, password = :password WHERE staff_id = :user_id";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }
}
?>

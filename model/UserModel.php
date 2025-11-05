<?php
require_once '../core/db.php';

class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getUserByEmailAndPassword($email, $password) {
        $sql = "SELECT nim as user_id, mhs_nama as user_nama, mhs_email as user_email, 'mahasiswa' as user_role, nim, NULL as nip, NULL as staff_id FROM mahasiswa WHERE mhs_email = :email AND password = :password
                UNION 
                SELECT nip as user_id, dosen_nama as user_nama, dosen_email as user_email, 'dosen' as user_role, NULL as nim, nip, NULL as staff_id FROM dosen WHERE dosen_email = :email AND password = :password
                UNION 
                SELECT staff_id as user_id, staff_nama as user_nama, staff_email as user_email, 'staff' as user_role, NULL as nim, NULL as nip, staff_id FROM staff WHERE staff_email = :email AND password = :password";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    public function registerUser($data) {
        try {
            $this->pdo->beginTransaction();

            if ($data['role'] == 'mahasiswa') {
                $sql = "INSERT INTO mahasiswa (nim, mhs_nama, mhs_email, mhs_username, password, prodi) VALUES (:nim, :nama, :email, :username, :password, :prodi)";
            } elseif ($data['role'] == 'dosen') {
                $sql = "INSERT INTO dosen (nip, dosen_nama, dosen_email, dosen_username, password) VALUES (:nip, :nama, :email, :username, :password)";
            } elseif ($data['role'] == 'staff') {
                $sql = "INSERT INTO staff (staff_id, staff_nama, staff_email, staff_username, password) VALUES (:staff_id, :nama, :email, :username, :password)";
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nama', $data['nama']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $data['password']);
            $stmt->bindParam(':username', $data['username']);

            if ($data['role'] == 'mahasiswa') {
                $stmt->bindParam(':nim', $data['nim']);
                $stmt->bindParam(':prodi', $data['prodi']);
            } elseif ($data['role'] == 'dosen') {
                $stmt->bindParam(':nip', $data['nip']);
            } elseif ($data['role'] == 'staff') {
                $stmt->bindParam(':staff_id', $data['staff_id']);
            }

            $stmt->execute();
            $this->pdo->commit();

            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            die("Error registering user: " . $e->getMessage());
        }
    }
}
?>

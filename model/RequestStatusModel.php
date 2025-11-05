<?php

class RequestStatusModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getStatusByUser($offset, $limit, $search = '', $user_id, $user_role)
    {
        $sql = '';
        if ($user_role == 'mahasiswa') {
            $sql = "SELECT buku_id AS id, buku_judul AS title, 'buku' AS type, buku_status AS status
                FROM buku WHERE nim = :user_id AND buku.buku_judul LIKE :search LIMIT :offset, :limit";
        } elseif ($user_role == 'dosen') {
            $sql = "(SELECT buku_id AS id, buku_judul AS title, 'buku' AS type, buku_status AS status
                FROM buku WHERE nip = :user_id AND buku.buku_judul LIKE :search
                UNION
                SELECT modul_code AS id, modul_judul AS title, 'modul' AS type, modul_status AS status
                FROM modul WHERE nip = :user_id AND modul.modul_judul LIKE :search) LIMIT :offset, :limit";
        } elseif ($user_role == 'staff') {
            $sql = "(SELECT buku_id AS id, buku_judul AS title, 'buku' AS type, buku_status AS status
                FROM buku WHERE staff_id = :user_id AND buku.buku_judul LIKE :search
                UNION
                SELECT modul_code AS id, modul_judul AS title, 'modul' AS type, modul_status AS status
                FROM modul WHERE staff_id = :user_id AND modul.modul_judul LIKE :search) LIMIT :offset, :limit";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT); // Bind user_id parameter
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute(); // Remove the array argument here

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function countRequests($search = '', $user_id, $user_role)
    {
        $sql = '';
        if ($user_role == 'mahasiswa') {
            $sql = "SELECT COUNT(*) AS total
                FROM buku WHERE nim = :user_id AND buku.buku_judul LIKE :search";
        } elseif ($user_role == 'dosen') {
            $sql = "(SELECT COUNT(*) AS total
                FROM buku WHERE nip = :user_id AND buku.buku_judul LIKE :search)
                UNION
                (SELECT COUNT(*) AS total
                FROM modul WHERE nip = :user_id AND modul.modul_judul LIKE :search)";
        } elseif ($user_role == 'staff') {
            $sql = "(SELECT COUNT(*) AS total
                FROM buku WHERE staff_id = :user_id AND buku.buku_judul LIKE :search)
                UNION
                (SELECT COUNT(*) AS total
                FROM modul WHERE staff_id = :user_id AND modul.modul_judul LIKE :search)";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->execute();

        // Mengambil jumlah total dari hasil UNION
        $totals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Menghitung jumlah total keseluruhan
        $total = 0;
        foreach ($totals as $row) {
            $total += $row['total'];
        }

        return $total;
    }
}

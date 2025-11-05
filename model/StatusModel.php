<?php

class StatusModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getBookRequests($offset, $limit, $search = '', $order = 'latest')
    {
        $orderQuery = $order === 'latest' ? 'DESC' : 'ASC';
        $query = "SELECT buku.buku_id AS id, buku.buku_judul AS title, buku.buku_status AS status, 
                    mahasiswa.mhs_nama AS requester_name, 'mahasiswa' AS requester_role, 'buku' AS type
             FROM buku
             LEFT JOIN mahasiswa ON buku.nim = mahasiswa.nim
             LEFT JOIN dosen ON buku.nip = dosen.nip
             LEFT JOIN staff ON buku.staff_id = staff.staff_id
             WHERE (buku.nim IS NOT NULL OR buku.nip IS NOT NULL OR buku.staff_id IS NOT NULL)
             AND buku.buku_judul LIKE :search
             ORDER BY buku.buku_id $orderQuery
             LIMIT :offset, :limit";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getModuleRequests($offset, $limit, $search = '', $order = 'latest')
    {
        $orderQuery = $order === 'latest' ? 'DESC' : 'ASC';
        $query = "SELECT modul.modul_code AS id, modul.modul_judul AS title, modul.modul_status AS status, 
                    dosen.dosen_nama AS requester_name, 'dosen' AS requester_role, 'modul' AS type
             FROM modul
             LEFT JOIN dosen ON modul.nip = dosen.nip
             LEFT JOIN staff ON modul.staff_id = staff.staff_id
             WHERE (modul.nip IS NOT NULL OR modul.staff_id IS NOT NULL)
             AND modul.modul_judul LIKE :search
             ORDER BY modul.modul_code $orderQuery
             LIMIT :offset, :limit";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countBookRequests($search = '')
    {
        $query = "SELECT COUNT(*) AS total
              FROM buku
              LEFT JOIN mahasiswa ON buku.nim = mahasiswa.nim
              LEFT JOIN dosen ON buku.nip = dosen.nip
              LEFT JOIN staff ON buku.staff_id = staff.staff_id
              WHERE (buku.nim IS NOT NULL OR buku.nip IS NOT NULL OR buku.staff_id IS NOT NULL)
              AND buku.buku_judul LIKE :search";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function countModuleRequests($search = '')
    {
        $query = "SELECT COUNT(*) AS total
              FROM modul
              LEFT JOIN dosen ON modul.nip = dosen.nip
              LEFT JOIN staff ON modul.staff_id = staff.staff_id
              WHERE (modul.nip IS NOT NULL OR modul.staff_id IS NOT NULL)
              AND modul.modul_judul LIKE :search";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function updateBookStatus($id, $status)
    {
        $sql = "UPDATE buku SET buku_status = :status WHERE buku_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':status' => $status, ':id' => $id]);
    }

    public function updateModuleStatus($id, $status)
    {
        $sql = "UPDATE modul SET modul_status = :status WHERE modul_code = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':status' => $status, ':id' => $id]);
    }
}
?>

<?php

class BookModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function saveBook($data)
    {
        $fields = [
            'isbn', 'buku_judul', 'buku_penerbit',
            'buku_harga', 'buku_pengarang', 'buku_kategori', 'buku_status'
        ];

        if (isset($data['nim'])) {
            $fields[] = 'nim';
        }
        if (isset($data['staff_id'])) {
            $fields[] = 'staff_id';
        }
        if (isset($data['nip'])) {
            $fields[] = 'nip';
        }

        $placeholders = array_map(function ($field) {
            return ':' . $field;
        }, $fields);

        $sql = sprintf(
            "INSERT INTO buku (%s) VALUES (%s)",
            implode(", ", $fields),
            implode(", ", $placeholders)
        );

        $stmt = $this->pdo->prepare($sql);

        foreach ($fields as $field) {
            $stmt->bindValue(':' . $field, $data[$field]);
        }

        $stmt->execute();
    }
}
?>

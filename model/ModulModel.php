<?php

class ModulModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function saveModul($data) {
        $fields = [
            'modul_judul', 'modul_penulis', 'modul_file', 'modul_status'
        ];

        if (isset($data['nip'])) {
            $fields[] = 'nip';
        }
        if (isset($data['staff_id'])) {
            $fields[] = 'staff_id';
        }

        $placeholders = array_map(function($field) {
            return ':' . $field;
        }, $fields);

        $sql = sprintf(
            "INSERT INTO modul (%s) VALUES (%s)",
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

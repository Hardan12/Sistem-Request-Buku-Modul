<?php
class kurvabuku {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getInputCountByTitle() {
        $stmt = $this->pdo->prepare("SELECT buku_judul, COUNT(*) as input_count FROM buku GROUP BY buku_judul");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

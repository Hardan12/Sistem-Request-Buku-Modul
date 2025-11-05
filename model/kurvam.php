<?php
class kurvam {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getInputCountByTitle() {
        $stmt = $this->pdo->prepare("SELECT modul_judul, COUNT(*) as input_count FROM modul GROUP BY modul_judul");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

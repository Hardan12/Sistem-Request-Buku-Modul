<?php
require_once __DIR__ . '/../model/kurvabuku.php';

class kurvabukuc {
    private $kurvabuku;

    public function __construct($pdo) {
        $this->kurvabuku = new kurvabuku($pdo);
    }

    public function getInputCountByTitle() {
        return $this->kurvabuku->getInputCountByTitle();
    }
}
?>

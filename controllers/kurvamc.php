<?php
 require_once __DIR__ . '/../model/kurvam.php';

class kurvamc {
    private $kurvam;

    public function __construct($pdo) {
        $this->kurvam = new kurvam($pdo);
    }

    public function getInputCountByTitle() {
        return $this->kurvam->getInputCountByTitle();
    }
}
?>

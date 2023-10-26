<?php
class ClientController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getClientByUrl($url) {
        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE url = ?");
        $stmt->bind_param('s', $url);  // liez la variable $url au paramètre de la requête
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}


?>

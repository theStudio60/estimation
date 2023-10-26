<?php

require_once BASE_PATH . '/database.php';

class Client {

    private $connection;

    public function __construct() {
        $db = new Database();
        $this->connection = $db->getConnection();
    }

    public function getClientByUrl($url) {
        $sql = "SELECT * FROM clients WHERE url = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param('s', $url);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

  public function getCalculMethodForClient($clientId) {
    $sql = "SELECT mc.* 
            FROM methode_calcul mc 
            JOIN clients c ON c.methode_calcul_id = mc.id 
            WHERE c.id = ?";
    $stmt = $this->connection->prepare($sql);
    $stmt->bind_param("i", $clientId);
    $stmt->execute();

    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


    public function setCalculMethodForClient($clientId, $methodId) {
        $sql = "UPDATE clients SET methode_calcul_id = ? WHERE id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ii", $methodId, $clientId);
        return $stmt->execute();
    }

    public function getAllClients() {
        $sql = "SELECT * FROM clients";
        $result = $this->connection->query($sql);
        $clients = [];
        while ($row = $result->fetch_assoc()) {
            $clients[] = $row;
        }
        return $clients;
    }
}

?>


<?php

require_once BASE_PATH . '/database.php';

class Estimation {

    private $connection;

    public function __construct() {
        $db = new Database();
        $this->connection = $db->getConnection();
    }

    public function getPrixParM2($categorie) {
        $sql = "SELECT price_per_m2 FROM tarification WHERE categorie = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("s", $categorie);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $prixParM2 = $row['price_per_m2'];
            return $prixParM2;
        } else {
            return null;
        }
    }

    public function getAllPrices() {
        $sql = "SELECT categorie, price_per_m2 FROM tarification";
        $result = $this->connection->query($sql);

        $prices = [];
        while($row = $result->fetch_assoc()) {
            $prices[$row['categorie']] = $row['price_per_m2'];
        }

        return $prices;
    }
    
    

    public function saveEstimationData($data) {
       $sql = "INSERT INTO estimation (critere1, critere2, critere3, m2_categorie1, m2_categorie2, ajustement_categorie1, ajustement_categorie2, 	prix_total_estime, choix_bouton) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("sssssssss", $data['critere1'], $data['critere2'], $data['critere3'], $data['m2_categorie1'], $data['m2_categorie2'], $data['ajustement_categorie1'], $data['ajustement_categorie2'], $data['prix_total_estime'], $data['choix_bouton']);
        $stmt->execute();

        if($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}

?>


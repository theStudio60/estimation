<?php
include 'config.php';

try {
    $stmt = $conn->query("SELECT * FROM price_variations");
    $tarifs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($tarifs);
} catch(PDOException $e) {
    echo json_encode(["error" => "Erreur lors de la récupération des variations : " . $e->getMessage()]);
}
?>

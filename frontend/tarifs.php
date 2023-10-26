<?php
include 'config.php';  

header('Content-Type: application/json');

try {
    $stmt = $conn->query("SELECT category_name, price_per_m2, threshold_m2, price_after_threshold FROM price_variations");
    
    $tarifs = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $category = $row['category_name'];
        unset($row['category_name']); 
        $tarifs[$category] = $row;
    }

    echo json_encode($tarifs);
    
} catch(PDOException $e) {
    echo json_encode(["error" => "Erreur lors de la récupération des tarifs: " . $e->getMessage()]);
}
?>

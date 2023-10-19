<?php
include 'config.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

try {
    $stmt = $conn->prepare("INSERT INTO estimations (description, quantite, prix_unitaire, total) VALUES (?, ?, ?, ?)");
    
    foreach ($data['estimations'] as $item) {
        $stmt->execute([$item['description'], $item['quantite'], $item['prix_unitaire'], $item['total']]);
    }
} catch(PDOException $e) {
    echo json_encode(["error" => "Erreur lors de l'enregistrement des données d'estimation: " . $e->getMessage()]);
    exit;
}

if (isset($data['contact'])) {
    try {
        $stmt = $conn->prepare("INSERT INTO contacts (nom, prenom, entreprise, email, telephone) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$data['contact']['nom'], $data['contact']['prenom'], $data['contact']['entreprise'], $data['contact']['email'], $data['contact']['telephone']]);
    } catch(PDOException $e) {
        echo json_encode(["error" => "Erreur lors de l'enregistrement des coordonnées du prospect: " . $e->getMessage()]);
        exit;
    }
}

echo json_encode(["message" => "Données enregistrées avec succès!"]);
?>

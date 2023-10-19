<?php
include 'config.php';

$categorie1_price_per_m2 = $_POST['categorie1_price_per_m2'];
$categorie1_threshold_m2 = $_POST['categorie1_threshold_m2'];
$categorie1_price_after_threshold = $_POST['categorie1_price_after_threshold'];

$categorie2_price_per_m2 = $_POST['categorie2_price_per_m2'];
$categorie2_threshold_m2 = $_POST['categorie2_threshold_m2'];
$categorie2_price_after_threshold = $_POST['categorie2_price_after_threshold'];

try {
    $stmt1 = $conn->prepare("UPDATE price_variations SET price_per_m2 = ?, threshold_m2 = ?, price_after_threshold = ? WHERE category_name = 'Catégorie 1'");
    $stmt1->execute([$categorie1_price_per_m2, $categorie1_threshold_m2, $categorie1_price_after_threshold]);

    $stmt2 = $conn->prepare("UPDATE price_variations SET price_per_m2 = ?, threshold_m2 = ?, price_after_threshold = ? WHERE category_name = 'Catégorie 2'");
    $stmt2->execute([$categorie2_price_per_m2, $categorie2_threshold_m2, $categorie2_price_after_threshold]);

    header('Location: ./backoffice.php?success=true');
} catch(PDOException $e) {
    echo "Erreur lors de la mise à jour des variations : " . $e->getMessage();
}
?>

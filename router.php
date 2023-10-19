<?php
include_once 'controllers/EstimationController.php';

$controller = new EstimationController();

// Si le formulaire d'estimation est soumis, traitez-le
if (isset($_POST['demandeDevisBtn']) || isset($_POST['refusOffreBtn'])) {
    $controller->handleFormSubmission();
} else {
    // Sinon, affichez simplement le formulaire d'estimation
    $controller->showEstimationForm();
}
?>


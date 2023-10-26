<?php
include_once 'controllers/EstimationController.php';
include_once 'controllers/ClientController.php';
include_once 'database.php';

$clientController = new ClientController($pdo);

$url = isset($_GET['url']) ? $_GET['url'] : null;

$clientInfo = $clientController->getClientByUrl($url);

$estimationController = new EstimationController();

if (isset($_POST['demandeDevisBtn']) || isset($_POST['refusOffreBtn'])) {
    $estimationController->handleFormSubmission($clientInfo);
} else {
    $estimationController->showEstimationForm('', $clientInfo);
}
?>


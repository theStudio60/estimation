<?php
require 'database.php';
include_once 'models/Estimation.php';

class EstimationController {

    private $estimation;

    public function __construct() {
        $this->estimation = new Estimation();
    }

    public function handleFormSubmission() {
        if(isset($_POST['demandeDevisBtn']) || isset($_POST['refusOffreBtn'])) {
            $action = isset($_POST['demandeDevisBtn']) ? 'demande_devis' : 'refus_offre';

            $data = [
                'critere1' => $_POST['critere1'] ?? '',
                'critere2' => $_POST['critere2'] ?? '',
                'critere3' => $_POST['critere3'] ?? '',
                'm2_categorie1' => $_POST['m2Categorie1'] ?? '',
                'm2_categorie2' => $_POST['m2Categorie2'] ?? '',
                'ajustement_categorie1' => $_POST['ajustementCategorie1'] ?? '',
                'ajustement_categorie2' => $_POST['ajustementCategorie2'] ?? '',
                'prix_total_estime' => $_POST['prix_total_estime'] ?? '0',
                'choix_bouton' => $action
            ];

            // Validation côté serveur
            $requiredFields = ['critere1', 'critere2', 'critere3', 'm2_categorie1', 'm2_categorie2', 'ajustement_categorie1', 'ajustement_categorie2'];
            
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    $message = "Veuillez remplir tous les champs avant de soumettre le formulaire.";
                    $this->showEstimationForm($message); // Affichez le formulaire avec le message d'erreur.
                    return; 
                }
            }

            $isSaved = $this->estimation->saveEstimationData($data);
            if(!$isSaved) {
                $message = "Une erreur est survenue lors de la sauvegarde.";
                $this->showEstimationForm($message);
                return;
            }


         if($action == 'demande_devis') {
    header("Location: views/formulaire_demande.php");
    exit;
} else {
    header("Location: views/formulaire_refus.php");
    exit;
}

        } else {
            // Si aucun formulaire n'est soumis, montrez simplement le formulaire d'estimation.
            $this->showEstimationForm();
        }
    }

    public function showEstimationForm($message = '') {
        $prices = $this->estimation->getAllPrices();
        $plafondsPrice = $prices['categorie1'] ?? '';
        $mursPrice = $prices['categorie2'] ?? '';
        include 'views/estimation.php';
    }
}
?>


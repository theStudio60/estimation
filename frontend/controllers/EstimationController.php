<?php
require 'database.php';
include_once 'models/Estimation.php';
include_once 'models/Client.php';

class EstimationController {
    private $estimation;
    private $client;

    public function __construct() {
        $this->estimation = new Estimation();
        $this->client = new Client();
    }

    public function handleFormSubmission($clientInfo) {
        if(isset($_POST['demandeDevisBtn']) || isset($_POST['refusOffreBtn'])) {
            $action = isset($_POST['demandeDevisBtn']) ? 'demande_devis' : 'refus_offre';

            $data = [
                'client_id' => $clientInfo['id'],
                'critere1' => $_POST['critere1'] ?? '',
                'critere2' => $_POST['critere2'] ?? '',
                'critere3' => $_POST['critere3'] ?? '',
                'm2_categorie1' => $_POST['m2Categorie1'] ?? '',
                'm2_categorie2' => $_POST['m2Categorie2'] ?? '',
                'ajustement_categorie1' => $_POST['ajustementCategorie1'] ?? '',
                'ajustement_categorie2' => $_POST['ajustementCategorie2'] ?? ''
            ];

            // Utiliser la valeur du prix total estimé du formulaire
            $prixTotalFromForm = $_POST['prix_total_estime'] ?? 0;
            $data['prix_total_estime'] = $prixTotalFromForm;
            
            $data['choix_bouton'] = $action;

            $requiredFields = ['critere1', 'critere2', 'critere3', 'm2_categorie1', 'm2_categorie2', 'ajustement_categorie1', 'ajustement_categorie2'];

            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    $message = "Veuillez remplir tous les champs avant de soumettre le formulaire.";
                    $this->showEstimationForm($message, $clientInfo); 
                    return; 
                }
            }

            $isSaved = $this->estimation->saveEstimationData($data);
            if(!$isSaved) {
                $message = "Une erreur est survenue lors de la sauvegarde.";
                $this->showEstimationForm($message, $clientInfo);
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
            $this->showEstimationForm('', $clientInfo);
        }
    }

    public function showEstimationForm($message = '', $clientInfo = null) {
        $prices = $this->estimation->getAllPrices();
        $plafondsPrice = $prices['categorie1'] ?? '';
        $mursPrice = $prices['categorie2'] ?? '';
        include 'views/estimation.php';
    }

    public function calculateEstimation($data, $methodId) {
        $methodeCalcul = $this->estimation->getCalculMethodById($methodId);
    
        $prix_total_estime = 0;
    
        if ($methodeCalcul && $methodeCalcul['nom'] == 'Pallier') {
            $prix_total_estime = $this->calculatePriceBasedOnPallier($data['m2_categorie1'], $methodeCalcul['formule_id']);
        } elseif ($methodeCalcul && $methodeCalcul['nom'] == 'Forfait') {
            $prix_total_estime = $this->calculatePriceBasedOnForfait($data['m2_categorie1'], $methodeCalcul['formule_id']);
        } elseif ($methodeCalcul && $methodeCalcul['nom'] == 'Coefficient fixe') {
            $prix_total_estime = $this->calculatePriceBasedOnCoefficient($data['m2_categorie1'], $methodeCalcul['formule_id']);
        }
    
        return $prix_total_estime;
    }

    private function calculatePriceBasedOnPallier($surface, $formuleId) {
        $palliers = $this->estimation->getPalliersByFormuleId($formuleId);
        
        foreach ($palliers as $pallier) {
            if ($surface >= $pallier['limite_inf'] && (!$pallier['limite_sup'] || $surface <= $pallier['limite_sup'])) {
                return $surface * $pallier['tarif'];
            }
        }
        
        return 0;
    }
    
    private function calculatePriceBasedOnForfait($surface, $formuleId) {
        $forfaits = $this->estimation->getForfaitsByFormuleId($formuleId);
        
        foreach ($forfaits as $forfait) {
            if ($surface == $forfait['quantite']) {
                return $forfait['tarif'];
            }
        }
        
        return 0; 
    }

    private function calculatePriceBasedOnCoefficient($surface, $formuleId) {
        $coefficient = $this->estimation->getCoefficientByFormuleId($formuleId);
        if ($coefficient) {
            return $surface * $coefficient['valeur'];
        }
        
        return 0; 
    }
}
?>


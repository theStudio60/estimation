
 <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estimation des coûts</title>
    <link rel="stylesheet" href="./frontend/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">MonSite</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./backoffice.php">BackOffice</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Connexion</a>
                </li>
              
            </ul>
        </div>
    </nav>
</header>

<body data-plafonds-price="<?= $plafondsPrice ?>" data-murs-price="<?= $mursPrice ?>">
<?php
if (isset($clientInfo) && $clientInfo) {
    echo "<div class='container mt-4' style='border: 1px solid #e0e0e0; padding: 20px; border-radius: 10px;'>";
    echo "<h1 style='color: #333; font-size: 24px;'>" . htmlspecialchars($clientInfo['prenom']) . " " . htmlspecialchars($clientInfo['nom']) . "</h1>";
    echo "<img src='" . htmlspecialchars($clientInfo['logo_url']) . "' alt='Logo' class='img-fluid' style='max-width: 150px; margin-top: 10px;'>";
    echo "</div>";
}
?>



    <div class="container mt-5">
        <h3 class="mb-4">Formulaire d'estimation</h3>
        <form action="index.php" method="post">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td>Critères de sélection</td>
                        <td>
                            <select class="form-select selection" name="critere1">
                                <option value="option1">Option 1</option>
                                <option value="option2">Option 2</option>
                                <option value="option3">Option 3</option>
                            </select>
                            <select class="form-select selection" name="critere2">
                                <option value="option1">Option 1</option>
                                <option value="option2">Option 2</option>
                                <option value="option3">Option 3</option>
                            </select>
                            <select class="form-select selection" name="critere3">
                                <option value="option1">Option 1</option>
                                <option value="option2">Option 2</option>
                                <option value="option3">Option 3</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
    <td id="categorie1Label">Plafonds</td>
    <td><input type="number" class="form-control" name="m2Categorie1" value="0" placeholder="m2" required>

</td>
</tr>
<tr>
    <td id="categorie2Label">Murs</td>
    <td><input type="number" class="form-control" name="m2Categorie2" value="0" placeholder="m2" required></td>
</tr>

                    <tr>
                        <td>Catégorie 1 Ajustement</td>
                        <td>
                            <select class="form-select rating" name="ajustementCategorie1" required>
                                <option value="" disabled selected>Choisissez une option</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Catégorie 2 Ajustement</td>
                        <td>
                            <select class="form-select rating" name="ajustementCategorie2" required>
                                <option value="" disabled selected>Choisissez une option</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>

           <div class="card mt-4">
    <div class="card-body">Le prix total estimé est de : <span id="prixTotal"><?php echo $prixTotal ?? '0'; ?></span> $</div>
    <input type="hidden" id="prixTotalInput" name="prix_total_estime">
    <input type="hidden" name="client_id" value="<?= isset($clientInfo['id']) ? htmlspecialchars($clientInfo['id']) : '' ?>">
</div>

            <button type="submit" class="btn btn-success" name="demandeDevisBtn">Demander une offre d'estimation</button>


        <?php if(isset($_POST['demandeDevisBtn'])): ?>
   
        <?php endif; ?>

        <button type="submit" class="btn btn-danger" name="refusOffreBtn">Refuser l'offre</button>

        <?php if(isset($_POST['refusOffreBtn'])): ?>
       
        <?php endif; ?>

        <?php if(isset($message) && $message): ?>
        <div class="alert alert-info mt-5">
            <?php echo $message; ?>
        </div>
        <?php endif; ?>

    </div>
        <script src="./app.js"></script>
</body>



</html>

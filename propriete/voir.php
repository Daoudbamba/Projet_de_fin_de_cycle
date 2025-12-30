<!DOCTYPE html>
<html>
<head>
    <title>Affichage des propriétés</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/code.css">
</head>
<body>

<?php
require "database.php";

// Récupération des détails des propriétés depuis la base de données
$req = $connection->query('SELECT * FROM propriete');
while ($propriete = $req->fetch_assoc()) {
    ?> 
    <div class="container admin" style="border:1px solid black;">
        <div class="row">
            <div class="col-md-6">
                <h1><strong>Voir les propriétés</strong></h1>
                <br>
                <form>
                    <div>ID: <?= $propriete['id']; ?></div>
                    <div>Adresse: <?= $propriete['adresse']; ?></div>
                    <div>Nombre de chambres: <?= isset($propriete['nombrechambres']) ? $propriete['nombrechambres'] : 'Non spécifié'; ?></div>
                    <div>Nombre de salons: <?= isset($propriete['nombresalons']) ? $propriete['nombresalons'] : 'Non spécifié'; ?></div>
                    <div>Nombre de parkings: <?= isset($propriete['nombreparkings']) ? $propriete['nombreparkings'] : 'Non spécifié'; ?></div>
                    <div>Nombre de cuisines: <?= isset($propriete['nombrecuisines']) ? $propriete['nombrecuisines'] : 'Non spécifié'; ?></div>
                    <div>Prix: <?= number_format((float)$propriete['prix'], 2, '.', '') . ' €'; ?></div>
                    <div>Type: <?= isset($propriete['statut']) ? $propriete['statut'] : 'Non spécifié'; ?></div>
                    <div>Opération: <?= isset($propriete['operation']) ? $propriete['operation'] : 'Non spécifié'; ?></div>
                    <div>Image: <?= isset($propriete['image']) ? $propriete['image'] : 'Image non disponible'; ?> </div>
                </form>
                <br>
                <div class="form-actions"><a class="btn btn-primary" href="code.php"><span class="bi-arrow-left"></span> Retour</a> </div> 
            </div>
            <br>
            
            <div class="col-md-6 site">
                <div class="img-thumbnail">
                    <img align="center" src="<?= isset($propriete['image']) ? 'imagess/'.$propriete['image'] : 'imagess/default.jpg'; ?>" alt="...">
                    <div class="price"><?= isset($propriete['prix']) ? number_format((float)$propriete['prix'], 2, '.', ''). ' €' : 'Prix non disponible'; ?></div>
                    <p><?= isset($propriete['adresse']) ? $propriete['adresse'] : ''; ?></p>
                   
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php
}  
?>    
  
</body>
</html>

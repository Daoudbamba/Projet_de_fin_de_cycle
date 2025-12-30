<!DOCTYPE html>
<html>
<head>
    <title>affichage</title>

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

// Récupération des détails des appartements depuis la base de données
$req = $connection->query('SELECT * FROM appartement');
while ($appartement = $req->fetch_assoc()) {
    ?> 
    <div class="container admin" style="border:1px solid black;">
        <div class="row">
            <div class="col-md-6">
                <h1><strong>Voir les appartements</strong></h1>
                <br>
                <form>
                    <div>ID: <?= $appartement['id']; ?></div>
                    <div>Adresse: <?= $appartement['adresse']; ?></div>
                    <div>Taille: <?= $appartement['taille']; ?></div>
                    <!-- Vérification si la clé 'nombre_chambres' est définie -->
                    <div>Nombre de chambres: <?= isset($appartement['nombrechambres']) ? $appartement['nombrechambres'] : 'Non spécifié'; ?></div>
                    <div>Prix: <?= number_format((float)$appartement['prix'], 2, '.', '') . ' €'; ?></div>
                    <!-- Vérification si la clé 'image' est définie -->
                    <div>Image: <?= isset($appartement['images']) ? $appartement['images'] : 'Image non disponible'; ?> </div>
                </form>
                <br>
                <div class="form-actions"><a class="btn btn-primary" href="code.php"><span class="bi-arrow-left"></span> Retour</a> </div> 
            </div>
            <br>
            
            <div class="col-md-6 site">
                <div class="img-thumbnail">
                    <!-- Vérification si la clé 'image' est définie -->
                    <img align="center" src="<?= isset($appartement['images']) ? 'imagess/'.$appartement['images'] : 'imagess/default.jpg'; ?>" alt="...">
                    <!-- Vérification si la clé 'prix' est définie -->
                    <div class="price"><?= isset($appartement['prix']) ? number_format((float)$appartement['prix'], 2, '.', ''). ' €' : 'Prix non disponible'; ?></div>
                   
                    <!-- Vérification si la clé 'adresse' est définie -->
                    <p><?= isset($appartement['adresse']) ? $appartement['adresse'] : ''; ?></p>
                   
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

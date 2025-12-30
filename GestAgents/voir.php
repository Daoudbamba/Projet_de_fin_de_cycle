<!DOCTYPE html>
<html>
<head>
    <title>Affichage des agents</title>
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

// Récupération des détails des agents depuis la base de données
$req = $connection->query('SELECT * FROM agent');
while ($agent = $req->fetch_assoc()) {
    ?> 
    <div class="container admin" style="border:1px solid black;">
        <div class="row">
            <div class="col-md-6">
                <h1><strong>Voir les agents</strong></h1>
                <br>
                <form>
                    <div>ID: <?= $agent['id']; ?></div>
                    <div>Nom: <?= $agent['nom']; ?></div>
                    <div>Prénom: <?= $agent['prenom']; ?></div>
                    <div>Description: <?= isset($agent['description']) ? $agent['description'] : 'Non spécifié'; ?></div>
                    <div>Email: <?= isset($agent['email']) ? $agent['email'] : 'Non spécifié'; ?></div>
                    <div>Numéro: <?= isset($agent['numero']) ? $agent['numero'] : 'Non spécifié'; ?></div>
                </form>
                <br>
                <div class="form-actions"><a class="btn btn-primary" href="code.php"><span class="bi-arrow-left"></span> Retour</a> </div> 
            </div>
            <br>
            
            <div class="col-md-6 site">
                <div class="img-thumbnail">
                    <img align="center" src="<?= isset($agent['image']) ? 'imagess/'.$agent['image'] : 'imagess/default.jpg'; ?>" alt="...">                    
                    <a href="mailto:<?= isset($agent['email']) ? $agent['email'] : 'daoudabenbamba@gmail.com'; ?>" class="btn btn-order" role="button"><span class="bi-cart-fill"> Contacter</span> </a>
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

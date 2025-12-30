<?php
require "database.php";
if (isset($_POST['Envoyer'])) {
    if (!empty($_POST['adresse']) && !empty($_POST['taille']) && !empty($_POST['nombre_chambres']) && !empty($_POST['prix']) && !empty($_POST['image'])) {
        $adresse = htmlspecialchars($_POST['adresse']);
        $taille = htmlspecialchars($_POST['taille']);
        $nombre_chambres = htmlspecialchars($_POST['nombre_chambres']);
        $prix = htmlspecialchars($_POST['prix']);
        $image = htmlspecialchars($_POST['image']);


        $insertion = $connection->prepare('INSERT INTO appartement (adresse, taille, nombrechambres, prix, images) VALUES (?, ?, ?, ?, ?)');
        if (!$insertion) {
            die('Erreur de préparation de la requête : ' . $connection->error);
        }

        $insertion->bind_param('sssss', $adresse, $taille, $nombre_chambres, $prix,  $image);
        if ($insertion->execute()) {
            echo "Bien immobilier ajouté avec succès.";
            header("Location: code.php");
        } else {
            echo "Erreur lors de l'ajout du bien immobilier : " . $insertion->error;
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Publier</title>
	 <link rel="stylesheet" type="text/css" href="css/authentification.css">
	
</head>
<body>
	<form method="POST" action="" >
		 <h1>Ajouter un Bien Immobilier</h1>
		<div class="inputs">
		
		<input type="text" name="adresse" autocomplete="off" placeholder="l'adresse" required>

		
		<input type="text" name="taille" autocomplete="off" placeholder="la taille de l'appart" required>
	
		
		<input type="text" name="nombre_chambres" autocomplete="off" placeholder="le nombre de chambres" required><br>
	
		<input type="text" name="prix" pattern="[0-9]+(\.[0-9]{1,2})?" title="Veuillez saisir un nombre décimal valide" required autocomplete="off" placeholder="le prix de l'appart">

		<input type="text" name="image" autocomplete="off" placeholder="Image de l'appart">
		
	</div>
	<p align="center"><span style="color:red;">*</span>Veuillez ajouter un nouveau appartement<span style="color:red;">*</span></p>
	<div align="center" class="envoi">
		<input type="submit" name="Envoyer" >
		<input type="reset" name="Annuler" value="Annuler" >
	</div>
		
	</form>
</body>

</html>

<?php
require "database.php";
if (isset($_POST['Envoyer'])) {
    if (!empty($_POST['image']) && !empty($_POST['prix']) && !empty($_POST['adresse'])  && !empty($_POST['nombrechambres']) && !empty($_POST['nombresalons']) && !empty($_POST['nombreparkings']) && !empty($_POST['nombrecuisines'])) {
    	$image = htmlspecialchars($_POST['image']);
    	$prix = htmlspecialchars($_POST['prix']);
        $adresse = htmlspecialchars($_POST['adresse']);
        $nombrechambres = htmlspecialchars($_POST['nombrechambres']);
        $nombresalons = htmlspecialchars($_POST['nombresalons']);
        $nombreparkings = htmlspecialchars($_POST['nombreparkings']);
        $nombrecuisines = htmlspecialchars($_POST['nombrecuisines']);
        $statut = htmlspecialchars($_POST['statut']);
        $type = htmlspecialchars($_POST['type']);
        

        $insertion = $connection->prepare('INSERT INTO propriete (image, prix, adresse, nombrechambres, nombresalons, nombreparkings, nombrecuisines, statut, operation ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        if (!$insertion) {
            die('Erreur de préparation de la requête : ' . $connection->error);
        }

        $insertion->bind_param('sssssssss', $image, $prix, $adresse, $nombrechambres, $nombresalons, $nombreparkings, $nombrecuisines, $statut, $type );
        if ($insertion->execute()) {
            echo "Propriété ajoutée avec succès.";
            header("Location: code.php");
        } else {
            echo "Erreur lors de l'ajout de la propriété : " . $insertion->error;
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
		 <h1>Ajouter une Propriété</h1>
		<div class="inputs">

		<input type="text" name="image" autocomplete="off" placeholder="URL de l'image">
		<input type="text" name="prix" pattern="[0-9]+(\.[0-9]{1,2})?" title="Veuillez saisir un nombre décimal valide" required autocomplete="off" placeholder="Prix">
		<input type="text" name="adresse" autocomplete="off" placeholder="Adresse" required>
		<input type="text" name="nombrechambres" autocomplete="off" placeholder="Nombre de chambres" required>
		<input type="text" name="nombresalons" autocomplete="off" placeholder="Nombre de salons" required>
		<input type="text" name="nombreparkings" autocomplete="off" placeholder="Nombre de parkings" required>
		<input type="text" name="nombrecuisines" autocomplete="off" placeholder="Nombre de cuisines" required>
		<select name="statut" class="form-control" style="padding: 15px; border-radius: 5px; border: none; background-color: #f2f2f2; margin-bottom: 10px; outline: none; font-family: 'Roboto', sans-serif;">
        <option>Propriété</option>
        <option>Appartement</option>
        <option>Bâtiment</option>
        <option>Bureau</option>
        </select>
        <select name="type" class="form-control" style="padding: 15px; border-radius: 5px; border: none; background-color: #f2f2f2; margin-bottom: 10px; outline: none; font-family: 'Roboto', sans-serif;">
        <option>operation</option>
        <option>Acheter</option>
        <option>Louer</option>
       
        </select>

		
	
	</div>
	<p align="center"><span style="color:red;">*</span>Veuillez ajouter une nouvelle propriété<span style="color:red;">*</span></p>
	<div align="center" class="envoi">
		<input type="submit" name="Envoyer" value="Envoyer">
		<input type="reset" name="Annuler" value="Annuler">
	</div>
		
	</form>
</body>
</html>

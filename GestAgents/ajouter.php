<?php
require "database.php";

if (isset($_POST['Envoyer'])) {
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['description']) && !empty($_POST['email']) && !empty($_POST['numero']) && !empty($_POST['image'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $prenom = htmlspecialchars($_POST['prenom']);
        $description = htmlspecialchars($_POST['description']);
        $email = htmlspecialchars($_POST['email']);
        $numero = htmlspecialchars($_POST['numero']);
        $image = htmlspecialchars($_POST['image']);

        $insertion = $connection->prepare('INSERT INTO agent (nom, prenom, description, email, numero, image) VALUES (?, ?, ?, ?, ?, ?)');
        if (!$insertion) {
            die('Erreur de préparation de la requête : ' . $connection->error);
        }

        $insertion->bind_param('ssssss', $nom, $prenom, $description, $email, $numero, $image);
        if ($insertion->execute()) {
            echo "Agent ajouté avec succès.";
            header("Location: voir.php");  // Change to the appropriate redirection page
        } else {
            echo "Erreur lors de l'ajout de l'agent : " . $insertion->error;
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
    <title>Ajouter un Agent</title>
    <link rel="stylesheet" type="text/css" href="css/authentification.css">
</head>
<body>
    <form method="POST" action="">
        <h1>Ajouter un Agent</h1>
        <div class="inputs">
            <input type="text" name="nom" autocomplete="off" placeholder="Nom" required>
            <input type="text" name="prenom" autocomplete="off" placeholder="Prénom" required>
            <textarea name="description" autocomplete="off" placeholder="Description" required></textarea>
            <input type="email" name="email" autocomplete="off" placeholder="Email" required>
            <input type="text" name="numero" autocomplete="off" placeholder="Numéro de téléphone" required>
            <input type="text" name="image" autocomplete="off" placeholder="URL de l'image" required>
        </div>
        <p align="center"><span style="color:red;">*</span>Veuillez remplir tous les champs<span style="color:red;">*</span></p>
        <div align="center" class="envoi">
            <input type="submit" name="Envoyer">
            <input type="reset" name="Annuler" value="Annuler">
        </div>
    </form>
</body>
</html>

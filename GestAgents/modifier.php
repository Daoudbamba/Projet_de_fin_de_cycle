<?php
require "database.php";
$nom = $prenom = $description = $email = $numero = '';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $requete = $connection->prepare('SELECT * FROM agent WHERE id = ?');
    $requete->bind_param('i', $id);
    $requete->execute();

    $resultat = $requete->get_result();
    $nombre_lignes = $resultat->num_rows;

    if ($nombre_lignes > 0) {
        $agent = $resultat->fetch_assoc();
        $nom = $agent['nom'];
        $prenom = $agent['prenom'];
        $description = $agent['description'];
        $email = $agent['email'];
        $numero = $agent['numero'];
        $image = $agent['image'];

        if (isset($_POST['valider'])) {
            $nom_saisie = htmlspecialchars($_POST['nom']);
            $prenom_saisie = htmlspecialchars($_POST['prenom']);
            $description_saisie = htmlspecialchars($_POST['description']);
            $email_saisie = htmlspecialchars($_POST['email']);
            $numero_saisie = htmlspecialchars($_POST['numero']);
            $image_saisie = htmlspecialchars($_POST['image']);

            $modification = $connection->prepare('UPDATE agent SET nom = ?, prenom = ?, description = ?, email = ?, numero = ? , image = ? WHERE id = ?');
            $modification->bind_param('ssssssi', $nom_saisie, $prenom_saisie, $description_saisie, $email_saisie, $numero_saisie, $image_saisie, $id);
            if ($modification->execute()) {
                header('location: voir.php');
            } else {
                echo "Erreur lors de la modification : " . $modification->error;
            }
        }
    } else {
        echo "Aucun agent trouvé.";
    }
} else {
    echo "Aucun identifiant spécifié.";
}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modification Agent</title>
    <link rel="stylesheet" type="text/css" href="css/authentification.css">
</head>
<body>
    <form method="POST" action="">
        <h1>Modification Agent</h1>
        <div class="inputs">
            <input type="text" name="nom" value="<?= $nom; ?>" autocomplete="off" placeholder="Nom" required>
            <input type="text" name="prenom" value="<?= $prenom; ?>" autocomplete="off" placeholder="Prénom" required>
            <input type="text" name="description" value="<?= $description; ?>" autocomplete="off" placeholder="Description" required>
            <input type="text" name="email" value="<?= $email; ?>" autocomplete="off" placeholder="Email" required>
            <input type="text" name="numero" value="<?= $numero; ?>" pattern="[0-9]+" title="Veuillez saisir un numéro de téléphone valide" required autocomplete="off" placeholder="Numéro de téléphone">
            <input type="text" name="image" autocomplete="off" value="<?=  $image; ?>" placeholder="URL de l'image" required>
        </div>
        <p align="center"><span style="color:red;">*</span>Veuillez modifier les informations de l'agent<span style="color:red;">*</span></p>
        <div align="center" class="envoi">
            <input type="submit" name="valider">
            <input type="reset" name="Annuler" value="Annuler">
        </div>
    </form>
</body>
</html>

<?php
require "database.php";
$adresse = $taille = $nombrechambres = $prix = $images = '';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $requete = $connection->prepare('SELECT * FROM appartement WHERE id = ?');
    $requete->bind_param('i', $id);
    $requete->execute();

    $resultat = $requete->get_result();
    $nombre_lignes = $resultat->num_rows;

    if ($nombre_lignes > 0) {
        $bien_immobilier = $resultat->fetch_assoc();
        $adresse = $bien_immobilier['adresse'];
        $taille = $bien_immobilier['taille'];
        $nombrechambres = $bien_immobilier['nombrechambres'];
        $prix = $bien_immobilier['prix'];
        $images = $bien_immobilier['images'];

        if (isset($_POST['valider'])) {
            $adresse_saisie = htmlspecialchars($_POST['adresse']);
            $taille_saisie = htmlspecialchars($_POST['taille']);
            $nombre_chambres_saisi = htmlspecialchars($_POST['nombrechambres']);
            $prix_saisi = htmlspecialchars($_POST['prix']);
            $image_saisie = htmlspecialchars($_POST['images']);

            $modification = $connection->prepare('UPDATE appartement SET adresse = ?, taille = ?, nombrechambres = ?, prix = ?, images = ? WHERE id = ?');
            $modification->bind_param('sssssi', $adresse_saisie, $taille_saisie, $nombre_chambres_saisi, $prix_saisi, $image_saisie, $id);
            if ($modification->execute()) {
                header('location: voir.php');
            } else {
                echo "Erreur lors de la modification : " . $modification->error;
            }
        }
    } else {
        echo "Aucun bien immobilier trouvé.";
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
    <title>Modification</title>
    <link rel="stylesheet" type="text/css" href="css/authentification.css">
</head>
<body>
    <form method="POST" action="">
        <h1>Modification</h1>
        <div class="inputs">
            <input type="text" name="adresse" value="<?= $adresse; ?>" autocomplete="off" placeholder="L'adresse de l'appartement">
            <input type="text" name="taille" value="<?= $taille; ?>" placeholder="La taille de l'appartement" required>
            <input type="text" name="nombrechambres" value="<?= $nombrechambres; ?>" autocomplete="off" placeholder="Le nombre de chambres" required>
            <input type="text" name="prix" value="<?= $prix; ?>" pattern="[0-9]+(\.[0-9]{1,2})?" title="Veuillez saisir un nombre décimal valide" required autocomplete="off" placeholder="Le prix de l'appartement">
            <input type="text" name="images" value="<?= $images; ?>" autocomplete="off" placeholder="Image de l'appartement">
        </div>
        <p align="center"><span style="color:red;">*</span>Veuillez ajouter la modification<span style="color:red;">*</span></p>
        <div align="center" class="envoi">
            <input type="submit" name="valider">
            <input type="reset" name="Annuler" value="Annuler">
        </div>
    </form>
</body>
</html>

<?php
require "database.php";
$image  =$prix =$adresse = $nombrechambres = $nombresalons = $nombreparkings = $nombrecuisines =  $statut = $operation = '';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $requete = $connection->prepare('SELECT * FROM propriete WHERE id = ?');
    $requete->bind_param('i', $id);
    $requete->execute();

    $resultat = $requete->get_result();
    $nombre_lignes = $resultat->num_rows;

    if ($nombre_lignes > 0) {
        $propriete = $resultat->fetch_assoc();
        $image = $propriete['image'];
        $prix = $propriete['prix'];
        $adresse = $propriete['adresse'];
        $nombrechambres = $propriete['nombrechambres'];
        $nombresalons = $propriete['nombresalons'];
        $nombreparkings = $propriete['nombreparkings'];
        $nombrecuisines = $propriete['nombrecuisines'];
        $statut = $propriete['statut'];
        $operation = $propriete['operation'];

        if (isset($_POST['valider'])) {
            $image_saisie = htmlspecialchars($_POST['image']);
            $prix_saisie = htmlspecialchars($_POST['prix']);
            $adresse_saisie = htmlspecialchars($_POST['adresse']);
            $nombre_chambres_saisie = htmlspecialchars($_POST['nombrechambres']);
            $nombre_salons_saisie = htmlspecialchars($_POST['nombresalons']);
            $nombre_parkings_saisie = htmlspecialchars($_POST['nombreparkings']);
            $nombre_cuisines_saisie = htmlspecialchars($_POST['nombrecuisines']);
            $statut_saisie =  htmlspecialchars($_POST['statut']);
            $operation_saisie =  htmlspecialchars($_POST['type']);

            $modification = $connection->prepare('UPDATE propriete SET image = ?, prix = ?, adresse = ?, nombrechambres = ?, nombresalons = ?, nombreparkings = ?, nombrecuisines = ?, statut = ?, operation = ? WHERE id = ?');
            $modification->bind_param('sssssssssi', $image_saisie, $prix_saisie, $adresse_saisie, $nombre_chambres_saisie, $nombre_salons_saisie, $nombre_parkings_saisie, $nombre_cuisines_saisie, $statut_saisie, $operation_saisie, $id);
            if ($modification->execute()) {
                header('location: voir.php');
            } else {
                echo "Erreur lors de la modification : " . $modification->error;
            }
        }
    } else {
        echo "Aucune propriété trouvée.";
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
            <input type="text" name="image" value="<?= $image; ?>" autocomplete="off" placeholder="URL de l'image" required>
            <input type="text" name="prix" value="<?= $prix; ?>" pattern="[0-9]+(\.[0-9]{1,2})?" title="Veuillez saisir un nombre décimal valide" required autocomplete="off" placeholder="Prix">
            <input type="text" name="adresse" value="<?= $adresse; ?>" autocomplete="off" placeholder="Adresse" required>
            <input type="text" name="nombrechambres" value="<?= $nombrechambres; ?>" autocomplete="off" placeholder="Nombre de chambres" required>
            <input type="text" name="nombresalons" value="<?= $nombresalons; ?>" autocomplete="off" placeholder="Nombre de salons" required>
            <input type="text" name="nombreparkings" value="<?= $nombreparkings; ?>" autocomplete="off" placeholder="Nombre de parkings" required>
            <input type="text" name="nombrecuisines" value="<?= $nombrecuisines; ?>" autocomplete="off" placeholder="Nombre de cuisines" required>
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
        <p align="center"><span style="color:red;">*</span>Veuillez ajouter la modification<span style="color:red;">*</span></p>
        <div align="center" class="envoi">
            <input type="submit" name="valider">
            <input type="reset" name="Annuler" value="Annuler">
        </div>
    </form>
</body>
</html>

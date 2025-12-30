<?php
require "database.php";
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $requete = $connection->prepare('SELECT * FROM Appartement WHERE id = ?');
    $requete->bind_param('i', $id);
    $requete->execute();

    $resultat = $requete->get_result();
    $nombre_lignes = $resultat->num_rows;

    if ($nombre_lignes > 0) {
        $suppression = $connection->prepare('DELETE FROM Appartement WHERE id = ?');
        $suppression->bind_param('i', $id);
        if ($suppression->execute()) {
            header('location: voir.php');
        } else {
            echo "Erreur lors de la suppression : " . $suppression->error;
        }
    } else {
        echo "Aucun bien immobilier trouvé.";
    }
} else {
    echo "Aucun identifiant spécifié.";
}
?>

<?php
require "database.php";
session_start();

if ($_SESSION['role'] != 'administrateur') {
    header("Location: login.php");
    exit();
}

if (!empty($_GET['id'])) {
    $id = intval($_GET['id']);

    $requete = $connection->prepare('DELETE FROM utilisateur WHERE utilisateurid = ?');
    if (!$requete) {
        die('Erreur de préparation de la requête : ' . $connection->error);
    }

    $requete->bind_param('i', $id);
    if ($requete->execute()) {
        header("Location: code.php");
    } else {
        echo "Erreur lors de la suppression de l'utilisateur : " . $requete->error;
    }
    $requete->close();
} else {
    echo "Aucun identifiant d'utilisateur spécifié.";
}

$connection->close();
?>

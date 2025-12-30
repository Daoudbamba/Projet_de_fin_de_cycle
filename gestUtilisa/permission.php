<?php
function verifier_permission($permission) {
    global $connection;

    $utilisateur_id = $_SESSION['utilisateurid'];
    $requete = $connection->prepare('SELECT permissions FROM utilisateur WHERE utilisateurid = ?');
    $requete->bind_param('i', $utilisateur_id);
    $requete->execute();
    $resultat = $requete->get_result();
    $utilisateur = $resultat->fetch_assoc();
    $requete->close();

    if ($utilisateur['permissions'] == 'accès_complet') {
        return true;
    }

    return $utilisateur['permissions'] == $permission;
}
?>
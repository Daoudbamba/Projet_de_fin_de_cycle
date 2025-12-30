<?php
session_start();

if (isset($_COOKIE['last_activity'])) {
    $inactive_time = 3600; // 1 heure

    // Vérifie si le temps écoulé depuis la dernière activité dépasse le temps inactif autorisé
    if (time() - $_COOKIE['last_activity'] > $inactive_time) {
        // Déconnexion de l'utilisateur
        session_unset();
        session_destroy();
        setcookie('last_activity', '', time() - 3600, "/"); // Supprime le cookie

        // Redirection vers la page de connexion ou autre logique
        header("Location: login.php");
        exit();
    } else {
        // Met à jour le cookie avec l'heure actuelle
        setcookie('last_activity', time(), time() + $inactive_time, "/");
    }
} else {
    // Si le cookie n'existe pas, redirige vers la page de connexion ou autre logique
    header("Location: login.php");
    exit();
}

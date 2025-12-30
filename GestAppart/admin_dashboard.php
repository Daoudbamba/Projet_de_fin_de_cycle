<?php
include 'session.php';

// Vérification si l'utilisateur est connecté et s'il est administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'administrateur') {
    header("Location: index.php");
    exit;
}

// Obtenir les permissions de l'utilisateur connecté
$user_id = $_SESSION['user_id'];
require 'database.php';

$requete = $connection->prepare('SELECT permissions FROM utilisateur WHERE utilisateurid = ?');
$requete->bind_param('i', $user_id);
$requete->execute();
$requete->bind_result($permissions);
$requete->fetch();
$requete->close();

$permissionsArray = explode(',', $permissions);
$connection->close();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>NOTRE AGENCE-IMMO</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/style.css"/>
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.js"></script>
    <script src="assets/script.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- Owl stylesheet -->
    <link rel="stylesheet" href="assets/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="assets/owl-carousel/owl.theme.css">
    <script src="assets/owl-carousel/owl.carousel.js"></script>
    <!-- Owl stylesheet -->

    <!-- slitslider -->
    <link rel="stylesheet" type="text/css" href="assets/slitslider/css/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/slitslider/css/custom.css" />
    <script type="text/javascript" src="assets/slitslider/js/modernizr.custom.79639.js"></script>
    <script type="text/javascript" src="assets/slitslider/js/jquery.ba-cond.min.js"></script>
    <script type="text/javascript" src="assets/slitslider/js/jquery.slitslider.js"></script>
    <!-- slitslider -->

</head>
<body>
<div class="navbar-wrapper">
    <div class="navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Nav Starts -->
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="index.php">Accueil</a></li>
                    <li><a href="about.php">Apropos</a></li>
                    <li><a href="agents.php">Agents</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            <!-- #Nav Ends -->
        </div>
    </div>
</div>

<div class="container">
    <div class="header">
        <a href="index.php"><img src="images/lo.jpg" alt="Realestate"></a>
        <ul class="pull-right">
           
        </ul>
    </div>
</div>
<div class="inside-banner">
    <div class="container"> 
        <span class="pull-right"><a href="index.php">Accueil</a> / Espace Admin</span>
        <h2>Bienvenue sur le tableau de bord administrateur</h2>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12" style="color: black;">
            <?php if (in_array('gestion_propriete', $permissionsArray) || in_array('accès_complet', $permissionsArray)): ?>
                <p><span>Vous pouvez gérer les propriétés ici.</span> <a class="btn btn-secondary" href="../propriete/code.php"><span class="bi-eye"></span> Voir Propriétés</a></p>
            <?php endif; ?>

            <?php if (in_array('gestion_background', $permissionsArray) || in_array('accès_complet', $permissionsArray)): ?>
                <p><span>Vous pouvez gérer le background ici.</span><a class="btn btn-secondary" href="../gestbg/code.php"><span class="bi-eye"></span> Voir Background</a></p>
            <?php endif; ?>

            <?php if (in_array('gestion_agents', $permissionsArray) || in_array('accès_complet', $permissionsArray)): ?>
                <p><span>Vous pouvez gérer les Agents ici.</span><a class="btn btn-secondary" href="../gestAgents/code.php"><span class="bi-eye"></span> Voir les Agents</a></p>
            <?php endif; ?>

            <?php if (in_array('gestion_utilisateurs', $permissionsArray) || in_array('accès_complet', $permissionsArray)): ?>
                <p><span>Vous pouvez gérer les Utilisateurs ici.</span><a class="btn btn-secondary" href="../gestUtilisa/code.php"><span class="bi-eye"></span> Voir les Utilisateurs</a></p>
            <?php endif; ?>

        </div>
    </div>
</div>

<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-3">
                <h4>Information</h4>
                <ul class="row">
                    <li class="col-lg-12 col-sm-12 col-xs-3"><a href="about.php">Apropos</a></li>
                    <li class="col-lg-12 col-sm-12 col-xs-3"><a href="agents.php">Agents</a></li>
                    <li class="col-lg-12 col-sm-12 col-xs-3"><a href="contact.php">Contact</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-sm-3">
                <h4>Bulletin</h4>
                <p>Soyez informé des dernières propriétés sur notre marché.</p>
                <form class="form-inline" role="form">
                    <input type="text" placeholder="Entrez votre adresse email" class="form-control">
                    <button class="btn btn-success" type="button">Informez-Moi!</button>
                </form>
            </div>

            <div class="col-lg-3 col-sm-3">
                <h4>Contactez Nous</h4>
                <p>
                    <b>Adresse</b><br>
                    <span class="glyphicon glyphicon-map-marker"></span> Rue Lalla Amira Aicha, Kenitra Maroc.<br>
                    <span class="glyphicon glyphicon-envelope"></span> Bambaame@mail.com<br>
                    <span class="glyphicon glyphicon-envelope"></span> tifchehaidara@gmail.com<br>
                    <span class="glyphicon glyphicon-earphone"></span> +212 6239461
                </p>
            </div>
        </div>
        <p class="copyright">Copyright 2024. All rights reserved.</p>
    </div>
</div>

</body>
</html>

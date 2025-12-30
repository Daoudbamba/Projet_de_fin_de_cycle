<?php
include 'session.php';

// Vérification de la session utilisateur
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Connexion à la base de données
require "database.php";

// Récupérer toutes les propriétés à vendre
$query = "SELECT * FROM propriete WHERE operation = 'acheter'";
$result = $connection->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>NOTRE AGENCE-IMMO </title>
<meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css" />
  <link rel="stylesheet" href="assets/style.css"/>
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.js"></script>
  <script src="assets/script.js"></script>



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
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="index.php">Accueil</a></li>
                        <li><a href="about.php">Apropos</a></li>
                        <li><a href="agents.php">Agents</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
       
    </div>
    <div class="inside-banner">
        <div class="container"> 
            <span class="pull-right"><a href="index.php">Accueil</a> / Acheter</span>
            <h2>Propriétés à Acheter</h2>
        </div>
    </div>
    <div class="container">
        <div class="properties-listing spacer">
            <div class="row">
                <?php
                if ($result->num_rows > 0) {
                    while($property = $result->fetch_assoc()) {
                        echo '
                        <div class="col-lg-4 col-sm-6">
                            <div class="property">
                                <div class="image-holder">
                                    <img src="imagess/' . htmlspecialchars($property["image"]) . '" class="img-responsive" alt="properties" />
                                </div>
                                <h4>' . htmlspecialchars($property["nombrechambres"]) . ' Chambres, ' . htmlspecialchars($property["nombresalons"]) . ' Salons</h4>
                                <p class="price">Prix: ' . htmlspecialchars($property["prix"]) . ' $</p>
                                <a class="btn btn-primary" href="property-detail.php?id=' . htmlspecialchars($property["id"]) . '">Détails</a>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<p>Aucune propriété disponible pour l\'achat.</p>';
                }
                $connection->close();
                ?>
            </div>
        </div>
    </div>

<!-- -------------#footer--------------------------------------------------------------------- -->


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
                                <button class="btn btn-success" type="button">Informez-Moi!</button></form>
            </div>
            
           <!--  <div class="col-lg-3 col-sm-3">
                    <h4>Follow us</h4>
                    <a href="#"><img src="images/facebook.png" alt="facebook"></a>
                    <a href="#"><img src="images/twitter.png" alt="twitter"></a>
                    <a href="#"><img src="images/linkedin.png" alt="linkedin"></a>
                    <a href="#"><img src="images/instagram.png" alt="instagram"></a>
            </div>
 -->
             <div class="col-lg-3 col-sm-3">
                <h4>Contactez Nous</h4>
                <p><b>Adresse</b><br>
                    <span class="glyphicon glyphicon-map-marker"></span>  Rue Lalla Amira Aicha, Kenitra Maroc.<br>
                    <span class="glyphicon glyphicon-envelope"></span>  Bambaame@mail.com <br>
                    <span class="glyphicon glyphicon-envelope"></span>  tifchehaidara@gmail.com<br>
                    <span class="glyphicon glyphicon-earphone"></span> +212 6239461
                </p>
            </div>
        </div>
    <p class="copyright">Copyright 2024. All rights reserved. </p>
  </div>
</div>
    
</body>
</html>

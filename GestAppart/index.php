<?php
session_start();
// Vérifier si l'utilisateur est connecté et récupérer le rôle
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;



//  fichier de connexion à la base de données
require "database.php";


// Requête pour récupérer les données des appartements
$sql = "SELECT nombrechambres, prix, adresse, images FROM appartement";
$result = $connection->query($sql);


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


<!-- Header Starts -->
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
             <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'administrateur'): ?>
                        <li><a href="admin_dashboard.php">Espace Admin</a></li>
                    <?php endif; ?>
        </ul>
    </div>
    <!-- #Nav Ends -->

          </div>
        </div>

    </div>
<!-- #Header Starts -->

<div class="container">

<!-- Header Starts -->
<div class="header">
<a href="index.php"><img src="images/lo.jpg" alt="Realestate"></a>

              <ul class="pull-right">
                <li><a href="buysalerent.php">Acheter</a></li>
                <!-- <li><a href="buysalerent.php">sale</a></li>          -->
                <li><a href="louer.php">Louer</a></li>
              </ul>
</div>
<!-- #Header Starts -->
</div>

<!-- --------------------------------Background------------------------------------------ -->

<div class="">
    <div id="slider" class="sl-slider-wrapper">
        <div class="sl-slider">

<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '
        <div class="sl-slide" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
            <div class="sl-slide-inner">
                <div class="bg-img" style="background-image: url(\'imagess/' . $row["images"] . '\');"></div>

                <h2><a href="#">Appartement de ' . $row["nombrechambres"] . ' </a></h2>
                <blockquote>
                    <p class="location"><span class="glyphicon glyphicon-map-marker"></span> ' . $row["adresse"] . '</p>
                    <p>Jusqu\'à ce qu\'il étende le cercle de sa compassion à tous les êtres vivants, l\'homme ne trouvera pas lui-même la paix.</p>
                    <cite>' . $row["prix"] . ' $</cite>
                </blockquote>
            </div>
        </div>';
    }
} else {
    echo "0 résultats";
}
$connection->close();
?>

        </div>
    </div>
</div>

<style>
.bg-img {
    background-size: cover;
    background-position: center;
    height: 500px; /* Ajustez selon vos besoins */
    width: 100%; /* Ajustez selon vos besoins */
}
</style>

        </div><!-- /sl-slider -->
        <nav id="nav-dots" class="nav-dots">
            <span class="nav-dot-current"></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </nav>
    </div><!-- /slider-wrapper -->
</div>



</div>



<!---------------------- formulaire de Recherche ---------------------->

<div class="banner-search">
    <div class="container">
        <!-- banner -->
        <h3>Acheter & Louer</h3>
        <div class="searchbar">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <form action="recherche_propriete.php" method="POST">
                        <input type="text" class="form-control" placeholder="Recherche de Propriétés : Adresse" name="adresse">
                        <div class="row mt-2">
                            <div class="col-lg-3 col-sm-3">
                                <select class="form-control" name="operation">
                                    <option value="Acheter">Acheter</option>
                                    <option value="Louer">Louer</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-4">
                                <input type="text" class="form-control" placeholder="Prix" name="prix">
                            </div>
                            <div class="col-lg-3 col-sm-4">
                                <select class="form-control" name="statut">
                                    <option value="Appartement">Appartement</option>
                                    <option value="Bâtiment">Bâtiment</option>
                                    <option value="Bureau">Bureau</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-sm-4">
                                <button type="submit" class="btn btn-success">Trouver</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5 col-lg-offset-1 col-sm-6">
    <?php if(isset($_SESSION['user_id'])): ?>
        <button class="btn btn-info" data-toggle="modal" data-target="#loginpop" onclick="window.location.href='logout.php'">Déconnexion</button>
    <?php else: ?>
        <p>Rejoignez-nous maintenant et restez informé de toutes les offres de propriétés.</p>
        <button class="btn btn-info" data-toggle="modal" data-target="#loginpop" onclick="window.location.href='login.php'">Connexion</button>
    <?php endif; ?>
</div>

            </div>
        </div>
    </div>
</div>
<?php
    if (isset($_SESSION['error_message'])) {
        echo "<p class='alert alert-warning'>" . $_SESSION['error_message'] . "</p>";
        unset($_SESSION['error_message']);
    }
    ?>
<!-- banner -->


<!-- -----------------------les details-------------------------------------- -->
<!-- banner -->
<div class="inside-banner">
  <div class="container"> 
    
  </div>
</div>
<!-- banner -->

<div class="container">
  <div class="properties-listing spacer">
    <a href="buysalerent.php" class="pull-right viewall">Voir toutes les annonces</a>
    <h2>Propriétés en vedette</h2>
    <div id="owl-example" class="owl-carousel">

    <?php
    require "database.php";
    $sql = "SELECT id, image, prix, adresse, nombrechambres, nombresalons, nombreparkings, nombrecuisines, operation FROM propriete";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '
            <div class="properties">
                <div class="image-holder"><img src="imagess/' . $row["image"] . '" class="img-responsive" alt="propriétés"/>
                    <div class="status new">' . $row["operation"] . '</div>
                </div>
                <h4><a href="property-detail.php">' . $row["adresse"] . '</a></h4>
                <p class="price">Prix : ' . $row["prix"] . ' $</p>
                <div class="listing-detail">
                    <span data-toggle="tooltip" data-placement="bottom" data-original-title="Chambre">' . $row["nombrechambres"] . '</span>
                    <span data-toggle="tooltip" data-placement="bottom" data-original-title="Salon">' . $row["nombresalons"] . '</span>
                    <span data-toggle="tooltip" data-placement="bottom" data-original-title="Parking">' . $row["nombreparkings"] . '</span>
                    <span data-toggle="tooltip" data-placement="bottom" data-original-title="Cuisine">' . $row["nombrecuisines"] . '</span>
                </div>
                <a class="btn btn-primary" href="property-detail.php?id=' . $row['id'] . '">Voir les détails</a>
            </div>';
        }
    } else {
        echo "0 résultats";
    }
    $connection->close();
    ?>
      
    </div>
  </div>
</div>
  </div>
  <div class="spacer">
    <div class="row">
      <div class="col-lg-6 col-sm-9 recent-view">
        <h3>À propos de nous</h3>
        <p>Chez Agence-Immo, nous sommes passionnés par la création de lieux de vie exceptionnels. Depuis plus 2024, nous avons su combiner expertise, innovation et engagement pour offrir à nos clients des propriétés qui répondent à leurs besoins et surpassent leurs attentes.

Notre équipe de professionnels dévoués s'engage à chaque étape du processus, de la conception à la réalisation, en passant par la gestion et le service après-vente. Nous mettons un point d'honneur à utiliser des matériaux de qualité et à intégrer les dernières technologies pour garantir durabilité et confort.

Découvrez notre approche unique de l'immobilier, où chaque projet est conçu pour améliorer la qualité de vie et créer des communautés harmonieuses. Rejoignez-nous et trouvons ensemble le lieu qui deviendra votre chez-vous idéal.<br><a href="about.php">En savoir plus</a></p>
      </div>
      <div class="col-lg-5 col-lg-offset-1 col-sm-3 recommended">
        <h3>Propriétés recommandées</h3>
        <div id="myCarousel" class="carousel slide">
          <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1" class=""></li>
            <li data-target="#myCarousel" data-slide-to="2" class=""></li>
            <li data-target="#myCarousel" data-slide-to="3" class=""></li>
          </ol>
          <!-- Carousel items -->
          <div class="carousel-inner">
            <div class="item active">
              <div class="row">
                <div class="col-lg-4"><img src="images/properties/1.jpg" class="img-responsive" alt="propriétés"/></div>
                <div class="col-lg-8">
                  <h5><a href="property-detail.php">magasin</a></h5>
                  <p class="price">300,000 $</p>
                  <!-- <a href="property-detail.php" class="more">Plus de détails</a>  -->
                </div>
              </div>
            </div>
            <div class="item">
              <div class="row">
                <div class="col-lg-4"><img src="images/properties/2.jpg" class="img-responsive" alt="propriétés"/></div>
                <div class="col-lg-8">
                  <h5><a href="property-detail.php">Villa</a></h5>
                  <p class="price">300,000 $</p>
                  <!-- <a href="property-detail.php" class="more">Plus de détails</a>  -->
                </div>
              </div>
            </div>
            <div class="item">
              <div class="row">
                <div class="col-lg-4"><img src="images/properties/3.jpg" class="img-responsive" alt="propriétés"/></div>
                <div class="col-lg-8">
                  <h5><a href="property-detail.php">Bureau</a></h5>
                  <p class="price">300,000 $</p>
                  <!-- <a href="property-detail.php" class="more">Plus de détails</a>  -->
                </div>
              </div>
            </div>
            <div class="item">
              <div class="row">
                <div class="col-lg-4"><img src="images/properties/4.jpg" class="img-responsive" alt="propriétés"/></div>
                <div class="col-lg-8">
                  <h5><a href="property-detail.php">Appartement</a></h5>
                  <p class="price">300,000 $</p>
                  <!-- <a href="property-detail.php" class="more">Plus de détails</a>  -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
                  <?php
if (isset($_POST['submit'])) {
    $errors = [];

    // Vérifier si le champ email est rempli
    if (empty($_POST['email'])) {
        $errors[] = 'Veuillez saisir votre adresse email.';
    } else {
        // Validation de l'email
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $errors[] = 'Veuillez saisir une adresse email valide.';
        }
    }

    if (empty($errors)) {
        $email = $_POST['email'];

        $destinataire = 'bambaame@gmail.com';  // Remplacez par votre adresse email
        $sujet = 'Inscription à la Newsletter';
        $contenu = "<html><body><p>Merci pour votre inscription à notre newsletter. Vous serez informé des dernières propriétés sur notre marché.</p></body></html>";
        $headers = "From: noreply@votresite.com \r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";

        if (mail($destinataire, $sujet, $contenu, $headers)) {
            $successMessage = "Votre inscription a été confirmée. Merci!";
        } else {
            $errorMessage = "Une erreur s'est produite lors de l'envoi de votre inscription. Veuillez réessayer plus tard.";
        }
    }
}
?>

                    <form class="form-inline" role="form" method="POST">
                            <input type="text" placeholder="Entrez votre adresse email" class="form-control">
                                <button class="btn btn-success" name="submit" type="Submit">Informez-Moi!</button></form>
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
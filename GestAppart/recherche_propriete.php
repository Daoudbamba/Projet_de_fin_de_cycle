<?php
session_start();

// // Vérification de la session utilisateur
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit;
// }

// Connexion à la base de données
require "database.php";

// // Récupérer les informations de l'utilisateur connecté
// $user_id = $_SESSION['user_id'];
// $query = "SELECT role_id FROM utilisateur WHERE utilisateurid = ?";
// $stmt = $connection->prepare($query);

// Vérifier si la préparation de la requête a réussi
// if ($stmt === false) {
//     die('Erreur de préparation de la requête : ' . $connection->error);
// }

// $stmt->bind_param("i", $user_id);
// $stmt->execute();
// $result = $stmt->get_result();
// $user = $result->fetch_assoc();

// // Fermer la connexion
// $stmt->close();
// $connection->close();

// Reconnect to the database for search
require "database.php";

// Get search parameters
$operation = isset($_POST['operation']) ? $_POST['operation'] : '';
$statut = isset($_POST['statut']) ? $_POST['statut'] : '';

// Build the query with search parameters
$sql = "SELECT id, image, prix, adresse, nombrechambres, nombresalons, nombreparkings, nombrecuisines, operation FROM propriete WHERE 1=1";

if (!empty($operation)) {
    $sql .= " AND operation = '" . $connection->real_escape_string($operation) . "'";
}
if (!empty($statut)) {
    $sql .= " AND statut = '" . $connection->real_escape_string($statut) . "'";
}

$result = $connection->query($sql);
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

    <style>
        .properties {
            /* Styles for each property */
        }
        .owl-carousel .owl-item img {
            max-width: 100%;
            height: auto;
        }
    </style>
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
       
    </div>
    <!-- #Header Starts -->
</div>

<!-- -----------------------les details-------------------------------------- -->
<!-- banner -->
<div class="inside-banner">
    <div class="container"> 
        <span class="pull-right"><a href="index.php">Accueil</a> / Résultats de Recherche</span>
        <h2>Résultats de Recherche</h2>
    </div>
</div>
<!-- banner -->

<div class="container">
    <div class="properties-listing spacer">
        <!-- <a href="buysalerent.php" class="pull-right viewall">Voir toutes les annonces</a> -->
        <h2>Propriétés Trouvées</h2>
        <div id="owl-example" class="owl-carousel">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '
                    <div class="properties">
                        <div class="image-holder"><img src="imagess/' . $row["image"] . '" class="img-responsive" alt="propriétés"/>
                            <div class="status">' . $row["operation"] . '</div>
                        </div>
                        <h4><a href="property-detail.php?id=' . $row['id'] . '">' . $row["adresse"] . '</a></h4>
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
                echo "<p>Aucun résultat trouvé pour votre recherche.</p>";
            }
            $connection->close();
            ?>
        </div>
    </div>
</div>

<!-- Footer -->
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
                <p><b>Adresse</b><br>
                    <span class="glyphicon glyphicon-map-marker"></span> Rue Lalla Amira Aicha, Kenitra Maroc.<br>
                    <span class="glyphicon glyphicon-envelope"></span> Bambaame@mail.com <br>
                    <span class="glyphicon glyphicon-envelope"></span> tifchehaidara@gmail.com<br>
                    <span class="glyphicon glyphicon-earphone"></span> +212 6239461
                </p>
            </div>
        </div>
        <p class="copyright">Copyright 2024. All rights reserved.</p>
    </div>
</div>



<!-- Initialize Owl Carousel -->
<script>
    $(document).ready(function() {
        $("#owl-example").owlCarousel({
            items: <?php echo ($result->num_rows < 5) ? $result->num_rows : 5; ?>, // Show 5 items or less
            itemsDesktop: [1000, 3],
            itemsDesktopSmall: [900, 3],
            itemsTablet: [600, 2],
            itemsMobile: [479, 1],
            navigation: true,
            navigationText: ["<", ">"]
        });
    });
</script>

</body>
</html>

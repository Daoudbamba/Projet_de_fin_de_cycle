<!DOCTYPE html>
<html lang="en">
<head>
    <title>NOTRE AGENCE-IMMO</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css"/>
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
    <link rel="stylesheet" type="text/css" href="assets/slitslider/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="assets/slitslider/css/custom.css"/>
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
              <li><a href="louer.php">Louer</a></li>
        </ul>
    </div>
    <!-- #Header Starts -->
</div>

<!-- banner -->
<div class="inside-banner">
    <div class="container">
        <span class="pull-right"><a href="index.php">Accueil</a> / Agents</span>
        <h2>Agents</h2>
    </div>
</div>
<!-- banner -->

<div class="container">
    <div class="spacer agents">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-sm-12">
                <?php
                require "database.php";
                
                // Récupérer les agents de la base de données
                $sql = "SELECT nom, prenom, description, email, numero, image FROM agent";
                $result = $connection->query($sql);

                if ($result->num_rows > 0) {
                    // Afficher chaque agent
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="row">';
                        echo '<div class="col-lg-2 col-sm-2"><a href="#"><img src="imagess/' . $row['image'] . '" class="img-responsive" alt="agent name"></a></div>';
                        echo '<div class="col-lg-7 col-sm-7"><h4>' . $row['nom'] . ' ' . $row['prenom'] . '</h4><p>' . $row['description'] . '</p></div>';
                        echo '<div class="col-lg-3 col-sm-3"><span class="glyphicon glyphicon-envelope"></span> <a href="mailto:' . $row['email'] . '">' . $row['email'] . '</a><br>';
                        echo '<span class="glyphicon glyphicon-earphone"></span> ' . $row['numero'] . '</div>';
                        echo '</div>';
                        echo '<hr>'; // Ligne de séparation entre les agents
                    }
                } else {
                    echo '<p>Aucun agent trouvé.</p>';
                }

                $connection->close();
                ?>
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

<!-- Modal -->
<div id="loginpop" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">
                <div class="col-sm-6 login"></div>
                <div class="col-sm-6">
                    <h4>New User Sign Up</h4>
                    <p>Join today and get updated with all the properties deal happening around.</p>
                    <button type="submit" class="btn btn-info" onclick="window.location.href='register.php'">Incrivez-vous</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->

</body>
</html>

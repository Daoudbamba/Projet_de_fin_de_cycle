<?php

include 'session.php';

// Vérification de la session utilisateur
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Connexion à la base de données
require "database.php";

// Récupérer les informations de l'utilisateur connecté
$user_id = $_SESSION['user_id'];
$query = "SELECT role_id FROM utilisateur WHERE utilisateurid = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fermer la connexion
$stmt->close();
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- contenu du head -->
</head>
<body>
    <!-- contenu de la page -->
</body>
</html>


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
    <link rel="stylesheet" href="assets/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="assets/owl-carousel/owl.theme.css">
    <script src="assets/owl-carousel/owl.carousel.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/slitslider/css/style.css" />
    <link rel="stylesheet" type="text/css" href="assets/slitslider/css/custom.css" />
    <script type="text/javascript" src="assets/slitslider/js/modernizr.custom.79639.js"></script>
    <script type="text/javascript" src="assets/slitslider/js/jquery.ba-cond.min.js"></script>
    <script type="text/javascript" src="assets/slitslider/js/jquery.slitslider.js"></script>
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
        <div class="header">
            <a href="index.php"><img src="images/lo.jpg" alt="Realestate"></a>
            
        </div>
    </div>
    <div class="inside-banner">
        <div class="container"> 
            <span class="pull-right"><a href="index.php">Accueil</a> / Détails de la propriété</span>
            <h2>Détails de la propriété</h2>
        </div>
    </div>
    <div class="container">
        <div class="properties-listing spacer">
            <div class="row">
                <div class="col-lg-3 col-sm-4 hidden-xs">
                    <div class="hot-properties hidden-xs">
                        <h4>NOTRE AGENCE</h4>
                        <div class="row">
                            <div class="col-lg-4 col-sm-5"><img src="images/properties/4.jpg" class="img-responsive img-circle" alt="properties"/></div>
                            
                        </div>
                    </div>
                    <div class="advertisement">
                        <h4>LE PLAN</h4>
                        <img src="images/advertisements.jpg" class="img-responsive" alt="advertisement">
                    </div>
                </div>
                <div class="col-lg-9 col-sm-8 ">
                    <?php
                     // Inclusion du fichier de connexion à la base de données
                    require "database.php";

            // Fonction pour afficher les messages de succès ou d'erreur
             function displayMessage($message, $type = 'success') {
                return '<p class="alert alert-' . $type . '">' . $message . '</p>';
            }

            // Variable pour stocker le message de retour
            $responseMessage = '';

            // Traitement de l'envoi du formulaire
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $errors = []; // Tableau pour stocker les erreurs de validation

                // Validation des champs
                $name = trim($_POST['name']);
                $email = trim($_POST['email']);
                $contact = trim($_POST['contact']);
                $message = trim($_POST['message']);

                if (empty($name)) {
                    $errors[] = 'Le nom est requis.';
                }
                if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'L\'adresse email n\'est pas valide.';
                }
                if (empty($contact)) {
                    $errors[] = 'Le numéro de contact est requis.';
                }
                if (empty($message)) {
                    $errors[] = 'Le message ne peut pas être vide.';
                }

                // Vérification des erreurs
                if (empty($errors)) {
                    // Récupération des données de la propriété
                    if (isset($_POST['property_id'], $_POST['property_address'])) {
                        $property_id = $_POST['property_id'];
                        $property_address = $_POST['property_address'];

                        // Construction du contenu de l'email
                        $subject = 'Demande depuis la page de propriété';
                        $to = 'bambaame@gmail.com'; // Adresse email destinataire
                        $message_content = "
                            <html>
                            <body>
                                <p><strong>Propriété ID:</strong> {$property_id}</p>
                                <p><strong>Adresse de la propriété:</strong> {$property_address}</p>
                                <p><strong>Nom:</strong> {$name}</p>
                                <p><strong>Email:</strong> {$email}</p>
                                <p><strong>Contact:</strong> {$contact}</p>
                                <p><strong>Message:</strong><br>{$message}</p>
                            </body>
                            </html>
                        ";

                        // En-têtes de l'email
                        $headers = "From: {$email}\r\n";
                        $headers .= "Reply-To: {$email}\r\n";
                        $headers .= "Content-type: text/html; charset=UTF-8\r\n";

                        // Envoi de l'email
                        if (mail($to, $subject, $message_content, $headers)) {
                            $responseMessage = displayMessage('Votre message a été envoyé avec succès.', 'success');
                        } else {
                            $responseMessage = displayMessage('Erreur lors de l\'envoi du message. Veuillez réessayer plus tard.', 'danger');
                        }
                    } else {
                        $responseMessage = displayMessage('Informations sur la propriété non disponibles.', 'danger');
                    }
                } else {
                    foreach ($errors as $error) {
                        $responseMessage .= displayMessage($error, 'danger');
                    }
                }
            }

            // Récupération des détails de la propriété si l'ID est fourni
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];

                        $sql = "SELECT * FROM propriete WHERE id = ?";
                        $stmt = $connection->prepare($sql);
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $property = $result->fetch_assoc();

                        if ($property) {

                            echo '
                            <h2> <p>' . htmlspecialchars($property["nombrechambres"]) .   ' Chambres '   . htmlspecialchars($property["nombresalons"]) .   ' Salon '  
                            . htmlspecialchars($property["nombrecuisines"]) .   ' Cuisines '  . htmlspecialchars($property["nombreparkings"]) . ' Parkings</p></h2>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="property-images">
                                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                           
                                            <div class="carousel-inner">
                                                <div class="item active">
                                                    <img src="imagess/' . htmlspecialchars($property["image"]) . '" class="properties" alt="properties" />
                                                </div>
                                            </div>
                                            <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
                                            <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <h4><span class="glyphicon glyphicon-map-marker"></span> Localisation</h4>
                                        <div class="well">
                                            <iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d514484.4730487318!2d-6.621632123752951!3d34.27007420403571!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xdad843a9be0d20d%3A0x40e9e4f78ee0e00!2sKenitra%2C%20Morocco!5e0!3m2!1sen!2sus!4v1621518378841!5m2!1sen!2sus"></iframe>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="col-lg-12 col-sm-6">
                                        <div class="property-info">
                                            <p class="price">' . htmlspecialchars($property["prix"]) . ' $</p>
                                            <p class="area"><span class="glyphicon glyphicon-map-marker"></span> ' . htmlspecialchars($property["adresse"]) . '</p>
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-6">
                                        <div class="enquiry">
                                            <h6><span class="glyphicon glyphicon-envelope"></span> Envoyer une demande</h6>
                                            ' . $responseMessage . '
                                             <form action="" method="post" role="form">
                                        <input type="hidden" name="property_id" value="' . htmlspecialchars($property["id"]) . '">
                                        <input type="hidden" name="property_address" value="' . htmlspecialchars($property["adresse"]) . '">
                                        <input type="text" class="form-control" name="name" placeholder="Nom complet" required>
                                        <input type="email" class="form-control" name="email" placeholder="you@yourdomain.com" required>
                                        <input type="text" class="form-control" name="contact" placeholder="Votre numéro" required>
                                        <textarea rows="6" class="form-control" name="message" placeholder="Qu\'est-ce qui vous préoccupe?" required></textarea>
                                        <button type="submit" class="btn btn-primary" name="submit">Envoyer le message</button>
                                    </form>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        } else {
                            echo '<p>Propriété non trouvée.</p>';
                        }
                    } else {
                        echo 'Propriété non trouvée. Veuillez fournir un ID de propriété valide.';
                    }
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
   
    </div>
</body>
</html>

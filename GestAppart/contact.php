<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if(isset($_POST['submit'])){
    $errors = [];

    if(empty($_POST['name'])) $errors[] = 'Veuillez saisir votre nom.';
    if(empty($_POST['email'])) $errors[] = 'Veuillez saisir votre adresse email.';
    if(empty($_POST['contact'])) $errors[] = 'Veuillez saisir le sujet.';
    if(empty($_POST['message'])) $errors[] = 'Veuillez saisir votre message.';

    if(empty($errors)) {
        $nom = $_POST['name'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'bambaame@gmail.com';
            $mail->Password   = 'monz zywk ysbk vxze ';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom($email, $nom);
            $mail->addAddress('bambaame@gmail.com');

            $mail->isHTML(true);
            $mail->Subject = 'Envoi depuis page Contact';
            $mail->Body    = "
                <html><body>
                <p><strong>Nom:</strong> $nom</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Sujet:</strong> $contact</p>
                <p><strong>Message:</strong> $message</p>
                </body></html>
            ";

            $mail->send();
            $successMessage = "Votre message a été envoyé avec succès.";
        } catch (Exception $e) {
            $errorMessage = "Erreur lors de l'envoi : " . $mail->ErrorInfo;
        }
    }
}
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

    <script>
        // Validation côté client
        function validateForm() {
            var name = document.forms["contactForm"]["name"].value;
            var email = document.forms["contactForm"]["email"].value;
            var contact = document.forms["contactForm"]["contact"].value;
            var message = document.forms["contactForm"]["message"].value;

            if (name == "" || email == "" || contact == "" || message == "") {
                alert("Tous les champs doivent être remplis.");
                return false;
            }
            return true;
        }
    </script>
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
      <div class="navbar-collapse  collapse">
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
      <!-- <li><a href="buysalerent.php">sale</a></li>          -->
        <li><a href="louer.php">Louer</a></li>
    </ul>
  </div>
  <!-- #Header Starts -->
</div>

<!-- banner -->
<div class="inside-banner">
  <div class="container">
    <span class="pull-right"><a href="index.php">Accueil</a> / Contactez Nous</span>
    <h2>Contactez Nous</h2>
  </div>
</div>
<!-- banner -->

<div class="container">
  <div class="spacer">
    <div class="row contact">
      <div class="col-lg-6 col-sm-6 ">
        <!-- Afficher les messages -->
        <?php
        if (!empty($errors)) {
            echo "<div class='alert alert-danger'>";
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            echo "</div>";
        }

        if (isset($successMessage)) {
            echo "<div class='alert alert-success'>$successMessage</div>";
        }

        if (isset($errorMessage)) {
            echo "<div class='alert alert-danger'>$errorMessage</div>";
        }
        ?>
        <form name="contactForm" action="" method="post" onsubmit="return validateForm()">
          <input type="hidden" name="submitted" value="1">
          <input type="text" name="name" class="form-control" placeholder="Votre Nom & Prénom" required>
          <input type="email" name="email" class="form-control" placeholder="Votre Email" required>
          <input type="text" name="contact" class="form-control" placeholder="Téléphone" required>
          <textarea rows="6" name="message" class="form-control" placeholder="Message" required></textarea>
          <button type="submit" class="btn btn-success" name="submit">Send Message</button>
        </form>
      </div>
      <div class="col-lg-6 col-sm-6">
        <div class="well"><iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d514484.4730487318!2d-6.621632123752951!3d34.27007420403571!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xdad843a9be0d20d%3A0x40e9e4f78ee0e00!2sKenitra%2C%20Morocco!5e0!3m2!1sen!2sus!4v1621518378841!5m2!1sen!2sus"></iframe></div>
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

</body>
</html>

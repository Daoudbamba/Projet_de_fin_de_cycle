<?php
session_start();
require "database.php";
require 'autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['form_email']) && !empty($_POST['form_password'])) {
        $email = $_POST['form_email'];
        $password = $_POST['form_password'];

        $recaptcha = $_POST['g-recaptcha-response'];

        // Vérification reCAPTCHA
        $secretKey = '6LdfEAwqAAAAAPMVljiT72k0mzwQdU-VzJu_IFzx';
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$recaptcha");
        $responseKeys = json_decode($response, true);

        if (intval($responseKeys["success"]) !== 1) {
            echo "<div class='alert alert-danger'>Validation reCAPTCHA échoue. réessayer.</div>";
        } else {
            // Continue with login process if reCAPTCHA is successful
            $query = "SELECT u.utilisateurid, u.email, u.password, r.nom as role
                      FROM utilisateur u
                      JOIN roles r ON u.role_id = r.id
                      WHERE u.email = ?";

            // preparation de la requete
            $stmt = $connection->prepare($query);

            if ($stmt === false) {
                die("Erreur de préparation de la requête : " . $connection->error);
            }

            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['utilisateurid'];
                    $_SESSION['role'] = $user['role'];

                    // Ajouter un cookie pour suivre la dernière activité
                    setcookie("last_activity", time(), time() + 3600, "/"); //3600

                    if ($user['role'] == 2) {
                        header("Location: admin_dashboard.php");
                    } else {
                        header("Location: index.php");
                    }
                    exit;
                } else {
                    echo "<div class='alert alert-danger'>Mot de passe incorrect.</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Utilisateur non trouvé.</div>";
            }

            $stmt->close();
        }
    } else {
        echo "<div class='alert alert-danger'>Veuillez remplir tous les champs.</div>";
    }
}
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
<link rel="stylesheet" href="assets/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="assets/owl-carousel/owl.theme.css">
<script src="assets/owl-carousel/owl.carousel.js"></script>
<link rel="stylesheet" type="text/css" href="assets/slitslider/css/style.css" />
<link rel="stylesheet" type="text/css" href="assets/slitslider/css/custom.css" />
<script type="text/javascript" src="assets/slitslider/js/modernizr.custom.79639.js"></script>
<script type="text/javascript" src="assets/slitslider/js/jquery.ba-cond.min.js"></script>
<script type="text/javascript" src="assets/slitslider/js/jquery.slitslider.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
            <li><a href="buysalerent.php">Louer</a></li>
        </ul>
    </div>
    <!-- #Header Starts -->
</div>
<div class="inside-banner">
    <div class="container"> 
        <span class="pull-right"><a href="index.php">Accueil</a> / <a href="register.php">Register</a></span>
        <h2>Login</h2>
    </div>
</div>
<hr>
<hr>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="form_email">Adresse Email</label>
                    <input type="email" class="form-control" name="form_email" placeholder="Entrez votre email" required>
                </div>
                <div class="form-group">
                    <label for="form_password">Mot de passe</label>
                    <input type="password" class="form-control" name="form_password" placeholder="Mot de passe" required>
                </div>
                <div class="g-recaptcha" data-sitekey="6LdfEAwqAAAAAKsmbY2jAYJOSlGiy25eUW7sgaMG"></div>
                <br>
                <button type="submit" class="btn btn-success">Connexion</button>
            </form>
            <div class="checkbox">
                <label>
                    <a href="../MdpOublié/dmde_password.php">Mot de passe oublié</a>
                </label>
            </div>
             
        </div>
    </div>
</div>
<hr>
<hr>

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

<?php
require "database.php"; // script de connexion à la base de données

$errors = []; // Tableau pour stocker les erreurs
$success = false; // Indicateur de succès

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = htmlspecialchars(trim($_POST['form_name']));
    $email = htmlspecialchars(trim($_POST['form_email']));
    $password = htmlspecialchars(trim($_POST['form_password']));
    $confirm_password = htmlspecialchars(trim($_POST['form_confirm_password']));
    $adresse = htmlspecialchars(trim($_POST['form_message']));
    $role_id = 2; // Par défaut, nouveau compte en tant qu'utilisateur standard (peut varier selon votre implémentation)

    // Validation des champs
    if (empty($nom)) {
        $errors[] = "Le nom est requis.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Un email valide est requis.";
    }
    if (empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }
    if (empty($adresse)) {
        $errors[] = "L'adresse est requise.";
    }

    // Vérifiez si le rôle a été sélectionné
    if (isset($_POST['user_role']) && ($_POST['user_role'] == 'administrateur')) {
        $role_id = 2; // Si l'utilisateur a sélectionné le rôle administrateur
    }

    // Si aucune erreur, insérer les données dans la base de données
    if (empty($errors)) {
        // Hashage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Préparer la requête SQL
        $stmt = $connection->prepare("INSERT INTO utilisateur (nom_et_prenom, email, password, adresse, role_id) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssssi", $nom, $email, $hashed_password, $adresse, $role_id);

            // Exécuter la requête
            if ($stmt->execute()) {
                $success = true;
            } else {
                $errors[] = "Erreur lors de l'inscription: " . $stmt->error;
            }
        } else {
            $errors[] = "Erreur de préparation de la requête: " . $connection->error;
        }
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
            <div class="navbar-collapse  collapse">
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

<!-- Header Starts -->
<div class="header">
<a href="index.php"><img src="images/lo.jpg" alt="Realestate"></a>

              <ul class="pull-right">
                <li><a href="buysalerent.php">Acheter</a></li>
                <!-- <li><a href="buysalerent.php">sale</a></li>          -->
                <li><a href="buysalerent.php">Louer</a></li>
              </ul>
</div>
<!-- #Header Starts -->
</div>

<div class="inside-banner">
    <div class="container"> 
        <span class="pull-right"><a href="index.php">Accueil</a> / <a href="login.php">Login</a></span>
        <h2>Register</h2>
    </div>
</div>
<hr>
<hr>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            
             <?php
        if ($success) {
            echo "<div class='alert alert-success'>Inscription réussie !</div>";
        }
        if (!empty($errors)) {
            echo "<div class='alert alert-danger'><ul>";
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul></div>";
        }
        ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" class="form-control" placeholder="Entrez votre Nom & Prenom" name="form_name" value="<?= isset($nom) ? $nom : '' ?>" required>
            <input type="text" class="form-control" placeholder="Entrez votre Email" name="form_email" value="<?= isset($email) ? $email : '' ?>" required>
            <input type="password" class="form-control" placeholder="Votre Password" name="form_password" required>
            <input type="password" class="form-control" placeholder="Confirmez votre Password" name="form_confirm_password" required>
            <textarea rows="6" class="form-control" placeholder="Entrez votre Adresse" name="form_message" required><?= isset($adresse) ? $adresse : '' ?></textarea>

           <!--  Champ pour sélectionner le rôle
            <label for="user_role">Sélectionner le rôle :</label>
            <select class="form-control" name="user_role" id="user_role">
                <option value="utilisateur" selected>Utilisateur</option>
                <option value="administrateur">Administrateur</option>
            </select>
 -->
            <br>
            <button type="submit" class="btn btn-success" name="Submit">Register</button>
        </form>
        </div>
    </div>
</div>
<hr>
<hr>




<!-- ----------------------------------------------footer------------------------------------- -->
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
        <div class="col-sm-6 login">
        <h4>Login</h4>
          <form class="" role="form">
        <div class="form-group">
          <label class="sr-only" for="exampleInputEmail2">Email address</label>
          <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Entrez votre email">
        </div>
        <div class="form-group">
          <label class="sr-only" for="exampleInputPassword2">Password</label>
          <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox"> Souviens-toi de moi
          </label>
        </div>
        <button type="submit" class="btn btn-success">Se Connecter</button>
      </form>          
        </div>
        <div class="col-sm-6">
          <h4>Inscription</h4>
          <p>rejoignez-nous aujourd'hui et soyez informé de toutes les transactions immobilières en cours.</p>
          <button type="submit" class="btn btn-info"  onclick="window.location.href='register.php'">Join Now</button>
        </div>

      </div>
    </div>
  </div>
</div>
<!-- /.modal -->

</body>
</html>

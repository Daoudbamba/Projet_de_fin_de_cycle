<?php
require "database.php";

// Initialiser la variable $mge
$mge = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);

    // Vérifiez si l'email existe dans la base de données
    $stmt = $connection->prepare('SELECT * FROM utilisateur WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $token = bin2hex(random_bytes(50)); // Générer un jeton sécurisé
        $expires = date('U') + 1800; // Le jeton expire dans 30 minutes

        // Insérez le jeton et l'expiration dans la base de données
        $stmt = $connection->prepare('INSERT INTO password_reset (email, token, expires) VALUES (?, ?, ?)');
        $stmt->bind_param('ssi', $email, $token, $expires);
        $stmt->execute();

        // Envoyez le lien de réinitialisation par email
        $resetLink = "http://localhost/pfc/MdpOublié/reini_password.php?token=$token";
        $subject = "Réinitialisation de mot de passe";
        $message = "Cliquez sur ce lien pour réinitialiser votre mot de passe : $resetLink";
        mail($email, $subject, $message); // Utilisez une fonction d'envoi d'email appropriée

        $mge = "Un lien de réinitialisation de mot de passe a été envoyé à votre adresse email.";
    } else {
        $mge = "Aucun compte trouvé avec cette adresse email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mot de passe oublié</title>
    <link rel="stylesheet" type="text/css" href="css/authentification.css">
</head>
<body>
    <form method="POST" action="">
        <h1>Mot de passe oublié</h1>
        <div class="inputs">
            <p style="color: green;"><?php echo $mge; ?></p>
            <br>
            <input type="email" name="email" id="email" required placeholder="Entrez votre Email pour recevoir le lien de réinitialisation">
        </div>
        <p align="center"><span style="color:red;">*</span>Vérifiez votre boîte mail<span style="color:red;">*</span></p>
        <div align="center" class="envoi">
            <input type="submit" name="Envoyer" value="Envoyer">
            <input type="reset" name="Annuler" value="Annuler">
        </div>
    </form>
</body>
</html>

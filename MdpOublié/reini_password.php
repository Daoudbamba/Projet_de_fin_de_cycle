<?php
require "database.php";

$mge = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = htmlspecialchars($_POST['token']);
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    // Récupérer l'email associé au token
    $stmt = $connection->prepare("SELECT email FROM password_reset WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Mettre à jour le mot de passe dans la table utilisateur
        $stmt = $connection->prepare("UPDATE utilisateur SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $new_password, $email);
        $stmt->execute();

        // Supprimer la demande de réinitialisation
        $stmt = $connection->prepare("DELETE FROM password_reset WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        $mge = "Votre mot de passe a été mis à jour.";
    } else {
        $mge = "Token invalide.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation du mot de passe</title>
    <link rel="stylesheet" type="text/css" href="css/authentification.css">
</head>
<body>
    <form method="POST" action="reset_password.php">
        <h1>Réinitialisation du mot de passe</h1>
        <div class="inputs">
            <p style="color: green;"><?php echo $mge; ?></p>
            <br>
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>" required>
            <input type="password" name="new_password" placeholder="Entrez votre nouveau mot de passe" required>
        </div>
        <div align="center" class="envoi">
            <button type="submit">Réinitialiser</button>
        </div>
    </form>
</body>
</html>

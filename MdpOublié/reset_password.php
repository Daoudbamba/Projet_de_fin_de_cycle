<?php
require "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $stmt = $connection->prepare('SELECT * FROM password_reset WHERE token = ?');
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $reset = $result->fetch_assoc();
        $email = $reset['email'];

        // Mettre à jour le mot de passe de l'utilisateur
        $stmt = $connection->prepare('UPDATE utilisateur SET password = ? WHERE email = ?');
        $stmt->bind_param('ss', $password, $email);
        if ($stmt->execute()) {
            // Supprimez le jeton de réinitialisation après usage
            $stmt = $connection->prepare('DELETE FROM password_reset WHERE email = ?');
            $stmt->bind_param('s', $email);
            $stmt->execute();

            echo "Votre mot de passe a été réinitialisé avec succès.";
        } else {
            echo "Erreur lors de la mise à jour du mot de passe : " . $stmt->error;
        }
    } else {
        echo "Lien de réinitialisation invalide.";
    }
}
?>

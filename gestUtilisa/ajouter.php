<?php
require "database.php";
session_start();

if ($_SESSION['role'] != 'administrateur') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_et_prenom = htmlspecialchars($_POST['nom_et_prenom']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $adresse = htmlspecialchars($_POST['adresse']);
    $role_id = intval($_POST['role_id']);
    $permissions = isset($_POST['permissions']) ? implode(',', $_POST['permissions']) : '';

    $insertion = $connection->prepare('INSERT INTO utilisateur (nom_et_prenom, email, password, adresse, role_id, permissions) VALUES (?, ?, ?, ?, ?, ?)');
    if (!$insertion) {
        die('Erreur de préparation de la requête : ' . $connection->error);
    }

    $insertion->bind_param('ssssss', $nom_et_prenom, $email, $password, $adresse, $role_id, $permissions);
    if ($insertion->execute()) {
        header("Location: code.php");
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur : " . $insertion->error;
    }
}

$roles = $connection->query('SELECT * FROM roles');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter Utilisateur</title>
    <link rel="stylesheet" href="css/authentification.css">
</head>
<body>
   <form method="POST" action="">
    <h1>Ajouter un Utilisateur</h1>
    <div class="inputs">
        <input type="text" name="nom_et_prenom" placeholder="Nom et Prénom" required>
        <input type="text" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="text" name="adresse" autocomplete="off" placeholder="Adresse" required>
        <select name="role_id" required>
            <?php while ($role = $roles->fetch_assoc()): ?>
                <option value="<?php echo $role['id']; ?>"><?php echo $role['nom']; ?></option>
            <?php endwhile; ?>
        </select>
        <label>Permissions :</label><br>
        <input type="checkbox" id="gestion_utilisateurs" name="permissions[]" value="gestion_utilisateurs">
        <label for="gestion_utilisateurs">Gestion des Utilisateurs</label><br>

        <input type="checkbox" id="gestion_propriete" name="permissions[]" value="gestion_propriete">
        <label for="gestion_propriete">Gestion des Propriétés</label><br>

        <input type="checkbox" id="gestion_background" name="permissions[]" value="gestion_background">
        <label for="gestion_background">Gestion des Backgrounds</label><br>

        <input type="checkbox" id="gestion_agents" name="permissions[]" value="gestion_agents">
        <label for="gestion_agents">Gestion des Agents</label><br>

        <input type="checkbox" id="accès_complet" name="permissions[]" value="accès_complet">
        <label for="accès_complet">Accès Complet</label><br>
    </div>
    <div class="envoi">
        <input type="submit" value="Ajouter">
        <input type="reset" value="Annuler">
    </div>
</form>

</body>
</html>

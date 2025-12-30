<?php
require "database.php";
session_start();

if ($_SESSION['role'] != 'administrateur') {
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id']);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_et_prenom = htmlspecialchars($_POST['nom_et_prenom']);
    $email = htmlspecialchars($_POST['email']);
    $adresse = htmlspecialchars($_POST['adresse']);
    $role_id = intval($_POST['role_id']);
    $permissions = isset($_POST['permissions']) ? implode(',', $_POST['permissions']) : '';

    $modification = $connection->prepare('UPDATE utilisateur SET nom_et_prenom = ?, email = ?, adresse = ?, role_id = ?, permissions = ? WHERE utilisateurid = ?');
    if (!$modification) {
        die('Erreur de préparation de la requête : ' . $connection->error);
    }

    $modification->bind_param('sssisi', $nom_et_prenom, $email, $adresse, $role_id, $permissions, $id);
    if ($modification->execute()) {
        header("Location: code.php");
    } else {
        echo "Erreur lors de la modification de l'utilisateur : " . $modification->error;
    }
} else {
    $requete = $connection->prepare('SELECT * FROM utilisateur WHERE utilisateurid = ?');
    $requete->bind_param('i', $id);
    $requete->execute();
    $resultat = $requete->get_result();
    $utilisateur = $resultat->fetch_assoc();
    $requete->close();

    $roles = $connection->query('SELECT * FROM roles');
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier Utilisateur</title>
    <link rel="stylesheet" href="css/authentification.css">
</head>
<body>
    <form method="POST" action="">
        <h1>Modifier un Utilisateur</h1>
        <div class="inputs">
            <input type="text" name="nom_et_prenom" value="<?php echo $utilisateur['nom_et_prenom']; ?>" required>
            <input type="text" name="email" value="<?php echo $utilisateur['email']; ?>" required>
        
            <input type="text" name="adresse" value="<?php echo $utilisateur['adresse']; ?>" autocomplete="off" placeholder="Adresse" required>
            <select name="role_id" required>
                <?php while ($role = $roles->fetch_assoc()): ?>
                    <option value="<?php echo $role['id']; ?>" <?php if ($role['id'] == $utilisateur['role_id']) echo 'selected'; ?>><?php echo $role['nom']; ?></option>
                <?php endwhile; ?>
            </select>

            <label>Permissions :</label><br>
            <?php
            $permissionsArray = explode(',', $utilisateur['permissions']);
            $permissions = [
                'gestion_utilisateurs' => 'Gestion des Utilisateurs',
                'gestion_propriete' => 'Gestion des Propriétés',
                'gestion_background' => 'Gestion des Backgrounds',
                'gestion_agents' => 'Gestion des Agents',
                'accès_complet' => 'Accès Complet'
            ];

            foreach ($permissions as $value => $label) {
                $checked = in_array($value, $permissionsArray) ? 'checked' : '';
                echo "<input type='checkbox' id='$value' name='permissions[]' value='$value' $checked> <label for='$value'>$label</label><br>";
            }
            ?>
        </div>
        <div class="envoi">
            <input type="submit" value="Modifier">
            <input type="reset" value="Annuler">
        </div>
    </form>
</body>
</html>

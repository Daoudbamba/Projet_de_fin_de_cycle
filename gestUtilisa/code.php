<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/code.css">
    <title>Gestion des Utilisateurs</title>
</head>
<body>
    <h1 class="text-logo" align="center"><span class="bi-person"></span> Gestion des Utilisateurs <span class="bi-person"></span></h1>
    <div class="container admin">
        <div class="row">
            <h1><strong>Liste des Utilisateurs</strong><a href="ajouter.php" class="btn btn-success btn-lg"><span class="bi-plus"></span> Ajouter</a></h1>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom et Prénom</th>
                        <th>Email</th>
                        <th>Adresse</th>
                        <th>Rôle</th>
                        <th>Permissions</th>
                        <th>Date de Création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require "database.php";

                    $req = $connection->query('SELECT utilisateur.*, roles.nom AS role_nom FROM utilisateur LEFT JOIN roles ON utilisateur.role_id = roles.id');
                    while ($utilisateur = $req->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $utilisateur['utilisateurid'] . "</td>";
                        echo "<td>" . $utilisateur['nom_et_prenom'] . "</td>";
                        echo "<td>" . $utilisateur['email'] . "</td>";
                        echo "<td>" . $utilisateur['adresse'] . "</td>";
                        echo "<td>" . $utilisateur['role_nom'] . "</td>";
                        echo "<td>" . $utilisateur['permissions'] . "</td>";
                        echo "<td>" . $utilisateur['DateCreation'] . "</td>";
                        echo "<td width=300>";
                       
                        echo '<a class="btn btn-primary" href="modifier.php?id=' . $utilisateur['utilisateurid'] . '"><span class="bi-pencil"></span> Modifier</a> ';
                        echo '<a class="btn btn-danger" href="supprimer.php?id=' . $utilisateur['utilisateurid'] . '"><span class="bi-x"></span> Supprimer</a>';
                        echo "</td>";
                        echo "</tr>";
                    }
                    $connection->close();
                    ?>
                </tbody>
            </table>
            <div class="form-actions"><a class="btn btn-primary" href="../gestAppart/admin_dashboard.php"><span class="bi-arrow-left"></span> Retour</a> </div>
        </div>
    </div>
</body>
</html>

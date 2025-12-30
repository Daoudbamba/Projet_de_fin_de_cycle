
<!DOCTYPE html>
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
	
	<title>Agence Immo</title>
</head>

<body>
	<h1 class="text-logo" align="center"><span class="bi-shop"></span> Agence Immo <span class="bi-shop"></span></h1>
        <div class="container admin">
            <div class="row">
                <h1><strong>Liste des Appartement  </strong><a href="ajouter.php" class="btn btn-success btn-lg"><span class="bi-plus"></span> Ajouter</a></h1>
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                       <th>Id</th>	
                       <th>Adresse</th>
                       <th>Taille</th>
                       <th>Nombre de Chambres</th>
                       <th>Prix</th>
                       <th>Image</th>
                       <th>Actions</th>
                    </tr>
                  </thead>
                  
               <tbody>
               	<?php
               	require "database.php";
              
    

               	$req = $connection->query('SELECT * FROM appartement;  ');
               	while ($appartement = $req->fetch_assoc()) {
               	echo "<tr>";
               	echo "<td>" . $appartement['id'] . '</td>';
               	echo "<td>" . $appartement['adresse'] . '</td>';
                echo "<td>" . $appartement['taille'] . '</td>';
               	echo "<td>" . $appartement['nombrechambres'] . '</td>';               	
               	echo "<td>" . number_format((float)$appartement['prix'],2,'.','') . '</td>';
               	echo "<td>" .$appartement['images']. '</td>';
               	echo "<td width=360>";
               echo '<a class="btn btn-secondary" href="voir.php?id=' . $appartement['id'] . '"><span class="bi-eye"></span> Voir</a>';

               	echo " ";
                echo '<a class="btn btn-primary" href="modifier.php?id=' . $appartement['id'] . '"><span class="bi-pencil"></span> Modifier</a>'; 
                echo " ";  
                echo '<a class="btn btn-danger" href="supprimer.php?id=' . $appartement['id'] . '"><span class="bi-x"></span> Supprimer</a>'; 
               	echo "</td>";	
                echo "</tr>";	




               	}
               

              mysqli_close($connection);
               	?>
               	
            </tbody>
        </table>
         <div class="form-actions"><a class="btn btn-primary" href="../gestAppart/admin_dashboard.php"><span class="bi-arrow-left"></span> Retour</a> </div> 
    </div>
</div>
</body>
</html>
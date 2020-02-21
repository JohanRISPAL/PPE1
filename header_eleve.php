<?php

			session_start();
			
		if (isset($_POST["deco"]))
				{
					session_destroy();
						
					header('Location: accueil.php');
				}
?>
	<!DOCTYPE html>
	<html lang="fr">
	<head>
	<link rel="stylesheet" type="text/css" href="../css/header.css" media="all" />
	<link rel="stylesheet" type="text/css" href="../css/correctionAdmin.css" media="all" />
	<link rel="stylesheet" type="text/css" href="../css/creation.css" media="all" />
	<link rel="stylesheet" type="text/css" href="../css/accueil.css" media="all" />
	<link rel="stylesheet" type="text/css" href="../css/correctionE.css" media="all" />
	<meta charset="utf-8" />
	<title>PPE</title>
	</head>

	<body>
		<div id='idPers'>
		<p>Bonjour 
		<?php
			echo $_SESSION["nomU"]." ".$_SESSION["prenomU"];
		?>	
		</p>
				
		<h1>Welcome to the cottorecteur rift</h1>
				
		<form action="accueil.php" method="post">
		<p><input type="submit" value="deconnexion" name="deco"/></p>
		</form>
				
		</div>

		<div id="bouttonNavigation">
				<a href="eleve.php">Accueil | </a>
		<?php
				$bdd = new PDO('mysql:host=localhost;dbname=application;charset=utf8', 'root', 'root');
				$admin = $bdd->query('SELECT * FROM Utilisateur WHERE idUser ="'.$_SESSION["idUser"].'"');
				$isAdmin = $admin->fetch();
				if ($isAdmin['isAdmin'] == 1)
				{
			?>
				<a href="creationTP.php">creation TP | </a>
				<a href="correctionA.php">Correction A</a> 			
				<?php
				}

				if ($isAdmin['isAdmin'] == 0)
				{
			?>
					<a href="correctionE.php">repondre aux questions</a>
			<?php		
				}

		?>

		</div>		
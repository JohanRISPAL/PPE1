<?php 
	
		session_start();

		if (!empty($_POST["ident"]))
		{
			$bdd = new PDO('mysql:host=localhost;dbname=application;charset=utf8', 'root', 'root');
			
			$user = $_POST["ident"];
			$pwd = $_POST["pass"];
				
			$reponse = $bdd->query('SELECT * FROM Utilisateur WHERE identifiant ="'.$user.'" AND password ="'.$pwd.'"');
			$data = $reponse->fetch();
?>
<div id="messageErreur">
<?php				
			if (empty($data)) 
			{
				echo "Les données de connexions sont incorrects veuillez recommencez s'il vous plait";
			} 
?>
</div>
<?php

			if (!empty($data))
			{
				if ($data['isAdmin'] == 1)
				{
					$_SESSION["idUser"] = $data['idUser'];
					$_SESSION["nomU"] = $data['nom'];
					$_SESSION["prenomU"] = $data['prenom'];
						
					header('Location: eleve.php');
				}
				else
				{
					$_SESSION["idUser"] = $data['idUser'];
					$_SESSION["nomU"] = $data['nom'];
					$_SESSION["prenomU"] = $data['prenom'];
						
					header('Location: eleve.php');
				}
			}
		}
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<link rel="stylesheet" type="text/css" href="../css/connexion.css" media="all" />
		<meta charset="utf-8" />
		<title>PPE</title>
	</head>
	
	<body>
	
		<div id="layout">
			<h1>Bienvenue dans le Sqlub voyageur, vas-tu te connecter ?</h1>
			<h3>Un jour mon ancetre Gurdil fut envoyé creuser dans la foret</h3>
			<form method='post' action='accueil.php'>
				<p>Identifiant<input type="text" name="ident"></p>
				<p>MotdePasse<input type="password" name="pass"></p>
				<input class=bouton type="submit" value="connexion"/>
			</form>
		</div>	
	
	
	</body>
</html>
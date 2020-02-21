<?php
	include('header_eleve.php');
?>
<?php
	//Insertion du Tp si il est rempli
	if(!empty($_POST['nomTp']))
	{
		//obligation du script pour continuer
		if (!empty($_FILES['scriptTP']))
		{
?>
		<div class="infoTp">
<?php
		$bdd = new PDO('mysql:host=localhost;dbname=application;charset=utf8', 'root', 'root');

		//récupere le script et on le copie
		$cheminScript = "../dataTP/scriptTP/" .$_FILES['scriptTP']['name'];
		move_uploaded_file($_FILES['scriptTP']['tmp_name'],$cheminScript);

		//info du tp
		$idTp = $bdd->query("SELECT idTp FROM tp WHERE numero=" .$_POST['numTp']);
		$idTpDonne = $idTp->fetch();
		$nombreEnonce = $_POST['nbQuestion'];

		//si le tp n'existe pas, on le créé
			if(empty($idTpDonne['idTp']))
			{
				//execute la requete d'insertion
				$creaTp = $bdd->prepare("INSERT INTO tp (intro, numero, titre, cheminScript, dateLimite) VALUES (?, ?, ?, ?, ?) ");
				$creaTp->execute([$_POST['introTp'], $_POST['numTp'], $_POST['nomTp'], $cheminScript, $_POST["dateRendu"]]);

				$idTp = $bdd->query("SELECT idTp FROM tp WHERE numero=" .$_POST['numTp']);
				$idTpDonne = $idTp->fetch();
				$idTpFinal = $idTpDonne['idTp'];

				//infos des enonces et des corriges, insertion dans la bdd
				for ($i = 1; $i <= $nombreEnonce; $i++)
				{
					$enonce = $_POST['enonce' .$i];

					$insertEnonce = $bdd->prepare('INSERT INTO enonce(idTp, numeroQuestion, question) VALUES (?, ?, ?);');
					$insertEnonce->execute([$idTpFinal, $i, $enonce]);

					$idEnonce = $bdd->query("SELECT idEnonce FROM enonce WHERE numeroQuestion = " .$i ." AND idTp = " .$idTpFinal);
					$idEnonceDonne = $idEnonce->fetch();
					$idEnonceFinal = $idEnonceDonne['idEnonce'];

					$correction = $_POST["correction" .$i];

					$insertCorrection = $bdd->prepare("INSERT INTO corrige (idEnonce, reponseProf) VALUES (?, ?);");
					$insertCorrection->execute([$idEnonceFinal, $correction]);

				}

				echo "<p id='reussite'> Le Tp a été créé avec succès</p>";
			}
		}
	}



?>
<?php
	include('footer_eleve.php');
?>
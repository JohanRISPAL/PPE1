<?php 
	include('header_eleve.php')
?>

<a href="eleve.php">accueil</a>
<!-- insertion réponses dans la bdd -->
<?php
if(!empty($_POST['idTP']))
{
	$bdd = new PDO('mysql:host=localhost;dbname=application;charset=utf8', 'root', 'root');

	$idTp = $_POST['idTP'];

	$idEnonce = $bdd->query('SELECT idEnonce FROM enonce WHERE idTp=' .$idTp);

	?>

	<div class="resultats">

	<?php

	$numeroQuestionActuelle = 1;

	while ($idEnonceResultat = $idEnonce->fetch())
	{
		$idEnonceFinal = $idEnonceResultat['idEnonce'];

		$reponseExist = $bdd->query('SELECT idReponse FROM reponse WHERE idEnonce =' .$idEnonceFinal.' AND idUser =' .$_SESSION['idUser']);
		$reponseExistDonne = $reponseExist->fetch();

		//si elle n'existe pas, insertion de la reponse

		if (empty($reponseExistDonne['idReponse']))
		{
			if ($_POST[$idEnonceFinal] == "")
			{
				echo '<p>Votre reponse est vide, ce qui signifie que cette reponse ne peut etre enregistre</p>';
			}
			else
			{
				echo '<p id="envoie">Votre réponse à la question numéro '. $numeroQuestionActuelle.' est enregistré c:</p>';
				$envoie = $bdd->prepare("INSERT INTO reponse (idEnonce, idUser, reponse) VALUES (?, ?, ?);");
				$envoie->execute([$idEnonceFinal, $_SESSION['idUser'], $_POST[$idEnonceFinal]]);
			}
			
		}

		//sinon message erreur

		else
		{
			echo '<p id="echec">Vous avez déja repondu à la question numero ' .$numeroQuestionActuelle .'</p>';
		}

		$numeroQuestionActuelle++;
	}
}
	?>
</div>
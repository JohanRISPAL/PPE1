<?php
	include('header_eleve.php');
	$bdd = new PDO('mysql:host=localhost;dbname=application;charset=utf8', 'root', 'root');

	$titre = ('SELECT titre, idTp FROM tp');
	$reponse = $bdd->query($titre);
?>
	<form id="idTP" method="post" action="eleve.php">
		<select name='tp'>
<?php
			while ($donne = $reponse->fetch())
			{
				 echo "<option value='".$donne["idTp"]."'>".$donne["titre"]."</option>";
			}
?>
			<input type="submit" id="selecTP" value="ok">
		</select>
	</form>	
	<div id="tpComplet">
<?php
	if (!empty($_POST['tp']))
	{
		$i = 1;

		$tp = $bdd->query('SELECT intro FROM tp WHERE idTp = '.$_POST['tp']);
		$affiche = $tp->fetch();

		$question = $bdd->query('SELECT question FROM enonce WHERE idTp ='.$_POST['tp']);

		echo "<p> Intro : ". " " .$affiche["intro"] . "</p>";
		while($questionDonne = $question->fetch())
		{
			echo "<p> Question " .$i. " : " . " " . $questionDonne["question"] . " <br> " . " <p>";
			$i++;
		} 
	}

?>
</div>
<div id="message">
<?php
	if (empty($_POST['tp'])) 
	{
		echo "<p> Selectionne un tp à gauche afin de voir son contenu <p>";
	}
?>	
</div>

	
<?php
	include('footer_eleve.php');
?>
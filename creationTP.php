<?php
	include('header_eleve.php');
?>
<!-- choix du nombre de questions -->
<form method="post" class="nombreQuestionSelection" action="creationTP.php">
	<input type="number" name="nombreQuestion" id="nbQuestion" placeholder="Nombre de Questions :" min="1">
	<input type="submit" name="boutton" id="bouttonSelection" value="confirmer">
</form>
<br>
<br>

<?php 
	
	//création des zones de textes apres selection nombre questions
	if (!empty($_POST['nombreQuestion']))
	{

?>
		<!-- formulaire pour les infos du TP -->
		<form method="post" class="creaTP" action="confirmationCreation.php" enctype="multipart/form-data">
			<div id="infoTp">
			<input type="text" name="nomTp" placeholder="Nom du Tp : ">
			<input type="number" name="numTp" placeholder="Numéro du Tp : " min="1">
			<input type="text" name="introTp" placeholder="Intro du Tp : ">
			<input type="date" name="dateRendu">
			<input type="file" name="scriptTP" accept=".sql, .SQL" placeholder="Script SQL du Tp">
			</div>
			<div id="affichage">
		<div id="enonce">
		<?php 
			$nombreQuestion = $_POST['nombreQuestion'];

			for ($i = 1; $i <= $nombreQuestion; $i++)
			{
				echo "<p> Enonce numero " .$i ."</p>";
				$enonce = "enonce" .$i;
				$correction = "correction" .$i;

		?>
	</div>
			<div id="zoneCreation">
				<textarea name="<?php echo $enonce ?>" cols="50" rows="15" placeholder ="Ecrire l'énoncé ici "></textarea>
				<textarea name="<?php echo $correction ?>"cols="50" rows="15" placeholder ="Ecrire la correction ici "></textarea>
			</div>
		</div>
		<?php
			}	
		?>
		<input type="hidden" name="nbQuestion" value="<?php echo $nombreQuestion ?>">
		<div id="boutonEnvoie">
		<input type="submit" id="bouttonValider" name="boutton" value="Créer">
	</div>
	</form>

	<?php
	}
	?>
<?php
	include('footer_eleve.php');
?>

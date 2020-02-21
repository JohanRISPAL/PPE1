<?php	
	include('header_eleve.php');
?>
<!-- selection tp -->
<form method="post" class="nomTp" action="correctionE.php">
	<select name="idTP" size="1">
		<?php 
		$bdd = new PDO('mysql:host=localhost;dbname=application;charset=utf8', 'root', 'root');
					
				$reponse = $bdd->query('SELECT * FROM tp WHERE dateLimite >= CURDATE()');

				while ($titre = $reponse->fetch())
				{
		?>
					    <option value="<?php echo $titre['idTp'] ?>.">Tp numero <?php echo $titre['numero']?></option>
		<?php
				}
		?>
	</select>
	<input type="submit" name="bouton" id="selectionTp" value="confirmer">
</form>

<!--si un tp est choisi, creation zone pour repondre-->
<?php 
	if(!empty($_POST['idTP']))
	{
		$tp = $bdd->query('SELECT * FROM tp WHERE idTp ='.$_POST['idTP']);
		$reponseTp = $tp->fetch();
		$idTP = $reponseTp['idTp'];
?>

<!-- creation textarea pour repondre selon le nombre de question -->
<form method="post" id="reponseE" action="envoie.php">
	<input type="hidden" name="idTP" value=<?php echo '"' .$idTP .'"' ?>>
<?php	
		//recup enonces
			$question = $bdd->query('SELECT * FROM enonce WHERE idTp ='.$_POST['idTP']);

		while ($questionAffiche = $question->fetch())
		{
?>
		<div id="zoneExercice">
		<p>Question : <?php echo $questionAffiche['numeroQuestion']?><br>
					<?php echo $questionAffiche['question']?>
		</p>

		<textarea name="<?php echo $questionAffiche['idEnonce']?>" cols ="80" row="40" placeholder ="Reponse :"></textarea>
	</div>
	<br>

<?php
		}
	}
	
	
?>
<div id="envoie">
<input type='submit' id="boutonEnvoie" name="bouton" value="envoyer">
</div>
</form>



<?php	
	include('footer_eleve.php');
?>
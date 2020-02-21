<?php
	include('header_eleve.php');
	$bdd = new PDO('mysql:host=localhost;dbname=application;charset=utf8', 'root', 'root');

	$titre = ('SELECT titre, idTp FROM tp');
	$reponse = $bdd->query($titre);
	$eleve = $bdd->query('SELECT nom, prenom, idUser FROM utilisateur WHERE isAdmin = 0');
?>
	<!-- recuperation eleve et tp -->
	<div id="recupTp">
	<form id="idTp" method="post" action="correctionA.php">
		<select name='tp'>
<?php
			while ($donne = $reponse->fetch())
			{
				 echo "<option value='".$donne["idTp"]."'>".$donne["titre"]."</option>";
			}
?>
		</select>
		<select name="nomEleve">
<?php
			while ($eleveNom = $eleve->fetch())
			{
				echo "<option value='" .$eleveNom['idUser'] ."'>".$eleveNom["nom"] ." " .$eleveNom["prenom"] ."</option>";
			}
?>			
		</select>
		<input type="submit" id="selecTP" value="ok">
	</form>	
	</div>

	<!--affichage corrige et reponse eleve -->
	<?php
		if (!empty($_POST['tp']) && !empty($_POST['nomEleve']))
		{
			$enonce = $bdd->query('SELECT * FROM enonce WHERE idTp =' .$_POST["tp"]);

		//affichage execution pour eleve
		
			//nouvelle bdd pour les reponses des eleves
			$bdd2 = new PDO('mysql:host=localhost;dbname=application2;charset=utf8', 'root', 'root');

			//info du tp pour son script
			$idTp = $bdd->query("SELECT idTp FROM tp WHERE idTp =" .$_POST['tp']);
			$idTpDonne = $idTp->fetch();
			$idTpFinal =$idTpDonne['idTp'];

			//recup du script
			$CheminScript = $bdd->query("SELECT cheminScript FROM tp WHERE idTp =" .$_POST['tp'] );
 			$CheminScriptDonne = $CheminScript->fetch();
 			$CheminScriptFinal = $CheminScriptDonne['cheminScript'];

 			//recup du nombre de table de la bdd2, afin de la vider pour y mettre le tp charger
 			$listeTable = $bdd2->query("SHOW TABLES");
 			$listeTableDonne = $listeTable->fetch();

 			//on vide la bdd2
 			while (!empty($listeTableDonne))
 			{
 				$nombreTables = $bdd2->query("SHOW TABLES");

 				while($nombreTablesDonnes = $nombreTables->fetch())
 				{
 					$dropTable = "DROP TABLE " .$nombreTablesDonnes["Tables_in_application2"];
 					$bdd2->query($dropTable);
 				}
 			}

 			//quand elle est vide, recupération du nouveau tp
 			$nouveauScript = file_get_contents($CheminScriptFinal);
 			$bdd2->exec($nouveauScript);

 			//info du nouveau tp
 			$nouveauEnonce = $bdd->query("SELECT * FROM enonce  WHERE idTp = " .$_POST['tp']);

 			//info eleve pour affichage
 			$eleveReponse = $bdd->query("SELECT * FROM utilisateur WHERE idUser = " .$_POST['nomEleve']);
 			$eleveReponseDonne = $eleveReponse->fetch();
	?>

	<div id="Affichage">
		<p> <?php echo "Ceci sont les reponses de" ." " . $eleveReponseDonne['nom'] ." " .$eleveReponseDonne['prenom'] ?> </p>

		<?php

			//Affichage corrigé, reponse et les exécutions
			while ($enonceReponse = $nouveauEnonce->fetch())
			{
			?>
			<!-- affichage enonce -->
			<div id="enonce">
				<br>
				<br>
				<p> Question numero <?php echo $enonceReponse['numeroQuestion'] ?> <br>
					<?php echo $enonceReponse['question'] ?> </p>
			</div>

			<?php

			//données reponses et corigé
				$corrige = $bdd->query('SELECT reponseProf from corrige WHERE idEnonce =' .$enonceReponse["idEnonce"]);
				$corrigeDonne = $corrige->fetch();

				$reponseE = $bdd->query('SELECT reponse from reponse WHERE idEnonce =' .$enonceReponse["idEnonce"] .' AND idUser = ' .$_POST["nomEleve"]);
				$reponseEdonne = $reponseE->fetch();

			//reponse et corrigé pour les requetes
				$corrigeRequete = $bdd2->query($corrigeDonne['reponseProf']);
				$reponseRequete = $bdd2->query($reponseEdonne['reponse']);
				?>

				<!-- affichage des données -->
				<div id="texte">
					<div id="corrige">
						<?php

						if($corrigeDonne['reponseProf'] != "")
						{
							?>
							<div id="texteCorrige">
							<p>Prof : <?php echo $corrigeDonne[0]; ?> <br> </p>
							</div>
							<?php
						}

						//erreur si il n'existe pas
						else
						{
							?>
							<div id="erreur">
							<p>Le corrigé n'existe pas, pensez à en faire un la prochaine fois</p>
						</div>
							<?php
						}

						//affichage requete du corrige
						if(!empty($corrigeRequete))
						{
							?>
							<div id="requeteCorrige">
							<p>Requete :
							<?php 

							while ($corrigeRequeteDonne = $corrigeRequete->fetch())
							{
								echo ("<br>");
								for ($i = 0; $i < count($corrigeRequeteDonne) / 2; $i++)
								{
									echo $corrigeRequeteDonne[$i] ." ";
								}
							}
							?>
							</p>
							</div>
							<?php
						}

						//sinon messsage erreur
						else
						{
							?>
							<div id="erreur">
							<p>La requete doit etre dure si meme le prof n'y arrive pas</p>
						</div>
							<?php
						}
						?>
					</div>
					<div id="reponse">
						<?php

						if($reponseEdonne['reponse'] != "")
						{
							?>
							<div id="texteReponse">
							<p>Eleve : <?php echo $reponseEdonne[0]; ?> </p>
							</div>
							<?php
						}
						
						//erreur si il n'existe pas
						else
						{
							?>
							<div id="erreur">
							<p>L'eleve n'a pas repondu à cette question, soit c'était trop dur ou peut etre qu'il y arrivera la prochaine fois</p>
						</div>
							<?php
						}

						//affichage requete du corrige
						if(!empty($reponseRequete))
						{
							?>
							<div id="requeteReponse">
							<p>
							Requete : 
							<?php 

							while ($reponseRequeteDonne = $reponseRequete->fetch())
							{
								echo ("<br>");
								for ($i = 0; $i < count($reponseRequeteDonne) / 2; $i++)
								{
									echo $reponseRequeteDonne[$i] . " ";
								}
							}
							?>
							</p>
							<?php
						}

						//sinon messsage erreur
						else
						{
							?>
							<div id="erreur">
							<p>La requete ne fonctionne pas, soit il n'a pas réussi ou alors il lui a manqué du temps</p>
						</div>
							<?php
						}
		?>
					</div>
				</div>
		<?php	
			}
		}

		?>
</div>
</div>
<?php
	include('footer_eleve.php');
?>
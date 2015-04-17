<?php

include_once ('FormulaireConnexion.class.php');	
		 
		
if(isset($_POST['email']) AND isset($_POST['mdp'])) 
	{
		try
			{
				$bdd = new PDO('mysql:host=sql2.olympe.in;dbname=la46ueoo;charset=utf8', 'la46ueoo', 'simply44');
			}
				catch (Exception $e)
			{
				die('Erreur : ' . $e->getMessage());
			}

				
				$email = $_POST['email'];
				$mdp = $_POST['mdp'];
				$aNiveaux = array('administrateur','moderateur','restaurateur');

				// Vérification des identifiants
				$req = $bdd->prepare('SELECT prenom, nom, visibilite FROM restaurateur WHERE email = :email AND mdp = :mdp');
				
				$req->execute(array(
				'email' => $email,
				'mdp' => $mdp));
				
				$req2 = $bdd->prepare('SELECT prenom, nom, visibilite FROM administrateur WHERE email = :email AND mdp = :mdp');
				
				$req2->execute(array(
				'email' => $email,
				'mdp' => $mdp));
				
				$req3 = $bdd->prepare('SELECT prenom, nom, visibilite FROM moderateur WHERE email = :email AND mdp = :mdp');
				
				$req3->execute(array(
				'email' => $email,
				'mdp' => $mdp));

				$resultat = $req->fetch();
				$resultat2 = $req2->fetch();
				$resultat3 = $req3->fetch();
				
				if (!$resultat AND !$resultat2 AND !$resultat3)
				{
					echo 'Mauvais email ou mot de passe !';
					$formulaire = new FormulaireConnexion();
					$formulaire -> creerFormulaireConnexion();
				}
				else
				{
					session_start();
					//$_SESSION['id_rest'] = $resultat['id_rest'];
					$_SESSION['visibilite'] = $resultat['visibilite'];
					$_SESSION['prenom'] = $resultat['prenom'];
					$_SESSION['nom'] = $resultat['nom'];
					$iTypeUtilisateur = $_SESSION['visibilite'];
  
					echo 'Vous êtes connecté '.$_SESSION['prenom'].$_SESSION['nom'];?>
					<br>
					<?php echo 'vous êtes un '.$iTypeUtilisateur;
					
					include ('menu.php');
				}
	}
		
		
	

?>
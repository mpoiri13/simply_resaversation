<?php

/* ------------------------------------------------------------------------- /
                        
    Ce fichier est la seule classe qui à l'authorisation de communiquer
    à la base de données. Elle ne contient que des fonctions de requêtages.  

/ ------------------------------------------------------------------------- */

class Bdd{	
	//variables
	//private
	private $sHost = BDD_HOST;
	private $sDbname = BDD_NAME;
	private $sUtilisateur = BDD_USER;
	private $sMdp = BDD_MDP;
	private $bdd = '';
	//public
	

	//Constructeur
	//Si aucun paramètre ne lui est passé, il charge la base de données à partir des constantes
	//contenu dans le fichier parametres. Sinon il charge la base de données passée en argument.
	function bdd($sHost='', $sDbname='', $sUtilisateur='', $sMdp=''){
		
		$sHost = $sHost != '' ? $sHost : $this->sHost;
		$sDbname = $sDbname != '' ? $sDbname : $this->sDbname;
		$sUtilisateur = $sUtilisateur != '' ? $sUtilisateur : $this->sUtilisateur;
		$sMdp = $sMdp != '' ? $sMdp : $this->sMdp;

		try{
			$this->bdd = new PDO('mysql:host=' . $sHost . ';dbname=' . $sDbname . ';charset=utf8', $sUtilisateur, $sMdp);
		}catch (Exception $e){
			die('Erreur : ' . $e->getMessage());
		}
	}

	public function user_getData($iId){
		$bdd = $this->bdd;

		$req=$bdd->prepare('SELECT * FROM user WHERE id=?');

	    $bReturn = $req->execute(array($iId));

	    if($bReturn == true){
	    	$aRetour = $req->fetch();
	    	$req->CloseCursor();
	    	
	    	return $aRetour;
	    }else{
	    	$req->CloseCursor();
	    	return $bReturn;
	    }
	}

	public function user_insert($oUser){
		$bdd = $this->bdd;

		$req=$bdd->prepare('INSERT INTO user (email, nom, prenom, mdp, droit) VALUES (:email, :nom, :prenom, :mdp, :droit)');

	    $req->bindValue(':email',$oUser->getEmail(), PDO::PARAM_STR);
	    $req->bindValue(':nom',$oUser->getNom(), PDO::PARAM_STR);
	    $req->bindValue(':prenom',$oUser->getPrenom(), PDO::PARAM_STR);
	    $req->bindValue(':mdp',md5($oUser->getMdp()), PDO::PARAM_STR);
	    $req->bindValue(':droit',$oUser->getDroit(), PDO::PARAM_STR);

	    $bReturn = $req->execute();
	    $req->CloseCursor();

	    if($bReturn == true){
	    	return $bdd->lastInsertId();
	    }else{
	    	return $bReturn;
	    }
	}

	public function user_update($oUser){

	}

	public function user_delete($oUser){

	}

}

?>
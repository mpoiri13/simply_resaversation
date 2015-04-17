<?php

/* ------------------------------------------------------------------------- /
                        
    Ce fichier est une classe, elle ne produira en aucun cas de l'html et
    ne communique pas avec la base de donnée.
	
	Cette classe gère les utilisateurs, le controller (le fichier rooting)
	ira charger la class bdd afin que celle-ci aille chercher les informations
	sur les utilisateurs dans la bdd. Cette classe se contente de réunir les
	informations de l'utilisateur et d'éffectuer des traitements ou des contrôles
	sur celle-ci. Si à l'issu des traitements, un utilisateur doit être modifié
	en base, le controller refera appel à la classe bdd.

	Une instance de cette classe correspond à un utilisateur.

/ ------------------------------------------------------------------------- */

class User
{
	//variables
	//private
    private $sPrenom;
	private $sNom;
    private $sEmail;
	private $sMdp;
	private $iDroit; /*Droits en chiffres*/
   	private $iActif; /*Voir si son profil est actif dans la BDD*/

   	//public
	public $aError;


	//Constructeur
	//Si on envoi un tableau d'information au constructeur, il
	//remplira les variables contenant les données de l'utilisateur
   	function User($aTableau=''){
   		if(!empty($aTableau)){
   			foreach($aTableau as $k=>$v){
   				switch ($k){
   					case 'prenom':
   						$this->sPrenom = $v;
   					break;
   					case 'nom':
   						$this->sNom = $v;
   					break;
   					case 'email':
   						$this->sEmail = $v;
   					break;
   					case 'mdp':
   						$this->sMdp = $v;
   					break;
   					case 'droit':
   						$this->iDroit = $v;
   					break;
   					case 'actif':
   						$this->iActif = $v;
   					break;
   				}
   			}
   		}
   	}

   	//Getter

	public function getPrenom(){
		return $this->sPrenom;
	}

	public function getNom(){
		return $this->sNom;
	}

	public function getEmail(){
		return $this->sEmail;
	}

	public function getMdp(){
		return $this->sMdp;
	}
	
	public function getDroit(){
		return $this->iDroit;
	}
	
	public function getActif(){
		return $this->iActif;
	}
	
	//Setter

	public function setPrenom($sNvPrenom) {
		$this->sPrenom = $sNvPrenom;
	}
	
	public function setNom($sNvNom) {
		$this->sNom = $sNvNom;	
	}
	
	public function setEmail($sNvEmail) {
		$this->sEmail = $sNvEmail;	
	}
	
	public function setMdp($sNouveauMdp){
		$this->sMdp = $sNouveauMdp;
	}
	
	public function setDroit($iNouveauAcces){
		$this->iDroit = $iNouveauAcces;
	}
	
	public function setActif($bNouveauActif){
		$this->bActif = $bNouveauActif;
	}

	//Fonctions internes

	public function validation(){

		$this->aError = array();

		if($this->sPrenom == ''){
			$this->aError['prenom'] = 'error_vide';
		}elseif(strlen($this->sPrenom) > 50){
			$this->aError['prenom'] = 'error_trop_long';
		}

		if($this->sNom == ''){
			$this->aError['nom'] = 'error_vide';
		}elseif(strlen($this->sNom) > 50){
			$this->aError['nom'] = 'error_trop_long';
		}

		if($this->sEmail == ''){
			$this->aError['email'] = 'error_vide';
		}elseif(strlen($this->sEmail) > 50){
			$this->aError['email'] = 'error_trop_long';
		}

		if($this->sMdp == ''){
			$this->aError['mdp'] = 'error_vide';
		}elseif(strlen($this->sMdp) > 8){
			$this->aError['mdp'] = 'error_trop_long';
		}

		if($this->iDroit == ''){
			$this->aError['droit'] = 'error_vide';
		}
	}
}

?>
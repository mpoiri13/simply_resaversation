<?php

	//Afin d'afficher les erreurs php
	error_reporting(E_ALL); 
	ini_set('display_errors', 1);

/* ------------------------------------------------------------------------- /
                        
    Ce fichier contient les paramètres réccurents du site.
    Comme le nom du site, les droits des utilisateurs...  

/ ------------------------------------------------------------------------- */
	
	//Démarre le service de variable de session.
	//Ce service fontionne comme un tableau qui serai stocké sur le server.
	//Tant que l'utilisateur a une variable de session de crée, les
	//informations contenues dans cette variable ne disparaissent pas
	//même si on quitte le site pour y revenir plus tard.
	//Elles expirent si on les détruits ou après un lapse de temps d'inactivité.

	session_start();

//	************** paramètres de connexion **************

	//Pour basculer le code de local à en ligne, il suffit de changer
	//le paramètre online à true pour en ligne, false pour hors ligne.
	define('ONLINE', false);


	if(ONLINE == true){
		define('BDD_HOST', 	"sql2.olympe.in");
		define('BDD_NAME', 	"la46ueoo");
		define('BDD_USER', 	"la46ueoo");
		define('BDD_MDP', 	"simply44");
	}else{
		define('BDD_HOST', 	"localhost");
		define('BDD_NAME', 	"database");
		define('BDD_USER', 	"root");
		define('BDD_MDP', 	"");
	}

	//Gestion des droits
	//Le principe est de créer des constantes = à des puissances de 2.
	//Chaque constante correspond à une authorisation.
	//Une fois les authorisations définies, on construit un tableau
	//et en fonction des droits (administrateur, restaurateur...)
	//on attribut les contantes (voir tableau $aPermission)
	//Il suffira de faire un test autour d'un bouton
	//if($aPermission & Lire){affiche mon bouton}
	//Pour afficher le bouton aux utilisateurs possédant les droits.

//	************** constantes **************

	define('LIRE', 			1);
	define('CREER', 		2);
	define('MODIFIER', 		4);
	define('SUPPRIMER', 	8);
	define('DEBUG', 		16);

//	************** tableau des droits **************

	if(isset($_SESSION['id_user'])){

		//Si la personne est connecté, je créé un objet
		//user avec ses caractéristiques.

		require_once 'class/bdd.class.php';
		require_once 'class/user.class.php';

		//récupération des informations de l'utilisateur
		$oBdd = new Bdd();
		$aUserData = $oBdd->user_getData($_SESSION['id_user']);

		//création de l'objet 
		$oConnectUser = new User($aUserData);

		$iDroit = $oConnectUser->getActif();
	}else{
		//Si la personne n'est pas connecté, je force ses droits à 0
		$iDroit = 0;
	}
	
	switch($iDroit){
		case 0 : //visiteur
			$aPermission['site'] = LIRE;
			$aPermission['admin'] = 0;
		break;
		case 1: //administrateur
			$aPermission['site'] = LIRE;
			$aPermission['admin'] = LIRE + CREER + MODIFIER + SUPPRIMER;
		break;
	}


//je définis le rooting de l'application
include 'include/rooting.inc.php';
?>
<?php

/* ------------------------------------------------------------------------- /
                        
    Cette page est la seul et unique page du site.
    Elle charge le fichier paramètre qui lui même charge le 
    controller (rooting).
    Elle charge ensuite la vue qui a été définie dans le controller.
	Elle ne contient rien, elle n'est qu'une passerelle.
	Le contenu du site du header au footer est placé dans les vues.

/ ------------------------------------------------------------------------- */

	include 'include/parametres.inc.php';
	
	include ROOTING;
?>
<?php

/* ------------------------------------------------------------------------- /
                        
    Ce fichier est une vue, elle affiche se que l'utilisateur voit.
    Ici se trouve le strict minimum, du code html et un peu de php
    pour les traitements des erreurs par exemple.

    Si la page necessite du javascript ou du css, il faudra le rentré 
    dans la variable $sScript.  

/ ------------------------------------------------------------------------- */


    //Si il y a besoin de rajouter du code javascript pour cette vue
    $sScript="";

    include 'include/header.inc.php';

?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

    <h1>Inscription</h1>

    <div>
        <label for="type">* Type utilisateur :</label>
        <select name="inscription[droit]">
            <option value='1'>Administrateur</option>
            <option value='2'>Modérateur</option>
            <option value='3'>Restaurateur</option>
        </select>
    </div>

    <div>
        <label for="nom">* Nom :</label><input type="text" name="inscription[nom]" /><?php if(isset($oUser->aError['nom'])){echo $oUser->aError['nom'];} ?>
    </div>
    <div>
        <label for="prenom">* Prénom :</label><input type="text" name="inscription[prenom]" /><?php if(isset($oUser->aError['prenom'])){echo $oUser->aError['prenom'];} ?>
    </div>
    <div>
        <label for="email">* Email :</label> <input type="text" name="inscription[email]" /><?php if(isset($oUser->aError['email'])){echo $oUser->aError['email'];} ?>
    </div>
    <div>
        <label for="password">* Mot de Passe :</label><input type="password" name="inscription[mdp]" id="mdp" /><?php if(isset($oUser->aError['mdp'])){echo $oUser->aError['mdp'];} ?>
    </div>
    <div>
        <label for="confirm">* Confirmer le mot de passe :</label><input type="password" name="inscription[confirm]" id="confirm" />
    </div>

    <p>Les champs précédés d'un * sont obligatoires</p>

    <p><input type="submit" value="Valider" />
</form>

<?php

include 'include/footer.inc.php';
?>

<?php include ('parametres.php'); ?>
<!DOCTYPE html>
<html>
	<nav id="menu">
		<div class="element_menu">
			<ul id="onglets">
				<?php
				
				if (!empty($iTypeUtilisateur)){
				switch ($iTypeUtilisateur)
				{ 
					case null:
					break;
					case "0": // Client : A créer 
					?>
						<li><a href="CompteClient.html"> Mon Compte C</a></li>
						<li><a href="ReservationsClients.html"> Ma Reservation C</a></li>
					<?php break;
					
					case "2": // Restaurateur : A créer
					?>
						<li><a href="CompteRestaurateur.html"> Mon Compte R</a></li>
						<li><a href="RestaurantsRestaurateur.html"> Mes Restaurants R</a></li>
						<li><a href="OffresRestaurateur.html"> Mes Offres R</a></li>
						<li><a href="ReservationsRestaurateur.html"> Mes Réservations R</a></li>
					<?php break;
					
					case "4" OR "6": // Moderateur ou Administrateur : A créer
					?>
						<li><a href="CompteModerateur.html"> Mon Compte M</a></li>
						<li><a href="OffresModerateur.html"> Offres M</a></li>
						<li><a href="RestaurantsModerateur.html"> Restaurants M</a></li>
						<li><a href="RestaurateursModerateur.html"> Restaurateurs M</a></li>
					<?php break;
					
					default:
								echo "Le type de l'utilisateur n'est pas reconnu";
				}
				}
				?>
			</ul>
		</div>
	</nav>
</html>

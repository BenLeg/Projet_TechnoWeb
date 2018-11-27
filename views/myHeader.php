

<!DOCTYPE html>

<html>

<header>

<div id="conteneur1">

	<div class="element3">	<img src="images/peacelove.png" width="50px">	</div>

	<div class="element1"> <a href="index.php?page=accueil"> Mon Peace </a>  </div>

	<div class="element2" >

<?php 
	if ($co==false){
		echo '
		<form id="connexion" method="post"> 
			Username : <input type="text" name="identifiant" />
			<input type="submit" value="Envoyer" />
			</br>
			Password : <input type="password" name="mdp"/> 
			</form>

		' ;
	}
		
	else {
		echo '
		<a href="index.php?page=accueil">  <form action="index.php?page=accueil" id="deconnexion" method="post"> 
		     <input type="hidden" type="text" name="deco" value="decon"/>
	    	<input type="submit" value="Me déconnecter" /></form> </a>
		';
}?>
	</div>

</div>


<div id="conteneur2">
    
    <div class="elem1"> <a id="produits" href="index.php?page=liste_produits">LesProduits</a> </div>
	<div class="elem2">       
        <form id="recherche" action="index.php?page=search" method="post">  <input type="text" name="recherche" placeholder="Votre recherche"/> </form> </div> 
<?php 	if ($co==true) {		echo '  <div class="elem3"> <a id="panier" href="index.php?page=panier">MonPanier</a> 		</div> '		;		}?>
<?php 	if ($co==false){		echo '  <div class="elem3"> <a id="produits" href="index.php?page=inscription">Inscription</a> </div> 	'		;		}?>

</div>
	

</header>

</html>
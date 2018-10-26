
<?php
	
	try	{			$bdd = new PDO('mysql:host=localhost;dbname=capsules;charset=utf8', 'root', '');		}
	catch (Exception $e)	{	        die('Erreur : ' . $e->getMessage());		}
	
	$user_id = '';
	$co=false;

	session_start ();
			
	if (isset($_POST['deco']) ){
    		session_unset ();
			session_destroy ();
#	   		echo 'vous venez de vous déconnecter';  
    }

	if (isset($_SESSION['identifiant']) && isset($_SESSION['password'])) {
#		echo "Vous etes connecté </br>";
		$co=true;	
	}

	if(isset($_POST['identifiant']) AND isset($_POST['mdp'])  ){
    	$identifiant = $_POST['identifiant'] ;
    	$mdp = $_POST['mdp'] ;
    	$result = $bdd->query('SELECT * FROM users');
    	$donnee = $result->fetch();
    	while($donnee != null){
    		if($donnee['username']==$identifiant AND $donnee['password']==$mdp){
    			$user_id = $donnee['id'];
				$_SESSION['identifiant'] = $identifiant;
				$_SESSION['password'] = $mdp;
				$_SESSION['id'] = $user_id;
#    			echo 'vous venez de vous connecter';
				$co=true;
    		}
    		$donnee = $result->fetch();
    	} 
    	$result->closeCursor();
    }


?>


<!DOCTYPE html>

<html>
<head><link rel="stylesheet" href="style.css" /></head>


<header>



<div id="conteneur1">

	<div class="element3">	<img src="images/macaps.png" width="50px">	</div>

	<div class="element1">  Ma Capsule </div>

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
		<form id="deconnexion" method="post">
		    <div id="hide"> <input type="text" name="deco" value="decon"/> </div>
	    	<input type="submit" value="Me déconnecter" />
		</form>
		';
	
}?>
	</div>

</div>


<div id="conteneur2">
    
    <div class="elem1"> <a id="produits" href="liste_produits.php">LesProduits</a> </div>
	<div class="elem2"> <form id="recherche" action="search.php" method="get">  <input type="text" name="search" placeholder="marecherche"/> </form> </div> 
<?php 	if ($co==true) {		echo '  <div class="elem3"> <a id="panier" href="empty card.php">MonPanier</a> 		</div> '		;		}?>
<?php 	if ($co==false){		echo '  <div class="elem3"> <a id="produits" href="inscription.php">Inscription</a> </div> 	'		;		}?>

</div>
	

</header>

</html>
<!DOCTYPE html>


<html>
<head><link rel="stylesheet" href="style.css" /></head>


<header>
	<link rel="stylesheet" href="mcss/common.css" />


<?php

	$bdd = new PDO('mysql:host=localhost;dbname=project;charset=utf8', 'root', '');
	
	try	{			$bdd = new PDO('mysql:host=localhost;dbname=project;charset=utf8', 'root', '');		}
	catch (Exception $e)	{	        die('Erreur : ' . $e->getMessage());		}
	
	$user_id = '';

    if (	isset($_POST['identifiant']) AND isset($_POST['mdp'])  ){
    	$identifiant = $_POST['identifiant'] ;
    	$mdp = $_POST['mdp'] ;
    	$result = $bdd->query('SELECT * FROM users');
    		$donnee = $result->fetch();
    	while($donnee != null){
    		if($donnee['username']==$identifiant AND $donnee['password']==$mdp){
    			$user_id = $donnee['id'];
    		}
    		$donnee = $result->fetch();
    	} 
    	$result->closeCursor();
    }


    ?>



<div id="conteneur1">

<div class='element3'>	<img src="images/macaps.png" width="50px">	</div>

	<div class="element1">  <a id="nomdusite" href="myHeaderLigne.php">Ma Capsule</a> </div>
	<div class="element2" id="deco">
		<form id="connexion"  method='post'> 
		Username : <input type='text' name='identifiant' />	<input type='Submit' value='Valider'>
		</br>
		Password : <input type='text' name='mdp'/> 
		</form> 
	</div>

	<div class="element2" id="co">	
	</br>
		Bonjour <?php ?>
		Vous êtes connecté.
		</form>

	</div>
</div>

<div id="conteneur2">
    
    <div class="elem1"> <a id="produits" href="produits.php">LesProduits</a> </div>
    <div class="elem2"><input type="text" href="search.php" value='Search'></div>
    <div class="elem3"> <a id="panier" href="panier.php">MonPanier</a> </div>

</div>
	

</header>

</html>
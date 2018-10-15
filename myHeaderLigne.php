<!DOCTYPE html>

<html>
<head><link rel="stylesheet" href="style.css" /></head>


<header>
	<link rel="stylesheet" href="mcss/common.css" />




<?php
	
	try	{			$bdd = new PDO('mysql:host=localhost;dbname=capsules;charset=utf8', 'root', '');		}
	catch (Exception $e)	{	        die('Erreur : ' . $e->getMessage());		}
	
	$user_id = '';
	$co=false;

    if (	isset($_POST['identifiant']) AND isset($_POST['mdp'])  ){
    	$identifiant = $_POST['identifiant'] ;
    	$mdp = $_POST['mdp'] ;
    	$result = $bdd->query('SELECT * FROM users');
    		$donnee = $result->fetch();
    	while($donnee != null){
    		if($donnee['username']==$identifiant AND $donnee['password']==$mdp){
    			$user_id = $donnee['id'];
    			echo 'vous etes co';
				$co=true;
    		}
    		$donnee = $result->fetch();
    	} 
    	$result->closeCursor();
    }


    ?>
<script type="text/javascript">
	var co = parseInt('<?php echo $co; ?>') ;
	if(co=true){
		document.querySelector(".co").style.display="block";
		document.querySelector(".deco").style.display="none";
	}
	else{
		document.querySelector(".co").style.display="none";
		document.querySelector(".deco").style.display="block";
	}

</script>

<div id="conteneur1">

	<div class="element3">	<img src="images/macaps.png" width="50px">	</div>

	<div class="element1">  <a id="nomdusite" href="myHeaderLigne.php">Ma Capsule</a> </div>
	<div class="element2" >
		<form id="connexion" method="post"> 
		Username : <input type="text" name="identifiant" />
		<input type="submit" value="Envoyer" />
		</br>
		Password : <input type="password" name="mdp"/> 
		</form> 
	</div>

	<div class="element2">	
		<div id="co">
		</br>
		Bonjour <?php echo $identifiant  ?>
		Vous êtes connecté.</div>
	</div>

</div>

<div id="conteneur2">
    
    <div class="elem1"> <a id="produits" href="search_p.php">LesProduits</a> </div>
    <div class="elem3"> <a id="panier" href="empty card.php">MonPanier</a> </div>

</div>
	

</header>

</html>
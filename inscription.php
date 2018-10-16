<!DOCTYPE html>
<html>
<head>
	<title>Inscription</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style_inscription.css">
</head>

<?php
try {
 	$bdd = new PDO('mysql:host=localhost;dbname=capsules;charset=utf8','root','');
 } catch (Exception $e) {
die('Erreur: '.$e->getMessage());
 } 
?>


<body>
	<div id="global">
		<div class="login-wrap">
			<span class="login-title-form">
				Inscrivez-vous !
			</span>
			<br>
			<form method="POST" action="inscription.php" class="login-form" required >
				<br>
	  			<input class="login-input" type="mail" name="mail" placeholder="Adresse mail" required>
				<br>
	  			<input class="login-input" type="text" name="username" placeholder="Identifiant" required>
	  			<br>
	  			<input class="login-input" type="password" name="password" placeholder="Mot de passe" required>
	  			<br>
	  			<input class="login-input" type="password" name="confirm-password" placeholder="Confirmer mot de passe" required>
	  			<br><br>
	  			<input class="submit-input" type="submit" name="validation" value="Valider">
	  			<a class="lien" href="search_p.php">Connexion</a>
	  			<img src = "images/logo.png" id="logo">
	  			<br>
			</form>
		</div>
	</div> 

	<?php 
	// On teste si le le client a appuye sur le bouton valider
	if(isset($_POST['validation'])){

		$mail = $_POST['mail'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$confirm_password=$_POST['confirm-password'];

			// On verifie que les deux mots de passe saisis sont identiques
			if( $password == $confirm_password){/*Manipulation de la BDD*/
				$reponse = $bdd->query('SELECT * FROM users WHERE username = \''. $username.'\'');
				$data = $reponse->fetch();

				if($data == null){
					$bdd->exec('INSERT INTO users(username,email,password) VALUES(\''.$username.'\',\''.$mail.'\',\''.$password.'\')');
					echo "BLABLABLA";
				}
				else{  echo "L'username existe deja"; }
				
			}
			else{$erreur = "Les deux mots de passe sont différents.";}
			}
	?>
</body>
</html>
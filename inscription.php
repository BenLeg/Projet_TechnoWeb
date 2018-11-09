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
	  			<input class="login-input" type="text" name="human_name" placeholder="Nom et prénom" required>
				<br>
	  			<input class="login-input" type="text" name="username" placeholder="Identifiant" required>
	  			<br>
	  			<input class="login-input" type="password" name="password" placeholder="Mot de passe" required>
	  			<br>
	  			<input class="login-input" type="password" name="confirm-password" placeholder="Confirmer mot de passe" required>
	  			<br>
	  			<input class="login-input" type="number" name="numero_rue" placeholder="Numéro de rue" required><br>
	  			<input class="login-input" type="text" name="rue" placeholder="Rue" required>
	  			<br>
	  			<input class="login-input" type="text" name="address_two" placeholder="Complément d'adresse" required>
	  			<br>
	  			<input class="login-input" type="text" name="postal_code" placeholder="Code postal" required>
	  			<br>
	  			<input class="login-input" type="text" name="city" placeholder="Ville" required>
	  			<br>
	  			<input class="login-input" type="text" name="country" placeholder="Pays" required>
	  			<br><br>
	  			<input class="submit-input" type="submit" name="validation" value="Valider">
	  			<a class="lien" href="accueil.php">Connexion</a>
	  			<img src = "images/logo.png" id="logo">
	  			<br>
			</form>
		</div>
	</div> 

	<?php 
	// On teste si le le client a appuye sur le bouton valider
	if(isset($_POST['validation'])){

			// On verifie que les deux mots de passe saisis sont identiques
			if( $_POST['password'] == $_POST['confirm-password']){/*Manipulation de la BDD*/
				$reponse = $bdd->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
				$reponse->execute(array(
					'username'=>$_POST['username'],
					'email'=>$_POST['mail']
				));
			
				$data = $reponse->fetch();
				$data_username = $data['username'];
				$data_mail = $data['email'];
				$reponse->closeCursor();

				if(empty($data_username) OR empty($data_mail)){
					$requete = $bdd->prepare("INSERT INTO user_address(human_name,address_one,address_two,postal_code,city,country) VALUES (:human_name,:address_one,:address_two,:postal_code,:city,:country)");
					$requete->execute(array(
						'human_name' => $_POST['human_name'],
						'address_one' => $_POST['numero_rue'].' '.$_POST['rue'],
						'address_two' => $_POST['address_two'],
						'postal_code' => $_POST['postal_code'],
						'city' => $_POST['city'],
						'country' => strtoupper($POST['country'])
					));

					$reponse = $bdd->prepare("SELECT id FROM user_address");
					$data_id = $reponse->fetch();
					$reponse->closeCursor();

					$requete = $bdd->prepare("INSERT INTO users(username,email,password,billing_address_id,delivery_address_id) VALUES (:username,:email,:password,:billing_address_id,:delivery_address_id)");
					$requete->execute(array(
						'username' => $_POST['username'],
						'email' => $_POST['mail'],
						'password' => $_POST['password'],
						'billing_address_id' => $data_id,
						'delivery_address_id' => $data_id
					));

					header('Location: accueil.php');
  					exit();
				}
				else{  echo "L'identifiant et/ou l'adresse mail existe(nt) déjà"; }
				
			}
			else{echo "Les deux mots de passe sont différents.";}
			}
	?>
</body>
</html>
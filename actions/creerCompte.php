
<?php
					$requete = $bdd->prepare("INSERT INTO user_addresses(human_name,address_one,address_two,postal_code,city,country) VALUES (:human_name,:address_one,:address_two,:postal_code,:city,:country)");
					$requete->execute(array(
						'human_name' => $_POST['human_name'],
						'address_one' => $_POST['numero_rue'].' rue '.$_POST['rue'],
						'address_two' => $_POST['address_two'],
						'postal_code' => $_POST['postal_code'],
						'city' => $_POST['city'],
						'country' => $_POST['country']
					));

					$reponse = $bdd->prepare("SELECT * FROM user_addresses WHERE human_name = :human_name AND address_one = :address_one AND address_two = :address_two");
					$reponse->execute(array(
						'human_name' => $_POST['human_name'],
						'address_one' => $_POST['numero_rue'].' rue '.$_POST['rue'],
						'address_two' => $_POST['address_two']
					));
					$data = $reponse->fetch();
					$data_id = $data['id'];
					$reponse->closeCursor();

					$requete = $bdd->prepare("INSERT INTO users(username,email,password,billing_adress_id,delivery_adress_id) VALUES (:username,:email,:password,:billing_adress_id,:delivery_adress_id)");
					$requete->execute(array(
						'username' => $_POST['username'],
						'email' => $_POST['mail'],
						'password' => $_POST['password'],
						'billing_adress_id' => $data_id,
						'delivery_adress_id' => $data_id
					));
					header('Location: accueil.php');
  					exit();

  					?>
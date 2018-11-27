    <?php
			
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
				$co=true;
    		}
    		$donnee = $result->fetch();
    	} 
    	$result->closeCursor();
    
?>
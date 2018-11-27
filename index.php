<?php 

	include 'database.php' ;


	session_start ();

	$user_id = '';
	$co=false;
	$page='index'; 
	
	if (isset($_POST['stop']) ){			echo "SALUT";        }

	if (isset($_POST['deco']) ){
    		session_unset ();
			session_destroy ();
    }

	if (isset($_SESSION['identifiant']) && isset($_SESSION['password'])) {		$co=true;		}

	if(isset($_POST['identifiant']) AND isset($_POST['mdp'])  ){    include 'connexion.php';    }

	if (isset($_GET['page'])){		$page=$_GET['page'];	} 

	if (file_exists('actions/'.$page.'.php')){	include ('actions/'.$page.'.php');	}

?>

<html>
	
	<head>
		<title>MonPeace.com</title>
		<link rel="stylesheet" href="style.css" />
	</head>


		<?php 


		if ($page != 'inscription'){		include('views/myHeader.php');		}

		?> 


		<?php 
		if (file_exists('views/'.$page.'.php')){	include ('views/'.$page.'.php');	}
		else {	include ('views/accueil.php');	}

		?> 

</html>
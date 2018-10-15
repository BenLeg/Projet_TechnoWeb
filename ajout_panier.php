<!DOCTYPE html>

<html>
	<head>
		<title>Capsules.com</title>
		<link rel="stylesheet" href="style.css" />
	</head>


<?php include 'myHeaderLigne.php'?>  

    <body>
        <?php
            $id = $_GET['id'];
            /*$user = $_GET['user'];*/
            $quantity = $_POST['quantity'];

            /*$req = $bdd->prepare('INSERT INTO jeux_video(nom, possesseur, console, prix, nbre_joueurs_max, commentaires) VALUES(:nom, :possesseur, :console, :prix, :nbre_joueurs_max, :commentaires)');
            $req->execute(array(
                'nom' => $nom,
                'possesseur' => $possesseur,
                'console' => $console,
                'prix' => $prix,
                'nbre_joueurs_max' => $nbre_joueurs_max,
                'commentaires' => $commentaires
                ));*/
        ?>
        <section>
            <div id="cadre_princ">
                <div class="ajout">
                    <?php echo $quantity ?>
                    <h> Article(s) Ajouté(s) au panier <br></h>
                </div>
                <a href="search_p.php">
                    <div class="keep_shopping">
                        <h>Keep Shopping</h>
                    </div>
                </a>
                <a href="cart.php">
                    <div class="check_cart">
                        <h>Check Cart</h>
                    </div>
                </a>
            </div>
        </section>
    </body>
</html>

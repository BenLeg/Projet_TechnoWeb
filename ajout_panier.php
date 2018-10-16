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
            $quantity = $_POST['quantity'];
            if(empty($_GET['user'])){
                ?>
                <div class="pasco">
                    <h>Avant d'ajouter vos articles dans votre panier :</h>
                    <a href="product_descri.php?id=<?php echo $_GET['id']; ?>">
                        <div id="log">
                            <h>Déjà client ?</h>
                            <p>Identifiez-vous</p>
                        </div>
                    <a href="inscription.php">
                        <div id="sign_in">
                            <h>Nouveau ?</h>
                            <p>Inscrivez-vous</p>
                        </div>
                    </a>
                </div>
            <?php 
            }
            else{
                /*Inserer commande dans bdd*/
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
                    <a href="empty card.php">
                        <div class="check_cart">
                            <h>Check Cart</h>
                        </div>
                    </a>
                </div>
            </section>
            <?php   
            }  
        ?>  
    </body>
</html>

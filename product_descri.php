<!DOCTYPE html>

<html>
	<head>
		<title>Capsules.com</title>
		<link rel="stylesheet" href="style.css" />
	</head>

	<header>
        <h1><?php include 'myHeaderLigne.php'?></h1>  
    </header>
    <body>

        <?php
            $product_id = $_GET['id'];
            /*$user = $_GET['username']*/
            $reponse = $bdd->query('SELECT * FROM products WHERE id=\'' . $product_id . '\'');
            $donnees = $reponse->fetch();
        ?>
        <section>
            <div id="conteneur">
                <div class="photo_produit">
                    <?php 
                        $image=$product_id;
                        echo '<img src="Images/'.$image.'"width="100%">';
                    ?>
                </div>
                <div class="selected_product">
                    <table>
                        <thead><tr>
                            <th><?php echo $donnees['name']; ?></th>
                        </tr></thead>
                        <tbody><tr>
                            <td><?php echo $donnees['unit_price']; ?> €</td>
                        </tr></tbody>
                    </table>
                    <form  action="ajout_panier.php?id=<?php echo $donnees['id']; ?>" method="post">
                        <p1>Quantité : <input type="int" name="quantity" value="1" autofocus required /><br><br><br></p1>
                        <p2><input type="submit" value="Ajouter au Panier" /></p2>
                    </form>
                </div>
            </div>
        <div class="descriptif">
            <h><?php echo $donnees['name']; ?></h>
            <p><?php echo $donnees['description'];?></p>
        </div>
        </section>
    </body>
</html>

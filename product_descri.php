<?php  
    echo 'cest le produit';
    echo $_GET['id'];
    echo '</br>';
    echo '</br>';

    $i = 5 ;
    $nom ='produitRecent'.$i;
    if(isset($_COOKIE[$nom])){    # si il y a deja 5 produits enregistrés
        echo 'deja 5 produits enregistrés!!';
        for($i = 1; $i <= 5; $i++){
            $nom ='produitRecent'.$i;
            echo $nom;
            echo ' = ';
            echo $_COOKIE[$nom];
            echo "</br>";
        }
            echo "</br>";
        for($j = 5; $j > 1; $j--){
            $nom ='produitRecent'.$j;
            $n = $j-1;
            $val ='produitRecent'.$n;
            $newval = $_COOKIE[$val];
            setcookie($nom, $newval, time() + 7*24*3600, null, null, false, true);
            echo $nom;
            echo $_COOKIE[$nom];
            echo "</br>";
        }
        $j = 1;
        $nom ='produitRecent'.$j;
        setcookie($nom, $_GET['id'], time() + 7*24*3600, null, null, false, true);
        echo $nom;
        echo $_COOKIE[$nom];
         echo "</br>";
    }

    else { 
        for ($i = 1; $i <= 5; $i++) {
            $nom = 'MonproduitRecent'.$i;
            echo  $nom ;
            echo "</br>";
            if(!isset($_COOKIE[$nom])){
                setcookie($nom, $_GET['id'], time() + 7*24*3600, null, null, false, true);
                echo "</br>";
                echo "</br>";
                $i=6;
            }
        }
    }

        $j = 1;
        $nom ='produitRecent'.$j;
echo $_COOKIE[$nom];
         echo "</br>";

    // setcookie('produit1', $_GET['id'], time() + 365*24*3600, null, null, false, true);
    

?>


<!DOCTYPE html>

<html>
	<head>
		<title>MonPeace.com</title>
		<link rel="stylesheet" href="style.css" />
	</head>

<?php include 'myHeaderLigne.php'?>  

    <body>

        <?php
            $product_id = $_GET['id'];
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
                    <form  action="ajout_panier.php?id=<?php echo $donnees['id']?>" ;  method="post">
                        <p1>Quantité : <input type="int" name="quantity" value="1" autofocus required /><br><br><br></p1>
                        <p2><input type="submit" value="Ajouter au Panier" /></p2>
                    </form>
                </div>
            </div>
        <div class="descriptif">
            <h><?php echo $donnees['name']; ?></h>
            <p><?php echo $donnees['description'];?></p>
            <?php $reponse->closeCursor(); ?>
        </div>
        </section>
    </body>
</html>

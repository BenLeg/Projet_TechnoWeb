<!DOCTYPE html>

<html>
	<head>
		<title>Capsules.com</title>
		<link rel="stylesheet" href="style.css" />
	</head>

<?php include 'myHeaderLigne.php' ?> 

<?php
$recherche = $_GET['search'];

?> 

   <body>

		<section>
            <h1>Résultat de la recherche</h1>
            <br>
            <div id="conteneur_principal">
            <?php
            $reponse = $bdd->query('SELECT * FROM products');

            $traitement_en_cours=true;
            while($traitement_en_cours)
            {             
                $donnees = $reponse->fetch();
                if($donnees==false)
                {
                    $traitement_en_cours=false;
                    break;
                }
                if( strcasecmp($donnees['name'], $recherche)){
                	?>
				
                    <div class="element">
                        <a href="product_descri.php?id=<?php echo $donnees['id']; ?>">
                            <figure>
                                <?php 
                                    $image=$donnees['id'];
                                    echo '<img src="Images/'.$image.'" width="100%">';
                                ?>
                                <table>
                                    <thead><tr>
                                        <th><?php echo $donnees['name']; ?></th>
                                    </tr></thead>
                                    <tbody><tr>
                                       <td><?php echo $donnees['unit_price']; ?> €</td>
                                    </tr></tbody>
                                </table>
                            </figure>
                        </a>
                    </div>

            <?php             }       
            }
            $reponse->closeCursor();
            ?>
            </div>
    	</section>



CC SAM, tu peux afficher les produits stp j'ai la flemme



    </body>
</html>

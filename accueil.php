<!DOCTYPE html>

<html>
	<head>
		<title>MonPeace.com</title>
		<link rel="stylesheet" href="style.css" />
	</head>

<?php include 'myHeaderLigne.php'?>
    <body> 

    <center>
   </br>   </br>
        <h1>  BIENVENUE SUR MONPEACE.COM </h1>
    </br>   </br>
    <img src="images/peacelove.png">   
</center>

<section>
            <h1>Produits récemments consultés</h1>
            <br><br>
            
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
                ?>
                    <div class="element">
                        <a href="product_descri.php?id=<?php echo $donnees['id']; ?>">
                            <figure>
                                <?php 
                                    $image=$donnees['id'];
                                    echo '<img src="Images/'.$image.'"png width="100%">';
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
            <?php                    
            }
            $reponse->closeCursor();
            ?>
            </div>
        </section>



    </body>
    </html>
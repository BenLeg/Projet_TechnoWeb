<html>
	<head>
		<link rel="stylesheet" href="style.css" />
	</head>

    <body> 
<br><br>
<section>

        <?php 
            $i =1;
            $nom ='produitRecent'.$i;
            if(isset($_COOKIE[$nom])){


        ?>

            <h1>Retrouvez vos produits récemments consultés</h1>
            <br>

            <div id="conteneur_principal">

            <?php

        }

            $reponse = $bdd->query('SELECT * FROM products');

            $traitement_en_cours=true;
            while($traitement_en_cours)
            {             
                $donnees = $reponse->fetch();
                $faire = false;
                for($i=1; $i<= 4; $i++){
                    $nom ='produitRecent'.$i;
                    if(isset($_COOKIE[$nom])){
                        if($_COOKIE[$nom]==$donnees['id']){
                            $faire = true;
                            break;
                        }
                    }
                }
                
                if($donnees==false)
                {
                    $traitement_en_cours=false;
                    break;
                }

                if($faire == true){
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
            }
            $reponse->closeCursor();
            ?>
            </div>

    

        </section>

    </body>
    </html>
<!DOCTYPE html>

<html>
    <body>

		<section>
            <h1>PRODUITS</h1>
            <p1>BlablablaBlablablaBlablablaBlablablaBlablablaBlablablaBlablablaBlablablaBlabla<br>blablablablablapisenlovelameilleurlisteblablabla</p1>
            <p2><br></p2>
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
                        <a href="index.php?page=fiche_produit&id=<?php echo $donnees['id']; ?>">
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

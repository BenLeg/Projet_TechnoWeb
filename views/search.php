<!DOCTYPE html>


<?php
$recherche = $_POST['recherche'];

?> 

   <body>

		<section>
            
            <?php
            $trouve = 0;
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
                if( strcasecmp($donnees['name'], $recherche) == 0){
                	
				
                if ($trouve == 0) { 
                    echo '
                    <h1>Résultat de la recherche</h1>
                        <br>
                        <div id="conteneur_principal">    ';
                /*    echo '
                        <br>

                     <input class="login-input" type="number" name="Filtrer par prix" placeholder="Numéro de rue" required>
                        <br>
                */    ';
            } ?>
                    <div class="element">
                        <a href=index.php?page=fiche_produit&id=<?php echo $donnees['id']; ?>">
                            <figure>
                                <?php 
                                    $trouve = 1;
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


            if($trouve == 0){
                echo '
                </br></br>
                    Aucun article ne correspond à votre recherche.
                </br></br></br>
                ';
            }

            ?>
            </div>
    	</section>

    </body>
</html>

<?php include 'produits_recents.php'?>

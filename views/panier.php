<!DOCTYPE html>

<html>

    <section>
    <h1>Votre Panier:</h1>

</br>
<?php

    $UsID=$_SESSION['id'];  /*$_GET['user'];*/  

    if(isset( $_POST['commande']) )  
    {
        $bdd->exec("UPDATE orders set type = 'ORDER' where type = 'CART' AND user_id=$UsID");
        $bdd->exec("UPDATE orders set `status` = 'BILLED' where `status` = 'CART' AND user_id=$UsID");
    }

    $request = $bdd->prepare('SELECT * FROM orders WHERE type = :type AND user_id =:us_id');
    $request->execute(array(
    	'type'=>'CART',
    	'us_id'=>$UsID
    ));

    while($datareponse=$request->fetch()){
        $id=$datareponse['id'];
    }


    if(isset( $_POST['plus']) )   {      include 'actions/augmenterQuantite.php';        }
    if(isset( $_POST['moins']))       {      include 'actions/diminuerQuantite.php';        }
    if(isset( $_POST['supprimer']) )    {        include 'actions/supprimerArticle.php';    }

    $request=$bdd->prepare('SELECT * FROM orders WHERE type = :type AND user_id = :us_id');
    $request->execute(array(
    	'type'=>'CART',
    	'us_id'=>$UsID
    ));
    while($datareponse=$request->fetch()){
        $id_verif=$datareponse['id'];
    }

    if(empty($id) OR empty($id_verif))
    {
      ?>
        <br>
        <h4>Votre panier ne contient aucun article.</h4>
        <h4>Si vous souhaitez ajouter des articles à votre panier, vous pouvez poursuivre en cliquant sur ce lien: "<a class="lien_panier" href="index.php"><u>Page d'Acceuil</u></a>".</h4>

      <?php
    }
    else
    {
    	$request_amount=$bdd->prepare('SELECT amount FROM orders WHERE id=:id');
    	$request_amount->execute(array(
    		'id'=>$id
    	));
        $amount=$request_amount->fetch();
        $prix=$amount['amount'];
        $request_amount->closeCursor();

        $request_order_product=$bdd->prepare('SELECT product_id,quantity,unit_price FROM order_products WHERE order_id = :id');
        $request_order_product->execute(array(
        	'id'=>$id
        ));
        ?>
            <?php
            while($order_product = $request_order_product->fetch())
            {
                $quantity=$order_product['quantity'];
                $product_id=$order_product['product_id'];
                $prix_prod=$order_product['unit_price'];

                $request_name_product=$bdd->prepare('SELECT name FROM products WHERE id = :prod_id');
                $request_name_product->execute(array(
                	'prod_id'=>$product_id
                ));
                $rep_name = $request_name_product->fetch();
                $name_product=$rep_name['name'];
                $request_name_product->closeCursor();
                ?>
                <body>
                    <div id="produit_panier">
                        <a href="index.php?page=product_descri&id=<?php echo $product_id; ?>">
                            <div class="image_produit">
                            <?php
                                 echo '<img src="Images/'.$product_id.'"png width="100%">';
                            ?>
                            </div>
                            <div class="info_produit">
                                <table>
                                    <thead><tr>
                                        <th><?php echo $name_product ?></th>
                                    </tr></thead>
                                    <tbody><tr>
                                        <td>Prix: <?php echo $prix_prod?> €</td>
                                    </tr><tr>
                                        <td>Quantité: <?php echo $quantity ?></td> 
                                    </tr></tbody>
                                </table>  
                            </div>
                            <div class="bouton">                       
                                <form id="plus" method="post">
                                    <input type="hidden" name="plus" value="<?php echo $product_id ?>"/>
                                    <input type="submit" value="+" />  
                                </form>
                                <form id="moins" method="post">
                                    <input type="hidden" name="moins" value="<?php echo $product_id ?>"/>
                                    <input type="submit" value="-" />  
                                </form>
                                <form id="supprimer" method="post">
                                    <input type="hidden" name="supprimer" value="<?php echo $product_id ?>"/>
                                    <input type="submit" value="x" />  
                                </form>
                            </div>
                        </a>
                    </div>
                </body>	
            <?php
            }
            ?>
        	<div class="payer">
				<div id="recap_commande">
					<?php 
						if($amount==0){
							?>
							<h1>Total : 0 €</h1>
							<?php
						}
						else{
							?>
							<h1>Total : <?php echo $amount['amount'] ?> €</h1>
							<?php
						}
					?>
		        </div>
		        <form id="commander" method="post">
	                <input type="hidden" name="commande" value="go"/>
	                <input type="submit" value="Commander" />  
		        </form>
		    <?php
        $request_order_product->closeCursor();
    }
 ?>
</html>

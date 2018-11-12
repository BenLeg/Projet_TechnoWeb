<!DOCTYPE html>

<html>

<?php include 'myHeaderLigne.php'?>
<head>
    <link rel="stylesheet" href="style.css" />
    <title>MonPeace.com</title>
</head>  

    <section>
    <h1>Votre Panier:</h1>

</br>
<?php

    $UsID=$_SESSION['id'];  /*$_GET['user'];*/  

    if(isset( $_POST['commande']) )  
    {
        $req=$bdd->prepare("UPDATE orders set type = ORDER where type = CART AND user_id= :user");
        $req->execute(array(
            'user'=>$UsID
        ));
        $req=$bdd->prepare("UPDATE orders set status = BILLED where status = :status AND user_id =:user");
        $req->execute(array(
        	'status'=>'CART',
            'user'=>$UsID
        ));
    }
    $request = $bdd->prepare('SELECT * FROM orders WHERE type = :type AND user_id =:us_id');
    $request->execute(array(
    	'type'=>'CART',
    	'us_id'=>$UsID
    ));
    while($datareponse=$request->fetch()){
        $id=$datareponse['id'];
    }


    if(isset( $_POST['plus']) )  
        {
            $product_id_modif=$_POST['plus'];
            $req=$bdd->prepare("SELECT * FROM `order_products` WHERE order_id = :id and product_id= :product");
            $req->execute(array(
                'product'=>$product_id_modif,
                'id'=>$id
            ));
            while($reponse=$req->fetch()){
                $quantity=$reponse['quantity'];
            }
            $req->closeCursor();
            $new_qtt=$quantity+1;
            $req=$bdd->prepare("UPDATE order_products SET quantity=:qtt WHERE product_id=:product_id_modif AND order_id=:id");
            $req->execute(array(
                'qtt'=>$new_qtt,
                'product_id_modif'=>$product_id_modif,
                'id'=>$id
            ));
            $req=$bdd->prepare("SELECT unit_price FROM `order_products` WHERE product_id=:product_id_modif");
            $req->execute(array(
                'product_id_modif'=>$product_id_modif
            ));
            while($reponse=$req->fetch()){
                $price=$reponse['unit_price'];
            }
            $req->closeCursor();
            $reponse = $bdd->prepare("SELECT * FROM orders WHERE user_id = :user_id AND status = :status");
            $reponse->execute(array(
                'user_id'=>$_SESSION['id'],
                'status'=>'CART'
            ));
            $data=$reponse->fetch();
            $current_amount = $data['amount'];
            $amount_order=$price + $current_amount;
            $reponse->closeCursor();
            $req = $bdd->prepare('UPDATE orders SET amount = :new_amount WHERE user_id = :user_id AND status= :status');
            $req->execute(array(
                'new_amount' => $amount_order,
                'user_id' => $_SESSION['id'],
                'status' => 'CART'
            ));
        }

    if(isset( $_POST['moins']))  
        {
            $product_id_modif=$_POST['moins'];
            $req=$bdd->prepare("SELECT * FROM `order_products` WHERE order_id = :id and product_id= :product");
            $req->execute(array(
                'product'=>$product_id_modif,
                'id'=>$id
            ));
            while($reponse=$req->fetch()){
                $quantity=$reponse['quantity'];
            }
            $req->closeCursor();
            $new_qtt=$quantity-1;
            $req=$bdd->prepare("UPDATE order_products SET quantity=:qtt WHERE product_id=:product_id_modif AND order_id=:id");
            $req->execute(array(
                'qtt'=>$new_qtt,
                'product_id_modif'=>$product_id_modif,
                'id'=>$id
            ));

            $req=$bdd->prepare("SELECT unit_price FROM `order_products` WHERE product_id=:product_id_modif");
            $req->execute(array(
                'product_id_modif'=>$product_id_modif
            ));
            while($reponse=$req->fetch()){
                $price=$reponse['unit_price'];
            }
            $req->closeCursor();
            $reponse = $bdd->prepare("SELECT * FROM orders WHERE user_id = :user_id AND status = :status");
            $reponse->execute(array(
                'user_id'=>$_SESSION['id'],
                'status'=>'CART'
            ));
            $data=$reponse->fetch();
            $current_amount = $data['amount'];
            $amount_order= $current_amount - $price ;
            $req = $bdd->prepare('UPDATE orders SET amount = :new_amount WHERE user_id = :user_id AND status= :status');
            $req->execute(array(
                'new_amount' => $amount_order,
                'user_id' => $_SESSION['id'],
                'status' => 'CART'
            ));     
            if($new_qtt==0)
            {
                $req=$bdd->prepare("DELETE from order_products WHERE product_id=:product_id_modif AND order_id=:id");
                $req->execute(array(
                    'product_id_modif'=>$product_id_modif,
                    'id'=>$id
                ));
            }
		    if($amount_order==0)
			{
				$req = $bdd->prepare('DELETE from orders WHERE user_id = :user_id AND status= :status AND amount=:amount');
				$req->execute(array(
		        'user_id' => $_SESSION['id'],
		        'status' => 'CART',
		        'amount'=>0
			));	
			}
        }
    if(isset( $_POST['supprimer']) )
    {
    	$product_id_modif=$_POST['supprimer'];
        $req=$bdd->prepare("SELECT * FROM `order_products` WHERE order_id = :id and product_id= :product");
        $req->execute(array(
            'product'=>$product_id_modif,
            'id'=>$id
        ));
        $data=$req->fetch();
        $price_unit=$data['unit_price'];
        $qtte=$data['quantity'];
        $req->closeCursor();
        $reponse = $bdd->prepare("SELECT * FROM orders WHERE user_id = :user_id AND status = :status");
        $reponse->execute(array(
            'user_id'=>$_SESSION['id'],
            'status'=>'CART'
        ));
        $data=$reponse->fetch();
        $current_amount = $data['amount'];
        $new_amount_order=$current_amount-($price_unit*$qtte);
        $reponse->closeCursor();
        $req = $bdd->prepare('UPDATE orders SET amount = :new_amount WHERE user_id = :user_id AND status= :status');
        $req->execute(array(
            'new_amount' => $new_amount_order,
            'user_id' => $_SESSION['id'],
            'status' => 'CART'
        ));
        $req=$bdd->prepare("DELETE from order_products WHERE product_id=:product_id_modif AND order_id=:id");
        $req->execute(array(
            'product_id_modif'=>$product_id_modif,
            'id'=>$id
        ));
        if($new_amount_order==0)
		{
			$req = $bdd->prepare('DELETE from orders WHERE user_id = :user_id AND status= :status AND amount=:amount');
			$req->execute(array(
	        'user_id' => $_SESSION['id'],
	        'status' => 'CART',
	        'amount'=>0
		));	
		}
    }
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
                        <a href="product_descri.php?id=<?php echo $product_id; ?>">
                            <div class="image_produit">
                            <?php
                                 echo '<img src="Images/'.$product_id.'"png width="100%">';
                            ?>
                            </div>
                            <div class="info_produit">
                                <table>
                                    <thead><tr>
                                        <th>
                                            <?php echo $name_product ?>
                                        </th>
                                    </tr></thead>
                                    <tbody><tr>
                                        <td>
                                            Prix: <?php echo $prix_prod?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Quantité: <?php echo $quantity ?>                                   
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
                                        </td>
                                    </tr></tbody>
                                </table>    
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

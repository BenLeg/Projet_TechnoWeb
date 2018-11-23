
<?php 


$reponse = $bdd->prepare("SELECT * FROM orders WHERE user_id = :user_id AND status = :status");
$reponse->execute(array(
		'user_id'=>$_SESSION['id'],
		'status'=>'CART'
	));
$data=$reponse->fetch();

if(empty($data)) 						/*Si l'utilisateur n'a pas de panier :*/
{ 
			$reponse->closeCursor();
			$reponse=$bdd->prepare("SELECT * from users WHERE id = :id");	
	$reponse->execute(array(
		'id'=>$_SESSION['id']
	));
	$data_user=$reponse->fetch();
	$billing_adress_id=$data_user['billing_adress_id'];
	$delivery_adress_id=$data_user['delivery_adress_id'];
	$reponse->closeCursor();
		/*On ajoute un nouveau panier correspondant au user co*/
	$requete = $bdd->prepare('INSERT INTO orders(user_id, type, status, amount, billing_adress_id, delivery_adress_id) VALUES(:user_id, :type, :status, :amount, :billing_adress_id, :delivery_adress_id)');
			$requete->execute(array(
				'user_id' => $_SESSION['id'],
				'type' => 'CART',
				'status' => 'CART',
				'amount' => '0',
				'billing_adress_id' => $billing_adress_id,
				'delivery_adress_id' => $delivery_adress_id
				));
				/*On ajoute l'article dans orders_products */
			$reponse=$bdd->prepare("SELECT * from orders WHERE user_id = :id AND type = :status");	
	$reponse->execute(array(
		'id'=>$_SESSION['id'],
		'status'=>'CART'
	));
	$data_order=$reponse->fetch();
	$current_order_id=$data_order['id'];
	$reponse->closeCursor();
	$reponse=$bdd->prepare("SELECT * from products WHERE id = :id");	
	$reponse->execute(array(
		'id'=>$id
	));
	$data_products=$reponse->fetch();
	$unit_price=$data_products['unit_price'];
	$reponse->closeCursor();
	    /*recuperation data utilisateur afin de creer nouvelle commande*/
	$requete = $bdd->prepare('INSERT INTO order_products(order_id, product_id, quantity,unit_price) VALUES(:order_id, :product_id, :quantity, :unit_price)');
			$requete->execute(array(
				'order_id' => $current_order_id,
				'product_id' => $id,
				'quantity' => $quantity,
				'unit_price' =>$unit_price
				));
			$amount_order=$unit_price*$quantity;
			$req = $bdd->prepare('UPDATE orders SET amount = :new_amount WHERE user_id = :user_id AND status= :status');
			$req->execute(array(
				'new_amount' => $amount_order,
				'user_id' => $_SESSION['id'],
				'status' => 'CART'
			));
}

 else /*Sinon on rajoute seulement les produits dans son panier actuel et on modifie l'amount et les qttes*/
{
        $current_order_id=$data['id'];
        $reponse->closeCursor();

        $reponse=$bdd->prepare("SELECT * from products WHERE id = :id");        
        $reponse->execute(array(
                'id'=>$id
        ));
        $data_products=$reponse->fetch();
        $unit_price=$data_products['unit_price'];
        $reponse->closeCursor();

            /*check si produit deja commandé*/
        $reponse=$bdd->prepare("SELECT * from order_products WHERE product_id = :id AND order_id = :orderid");  
        $reponse->execute(array(
                'id'=>$id,
                                'orderid' => $current_order_id
        ));
        $data_order_product=$reponse->fetch();
        if($data_order_product==true) /*produit deja commande*/
        {
                $qtte_final = $data_order_product['quantity'] + $quantity;
                $reponse->closeCursor();
                $req = $bdd->prepare('UPDATE order_products SET quantity = :new_qtte WHERE product_id = :product_id');
                                $req->execute(array(
                                'new_qtte' => $qtte_final,
                                'product_id' => $id
                                ));
        } 
        else
        {
                $reponse->closeCursor();
                $requete = $bdd->prepare('INSERT INTO order_products(order_id, product_id, quantity,unit_price) VALUES(:order_id, :product_id, :quantity, :unit_price)');
                                $requete->execute(array(
                                        'order_id' => $current_order_id,
                                        'product_id' => $id,
                                        'quantity' => $quantity,
                                        'unit_price' =>$unit_price
                                ));
        }  

        /*Gestion du prix total*/
                        $reponse = $bdd->prepare("SELECT * FROM orders WHERE user_id = :user_id AND status = :status");
        $reponse->execute(array(
                'user_id'=>$_SESSION['id'],
                'status'=>'CART'
        ));
        $data=$reponse->fetch();
        $current_amount = $data['amount'];
                        $amount_order=$unit_price*$quantity + $current_amount;
                        $req = $bdd->prepare('UPDATE orders SET amount = :new_amount WHERE user_id = :user_id AND status= :status');
                        $req->execute(array(
                                'new_amount' => $amount_order,
                                'user_id' => $_SESSION['id'],
                                'status' => 'CART'
                        ));
                        
}

?>
        <?php

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

        ?>
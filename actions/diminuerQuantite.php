
<?php
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

            ?>
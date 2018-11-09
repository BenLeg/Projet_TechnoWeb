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
        $req=$bdd->prepare("UPDATE orders set type = 'ORDER' where type = 'CART' AND user_id= :user");
        $req->execute(array(
            'user'=>$UsID
        ));
        $req=$bdd->prepare("UPDATE orders set `status` = 'BILLED' where `status` = 'CART' AND :user=$UsID");
        $req->execute(array(
            'user'=>$UsID
        ));
    }

    $request="SELECT * FROM orders WHERE `type`='CART' AND user_id='" . $UsID . "'";
    $reponseorder=$bdd->query($request);
    while($datareponse=$reponseorder->fetch()){
        $id=$datareponse['id'];
    }

    if(isset( $_POST['plus']) )  
        {
            $product_id_modif=$_POST['plus'];
            $req=$bdd->prepare("SELECT * FROM `order_products` WHERE order_id = $id and product_id= :product");
            $req->execute(array(
                'product'=>$product_id_modif
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
            $reponse = $bdd->prepare("SELECT * FROM orders WHERE user_id = :user_id AND status = :status");
            $reponse->execute(array(
                'user_id'=>$_SESSION['id'],
                'status'=>'CART'
            ));
            $data=$reponse->fetch();
            $current_amount = $data['amount'];
            $amount_order=$price + $current_amount;
            $req = $bdd->prepare('UPDATE orders SET amount = :new_amount WHERE user_id = :user_id AND status= :status');
            $req->execute(array(
                'new_amount' => $amount_order,
                'user_id' => $_SESSION['id'],
                'status' => 'CART'
            ));
        }

    if(isset( $_POST['moins']) )  
        {
            $product_id_modif=$_POST['moins'];
            $req=$bdd->prepare("SELECT * FROM `order_products` WHERE order_id = $id and product_id= :product");
            $req->execute(array(
                'product'=>$product_id_modif
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
        }
    if(isset( $_POST['supprimer']) )
    {
        $product_id_modif=$_POST['supprimer'];
        $req=$bdd->prepare("DELETE from order_products WHERE product_id=:product_id_modif AND order_id=:id");
        $req->execute(array(
            'product_id_modif'=>$product_id_modif,
            'id'=>$id
        ));
    }


    if(empty($id))
    {
      ?>
        <br>
        <h4>Votre panier ne contient aucun article.</h4>
        <h4>Si vous souhaitez ajouter des articles à votre panier, vous pouvez poursuivre en cliquant sur ce lien: "<a class="lien_panier" href="liste_produits.php"><u>Page d'Acceuil</u></a>".</h4>

      <?php

    }
    else
    {
        $request_amount="SELECT amount FROM `orders` WHERE id=$id";
        $reponse_request_amount=$bdd->query($request_amount);
        $amount=$reponse_request_amount->fetch();
        $prix=$amount['amount'];
        $reponse_request_amount->closeCursor();
        echo "\n";

        $request_order_product="SELECT product_id,quantity,unit_price FROM `order_products` WHERE order_id = $id";
        $reponse_request_order_product=$bdd->query($request_order_product);
        ?>
            <?php
            while($order_product = $reponse_request_order_product->fetch())
            {
                $quantity=$order_product['quantity'];
                $product_id=$order_product['product_id'];
                $prix_prod=$order_product['unit_price'];
                $request_name_product="SELECT name FROM products WHERE id =$product_id";
                $reponse_request_name_product=$bdd->query($request_name_product);
                $rep_name= $reponse_request_name_product->fetch();
                $name_product=$rep_name['name'];
                $reponse_request_name_product->closeCursor();
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
            <?php
            }
        $reponse_request_order_product->closeCursor();
    }
 ?>

<?php 
if(empty($id))
{}

else {
?>
    <div class="payer">
        <div id="recap_commande">
            <h1>Total : <?php echo $amount['amount'] ?> €</h1>
        </div>
        <form id="commander" method="post">

                <input type="hidden" name="commande" value="go"/>
                <input type="submit" value="Commander" />
             
        </form>
<?php 
}
?>

                </body>
        </section>
</html>

<!DOCTYPE html>

<html>

<?php include 'myHeaderLigne.php'?>
<head>
    <link rel="stylesheet" href="style.css" />
    <title>Capsules.com</title>
    <b><font size="+3">Votre Panier:</font><b>
</head>  

<?php
        $UsID=$_SESSION['id'];/*$_GET['user'];*/
        $request="SELECT * FROM orders WHERE `type`='CART' AND user_id='" . $UsID . "'";
        $reponseorder=$bdd->query($request);
        while($datareponse=$reponseorder->fetch()){
            $id=$datareponse['id'];
        }

        if(empty($id))
        {
            echo "panier vide";
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
            while($order_product = $reponse_request_order_product->fetch())
            {
                $quantity=$order_product['quantity'];
                $product_id=$order_product['product_id'];
                $prix_prod=$order_product['unit_price'];
                ?>
                <body>
                <a href="product_descri.php?id=<?php echo $product_id; ?>">
                <div id="monpanier">
                    <div class="image_produit">
                    <?php 
                        echo '<img src="Images/'.$product_id.'"width="100%">';
                    ?>
                    </div>
                    <div class="info_produit">
                        <table>
                            <thead><tr>
                                <th>
                                    id produit: <?php echo $product_id ?>
                                </th>
                            </tr></thead>
                            <tbody><tr>
                                <td>
                                    prix: <?php echo $prix_prod?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    nb de produits: <?php echo $quantity ?>
                                </td>
                            </tr></tbody>
                        </table>    
                    </div>
                </div>
                </a><br>
                </body>
            <?php
            }
        }
 ?>  

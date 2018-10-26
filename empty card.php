<!DOCTYPE html>

<html>

<?php include 'myHeaderLigne.php'?>
<head>
    <link rel="stylesheet" href="style.css" />
    <title>Capsules.com</title>
</head>  
<h1>Votre Panier:</h1>
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
                                 echo '<img src="Images/'.$product_id.'"width="100%">';
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
                                        </td>
                                    </tr></tbody>
                                </table>    
                            </div>
                        </a>
                    </div>
                </body>
            <?php
            }
        $reponse_request_order_product->closeCursor();
    }
 ?>  
<?php 
if(empty($id))
{
 
}
else
{
?>
    <div class="payer">
    <?php 
    if(isset( $_POST['commande']) )  {

    $bdd->exec("UPDATE orders set type = 'ORDER' where type = 'CART' AND user_id=$UsID");
    $bdd->exec("UPDATE orders set `status` = 'BILLED' where `status` = 'CART' AND user_id=$UsID");
    
        
    }
    ?>
        <form id="comander" method="post">
            <div id="hide"> <input type="text" name="commande" value="go"/> </div>
            <input type="submit" value="Commander" />
        </form>
<div/>
<?php 
}
?>


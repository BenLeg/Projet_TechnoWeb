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

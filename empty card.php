<!DOCTYPE html>

<html>
<?php include 'myHeaderLigne.php'?>  

<?php
        $UsID=1;/*$_GET['user'];*/
        $request="SELECT * FROM orders WHERE `type`='CART' AND user_id='" . $UsID . "'";
        $reponseorder=$bdd->query($request);
        while($datareponse=$reponseorder->fetch()){
            $id=$datareponse['id'];
           

        } 

        if(empty($id)==true){
            $verifpanier=false;
        }
        if(empty($id)==false){
            $request_amount="SELECT amount FROM `orders` WHERE id=$id";
            $reponse_request_amount=$bdd->query($request_amount);
            $amount=$reponse_request_amount->fetch();
            $prix=$amount['amount'];
            $request_order_product="SELECT product_id,quantity FROM `order_products` WHERE order_id=$id";
            $reponse_request_order_product=$bdd->query($request_order_product);
            while($order_product=$reponse_request_order_product->fetch()){
                $quantity=$order_product['quantity'];
                $product_id=$order_product['product_id'];

                echo $product_id;


            }
            $reponse_request_amount->closeCursor();
            $reponse_request_order_product->closeCursor();

            $verifpanier=true;


        }
       

    ?>

<head>
    <link rel="stylesheet" href="style.css" />
	<title>Capsules.com</title>
	<b><font size="+3">Votre Panier:</font><b>
    <?php if ($verifpanier==true) { ?>
	   <u><h3>Articles dans votre panier(<?php echo $quantity ?>)<h3></u>
    <?php } ?>
    <?php if ($verifpanier==false) { ?>
        <u><h3>Articles dans votre panier(0)<h3></u>
    <?php } ?>
</head>


<?php if ($verifpanier==true) { ?>
    <body>
        <?php 
        $request_order_product="SELECT product_id,quantity FROM `order_products` WHERE order_id=$id";
        $reponse_request_order_product=$bdd->query($request_order_product);
        while($order_product=$reponse_request_order_product->fetch()){
            $product_id=$order_product['product_id'];
            ?>
            <a href="product_descri.php?id=<?php echo $product_id;?>">
                <div id="paniervide">
           
                    <div id=article1>
            
                        <div class="element">
                            <img src="photo.png">
                        </div>
                        <div class="element1">
                            <table>
                                <thead><tr>
                                   <th>
                                      id produit: <?php echo $product_id ?>
                                   </th>
                                </tr></thead>
                                <tbody><tr>
                                   <td>
                                    prix: <?php echo $prix ?>
                                   </td>
                                </tr>
                                <tr>
                                   <td>
                                      nb de produits:1
                                   </td>
                                </tr></tbody>
                            </table>   
                        </div>
                
                    </div>
                <br>
            </div>
        </a>
        <?php 
    }
    ?>
        



       <a href="search_p.php">Retour vers la boutique</a>


    </body>

<?php } ?>
<?php if ($verifpanier==false) { ?>
    <body>
        Votre panier est vide :(<br><br>
        <a href="search_p.php">Retour vers la boutique</a>
    </body>
<?php } ?>

</html>
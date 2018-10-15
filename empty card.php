<?php 
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
	}
	catch(Exception $e){
		die('erreur:' .$e->getMessage());
	}

 ?>
<!DOCTYPE html>
<?php
$UsID=1;/*$_GET['user'];*/
$request="SELECT * FROM orders WHERE `type`='CART' AND user_id='" . $UsID . "'";
$reponseorder=$bdd->query($request);
while($datareponse=$reponseorder->fetch()){
	echo $datareponse['id'];
	echo "\n";
	$id=$datareponse['id'];

}
$request_amount="SELECT amount FROM `orders` WHERE id=$id";
$reponse_request_amount=$bdd->query($request_amount);
$amount=$reponse_request_amount->fetch();
echo $amount['amount'];
$prix=$amount['amount'];
echo "\n";

$request_order_product="SELECT product_id,quantity FROM `order_products` WHERE id=$id";
$reponse_request_order_product=$bdd->query($request_order_product);
$order_product=$reponse_request_order_product->fetch();
$quantity=$order_product['quantity'];
echo $quantity;
echo "\n";

$product_id=$order_product['product_id'];
echo $product_id






  ?>
<html>
<head>
<header>
	<link rel="stylesheet" href="css/head.css" />
        <h1>P'ISENLOVE</h1>  	<!-- -->
    </header>
	<title>boulanger.com</title>
	<b><font size="+3">Votre Panier:</font><b>
	<u><h3>Articles dans votre panier(<?php echo $quantity ?>)<h3></u>

</head>
<body>
	<div id="paniervide">
		<a href="https://www.google.fr/?gws_rd=ssl">
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
</a><br>

	<a href="mettrelaboutique.html">Retour vers la boutique</a>


</body>
</html>
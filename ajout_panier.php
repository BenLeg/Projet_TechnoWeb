<!DOCTYPE html>

<?php
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=capsules;charset=utf8', 'root', '');
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
?>

<html>
	<head>
		<title>Capsules.com</title>
		<link rel="stylesheet" href="product_css.css" />
	</head>

	<header>
        <h1>P'ISENLOVE</h1>  
    </header>
    <body>
        <?php
            $product_id = $_GET['id'];
            $quantity = $_POST['quantity'];

            $req = $bdd->query('SELECT ');
        ?>
        <section>
            <div id="cadre_princ">
                <div class="ajout">
                    <?php echo $quantity ?>
                    <h> Article(s) Ajouté(s) au panier <br></h>
                </div>
                <a href="search_p.php">
                    <div class="keep_shopping">
                        <h>Keep Shopping</h>
                    </div>
                </a>
                <a href="cart.php">
                    <div class="check_cart">
                        <h>Check Cart</h>
                    </div>
                </a>
            </div>
        </section>
    </body>
</html>

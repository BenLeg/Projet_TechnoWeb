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
        <aside>
            <div id="conteneur_aside">
                <div class ="element">
                    <h1>Filtres</h1>
                    <p>Blablabla<br>Blabla<br>BlablablaBla</p>
                </div>
            </div>
        </aside>

		<section>
            <h1>PRODUITS</h1>
            <p1>BlablablaBlablablaBlablablaBlablablaBlablablaBlablablaBlablablaBlablablaBlabla<br>blablablablablapisenlovelameilleurlisteblablabla</p1>
            <p2><br></p2>
            <div id="conteneur_principal">
            <?php
            $reponse = $bdd->query('SELECT * FROM products');

            $traitement_en_cours=true;
            while($traitement_en_cours)
            {             
                $donnees = $reponse->fetch();
                if($donnees==false)
                {
                    $traitement_en_cours=false;
                    break;
                }
                ?>
                    <div class="element">
                        <a href="product_descri.php?id=<?php echo $donnees['id']; ?>">
                            <figure>
                                <?php 
                                    $image=$donnees['id'];
                                    echo '<img src="Images/'.$image.'">';
                                ?>
                                <table>
                                    <thead><tr>
                                        <th><?php echo $donnees['name']; ?></th>
                                    </tr></thead>
                                    <tbody><tr>
                                       <td><?php echo $donnees['unit_price']; ?> €</td>
                                    </tr></tbody>
                                </table>
                            </figure>
                        </a>
                    </div>
            <?php                    
            }
            ?>
            </div>
    	</section>
    </body>
</html>

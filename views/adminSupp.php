<?php 

            $product_id = $_GET['id'];

            echo  $product_id ;
            echo '</br>';
    $UsID=$_SESSION['id'];  /*$_GET['user'];*/  
    if($a=="admin"){

            $product_id = $_GET['id'];
            $reponse = $bdd->prepare('SELECT * FROM products WHERE id = :id');
            $reponse->execute(array(
                'id'=>$product_id
            )); 
            $donnees = $reponse->fetch();
        $reponse = $bdd->query('SELECT * FROM products');

        $traitement_en_cours=true;
        while($traitement_en_cours)  {      

            $donnees = $reponse->fetch();
            if($donnees==false)  {
                $traitement_en_cours=false;
                break;
            }

    }

    else{	echo "vous n'êtes pas autorisé à effectuer cette action."}

?>
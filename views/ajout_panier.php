<!DOCTYPE html>

<html> 

    <body>
        <?php
            $id = $_GET['id'];
            $quantity = $_POST['quantity'].'';

            /*Si user no co*/
            if(empty($co)){
                ?>
                <div class="pasco">
                    <h>Avant d'ajouter vos articles dans votre panier :</h>
                    <a href="index.php?page=accueil">
                        <div id="log">
                            <h>Déjà client ?</h>
                            <p>Identifiez-vous</p>
                        </div>
                    <a href="index.php?page=inscription">
                        <div id="sign_in">
                            <h>Nouveau ?</h>
                            <p>Inscrivez-vous</p>
                        </div>
                    </a>
                </div>
            <?php 
            }

            /*si session utilisateur ouverte*/
            else{
                include 'actions/ajouterAuPanier.php'
            ?>
            <section>
                <div id="cadre_princ">
                    <div class="ajout">
                        <?php echo $quantity ?>
                        <h> Article(s) Ajouté(s) au panier <br></h>
                    </div>
                    <a href="index.php?page=liste_produits">
                        <div class="keep_shopping">
                            <h>Keep Shopping</h>
                        </div>
                    </a>
                    <a href="index.php?page=panier">
                        <div class="check_cart">
                            <h>Check Cart</h>
                        </div>
                    </a>
                </div>
            </section>
            <?php   
            }  
        ?>  
    </body>
</html>


<?php include 'produits_recents.php'?>
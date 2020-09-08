<?php
session_start();
set_time_limit(0);
if(isset($_GET)){
    require_once("../system/produit.class.php");
    $produit = new Produit();
    //if user posted data for login : 
    if(isset($_GET["ajout"])){

        $id = $produit->add($_POST['idf'],$_POST['label'],$_POST['prix_vente']);
        header("location:../../ajoutStock.php");

    }elseif(isset($_GET["liste"])){
        echo "liste";
    }
}

?>


<?php
session_start();
set_time_limit(0);
if(isset($_GET)){
    require_once("../system/stock.class.php");
    $stock = new Stock();
    //si lutilisateur ajut au stock  : 
    if(isset($_GET["ajout"])){
        print_r($_POST);
        require_once("../system/produit.class.php");
        $produit = new Produit();
        $idf = $produit->IDproduitToFornisseur($_POST['idp']); 
        $stock->add($_POST['idp'],$idf,$_POST['qte'],$_POST['prixachat'],$_POST['prixvente'],$_POST['prixtotal'],$_POST['montantpayee']);
        header("location:../../listeProduits.php");
    }
}

?>


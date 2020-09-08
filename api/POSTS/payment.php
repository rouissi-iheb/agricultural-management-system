<?php
session_start();
set_time_limit(0);
if(isset($_GET)){
    require_once("../system/payment.class.php");
    $payment = new Payment();
    //if user posted data for login : 
    if(isset($_GET["paymentClient"])){
        if(isset($_GET['ajout'])){
            $c = $payment->add($_POST["idc"],$_POST["idov"],$_POST["montant"]);
            header("location:../../recuPayment.php?ajoutfacilite&idc=".$_POST["idc"]."&montant=".urlencode($_POST["montant"])."&idov=".$_POST["idov"]);
        }
    }elseif(isset($_GET["paymentFornisseur"])){
        if(isset($_GET['ajout'])){
            require_once("../system/fornisseur.class.php");
            $fornisseur = new Fornisseur();
            $fornisseur->paymentFornisseur($_POST['id'],$_POST['montant']);
            header("location:../../listeFornisseurs.php");
        }
    }
}

?>


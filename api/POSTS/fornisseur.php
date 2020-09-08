<?php
session_start();
set_time_limit(0);
if(isset($_GET)){
    require_once("../system/fornisseur.class.php");
    $fornisseur = new Fornisseur();
    //if user posted data for login : 
    if(isset($_GET["ajout"])){
        $idFornisseur = $fornisseur->add($_POST["nomForn"],$_POST["adrsForn"],$_POST["telForn"]);
        header("location:../../ajoutStock.php");
    }elseif(isset($_GET["liste"])){
        echo "liste";
    }
}

?>


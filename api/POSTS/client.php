<?php
session_start();
set_time_limit(0);
if(isset($_GET)){
    require_once("../system/client.class.php");
    $client = new Client();
    //if user posted data for login : 
    if(isset($_GET["ajout"])){
        $idClient = $client->add($_POST["nomClient"],$_POST["prenomClient"],$_POST["adrsClient"],$_POST["telClient"]);
        header("location:../../listeClients.php");
    }if(isset($_GET["ajoutAncien"])){
        $idClient = $client->addOld($_POST["nomClient"],$_POST["prenomClient"],$_POST["adrsClient"],$_POST["telClient"],$_POST["mtp"],$_POST["mdp"],$_POST["ddp"]);
        header("location:../../listeClients.php");
    }
}

?>


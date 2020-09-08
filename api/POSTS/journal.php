<?php
session_start();
set_time_limit(0);
if(isset($_GET)){
    require_once("../system/journal.class.php");
    $journal = new Journal();
    if(isset($_GET["ajout"])){
        $idov = $journal->add($_POST["type"],$_POST["idc"],$_POST["listeidp"],$_POST["listeqte"],$_POST["prixtotal"],$_POST["montantpayee"],$_POST["tva"],$_POST["ddp"]);
        if($_POST["type"] == "Facilite"){
            echo '
            <script>
                window.onload = function(){
                    window.open("../../recuPayment.php?ajoutfacilite&idc='.$_POST["idc"].'&idov='.$idov.'&montant='.$_POST["montantpayee"].'", "_blank"); // will open new tab on window.onload
					setTimeout(function(){window.location = "journal.php?redirect";},200);
                }
            </script>
            ';
        }else{
            header("location:../../listeJournal.php");
        }
        //header("location:../../listeJournal.php");
    }elseif (isset($_GET["getPrix"])) {
        $idp=$_GET['idp'];
        echo $journal->getPrix($idp); 
    }elseif (isset($_GET["getMaxQte"])) {
        $idp=$_GET['idp'];
        echo $journal->getMaxQte($idp); 
    }elseif (isset($_GET["redirect"])) {
        header("location:../../listeJournal.php");
    }elseif (isset($_GET["getMontant"])) {
        $date = $_GET["date"];
        echo $journal->getMontantTotalByDate($date);
    }elseif (isset($_GET["update"])) {
        
        $rendre = $journal->update($_POST["idjournal"],$_POST["idp"],$_POST["qte"]);
        echo '
            <script>
                window.onload = function(){
                    alert("le total a rendre pour ce client est : " + '.$rendre.');
                    window.open("../../listeJournal.php"); // will open new tab on window.onload
                }
            </script>';
    }

}

?>
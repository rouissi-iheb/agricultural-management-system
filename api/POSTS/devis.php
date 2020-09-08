<?php
session_start();
set_time_limit(0);
    require_once("../system/journal.class.php");
    $journal = new Journal();
    echo '
    <script>
        window.onload = function(){
            window.open("../../devisImpr.php?idc='.urlencode($_POST["idc"]).'&idp='.urlencode($_POST["listeidp"]).'&qte='.urlencode($_POST["listeqte"]).'&tva='.urlencode($_POST["tva"]).'&prixtotal='.urlencode($_POST["prixtotal"]).'", "_blank"); // will open new tab on window.onload
            setTimeout(function(){window.location = "journal.php?redirect";},200);
        }
    </script>
    ';

?>
<?php
session_start();
set_time_limit(0);
require_once("api/system/admin.class.php");
$admin = new Admin();
if(!$admin->checkLogin()){
    header("location:login.php");
    exit();
}else{
    $ht=0;
    $idc = urldecode($_GET["idc"]);
    $listeidp = urldecode($_GET["idp"]);
    $listeqte = urldecode($_GET["qte"]);
    $tva = urldecode($_GET["tva"]);
    $prixtotale = urldecode($_GET["prixtotal"]);
    require_once("api/system/journal.class.php"); 
    $journal = new Journal();
    echo '

        
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title> Devis</title>
		<link href="style/css/bootstrap.min.css" rel="stylesheet">
		<link href="style/css/font-awesome.min.css" rel="stylesheet">
		<link href="style/css/datepicker3.css" rel="stylesheet">
		<link href="style/css/styles.css" rel="stylesheet">
		<!--Theme-->
		<link href="style/css/theme-default.css" rel="stylesheet">
		<!--Custom Font-->
		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->
				<style>
		.cc{
			 background-image:url(style/images/9.png)  !important;
			 background-position: center !important;
			 background-repeat: no-repeat!important;
			 background-size: contain !important;
			 	}
		
		
		@media print {
		html, body {
   width: 210mm;
   height: 297mm;
 -webkit-print-color-adjust: exact;
          
                     }
        @page {
               size:A4 ;
              margin: 0 auto;
			  
}
    -webkit-print-color-adjust: exact;
}
.dd{ 
position:right-side  !important;

}
		</style>
	</head>
  <body>
    <div class="container cc" >
      <div class="row">
       
		<table>
			<tr>
				<td>
					<img src="style/images/7.png" height="80px" width="120px">
				</td>
				<td>
				Magasin de Fournitures de l\'agriculter à Nouail<br>
				لوازم الفلاح بنويل
								</td>
			</tr>
		</table>
		 
     
      </div>
	  <hr>
      <div class="row">
        <div class="col-sm-12">
		          <label class="top-right">Date :</label>'."20".date("y-m-d").'
          <center><h2>Devis<h2></center>
          <br>
        </div>
      </div>
      ';
      if($idc !=""){
        echo '
        <div class="row">
            <div class="col-sm-6">
		        <label>Nom de Client:</label> '.$idc.'
            </div>
        </div>
        ';
      }
      
      echo '
      <div class="row">
        <div class="col-sm-8">
          <table class="table border" >
            <tr>
			  <td><b>N°</b></td>
              <td><b>Produit</b></td>
              <td><b>Quantite</b></td>
			  <td><b>Prix</b></td>
			  <td><b>Total</b></td>
            </tr>
            ';
            $lp = explode("|",$listeidp);
            $lq = explode("|",$listeqte);
            $long = count($lp) - 1;
            for($i=0;$i<$long;$i++){
                echo '
                <tr>
			        <td>'.floatval($i+1).'</td>
                    <td>'.$journal->getProduit($lp[$i])["label"] . ' </td>
                    <td>'.$lq[$i].'</td>
			        <td>'.$journal->getProduit($lp[$i])["prix_vente"].'</td>
			        <td>'.floatval($journal->getProduit($lp[$i])["prix_vente"]) * $lq[$i].'</td> 
                </tr>
                ';
                $ht = $ht + (floatval($journal->getProduit($lp[$i])["prix_vente"]) * $lq[$i]);
            }
            echo '
          </table>
        </div>
        
      </div>
        <div class="col-sm-4 ">
          <table class="table">
            <tr>
              <td style="text-align:right"><p>
              <label>HT:</label>'.$ht.' DT<br>
              
              ';
                if($tva == '1'){
                    echo '<label>TVA:</label> 0 DT <br>';
                }else{
                    $tva = floatval($tva) * $ht;//oum li bch nzidouuh 
                    echo '<label>TVA:</label>'.$tva.' DT <br>';
                }
                $s = floatval($tva) + floatval($ht);

              echo '
			  
			  <label>TTC:</label>'.$s.' DT<br>
			  </p></td>

                
                          </tr>
          </table>
		  <br><br><br><br>
        </div>
      
      <br><br><br><br>
     <div class="row">
        <div class="col-sm-12">
          <hr>
          <p>
            <small><small><center>
            Bienvenue au magasin spécialisé dans les fournitures agriculture
à  Nouail,Douz,Kebili 4222<br>Tel: 97 37 07 81
          </center></small></small>
          </p>
          <hr>
        </div>
      </div>
    </div>
    <script>
    window.print();
  </script>
  </body>
</html>
        ';
}


?>
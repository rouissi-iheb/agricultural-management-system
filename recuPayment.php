<?php
session_start();
set_time_limit(0);
require_once("api/system/admin.class.php");
$admin = new Admin();
if(!$admin->checkLogin()){
    header("location:login.php");
    exit();
}else{
    if(isset($_GET['ajoutfacilite'])){
        $idc = $_GET['idc'];
        $idov = $_GET['idov'];
        $montant = urldecode($_GET['montant']);
        require_once("api/system/client.class.php");
        $c = new Client();
        $nom = $c->showData($idc)["nom"]." ".$c->showData($idc)["prenom"];
        echo '
        <!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title> Details Client</title>
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
   width: 148mm;
   height: 210mm;
 -webkit-print-color-adjust: exact;
          
                     }
        @page {
               size:A5 ;
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
    <div class="container cc  ">
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
			<center>
			<p>

				<h1>Reçue De Paiement</h1>
			</p>
			</center>
		</div>
	  </div>
      <div class="row">
        <div class="col-sm-12">
          <center>IDC:'.$idc.' | IDOV : '.$idov.'</center>
          
        </div>
      </div>
	  <div class="row">
        <div class="col-sm-8">
          <table class="table " >
            <tr>
              <td>
                <p>
                  <h4><b>Nom du client : </b>'.$nom.'</h4 >
				  <h4><b>La somme de  :</b> '.$montant.' DT</h4 >
				  <h4><b>pour  :</b> solde de la commande '.$idov.' </h4 >
                 <h4><b>Date :</b> 20'.date("y-m-d").' </h3 >
                </p>
              </td>
            </tr>
          </table>
        </div>
      </div>
	   <div class="row">
	   <div class="col-sm-8 ">
	   <br>
	   <br>
	   
	     

	   
	   
	   </div>
        <div class="col-sm-4 ">
          <table class="table">
            <tr>
              <td style="text-align:right">
                <p>
                  <b>Date et Signature </b><br><br>
				  Fait  à Nouail,le 20'.date("y-m-d").'<br>
				  <small>mehdi jaber /Gérant</small>
				  <br><br>
                </p>
              </td>
            </tr>
          </table>
		  <br><br><br><br>
        </div>
      </div>
      <br><br><br><br>
      <div class="row">
        <div class="col-sm-12">
          <hr>
          <p>
            <small><small><center>
              Nouail,Douz,Kebili 4222
          </center></small></small>
          </p>
          <hr>
        </div>
      </div>
    </div>
  </body>
    </body>
    <script>
    window.print();
  </script>
</html>

        ';
    }
}


?>
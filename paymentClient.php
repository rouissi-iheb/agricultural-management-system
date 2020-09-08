<?php
session_start();
set_time_limit(0);
error_reporting(0);
require_once("api/system/admin.class.php");
$admin = new Admin();
if(!$admin->checkLogin()){
    header("location:login.php");
    exit();
}else{
    require_once("api/system/client.class.php");
    $client   = new Client();
    $idClient = $_GET["id"];
    $detaillesClients = $client->showData($idClient);



    echo '
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title> Payement client</title>
            <link href="style/css/bootstrap.min.css" rel="stylesheet">
            <link href="style/css/font-awesome.min.css" rel="stylesheet">
            <link href="style/css/datepicker3.css" rel="stylesheet">
            <link href="style/css/styles.css" rel="stylesheet">

            <!--Theme-->
            <link href="style/css/theme-default.css" rel="stylesheet">

            <!--Custom Font-->


            <!--[if lt IE 9]>
            <script src="style/js/html5shiv.js"></script>
            <script src="style/js/respond.min.js"></script>
            <![endif]-->
        </head>
        <body>
            <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span></button>
                        <a class="navbar-brand" href="#"><span>Le magasin de fournitures de l\'agriculteur</span>Admin</a>
                         <span class="nav navbar-brand navbar-right digital-clock" name"date"> 00:00:00</span>
                    </div>

                </div><!-- /.container-fluid -->
            </nav>
        <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
          <div class="profile-sidebar">
            <div class="profile-userpic">
              <img src="style/images/7.jpg" width="50" class="img-responsive" alt="">
            </div>
            <div class="profile-usertitle">
              <div class="profile-usertitle-name">Mehdi Jaber</div>
              <div class="profile-usertitle-status"><span class="indicator label-success"></span>En ligne</div>
            </div>
            <div class="clear"></div>
          </div>
          <div class="divider"></div>

          ';
          include('menu.php');
          echo '
		</div><!--/.sidebar-->


		<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
			<div class="row">
				<ol class="breadcrumb">
					<li><a href="#">
						<em class="fa fa-home"></em>
					</a></li>
					<li class="active">Paiement de Client</li>
				</ol>
			</div><!--/.row-->

			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Paiement de Client</h1>
				</div>
			</div><!--/.row-->
            <div class="row">
	            <div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-body">
                                <b>Nom Client</b> :  '.$detaillesClients["nom"].'<br>
                                <b>Prenom Client</b> :  '.$detaillesClients["prenom"].'<br>
                                <b>Adresse Client</b> :  '.$detaillesClients["adresse"].'<br>
                                <b>Telephone Client</b> : '.$detaillesClients["telephone"].' <br>
							</div>
						</div>
                    </div>


                    <div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-body">
                                <table class="table">
                                <tr>
                                <th>numero du commande</th>
                                <th>date de commande</th>
                                <th>produit</th>
                                <th>qte</th>
                                <th>Totale Facture</th>
                                <th>totale recue</th>
                                <th>reste totale</th>
                                <th>montant a payer</th>
                                <th>action</th>
                            </tr>
                            ';
                            require_once("api/system/payment.class.php");
                            $payment  = new Payment();
                            $tableau = $payment->detaillesNonPayee($idClient);
                            echo $tableau;

                            echo'
                                </table>
							</div>
						</div>
					</div>
			</div><!-- /.row -->
			<div class="col-sm-12">
				<p class="back-link">© Copyright Rouissi&Benali  </p>
			</div>
		</div><!--/.main-->
        <script>
        function verif(form,id){
            var max = Number(document.getElementById(id).value);
            var inp = Number(document.getElementById(form).value);
            if(inp > max ){	
                    
                alert("la valeur a payer ne doit pas depassé " + max);
                return false;	
            }
            if(Number(inp) <= 0 ){	
                alert("valeur ne doit pas etre negative");
                return false;	
            }else{
                return true;
            }
        }
        </script>
		        <script src="style/js/jquery-1.11.1.min.js"></script>
				<script src="style/js/bootstrap.min.js"></script>
				<script src="style/js/chart.min.js"></script>
				<script src="style/js/chart-data.js"></script>
				<script src="style/js/easypiechart.js"></script>
				<script src="style/js/easypiechart-data.js"></script>
				<script src="style/js/bootstrap-datepicker.js"></script>
				<script src="style/js/bootstrap-table.js"></script>
				<script src="style/js/custom.js"></script>
            <script src="style/js/clock.js"></script>
	</body>
</html>

    ';
}


?>

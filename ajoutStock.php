<?php
session_start();
set_time_limit(0);
require_once("api/system/admin.class.php");
$admin = new Admin();
if(!$admin->checkLogin()){
    header("location:login.php");
    exit();
}else{
	require_once("api/system/produit.class.php");
	require_once("api/system/fornisseur.class.php");
	$produit    = new Produit();
	$fornisseur = new Fornisseur();

	echo '
  <!DOCTYPE html>
  <html>
      <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <title> Ajouter Stock</title>
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
					<li class="active">Ajouter au Stock</li>
				</ol>
			</div><!--/.row-->

			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Ajouter au Stock</h1>
				</div>
			</div><!--/.row-->

			<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading clearfix">Saisir les  données suivantes:</div>
								<div class="panel-body">
									<form class="form-horizontal row-border"  method = "POST" action="api/POSTS/stock.php?ajout">
										<div class="form-group">
											<label class="col-md-2 control-label">Nom de Produit:</label>
												<div class="col-md-4">
													<select name="idp" class="form-control input-sm">
														';
														$produit->getProductsSelectList();
														echo '
													</select>
												</div>
												<div class="col-md-4">
												<a href="ajoutProduit.php" class="fa fa-plus btn btn-sm btn-default" > Ajouter Porduit</a>
												</div>
										</div>
										
                     					<div id="blocs">
										<div class="form-group">
											<label class="col-md-2 control-label">Quantite:</label>
											<div class="col-md-4 " >
												<input class="input-sm"type="number" name="qte"  id="qte" onBlur="calcul()" class="form-control" placeholder="Quantite de Produit">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label">Prix d\'Achat:</label>
											<div class="col-md-4 " >
												<input class="input-sm"type="text" name="prixachat" id="prixachat"  onChange="calcul()" class="form-control" placeholder="Prix d\'Achat en DT"    >
											</div>
										</div>
<div class="form-group">
											<label class="col-md-2 control-label">Prix de vente:</label>
											<div class="col-md-4 " >
												<input class="input-sm"type="text" name="prixvente"  class="form-control" placeholder="Prix de vente en DT"    >
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label">Total:</label>
											<div class="col-md-4 " >
												<input class="input-sm"type="text" name="prixtotal" id="prixtotal" class="form-control" placeholder="Total" readonly="true">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label">Montant Payé:</label>
											<div class="col-md-4 " >
												<input class="input-sm"type="text" name="montantpayee" class="form-control" placeholder="Montant Payé">
											</div>
										</div>

										<div class="form-group col-md-20 ">
											<div class="col-md-10">
												<button  class="btn btn-ls btn-primary  " type="reset"><span class="fa fa-times"></span> &nbsp;Annuler</button>
													<button  class="btn btn-ls btn-primary  " onclick="return verif()" type="submit"><span class="fa fa-cart-plus"></span> &nbsp;Ajouter au Stock</button>

														</div>
													</div>
												</div>
												</div>
																</form>
															</div>
															</div>
														</div>
			</div><!-- /.row -->
			<div class="col-sm-12">
				<p class="back-link">© Copyright Rouissi&Benali  </p>
			</div>
		</div><!--/.main-->
		<script>
		function verif(){
			var msg = "vouler vous continuer ?";
			if(confirm(msg)){
				return true;
			}else{
				return false;
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
		<script src="style/js/custom.js"></script>
   <script src="style/js/clock.js"></script>
    <script src="style/js/calculTotal.js"></script>
	</body>
</html>

    ';
}


?>

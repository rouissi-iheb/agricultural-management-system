<?php
session_start();
set_time_limit(0);
require_once("api/system/admin.class.php");
$admin = new Admin();
if(!$admin->checkLogin()){
    header("location:login.php");
    exit();
}else{

    echo '
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title> Ajouter Journal</title>
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
					<li class="active">Ajouter au Journal</li>
				</ol>
			</div><!--/.row-->

			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Ajouter au Journal</h1>
				</div>
			</div><!--/.row-->


			<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading clearfix">Saisir les  données suivantes:</div>
								<div class="panel-body">
									<form class="form-horizontal row-border" name="form1" action="api/POSTS/journal.php?ajout" method="POST">
										<div class="form-group">
											<label class="col-md-2 control-label">Type de Vente:</label>
												<div class="col-md-4">
													<input type="radio"  name="type" value="Normal" class="checkboxN" required>Normal <input type="radio" class="checkboxF"  name="type" value="Facilite" required>Facilite
												</div>
																											</div>
                                                      <hr>
										<div class="form-group">
											<label class="col-md-2 control-label">Nom de Produit:</label>
												<div class="col-md-2 ">
													<select name="idp" onchange="SetValues()" class="form-control input-sm" required>
														<option value=""></option>
														';
														require_once("api/system/produit.class.php");
														$p = new Produit();
														echo $p->getProductsSelectList();
														echo '
													</select>
												</div>
												<div class="col-md-2">
												<a onclick="return addProduct()" class="fa fa-plus btn btn-sm btn-default">  </a>
												</div>
													</div>

												<div class="form-group">
											<label class="col-md-2 control-label">Quantite:</label>
											<div class="col-md-2 " >
												<input class="input-sm" type="number" name="qte" class="form-control"  placeholder="Quantite de Produit" required>
											</div>
										</div>
										<input type="text" hidden name="qtemax">

										<input type="text" hidden name="listeidp">
										<input type="text" hidden name="listeqte">

										<div class="form-group">
											<label class="col-md-2 control-label">Prix :</label>
											<div class="col-md-2 " >
												<input class="input-sm"type="text"  name="prixv" class="form-control" placeholder="Prix en Dt" readOnly="true" required>
											</div>
										</div>
										<div class="field_wrapper">
										</div>
										<hr>
											<table class="table" id="items">
												<tr>
													<th> Produit </th>
													<th> Quantité </th>
													<th> Prix Unitaire </th>
													<th> Prix Totale </th>
												</tr>
												
												
											</table>
										<hr>
										<div class="form-group">
										<label class="col-md-2 control-label">TVA:</label>
										  <div class="col-md-2">
											<select onchange="changeTVA()" name="tva" class="form-control input-sm"  >
											  <option value="1">0%</option>
												<option value="0.19">19%</option>
											</select >
										  </div>
											</div>
										<div class="form-group">
                    											<label class="col-md-2 control-label">Total:</label>
											<div class="col-md-2 " >
												<input class="input-sm"type="text" name="prixtotal" class="form-control" placeholder="Total" readOnly="true">
												<input type="text" name="pxt" hidden>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label">Nom de Client:</label>
											<div class="col-md-2">
												<select name="idc" class="form-control input-sm para" disabled > <option> </option>

													';
													require_once("api/system/client.class.php");
													$c= new client();
													$c->showSelectList();
													echo '
												</select >
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-2 control-label">Montant Payé:</label>
											<div class="col-md-2 " >
												<input type="text" name="montantpayee" class="form-control input-sm" placeholder="Montant Payé" >
											</div>
										</div>
<div class="form-group  ">
                                                <label class="col-md-2 control-label">Dernier date de journal</label>
                                                <div class="col-md-2	">
                                                    <input class="form-control input-sm" type="date" name="ddp"  required>
                                                </div>
                                            </div>
										<div class="form-group col-md-20 ">
											<div class="col-md-10">
												<button  class="btn btn-ls btn-primary  " type="reset"><span class="fa fa-times"></span> &nbsp;Annuler</button>
													<button  class="btn btn-ls btn-primary  " onclick="return verif()" type="submit"><span class="fa fa-cart-plus"></span> &nbsp;Ajouter au Journal</button>

														</div>
													</div>


												</div>
																</form>
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
	  <script src="style/js/ajoutJornal.js"></script>
	</body>
</html>
    ';
}




?>

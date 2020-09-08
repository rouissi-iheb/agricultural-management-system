<?php
session_start();
set_time_limit(0);
require_once("api/system/admin.class.php");
$admin = new Admin();
if(!$admin->checkLogin()){
    header("location:login.php");
    exit();
}else{
    require_once("api/system/fornisseur.class.php");
    $fornisseur = new Fornisseur();
    file_put_contents("JSON/fornisseur.json",json_encode($fornisseur->liste()));

    echo '

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title> Liste des Fournisseurs</title>
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
                        <li class="active">Liste des fornisseurs</li>
                    </ol>
                </div><!--/.row-->

                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Liste des fornisseurs</h1>
                    </div>
                </div><!--/.row-->
    <div class="row">
        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <table data-toggle="table" id="table" data-url="JSON/fornisseur.json" data-show-export="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="reste" data-sort-order="desc">
                                        <thead>
                                            <tr>
                                                <th data-field="id" data-sortable="true">ID</th>
                                                <th data-field="nom"  data-sortable="true">Nom</th>
                                                <th data-field="adresse" data-sortable="true">Adresse</th>
                                                <th data-field="telephone" data-sortable="true">Telephone</th>
                                                <th data-field="reste" data-sortable="true">reste a payée</th>
                                                <th data-field="action" >Action</th>
                                            </tr>
                                            </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                </div><!-- /.row -->
                <div class="col-sm-12">
                    <p class="back-link">© Copyright Rouissi&Benali  </p>
                </div>
            </div><!--/.main-->

            <script src="style/js/jquery-1.11.1.min.js"></script>
                    <script src="style/js/bootstrap.min.js"></script>
                    <script src="style/js/chart.min.js"></script>
                    <script src="style/js/chart-data.js"></script>
                    <script src="style/js/easypiechart.js"></script>
                    <script src="style/js/easypiechart-data.js"></script>
                    <script src="style/js/bootstrap-datepicker.js"></script>
                    <script src="style/js/bootstrap-table.js"></script>
                    <script src="style/js/custom.js"></script>
                    <script src="style/js/tableExport.min.js"></script>
                    <script src="style/js/bootstrap-table-export.min.js"></script>
                    <script src="style/js/bootstrap-table-locale-all.min.js"></script>
                    <script src="style/js/bootstrap-table.min.js"></script>
                      <script src="style/js/clock.js"></script>
        </body>
    </html>

    ';
}


?>

<?php
session_start();
set_time_limit(0);
require_once("api/system/admin.class.php");
$admin = new Admin();
if(!$admin->checkLogin()){
    header("location:login.php");
    exit();
}else{
    require_once("api/system/stats.class.php");
    $stats = new Stats();


    echo '<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title> Tableau de bord</title>
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
                        <li class="active"> Tableau de bord</li>
                    </ol>
                </div><!--/.row-->

                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"> Tableau de bord</h1>
                    </div>
                </div><!--/.row-->

                <div class="panel panel-container">
                    <div class="row">
                        <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                            <div class="panel panel-teal panel-widget border-right">
                                <div class="row no-padding"><em class="fa fa-xl fa-shopping-cart color-blue"></em>
                                    <div class="large">'.$stats->OrdreDeJour().'</div>
                                    <div class="text-muted">Ordres du jour</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                            <div class="panel panel-blue panel-widget border-right">
                                <div class="row no-padding"><em class="fa fa-building color-orange"></em>
                                    <div class="large">'.$stats->TotalFornisseurs().'</div>
                                    <div class="text-muted">Fournisseurs</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                            <div class="panel panel-orange panel-widget border-right">
                                <div class="row no-padding"><em class="fa fa-xl fa-users color-teal"></em>
                                    <div class="large">'.$stats->TotalClients().'</div>
                                    <div class="text-muted">Clients</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-3 col-lg-3 no-padding">
                            <div class="panel panel-red panel-widget ">
                                <div class="row no-padding"><em class="fa fa-xl fa-server color-red"></em>
                                    <div class="large">'.$stats->TotaleStock().'</div>
                                    <div class="text-muted">Total Stock </div>
                                </div>
                            </div>
                        </div>
                    </div><!--/.row-->
                </div>
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="panel panel-info ">
                            <div class="panel-heading " >

                                Bienvenue
                            <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                            <div class="panel-body ">
                                <div class="canvas-wrapper ">
                                <img src="style/images/7.jpg"  class="col-xs-4 col-sm-10 col-md-2 portfolio-item"/>
                                <h2 class="col-xs-8 col-sm-0  ">Bienvenue à magasin de fournitures de l\'agriculteur</h2>

                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.row-->
                <div class="row">
                    <div class="col-md-4 ">
                        <div class="panel panel-info ">
                            <div class="panel-heading " >
                                Calendrier
                                <span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
                                <div class="panel-body ">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.row-->
                </div><!--/.row-->
                <div class="col-sm-12">
                    <p class="back-link">© Copyright Rouissi&Benali  </p>
                </div>
            </div>	<!--/.main-->
            <script src="style/js/jquery-1.11.1.min.js"></script>
            <script src="style/js/bootstrap.min.js"></script>
            <script src="style/js/chart.min.js"></script>
            <script src="style/js/chart-data.js"></script>
            <script src="style/js/easypiechart.js"></script>
            <script src="style/js/easypiechart-data.js"></script>
            <script src="style/js/bootstrap-datepicker.js"></script>
            <script src="style/js/custom.js"></script>
              <script src="style/js/clock.js"></script>
        </body>
    </html>
    ';
}




?>

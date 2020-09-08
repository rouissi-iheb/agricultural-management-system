<?php
session_start();
set_time_limit(0);
error_reporting(0);
require_once("api/system/admin.class.php");
$admin = new Admin();
if($admin->checkLogin()){
    header("location:index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link href="style/css/bootstrap.min.css" rel="stylesheet">
	<link href="style/css/datepicker3.css" rel="stylesheet">
	<link href="style/css/styles.css" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">S'identifier</div>
				<div class="panel-body">
					<form role="form" method="POST" action="api/POSTS/admin.php?login">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Login" name="username" type="Login" autofocus="">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="password" name="password" type="password" value="">
							</div>
							<button type="submit" class="btn btn-primary">Connecte</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->


<script src="style/js/jquery-1.11.1.min.js"></script>
	<script src="style/js/bootstrap.min.js"></script>
</body>
</html>

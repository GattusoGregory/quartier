<?php include_once("../functions.php"); ?>
<?php include_once("includes/admin_functions.php"); ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?= getWebsiteTitle() ?></title>
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.css"/>
		<link rel="stylesheet" href="../CSS/globals.css"/>
		<link rel="stylesheet" href="../font-awesome/css/font-awesome.css"/>
		<link rel="stylesheet" href="CSS/auth.css"/>

		<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
		<script src="../bootstrap/js/bootstrap.js"></script>
	</head>

	<body>
		<div class="v-align">
			
			<?php
			
			if(isset($_POST["login"], $_POST["pass"]))
			{
				if(!authUser())
				{
			?>

			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>
				<span>Identifiant ou mot de passe invalide !</span>
			</div>

			<?php

				}
				else
				{
					header("location:dashboard.php");
				}
			}

			?>

			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Connexion au panneau d'administration</h3>
				</div>
				<div class="panel-body">
					<form class="form-horizontal" method="POST" action="">
						<div class="col-md-12">
							<div class="form-group">
								<label for="login">Identifiant : </label><input name="login" id="login" type="text" class="form-control" <?=isset($_POST["login"]) ? 'value="' . $_POST["login"] . '"' : ''?>/>
							</div>
							<div class="form-group">
								<label for="pass">Mot de passe : </label><input name="pass" id="pass" type="password" class="form-control"/>
							</div>
						</div>

						<div>
							<div class="col-md-12">
								<input type="submit" id="confirm" class="form-control btn btn-primary" value="Connexion"/>
								<a type="button" href="../index.php" class="margin-top form-control btn btn-primary">Retourner au site</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
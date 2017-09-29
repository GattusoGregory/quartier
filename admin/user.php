<?php include_once("../functions.php"); ?>
<?php include_once("includes/admin_functions.php"); ?>

<?php
	$subtitle = 'Utilisateurs';
?>

<?php
	if(isset($_POST['editUser_send']))
		$status = editUser();
		
	if(!isset($_GET['user']) || !userMailExists($_GET['user'])) header('location:users.php'); else $user = getUserInfos($_GET['user']);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?= getWebsiteTitle() ?> - <?= $subtitle ?></title>
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="../CSS/globals.css"/>
		<link rel="stylesheet" href="../font-awesome/css/font-awesome.css"/>
		<link rel="stylesheet" href="CSS/menu.css"/>
		<link rel="stylesheet" href="CSS/header.css"/>

		<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.js"></script>
		<script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="admin_functions.js"></script>
	</head>

	<body>

		<?php include_once("nav.php"); ?>

		<!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
		<div id="main">
			<?php include_once("header.php"); ?>
			<?php include_once("sign-out_modal.php"); ?>

			<div class="margin-100">

				<?php
					if(isset($_POST['editUser_send']))
					{
						if($status == 'success')
						{
				?>

				<div class="alert alert-success alert-dismissable" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p><span class="bold">Action réussie !</span><br/>L'utilisateur '<?= $_GET['user'] ?>' a été modifié avec succès !</p>
				</div>

				<?php
						}
						else
						{
				?>

				<div class="alert alert-danger alert-dismissable" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p>
						<span class="bold">Echec de la modification</span><br/>
						L'utilisateur '<?= $_GET['user'] == $_POST['editUser_mail'] ? $_POST['editUser_mail'] : $_POST['editUser_mail'] . '/' . $_GET['user'] ?>' n'a pas pu être modifié :<br/>
						<?= $status ?>
					</p>
				</div>

				<?php
						}
					}
				?>
				<a href="users.php" class="btn btn-default"><i class="fa fa-users" aria-hidden="true"></i> Liste des utilisateurs</a>
				<a href="adduser.php" class="btn btn-default"><i class="fa fa-user-plus" aria-hidden="true"></i> Ajouter un utilisateur</a>
				<h1><i class="fa fa-user-circle-o" aria-hidden="true"></i> Edition d'un utilisateur</h1>

				<div class="panel panel-default">
					<div class="panel-heading panel-dashboard">
						<h3 class="panel-title">Formulaire de modification</h3>
					</div>

					<div class="panel-body">
						<form action="" method="POST">
							<fieldset>
								<legend>Champs requis</legend>
								<div class="col-md-6">
									<div class="form-group">
										<label for="editUser_mail">Adresse mail :</label>
										<input type="text" class="form-control" name="editUser_mail" id="editUser_mail" <?= 'value="' . $user['mail'] . '"' ?> oninput="enableOrDisableMailConfirmation();" required/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="editUser_username">Nom d'utilisateur :</label>
										<input type="text" class="form-control" name="editUser_username" id="editUser_username" <?= 'value="' . $user['username'] . '"' ?> required/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="editUser_password1">Changer mot de passe :</label>
										<input type="password" class="form-control" name="editUser_password1" id="editUser_password1" placeholder="Le mot de passe doit contenir au moins 8 caractères et 1 chiffre"/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="editUser_password2">Répéter nouveau mot de passe :</label>
										<input type="password" class="form-control" name="editUser_password2" id="editUser_password2"/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<div class="checkbox">
											<label><input type="radio" id="editUser_confirm_default" name="editUser_confirm" value="default" disabled checked> Renvoyer un mail de confirmation</label>
										</div>
										<div class="checkbox">
										<label><input type="radio" id="editUser_confirm_force" name="editUser_confirm" value="force" disabled> Laisser le compte valide</label>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="editUser_role">Rôle :</label>
										<select class="form-control" id="editUser_role" name="editUser_role">
											<?php
												$roles = getRoles();
												foreach ($roles as $role)
												{
											?>

											<option <?= $user['role'] == $role ? 'selected' : '' ?> value=<?= '"' . $role . '"' ?>><?= $role ?></option>

											<?php
												}
											?>
										</select>
									</div>
								</div>
							</fieldset>

							<fieldset>
								<legend>Champs facultatifs</legend>
								<div class="col-md-6">
									<div class="form-group">
										<label for="editUser_firstname">Prénom :</label>
										<input type="text" class="form-control" name="editUser_firstname" id="editUser_firstname" <?= 'value="' . $user['firstname'] . '"' ?>/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="editUser_name">Nom :</label>
										<input type="text" class="form-control" name="editUser_name" id="editUser_name" <?= 'value="' . $user['name'] . '"' ?>/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="editUser_adress1">Adresse 1 :</label>
										<input type="text" class="form-control" name="editUser_adress1" id="editUser_adress1" <?= 'value="' . $user['adress1'] . '"' ?>/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="editUser_adress2">Adresse 2 :</label>
										<input type="text" class="form-control" name="editUser_adress2" id="editUser_adress2" <?= 'value="' . $user['adress2'] . '"' ?>/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="editUser_city">Ville : </label>
										<input type="text" class="form-control" name="editUser_city" id="editUser_city" <?= 'value="' . $user['city'] . '"' ?>/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="editUser_cp">Code postal :</label>
										<input type="text" class="form-control" name="editUser_cp" id="editUser_cp" <?= 'value="' . $user['postalCode'] . '"' ?>/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="editUser_country">Pays :</label>
										<input type="text" class="form-control" name="editUser_country" id="editUser_country" <?= 'value="' . $user['country'] . '"' ?>/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="editUser_phone">Téléphone :</label>
										<input type="text" class="form-control" name="editUser_phone" id="editUser_phone" <?= 'value="' . $user['phone'] . '"' ?>/>
									</div>
								</div>
							</fieldset>
							<div class="col-md-12 text-right">
								<button class="btn btn-warning">Réinitialiser</button>
								<button class="btn btn-success" type="submit" name="editUser_send" value="editUser_send"><i class="fa fa-save"></i> Enregistrer</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php include_once("../functions.php"); ?>
<?php include_once("includes/admin_functions.php"); ?>

<?php
	$subtitle = 'Utilisateurs';
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
					if(isset($_POST['addUser_send']))
					{
						$status = addUserToDB();
						if($status == 'success')
						{
				?>

				<div class="alert alert-success alert-dismissable" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p><span class="bold">Action réussie !</span><br/>L'utilisateur '<?= $_POST['addUser_mail'] ?>' a été ajouté avec succès !</p>
				</div>

				<?php
						}
						else
						{
				?>

				<div class="alert alert-danger alert-dismissable" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p>
						<span class="bold">Echec de l'ajout</span><br/>
						L'utilisateur '<?= $_POST['addUser_mail'] ?>' n'a pas pu être ajouté :<br/>
						<?= $status ?>
					</p>
				</div>

				<?php
						}
					}
				?>

				<a href="users.php" class="btn btn-default"><i class="fa fa-users" aria-hidden="true"></i> Liste des utilisateurs</a>
				<h1><i class="fa fa-user-plus" aria-hidden="true"></i> Ajout d'un utilisateur</h1>

				<div class="panel panel-default">
					<div class="panel-heading panel-dashboard">
						<h3 class="panel-title">Formulaire de création</h3>
					</div>

					<div class="panel-body">
						<form action="" method="POST">
							<fieldset>
								<legend>Champs requis</legend>
								<div class="col-md-6">
									<div class="form-group">
										<label for="addUser_mail">Adresse mail :</label>
										<input type="email" class="form-control" name="addUser_mail" id="addUser_mail" <?= isset($_POST['addUser_mail']) ? 'value="' . $_POST['addUser_mail'] . '"' : '' ?> required/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="addUser_username">Nom d'utilisateur :</label>
										<input type="text" class="form-control" name="addUser_username" id="addUser_username" <?= isset($_POST['addUser_username']) ? 'value="' . $_POST['addUser_username'] . '"' : '' ?> required/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="addUser_password1">Mot de passe :</label>
										<input type="password" class="form-control" name="addUser_password1" id="addUser_password1" placeholder="Le mot de passe doit contenir au moins 8 caractères et 1 chiffre" required/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="addUser_password2">Répéter mot de passe :</label>
										<input type="password" class="form-control" name="addUser_password2" id="addUser_password2" required/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<div class="checkbox">
											<label><input type="radio" id="addUser_confirm_default" name="addUser_confirm" value="default" <?= (!isset($_POST['addUser_confirm']) || $_POST['addUser_confirm'] == 'default') ? 'checked' : '' ?>> Envoyer le mail de confirmation</label>
										</div>
										<div class="checkbox">
										<label><input type="radio" id="addUser_confirm_force" name="addUser_confirm" value="force" <?= (isset($_POST['addUser_confirm']) && $_POST['addUser_confirm'] == 'force') ? 'checked' : '' ?>> Forcer la confirmation du compte</label>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="addUser_role">Rôle :</label>
										<select class="form-control" id="addUser_role" name="addUser_role">
											<?php
												$roles = getRoles();
												foreach ($roles as $role)
												{
											?>

											<option value=<?= '"' . $role . '"' ?> <?= ((!isset($_POST['addUser_role']) && $role == 'Utilisateur') || (isset($_POST['addUser_role']) && $_POST['addUser_role'] == $role)) ? 'selected' : '' ?> ><?= $role ?></option>

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
										<label for="addUser_firstname">Prénom :</label>
										<input type="text" class="form-control" name="addUser_firstname" id="addUser_firstname" <?= isset($_POST['addUser_firstname']) ? 'value="' . $_POST['addUser_firstname'] . '"' :'' ?>/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="addUser_name">Nom :</label>
										<input type="text" class="form-control" name="addUser_name" id="addUser_name" <?= isset($_POST['addUser_name']) ? 'value="' . $_POST['addUser_name'] . '"' : '' ?>/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="addUser_adress1">Adresse 1 :</label>
										<input type="text" class="form-control" name="addUser_adress1" id="addUser_adress1" <?= isset($_POST['addUser_adress1']) ? 'value="' . $_POST['addUser_adress1'] . '"' : '' ?>/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="addUser_adress2">Adresse 2 :</label>
										<input type="text" class="form-control" name="addUser_adress2" id="addUser_adress2" <?= isset($_POST['addUser_adress2']) ? 'value="' . $_POST['addUser_adress2'] . '"' : '' ?>/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="addUser_city">Ville : </label>
										<input type="text" class="form-control" name="addUser_city" id="addUser_city" <?= isset($_POST['addUser_city']) ? 'value="' . $_POST['addUser_city'] . '"' : '' ?>/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="addUser_cp">Code postal :</label>
										<input type="text" class="form-control" name="addUser_cp" id="addUser_cp" <?= isset($_POST['addUser_cp']) ? 'value="' . $_POST['addUser_cp'] . '"' : '' ?>/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="addUser_country">Pays :</label>
										<input type="text" class="form-control" name="addUser_country" id="addUser_country" <?= isset($_POST['addUser_country']) ? 'value="' . $_POST['addUser_country'] . '"' : '' ?>/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="addUser_phone">Téléphone :</label>
										<input type="text" class="form-control" name="addUser_phone" id="addUser_phone" <?= isset($_POST['addUser_phone']) ? 'value="' . $_POST['addUser_phone'] . '"' : '' ?>/>
									</div>
								</div>
							</fieldset>
							<div class="col-md-12 text-right">
								<button class="btn btn-success" type="submit" name="addUser_send" value="addUser_send">Ajouter</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
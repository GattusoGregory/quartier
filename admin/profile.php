<?php
	session_start();

	include_once("../functions.php");
	include_once("includes/admin_functions.php");

	if(!isset($_SESSION['currentUser']['mail']) || !doesUserExist($_SESSION['currentUser']['mail']))
		header('location:login.php');
?>

<?php
	$subtitle = 'Profil';
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?= getWebsiteTitle() ?> - <?= $subtitle ?></title>
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.css"/>
		<link rel="stylesheet" href="../css/globals.css"/>
		<link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css"/>
		<link rel="stylesheet" href="css/menu.css"/>
		<link rel="stylesheet" href="css/header.css"/>

		<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
		<script src="../bootstrap/js/bootstrap.js"></script>
		<script src="js/admin_functions.js"></script>
	</head>

	<body>

		<?php include_once("nav.php"); ?>

		<!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
		<div id="main">
			<?php include_once("header.php"); ?>
			<?php include_once("sign-out_modal.php"); ?>

			<div class="margin-100">

				<?php
					if(isset($_POST['profile_submit']))
					{
						$status = editProfile();
						if($status == 'success')
						{
				?>

				<div class="alert alert-success alert-dismissable" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p><span class="bold">Action réussie !</span><br/>Votre profil a bien été modifié !</p>
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
						Votre profil n'a pas pu être modifié :<br/>
						<?= $status ?>
					</p>
				</div>

				<?php
						}
					}

					$profile = getProfileDataFromDB($_SESSION['currentUser']['mail']); // very important
				?>				

				<a href="users.php" class="btn btn-default"><i class="fa fa-users"></i> Liste des utilisateurs</a>
				<a href="adduser.php" class="btn btn-default"><i class="fa fa-user-plus"></i> Ajouter un utilisateur</a>
				<h1><i class="fa fa-pencil" aria-hidden="true"></i> Modification du profil personnel</h1>
				<div class="panel panel-default">
					<div class="panel-heading panel-dashboard">
						<h3 class="panel-title">Vos informations</h3>
					</div>
					<div class="panel-body">
						<form method="POST" action="">
							<div class="form-group">
								<label for="profile_username">Pseudonyme :</label>
								<input class="form-control" type="text" id="profile_username" name="profile_username" placeholder="Ce champ est requis" value="<?= $profile['username'] ?>" required />
							</div>
							<div class="form-group">
								<label for="profile_name">Nom :</label>
								<input class="form-control" type="text" id="profile_name" name="profile_name" value="<?= $profile['name'] ?>" />
							</div>
							<div class="form-group">
								<label for="profile_firstname">Prénom :</label>
								<input class="form-control" type="text" id="profile_firstname" name="profile_firstname" value="<?= $profile['firstname'] ?>" />
							</div>
							<div class="form-group">
								<label for="profile_mail">Adresse mail :</label>
								<input class="form-control" type="email" id="profile_mail" name="profile_mail" placeholder="Ce champ est requis" value="<?= $profile['mail'] ?>" required />
							</div>
							<div class="form-group">
								<label for="profile_oldPassword">Ancien mot de passe :</label>
								<input class="form-control" type="password" id="profile_oldPassword" name="profile_oldPassword" />
							</div>
							<div class="form-group">
								<label for="profile_newPassword1">Nouveau mot de passe :</label>
								<input class="form-control" type="password" id="profile_newPassword1" name="profile_newPassword1" />
							</div>
							<div class="form-group">
								<label for="profile_newPassword2">Répétez le nouveau mot de passe :</label>
								<input class="form-control" type="password" id="profile_newPassword2" name="profile_newPassword2" />
							</div>
							<div class="form-group">
								<label for="profile_adress1">Adresse :</label>
								<input class="form-control" type="text" id="profile_adress1" name="profile_adress1" value="<?= $profile['adress1'] ?>" />
							</div>
							<div class="form-group">
								<label for="profile_adress2">Adresse (complément) :</label>
								<input class="form-control" type="text" id="profile_adress2" name="profile_adress2" value="<?= $profile['adress2'] ?>" />
							</div>
							<div class="form-group">
								<label for="profile_postalCode">Code postal :</label>
								<input class="form-control" type="text" id="profile_postalCode" name="profile_postalCode" value="<?= $profile['postalCode'] ?>" />
							</div>
							<div class="form-group">
								<label for="profile_city">Ville :</label>
								<input class="form-control" type="text" id="profile_city" name="profile_city" value="<?= $profile['city'] ?>" />
							</div>
							<div class="form-group">
								<label for="profile_country">Pays :</label>
								<input class="form-control" type="text" id="profile_country" name="profile_country" value="<?= $profile['country'] ?>" />
							</div>
							<div class="form-group">
								<label for="profile_phone">Téléphone :</label>
								<input class="form-control" type="text" id="profile_phone" name="profile_phone" value="<?= $profile['phone'] ?>" />
							</div>
							<input type="submit" name="profile_submit" value="Modifier" class="btn btn-primary pull-right"/>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
	session_start();

	include_once("../functions.php");
	include_once("includes/admin_functions.php");

	/*if(!isset($_SESSION['currentUser']['mail']) || !doesAdminExist($_SESSION['currentUser']['mail']))
		header('location:login.php');*/
?>

<?php
	$subtitle = 'Articles';
	setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
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
				if(isset($_POST['addArticle_submit']))
				{
					$status = addArticleToDB();
					if($status == 'success')
					{
				?>

			<div class="alert alert-success alert-dismissable" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<p><span class="bold">Action réussie !</span><br/>Votre article a bien été ajouté</p>
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
					Votre article n'a pas pu être ajouté :<br/>
					<?= $status ?>
				</p>
			</div>

				<?php
					}
				}
			?>

				<a href="articles.php" class="btn btn-default"><i class="fa fa-shopping-cart"></i> Liste des articles</a>
				<h1><i class="fa fa-cart-plus" aria-hidden="true"></i> Ajout d'un article</h1>
				<div class="panel panel-default">
					<div class="panel-heading panel-dashboard">
						<h3 class="panel-title">Détail de l'article</h3>
					</div>

					<div class="panel-body">
						<form action="" method="POST">
							<div class="form-group">
								<label for="addArticle_name">Nom : </label>
								<input type="text" id="addArticle_name" name="addArticle_name" class="form-control" placeholder="Ce champ est requis" required value="<?= isset($_POST['addArticle_name']) ? $_POST['addArticle_name'] : '' ?>" />
							</div>
							<div class="form-group">
								<label for="addArticle_description">Description :</label>
								<textarea class="mceEditor form-control" id="addArticle_description" name="addArticle_description" placeholder="Ce champ est requis" required><?= isset($_POST['addArticle_description']) ? $_POST['addArticle_description'] : '' ?></textarea>
							</div>
							<div class="form-group">
								<?php
									$categories = getCategoriesBy('name');
								?>
								<label for="addArticle_category">Catégorie :</label>
								<select class="form-control" id="addArticle_category" name="addArticle_category">
									<option>--- Veuillez sélectionner ---</option>
									<?php
										foreach($categories as $category)
										{
									?>

									<option value="<?= $category ?>" <?= isset($_POST['addArticle_category']) && $category == $_POST['addArticle_category'] ? 'selected' : '' ?>><?= $category ?></option>

									<?php
										}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="addArticle_price">Prix (€) :</label>
								<input type="number" class="form-control" id="addArticle_price" name="addArticle_price" min="0" required value="<?= isset($_POST['addArticle_price']) ? $_POST['addArticle_price'] : '' ?>" step="any" />
							</div>
							<div class="form-group">
								<label for="addArticle_weight">Poids (g)* :</label>
								<input type="number" class="form-control" id="addArticle_weight" name="addArticle_weight" min="0" value="<?= isset($_POST['addArticle_weight']) ? $_POST['addArticle_weight'] : '' ?>" step="any" />
							</div>
							<div class="form-group">
								<label for="addArticle_length">Longueur (cm)* :</label>
								<input type="number" class="form-control" id="addArticle_length" name="addArticle_length" min="0" value="<?= isset($_POST['addArticle_length']) ? $_POST['addArticle_length'] : '' ?>" step="any" />
							</div>
							<div class="form-group">
								<label for="addArticle_quantity">Quantité :</label>
								<input type="number" class="form-control" id="addArticle_quantity" name="addArticle_quantity" min="0" required value="<?= isset($_POST['addArticle_quantity']) ? $_POST['addArticle_quantity'] : '' ?>" />
							</div>
							<div>
								<label>Composition (si une pierre n'existe pas, vous devez d'abord <a href="addstone.php">la créer</a>) :</label>
								<div class="checkbox">
									<?php
										$stones = getStonesFromDB();
										foreach($stones as $stone)
										{
									?>

									<label><input type="checkbox" id="addArticle_composition" name="addArticle_composition[]" value="<?= $stone['name'] ?>" <?= isset($_POST['addArticle_composition']) && in_array($stone['name'], $_POST['addArticle_composition']) ? 'checked' : '' ?> /> <?= $stone['name'] ?></label><br/>

									<?php
										}
									?>
								</div>
							</div>
							<div class="alert alert-info">
								<span class="bold">* Les champs marqués d'un astérisques sont facultatifs et peuvent être ignorés les laissant vides</span>
							</div>
							<div class="text-right">
								<input type="submit" name="addArticle_submit" class="btn btn-primary" value="Ajouter"/>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
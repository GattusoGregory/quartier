<?php
	session_start();

	include_once("../functions.php");
	include_once("includes/admin_functions.php");

	/*if(!isset($_SESSION['currentUser']['mail']) || !doesAdminExist($_SESSION['currentUser']['mail']))
		header('location:login.php');*/
?>

<?php
	if(!isset($_GET['id']) || !doesArticleExist(htmlspecialchars($_GET['id'])))
		header('location:articles.php');

	if(isset($_POST['editArticle_submit']))
		$status = editArticleToDB();

	$data = getArticleFromDB(htmlspecialchars($_GET['id']));
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
				if(isset($_POST['editArticle_submit']))
				{
					if($status == 'success')
					{
				?>

			<div class="alert alert-success alert-dismissable" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<p><span class="bold">Action réussie !</span><br/>Votre article a bien été modifié</p>
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
					Votre article n'a pas pu être modifié :<br/>
					<?= $status ?>
				</p>
			</div>

				<?php
					}
				}
			?>

				<a href="addarticle.php" class="btn btn-default"><i class="fa fa-cart-plus"></i> Ajouter un article</a>
				<a href="articles.php" class="btn btn-default"><i class="fa fa-shopping-cart"></i> Liste des articles</a>
				<h1><i class="fa fa-edit" aria-hidden="true"></i> Modification d'un article</h1>
				<div class="panel panel-default">
					<div class="panel-heading panel-dashboard">
						<h3 class="panel-title">Détail de l'article</h3>
					</div>

					<div class="panel-body">
						<form action="" method="POST">
							<div class="form-group">
								<label for="editArticle_name">Nom : </label>
								<input type="text" id="editArticle_name" name="editArticle_name" class="form-control" placeholder="Ce champ est requis" required value="<?= $data['name'] ?>" />
							</div>
							<div class="form-group">
								<label for="editArticle_description">Description :</label>
								<textarea class="mceEditor form-control" id="editArticle_description" name="editArticle_description" placeholder="Ce champ est requis" required><?= $data['description'] ?></textarea>
							</div>
							<div class="form-group">
								<?php
									$categories = getCategoriesBy('name');
								?>
								<label for="editArticle_category">Catégorie :</label>
								<select class="form-control" id="editArticle_category" name="editArticle_category">
									<?php
										foreach($categories as $category)
										{
									?>

									<option value="<?= $category ?>" <?= $category == $data['category'] ? 'selected' : '' ?>><?= $category ?></option>

									<?php
										}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="editArticle_price">Prix (€) :</label>
								<input type="number" class="form-control" id="editArticle_price" name="editArticle_price" min="0" required value="<?= $data['price'] ?>" step="any" />
							</div>
							<div class="form-group">
								<label for="editArticle_weight">Poids (g)* :</label>
								<input type="number" class="form-control" id="editArticle_weight" name="editArticle_weight" min="0" value="<?= $data['weight'] ?>" step="any" />
							</div>
							<div class="form-group">
								<label for="editArticle_length">Longueur (cm)* :</label>
								<input type="number" class="form-control" id="editArticle_length" name="editArticle_length" min="0" value="<?= $data['length'] ?>" step="any" />
							</div>
							<div class="form-group">
								<label for="editArticle_quantity">Quantité :</label>
								<input type="number" class="form-control" id="editArticle_quantity" name="editArticle_quantity" min="0" required value="<?= $data['quantity'] ?>" />
							</div>
							<div>
								<label>Composition (si une pierre n'existe pas, vous devez d'abord <a href="addstone.php">la créer</a>) :</label>
								<div class="checkbox">
									<?php
										$stones = getStonesFromDB();
										$compo = getArticleStones($data['id']);
										foreach($stones as $stone)
										{
									?>

									<label><input type="checkbox" id="editArticle_composition" name="editArticle_composition[]" value="<?= $stone['name'] ?>" <?= in_array($stone['name'], $compo) ? 'checked' : '' ?> /> <?= $stone['name'] ?></label><br/>

									<?php
										}
									?>
								</div>
							</div>
							<div class="alert alert-info">
								<span class="bold">* Les champs marqués d'un astérisques sont facultatifs et peuvent être ignorés les laissant vides</span>
							</div>
							<div class="text-right">
								<input type="submit" name="editArticle_submit" class="btn btn-primary" value="Modifier"/>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
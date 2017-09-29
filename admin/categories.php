<?php include_once("../functions.php"); ?>
<?php include_once("includes/admin_functions.php"); ?>

<?php
	$subtitle = 'Catégories';
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
		<link rel="stylesheet" href="CSS/categories.css"/>

		<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.js"></script>
		<script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="categories.js"></script>
		<script type="text/javascript" src="admin_functions.js"></script>
	</head>

	<body onload="initList();">

		<?php include_once("nav.php"); ?>

		<!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
		<div id="main">
			<?php include_once("header.php"); ?>
			<?php include_once("sign-out_modal.php"); ?>

			<div class="margin-100">

				<?php
					if(isset($_POST['selectEditCatButton'], $_POST['selectEditCat']) && $_POST['selectEditCat'] != '--- Catégories ---')
					{
						$back = updateCategory();
						if($back == 'success')
						{
				?>

				<div class="alert alert-success alert-dismissable" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p><span class="bold">Action réussie !</span><br/>La catégorie <?= $_POST['selectEditCat'] ?> a bien été mise à jour !</p>
				</div>

				<?php
						}
						else
						{
				?>

				<div class="alert alert-danger alert-dismissable" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p>
						<span class="bold">Echec de l'action !</span><br/>La catégorie <?= $_POST['selectEditCat'] ?> n'a pas pu être mise à jour :<br/>
						<?= $back ?>
					</p>
				</div>

				<?php
						}
					}
					else if(isset($_POST['selectCatButton']))
					{
						$back = updateCategoriesPriority();
						if($back == 'success')
						{
				?>

				<div class="alert alert-success alert-dismissable" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p><span class="bold">Action réussie !</span><br/>Les catégories ont bien été mis à jour !</p>
				</div>

				<?php
						}
						else
						{
				?>

				<div class="alert alert-danger alert-dismissable" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p>
						<span class="bold">Echec de l'action !</span><br/>Les catégories n'ont pas pu être mis à jour :<br/>
						<?= $back ?>
					</p>
				</div>

				<?php
						}
					}
					else if(isset($_POST['deleteAddCatButton']))
					{
						if(isset($_POST['deleteCat']) && $_POST['deleteCat'] != 'Ne rien supprimer')
						{
							$back = deleteCategory();
							if($back == 'success')
							{
				?>

				<div class="alert alert-success alert-dismissable" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p><span class="bold">Action réussie !</span><br/>La catégorie '<?= $_POST['deleteCat'] ?>' a bien été supprimée !</p>
				</div>

				<?php
							}
							else
							{
				?>

				<div class="alert alert-danger alert-dismissable" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p>
						<span class="bold">Echec de l'action !</span><br/>La catégorie '<?= $_POST['deleteCat'] ?>' n'a pas pu être supprimée :<br/>
						<?= $back ?>
					</p>
				</div>

				<?php
							}
						}

						if(isset($_POST['addCat']) && $_POST['addCat'] != '')
						{
							$back = addCategory();
							if($back == 'success')
							{
				?>

				<div class="alert alert-success alert-dismissable" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p><span class="bold">Action réussie !</span><br/>La catégorie '<?= $_POST['addCat'] ?>' a bien été ajoutée !</p>
				</div>

				<?php
							}
							else
							{
				?>

				<div class="alert alert-danger alert-dismissable" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p>
						<span class="bold">Echec de l'action !</span><br/>La catégorie '<?= $_POST['addCat'] ?>' n'a pas pu être ajoutée :<br/>
						<?= $back ?>
					</p>
				</div>

				<?php
							}
						}
					}
				?>

				<h1><i class="fa fa-database" aria-hidden="true"></i> Liste des catégories</h1>

				<div class="panel panel-default">
					<div class="panel-heading panel-dashboard">
						<h3 class="panel-title">Modifier l'ordre d'apparition</h3>
					</div>

					<div class="panel-body">
						<form action="" method="POST" onsubmit="return forceSelection()">
							<div class="row">
								<div class="col-md-10">
									<select id="selectCat" name="selectCat[]" class="form-control" size="10" multiple onchange="valueChanged()">
										<?php
											$categories = getCategoriesBy('priority');
											foreach ($categories as $categorie)
											{
										?>
										<option value=<?= '"' . $categorie . '"' ?>><?= $categorie ?></option>
										<?php
											}
										?>
									</select>
									<span><span class="italic">Utilisez </span><kbd>Ctrl/Cmd</kbd> + <kbd>Clic</kbd> <span class="italic"> pour sélectionner/désélectionner plusieurs éléments</span>
								</div>
								<div class="col-md-2 text-center">
									<table width="100%" class="table-arrows">
										<tr>
											<td>
												<a type="button" onclick="upElems();" class="btn btn-default"><i class="fa fa-arrow-up fa-1x"></i></a>
												<a type="button" onclick="downElems();" class="btn btn-default"><i class="fa fa-arrow-down fa-1x"></i></a>
											</td>
										</tr>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 text-right margin-top-10">
									<button class="btn btn-default" onclick="resetCategories();"><i class="fa fa-times-circle fa-1x"></i> Annuler</button>
									<button type="submit" name="selectCatButton" class="btn btn-success"><i class="fa fa-save fa-1x"></i> Enregistrer</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading panel-dashboard">
						<h3 class="panel-title">Modifier un élément</h3>
					</div>

					<div class="panel-body">
						<form method="POST" action="" class="form-inline">
							<div class="row">
								<div class="col-md-6">
									<label for="selectEditCat">Catégorie :</label><br/>
									<select id="selectEditCat" name="selectEditCat" class="form-control" onchange="changeCurrentCategory()">
										<option>--- Catégories ---</option>
										<?php
											$categories = getCategoriesBy('priority');
											foreach ($categories as $categorie)
											{
										?>
										<option value="<?= $categorie ?>"><?= $categorie ?></option>
										<?php
											}
										?>
									</select>
								</div>
								<div class="col-md-6">
									<div>
										<label for="editCatName">Nom : </label><br/>
										<input type="text" name="editCatName" id="editCatName" class="form-control" oninput="selectedCatUpdated()" required />
									</div>
									<div>
										<label for="editCatDesc">Description : </label><br/>
										<textarea class="form-control" name="editCatDesc" id="editCatDesc" rows="3" cols="50" resize="none" oninput="selectedCatUpdated()"></textarea>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 text-right margin-top-10">
									<button type="reset" class="btn btn-default"><i class="fa fa-times-circle fa-1x"></i> Annuler</button>
									<button type="submit" id="selectEditCatButton" name="selectEditCatButton" value="Modifier" class="btn btn-success" disabled><i class="fa fa-save fa-1x"></i> Enregistrer</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading panel-dashboard">
						<h3 class="panel-title">Supprimer/Ajouter un élément</h3>
					</div>

					<div class="panel-body">
						<form action="" method="POST">
							<div class="row">
								<div class="col-md-6">
									<label for="deleteCat">Supprimer une catégorie :</label><br/>
									<select id="deleteCat" name="deleteCat" class="form-control" onchange="changeButtonStatus();">
										<option>Ne rien supprimer</option>
										<?php
											$categories = getCategoriesBy('priority');
											foreach ($categories as $categorie)
											{
										?>
										<option value="<?= $categorie ?>"><?= $categorie ?></option>
										<?php
											}
										?>
									</select>
								</div>

								<div class="col-md-6">
									<label for="addCat">Ajouter une catégorie :</label><br/>
									<input type="text" class="form-control" id="addCat" name="addCat" placeholder="Nom de la catégorie" oninput="changeButtonStatus();"/>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12 text-right margin-top-10">
									<button type="reset" class="btn btn-default" onclick="$('#deleteAddCatButton').attr('disabled', true);"><i class="fa fa-times-circle fa-1x"></i> Annuler</button>
									<button type="submit" id="deleteAddCatButton" name="deleteAddCatButton" class="btn btn-success" disabled><i class="fa fa-save fa-1x"></i> Enregistrer</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
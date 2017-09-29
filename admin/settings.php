<?php
	session_start();

	include_once("../functions.php");
	include_once("includes/admin_functions.php");

	/*if(!isset($_SESSION['currentUser']['mail']) || !doesAdminExist($_SESSION['currentUser']['mail']))
		header('location:login.php');*/
?>

<?php
	$subtitle = 'Paramètres';
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

		<script src='../tinymce/tinymce.min.js'></script>
		<script type="text/javascript">
			tinymce.init({
				selector: '.mceEditor',
				height: '300',
				plugins: 'link image preview advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor colorpicker',
				toolbar: 'bold italic underline | alignleft aligncenter alignright alignjustify | styleselect formatselect removeformat | fontselect fontsizeselect forecolor backcolor | bullist numlist | outdent indent | undo redo | blockquote subscript superscript',
				inline: false,
				table_cell_class_list: true
			});
		</script>
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
					if(isset($_POST['meta_submit']))
					{
						$status = updateMetaData();
						if($status == 'success')
						{
				?>

				<div class="alert alert-success alert-dismissable" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p><span class="bold">Action réussie !</span><br/>Les données ont bien été mises à jour !</p>
				</div>

				<?php
						}
						else
						{
				?>

				<div class="alert alert-danger alert-dismissable" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<p>
						<span class="bold">Echec de la mise à jour</span><br/>
						Les données n'ont pas pu être actualisées :<br/>
						<?= $status ?>
					</p>
				</div>

				<?php
						}
					}
					
					$data = getAllMetaDataFromDB();
				?>

				<h1><i class="fa fa-cogs" aria-hidden="true"></i> Paramètres</h1>
				<div class="panel panel-default">
					<div class="panel-heading panel-dashboard">
						<h3 class="panel-title">Modifier les paramètres</h3>
					</div>

					<div class="panel-body">
						<form action="" method="POST">
							<fieldset>
								<legend>Informations générales</legend>
								<div class="form-group">
									<label for="meta_websiteName">Nom du site :</label>
									<input type="text" id="meta_websiteName" name="meta_websiteName" class="form-control" placeholder="Ce champ est requis" required value="<?= $data['websiteTitle'] ?>"/>
								</div>
								<div class="form-group">
									<div class="alert alert-warning">
										<p>
											<span class="bold">Attention !</span><br/>
											Modifier ce champ peut apporter des problèmes sur le site
										</p>
									</div>
									<label for="meta_websiteRoot">Racine du site :</label>
									<input type="text" id="meta_websiteRoot" name="meta_websiteRoot" class="form-control" placeholder="Ce champ est requis" required value="<?= $data['websiteRoot'] ?>"/>
								</div>
								<div class="form-group">
									<label for="meta_ownerMail">Adresse mail du propriétaire :</label>
									<input type="email" id="meta_ownerMail" name="meta_ownerMail" class="form-control" placeholder="Ce champ est requis" required value="<?= $data['ownerMail'] ?>"/>
								</div>
								<div class="form-group">
									<label for="meta_websiteIntro">Texte d'introduction :</label>
									<textarea id="meta_websiteIntro" name="meta_websiteIntro" class="mceEditor form-control"><?= $data['websiteIntro'] ?></textarea>
								</div>
							</fieldset>
							<fieldset>
								<legend>Informations sur l'entreprise</legend>
								<div class="alert alert-warning">
										<p>
											<span class="bold">Attention !</span><br/>
											Ces informations seront visibles pour les visiteurs
										</p>
									</div>
								<div class="form-group">
									<label for="meta_corpName">Nom :</label>
									<input type="text" id="meta_corpName" name="meta_corpName" class="form-control" placeholder="Ce champ est requis" required value="<?= $data['corporationName'] ?>"/>
								</div>
								<div class="form-group">
									<label for="meta_corpAdress1">Adresse :</label>
									<input type="text" id="meta_corpAdress1" name="meta_corpAdress1" class="form-control" placeholder="Ce champ est requis" required value="<?= $data['corporationAdress1'] ?>"/>
								</div>
								<div class="form-group">
									<label for="meta_corpAdress2">Adresse complémentaire :</label>
									<input type="text" id="meta_corpAdress2" name="meta_corpAdress2" class="form-control" value="<?= $data['corporationAdress2'] ?>"/>
								</div>
								<div class="form-group">
									<label for="meta_corpCP">Code postal :</label>
									<input type="text" id="meta_corpCP" name="meta_corpCP" class="form-control" placeholder="Ce champ est requis" required value="<?= $data['corporationCP'] ?>"/>
								</div>
								<div class="form-group">
									<label for="meta_corpCity">Ville :</label>
									<input type="text" id="meta_corpCity" name="meta_corpCity" class="form-control" placeholder="Ce champ est requis" required value="<?= $data['corporationCity'] ?>"/>
								</div>
								<div class="form-group">
									<label for="meta_corpCountry">Pays :</label>
									<input type="text" id="meta_corpCountry" name="meta_corpCountry" class="form-control" placeholder="Ce champ est requis" required value="<?= $data['corporationCountry'] ?>"/>
								</div>
								<div class="form-group">
									<label for="meta_corpPhone">Téléphone :</label>
									<input type="text" id="meta_corpPhone" name="meta_corpPhone" class="form-control" placeholder="Ce champ est requis" required value="<?= $data['corporationPhone'] ?>"/>
								</div>
								<button type="submit" class="btn btn-primary pull-right" name="meta_submit"><i class="fa fa-save"></i> Enregistrer</button>
							</fieldset>
							
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
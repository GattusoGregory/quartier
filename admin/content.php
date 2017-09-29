<?php
	session_start();

	include_once("../functions.php");
	include_once("includes/admin_functions.php");

	/*if(!isset($_SESSION['currentUser']['mail']) || !doesAdminExist($_SESSION['currentUser']['mail']))
		header('location:login.php');*/
?>

<?php
	if(!isset($_GET['id']) || !doesContentExist(htmlspecialchars($_GET['id'])))
		header('location:contents.php');

	if(isset($_POST['editContent_submit']))
		$status = editContentToDB();

	$data = getContentDataFromDB(htmlspecialchars($_GET['id']));
	$subtitle = 'Contenu';

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
				if(isset($_POST['editContent_submit']))
				{
					if($status == 'success')
					{
				?>

			<div class="alert alert-success alert-dismissable" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<p><span class="bold">Action réussie !</span><br/>Le contenu a bien été modifié</p>
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
					Le contenu n'a pas pu être modifié :<br/>
					<?= $status ?>
				</p>
			</div>

				<?php
					}
				}
			?>

				<a href="contents.php" class="btn btn-default"><i class="fa fa-file-text"></i> Contenu du site</a>
				<h1><i class="fa fa-edit" aria-hidden="true"></i> Modification de texte</h1>
				<div class="panel panel-default">
					<div class="panel-heading panel-dashboard">
						<h3 class="panel-title">Détail du contenu</h3>
					</div>

					<div class="panel-body">
						<form action="" method="POST">
							<div class="form-group">
								<label for="editContent_type">Type : </label>
								<input type="text" id="editContent_type" name="editContent_type" class="form-control" value="<?= $data['refType'] ?>" readonly disabled />
							</div>
							<div class="form-group">
								<label for="editContent_theme">Thème : </label>
								<input type="text" id="editContent_theme" name="editContent_theme" class="form-control" value="<?= $data['refTheme'] ?>" readonly disabled />
							</div>
							<div class="form-group">
								<label for="editContent_title">Titre : </label>
								<input type="text" id="editContent_title" name="editContent_title" class="form-control" value="<?= $data['title'] ?>" required placeholder="Ce champ est requis" />
							</div>
							<div class="form-group">
								<label for="editContent_content">Contenu :</label>
								<textarea class="mceEditor form-control" id="editContent_content" name="editContent_content"><?= $data['content'] ?></textarea>
							</div>
							<div class="text-right">
								<input type="submit" name="editContent_submit" class="btn btn-primary" value="Modifier"/>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
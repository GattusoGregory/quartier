<?php
	session_start();

	include_once("../functions.php");
	include_once("includes/admin_functions.php");

	/*if(!isset($_SESSION['currentUser']['mail']) || !doesAdminExist($_SESSION['currentUser']['mail']))
		header('location:login.php');*/
?>

<?php
	$subtitle = 'Contenu';
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?= getWebsiteTitle() ?> - <?= $subtitle ?></title>
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="../CSS/globals.css"/>
		<link rel="stylesheet" href="../font-awesome/css/font-awesome.css"/>
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css"/>
		<link rel="stylesheet" href="CSS/menu.css"/>
		<link rel="stylesheet" href="CSS/header.css"/>

		<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.js"></script>
		<script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="admin_functions.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
			    $('#contentsTable').DataTable(
			    {
			        "language": {"url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"},
			        columnDefs: [{ orderable: false, targets: [4]}],
			        "order": [2, 'asc']
			    });
			} );
		</script>
	</head>

	<body>

		<?php include_once("nav.php"); ?>

		<!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
		<div id="main">
			<?php include_once("header.php"); ?>
			<?php include_once("sign-out_modal.php"); ?>

			<div class="margin-100">

				<h1><i class="fa fa-file-text" aria-hidden="true"></i> Contenu du site</h1>
				<div class="panel panel-default">
					<div class="panel-heading panel-dashboard">
						<h3 class="panel-title">Liste des éléments</h3>
					</div>

					<div class="panel-body">
						<?php
							$contents = getContentsFromDB();
						?>
						<div class="margin-bottom-20">
							<button class="btn btn-danger" id="deleteSelected" data-toggle="modal" data-target="#deletion-modal" disabled>
								<i class="fa fa-trash fa-1x"></i> Supprimer la sélection
							</button>
						</div>
						<table id="contentsTable" class="table table-bordered table-hover table-striped table-center">
							<thead>
								<tr>
									<th>Type</th>
									<th>Thème</th>
									<th>Titre</th>
									<th>Dernière modification</th>
									<th>Modération</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($contents as $content)
									{
								?>
								<tr>
									<td><?= $content['refType'] == 'training' ? 'Formation' : 'Soin' ?></td>
									<td><?= $content['refTheme'] == 'lithotherapie' ? 'Lithothérapie' : ($content['refTheme'] == 'reiki' ? 'Reiki' : 'Chamanisme') ?></td>
									<td><?= $content['title'] ?></td>
									<td><?= $content['updatedOn'] ?></td>
									<td>
										<a href="content.php?id=<?= $content['id'] ?>" class="btn btn-primary"><i class="fa fa-edit fa-1x"></i></a>
									</td>
								</tr>

								<?php
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
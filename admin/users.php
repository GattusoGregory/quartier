<?php include_once("../functions.php"); ?>
<?php include_once("includes/admin_functions.php"); ?>

<?php
	$subtitle = 'Utilisateurs';
	$keyword = 'users';
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?= getWebsiteTitle() ?> - <?= $subtitle ?></title>
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="../CSS/globals.css"/>
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css"/>
		<link rel="stylesheet" href="../font-awesome/css/font-awesome.css"/>
		<link rel="stylesheet" href="CSS/menu.css"/>
		<link rel="stylesheet" href="CSS/header.css"/>

		<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.js"></script>
		<script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript" src="admin_functions.js"></script>
  
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
			    $('#userTable').DataTable(
			    {
			        "language": {"url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"},
			        columnDefs: [{ orderable: false, targets: [0, 5]}],
			        "order": [1, 'asc']
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
			<?php include_once("deletionConfirmation_modal.php"); ?>

			<div class="margin-100">

				<a href="adduser.php" class="btn btn-default"><i class="fa fa-user-plus" aria-hidden="true"></i> Ajouter un nouvel utilisateur</a>
				<h1><i class="fa fa-users" aria-hidden="true"></i> Liste des utilisateurs</h1>

				<div class="panel panel-default">
					<div class="panel-heading panel-dashboard">
						<h3 class="panel-title">Liste des utilisateurs inscrits</h3>
					</div>

					<div class="panel-body">
						<?php
							$rows = getUsers();
						?>

						<div class="margin-bottom-20">
							<button class="btn btn-danger" id="deleteSelected" data-toggle="modal" data-target="#deletion-modal" disabled>
								<i class="fa fa-trash fa-1x"></i> Supprimer la sélection
							</button>
						</div>
						<table id="userTable" class="table table-striped table-hover table-responsive table-no-margin table-center">
							<thead>
								<tr>
									<th><input type="checkbox" class="form-control" id="selectAll" onclick="deletionSelectOrUnselectAll()"/></th>
									<th>Mail</th>
									<th>Nom d'utilisateur</th>
									<th>Nom complet</th>
									<th>Rôle</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>

						<?php
								foreach($rows as $row)
								{
						?>
								<tr>
									<td>
										<input type="checkbox" name="selectSingle[]" id="selectSingle" value="<?= $row['mail'] ?>" class="form-control" onclick="deletionSelectionState();"/>
									</td>
									<td><a href="mailto:<?= $row['mail'] ?>"><?= $row['mail'] ?></a></td>
									<td><?= $row['username']?></td>
									<td><?= $row['firstname']?> <?= $row['name'] ?></td>
									<td><?= $row['role'] ?></td>
									<td>
										<a type="button" class="btn btn-success" href="user.php?user=<?= $row['mail'] ?>"><i class="fa fa-pencil fa-1x"></i></a>
										<button class="btn btn-danger" onclick="if(confirm('Voulez-vraiment supprimer cet utilisateur ? Cette action est irréversible !')) deleteUserFromDB('<?= addslashes($row['mail']) ?>', '<?= addslashes($row['username']) ?>');"><i class="fa fa-trash fa-1x"></i></button>
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
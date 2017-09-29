<?php include_once("../functions.php"); ?>
<?php include_once("includes/admin_functions.php"); ?>

<?php
	$subtitle = 'Dashboard';
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?= getWebsiteTitle() ?> - <?= $subtitle ?></title>
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.css"/>
		<link rel="stylesheet" href="../CSS/globals.css"/>
		<link rel="stylesheet" href="../font-awesome/css/font-awesome.css"/>
		<link rel="stylesheet" href="CSS/menu.css"/>
		<link rel="stylesheet" href="CSS/header.css"/>

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
				<h1><i class="fa fa-tachometer" aria-hidden="true"></i> Panneau d'administration</h1>
				<div class="panel panel-default">
					<div class="panel-heading panel-dashboard">
						<h3 class="panel-title">Derniers utilisateurs inscrits</h3>
						<a class="action" href="users.php"><i class="fa fa-users" aria-hidden="true"></i> Tous</a>
						<a class="action padding-space" href="adduser.php"><i class="fa fa-user-plus" aria-hidden="true"></i> Ajouter</a>
					</div>

					<div class="panel-body">
						<?php

							if(($rows = getLastInsertedUsers()) != null)
							{
						?>

						<table class="table table-striped table-hover table-responsive table-no-margin">
							<thead>
								<tr>
									<th>Mail</th>
									<th>Nom d'utilisateur</th>
									<th>Nom complet</th>
									<th>Adresse complète</th>
									<th>Rôle</th>
									<th>Date d'inscription</th>
								</tr>
							</thead>
							<tbody>

						<?php
							foreach($rows as $row)
							{
						?>
								<tr>
									<td><a href="user.php?user=<?= $row['mail'] ?>"><?= $row['mail'] ?></a></td>
									<td><?= $row['username'] ?></td>
									<td><?= $row['firstname'] . ' ' . $row['name'] ?></td>
									<td><?= $row['adress1'] . ' ' . $row['adress2'] . ' ' . $row['city'] ?></td>
									<td><?= $row['role'] ?></td>
									<td><?= $row['inscriptionDate'] ?></td>
								</tr>
						<?php
							}
						?>

							</tbody>
						</table>

						<?php
							}
							else
								echo '<p class="text-center italic">Aucun utilisateur récent</p>';
						?>
					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-heading panel-dashboard">
						<h3 class="panel-title">Dernières transactions</h3>
						<a class="action" href="">Voir toutes les transactions</a>
					</div>

					<div class="panel-body">
						<p class="text-center italic">Aucune transaction récente</p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
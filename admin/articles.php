<?php include_once("../functions.php"); ?>
<?php include_once("includes/admin_functions.php"); ?>

<?php
	$subtitle = 'Articles';
	$keyword = 'articles';
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?= getWebsiteTitle() ?> - <?= $subtitle ?></title>
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.css"/>
		<link rel="stylesheet" href="../CSS/globals.css"/>
		<link rel="stylesheet" href="../font-awesome/css/font-awesome.css"/>
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css"/>
		<link rel="stylesheet" href="CSS/menu.css"/>
		<link rel="stylesheet" href="CSS/header.css"/>

		<script src="https://code.jquery.com/jquery-3.1.1.js"></script>
		<script src="../bootstrap/js/bootstrap.js"></script>
		<script src="js/admin_functions.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
			    $('#articlesTable').DataTable(
			    {
			        "language": {"url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"},
			        columnDefs: [{ orderable: false, targets: [0, 3, 6]}],
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

				<a href="addarticle.php" class="btn btn-default"><i class="fa fa-cart-plus" aria-hidden="true"></i> Ajouter un nouvel article</a>

				<h1><i class="fa fa-shopping-cart" aria-hidden="true"></i> Articles du magasin</h1>
				<div class="panel panel-default">
					<div class="panel-heading panel-dashboard">
						<h3 class="panel-title">Liste des articles</h3>
					</div>

					<div class="panel-body">
						<?php
							$articles = getArticlesFromDB();
						?>
						<div class="margin-bottom-20">
							<button class="btn btn-danger" id="deleteSelected" data-toggle="modal" data-target="#deletion-modal" disabled>
								<i class="fa fa-trash fa-1x"></i> Supprimer la sélection
							</button>
						</div>
						<table id="articlesTable" class="table table-striped table-hover table-responsive table-no-margin table-center">
							<thead>
								<tr>
									<th><input type="checkbox" name="selectAll" id="selectAll" onclick="deletionSelectOrUnselectAll();" /></th>
									<th>ID</th>
									<th>Nom</th>
									<th>Composition</th>
									<th>Prix</th>
									<th>Quantité</th>
									<th>Modération</th>
								</tr>
							</thead>
							<tbody>

						<?php
							foreach($articles as $article)
							{
						?>
								<tr>
									<td>
										<input type="checkbox" name="selectSingle[]" id="selectSingle" value="<?= $article['id'] ?>" class="form-control" onclick="deletionSelectionState();"/>
									</td>
									<td><?= $article['id'] ?></td>
									<td><?= $article['name'] ?></td>
									<td>
										<?php
						    				$compo = getArticleStones($article['id']);
						    				$compoLength = sizeof($compo);
						    			
						    				for($i = 0; $i < $compoLength; $i++)
						    				{
						    					echo $compo[$i];
						    					if($i < $compoLength-1)
						    						echo "/";
						    				}
	    								?>
	    							</td>
									<td><?= $article['price'] ?></td>
									<td><?= $article['quantity'] ?></td>
									<td>
										<a type="button" class="btn btn-primary" href="article.php?id=<?= $article['id'] ?>"><i class="fa fa-edit fa-1x"></i></a>
										<button class="btn btn-danger" onclick="if(confirm('Voulez-vraiment supprimer cet article ? Cette action est irréversible !')) deleteArticleFromDB('<?= addslashes($article['id']) ?>', '<?= addslashes($article['name']) ?>');"><i class="fa fa-trash fa-1x"></i></button>
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
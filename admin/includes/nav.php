<nav id="sidenav" class="sidenav">
	<div class="margin-10 text-center">
		<a href="../index.php" title="Accéder au site web"><img src="../Resources/logo.svg" alt="Logo site" width="200px"/></a>
	</div>
	<ul class="nav nav-pills nav-stacked">
		<li role="presentation" <?php if(isset($subtitle) && $subtitle == 'Dashboard'){ ?> class="active" <?php } ?>>
			<a href="dashboard.php"><i class="fa fa-tachometer fa-1x" aria-hidden="true"></i> Panneau d'administration</a>
		</li>
		<li role="presentation" <?php if(isset($subtitle) && $subtitle == 'Paramètres'){ ?> class="active" <?php } ?>>
			<a href="settings.php"><i class="fa fa-cogs fa-1x" aria-hidden="true"></i> Paramètres</a>
		</li>
		<li role="presentation" <?php if(isset($subtitle) && $subtitle == 'Contenu'){ ?> class="active" <?php } ?>>
			<a href="contents.php"><i class="fa fa-file-text fa-1x" aria-hidden="true"></i> Contenu</a>
		</li>
		<li role="presentation" <?php if(isset($subtitle) && $subtitle == 'Salons'){ ?> class="active" <?php } ?>>
			<a href="meetings.php"><i class="fa fa-map-marker fa-1x" aria-hidden="true"></i> Salons</a>
		</li>
		<li role="presentation" <?php if(isset($subtitle) && $subtitle == 'Utilisateurs'){ ?> class="active" <?php } ?>>
			<a href="users.php"><i class="fa fa-users fa-1x" aria-hidden="true"></i> Utilisateurs</a>
		</li>
		<li role="presentation" <?php if(isset($subtitle) && $subtitle == 'Messages'){ ?> class="active" <?php } ?>>
			<a href="messages.php"><i class="fa fa-comments fa-1x" aria-hidden="true"></i> Messages (à faire)</a>
		</li>
		<li role="presentation" <?php if(isset($subtitle) && $subtitle == 'Catégories'){ ?> class="active" <?php } ?>>
			<a href="categories.php"><i class="fa fa-database fa-1x" aria-hidden="true"></i> Catégories (à revoir)</a>
		</li>
		<li role="presentation" <?php if(isset($subtitle) && $subtitle == 'Articles'){ ?> class="active" <?php } ?>>
			<a href="articles.php"><i class="fa fa-shopping-cart fa-1x" aria-hidden="true"></i> Articles</a>
		</li>
		<li role="presentation" <?php if(isset($subtitle) && $subtitle == 'Pierres'){ ?> class="active" <?php } ?>>
			<a href="stones.php"><i class="fa fa-diamond fa-1x" aria-hidden="true"></i> Pierres</a>
		</li>
		<li role="presentation" <?php if(isset($subtitle) && $subtitle == 'Transactions'){ ?> class="active" <?php } ?>>
			<a href="transactions.php"><i class="fa fa-dollar fa-1x" aria-hidden="true"></i> Transactions (à faire)</a>
		</li>
	</ul>
</nav>
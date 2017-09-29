<?php
	include_once("../../functions.php");
	include_once("../includes/admin_functions.php");

	if(!isset($_POST['id'], $_POST['name']))
		echo 'Des champs attendus sont manquants';
	else
	{
		if(doesStoneExist(htmlspecialchars($_POST['id'])))
		{
			try
			{
				$query = $GLOBALS['db']->query("SELECT name FROM articles WHERE id = " . htmlspecialchars($_POST['id']));
				if($row = $query->fetch())
				{
					if($row['name'] == htmlspecialchars($_POST['name']))
					{
						$GLOBALS['db']->query("DELETE FROM rel_articles_stones WHERE idArticle = " . htmlspecialchars($_POST['id']));
						$query = $GLOBALS['db']->prepare("DELETE FROM articles WHERE id = ? AND name = ?");
						$query->execute(array(htmlspecialchars($_POST['id']), htmlspecialchars($_POST['name'])));
						echo 'success';
					}
					else
						echo "Les champs entrés sont invalides (" . $row['name'] . ") VS (" . htmlspecialchars($_POST['name']) . ")";
				}
				else
					echo "L'article n'existe pas";
			}
			catch(Exception $e)
			{
				echo 'Erreur MySQL: ' . $e->getMessage();
			}
		}
		else
			echo "L'article n'existe pas";
	}
?>
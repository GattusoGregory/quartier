<?php
	include_once("../../functions.php");
	include_once("../includes/admin_functions.php");

	if(!isset($_POST['mail'], $_POST['username']))
		echo 'Des champs attendus sont manquants';
	else
	{
		if(doesUserExist(htmlspecialchars($_POST['mail'])))
		{
			try
			{
				$query = $GLOBALS['db']->query("SELECT username FROM users WHERE mail = '" . htmlspecialchars($_POST['mail']) . "'");
				if($row = $query->fetch())
				{
					if($row['username'] == htmlspecialchars($_POST['username']))
					{
						$query = $GLOBALS['db']->prepare("DELETE FROM users WHERE mail = ? AND username = ?");
						$query->execute(array(htmlspecialchars($_POST['mail']), htmlspecialchars($_POST['username'])));
						echo 'success';
					}
					else
						echo "Les champs entrés sont invalides (" . $row['username'] . ") VS (" . htmlspecialchars($_POST['username']) . ")";
				}
				else
					echo "L'utilisateur n'existe pas";
			}
			catch(Exception $e)
			{
				echo 'Erreur MySQL: ' . $e->getMessage();
			}
		}
		else
			echo "L'utilisateur n'existe pas";
	}
?>
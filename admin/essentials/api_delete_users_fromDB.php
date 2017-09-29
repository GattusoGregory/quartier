<?php
	include_once("../../functions.php");
	include_once("../includes/admin_functions.php");

	if(!isset($_POST['ids']))
		echo 'Des champs attendus sont manquants';
	else
	{
		if(is_array($_POST['ids']))
		{
			try
			{
				$GLOBALS['db']->beginTransaction();
				for($i = 0; $i < sizeof($_POST['ids']); $i++)
					$GLOBALS['db']->query("DELETE FROM users WHERE mail = '" . htmlspecialchars($_POST['ids'][$i]) . "'");

				$GLOBALS['db']->commit();
				echo "success";
			}
			catch(Exception $e)
			{
				$GLOBALS['db']->rollback();
				die('Erreur MySQL : ' . $e->getMessage());
			}
		}
		else
			die('Une erreur de format est survenue');
	}
?>
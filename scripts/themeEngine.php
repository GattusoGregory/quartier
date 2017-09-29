<?php

/** Classe de gestion des utilisateurs [Model] */

$path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/db.php";
include_once("$path");


class themeEngine
{


		public function getTheme()
	{
		try
		{
			$sql = "SELECT path FROM themeEngine WHERE current='1'";

			$stmt = Database::getInstance()->request($sql, false, false); 
			return $stmt;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	/*----------------------------------------*/

	/** Fonction de connexion  */

	public function changeTheme($themeID)
	{
		try
		{
			$sql = "UPDATE themeEngine SET current = '0'";
			$stmt = Database::getInstance()->request($sql, false, false);
			$sql = "UPDATE themeEngine SET current = '1' WHERE id='$themeID'";
			$stmt = Database::getInstance()->request($sql, false, false);
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	/*----------------------------------------*/

	/** Fonction de connexion  */

	public function Delete($tname)
	{
		try
		{
			$sql = "DELETE FROM themeEngine
					WHERE Nom = '$tname';"	;
			$stmt = Database::getInstance()->request($sql, false, false);
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
}
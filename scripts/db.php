<?php

$path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/db_c.php";
include_once("$path");
session_start();

/** Classe de gestion de la base de données [Model]*/

class Database
{
	/** Instanciation de PDO */
	private $_PDOInstance;

	/** Instance de Database */
	private static $_instance = null;
	

	/*----------------------------------------*/

	/** Constructeur  */

	private function __construct()
	{
		try
		{
			$options = 
						[
							PDO::MYSQL_ATTR_INIT_COMMAND =>"SET NAMES utf8",
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
							PDO::ATTR_EMULATE_PREPARES => false
						];
			$this->_PDOInstance = new PDO('mysql:host='.BDD_HOST.';dbname='.BDD_DATABASE, BDD_USER, BDD_PASSWORD, $options);
		}
		catch(PDOException $e)
		{
			exit($e->getMessage());
		}
	}

	/*----------------------------------------*/

	/** Retourne Instance de BDD  */

	public static function getInstance()
	{
		if(is_null(self::$_instance))
			self::$_instance = new Database();

		return self::$_instance;
	}

	/**
	*Requête SQL
	*
	*@param $sql la Requete
	*@param $fields Traitement de champs
	*@param $multiple Plusieurs resultats
	*/

	
	public function request($sql, $fields = false, $multiple = false)
	{
		try
		{
			$statement = $this->_PDOInstance->prepare($sql);

			if($fields)
			{
				foreach($fields as $key => $value)
				{
					if(is_int($value))
						$dataType = PDO::PARAM_INT;
					else if(is_bool($value))
						$dataType = PDO::PARAM_BOOL;
					else if(is_null($value))
						$dataType = PDO::PARAM_NULL;
					else
						$dataType = PDO::PARAM_STR;

					$statement->bindValue(':'.$key, $value, $dataType);
				}
			}
			$statement->execute();

			if($multiple)
				$result = $statement->fetchAll(PDO::FETCH_OBJ);
			else
				$result = $statement->fetch(PDO::FETCH_OBJ);

			$statement->closeCursor();

			return $result;
		}
		catch(Exception $e)
		{
			exit($e->getMessage());
		}
	}	
}

/**
*
*Fichier de gestion utilisateurs
*/
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/quartier/scripts/user.php";
include_once("$path");
<?php

/** Classe de gestion des utilisateurs [Model] */

$path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/db.php";
include_once("$path");


class User
{

	/** Fonction d'inscription  */

	public function register($uname,$upass,$uphone,$umail,$unom,$uprenom,$ucb)
	{
		try
		{
			$new_password = password_hash($upass, PASSWORD_DEFAULT);

			$sql = "INSERT INTO users(Nom,Prenom,Pseudo,Mdp,mail,Telephone,cartebancaire,Creationtime) 
			VALUES('$unom', '$uprenom', '$uname', '$new_password', '$umail', '$uphone', '$ucb', CURRENT_TIMESTAMP)";

			$stmt = Database::getInstance()->request($sql, false, false);   
			return $stmt; 
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}    			$sql = "SELECT COUNT(*) as login_match FROM users 
			WHERE Pseudo='$ident' 
			OR mail='$ident' 
			LIMIT 1";

			$stmt = Database::getInstance()->request($sql, false, false);   
	}

	/*----------------------------------------*/

	/** Fonction de connexion  */

	public function login($ident,$upass)
	{
		try
		{
			$sql = "SELECT COUNT(*) as login_match FROM users 
			WHERE Pseudo='$ident' 
			OR mail='$ident' 
			LIMIT 1";

			$stmt = Database::getInstance()->request($sql, false, false);   
			if($stmt->login_match > 0)
			{
				$sql = "SELECT * FROM users 
				WHERE Pseudo='$ident' 
				OR mail='$ident' 
				LIMIT 1";
				$stmt = Database::getInstance()->request($sql, false, false); 
				if(password_verify($upass, $stmt->Mdp))
				{
					$_SESSION['user_session'] = $stmt->Pseudo;
					$_SESSION['user_mail'] = $stmt->mail;
					$_SESSION['user_phone'] = $stmt->Telephone;
					$_SESSION['user_card'] = $stmt->cartebancaire;
					return true;
				}
			}
			else
			{
				return false;
			}
		}

		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	/*----------------------------------------*/

	/** Fonction de connexion  */

	public function unRegister($uname)
	{
		try
		{
			$sql = "DELETE FROM users
					WHERE Pseudo = '$uname';"	;
			$stmt = Database::getInstance()->request($sql, false, false);
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	/*----------------------------------------*/
	
	/** Fonction de vérification d'êtat de connexion  */


	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}

	/*----------------------------------------*/

	/** Fonction de redirection  */

	public function redirect($url)
	{
		header("Location: $url");
	}

	/*----------------------------------------*/

	/** Fonction de deconnexion  */


	public function logout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}


}
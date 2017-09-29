<?php

	define("ERR_MISSING_FIELDS", "Des champs attendus sont requis");
	define("ERR_EMAIL_FORMAT", "L'adresse mail n'est pas dans un format valide");
	define("ERR_SQL_FAILURE", "Une erreur MySQL est survenue : ");
	
	function updateMetaData()
	{
		if(isset($_POST['meta_websiteName'], $_POST['meta_websiteRoot'], $_POST['meta_ownerMail'], $_POST['meta_corpName'], $_POST['meta_corpAdress1'], $_POST['meta_corpCP'], $_POST['meta_corpCity'], $_POST['meta_corpCountry'], $_POST['meta_corpPhone']))
		{
			$websiteName = htmlspecialchars($_POST['meta_websiteName']);
			$websiteRoot = htmlspecialchars($_POST['meta_websiteRoot']);
			$ownerMail = htmlspecialchars($_POST['meta_ownerMail']);
			$websiteIntro = isset($_POST['meta_websiteIntro']) && !is_null($_POST['meta_websiteIntro']) && $_POST['meta_websiteIntro'] != '' ? $_POST['meta_websiteIntro'] : null;
			$corpName = htmlspecialchars($_POST['meta_corpName']);
			$corpAdress1 = htmlspecialchars($_POST['meta_corpAdress1']);
			$corpAdress2 = (isset($_POST['meta_corpAdress2']) && $_POST['meta_corpAdress2'] != '' ? htmlspecialchars($_POST['meta_corpAdress2']) : null);
			$corpCP = htmlspecialchars($_POST['meta_corpCP']);
			$corpCity = htmlspecialchars($_POST['meta_corpCity']);
			$corpCountry = htmlspecialchars($_POST['meta_corpCountry']);
			$corpPhone = htmlspecialchars($_POST['meta_corpPhone']);

			if(!filter_var($ownerMail, FILTER_VALIDATE_EMAIL))
				return ERR_EMAIL_FORMAT;
			if(strlen($corpCP) != 5 || !is_numeric($corpCP))
				return "Le code postal n'est pas au bon format";

			try
			{
				$query = $GLOBALS['db']->prepare('UPDATE meta SET websiteTitle = ?, websiteRoot = ?, ownerMail = ?, websiteIntro = ?, corporationName = ?, corporationAdress1 = ?, corporationAdress2 = ?, corporationCP = ?, corporationCity = ?, corporationCountry = ?, corporationPhone = ? WHERE id = 1');
				$query->execute(array($websiteName, $websiteRoot, $ownerMail, $websiteIntro, $corpName, $corpAdress1, $corpAdress2, $corpCP, $corpCity, $corpCountry, $corpPhone));
			}
			catch(Exception $ex)
			{
				return ERR_SQL_FAILURE . $ex->getMessage();
			}

			return 'success';
		}
		else
			return ERR_MISSING_FIELDS;
	}

	function authUser()
	{
		if(isset($_POST["login"], $_POST["pass"]))
		{
			try
			{
				$query = $GLOBALS['db']->prepare("SELECT mail, password FROM users WHERE mail = ?");
				$query->execute(array(htmlspecialchars($_POST["login"])));

				if($row = $query->fetch())
					if(password_verify(htmlspecialchars($_POST["pass"]), $row['password']))
						return true;
			}
			catch (Exception $e)
			{
				echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-label="Fermer"><span aria-hidden="true">&times;</span></button>ERREUR: ' . $e->getMessage() . '</div>';
			}
		}
		
		return false;
	}

	function editProfile()
	{
		if(!isset($_SESSION['currentUser']['mail'], $_POST['profile_mail'], $_POST['profile_username']))
			return ERR_MISSING_FIELDS;

		if(!filter_var($_POST['profile_mail'], FILTER_VALIDATE_EMAIL))
			return ERR_EMAIL_FORMAT;

		$currMail = htmlspecialchars($_SESSION['currentUser']['mail']);
		$mail = htmlspecialchars($_POST['profile_mail']);
		$username = htmlspecialchars($_POST['profile_username']);

		$name = isset($_POST['profile_name']) && $_POST['profile_name'] != '' && !is_null($_POST['profile_name']) ? htmlspecialchars($_POST['profile_name']) : null;
		$firstname = isset($_POST['profile_firstname']) && $_POST['profile_firstname'] != '' && !is_null($_POST['profile_firstname']) ? htmlspecialchars($_POST['profile_firstname']) : null;
		$adress1 = isset($_POST['profile_adress1']) && $_POST['profile_adress1'] != '' && !is_null($_POST['profile_adress1']) ? htmlspecialchars($_POST['profile_adress1']) : null;
		$adress2 = isset($_POST['profile_adress2']) && $_POST['profile_adress2'] != '' && !is_null($_POST['profile_adress2']) ? htmlspecialchars($_POST['profile_adress2']) : null;
		$postalCode = isset($_POST['profile_postalCode']) && $_POST['profile_postalCode'] != '' && !is_null($_POST['profile_postalCode']) ? htmlspecialchars($_POST['profile_postalCode']) : null;
		$city = isset($_POST['profile_city']) && $_POST['profile_city'] != '' && !is_null($_POST['profile_city']) ? strtoupper(htmlspecialchars($_POST['profile_city'])) : null;
		$country = isset($_POST['profile_country']) && $_POST['profile_country'] != '' && !is_null($_POST['profile_country']) ? htmlspecialchars($_POST['profile_country']) : null;
		$phone = isset($_POST['profile_phone']) && $_POST['profile_phone'] != '' && !is_null($_POST['profile_phone']) ? htmlspecialchars($_POST['profile_phone']) : null;

		if(!is_null($postalCode) && (!is_numeric($postalCode) || strlen($postalCode) != 5))
			return "Le code postal n'est pas dans un format valide";

		try
		{
			$GLOBALS['db']->beginTransaction();

			if(isset($_POST['profile_oldPassword'], $_POST['profile_newPassword1'], $_POST['profile_newPassword2']) && $_POST['profile_oldPassword'] != '' && !is_null($_POST['profile_oldPassword']))
			{
				$query = $GLOBALS['db']->query("SELECT password FROM users WHERE mail = '" . $currMail . "'");

				if($row = $query->fetch())
				{
					if(!password_verify($_POST['profile_oldPassword'], $row['password']))
						return "Votre ancien mot de passe est invalide";
				}
				else return "Une erreur est survenue : impossible de changer le mot de passe";

				if($_POST['profile_newPassword1'] != $_POST['profile_newPassword2'])
					return "Vos mots de passe ne correspondent pas";

				if(strlen($_POST['profile_newPassword1']) < 6)
					return "Votre mot de passe doit être composé d'au moins 6 caractères";

				$query = $GLOBALS['db']->prepare("UPDATE users SET password = ? WHERE mail = ?");
				$query->execute(array(password_hash(htmlspecialchars($_POST['profile_newPassword1']), PASSWORD_BCRYPT), $currMail));
			}

			$query = $GLOBALS['db']->prepare("UPDATE users SET mail = ?, username = ?, name = ?, firstname = ?, adress1 = ?, adress2 = ?, postalCode = ?, city = ?, country = ?, phone = ? WHERE mail = ?");
			$query->execute(array($mail, $username, $name, $firstname, $adress1, $adress2, $postalCode, $city, $country, $phone, $currMail));

			$_SESSION['currentUser']['mail'] = $mail;
			$GLOBALS['db']->commit();

			return 'success';
		}
		catch(Exception $e)
		{
			$GLOBALS['db']->rollback();
			return ERR_SQL_FAILURE . $e->getMessage();
		}
	}

	function getLastInsertedUsers()
	{
		try
		{
			$res = $GLOBALS['db']->query("SELECT * FROM users ORDER BY inscriptionDate DESC LIMIT 10");
			return $res;
		}
		catch(Exception $ex)
		{
			die(ERR_SQL_FAILURE . $ex->getMessage());
		}

		return null;
	}

	function getUsers()
	{
		try
		{
			$res = $GLOBALS['db']->query("SELECT * FROM users ORDER BY inscriptionDate");
			return $res;
		}
		catch(Exception $ex)
		{
			die(ERR_SQL_FAILURE . $ex->getMessage());
		}

		return ($a=array());
	}

	function getMeetings()
	{
		try
		{
			$res = $GLOBALS['db']->query("SELECT * FROM meetings ORDER BY meetingDate ASC");
			return $res;
		}
		catch(Exception $ex)
		{
			die(ERR_SQL_FAILURE . $ex->getMessage());
		}

		return ($a=array());
	}

	function getProfileDataFromDB($mail)
	{
		$query = $GLOBALS['db']->query("SELECT * FROM users WHERE mail = '" . htmlspecialchars($mail) . "'");
		if($row = $query->fetch())
			return $row;

		return (array());
	}

	function deleteSelectedUsers()
	{
		if(isset($_POST['deleteSelectedUsers']))
		{
			$GLOBALS['db']->beginTransaction();
			foreach ($_POST['selectSingle'] as $cb)
			{
				try
				{
					$GLOBALS['db']->query("DELETE FROM users WHERE mail = '" . htmlspecialchars($cb) . "'");
				}
				catch(Exception $ex)
				{
					$GLOBALS['db']->rollback();
					return ERR_SQL_FAILURE . $ex->getMessage();
				}

				$GLOBALS['db']->commit();
				return 'success';
			}
		}
		else
			return ERR_MISSING_FIELDS;
	}

	function deleteSelectedUser()
	{
		if(isset($_POST['deleteSingle']))
		{
			try
			{
				$GLOBALS['db']->query("DELETE FROM users WHERE mail = '" . htmlspecialchars($_POST['deleteSingle']) . "'");
			}
			catch(Exception $ex)
			{
				return ERR_SQL_FAILURE . $ex->getMessage();
			}

			return 'success';
		}
		else
			return ERR_MISSING_FIELDS;
	}

	function addUserToDB()
	{
		if(isset($_POST['addUser_mail'], $_POST['addUser_username'],$_POST['addUser_password1'],$_POST['addUser_password2'],$_POST['addUser_confirm'],$_POST['addUser_role']))
		{
			$mail = htmlspecialchars($_POST['addUser_mail']);
			$username = htmlspecialchars($_POST['addUser_username']);
			$password1 = htmlspecialchars($_POST['addUser_password1']);
			$password2 = htmlspecialchars($_POST['addUser_password2']);
			$confirm = htmlspecialchars($_POST['addUser_confirm']);
			$role = htmlspecialchars($_POST['addUser_role']);
			$firstname = isset($_POST['addUser_firstname']) && $_POST['addUser_firstname'] != null ? htmlspecialchars($_POST['addUser_firstname']) : null;
			$name = isset($_POST['addUser_name']) && $_POST['addUser_name'] != null ? htmlspecialchars($_POST['addUser_name']) : null;
			$adress1 = isset($_POST['addUser_adress1']) && $_POST['addUser_adress1'] != null ? htmlspecialchars($_POST['addUser_adress1']) : null;
			$adress2 = isset($_POST['addUser_adress2']) && $_POST['addUser_adress2'] != null ? htmlspecialchars($_POST['addUser_adress2']) : null;
			$city = isset($_POST['addUser_city']) && $_POST['addUser_city'] != null ? htmlspecialchars($_POST['addUser_city']) : null;
			$cp = isset($_POST['addUser_cp']) && $_POST['addUser_cp'] != null ? htmlspecialchars($_POST['addUser_cp']) : null;
			$country = isset($_POST['addUser_country']) && $_POST['addUser_country'] != null ? htmlspecialchars($_POST['addUser_country']) : null;
			$phone = isset($_POST['addUser_phone']) && $_POST['addUser_phone'] != null ? htmlspecialchars($_POST['addUser_phone']) : null;

			$err = "";

			if(!filter_var($mail, FILTER_VALIDATE_EMAIL))
				$err .= "<li>L'adresse mail n'est pas au bon format</li>";
			if(userMailExists($mail))
				$err .= "<li>L'adresse mail est déjà utilisée</li>";
			if(userUsernameExists($username))
				$err .= "<li>Le nom d'utilisateur est déjà utilisé</li>";
			if(strlen($password1) < 8)
				$err .= "<li>Votre mot de passe doit contenir au moins 8 caractères</li>";

			{
				$ok = false;
				for($i = 48; $i < 58; $i++)
				{
					if(strrchr($password1, $i) != -1)
						$ok = true;
				}

				if(!$ok)
					$err .= "<li>Votre mot de passe doit contenir au moins un chiffre</li>";
			}

			if($password1 != $password2)
				$err .= "<li>Vos mots de passe ne correspondent pas</li>";

			if($cp != null && (!is_numeric($cp) || $cp < 10000 || $cp > 99999))
				$err .= "<li>Le code postal n'est pas un nombre valide</li>";
			/*if($phone != null && (preg_match("/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im", $phone)))
				$err .= "<li>Le numéro de téléphone n'est pas dans un format valide</li>";*/

			{
				$ok = false;
				$roles = getRoles();
				foreach($roles as $row)
					if($row == $role) {$ok = true; break;}

				if(!$ok)
					$err .= "<li>Le rôle sélectionné n'existe pas</li>";
			}

			if(strlen($err) == 0)
			{
				try
				{
					$pass = password_hash($password1, PASSWORD_BCRYPT);
					$seed = password_hash($mail, PASSWORD_BCRYPT);

					$query = $GLOBALS['db']->prepare("INSERT INTO users VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP(), NULL)");
					$query->execute(array($mail, $username, $pass, $name, $firstname, $adress1, $adress2, $cp, $city, $country, $phone, $role, ($confirm == 'force' ? NULL : $seed), ($confirm == 'force' ? true : false)));

					if($confirm != 'force')
						mail($mail, "Confirmation d'inscription au site" . getWebsiteTitle(), 'Votre compte a bien été créé mais n\'est pas encore activé. Pour le débloquer, rendez-vous à cette page : <a href="' . getWebsiteURL() . '/validation.php?value=' . $seed . '">' . getWebsiteURL() .'/validation.php?value=' . $seed . '</a>');

					return 'success';
				}
				catch(Exception $ex)
				{
					$err .= "<li>Une erreur MySQL est survenue : " . $ex->getMessage() . "</li>";
				}
			}

			return '<ul>' . $err . '</ul>';
		}
		
		return ERR_MISSING_FIELDS;
	}

	function addMeetingToDB()
	{
		if(!isset($_POST['addMeeting_name'], $_POST['addMeeting_location'],$_POST['addMeeting_date'], $_POST['addMeeting_description']))
			return ERR_MISSING_FIELDS;

		if(is_null($_POST['addMeeting_name']) || $_POST['addMeeting_name'] == '')
			return "Le nom du salon ne peut pas être vide ou null";

		if(is_null($_POST['addMeeting_location']) || $_POST['addMeeting_location'] == '')
			return "Le lieu du salon ne peut pas être vide ou null";

		if(is_null($_POST['addMeeting_description']) || $_POST['addMeeting_description'] == '')
			return "La description du salon ne peut pas être vide ou null";

		if(is_null($_POST['addMeeting_date']) || $_POST['addMeeting_date'] == '')
			return "La date du salon ne peut pas être vide ou null";

		$name = htmlspecialchars($_POST['addMeeting_name']);
		$location = htmlspecialchars($_POST['addMeeting_location']);
		$description = htmlspecialchars($_POST['addMeeting_description']);
		$links = isset($_POST['addMeeting_links']) && $_POST['addMeeting_links'] != '' ? htmlspecialchars($_POST['addMeeting_links']) : null;

		$date = date_create(htmlspecialchars($_POST['addMeeting_date']) . '00:00:00');
		if(!$date)
			return "La date n'est pas au bon format";
		
		if(!checkdate((int)date_format($date, 'm'), (int)date_format($date, 'd'), (int)date_format($date, 'Y')))
			return "La date n'est pas au bon format";

		try
		{
			$query = $GLOBALS['db']->prepare("INSERT INTO meetings VALUES(NULL, ?, ?, ?, ?, ?)");
			$query->execute(array($name, date_format($date, 'Y-m-d'), $location, $description, $links));
			return 'success';
		}
		catch(Exception $e)
		{
			return ERR_SQL_FAILURE . $e->getMessage();
		}
	}

	function addStoneToDB()
	{
		if(!isset($_POST['addStone_name'], $_POST['addStone_description']))
			return ERR_MISSING_FIELDS;

		if(is_null($_POST['addStone_name']) || $_POST['addStone_name'] == '')
			return 'Le nom de la pierre ne peut être vide ou null';

		$name = htmlspecialchars($_POST['addStone_name']);
		$description = (is_null($_POST['addStone_description']) || $_POST['addStone_description'] == '') ? null : htmlspecialchars($_POST['addStone_description']);

		try
		{
			$query = $GLOBALS['db']->query("SELECT id FROM stones WHERE name = '" . $name . "'");
			if($row = $query->fetch())
				return 'Cette pierre existe déjà dans la base';

			$query = $GLOBALS['db']->prepare("INSERT INTO stones VALUES (NULL, ?, ?)");
			$query->execute(array($name, $description));
			return 'success';
		}
		catch(Exception $e)
		{
			return ERR_SQL_FAILURE . $e->getMessage();
		}
	}

	function editStoneToDB()
	{
		if(!isset($_GET['id'], $_POST['editStone_name'], $_POST['editStone_description']))
			return ERR_MISSING_FIELDS;

		if(is_null($_POST['editStone_name']) || $_POST['editStone_name'] == '')
			return 'Le nom de la pierre ne peut être vide ou null';

		$name = htmlspecialchars($_POST['editStone_name']);
		$description = (is_null($_POST['editStone_description']) || $_POST['editStone_description'] == '') ? null : htmlspecialchars($_POST['editStone_description']);

		try
		{
			// Vérification en cas de changement de nom de la pierre
			$query = $GLOBALS['db']->query("SELECT id FROM stones WHERE name = '" . $name . "'");
			if($row = $query->fetch())
				if($row['id'] != $_GET['id']) // Si nom inchangé, ce code sera FALSE
					return 'Cette pierre existe déjà dans la base';

			$query = $GLOBALS['db']->prepare("UPDATE stones SET name = ?, description = ? WHERE id = ?");
			$query->execute(array($name, $description, htmlspecialchars($_GET['id'])));
			return 'success';
		}
		catch(Exception $e)
		{
			return ERR_SQL_FAILURE . $e->getMessage();
		}
	}

	function addArticleToDB()
	{
		if(!isset($_POST['addArticle_name'], $_POST['addArticle_description'], $_POST['addArticle_category'], $_POST['addArticle_price'], $_POST['addArticle_quantity']))
			return ERR_MISSING_FIELDS;

		if(!isset($_POST['addArticle_composition']))
			return "Vous devez au moins sélectionner une pierre dans la composition";

		if(is_null($_POST['addArticle_name']) || $_POST['addArticle_name'] == '')
			return "Le nom de l'article ne peut être vide ou null";

		if(is_null($_POST['addArticle_description']) || $_POST['addArticle_description'] == '')
			return "La description de l'article ne peut être vide ou null";

		if(!in_array(htmlspecialchars($_POST['addArticle_category']), getCategoriesBy('name')))
			return "La catégorie sélectionnée n'est pas valide";

		if(!is_numeric($_POST['addArticle_price']) || $_POST['addArticle_price'] < 0)
			return "Le prix doit être un nombre valide supérieur ou égal à 0";

		if(!is_numeric($_POST['addArticle_quantity']) || $_POST['addArticle_quantity'] < 0)
			return "La quantité doit être un nombre valide supérieur ou égal à 0";

		if(isset($_POST['addArticle_weight']) && is_numeric($_POST['addArticle_weight']) && $_POST['addArticle_weight'] < 0)
			return "Le poids de l'article n'est pas un nombre ou est invalide";

		if(isset($_POST['addArticle_length']) && is_numeric($_POST['addArticle_length']) && $_POST['addArticle_length'] < 0)
			return "La longueur de l'article n'est pas un nombre ou est invalide";

		$name = htmlspecialchars($_POST['addArticle_name']);
		$description = (is_null($_POST['addArticle_description']) || $_POST['addArticle_description'] == '') ? null : htmlspecialchars($_POST['addArticle_description']);
		$category = htmlspecialchars($_POST['addArticle_category']);
		$price = floatval(htmlspecialchars($_POST['addArticle_price']));
		$weight = isset($_POST['addArticle_weight']) && (is_null($_POST['addArticle_weight']) || $_POST['addArticle_weight'] == '') ? null : htmlspecialchars($_POST['addArticle_weight']);
		$length = isset($_POST['addArticle_length']) && (is_null($_POST['addArticle_length']) || $_POST['addArticle_length'] == '') ? null : htmlspecialchars($_POST['addArticle_length']);
		$quantity = intval(htmlspecialchars($_POST['addArticle_quantity']));

		try
		{
			$GLOBALS['db']->beginTransaction();

			$query = $GLOBALS['db']->prepare("INSERT INTO articles VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, 0, NULL)");
			$query->execute(array($name, $category, $description, $price, $weight, $length, $quantity/*, $delivery, $picture*/));

			$id = $GLOBALS['db']->lastInsertId();

			// SET COMPOSITION
			{
				$ids = array();
				for($i = 0; $i < sizeof($_POST['addArticle_composition']); $i++)
				{
					$query = $GLOBALS['db']->prepare("SELECT id FROM stones WHERE name = ?");
					$query->execute(array(htmlspecialchars($_POST['addArticle_composition'][$i])));
					if($row = $query->fetch())
						array_push($ids, $row['id']);
				}

				for($i = 0; $i < sizeof($ids); $i++)
				{
					$query = $GLOBALS['db']->prepare("INSERT INTO rel_articles_stones VALUES(?, ?)");
					$query->execute(array($id, $ids[$i]));
				}
			}
			
			$GLOBALS['db']->commit();
			return 'success';
		}
		catch(Exception $e)
		{
			$GLOBALS['db']->rollback();
			return ERR_SQL_FAILURE . $e->getMessage();
		}
	}

	function editArticleToDB()
	{
		if(!isset($_GET['id'], $_POST['editArticle_name'], $_POST['editArticle_description'], $_POST['editArticle_category'], $_POST['editArticle_price'], $_POST['editArticle_quantity']))
			return ERR_MISSING_FIELDS;

		if(!isset($_POST['editArticle_composition']))
			return "Vous devez au moins sélectionner une pierre dans la composition";

		if(is_null($_POST['editArticle_name']) || $_POST['editArticle_name'] == '')
			return "Le nom de l'article ne peut être vide ou null";

		if(is_null($_POST['editArticle_description']) || $_POST['editArticle_description'] == '')
			return "La description de l'article ne peut être vide ou null";

		if(!in_array(htmlspecialchars($_POST['editArticle_category']), getCategoriesBy('name')))
			return "La catégorie sélectionnée n'est pas valide";

		if(!is_numeric($_POST['editArticle_price']) || $_POST['editArticle_price'] < 0)
			return "Le prix doit être un nombre valide supérieur ou égal à 0";

		if(!is_numeric($_POST['editArticle_quantity']) || $_POST['editArticle_quantity'] < 0)
			return "La quantité doit être un nombre valide supérieur ou égal à 0";

		if(isset($_POST['editArticle_weight']) && is_numeric($_POST['editArticle_weight']) && $_POST['editArticle_weight'] < 0)
			return "Le poids de l'article n'est pas un nombre ou est invalide";

		if(isset($_POST['editArticle_length']) && is_numeric($_POST['editArticle_length']) && $_POST['editArticle_length'] < 0)
			return "La longueur de l'article n'est pas un nombre ou est invalide";

		$name = htmlspecialchars($_POST['editArticle_name']);
		$description = (is_null($_POST['editArticle_description']) || $_POST['editArticle_description'] == '') ? null : htmlspecialchars($_POST['editArticle_description']);
		$category = htmlspecialchars($_POST['editArticle_category']);
		$price = floatval(htmlspecialchars($_POST['editArticle_price']));
		$weight = isset($_POST['editArticle_weight']) && (is_null($_POST['editArticle_weight']) || $_POST['editArticle_weight'] == '') ? null : htmlspecialchars($_POST['editArticle_weight']);
		$length = isset($_POST['editArticle_length']) && (is_null($_POST['editArticle_length']) || $_POST['editArticle_length'] == '') ? null : htmlspecialchars($_POST['editArticle_length']);
		$quantity = intval(htmlspecialchars($_POST['editArticle_quantity']));

		try
		{
			$GLOBALS['db']->beginTransaction();

			$query = $GLOBALS['db']->prepare("UPDATE articles SET name = ?, description = ?, category = ?, price = ?, weight = ?, length = ?, quantity = ? WHERE id = ?");
			$query->execute(array($name, $description, $category, $price, $weight, $length, $quantity, htmlspecialchars($_GET['id'])));

			// SET COMPOSITION
			{
				// remove actual composition
				$query = $GLOBALS['db']->prepare("DELETE FROM rel_articles_stones WHERE idArticle = ?");
				$query->execute(array(htmlspecialchars($_GET['id'])));

				$ids = array();
				for($i = 0; $i < sizeof($_POST['editArticle_composition']); $i++)
				{
					// get stones id from DB
					$query = $GLOBALS['db']->prepare("SELECT id FROM stones WHERE name = ?");
					$query->execute(array(htmlspecialchars($_POST['editArticle_composition'][$i])));
					if($row = $query->fetch())
						array_push($ids, $row['id']);
				}

				// inserting new data
				for($i = 0; $i < sizeof($ids); $i++)
				{
					$query = $GLOBALS['db']->prepare("INSERT INTO rel_articles_stones VALUES(?, ?)");
					$query->execute(array(htmlspecialchars($_GET['id']), $ids[$i]));
				}
			}

			$GLOBALS['db']->commit();
			return 'success';
		}
		catch(Exception $e)
		{
			$GLOBALS['db']->rollback();
			return ERR_SQL_FAILURE . $e->getMessage();
		}
	}

	function editUser()
	{
		if(isset($_POST['editUser_mail'], $_POST['editUser_username']))
		{
			$mail = htmlspecialchars($_POST['editUser_mail']);
			$username = htmlspecialchars($_POST['editUser_username']);
			$password1 = isset($_POST['editUser_password1']) && $_POST['editUser_password1'] != null ? htmlspecialchars($_POST['editUser_password1']) : null;
			$password2 = isset($_POST['editUser_password2']) && $_POST['editUser_password2'] != null ? htmlspecialchars($_POST['editUser_password2']) : null;
			$confirm = isset($_POST['editUser_confirm']) && $_POST['editUser_confirm'] != null ? htmlspecialchars($_POST['editUser_confirm']) : null;
			$role = htmlspecialchars($_POST['editUser_role']);
			$firstname = isset($_POST['editUser_firstname']) && $_POST['editUser_firstname'] != null ? htmlspecialchars($_POST['editUser_firstname']) : null;
			$name = isset($_POST['editUser_name']) && $_POST['editUser_name'] != null ? htmlspecialchars($_POST['editUser_name']) : null;
			$adress1 = isset($_POST['editUser_adress1']) && $_POST['editUser_adress1'] != null ? htmlspecialchars($_POST['editUser_adress1']) : null;
			$adress2 = isset($_POST['editUser_adress2']) && $_POST['editUser_adress2'] != null ? htmlspecialchars($_POST['editUser_adress2']) : null;
			$city = isset($_POST['editUser_city']) && $_POST['editUser_city'] != null ? htmlspecialchars($_POST['editUser_city']) : null;
			$cp = isset($_POST['editUser_cp']) && $_POST['editUser_cp'] != null ? htmlspecialchars($_POST['editUser_cp']) : null;
			$country = isset($_POST['editUser_country']) && $_POST['editUser_country'] != null ? htmlspecialchars($_POST['editUser_country']) : null;
			$phone = isset($_POST['editUser_phone']) && $_POST['editUser_phone'] != null ? htmlspecialchars($_POST['editUser_phone']) : null;

			$err = "";

			if(!filter_var($mail, FILTER_VALIDATE_EMAIL))
				$err .= "<li>L'adresse mail n'est pas au bon format</li>";
			if($mail != $_GET['user'] && userMailExists($mail))
				$err .= "<li>L'adresse mail est déjà utilisée !</li>";
			if(userUsernameExists($username))
			{
				try
				{
					$query = $GLOBALS['db']->query("SELECT username FROM users WHERE mail = '" . htmlspecialchars($_GET['user']) . "'");
					if($row = $query->fetch())
						$oldUsername = $row['username'];

					if($oldUsername != $username)
						$err .= "<li>Le nom d'utilisateur est déjà utilisé</li>";
				}
				catch(Exception $ex)
				{
					return "Erreur MySQL survenue : " . $ex->getMessage();
				}
			}
			if($password1 != null && strlen($password1) < 8)
				$err .= "<li>Votre mot de passe doit contenir au moins 8 caractères</li>";

			if($password1 != null)
			{
				$ok = false;
				for($i = 48; $i < 58; $i++)
				{
					if(strrchr($password1, $i) != -1)
						$ok = true;
				}

				if(!$ok)
					$err .= "<li>Votre mot de passe doit contenir au moins un chiffre</li>";
			}

			if($password1 != null && $password1 != $password2)
				$err .= "<li>Vos mots de passe ne correspondent pas</li>";

			if($cp != null && (!is_numeric($cp) || $cp < 10000 || $cp > 99999))
				$err .= "<li>Le code postal n'est pas un nombre valide</li>";
			/*if($phone != null && (preg_match("/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im", $phone)))
				$err .= "<li>Le numéro de téléphone n'est pas dans un format valide</li>";*/

			{
				$ok = false;
				$roles = getRoles();
				foreach($roles as $row)
					if($row == $role) {$ok = true; break;}

				if(!$ok)
					$err .= "<li>Le rôle sélectionné n'existe pas</li>";
			}

			if(strlen($err) == 0)
			{
				try
				{
					$GLOBALS['db']->beginTransaction();

					if(!userMailExists($mail))
					{
						$seed = password_hash($mail, PASSWORD_BCRYPT);

						$query = $GLOBALS['db']->query("SELECT isConfirmed FROM users WHERE mail = '" . htmlspecialchars($_GET['user']) . "'");
						if($row = $query->fetch())
							$oldConfirm = $row['isConfirmed'];

						$query = $GLOBALS['db']->prepare("UPDATE users SET mail = ?, isConfirmed = ?, seed = ? WHERE mail = ?");
						$query->execute(array($mail, $confirm != null ? ($confirm == 'force' ? 1 : 0) : $oldConfirm, $confirm != null && $confirm != 'force' ? $seed : NULL, htmlspecialchars($_GET['user'])));
					}

					if($password1 != null)
					{
						$query = $GLOBALS['db']->prepare("UPDATE users SET password = ? WHERE mail = ?");
						$query->execute(array(password_hash($password1, PASSWORD_BCRYPT), $mail));
					}

					$query = $GLOBALS['db']->prepare("UPDATE users SET username = ?, firstname = ?, name = ?, adress1 = ?, adress2 = ?, city = ?, postalCode = ?, country = ?, phone = ?, role = ? WHERE mail = ?");
					$query->execute(array($username, $firstname, $name, $adress1, $adress2, $city, $cp, $country, $phone, $role, $mail));

					$GLOBALS['db']->commit();

					if($confirm != null && $confirm != 'force')
						mail($mail, "Confirmation d'inscription au site" . getWebsiteTitle(), 'Votre compte a bien été créé mais n\'est pas encore activé. Pour le débloquer, rendez-vous à cette page : <a href="' . getWebsiteURL() . '/validation.php?value=' . $seed . '">' . getWebsiteURL() .'/validation.php?value=' . $seed . '</a>');

					return 'success';
				}
				catch(Exception $ex)
				{
					$GLOBALS['db']->rollback();
					$err .= "<li>Une erreur MySQL est survenue : " . $ex->getMessage() . "</li>";
				}
			}

			return '<ul>' . $err . '</ul>';
		}
		else
			return ERR_MISSING_FIELDS;
	}

	function editMeetingToDB()
	{
		if(!isset($_GET['id'], $_POST['editMeeting_name'], $_POST['editMeeting_location'],$_POST['editMeeting_date'], $_POST['editMeeting_description']))
			return ERR_MISSING_FIELDS;

		if(is_null($_POST['editMeeting_name']) || $_POST['editMeeting_name'] == '')
			return "Le nom du salon ne peut pas être vide ou null";

		if(is_null($_POST['editMeeting_location']) || $_POST['editMeeting_location'] == '')
			return "Le lieu du salon ne peut pas être vide ou null";

		if(is_null($_POST['editMeeting_description']) || $_POST['editMeeting_description'] == '')
			return "La description du salon ne peut pas être vide ou null";

		if(is_null($_POST['editMeeting_date']) || $_POST['editMeeting_date'] == '')
			return "La date du salon ne peut pas être vide ou null";

		if(!doesMeetingExist(htmlspecialchars($_GET['id'])))
			return "Le meeting n'existe pas";

		$name = htmlspecialchars($_POST['editMeeting_name']);
		$location = htmlspecialchars($_POST['editMeeting_location']);
		$description = htmlspecialchars($_POST['editMeeting_description']);
		$links = isset($_POST['editMeeting_links']) && $_POST['editMeeting_links'] != '' ? htmlspecialchars($_POST['editMeeting_links']) : null;

		$date = date_create(htmlspecialchars($_POST['editMeeting_date']) . '00:00:00');
		if(!$date)
			return "La date n'est pas au bon format";
		
		if(!checkdate((int)date_format($date, 'm'), (int)date_format($date, 'd'), (int)date_format($date, 'Y')))
			return "La date n'est pas au bon format";

		try
		{
			$query = $GLOBALS['db']->prepare("UPDATE meetings SET name = ?, meetingDate = ?, location = ?, description = ?, link = ? WHERE id = ?");
			$query->execute(array($name, date_format($date, 'Y-m-d'), $location, $description, $links, htmlspecialchars($_GET['id'])));
			return 'success';
		}
		catch(Exception $e)
		{
			return ERR_SQL_FAILURE . $e->getMessage();
		}
	}

	function editContentToDB()
	{
		if(!isset($_GET['id'], $_POST['editContent_title'], $_POST['editContent_content']))
			return ERR_MISSING_FIELDS;

		if(is_null($_POST['editContent_title']) || $_POST['editContent_title'] == '')
			return 'Le titre ne peut pas être vide ou null';

		$title = htmlspecialchars($_POST['editContent_title']);
		$content = is_null($_POST['editContent_content']) || $_POST['editContent_content'] == '' ? null :  $_POST['editContent_content'];

		try
		{
			$query = $GLOBALS['db']->prepare("UPDATE contents SET title = ?, content = ?, updatedOn = CURRENT_TIMESTAMP() WHERE id = ?");
			$query->execute(array($title, $content, htmlspecialchars($_GET['id'])));
			return 'success';
		}
		catch(Exception $e)
		{
			return ERR_SQL_FAILURE . $e->getMessage();
		}
	}

	function updateCategory()
	{
		if(!isset($_POST['selectEditCatButton'], $_POST['selectEditCat'], $_POST['editCatName'], $_POST['editCatDesc']))
			return ERR_MISSING_FIELDS;

		if(!categoryExists($_POST['selectEditCat']))
			return 'La valeur sélectionnée de la liste déroulante est invalide ("' . htmlspecialchars($_POST['selectEditCat']) . '")';

		if($_POST['editCatName'] == null || $_POST['editCatName'] == "")
			return 'Le nom de la catégorie ne peut être nulle ou vide';

		try
		{
			$query = $GLOBALS['db']->prepare("UPDATE categories SET name = ?, description = ? WHERE name = ?");
			$query->execute(array($_POST['editCatName'], $_POST['editCatDesc'] == null || $_POST['editCatDesc'] == "" ? NULL : $_POST['editCatDesc'], $_POST['selectEditCat']));

			return 'success';
		}
		catch(Exception $ex)
		{
			return ERR_SQL_FAILURE . $ex->getMessage();
		}

		return 'Le programme a atteint un point invalide, votre requête peut ne pas avoir été exécutée';
	}

	function updateCategoriesPriority()
	{
		if(!isset($_POST['selectCat']))
			return ERR_MISSING_FIELDS;

		if(count(getCategoriesBy()) != count($_POST['selectCat']))
			return "Le nombre d'éléments est invalide";

		try
		{
			$GLOBALS['db']->beginTransaction();
			$GLOBALS['db']->query("ALTER TABLE categories DROP INDEX priority");

			for($i = count($_POST['selectCat'], $t = 0); $i > 0; $i--, $t++)
			{
				$query = $GLOBALS['db']->prepare("UPDATE categories SET priority = ? WHERE name = ?");
				$query->execute(array($i, htmlspecialchars($_POST['selectCat'][$t])));
			}

			$GLOBALS['db']->query("ALTER TABLE categories ADD UNIQUE(priority)");

			$GLOBALS['db']->commit();
			return 'success';
		}
		catch(Exception $ex)
		{
			$GLOBALS['db']->rollback();
			return 'Erreur MySQL : ' . $ex->getMessage();
		}

		return 'Le programme a atteint un point invalide, votre requête peut ne pas avoir été exécutée';
	}

	function deleteCategory()
	{
		if(!isset($_POST['deleteCat']))
			return ERR_MISSING_FIELDS;

		if(!categoryExists(htmlspecialchars($_POST['deleteCat'])))
			return 'La catégorie sélectionnée n\'existe pas';

		try
		{
			$GLOBALS['db']->query("DELETE FROM categories WHERE name = '" . htmlspecialchars($_POST['deleteCat']) . "'");
			return 'success';
		}
		catch(Exception $ex)
		{
			return 'Erreur MySQL : ' . $ex->getMessage();
		}

		return 'Le programme a atteint un point invalide, votre requête peut ne pas avoir été exécutée';
	}

	function addCategory()
	{
		if(!isset($_POST['addCat']))
			return ERR_MISSING_FIELDS;

		try
		{
			$GLOBALS['db']->query("INSERT INTO categories (name, priority, description) SELECT  '" . htmlspecialchars($_POST['addCat']) . "', MAX(priority)+1, NULL FROM categories");
			return 'success';
		}
		catch(Exception $ex)
		{
			return 'Erreur MySQL : ' . $ex->getMessage();
		}

		return 'Le programme a atteint un point invalide, votre requête peut ne pas avoir été exécutée';
	}

	function updateStone()
	{
		if(!isset($_POST['selectEditStoneButton'], $_POST['selectEditStone'], $_POST['editStoneName'], $_POST['editStoneDesc']))
			return ERR_MISSING_FIELDS;

		if(!stoneExists($_POST['selectEditStone']))
			return 'La valeur sélectionnée de la liste déroulante est invalide ("' . htmlspecialchars($_POST['selectEditStone']) . '")';

		if($_POST['editStoneName'] == null || $_POST['editStoneName'] == "")
			return 'Le nom de la pierre ne peut être nulle ou vide';

		try
		{
			$query = $GLOBALS['db']->prepare("UPDATE stones SET name = ?, description = ? WHERE name = ?");
			$query->execute(array($_POST['editStoneName'], $_POST['editStoneDesc'] == null || $_POST['editStoneDesc'] == "" ? NULL : $_POST['editStoneDesc'], $_POST['selectEditStone']));

			return 'success';
		}
		catch(Exception $ex)
		{
			return ERR_SQL_FAILURE . $ex->getMessage();
		}

		return 'Le programme a atteint un point invalide, votre requête peut ne pas avoir été exécutée';
	}

	function addStone()
	{
		if(!isset($_POST['addStone']))
			return ERR_MISSING_FIELDS;

		try
		{
			$GLOBALS['db']->query("INSERT INTO Stones VALUES('" . $_POST['addStone'] . "', NULL)");
			return 'success';
		}
		catch(Exception $ex)
		{
			return 'Erreur MySQL : ' . $ex->getMessage();
		}

		return 'Le programme a atteint un point invalide, votre requête peut ne pas avoir été exécutée';
	}

	function deleteStone()
	{
		if(!isset($_POST['deleteStone']))
			return ERR_MISSING_FIELDS;

		if(!stoneExists(htmlspecialchars($_POST['deleteStone'])))
			return 'La pierre sélectionnée n\'existe pas';

		try
		{
			$GLOBALS['db']->query("DELETE FROM stones WHERE name = '" . htmlspecialchars($_POST['deleteStone']) . "'");
			return 'success';
		}
		catch(Exception $ex)
		{
			return 'Erreur MySQL : ' . $ex->getMessage();
		}

		return 'Le programme a atteint un point invalide, votre requête peut ne pas avoir été exécutée';
	}

?>
<?php
$path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/db.php";
include_once("$path");

/** Classe de gestion du layout (menu gauche) EN CONSTRUCTION  [Model]*/
class Layout
{
/**
* Fonction retournant le menu de navigation en fonction des permissions
*
* Renvois le menu de navigation
* @var layout['nav']
*/


	public static function getLayout()
	{
			$user = new user();
			$sql = "SELECT * FROM module";
			$stmt = Database::getInstance()->request($sql, false, false); 
			$layout['Nav'] = "<div class=\"navbar\">";
			$layout['Nav'] .="<a class=\"navAccueil\" href=\"/quartier/scripts/path.php?target=Accueil\">Accueil</a>";


			if($stmt->login == 1)
			{
				if($user->is_loggedin())
				{
					$layout['navLogin'] =
												"<div class=\"navDisconnect\"><a class=\"navLogin\" href=\"/quartier/scripts/path.php?target=Logout\">Deconnexion</a>";
					$layout['theme'] =
												"<select name=\"themeengine\" id=\"engine\" onchange=\"window.location = '?newtheme=' + this.value\">
												<option value=\"0\">Choisir Theme</option>
												<option value=\"1\">Ete</option>
												<option value=\"2\">Hiver</option>
												<option value=\"3\">Automne</option>
												</select></div>";
				}
				else{
					$layout['navLogin'] =
											"<div class=\"navConnect\"><a class=\"navLogin\" href=\"/quartier/scripts/path.php?target=connect\">Connexion</a>
											<a class=\"navSubscribe\" href=\"/quartier/scripts/path.php?target=subscribe\">Inscription</a></div>
											";
					$layout['theme'] ="";
				}

			}
			else{$layout['navLogin'] ="<a class=\"Administration\" href=\"/quartier/scripts/path.php?target=admin\">Administration</a>";}

			if($stmt->history == 1)
			{
				$layout['Nav'] .=
				"<a class=\"navHistory\" href=\"/quartier/scripts/path.php?target=history\"> Histoire</a>";

			}
			if($stmt->events == 1)
			{
				$layout['Nav'] .=
				"<a class=\"navEvents\" href=\"/quartier/scripts/path.php?target=events\"> Evenements</a>";

			}
			if($stmt->restaurant == 1)
			{
				$layout['Nav'] .=
				"<a class=\"navRestaurant\" href=\"/quartier/scripts/path.php?target=restau\"> Restauration</a>";

			}
			if($stmt->discovery == 1)
			{
				$layout['Nav'] .=
				"<a class=\"navDiscover\" href=\"/quartier/scripts/path.php?target=discovery\"> Decouverte</a>";

			}
			if($stmt->gallery == 1)
			{
				$layout['Nav'] .=
				"<a class=\"navGallery\" href=\"/quartier/scripts/path.php?target=gallery\"> Gallerie</a>";

			}

			if($stmt->shop == 1)
			{
				$layout['Nav'] .=
				"<a class=\"navShop\" href=\"/quartier/scripts/path.php?target=shop\"> Boutique</a>";

			}
			$layout['Nav'] .= "</div>";
			return $layout;
	}
}
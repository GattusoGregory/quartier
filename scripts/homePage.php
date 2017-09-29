<?php
$path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/db.php";
include_once("$path");

/** Classe de gestion de la page de connexion [Controller] */	

class HomePage
{
	
	/**
	* Fonction retournant le formulaire de connexion si on est pas connecter sinon il renvois les informations utilisateurs
	*
	* Renvois le nom utilisateurs pour le Layout
	* @var HomePage[login_form, current_user]
	*/	


	public static function getHomePage()
	{
		$user = new User();
		if($user->is_loggedin())
		{
			$forms = "	
						<div class=\"current_user\">
						<div class=\"userinfo mdl-card mdl-shadow--2dp\">
				 		<div class=\"mdl-card__title mdl-card--expand\">
				 		<h2 class=\"mdl-card__title-text\">Informations utilisateur</h2>
				  		</div>
				 		<div class=\"userinfo mdl-card__supporting-text\"><b><i>Mail : </i></b>".
				 		$_SESSION['user_mail']."</br><b><i>téléphone : </i></b>".$_SESSION['user_phone']."</br><b><i>Carte Bancaire : </i></b>".$_SESSION['user_card']."
				 		</div>";

			$isloggedin = $_SESSION['user_session']; }
		else
		{
			$forms = 	"<div class=\"login\">
						<form method=\"POST\" action=\"login.php\">
						<div class=\"test mdl-textfield mdl-js-textfield\">
						<input class=\"textfield_input\" type=\"text\" id=\"sample1\" name=\"uname\"><br>
						<label class=\"textfield_label\" for=\"sample1\">Nom De Compte</label>
						</div>
						<input class=\"textfield_input\" type=\"password\" id=\"sample2\" name=\"upass\"><br>
						<label class=\"textfield_label\" for=\"sample2\">Mot De Passe</label>
						</div>
						<button class=\"btnLogin\">Connexion
						</button>
						<input type=\"hidden\" value=\"connexion\" name =\"submit\">
						
						</form>";

			$isloggedin = "Non Connecté";
		}

		$HomePage['login_form'] = $forms ;
		$HomePage['current_user'] = $isloggedin;

		return $HomePage;
	}
}


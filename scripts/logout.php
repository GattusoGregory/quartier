<?php

/** Gestion de la Deconnexion [Controller] */

$path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/db.php";
include_once("$path");

$user = new User();

if($user->is_loggedin())
{
	$user->logout();
	$user->redirect('../../quartier/index.php?Disconnected');
}
else
{
	$user->redirect('../../quartier/index.php?AlreadyDisconnected');
}

<?php

/** Gestion de la navigation du site [Controller] */


$path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/db.php";
include_once("$path");

$user = new user();

$target = $_GET['target'];

	if ($target == "Accueil") 				{$user->redirect("../../quartier/index.php?redirected");}
	else if ($target == "connect") 			{$user->redirect("../../quartier/pages/backend/login.php?redirected");}
	else if ($target == "subscribe") 		{$user->redirect("../../quartier/pages/subscribe.php?redirected");}
	else if ($target == "history") 		{$user->redirect("../../quartier/pages/history.php?redirected");}
	else if ($target == "events") 		{$user->redirect("../../quartier/pages/events.php?redirected");}
	else if ($target == "gallery") 		{$user->redirect("../../quartier/pages/gallery.php?redirected");}
	else if ($target == "shop") 		{$user->redirect("../../quartier/pages/shop.php?redirected");}
	else if ($target == "restau") 		{$user->redirect("../../quartier/pages/restaurant.php?redirected");}
	else if ($target == "discovery") 		{$user->redirect("../../quartier/pages/discovery.php?redirected");}
	else if ($target == "sadmin") 		{$user->redirect("../../quartier/pages/backend/admin.php?redirected");}
	else if ($target == "Logout") 			{$user->redirect("logout.php");}
	else 									{$user->redirect("../../quartier/pages/404.php");}
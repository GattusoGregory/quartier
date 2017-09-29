<?php
$path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/db.php";
include_once("$path");
$path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/layout.php";
include_once("$path");
$path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/homePage.php";
include_once("$path");
$path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/themeEngine.php";
include_once("$path");

$themeEngine = new themeEngine();
$user = new User();

$currentTheme = $themeEngine->getTheme();

if(isset($_POST['submit']))
{
  $uname = $_POST['uname'];
  $upass = $_POST['upass'];

	  if($user->login($uname,$upass))
		  {
		    $user->redirect('../../index.php?connected');
		  }
	  else
		  {
		    $error[] = "Mauvais Identifiants";
		  }
}

$layout = layout::getLayout();
$login = HomePage::getHomePage();
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    <link rel="stylesheet" href=../../<?php echo $currentTheme->path;?> />
        <title>Chateau Gombert</title>
        <div id="bande_horizontale">
          <?php 
            echo $layout['navLogin'];
            echo $layout['theme']; 
          ?>
        </div>
    </head>

<body>
    <div class="logo"></div>
    <?php 
      echo $layout['Nav'];
    ?>
<div id="bande_horizontalenav">
<br>
<?php 
echo $login['login_form'];
?></div>


</body>
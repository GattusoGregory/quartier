<?php
$path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/db.php";
include_once("$path");
$path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/article.php";
include_once("$path");

$article = new Article();
$user = new User();

if(isset($_POST['submit']))
{
	 $atitle = addslashes(trim($_POST['atitle']));
 	 $adesc = addslashes(trim($_POST['adesc']));
 	 $acontent = addslashes(trim($_POST['acontent']));
 	 $aimg = addslashes(trim($_POST['aimg']));

 	 if($atitle=="") {
      $error[] = "Veuillez Renseigner un titre !";
   }
   else if($adesc=="" || strlen($adesc) > 250 ) {
      $error[] = "Description vide ou supérieur à 250 caractère !"; 
   }
   else if($acontent=="") {
      $error[] = "Veuillez Renseigner un contenus";
   }
   else
   {
            if($article->createArticle($atitle,$adesc,$acontent,$aimg)) 
            {
                $user->redirect('createarticle.php?joined');
            }
	}
}

if(isset($_POST['del']))
{
  $uname = $_POST['atitle'];
  $user->unRegister($atitle);
}

//$sql = 'SELECT * from users';

//$getUsers = Database::getInstance()->request($sql);$sql);

//print_r($getUsers)
?>
<html lang="FR">
  <head>
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  </META></head>
<div class="create_articleS">
		<form method="POST" action="createarticle.php">
		<?php
		if(isset($error))
            {
               foreach($error as $error)
               {
					echo $error;
               }
            }?>
				<h2>Création d'Articles</h2>
				<input type="text" placeholder="Titre" name="atitle"><br/>
        <textarea name="adesc" placeholder="Description" style="height: 30px; width: 167px"></textarea><br>
				<textarea name="acontent" placeholder="Contenus" style="height: 30px; width: 167px"></textarea><br>
        <input type="text" placeholder="Image" name="aimg"><br/>

				<input type="submit" value="Val ider" name="submit"><br/>	
        <input type="submit" value="del" name="del"><br/>  			
		</form>
		</div>
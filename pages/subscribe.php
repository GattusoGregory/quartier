<?php
$path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/db.php";
include_once("$path");

$user = new User();

if(isset($_POST['submit']))
{
	 $uname = trim($_POST['uname']);
 	 $upass = trim($_POST['upass']);
 	 $uphone = trim($_POST['uphone']);
 	 $umail = trim($_POST['umail'])	;
   $unom = trim($_POST['unom']) ;
   $uprenom = trim($_POST['uprenom']) ;
   $ucb = trim($_POST['ucb']) ;

 	 if($uname=="") {
      $error[] = "Veuillez Renseigner un nom de compte !";
   }
   else if($upass=="") {
      $error[] = "Veuillez Renseigner un mot de passe !"; 
   }
   else if(!filter_var($umail, FILTER_VALIDATE_EMAIL)) {
      $error[] = 'Veuillez Renseigner une adresse Email Valide !';
   }
   else if($upass=="") {
      $error[] = "Veuillez Renseigner un mot de passe";
   }
   else if(strlen($upass) < 6){
      $error[] = "Le mot de passe doit contenir plus de 6 caractere"; 
   }
   else
   {
      try
      {
         $stmt = Database::getInstance()->request("SELECT Pseudo,mail FROM users WHERE Pseudo='$uname' OR mail='$umail'");
         if($stmt['Pseudo'] == $uname)
         {
         	$error[] = "Pseudo déjà utilisé";
         }
         else if($stmt['mail'] == $umail)
         {
         	$error[] = "Email déjà utilisé";
         }
         else
         {
            if($user->register($uname,$upass,$uphone,$umail,$unom,$uprenom,$ucb)) 
            {
                $user->redirect('subscribe.php?joined');
            }
         }
     }
        catch(PDOException $e)
	     {
	       // echo $e->getMessage();
	     }
	}
}

if(isset($_POST['del']))
{
  $uname = $_POST['uname'];
  $user->unRegister($uname);
}

if(isset($_POST['okay']))
{
	$uname = $_POST['uname'];
 	$umail = $_POST['umail'];
 	$upass = $_POST['upass'];
  
 if($user->login($uname,$umail,$upass))
 {
  $user->redirect('home.php');
 }
 else
 {
  $error[] = "Wrong Details !";
 } 
}


//$sql = 'SELECT * from users';

//$getUsers = Database::getInstance()->request($sql);$sql);

//print_r($getUsers)
?>
<html lang="FR">
  <head>
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  </META></head>
<div class="create_account">
		<form method="POST" action="subscribe.php">
		<?php
		if(isset($error))
            {
               foreach($error as $error)
               {
					echo $error;
               }
            }?>
				<h2>Création de Comptes</h2>
				<input type="text" placeholder="Nom de Compte" name="uname"><br/>
				<input type="text" placeholder="Mot de Passe" name="upass"><br/>
				<input type="text" placeholder="Telephone" name="uphone"><br/>
        <input type="text" placeholder="Nom" name="unom"><br/>
				<input type="text" placeholder="Prenom" name="uprenom"><br/>
        <input type="text" placeholder="Carte Bancaire" name="ucb"><br/>
        <input type="text" placeholder="mail" name="umail"><br/>

				<input type="submit" value="Valider" name="submit"><br/>	
        <input type="submit" value="del" name="del"><br/>  			
		</form>
		</div>
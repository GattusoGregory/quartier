<?php

/** Classe de gestion des utilisateurs [Model] */

$path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/db.php";
include_once("$path");


class Article
{

	/** Fonction de création d'article  */

	public function createArticle($atitle,$adesc,$acontent,$aimg)
	{
		try
		{
			$sql = "INSERT INTO articles(Titre,Description,ImagePath,Contenus,Creationtime) 
			VALUES('$atitle', '$adesc', '$aimg', '$acontent', CURRENT_TIMESTAMP)";

			$stmt = Database::getInstance()->request($sql, false, false);   
			return $stmt; 
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}   $sql = "SELECT COUNT(*) as login_match FROM users 
			WHERE Pseudo='$ident' 
			OR mail='$ident' 
			LIMIT 1";

			$stmt = Database::getInstance()->request($sql, false, false);   
	}

	/*----------------------------------------*/

	/** Fonction de suppression d'article */

	public function deleteArticle($atitle)
	{
		try
		{
			$sql = "DELETE FROM articles
					WHERE Titre = '$atitle';"	;
			$stmt = Database::getInstance()->request($sql, false, false);
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}

	/*----------------------------------------*/
	/** Fonction de suppression d'article */

		public function findAllArticle()
	{
		$title = "title";
		$content = "content";
		$number = 0;
		try
		{
			$sql = "SELECT * FROM articles";
			$stmt = Database::getInstance()->request($sql, false, true);
          	foreach($stmt as $articles):
											$title = "title";
											$content = "content";
											$desc = "desc";
          									$article[$title .= $number] = $articles->title."<br>";
            								$article[$desc .= $number] = $articles->description."<br>";
            								$article[$content .= $number] = $articles->content."<br><br>";
            								$number += 1;
                endforeach;
                $article['number'] = $number;
                return $article;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
}
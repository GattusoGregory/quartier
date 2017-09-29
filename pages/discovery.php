
<?php
     $path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/db.php";          include_once("$path");
     $path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/layout.php";      include_once("$path");
     $path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/homePage.php";    include_once("$path");
     $path = $_SERVER['DOCUMENT_ROOT'];$path .= "/quartier/scripts/themeEngine.php"; include_once("$path");

     $layout = layout::getLayout();

     $themeEngine = new themeEngine();

     if(isset($_GET['newtheme']))
     {
       $themeEngine->changeTheme($_GET['newtheme']);
     }

     $currentTheme = $themeEngine->getTheme();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href=../<?php echo $currentTheme->Chemin;?> />
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

      blablabl<br> <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    </div>
</body>
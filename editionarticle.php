<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');

if(isset($_SESSION['id']))
{
    // $getid = intval($_SESSION['id']);
    $requtilisateur = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
    $requtilisateur->execute(array($_SESSION['id']));
    $infoutilisateur = $requtilisateur->fetch();

    if(isset($_POST['newarticle']) && !empty($_POST['newarticle']) && $_POST['newarticle'] != $infoutilisateur['article'])
    {
        $login= $_POST['newarticle']; 
        $requetelogin = $bdd->prepare("SELECT * FROM articles WHERE nom = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
        $requetelogin->execute(array($article));
        $newlogin = htmlspecialchars($_POST['newlogin']);
        $insertlogin = $bdd->prepare("UPDATE articles SET nom = ? WHERE id = ?");
        $insertlogin->execute(array($newarticle, $_SESSION['id']));
        // header('Location: profil.php');
        }
    }

    
    if(isset($_POST['newtitre']) && !empty($_POST['newtitre']) && $_POST['newtitre'] != $infoutilisateur['titre'])
    {
        $newnom = htmlspecialchars($_POST['newtitre']);
        $insertnom = $bdd->prepare("UPDATE articles SET nom = ? WHERE id = ?");
        $insertnom->execute(array($newtitre, $_SESSION['id']));
        // header('Location: profil.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8" />
   <link rel="stylesheet" type="text/css" href="style.css">
   <title>Edition article</title>
</head>
<body id="al_body">
<header>
    <?php
include_once('header.php');
?>
</header>
<main id="al_main">
  <div id="LMedition">

    <a href="deconnexion"><input type="button" value="Déconnexion"></a>
  </div>
  </main>
  <footer>
      <?php
      include_once('footer.php');
      ?>
  </footer>
</body>
</html>
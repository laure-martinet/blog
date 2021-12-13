<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');

   if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
      $supprime = (int) $_GET['supprime'];
      $req = $bdd->prepare('DELETE FROM utilisateurs WHERE id = ?');
      $req->execute(array($supprime));
   }
   
   if(isset($_GET['supprimearticle']) AND !empty($_GET['supprimearticle'])) {
      $supprime = (int) $_GET['supprimearticle'];
      $req = $bdd->prepare('DELETE FROM articles WHERE id = ?');
      $req->execute(array($supprime));
   }


$membres = $bdd->query('SELECT * FROM utilisateurs ORDER BY id DESC LIMIT 0,5');
$article = $bdd->query('SELECT * FROM articles ORDER BY id DESC LIMIT 0,5');
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8" />
   <link rel="stylesheet" type="text/css" href="style.css">
   <title>Administration</title>
</head>
<body id="al_body">
<header>
    <?php
include_once('header.php');
?>
</header>
<main id="al_main">
  <div id="LMadmin">
    <ul>
        <?php while($m = $membres->fetch()) { ?>
        <li><?= $m['id'] ?> : <?= $m['login'] ?> - <a href="admin.php?supprime=<?= $m['id'] ?>">Supprimer user</a></li>
        <?php } ?>
    </ul>
    <ul>
        <?php while($a = $article->fetch()) { ?>
        <li><?= $a['article'] ?> - <a href="admin.php?supprimearticle=<?= $a['id'] ?>">Supprimer article</a></li>
        <?php } ?>
    </ul>
    <br /><br />
    <a href="deconnexion"><input type="button" value="Déconnexion"></a>
    <a href="creer-article.php"><input type="button" value="Crée article"></a>
  </div>
  </main>
  <footer>
      <?php
      include_once('footer.php');
      ?>
  </footer>
</body>
</html>
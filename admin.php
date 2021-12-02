<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');

if(isset($_GET['type']) AND $_GET['type'] == 'utilisateurs') {
   
   }
   if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
      $supprime = (int) $_GET['supprime'];
      $req = $bdd->prepare('DELETE FROM utilisateurs WHERE id = ?');
      $req->execute(array($supprime));
   }
   
   if(isset($_GET['supprime']) AND !empty($_GET['supprime'])) {
      $supprime = (int) $_GET['supprime'];
      $req = $bdd->prepare('DELETE FROM commentaires WHERE id = ?');
      $req->execute(array($supprime));
   }

$membres = $bdd->query('SELECT * FROM utilisateurs ORDER BY id DESC LIMIT 0,5');

?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8" />
   <link rel="stylesheet" type="text/css" href="style.css">
   <title>Administration</title>
</head>
<header>
    <h1>Administration</h1>
</header>
<body>
  <div id="admin">
    <ul>
        <?php while($m = $membres->fetch()) { ?>
        <li><?= $m['id'] ?> : <?= $m['login'] ?> - <a href="index.php?type=supprime=<?= $m['id'] ?>">Supprimer</a></li>
        <?php } ?>
    </ul>
    <br /><br />
    <a href="deconnexion"><input type="button" value="Déconnexion"></a>
  </div>
</body>
</html>
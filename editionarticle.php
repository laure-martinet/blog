<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');

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
<?php
$recuparticle = $bdd->query('SELECT * FROM articles');
while ($article = $recuparticle->fetch()){
    ?>
    <div class="article">
        <h1><?= $article['titre']; ?></h1>
        <br>
        <p><?= $article['article']; ?></p>
    </div>
    <?php
}
?>
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
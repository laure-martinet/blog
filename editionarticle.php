<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
if (isset($_POST['newarticle']) && !empty($_POST['newarticle'])) {
  $idchange = $_POST['id'];
  $article = $_POST['newarticle'];
  $titre = $_POST['newtitre'];
  $requetearticle = $bdd->prepare("SELECT * FROM articles WHERE article = ?, titre = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
  $requetearticle->execute(array($article, $titre));
  $articleexist = $requetearticle->rowCount(); // rowCount = Si une ligne existe = PAS BON

  if ($articleexist !== 0) {
      $msg = "L'article existe déjà !";
  } else {

      $newarticle = htmlspecialchars($_POST['article']);
      $newtitre = htmlspecialchars($_POST['titre']);
      $insertlogin = $bdd->prepare("UPDATE articles SET article = ?, titre = ? WHERE id = ?");
      $insertlogin->execute(array($newarticle, $newtitre, $idchange));
      header('Location: editionarticle.php');
      exit();
  }
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
    <form id="form_inscription" method="post">
  <div id="LMedition">
<?php
$recuparticle = $bdd->query('SELECT * FROM articles');
while ($article = $recuparticle->fetch()){
    ?>
    <div class="article">
    <input type="text" name="article_titre" placeholder="Titre"value="<?= $article['titre'] ?>" />

      <textarea name="article_contenu" placeholder="Contenu de l'article"><?= $article['article'] ?></textarea>

        <a href="supprimerarticle.php?id=<?= $article['id'] ?>">Supprimer</a>
        <input type="submit" name="Valider" value="Valider">
    </div>
</form>
    <?php
}
?>
  </div>
  </main>
  <footer>
      <?php
      include_once('footer.php');
      ?>
  </footer>
</body>
</html>
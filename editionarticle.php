<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');

if(isset($_GET['id']) AND !empty($_GET['id'])){
$getid = $_GET['id'];

$recuparticle = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
$recuparticle->execute(array($getid));
// TOUT CA PERMET DE RECUP L'ARTICLE DE L'ID UTILISATEUR
if($recuparticle->rowCount() > 0){
$articleInfos = $recuparticle->fetch();
$titre = $articleInfos['titre'];
$contenu = $articleInfos['article'];

if(isset($_POST['Valider'])){
$titre_saisie = htmlspecialchars($_POST['titre']);
$contenu_saisie = htmlspecialchars($_POST['article']);

$updatearticle = $bdd->prepare('UPDATE articles SET titre = ? AND article = ? WHERE id = ?');
$updatearticle->execute(array($titre_saisie, $contenu_saisie, $getid));
}
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
    <form id="form_inscription" method="POST">
  <div id="LMedition">
<?php
$recuparticle = $bdd->query('SELECT * FROM articles');
while ($article = $recuparticle->fetch()){
    ?>
    <div class="article">
    <input type="text" name="article_titre" placeholder="Titre"value="<?= $article['titre'] ?>" />

      <textarea name="article_contenu" placeholder="Contenu de l'article"><?= $article['article'] ?></textarea>

        <a href="supprimerarticle.php?id=<?= $article['id'] ?>">Supprimer</a>
        <input type="submit" name="Valider">
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
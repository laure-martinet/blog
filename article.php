<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', ''); 

if(isset($_GET['id']) AND !empty($_GET['id'])) {
    $get_id = htmlspecialchars($_GET['id']);
    $article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
    $article->execute(array($get_id));
    if($article->rowCount() == 1) {
        $article = $article->fetch();
        $titre = $article['titre'];
        $contenu = $article['article'];
    } else {
        die('Cet article n\'existe pas !');
    }
} else {
    die('Erreur');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
    <meta charset="utf-8">
</head>

<body id="al_body">
<header>
    <?php
        include_once ("header.php");
    ?>
</header>
<main>
    <p class="lr_h2">Catégorie : <?php echo $article['id_categorie'] ;?></p>
    <div id="deplacement_article"> 
        <div id="lr_article"> 
            <p class="lr_h2">Créée le <?php echo $article['date'] ;?></p>
            <h1 class="lr_h2"><?= $titre ?></h1>
            <p class="lr_h2"><?= $contenu ?></p>
        </div>
    </div>
</main>
<footer>
    <?php
        include_once ("footer.php");
    ?>
</footer>
</body>
</html>

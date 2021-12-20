<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
$bdd->query('SELECT * FROM articles ORDER BY date DESC LIMIT 0,5');

$article_par_page = 3;
$articles = $bdd->query('SELECT * FROM articles ORDER BY date DESC LIMIT 0,3');
$articles_totales = $articles->rowCount();

$pagestotales = ceil($articles_totales / $article_par_page);

if (isset($_GET['page']) and !empty($_GET['page']) and $_GET['page'] > 0 and $_GET['page'] <= $pagestotales) {
    $_GET['page'] = intval($_GET['page']);
    $pageCourante = $_GET['page'];
} else {
    $pageCourante = 1;
}
$depart = ($pageCourante - 1) * $article_par_page;
?>
<!DOCTYPE html>
<html lang="fr">
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta charset="utf-8">
    <link href="style.css" rel="stylesheet">
    <title>Blog</title>
</head>

<body id="al_body">

    <header>
        <?php
        require("header.php");
        ?>
    </header>
    <main id="al_articles">
        <h1 id="al_h1"> Dernier articles mis en ligne</h1>
        <?php
        $articles = $bdd->query('SELECT * FROM articles ORDER BY id DESC LIMIT ' . $depart . ',' . $article_par_page);
        while ($art = $articles->fetch()) {
        ?>
            <div id="al_article">
                <li><a class="al_href" href="article.php?id=<?= $art['id'] ?>"><?= $art['titre'] ?></a></li>
                <i id="al_date"><?php echo $art['date']; ?></i>
            </div>
            <br /><br />
        <?php
        }
        ?>
        <!-- <div class="rectangle"></div> -->
    </main>
    <footer>
        <?php
        require("footer.php");
        ?>
    </footer>
</body>

</html>
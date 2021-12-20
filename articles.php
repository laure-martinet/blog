<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

$article_par_page = 5;
$articles = $bdd->query('SELECT * FROM articles ORDER BY date DESC LIMIT 0,5');
$articles_totales = $articles->rowCount();

$pagestotales = ceil($articles_totales / $article_par_page);

if (isset($_GET['id_categorie']) and !empty($_GET['id_categorie']) and $_GET['id_categorie'] > 0 and $_GET['id_categorie'] <= $pagestotales) {
    $_GET['id_categorie'] = intval($_GET['id_categorie']);
    $pageCourante = $_GET['id_categorie'];
} else {
    $pageCourante = 1;
}
$depart = ($pageCourante - 1) * $article_par_page;


?>
<!DOCTYPE html>
<html>

<head>
    <title>articles</title>
    <link rel="stylesheet" href="style.css" />
    <meta charset="utf-8">
</head>

<body id="al_body">
    <header>
        <?php
        require('header.php');
        ?>
    </header>
    <main id=al_articles>
        <?php
        $articles = $bdd->query('SELECT * FROM articles ORDER BY date DESC LIMIT ' . $depart . ',' . $article_par_page);
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
        <?php
       
        for($i=1; $i<= $pagestotales; $i++) {
            if ($i == $pageCourante) {
                echo $i . '' ;
                

            }
            else {
                // echo '<a href="articles.php?p=' . $i . '">' . $i . '</a> ';
            }
        }
        ?>
        <a href="?id_categorie=<?php echo $i - 1; ?>">Page précédente</a>
        <a href="?id_categorie=<?php echo $i ++; ?>">Page suivante</a>
    </main>
    <footer>
        <?php
        require('footer.php')
        ?>
    </footer>
</body>

</html>
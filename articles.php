<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

$article_par_page = 5;
$articles = $bdd->query('SELECT * FROM articles ORDER BY date DESC LIMIT 0,5');
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
        <?php
        $i = 1;
        while( $i <= $pagestotales) {
            if ($i == $pageCourante) {
                echo $i . '' ;
                $i++;
            }
            // else {

            //     echo '<a href="articles.php?page=' . $i . '">' . $i . '</a> ';
            // }
        }
        ?>
        <a href="?page=<?php echo $i - 1; ?>">Page précédente</a>
        <a href="?page=<?php echo $i ++; ?>">Page suivante</a>
    </main>
    <footer>
        <?php
        require('footer.php')
        ?>
    </footer>
</body>

</html>
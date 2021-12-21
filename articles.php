<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

// $article_par_page = 5;
// $articles = $bdd->query('SELECT * FROM articles ORDER BY date DESC LIMIT 5,5');
// $articles_totales = $articles->rowCount();

// $pagestotales = ceil($articles_totales / $article_par_page);

// if (isset($_GET['id_categorie']) and !empty($_GET['id_categorie']) and $_GET['id_categorie'] > 0 and $_GET['id_categorie'] <= $pagestotales) {
//     $_GET['id_categorie'] = intval($_GET['id_categorie']);
//     $pageCourante = $_GET['id_categorie'];
// } else {
//     $pageCourante = 1;
// }
// $depart = ($pageCourante - 1) * $article_par_page;
if (isset($_GET['page'])&& !empty($_GET['page'])){
    $pageCourante=(int)strip_tags($_GET['page']);
}else{
    $pageCourante=1;
}

$sql= 'SELECT COUNT(*) AS nb_articles FROM `articles`;';
$query=$bdd->prepare($sql);
$query->execute();
$result=$query->fetch();
$nbArticles=(int) $result['nb_articles'];

$article_par_page=5;

$pagestotales = ceil($nbArticles / $article_par_page);
$debut=($pageCourante*$article_par_page)-$article_par_page;

$sql='SELECT * FROM articles ORDER BY date DESC LIMIT :debut, :article_par_page;';
$query=$bdd->prepare($sql);
$query-> bindValue(':debut', $debut, PDO ::PARAM_INT);
$query-> bindValue(':article_par_page', $article_par_page, PDO ::PARAM_INT);
$query->execute();

$articles=$query->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>

<head>
    <title>articles</title>
    <link rel="stylesheet" href="../style.css" />
    <meta charset="utf-8">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body id="al_body">
    <header>
        <?php
        require('header.php');
        ?>
    </header>
    <main id=al_articles>
        <?php
        // $articles = $bdd->query('SELECT * FROM articles ORDER BY date DESC LIMIT ' . $depart . ',' . $article_par_page);
        // while ($art = $articles->fetch()) {
            foreach ($articles as $article){
        ?>
        <?= $article['id']?>
        <a href="articles.php?p="><?= $article['titre']?> </a><br>
        <?= $article['date']?><br>
            
        <?php
        }
        ?>
        <?php
       
        // for($i=1; $i<= $pagestotales; $i++) {
        //     if ($i == $pageCourante) {
        //         echo $i . '' ;
                

        //     }
        //     else {
        //         echo '<a href="articles.php?p=' . $i . '">' . $i . '</a> ';
        //     }
        // }
        ?>
        <nav>
            <ul class="pagination">
                <li class="page-item <?=($pageCourante == 1) ? "disabled" :"" ?>">
                    <a href="articles.php?page=<?= $pageCourante-1 ?>" class="page-link">Précédente</a>
                </li> 
                <?php for($page = 1; $page <= $pagestotales; $page++): ?>
                            <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                <a href="articles.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                            </li>
                        <?php endfor ?>
                <li class="page-item <?=($pageCourante==$pagestotales) ? "disabled" :"" ?>">
                    <a href="articles.php?page=<?= $pageCourante+1 ?>" class="page-link">Suivante</a>
                </li>
            </ul>
        </nav>
    </main>
    <footer>
        <?php
        require('footer.php')
        ?>
    </footer>
</body>

</html>
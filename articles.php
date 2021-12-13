<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', ''); 
$articles = $bdd->query('SELECT * FROM articles ORDER BY date DESC');

$count=$bdd->prepare("select count(id) as cpt from articles");
$count->setFetchMode(PDO::FETCH_ASSOC);
$count->execute();
$tcount=$count->fetchAll();


$nbr_par_page=5;
$nbr_par_page= ceil ($tcount[0]["cpt"]/$nbr_par_page);



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
            require('header.php')
            ?>
        </header>
        <main>
            <ul id=al_articles>
            <?php while($a = $articles->fetch()) { ?>
            <li><a class=al_liste href="article.php?id=<?= $a['id'] ?>"><?= $a['titre'] ?></a></li>
            <?php } ?>
            </ul>
            <?php
                for($i=1;$i<=$nbr_par_page;$i++){
                    echo "<a href=''>$i</a>";
                }
            ?>
        </main>
        <footer>
            <?php
            require('footer.php')
            ?>
        </footer>
    </body>
</html>
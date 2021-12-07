<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', ''); 
$articles = $bdd->query('SELECT * FROM articles ORDER BY date DESC');
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
            <ul class=liste>
            <?php while($a = $articles->fetch()) { ?>
            <li><a href="article.php?id=<?= $a['id'] ?>"><?= $a['titre'] ?></a></li>
            <?php } ?>
            </ul>
        </main>
        <footer>
            <?php
            require('footer.php')
            ?>
        </footer>
    </body>
</html>
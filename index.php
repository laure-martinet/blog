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
        <main id="al_main">
            <h1 id="al_h1"> Dernier articles mis en ligne</h1>
            <div class="rectangle"></div>
        </main>
        <footer>
            <?php 
            require("footer.php");
            ?>
        </footer>
    </body>
</html>
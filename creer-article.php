<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', ''); 

if(isset($_POST['titrearticle'], $_POST['contenu'])) {
    if(!empty($_POST['titrearticle']) AND !empty($_POST['contenu'])) {
        $titrearticle = htmlspecialchars($_POST['titrearticle']);
        $contenu = htmlspecialchars($_POST['contenu']);
        $ins = $bdd->prepare('INSERT INTO articles (article, date, id_utilisateur, id_categorie) VALUES (?, ?, ? NOW()');
        $ins->execute(array($titrearticle, $contenu));
        $message = 'Votre article a bien été posté';
}
else {
    $message = "Veuillez remplir tout les champs !";
}
}
?>
<!doctype html>
<html>
    <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Cree article</title>
    </head>
    <body id="al_body">
    <header>     
            <?php
                include_once('header.php');
            ?>
    </header>
    <main id="al_main">
        <div id="deplacement_form">
            <form id="form_inscription" action="" method="post">
                <h1 class="lr_h2">Crée article !</h1><br>
                    <input type="text" name="titrearticle" placehorder="Titre">
                    <textarea name="contenu" placehorder="Contenu de l'article">
                    </textarea>
                <input type="submit" value="Envoyez">
            </form>
            <?php if(isset($message)) { echo $message; } ?>
        </div>
                <footer>
                    <?php
                include_once("footer.php");
                    ?>
                </footer>
    </main>
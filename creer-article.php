<?php
session_start();
var_dump($_SESSION);

if(isset($_POST['titrearticle']) && isset($_POST['contenu'])) {
    if(!empty($_POST['titrearticle']) && !empty($_POST['contenu'])) {

        $bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', ''); 

        if ($bdd == true)
        {
            $titrearticle = htmlspecialchars($_POST['titrearticle']);
            $contenu = htmlspecialchars($_POST['contenu']);
            $id_user = $_SESSION['id'];

            // $ins = $bdd->prepare("INSERT INTO articles(titre, article, id_utilisateur, id_categorie, date, table) VALUES ('$titrearticle', '$contenu', $id_user, null, NOW(), null");
            $ins = $bdd->prepare('INSERT INTO `articles`( `titre`, `article`, `id_utilisateur`, `id_categorie`, `date`, `table`) VALUES (:titre, :art, :id_user, :id_cat, :date, :table)');
            var_dump($ins);
            $ins->execute([
                ':titre' => $titrearticle,
                ':art' => $contenu,
                ':id_user' => $id_user,
                ':id_cat' => 0,
                ':date' => date("m.d.y"),
                ':table' => 0
            ]);

            if($ins == true)
            {
                $message = 'Votre article a bien été posté';
            }
            else
            {
                $message = 'erreur';
            }
        }
        else
        {
            echo ('bdd pas ok');
        }
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
                <select name="selectLM" id="selectLM">
                    <option value="AC">Assassin's Creed</option>
                    <option value="WOW">World of Warcraft</option>
                    <option value="TLU">The last of US</option>
                </select>
                <input type="submit" name="submit" value="Envoyez">
            </form>
            <?php if(isset($message)) { echo $message; } ?>
        </div>
                <footer>
                    <?php
                include_once("footer.php");
                    ?>
                </footer>
    </main>
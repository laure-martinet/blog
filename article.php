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

                if(isset($_GET['id']) AND !empty($_GET['id'])) {
                    $getid = htmlspecialchars($_GET['id']);
                    $article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
                    $article->execute(array($getid));
                    $article = $article->fetch();
                    if(isset($_POST['submit_commentaire'])) {
                    if(isset($_POST['id'],$_POST['commentaire']) AND !empty($_POST['id']) AND !empty($_POST['commentaire'])) {
                        $pseudo = htmlspecialchars($_POST['id']);
                        $commentaire = htmlspecialchars($_POST['commentaire']);
                        if(strlen($pseudo) < 25) {
                            $ins = $bdd->prepare('INSERT INTO commentaires (id, commentaire, id_article) VALUES (?,?,?)');
                            $ins->execute(array($pseudo,$commentaire,$getid));
                            $c_msg = "<span style='color:green'>Votre commentaire a bien été posté</span>";
                        } else {
                            $c_msg = "Erreur: Le id doit faire moins de 25 caractères";
                        }
                    } else {
                        $c_msg = "Erreur: Tous les champs doivent être complétés";
                    }
                    }
                    $commentaires = $bdd->prepare('SELECT * FROM commentaires WHERE id_article = ? ORDER BY id DESC');
                    $commentaires->execute(array($getid));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Article</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta charset="utf-8">
</head>

<body id="al_body">
<header>
    <?php
        include_once ("header.php");
    ?>
</header>
<main>
    <div id="deplacement_article"> 
        <div id="lr_article">     
            <p class="lr_text">Catégorie : <?php if($article['id_categorie']=1){
            echo $article['id_categorie'] ;
            }?></p>
            <p class="lr_text">Créée le <?php echo $article['date'] ;?></p>
            <h1 class="lr_h2"><?= $titre ?></h1>
            <p class="lr_h2"><?= $contenu ?></p>
                    <div id="lr_espace_commentaire">
                        <h2 class="lr_h2">Commentaires:</h2>
                            <form id="form_commentaire" method="POST">
                                <input type="text" name="id" placeholder="Votre pseudo" /><br />
                                <textarea name="commentaire" placeholder="Votre commentaire..."></textarea><br />
                                <input type="submit" class="btn btn-secondary btn-lg" value="Poster mon commentaire" name="submit_commentaire" />
                            </form>
                            <?php if(isset($c_msg)) { echo $c_msg; } ?><br /><br />
                            <?php while($c = $commentaires->fetch()) { ?><b>
                            <?= $c['id'] ?>:</b> <?= $c['commentaire'] ?><br/>
                            <?php } ?>
                    </div>
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
<?php } ?>
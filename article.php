<?php
session_start();
include('bdd.php');//ARTICLE (Afficher l'article)
if (isset($_GET['id']) and !empty($_GET['id'])) {
    $get_id = htmlspecialchars($_GET['id']);
    $article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
    $article->execute(array($get_id));
    if ($article->rowCount() == 1) {
        $article = $article->fetch();
        $titre = $article['titre'];
        $contenu = $article['article'];
    } else {
        die('Cet article n\'existe pas !');
    }
} else {
    die('Erreur');
}
// ESPACE COMMENTAIRES (afficher les commentaires)
if (isset($_GET['id']) and !empty($_GET['id'])) {
    $getid = intval($_GET['id']);
    if (isset($_POST['submit_commentaire'])) {
        if (isset($_POST['commentaire']) and !empty($_POST['commentaire'])) {
            if (intval($getid) > 0) {
                $commentaire = htmlspecialchars($_POST['commentaire']);
                $getid_u = intval($_SESSION['id']);
                $ins = $bdd->prepare('INSERT INTO commentaires (commentaire, id_article, id_utilisateur, date) VALUES(?,?,?,NOW())');
                $ins->execute(array($commentaire, $getid, $getid_u));
                $c_msg = "<span class='lr_message'>Votre commentaire a bien été posté</span>";
                header("location: #redirect");
                unset($_POST);
            } else {
                $c_msg = "Erreur: Le id doit faire moins de 25 caractères";
            }
        } else {
            $c_msg = "Erreur: Tous les champs doivent être complétés";
        }
    }
    //Afficher les commentaires de l'article sélectionné et INNER JOIN pour pouvoir afficher le pseudo de l'utilisateur avec son commentaire
    $commentaires = $bdd->query('SELECT * FROM commentaires  INNER JOIN utilisateurs ON commentaires.id_utilisateur = utilisateurs.id ORDER BY commentaires.date DESC');
    //Afficher catégorie 
    $categorie = $bdd->prepare('SELECT id_categorie FROM articles WHERE id = ?');
    $categorie->execute(array($get_id));
    while ($cat = $categorie->fetch()) {
        if ($cat['id_categorie'] == 1) {
            $msg_cat = "Assassin's Creed";
        } elseif ($cat['id_categorie'] == 2) {
            $msg_cat = "World of Warcraft";
        } elseif ($cat['id_categorie'] == 3) {
            $msg_cat = "The Last of Us";
        } else {
            $msg_cat = "Cet article n'a pas de catégorie";
        }
    }
    // Supprimer un commentaire
    if (isset($_GET['supprimer']) && !empty($_GET['supprimer'])) {
        $supprimer = (int) $get_id;
        $req = $bdd->prepare('DELETE FROM commentaires WHERE id = ?');
        $req->execute(array($supprimer));
        header("location: articles.php?id=<?= $get_id ?>");
        exit();
    }
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
            include_once("header.php");
            ?>
        </header>
        <main>
            <div id="deplacement_article">
                <div id="lr_article">
                    <p class="lr_text">Catégorie : <?php
                        echo $msg_cat;
                        ?></p>
                    <p class="lr_text">Créée le <?php echo $article['date']; ?></p>
                    <h1 id="lr_titre_article"><?= $titre ?></h1>
                    <p class="lr_h2"><?= $contenu ?></p>
                    <div id="lr_espace_commentaire">
                        <!-- Si utilisateur connecté, affiche de quoi poster un commentaire sinon affiche un message pour se connecter -->
                        <?php if (isset($_SESSION['login']) == true) { ?>
                            <h2 class="lr_h2">Commentaires:</h2>
                            <form id="form_commentaire" method="POST">
                                <textarea name="commentaire" placeholder="Votre commentaire..."></textarea><br />
                                <input type="submit" class="btn btn-secondary btn-lg" value="Poster mon commentaire" name="submit_commentaire" href="redirect" />
                            </form>
                        <?php } else {
                            echo "<p class='lr_error'>Vous devez être connecté pour poster un commentaire !<br><a class='lr_error' href='connexion.php'>Connectez-vous ici</a></p>";
                        }
                        ?>
                        <!-- Message d'erreurs -->
                        <div id="lr_position_comm">
                            <div class="lr_error">
                                <?php if (isset($c_msg)) {
                                    echo $c_msg;
                                } ?><br /><br />
                            </div>
                            <!-- Affichage des commentaires de l'article -->
                            <?php
                            while ($c = $commentaires->fetch()) {
                                if ($c['id_article'] == $get_id) {
                                    echo $c['login'];
                            ?><br>
                                    Créée le <?php echo $c['date']; ?><br>
                                    <p id="lr_commentaire_1"><?= $c['commentaire'] ?></p><br />
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <?php
            include_once("footer.php");
}
            ?>
        </footer>
    </body>
    </html>
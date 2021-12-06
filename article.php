<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', ''); 

if(isset($_GET['id']) AND !empty($_GET['id'])) {
    $getid = htmlspecialchars($_GET['id']);
    $article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
    $article->execute(array($getid));
    $article = $article->fetch();
    if(isset($_POST['submit_commentaire'])) {
        if(isset($_POST['login'],$_POST['commentaire']) AND !empty($_POST['login']) AND !empty($_POST['commentaire'])) {
            $login = htmlspecialchars($_POST['login']);
            $commentaire = htmlspecialchars($_POST['commentaire']);
        if(strlen($login) < 25) {
            $ins = $bdd->prepare('INSERT INTO commentaires (login, commentaire, id_article) VALUES (?,?,?,?)');
            $ins->execute(array($login,$commentaire,$getid));
            $c_msg = "<span style='color:green'>Votre commentaire a bien été posté</span>";
            } else {
                $c_msg = "Erreur: Le login doit faire moins de 25 caractères";
            }
        } else {
            $c_msg = "Erreur: Tous les champs doivent être complétés";
        }
    }
    $commentaires = $bdd->prepare('SELECT * FROM commentaires WHERE id_article = ? ORDER BY id DESC');
    $commentaires->execute(array($getid));
?>
<body id="al_body">
<main id="al_main"> 
    <div id="deplacement_form"> 
        <h2>Article:</h2>
        <p><?= $article['contenu'] ?></p> <br />
        <h2>Commentaires:</h2>
            <form method="POST">
                <input type="text" name="login" placeholder="Votre login" /><br />
                <textarea name="commentaire" placeholder="Votre commentaire..."></textarea><br />
                <input type="submit" value="Poster mon commentaire" name="submit_commentaire" />
            </form>
        <?php if(isset($c_msg)) { echo $c_msg; } ?>
        <br /><br />
        <?php while($c = $commentaires->fetch()) { ?>
            <b><?= $c['login'] ?>:</b> <?= $c['commentaire'] ?><br />
    </div>
</main>
</body>
<?php } ?>
<?php
}
?>
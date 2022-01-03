<?php
session_start();
include('bdd.php');

$articles = $bdd->query('SELECT articles.`id` as ida, article, id_utilisateur, id_categorie, categories.nom, date, titre FROM articles INNER JOIN categories ON categories.id = articles.id_categorie ORDER BY articles.id ASC;');
$listearticles = $bdd->query('SELECT `id` as ida, `article`, `id_utilisateur`, `id_categorie`, `date`, `titre` FROM `articles`');
$lisar = $articles->fetchAll();
$categories = $bdd->query('SELECT `id` as idc, `nom` FROM `categories`');
$categoriess = $bdd->query('SELECT `id` as idc, `nom` FROM `categories`');
$fetchcate = $categories->fetchAll();
$utilisateurs = $bdd->query('SELECT utilisateurs.`id` as idu, `login`, `password`, `email`, `id_droits`,`nom` FROM `utilisateurs` INNER JOIN droits ON droits.id = utilisateurs.id_droits ORDER BY utilisateurs.id ASC;');
$listedroits = $bdd->query('SELECT * FROM droits');
$lis = $listedroits->fetchAll();

// ID nécessaire pour la connexion 
if (!isset($_SESSION['id']) || $_SESSION['id_droits'] != 1337) {
    header("Location: profil.php");
    exit();
}
// Fonction supprimé une catégorie
if (isset($_GET['supprimercateg']) && !empty($_GET['supprimercateg'])) {
    $supprimercateg = (int) $_GET['supprimercateg'];
    $reqc = $bdd->prepare('DELETE FROM categories WHERE id = ?');
    $reqc->execute(array($supprimercateg));
    header("Location: editionarticle.php");
    exit();
}
// Fonction ajouter une catégorie 
if (isset($_POST['creercateg']) && !empty($_POST['creercateg'])) {
    $creercateg = htmlspecialchars($_POST['creercateg']);
    $requetecategor = $bdd->prepare("SELECT * FROM categories WHERE nom = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
    $requetecategor->execute(array($creercateg));
    $categexist = $requetecategor->rowCount(); // rowCount = Si une ligne existe = PAS BON
    if ($categexist !== 0) {
        $_SESSION['msg'] = $_SESSION['msg'] . "la catégorie existe déjà <br>";
    } else {
        $creercategorie = htmlspecialchars($_POST['creercateg']);
        $insertcateg = $bdd->prepare("INSERT INTO categories (nom) VALUES (?)");
        $insertcateg->execute(array($creercategorie));
        header('Location: editionarticle.php');
        exit();
    }
}
// Fonction modifié la catégorie
if (isset($_POST['newcateg']) && !empty($_POST['newcateg'])) {
    $idchange = $_POST['idc'];
    $newcateg = $_POST['newcateg'];
    $requetecateg = $bdd->prepare("SELECT * FROM categories WHERE nom = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
    $requetecateg->execute(array($newcateg));
    $categexist = $requetecateg->rowCount(); // rowCount = Si une ligne existe = PAS BON
    if ($categexist !== 0) {
        $_SESSION['msg'] = $_SESSION['msg'] . "la catégorie existe déjà <br>";
    } else {
        $newcategorie = htmlspecialchars($_POST['newcateg']);
        $insertcateg = $bdd->prepare("UPDATE categories SET nom = ? WHERE id = ?");
        $insertcateg->execute(array($newcategorie, $idchange));
        header('Location: editionarticle.php');
        exit();
    }
}
// Fonction modifié le titre
if (isset($_POST['modiftitre']) && !empty($_POST['modiftitre'])) {
    $idchange = $_POST['ida'];
    $modificationtitre = $_POST['modiftitre'];
    $requetetitre = $bdd->prepare("SELECT * FROM articles WHERE titre = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
    $requetetitre->execute(array($modificationtitre));
    $titreexist = $requetetitre->rowCount(); // rowCount = Si une ligne existe = PAS BON
    var_dump($msg);
    if ($titreexist !== 0) {
        $_SESSION['msg'] = $_SESSION['msg'] . "Le titre éxiste déjà ! <br>";
    } else {
        $newtitre = htmlspecialchars($_POST['modiftitre']);
        $insertnewtitre = $bdd->prepare("UPDATE articles SET titre = ? WHERE id = ?");
        $insertnewtitre->execute(array($newtitre, $idchange));
        header('Location: admin.php');
        exit();
    }
}
// Fonction modifié l'article
if (isset($_POST['modifarticle']) && !empty($_POST['modifarticle'])) {
    $idchange = $_POST['ida'];
    $modificationarticle = $_POST['modifarticle'];
    $requetearct = $bdd->prepare("SELECT * FROM articles WHERE article = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
    $requetearct->execute(array($modificationarticle));
    $articleexist = $requetearct->rowCount(); // rowCount = Si une ligne existe = PAS BON
    var_dump($msg);
    if ($articleexist !== 0) {
        $_SESSION['msg'] = $_SESSION['msg'] . "Il n'y as pas eu de modifications sur l'article <br>";
    } else {
        $newarticle = htmlspecialchars($_POST['modifarticle']);
        $insertnewarticle = $bdd->prepare("UPDATE articles SET article = ? WHERE id = ?");
        $insertnewarticle->execute(array($newarticle, $idchange));
        header('Location: admin.php');
        exit();
    }
}
// Fonction modifié la catégorie d'un article
if (isset($_POST['selectc'])) {
    $idchange = $_POST['ida'];
    $categoriechange = $_POST['selectc'];
    $changercateg = $bdd->prepare("UPDATE articles SET id_categorie = ? WHERE id = ?");
    $changercateg->execute(array($categoriechange, $idchange));
    header('Location: admin.php');
    exit();
}
// Fonction supprimé un article
if (isset($_GET['supprimerarticle']) && !empty($_GET['supprimerarticle'])) {
    $supprimerarticle = (int) $_GET['supprimerarticle'];
    $reqc = $bdd->prepare('DELETE FROM articles WHERE id = ?');
    $reqc->execute(array($supprimerarticle));
    header("Location: admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Espace modif</title>
</head>

<body id="al_body">
    <header>
        <?php
            include_once("header.php");
        ?>
    </header>

    <main id="al_main">
        <h2>Espace modifier</h2>
        <br />
        <table>
            <thead>
                <tr class=test>
                    <th class="text-light">Catégories</th>
                </tr>
            </thead>
            <?php while ($c = $categoriess->fetch()) { ?>
                <form method="POST">
                    <input id="idc" type="hidden" name="idc" value="<?php echo $c['idc']; ?>">
                    <label class="text-light" for="newcateg"></label>
                    <td><input class="crtdedition" id="newcateg" type="text" name="newcateg" value="<?php echo $c['nom']; ?>"></td>
                    <td class=test><a class="btn btn-danger" href="editionarticle.php?supprimercateg=<?= $c['idc'] ?>">Supprimer la catégorie</a></td>
                    <td class=test><input id="" type="submit" class="btn btn-primary" name="submit" value="Modifier"></td>
                </form>
                </tr>
            <?php } ?>
            <form id="form_inscription" method="POST">
                <label class="mt-4 text-light" for="creercateg"></label>
                <td><input class="mt-4 ms-3" id="creercateg" type="text" name="creercateg" placeholder="Ajoutez une catégorie..."></td>
                <td class=test><input id="" type="submit" class="btn btn-primary mt-4 ms-3" name="submit" value="Confirmé !"></td>
            </form>
        </table>
        <table>
            <thead>
                <tr class=test>
                    <th class="text-light">Titre</th>
                    <th class="text-light">Article</th>
                    <th class="text-light">Categorie</th>
                </tr>
            </thead>
            <?php while ($a = $listearticles->fetch()) { ?>
                <tr>
                    <form method="POST">
                        <input id="ida" type="hidden" name="ida" value="<?php echo $a['ida']; ?>">
                        <label class="text-light" for="modiftitre"></label>
                        <td><input class="crtdedition" id="modiftitre" type="text" name="modiftitre" value="<?php echo $a['titre']; ?>"></td>
                        <label class="text-light" for="modifarticle"></label>
                        <td><input class="crtdedition" id="modifarticle" type="text" name="modifarticle" value="<?php echo $a['article']; ?>"></td>
                        <td>
                            <select name="selectc" id="selectc">
                                <?php foreach ($fetchcate as $key => $value) { ?>
                                    <option <?= $a['id_categorie'] == $value['idc'] ? "selected" : NULL ?> value="<?= $value['idc'] ?>"><?= $value['nom'] ?></option>
                                <?php
                                } ?>
                            </select>
                        </td>
                        <td class=test><a class="btn btn-danger" href="editionarticle.php?supprimerarticle=<?= $a['ida'] ?>">Supprimer l'article</a></td>
                        <td class=test><input id="" type="submit" class="btn btn-primary" name="submit" value="Modifier"></td>
                    </form>
                </tr>
            <?php } ?>
        </table>
        <br><br>
        <?php
        if (isset($_SESSION['msg'])) {
            echo '<font color="red">' . $_SESSION['msg'] . '</font><br /><br />';
            $_SESSION['msg'] = "";
        }
        ?>
    </main>
    <footer>
        <?php
        include_once('footer.php');
        ?>
    </footer>
</body>
</html>
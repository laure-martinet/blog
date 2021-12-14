<?php
$bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
session_start();

//  if(!isset($_SESSION['id'])) // ID a changer a modérateur et admin
// {
//     exit();
// }
// else 
{

    $listecate = $bdd->query('SELECT * FROM categories ORDER BY id ASC');
    $getid = intval($_SESSION['id']); // Convertie ma valeur en int ( ID = un numéro )
    $requtilisateur = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?'); // créer une requete qui va récuperer tout de mon utilisateur de mon id actuel
    $requtilisateur->execute(array($getid)); // return le tableau de mon utilisateur
    $infoutilisateur = $requtilisateur->fetch(); // récupere les informations que j'appelle
    $a_msg = "";
    $categorie

    if(isset($_POST['submit_article'])) 
    {

    $titre = htmlspecialchars($_POST['titre']);
    $article = htmlspecialchars($_POST['article']);

        if(isset($_POST['article']) && !empty($_POST['article']))
        {
            $articlelenght = strlen($_POST['article']);

            if($articlelenght > 5000)
            $a_msg = "Votre article ne doit pas dépasser 5000 caractères !<br><br>";

        if ($a_msg == "") {
            $getcateg = $bdd->query('SELECT id FROM categories WHERE ')
            $lecommentaire = htmlspecialchars($_POST['article']);
            $postage = $bdd->prepare('INSERT INTO articles (id_utilisateur, id_categorie, article, titre, date) VALUES (?,?,?,?,NOW())');
            $postage->execute(array($getcateg,$getid,$lecommentaire,$titre));
            $a_msg = "<span style='color:green'>Votre article a bien été posté</span><br><br>";
            unset($_POST);
        }
        }
        else
        {
            $a_msg = "Champs vide";
            unset($_POST);
        }


    }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>Créer un article</title>
</head>
<body id="al_body">
    <header>
    <?php include_once('header.php'); ?>
    </header>
<main id="al_main">
    <form id="form_inscription" method="POST">
        Votre pseudo : <?php echo $infoutilisateur['login'] ?><br><br>
        <input type="text" placeholder="Titre" name="titre" id="titre" value="<?php if(isset($titre)) { echo $titre; } ?>" ><br><br>
        <textarea name="article" placeholder="Votre article..." value="<?php if(isset($article)) { echo $article; } ?>" style="width: 300px; height: 100px"></textarea><br /><br>
            <select name="select" id="select">
                    <?php while ($lis = $listecate->fetch()) { ?>

                        <option><?= $lis['nom'] ?></option>
                    <?php } ?>
                </select><br><br>
        <input type="submit" value="Poster mon article" name="submit_article"/>
    </form>
<br>
    <?php if(isset($a_msg)) { echo $a_msg; } ?>
</main>
<footer>
<?php include_once('footer.php'); ?>
</footer>
</body>
</html>

<?php 
}
?>
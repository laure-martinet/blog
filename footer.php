<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
<footer>
    <div id="footerbox">
    <a class="btn btn-secondary btn-lg" href="index.php"> Accueil</a>  
    <?php if (empty($_SESSION['utilisateur'])) 
    {
        echo
        "
        <a class='btn btn-secondary btn-lg' href='profil.php'> Profil</a>
        <a class='btn btn-secondary btn-lg' href='articles.php?categorie=1&page=1'>Ensembles articles</a>
        <a class='btn btn-secondary btn-lg' href='deconnexion.php'>Decconexion</a>
        ";
    }
if (isset($_SESSION['id_droits'])) {
    if ($_SESSION['id_droits']==42 || $_SESSION['id_droits']==1337) {
        echo"<a class='btn btn-secondary btn-lg' href='creer-article.php'>Créer un article</a>";
        echo"<a class='btn btn-secondary btn-lg' href='admin.php'>Administration</a>";   
    }
}
?>
            <a href="https://github.com/laure-martinet/blog.git"><img src="medias/unnamed-removebg-preview.png" height="60px" width="60px"></a>
        </div>
    </div>
</footer>
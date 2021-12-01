<html> 
    <head>
        <meta charset="utf-8">
        <link href="style.css" rel="stylesheet">
    </head>
<body id="lr_body">
<header id="lr_header">
    <?php
    date_default_timezone_set('UTC');
    if (isset($_SESSION['login'])){
        $login = $_SESSION['login'];
    ?>
    <nav class="lr_nav_header">
        <ul class="lr_ul_header">
            <?php 
            if($_SESSION['id_droits'] = 1337)
            if($_SESSION['id_droits'] == 1337){
            ?>
                <li ><a class="lr_li_header" href="index.php">Accueil</a></li>
                <li ><a class="lr_li_header" href="deconnexion.php">Déconnexion</a></li>
            <?php
            }
            else if ($_SESSION['id_droits'] = 42){
            ?>
                <li ><a class="lr_li_header" href="index.php">Accueil</a></li>
                <li ><a class="lr_li_header" href="modo.php">modérateur</a>
                <li ><a class="lr_li_header" href="deconnexion.php">Déconnexion</a></li>
            <?php
            }
            else if ($_SESSION['id_droits'] = 1){
            ?>
                <li ><a class="lr_li_header" href="index.php">Accueil</a></li>
                <li ><a class="lr_li_header" href="allArticle.php">Article</a>
                <li ><a class="lr_li_header" href="profil.php">Mon compte</a></li>
                <li ><a class="lr_li_header" href="creer-article.php">Add article</a></li>
                <li ><a class="lr_li_header" href="deconnexion.php">Déconnexion</a></li>
            <?php
            }
            ?> 
        </ul>
    </nav>
    <?php 
    }
    else{
    ?>
    <nav class="lr_nav_header">   
        <div id="lr_logo">
            <img src="../blog/medias/logo_blog.png">
        </div> 
        <ul class="lr_ul_header">
            <li ><a class="lr_li_header" href="index.php"> Accueil</a></li>
            <li ><a class="lr_li_header" href="inscription.php"> Inscription</a></li>
            <li ><a class="lr_li_header" href="connexion.php"> Connexion</a></li> 
        </ul>
    </nav>
    <?php
    }
    ?>
</header>
</body>
</html>
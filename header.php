<?php 
include('bdd.php');$listecat = $bdd->query('SELECT * FROM categories');
$categories = $listecat->fetchAll();
?>
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
    ?>
    <nav class="lr_nav_header">
    <div id="lr_logo">
        <img src="../blog/medias/logo_blog.png">
    </div> 
        <ul class="lr_ul_header">
            <?php 
            if($_SESSION['id_droits'] == 1){
            ?>
                <li ><a class="lr_li_header" href="index.php">Accueil</a></li> 
                <div class="dropdown">
                    <nav class="boutonmenuprincipal">Catégories</nav>
                    <div class="dropdown-child">
                        <?php
                        foreach($categories as $categorie){
                            echo '<a href="articles.php?categorie='.$categorie['id'].'">'.$categorie['nom'].'</a>';
                        }
                        ?>
                    </div>
                </div>
                <li ><a class="lr_li_header" href="profil.php">Profil</a></li>
                <li ><a class="lr_li_header" href="deconnexion.php">Déconnexion</a></li>
            <?php
            }
            else if ($_SESSION['id_droits'] == 42){
            ?>
                <li ><a class="lr_li_header" href="index.php">Accueil</a></li>
                <div class="dropdown">
                    <nav class="boutonmenuprincipal">Catégories</nav>
                    <div class="dropdown-child">
                    <?php
                        foreach($categories as $categorie){
                            echo '<a href="articles.php?categorie='.$categorie['id'].'">'.$categorie['nom'].'</a>';
                        }
                        ?>
                    </div>
                </div>                
                <li ><a class="lr_li_header" href="creer-article.php">Créer Article</a>
                <li ><a class="lr_li_header" href="deconnexion.php">Déconnexion</a></li>
            <?php
            }
            else if ($_SESSION['id_droits'] == 1337){
            ?>
                <li ><a class="lr_li_header" href="index.php">Accueil</a></li>     
                <div class="dropdown">
                    <nav class="boutonmenuprincipal">Catégories</nav>
                    <div class="dropdown-child">
                    <?php
                        foreach($categories as $categorie){
                            echo '<a href="articles.php?categorie='.$categorie['id'].'">'.$categorie['nom'].'</a>';
                        }
                        ?>
                    </div>
                </div>    
                <li ><a class="lr_li_header" href="creer-article.php">Créer Article</a></li>
                <li ><a class="lr_li_header" href="admin.php">Administrateur</a></li>
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
            <div class="dropdown">
                <nav class="boutonmenuprincipal">Catégories</nav>
                    <div class="dropdown-child">
                        <?php
                            foreach($categories as $categorie){
                                echo '<a href="articles.php?categorie='.$categorie['id'].'">'.$categorie['nom'].'</a>';
                            }
                        ?>
                    </div>
            </div>
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
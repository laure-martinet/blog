<?php
$bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', ''); 
if (isset($_POST['submit'])){
            $erreur = "";  
            $login = htmlspecialchars($_POST['login']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $confirmation = htmlspecialchars ($_POST['password2']);

        if (!empty($_POST['login']) AND !empty($_POST['email']) AND !empty($_POST['password']) AND !empty($_POST['password2'])){
            $loginlenght = strlen($login);  //Permet de calculer la longueur du login
            $requete=$bdd->prepare("SELECT * FROM utilisateurs WHERE login = ? "); 
            $requete->execute(array($login));
            $loginexist= $requete->rowCount();
            ($requete);
            $id_droits= 1;

            if ($loginlenght > 255)
            $erreur= "Votre pseudo ne doit pas depasser 255 caractères !";        
            elseif($password !== $confirmation)
                    $erreur="Les mots de passes sont differents !";
            if($loginexist !== 0)
                    $erreur = "Login déjà pris !";
            if($erreur == ""){
                $hashage = password_hash($password, PASSWORD_BCRYPT);
                $insertmbr= $bdd->prepare("INSERT INTO  utilisateurs (login, email, password, id_droits) VALUES(?, ?, ?, ?)");
                $insertmbr->execute(array($login, $email, $hashage, $id_droits));
                $erreur = "Votre compte à bien été créer !";
            }
        }
            else{
                $erreur="Tout les champs doivent être remplis !";
            }
}
?>
<!doctype html>
<html>
    <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Inscription</title>
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
                    <div style="color: yellow;"><?php
                    if (isset($erreur)){
                        echo $erreur;
                    }
                    ?></div>
                    <h1 class="lr_h2">S'inscrire</h1><br>
                        <input type="text" class="box-input" name="login" placeholder="Login" required /><br>
                        <input type="email" class="box-input" name="email" placeholder="email" required /><br>
                        <input type="password" class="box-input" name="password" placeholder="Mot de passe" required /><br>
                        <input type="password" class="box-input" name="password2" placeholder="Confirmez votre mot de passe" required /> <br><br>
                        <input type="submit" name="submit" value="S'inscrire" class="btn btn-secondary btn-lg" /> <br><br>
                        <p class="lr_h2">Déjà inscrit? <a id="color_link" href="connexion.php">Connectez-vous ici</a></p> 
                    </div>
                </form>
            </div>
        </main>
        <footer>
            <?php
                include_once('footer.php');
            ?>
        </footer>
    </body>
</html>
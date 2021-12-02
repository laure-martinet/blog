<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', '');

if(isset($_POST['formconnexion']))
{
    $loginconnect = htmlspecialchars($_POST['loginconnect']);
    $passwordconnect = $_POST['passwordconnect'];
    
    if(!empty($loginconnect) AND !empty($passwordconnect))
        {
            $requeteutilisateur = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
            $requeteutilisateur->execute(array($loginconnect));   // Execute le prepare
            $result = $requeteutilisateur->fetchAll();   // Return TOUTE la requete ( tableau )
                if (count($result) > 0){ // S'il trouve pas de même login, il return mauvais login
                    $sqlPassword = $result[0]['password'];  // Récupere le resultat du tableau (0)  /!\ SI PAS LE 0 ça marche pas /!\ et la colonne password
                    if(password_verify($passwordconnect, $sqlPassword)) // Si passwordconnect est hashé et qu'il est pareil que sql password c'est bon 
                        {
                        $_SESSION['id'] = $result[0]['id'];
                        $_SESSION['login'] = $result[0]['login'];
                        $_SESSION['email'] = $result[0]['email'];
                        $_SESSION['id_droits'] = $result[0]['id_droits'];
                        header("Location: profil.php");
                        }
                    else 
                        {
                        $erreur = "Mauvais mot de passe !";
                        }
                        
            }
            else{
                $erreur = "Mauvais login !";
            }
        }
        if ($_SESSION['login'] == 'admin'){
            header('Location: admin.php');
        }
    else
        {
        $erreur = "Tous les champs doivent être remplis !";
        }
}
?>
<html>
    <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <title>Connexion</title>
        <meta charset="utf-8">
    </head>
<body id="al_body">
    <header>
        <?php
            include_once ("header.php");
        ?>
    </header>
    <main id="al_main"> 
        <div id="deplacement_form"> 
            <form id="form_inscription" method="POST" action=""> 
                <?php 
                    if(isset($erreur))
                    {
                    echo '<font color="red">'.$erreur.'</font>'; 
                    }
                ?>
                <h1 class="lr_h2">Connexion</h1>
                <input type="text" class="box-input" name="loginconnect" placeholder="Login"><br>
                <input type="password" class="box-input" name="passwordconnect" placeholder="Password"><br><br>
                <input type="submit" class="btn btn-secondary btn-lg" name="formconnexion" value="Se connecter !"><br><br>
            </form>
        </div>    
    </main>
    <footer>
        <?php
            include_once ("footer.php");
        ?>
    </footer>
</body>
</html>
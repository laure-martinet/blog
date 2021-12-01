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
        <title>connexion</title>
        <meta charset="utf-8">
    </head>
<body>
    <header>
    
    </header>
    <h1>Connexion</h1>
        <div id="connexion">
            <form method="POST" action="">
                <input type="text" name="loginconnect" placeholder="Login">
                <input type="password" name="passwordconnect" placeholder="Password">
                <br /><br />
                <input type="submit" name="formconnexion" value="Se connecter !">
                <a href="http://localhost/module-connexion/projet1/index.php"><input type="submit" name="retour" value="Retour à l'accueil"></a>
            </form>
        </div>
    <footer>

    </footer>
    <?php 
        if(isset($erreur))
        {
        echo '<font color="red">'.$erreur.'</font>'; 
        }
        ?>
</html>
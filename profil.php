<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
if (isset($_SESSION['id']) && $_SESSION['id'] > 0) {
    $requtilisateur = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
    $requtilisateur->execute(array($_SESSION['id']));
    $infoutilisateur = $requtilisateur->fetch();

    if (isset($_POST['newlogin']) && !empty($_POST['newlogin']) && $_POST['newlogin'] != $infoutilisateur['login']) {
        $login = $_POST['newlogin'];
        $requetelogin = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?");
        $requetelogin->execute(array($login));
        $loginexist = $requetelogin->rowCount();

        if ($loginexist !== 0) {
            $msg = "Le login existe déjà !";
        } else {
            $newlogin = htmlspecialchars($_POST['newlogin']);
            $insertlogin = $bdd->prepare("UPDATE utilisateurs SET login = ? WHERE id = ?");
            $insertlogin->execute(array($newlogin, $_SESSION['id']));
            $_SESSION['login'] = $newlogin;
            header('Location: profil.php');
        }
    }
    if (isset($_POST['newemail']) && !empty($_POST['newemail']) && $_POST['newemail'] != $infoutilisateur['email']) {
        $newnom = htmlspecialchars($_POST['newemail']);
        $insertnom = $bdd->prepare("UPDATE utilisateurs SET email = ? WHERE id = ?");
        $insertnom->execute(array($newemail, $_SESSION['id']));
        header('Location: profil.php');
    }
    if (isset($_POST['newmdp']) && !empty($_POST['newmdp']) && isset($_POST['newmdp2']) && !empty($_POST['newmdp2'])) {
        $mdp1 = $_POST['newmdp'];
        $mdp2 = $_POST['newmdp2'];

        if ($mdp1 == $mdp2) {
            $hachage = password_hash($mdp1, PASSWORD_BCRYPT);
            $insertmdp = $bdd->prepare("UPDATE utilisateurs SET password = ? WHERE id = ?");
            $insertmdp->execute(array($hachage, $_SESSION['id']));
            header('Location: profil.php');
        } else {
            $msg = "Vos mots de passes ne correspondent pas !";
        }
    }
    if (isset($_POST['newlogin']) && $_POST['newlogin'] == $infoutilisateur['login']) {
        header('Location: profil.php');
    }
    
?>
<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body id=al_body>
    <header>
        <?php
        require('header.php');
        ?>
    </header>
    <main>
        <div id="deplacement_form">
            <form id="form_inscription" action="" method="post">
                <?php
                if (isset($msg)) {
                    echo '<font color="red">' . $msg . '</font><br /><br />';
                }
                ?>
                <h2 class="lr_h2">Modifier mes informations</h1><br>
                    <input type="text" class="box-input" name="newlogin" placeholder="Login" required /><br>
                    <input type="text" class="box-input" name="newemail" placeholder="email" required /><br>
                    <input type="password" class="box-input" name="newmdp" placeholder="Mot de passe" required /><br>
                    <input type="password" class="box-input" name="newmdp2" placeholder="Confirmez votre mot de passe" required /><br><br>
                    <input type="submit" name="submit" value="Enregistrer mes informations" class="btn btn-secondary btn-lg" /><br><br>
                    <a href="deconnexion.php"><input class="btn btn-secondary btn-lg" type="button" value="Déconnexion"></a>
            </form>
        </div>
    </main>
    <footer>
        <?php
        require('footer.php');
            } else{
        echo "Eh vous n'êtes pas censé être là !";  ?>
        <a href="../blog/index.php">Par ici</a>
        <?php } ?>
</body>

</html>
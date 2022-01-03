<?php
session_start();
include('bdd.php');

$utilisateurs = $bdd->query('SELECT utilisateurs.`id` as idutilisateur, `login`, `password`, `email`, `id_droits`,`nom` FROM `utilisateurs` INNER JOIN droits ON droits.id = utilisateurs.id_droits ORDER BY utilisateurs.id ASC;');
$listedroits = $bdd->query('SELECT * FROM droits');
$lis = $listedroits->fetchAll();


// ID nécessaire pour la connexion 
if (!isset($_SESSION['id']) || $_SESSION['id_droits'] != 1337) {
   header("Location: profil.php");
   exit();
}

// Fonction supprimé un utilisateur
if (isset($_GET['supprimer']) && !empty($_GET['supprimer'])) {
   $supprimer = (int) $_GET['supprimer'];
   $req = $bdd->prepare('DELETE FROM utilisateurs WHERE id = ?');
   $req->execute(array($supprimer));
   header("Location: admin.php");
   exit();
}

// Fonction Modifié le login d'un utilisateur
if (isset($_POST['newlogin']) && !empty($_POST['newlogin'])) {
   $idchange = $_POST['id'];
   $login = $_POST['newlogin'];
   $requetelogin = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
   $requetelogin->execute(array($login));
   $loginexist = $requetelogin->rowCount(); // rowCount = Si une ligne existe = PAS BON

   if ($loginexist !== 0) {
      $msg = "Le login existe déjà !";
   } else {
      $newlogin = htmlspecialchars($_POST['newlogin']);
      $insertlogin = $bdd->prepare("UPDATE utilisateurs SET login = ? WHERE id = ?");
      $insertlogin->execute(array($newlogin, $idchange));
      header('Location: admin.php');
      exit();
   }
}
// Fonction modifié l'email d'un utilisateur 
if (isset($_POST['newmail']) && !empty($_POST['newmail'])) {
   $idchange = $_POST['id'];
   $email = $_POST['newmail'];
   $requetemail = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = ?"); // SAVOIR SI LE MEME LOGIN EST PRIS
   $requetemail->execute(array($email));
   $emailexist = $requetemail->rowCount(); // rowCount = Si une ligne existe = PAS BON

   if ($emailexist !== 0) {
      $msg = "L'email existe déjà !";
   } else {
      $newmail = htmlspecialchars($_POST['newmail']);
      $insertlogin = $bdd->prepare("UPDATE utilisateurs SET email = ? WHERE id = ?");
      $insertlogin->execute(array($newmail, $idchange));
      header('Location: admin.php');
      exit();
   }
}
// Fonction modifié le rang d'un utilisateur
if (isset($_POST['select'])) {

   $idchange = $_POST['id'];
   $rang = $_POST['select'];
   $changerrang = $bdd->prepare("UPDATE utilisateurs SET id_droits = ? WHERE id = ?");
   $changerrang->execute(array($rang, $idchange));
   header('Location: admin.php');
   exit();
}


?>

<!DOCTYPE html>
<html>

<head>
   <meta charset="UTF-8">
   <link rel="stylesheet" type="text/css" href="style.css">
   <title>Espace Administrateur</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body id="al_body">
   <header>
      <?php
      include_once('header.php');
      ?>
   </header>
   <main id="al_main">
      <div id="div_admin">
      <table id="LMtitrediv">
         <h1 class="LM_color_text">Espace Administrateur</h1>
         <thead>
            <tr>
               <th class="LM_color_text">Login</th>
               <th class="LM_color_text">Email</th>
               <th class="LM_color_text">Droits</th>
         </thead>
         <?php while ($u = $utilisateurs->fetch()) { ?>
            <form method="POST">
               <input class="text_admin" type="hidden" name="id" value="<?php echo $u['idutilisateur']; ?>">
               <label class="text_admin" for="newlogin"></label>
               <td><input class="text_admin" id="newlogin" type="text" name="newlogin" value="<?php echo $u['login']; ?>"></td>
               <label class="text_admin" for="newmail"></label>
               <td><input class="text_admin" id="newmail" type="mail" name="newmail" value="<?php echo $u['email']; ?>"></td>
               <td>
                  <select name="select" id="select">
                     <?php foreach ($lis as $key => $value) { ?>
                        <option <?= $u['id_droits'] == $value['id'] ? "selected" : NULL ?> value="<?= $value['id'] ?>"><?= $value['nom'] ?></option>
                     <?php
                     } ?>
                     <!-- Boucle qui permet de savoir le rang de mon utilisateur -->
                  </select>
               </td>
               <td class=test><a class="btn btn-danger" href="admin.php?supprimer=<?= $u['idutilisateur'] ?>">Bannir</a></td>
               <td class=test><input type="submit" class="btn btn-primary" name="submit" value="Confirmer !"></td>
            </form>
            </tr>
         <?php } ?>
      </table>
      <br>
      <br>
      <?php
      if (isset($msg)) {
         echo '<font color="pink">' . $msg . '</font><br /><br />';
      }
      ?>
      <a href="deconnexion"><input class="btn btn-secondary btn-lg" type="button" value="Déconnexion"></a>
      <a href="creer-article.php"><input class="btn btn-secondary btn-lg" type="button" value="Crée article"></a>
      <a href="editionarticle.php"><input class="btn btn-secondary btn-lg" type="button" value="Modifier article"></a>
      </div>
   </main>

   <footer>
      <?php
      include_once('footer.php');
      ?>
   </footer>
</body>
</head>
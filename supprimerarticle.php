<?php
include('bdd.php');

if(isset($_GET['id']) AND !empty($_GET['id'])){
$getid = $_GET['id'];
$recuparticle = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
$recuparticle->execute(array($getid));

if($recuparticle->rowCount() > 0){
$supparticle = $bdd->prepare('DELETE FROM articles WHERE id = ?');
$supparticle->execute(array($getid));
header('location: editionarticle.php');
exit();
}
else{
    echo "Aucun article n'a été trouvé !";
    header('location: editionarticle.php');
exit();
}
}
?>
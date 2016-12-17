<?php
session_start();
require_once 'settings/bdd.inc.php'; //liaison avec le fichier php relié à la bdd
require_once 'settings/init.inc.php'; //liaison avec le fichier php permettant d'afficher les erreurs à l'écran (facultatif)

#------------------Smarty------------------#
require_once 'libs/Smarty.class.php';

#------------------Connexion------------------#
include_once 'includes/connexion.inc.php';

if (isset($_POST['connexion'])) {
$sth = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = :email AND mdp = :mdp");
$sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR); //Sécurité
$sth->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR); //Sécurité
$sth->execute();
$count = $sth->rowCount();

if ($count == 1) {
    echo "Authentification reussie";
    $tab_connexion = $sth->fetchAll(PDO::FETCH_ASSOC); //Forme le tableau
    $email = $tab_connexion[0]['email'];
    $sid = md5($email . time());
    $maj = $bdd->prepare("UPDATE utilisateurs SET sid = :sid");
    $maj->bindValue(':sid', $sid, PDO::PARAM_STR);
    $maj->execute();
    
    setcookie('sid', $sid, time() +30);
    
     $_SESSION['statut_connexion'] = TRUE;
    header("Location: index.php");

} else {
   
$_SESSION['statut_connexion'] = FALSE;
header("Location: connexion.php");
}

} else {
    $smarty = new Smarty();

$smarty->template_dir = 'templates/';
$smarty->compile_dir = 'templates_c/';
//$smarty->setConfigDir('/web/www.example.com/guestbook/configs/');
//$smarty->setCacheDir('/web/www.example.com/guestbook/cache/');


if (isset($_SESSION['statut_connexion'])) {
$smarty->assign('statut_connexion', $_SESSION['statut_connexion']); 
} 
unset($_SESSION['statut_connexion']);
//** un-comment the following line to show the debug console
$smarty->debugging = true;



include_once 'includes/header.inc.php'; //appelle du fichier php header
$smarty->display('connexion.tpl');
include_once 'includes/menu.inc.php'; //appelle du fichier php menu
include_once 'includes/footer.inc.php'; //appelle du fichier php footer

}

##PHP
#vérif champs postés
#comparer en base le couple login/mdp
#Si ok: créer variable aléatoire -> inserer variable en base -> créer cookie -> Rédiriger l'utilisateur vers l'accueil -> afficher msg confirmation
#Si non: rediriger vers la page login -> afficher message erreur
?>
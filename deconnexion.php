<?php
session_start();
include_once 'connexion.php';
mysql_query("DELETE FROM utilisateurs WHERE sid = ".$_SESSION['sid']) or exit(mysql_error());
vider_cookie();
session_destroy();

$informations = Array(/*Déconnexion*/
				false,
				'Déconnexion',
				'Vous êtes à présent déconnecté.',
				' - <a href="'.ROOTPATH.'http://wallynvincent.esy.es/connexion.php">se connecter</a>',
				ROOTPATH.'/index.php',
				5
				);

require_once('../information.php');
exit();
?>



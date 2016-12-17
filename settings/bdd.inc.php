<?php
try {
    $bdd = new PDO('mysql:host=localhost;dbname=u198625674_wally;charset=utf8', 'u198625674_wally', 'ewynauleakeacerten5b');
    $bdd->exec("set names utf8");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);       
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
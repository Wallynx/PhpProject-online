<?php
if (isset($_COOKIE['sid']) && !empty($_COOKIE['sid']))
{
   $sth = $bdd->prepare("SELECT sid FROM utilisateurs WHERE sid = :sid"); 
    $sth->bindValue(':sid', $_POST['sid'], PDO::PARAM_STR); //Sécurise la requete
    $sth->execute();
    $count = $sth->rowCount();
echo " $count '</br>'";
if ($count>0) {
    //echo "le sid correspond";
    $_COOKIE['connecté'] = TRUE;
    }
else {
    //echo "le sid ne correspond pas";
    $_COOKIE['connecté'] = FALSE;
} 
}
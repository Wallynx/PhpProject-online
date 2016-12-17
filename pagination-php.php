<?php
require_once 'settings/bdd.inc.php'; //liaison avec le fichier php relié à la bdd
require_once 'settings/init.inc.php'; //liaison avec le fichier php permettant d'afficher les erreurs à l'écran (facultatif)

#------------------Pagination------------------#*

/*  Résultat : Page courante , Index de départ , index d'arrivée
Déclarer la variable du nombre d'articles par page
variable qui contient la page courante
<?php $maVariable = $GET['p'] ?>
Calculer l'index de départ de la requete
<?php
cell($value) //retourne entier supérieur  */

$NbArticlesParPage = 2;
$pageCourante = isset($_GET['p']) ? $_GET['p'] : 1;

function indexstart($NbArticlesParPage, $pageCourante) {
    $debut = ($pageCourante-1)*($NbArticlesParPage); //index de départ
    return $debut;
}
$sql = "UPDATE articles SET titre ='$titre', texte ='$texte', publie='$publie' WHERE id='$id'";

$indexdepart = indexstart($NbArticlesParPage, $pageCourante);

echo '<br/><h2><b>Page : ' . $pageCourante .' - index de départ: <u>' . $indexdepart . '</u></b></h2>' ;

$articlestotal = $bdd->prepare("SELECT COUNT(*) as NbArticles FROM articles WHERE publie = :publie");
$articlestotal->bindValue(':publie', 1, PDO::PARAM_INT); //sécurise la requête
$articlestotal->execute();

$tab_articles = $articlestotal->fetchAll(PDO::FETCH_ASSOC);
print_r($tab_articles);

$NbArticlesInBdd = $tab_articles[0]['NbArticles'];

$NbPage = ceil($NbArticlesInBdd / $NbArticlesParPage);

echo "<br/><h2><b>Nombre d'articles en bdd  <u>$NbArticlesInBdd</u> Nombre de pages à créer: <u>$NbPage</u></b></h2>" ;

?>
<?php
session_start();
require_once 'settings/bdd.inc.php'; //liaison avec le fichier php relié à la bdd
require_once 'settings/init.inc.php'; //liaison avec le fichier php permettant d'afficher les erreurs à l'écran (facultatif)
include_once 'includes/header.inc.php'; //appelle du fichier php header
include_once 'includes/menu.inc.php'; //appelle du fichier php menu 

#------------------Articles------------------#
$NbArticlesParPage = 3;
$pageCourante = isset($_GET['p']) ? $_GET['p'] : 1;

function indexstart($NbArticlesParPage, $pageCourante) {
    $debut = ($pageCourante-1)*($NbArticlesParPage); //index de départ
    return $debut;}

$indexdepart = indexstart($NbArticlesParPage, $pageCourante);
//echo '<br/><h2><b>Page : ' . $pageCourante .' - index de départ: <u>' . $indexdepart . '</u></b></h2>' ;

$articlestotal = $bdd->prepare("SELECT COUNT(*) as NbArticles FROM articles WHERE publie = :publie");
$articlestotal->bindValue(':publie', 1, PDO::PARAM_INT); //sécurise la requête
$articlestotal->execute();


$tab_articles = $articlestotal->fetchAll(PDO::FETCH_ASSOC);
#print_r($tab_articles);

$NbArticlesInBdd = $tab_articles[0]['NbArticles'];
$NbPage = ceil($NbArticlesInBdd / $NbArticlesParPage);//ceil calcule en retournant un arrondi supérieur ex 13 articles font 6.5 pages donc 7 avec un seul article

//echo "<br/><h2><b>Nombre d'articles en bdd  <u>$NbArticlesInBdd</u> Nombre de pages à créer: <u>$NbPage</u></b></h2>" ;
//$sth = $bdd->prepare("SELECT id, titre, texte, DATE_FORMAT(date, '%d/%m/%Y') as date_fr FROM articles WHERE publie = :publie"); //préparation de la requête


$sth = $bdd->prepare("SELECT id, titre, texte, DATE_FORMAT(date, '%d/%m/%Y') as date_fr FROM articles WHERE publie =:publie LIMIT $indexdepart, $NbArticlesParPage"); //préparation de la requête
//LIMIT indexDépart, NbrArticle ex LIMIT 0,2 = on retourne 2 articles a partir du 0 donc 1 et 2.
$sth->bindValue(':publie', 1, PDO::PARAM_INT); //sécurise la requête
$sth->execute();
$tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC);
//print_r($tab_articles); ->récup les données de la bdd dans un tableau.


##------------------Notification------------------>        

 //if (isset($_COOKIE['sid'])) {                                        ##--condition permettant de controler la présence du cookie de connexion-->
if (isset($_SESSION['statut_connexion'])){    
?>
        <div class = "alert alert-success text-center" role = "alert">   <!--Affichage d'un message de confirmation de connexion-->
            <strong>Authentification réussie.</strong>
        </div>
<?php unset($_SESSION['statut_connexion']);}
foreach ($tab_articles as $value) {
    ?>
<!-- Le if isset ci-dessus permet de retirer la notification une fois que nous sommes connectés.-->



<h2><?php echo $value['titre'] ?></h2><div class="span8">
        


<!------------------Modification d'article------------------>        
<div> <a href ="article.php?id=<?= $value['id']?>"> Modifier l'article </a> </div> 
    
    <img src="img/<?php echo $value['id'] ?>.jpg" width="300px" alt="<?php echo $value['titre'] ?>"/>
    <p style="text-align: justify;"><?php echo $value['texte']?></p>
    <p><em><u>Publié le : <?php echo $value['date_fr']?></u></em></p><br>
  
    
          <?php } ?>
    
<!------------------Pagination------------------>    
    <center>
<div class="pagination">
    <ul>
        <li><a>Page : </a></li>
        <?php for ($i = 1; $i <= $NbPage; $i++) { ?>
            <li <?php if ($pageCourante == $i) { ?>class="active"<?php } ?>><a href=index.php?p=<?= $i ?>"><?= $i ?></a></li>
                    <?php } ?>
            </ul> 
        </div>
    </center>
</div>   
    
 <?php 
 include_once 'includes/menu.inc.php'; //appelle du fichier php menu
 include_once 'includes/footer.inc.php'; //appelle du fichier php footer
?>
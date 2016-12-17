<?php
session_start();
require_once 'settings/bdd.inc.php'; //liaison avec le fichier php relié à la bdd
require_once 'settings/init.inc.php'; //liaison avec le fichier php permettant d'afficher les erreurs à l'écran (facultatif)

#------------------Article------------------#
if (isset($_GET['id'])) {


    $idarticles = $bdd->prepare("SELECT * FROM articles WHERE id = :id");
    $idarticles->bindValue(':id', $_GET['id'], PDO::PARAM_INT); //Sécurise la requete
    $idarticles->execute(); //cette requette donne dans un tableau et sous tableau le nombre totale d'article

    $tabid_articles = $idarticles->fetchAll(PDO::FETCH_ASSOC); //Créer le tableau

    $titrearticle = $tabid_articles[0]['titre'];
    $textearticle = $tabid_articles[0]['texte'];
    $publiearticle = $tabid_articles[0]['publie'];
    $iddelarticle = $tabid_articles[0]['id'];
//print_r($tabid_articles); // récupére dans un tableau les donnée de la bdd
}


#------------------Ajout------------------#
if (isset($_POST['ajouter'])) {
##print_r($_FILES); //IMAGE
##exit();

    $date_ajout = date("Y-m-d"); //création d'une date
    $_POST['date_ajout'] = $date_ajout; //ajout de la date dans $_POST
#################condition simple:
#if(isset($_POST['publie'])){
#    $_POST['publie'] = 1;
#} else{
#    $_POST['publie'] = 0;
#}
##################################

    $_POST['publie'] = isset($_POST['publie']) ? 1 : 0; //condition ternaire (?=alors) (:=sinon)
#print_r($_POST);

    ##if ($_FILES['image']['error'] == 0) {
        $sth = $bdd->prepare("INSERT INTO articles (titre, texte, publie, date) VALUES (:titre, :texte, :publie, :date)");
        $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR); //Sécurise la requete
        $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR); //Sécurise la requete
        $sth->bindValue(':date', $_POST['date_ajout'], PDO::PARAM_STR); //Sécurise la requete
        $sth->bindValue(':publie', $_POST['publie'], PDO::PARAM_INT); //Sécurise la requete
        $sth->execute();

        $dernier_id = $bdd->lastInsertID(); //retourne l'identifiant qui vient d'être inséré
        //echo '<br> <b><u>' . $dernier_id . '<br> </u></b>';

        move_uploaded_file($_FILES['image']['tmp_name'], dirname(__FILE__) . "/img/$dernier_id.jpg");
        $_SESSION['ajout_article'] = TRUE;
        
##                header("Location: article.php");
##    } else {
##        echo 'Image non chargée';
##    }
##} else {

        
  
#------------------Modification------------------#
    } elseif(isset($_POST['modifier'])){

    
    $_POST['publie'] = isset($_POST['publie']) ? 1 : 0;
    $sth = $bdd->prepare("UPDATE articles SET titre = :titre1article, texte = :texte1article, publie = :publie1article WHERE id = :id1delarticle"); //requete préparer
    
    $sth->bindValue(':titre1article', $_POST['titre'], PDO::PARAM_STR); //Sécurise la requete
    $sth->bindValue(':texte1article', $_POST['texte'], PDO::PARAM_STR); //Sécurise la requete
    $sth->bindValue(':publie1article', $_POST['publie'], PDO::PARAM_INT); //Sécurise la requete 
    $sth->bindValue(':id1delarticle', $_POST['id'], PDO::PARAM_INT); //Sécurise la requete 
    $sth->execute();
    header("Location: index.php");
}
else {
    
    
$publiearticle = isset($publiearticle) ? 1 : 0;


 
    #------------------Formulaire HTML------------------#
    include_once 'includes/header.inc.php'; //appelle du fichier php header ?>
    <html>
        <div class="span8">
    <?php if (isset($_SESSION['ajout_article'])) { ?>
                <div class="alert alert-success" role="alert">
                    <strong>Félicitation</strong> Votre article a été ajouté.
                </div>
        <?php
        unset($_SESSION['ajout_article']);
    }
    ?>

            <form action="article.php" method="post" enctype="multipart/form-data" id="form_article" name="form_article">
                <input type="hidden" name="id" value="<?php if (isset($tabArticle)){ echo $tabArticle[0]['id']; } ?>"/>

                <div class="form-actions">

                    <div class="clearfix">
                        <label for="title">Titre</label>
                        <div class="input"><input type="text" name="titre" id="titre" value="<?php if (isset($tabArticle)){ echo $tabArticle[0]['titre']; } ?>"</div>
                    </div>          
                    <br>
                    <div class="clearfix">
                        <label for="texte">Texte</label>
                        <div class="input"><textarea name="texte" id="text" ></textarea></div>
                    </div>
                    <br>
                    <div class="clearfix">
                        <label for="image">Image</label>
                        <div class="input"><input type="file" name="image" id="image"></div>
                    </div>
                    <br>
                    <div class="clearfix">
                        <label for="publie">Publié</label>
                        <div class="input"><input type="checkbox" name="publie" id="publie"></div>
                    </div>
                    <br>
                                    
 #------------------Boutons------------------#
        <?php if (isset($_GET['id'])) { ?>
                    <div class="form-actions">        
                    <input type="submit" name="modifier" value="modifier" class="btn btn-large btn-primary">
                </div>
        <?php }else{ ?>
                    <div class=""form-actions">
                    <input type="submit" name="ajouter" value="ajouter" class="btn btn-large btn-primary">
                </div>
<?php }} ?>
    </form>
    </div>
    </html>

    

    <?php
include_once 'includes/footer.inc.php'; //appelle du fichier php footer
include_once 'includes/menu.inc.php'; //appelle du fichier php menu
    ?>

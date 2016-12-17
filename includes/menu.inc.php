<nav class="span4">
    <center><h3>Menu</h3></center>
            <ul>
                
                <?php if(isset ($_COOKIE['connecté'])) { ?><li><a href="http://wallynvincent.esy.es/deconnexion.php">Déconnexion</a> <li> <?php } else {?><li><a href="http://wallynvincent.esy.es/connexion.php"> Connexion  </a></li> <?php } ?>
                <li><a href="http://wallynvincent.esy.es/">Accueil</a></li>
                <li><a href="http://wallynvincent.esy.es/article.php">Rédiger un article</a></li>
            </ul>
          </nav>
</div>

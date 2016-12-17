<div class="span8">
<!------------------Notifs------------------>
  
    {if isset($statut_connexion) AND $statut_connexion == FALSE}
    <div class="alert alert-error" role=""alert>    
        <strong>Erreur </strong> Login et / ou mot de passe incorrect.
    </div>
    {/if}
<!------------------Contenu------------------>
    <form action="connexion.php" method="post" enctype="multipart/form-data" id="form_connexion" name="form_connexion">
           
            <div class="clearfix">
                        <label for="email">login</label>
                    <div class="input"><input type="text" name="email" id="email" value=""</div>
                    </div>          
                <br>
                    <div class="clearfix">
                    <label for="mdp">mot de passe</label>
                    <div class="input"><input type="password" name="mdp" id="mdp" value=""></textarea></div>
                    </div>
                <br>
                    <div class="form-actions">
                    <input type="submit" name="connexion" value="connexion" class="btn btn-large btn-primary">
                    </div>
            </div>
    </form>  
</div>
        <?php
            if (isset($_SESSION['liste_donnees_jdr'])) { ?>
                <hr>
                <form action="./compte.php">
                    <input type="hidden" name="action" value="deconnecter">
                    <input type="hidden" name="redirection_echec" value="<?=$_SERVER['REQUEST_URI']?>">
                    <input type="hidden" name="redirection_succes" value="<?=$_SERVER['REQUEST_URI']?>">
                    
                    <button type="submit">Se D&eacute;connecter</button>
                </form>
            <?php }
        ?>
    </body>
</html>

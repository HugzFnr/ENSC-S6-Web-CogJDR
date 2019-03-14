        <form action="./gestion_compte.php">
            <input type="hidden" name="action" value="deconnecter">
            <input type="hidden" name="redirection_echec" value="<?=$_SERVER['REQUEST_URI']?>">
            <input type="hidden" name="redirection_succes" value="<?=$_SERVER['REQUEST_URI']?>">
            
            <button type="submit">Se D&eacute;connecter</button>
        </form>
    </body>
</html>

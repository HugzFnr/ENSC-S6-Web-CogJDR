
        </div><!-- container -->

        <footer class="footer">
            <div class="container text-left">
                <?php
                    if (isset($_SESSION['liste_donnees_jdr'])) { ?>
                        <hr>
                        <form action="./compte.php">
                            <input type="hidden" name="action" value="deconnecter">
                            <input type="hidden" name="redirection_echec" value="<?=$_SERVER['REQUEST_URI']?>">
                            <input type="hidden" name="redirection_succes" value="<?=$_SERVER['REQUEST_URI']?>">
                            
                            <button type="submit" class="btn btn-warning float-right">Se D&eacute;connecter</button>
                        </form>
                    <?php }
                ?>
            </div>
        </footer>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>

<?php require "./inclus/page_debut.php" ?>

<div class="container">

<h1 class="text-center">Inscription</h1>

<div class="well">
    <form class="form-signin form-horizontal" role="form" action="./compte.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="redirection_echec" value="./#">
        <input type="hidden" name="redirection_succes" value="./#">

        <div class="form-group">
            <div class="col-sm-6 offset-sm-3">
                <p>Adresse e-mail (sera visible)</p>
                <input type="text" name="email" class="form-control" id="email" placeholder="E-mail"<?=empty($_REQUEST['email']) ? "" : " value=\"".$_REQUEST['email']."\""?> required autofocus>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6 offset-sm-3">
                <p>Mot de passe</p>
                <input type="password" name="mdp" class="form-control" id="mdp" placeholder="Mot de passe"<?=empty($_REQUEST['mdp']) ? "" : " value=\"".$_REQUEST['mdp']."\""?> oninput="form.confirm.pattern = escapeRegExp(this.value)" required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6 offset-sm-3">
                <p>Confirmer mot de passe</p>
                <input type="password" name="mdp" class="form-control" id="confirm" placeholder="tmtc." required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6 offset-sm-3">
                <input type="file" name="img" id="gestion_compte_img">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-4 offset-sm-5">
                <button type="submit" name="action" value="creer" class="btn btn-primary btn-block">Créer le compte</button>
            </div>
        </div>
    </form>

    <script>
        function escapeRegExp(str) {
            return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
        }
    </script>
</div>

</div>

<?php require "./inclus/page_fin.php" ?>

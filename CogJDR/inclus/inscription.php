<div class="container">
    <h1 class="text-center">Inscription</h1>

    <div class="well">
        <form id="form_inscription" class="form-signin form-horizontal" role="form" action="./compte.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="redirection_echec" value="./#">
            <input type="hidden" name="redirection_succes" value="./#">

            <div class="form-group">
                <div class="col-sm-6 offset-sm-3">
                    <p>Adresse e-mail (sera visible)</p>
                    <input type="text" name="email" class="form-control" id="email" placeholder="E-mail"<?=empty($_REQUEST['email']) ? "" : " value=\"".$_REQUEST['email']."\""?> required<?=empty($_REQUEST['email']) ? " autofocus" : ""?>>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-6 offset-sm-3">
                    <p>Mot de passe</p>
                    <input type="password" name="mdp" class="form-control" id="mdp" placeholder="Mot de passe"<?=empty($_REQUEST['mdp']) ? "" : " value=\"".$_REQUEST['mdp']."\""?> required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-6 offset-sm-3">
                    <p>Confirmer mot de passe</p>
                    <input type="password" name="mdp_confirm" class="form-control" id="mdp_confirm" placeholder="tmtc." required<?=empty($_REQUEST['email']) ? "" : " autofocus"?>><!--  oninput="form.confirm.pattern = escapeRegExp(this.value)" -->
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
            var mdp = document.getElementById("mdp");
            var mdp_confirm = document.getElementById("mdp_confirm");

            // utilisée pour vérivier que les champs sont les même
            function validerMPD() {
                mdp_confirm.setCustomValidity(mdp.value != mdp_confirm.value ? "Les mots de passe ne correspondent pas" : "");
            }

            mdp.onchange = validerMPD;
            mdp_confirm.onkeyup = validerMPD;
        </script>
    </div>
</div>

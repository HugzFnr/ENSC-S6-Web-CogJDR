<?php include "./inclus/page_debut.php" ?>

<h1 class="text-center"> Créer un modèle de JDR </h1>

<!-- partie 'Paramètres généraux' -->
<div class="container" id="menu1">
    <form id="form1" class="form-signin form-horizontal" role="form" action="./creer.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="redirection_echec" value="./#">
        <input type="hidden" name="redirection_succes" value="./#">

        <h3 class="text-center"> Paramètres généraux </h3>
        <div class="form-group">
            <div class="col-sm-6 offset-sm-3">
                <p>Titre du modèle</p>
                <input type="text" name="titre_modele" class="form-control" id="titre_modele" placeholder="Un nom sympa!" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6 offset-sm-3">
                <p>Nombre d'équipes différentes max.</p>
                <input type="number" name="nb_equipes" class="form-control" id="nb_equipes" required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6 offset-sm-3">
                <p>Nombre de rôles différents</p>
                <input type="number" name="nb_roles" class="form-control" id="nb_roles" required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6 offset-sm-3">
                <p>Nombre d'actions différentes</p>
                <input type="number" name="nb_actions" class="form-control" id="nb_actions"     required>
            </div>
        </div>

        <div class="form-group" id="fleche1">
            <div class="col-sm-6 offset-sm-3">
                <button type="submit" name="action" value="creer" class="btn btn-primary btn-block">Etape suivante</button>
            </div>
        </div>
    </form>
</div>
<!-- FIN partie 'Paramètres généraux' -->


<!-- partie 'Paramètres PAS GENERAUX AAH' -->
<div class="container invisible" style="margin-top: -29.42rem;" id="menu2">
    <form id="form2" class="form-signin form-horizontal" role="form" action="./creer.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="redirection_echec" value="./#">
        <input type="hidden" name="redirection_succes" value="./#">

        <h3 class="text-center"> Paramètres PAS GENERAUX AAH </h3>
        <div class="form-group">
            <div class="col-sm-6 offset-sm-3">
                <p>Titre du modèle</p>
                <input type="text" name="titre_modele" class="form-control" id="titre_modele" placeholder="Un nom sympa!" required autofocus>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6 offset-sm-3">
                <p>Nombre d'équipes différentes max.</p>
                <input type="number" name="nb_equipes"  class="form-control" id="nb_equipes" required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6 offset-sm-3">
                <p>Nombre de rôles différents</p>
                <input type="number" name="nb_roles" class="form-control" id="nb_roles" required>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-6 offset-sm-3">
                <p>Nombre d'actions différentes</p>
                <input type="number" name="nb_actions" class="form-control" id="nb_actions"     required>
            </div>
        </div>

        <div class="form-group" id="fleche1">
            <div class="col-sm-6 offset-sm-3">
                <button type="submit" name="action" value="creer" class="btn btn-primary btn-block">Etape suivante</button>
            </div>
        </div>
    </form>
</div>
<!-- FIN partie 'Paramètres PAS GENERAUX AAH' -->


<script>
    var etape = 1;

    $("#fleche1").click(function(e) {
        e.preventDefault();

        switch (etape) {
            case 1:
                    if ($("#form1")[0].checkValidity()) {
                        $("#menu1").toggleClass("invisible");
                        $("#menu2").toggleClass("invisible");
                        etape++;
                    } else {
                        alert("Veuillez renseigner les champs.");
                    }
                break;

            case 2:
                    if ($("#form2")[0].checkValidity()) {
                        /* ... */
                        etape++;
                    } else {
                        alert("Veuillez renseigner les champs.");
                    }
                break;
        }
    });
</script>


<?php include "./inclus/page_fin.php" ?>

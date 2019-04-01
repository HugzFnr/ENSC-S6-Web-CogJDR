<h1 class="text-center"> Créer une partie de JDR </h1>

<div class="row">

    <!-- partie 'Paramètres généraux' -->
    <div class="col">
        <div class="container actif" id="menu1">
            <form id="form1" class="form sign-in" role="form" action="./creer.php" method="post" enctype="multipart/form-data">

                <h3 class="text-center"> Choix du modèle </h3>
                <div class="form-group" id="fleche0">
                    <div class="col-sm-10 offset-sm-1">
                        <button name="quoi" value="modele" id="boutonCreer" class="btn btn-info btn-block" formaction="./creer.php">Créer un nouveau modèle</button>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10 offset-sm-1">
                        <label for="choix_modele"> <p>Faire apparaître les modèles pré existaaants</p> </label>
                        <input type="number" value="1" min="1" max="99" name="choix_modele" class="form-control" id="choix_modele" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10 offset-sm-1">
                        <label for="nb_roles"> <p>Pseudo de MJ</p> </label>
                        <!-- <input type="number" value="1" min="1" max="99" name="nb_roles" class="form-control" id="nb_roles" required> -->
                        <input type="text" name="pseudo_mj" class="form-control" id="pseudo_mj">
                    </div>
                </div>

                <div class="form-group" id="fleche1">
                    <div class="col-sm-10 offset-sm-1">
                        <button name="action" value="creer" id="bouton1" class="btn btn-primary btn-block">Etape suivante</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- FIN partie 'Paramètres généraux' -->


    <!-- partie 'Créer une équipe' -->
    <div class="col">
        <div class="container invisible" id="menu2">
            <form id="form2" class="form sign-in" role="form" action="./creer.php" method="post" enctype="multipart/form-data">

                <h3 class="text-center"> Paramètres de la partie</h3>

                <div class="form-group">
                    <div class="col-sm-10 offset-sm-1">
                        <label for="taille_equipe"> <p>Nombre max. de joueurs</p> </label>
                        <input type="number" value="12" min="1" max="999" name="nb_joueurs_max" class="form-control" id="nb_joueurs_max" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10 offset-sm-1">
                        <label for="nb_joueurs_min"> <p>Nombre min. de joueurs</p> </label>
                        <input type="number" value="12" min="1" max="999" name="nb_joueurs_min" class="form-control" id="nb_joueurs_min" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10 offset-sm-1">
                        <label for="effet_action"> <p>Occurence (jours de fonctionnement) </p> </label>
                        <select name="occurence" form="form2" class="form-control" id="occurence" required>
                            <option value="6"> Tous les jours sauf le dimanche
                            <option value="5"> Tous les jours sauf le week-end
                            <option value="7"> Tous les jours
                        </select>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col">
                        <div class="form-group" id="fleche2">
                                <button name="action" value="creer" id="bouton21" class="btn btn-primary btn-block">Etape précédente</button>
                            </div>
                        </div>
                        <div class="col">   
                        <div class="form-group" id="fleche3">
                                <button name="action" value="creer" id="bouton22" class="btn btn-primary btn-block">Etape suivante</button>                            
                        </div>
                    </div>
                </div>

                </div>
            </form>
        </div> 
    </div>
    <!-- FIN partie 'Créer une équipe' -->

    <!-- partie 'Créer le rôle' -->

    <div class="col">
        <div class="container invisible" id="menu3">
            <form id="form3" class="form sign-in" role="form" action="./creer.php" method="post" enctype="multipart/form-data">

                <h3 class="text-center"> Lancement de la partie </h3>
                <div class="form-group">
                    <div class="col-sm-10 offset-sm-1">
                        <p> Vous venez de choisir les options de votre partie. Vous allez être redirigé vers le tableau de bord
                        du lancement de la partie pour voir et répartir les joueurs qui rejoignent la partie.
                        Vous pourrez y décider de la lancer et récupérer le code d'invitation à partager. </p> 
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col">
                        <div class="form-group" id="fleche4">
                                <button name="action" value="creer" id="bouton31" class="btn btn-primary btn-block">Etape précédente</button>
                            </div>
                        </div>
                        <div class="col">   
                        <div class="form-group" id="fleche5">
                                <button name="action" value="creer" id="bouton32" class="btn btn-primary btn-block">Créer partie</button>                            
                        </div>
                    </div>
                </div>

                </div>
            </form>
        </div> 
    </div>
    <!-- FIN partie 'Créer le rôle' -->

</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"> // non, c'est celui là la framework pour l'effet de flash </script>

<script src="inclus/creer/creerPartie.js"></script>

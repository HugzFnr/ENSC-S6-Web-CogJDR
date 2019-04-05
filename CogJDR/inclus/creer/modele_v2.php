<h1 class="text-center"> Créer un modèle de JDR </h1>

<div class="row">
    <form id="form_total" class="form sign-in" role="form" action="./inclus/creer/faire_modele.php" method="post" enctype="multipart/form-data">
        <!-- partie 'Paramètres généraux' -->
        <div class="col">
            <div class="container actif menu-partie" id="menu1">
                <h3 class="text-center"> Paramètres généraux </h3>
                <div class="form-group">
                    <div class="col-sm-10 offset-sm-1">
                        <label for="titre_modele"> <p>Titre du modèle</p> </label>
                        <input type="text" name="titre_modele" class="form-control" id="titre_modele" placeholder="Un nom qui en jette !"  required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10 offset-sm-1">
                        <label for="nb_equipes"> <p>Nombre d'équipes différentes max.</p> </label>
                        <input type="number" value="1" min="1" max="99" name="nb_equipes" class="form-control" id="nb_equipes" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10 offset-sm-1">
                        <label for="nb_roles"> <p>Nombre de rôles différents</p> </label>
                        <input type="number" value="1" min="1" max="99" name="nb_roles" class="form-control disabled" id="nb_roles" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10 offset-sm-1">
                        <label for="nb_actions"> <p>Nombre d'actions différentes</p> </label>
                        <input type="number" value="1" min="1" max="99" name="nb_actions" class="form-control" id="nb_actions" required>
                    </div>
                </div>

                <div class="form-group" id="fleche1">
                    <div class="col-sm-10 offset-sm-1">
                        <button name="action" value="creer" id="bouton12" class="btn btn-primary btn-block etape-suivante">Etape suivante</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN partie 'Paramètres généraux' -->


        <!-- partie 'Créer une équipe' -->
        <div class="col" id="liste2">
            <div class="container invisible menu-partie" id="menu2">
                <div id="num0">
                    <h3 class="text-center"> Créer l'équipe  <b class="rouge" id="equipe_actuel0">1</b>/<b id="equipe_total0"></b> </h3>
                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="nom_equipe"> <p>Nom de l'équipe</p> </label>
                            <input type="text" name="nom_equipe" class="form-control" id="nom_equipe0" placeholder="Un nom fédérateur !" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="taille_equipe"> <p>Taille maximale de l'équipe (-1 = &infin;)</p> </label>
                            <input type="number" value="1" min="-1" max="99" name="taille_equipe"  class="form-control" id="taille_equipe0" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="discussion"> <p>Discussion autorisée</p> </label>
                            <select name="discussion" class="form-control" id="discussion0" required>
                                <option value=true> Oui </option>
                                <option value=false> Non </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="form-group" id="fleche2">
                                <button name="action" value="creer" id="bouton21" class="btn btn-primary btn-block etape-liste-precedente">Etape précédente</button>
                            </div>
                        </div>
                        <div class="col">   
                            <div class="form-group" id="fleche3">
                                <button name="action" value="creer" id="bouton23" class="btn btn-primary btn-block etape-liste-suivante">Etape suivante</button>                            
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <!-- FIN partie 'Créer une équipe' -->

        <!-- partie 'Créer le rôle' -->
        <div class="col" id="liste3">
            <div class="container invisible menu-partie" id="menu3">
                <div id="num0">
                    <h3 class="text-center"> Créer le rôle <b class="rouge" id="role_actuel0">1</b>/<b id="role_total0"></b> </h3>
                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="nom_role"> <p>Nom du rôle</p> </label>
                            <input type="text" name="nom_role" class="form-control" id="nom_role0" placeholder="Pas 'loup-garou' stp " required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="img_role"> <p>Image du rôle</p> </label>
                            <input type="file" name="img_role" accept=".jpg,.png,.jpeg,.gif" class="form-control" id="img_role0">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="desc_role"> <p>Description du rôle</p> </label>
                            <textarea name="discussion" class="form-control" id="desc_role0" placeholder="Décris donc qui est ce personnage !" required></textarea>                            
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="form-group" id="fleche4">
                                <button name="action" value="creer" id="bouton32" class="btn btn-primary btn-block etape-liste-precedente">Etape précédente</button>
                            </div>
                        </div>
                        <div class="col">   
                            <div class="form-group" id="fleche5">
                                <button name="action" value="creer" id="bouton34" class="btn btn-primary btn-block etape-liste-suivante">Etape suivante</button>                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN partie 'Créer le rôle' -->

        <!-- partie 'Créer l'action -->
        <div class="col" id="liste4">
            <div class="container invisible menu-partie" id="menu4">
                <div id="num0">
                    <h3 class="text-center"> Créer l'action <b class="rouge" id="action_actuel0">1</b>/<b id="action_total0"></b> </h3>
                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="titre_action"> <p>Titre de l'action</p> </label>
                            <input type="text" name="titre_action" class="form-control" id="titre_action0" placeholder="Un titre explicite (genre 'envoyer au bûcher') !" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="effecteur_action"> <p>Effecteur de l'action </p> </label>
                            <select name="effecteur_action" class="form-control" id="effecteur_action0" required>
                                <option> Vivants </option>
                                <option> Morts </option>
                                <option> Tous </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="cibles_action"> <p>Cibles potentielles de l'action </p> </label>
                            <select name="cibles_action" class="form-control" id="cibles_action0" required>
                                <option> Vivants </option>
                                <option> Morts </option>
                                <option> Tous </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="fct_origine_action"> <p>Equipe d'origine de la cible </p> </label>
                            <select name="fct_origine_action" class="form-control" id="fct_origine_action0" required>
                                <option> Placeholder</option>
                            </select>
                            <label for="fct_arrivee_action"> <p>Equipe d'arrivee de la cible </p> </label>
                            <select name="fct_arrivee_action" class="form-control" id="fct_arrivee_action0" required>
                                <option> Placeholder</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="effet_action"> <p>Effet de l'action </p> </label>
                            <select name="effet_action" class="form-control" id="effet_action0" required>
                                <?php
                                    $tab = array_slice(list_enum('ModeleAction', 'action_fct'), 0, 6);
                                    foreach ($tab as $i) { ?>
                                        <option value=<?=$i?>><?=$i?></option><?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="horaire_action"> <p>Horaire limite </p> </label>
                            <input type="time" name="horaire_action"  class="form-control" id="horaire_action0" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="msg_action"> <p>Message automatique de l'action (optionnel) </p> </label>
                            <textarea name="msg_action" class="form-control" id="msg_action0" placeholder="Pour avertir vos joueurs de ce qu'il s'est passé dans le chat général !"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="desc_action"> <p>Description de l'action</p> </label>
                            <textarea name="desc_action"  class="form-control" id="desc_action0" placeholder="Explique ce que fait l'action!" required></textarea>                            
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="form-group" id="fleche6">
                                <button name="action" value="creer" id="bouton43" class="btn btn-primary btn-block etape-liste-precedente">Etape précédente</button>
                            </div>
                        </div>
                        <div class="col">   
                            <div class="form-group" id="fleche7">
                                <button name="action" value="creer" id="bouton45" class="btn btn-primary btn-block etape-liste-suivante">Etape suivante</button>                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- partie 'Créer l'action' -->

        <!-- partie 'Finaliser le modèle' -->
        <div class="col">
            <div class="container invisible menu-partie" id="menu5">
                <h3 class="text-center"> Finaliser le modèle de JDR</h3>
                <div class="form-group">
                    <div class="col-sm-10 offset-sm-1">
                        <label for="desc_modele"> <p>Description de ce modèle</p> </label>
                        <textarea name="desc_modele" class="form-control" id="desc_modele" placeholder="Une jolie histoire !" required autofocus></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10 offset-sm-1">
                        <label for="fichier_regles"> <p>Fichier de règles</p> </label>
                        <input type="file" name="fichier_regles" accept=".pdf"  class="form-control" id="fichier_regles" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10 offset-sm-1">
                        <label for="img_banniere"> <p>Image de bannière</p> </label>
                        <input type="file" name="img_banniere" accept=".jpg,.png,.jpeg,.gif" class="form-control" id="img_banniere">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10 offset-sm-1">
                        <label for="img_fond"> <p>Image de fond</p> </label>
                        <input type="file" name="img_fond" accept=".jpg,.png,.jpeg,.gif" class="form-control" id="img_fond">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10 offset-sm-1">
                        <label for="img_logo"> <p>Logo du modèle</p> </label>
                        <input type="file" name="img_logo" accept=".jpg,.png,.jpeg,.gif" class="form-control" id="img_logo" required>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="form-group" id="fleche8">
                                <button name="action" value="creer" id="bouton54" class="btn btn-primary btn-block etape-precedente">Etape précédente</button>
                            </div>
                        </div>
                        <div class="col">   
                            <div class="form-group" id="fleche9">
                                <button type="submit" class="btn btn-primary btn-block">Créer le modèle</button>                     
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <!-- FIN partie 'Finaliser le modele' -->
    </form>
</div> <!-- .row -->

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"> // non, c'est celui là la framework pour l'effet de flash </script>
<script type="text/javascript" src="inclus/creer/creerModele_v2.js"></script>

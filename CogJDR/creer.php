<?php include "./inclus/page_debut.php" ?>

    <h1 class="text-center"> Créer un modèle de JDR </h1>
    <!-- partie 'Paramètres généraux' -->
    <div class="row">

        <div class="col">
            <div class="container actif" id="menu1">
                <form id="form1" class="form sign-in" role="form" action="./creer.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="redirection_echec" value="./#">
                    <input type="hidden" name="redirection_succes" value="./#">

                    <h3 class="text-center"> Paramètres généraux </h3>
                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="titre_modele"> <p>Titre du modèle</p> </label>
                            <input type="text" name="titre_modele" class="form-control" id="titre_modele" placeholder="Un nom sympa!"  required autofocus>
                        </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="nb_equipes"> <p>Nombre d'équipes différentes max.</p> </label>
                            <input type="number" min="1" max="99" name="nb_equipes" class="form-control" id="nb_equipes" required>
                        </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="nb_roles"> <p>Nombre de rôles différents</p> </label>
                            <input type="number" min="1" max="99" name="nb_roles" class="form-control disabled" id="nb_roles" required>
                        </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="nb_actions"> <p>Nombre d'actions différentes</p> </label>
                            <input type="number" min="1" max="99" name="nb_actions" class="form-control" id="nb_actions" required>
                        </div>

                        <div class="form-group" id="fleche1">
                            <div class="col-sm-10 offset-sm-1">
                                <button name="action" value="creer" id="bouton1" class="btn btn-primary btn-block">Etape suivante</button>
                            </div>
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
                    <input type="hidden" name="redirection_echec" value="./#">
                    <input type="hidden" name="redirection_succes" value="./#">

                    <h3 class="text-center"> Créer l'équipe ??/?? </h3>
                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="nom_equipe"> <p>Nom de l'équipe</p> </label>
                            <input type="text" name="nom_equipe" class="form-control" id="nom_equipe" placeholder="Un nom sympa!" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="taille_equipe"> <p>Taille maximale de l'équipe</p> </label>
                            <input type="number" min="1" max="99" name="taille_equipe"  class="form-control" id="taille_equipe" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="discussion"> <p>Discussion autorisée</p> </label>
                            <select name="discussion" class="form-control" id="discussion" required>
                                <option> Oui
                                <option> Non
                                <option> Peut-être
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
                    <input type="hidden" name="redirection_echec" value="./#">
                    <input type="hidden" name="redirection_succes" value="./#">

                    <h3 class="text-center"> Créer le rôle ??/?? </h3>
                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="nom_role"> <p>Nom du rôle</p> </label>
                            <input type="text" name="nom_role" class="form-control" id="nom_role" placeholder="Pas 'loup-garou' stp " required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="img_role"> <p>Image du rôle</p> </label>
                            <input type="file" name="img_role" accept=".jpg,.png,.jpeg" class="form-control" id="img_role">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="desc_role"> <p>Description du rôle</p> </label>
                            <textarea name="discussion" class="form-control" id="desc_role" required>
                            </textarea>
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

                                    <button name="action" value="creer" id="bouton32" class="btn btn-primary btn-block">Etape suivante</button>
                            
                            </div>
                        </div>
                    </div>

                    </div>
                </form>
            </div> 
        </div>
        <!-- FIN partie 'Créer le rôle' -->

        <!-- partie 'Créer l'action -->            

        <div class="col">
            <div class="container invisible" id="menu4">
                <form id="form4" class="form sign-in" role="form" action="./creer.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="redirection_echec" value="./#">
                    <input type="hidden" name="redirection_succes" value="./#">

                    <h3 class="text-center"> Créer l'action ??/?? </h3>
                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="titre_action"> <p>Titre de l'action</p> </label>
                            <input type="text" name="titre_action" class="form-control" id="titre_action" placeholder="Un titre explicite (genre 'envoyer au bûcher') !" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="effecteur_action"> <p>Effecteur de l'action </p> </label>
                            <select name="effecteur_action" class="form-control" id="effecteur_action" required>
                                <option> Vivants
                                <option> Morts
                                <option> Equipe 1
                                <option> Role pyromane
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="cibles_action"> <p>Cibles potentielles de l'action </p> </label>
                            <select name="cibles_action" class="form-control" id="cibles_action" required>
                                <option> Vivants
                                <option> Morts
                                <option> Equipe 1
                                <option> Role pyromane
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="fct_action"> <p>Fonctionnement de l'action </p> </label>
                            <select name="fct_action" class="form-control" id="fct_action" required>
                                <option> Vote majoritaire nul
                                <option> Vote majoritaire double
                                <option> Vote majoritaire rapide
                                <option> Vote minoritaire
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="effet_action"> <p>Effet de l'action </p> </label>
                            <select name="effet_action" class="form-control" id="effet_action" required>
                                <option> Tuer
                                <option> Ressuciter
                                <option> Protéger
                                <option> Révéler
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="horaire_action"> <p>Horaire limite </p> </label>
                            <input type="time" name="horaire_action"  class="form-control" id="horaire_action" required>
                        </div>
                    </div>                                                                    

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="msg_action"> <p>Message automatique de l'action</p> </label>
                            <textarea name="msg_action"  class="form-control" id="msg_action" placeholder="Pour avertir vos joueurs de ce qu'il s'est passé dans le chat général !" required>
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="desc_action"> <p>Description de l'action</p> </label>
                            <textarea name="desc_action"  class="form-control" id="desc_action" placeholder="Explique ce que fait l'action!" required>
                            </textarea>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col">
                            <div class="form-group" id="fleche6">

                                    <button name="action" value="creer" id="bouton41" class="btn btn-primary btn-block">Etape précédente</button>
                                </div>
                            </div>
                            <div class="col">   
                            <div class="form-group" id="fleche7">

                                    <button name="action" value="creer" id="bouton42" class="btn btn-primary btn-block">Etape suivante</button>
                            
                            </div>
                        </div>
                    </div>

                    </div>
            </form>    
            </div> 
        </div>
        <!-- partie 'Créer l'action' -->

        <!-- partie 'Finaliser le modèle' -->            

        <div class="col">
            <div class="container invisible" id="menu5">
                <form id="form5" class="form sign-in" role="form" action="./creer.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="redirection_echec" value="./#">
                    <input type="hidden" name="redirection_succes" value="./#">

                    <h3 class="text-center"> Finaliser le modèle de JDR</h3>
                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="desc_modele"> <p>Description de ce modèle</p> </label>
                            <textarea name="desc_modele" class="form-control" id="desc_modele" placeholder="Une jolie histoire !" required autofocus>
                            </textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="fichier_regles"> <p>Fichier de règles</p> </label>
                            <input type="file" name="fichier_regles" accept=".pdf,.docx,.doc,.odt"  class="form-control" id="fichier_regles" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="img_banniere"> <p>Image de bannière</p> </label>
                            <input type="file" name="img_banniere" accept=".jpg,.png,.jpeg" class="form-control" id="img_banniere">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="img_fond"> <p>Image de fond</p> </label>
                            <input type="file" name="img_fond" accept=".jpg,.png,.jpeg" class="form-control" id="img_fond">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="img_logo"> <p>Logo du modèle</p> </label>
                            <input type="file" name="img_logo" accept=".jpg,.png,.jpeg" class="form-control" id="img_logo" required>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col">
                            <div class="form-group" id="fleche8">

                                    <button name="action" value="creer" id="bouton51" class="btn btn-primary btn-block">Etape précédente</button>
                                </div>
                            </div>
                            <div class="col">   
                            <div class="form-group" id="fleche9">

                                    <button name="action" value="creer" id="bouton52" class="btn btn-primary btn-block">Valider et créer le modèle</button>
                            
                            </div>
                        </div>
                    </div>

                    </div>
                </form>
            </div> 
        </div>

    <!-- FIN partie 'Finaliser le modele' -->

    </div>

<!-- FIN du form -->


<script>

    //console.log(document.getElementById("titre_modele").value); ça servira ça

    $("#fleche1").click(function(e) { ClicFlecheImpair(1,e); });
    $("#fleche3").click(function(e) { ClicFlecheImpair(3,e); });
    $("#fleche5").click(function(e) { ClicFlecheImpair(5,e); });
    $("#fleche7").click(function(e) { ClicFlecheImpair(7,e); });

    $("#fleche2").click(function(e) { ClicFlechePair(2,e); });
    $("#fleche4").click(function(e) { ClicFlechePair(4,e); });
    $("#fleche6").click(function(e) { ClicFlechePair(6,e); }); 
    $("#fleche8").click(function(e) { ClicFlechePair(8,e); });     


    function ClicFlecheImpair (numeroFleche,e)
     {
            e.preventDefault(); //on vérifie que tous les éléments de la partie du formulaire sont correctement remplis
                if ($("#form"+(Math.floor(numeroFleche/2)+1))[0].checkValidity()) {
                    DesactiverPanneau(Math.floor(numeroFleche/2)+1);//désactive le panneau associé au bouton flèche
                    AfficherMasquerPanneau(Math.floor(numeroFleche/2)+2); //et affiche le panneau suivant
                    //https://stackoverflow.com/questions/5338716/get-multiple-elements-by-id faut plutot récupérer toutes les flèches en leur donnant une classe puis utiliser leur chiffre comme iter

                } else {
                    alert("Veuillez renseigner les champs.");
                }
            }

    function ClicFlechePair (numeroFleche,e)
    {
            e.preventDefault();
                        if ($("#form1")[0].checkValidity()) {

                            DesactiverPanneau(Math.floor(numeroFleche/2)+1);
                            ActiverPanneau(1);     

                        } else {
                            alert("Veuillez renseigner les champs.");
                        }
            }


    function DesactiverPanneau(numero)
    {
        if (numero==1)
        {
            $("#titre_modele").attr('disabled','');
            $("#nb_equipes").attr('disabled','');
            $("#nb_roles").attr('disabled','');
            $("#nb_actions").attr('disabled','');
            $("#bouton1").attr('disabled','');   
        }
        else if (numero==2)
        {
            $("#nom_equipe").attr('disabled','');
            $("#taille_equipe").attr('disabled','');
            $("#discussion").attr('disabled','');
            $("#bouton21").attr('disabled','');
            $("#bouton22").attr('disabled','');
        }     
    }

    function ActiverPanneau(numero)
    {
        if (numero==1)
        {
            $("#titre_modele").attr('enabled','');
            $("#nb_equipes").attr('enabled','');
            $("#nb_roles").attr('enabled','');
            $("#nb_actions").attr('enabled','');
            $("#bouton1").attr('enabled','');
        }
        else if (numero==2)
        {
            $("#nom_equipe").attr('enabled','');
            $("#taille_equipe").attr('enabled','');
            $("#discussion").attr('enabled','');
            $("#bouton21").attr('enabled','');
            $("#bouton22").attr('enabled','');
        }        
    }

    function AfficherMasquerPanneau(numero)
    {
        $("#menu" + numero).toggleClass("invisible"); //pratique
    }




</script>


<?php include "./inclus/page_fin.php" ?>

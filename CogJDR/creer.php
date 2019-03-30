<?php include "./inclus/page_debut.php" ?>

    <h1 class="text-center"> Créer un modèle de JDR </h1>
    <!-- partie 'Paramètres généraux' -->
    <form id="form1" class="form sign-in" role="form" action="./creer.php" method="post" enctype="multipart/form-data">
        <div class="row">

            <div class="col">
                <div class="container actif" id="menu1">

                    <input type="hidden" name="redirection_echec" value="./#">
                    <input type="hidden" name="redirection_succes" value="./#">

                    <h3 class="text-center"> Paramètres généraux </h3>
                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <p>Titre du modèle</p>
                            <input type="text" name="titre_modele" class="form-control" id="titre_modele" placeholder="Un nom sympa!"  required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <p>Nombre d'équipes différentes max.</p>
                            <input type="number" min="1" max="99" name="nb_equipes" class="form-control" id="nb_equipes" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <p>Nombre de rôles différents</p>
                            <input type="number" min="1" max="99" name="nb_roles" class="form-control disabled" id="nb_roles" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <p>Nombre d'actions différentes</p>
                            <input type="number" min="1" max="99" name="nb_actions" class="form-control" id="nb_actions" required>
                        </div>
                    </div>

                    <div class="form-group" id="fleche1">
                        <div class="col-sm-10 offset-sm-1">
                            <button name="action" value="creer" id="bouton1" class="btn btn-primary btn-block">Etape suivante</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIN partie 'Paramètres généraux' -->


            <!-- partie 'Créer une équipe' -->
            <div class="col">
                <div class="container invisible" id="menu2">

                        <input type="hidden" name="redirection_echec" value="./#">
                        <input type="hidden" name="redirection_succes" value="./#">

                        <h3 class="text-center"> Créer l'équipe ??/?? </h3>
                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Nom de l'équipe</p>
                                <input type="text" name="nom_equipe" class="form-control" id="nom_equipe" placeholder="Un nom sympa!" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Taille maximale de l'équipe</p>
                                <input type="number" min="1" max="99" name="taille_equipe"  class="form-control" id="taille_equipe" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Discussion autorisée</p>
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
                    
                </div> 
            </div>
            <!-- FIN partie 'Créer une équipe' -->

            <!-- partie 'Créer le rôle' -->

            <div class="col">
                <div class="container invisible" id="menu3">

                        <input type="hidden" name="redirection_echec" value="./#">
                        <input type="hidden" name="redirection_succes" value="./#">

                        <h3 class="text-center"> Créer le rôle ??/?? </h3>
                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Nom du rôle</p>
                                <input type="text" name="nom_role" class="form-control" id="nom_role" placeholder="Pas 'loup-garou' stp " required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Image du rôle</p>
                                <input type="file" name="img_role" accept=".jpg,.png,.jpeg" class="form-control" id="img_role">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Description du rôle</p>
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
                    
                </div> 
            </div>
            <!-- FIN partie 'Créer le rôle' -->

            <!-- partie 'Créer l'action -->            

            <div class="col">
                <div class="container invisible" id="menu4">

                        <input type="hidden" name="redirection_echec" value="./#">
                        <input type="hidden" name="redirection_succes" value="./#">

                        <h3 class="text-center"> Créer l'action ??/?? </h3>
                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Titre de l'action</p>
                                <input type="text" name="titre_action" class="form-control" id="titre_action" placeholder="Un titre explicite (genre 'envoyer au bûcher') !" required autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Effecteur de l'action </p>
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
                                <p>Cibles potentielles de l'action </p>
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
                                <p>Fonctionnement de l'action </p>
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
                                <p>Effet de l'action </p>
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
                                <p>Horaire limite </p>
                                <input type="time" name="horaire_action"  class="form-control" id="horaire_action" required>
                            </div>
                        </div>                                                                    

                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Message automatique de l'action</p>
                                <textarea name="msg_action"  class="form-control" id="msg_action" placeholder="Pour avertir vos joueurs de ce qu'il s'est passé dans le chat général !" required>
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Description de l'action</p>
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
                    
                </div> 
            </div>
            <!-- partie 'Créer l'action' -->

            <!-- partie 'Finaliser le modèle' -->            

            <div class="col">
                <div class="container invisible" id="menu5">

                        <input type="hidden" name="redirection_echec" value="./#">
                        <input type="hidden" name="redirection_succes" value="./#">

                        <h3 class="text-center"> Finaliser le modèle de JDR</h3>
                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Description de ce modèle</p>
                                <textarea name="desc_modele" class="form-control" id="desc_modele" placeholder="Une jolie histoire !" required autofocus>
                                </textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Fichier de règles</p>
                                <input type="file" name="fichier_regles" accept=".pdf,.docx,.doc,.odt"  class="form-control" id="fichier_regles" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Image de bannière</p>
                                <input type="file" name="img_banniere" accept=".jpg,.png,.jpeg" class="form-control" id="img_banniere">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Image de fond</p>
                                <input type="file" name="img_fond" accept=".jpg,.png,.jpeg" class="form-control" id="img_fond">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Logo du modèle</p>
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
                    
                </div> 
            </div>

        <!-- FIN partie 'Finaliser le modele' -->

        </div>
    </form>
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

    //ce tableau de 5 lignes contient les éléments de chaque menu, pour pouvoir les désactiver ou activer facilement

    var elts_menu = [ [$("#titre_modele"),$("#nb_equipes"),$("#nb_roles"),$("#nb_actions"),$("#bouton1")],
    [$("#nom_equipe"),$("#taille_equipe"),$("#discussion"),$("#bouton21"),$("#bouton22")],
    [$("#nom_role"),$("#img_role"),$("#desc_role"),$("#bouton31"),$("#bouton32")],
    [$("#titre_action"),$("#effecteur_action"),$("#cibles_action"),$("#fct_action"),$("#effet_action"),$("#horaire_action"),$("#msg_action"),$("#desc_action"),$("#bouton41"),$("#bouton42")],
    [$("#desc_modele"),$("#fichier_regles"),$("#img_banniere"),$("#img_banniere"),$("#img_fond"),$("#img_logo"),$("#bouton51"),$("#bouton52")],    
    ];


    function ClicFlecheImpair (numeroFleche,e)
     {
            e.preventDefault();
                if (!($("#form1")[0].checkValidity())) {
                    DesactiverPanneau(Math.floor(numeroFleche/2)+1);//désactive le panneau associé au bouton flèche
                    AfficherPanneau(Math.floor(numeroFleche/2)+2); //et affiche le panneau suivant
                    ActiverPanneau(Math.floor(numeroFleche/2)+2); //et le ré-active si besoin

                } else {
                    alert("Veuillez renseigner correctement les champs.");
                }
            }

    function ClicFlechePair (numeroFleche,e)
    {
            e.preventDefault();
                            DesactiverPanneau(Math.floor(numeroFleche/2)+1);
                            ActiverPanneau(Math.floor(numeroFleche/2));     
            }


    function DesactiverPanneau(numero)
    {
        $("#menu" + numero).removeClass("actif"); //pratique
            elts_menu[numero-1].forEach(function(element)
            {
                element.attr('disabled','');
            })    
    }

    function ActiverPanneau(numero)
    //active le menu associé au numéro demandé
    {
        $("#menu" + numero).addClass("actif"); //pratique
        elts_menu[numero-1].forEach(function(element)
            {
                element.removeAttr('disabled','');
            })               
    }

    function AfficherPanneau(numero)
    {
        $("#menu" + numero).removeClass("invisible"); //pratique
    }


</script>


<?php include "./inclus/page_fin.php" ?>

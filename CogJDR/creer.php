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
                    <input type="hidden" name="redirection_echec" value="./#">
                    <input type="hidden" name="redirection_succes" value="./#">

                    <h3 class="text-center"> Créer l'équipe <b class="rouge" id="equipe_actuel"> ?? </b>/<b id="equipe_total"> ?? </b> </h3>
                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="nom_equipe"> <p>Nom de l'équipe</p> </label>
                            <input type="text" name="nom_equipe" class="form-control" id="nom_equipe" placeholder="Un nom fédérateur !" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="taille_equipe"> <p>Taille maximale de l'équipe</p> </label>
                            <input type="number" value="1" min="1" max="99" name="taille_equipe"  class="form-control" id="taille_equipe" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="discussion"> <p>Discussion autorisée</p> </label>
                            <select name="discussion" class="form-control" id="discussion" required>
                                <option> Oui
                                <option> Non
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

                    <h3 class="text-center"> Créer le rôle <b class="rouge" id="role_actuel"> ?? </b>/<b id="role_total"> ?? </b> </h3>
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
                            <textarea name="discussion" class="form-control" id="desc_role" placeholder="Décris donc qui est ce personnage !" required></textarea>                            
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

                    <h3 class="text-center"> Créer l'action <b class="rouge" id="action_actuel"> ?? </b>/<b id="action_total"> ?? </b> </h3>
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
                                <option> Tous
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="cibles_action"> <p>Cibles potentielles de l'action </p> </label>
                            <select name="cibles_action" class="form-control" id="cibles_action" required>
                                <option> Vivants
                                <option> Morts
                                <option> Tous
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="fct_action"> <p>Fonctionnement de l'action </p> </label>
                            <select name="fct_action" class="form-control" id="fct_action" required>
                                <option> Placeholder
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="effet_action"> <p>Effet de l'action </p> </label>
                            <select name="effet_action" class="form-control" id="effet_action" required>
                                <option> Placeholder
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="horaire_action"> <p>Horaire limite </p> </label>
                            <input type="time" value="10:10 PM" name="horaire_action"  class="form-control" id="horaire_action" required>
                        </div>
                    </div>                                                                    

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="msg_action"> <p>Message automatique de l'action (optionnel)</p> </label>
                            <textarea name="msg_action" class="form-control" id="msg_action" placeholder="Pour avertir vos joueurs de ce qu'il s'est passé dans le chat général !" required></textarea>
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10 offset-sm-1">
                            <label for="desc_action"> <p>Description de l'action</p> </label>
                            <textarea name="desc_action"  class="form-control" id="desc_action" placeholder="Explique ce que fait l'action!" required></textarea>
                            
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col">
                            <div class="form-group" id="fleche6">

                                    <button name="action" value="creer" id="bouton41" class="btn btn-primary btn-block">Etape précédente</button>                                </div>
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
                            <textarea name="desc_modele" class="form-control" id="desc_modele" placeholder="Une jolie histoire !" required autofocus></textarea>
                            
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
                                    <button name="action" value="creer" id="bouton52" class="btn btn-primary btn-block">Créer le modèle</button>                            
                            </div>
                        </div>
                    </div>

                    </div>
                </form>
            </div> 
        </div>

    <!-- FIN partie 'Finaliser le modele' -->

    </div>

<script type = "text/javascript"
         src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
         //framework pour l'effet de flash
</script>

<script type = "text/javascript" 
    src = "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js">
</script>


<script>
    //on associe les bonnes fonctions aux boutons suivant et précédent

    $("#fleche1").click(function(e) { ClicFlecheImpair(1,e); });
    $("#fleche3").click(function(e) { ClicFlecheImpair(3,e); });
    $("#fleche5").click(function(e) { ClicFlecheImpair(5,e); });
    $("#fleche7").click(function(e) { ClicFlecheImpair(7,e); });

    $("#fleche2").click(function(e) { ClicFlechePair(2,e); });
    $("#fleche4").click(function(e) { ClicFlechePair(4,e); });
    $("#fleche6").click(function(e) { ClicFlechePair(6,e); }); 
    $("#fleche8").click(function(e) { ClicFlechePair(8,e); });

    //$("#effecteur_action").click(function(){ MajChoixActions(); });     

    //ce tableau de 5 lignes contient les éléments de chaque menu, pour pouvoir les désactiver ou activer facilement

    var elts_menu = [ [$("#titre_modele"),$("#nb_equipes"),$("#nb_roles"),$("#nb_actions"),$("#bouton1")],
    [$("#nom_equipe"),$("#taille_equipe"),$("#discussion"),$("#bouton21"),$("#bouton22")],
    [$("#nom_role"),$("#img_role"),$("#desc_role"),$("#bouton31"),$("#bouton32")],
    [$("#titre_action"),$("#effecteur_action"),$("#cibles_action"),$("#fct_action"),$("#effet_action"),
    $("#horaire_action"),$("#msg_action"),$("#desc_action"),$("#bouton41"),$("#bouton42")],
    [$("#desc_modele"),$("#fichier_regles"),$("#img_banniere"),$("#img_banniere"),$("#img_fond"),$("#img_logo"),$("#bouton51"),$("#bouton52")],    
    ];

    //compteurs du nombre d'équipes, roles et actions à modéliser

    var cpt_equipe=1;
    var nb_equipes=1;

    var cpt_role=1;
    var nb_roles=1;

    var cpt_action=1;
    var nb_actions=1;

    //tableaux permettant de temporairement stockés les valeurs des formulaires de création d'équipe, actions et roles

    var equipes = [];
    var roles = [];
    var actions = [];

    function ClicFlecheImpair (numeroFleche,e) //les fleches impaires sont les boutons d'étape suivante
     {
        e.preventDefault();
            if ((Math.floor(numeroFleche/2)+1)==2 && cpt_equipe<nb_equipes)
            {
                if ($("#form2")[0].checkValidity()) //si les champs sont correctement remplis, on peut passer à l'étape suivante
                {
                    if (equipes[cpt_equipe-1]==undefined) 
                    equipes.push([$("#nom_equipe").val(),$("#taille_equipe").val(),$("#discussion").val()]); //on enregistre dans le tableau les valeurs du form
                    else equipes[cpt_equipe-1] = [$("#nom_equipe").val(),$("#taille_equipe").val(),$("#discussion").val()]; //en faisant attention à ne pas dupliquer des forms
                    $("#form2")[0].reset(); //puis on le réinitialise
                    cpt_equipe++;
                    $("#equipe_actuel").text(cpt_equipe); //enfin, on notifie l'utilisateur qu'il passe à l'étape suivante
                    $("#menu2").effect("highlight", {color:"#00c72b"}, 1300);
                }
                else alert("Veuillez renseigner correctement les champs.");
            }
            else if ((Math.floor(numeroFleche/2)+1)==3 && cpt_role<nb_roles)
            {
                if ($("#form3")[0].checkValidity())
                {
                    if (roles[cpt_role-1]==undefined)
                    roles.push([$("#nom_role").val(),$("#img_role").val(),$("#desc_role").val()]);
                    else roles[cpt_role-1] = [$("#nom_role").val(),$("#img_role").val(),$("#desc_role").val()];
                    $("#form3")[0].reset();
                    cpt_role++;
                    $("#role_actuel").text(cpt_role);                        
                    $("#menu3").effect("highlight", {color:"#00c72b"}, 1300);
                }
                else alert("Veuillez renseigner correctement les champs.");
            }
            else if ((Math.floor(numeroFleche/2)+1)==4 && cpt_action<nb_actions)
            {
                if ($("#form4")[0].checkValidity())
                {   
                    if (actions[cpt_action-1]==undefined)
                    actions.push([$("#titre_action").val(),$("#effecteur_action").val(),$("#cibles_action").val(),$("#fct_action").val(),
                    $("#effet_action").val(),$("#horaire_action").val(),$("#msg_action").val(),$("#desc_action").val()]);
                    else actions[cpt_action-1] = [$("#titre_action").val(),$("#effecteur_action").val(),$("#cibles_action").val(),$("#fct_action").val(),
                    $("#effet_action").val(),$("#horaire_action").val(),$("#msg_action").val(),$("#desc_action").val()];
                    $("#form4")[0].reset();
                    cpt_action++;
                    $("#action_actuel").text(cpt_action);                        
                    $("#menu4").effect("highlight", {color:"#00c72b"}, 1300);
                }
                else alert("Veuillez renseigner correctement les champs.");
            }                
            else if ($("#form"+(Math.floor(numeroFleche/2)+1))[0].checkValidity())  //on vérifie que tous les éléments de la partie du formulaire sont correctement remplis
            {

                DesactiverPanneau(Math.floor(numeroFleche/2)+1);//désactive le panneau associé au bouton flèche
                AfficherPanneau(Math.floor(numeroFleche/2)+2); //et affiche le panneau suivant
                ActiverPanneau(Math.floor(numeroFleche/2)+2); //et le ré-active si besoin
                $("#menu"+(Math.floor(numeroFleche/2)+1)).effect("highlight", {color:"#00c72b"}, 1300); //produit un flash vert sur le form validé                    

                if (numeroFleche ==1) //le premier panneau détermine le nombre d'équipes, roles et actions à créer
                {
                    nb_equipes=$("#nb_equipes").val();
                    nb_roles=$("#nb_roles").val();
                    nb_actions=$("#nb_actions").val();

                    $("#equipe_total").text(nb_equipes);
                    $("#role_total").text(nb_roles);
                    $("#action_total").text(nb_actions);

                    $("#equipe_actuel").text(cpt_equipe);
                    $("#role_actuel").text(cpt_role);
                    $("#action_actuel").text(cpt_action);
                }
                 else if (numeroFleche == 5) //le second panneau, dont la fleche "suivante" est la numéro 3 transmet au 4eme des équipes qui vont apparaitre dans ses menus déroulants
                {
                    MajChoixActions();
                } 
 
            } 
            else 
            {
                alert("Veuillez renseigner correctement les champs.");
            }
            
     }

    function ClicFlechePair (numeroFleche,e) //les fleches paires sont les boutons d'étape précédente
    {
        e.preventDefault();
        if ((Math.floor(numeroFleche/2)+1)==2 && cpt_equipe>1)
        {                
            cpt_equipe--;
            for (i=0; i<=2;i++) //on remet chaque champ aux valeurs précédémment validées par l'utilisateur
            {
                elts_menu[1][i].val(equipes[cpt_equipe-1][i]);
            }
            $("#equipe_actuel").text(cpt_equipe); //enfin, on notifie l'utilisateur qu'il passe à l'étape précédente par un flash violet
            $("#menu2").effect("highlight", {color:"#6b00a8"}, 1300);
        }
        else if ((Math.floor(numeroFleche/2)+1)==3 && cpt_role>1)
        {
            cpt_role--;
            for (i=0; i<=2;i++)
            {
                elts_menu[2][i].val(roles[cpt_role-1][i]);
            }
            $("#role_actuel").text(cpt_role);
            $("#menu3").effect("highlight", {color:"#6b00a8"}, 1300);
        }
        else if ((Math.floor(numeroFleche/2)+1)==4 && cpt_action>1)
        {
            cpt_action--;
            for (i=0; i<=7;i++) //on remet chaque champ aux valeurs précédémment validées par l'utilisateur
            {
                elts_menu[3][i].val(actions[cpt_action-1][i]);
            }
            $("#action_actuel").text(cpt_action); //enfin, on notifie l'utilisateur qu'il passe à l'étape précédente par un flash violet
            $("#menu4").effect("highlight", {color:"#6b00a8"}, 1300);
        }
        else {

        DesactiverPanneau(Math.floor(numeroFleche/2)+1);
        ActiverPanneau(Math.floor(numeroFleche/2));
        }

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

    var options;
    
    function MajChoixActions() //met à jour les options d'effecteurs et de cibles dans la création des actions pour inclure les nouvelles équipes et roles
    {

        var newOptions = {
        'vivants' : 'Vivants',
        'morts' : 'Morts',
        'tous' : 'Tous',
        };

        for (i=0; i<equipes.length;i++)
        {
            newprop = equipes[i][0];
            newOptions[newprop] =(equipes[i][0]);
        }
        
        newprop = $("#nom_equipe").val();
        newOptions[newprop] = newprop;

        for (i=0; i<roles.length;i++)
        {
            newprop = roles[i][0];
            newOptions[newprop] =(roles[i][0]);
        }
        
        newprop = $("#nom_role").val();
        newOptions[newprop] = newprop;

        var select1 = $('#effecteur_action');
        var select2 = $("#cibles_action")
        
        if(select1.prop) {
        options = select1.prop('options');
        }
        else {
            options = select1.attr('options');
        }
        $('option', select1).remove();

        if(select2.prop) {
        options2 = select2.prop('options');
        }
        else {
            options2 = select2.attr('options');
        }
        $('option', select2).remove();

        $.each(newOptions, function(val, text) {
            options[options.length] = new Option(text, val);
            options2[options2.length] = new Option(text, val);
        });

    }

</script>


<?php include "./inclus/page_fin.php" ?>

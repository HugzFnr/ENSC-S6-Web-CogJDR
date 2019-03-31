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
    //on associe les bonnes fonctions aux boutons suivant et précédent

    $("#fleche1").click(function(e) { ClicFlecheImpair(1,e); });
    $("#fleche3").click(function(e) { ClicFlecheImpair(3,e); });

    $("#fleche2").click(function(e) { ClicFlechePair(2,e); });
    $("#fleche4").click(function(e) { ClicFlechePair(4,e); });

    //$("#effecteur_action").click(function(){ MajChoixActions(); });     

    //ce tableau de 5 lignes contient les éléments de chaque menu, pour pouvoir les désactiver ou activer facilement

    var elts_menu = [ [$("#boutonCreer"),$("#choix_modele"),$("#bouton1")],
    [$("#nom_jeu"),$("#nb_joueurs_max"),$("#nb_joueurs_min"),$("#date_ouverture"),$("#date_lancement"),$("#occurence"),$("#bouton21"),$("#bouton22")],
    [$("#bouton31"),$("#bouton32")],
    ];

    function ClicFlecheImpair (numeroFleche,e) //les fleches impaires sont les boutons d'étape suivante
     {
        e.preventDefault();
        console.log(numeroFleche);
               
            if ($("#form"+(Math.floor(numeroFleche/2)+1))[0].checkValidity())  //on vérifie que tous les éléments de la partie du formulaire sont correctement remplis
            {

                DesactiverPanneau(Math.floor(numeroFleche/2)+1);//désactive le panneau associé au bouton flèche
                AfficherPanneau(Math.floor(numeroFleche/2)+2); //et affiche le panneau suivant
                ActiverPanneau(Math.floor(numeroFleche/2)+2); //et le ré-active si besoin
                $("#menu"+(Math.floor(numeroFleche/2)+1)).effect("highlight", {color:"#00c72b"}, 1300); //produit un flash vert sur le form validé                     
            } 
            else 
            {
                alert("Veuillez renseigner correctement les champs.");
            }
            
     }

    function ClicFlechePair (numeroFleche,e) //les fleches paires sont les boutons d'étape précédente
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

    var options;

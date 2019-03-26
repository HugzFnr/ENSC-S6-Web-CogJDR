<?php include "./inclus/page_debut.php" ?>

    <h1 class="text-center"> Créer un modèle de JDR </h1>
    <!-- partie 'Paramètres généraux' -->
        <div class="row">
            <div class="col">
                <div class="container" id="menu1">
                    <form id="form1" class="form-signin form-horizontal" role="form" action="./creer.php" method="post" enctype="multipart/form-data">
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
                                <input type="number" name="nb_equipes" class="form-control" id="nb_equipes" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Nombre de rôles différents</p>
                                <input type="number" name="nb_roles" class="form-control" id="nb_roles" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10 offset-sm-1">
                                <p>Nombre d'actions différentes</p>
                                <input type="number" name="nb_actions" class="form-control" id="nb_actions" required>
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
                                <input type="number" name="taille_equipe"  class="form-control" id="taille_equipe" required>
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
        </div>
    </div>
<!-- FIN partie 'Créer une équipe' -->


<script>

    //console.log(document.getElementById("titre_modele").value); ça servira ça

    for(iter=1;iter<=2;iter++) //à la fin yen aura 8 et 5 types de panneaux distincts
    {
        if (iter%2==1) //les flèches impaires sont des flèches d'avancement au panneau suivant
        {
            $("#fleche"+iter).click(function(e) {
            e.preventDefault();
                stock = iter;
                if ($("#form1")[0].checkValidity()) {
                    DesactiverPanneau(Math.floor(stock/2)+1);//désactive le panneau associé au bouton flèche
                    AfficherMasquerPanneau(Math.floor(stock/2)+2); //et affiche le panneau suivant
                    console.log(iter); //ah bah oui ça prend iter au moment du click eh, donc =3

                    //https://stackoverflow.com/questions/5338716/get-multiple-elements-by-id faut plutot récupérer toutes les flèches en leur donnant une classe puis utiliser leur chiffre comme iter

                } else {
                    alert("Veuillez renseigner les champs.");
                }
            });      
        }

        else //les flèches paires sont des flèches de retour au panneau précédent
        {
            $("#fleche"+iter).click(function(e) {
            e.preventDefault();
                        if ($("#form1")[0].checkValidity()) {

                            DesactiverPanneau(Math.floor(iter/2)+1);
                            ActiverPanneau(Math.floor(iter/2));     

                        } else {
                            alert("Veuillez renseigner les champs.");
                        }
            });              
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

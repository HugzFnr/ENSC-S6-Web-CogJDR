<?php include_once "page_debut.php" ?>

<form action="./action" method="post">
    <?php
        $donne_jdr = $_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']];

        $autorise = sql_select(
                array(
                    'Joueur',
                    'Equipe', 'ModeleEquipe', 'EstDans', 
                    'Action_', 'ModeleAction', 'Autorise'
                ),
                "*",
                array(
                    'Joueur::id_joueur' => 'EstDans::id_joueur',
                    'Equipe::id_equipe' => 'EstDans::id_equipe',
                    'Equipe::id_modele_equipe' => 'ModeleEquipe::id_modele_equipe',
                    'ModeleEquipe::id_modele_equipe' => 'Autorise::id_modele_equipe_autorise',
                    'Autorise::id_modele_action' => 'ModeleAction::id_modele_action',
                    'ModeleAction::id_modele_action' => 'Action_::id_modele_action',
                    'Action_::id_action' => $_REQUEST['id'],
                    'Joueur::id_joueur' => $donne_jdr['id_dans']
                )
            )->fetch();
        if ($autorise) {
            $cibles = sql_select(
                    array(
                        'Utilisateur', 'Joueur',
                        'Equipe', 'ModeleEquipe', 'EstDans', 
                        'Action_', 'ModeleAction', 'Cible'
                    ),
                    array('Joueur.id_joueur', 'Joueur.pseudo', 'Utilisateur.email'),
                    array(
                        'Joueur::id_utilisateur' => 'Utilisateur::id',
                        'EstDans::id_joueur' => 'Joueur::id_joueur',
                        'Equipe::id_equipe' => 'EstDans::id_equipe',
                        'Equipe::id_modele_equipe' => 'ModeleEquipe::id_modele_equipe',
                        'ModeleEquipe::id_modele_equipe' => 'Cible::id_modele_equipe_cible',
                        'Cible::id_modele_action' => 'ModeleAction::id_modele_action',
                        'ModeleAction::id_modele_action' => 'Action_::id_modele_action',
                        'Action_::id_action' => $_REQUEST['id']
                    ),
                    array('Joueur::pseudo' => 'ASC'),
                    true
                );
            
            $compteur = 0;
            while ($joueur = $cibles->fetch()) { ?>
                <input type="radio" name="id_joueur_choix" id="choix<?=$compteur++?>" value="<?=$joueur['id_joueur']?>"><?=$joueur['pseudo']?> (<?=$joueur['email']?>)<?php
            }
        }
    ?>
</form>

<?php include_once "page_fin.php" ?>

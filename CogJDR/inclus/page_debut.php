<?php require_once "./inclus/session.php" ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>CogJDR<?=isset($sous_titre) ? " - $sous_titre" : " !"?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" media="screen" href="./css/discussion.css">

        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    </head>

    <body>
        <?php
            if (isset($_SESSION['id'])) {
                $donnees_jdr = empty($_SESSION['liste_donnees_jdr']) ? "" : $_SESSION['liste_donnees_jdr'][$_SESSION['indice_jdr_suivi']] ?>
                Utilisateur <?=$_SESSION['email']?> (no<?=$_SESSION['id']?>) <?php

                if (!empty($donnees_jdr)) { ?>
                    connect&eacute; en tant que <?=$donnees_jdr['nom_joueur'] ?>.<?php 
                    if (-1 < $donnees_jdr['indice_equipe_discussion_suivi']) { ?>
                        <br>Affichage de la discussion de l'&eacute;quipe <?=$donnees_jdr['liste_equipe'][$donnees_jdr['indice_equipe_discussion_suivi']]['titre_equipe']?>.<?php
                    }
                }
            }
        ?>

        <h1>Yo!</h1>
        <hr>
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
            if (isset($_SESSION['id'])) { ?>
                Utilisateur <?=$_SESSION['email']?> (no<?=$_SESSION['id']?>) connect&eacute; en tant que <?=$_SESSION['id_joueur']?>.
                <br>Affichage de la discussion de l'&eacute;quipe <?=$_SESSION['id_equipe_discussion']?>.
            <?php }
        ?>

        <h1>Yo!</h1>
        <hr>
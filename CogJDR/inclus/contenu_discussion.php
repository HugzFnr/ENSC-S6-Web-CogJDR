<?php
    require_once "connection.php";

    $r = sql_select(
        'Message_',
        array('id_joueur', 'horaire_publi', 'text'),
        array('id_equipe' => $_SESSION['equipes'], 'horaire_publi'),
        'ORDER BY horaire_publi'
    );

    while($message = $r->fetch()) { ?>
        <li>
            <ul class="discussion_message">
                <p class="discussion_debut">[<?=$message['horaire_publi']?>]<?=sql_select('Joueur', 'pseudo', array('id_joueur' => $message['id_joueur']))?></p>
                <p class="discussion_text"><?=$message['text']?></p>
            </ul>
        </li>
    <?php }
?>

delete from Cible where 1;
delete from Autorise where 1;
delete from ModeleAction where 1;
delete from Message_ where 1;
delete from EstDans where 1;
delete from Equipe where 1;
delete from ModeleEquipe where id_modele_equipe != 0;
delete from Joueur where 1;
delete from MJ where 1;
delete from JDR where 1;
delete from ModeleJDR where 1;
delete from Utilisateur where 1;


insert into Utilisateur (`id`, `mdp`, `email`, `img`) values
    (null, '$2y$10$hXBu1vDgRNw7cliHI2pZgOpNI5q4LlAshFU70Dg9KanzccApfiGy6', 'exemple@email.voila', 'exemple_40email.voila.png'),
    (null, '$2y$10$lyClN0AX5HnrZAPFMyga2uF6CoIoKv2dq2Hnju3Q29n0PvKLg/5YW', 'mj@cog.jdr', 'mj_40cog.jdr.png'),
    (null, '$2y$10$Bvs9nWFl89CtEFH18Iy9gOZ.QmpizdrYWFUtei5LvZWtmIfZVRwjy', 'coucou@coucou.coucou', 'coucou_40coucou.coucou.gif');

insert into ModeleJDR (`id_modele_jdr`, `id_createur`, `titre`, `desc_jdr`, `fichier_regles`, `img_banniere`, `img_fond`, `img_logo`) values
    (null, 2, 'Jeux Rigolo', 'Ceci est la description du Jeux Rigolo :). Du coup je remplis cet espace avec un texte long et plein de fautes de fran&ccedil;ais en tout genre. Dailleurs, ce jeu, tout aussi rigolo qu&apos;il soit, ne se joue qu&apos;à 12 joueurs max... donc bon, voil&agrave;.', 'Jeux-Rigolo.pdf', 'Jeux-Rigolo.png', 'Jeux-Rigolo.png', 'Jeux-Rigolo.png'),
    (null, 2, 'Space', 'Ceci est une description assez courte. Un super JDR dans l&apos;espace, WOAW &num;paieTaDescription', 'Space.pdf', 'Space.jpg', 'Space.jpg', 'Space.png');

insert into JDR (`id_jdr`, `id_modele_jdr`, `code_invite`, `nb_max_joueurs`, `nb_min_joueurs`, `jours_ouvrables`, `etat_partie`) values
    (null, 1, "12da0fde", 12, 0, '7 jours', 'lancement');

insert into MJ (`id_mj`, `id_utilisateur`, `id_jdr_dirige`, `pseudo_mj`) values
    (null, 2, 1, "xXMeuJeuXx");

insert into Joueur (`id_joueur`, `id_utilisateur`, `id_jdr_participe`, `pseudo`) values
    (null, 1, 1, 'Joueur'),
    (null, 3, 1, 'Sel');

insert into ModeleEquipe (`id_modele_equipe`, `id_modele_jdr`, `titre_equipe`, `taille_equipe_max`, `discussion_autorisee`) values
    (null, 1, 'Vivants', -1, 1),
    (null, 1, 'Sac', 11, 1),
    (null, 1, 'Morts', -1, 1),
    (null, 1, 'Tous', -1, 0);

insert into Equipe (`id_equipe`, `id_modele_equipe`, `id_jdr`) values
    (null, 1, 1),
    (null, 2, 1),
    (null, 3, 1),
    (null, 4, 1);

insert into EstDans (`id_joueur`, `id_equipe`) values
    (1, 1),
    (2, 1),
    (2, 2),
    (1, 4),
    (2, 4);

insert into Message_ (`id_message`, `id_joueur`, `id_equipe`, `horaire_publi`, `texte`) values
    (null, 1, 1, NOW(), "Hey, salut !"),
    (null, 1, 1, NOW(), "Comment ca va ?"),
    (null, 1, 1, NOW(), "Héo.."),
    (null, 1, 1, NOW(), "Ya qqun ? Tu répond ?"),
    (null, 2, 2, NOW(), "c'est plustot calme ici..."),
    (null, 2, 1, NOW(), "Tutecalm."),
    (null, null, 2, NOW(), "oui lol"),
    (null, 2, 2, NOW(), "ha slt"),
    (null, null, 1, NOW(), "TAISEZ VOUS!");

insert into ModeleAction (`id_modele_action`, `id_modele_jdr`, `titre_action`, `desc_action`, `message_action`, `horaire_activ`, `action_effet_id_modele_equipe_depart`, `action_effet_id_modele_equipe_arrive`, `action_fct`) values
    (null, 1, "Vote des villageois", "Les villageois votent pour la personne qu'ils veulent br&ucirc;ler. Qui pensez-vous &ecirc;tre un loup ?", "$cible.pseudo; ($cible.email;) a &eacute;t&eacute; choisis &agrave; la majorit&eacute;e ($vote.nb_majoritaire; sur $vote.nb_total;) pour &ecirc;tre br&ucirc;l&eacute;(e) ce soir...", "23:24:25", 1, 3, "voteMajoritaireTous"),
    (null, 1, "Modele d'action test no 2", "Titre de l'action", "Description de l'action", "10:11:12", null, 2, "voteMajoritaire");

insert into Cible (`id_modele_equipe_cible`, `id_modele_action`) values
    (1, 1),
    (1, 2);

insert into Autorise (`id_modele_equipe_autorise`, `id_modele_action`) values
    (1, 1),
    (2, 2);

insert into Role_ (`id_role`, `id_modele_jdr`, `img_role`, `nom_role`, `desc_role`) values
    (null, 1, "bla", "d-Role", "Fait un blague qui transforme un joueur en sac.");

insert into Permet (`id_role`, `id_modele_action`) values
    (1, 2);

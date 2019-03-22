delete from Message_ where 1;
delete from EstDans where 1;
delete from Equipe where 1;
delete from ModeleEquipe where 1;
delete from Joueur where 1;
delete from MJ where 1;
delete from JDR where 1;
delete from ModeleJDR where 1;
delete from Utilisateur where 1;


insert into Utilisateur (`id`, `mdp`, `email`, `img`) values
    (0, 'mdp', 'exemple@email.voila', 'images/compte/img.png'),
    (1, '1234', 'cgrenier003@ensc.fr', 'images/compte/sel_40cog.jdr.gif'),
    (2, 'poi', 'mj@cog.jdr', 'images/compte/coucou.jpg');

insert into ModeleJDR (`id_modele_jdr`, `id_createur`, `titre`, `desc_jdr`, `fichier_regles`, `img_banniere`, `img_fond`, `img_logo`, `nb_equipes_max`) values
    (0, 0, 'Jeux Rigolo', 'Ceci est la description du Jeux Rigolo :). Du coup je rempli cet espcace avec un texte long et plein de fautes de fran&ccedil;ais en tout genre. Btw, ce jeux, tout aussi rigolo qu&apos;il soit, ne se jout qu&apos;à 12 joueus max... donc bon, voil&agrave;.', 'fichier/regles.pdf', 'images/jdr/banniereRigolo.png', 'images/jdr/fondRigolo.png', 'images/jdr/logoRigolo.png', 12);

insert into JDR (`id_jdr`, `id_modele_jdr`, `code_invite`, `nb_max_joueurs`, `nb_min_joueurs`, `jours_ouvrables`) values
    (0, 0, "12da0fde", 12, 0, '7 jours');

insert into MJ (`id_mj`, `id_utilisateur`, `id_jdr_dirige`, `pseudo_mj`) values
    (0, 2, 0, "xDA_MASTEURx");

insert into Joueur (`id_joueur`, `id_utilisateur`, `id_jdr_participe`, `pseudo`) values
    (0, 0, 0, 'Jsp'),
    (1, 1, 0, 'Sel');

insert into ModeleEquipe (`id_modele_equipe`, `id_modele_jdr`, `titre_equipe`, `taille_equipe_max`, `discussion_autorisee`) values
    (0, 0, 'L&apos;&eacute;quipe des Vivants', 10, 1),
    (1, 0, 'L&apos;&eacute;quipe Sac', 11, 1);

insert into Equipe (`id_equipe`, `id_modele_equipe`) values
    (0, 0),
    (1, 1);

insert into EstDans (`id_joueur`, `id_equipe`) values
    (0, 0),
    (1, 0),
    (1, 1);

insert into Message_ (`id_message`, `id_joueur`, `id_equipe`, `horaire_publi`, `texte`) values
    (0, 0, 0, NOW(), "Hey, salut !"),
    (1, 0, 0, NOW(), "Comment ca va ?"),
    (2, 0, 0, NOW(), "Héo.."),
    (3, 0, 0, NOW(), "Ya qqun ? Tu répond ?"),
    (4, 1, 1, NOW(), "c'est plustot calme ici..."),
    (5, 1, 0, NOW(), "Tutecalm."),
    (6, null, 1, NOW(), "oui lol"),
    (7, 1, 1, NOW(), "ha slt"),
    (8, null, 0, NOW(), "TAISEZ VOUS!");

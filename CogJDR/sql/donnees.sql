delete from Message_ where 1;
delete from EstDans where 1;
delete from Equipe where 1;
delete from ModeleEquipe where 1;
delete from Joueur where 1;
delete from JDR where 1;
delete from ModeleJDR where 1;
delete from Utilisateur where 1;


insert into Utilisateur (`id`, `mdp`, `email`, `img`) values
    (0, 'mdp', 'exemple@email.voila', 'images/img.png'),
    (1, '1234', 'cgrenier003@ensc.fr', 'images/s32d3s21df.png');

insert into ModeleJDR (`id_modele_jdr`, `id_createur`, `titre`, `desc_jdr`, `fichier_regles`, `img_banniere`, `img_fond`, `img_logo`, `nb_equipes_max`) values
    (0, 0, 'Jue Rigolo', 'Ceci est la description du Jeu Rigolo :)', 'fichier/regles.pdf', 'images/banniereRigolo.png', 'images/fondRigolo.png', 'images/logoRigolo.png', 12);

insert into JDR (`id_jdr`, `id_modele_jdr`, `code_invite`, `nb_max_joueurs`, `nb_min_joueurs`, `jours_ouvrables`) values
    (0, 0, "12da0fde", 42, 0, '7 jours');

insert into Joueur (`id_joueur`, `id_utilisateur`, `id_jrd_participe`, `pseudo`) values
    (0, 0, 0, 'Jps'),
    (1, 1, 0, 'Sel');

insert into ModeleEquipe (`id_modele_equipe`, `id_modele_jdr`, `titre_equipe`, `taille_equipe_max`, `discussion_autorisee`) values
    (0, 0, 'Sac', 42, 1);

insert into Equipe (`id_equipe`, `id_modele_equipe`) values
    (0, 0);

insert into EstDans (`id_joueur`, `id_equipe`) values
    (0, 0),
    (1, 0);

insert into Message_ (`id_message`, `id_joueur`, `id_equipe`, `horaire_publi`, `texte`) values
    (0, 0, 0, NOW(), "Hey, salut !"),
    (1, 0, 0, NOW(), "Comment ca va ?"),
    (2, 0, 0, NOW(), "Héo.."),
    (3, 0, 0, NOW(), "Ya qqun ? Tu répond ?"),
    (5, 1, 0, NOW(), "Tutecalm.");

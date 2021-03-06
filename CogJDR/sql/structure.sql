drop table if exists Message_;
drop table if exists EstDans;
drop table if exists Equipe;
drop table if exists Action_;
drop table if exists EstUn;
drop table if exists Joueur;
drop table if exists MJ;
drop table if exists JDR;
drop table if exists Permet;
drop table if exists Autorise;
drop table if exists Cible;
drop table if exists ModeleAction;
drop table if exists Role_;
drop table if exists ModeleEquipe;
drop table if exists ModeleJDR;
drop table if exists Utilisateur;


create table Utilisateur (
    id integer not null primary key auto_increment,
    mdp varchar(255) not null,
    email varchar(32) not null,
    img varchar(128) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table ModeleJDR (
    id_modele_jdr integer not null primary key auto_increment, 
    id_createur integer,
    titre varchar(32) not null,
    desc_jdr varchar(1024) not null,
    fichier_regles varchar(128) not null,
    img_banniere varchar(128) not null,
    img_fond varchar(128) not null,
    img_logo varchar(128) not null,

    foreign key (id_createur) references Utilisateur (id)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table ModeleEquipe (
    id_modele_equipe integer not null primary key auto_increment,
    id_modele_jdr integer,
    titre_equipe varchar(32) not null,
    taille_equipe_max integer not null,
    discussion_autorisee boolean not null,

    foreign key (id_modele_jdr) references ModeleJDR (id_modele_jdr)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table Role_ (
    id_role integer not null primary key auto_increment,
    id_modele_jdr integer,
    img_role varchar(128) not null,
    nom_role varchar(128) not null,
    desc_role varchar(512) not null,

    foreign key (id_modele_jdr) references ModeleJDR (id_modele_jdr)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table ModeleAction (
    id_modele_action integer not null primary key auto_increment,
    id_modele_jdr integer,
    titre_action varchar(32) not null,
    desc_action varchar(512) not null,
    message_action varchar(1024) not null,
    horaire_activ time not null,
    action_effet_id_modele_equipe_depart integer,
    action_effet_id_modele_equipe_arrive integer,
    action_fct enum('voteMajoritaireTous', 'voteMinoritaireTous', 'voteMajoritairePremier', 'voteMinoritairePremier', 'voteMajoritaireNul', 'voteMinoritaireNul', 'pouvoir') not null,

    foreign key (action_effet_id_modele_equipe_depart) references ModeleEquipe (id_modele_equipe),
    foreign key (action_effet_id_modele_equipe_arrive) references ModeleEquipe (id_modele_equipe),
    foreign key (id_modele_jdr) references ModeleJDR (id_modele_jdr)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table Cible (
    id_modele_equipe_cible integer,
    id_modele_action integer,

    foreign key (id_modele_equipe_cible) references ModeleEquipe (id_modele_equipe),
    foreign key (id_modele_action) references ModeleAction (id_modele_action)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table Autorise (
    id_modele_equipe_autorise integer,
    id_modele_action integer,

    foreign key (id_modele_equipe_autorise) references ModeleEquipe (id_modele_equipe),
    foreign key (id_modele_action) references ModeleAction (id_modele_action)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table Permet (
    id_role integer,
    id_modele_action integer,

    foreign key (id_role) references Role_ (id_role),
    foreign key (id_modele_action) references ModeleAction (id_modele_action)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table JDR (
    id_jdr integer not null primary key auto_increment,
    id_modele_jdr integer,
    code_invite varchar(8),
    nb_max_joueurs integer not null,
    nb_min_joueurs integer not null,
    jours_ouvrables enum('5 jours', '6 jours', '7 jours') not null,
    etat_partie enum('lancement', 'deroulement', 'fin') not null,

    foreign key (id_modele_jdr) references ModeleJDR (id_modele_jdr)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table MJ (
    id_mj integer not null primary key auto_increment,
    id_utilisateur integer,
    id_jdr_dirige integer,
    pseudo_mj varchar(32) not null,

    foreign key (id_utilisateur) references Utilisateur (id),
    foreign key (id_jdr_dirige) references JDR (id_jdr)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table Joueur (
    id_joueur integer not null primary key auto_increment,
    id_utilisateur integer,
    id_jdr_participe integer,
    pseudo varchar(32) not null,

    foreign key (id_utilisateur) references Utilisateur (id),
    foreign key (id_jdr_participe) references JDR (id_jdr)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table EstUn (
    id_joueur integer,
    id_role integer,

    foreign key (id_joueur) references Joueur (id_joueur),
    foreign key (id_role) references Role_ (id_role),

    primary key (id_joueur, id_role)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table Action_ (
    id_action integer not null primary key auto_increment,
    id_modele_action integer,
    id_jdr integer,
    id_joueur_cible integer,
    id_joueur_effecteur integer,
    horaire_envoi timestamp not null default CURRENT_TIMESTAMP,

    foreign key (id_modele_action) references ModeleAction (id_modele_action),
    foreign key (id_jdr) references JDR (id_jdr),
    foreign key (id_joueur_cible) references Joueur (id_joueur),
    foreign key (id_joueur_effecteur) references Joueur (id_joueur)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table Equipe (
    id_equipe integer not null primary key auto_increment,
    id_modele_equipe integer,
    id_jdr integer,

    foreign key (id_modele_equipe) references ModeleEquipe (id_modele_equipe),
    foreign key (id_jdr) references JDR (id_jdr)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table EstDans (
    id_joueur integer,
    id_equipe integer,

    foreign key (id_joueur) references Joueur (id_joueur),
    foreign key (id_equipe) references Equipe (id_equipe),

    primary key (id_joueur, id_equipe)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table Message_ (
    id_message integer not null primary key auto_increment,
    id_joueur integer,
    id_equipe integer,
    horaire_publi timestamp not null default CURRENT_TIMESTAMP,
    texte varchar(1024) not null,

    foreign key (id_joueur) references Joueur (id_joueur),
    foreign key (id_equipe) references Equipe (id_equipe)
) engine=innodb character set utf8 collate utf8_unicode_ci;


insert into ModeleEquipe (`id_modele_equipe`, `id_modele_jdr`, `titre_equipe`, `taille_equipe_max`, `discussion_autorisee`) values (0, null, 'MP', 2, 1);

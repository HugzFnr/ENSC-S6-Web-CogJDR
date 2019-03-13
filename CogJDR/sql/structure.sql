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
    mdp varchar(32) not null,
    email varchar(32) not null,
    img varchar(32) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table ModeleJDR (
    id_modele_jdr integer not null primary key auto_increment, 
    id_createur integer,
    titre varchar(32) not null,
    desc_jdr varchar(256) not null,
    fichier_regles varchar(32) not null,
    img_banniere varchar(32) not null,
    img_fond varchar(32) not null,
    img_logo varchar(32) not null,
    nb_equipes_max integer not null,

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
    img_role varchar(32) not null,
    nom_role varchar(32) not null,
    desc_role varchar(256) not null,

    foreign key (id_modele_jdr) references ModeleJDR (id_modele_jdr)
) engine=innodb character set utf8 collate utf8_unicode_ci;


create table ModeleAction (
    id_modele_action integer not null primary key auto_increment,
    id_modele_jdr integer,
    desc_action varchar(256) not null,
    message_action varchar(256) not null,
    action_effet enum('ressusciter', 'tuer') not null,
    action_fct enum('voteMajoritaire', 'voteMinoritaire', 'pouvoir') not null,

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

    foreign key (id_modele_jdr) references ModeleJDR (id_modele_jdr)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table MJ (
    id_mj integer not null primary key auto_increment,
    id_utilisateur integer,
    id_jrd_dirige integer,
    pseudo_mj varchar(32) not null,

    foreign key (id_utilisateur) references Utilisateur (id),
    foreign key (id_jrd_dirige) references JDR (id_jdr)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table Joueur (
    id_joueur integer not null primary key auto_increment,
    id_utilisateur integer,
    id_jrd_participe integer,
    pseudo varchar(32) not null,

    foreign key (id_utilisateur) references Utilisateur (id),
    foreign key (id_jrd_participe) references JDR (id_jdr)
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
    horaire_activ date not null,

    foreign key (id_modele_action) references ModeleAction (id_modele_action),
    foreign key (id_jdr) references JDR (id_jdr),
    foreign key (id_joueur_cible) references Joueur (id_joueur)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table Equipe (
    id_equipe integer not null primary key auto_increment,
    id_modele_equipe integer,

    foreign key (id_modele_equipe) references ModeleEquipe (id_modele_equipe)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table EstDans  (
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
    horaire_publi date not null,
    texte varchar(256) not null,

    foreign key (id_joueur) references Joueur (id_joueur),
    foreign key (id_equipe) references Equipe (id_equipe)
) engine=innodb character set utf8 collate utf8_unicode_ci;

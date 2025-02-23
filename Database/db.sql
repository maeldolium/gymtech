drop database if exists GYMTECH;

create database GYMTECH;
use GYMTECH;

drop table if exists COURS;

drop table if exists EQUIPEMENTS;

drop table if exists RESERVER;

drop table if exists SALLES;

drop table if exists TYPE_SALLE;

drop table if exists TYPE_USER;

drop table if exists USERS;

/*==============================================================*/
/* Table : COURS                                                */
/*==============================================================*/
create table COURS
(
   ID_COURS             int not null,
   TYPE_COURS           varchar(25),
   primary key (ID_COURS)
);

/*==============================================================*/
/* Table : EQUIPEMENTS                                          */
/*==============================================================*/
create table EQUIPEMENTS
(
   ID_EQUIPEMENT        int not null,
   TYPE_EQUIPEMENT      varchar(25),
   primary key (ID_EQUIPEMENT)
);

/*==============================================================*/
/* Table : RESERVER                                             */
/*==============================================================*/
create table RESERVER
(
   ID_USER              int not null,
   ID_EQUIPEMENT        int not null,
   ID_COURS             int not null,
   DATE                 date,
   HEURE_DEBUT          time,
   HEURE_FIN            time,
   primary key (ID_USER, ID_EQUIPEMENT, ID_COURS)
);

/*==============================================================*/
/* Table : SALLES                                               */
/*==============================================================*/
create table SALLES
(
   ID_SALLE             int not null,
   ID_TYPE_SALLE        char(1) not null,
   NOM_SALLE            varchar(25),
   primary key (ID_SALLE)
);

/*==============================================================*/
/* Table : TYPE_SALLE                                           */
/*==============================================================*/
create table TYPE_SALLE
(
   ID_TYPE_SALLE        char(1) not null,
   LIBELLE_TYPE_SALLE   varchar(25),
   primary key (ID_TYPE_SALLE)
);

/*==============================================================*/
/* Table : TYPE_USER                                            */
/*==============================================================*/
create table TYPE_USER
(
   ID_TYPE_USER         char(1) not null,
   LIBELLE_TYPE_USER    varchar(25),
   primary key (ID_TYPE_USER)
);

/*==============================================================*/
/* Table : USERS                                                */
/*==============================================================*/
create table USERS
(
   ID_USER              int not null,
   ID_SALLE             int not null,
   ID_TYPE_USER         char(1) not null,
   NOM_USER             varchar(25),
   PRENOM_USER          varchar(25),
   GENRE_USER           char(1),
   primary key (ID_USER)
);

alter table RESERVER add constraint FK_RESERVER foreign key (ID_USER)
      references USERS (ID_USER) on delete restrict on update restrict;

alter table RESERVER add constraint FK_RESERVER2 foreign key (ID_EQUIPEMENT)
      references EQUIPEMENTS (ID_EQUIPEMENT) on delete restrict on update restrict;

alter table RESERVER add constraint FK_RESERVER3 foreign key (ID_COURS)
      references COURS (ID_COURS) on delete restrict on update restrict;

alter table SALLES add constraint FK_ASSOCIATION_4 foreign key (ID_TYPE_SALLE)
      references TYPE_SALLE (ID_TYPE_SALLE) on delete restrict on update restrict;

alter table USERS add constraint FK_ASSOCIATION_2 foreign key (ID_TYPE_USER)
      references TYPE_USER (ID_TYPE_USER) on delete restrict on update restrict;

alter table USERS add constraint FK_ASSOCIATION_3 foreign key (ID_SALLE)
      references SALLES (ID_SALLE) on delete restrict on update restrict;

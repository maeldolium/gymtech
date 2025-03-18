drop database if exists GYMTECH;

create database GYMTECH;
use GYMTECH;

drop table if exists COURS;

drop table if exists EQUIPEMENTS;

drop table if exists RESERVAVTION;

drop table if exists SALLE;

drop table if exists SEANCES;

drop table if exists TYPE_SALLE;

drop table if exists TYPE_USER;

drop table if exists USERS;

/*==============================================================*/
/* Table : COURS                                                */
/*==============================================================*/
create table COURS
(
   ID_COURS             char(1) not null,
   TYPE_COURS           varchar(50) not null,
   NOMBRE_PLACES        int not null,
   primary key (ID_COURS)
);

/*==============================================================*/
/* Table : EQUIPEMENTS                                          */
/*==============================================================*/
create table EQUIPEMENTS
(
   ID_EQUIPEMENT        int not null,
   TYPE_EQUIPEMENT      varchar(50) not null,
   NOM_EQUIPEMENT       varchar(50) not null,
   primary key (ID_EQUIPEMENT)
);

/*==============================================================*/
/* Table : RESERVAVTION                                         */
/*==============================================================*/
create table RESERVAVTION
(
   ID_RESERVATION       int not null,
   ID_COURS             char(1),
   ID_EQUIPEMENT        int,
   ID_USER              int not null,
   DATE                 date not null,
   HEURE_DEBUT          time not null,
   HEURE_FIN            time not null,
   primary key (ID_RESERVATION)
);

/*==============================================================*/
/* Table : SALLE                                                */
/*==============================================================*/
create table SALLE
(
   ID_SALLE             int not null,
   ID_TYPE_SALLE        char(1) not null,
   ID_USER              int not null,
   NOM_SALLE            varchar(50),
   primary key (ID_SALLE)
);

/*==============================================================*/
/* Table : SEANCES                                              */
/*==============================================================*/
create table SEANCES
(
   ID_SEANCE            int not null,
   ID_USER              int not null,
   ID_EQUIPEMENT        int,
   ID_COURS             char(1),
   TYPE_SEANCE          varchar(20) not null,
   DATE_SEANCE          date not null,
   DUREE_SEANCE         int not null,
   ENERGIE_PRODUITE     float not null,
   primary key (ID_SEANCE)
);

/*==============================================================*/
/* Table : TYPE_SALLE                                           */
/*==============================================================*/
create table TYPE_SALLE
(
   ID_TYPE_SALLE        char(1) not null,
   LIBELLE_TYPE_SALLE   varchar(50) not null,
   primary key (ID_TYPE_SALLE)
);

/*==============================================================*/
/* Table : TYPE_USER                                            */
/*==============================================================*/
create table TYPE_USER
(
   ID_TYPE_USER         char(1) not null,
   ID_USER              int not null,
   LIBELLE_TYPE_USER    varchar(25) not null,
   primary key (ID_TYPE_USER)
);

/*==============================================================*/
/* Table : USERS                                                */
/*==============================================================*/
create table USERS
(
   ID_USER              int not null,
   NOM_USER             varchar(50) not null,
   PRENOM_USER          varchar(50) not null,
   USER_NAME            varchar(50) not null,
   PSWD                 varchar(255) not null,
   GENRE                char(1) not null,
   CREATED_AT           timestamp not null,
   primary key (ID_USER)
);

-- Ajout des contraintes de clés étrangères

alter table RESERVAVTION add constraint FK_CONCERNE_C foreign key (ID_COURS)
      references COURS (ID_COURS) on delete restrict on update restrict;

alter table RESERVAVTION add constraint FK_CONCERNE_E foreign key (ID_EQUIPEMENT)
      references EQUIPEMENTS (ID_EQUIPEMENT) on delete restrict on update restrict;

alter table RESERVAVTION add constraint FK_RESERVE foreign key (ID_USER)
      references USERS (ID_USER) on delete restrict on update restrict;

alter table SALLE add constraint FK_A_POUR_TYPE foreign key (ID_TYPE_SALLE)
      references TYPE_SALLE (ID_TYPE_SALLE) on delete restrict on update restrict;

alter table SALLE add constraint FK_EST_AFFECTE_A foreign key (ID_USER)
      references USERS (ID_USER) on delete restrict on update restrict;

alter table SEANCES add constraint FK_CONCERNE foreign key (ID_COURS)
      references COURS (ID_COURS) on delete restrict on update restrict;

alter table SEANCES add constraint FK_EFFECTUE foreign key (ID_USER)
      references USERS (ID_USER) on delete restrict on update restrict;

alter table SEANCES add constraint FK_UTILISE foreign key (ID_EQUIPEMENT)
      references EQUIPEMENTS (ID_EQUIPEMENT) on delete restrict on update restrict;

alter table TYPE_USER add constraint FK_APPARTIENT_A foreign key (ID_USER)
      references USERS (ID_USER) on delete restrict on update restrict;

-- Ajout des contraintes de vérification

DELIMITER //

CREATE TRIGGER before_insert_SEANCES
BEFORE INSERT ON SEANCES
FOR EACH ROW
BEGIN
    IF (NEW.ID_COURS IS NOT NULL AND NEW.ID_EQUIPEMENT IS NOT NULL)
    OR (NEW.ID_COURS IS NULL AND NEW.ID_EQUIPEMENT IS NULL) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Une séance doit concerner soit un cours, soit un équipement, mais pas les deux';
    END IF;
END;

//

DELIMITER ;

DELIMITER //

CREATE TRIGGER before_insert_RESERVATION
BEFORE INSERT ON RESERVATION
FOR EACH ROW
BEGIN
    IF (NEW.ID_COURS IS NOT NULL AND NEW.ID_EQUIPEMENT IS NOT NULL)
    OR (NEW.ID_COURS IS NULL AND NEW.ID_EQUIPEMENT IS NULL) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Une réservation doit concerner soit un cours, soit un équipement, mais pas les deux';
    END IF;
END;

//
DELIMITER ;

/*==============================================================*/
/* Insérer des données                                          */
/*==============================================================*/

-- Insérer des types d'utilisateur
INSERT INTO TYPE_USER (ID_TYPE_USER, ID_USER, LIBELLE_TYPE_USER) VALUES
('A', 1, 'Administrateur'),
('S', 2, 'Abonné'),
('M', 3, 'Maintenance');

-- Insérer des utilisateurs
INSERT INTO USERS (ID_USER, NOM_USER, PRENOM_USER, USER_NAME, PSWD, GENRE, CREATED_AT) VALUES
(1, 'Admin', 'GymTech', 'admin', 'hashed_password_1', 'M', NOW()),
(2, 'Durand', 'Sophie', 'sophie_d', 'hashed_password_2', 'F', NOW()),
(3, 'Martin', 'Paul', 'paul_m', 'hashed_password_3', 'M', NOW());

-- Insérer des types de salles
INSERT INTO TYPE_SALLE (ID_TYPE_SALLE, LIBELLE_TYPE_SALLE) VALUES
('C', 'Salle de cours'),
('M', 'Salle de musculation');

-- Insérer des salles
INSERT INTO SALLE (ID_SALLE, ID_TYPE_SALLE, ID_USER, NOM_SALLE) VALUES
(1, 'C', 1, 'Salle Yoga'),
(2, 'M', 2, 'Salle Cardio');

-- Insérer des équipements
INSERT INTO EQUIPEMENTS (ID_EQUIPEMENT, TYPE_EQUIPEMENT, NOM_EQUIPEMENT) VALUES
(1, 'Tapis de course', 'Tapis ProForm'),
(2, 'Vélo elliptique', 'Vélo NordicTrack');

-- Insérer des cours
INSERT INTO COURS (ID_COURS, TYPE_COURS, NOMBRE_PLACES) VALUES
('A', 'Yoga', 10),
('B', 'CrossFit', 15);

-- Insérer des séances
INSERT INTO SEANCES (ID_SEANCE, ID_USER, ID_EQUIPEMENT, ID_COURS, TYPE_SEANCE, DATE_SEANCE, DUREE_SEANCE, ENERGIE_PRODUITE) VALUES
(1, 2, NULL, 'A', 'Cours collectif', '2024-03-10', 60, 500.0),
(2, 2, 1, NULL, 'Individuelle', '2024-03-11', 30, 250.0);

-- Insérer des réservations
INSERT INTO RESERVAVTION (ID_RESERVATION, ID_COURS, ID_EQUIPEMENT, ID_USER, DATE, HEURE_DEBUT, HEURE_FIN) VALUES
(1, 'A', NULL, 2, '2024-03-09', '10:00:00', '11:00:00'),
(2, NULL, 1, 2, '2024-03-12', '14:00:00', '14:30:00');


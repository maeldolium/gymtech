drop database if exists gymtech;

create database gymtech;

use gymtech;

drop table if exists CAPTEURS;

drop table if exists COURS;

drop table if exists EQUIPEMENTS;

drop table if exists RESERVER;

drop table if exists SALLES;

drop table if exists TYPE_CAPTEUR;

drop table if exists TYPE_SALLE;

drop table if exists TYPE_USER;

drop table if exists USERS;

/*==============================================================*/
/* Table : CAPTEURS                                             */
/*==============================================================*/
create table CAPTEURS
(
   ID_CAPTEUR           int not null,
   ID_TYPE_CAPTEUR      char(1) not null,
   LIBELLE_CAPTEUR      varchar(50) not null,
   MESURE_1             float(3) not null,
   MESURE_2             float(3) not null,
   primary key (ID_CAPTEUR)
);

/*==============================================================*/
/* Table : COURS                                                */
/*==============================================================*/
create table COURS
(
   ID_COURS             int not null,
   TYPE_COURS           varchar(25) not null,
   DATE_COURS           date not null,
   HEURE_DEBUT          time not null,
   HEURE_FIN            time not null,
   NOMBRE_PLACES        int not null,
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
   ID_EQUIPEMENT        int,
   ID_COURS             int,
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
   ID_CAPTEUR           int not null,
   NOM_SALLE            varchar(25),
   primary key (ID_SALLE)
);

/*==============================================================*/
/* Table : TYPE_CAPTEUR                                         */
/*==============================================================*/
create table TYPE_CAPTEUR
(
   ID_TYPE_CAPTEUR      char(1) not null,
   LIBELLE_TYPE_CAPTEUR varchar(50) not null,
   primary key (ID_TYPE_CAPTEUR)
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
   MOT_DE_PASSE_USER    char(60),
   primary key (ID_USER)
);

alter table CAPTEURS add constraint FK_DE_TYPE foreign key (ID_TYPE_CAPTEUR)
      references TYPE_CAPTEUR (ID_TYPE_CAPTEUR) on delete restrict on update restrict;

alter table RESERVER add constraint FK_RESERVER foreign key (ID_USER)
      references USERS (ID_USER) on delete restrict on update restrict;

alter table RESERVER add constraint FK_RESERVER2 foreign key (ID_EQUIPEMENT)
      references EQUIPEMENTS (ID_EQUIPEMENT) on delete restrict on update restrict;

alter table RESERVER add constraint FK_RESERVER3 foreign key (ID_COURS)
      references COURS (ID_COURS) on delete restrict on update restrict;

alter table SALLES add constraint FK_A_POUR_TYPE foreign key (ID_TYPE_SALLE)
      references TYPE_SALLE (ID_TYPE_SALLE) on delete restrict on update restrict;

alter table SALLES add constraint FK_COMPORTE foreign key (ID_CAPTEUR)
      references CAPTEURS (ID_CAPTEUR) on delete restrict on update restrict;

alter table USERS add constraint FK_EST foreign key (ID_TYPE_USER)
      references TYPE_USER (ID_TYPE_USER) on delete restrict on update restrict;

alter table USERS add constraint FK_EST_AFFECTE_A foreign key (ID_SALLE)
      references SALLES (ID_SALLE) on delete restrict on update restrict;


-- Ajout des contraintes de vérification

DELIMITER //

CREATE TRIGGER before_insert_RESERVER
BEFORE INSERT ON RESERVER
FOR EACH ROW
BEGIN
    -- Vérifie qu'il y a soit un cours, soit un équipement (exclusif)
    IF (NEW.ID_COURS IS NOT NULL AND NEW.ID_EQUIPEMENT IS NOT NULL)
    OR (NEW.ID_COURS IS NULL AND NEW.ID_EQUIPEMENT IS NULL) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Une réservation doit concerner soit un cours, soit un équipement, mais pas les deux';
    END IF;
END;
//

DELIMITER ;


-- Types d'utilisateur
INSERT INTO TYPE_USER (ID_TYPE_USER, LIBELLE_TYPE_USER) VALUES
('A', 'Administrateur'),
('C', 'Coach'),
('M', 'Membre');

-- Types de salle
INSERT INTO TYPE_SALLE (ID_TYPE_SALLE, LIBELLE_TYPE_SALLE) VALUES
('S', 'Salle de sport'),
('C', 'Salle de cours'),
('R', 'Salle de repos');

-- Types de capteurs
INSERT INTO TYPE_CAPTEUR (ID_TYPE_CAPTEUR, LIBELLE_TYPE_CAPTEUR) VALUES
('C', 'Caméra'),
('D', 'Capteur Température/Humidité DHT11'),
('R', 'Lecteur RFID');

-- Capteurs
INSERT INTO CAPTEURS (ID_CAPTEUR, ID_TYPE_CAPTEUR, LIBELLE_CAPTEUR, MESURE_1, MESURE_2) VALUES
(1, 'C', 'Caméra principale', 0, 0),
(2, 'D', 'Capteur Temp/Hum DHT11 - Zone Cardio', 22.5, 55.2),
(3, 'R', 'Lecteur RFID Entrée', 0, 0);

-- Salles
INSERT INTO SALLES (ID_SALLE, ID_TYPE_SALLE, ID_CAPTEUR, NOM_SALLE) VALUES
(1, 'S', 1, 'Salle Musculation'),
(2, 'C', 2, 'Salle Yoga'),
(3, 'R', 3, 'Salon Détente');

-- Équipements
INSERT INTO EQUIPEMENTS (ID_EQUIPEMENT, TYPE_EQUIPEMENT) VALUES
(1, 'Tapis de course'),
(2, 'Vélo elliptique'),
(3, 'Banc de musculation'),
(4, 'Haltères 20kg');

-- Cours
INSERT INTO COURS (ID_COURS, TYPE_COURS, DATE_COURS, HEURE_DEBUT, HEURE_FIN, NOMBRE_PLACES) VALUES
(1, 'Yoga', '2025-05-01', '10:00:00', '11:00:00', 10),
(2, 'Crossfit', '2025-05-02', '14:00:00', '15:00:00', 15),
(3, 'Pilates', '2025-05-03', '09:00:00', '10:00:00', 8);

-- Utilisateurs
INSERT INTO USERS (ID_USER, ID_SALLE, ID_TYPE_USER, NOM_USER, PRENOM_USER, GENRE_USER) VALUES
(1, 1, 'A', 'Dupont', 'Alice', 'F'),
(2, 1, 'C', 'Martin', 'Luc', 'M'),
(3, 2, 'M', 'Durand', 'Emma', 'F'),
(4, 2, 'M', 'Lemoine', 'Pierre', 'M'),
(5, 3, 'M', 'Moreau', 'Chloé', 'F');

-- Réservations

-- Alice réserve le tapis de course (équipement)
INSERT INTO RESERVER (ID_USER, ID_EQUIPEMENT, ID_COURS, DATE, HEURE_DEBUT, HEURE_FIN) VALUES
(1, 1, NULL, '2025-05-01', '08:00:00', '09:00:00');

-- Luc participe au cours de Crossfit (cours)
INSERT INTO RESERVER (ID_USER, ID_EQUIPEMENT, ID_COURS, DATE, HEURE_DEBUT, HEURE_FIN) VALUES
(2, NULL, 2, '2025-05-02', '14:00:00', '15:00:00');

-- Emma réserve le vélo elliptique (équipement)
INSERT INTO RESERVER (ID_USER, ID_EQUIPEMENT, ID_COURS, DATE, HEURE_DEBUT, HEURE_FIN) VALUES
(3, 2, NULL, '2025-05-01', '10:00:00', '11:00:00');

-- Pierre participe au cours de Pilates (cours)
INSERT INTO RESERVER (ID_USER, ID_EQUIPEMENT, ID_COURS, DATE, HEURE_DEBUT, HEURE_FIN) VALUES
(4, NULL, 3, '2025-05-03', '09:00:00', '10:00:00');

-- Chloé réserve le banc de musculation (équipement)
INSERT INTO RESERVER (ID_USER, ID_EQUIPEMENT, ID_COURS, DATE, HEURE_DEBUT, HEURE_FIN) VALUES
(5, 3, NULL, '2025-05-01', '11:00:00', '12:00:00');

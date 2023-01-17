

/* 
OUVRIR LE SERVEUR
  
CREER LA BASE :
*/

CREATE DATABASE sandrine_coupart;

ALTER DATABASE sandrine_coupart CHARSET=utf8; 

SHOW DATABASES;               
USE sandrine_coupart;

/*Creer les tables*/


 CREATE TABLE recettes(
  id_recettes INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(50)NOT NULL,
  description VARCHAR(255) NOT NULL,
  tps_prep VARCHAR(20) NULL,
  tps_repos VARCHAR(20),
  tps_cuisson VARCHAR(20) NULL,
  ingredients TEXT NULL,
  etapes TEXT NULL,
  regime_vegetarien INT NULL,
  regime_sans_sel INT NULL,
  regime_sans_lactose INT NULL,
  regime_sans_gluten INT NULL,
  oeufs INT NULL,
  lait INT NULL,
  crustaces INT NULL,
  arachides INT NULL,
  ble INT NULL,
  recette_reservee INT NULL,
  avis_id INT(11),
  FOREIGN KEY(avis_id) REFERENCES avis(id)
  user_id INT(11),
  FOREIGN KEY(user_id) REFERENCES user(id)
  );

SHOW TABLES;  


CREATE TABLE patient(
  id_patient INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(50) NOT NULL,
  prenom VARCHAR(50) NOT NULL,
  password VARCHAR(128) NULL,
  email VARCHAR(200)NOT NULL,
  ville VARCHAR(128) NOT NULL,
  regime_vegetarien INT NOT NULL,
  regime_sans_sel INT NOT NULL,
  regime_sans_lactose INT NOT NULL,
  regime_sans_gluten INT NOT NULL,
  allergie_oeufs INT NOT NULL,
  allergie_lait INT NOT NULL,
  allergie_crustaces INT NOT NULL,
  allergie_arachides INT NOT NULL,
  allergie_ble INT NOT NULL
  recettes_id INT(11),
  FOREIGN KEY(recettes_id) REFERENCES recettes(id),
  user_id INT(11),
  FOREIGN KEY(user_id) REFERENCES user(id)
);


CREATE TABLE avis(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(100) NOT NULL ,
  message TEXT NOT NULL,
  note INT NOT NULL,
  id_recettes INT(11),
  FOREIGN KEY(id_recettes) REFERENCES recettes(id)
);


CREATE TABLE user(
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR (180) NOT NULL,
  password VARCHAR(255) NOT NULL
  );
  
 


/*RESTREINDRE LES AUTORISATIONS */

/*creation des autorisations pour un patient en lecture seule*/
CREATE USER 'readUser'@'localhost' IDENTIFIED BY 'P@ssw0rd';
GRANT SELECT ON sandrinecoupart.recettes TO 'readUser'@'localhost';

/*creation des autorisations pour un administrateur qui a vue sur tout*/
CREATE USER 'admin'@'localhost' IDENTIFIED BY 'P@ssw0rd';
GRANT ALL ON sandrinecoupart.* TO 'admin'@'localhost';


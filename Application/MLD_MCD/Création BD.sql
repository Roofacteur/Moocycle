DROP DATABASE IF EXISTS bd_moocycle;
CREATE DATABASE bd_moocycle;
USE bd_moocycle:
CREATE TABLE tbl_vache(
   numero INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   date_prochaine_chaleur DATE,
   date_insemination DATE,
   date_naissance DATE NOT NULL,
   nombre_lactation INT,
   race VARCHAR(50) NOT NULL,
   PRIMARY KEY(numero)
);

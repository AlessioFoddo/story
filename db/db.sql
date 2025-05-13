CREATE DATABASE IF NOT EXISTS storia;
USE storia;

-- Tabella User (contiene utenti e admin)
CREATE TABLE User (
  ID int(11) NOT NULL AUTO_INCREMENT,
  Username varchar(100) NOT NULL,
  Password varchar(255) NOT NULL,
  profile_image longblob DEFAULT NULL,
  PRIMARY KEY (ID),
  UNIQUE KEY Username (Username)
);

-- Tabella Utenti (referenzia User)
CREATE TABLE utenti (
  ID int(11) NOT NULL,
  PRIMARY KEY (ID),
  FOREIGN KEY (ID) REFERENCES user (ID) ON DELETE CASCADE
);

-- Tabella Admin (referenzia User)
CREATE TABLE admin (
  ID int(11) NOT NULL,
  PRIMARY KEY (ID),
  FOREIGN KEY (ID) REFERENCES user (ID) ON DELETE CASCADE
);

-- Tabella Capitoli
CREATE TABLE capitoli (
  ID_Capitolo int(11) NOT NULL AUTO_INCREMENT,
  Titolo varchar(255) NOT NULL,
  File longblob NOT NULL,
  Riassunto varchar(500) NOT NULL,
  PRIMARY KEY (ID_Capitolo)
);

-- Tabella Recensioni
CREATE TABLE recensioni (
  ID_Recensione int(11) NOT NULL AUTO_INCREMENT,
  ID int(11) DEFAULT NULL,
  File longblob NOT NULL,
  PRIMARY KEY (ID_Recensione),
  KEY ID (ID),
  FOREIGN KEY (ID) REFERENCES user (ID) ON DELETE CASCADE
);


-- Tabella Recensione_capitolo
CREATE TABLE recensione_capitolo (
  ID_Recensione int(11) NOT NULL,
  ID_Capitolo int(11) NOT NULL,
  PRIMARY KEY (ID_Recensione,ID_Capitolo),
  KEY ID_Capitolo (ID_Capitolo),
  FOREIGN KEY (ID_Recensione) REFERENCES recensioni (ID_Recensione) ON DELETE CASCADE,
  FOREIGN KEY (ID_Capitolo) REFERENCES capitoli (ID_Capitolo) ON DELETE CASCADE
);

CREATE TABLE capitoli_preferiti (
  ID int(11) NOT NULL,
  ID_Capitolo int(11) NOT NULL,
  PRIMARY KEY (ID,ID_Capitolo),
  KEY ID_Capitolo (ID_Capitolo),
  FOREIGN KEY (ID) REFERENCES utenti (ID) ON DELETE CASCADE,
  FOREIGN KEY (ID_Capitolo) REFERENCES capitoli (ID_Capitolo) ON DELETE CASCADE
);

-- Tabella Recensione_storia
CREATE TABLE recensione_storia (
  ID_Recensione int(11) NOT NULL,
  ID int(11) NOT NULL,
  PRIMARY KEY (ID_Recensione,ID),
  KEY ID (ID),
  FOREIGN KEY (ID_Recensione) REFERENCES recensioni (ID_Recensione) ON DELETE CASCADE,
  FOREIGN KEY (ID) REFERENCES user (ID) ON DELETE CASCADE
);


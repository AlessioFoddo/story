CREATE DATABASE IF NOT EXISTS storia;
USE storia;

-- Tabella User (contiene utenti e admin)
CREATE TABLE User (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(100) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL
);

-- Tabella Utenti (referenzia User)
CREATE TABLE Utenti (
    ID INT PRIMARY KEY,
    FOREIGN KEY (ID) REFERENCES User(ID) ON DELETE CASCADE
);

-- Tabella Admin (referenzia User)
CREATE TABLE Admin (
    ID INT PRIMARY KEY,
    FOREIGN KEY (ID) REFERENCES User(ID) ON DELETE CASCADE
);

-- Tabella Capitoli
CREATE TABLE Capitoli (
    ID_Capitolo INT AUTO_INCREMENT PRIMARY KEY,
    Titolo VARCHAR(255) NOT NULL,
    File LONGBLOB NOT NULL
);

-- Tabella Pubblicazione (associa un User a un Capitolo)
CREATE TABLE Pubblicazione (
    ID INT,
    ID_Capitolo INT,
    PRIMARY KEY (ID, ID_Capitolo),
    FOREIGN KEY (ID) REFERENCES User(ID) ON DELETE CASCADE,
    FOREIGN KEY (ID_Capitolo) REFERENCES Capitoli(ID_Capitolo) ON DELETE CASCADE
);

-- Tabella Recensioni
CREATE TABLE Recensioni (
    ID_Recensione INT AUTO_INCREMENT PRIMARY KEY,
    File LONGBLOB NOT NULL
);

-- Tabella Recensione_capitolo (collega recensioni ai capitoli)
CREATE TABLE Recensione_capitolo (
    ID_Recensione INT,
    ID_Capitolo INT,
    PRIMARY KEY (ID_Recensione, ID_Capitolo),
    FOREIGN KEY (ID_Recensione) REFERENCES Recensioni(ID_Recensione) ON DELETE CASCADE,
    FOREIGN KEY (ID_Capitolo) REFERENCES Capitoli(ID_Capitolo) ON DELETE CASCADE
);

-- Tabella Recensione_storia (collega recensioni alle storie, riferendosi all'User)
CREATE TABLE Recensione_storia (
    ID_Recensione INT,
    ID INT,
    PRIMARY KEY (ID_Recensione, ID),
    FOREIGN KEY (ID_Recensione) REFERENCES Recensioni(ID_Recensione) ON DELETE CASCADE,
    FOREIGN KEY (ID) REFERENCES User(ID) ON DELETE CASCADE
);

-- Aggiunta di un Admin
INSERT INTO User (Username, Password) VALUES ('foddo', 'JyleAlice');
INSERT INTO Admin (ID) VALUES (1);

-- Gemaakt door Furkan Uçar OITAOO8B
-- create new db
CREATE DATABASE drempeltoets;

-- tabel activiteiten aanmaken.
CREATE TABLE locatie(
    id INT NOT NULL AUTO_INCREMENT,
    locatie VARCHAR(250) NOT NULL,
    PRIMARY KEY(id)
);

-- tabel voorraad aanmaken.
  CREATE TABLE voorraad(
      id INT NOT NULL AUTO_INCREMENT,
      LocatieID INT NOT NULL,
      ArtikelID INT NOT NULL,
      aantal VARCHAR(250) NOT NULL,
      PRIMARY KEY(id),
      FOREIGN KEY(ArtikelID) REFERENCES Artikel(id),
      FOREIGN KEY(locatieID) REFERENCES Locatie(id)
  );

-- tabel Jongeren aanmaken.
CREATE TABLE Artikel(
    id INT NOT NULL AUTO_INCREMENT,
    FabriekID INT NOT NULL,
    product VARCHAR(250) NOT NULL,
    type VARCHAR(250) NOT NULL,
    inkoopprijs INT(250) NOT NULL,
    verkoopprijs INT(250) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(FabriekID) REFERENCES fabriek(id)
);

-- telefoon staat op varchar 15, heb het gegoogled meeste bedrijven doen tot 15 omdat de internationale telefoonnummer tot 15 kan gaan.
-- tabel activiteiten aanmaken.
CREATE TABLE fabriek(
    id INT NOT NULL AUTO_INCREMENT,
    fabriek VARCHAR(250) NOT NULL,
    telefoon VARCHAR(15) NOT NULL,
    PRIMARY KEY(id)
);

-- tabel Medewerker aanmaken.
CREATE TABLE Medewerker(
    id INT NOT NULL AUTO_INCREMENT,
    usertype_id INT NOT NULL,
    voorletters VARCHAR(250) NOT NULL,
    voorvoegsels VARCHAR(250),
    achternaam VARCHAR(250),
    gebruikersnaam VARCHAR(250),
    wachtwoord VARCHAR(250),
    PRIMARY KEY(id),
    FOREIGN KEY(usertype_id) REFERENCES usertype(id)
);

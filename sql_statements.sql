-- Gemaakt door Yusa Celiker OITAOO8B
-- create new db
CREATE DATABASE hengelsport;

-- tabel Usertype aanmaken, met dit tabel kun je kijken of iemand een admin is of een medewerker is
CREATE TABLE usertype(
    id INT NOT NULL AUTO_INCREMENT,
    type VARCHAR(255),
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY(id)
);

-- insert entrIES into table usertype (admin AND user)
INSERT INTO usertype VALUES (NULL, 'admin', now(), now()), (NULL, 'user', now(), now());

-- tabel Locatie aanmaken.
CREATE TABLE locatie(
    id INT NOT NULL AUTO_INCREMENT,
    locatie VARCHAR(250) NOT NULL,
    PRIMARY KEY(id)
);

-- tabel Leverancier aanmaken.
CREATE TABLE leverancier(
    id INT NOT NULL AUTO_INCREMENT,
    leverancier VARCHAR(250) NOT NULL,
    telefoon INT(15) NOT NULL,
    PRIMARY KEY(id)
);

-- tabel Artikel aanmaken.
CREATE TABLE artikel(
    id INT NOT NULL AUTO_INCREMENT,
    levID INT NOT NULL,
    product VARCHAR(250) NOT NULL,
    type VARCHAR(250) NOT NULL,
    inkoopprijs INT(250) NOT NULL,
    verkoopprijs INT(250) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(levID) REFERENCES leverancier(id)
);

-- tabel Voorraad aanmaken.
CREATE TABLE voorraad(
    id INT NOT NULL AUTO_INCREMENT,
    locatieID INT NOT NULL,
    productID INT NOT NULL,
    aantal VARCHAR(250) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY(locatieID) REFERENCES locatie(id),
    FOREIGN KEY(productID) REFERENCES artikel(id)
);

-- tabel Medewerker aanmaken.
CREATE TABLE medewerker(
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

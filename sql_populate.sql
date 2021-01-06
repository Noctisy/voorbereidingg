-- Populate gegevens voor de database. Heb het geprobeerd om in populate.php te doen maar het werkte niet dus moet maar zo.

INSERT INTO leverancier
        (id, leverancier, telefoon)
        VALUES
        (1, 'Henk de slager', 0625326170);
INSERT INTO leverancier
        (id, leverancier, telefoon)
        VALUES
        (2, 'Kees de kaas gozer', 0625326170);
INSERT INTO leverancier
        (id, leverancier, telefoon)
        VALUES
        (3, 'Bob de alcoholist', 0625326170);
INSERT INTO locatie
        (id, locatie)
        VALUES
        (1, 'Rotterdam');
INSERT INTO locatie
        (id, locatie)
        VALUES
        (2, 'Zoutermeer');
INSERT INTO locatie
        (id, locatie)
        VALUES
        (3, 'Amsterdam');
INSERT INTO artikel
        (id, levID, product, type, inkoopprijs, verkoopprijs)
        VALUES
        (1, '1', 'biefstuk', 'vlees', '15', '25');
INSERT INTO artikel
        (id, levID, product, type, inkoopprijs, verkoopprijs)
        VALUES
        (2, '1', 'kipfillet', 'kip', '13', '22');
INSERT INTO artikel
        (id, levID, product, type, inkoopprijs, verkoopprijs)
        VALUES
        (3, '2', 'gouda kaas', 'kaas', '25', '45');
INSERT INTO artikel
        (id, levID, product, type, inkoopprijs, verkoopprijs)
        VALUES
        (4, '2', 'cheddar kaas', 'kaas', '15', '115');
INSERT INTO artikel
        (id, levID, product, type, inkoopprijs, verkoopprijs)
        VALUES
        (5, '2', 'oude kaas', 'kaas', '1', '1,15');
INSERT INTO artikel
        (id, levID, product, type, inkoopprijs, verkoopprijs)
        VALUES
        (6, '3', 'klok', 'bier', '5', '7');
INSERT INTO voorraad
        (id, locatieID, productID,aantal)
        VALUES
        (1, '2', '1', '17');
INSERT INTO voorraad
        (id, locatieID, productID,aantal)
        VALUES
        (2, '2', '3', '117');
INSERT INTO voorraad
        (id, locatieID, productID,aantal)
        VALUES
        (3, '3', '6', '7');
INSERT INTO voorraad
        (id, locatieID, productID,aantal)
        VALUES
        (4, '1', '5', '7');
INSERT INTO voorraad
        (id, locatieID, productID,aantal)
        VALUES
        (5, '1', '4', '1');

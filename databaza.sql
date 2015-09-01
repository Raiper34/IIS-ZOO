SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';

-- -------------------------------------
-- -------- vymazanie tabuliek ---------
-- -------------------------------------
DROP TABLE IF EXISTS staraSa;
DROP TABLE IF EXISTS spravuje;
DROP TABLE IF EXISTS obsahuje;

DROP TABLE IF EXISTS klietka;
DROP TABLE IF EXISTS vybeh;

DROP TABLE IF EXISTS zamestnanec;
DROP TABLE IF EXISTS zivocich;
DROP TABLE IF EXISTS druhZivocicha;
DROP TABLE IF EXISTS testoval;
DROP TABLE IF EXISTS umiestnenie;

-- -------------------------------------
-- -------- vytvorenie tabuliek ---------
-- -------------------------------------
CREATE TABLE zamestnanec(
RodneCislo BIGINT NOT NULL,
meno VARCHAR(25) NOT NULL,
priezvisko VARCHAR(25) NOT NULL,
heslo VARCHAR(25) NOT NULL,
titul VARCHAR(10),
datumNarodenia DATE,
adresa VARCHAR(50),
funkcia VARCHAR(25) NOT NULL,
IBAN VARCHAR(24),
PRIMARY KEY(RodneCislo)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE zivocich(
IDZivocicha BIGINT NOT NULL AUTO_INCREMENT,
meno VARCHAR(25) NOT NULL,
datumNarodenia DATE,
datumUmrtia DATE,
trieda VARCHAR(25),
rad VARCHAR(25),
celad VARCHAR(25),
rod VARCHAR(25),
IDDruhuZivocicha BIGINT NOT NULL,
IDUmiestnenia BIGINT NOT NULL,
PRIMARY KEY(IDZivocicha)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE druhZivocicha(
IDDruhuZivocicha BIGINT NOT NULL AUTO_INCREMENT,
nazov VARCHAR(25) NOT NULL,
PRIMARY KEY(IDDruhuZivocicha)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE umiestnenie(
IDUmiestnenia BIGINT NOT NULL AUTO_INCREMENT,
nazov VARCHAR(25) NOT NULL,
sirka FLOAT,
dlzka FLOAT,
vyska FLOAT,
PRIMARY KEY(IDUmiestnenia)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE testoval(
IDTestu BIGINT NOT NULL AUTO_INCREMENT,
IDZivocicha BIGINT NOT NULL,
RodneCislo BIGINT NOT NULL,
hmotnostZivocicha FLOAT,
rozmerZivocicha FLOAT,
datumTestu DATE NOT NULL,
PRIMARY KEY(IDTestu)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
-- ---------------------------------

CREATE TABLE klietka(
IDUmiestnenia BIGINT NOT NULL,
typ VARCHAR(25),
podstielka VARCHAR(25),
lokacia VARCHAR(25),
PRIMARY KEY(IDUmiestnenia)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE vybeh(
IDUmiestnenia BIGINT NOT NULL,
teren VARCHAR(25),
povrch VARCHAR(25),
ohradenie VARCHAR(25),
PRIMARY KEY(IDUMIESTNENIA)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
-- ---------------------------------

CREATE TABLE staraSa(
IDZivocicha BIGINT NOT NULL,
RodneCislo BIGINT NOT NULL,
PRIMARY KEY(IDZivocicha, RodneCislo)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE spravuje(
IDUmiestnenia BIGINT NOT NULL,
RodneCislo BIGINT NOT NULL,
PRIMARY KEY(IDUmiestnenia, RodneCislo)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE obsahuje(
IDUmiestnenia BIGINT NOT NULL,
IDDruhuZivocicha BIGINT NOT NULL,
PRIMARY KEY(IDUmiestnenia, IDDruhuZivocicha)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- -------------------------------------
-- ---- pridanie cudzich klucov --------
-- -------------------------------------
ALTER TABLE zivocich ADD FOREIGN KEY(IDDruhuZivocicha) REFERENCES druhZivocicha(IDDruhuZivocicha);
ALTER TABLE zivocich ADD FOREIGN KEY(IDUmiestnenia) REFERENCES umiestnenie(IDUmiestnenia);

ALTER TABLE staraSa ADD FOREIGN KEY(IDZivocicha) REFERENCES zivocich(IDZivocicha);
ALTER TABLE staraSa ADD FOREIGN KEY(RodneCislo) REFERENCES zamestnanec(RodneCislo);
ALTER TABLE spravuje ADD FOREIGN KEY(IDUmiestnenia) REFERENCES umiestnenie(IDUmiestnenia);
ALTER TABLE spravuje ADD FOREIGN KEY(RodneCislo) REFERENCES zamestnanec(RodneCislo);
ALTER TABLE obsahuje ADD FOREIGN KEY(IDDruhuzivocicha) REFERENCES druhZivocicha(IDDruhuZivocicha);
ALTER TABLE obsahuje ADD FOREIGN KEY(IDUmiestnenia) REFERENCES umiestnenie(IDUmiestnenia);
ALTER TABLE testoval ADD FOREIGN KEY(IDZivocicha) REFERENCES zivocich(IDZivocicha);
ALTER TABLE testoval ADD FOREIGN KEY(RodneCislo) REFERENCES zamestnanec(RodneCislo);

ALTER TABLE klietka ADD FOREIGN KEY(IDUmiestnenia) REFERENCES umiestnenie(IDUmiestnenia);
ALTER TABLE vybeh ADD FOREIGN KEY(IDUmiestnenia) REFERENCES umiestnenie(IDUmiestnenia);

-- -------------------------------------
-- ----- vkladanie do tabuliek ---------
-- -------------------------------------

INSERT INTO zamestnanec (RodneCislo, heslo, meno, priezvisko, titul, datumNarodenia, adresa, funkcia, IBAN) VALUES('0', 'heslo', 'Filip', 'Gulán', 'Bc', '1993-12-15', 'Bzince pod Javorinou 1556, 916 11', 'riaditeľ', 'SK6508000000192000145399');
INSERT INTO zamestnanec (RodneCislo, heslo, meno, priezvisko, titul, datumNarodenia, adresa, funkcia, IBAN) VALUES('1', 'heslo', 'Eduard', 'Rybár', null, '1994-1-10', 'Bzince pod Javorinou Hrušové 100, 916 18', 'zamestnanec', 'CZ6508008894505');
INSERT INTO zamestnanec (RodneCislo, heslo, meno, priezvisko, titul, datumNarodenia, adresa, funkcia, IBAN) VALUES('5680186', 'heslo', 'Alexandra', 'Milkova', null, '1990-8-25', 'Brno Semilasso', 'zamestnanec', 'SK6508000000192000145399');
INSERT INTO zamestnanec (RodneCislo, heslo, meno, priezvisko, titul, datumNarodenia, adresa, funkcia, IBAN) VALUES('565882', 'heslo', 'Jana', 'Pracovita', 'Mgr', '1989-10-5', 'Bratislava 4, Ľudovitová 2', 'zamestnanec', 'CZ655465465456');
INSERT INTO zamestnanec (RodneCislo, heslo, meno, priezvisko, titul, datumNarodenia, adresa, funkcia, IBAN) VALUES('56465', 'heslo', 'Michal', 'Hralen', null, '1997-11-6', 'Praha 5, Divadelná 56', 'zamestnanec', 'CZ456464561564');

INSERT INTO druhZivocicha (IDDruhuZivocicha, nazov) VALUES('1', 'Lev');
INSERT INTO druhZivocicha (IDDruhuZivocicha, nazov) VALUES('2', 'Zebra');
INSERT INTO druhZivocicha (IDDruhuZivocicha, nazov) VALUES('3', 'Hroch');
INSERT INTO druhZivocicha (IDDruhuZivocicha, nazov) VALUES('4', 'Žirafa');
INSERT INTO druhZivocicha (IDDruhuZivocicha, nazov) VALUES('5', 'Medveď');
INSERT INTO druhZivocicha (IDDruhuZivocicha, nazov) VALUES('6', 'Slon');

INSERT INTO zivocich (IDZivocicha, meno, datumNarodenia, datumUmrtia, trieda, rad, celad, rod, IDDruhuZivocicha, IDUmiestnenia) VALUES('1', 'Alex', '2001-12-16', null, 'cicavci', 'šelmy', 'kočkovité', 'Panthera', '1', '1');
INSERT INTO zivocich (IDZivocicha, meno, datumNarodenia, datumUmrtia, trieda, rad, celad, rod, IDDruhuZivocicha, IDUmiestnenia) VALUES('2', 'Marty', '2005-12-15', null, 'cicavci', 'nepárno-kopýtníci', 'koňovitý', 'Equus', '2', '2');
INSERT INTO zivocich (IDZivocicha, meno, datumNarodenia, datumUmrtia, trieda, rad, celad, rod, IDDruhuZivocicha, IDUmiestnenia) VALUES('3', 'Gloria', '1999-9-10', null, 'cicavci', 'nepárno-kopýtníci', 'hrochovitý', 'Hippopotamus', '3', '2');
INSERT INTO zivocich (IDZivocicha, meno, datumNarodenia, datumUmrtia, trieda, rad, celad, rod, IDDruhuZivocicha, IDUmiestnenia) VALUES('4', 'Melvan', '1993-12-15', null, 'cicavci', 'nepárno-kopýtníci', 'žirafovitý', 'Giraffa', '4', '2');
INSERT INTO zivocich (IDZivocicha, meno, datumNarodenia, datumUmrtia, trieda, rad, celad, rod, IDDruhuZivocicha, IDUmiestnenia) VALUES('5', 'Dumbo', '1998-10-15', '2001-10-16', 'cicavci', 'šelmy', 'medveďovité', 'Ursulus', '5', '2');
INSERT INTO zivocich (IDZivocicha, meno, datumNarodenia, datumUmrtia, trieda, rad, celad, rod, IDDruhuZivocicha, IDUmiestnenia) VALUES('6', 'Selma', '2012-6-28', null, 'cicavci', 'chobotnantec', 'slonovité', 'Elephas', '6', '3');

INSERT INTO umiestnenie (IDUmiestnenia, nazov, sirka, dlzka, vyska) VALUES('1', 'Klietka Levi', '1500.5', '800', '2');
INSERT INTO umiestnenie (IDUmiestnenia, nazov, sirka, dlzka, vyska) VALUES('2', 'Výbeh Afrika', '1486.5', '920.1', null);
INSERT INTO umiestnenie (IDUmiestnenia, nazov, sirka, dlzka, vyska) VALUES('3', 'Klietka Medvede', '1489', '1200.6', '2.2');
INSERT INTO umiestnenie (IDUmiestnenia, nazov, sirka, dlzka, vyska) VALUES('4', 'Výbeh Ázia', '1300', '1000', null);
INSERT INTO umiestnenie (IDUmiestnenia, nazov, sirka, dlzka, vyska) VALUES('5', 'Výbeh Amerika', '1800', '1200', null);

INSERT INTO testoval (IDZivocicha, RodneCislo, hmotnostZivocicha, rozmerZivocicha, datumTestu ) VALUES('1', '5680186', '106.5', '1.15', '2015-9-10');
INSERT INTO testoval (IDZivocicha, RodneCislo, hmotnostZivocicha, rozmerZivocicha, datumTestu ) VALUES('2', '5680186', '86', '1.85', '2015-12-16');
INSERT INTO testoval (IDZivocicha, RodneCislo, hmotnostZivocicha, rozmerZivocicha, datumTestu ) VALUES('3', '56465', '226.8', '3.1', '2015-10-28');
INSERT INTO testoval (IDZivocicha, RodneCislo, hmotnostZivocicha, rozmerZivocicha, datumTestu ) VALUES('4', '1', '126', '4.6', '2015-1-1');

INSERT INTO klietka (typ, podstielka, lokacia, IDUmiestnenia) VALUES('železná', 'tráva', 'Naturov pavilón', '1');
INSERT INTO klietka (typ, podstielka, lokacia, IDUmiestnenia) VALUES('železná', 'hlina', 'Helzmerov pavilón', '3');

INSERT INTO vybeh (teren, povrch, ohradenie, IDUmiestnenia) VALUES('rovný', 'step', 'železný plot', '2');
INSERT INTO vybeh (teren, povrch, ohradenie, IDUmiestnenia) VALUES('hrbolatý', 'tajga', 'drevený plot', '4');
INSERT INTO vybeh (teren, povrch, ohradenie, IDUmiestnenia) VALUES('hrbolatý', 'step', 'drevený plot', '5');

INSERT INTO staraSa (IDZivocicha, RodneCislo) VALUES('1', '565882');
INSERT INTO staraSa (IDZivocicha, RodneCislo) VALUES('1', '1');
INSERT INTO staraSa (IDZivocicha, RodneCislo) VALUES('3', '565882');
INSERT INTO staraSa (IDZivocicha, RodneCislo) VALUES('4', '5680186');
INSERT INTO staraSa (IDZivocicha, RodneCislo) VALUES('4', '565882');
INSERT INTO staraSa (IDZivocicha, RodneCislo) VALUES('5', '5680186');
INSERT INTO staraSa (IDZivocicha, RodneCislo) VALUES('5', '1');

INSERT INTO spravuje (IDUmiestnenia, RodneCislo) VALUES('1', '1');
INSERT INTO spravuje (IDUmiestnenia, RodneCislo) VALUES('1', '5680186');
INSERT INTO spravuje (IDUmiestnenia, RodneCislo) VALUES('2', '565882');
INSERT INTO spravuje (IDUmiestnenia, RodneCislo) VALUES('3', '565882');
INSERT INTO spravuje (IDUmiestnenia, RodneCislo) VALUES('4', '565882');
INSERT INTO spravuje (IDUmiestnenia, RodneCislo) VALUES('4', '5680186');
INSERT INTO spravuje (IDUmiestnenia, RodneCislo) VALUES('4', '1');
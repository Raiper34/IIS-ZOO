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
datumNarodenia DATE NOT NULL,
adresa VARCHAR(50) NOT NULL,
funkcia VARCHAR(25) NOT NULL,
IBAN VARCHAR(24),
PRIMARY KEY(RodneCislo)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE zivocich(
IDZivocicha BIGINT NOT NULL AUTO_INCREMENT,
meno VARCHAR(25) NOT NULL,
datumNarodenia DATE NOT NULL,
datumUmrtia DATE,
trieda VARCHAR(25) NOT NULL,
rad VARCHAR(25) NOT NULL,
celad VARCHAR(25) NOT NULL,
rod VARCHAR(25) NOT NULL,
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
sirka FLOAT NOT NULL,
dlzka FLOAT NOT NULL,
vyska FLOAT,
PRIMARY KEY(IDUmiestnenia)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE testoval(
IDZivocicha BIGINT NOT NULL,
RodneCislo BIGINT NOT NULL,
hmotnostZivocicha FLOAT NOT NULL,
rozmerZivocicha FLOAT NOT NULL,
datumTestu DATE NOT NULL,
PRIMARY KEY(IDZivocicha, RodneCislo)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;
-- ---------------------------------

CREATE TABLE klietka(
IDUmiestnenia BIGINT NOT NULL,
typ VARCHAR(25) NOT NULL,
podstielka VARCHAR(25) NOT NULL,
lokacia VARCHAR(25) NOT NULL,
PRIMARY KEY(IDUmiestnenia)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

CREATE TABLE vybeh(
IDUmiestnenia BIGINT NOT NULL,
teren VARCHAR(25) NOT NULL,
povrch VARCHAR(25) NOT NULL,
ohradenie VARCHAR(25) NOT NULL,
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
INSERT INTO umiestnenie (IDUmiestnenia, nazov, sirka, dlzka, vyska) VALUES('001', 'Výbeh Levi', '1500.5', '800', '2');
INSERT INTO druhZivocicha (IDDruhuZivocicha, nazov) VALUES('001', 'Lev');
INSERT INTO zivocich (IDZivocicha, meno, datumNarodenia, datumUmrtia, trieda, rad, celad, rod, IDDruhuZivocicha, IDUmiestnenia) VALUES('001', 'Alex', '1993-12-15', null, 'cicavci', 'šelmy', 'kočkovité', 'Panthera', '001', '001');
INSERT INTO zamestnanec (RodneCislo, meno, priezvisko, titul, datumNarodenia, adresa, funkcia, IBAN) VALUES('8802012131','Michal', 'Burgh', 'MGR', '1993-12-15', 'Trnava, 745', 'pracovnik', 'CZ6508000000192000145399');
INSERT INTO staraSa (IDZivocicha, RodneCislo) VALUES('001', '8802012131');


  
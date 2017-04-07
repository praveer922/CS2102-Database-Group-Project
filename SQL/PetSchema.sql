CREATE TABLE bidUpdateHistory (
userid VARCHAR(32) NOT NULL,
lastprice NUMERIC(7,2) NOT NULL,
changed_on DATE NOT NULL DEFAULT CURRENT_DATE
);

CREATE TRIGGER bidUpdated
AFTER UPDATE
ON Bids
FOR EACH ROW
EXECUTE PROCEDURE logBidUpdated();

CREATE FUNCTION logBidUpdated()
RETURNS TRIGGER AS $$
BEGIN
 INSERT INTO bidUpdateHistory (userid, lastprice)
 VALUES (OLD.petownerid, OLD.price);
RETURN NEW;
END; $$
LANGUAGE PLPGSQL;

CREATE TABLE Users (
userid VARCHAR(32) PRIMARY KEY,
password VARCHAR(32) NOT NULL,
name VARCHAR(128) NOT NULL,
email VARCHAR(128) UNIQUE NOT NULL,
address VARCHAR(128) NOT NULL,
isA VARCHAR(20) CHECK(isA = 'caretaker' OR isA ='petowner' OR isA = 'both'),
description TEXT,
likebreeds TEXT
);

CREATE TABLE Pets (
petid SERIAL PRIMARY KEY,      
owner VARCHAR(32) REFERENCES Users(userid) ON UPDATE CASCADE ON DELETE CASCADE,
name VARCHAR(128) NOT NULL,
age INTEGER NOT NULL,
breed VARCHAR(128),
gender VARCHAR(10) CHECK(gender = 'Male' OR gender='Female'),
description TEXT
);

CREATE TABLE Bids (
petownerid VARCHAR(32) NOT NULL,
caretakerid VARCHAR(32) NOT NULL,
petid INTEGER NOT NULL,
fromDate DATE NOT NULL,
toDate DATE NOT NULL,
price NUMERIC(7,2) NOT NULL,
PRIMARY KEY (petownerid, caretakerid, petid),
FOREIGN KEY (petownerid) REFERENCES Users(userid) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN KEY (caretakerid) REFERENCES Users(userid) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN KEY (petid) REFERENCES Pets(petid) ON UPDATE CASCADE ON DELETE CASCADE,
CONSTRAINT id CHECK(petownerid <> caretakerid),
CONSTRAINT dates CHECK(fromDate < toDate)
);

CREATE VIEW Bishan_caretakers AS
SELECT userid, password, name, email, address, description
FROM Users
WHERE UPPER(address) LIKE UPPER('%Bishan%') AND (isA = 'caretaker' OR isA = 'both');

CREATE VIEW Toa_payoh_caretakers AS
SELECT userid, password, name, email, address, description
FROM Users
WHERE UPPER(address) LIKE UPPER('%Toa Payoh%') AND (isA = 'caretaker' OR isA = 'both');

CREATE VIEW Kent_ridge_caretakers AS
SELECT userid, password, name, email, address, description
FROM Users
WHERE UPPER(address) LIKE UPPER('%Kent Ridge%') AND (isA = 'caretaker' OR isA = 'both');

CREATE VIEW Jurong_caretakers AS
SELECT userid, password, name, email, address, description
FROM Users
WHERE UPPER(address) LIKE UPPER('%Jurong%') AND (isA = 'caretaker' OR isA = 'both');

CREATE VIEW Woodlands_caretakers AS
SELECT userid, password, name, email, address, description
FROM Users
WHERE UPPER(address) LIKE UPPER('%Woodlands%') AND (isA = 'caretaker' OR isA = 'both');

CREATE VIEW Pasir_ris_caretakers AS
SELECT userid, password, name, email, address, description
FROM Users
WHERE UPPER(address) LIKE UPPER('%Pasir Ris%') AND (isA = 'caretaker' OR isA = 'both');
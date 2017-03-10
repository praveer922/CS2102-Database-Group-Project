CREATE TABLE Users (
userid VARCHAR(32) PRIMARY KEY,
password VARCHAR(32) NOT NULL,
name VARCHAR(128) NOT NULL,
email VARCHAR(128) NOT NULL,
address VARCHAR(128) NOT NULL,
isA VARCHAR(20) CHECK(isA = 'caretaker' OR isA ='petowner' OR isA = 'both'),
description TEXT
);

CREATE TABLE Pets (
petid SERIAL PRIMARY KEY,      
owner VARCHAR(32) REFERENCES Users(userid),
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
FOREIGN KEY (petownerid) REFERENCES Users(userid),
FOREIGN KEY (caretakerid) REFERENCES Users(userid),
FOREIGN KEY (petid) REFERENCES Pets(petid),
CONSTRAINT id CHECK(petownerid <> caretakerid),
CONSTRAINT dates CHECK(fromDate < toDate)
);
.mode column
.headers on

CREATE Table Event(
idEvent INTEGER PRIMARY KEY,
name VARCHAR NOT NULL,
date DATETIME,
type VARCHAR,
description VARCHAR,
private BOOLEAN);

CREATE Table User(
idUser INTEGER PRIMARY KEY,
name VARCHAR,
age INTEGER,
username VARCHAR,
password VARCHAR);

CREATE Table Registration(
idUser INTEGER REFERENCES User(idUser),
idEvent INTEGER REFERENCES Event(idEvent),
creator BOOLEAN);


CREATE Table Comment(
idComment INTEGER PRIMARY KEY,
comment VARCHAR,
idEvent INTEGER,
idUser INTEGER,
FOREIGN KEY(idEvent) REFERENCES Event(idEvent),
FOREIGN KEY(idUser) REFERENCES User(idUser),
date DATETIME);

INSERT INTO User (name, age,username,password) VALUES ('Joaquim', 45,'jquim','1234');
INSERT INTO Event (name, date,type,description,private) VALUES ('Evento','1968-04-19 15:48:15','Tipo de Evento','O maior deles todos', 0);
INSERT INTO Registration (idUser, idEvent,creator) VALUES (1,1,1);
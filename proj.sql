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
birthDate DATE,
username VARCHAR,
password VARCHAR,
email VARCHAR);

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

CREATE Table Invite(
idInvite INTEGER PRIMARY KEY,
idSender INTEGER REFERENCES User(idUser),
idReceiver INTEGER REFERENCES User(idUser),
idEvent INTEGER REFERENCES Event(idEvent),
status INTEGER DEFAULT 0);

CREATE Table PendingInvite(
idPendingInvite INTEGER PRIMARY KEY,
idSender INTEGER REFERENCES User(idUser),
receiverEmail VARCHAR,
idEvent INTEGER REFERENCES Event(idEvent));


INSERT INTO User (name, age,username,password) VALUES ('Joaquim', 45,'jquim','1234');
INSERT INTO Event (name, date,type,description,private) VALUES ('Evento','1968-04-19 15:48:15','Tipo de Evento','O maior deles todos', 0);
INSERT INTO Registration (idUser, idEvent,creator) VALUES (1,1,1);

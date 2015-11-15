.mode column
.headers on

/* Verify that Foreign keys are enabled:
PRAGMA foreign_keys = ON;
*/

CREATE Table User(
idUser INTEGER PRIMARY KEY,
firstName VARCHAR NOT NULL,
lastName VARCHAR,
birthDate DATE,
email VARCHAR NOT NULL,
username VARCHAR NOT NULL,
password VARCHAR NOT NULL,
profilePhoto VARCHAR DEFAULT NULL);

CREATE Table Event(
idEvent INTEGER PRIMARY KEY,
name VARCHAR NOT NULL,
date DATETIME,
description VARCHAR,
type VARCHAR,
address VARCHAR,
private BOOLEAN DEFAULT 0,
eventPhoto VARCHAR DEFAULT NULL);

CREATE Table Registration(
idUser INTEGER REFERENCES User(idUser) ON DELETE CASCADE ON UPDATE CASCADE,
idEvent INTEGER REFERENCES Event(idEvent) ON DELETE CASCADE ON UPDATE CASCADE,
creator BOOLEAN DEFAULT 0,
PRIMARY KEY (idUser, idEvent));

CREATE Table Invite(
idSender INTEGER REFERENCES User(idUser) ON DELETE CASCADE ON UPDATE CASCADE,
idReceiver INTEGER REFERENCES User(idUser) ON DELETE CASCADE ON UPDATE CASCADE,
idEvent INTEGER REFERENCES Event(idEvent) ON DELETE CASCADE ON UPDATE CASCADE,
status INTEGER DEFAULT 0,
PRIMARY KEY (idSender, idReceiver, idEvent));

CREATE Table PendingInvite(
idSender INTEGER REFERENCES User(idUser) ON DELETE CASCADE ON UPDATE CASCADE,
emailReceiver VARCHAR,
idEvent INTEGER REFERENCES Event(idEvent) ON DELETE CASCADE ON UPDATE CASCADE,
PRIMARY KEY (idSender, emailReceiver, idEvent));


CREATE Table Comment(
idComment INTEGER PRIMARY KEY,
content VARCHAR,
photo VARCHAR,
date DATETIME,
idUser INTEGER REFERENCES User(idUser) ON DELETE CASCADE ON UPDATE CASCADE,
idEvent INTEGER REFERENCES Event(idEvent) ON DELETE CASCADE ON UPDATE CASCADE,
parentComment INTEGER REFERENCES Comment(idComment) ON DELETE CASCADE ON UPDATE CASCADE);



INSERT INTO User (name, age,username,password) VALUES ('Joaquim', 45,'jquim','1234');
INSERT INTO Event (name, date,type,description,private) VALUES ('Evento','1968-04-19 15:48:15','Tipo de Evento','O maior deles todos', 0);
INSERT INTO Registration (idUser, idEvent,creator) VALUES (1,1,1);

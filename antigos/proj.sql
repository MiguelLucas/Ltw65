.mode column
.headers on
/* Enable foreign keys. Default is OFF. We'll likely need this in the connection */
PRAGMA foreign_keys = ON;


CREATE TABLE User(
	idUser INTEGER PRIMARY KEY,
	firstName VARCHAR NOT NULL,
	lastName VARCHAR,
	birthDate DATE NOT NULL CHECK((date('now')-birthDate) > 13),
	email VARCHAR NOT NULL UNIQUE,
	password VARCHAR NOT NULL,
	profilePhoto VARCHAR DEFAULT NULL
);

CREATE TABLE Event(
	idEvent INTEGER PRIMARY KEY,
	name VARCHAR NOT NULL,
	date DATETIME NOT NULL,
	description VARCHAR,
	type INTEGER REFERENCES EventType(idEventType) ON DELETE SET NULL ON UPDATE CASCADE,
	address VARCHAR,
	private BOOLEAN DEFAULT 0,
	eventPhoto VARCHAR DEFAULT NULL
);

CREATE TABLE EventType(
	idEventType INTEGER PRIMARY KEY,
	type VARCHAR NOT NULL UNIQUE
);

CREATE TABLE Registration(
	idUser INTEGER REFERENCES User(idUser) ON DELETE CASCADE ON UPDATE CASCADE,
	idEvent INTEGER REFERENCES Event(idEvent) ON DELETE CASCADE ON UPDATE CASCADE,
	creator BOOLEAN DEFAULT 0,
	PRIMARY KEY (idUser, idEvent)
);

CREATE TABLE Invite(
	idSender INTEGER REFERENCES User(idUser) ON DELETE CASCADE ON UPDATE CASCADE,
	idReceiver INTEGER REFERENCES User(idUser) ON DELETE CASCADE ON UPDATE CASCADE,
	idEvent INTEGER REFERENCES Event(idEvent) ON DELETE CASCADE ON UPDATE CASCADE,
	status INTEGER DEFAULT 0,
	PRIMARY KEY (idSender, idReceiver, idEvent)
);

CREATE TABLE PendingInvite(
	idSender INTEGER REFERENCES User(idUser) ON DELETE CASCADE ON UPDATE CASCADE,
	emailReceiver VARCHAR NOT NULL,
	idEvent INTEGER REFERENCES Event(idEvent) ON DELETE CASCADE ON UPDATE CASCADE,
	PRIMARY KEY (idSender, emailReceiver, idEvent)
);

CREATE TABLE Comment(
	idComment INTEGER PRIMARY KEY,
	content VARCHAR,
	photo VARCHAR,
	date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	idUser INTEGER REFERENCES User(idUser) ON DELETE CASCADE ON UPDATE CASCADE,
	idEvent INTEGER REFERENCES Event(idEvent) ON DELETE CASCADE ON UPDATE CASCADE,
	parentComment INTEGER REFERENCES Comment(idComment) ON DELETE CASCADE ON UPDATE CASCADE,
	CHECK(content IS NOT NULL OR photo IS NOT NULL)
);


/* To do: review and update inserts */

INSERT INTO User (firstName,lastName,birthDate,email,password,profilePhoto) VALUES ('Joaquim', 'da Silva','1968-04-19','jquim@gmail.com','1234','uma foto');
INSERT INTO User (firstName,lastName,birthDate,email,password,profilePhoto) VALUES ('Manuel', 'da Gertrudes','1965-07-19','o.manel@gmail.com','4321','uma outra foto');
INSERT INTO EventType(type) VALUES ('Concerto');
INSERT INTO EventType(type) VALUES ('Teatro');
INSERT INTO Event (name,date,description,type,address,private,eventPhoto) VALUES ('Muse','2015-12-19 21:00:00','Concerto dos Muse do seu último albúm, Drones',1,'Porto',0,'Uma foto do concerto');
INSERT INTO Event (name,date,description,type,address,private,eventPhoto) VALUES ('Quizoola','2015-12-21 20:00:00','Performance com a duração de 6 horas',2,'Porto',0,'Uma foto do teatro');

INSERT INTO Registration (idUser, idEvent,creator) VALUES (1,1,1);
INSERT INTO Registration (idUser, idEvent,creator) VALUES (2,2,1);

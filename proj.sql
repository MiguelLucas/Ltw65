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
	username VARCHAR NOT NULL UNIQUE,
	password VARCHAR NOT NULL,
	profilePhoto VARCHAR DEFAULT NULL
);

CREATE TABLE Event(
	idEvent INTEGER PRIMARY KEY,
	name VARCHAR NOT NULL,
	date DATETIME NOT NULL,
	description VARCHAR,
	type VARCHAR REFERENCES EventType(type) ON DELETE SET NULL ON UPDATE CASCADE,
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
	date NOT NULL DATETIME DEFAULT CURRENT_TIMESTAMP,
	idUser INTEGER REFERENCES User(idUser) ON DELETE CASCADE ON UPDATE CASCADE,
	idEvent INTEGER REFERENCES Event(idEvent) ON DELETE CASCADE ON UPDATE CASCADE,
	parentComment INTEGER REFERENCES Comment(idComment) ON DELETE CASCADE ON UPDATE CASCADE,
	CHECK(content IS NOT NULL OR photo IS NOT NULL)
);


/* To do: review and update inserts */
INSERT INTO User (name, age,username,password) VALUES ('Joaquim', 45,'jquim','1234');
INSERT INTO Event (name, date,type,description,private) VALUES ('Evento','1968-04-19 15:48:15','Tipo de Evento','O maior deles todos', 0);
INSERT INTO Registration (idUser, idEvent,creator) VALUES (1,1,1);

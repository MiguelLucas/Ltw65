PRAGMA foreign_keys = ON;
.mode columns
.headers ON

CREATE TABLE User(
        idUser INTEGER PRIMARY KEY,
        firstName VARCHAR NOT NULL,
        lastName VARCHAR NOT NULL,
        birthDate DATE NOT NULL,
        email VARCHAR NOT NULL UNIQUE,
        password VARCHAR NOT NULL,
        profilePhoto VARCHAR DEFAULT "default.png",
        active INTEGER NOT NULL DEFAULT 1
);

CREATE TABLE Event(
        idEvent INTEGER PRIMARY KEY,
        name VARCHAR NOT NULL,
        date DATETIME NOT NULL,
        description VARCHAR,
        type INTEGER REFERENCES EventType(idEventType) ON DELETE SET NULL ON UPDATE CASCADE,
        address VARCHAR,
        private BOOLEAN DEFAULT 0,
        idUserCreator INTEGER REFERENCES User(idUser) ON DELETE CASCADE ON UPDATE CASCADE,
        eventPhoto VARCHAR DEFAULT "default.png",
        active INTEGER NOT NULL DEFAULT 1
);

CREATE TABLE EventType(
        idEventType INTEGER PRIMARY KEY,
        type VARCHAR NOT NULL UNIQUE
);

CREATE TABLE Registration(
        idUser INTEGER REFERENCES User(idUser) ON DELETE CASCADE ON UPDATE CASCADE,
        idEvent INTEGER REFERENCES Event(idEvent) ON DELETE CASCADE ON UPDATE CASCADE,
        PRIMARY KEY (idUser, idEvent)
);

CREATE TABLE PendingInvite(
        idSender INTEGER REFERENCES User(idUser) ON DELETE CASCADE ON UPDATE CASCADE,
        emailReceiver VARCHAR NOT NULL,
        idEvent INTEGER REFERENCES Event(idEvent) ON DELETE CASCADE ON UPDATE CASCADE,
        PRIMARY KEY (idSender, emailReceiver, idEvent)
);

CREATE TABLE Invite(
        idSender INTEGER REFERENCES User(idUser) ON DELETE CASCADE ON UPDATE CASCADE,
        idReceiver INTEGER REFERENCES User(idUser) ON DELETE CASCADE ON UPDATE CASCADE,
        idEvent INTEGER REFERENCES Event(idEvent) ON DELETE CASCADE ON UPDATE CASCADE,
        active INTEGER NOT NULL DEFAULT 1,
        PRIMARY KEY (idSender, idReceiver, idEvent)
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

CREATE TRIGGER TriggerUserCreator
        AFTER INSERT ON Event
        FOR EACH ROW
        BEGIN
        INSERT INTO Registration(idUser,idEvent) VALUES (NEW.idUserCreator,NEW.idEvent);
        END;

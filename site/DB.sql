/* Création des catégorie "Artiste" et "Albumn"*/
CREATE TABLE IF NOT EXISTS `Artiste` (
	`Id_artiste` integer primary key NOT NULL UNIQUE IDENTITY,
	`Nom_artiste` TEXT NOT NULL,
	'Description' TEXT  NOT NULL
FOREIGN KEY(`Id_artiste`) REFERENCES `Music`(`Id_artiste`)
);

INSERT INTO Artiste (Nom_artiste, Description) VALUES ('Denga', 'TEST')

/* CREATE TABLE IF NOT EXISTS `Album` (
	`Id_album` integer primary key NOT NULL UNIQUE IDENTITY,
	`Nom_album` TEXT NOT NULL,
	`Id_artiste` INTEGER NOT NULL,
	`Date_sortie` TEXT NOT NULL,
	`Description` TEXT NOT NULL,
FOREIGN KEY(`Id_album`) REFERENCES `Music`(`Id_album`)
); */

/* Création de la table produit "Music"*/
CREATE TABLE IF NOT EXISTS `Music` (
	`Id_music` integer primary key NOT NULL UNIQUE IDENTITY,
	`Nom_music` TEXT NOT NULL,
	`Id_artiste` INTEGER NOT NULL,
	`Prix` TEXT NOT NULL,
	`Style` TEXT NOT NULL,
	`Description` TEXT NOT NULL,
FOREIGN KEY(`Id_music`) REFERENCES `Panier`(`Id_music`),
FOREIGN KEY(`Id_artiste`) REFERENCES `Album`(`Id_artiste`)
);

INSERT INTO Music (Nom_music, Id_artiste, Prix, Style, Description) VALUES ('Le Chauve', 1, '100€', 'Pop', 'TEST')

/* Création de la table "Uttilisateurs"*/
CREATE TABLE IF NOT EXISTS `Users` (
	`Id_users` integer primary key NOT NULL UNIQUE IDENTITY,
	`Nom_users` TEXT NOT NULL,
	`Password` TEXT NOT NULL,
	`Perm` TEXT NOT NULL,
FOREIGN KEY(`Id_users`) REFERENCES `Panier`(`Id_users`)
);

/* Création des tables "Panier" et "Commandes"*/
CREATE TABLE IF NOT EXISTS `Panier` (
	`Id_users` INTEGER NOT NULL,
	`Id_music` INTEGER NOT NULL,
	`QTE` INTEGER NOT NULL,
FOREIGN KEY(`Id_users`) REFERENCES `Commande`(`Id_users`)
);

CREATE TABLE IF NOT EXISTS `Commande` (
	`Id_commande` integer primary key NOT NULL UNIQUE IDENTITY,
	`Id_users` INTEGER NOT NULL,
	`Date_commande` REAL NOT NULL
);
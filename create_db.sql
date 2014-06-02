CREATE DATABASE IF NOT EXISTS `NBA`;
USE `NBA`;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `Division`;
DROP TABLE IF EXISTS `Venue`;
DROP TABLE IF EXISTS `NBATeam_BelongsTo`;
DROP TABLE IF EXISTS `NBAPlayer_PlaysFor`;
DROP TABLE IF EXISTS `NBAStaff_WorksFor`;
DROP TABLE IF EXISTS `Sponsor_Endorses`;
DROP TABLE IF EXISTS `NBAGame_Plays_PlayedAt`;
DROP TABLE IF EXISTS `NBAReferee`;
DROP TABLE IF EXISTS `Referees`;

CREATE TABLE `Division` (
    `divisionName` VARCHAR(10),
    PRIMARY KEY (`divisionName`)
);

CREATE TABLE `Venue` (
    `venueName` VARCHAR(30),
    `city` VARCHAR(30),
    `address` VARCHAR(50),
    PRIMARY KEY (`venueName`, `city`)
);

CREATE TABLE `NBATeam_BelongsTo` (
    `abbreviation` CHAR(3),
    `city` VARCHAR(30),
    `teamName` VARCHAR(30),
    `divisionName` VARCHAR(10) NOT NULL,
    PRIMARY KEY (`abbreviation`),
    FOREIGN KEY (`divisionName`) REFERENCES `Division` (`divisionName`)
);

CREATE TABLE `NBAPlayer_PlaysFor` (
    `number` INT,
    `position` CHAR(2),
    `firstName` VARCHAR(30),
    `lastName` VARCHAR(30),
    `height` INT,
    `weight` INT,
    `draftYear` YEAR(4),
    `team` CHAR(3) NOT NULL,
    PRIMARY KEY (`number`, `team`),
    FOREIGN KEY (`team`) REFERENCES `NBATeam_BelongsTo` (`abbreviation`)
        ON DELETE CASCADE
);

CREATE TABLE `NBAStaff_WorksFor` (
    `firstName` VARCHAR(30),
    `lastName` VARCHAR(30),
    `job` VARCHAR(30),
    `team` CHAR(3) NOT NULL,
    PRIMARY KEY (`firstname`, `lastname`, `team`),
    FOREIGN KEY (`team`) REFERENCES `NBATeam_BelongsTo` (`abbreviation`)
        ON DELETE CASCADE
);

CREATE TABLE `Sponsor_Endorses` (
    `company` VARCHAR(30),
    `team` CHAR(3) NOT NULL,
    PRIMARY KEY (`company`, `team`),
    FOREIGN KEY (`team`) REFERENCES `NBATeam_BelongsTo` (`abbreviation`)
        ON DELETE CASCADE
);

CREATE TABLE `NBAGame_Plays_PlayedAt` (
    `gameDate` DATE,
    `homeScore` INT,
    `awayScore` INT,
    `homeTeam` CHAR(3) NOT NULL,
    `awayTeam` CHAR(3) NOT NULL,
    `venueName` VARCHAR(30) NOT NULL,
    `city` VARCHAR(30) NOT NULL,
    PRIMARY KEY (`gameDate`, `homeTeam`, `awayTeam`),
    FOREIGN KEY (`homeTeam`) REFERENCES `NBATeam_BelongsTo` (`abbreviation`)
        ON DELETE CASCADE,
    FOREIGN KEY (`awayTeam`) REFERENCES `NBATeam_BelongsTo` (`abbreviation`)
        ON DELETE CASCADE,
    FOREIGN KEY (`venueName`, `city`) REFERENCES `Venue` (`venueName`,`city`)
);

CREATE TABLE `NBAReferee` (
    `number` INT,
    `firstName` VARCHAR(30),
    `lastName` VARCHAR(30),
    PRIMARY KEY (`number`)
);

CREATE TABLE `Referees` (
    `refNumber` INT,
    `gameDate` DATE,
    `homeTeam` CHAR(3),
    `awayTeam` CHAR(3),
    PRIMARY KEY (`refNumber`, `gameDate`, `homeTeam`, `awayTeam`),
    FOREIGN KEY (`refNumber`) REFERENCES `NBAReferee` (`number`),
    FOREIGN KEY (`gameDate`, `homeTeam`, `awayTeam`)
        REFERENCES `NBAGame_Plays_PlayedAt` (`gameDate`, `homeTeam`, `awayTeam`)
);

# Database Logical Schema Translated From ER Diagram

## Legend

- `PRIMARY KEY` = **Bold**
- `FOREIGN KEY` = *Italics*
- `PRIMARY KEY` and `FOREIGN KEY` = ***Bold Italics***

## Schemas

### Initialization

```mysql
DROP TABLE IF EXISTS `Division`;
DROP TABLE IF EXISTS `Venue`;
DROP TABLE IF EXISTS `NBATeam_BelongsTo`;
DROP TABLE IF EXISTS `NBAPlayer_PlaysFor`;
DROP TABLE IF EXISTS `NBAStaff_WorksFor`;
DROP TABLE IF EXISTS `Sponsor_Endorses`;
DROP TABLE IF EXISTS `NBAGame_Plays_PlayedAt`;
DROP TABLE IF EXISTS `NBAReferee`;
DROP TABLE IF EXISTS `Referees`;
```

### Division

Division(**divisionName**: VARCHAR(10))

```mysql
CREATE TABLE `Division` (
    `divisionName` VARCHAR(10),
    PRIMARY KEY (`divisionName`)
);
```

### Venue

Venue(**venueName**: VARCHAR(30), **city**: VARCHAR(30), address: VARCHAR(50))

```mysql
CREATE TABLE `Venue` (
    `venueName` VARCHAR(30),
    `city` VARCHAR(30),
    `address` VARCHAR(50),
    PRIMARY KEY (`venueName`, `city`)
);
```

### NBATeam_BelongsTo

NBATeam_BelongsTo(**abbreviation**: CHAR(3), city: VARCHAR(30), teamName: VARCHAR(30), *divisionName*: VARCHAR(10))

- *divisionName* `NOT NULL`
- *divisionName* `REFERENCES` Division

```mysql
CREATE TABLE `NBATeam_BelongsTo` (
    `abbreviation` CHAR(3),
    `city` VARCHAR(30),
    `teamName` VARCHAR(30),
    `divisionName` VARCHAR(10) NOT NULL,
    PRIMARY KEY (`abbreviation`),
    FOREIGN KEY (`divisionName`) REFERENCES `Division` (`divisionName`)
);
```

### NBAPlayer_PlaysFor

NBAPlayer_PlaysFor(**number**: INT, position: CHAR(2), firstName: VARCHAR(30), lastName: VARCHAR(30), height: INT, weight: INT, draftDate: DATE, ***team***: CHAR(3))

- ***team*** `NOT NULL`
- ***team*** `REFERENCES` NBATeam_BelongsTo(**abbreviation**) `ON DELETE CASCADE`
- height in inches
- weight in pounds

```mysql
CREATE TABLE `NBAPlayer_PlaysFor` (
    `number` INT,
    `position` CHAR(2),
    `firstName` VARCHAR(30),
    `lastName` VARCHAR(30),
    `height` INT,
    `weight` INT,
    `draftDate` DATE,
    `team` CHAR(3) NOT NULL,
    PRIMARY KEY (`number`, `team`),
    FOREIGN KEY (`team`) REFERENCES `NBATeam_BelongsTo` (`abbreviation`)
        ON DELETE CASCADE
);
```

### NBAStaff_WorksFor

NBAStaff_WorksFor(**firstName**: VARCHAR(30), **lastName**: VARCHAR(30), job: VARCHAR(30), ***team***: CHAR(3))

- ***team*** `NOT NULL`
- ***team*** `REFERENCES` NBATeam_BelongsTo(**abbreviation**) `ON DELETE CASCADE`

```mysql
CREATE TABLE `NBAStaff_WorksFor` (
    `firstName` VARCHAR(30),
    `lastName` VARCHAR(30),
    `job` VARCHAR(30),
    `team` CHAR(3) NOT NULL,
    PRIMARY KEY (`firstname`, `lastname`, `team`),
    FOREIGN KEY (`team`) REFERENCES `NBATeam_BelongsTo` (`abbreviation`)
        ON DELETE CASCADE
);
```

### Sponsor_Endorses

Sponsor_Endorses(**company**: VARCHAR(30), ***team***: CHAR(3))

- ***team*** `NOT NULL`
- ***team*** `REFERENCES` NBATeam_BelongsTo(**abbreviation**) `ON DELETE CASCADE`

```mysql
CREATE TABLE `Sponsor_Endorses` (
    `company` VARCHAR(30),
    `team` CHAR(3) NOT NULL,
    PRIMARY KEY (`company`, `team`),
    FOREIGN KEY (`team`) REFERENCES `NBATeam_BelongsTo` (`abbreviation`)
        ON DELETE CASCADE
);
```

### NBAGame_Plays_PlayedAt

NBAGame_Plays_PlayedAt(**gameDate**: DATE, homeScore: INT, awayScore: INT, ***homeTeam***: CHAR(3), ***awayTeam***: CHAR(3), *venueName*: VARCHAR(30), *city*: VARCHAR(30))

- ***homeTeam*** `NOT NULL`
- ***awayTeam*** `NOT NULL`
- *venueName* `NOT NULL`
- *city* `NOT NULL`
- ***homeTeam*** `REFERENCES` NBATeam_BelongsTo(**abbreviation**) `ON DELETE CASCADE`
- ***awayTeam*** `REFERENCES` NBATeam_BelongsTo(**abbreviation**) `ON DELETE CASCADE`
- *venueName* `REFERENCES` Venue
- *city* `REFERENCES` Venue

```mysql
CREATE TABLE `NBAGame_PlaysAt` (
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
```

### NBAReferee

NBAReferee(**number**: INT, firstName: VARCHAR(30), lastName: VARCHAR(30))

```mysql
CREATE TABLE `NBAReferee` (
    `number` INT,
    `firstName` VARCHAR(30),
    `lastName` VARCHAR(30),
    PRIMARY KEY (`number`)
);
```

### Referees

Referees(***refNumber***: INT, **gameDate**: DATE, **homeTeam**: CHAR(3), **awayTeam**: CHAR(3))

- ***refNumber*** `REFERENCES` NBAReferee(**number**)
- **gameDate** `REFERENCES` NBAGame_Plays_PlayedAt(**gameDate**)
- **homeTeam** `REFERENCES` NBAGame_Plays_PlayedAt(***homeTeam***)
- **awayTeam** `REFERENCES` NBAGame_Plays_PlayedAt(***awayTeam***)

```mysql
CREATE TABLE `Referees` (
    `refNumber` INT,
    `gameDate` DATE,
    `homeTeam` CHAR(3),
    `awayTeam` CHAR(3),
    PRIMARY KEY (`refNumber`, `gameDate`, `homeTeam`, `awayTeam`),
    FOREIGN KEY (`refNumber`) REFERENCES `NBAReferee` (`number`),
    FOREIGN KEY (`gameDate`) REFERENCES `NBAGame_Plays_PlayedAt` (`gameDate`),
    FOREIGN KEY (`homeTeam`) REFERENCES `NBAGame_Plays_PlayedAt` (`abbreviation`),
    FOREIGN KEY (`awayTeam`) REFERENCES `NBAGame_Plays_PlayedAt` (`abbreviation`)
);
```

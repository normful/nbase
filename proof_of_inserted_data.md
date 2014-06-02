# SQL commands for creating database and tables

```sqlmysql
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
```

# SQL commands for inserting data

```sqlmysql
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/Division.txt' 
    INTO TABLE nba.division
    IGNORE 1 LINES;
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/NBAGame_Plays_PlayedAt.txt'
    INTO TABLE nba.nbagame_plays_playedat
    IGNORE 1 LINES;
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/NBAPlayer_PlaysFor.txt'
    INTO TABLE nba.nbaplayer_playsfor
    IGNORE 1 LINES;
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/NBAReferee.txt'
    INTO TABLE nba.nbareferee
    IGNORE 1 LINES;
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/NBAStaff_WorksFor.txt'
    INTO TABLE nba.nbastaff_worksfor
    IGNORE 1 LINES;
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/NBATeam_BelongsTo.txt'
    INTO TABLE nba.nbateam_belongsto
    IGNORE 1 LINES;
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/Referees.txt'
    INTO TABLE nba.referees
    IGNORE 1 LINES;
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/Sponsor_Endorses.txt'
    INTO TABLE nba.sponsor_endorses
    IGNORE 1 LINES;
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/Venue.txt'
    INTO TABLE nba.venue
    IGNORE 1 LINES;
```

# Proof that data is stored correctly


\begingroup
\fontsize{8pt}{8pt}\selectfont
\begin{verbatim}  
mysql> show tables;
+------------------------+
| Tables_in_nba          |
+------------------------+
| division               |
| nbagame_plays_playedat |
| nbaplayer_playsfor     |
| nbareferee             |
| nbastaff_worksfor      |
| nbateam_belongsto      |
| referees               |
| sponsor_endorses       |
| venue                  |
+------------------------+
9 rows in set (0.00 sec)

mysql> select * from division;
+--------------+
| divisionName |
+--------------+
| Atlantic     |
| Central      |
| Northwest    |
| Pacific      |
| Southeast    |
| Southwest    |
+--------------+
6 rows in set (0.00 sec)

mysql> select * from nbagame_plays_playedat;
+------------+-----------+-----------+----------+----------+--------------------------+-------------------+
| gameDate   | homeScore | awayScore | homeTeam | awayTeam | venueName                | city              |
+------------+-----------+-----------+----------+----------+--------------------------+-------------------+
| 2014-04-20 |        90 |        85 | SAS      | DAL      | AT&T Center              | San Antonio, TX   |
| 2014-05-06 |       116 |        92 | SAS      | POR      | AT&T Center              | San Antonio, TX   |
| 2014-05-07 |       105 |       122 | OKC      | LAC      | Cheasapeake Energy Arena | Oklahoma City, OK |
| 2014-05-10 |       103 |       118 | POR      | SAS      | Moda Center              | Portland, OR      |
| 2014-05-11 |       104 |       105 | LAC      | OKC      | Staples Center           | Los Angeles, CA   |
+------------+-----------+-----------+----------+----------+--------------------------+-------------------+
5 rows in set (0.00 sec)

mysql> select * from nbaplayer_playsfor;
+--------+----------+-----------+----------+--------+--------+-----------+------+
| number | position | firstName | lastName | height | weight | draftYear | team |
+--------+----------+-----------+----------+--------+--------+-----------+------+
|     12 | C        | Steven    | Adams    |     84 |    255 |      2013 | OKC  |
|     12 | PF       | LaMarcus  | Aldridge |     83 |    240 |      2009 | POR  |
|     21 | PF       | Tim       | Duncan   |     83 |    250 |      1997 | SAS  |
|     22 | SF       | Matt      | Barnes   |     79 |    226 |      2012 | LAC  |
|     41 | PF       | Dirk      | Nowitzki |     84 |    237 |      1998 | DAL  |
+--------+----------+-----------+----------+--------+--------+-----------+------+
5 rows in set (0.00 sec)

mysql> select * from nbareferee;
+--------+-----------+-----------+
| number | firstName | lastName  |
+--------+-----------+-----------+
|     10 | Ron       | Garretson |
|     12 | Violet    | Palmer    |
|     13 | Monty     | McCutchen |
|     15 | Bennett   | Salvatore |
|     17 | Joe       | Crawford  |
|     27 | Dick      | Bavetta   |
|     28 | Zach      | Zarba     |
|     32 | Eddie     | Rush      |
|     40 | Leon      | Wood      |
+--------+-----------+-----------+
9 rows in set (0.00 sec)

mysql> select * from nbastaff_worksfor;
+-----------+----------+-----------------+------+
| firstName | lastName | job             | team |
+-----------+----------+-----------------+------+
| Alvin     | Gentry   | Assistant Coach | LAC  |
| Gregg     | Popovich | Head Coach      | SAS  |
| Jay       | Triano   | Assistant Coach | POR  |
| Rick      | Carlisle | Head Coach      | DAL  |
| Scott     | Brooks   | Head Coach      | OKC  |
+-----------+----------+-----------------+------+
5 rows in set (0.00 sec)

mysql> select * from nbateam_belongsto;
+--------------+-------------------+-----------+--------------+
| abbreviation | city              | teamName  | divisionName |
+--------------+-------------------+-----------+--------------+
| DAL          | Dallas, TX        | Mavericks | Southwest    |
| LAC          | Los Angeles, CA   | Clippers  | Pacific      |
| OKC          | Oklahoma City, OK | Thunder   | Northwest    |
| POR          | Portland, OR      | Blazers   | Northwest    |
| SAS          | San Antonio, TX   | Spurs     | Southwest    |
+--------------+-------------------+-----------+--------------+
5 rows in set (0.00 sec)

mysql> select * from referees;
+-----------+------------+----------+----------+
| refNumber | gameDate   | homeTeam | awayTeam |
+-----------+------------+----------+----------+
|        10 | 2014-04-20 | SAS      | DAL      |
|        40 | 2014-04-20 | SAS      | DAL      |
|        10 | 2014-05-06 | SAS      | POR      |
|        12 | 2014-05-06 | SAS      | POR      |
|        13 | 2014-05-07 | OKC      | LAC      |
|        15 | 2014-05-07 | OKC      | LAC      |
|        17 | 2014-05-10 | POR      | SAS      |
|        27 | 2014-05-10 | POR      | SAS      |
|        28 | 2014-05-11 | LAC      | OKC      |
|        32 | 2014-05-11 | LAC      | OKC      |
+-----------+------------+----------+----------+
10 rows in set (0.00 sec)

mysql> select * from sponsor_endorses;
+--------------------------+------+
| company                  | team |
+--------------------------+------+
| AMERICAN AIRLINES        | DAL  |
| ANHEUSER-BUSCH           | DAL  |
| AT&T                     | DAL  |
| AUDI                     | DAL  |
| COCA-COLA                | DAL  |
| DR PEPPER SNAPPLE GROUP  | DAL  |
| MILLERCOORS              | DAL  |
| PLAINS CAPITAL BANK      | DAL  |
| TEXAS FORD DEALERS       | DAL  |
| TXU                      | DAL  |
| DODGE                    | LAC  |
| KIA                      | LAC  |
| MERCEDEZ BENZ            | LAC  |
| STATE FARM INSURANCE     | LAC  |
| CHESAPEAKE ENERGY        | OKC  |
| DEVON ENERGY             | OKC  |
| HERTZ                    | OKC  |
| LOVE'S COUNTRY'S         | OKC  |
| MIDFIRST BANK            | OKC  |
| RIVERWIND CASINO         | OKC  |
| SANDRIDGE ENERGY         | OKC  |
| COMCAST                  | POR  |
| KIA                      | POR  |
| NORTHWEST FORD STORES    | POR  |
| SPIRIT MOUNTAIN CASINO   | POR  |
| WELLS FARGO              | POR  |
| BROWN AUTO GROUP         | SAS  |
| H-E-B                    | SAS  |
| SILVER EAGLE DISTRIBUTOR | SAS  |
| SWBC                     | SAS  |
| USAA                     | SAS  |
| VALERO                   | SAS  |
+--------------------------+------+
32 rows in set (0.00 sec)

mysql> select * from venue;
+--------------------------+-------------------+-------------------------+
| venueName                | city              | address                 |
+--------------------------+-------------------+-------------------------+
| American Airlines Center | Dallas, TX        | 2500 Victory Avenue     |
| AT&T Center              | San Antonio, TX   | 1 AT&T Center Parkway   |
| Chesapeake Energy Arena  | Oklahoma City, OK | 100 West Reno Avenue    |
| Moda Center              | Portland, OR      | 1 Center Court          |
| Staples Center           | Los Angeles, CA   | 1111 S. Figueroa Street |
+--------------------------+-------------------+-------------------------+
5 rows in set (0.00 sec)
\end{verbatim}  
\endgroup

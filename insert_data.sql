LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/Division.txt' 
    INTO TABLE nbatest1.division
    IGNORE 1 LINES;
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/NBAGame_Plays_PlayedAt.txt'
    INTO TABLE nbatest1.nbagame_plays_playedat
    IGNORE 1 LINES;
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/NBAPlayer_PlaysFor.txt'
    INTO TABLE nbatest1.nbaplayer_playsfor
    IGNORE 1 LINES;
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/NBAReferee.txt'
    INTO TABLE nbatest1.nbareferee
    IGNORE 1 LINES;
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/NBAStaff_WorksFor.txt'
    INTO TABLE nbatest1.nbastaff_worksfor
    IGNORE 1 LINES;
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/NBATeam_BelongsTo.txt'
    INTO TABLE nbatest1.nbateam_belongsto
    IGNORE 1 LINES;
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/Referees.txt'
    INTO TABLE nbatest1.referees
    IGNORE 1 LINES;
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/Sponsor_Endorses.txt'
    INTO TABLE nbatest1.sponsor_endorses
    IGNORE 1 LINES;
LOAD DATA INFILE '/opt/bitnami/apache2/cpsc304/data/Venue.txt'
    INTO TABLE nbatest1.venue
    IGNORE 1 LINES;

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

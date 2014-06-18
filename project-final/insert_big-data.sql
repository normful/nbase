LOAD DATA INFILE '/home/project/cpsc304/data/big-data/Division.txt' 
    INTO TABLE nba.division
    IGNORE 1 LINES;
LOAD DATA INFILE '/home/project/cpsc304/data/big-data/Venue.txt'
    INTO TABLE nba.venue
    IGNORE 1 LINES;
LOAD DATA INFILE '/home/project/cpsc304/data/big-data/NBATeam_BelongsTo.txt'
    INTO TABLE nba.nbateam_belongsto
    IGNORE 1 LINES;
LOAD DATA INFILE '/home/project/cpsc304/data/big-data/NBAPlayer_PlaysFor.txt'
    INTO TABLE nba.nbaplayer_playsfor
    IGNORE 1 LINES;
LOAD DATA INFILE '/home/project/cpsc304/data/big-data/NBAStaff_WorksFor.txt'
    INTO TABLE nba.nbastaff_worksfor
    IGNORE 1 LINES;
LOAD DATA INFILE '/home/project/cpsc304/data/big-data/Sponsor_Endorses.txt'
    INTO TABLE nba.sponsor_endorses
    IGNORE 1 LINES;
LOAD DATA INFILE '/home/project/cpsc304/data/big-data/NBAGame_Plays_PlayedAt.txt'
    INTO TABLE nba.nbagame_plays_playedat
    IGNORE 1 LINES;
LOAD DATA INFILE '/home/project/cpsc304/data/big-data/NBAReferee.txt'
    INTO TABLE nba.nbareferee
    IGNORE 1 LINES;
LOAD DATA INFILE '/home/project/cpsc304/data/big-data/Referees.txt'
    INTO TABLE nba.referees
    IGNORE 1 LINES;

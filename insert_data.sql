LOAD DATA INFILE './data/Division.txt' 
    INTO TABLE nbatest1.division
    IGNORE 1 LINES;
LOAD DATA INFILE './data/NBAGame_Plays_PlayedAt.txt'
    INTO TABLE nbatest1.nbagame_plays_playedat
    IGNORE 1 LINES;
LOAD DATA INFILE './data/NBAPlayer_PlaysFor.txt'
    INTO TABLE nbatest1.nbaplayer_playsfor
    IGNORE 1 LINES;
LOAD DATA INFILE './data/NBAReferee.txt'
    INTO TABLE nbatest1.nbareferee
    IGNORE 1 LINES;
LOAD DATA INFILE './data/NBAStaff_WorksFor.txt'
    INTO TABLE nbatest1.nbastaff_worksfor
    IGNORE 1 LINES;
LOAD DATA INFILE './data/NBATeam_BelongsTo.txt'
    INTO TABLE nbatest1.nbateam_belongsto
    IGNORE 1 LINES;
LOAD DATA INFILE './data/Referees.txt'
    INTO TABLE nbatest1.referees
    IGNORE 1 LINES;
LOAD DATA INFILE './data/Sponsor_Endorses.txt'
    INTO TABLE nbatest1.sponsor_endorses
    IGNORE 1 LINES;
LOAD DATA INFILE './data/Venue.txt'
    INTO TABLE nbatest1.venue
    IGNORE 1 LINES;

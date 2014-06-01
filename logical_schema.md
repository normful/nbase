# Database Logical Schema Translated From ER Diagram

## Legend

- `PRIMARY KEY` = **Bold**
- `FOREIGN KEY` = *Italics*
- `PRIMARY KEY` and `FOREIGN KEY` = ***Bold Italics***

## Schemas

- NBAPlayer_PlaysFor(**number**, position, firstName, lastName, height, weight, draftDate, ***team***)
    - ***team*** `REFERENCES` NBATeam_BelongsTo(**abbreviation**)

- NBAStaff_WorksFor(**firstName**, **lastName**, job, ***team***)
    - ***team*** `REFERENCES` NBATeam_BelongsTo(**abbreviation**)

- NBATeam_BelongsTo(**abbreviation**, city, teamName, *divisionName*)
	- *divisionName* `NOT NULL`
    - *divisionName* `REFERENCES` Division

- Division(**divisionName**)

- Sponsor_Endorses(**company**, ***team***)
    - ***team*** `REFERENCES` NBATeam_BelongsTo(**abbreviation**)

- NBAGame_Plays_PlayedAt(**gameDate**, homeScore, awayScore, ***homeTeam***, ***awayTeam***,  
    *venueName*, *city*)
	- ***homeTeam*** `REFERENCES` NBATeam_BelongsTo(**abbreviation**)
	- ***awayTeam*** `REFERENCES` NBATeam_BelongsTo(**abbreviation**)
    - *venueName* `NOT NULL`
	- *venueName* `REFERENCES` Venue
    - *city* `NOT NULL`
    - *city* `REFERENCES` Venue

- Venue(**venueName**, **city**, address)

- NBAReferee(**number**, firstName, lastName)

- Referees(***refNumber***, **gameDate**, **homeTeam**, **awayTeam**)
	- ***refNumber*** `REFERENCES` NBAReferee(**number**)

TODO: attr1: domain1, attr2: domain2 ...

# Functional Dependencies

## NBAPlayer_PlaysFor
* number, team -> firstName, lastName, position, height, weight, draftYear

## NBAStaff_WorksFor
* lastName, firstName, team -> job

## NBATeam_BelongsTo
* abbreviation -> city, teamName, divisionName
* teamName -> abbreviation, city, divisionName

## NBAGame_Plays_PlayedAt
* gameDate, homeTeam, awayTeam -> homeScore, awayScore, venueName, city 
* venueName, city, gameDate -> homeTeam, awayTeam, homeScore, awayScore

## Sponsor_Endorses
* *no non-trivial functional dependencies*

## Division
* *no non-trivial functional dependencies*

## NBAReferee
* number -> firstName, lastName

## Referees
* *no non-trivial functional dependencies*

## Venue
* venueName, city -> address
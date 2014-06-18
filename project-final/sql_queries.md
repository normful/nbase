# SQL Queries
Note that these are only example queries. The attributes in the SELECT clauses and the conditions in the WHERE clauses may vary depending on the user's input.


## Selection and Projection Queries
Location: players.php

```
SELECT lastName, firstName, position, number, height, weight, draftYear, team
FROM NBAPlayer_PlaysFor
WHERE height > 80
ORDER BY lastName;
```

## Join Queries
Location: games.php

```
SELECT *
FROM NBAGame_Plays_PlayedAt NPP, NBAReferee NR, Referees R
WHERE NR.number = R.refNumber AND 
	  R.gameDate = NPP.gameDate AND 
	  R.homeTeam = NPP.homeTeam AND 
	  R.awayTeam = NPP.awayTeam
ORDER BY npp.gameDate
```

## Division Query
Location: venues.php

```
SELECT *
FROM NBATeam_BelongsTo T
WHERE NOT EXISTS
	(SELECT V.venueName
	FROM Venue V
	WHERE NOT EXISTS
		(SELECT DISTINCT G.venueName
		FROM NBAGame_Plays_PlayedAt G
		WHERE V.venueName = G.venueName AND
      			(G.homeTeam = T.abbreviation OR G.awayTeam = T.abbreviation)))
```

## Aggregation Query
Location: stats.php

```
SELECT MAX(weight) as result
FROM NBAPlayer_PlaysFor
```

## Nested Aggregation with Group-By Query
Location: stats.php

```
SELECT team, AVG(draftYear) as result
FROM NBAPlayer_PlaysFor
WHERE team IN
	(SELECT abbreviation
	FROM NBATeam_BelongsTo N, Sponsor_Endorses S
	WHERE N.abbreviation = S.team AND S.company = 'Mercedes Benz')
GROUP BY team
```

## Delete Operation
Location: delete_team.php

```
DELETE FROM NBATeam_BelongsTo
WHERE abbreviation = 'TOR'
```
Location: delete_player.php

```
DELETE FROM NBAPlayer_PlaysFor
WHERE team = 'DAL' AND number = 41
```

## Update Operation
Location: update.php

```
UPDATE NBAPlayer_PlaysFor
SET	firstName = 'LeBron',
	lastName = 'James',
	team = 'MIA',
	number = 6,
	position = SF,
	weight = 250,
	height = 80,
	draftYear = 2003
WHERE team = 'CLE' AND number = 23;
```

## Other Queries

There are miscellaneous queries that were used in the project that were not explicitly required.

Location: venues.php

```
INSERT INTO Venue
VALUES('Rogers Arena', 'Vancouver', '800 Griffiths Way')
```
Location: rosters.php

```
SELECT *
FROM NBAPlayer_PlaysFor
WHERE team = 'TOR';

SELECT *
FROM NBAStaff_WorksFor
WHERE team = 'TOR'
ORDER BY job DESC;

SELECT company
FROM NBATeam_BelongsTo N, Sponsor_Endorses S 
WHERE N.abbreviation = S.team AND team = 'TOR';
```
Location: teams.php

```
SELECT city, abbreviation, teamName, divisionName
FROM NBATeam_BelongsTo
```
Location: update.php

```
SELECT firstName, lastName, number, team
FROM NBAPlayer_PlaysFor
ORDER BY firstName, lastName;

SELECT *
FROM NBATeam_BelongsTo;

SELECT *
FROM NBAPlayer_PlaysFor
WHERE number = 0 AND team = 'DAL';

SELECT *
FROM NBATeam_BelongsTo
WHERE abbreviation = 'DAL';
```
Location: forms/rosters_select.php

```
SELECT abbreviation, teamName, city
FROM NBATeam_BelongsTo
```
Location: forms/stats_team.php

```
SELECT DISTINCT company
FROM Sponsor_Endorses
```
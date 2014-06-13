# CPSC 304 Database Project Description

## Domain

We will model the 2013-2014 NBA league. 

## Domain aspects modeled

We are modelling NBA players that play for Teams, along with NBA Staff that work for Teams. Each Team belongs to a division. Each Team plays a game refereed by an NBA Referee against another Team at a Venue on a particular date. Each Team's Sponsor is also modeled.

User classes include NBA Staff and normal users. Only NBA Staff can modify database information. All other users can only view database information.

## Entity-Relationship diagram

An updated copy of our [ER diagram](http://www.gliffy.com/go/publish/5784240) is attached, which incorporates all TA feedback from the first submission, and includes various minor modifications.

## Translation from ER diagram to SQL tables

All tables are in BCNF because there are no functional dependencies in our SQL tables.

TODO: Add note on whether your tables fully capture your ER diagram

## Platform

- Amazon EC2 virtual server running Ubuntu 12.04.4 LTS
- Apache HTTP Server 2.4
- MySQL 5.5.36
- PHP 5.4.26 (with the PDO extension)

## How we are meeting the marking requirements

### Selection and projection query

`players.php` allows a selection constant to be chosen when searching for players.

### Join query

`games.php` joins the `NBAGame_Plays_PlayedAt`, `NBAReferee`, `Referees`, and `Venue` tables.

### Division query

Potential options:

1. Find teams who have played against all other teams.
2. Find teams who have played at all venues.

TODO: Jacob will think about this later.

### Aggregation query

`stats.php`

### Nested aggregation with group-by

For each team sponsored by a particular company (selected from a dropdown box with all possible sponsoring companies), list the AGGOP=(MAX | MIN | AVG) attribute=(height | weight) of the players on that team.

```sql
SELECT team, AGGOP(attribute)
FROM Players, Team
WHERE team IN (SELECT team
               FROM Sponsor_Endorses
               WHERE company = 'selectedDropdownBox')
GROUP BY team
```

### Delete operation

Requirements from checklist:

1. deletion causing cascades
2. deletion without cascades

### Update operation


### Graphical user interface


### Extra features

?







## System functionality

TODO: Revise this entire section to match what we actually implement.

We will create two different user interfaces: one for normal users; one for NBA Staff. However, we will not be spending time implementing access control and user accounts. Instead, all users will be able to access both interfaces.

All users will be able to access an interface that allows them to:

- Query the database using a Division name and receive a list of all NBA Team within that Division.

- Click on a NBA Team from a list of NBA Teams and be shown a display that includes:

    - a list of all NBA Players on that NBA Team
    - a list of all Sponsors on that NBA Team
    - a summary of all NBA Games that that NBA Team has played in this season

- Click on a NBA Player from a list of NBA Players and receive a display of all his attributes.

- Query the database using a NBA Player's name and receive a display of all his attributes.

- Query the database using a city name and receive a list of all Venues in that city.

- Query the database for a list of all Venues.

- Click on a Venue from a list of Venues and receive a list of all NBA Games played at that Venue.

- Click on a NBA Game from a list of NBA Games and receive a display all information about that game.

- Query the database for a list of NBA Games played before a date, after a date, or within a date range.

- Query the database using a NBA Referee's name and receive a list of all games he refereed.

- Query the database for all NBA Players who are above a height, below a height, or within a height range.

In addition to the above, the interface for NBA Staff will also provide the ability to:

- Delete NBA Player and NBA Staff when they are fired.
- Update the database to add results from a new NBA Game.
- Update the database to add a new NBA Player to an NBA Team.


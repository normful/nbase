# CPSC 304 Database Project Description

## Domain

We will model the 2013-2014 NBA league. 

## Domain aspects modeled

We are modelling NBA players that play for Teams, along with NBA Staff that work for Teams. Each Team belongs to a division. Each Team plays a game refereed by an NBA Referee against another Team at a Venue on a particular date. Each Team's Sponsor is also modeled.

User classes include NBA Staff and normal users. Only NBA Staff can modify database information. All other users can only view database information.

## Entity-Relationship diagram

An updated copy of our [ER diagram](http://www.gliffy.com/go/publish/5784240) is attached, which incorporates all TA feedback from the first submission, and includes various minor modifications.

## Platform

- Amazon EC2 virtual server running Ubuntu 12.04.4 LTS
- Apache 2.4
- MySQL 5.5.36
- PHP 5.4.26 (with the PDO extension)
- AngularJS (potentially; still not confirmed)

## System functionality

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

## Division of Labour

### Marvin Cadano

- populate the NBAGame_Plays_PlayedAt table
- populate the Referees table
- write PHP queries and GUI for these functionalites:
    - Click on a NBA Player from a list of NBA Players and receive a display of all his attributes.
    - Query the database using a NBA Player's name and receive a display of all his attributes.
    - Query the database for all NBA Players who are above a height, below a height, or within a height range.
    - Update the database to add a new NBA Player to an NBA Team.

### Jacob Lee

- populate the NBATeam_BelongsTo table
- populate the Sponsor_Endorses table
- write PHP queries and GUI for these functionalites:
    - Query the database using a Division name and receive a list of all NBA Team within that Division.
    - Click on a NBA Team from a list of NBA Teams and be shown a display that includes:
        - a list of all NBA Players on that NBA Team
        - a list of all Sponsors on that NBA Team
        - a summary of all NBA Games that that NBA Team has played in this season

### Daniel Tsang

- populate the NBAPlayer_PlaysFor table
- populate the NBAReferee table
- write PHP queries and GUI for these functionalites:
    - Query the database using a NBA Referee's name and receive a list of all games he refereed.
    - Click on a NBA Game from a list of NBA Games and receive a display all information about that game.
    - Query the database for a list of NBA Games played before a date, after a date, or within a date range.
    - Update the database to add results from a new NBA Game.

### Norman Sue

- populate the NBAStaff_WorksFor table
- populate the Venue table
- write PHP queries and GUI for these functionalites:
    - Query the database using a city name and receive a list of all Venues in that city.
    - Query the database for a list of all Venues.
    - Delete NBA Player and NBA Staff when they are fired.
    - Click on a Venue from a list of Venues and receive a list of all NBA Games played at that Venue.

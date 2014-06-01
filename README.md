# CPSC 304 Database Project

## Project Description

### Domain

We will model the 2013-2014 NBA league. 

### Domain aspects modeled

We are modelling NBA players that play for Teams, along with NBA Staff that work for Teams. Each Team belongs to a division. Each Team plays a game refereed by an NBA Referee against another Team at a Venue on a particular date. Each Team's Sponsor is also modeled.

User classes include NBA Staff and normal users. Only NBA Staff can modify database information. All other users can only view database information.

### System functionality

NBA Staff and normal users will be able to:

- Look up NBA Player information.
- Search for all NBA Players on a NBA Team.
- Search for all NBA Players in a particlar Division.
- Search for all NBA Teams in a particular Division.
- Search for all NBA Games played at a particular Venue.
- Search for all NBA Games played before or after a certain date.
- Search for all NBA Games refereed by a particular NBA Referee.
- Search for all Sponsors for a particular NBA Team.
- Be able to filter NBA Players that fit certain criteria (e.g. players who are at least 6'6" tall).

Only NBA Staff will be able to:

- Be able to delete NBA Player and NBA Staff when they are fired.

### Platform

- Amazon EC2 virtual server running Ubuntu 12.04.4 LTS
- Apache 2.4
- MySQL 5.5.36
- PHP 5.4.26 (with the PDO extension)

## Entity-Relationship diagram

Gliffy ER diagram http://www.gliffy.com/go/publish/5784240

## Team members

- Marvin Cadano
- Jacob Lee
- Daniel Tsang
- Norman Sue

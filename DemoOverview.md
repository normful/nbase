## Project Demo Overview
*times for each section are approximate*

### Before the demo

* For Norman: Print 3 copies of `project-final-report` which should contain:
    - ER diagram
    - relation instances (table of data)
    - SQL for all queries used in demo
    - SQL for creating tables
- For Norman: Have windows on your laptop open with:
    - Amazon EC2 dashboard
    - Apache HTTP Server config file: `/opt/bitnami/apache2/conf/httpd.cnf`
    - Apache HTTP Server config file: `/opt/bitnami/apache2/conf/bitnami/bitnami.cnf`
    - MySQL config file: `/opt/bitnami/mysql/my.cnf`
    - Terminal to restart `apache` and/or `mysql` with commands:

        sudo bash ctlscript.sh restart apache
        sudo bash ctlscript.sh restart mysql

### Setup (2 minutes)

* Run scripts to create and populate database
  * Show TA database instances before and after

### Selection and Projection Query (2 minutes)

* Navigate to **Players** page
  1. From the **Filter Results** menu, specify a selection constraint (any is fine)
  2. Repeat the previous step with a different selection constraint
    * Demonstrate type checking on user input (i.e. input must be a number >= 0)
  3. *Optional*: Order the results by some attribute in the **Order Results** menu
  4. Choose some attributes to display in the **Display Attributes** menu

### Join Query (2 minutes)

* Navigate to **Games** page
  1. Show TA that data has been joined from 4 tables: `nbagame_plays_playedat`, `nbareferee`, and `referees`
  2. If necessary to show a second example, navigate to **Rosters** page and show the list of sponsors for any team
    * This query joins data from 2 tables: `nbateam_belongsto` and `sponsor_endorses`

### Division Query (2 minutes)

* Navigate to **Venues** page
  1. Show TA *Teams that have played at all venues* section (and explain how this is a divison query if necessary)
  2. Add a new venue under the **Add a Venue** menu
  3. Return to **Venues** page, show TA that there are no longer any teams under the *Teams that have played at all venues* section

### Aggregation Query (2 minutes)

* Navigate to **Stats** page
  1. From the **League-Wide** menu, choose an aggregate operator and an attribute
    * Show that this result is consistent with our relation instance
  2. Repeat the previous step with a different operator and attribute
    * Show that this result is consistent with our relation instance


### Nested Aggregation with Group By (2 minutes)

* While still on the **Stats** page
  1. Show TA nested aggregation query on printout
  2. From the **Team-Wide** menu, choose an aggregate operator, an attribute, and a sponsor
    * Show that the results are consistent with our relation instances
  3. Repeat the previous step with different parameters
    * Show that the results are consistent with our relation instances

### Delete Operation (4 minutes)

* Navigate to **Teams** page
  1. Explain the constraints for our tables
    * Deleting a team should delete all players and games that reference that team (`ON DELETE CASCADE`)
    * Cannot delete a game that is referenced by the referees table (`ON DELETE NO ACTION`)
      * Deleting a team should fail if a game has at least one referee
  2. Delete a team that participates in a game with a referee
    * Show that this deletion fails (e.g. show that the team still exists and/or any players & games associated with that team still exist)
    * Show that error message is located in popup box
  3. Delete a team that only participates in games without referees
    * Show that this deletion succeeds (e.g. show that the team is gone from **Teams** page and that there are no players on the **Players** page with that team)

* Navigate to **Players** page
  1. Delete a player from the table (deletion without cascade)

### Update Operation (2 minutes)

* Navigate to **Edit** page
  1. Choose any player to edit
  2. Attempt to change that player's draft year to a year that is greater than the current year
    * Show TA that this update is rejected since it violates a constraint
    * Show that error message is located in popup box
  3. Reattempt to change that player's draft year to a valid year
    * Show that this update succeeded (e.g. navigate to **Players** page and show the player with new draft year)
  4. Show additional type checking for the update form
    * First and Last names must have only alphabet characters and have length >= 1
    * Position is selected from dropdown menu
    * Number must be numeric and have value: 0 <= value <= 99
      * Note: Could also attempt to update player number to a number that already exists on that team (violates primary key constraint)
    * Height must be numeric with value >= 0
    * Weight must be numeric with value >= 0
    * Draft year must be numeric with 1946 <= value <= currentYear
    * Team is selected from dropdown

### Extra Features (2 minutes)

* Navigate to **Players page**
  1. Click on any player from list of players
  2. Show that the page displays unique information from the database about that player
  3. Explain that the profile picture is dynamically retrieved from Google images
  4. Explain that the latest news for each player is dynamically retrieved from Google news
  5. Show the profile page of another (one or more) players
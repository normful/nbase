<?php

require "header.php";

// any functions you write should go in functions.php unless they are highly specific to what you're doing in this file
require "functions.php";

try {
    // connect to the Amazon EC2 MySQL database with PDO
    $dbh = new PDO("mysql:host=54.86.9.29;dbname=nba", 'jacob', 'jacob');
} catch(PDOException $e) {
    // use the error() function I wrote whenever you want to signal that an error has occured
    error($e->getMessage());
    exit();
}

/*
IMPORTANT:
If you allow user input into the database, make sure you sanitize your inputs before inserting them into the query.
For more information, look up prepared statements or how to escape inputs with PDO (the quote() function is OK but not ideal).
This is more of a concern for real world projects (so you should know it anyway), but I'm not sure if the TAs will care.
*/

// Find all venues
$venuesQuery = <<<SQL
SELECT venueName, city, address
FROM venue
SQL;

$venuesResult = $dbh->query($venuesQuery);
$venuesResult->setFetchMode(PDO::FETCH_ASSOC);

// Find all teams that have played at all venues
$teamsQuery = <<<SQL
SELECT *
FROM nbateam_belongsto T
WHERE NOT EXISTS
(SELECT V.venueName
		FROM venue V
        WHERE NOT EXISTS
(SELECT DISTINCT G.venueName
FROM nbagame_plays_playedat G
WHERE V.venueName = G.venueName AND
      (G.homeTeam = T.abbreviation OR G.awayTeam = T.abbreviation)))
SQL;

$teamsResult = $dbh->query($teamsQuery);
$teamsResult->setFetchMode(PDO::FETCH_ASSOC);

?>

<!-- CONTENT -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Venues</h1>

    <div class="table-responsive">
        <table class="table table-striped table-hover hoverTable">
            <thead>
                <tr>
                    <th>Venue Name</th>
                    <th>City</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $venuesResult->fetch()): ?>
                    <tr>
                        <td><?php echo $row['venueName']?></td>
                        <td><?php echo $row['city']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <h2>Teams that have played at all venues</h2>

    <div class="table-responsive">
        <table class="table table-striped table-hover hoverTable">
            <thead>
                <tr>
                    <th>Team</th>
                    <th>City</th>
                    <th>Division</th>
                    <th>Abbreviation</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $teamsResult->fetch()): ?>
                    <tr>
                        <td><?php echo $row['teamName']?></td>
                        <td><?php echo $row['city']?></td>
                        <td><?php echo $row['divisionName']?></td>
                        <td><?php echo $row['abbreviation']?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>
<!-- END CONTENT -->

<?php require "footer.php"; ?>

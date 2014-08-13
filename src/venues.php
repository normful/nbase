<?php

require "header.php";
require "functions.php";

try {
    // connect to the Amazon EC2 MySQL database with PDO
    $dbh = new PDO("mysql:host=54.191.180.156;dbname=NBA", 'root', 'ubuntu');
} catch(PDOException $e) {
    error($e->getMessage());
    exit();
}

// Query database for all venues
$venuesQuery = <<<SQL
SELECT venueName, city, address
FROM venue
SQL;

$venuesResult = $dbh->query($venuesQuery);
$venuesResult->setFetchMode(PDO::FETCH_ASSOC);

// Query database for teams that have played at all venues
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

    <!-- Form for adding new venue -->
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    Add a Venue
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                    <form method="POST" action="add_venue.php">
                        Venue Name: <input type="text" name="venue" maxlength="30" required>
                        Venue City: <input type="text" name="city" maxlength="30" required>
                        Venue Address: <input type="text" name="address" maxlength="50" required>
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Display venues -->
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

    <!-- Teams that have played at all venues (Division Query) -->
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

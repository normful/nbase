<?php

require "header.php";
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

// WRITE YOUR SQL QUERIES HERE
$allPlayers = <<<SQL
SELECT firstName, lastName, number, team
FROM nbaplayer_playsfor;
SQL;

$allPlayersResult = $dbh->query($allPlayers);
$allPlayersResult->setFetchMode(PDO::FETCH_ASSOC);

?>

<!-- CONTENT -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Update Players</h1>
    <!-- Player Selection -->
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    Select a Player
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                    <form method="POST" action="profiles.php">
                        <select name="params" onchange="this.form.submit()">
                            <option value="" selected disabled>Select a Player</option>
                        <?php while ($row = $allPlayersResult->fetch()): ?>
                            <option value="<?php echo $row['team'] . "," . $row['number']; ?>">
                                <?php echo $row['firstName'] . " " . $row['lastName'] . " (" . $row['team'] . ")"; ?>
                            </option>
                        <?php endwhile; ?>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- END CONTENT -->

<?php require "footer.php"; ?>

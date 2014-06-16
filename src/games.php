<?php

require "header.php"; 
require "functions.php";

try {
	// connect to the Amazon EC2 MySQL database with PDO
  	$dbh = new PDO("mysql:host=54.86.9.29;dbname=nba", 'jacob', 'jacob');
} catch(PDOException $e) {
	error($e->getMessage());
	exit();
}

$where = "";
if (isset($_POST['from_date']) && isset($_POST['to_date'])) {
	$fromValid = preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_POST['from_date']);
	$toValid = preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $_POST['to_date']);
	if ($fromValid && $toValid) {
		$from = $dbh->quote($_POST['from_date']);
		$to = $dbh->quote($_POST['to_date']);
		$where .= "AND npp.gameDate BETWEEN {$from} AND {$to}";
	}
}

$query = <<<SQL
SELECT *
FROM nbagame_plays_playedat npp, nbareferee nr, referees r
WHERE 
nr.number = r.refNumber AND 
r.gameDate = npp.gameDate AND 
r.homeTeam = npp.homeTeam AND 
r.awayTeam = npp.awayTeam
{$where}
ORDER BY npp.gameDate;
SQL;

$result = $dbh->query($query);
$result->setFetchMode(PDO::FETCH_ASSOC);

?>

<!-- CONTENT -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Games</h1>

	<!-- Date Selection -->   
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    Filter Games
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                    <form method="POST">
                        From: <input type="date" name="from_date">
                        To: <input type="date" name="to_date">
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Date Range Message -->
    <?php
    if ($fromValid && $toValid) {
		echo "<p>Showing games between {$from} and {$to}</p>";
	} else {
		echo "<p>Showing all games</p>";
	}
	?>

	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Game Date</th>
					<th>Home Team</th>
					<th>Away Team</th>
					<th>Venue</th>
					<th>City</th>
					<th>Referee</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $result->fetch()): ?>
					<tr>
						<td><?php echo $row['gameDate']; ?></td>
						<td><?php printScore($row['homeTeam'], $row['homeScore'], $row['awayTeam'], $row['awayScore']); ?></td>
						<td><?php printScore($row['awayTeam'], $row['awayScore'], $row['homeTeam'], $row['homeScore']); ?></td>
						<td><?php echo $row['venueName']; ?></td>
						<td><?php echo $row['city']; ?></td>
						<td><?php echo $row['firstName'] . " " . $row['lastName'] . " (#{$row['refNumber']})"; ?></td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
		<em><span class="glyphicon glyphicon-ok"></span> - Winner</em>
	</div>
</div>

<!-- END CONTENT -->

<?php require "footer.php"; ?>
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

$displayRoster = false;

if (isset($_GET['team']) && preg_match("/^[a-z]{3}$/", strtolower($_GET['team']))) {
	$displayRoster = true;
	$team = $dbh->quote($_GET['team']);

	$query = <<<SQL
SELECT *
FROM nbaplayer_playsfor
WHERE team = {$team}
SQL;
	$result = $dbh->query($query);
	$result->setFetchMode(PDO::FETCH_ASSOC);

	$staffQuery = <<<SQL
SELECT *
FROM nbastaff_worksfor
WHERE team = {$team}
SQL;
	$staffResult = $dbh->query($staffQuery);
	$staffResult->setFetchMode(PDO::FETCH_ASSOC);

	$sponsorsQuery = <<<SQL
SELECT company
FROM nbateam_belongsto n, sponsor_endorses s 
WHERE n.abbreviation = s.team AND team = {$team}
SQL;
	$sponsorsResult = $dbh->query($sponsorsQuery);
	$sponsorsResult->setFetchMode(PDO::FETCH_ASSOC);
}

?>

<!-- CONTENT -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Rosters</h1>

	<div class="panel-group" id="accordion">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
					Select a team
					</a>
				</h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse">
				<div class="panel-body">
					<?php require "forms/rosters_select.php" ?>
				</div>
			</div>
		</div>
	</div>


	<?php if ($displayRoster): ?>
		<h2 class="sub-header">Players on team <strong><?php echo strtoupper(trim($team, "'")); ?></strong></h2>
		
		<!-- Players -->
		<div class="table-responsive">
			<table class="table table-striped table-hover hoverTable">
				<thead>
					<tr>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Position</th>
						<th>Number</th>
						<th>Height (in)</th>
						<th>Weight (lbs)</th>
						<th>Draft Year</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php while ($row = $result->fetch()): ?>
						<?php $playerKey = "number={$row['number']}&team={$row['team']}"; ?>
						<tr onclick="document.location = 'profiles.php?<?php echo $playerKey; ?>';">
							<td><?php echo $row['lastName']?></td>
							<td><?php echo $row['firstName']; ?></td>
							<td><?php echo $row['position']; ?></td>
							<td><?php echo $row['number']?></td>
							<td><?php echo $row['height']; ?></td>
							<td><?php echo $row['weight']; ?></td>
							<td><?php echo $row['draftYear']?></td>
							<td>
								<a href="delete_player.php?<?php echo $playerKey; ?>">
									<span class="glyphicon glyphicon-remove" ></span>
								</a>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>

		<!-- Staff -->
		<h2 class="sub-header">Staff on team <strong><?php echo strtoupper(trim($team, "'")); ?></strong></h2>
		<div class="table-responsive">
			<table class="table table-striped table-hover hoverTable">
				<thead>
					<tr>
						<th>Last Name</th>
						<th>First Name</th>
						<th>Job</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($row = $staffResult->fetch()): ?>
						<tr>
							<td><?php echo $row['lastName']?></td>
							<td><?php echo $row['firstName']; ?></td>
							<td><?php echo $row['job']; ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>

		<!-- Sponsors -->
		<h2 class="sub-header">Sponsors of team <strong><?php echo strtoupper(trim($team, "'")); ?></strong></h2>
		<ul>
		<?php while ($row = $sponsorsResult->fetch()): ?>
			<li><?php echo ucwords(strtolower($row['company'])); ?></li>
		<?php endwhile; ?>
		</ul>
	<?php endif; ?>
</div>         
<!-- END CONTENT -->

<?php require "footer.php"; ?>
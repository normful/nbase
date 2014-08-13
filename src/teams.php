<?php

require "header.php"; 
require "functions.php";

try {
	// connect to the Amazon EC2 MySQL database with PDO
  	$dbh = new PDO("mysql:host=54.186.234.91;dbname=NBA", 'root', 'ubuntu');
} catch(PDOException $e) {
	error($e->getMessage());
	exit();
}

// Query the database for teams
$query = <<<SQL
SELECT city, abbreviation, teamName, divisionName
FROM NBATeam_BelongsTo
SQL;

$result = $dbh->query($query);
$result->setFetchMode(PDO::FETCH_ASSOC);

?>

<!-- CONTENT -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Teams</h1>
	<div class="table-responsive">
		<table class="table table-striped table-hover hoverTable">
			<thead>
				<tr>
					<th>Abbreviation</th>
					<th>City</th>
					<th>Team Name</th>
					<th>Division</th>					
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $result->fetch()): ?>
					<tr onclick="document.location = 'rosters.php?team=<?php echo $row['abbreviation']; ?>';">
						<td><?php echo $row['abbreviation']?></td>
						<td><?php echo $row['city']; ?></td>
						<td><?php echo $row['teamName']; ?></td>
						<td><?php echo $row['divisionName']?></td>						
						<td>
							<a href="delete_team.php?team=<?php echo $row['abbreviation']; ?>">
								<span class="glyphicon glyphicon-remove"></span>
							</a>
						</td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>         
<!-- END CONTENT -->

<?php require "footer.php"; ?>
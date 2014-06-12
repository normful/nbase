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

// WRITE YOUR SQL QUERIES HERE
$query = <<<SQL
SELECT city, abbreviation, teamName, divisionName
FROM NBATeam_BelongsTo
SQL;

// Uncomment the following two lines after you've written your SQL queries
 $result = $dbh->query($query);
$result->setFetchMode(PDO::FETCH_ASSOC);

?>

<!-- CONTENT -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Teams</h1>
	<!-- All your html code you be AFTER this line -->
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>City</th>
					<th>Abbreviation</th>
					<th>Team Name</th>
					<th>Division</th>					
					<th></th> <!-- this is for the delete -->
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $result->fetch()): ?>
					<tr>
						<td><?php echo $row['city']?></td>
						<td><?php echo $row['abbreviation']; ?></td>
						<td><?php echo $row['teamName']; ?></td>
						<td><?php echo $row['divisionName']?></td>						
						<td>
							<a href="delete_teams.php?abbreviation=<?php echo $row['abbreviation']; ?>">
								<span class="glyphicon glyphicon-remove"></span>
							</a>
						</td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>


	<!-- All your html code you be BEFORE this line -->
</div>         
<!-- END CONTENT -->

<?php require "footer.php"; ?>
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
$select = "";
if (isset($_GET['sel_gDate'])) $select .= ",gameDate";
if (isset($_GET['sel_hScore'])) $select .= ",homeScore";
if (isset($_GET['sel_aScore'])) $select .= ",awayScore";
if (isset($_GET['sel_hteam'])) $select .= ",homeTeam";
if (isset($_GET['sel_ateam'])) $select .= ",awayTeam";
if (isset($_GET['sel_vName'])) $select .= ",venueName";
if (isset($_GET['sel_city'])) $select .= ",city";
if (isset($_GET['sel_rNumber'])) $select .= ",refNumber";
$select = substr($select,1);

if ($select == "") $select = "*";

// WRITE YOUR SQL QUERIES HERE
$query = <<<SQL
SELECT {$select}
FROM nbagame_plays_playedat npp, nbareferee nr, referees r, venue v
WHERE 
npp.venueName = v.venueName and 
npp.city = v.city and 
nr.number = r.refNumber and 
r.gameDate = npp.gameDate and 
r.homeTeam = npp.homeTeam and 
r.awayTeam = npp.awayTeam 
SQL;

// Uncomment the following two lines after you've written your SQL queries
$result = $dbh->query($query);
$result->setFetchMode(PDO::FETCH_ASSOC);

?>

<!-- CONTENT -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Games</h1>
	<!-- All your html code you be AFTER this line -->
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Game Date</th>
					<th>Home Team</th>
					<th>Away Team</th>
					<th>Home Score</th>
					<th>Away Score</th>
					<th>Venue</th>
					<th>City</th>
					<th>Referee</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $result->fetch()): ?>
					<tr>
						<td><?php echo $row['gameDate']?></td>
						<td><?php echo $row['homeTeam']?></td>
						<td><?php echo $row['awayTeam']; ?></td>
						<td><?php echo $row['homeScore']; ?></td>
						<td><?php echo $row['awayScore']; ?></td>
						<td><?php echo $row['venueName']; ?></td>
						<td><?php echo $row['city']?></td>
						<td><?php echo $row['refNumber']; ?></td>
						<td>
							<!-- <a href="delete_player.php?number=<?php echo $row['number']; ?>&team=<?php echo $row['team']; ?>">
								<span class="glyphicon glyphicon-remove"></span>
							</a> -->
						</td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>

<!-- Find games in between a certain date range -->

	<div class ="data-responsive">
		<!-- Calendar css -->
		<link rel="stylesheet" type="text/css" href="css/tcal.css" />
		<!-- Calendar js --> 
		<script type="text/javascript" src="js/tcal.js"></script> 
		<form action="games.php" method="get">
			From : <input type="text" name="gDate1" class="tcal" value=""><br>
			To: <input type="text" name="gDate2" class="tcal" value=""><br> 
				<input type="submit" value="Search">
		</form>
		<table id="resultTable" data-responsive="table" style="text-align: left; width: 550px;" border="1" cellspacing="0" cellpadding="4">
			<thead>
				<tr>
					<th>Game Date</th>
					<th>Home Team</th>
					<th>Away Team</th>
					<th>Home Score</th>
					<th>Away Score</th>
					<th>Venue</th>
					<th>City</th>
					<th>Referee</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php
				if (isset($_GET["gDate1"])) { $gDate1 = $_GET["gDate1"]; } else { $gDate1="0000-00-00"; };
				if (isset($_GET["gDate2"])) { $gDate2 = $_GET["gDate2"]; } else { $gDate2="0000-00-00"; };
				$result = $dbh->prepare("SELECT * FROM nbagame_plays_playedat WHERE nbagame_plays_playedat.gameDate BETWEEN :a AND :b");
				$result->bindValue(':a', $gDate1);
				$result->bindValue(':b', $gDate2);
				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){
					?>
					<tr>
						<td><?php echo $row['gameDate']?></td>
						<td><?php echo $row['homeTeam']?></td>
						<td><?php echo $row['awayTeam']; ?></td>
						<td><?php echo $row['homeScore']; ?></td>
						<td><?php echo $row['awayScore']; ?></td>
						<td><?php echo $row['venueName']; ?></td>
						<td><?php echo $row['city']?></td>
						<td><?php echo $row['refNumber']; ?></td>
					</tr>
					<?php } ?>
			</tbody>
		</table>
	</div>
</div>
	<!-- All your html code you be BEFORE this line -->    
<!-- END CONTENT -->

<?php require "footer.php"; ?>
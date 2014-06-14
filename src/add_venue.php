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

if (isset($_POST['venue']) && isset($_POST['city']) && isset($_POST['address'])) {
	$venue = $dbh->quote($_POST['venue']);
	$city = $dbh->quote($_POST['city']);
	$address = $dbh->quote($_POST['address']);

	$query = <<<SQL
INSERT INTO venue VALUES({$venue}, {$city}, {$address});
SQL;
	$result = $dbh->query($query);
	if (!$result) {
		error("ERROR: Unable to add venue. Returning to venues page.");
		echo '<meta http-equiv="refresh" content="0;venues.php">';
	} else {
		alert("SUCCESS: {$venue} was successfully added. Returning to venues page.");
		echo '<meta http-equiv="refresh" content="0;venues.php">';
	}
} else {
	error("ERROR: Unable to add venue. Returning to venues page.");
	echo '<meta http-equiv="refresh" content="0;venues.php">';
}

?>

<!-- CONTENT -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Add Venue</h1>
</div>
<!-- END CONTENT -->
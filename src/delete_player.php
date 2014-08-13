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

?>

<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Delete Player</h1>

<?php if (isset($_GET['team']) && is_numeric($_GET['number']) && $_GET['confirm'] == "yes"): ?>
	<?php

	$team = $dbh->quote($_GET['team']);
	$number = $_GET['number'];

	$query = <<<SQL
DELETE FROM nbaplayer_playsfor
WHERE team = {$team} AND number = {$number};
SQL;
	$result = $dbh->query($query);

	if (!$result) {
		error("ERROR: Cannot delete player number {$number} of team {$team} from the database. Returning to players page.");
		echo '<meta http-equiv="refresh" content="0;players.php">';
	} else {
		alert("SUCCESS: Player {$number} of team {$team} was successfully deleted from the database. Returning to players page.");
		echo '<meta http-equiv="refresh" content="0;players.php">';
	}

	?>
<?php elseif (isset($_GET['team']) && is_numeric($_GET['number'])): ?>
	<?php 
	$team = $dbh->quote($_GET['team']);
	$number = $_GET['number'];
	?>
	<p>Warning! You are about to delete player number <strong><?php echo $number; ?></strong> from team <strong><?php echo strtoupper(trim($team, "'")); ?></strong>. This action cannot be undone. Are you sure you want to continue?</p>
	<form method="GET">
		<input type="hidden" name="confirm" value="yes">
		<input type="hidden" name="team" value="<?php echo trim($team, "'"); ?>">
		<input type="hidden" name="number" value="<?php echo $number; ?>">
		<input type="submit" value="Confirm Deletion">
	</form>
<?php else: ?>
	<?php error("ERROR: Player not specified. Returning to teams page."); ?>
	<meta http-equiv="refresh" content="0;players.php">
<?php endif; ?>

</div>

<?php require "footer.php"; ?>
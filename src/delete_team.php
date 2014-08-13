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
	<h1 class="page-header">Delete Team</h1>

<?php if (isset($_GET['team']) && $_GET['confirm'] == "yes"): ?>
	<?php

	$team = $dbh->quote($_GET['team']);

	$query = <<<SQL
DELETE FROM nbateam_belongsto
WHERE abbreviation = {$team};
SQL;
	$result = $dbh->query($query);

	if (!$result) {
		error("ERROR: Cannot delete team {$team} from the database. Returning to teams page.");
		echo '<meta http-equiv="refresh" content="0;teams.php">';
	} else {
		alert("SUCCESS: Team {$team} was successfully deleted from the database. Returning to teams page.");
		echo '<meta http-equiv="refresh" content="0;teams.php">';
	}

	?>
<?php elseif (isset($_GET['team'])): ?>
	<?php $team = $dbh->quote($_GET['team']); ?>
	<p>Warning! You are about to delete team <strong><?php echo strtoupper(trim($team, "'")); ?></strong>. This will also delete all players associated with this team. This action cannot be undone. Are you sure you want to continue?</p>
	<form method="GET">
		<input type="hidden" name="confirm" value="yes">
		<input type="hidden" name="team" value="<?php echo trim($team, "'"); ?>">
		<input type="submit" value="Confirm Deletion">
	</form>
<?php else: ?>
	<?php error("ERROR: Team not specified. Returning to teams page."); ?>
	<meta http-equiv="refresh" content="0;teams.php">
<?php endif; ?>

</div>

<?php require "footer.php"; ?>
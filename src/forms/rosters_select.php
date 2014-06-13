<?php

$teamQuery = <<<SQL
SELECT abbreviation, teamName, city
FROM nbateam_belongsto
SQL;

$teamResults = $dbh->query($teamQuery);
$teamResults->setFetchMode(PDO::FETCH_ASSOC);

?>

<form method="get">
	<select name="team" onchange="this.form.submit()">
		<option value="" disabled selected>Select a team</option>
		<?php while ($row = $teamResults->fetch()): ?>
		<option value="<?php echo $row['abbreviation']; ?>"><?php echo explode(",", $row['city'])[0] . " " . $row['teamName'] . " (" . $row['abbreviation'] . ")"; ?></option>
		<?php endwhile; ?>
	<select>
</form>
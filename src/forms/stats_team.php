<?php

$sponsorsQuery = <<<SQL
SELECT DISTINCT company
FROM sponsor_endorses
SQL;

$sponsorsResults = $dbh->query($sponsorsQuery);
$sponsorsResults->setFetchMode(PDO::FETCH_ASSOC);

?>

<form method="POST">
	Find the 
	<select name="operator">
		<option value="max">maximum</option>
		<option value="min">minimum</option>
		<option value="avg">average</option>
	</select>
	of the
	<select name="attribute">
		<option value="height">height</option>
		<option value="weight">weight</option>
		<option value="number">number</option>
		<option value="draftYear">draft year</option>
	</select>
	for each team that is sponsored by
	<select name="sponsor">
		<?php while ($row = $sponsorsResults->fetch()): ?>
		<option value="<?php echo $row['company']; ?>"><?php echo $row['company']; ?></option>
		<?php endwhile; ?>
	<select>
	<input type="hidden" name="mode" value="team">
	<input type="submit">
</form>
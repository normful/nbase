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

if (isset($_POST['mode'])) {
	$operator = trim($dbh->quote($_POST['operator']), "'");
	$attribute = trim($dbh->quote($_POST['attribute']), "'");
	if ($_POST['mode'] == "team") {
		$sponsor = $dbh->quote($_POST['sponsor']);
		$select = " team, " . $operator . "(" . $attribute . ") as result";
		$where = " WHERE team IN (SELECT abbreviation FROM nbateam_belongsto n, sponsor_endorses s WHERE n.abbreviation = s.team AND s.company = {$sponsor})";
		$groupby = " GROUP BY team";
	}  else if ($_POST['mode'] == "all") {
		$select = $operator . "(" . $attribute . ") as result";
		$where = "";
		$groupby = "";
	}
		$query = <<<SQL
SELECT {$select}
FROM nbaplayer_playsfor
{$where}
{$groupby};
SQL;

	$result = $dbh->query($query);
	$result->setFetchMode(PDO::FETCH_ASSOC);

	// string of units for selected attribute
	if ($attribute == "height") $units = "in";
	else if ($attribute == "weight") $units = "lbs";
	else $units = "";

	// string of selected aggregate operator
	if ($operator == "max") $opstr = "maximum";
	else if ($operator == "min") $opstr = "minimum";
	else if ($operator == "avg") $opstr = "average";
	else $opstr = "";

	// string of attribute
	$attribute = strtolower(trim(preg_replace('/(?<=\\w)(?=[A-Z])/'," $1", $attribute)));
}

?>

<!-- CONTENT -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Statistics</h1>

	<!-- Forms -->
	<div class="panel-group" id="accordion">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
					League Stats
					</a>
				</h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse">
				<div class="panel-body">
					<?php require "forms/stats_all.php" ?>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
					Team Stats
					</a>
				</h4>
			</div>
			<div id="collapseTwo" class="panel-collapse collapse">
				<div class="panel-body">
					<?php require "forms/stats_team.php"; ?>
				</div>
			</div>
		</div>
	</div>

	<!-- Display result -->
	<?php if ($_POST['mode'] == "all"): ?>

		<?php $row = $result->fetch() ?>
		<h3>The <?php echo $opstr . " " . $attribute; ?> for all players is <?php echo round($row['result'], 0) . " " . $units; ?>.</h3>
	
	<?php elseif ($_POST['mode'] == "team"): ?>
		
		<h3>Showing the <?php echo $opstr . " " . $attribute ?> for each team that is sponsored by <?php echo $sponsor ?>.</h3>
		<div class="table-responsive">
			<table class="table table-striped table-hover hoverTable">
				<thead>
					<tr>
						<th>Team</th>
						<th><?php echo ucwords($opstr . " " . $attribute) . " (" . $units . ")"; ?></th>
					</tr>
				</thead>
				<tbody>
					<?php while ($row = $result->fetch()): ?>
					<tr>
						<td><?php echo $row['team'] ?></td>
						<td><?php echo round($row['result'], 0) ?></td>
					<tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>

	<?php endif; ?>

</div>         
<!-- END CONTENT -->

<?php require "footer.php"; ?>
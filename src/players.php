<?php

require "header.php";
	
require "functions.php";
	
try {
  	$dbh = new PDO("mysql:host=54.191.180.156;dbname=NBA", 'root', 'ubuntu');
} catch(PDOException $e) {
	error($e->getMessage());
	exit();
}

// Specify SELECT clause of query
$select = "";
if (isset($_GET['sel_lname'])) $select .= ",lastName";
if (isset($_GET['sel_fname'])) $select .= ",firstName";
if (isset($_GET['sel_pos'])) $select .= ",position";
if (isset($_GET['sel_height'])) $select .= ",height";
if (isset($_GET['sel_weight'])) $select .= ",weight";
if (isset($_GET['sel_year'])) $select .= ",draftYear";
if (isset($_GET['sel_num'])) $select .= ",number";
if (isset($_GET['sel_team'])) $select .= ",team";
$select = substr($select,1);

if ($select == "") $select = "*";


// Specify WHERE clause of query
$where = "";
if (isset($_GET['filter']) && isset($_GET['operator']) && isset($_GET['value']) && is_numeric($_GET['value'])) {
	if ($_GET['filter'] == "height") $filter = "height";
	else if ($_GET['filter'] == "weight") $filter = "weight";
	else if ($_GET['filter'] == "number") $filter = "number";
	else $filter = "draftYear";
	
	if ($_GET['operator'] == "lt") $operator = "<";
	else if ($_GET['operator'] == "lteq") $operator = "<=";
	else if ($_GET['operator'] == "gt") $operator = ">";
	else if ($_GET['operator'] == "gteq") $operator = ">=";
	else if ($_GET['operator'] == "noteq") $operator = "<>";
	else $operator = "=";
	
	$where = "WHERE " . $filter . " $operator " . $_GET['value'];
}

// Specify ORDER BY clause of query
$orderby = "";
if (isset($_GET['sort'])) {
	if ($_GET['sort'] == "firstname") $filter = "firstName";
	else if ($_GET['sort'] == "position") $filter = "position";
	else if ($_GET['sort'] == "number") $filter = "number";
	else if ($_GET['sort'] == "height") $filter = "height";
	else if ($_GET['sort'] == "weight") $filter = "weight";
	else if ($_GET['sort'] == "draftyear") $filter = "draftYear";
	else if ($_GET['sort'] == "team") $filter = "team";
	else $filter = "lastName";
	
	if (isset($_GET['order']) && $_GET['order'] == "desc") $order = "DESC";
	else $order = "ASC";
	
	$orderby = "ORDER BY " . $filter . " " . $order;
}

$query = <<<SQL
SELECT {$select}
FROM nbaplayer_playsfor
{$where}
{$orderby};
SQL;
    
$result = $dbh->query($query);
$result->setFetchMode(PDO::FETCH_ASSOC);

?>

<!-- CONTENT -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Players</h1>
     
	<div class="panel-group" id="accordion">
		<!-- Form to specify selection constraint -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
					Filter Results
					</a>
				</h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse">
				<div class="panel-body">
					<?php require "forms/players_filter.php" ?>
				</div>
			</div>
		</div>
		<!-- Form to specify ordering -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
					Order Results
					</a>
				</h4>
			</div>
			<div id="collapseTwo" class="panel-collapse collapse">
				<div class="panel-body">
					<?php require "forms/players_sort.php"; ?>
				</div>
			</div>
		</div>
		<!-- Form to specify projection -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
					Display Attributes
					</a>
				</h4>
			</div>
			<div id="collapseThree" class="panel-collapse collapse">
				<div class="panel-body">
					<?php require "forms/players_select.php"; ?>
				</div>
			</div>
		</div>
	</div>

    <!-- Display players -->                
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
					<th>Team</th>
					<th></th>
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
						<td><?php echo $row['team']; ?></td>
						<td>
							<a href="update.php?<?php echo $playerKey; ?>">
								<span class="glyphicon glyphicon-pencil" ></span>
							</a>
						</td>
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
</div>
<!-- END CONTENT -->

<?php require "footer.php"; ?>
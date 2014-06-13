<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>NBAse</title>

		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- Custom styles for this template -->
		<link href="css/dashboard.css" rel="stylesheet">
		<link href="css/styles.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>

		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="./"><img src="./img/logo.png" height="33px"></a>
				</div>
				<div class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="./">About</a></li>
					</ul>
				</div>
			</div>
		</div>
				
<?php

$currentPage = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
$base="";
if ($currentPage == $base."players.php") $playersClass = 'class="active"';
else if ($currentPage == $base."profiles.php") $profilesClass = 'class="active"';
else if ($currentPage == $base."teams.php") $teamsClass = 'class="active"';
else if ($currentPage == $base."rosters.php") $rostersClass = 'class="active"';
else if ($currentPage == $base."games.php") $gamesClass = 'class="active"';
else if ($currentPage == $base."venues.php") $venuesClass = 'class="active"';
else if ($currentPage == $base."stats.php") $statsClass = 'class="active"';
else if ($currentPage == $base."update.php") $updateClass = 'class="active"';

?>

<!-- LEFT NAV -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3 col-md-2 sidebar">
					<ul class="nav nav-sidebar">
						<li <?php echo $playersClass; ?>><a href="players.php"><span class="glyphicon glyphicon-user"> Players</span></a></li>
						<li <?php echo $profilesClass; ?>><a href="profiles.php"><span class="glyphicon glyphicon-star"> Profiles</span></a></li>
						<li <?php echo $teamsClass; ?>><a href="teams.php"><span class="glyphicon glyphicon-globe"> Teams</span></a></li>
						<li <?php echo $rostersClass; ?>><a href="rosters.php"><span class="glyphicon glyphicon-list"> Rosters</span></a></li>
						<li <?php echo $gamesClass; ?>><a href="games.php"><span class="glyphicon glyphicon-bullhorn"> Games</span></a></li>
						<li <?php echo $venuesClass; ?>><a href="venues.php"><span class="glyphicon glyphicon-map-marker"> Venues</span></a></li>
						<li <?php echo $statsClass; ?>><a href="stats.php"><span class="glyphicon glyphicon-stats"> Stats</span></a></li>
						<li <?php echo $updateClass; ?>><a href="update.php"><span class="glyphicon glyphicon-edit"> Edit</span></a></li>
					</ul>
				</div>
<!-- END LEFT NAV -->
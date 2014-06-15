<?php

require "header.php";
require "functions.php";

if (isset($_POST['params'])) {
    $params = explode(",", $_POST['params']);
    $team = $params[0];
    $number = $params[1];
    echo "<meta http-equiv=\"refresh\" content=\"0;?team={$team}&number={$number}\">";
}

try {
    // connect to the Amazon EC2 MySQL database with PDO
    $dbh = new PDO("mysql:host=54.86.9.29;dbname=nba", 'jacob', 'jacob');
} catch(PDOException $e) {
    // use the error() function I wrote whenever you want to signal that an error has occured
    error($e->getMessage());
    exit();
}

// Get all players
$allPlayers = <<<SQL
SELECT firstName, lastName, number, team
FROM nbaplayer_playsfor
SQL;
$allPlayersResult = $dbh->query($allPlayers);
$allPlayersResult->setFetchMode(PDO::FETCH_ASSOC);

// Get all teams
$allTeams = <<<SQL
SELECT *
FROM nbateam_belongsto
SQL;
$allTeamsResult = $dbh->query($allTeams);
$allTeamsResult->setFetchMode(PDO::FETCH_ASSOC);

// Build where clause from http get parameters
$where = "";
$displayUpdateForm = FALSE;
if (isset($_GET['number']) && isset($_GET['team'])) {
    $where .= "WHERE";
    if (is_numeric($_GET['number'])) {
        $where .= " number = {$_GET['number']}";
    } else {
        error("Invalid player number");
        exit();
    }

    if (preg_match("/^[a-z]{3}$/", strtolower($_GET['team']))) {
        $where .= " AND team = '{$_GET['team']}'";
    } else {
        error("Invalid team");
        exit();
    }
    $displayUpdateForm = TRUE;
}

if ($displayUpdateForm) {
    $currPlayer = <<<SQL
SELECT *
FROM nbaplayer_playsfor
{$where};
SQL;
    $currPlayerResult = $dbh->query($currPlayer);
    $currPlayerResult->setFetchMode(PDO::FETCH_ASSOC);

    $currTeam = <<<SQL
SELECT teamName, abbreviation
FROM nbateam_belongsto
WHERE abbreviation = '{$_GET['team']}'
SQL;
    $currTeamResult = $dbh->query($currTeam);
    $currTeamResult->setFetchMode(PDO::FETCH_ASSOC);
}

?>

<!-- CONTENT -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
    <h1 class="page-header">Update Players</h1>
    <!-- Player Selection -->
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    Select a Player to Edit
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                    <form method="POST" action="update.php">
                        <select name="params" onchange="this.form.submit()">
                            <option value="" selected disabled>Players</option>
                        <?php while ($row = $allPlayersResult->fetch()): ?>
                            <option value="<?php echo $row['team'] . "," . $row['number']; ?>">
                                <?php echo $row['firstName'] . " " . $row['lastName'] . " (" . $row['team'] . ")"; ?>
                            </option>
                        <?php endwhile; ?>
                        </select>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Display update form -->
    <?php
    if ($displayUpdateForm):
        $player = $currPlayerResult->fetch();
        $team = $currTeamResult->fetch();

        $oldFirstName = $player['firstName'];
        $oldLastName = $player['lastName'];
        $oldTeam = $player['team'];
        $oldNumber = $player['number'];
        $oldPosition = $player['position'];
        $oldWeight =  $player['weight'];
        $oldHeight = $player['height'];
        $oldDraftYear =  $player['draftYear'];

        $oldTeamName = $team['teamName'];
        $oldAbbreviation = $team['abbreviation'];

        require "forms/update_player.php";
    endif;
    ?>

    <!-- Update database -->
    <?php if (isset($_POST['newFirstName']) &&
          isset($_POST['newLastName']) &&
          isset($_POST['newTeam']) &&
          isset($_POST['newNumber']) &&
          isset($_POST['newPosition']) &&
          isset($_POST['newWeight']) &&
          isset($_POST['newHeight']) &&
          isset($_POST['newDraftYear'])): ?>

    <?php
    $newFirstName = $dbh->quote($_POST['newFirstName']);
    $newLastName = $dbh->quote($_POST['newLastName']);
    $newTeam = $dbh->quote($_POST['newTeam']);
    $newNumber = $_POST['newNumber'];
    $newPosition = $dbh->quote($_POST['newPosition']);
    $newWeight = $_POST['newWeight'];
    $newHeight = $_POST['newHeight'];
    $newDraftYear = $_POST['newDraftYear'];

    $oldTeam = $dbh->quote($_POST['oldTeam']);
    $oldNumber = $_POST['oldNumber'];

    $updateQuery = <<<SQL
UPDATE nbaplayer_playsfor
SET
firstName = {$newFirstName},
lastName = {$newLastName},
team = {$newTeam},
number = {$newNumber},
position = {$newPosition},
weight = {$newWeight},
height = {$newHeight},
draftYear = {$newDraftYear}
WHERE team = {$oldTeam} AND number = {$oldNumber};
SQL;

    echo $updateQuery;

    $updateResult = $dbh->query($updateQuery);

    $oldTeam = trim($oldTeam, "'");

	if (!$updateResult) {
		error("ERROR: Cannot update player {$oldNumber} of team {$oldTeam}. Returning to edit page.");
		echo '<meta http-equiv="refresh" content="0;update.php">';
	} else {
		alert("SUCCESS: Player {$oldNumber} of team {$oldTeam} was successfully updated. Returning to players page.");
		echo '<meta http-equiv="refresh" content="0;players.php">';
    }
?>
<?php endif; ?>


</div>
<!-- END CONTENT -->

<?php require "footer.php"; ?>

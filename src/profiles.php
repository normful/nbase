<?php

require "header.php"; 
require "functions.php";

// Refresh with correct parameters
if (isset($_POST['params'])) {
    $params = explode(",", $_POST['params']);
    $team = $params[0];
    $number = $params[1];
    echo "<meta http-equiv=\"refresh\" content=\"0;?team={$team}&number={$number}\">";
}

try {
	// connect to the Amazon EC2 MySQL database with PDO
  	$dbh = new PDO("mysql:host=54.191.180.156;dbname=NBA", 'root', 'ubuntu');
} catch(PDOException $e) {
	error($e->getMessage());
	exit();
}

// Build where clause from http GET parameters
$where = "";
$displayPlayer = FALSE;
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
    $displayPlayer = TRUE;
}

// Query for names all players
$allPlayers = <<<SQL
SELECT firstName, lastName, number, team
FROM nbaplayer_playsfor
ORDER BY firstName, lastName
SQL;

$allPlayersResult = $dbh->query($allPlayers);
$allPlayersResult->setFetchMode(PDO::FETCH_ASSOC);

// Query for information about current player
if ($displayPlayer) {
    $currPlayer = <<<SQL
SELECT *
FROM nbaplayer_playsfor
{$where};
SQL;

    $currPlayerResult = $dbh->query($currPlayer);
    $currPlayerResult->setFetchMode(PDO::FETCH_ASSOC);
}

?>

<!-- CONTENT -->
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
	<h1 class="page-header">Profiles</h1>

    <!-- Player Selection -->   
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    Select a Player
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse">
                <div class="panel-body">
                    <form method="POST" action="profiles.php">
                        <select name="params" onchange="this.form.submit()">
                            <option value="" selected disabled>Select a Player</option>
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

    <!-- Display player profile -->
    <?php if ($displayPlayer): ?>
        <!-- Get the profile image for the current player -->
        <?php 
            $row = $currPlayerResult->fetch();
            $namequery = $row['firstName'] . "+" . $row['lastName'];
            $name = $row['firstName'] . " " . $row['lastName'];
            $json = get_url_contents("http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q={$namequery}");
            $data = json_decode($json);
            foreach ($data->responseData->results as $result) {
                if (@getimagesize($result->url) !== false) {
                    $imgurl = $result->url;
                    break;
                }
            }
        ?>

        <h2 class="sub-header"><?php echo $name ?></h2>
        <table>
            <tr>
                <!-- Display information about the current player -->
                <td width="300px" style="vertical-align:top;">
                    <img src="<?php echo $imgurl; ?>" class="roundrect" width="300"><p>
                    <table class="table table-striped">
                        <tr>
                            <td><?php echo '<span class="playerstat">Current Team</span>'; ?></td>
                            <td><?php echo $row['team']; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo '<span class="playerstat">Number</span>'; ?></td>
                            <td><?php echo $row['number']; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo '<span class="playerstat">Position</span>'; ?></td>
                            <td><?php echo $row['position']; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo '<span class="playerstat">Height (in)</span>'; ?></td>
                            <td><?php echo $row['height']; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo '<span class="playerstat">Weight (lbs)</span>'; ?></td>
                            <td><?php echo $row['weight']; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo '<span class="playerstat">Year Drafted</span>'; ?></td>
                            <td><?php echo $row['draftYear']; ?></td>
                        </tr>
                    </table></p>
                </td>

                <!-- Display latest news about the current player -->
                <td style="vertical-align:top;">
                    <div class="playernews">
                        <h3>Latest News on <?php echo $name; ?></h3>
                        <?php printProfileNews($namequery, 4); ?>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Display image gallery for current player -->
        <h2 class="sub-header">Gallery</h2>
        <p class="gallery">
            <?php printImageGallery($namequery, 9); ?>
        </p>

    <?php endif; ?>
</div>         
<!-- END CONTENT -->

<?php require "footer.php"; ?>
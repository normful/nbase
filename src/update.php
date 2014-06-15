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
FROM nbaplayer_playsfor;
SQL;

$allPlayersResult = $dbh->query($allPlayers);
$allPlayersResult->setFetchMode(PDO::FETCH_ASSOC);

// Build where clause from http get parameters
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
                            <option value="" selected disabled>Select a Player to Edit</option>
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
        <table>
            <tr>
                <td>
                    <img src="<?php echo $imgurl; ?>" class="roundrect" width="300">
                </td>
            </tr>
            <tr>
                <td>
                    <?php require "forms/update_player.php"; ?>
                </td>
            </tr>
        </table>
    <?php endif; ?>

</div>
<!-- END CONTENT -->

<?php require "footer.php"; ?>

<?php

$allTeams = <<<SQL
SELECT teamName, abbreviation
FROM nbaplayer_playsfor;
SQL;

$allTeamsResult = $dbh->query($allTeams);
$allTeamsResult->setFetchMode(PDO::FETCH_ASSOC);

?>

<form method="POST" class="form-horizontal">
    <div class="form-group">
        <label for="newFirstName" class="control-label col-xs-2">First Name</label>
        <div class="col-xs-10">
            <input type="text" class="form-control" id="newFirstName" placeholder="oldFirstName">
        </div>
    </div>

    <select name="newPosition">
        <option value="PG">PG</option>
        <option value="SG">SG</option>
        <option value="SF">SF</option>
        <option value="PF">PF</option>
        <option value="C">C</option>
    </select>

    <select name="newTeamName">
        <?php while ($row = $allTeamsResult ->fetch()): ?>
        <option value="<?php echo $row['abbreviation']; ?>">
            <?php echo $row['teamName'] . " (" . $row['abbreviation'] . ")"; ?>
        </option>
        <?php endwhile; ?>
    <select>

    <div class="form-group">
        <div class="col-xs-offset-2 col-xs-10">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

</form>

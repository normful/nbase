<?php

$allTeams = <<<SQL
SELECT teamName, abbreviation
FROM nbaplayer_playsfor;
SQL;

$allTeamsResult = $dbh->query($allTeams);
$allTeamsResult->setFetchMode(PDO::FETCH_ASSOC);

?>

<div class="container">
    <form method="POST" class="form-horizontal">

        <div class="form-group">
            <label for="newFirstName" class="control-label col-xs-2">First Name</label>
            <div class="col-xs-5">
                <input type="text" class="form-control" name="newFirstName" placeholder="oldFirstName">
            </div>
        </div>

        <div class="form-group">
            <label for="newLastName" class="control-label col-xs-2">Last Name</label>
            <div class="col-xs-5">
                <input type="text" class="form-control" name="newLastName" placeholder="oldLastName">
            </div>
        </div>

        <div class="form-group">
            <label for="newPosition" class="control-label col-xs-2">Position</label>
            <div class="col-xs-5">
                <select name="newPosition" class="form-control">
                    <option value="PG">PG</option>
                    <option value="SG">SG</option>
                    <option value="SF">SF</option>
                    <option value="PF">PF</option>
                    <option value="C">C</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>
</div>

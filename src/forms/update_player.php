<div class="container">
    <form method="POST" class="form-horizontal" action="update.php">

        <div class="form-group">
            <label class="control-label col-xs-2">First Name</label>
            <div class="col-xs-5">
                <input type="text" class="form-control" name="newFirstName" value="<?php echo $oldFirstName;?>" pattern="[A-Za-z]+">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Last Name</label>
            <div class="col-xs-5">
                <input type="text" class="form-control" name="newLastName" value="<?php echo $oldLastName;?>" pattern="[A-Za-z]+">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Team</label>
            <div class="col-xs-5">
                <select name="newTeam" class="form-control">
                    <option value="<?php echo $oldAbbreviation; ?>">
                        <?php echo explode(",", $oldCity)[0] . " " . $oldTeamName . " (" . $oldAbbreviation . ")"; ?></option>
                    </option>
                    <?php while ($row = $allTeamsResult->fetch()):
                        if (strcmp($row['teamName'], $oldTeamName) != 0): ?>
                            <option value="<?php echo $row['abbreviation']; ?>">
                                <?php echo explode(",", $row['city'])[0] . " " . $row['teamName'] . " (" . $row['abbreviation'] . ")"; ?>
                            </option>
                    <?php endif;
                          endwhile; ?>
                <select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Number</label>
            <div class="col-xs-5">
                <input type="number" class="form-control" name="newNumber" value="<?php echo $oldNumber;?>" min="0" max="99">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Position</label>
            <div class="col-xs-5">
                <select name="newPosition" class="form-control">
                    <option value="<?php echo $oldPosition; ?>">
                        <?php echo $oldPosition; ?>
                    </option>
                    <?php $positionArray = array("PG", "SG", "PF", "SF", "C");
                        foreach ($positionArray as $position) {
                            if (strcmp($position, $oldPosition) != 0):
                    ?>
                            <option value="<?php echo $position; ?>">
                                <?php echo $position; ?>
                            </option>
                    <?php endif; }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Weight (lbs)</label>
            <div class="col-xs-5">
                <input type="number" class="form-control" name="newWeight" value="<?php echo $oldWeight;?>" min="0">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Height (in)</label>
            <div class="col-xs-5">
                <input type="number" class="form-control" name="newHeight" value="<?php echo $oldHeight;?>" min="0">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Draft Year</label>
            <div class="col-xs-5">
                <input type="number" class="form-control" name="newDraftYear" value="<?php echo $oldDraftYear;?>" min="1946" max="2014">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

		<input type="hidden" name="oldTeam" value="<?php echo $oldTeam; ?>">
		<input type="hidden" name="oldNumber" value="<?php echo $oldNumber; ?>">

    </form>
</div>

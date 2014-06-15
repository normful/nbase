<div class="container">
    <form method="POST" class="form-horizontal" action="update.php">

        <div class="form-group">
            <label class="control-label col-xs-2">First Name</label>
            <div class="col-xs-5">
            <input type="text" class="form-control" name="newFirstName" placeholder="<?php echo $oldFirstName;?>" pattern="[A-Za-z]+">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Last Name</label>
            <div class="col-xs-5">
            <input type="text" class="form-control" name="newLastName" placeholder="<?php echo $oldLastName;?>" pattern="[A-Za-z]+">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Team</label>
            <div class="col-xs-5">
                <select name="newTeam" class="form-control">
                    <?php while ($row = $allTeamsResult->fetch()): ?>
                    <option value="<?php echo $row['abbreviation']; ?>">
                        <?php echo $row['teamName'] . " (" . $row['abbreviation'] . ")"; ?>
                    </option>
                    <?php endwhile; ?>
                <select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Number</label>
            <div class="col-xs-5">
            <input type="number" class="form-control" name="newNumber" placeholder="<?php echo $oldNumber;?>" min="1" max="99">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Position</label>
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
            <label class="control-label col-xs-2">Weight (lbs)</label>
            <div class="col-xs-5">
            <input type="number" class="form-control" name="newWeight" placeholder="<?php echo $oldWeight;?>" min="0">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Height (in)</label>
            <div class="col-xs-5">
            <input type="number" class="form-control" name="newHeight" placeholder="<?php echo $oldHeight;?>" min="0">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-xs-2">Draft Year</label>
            <div class="col-xs-5">
            <input type="number" class="form-control" name="newDraftYear" placeholder="<?php echo $oldDraftYear;?>" min="1946" max="2014">
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

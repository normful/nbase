<form method="GET" action="">
	Sort players by
	
	<select name="sort">
		<option value="lastname">Last Name</option>
		<option value="firstname">First Name</option>
		<option value="position">Position</option>
		<option value="number">Number</option>
		<option value="height">Height</option>
		<option value="weight">Weight</option>
		<option value="draftyear">Draft Year</option>
		<option value="team">Team</option>
	</select>
	
	<select name="order">
		<option value="asc">Ascending</option>
		<option value="desc">Descending</option>
	</select>
	
	<input type="hidden" name="filter" value="<?php echo $_GET['filter']; ?>">
	<input type="hidden" name="operator" value="<?php echo $_GET['operator']; ?>">
	<input type="hidden" name="value" value="<?php echo $_GET['value']; ?>">
	
	<input type="submit" value="Order">
</form>
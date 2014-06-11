<form method="GET">
	Show only players where
	
	<select name="filter">
		<option value="height">Height</option>
		<option value="weight">Weight</option>
		<option value="number">Number</option>
		<option value="year">Draft Year</option>
	</select>
	
	is
	
	<select name="operator">
		<option value="eq">=</option>
		<option value="noteq">≠</option>
		<option value="gt">></option>
		<option value="lt"><</option>
		<option value="gteq">≥</option>
		<option value="lteq">≤</option>
	</select>
	
	<input type="number" name="value" min=0 required>
	
	<input type="hidden" name="sort" value="<?php echo $_GET['sort']; ?>">
	<input type="hidden" name="order" value="<?php echo $_GET['order']; ?>">
	
	<input type="submit" value="Filter">
</form>

or <a href="<?php echo generateURL(['sort','order']); ?>">show all players</a>
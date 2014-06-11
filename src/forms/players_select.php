<form method="GET" action="">
	Choose the attributes to display <br>
	
	<input type="checkbox" name="sel_lname" value="y" checked> Last Name | 
	<input type="checkbox" name="sel_fname" value="y" checked> First Name | 
	<input type="checkbox" name="sel_pos" value="y" checked> Position | 
	<input type="checkbox" name="sel_num" value="y" checked disabled> Number | 
	<input type="checkbox" name="sel_height" value="y" checked> Height | 
	<input type="checkbox" name="sel_weight" value="y" checked> Weight | 
	<input type="checkbox" name="sel_year" value="y" checked> Draft Year | 
	<input type="checkbox" name="sel_team" value="y" checked disabled> Team 

	<input type="hidden" name="sel_team" value="y">
	<input type="hidden" name="sel_num" value="y">
	
	<input type="hidden" name="filter" value="<?php echo $_GET['filter']; ?>">
	<input type="hidden" name="operator" value="<?php echo $_GET['operator']; ?>">
	<input type="hidden" name="value" value="<?php echo $_GET['value']; ?>">
	<input type="hidden" name="sort" value="<?php echo $_GET['sort']; ?>">
	<input type="hidden" name="order" value="<?php echo $_GET['order']; ?>">
	
	<input type="submit" value="Go">
</form>
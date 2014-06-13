<form method="POST">
	Find the 
	<select name="operator">
		<option value="max">maximum</option>
		<option value="min">minimum</option>
		<option value="avg">average</option>
	</select>
	of the
	<select name="attribute">
		<option value="height">height</option>
		<option value="weight">weight</option>
		<option value="number">number</option>
		<option value="draftYear">draft year</option>
	</select>
	of all players
	<input type="hidden" name="mode" value="all">
	<input type="submit">
</form>
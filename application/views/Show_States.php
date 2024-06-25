<label for=""> State</label>
<select class="form-control" name="state" id="state" onchange="Get_cities(this.value);">
<option value="">Select state</option>
<?php 
	foreach($State_records as $rec)
	{
		echo "<option value=".$rec->id.">".$rec->name."</option>";
	}
?>
</select>	


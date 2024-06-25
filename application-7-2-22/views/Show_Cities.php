<label for=""> City</label>
<select class="form-control" name="city" id="city">
<option value="">Select city</option>
<?php 
	foreach($City_records as $rec)
	{
		echo "<option value=".$rec->id.">".$rec->name."</option>";
	}
?>
</select>		


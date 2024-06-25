<div class="form-group" id="Show_Partners">								
	<label for="exampleInputEmail1"><span class="required_info">*</span>Select Partner</label>
	<select class="form-control" data-error="Select Partner" required="required" name="Partner_id" id="Partner_id" required>
	<?php 
	foreach($State_records as $rec)
	{
		echo "<option value=".$rec['Partner_id'].">".$rec['Partner_name']."</option>";
	}
	?>
	</select>							
</div>
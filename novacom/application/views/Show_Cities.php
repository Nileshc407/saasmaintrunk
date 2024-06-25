

<div class="form-group" id="Show_Cities">
								
	<label for="exampleInputEmail1"><span class="required_info">*</span>&nbsp;City</label>
	<select class="form-control" name="city" id="city" required >
	<option value="">Select City</option>
		<?php 
			foreach($City_records as $rec)
			{
				echo "<option value=".$rec->id.">".$rec->name."</option>";
			}
		?>
	</select>							
</div>
<div class="form-group" id="Show_States">								
	<label for="exampleInputEmail1"><span class="required_info">*</span>&nbsp;State</label>
	<select class="form-control" name="state" id="state" required onchange="Get_cities(this.value);">
	<option value="">Select State</option>
		<?php 
			foreach($State_records as $rec)
			{
				echo "<option value=".$rec->id.">".$rec->name."</option>";
			}
		?>
	</select>							
</div>
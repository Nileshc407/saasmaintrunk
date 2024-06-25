
	<select class="txt" name="state" id="state1" onchange="Get_cities(this.value);">
	<option value="">Select State</option>
		<?php 
			foreach($State_records as $rec)
			{
				echo "<option value=".$rec->id.">".$rec->name."</option>";
			}
		?>
	</select>							

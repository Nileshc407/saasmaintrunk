
	<select class="txt" name="city" id="city">
		<option value="">Select City</option>
		<?php 
			foreach($City_records as $rec)
			{
				echo "<option value=".$rec->id.">".$rec->name."</option>";
			}
		?>
	</select>							

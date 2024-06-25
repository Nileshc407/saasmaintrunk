<div  id="Show_States">								
	<label for="exampleInputEmail1"><font id="Medium_font" >State:</font></label>
	<select class="select_css" name="state" id="state" required onchange="Get_cities(this.value);">
	<option value="">Select State</option>
		<?php 
			foreach($State_records as $rec)
			{
				echo "<option value=".$rec->id.">".$rec->name."</option>";
			}
		?>
	</select>							
</div>
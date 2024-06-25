<div id="Show_Cities">								
<label for="exampleInputEmail1"><font id="Medium_font" >City:</font></label>
	<select class="select_css" name="city" id="city" required >
		<option value="">Select City</option>
		<?php 
			foreach($City_records as $rec)
			{
				echo "<option value=".$rec->id.">".$rec->name."</option>";
			}
		?>
	</select>							
</div>
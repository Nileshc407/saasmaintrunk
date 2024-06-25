<select class="form-control" name="Segment_id" id="Segment_id" required>
<option value="">Select Segment First</option>
	<?php 
		foreach($Segment_records as $rec)
		{
			echo "<option value=".$rec->Segment_code.">".$rec->Segment_name."</option>";
		}
	?>
</select>							

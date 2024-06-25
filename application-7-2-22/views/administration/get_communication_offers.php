<select class="form-control" name="activeoffer" id="activeoffer">
	<option value="">Select Active Offer</option>
	<?php
	foreach($communication_offers_array as $communication_offers)
	{
		echo "<option value=".$communication_offers['id'].">".$communication_offers['communication_plan']."</option>";
	}
	?>
</select>

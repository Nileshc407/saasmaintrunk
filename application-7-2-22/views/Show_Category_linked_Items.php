
<div class="form-group" id="Item_codes">
	<label for=""><span class="required_info">*</span>Items Linked With Group</label>
	<select class="form-control" name="Condiment_item_code[]" required  multiple>
		<option value="">Select Items</option>
		<?php
			foreach($Category_items_list as $e)
			{
				echo "<option value='$e->Company_merchandize_item_code'>".$e->Merchandize_item_name."</option>";
			}
		?>
	</select>							
</div>
<?php	
foreach($Get_POS_group_values as $POS_group_val)
{
	
	?>
		<option value="<?php echo $POS_group_val->Condiment_item_code; ?>"><?php echo $POS_group_val->Merchandize_item_name; ?></option>
	<?php
	
}
?>
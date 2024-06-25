<option value="" >Select Main Group</option>
<?php	
if($MainGrpArray != null)
{
	foreach($MainGrpArray as $POS_main_group)
	{
		?>
			<option value="<?php echo $POS_main_group['Product_group_id']; ?>"><?php echo $POS_main_group['Product_group_name']; ?></option>
		<?php
		
	}
}
?>
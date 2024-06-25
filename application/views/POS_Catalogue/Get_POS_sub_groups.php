<option value="" >Select Sub Group</option>
<?php	
foreach($Get_POS_sub_groups as $POS_sub_group)
{
	
	?>
		<option value="<?php echo $POS_sub_group->Product_brand_id; ?>"><?php echo $POS_sub_group->Product_brand_name; ?></option>
	<?php
	
}
?>

<?php	
if($Tier_customers != NULL)
{
	foreach($Tier_customers as $cust_details)
	{
		
		?>
			<option value="<?php echo $cust_details->Enrollement_id; ?>" selected><?php echo $cust_details->First_name." ".$cust_details->Last_name; ?></option>
		<?php
		
	}
}
else
{
	echo '<option value="0">No Members Found</option>';
}	


?>

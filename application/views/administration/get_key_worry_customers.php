
<?php	
if($key_worry_customers != NULL)
{
	//echo '<option value="0">All Members</option>';
	foreach($key_worry_customers as $key_worry_cust)
	{
		$cust_details = $this->Igain_model->get_enrollment_details($key_worry_cust);
		if($cust_details != NULL)
		{
		?>
			<option value="<?php echo $cust_details->Enrollement_id; ?>" selected><?php echo $cust_details->First_name." ".$cust_details->Last_name; ?></option>
		<?php
		}
	}
}
else
{
	echo '<option value="0">No Members Found</option>';
}	


?>

<select class="form-control" name="user_name" id="user_name" required="required" data-error="Please select user name">
	<option value="">Select User Names</option>
	
	<?php
	$Merchant = "";
	
	if($User_names != NULL)
	{
	?>
	
		<option value="0">All</option>
	
	<?php
		foreach($User_names as $User)
		{
			if($User['Super_seller'] == 1)
			{
				$Merchant = " - Super Merchant";
			}
			else if($User['Sub_seller_admin'] == 1)
			{
				$Merchant = " - Sub Merchant Admin";
			}
			else
			{
				$Merchant = " - Merchant";
			}
			if($User['User_id'] == 6)
			{
				$Merchant = " - Call Center User";
			}
			if($User['User_id'] == 6 && $User['Sub_seller_admin'] == 1)
			{
				$Merchant = " - Call Center Supervisor";
			}
			if($User['User_id'] == 7)
			{
				$Merchant = " - Finance User";
			}
			if($User['User_id'] == 7 && $User['Sub_seller_admin'] == 1)
			{
				$Merchant = " - Finance Manager";
			}
			
		?>
		
			<option value="<?php echo $User['Enrollement_id']; ?>"><?php echo $User['First_name']." ".$User['Middle_name']." ".$User['Last_name']." ".$Merchant; ?></option>
		
		<?php
		}
	}
	?>
</select>

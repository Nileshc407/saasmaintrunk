<?php

	if(count($Client_company_array) > 0)
	{
?>
	<label for="exampleInputEmail1">Select Company Clients</label>
					
<select class="form-control" onchange="get_info(this.value);"  id="partner_client" name="partner_client">
	<option value="">Select Company Clients</option>
		<?php 
		
			foreach($Client_company_array as $Client_company)
			{
				echo "<option value=".$Client_company['Company_id'].">".$Client_company['Company_name']."</option>";
			} 
		?>
</select>	
<?php
}
?>

<table  class="table table-bordered table-hover">
	<thead>
	
	<tr>
		<th>Customer Name</th>
		<td><?php echo $cust_details->First_name." ".$cust_details->Last_name; ?></td>
	</tr>
	
	<tr>
		<th>Address</th>
		<td><?php echo App_string_decrypt($cust_details->Current_address); ?></td>
	</tr>

	<tr>
		<th>City</th>
		<td><?php echo $cust_details->City; ?></td>
	</tr>	

	<tr>
		<th>Email ID</th>
		<td><?php echo App_string_decrypt($cust_details->User_email_id); ?></td>
	</tr>
	
	<tr>
		<th>Phone No.</th>
		<td><?php echo App_string_decrypt($cust_details->Phone_no); ?></td>
	</tr>
	
	<tr>
		<th>Membership ID</th>
		<td><?php echo $cust_details->Card_id; ?></td>
	</tr>
	
	</thead>
</table>

<script>
$(document).ready(function() 
{	
	$( "#close_modal" ).click(function(e)
	{
		$('#custdetail_myModal').hide();
		$("#custdetail_myModal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
});
</script>
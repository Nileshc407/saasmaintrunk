<?php  
$ci_object = &get_instance();
$ci_object->load->model('CallCenter_model');
$ci_object->load->model('Igain_model');
?>
<!-- Modal content-->

		<div class="modal-header">
			<h4 class="modal-title text-center" style="color:red;">
				Call Center Query Interaction Details
			</h4>			
		</div>
		<div class="modal-body">
			<div class="table-responsive">
				<table  class="table table-bordered table-hover">
					<thead>
					<tr>
						<th>Log Query Ticket</th>		
						<th>Assigned/ Forwarded To</th>
						<th>Interaction Date</th>
						<th>Query Details</th>
						<th>Interaction Details</th>
						<th>Status</th>				
					</tr>
					<?php
					if($Memberquery_interaction != NULL)
					{
						foreach($Memberquery_interaction as $row)
						{														
						?>
					<tr>		
						<td class="text-center"><?php echo $row->Querylog_ticket;?> </td>
						<?php $get_enrollment = $ci_object->Igain_model->get_enrollment_details($row->Query_assign); ?>
						<td class="text-center"><?php echo $get_enrollment->First_name.' '.$get_enrollment->Last_name; ?>
						</td>
						<td class="text-center"><?php echo $row->Creation_date; ?> </td>
						<td class="text-center"><?php echo $row->Query_details; ?> </td>
						<td class="text-center"><?php echo $row->Query_interaction; ?> </td>
						<td class="text-center"><?php echo $row->Query_status; ?> </td>			
					</tr>
				<?php }
					}
					?>
					</thead>
				</table>
			</div>		
		</div>
		
	
<!-- Modal content-->

<script>
$(document).ready(function() 
{	
	$( "#close_modal" ).click(function(e)
	{
		$('#receipt_myModal').hide();
		$("#receipt_myModal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
});
</script>

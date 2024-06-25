<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			 
			
		<div class="modal-body">
		<div class="text-center">e-Voucher Update Breakup details</div>
			<div class="table-responsive">
				<table  class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Member Name</th>		
							<th>Voucher No</th>						
							<th>Upadte Date</th>					
							<th>Used Quantity</th>						
						</tr>
					</thead>
					<thead>
					<?php 
					$count = count($transaction_details);
					// echo"---count--".$count."--<br>";
					if($count > 0)
					{	
						foreach($transaction_details as $trans ) 
						{
						?>
						<tr>
						<th><?php echo $trans->First_name.' '.$trans->Last_name; ?></th>
						<th><?php echo $trans->Voucher_no?></th>
						<th><?php echo date('d-M-Y',strtotime($trans->Update_date));?></th>
						<th><?php echo $trans->Updated_quantity?></th>
						<tr>
						<?php 
						}
					}
					else
					{
					?>
						<tr>
						<td colspan="4"><span class="required_info">No Records have been USED!</span></td>
						
						<tr>
					<?php }
					?>
					</thead>
				</table>
			</div>
			
			
		</div>
		
	</div>
	<div class="modal-footer">
			<button type="button" id="print_modal" onclick="window.print();" class="btn btn-primary">Print</button>
			<button type="button" id="close_modal" class="btn btn-primary">Cancel</button>
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

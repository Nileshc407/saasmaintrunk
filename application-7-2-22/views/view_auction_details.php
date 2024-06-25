<div class="element-wrapper">                
	<div class="element-box">
	  <h5 class="form-header">
	  Auction Details
	  </h5>       
		<?php
			if($auction_results != NULL)
			{
		?>	  
	  <div class="table-responsive">
		<table id="dataTable2" width="100%" class="table table-striped table-lightfont">
			<thead>
				<tr>
				<th class="text-center">Auction Name</th>
				<th class="text-center">Prize</th>
				<th class="text-center">Validity</th>
				<th class="text-center">Reminder Trigger Notification Days After Validity Starts</th>
				<th class="text-center">Reminder Trigger Notification Days After Validity Ends</th>
				</tr>
			</thead>	
				

			<tbody>
					<tr>

							<td class="text-center"><?php echo $auction_results->Auction_name; ?></td>
							<td><?php echo  $auction_results->Prize; ?> </td>	
							<td><?php echo  date("m/d/Y", strtotime($auction_results->From_date))." To ".date("m/d/Y", strtotime($auction_results->To_date)); ?> </td>	
							<td><?php echo $auction_results->Trigger_notification_start_days;?></td>
							<td><?php echo $auction_results->Trigger_notification_end_days;?></td>
			
					</tr>					
			</tbody> 
			</table>
		  </div>
	  <?php
		}
		
	?>
		</div>
	  </div>
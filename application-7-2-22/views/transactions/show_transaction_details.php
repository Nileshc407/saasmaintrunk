	<div class="table-responsive">
	
	<table  class="table table-bordered table-hover">
		<thead>
		<tr >
			<th>Transaction Date</th>
			<th>Transaction Type</th>
			<th>Purchase Amount</th>
			<th>Points Redeemed</th>
			<th>Balance Paid</th>
			<th>Gained Points</th>
			<th>Transaction By</th>
		</tr>
		</thead>

		<tbody>
		<?php
		$Total_Purchase_amount=array();
		$Total_Redeem_points=array();
		$Total_balance_to_pay=array();
		$Total_gained_points=array();
		if($transaction_details)
		{
			//print_r($transaction_details);
			foreach($transaction_details as $trans_details)
			{
					if($trans_details['Purchase_amount']==0 && $trans_details['Redeem_points']==0 && $trans_details['balance_to_pay']==0 && $trans_details['Loyalty_pts']==0 && $trans_details['Topup_amount']==0){
						continue;
					}
					$Redeem_points=0;
				if($trans_details['Trans_type']=='Loyalty Transaction')
				{
					$Redeem_points=$trans_details['Redeem_points'];
				}
				if($trans_details['Trans_type']=='Only Redeem')
				{
					$Redeem_points=$trans_details['Redeem_points'];
				}
				if($trans_details['Trans_type']=='Redemption')
				{
					$Redeem_points=$trans_details['Redeem_points']*$trans_details['Quantity'];
				}
				$Total_Purchase_amount[]=$trans_details['Purchase_amount'];
				$Total_Redeem_points[]=$Redeem_points;
				$Total_balance_to_pay[]=$trans_details['balance_to_pay'];
		?>
				<tr>
					<td><?php echo $trans_details['Trans_date']; ?></td>
					<td><?php echo $trans_details['Trans_type']; ?></td>
					<td><?php if($trans_details['Purchase_amount']==0){echo "-";}else {echo $trans_details['Purchase_amount']; }?></td>
					<td><?php if($Redeem_points==0){echo "-";}else {echo $Redeem_points; }?></td>
					<td><?php if($trans_details['balance_to_pay']==0 && $trans_details['Trans_type']!="Loyalty Transaction"){echo "-";}else {echo $trans_details['balance_to_pay']; }?></td>
					
					
					<td>
						<?php 
						if($trans_details['Loyalty_pts'] != 0)
						{
							echo $trans_details['Loyalty_pts']; 
							$Total_gained_points[]=$trans_details['Loyalty_pts'];
						}
						elseif($trans_details['Topup_amount'] != 0)
						{
							echo $trans_details['Topup_amount']; 
							$Total_gained_points[]=$trans_details['Topup_amount'];
						}
						else
						{
							if($trans_details['Trans_type']!="Loyalty Transaction")
							{
								echo "-";
							}
							
						}
						?>
					</td>
					<td><?php echo $trans_details['Seller_name']; ?></td>
				</tr>
		<?php
			}
		// }
		?>
		
		<?php	
		/* foreach($transaction_sum_details as $trans_sum_details)
		{
			$total_gainpts = ($trans_sum_details['Loyalty_pts']) + ($trans_sum_details['Topup_amount']); */
		?>
			<tr>
				<td>&nbsp;</td>
				<td>Total</td>
				<td><?php echo array_sum($Total_Purchase_amount); ?></td>
				<td><?php echo array_sum($Total_Redeem_points); ?></td>
				<td><?php echo array_sum($Total_balance_to_pay); ?></td>
				
				<td><?php echo array_sum($Total_gained_points); ?></td>
				<td></td>
			</tr>
		<?php
		//}
		} else { ?> 
			
			<tr>
				
				<td colspan="7" class="text-center">No Records found</td>
				
			</tr>
		<?php 
		}
		?>
		</tbody>
	</table>
</div>
<script>
$(document).ready(function() 
{	
	$( "#close_modal" ).click(function(e)
	{
		$('#detail_myModal').hide();
		$("#detail_myModal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
});
</script>

	
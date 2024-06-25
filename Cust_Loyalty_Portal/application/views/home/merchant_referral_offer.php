<?php if($MerchantReferralOffers != NULL) { ?>
<div class="modal-content">	
	<div class="modal-body" style="overflow: auto;">
	
		<table  class="table table-bordered table-hover" id="detail_myModal">
			<thead>
				<h4 class="modal-title" style="background-color:#31859C;color:#fff;text-align:center; width:100%">Referral Campaigns</h4>
				<tr>
					<th>Referral Rule For</th>
					<th>Campaign Start Date</th>
					<th>Campaign End Date</th>
					<th>Refree Topup</th>
					<th>Member Topup</th>
				</tr>					  
			</thead>

			<tbody>
			<?php
			$todays = date("Y-m-d");
			foreach($MerchantReferralOffers as $offer_details)
			{
				if( ($todays >= $offer_details['From_date']) && ($todays <= $offer_details['Till_date']) )
				{ 		
				?>
				
					<tr>
						<td>
							<?php
							if($offer_details['Referral_rule_for'] == '1')
							{
								echo "Enrollment";
							}
							else
							{
								echo "Transaction";
							}
							?>
						</td>
						<td><?php echo $offer_details['From_date']; ?></td>
						<td><?php echo $offer_details['Till_date']; ?></td>
						<td><?php echo $offer_details['Refree_topup']; ?></td>
						<td><?php 
							if( $offer_details['Customer_topup'] == "" || $offer_details['Customer_topup'] ==0 ){
								echo $offer_details['Customer_topup']='-';
							}
							else
							{
								echo $offer_details['Customer_topup']=$offer_details['Customer_topup'];
							}

						?></td>
					</tr>
				
				<?php
				}
			}	
			?>
			</tbody>
		</table>

		<?php } else { ?>

				<div class="progress-bar" style="width: 100%;height:10%"><span class="info-box-number" >Currently No Loyalty Offers</span></div>
				
		<?php } ?>
	
	</div>
	
	<div class="modal-footer">
		<button type="button" id="close_modal3" class="btn btn-default">Close</button>
	</div>
				
</div>

<script>
$(document).ready(function() 
{	
	$( "#close_modal3" ).click(function(e)
	{
		$('#referral_Modal').hide();
		$("#referral_Modal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
});
</script>


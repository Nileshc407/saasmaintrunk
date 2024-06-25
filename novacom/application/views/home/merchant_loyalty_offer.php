<script src="<?php echo base_url()?>assets/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>
<?php 
// echo"ci_object----";
// $ci_object = &get_instance();
// $ci_object->load->model('Igain_model'); 
if($MerchantLoyaltyDetails != NULL)
	{	
	?>	
<table  class="table table-bordered table-hover" id="detail_myModal">	
	<thead>
	 	<h4 class="modal-title" style="background-color:#31859C;color:#fff;text-align:center">Loyalty Rule</h4>
	</thead>
	<tbody>
	<?php
// echo"ci_object----".$ci_object;
	$i=1;
	$todays=date("Y-m-d");
	// echo $todays."<br>";  
	// echo "MerchantLoyaltyDetails----".$offerCount=Count($MerchantLoyaltyDetails);
	$offerCount=Count($MerchantLoyaltyDetails);
	echo"<tr><th>Name Of Offer</th><th>Offer Detail</th><th>Validity</th><th>For Whom</th></tr>";
		foreach($MerchantLoyaltyDetails as $offer_details)
		{
			
			if($i<=$offerCount)
			{
				if($offer_details['Tier_name'] == NULL)
				{
					$Lp_tier_name = "ALL";
				}
				else
				{
					$Lp_tier_name = $offer_details['Tier_name'];
				}
				
					$str = substr($offer_details['Loyalty_name'],0,2);
					if($str=='BA')
					{
						$str1='Balance to pay Amount';
					}
					if($str=='PA')	
					{
						$str1='Purchase Amount';
					}
					if($offer_details['Loyalty_at_transaction'] != '0.00')
					{
						echo "<tr><td>".$offer_details['Loyalty_name']." </td><td>".$offer_details['Loyalty_at_transaction']." %  On Every Transaction  </td><td>".date('d-M-Y',strtotime($offer_details['From_date']))." To  : ".date('d-M-Y',strtotime($offer_details['Till_date']))."</td><td>'".$Lp_tier_name."' Tier Members </td></tr>";
						// echo "</tr><td></td><td></td>";
						

					}
					else
					{
						echo "<tr><td>".$offer_details['Loyalty_name']."</td><td>Get".$offer_details['discount']." %  discount on  ".$offer_details['Loyalty_at_value']." ".$str1." ,</td><td>".date('d-M-Y',strtotime($offer_details['From_date']))." To  : ".date('d-M-Y',strtotime($offer_details['Till_date']))."</td><td>'".$Lp_tier_name."' Tier Members</td></tr>";
						// echo "</tr><td></td><td></td>";
					
					}
				// }
			}
			$i++;
		}
		
	?>
	</tbody>
</table>
<?php } 
	else
	{
	?>
		<div class="progress-bar" style="width: 100%;height:10%">
		<span class="info-box-number" >Currently No Loyalty Offers</span>
		</div>
	<?php
	}
	?>
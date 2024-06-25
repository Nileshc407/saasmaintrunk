<?php if($Trans_Records != NULL) {  
// error_reporting(0);
?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Partner Merchandize Catalogue Report: <?php if($Report_type == 1) { echo "Details"; } else { echo "Summary"; } ?></h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($From_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>		
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo date("Y-m-d"); ?></h5>
	</div>	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">		
				<thead>					
					<tr style="background-color: #D9EDF7;">
					<?php if($Report_type == 1) 
					{ ?>
						<th>Transaction Date</th>
						<th>Trans Type</th>
						<th>Partner Name</th>
						<th>Partner Branch</th>
						<th>Membership ID</th>
						<th>Member Name</th>
						<!--<th>Item Code</th>-->
						<th>Item Name</th>
						<th>Quantity</th>
						<th>Item size</th>
						<!--<th>Purchase Amount <?php //echo '('.$Symbol_of_currency.')'; ?></th>
						-->
						<th>Redeemed <?php echo $Company_details->Currency_name; ?></th>
						<th>Total Redeemed <?php echo $Company_details->Currency_name; ?></th>
						<th>Shipping <?php echo $Company_details->Currency_name; ?></th>
						<th>Voucher No.</th>
						<th>Voucher Status</th>
						<th>Cost Payable to Partner</th>
						<th>Payment Status</th>
						<th>Remarks</th>	
					<?php 
					} 
					else
					{ ?>
						<tr style="background-color: #D9EDF7;">
							<th>Month</th>
							<th>partner Name</th>
							<th>Partner Branch</th>
							<th>Voucher Status</th>
							<th>Total Quantity</th>
							<!--<th>Total Purchase Amount <?php //echo '('.$Symbol_of_currency.')';?></th>-->
							<th>Total Redeemed <?php echo $Company_details->Currency_name; ?></th>
							<th>Total Cost Payable to Partner</th>
						</tr>
					
					<?php 
					}
					?>
					</tr>
				</thead>
				<tbody>
						<?php
						$todays = date("Y-m-d");				
						if($Trans_Records != NULL)
						{	
							foreach($Trans_Records as $row)
							{							
								if($Report_type == 1)
								{	
									if($row->Status=="Used" || $row->Status=="Expired")
									{
										$color="red";
									}	
									else
									{
										$color="green";
									}
									if($row->Payment_status== "Paid")
									{
										$color1="green";
									}
									else
									{
										$color1="red";
									}
									
									echo "<tr>"; 
										echo "<td>".$row->Trans_date."</td>";
										echo "<td>".$row->Trans_type."</td>";
										echo "<td>".$row->Partner_name."</td>";
										echo "<td>".$row->Branch_name."</td>";
										echo "<td>".$row->Membership_ID."</td>";
										echo "<td>".$row->First_name.' '.$row->Last_name."</td>";
										// echo "<td>".$row->Item_code."</td>";
										echo "<td>".$row->Merchandize_item_name."</td>";
										echo "<td>".$row->Quantity."</td>";
										echo "<td>".$row->Item_size."</td>";
										/*
										echo "<td>".$row->Purchase_amount."</td>";
										echo "<td>".$row->Shipping_cost."</td>";							echo "<td>".$row->Redeem_points_per_Item."</td>"; 
										*/
										echo "<td>".$row->Redeem_points."</td>";
										echo "<td>".$row->Total_Redeem_points."</td>";
										echo "<td>".$row->Shipping_points."</td>";
										echo "<td>".$row->Voucher_no."</td>";						echo "<td style='color:$color;'>".$row->Status."</td>";
										echo "<td>".$row->Cost_payable_partner."</td>";
										echo "<td style='color:$color1;'>".$row->Payment_status."</td>";
										echo "<td>".$row->Remarks."</td>";
									echo "</tr>";									
								}
								else
								{
									echo "<tr>";
										echo "<td>".$row->Trans_monthyear."</td>";		
										echo "<td>".$row->Partner_name."</td>";		
										echo "<td>".$row->Branch_name."</td>";		
										echo "<td>".$row->Status."</td>";	
										echo "<td>".$row->total_voucher."</td>";	
										//echo "<td>".$row->total_purchase_amt."</td>";	
										echo "<td>".$row->Total_points."</td>";	
										echo "<td>".$row->Total_cost_pay_to_partnet."</td>";	
									echo "</tr>";	
								}
							}
						}
						?>			
				</tbody> 
		</table>
	</div>
</div>
<?php } ?>
<?php if($Trans_Records != NULL) { 

//error_reporting(0);
 
?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Merchandize Partner Redemption Report</h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($From_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
		
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo date("Y-m-d"); ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
				<thead>
						
						<tr style="background-color: #D9EDF7;">
						<th>Transaction Date</th>
						<th>M. Partner Name</th>
						<th>M. Partner Branch</th>
						<th>Item Code</th>
						<th>Item Name</th>
						<th>Issued Quantity</th>
						<th>Used Quantity</th>
						<th>Redeem <?php echo $Company_details->Currency_name; ?>  per Item</th>
						<th>Total Redeemed <?php echo $Company_details->Currency_name; ?> </th>
						<th>Voucher No.</th>
						<th>Voucher Status</th>
						<th>Cost Payable to Partner</th>
						
						
					</tr>
						
						</thead>
						
						<tbody>
						<?php
						$todays = date("Y-m-d");
						
						
					
						if($Trans_Records != NULL)
						{
							//print_r($Trans_Records);die;
							
							//$From_date=$_REQUEST["start_date"];
							//echo '<table  class="table table-bordered table-hover">';
							$lv_Card_id=0;
							
							foreach($Trans_Records as $row)
							{
								$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
								$Card_id=$row->Membership_ID;
								$Enrollement_id=$row->Enrollement_id;
								
								/* if($lv_Card_id!=$Card_id)
								{
									echo "<tr><td colspan='12'><font color='blue'><h4>".$Full_name." (".$Card_id.")</font></h4></td></tr>";
								} */
								
								
									if($row->Voucher_status=="Issued" || $row->Voucher_status=="Ordered")
									{
										$color="green";
									}
									else
									{
										$color="red";
									}
									
									echo "<tr>";?>
									
									<?php 
									echo "<td>".$row->Trans_date."</td>";
									echo "<td>".$row->Partner_name."</td>";
									echo "<td>".$row->Branch_name."</td>";
									echo "<td>".$row->Item_code."</td>";
									echo "<td>".$row->Merchandize_item_name."</td>";
									echo "<td>".$row->Quantity."</td>";
									echo "<td>".$row->Used_quantity."</td>";
									
									echo "<td>".$row->Redeem_points_per_Item."</td>";
									echo "<td>".$row->Redeem_points*$row->Quantity."</td>";
									echo "<td>".$row->Voucher_no."</td>";
									
									echo "<td style='color:$color;'>".$row->Voucher_status."</td>";
									echo "<td>".$row->Cost_payable_to_partner."</td>";
									echo "</tr>";
									$lv_Card_id=$Card_id;
							}
						}
						?>			
			</tbody> 
		</table>
		</table>
	</div>
</div>
<?php } ?>
<?php if($Trans_Records != NULL) { 

//error_reporting(0);

if($report_type==1){
	$report_type_name="Details";
}
else
{
	$report_type_name="Summary";
}
?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Member Catalogue Report: <?php echo $report_type_name;?></h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($From_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
		
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo $Report_date; ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>
						<?php if($report_type==1){ //Details?>
						<tr>
						<th>Transaction Date</th>
						<th>Trans Type</th>
						<th>Membership ID</th>
						<th>Member Name</th>
						<th>Item Name</th>
						<th>Qty</th>
						<th>Item Size</th>
						<th>Partner Name</th>
						<th>Partner Branch</th>
						<th>Topup Amount</th>
						<th>Purchase Amount <?php echo '('.$Symbol_of_currency.')'; ?></th>
						<th>Redeem <?php echo $Company_details->Currency_name; ?></th>
						<th>Total Redeemed <?php echo $Company_details->Currency_name; ?></th>
						<th>Voucher No.</th>
						<th>Voucher Status</th>
						<th>Issued By</th>
						<th>Utilized Date</th>
						<th>Updated By</th>
						
					</tr>
						<?php }else{ //Summary?>
						<tr>
							<!--<th class="text-center">Details</th>-->
							<th>Month</th>
							<th>partner Name</th>
							<th>Partner Branch</th>
							<th>Voucher Status</th>
							<th>Total Quantity</th>
							<th>Total Purchase Amount <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Total Redeemed <?php echo $Company_details->Currency_name; ?></th>
							
							
						</tr>
						<?php } ?>
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
								$Member_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
								$Card_id=$row->Membership_ID;
								//$Enrollement_id=$row->Enrollement_id;
								//echo "<br>lv_Card_id ".$lv_Card_id." Card_id ".$Card_id;
								/* if($lv_Card_id!=$Card_id)
								{
									echo "<tr  style='background-color: #C8E0D6;'><td colspan='13'>".$Full_name." (".$Card_id.")</td></tr>";
								} */
								
								
								
								if($report_type==1)//Details
								{
									if($row->Voucher_status=="Issued" || $row->Voucher_status=="Ordered")
									{
										$color="green";
										$Utilized_date="-";
									}
									else if($row->Voucher_status=="Delivered")
									{
										$color="green";
										$Utilized_date=$row->Update_date;
									}
									else if($row->Voucher_status=="Shipped")
									{
										$color="green";
										$Utilized_date=$row->Update_date;
									}
									else
									{
										$color="red";
										$Utilized_date=$row->Utilized_date;
									}
									$Total_points=($row->Redeem_points_per_Item*$row->Quantity);
									
									$ci_object = &get_instance();
									$ci_object->load->model('Igain_model');
									
									$user_details = $this->Igain_model->get_enrollment_details($row->Updated_Enrollment);					
									$Updated_by = $user_details->First_name.' '.$user_details->Last_name;					
									$user_details = $this->Igain_model->get_enrollment_details($row->Issued_Enrollment);
									$Issued_by = $user_details->First_name.' '.$user_details->Last_name;
									
									echo "<tr>";?>
									<?php echo "<td>".$row->Trans_date."</td>";
									echo "<td>".$row->Trans_type."</td>";
									echo "<td>".$Card_id."</td>";
									echo "<td>".$Member_name."</td>";
									 
									//echo "<td>".$row->Item_code."</td>";
									echo "<td>".$row->Merchandize_item_name."</td>";
									echo "<td>".$row->Quantity."</td>";
									echo "<td>".$row->Item_size."</td>";
									echo "<td>".$row->Partner_name."</td>";
									echo "<td>".$row->Branch_name."</td>";
									if($row->Topup_amount!=0)
									{
									echo "<td>".$row->Topup_amount."</td>";
									}
									else
									{
										echo "<td>-</td>";
									}
									if($row->Purchase_amount!=0)
									{
										echo "<td>".$row->Purchase_amount."</td>";
									}
									else
									{
										echo "<td>-</td>";
									}
									echo "<td>".$row->Redeem_points_per_Item."</td>";
									echo "<td>".$row->Total_Redeem_points."</td>";
									echo "<td>".$row->Voucher_no."</td>";
									echo "<td style='color:$color;'>".$row->Voucher_status."</td>";
									echo "<td>".$Issued_by."</td>";
									echo "<td>".$Utilized_date."</td>";
									echo "<td>".$Updated_by."</td>";
									echo "</tr>";
					
								}
								else
								{?>
									<tr>
									<td><?php echo $row->Trans_monthyear;?></td>
									<td><?php echo $row->Partner_name; ?> </td>		
									<td><?php echo $row->Branch_name; ?> </td>	
									<td><?php echo $row->Voucher_status;?></td>
									<td><?php echo $row->Total_Quantity;?></td>
									<td><?php echo $row->total_purchase_amt;?></td>	
									<td><?php echo $row->Total_points;?></td>	
									</tr>
						<?php   }
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
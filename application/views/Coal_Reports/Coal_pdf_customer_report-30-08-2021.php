<?php if($Trans_Records != NULL) { 
error_reporting(0);
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
		<h2 style="text-align:center">Member Transaction Report: <?php echo $report_type_name;?></h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($From_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
		
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo $Report_date; ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>
			<?php if($report_type==1){ //Details?>
						<tr style="background-color: #D9EDF7;">
						<th>Transaction Date</th>
						<th>Member Name</th>
						<th>Membership ID</th>
						<th>Transaction Type</th>
						<th>Bill No.</th>
						<th>Purchase amount <?php echo "($Symbol_currency)"; ?></th>
						<th>Redeem <?php echo $Company_details->Currency_name; ?></th>
						<?php
									if($Enable_company_meal_flag==1){echo '<th>Meal Topup</th>';}else{echo '<th>Bonus '.$Company_details->Currency_name.'</th>';}
								?>
					
						<!--<th>Loyalty Points</th>
						<th>Coalition Loyalty Points</th>-->
						<th>Transfer To/From</th>
						<th>Transfer <?php echo $Company_details->Currency_name; ?></th>
						<th>Remarks</th>
                                                
						
					</tr>
						<?php }else{ //Summary?>
						<tr style="background-color: #D9EDF7;">
							<th>Transaction Type</th>
							<th>Total Redeem <?php echo $Company_details->Currency_name; ?></th>
							<!--<th>Total Gained Points</th>
							<th>Total Coalition Loyalty Points</th>-->
							<?php
									if($Enable_company_meal_flag==1){echo '<th>Total Meal Topup</th>';}else{echo '<th>Total Bonus '.$Company_details->Currency_name.'</th>';}
								?>
							<th>Total Purchase Amount <?php echo "($Symbol_currency)"; ?></th>
							<th>Total Transfered <?php echo $Company_details->Currency_name; ?></th>
						</tr>
						<?php } ?>
			</thead>
			
			<tbody>
			<?php
						$todays = date("Y-m-d");
						
						/*  */
					
						// print_r($Trans_Records);
						// die;
						if($Trans_Records != NULL)
						{
							//print_r($Trans_Records);die;
							
							//$From_date=$_REQUEST["start_date"];
							//echo '<table  class="table table-bordered table-hover">';
							$lv_Card_id=0;							
							foreach($Trans_Records as $row)
							{
								$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
								$Membership_ID=$row->Membership_ID;
								$Tier_name=$row->Tier_name;
								if($lv_Card_id!=$Membership_ID && $report_type==2)
								{
									// echo "<tr  style='background-color: #C8E0D6;'><td colspan='12'>".$Full_name." (".$Membership_ID.")</td></tr>";
									echo "<tr style='background-color: #C8E0D6;'><td colspan='12'><b>".$Full_name." (".$Membership_ID.")   Tier : ". $Tier_name." </b></td></tr>";
								}							
								if($report_type==1)//Details
								{
							
									if($row->Purchase_amount==0)
									{
										$row->Purchase_amount="-";
									}
									if($row->Redeem_points==0)
									{
										$row->Redeem_points="-";
									}
									if($row->Paid_amount==0)
									{
										$row->Paid_amount="-";
									}
									if($row->Topup_amount==0)
									{
										$row->Topup_amount="-";
									}
									/* if($row->Loyalty_pts==0)
									{
										$row->Loyalty_pts="-";
									} */
									if($row->Transfer_to==0)
									{
										$row->Transfer_to="-";
									}
									if($row->Transfer_points==0)
									{
										$row->Transfer_points="-";
									}
									if($row->Bill_no==0)
									{
										$row->Bill_no="-";
									}
									
									
									echo "<tr>";
									
									echo "<td>".$row->Trans_date."</td>";
									echo "<td>".$Full_name."</td>";
									echo "<td>".$Membership_ID."</td>";
									echo "<td>".$row->Trans_type."</td>";
									echo "<td>".$row->Bill_no."</td>";
									echo "<td>".$row->Purchase_amount."</td>";
									echo "<td>".$row->Redeem_points."</td>";
									echo "<td>".$row->Topup_amount."</td>";
									/* echo "<td>".$row->Loyalty_pts."</td>";
									 echo "<td>".$row->Coalition_Loyalty_pts."</td>"; */
									echo "<td>".$row->Transfer_to."</td>";
									echo "<td>".$row->Transfer_points."</td>";
									echo "<td>".$row->Remarks."</td>";
                                    echo "</tr>";
							
								}
								else
								{
									if($row->Total_Redeem==0)
									{
										$row->Total_Redeem="-";
									}
									/* if($row->Total_Gained_Points==0)
									{
										$row->Total_Gained_Points="-";
									} */
									if($row->Total_Purchase_Amount==0)
									{
										$row->Total_Purchase_Amount="-";
									}
									if($row->Total_Transfer_Points==0)
									{
										$row->Total_Transfer_Points="-";
									}
									if($row->Total_Bonus_Points==0)
									{
										$row->Total_Bonus_Points="-";
									}							
									
										?>
									<tr>								
									<td><?php echo $row->Trans_type;?></td>
									<td><?php echo $row->Total_Redeem;?></td>
									<!--<td><?php //echo $row->Total_Gained_Points;?></td>
									<td><?php //echo $row->Total_Coalition_Loyalty_pts;?></td>-->
									<td><?php echo $row->Total_Bonus_Points;?></td>
									<td><?php echo $row->Total_Purchase_Amount; ?> </td>
									<td><?php echo $row->Total_Transfer_Points; ?> </td>
                                                                    
									</tr>
							<?php   }
								$lv_Card_id=$Membership_ID;
							}
						}
						?>			
			</tbody> 
		</table>
		</table>
	</div>
</div>
<?php } ?>
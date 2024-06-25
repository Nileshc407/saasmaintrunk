<?php if($Trans_Records != NULL) { 

//error_reporting(0);

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Member High Value Transaction Report</h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("d M Y",strtotime($From_date))." To Date: ".date("d M Y",strtotime($end_date)); ?></h4>
		
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo date("d M Y"); ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>
						<?php
							$lv_Company_id = $_REQUEST["Company_id"];
							$start_date = $_REQUEST["start_date"];
							$end_date = $_REQUEST["end_date"];
							$Value_type = $_REQUEST["Value_type"];
							$Operatorid = $_REQUEST["Operatorid"];
							$Criteria = $_REQUEST["Criteria"];
							$Criteria_value = $_REQUEST["Criteria_value"];
							
							if($Operatorid==1)
							{
								$Criteria_value2 =0;
							}
							else
							{
								$Criteria_value2 =$_REQUEST["Criteria_value2"];
							}
						if($Value_type==1)//High Value 
						{ ?>
						<tr>
							<th>Transaction Date</th>
							<th>Transaction Type</th>
							<th>Bill No.</th>
							<th>Purchase Amount <?php echo "($Symbol_of_currency)"; ?></th>
							<th>Redeemed <?php echo $Company_details->Currency_name; ?> </th>
							<th>Gained <?php echo $Company_details->Currency_name; ?> </th>
							<th>Balance Paid</th>
						</tr>
						<?php }else{ ?>
						<tr>
							<th>Member Name</th>
							<th>Membership ID</th>
							<th>Transaction Type</th>
							<th>Total Purchase Amount <?php echo "($Symbol_of_currency)"; ?></th>
							<th>Total Redeemed <?php echo $Company_details->Currency_name; ?> </th>
							<th>Total Gained <?php echo $Company_details->Currency_name; ?> </th>
							<th>Total Balance Paid</th>
						</tr>
						<?php } ?>
						</thead>
						
						<tbody>
						<?php
						
						if($Trans_Records != NULL)
						{
							$lv_Enrollement_id=0;
							
							foreach($Trans_Records as $row)
							{
								$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
								$Membership_ID=$row->Membership_ID;
								$Enrollement_id=$row->Enrollement_id;
								$Show_member=0;
								
								
								if($row->Redeem_points==0)
								{
									$row->Redeem_points="-";
								}
								
								
							
									$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
									$Current_balance=$row->Current_balance;
									if($Value_type==1)//High Value
									{
										if($lv_Enrollement_id!=$Enrollement_id)
										{
											echo "<tr  style='background-color: #C8E0D6;'><td colspan='12' style='color:blue;'>".$Full_name." (".$Membership_ID.")</td></tr>";
										}
										?>
										<tr>
									
										<td><?php echo $row->Trans_date;?></td>
										<td><?php echo $row->Trans_type;?></td>
										<td><?php echo $row->Bill_no;?></td>
										<td><?php echo $row->Purchase_amount;?></td>
										<td><?php echo $row->Redeem_points;?></td>
										<td><?php echo $row->Loyalty_pts;?></td>
										<td><?php echo $row->balance_to_pay;?></td>
									
										</tr>
						<?php   
									}
									else
									{ 
										if($Criteria==1)//Purchase
										{
											$Total_value=$row->Total_Purchase_Amount;
										}	
										else //Gained Points
										{
											$Total_value=$row->Total_Gained_Points;
										}
										
										if($Operatorid=="<")
										{
											if($Total_value < $Criteria_value)
											{
												$Show_member=1;
											}
										}
										if($Operatorid=="<=")
										{
											if($Total_value <= $Criteria_value)
											{
												$Show_member=1;
											}
										}
										if($Operatorid==">")
										{
											if($Total_value > $Criteria_value)
											{
												$Show_member=1;
											}
										}
										if($Operatorid==">=")
										{
											if($Total_value >= $Criteria_value)
											{
												$Show_member=1;
											}
										}
										if($Operatorid=="=")
										{
											if($Total_value == $Criteria_value)
											{
												$Show_member=1;
											}
										}
										if($Operatorid=="!=")
										{
											if($Total_value != $Criteria_value)
											{
												$Show_member=1;
											}
										}
										if($Operatorid=="Between")
										{
											$Criteria_value2 =$_REQUEST["Criteria_value2"];
											if(($Total_value >= $Criteria_value) && ($Total_value <= $Criteria_value2))
											{
												$Show_member=1;
											}
										}
										
										
										if($Show_member==1)
										{
								?>
											<tr>
												<td><?php echo $Full_name;?></td>
												<td><?php echo $row->Membership_ID;?></td>
												<td><?php echo $row->Trans_type;?></td>
												<td><?php echo $row->Total_Purchase_Amount; ?> </td>
												<td><?php echo $row->Total_Redeemed_Points;?></td>
												<td><?php echo $row->Total_Gained_Points;?></td>
												<td><?php echo $row->Total_balance_to_pay;?></td>
											</tr>
							<?php		} 
									}
									$lv_Enrollement_id=$Enrollement_id;
							
							}
						}
						
						?>			
			</tbody> 
		</table>
		</table>
	</div>
</div>
<?php } ?>
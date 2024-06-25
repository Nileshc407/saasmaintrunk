<?php if($Trans_Records != NULL) { 

//error_reporting(0);

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div> 
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Member Balance Report</h2>
		
		
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo date("d M Y"); ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>
						
						<tr>
						<th>Membership ID</th>
						<th>Member Name</th>
						<th>Tier Name</th>
							<th>Joined Date</th>
							
							
							<th>Current Address</th>
							<th>City</th>
							<th>State</th>
							<th>Phone no</th>
							<th>User Email ID</th>
							<th>Total Purchase Amount <?php echo "($Symbol_currency)"; ?></th>
							<th>Total Gained  <?php echo $Company_details->Currency_name; ?></th>

							<th>Total Redeemed  <?php echo $Company_details->Currency_name; ?></th>
							<th>Current Balance</th>
							<th>Gift Card Purchase Amount <?php echo "($Symbol_currency)"; ?></th>
							<th>Gift Card Redeemed Amount <?php echo "($Symbol_currency)"; ?></th>
											   
							<th>Active</th>
							<th>Enrolled by</th> 
							<th>Source</th>
					
						</tr>
					
						</thead>
						
						<tbody>
						<?php
						
						if($Trans_Records != NULL)
						{
							
							$ci_object = &get_instance(); 

							foreach($Trans_Records as $row)
							{
								$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
								$Membership_ID=$row->Membership_ID;
								$Enrollement_id=$row->Enrollement_id;
								$Show_member=0;
								
								$Active="<font color='green'>Yes</font>";
								if($row->User_activated=="No")
								{
									$Active="<font color='red'>No</font>";
								}
								$start_date = $_REQUEST["start_date"];
								$end_date = $_REQUEST["end_date"];
								
							
								$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
								$Total_current_balance=round($row->Total_current_balance);								
								?>
								
									<tr>
										<td><?php echo $row->Membership_ID;?></td>
																				<td><?php echo $Full_name;?></td>
										<td><?php echo $row->Tier_name;?></td>
										<td><?php echo $row->joined_date;?></td>
										

										<td><?php echo $row->Current_address;?></td>
										<td><?php echo $row->City;?></td>
										<td><?php echo $row->State;?></td>
										<td><?php echo $row->Phone_no;?></td>
										<td><?php echo $row->User_email_id; ?> </td>
										<td><?php echo $row->Total_Purchase_Amount;?></td>
										<td><?php echo $row->Total_Gained_Points;?></td>
										<td><?php echo $row->Total_Redeemed_Points;?></td>
										
										<td><?php echo $Total_current_balance; ?> </td>
										<td><?php echo $row->Gift_card_purchase_amt;?></td>
												<td><?php echo $row->Gift_card_redeem_amt;?></td>
										<td><?php echo $Active;?></td>
										<td><?php echo $row->Enrolled_by;?></td>
										<td><?php echo $row->Source;?></td>
									
									</tr>
							<?php		
							}
						}
						?>			
			</tbody> 
		</table>
		</table>
	</div>
</div>
<?php } ?>
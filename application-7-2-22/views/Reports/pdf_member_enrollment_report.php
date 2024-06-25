<?php if($Trans_Records != NULL) { 

//error_reporting(0);

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div> 
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Member Enrollment Report</h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("d M Y",strtotime($From_date))." To Date: ".date("d M Y",strtotime($end_date)); ?></h4>
		
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo date("d M Y"); ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>
						
						<tr>
							<th>Enrollment Date</th>
							<th>Membership ID</th>
							<th>Member Name</th>
							<th>Current Address</th>
							<th>City</th>
							<th>District</th>
							<th>State</th>
							<th>Phone no</th>
							<th>User Email ID</th>
							<th>Current Balance</th>
							<th>Total Purchase Amount <?php echo "($Symbol_currency)"; ?></th>
							<th>Total Redeemed  <?php echo $Company_details->Currency_name; ?></th>
							<th>Total Gained  <?php echo $Company_details->Currency_name; ?></th>
							<th>Active</th>
							<th>Enrolled by</th> 
							<?php if($Company_details->Label_1 != NULL) { ?> <th> <?php echo $Company_details->Label_1;  ?> </th> <?php } ?>
							<?php if($Company_details->Label_2 != NULL) { ?> <th> <?php echo $Company_details->Label_2;  ?> </th> <?php } ?>
							<?php if($Company_details->Label_3 != NULL) { ?> <th> <?php echo $Company_details->Label_3;  ?> </th> <?php } ?>
							<?php if($Company_details->Label_4 != NULL) { ?> <th> <?php echo $Company_details->Label_4;  ?> </th> <?php } ?>
							<?php if($Company_details->Label_5 != NULL) { ?> <th> <?php echo $Company_details->Label_5;  ?> </th> <?php } ?>
						</tr>
					
						</thead>
						
						<tbody>
						<?php
						
						if($Trans_Records != NULL)
						{
							
							
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
										<td><?php echo $row->joined_date;?></td>
										<td><?php echo $row->Membership_ID;?></td>
										<td><?php echo $Full_name;?></td>
										<td><?php echo $row->Current_address;?></td>
										<td><?php echo $row->City;?></td>
										<td><?php echo $row->District;?></td>
										<td><?php echo $row->State;?></td>
										<td><?php echo $row->Phone_no;?></td>
										<td><?php echo $row->User_email_id; ?> </td>
										<td><?php echo $Total_current_balance; ?> </td>
										<td><?php echo sprintf("%.2f",$row->Total_Purchase_Amount); ?> </td>
										<td><?php echo $row->Total_Redeemed_Points;?></td>
										<td><?php echo $row->Total_Gained_Points;?></td>
										<td><?php echo $Active;?></td>
										<td><?php echo $row->Enrolled_by;?></td>
										<?php if($Company_details->Label_1 != NULL) { ?> <td> <?php echo $row->Label_1_value;  ?> </td> <?php } ?>
										<?php if($Company_details->Label_2 != NULL) { ?> <td> <?php echo $row->Label_2_value;  ?> </td> <?php } ?>
										<?php if($Company_details->Label_3 != NULL) { ?> <td> <?php echo $row->Label_3_value;  ?> </td> <?php } ?>
										<?php if($Company_details->Label_4 != NULL) { ?> <td> <?php echo $row->Label_4_value;  ?> </td> <?php } ?>
										<?php if($Company_details->Label_5 != NULL) { ?> <td> <?php echo $row->Label_5_value;  ?> </td> <?php } ?>
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
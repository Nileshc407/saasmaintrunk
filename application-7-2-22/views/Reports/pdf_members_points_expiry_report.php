<?php if($Trans_Records != NULL) { 

//error_reporting(0);

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center"><?php if($_REQUEST["Expiry_flag"]==1){echo "Members" .$Company_details->Currency_name." Expiry Report";}else{echo "Members ".$Company_details->Currency_name." to be Expiry in ".$_REQUEST["days"]." days";}?> </h2>
		
		<?php if($_REQUEST["Expiry_flag"]==1){echo '<h4 style="text-align:center">From Date: '.date("d M Y",strtotime($start_date)).' To Date: '.date("d M Y",strtotime($end_date)).'</h4>';
		}?>
		
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo date("d M Y"); ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>
						<?php 
						$Expiry_flag = $_REQUEST["Expiry_flag"];
						$Points_expiry_period =$_REQUEST["Points_expiry_period"];
						$Deduct_points_expiry =$_REQUEST["Deduct_points_expiry"];
						if($Expiry_flag==1)//Points Expiry
						{
							echo "<tr>
							<th>Expired Date</th>
							<th>Member Name</th>
							<th>Membership ID</th>
							<th>User Email ID</th>
							<th>Current Balance</th>
							<th>Expired ".$Company_details->Currency_name."</th>
							</tr>";
						}
						else
						{
							echo "<tr>
							<th>When to Expiry Date</th>
							<th>Member Name</th>
							<th>Membership ID</th>
							<th>User Email ID</th>
							<th>Current Balance</th>
							<th>".$Company_details->Currency_name." to be Expired</th>
							</tr>";
						}
						?>
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
								if($Expiry_flag==1)//Points Expiry
								{
									$start_date = $_REQUEST["start_date"];
									$end_date = $_REQUEST["end_date"];
									echo "<tr>";
									echo "<td>".date("Y-m-d",strtotime($row->Expired_Date))."</td>";
									echo "<td>".$Full_name."</td>";
									echo "<td>".$row->Membership_ID."</td>";
									echo "<td>".$row->User_email_id."</td>";
									echo "<td>".$row->Total_Balance."</td>";
									echo "<td>".$row->Expired_points."</td>";
									echo "</tr>";
										
								}
								else
								{
									$days = $_REQUEST["days"];
									$Deduct_balance=round(($row->Total_Balance*$Deduct_points_expiry)/100);
									if($Deduct_balance==0)
									{
										$Deduct_balance=1;
									}
									/******************Calculate Days*********************************************/
									$Transaction_date=date("m-d-Y",strtotime($row->Trans_date));
									$tUnixTime = time();
									list($month, $day, $year) = EXPLODE('-', $Transaction_date);
									$timeStamp = mktime(0, 0, 0, $month, $day, $year);
									$num_days= ceil(abs($timeStamp - $tUnixTime) / 86400);
									////*************************************************************************/
									//echo "<br><br>Membership_ID ".$row->Membership_ID."  Trans_date ".$row->Trans_date." "."  num_days".$num_days." "."  remain ".($Points_expiry_period-$days);
									if($num_days<=$days)
									{
										//$When_to_expiry_date=date("Y-m-d",strtotime($row->Trans_date));
										$When_to_expiry_date=date("Y-m-d",strtotime($row->Trans_date ."+$Points_expiry_period days"));
										echo "<tr>";
										echo "<td>".$When_to_expiry_date."</td>";
										echo "<td>".$Full_name."</td>";
										echo "<td>".$row->Membership_ID."</td>";
										echo "<td>".$row->User_email_id."</td>";
										echo "<td>".$row->Total_Balance."</td>";
										echo "<td>".$Deduct_balance."</td>";
										echo "</tr>";
									}
								}
									
							}
						}
	
						
						?>			
			</tbody> 
		</table>
		</table>
	</div>
</div>
<?php } ?>
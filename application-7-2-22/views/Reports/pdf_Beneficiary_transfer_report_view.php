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
		<h2 style="text-align:center">Beneficiary Company Liability Report: <?php echo $report_type_name;?></h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($From_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
		
	</div>
	<div>
		<h5 style="text-align:right">Todays Date : <?php echo $Report_date; ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;" align="center">
		
			<thead>
			<?php if($report_type==1){ //Details?>
						<tr style="background-color: #D9EDF7;">
						
						<th>Transaction Date</th>
						<th>From Beneficiary Company</th>
						<th>From Member Name</th>
						<th>From Membership ID</th>
						<!--<th>Transaction Type</th>-->			
						<th>To Beneficiary Company</th>
						<th>To Beneficiary Member Name</th>
						<th>To Membership ID</th>
						<th>Transfer <?php echo $Company_details->Currency_name; ?></th>
						<th>Recived <?php echo $Company_details->Currency_name; ?></th>
						<th>Remarks</th>
					</tr>
						<?php }else{ //Summary?>
						<tr style="background-color: #D9EDF7;">
							
							<th>Total Transfered <?php echo $Company_details->Currency_name; ?></th>
							<th>Total Recived <?php echo $Company_details->Currency_name; ?></th>       
						</tr>
						<?php } ?>
			</thead>
			
			<tbody>
			<?php
						$todays = date("Y-m-d");
					
						// print_r($Trans_Records);
						// die;
						if($Trans_Records != NULL)
						{
							//print_r($Trans_Records);die;
							//$From_date=$_REQUEST["start_date"];
							//echo '<table  class="table table-bordered table-hover">';
							
							$lv_Company_id=0;							
							foreach($Trans_Records as $row)
							{
								$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
								$Membership_ID=$row->Membership_ID;
								$Company_name=$row->Company_name;
								$rowCompany_id=$row->Company_id;
								if($lv_Company_id!=$rowCompany_id && $report_type==2)
								{
									// echo "<tr  style='background-color: #C8E0D6;'><td colspan='12'>".$Full_name." (".$Membership_ID.")</td></tr>";
									// echo "<tr style='background-color: #C8E0D6;'><td colspan='12'><b>".$Full_name." (".$Membership_ID.")   Tier : ". $Tier_name." </b></td></tr>";
									
									echo "<tr class='success' style='background-color: #C8E0D6;'><td colspan='14'><b>".$Company_name."</b></td></tr>";
								}							
								if($report_type==1)//Details
								{
							   
									if($row->From_Beneficiary_company_name=="")
									{
										$row->From_Beneficiary_company_name="-";
									}
									if($row->To_Beneficiary_company_name=="")
									{
										$row->To_Beneficiary_company_name="-";
									}
									if($row->To_Beneficiary_cust_name=="")
									{
										$row->To_Beneficiary_cust_name="-";
									}
									if($row->Topup_amount==0)
									{
										$row->Topup_amount="-";
									}
									if($row->Transfer_to=='0')
									{
										$row->Transfer_to="-";
									}
									if($row->Transfer_points==0)
									{
										$row->Transfer_points="-";
									}
										
									echo "<tr>";
									echo "<td>".$row->Trans_date."</td>";
									echo "<td>".$row->From_Beneficiary_company_name."</td>";
									echo "<td>".$Full_name."</td>";
									echo "<td>".$Membership_ID."</td>";
									// echo "<td>".$row->Trans_type."</td>";
									
									echo "<td>".$row->To_Beneficiary_company_name."</td>";
									echo "<td>".$row->To_Beneficiary_cust_name."</td>";
									echo "<td>".$row->Transfer_to."</td>";
									echo "<td>".$row->Transfer_points."</td>";
									echo "<td>".$row->Recived_point."</td>";
									echo "<td>".$row->Remarks."</td>";
                                    echo "</tr>";
								}
								else
								{
									
									if($row->Total_Transfer_Points==0)
									{
										$row->Total_Transfer_Points="-";
									}	
									if($row->Total_Recived_Points==0)
									{
										$row->Total_Recived_Points="-";
									}						
									
								?>
									<tr>								
										<td><?php echo $row->Total_Transfer_Points; ?> </td>
										<td><?php echo $row->Total_Recived_Points;?></td>
									</tr>
							<?php   }
								$lv_Card_id=$Membership_ID;
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
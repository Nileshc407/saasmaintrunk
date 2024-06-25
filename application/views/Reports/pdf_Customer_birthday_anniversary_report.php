<?php if($Trans_Records != NULL) { 

//error_reporting(0);

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div> 
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">MEMBER Birthday & Anniversary Report</h2>

		
	</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>
						
						<tr>
									<th>Membership ID</th>
									<th>Member Name</th>
									<th>Birth Date</th>
									<th>Anniversary Date</th>
									<th>Joined Date</th>
									<th>Total Purchase Amount <?php echo "($Symbol_currency)"; ?></th>
									<th>Total Paid Amount <?php echo "($Symbol_currency)"; ?></th>
									<th>Total Gained  <?php echo $Company_details->Currency_name; ?></th>
									<th>Total Redeemed  <?php echo $Company_details->Currency_name; ?></th>
					
						</tr>
					
						</thead>
						
						<tbody>
						<?php
						
							if($Trans_Records != NULL)
							{
								
								$ci_object = &get_instance(); 

								foreach($Trans_Records as $row)
								{
									$Full_name=$row->First_name." ".$row->Last_name;
									$Membership_ID=$row->Membership_ID;
									
									?>
												<tr>
												<td><?php echo $row->Membership_ID;?></td>
												<td><?php echo $Full_name;?></td>
													<td><?php echo date('d M Y',strtotime($row->Date_of_birth));?></td>
													<td><?php echo date('d M Y',strtotime($row->Anniversary_date));?></td>
													<td><?php echo date('d M Y',strtotime($row->joined_date));?></td>
													
													<td><?php echo $row->Total_Purchase_Amount;?></td>
													<td><?php echo $row->Total_Paid_Amount;?></td>
													<td><?php echo $row->Total_Gained_Points;?></td>
													
													<td><?php echo $row->Total_Redeemed_Points;?></td>

											

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
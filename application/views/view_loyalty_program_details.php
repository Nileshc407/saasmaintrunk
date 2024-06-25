<div class="element-wrapper">                
	<div class="element-box">
	  <h5 class="form-header">
	  Loyalty Rules
	  </h5>                  
	  <div class="table-responsive">
		<table id="dataTable2" width="100%" class="table table-striped table-lightfont">
			<thead>
				<tr>
				<th class="text-center">Loyalty Program Name</th>
				<th class="text-center" colspan="2">Validity Of Transaction</th>
				<th class="text-center">Loyalty @ Transaction</th>
				<th class="text-center" colspan="2">Loyalty @ Value</th>
								
				</tr>
				<tr>
				<th class="text-center"></th>
				<th class="text-center">From Date</th>
				<th class="text-center">Till Date</th>
				<th class="text-center"> % <?php echo $Company_details->Currency_name; ?>  Gained</th>
				<th class="text-center">Value</th>
				<th class="text-center"> % <?php echo $Company_details->Currency_name; ?>  Gained</th>
				</tr>
			</thead>	
				

			<tbody>
					<?php
						if($lp_array != NULL)
						{
							
							foreach($lp_array as $rows)
							{
								$lp_name = $rows['Loyalty_name'];
								$Loyalty_id = $rows['Loyalty_id'];
								$From_date = date("Y-m-d",strtotime($rows['From_date']));
								$Till_date = date("Y-m-d",strtotime($rows['Till_date']));
								$PABA_val = substr($rows['Loyalty_name'],0,2);
								
								$Loyalty_at_transaction = $rows['Loyalty_at_transaction'];
								$Loyalty_at_value = $rows['Loyalty_at_value'];
								$discount = $rows['discount'];
								$SellerID = $rows['Seller'];
								$Company_id = $rows['Company_id'];
								$todays=date("Y-m-d");
								
									if(($todays >= $From_date) && ($todays <= $Till_date))
									{		
							?>
								<tr>

									<td><?php echo $lp_name;?></td>
									
									<?php 
										
										
										if(($todays >= $From_date) && ($todays <= $Till_date))
										{
											echo "<td style='color:green'>".$From_date."</td>";
											echo "<td style='color:green'>".$Till_date."</td>";
										}
										else
										{
											echo "<td>".$From_date."</td>";	
											echo "<td>".$Till_date."</td>";	
										}
									?>

									<td><?php echo $Loyalty_at_transaction;?></td>
									<td><?php echo $Loyalty_at_value;?></td>
									<td><?php echo $discount;?></td>
					
								</tr>
							<?php
								}
							}
						}
						?>							
			</tbody> 
			</table>
		  </div>
		</div>
	  </div>
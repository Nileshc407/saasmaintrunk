
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Loyalty Report</h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($start_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
	</div>	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
			<thead>
				<tr>
					<th>Outlet</th>
					<th>Channel</th>
					<th>Visits</th>
					<th>Online Purchase</th>
					<th>Bill Amount Visit <?php echo '('.$Symbol_of_currency.')';?></th>
					<th>Bill Amount Online <?php echo '('.$Symbol_of_currency.')';?></th>
					<th>Total Spend Amt <?php echo '('.$Symbol_of_currency.')';?></th>
					<th>Total Discount Amt <?php echo '('.$Symbol_of_currency.')';?></th>
					<th>Earn Points</th>
					<th>Earn Amt <?php echo '('.$Symbol_of_currency.')';?></th>
					<th>Redeem Points</th>
					<th>Redeem Amt <?php echo '('.$Symbol_of_currency.')';?></th>
					<th>Voucher Amt <?php echo '('.$Symbol_of_currency.')';?></th>
					
					<th>Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th>
					
				</tr>
			</thead>	
			<tbody>
				<?php
					$ci_object = &get_instance(); 
						$Visits=0;
						  $Bill_amount_visit=0;
						  $Online_purchase=0;
						  $Bill_amount_online=0;
						  
						 $ci_object = &get_instance(); 
						 
						if(count($Trans_Records) > 0)
						{
							foreach($Trans_Records as $row)
							{
								$All_online = array();
								$All_onlineAmt = array();
								if($transaction_from==0 || $transaction_from==2)
								{
									$POS = $ci_object->Report_model->Get_outlet_pos_online_summary($Company_id, $start_date, $end_date, 2,$row->Seller);
									if($POS != NULL)
									{
										foreach($POS as $rec)
										{
											$Visits=$rec->Visits;
											$Bill_amount_visit=$rec->Bill_amount_visit;
										}
									}
									else
									{
										$Visits=0;
										$Bill_amount_visit=0;
									}
								}
								if($transaction_from==0 || $transaction_from==12)
								{
									$ONLINE = $ci_object->Report_model->Get_outlet_pos_online_summary($Company_id, $start_date, $end_date, 12,$row->Seller);
									if($ONLINE != NULL)
									{
										foreach($ONLINE as $rec)
										{
											$Online_purchase=$rec->Online_purchase;
											$Bill_amount_online=$rec->Bill_amount_online;
										}
									}
									else
									{
										$Online_purchase=0;
										$Bill_amount_online=0;
									}
									$All_online[]= $Online_purchase;
									$All_onlineAmt[]= $Bill_amount_online;
								}
								if($transaction_from==0 || $transaction_from==29)
								{
									$ONLINE = $ci_object->Report_model->Get_outlet_pos_online_summary($Company_id, $start_date, $end_date, 29,$row->Seller);
									if($ONLINE != NULL)
									{
										foreach($ONLINE as $rec)
										{
											$Online_purchase=$rec->Online_purchase;
											$Bill_amount_online=$rec->Bill_amount_online;
										}
										$row->Total_spend = $Bill_amount_online;
									}
									else
									{
										$Online_purchase=0;
										$Bill_amount_online=0;
									}
									$All_online[]= $Online_purchase;
									$All_onlineAmt[]= $Bill_amount_online;
								}
								if($row->Channel == 12)
								{
									$TransType = "Online";
								}
								
								if($row->Channel == 2)
								{
									$TransType = "POS";
								}
								if($row->Channel == 29)
								{
									$Channel_name = $ci_object->Report_model->Get_beneficiary_company($row->Channel_id);
									$TransType = $Channel_name->Beneficiary_company_name;
								}
								if($transaction_from==0 )
								{
									$TransType = "All";
									$row->Total_spend = array_sum($All_onlineAmt) + $Bill_amount_visit;
								}
								
								echo "<tr>";
								echo "<td>".$row->Outlet."</td>";
								echo "<td>".$TransType."</td>";
								echo "<td>".$Visits."</td>";
								echo "<td>".array_sum($All_online)."</td>";
								echo "<td>".number_format(round($Bill_amount_visit),2)."</td>";
								echo "<td>".number_format(round(array_sum($All_onlineAmt)),2)."</td>";
								echo "<td>".number_format(round($row->Total_spend),2)."</td>";
								echo "<td>".number_format(round($row->Total_discount_amount),2)."</td>";
								echo "<td>".round($row->Earn_points)."</td>";
								echo "<td>".number_format(round($row->Earned_amt),2)."</td>";
								echo "<td>".round($row->Redeem_points)."</td>";
								echo "<td>".number_format(round($row->Redeem_amount),2)."</td>";
								echo "<td>".number_format(round($row->Voucher_amount),2)."</td>";
								
								echo "<td>".number_format(round($row->Paid_amount),2)."</td>";
								
								echo "</tr>";
								
							}
						}
		
				?>		
			</tbody> 
		</table>
	</div>
</div>

<?php 
$ci_object = &get_instance();
$ci_object->load->model('Igain_model');
if($Transaction_Reports != NULL) { 
// error_reporting(0);
if($Report_type=='1'){
	$report_type_name="Summary";
}
else
{
	$report_type_name="Details";
}

// echo"Report_type------".$Report_type."<br>";

?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">Member Report: <?php echo $report_type_name;?></h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($From_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>
		
	</div>
	<div>
		<h5 style="text-align:right">Date : <?php echo date('Y-m-d'); ?></h5>
		</div>
	
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
		
			<thead>
			<tr style="background-color: #D9EDF7;">
			<?php 
					if($Redeemption_report==1)  
					{ 						
						if($Report_type==0) 
						{
						?>
							<th>Transaction Date</th>
							<th>Transaction Type</th>					  
							<th>Item Name</th>	
							<th>Item Size</th>								
							<th>Quantity</th>					  
							<th>Redeemed <?php echo $Company_Details->Currency_name; ?></th>	
							<th>Shipping <?php echo $Company_Details->Currency_name; ?></th>	
							<th>Voucher No</th>	
							<th>Voucher Status</th>	
						<?php
						}
						else
						{
						?>
							<th>Transaction Type</th>
							<th>Redeemed <?php echo $Company_Details->Currency_name; ?></th>
							<th>Shipping <?php echo $Company_Details->Currency_name; ?></th>
							<th>Quantity</th>														
						<?php
						}
					} 
					else 
					{ 
						if($Report_type==0) 
						{ 
						?>
							<th>Transaction Date</th>
							<th>Bill No</th>
							<th>Transaction Type</th>
							<th>Item Name</th>					  
							<th>Item Size</th>					  
							<th>Quantity</th>
							<th>Purchase Amount/Miles/Rewards</th>
							<th>Shipping Cost</th>
							<th>Bonus <?php echo $Company_Details->Currency_name; ?></th>						  
							<th>Redeemed <?php echo $Company_Details->Currency_name; ?></th>						  
							<th>Gained <?php echo $Company_Details->Currency_name; ?></th>
							<th>Done By</th>
							<th>Transfer <?php echo $Company_Details->Currency_name; ?></th>
							<th>Transfer To/From</th>
							<th>Remarks</th>
						<?php
						}
						else
						{ 
						?>					 
							<th>Transaction Type</th>
							<th>Purchase Amount/Miles/Rewards</th>
							<th>Bonus <?php echo $Company_Details->Currency_name; ?></th>						  
							<th>Redeem <?php echo $Company_Details->Currency_name; ?></th>						  
							<th>Gained <?php echo $Company_Details->Currency_name; ?></th>
							<th>Transfer <?php echo $Company_Details->Currency_name; ?></th>
							<th>Shipping <?php echo $Company_Details->Currency_name; ?></th>
						<?php
						}
					}
					?>
			  </tr>
			</thead>			
			<tbody>					 
					<?php 
					if($Transaction_Reports != "")
					{
						foreach($Transaction_Reports as $Trans_RPT)
						{
							if($Redeemption_report ==0 )
							{
								// echo"TransferTo-------".$Trans_RPT['TransferTo'];
								/* if($$Trans_RPT->TransferTo !=0)
								{
									$full_name=$Trans_RPT->TransferTo; */
									/* $Enroll_details12= $ci_object->Igain_model->get_enrollment_details($Trans_RPT['TransferTo']);
									$first_name=$Enroll_details12->First_name;
									$Last_name=$Enroll_details12->Last_name;
									$full_name=$first_name.' '.$Last_name;
									if($full_name==""   ){$full_name='-';}else{ $full_name=$full_name;} */
									// if($full_name==""){$full_name='-';}else{ $full_name=$Trans_RPT['TransferTo'];}
								/* }
								else
								{
									$full_name='-';
								} */							
								if($Report_type =='1')
								{	
							
									// echo"Report_type-----".$Report_type;
									// echo"TransactionTypeID-----".$Trans_RPT->TransactionTypeID;
									if($Trans_RPT->TransactionTypeID == 25)
									{
										$TotalPurchaseAmount=round($Trans_RPT->TotalPurchaseAmount);
										
									} else {
										
										$TotalPurchaseAmount=$Trans_RPT->TotalPurchaseAmount;
									}
								?>
									<tr>							  
										<td><span class="label label-success"><?php echo $Trans_RPT->TransactionType; ?></span></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $TotalPurchaseAmount; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalBonusPoints; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalRedeemPoints; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalGainPoints; ?></div></td>							  
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalTransPoints; ?></div></td>							  
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalShippingCost; ?></div></td>							  
									</tr>
								<?php 
								}
								else
								{
									// echo"BillNo-----".$Trans_RPT->BillNo;
									
									if($Trans_RPT->TransactionTypeID == 25)
									{
										$PurchaseAmount=round($Trans_RPT->PurchaseAmount);
										
									} else {
										
										$PurchaseAmount=$Trans_RPT->PurchaseAmount;
									}
									
								?>						
									<tr>							 
										<td><?php echo date('d-M-y', strtotime($Trans_RPT->TransactionDate)); ?></td>
										<td><?php echo $Trans_RPT->BillNo; ?></td>
										<td><span class="label label-success"><?php echo $Trans_RPT->TransactionType; ?></span></td>
										<td><span class="label label-success"><?php echo $Trans_RPT->Item_name; ?></span></td>
										<td><span class="label label-success"><?php echo $Trans_RPT->Item_size; ?></span></td>
										<td><span class="label label-success"><?php echo $Trans_RPT->Quantity; ?></span></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $PurchaseAmount; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->Shipping_cost; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->BounsPoints; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->RedeemPoints; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->GainPoints; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->DoneBy;  ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TransferPoints; ?></div></td>										
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->TransferToFrom; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->Remarks; ?></div></td>
									</tr>									
								<?php
								}
							}
							else
							{
								if($Report_type==0)
								{
								?>
									<tr>							 
										<td><?php echo date('d-M-y', strtotime($Trans_RPT->TransactionDate)); ?></td>
										<td><span class="label label-success"><?php echo $Trans_RPT->TransactionType; ?></span></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->ItemName; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->Item_size; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->TotalQuantity; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->TotalItemRedeemPoints; ?></div></td>									
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->Shipping_points; ?></div></td>									
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->VoucherNo; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->VoucherStatus; ?></div></td>
									</tr>
								
								<?php
								}
								else
								{
								?>
									<tr>
									<td><span class="label label-success"><?php echo $Trans_RPT->TransactionType; ?></span></td>
									<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalItemRedeemPoints; ?></div></td>
									<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalShippingpoints; ?></div></td>
									<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalQuantity; ?></div></td>
									</tr>
								<?php
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
<?php }
// die;
 ?>
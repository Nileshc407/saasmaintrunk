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
?>
<div class="panel panel-info" style="border-color: #bce8f1;">
	<div>
		<h1 style="text-align:center"><?php echo $Company_name;?></h1>
		<h2 style="text-align:center">My Statement: <?php echo $report_type_name;?></h2>
		<h4 style="text-align:center"><?php echo "From Date: ".date("Y-m-d",strtotime($From_date))." To Date: ".date("Y-m-d",strtotime($end_date)); ?></h4>		
	</div>
	<div>
		<h5 style="text-align:right">Date : <?php echo $Report_date; ?></h5>
		</div>
	<div>
		<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">		
			<thead>
			<tr style="background-color: #D9EDF7;">
			<?php 
					if($Redeemption_report==1)  
					{ 						
						if($Report_type==0) 
						{ 	?>
							<th>Transaction Date</th>
							<th>Transaction Type</th>					  
							<th>Menu Item</th>	
							<!--<th>Item Size</th>-->							
							<th>Quantity</th>					  
							<th>Redeemed <?php echo $Company_Details->Currency_name; ?></th>	
							<?php /*<th>Delivery <?php echo $Company_Details->Currency_name; ?></th>	
							<th>Voucher No</th>	 */?>
							<th>Voucher Status</th>	
						<?php
						}
						else
						{ ?>
							<th>Transaction Type</th>
							<th>Redeemed <?php echo $Company_Details->Currency_name; ?></th>
							<?php /*<th>Delivery <?php echo $Company_Details->Currency_name; ?></th> */ ?>
							<th>Quantity</th>														
						<?php
						}
					} 
					else 
					{ 
						if($Report_type==0) 
						{ ?>
							<th>Transaction Date</th>
							<th>Bill No.</th>
							<th>Pos Bill No.</th>
							<th>Transaction Type</th>
							<!--<th>Menu Item</th>					  
							<th>Item Size</th>					  
							<th>Quantity</th> -->
							<th>Purchase Am(<?php echo $Symbol_currency; ?>)t</th>
							<th>Paid Amt(<?php echo $Symbol_currency; ?>)</th>
							<th>Delivery Cost(<?php echo $Symbol_currency; ?>)</th>
							<th>Bonus <?php echo $Company_Details->Currency_name; ?></th>
							<th>Earned <?php echo $Company_Details->Currency_name; ?></th>							
							<th>Redeemed <?php echo $Company_Details->Currency_name; ?></th>			
							<th>Mpesa TransID</th>
							<!--<th>Done By</th>-->
							<th>Transfer <?php echo $Company_Details->Currency_name; ?></th>
							<th>Transfer To/From</th>
							<th>Remarks</th>
						<?php
						}
						else
						{ 
						?>					 
							<th>Transaction Type</th>
							<th>Purchase Amount(<?php echo $Symbol_currency; ?>)</th>
							<th>Delivery Cost(<?php echo $Symbol_currency; ?>)</th>
							<th>Bonus <?php echo $Company_Details->Currency_name; ?></th>
							<th>Earned <?php echo $Company_Details->Currency_name; ?></th>							
							<th>Redeem <?php echo $Company_Details->Currency_name; ?></th>
							<th>Transfer <?php echo $Company_Details->Currency_name; ?></th> 
							
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
								if($Report_type =='1')
								{
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
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalShippingCost; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalBonusPoints; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo round($Trans_RPT->TotalGainPoints); ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo round($Trans_RPT->TotalRedeemPoints); ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalTransPoints; ?></div></td>	
									</tr>
								<?php 
								}
								else
								{
									if($Trans_RPT->TransactionTypeID == 25)
									{
										$PurchaseAmount=round($Trans_RPT->PurchaseAmount);
										
									} else {
										
										$PurchaseAmount=$Trans_RPT->PurchaseAmount;
									}
									
									$Shipping_cost = round($Trans_RPT->Shipping_cost);
									$Paid_amount = round($Trans_RPT->Paid_amount);
									
								?>						
									<tr>							 
										<td><?php echo date('d-M-y', strtotime($Trans_RPT->TransactionDate)); ?></td>
										<td><?php echo $Trans_RPT->BillNo; ?></td>
										<td><?php echo $Trans_RPT->Manual_billno; ?></td>
										<td><span class="label label-success"><?php echo $Trans_RPT->TransactionType; ?></span></td>
										<?php /*<td><span class="label label-success"><?php echo $Trans_RPT->Item_name; ?></span></td>
										<td><span class="label label-success"><?php echo $Trans_RPT->Item_size; ?></span></td> 
										<td><span class="label label-success"><?php echo $Trans_RPT->Quantity; ?></span></td>*/ ?>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $PurchaseAmount; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo number_format($Paid_amount, 2); ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo number_format($Shipping_cost, 2); ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->BounsPoints; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo round($Trans_RPT->GainPoints); ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo round($Trans_RPT->RedeemPoints); ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php if($Trans_RPT->Mpesa_Paid_Amount !=0){ echo $Trans_RPT->Mpesa_TransID; } else { echo '-'; } ?></div></td>
										<?php /*<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->DoneBy;  ?></div></td> */ ?>
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
									<?php /*	<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->Item_size; ?></div></td> */ ?>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->TotalQuantity; ?></div></td>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo round($Trans_RPT->TotalItemRedeemPoints); ?></div></td>
										<?php /*<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->Shipping_points; ?></div></td>									
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->VoucherNo; ?> </div></td> */ ?>
										<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php  echo $Trans_RPT->VoucherStatus; ?></div></td>
									</tr>
								<?php
								}
								else
								{
								?>
									<tr>
									<td><span class="label label-success"><?php echo $Trans_RPT->TransactionType; ?></span></td>
									<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo round($Trans_RPT->TotalItemRedeemPoints); ?></div></td>
									<?php /*<td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo $Trans_RPT->TotalShippingpoints; ?></div></td> */ ?>
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
 ?>
<?php 
$ci_object = &get_instance();
$ci_object->load->model('Report/Report_model');
foreach($Order_details as $Order_det)
{
	$Bill_no=$Order_det["Bill_no"];
	$Manual_billno=$Order_det["Manual_billno"];
} 
?>
<div class="modal-content">
	<div class="modal-header">
	<?php echo '<b>Online Order No. :</b> '.$Bill_no; 
		echo '&nbsp&nbsp&nbsp; <b>POS Bill No. :</b> '.$Manual_billno; ?>
	</div>
	<div class="modal-body">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Menu Item</th>
						<th>Condiments</th>
						<th>Quantity</th>								
						<th>Unit price (<?php echo $Symbol_of_currency; ?>)</th>
						<th>Total Amount (<?php echo $Symbol_of_currency; ?>)</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$sub_total = 0;
					$Subtotal = array();
					$Shippingcost = array();
					$Paid_amount = array();
					$Mpesa_Paid_Amount = array();
					$COD_Amount = array();
					$RedeemPoints = array();
					$RedeemAmounts = array();
					
					if($Order_details!=NULL)
					{
						foreach($Order_details as $Order_det)
						{
							$Subtotal[] =$Order_det['Purchase_amount'];
							$Shippingcost[] =$Order_det['Shipping_cost'];
							$Paid_amount[] =$Order_det['Paid_amount'];
							$Mpesa_Paid_Amount[] =$Order_det['Mpesa_Paid_Amount'];
							$COD_Amount[] =$Order_det['COD_Amount'];
							$RedeemPoints[]=$Order_det['Redeem_points'];
							$RedeemAmounts[]=$Order_det['Redeem_amount'];
							$sub_total =  $Order_det['Purchase_amount'];
							$Shipping_cost=$Order_det['Shipping_cost'];
							$Bill_no=$Order_det["Bill_no"];
							$Company_id=$Order_det["Company_id"];
							$Voucher_no=$Order_det['Voucher_no'];
							$Delivery_method=$Order_det['Delivery_method'];
							$Seller=$Order_det['Seller'];
							$Table_no=$Order_det['Table_no'];
							$Mpesa_TransID=$Order_det['Mpesa_TransID'];
							$Total_discount = $Order_det['Total_discount'];
						?>
							<tr>
								<td>
									<?php echo $Order_det['Merchandize_item_name']; ?>
								</td>
								<td><?php if($Order_det['remark2']!=NULL) { echo $Order_det['remark2']; } else { echo "-"; } ?></td>
								<td><?php echo $Order_det['Quantity']; ?></td>
								<?php $Unit_price=$Order_det['Purchase_amount']/$Order_det['Quantity']; ?>
								<td><?php echo number_format((float)$Unit_price, 2) ?></td>
								<td><?php echo number_format( (float)($Order_det['Purchase_amount']), 2); ?></td>
							</tr>
						<?php 
							$Redeem_points = $Order_det['Redeem_points'] ;
							$calculate_redeem_amounts=round($Redeem_points/$Redemptionratio);
							$Grand_total=($Shipping_cost+$sub_total-$calculate_redeem_amounts);
						}
					}
					$SubtotalAmt = array_sum($Subtotal);							
					$ShippingcostAmt = array_sum($Shippingcost);							
					$Paid_amount = array_sum($Paid_amount);
					$MpesaPaidAmount = array_sum($Mpesa_Paid_Amount);
					$CODAmount = array_sum($COD_Amount);
					$REDEEM_Points = array_sum($RedeemPoints);
					$RedeemAmount = array_sum($RedeemAmounts);
					
					$ShippingcostAmt1=round($ShippingcostAmt);
					$CODAmount1 = round($CODAmount);
					$MpesaPaidAmount1 = round($MpesaPaidAmount);
					
					/* if($REDEEM_Points!=0)
					{	
						$RedeemAmount = ($SubtotalAmt+$ShippingcostAmt1)-($MpesaPaidAmount1+$CODAmount1);
					}
					else
					{
						$RedeemAmount=0;
					}  */
					// $RedeemAmount = ($SubtotalAmt+$ShippingcostAmt1)-$Paid_amount;
					?>		
						<tr><td colspan="4">&nbsp;</td></tr>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="4" class="text-right">Subtotal</th>
						<td><?php echo $Symbol_of_currency." ". number_format((float)$SubtotalAmt, 2); ?></td>
					</tr>
					<?php if($ShippingcostAmt1>0) { ?>
					<tr>
						<th colspan="4" class="text-right">Delivery Cost</th>
						<td><?php echo $Symbol_of_currency." ".number_format((float)$ShippingcostAmt1, 2); ?></td>
					</tr>
					<?php } ?>	
					<?php if($RedeemAmount > 0){ ?><tr>
						<th colspan="4" class="text-right">Redeem Amount</th>
						<td> <?php  echo $Symbol_of_currency." ".number_format((float)$RedeemAmount, 2); ?> </td>
					</tr> <?php } ?>
					<?php if($Total_discount > 0){ ?><tr>
						<th colspan="4" class="text-right">Discount Amount</th>
						<td> <?php  echo $Symbol_of_currency." ".number_format((float)$Total_discount, 2); ?> </td>
					</tr> <?php } ?>
					
					<tr>
						<th colspan="4" class="text-right">Mpesa Paid Amount</th>
						<td colspan="2"><?php echo $Symbol_of_currency." ".number_format((float)$MpesaPaidAmount1, 2);?>&nbsp;<?php if($MpesaPaidAmount1 !=0){ echo '('.$Mpesa_TransID.')'; } ?></td>
					</tr>
					<tr>
						<th colspan="4" class="text-right"><?php if($Order_det['Voucher_status']==20) { ?> COD Amount <?php } else { ?> Amount Due <?php } ?> </th>
						<td><?php echo $Symbol_of_currency." ".number_format((float)$CODAmount1, 2);?></td>
					</tr>
					
					<?php
						if($Order_det['Voucher_status']==20) //Delivered 
						{
							if($Delivery_method == 28)
							{
								$Voucher_status = 'Collected';
							}
							else if($Delivery_method == 29)
							{
								$Voucher_status = 'Delivered';
							}
							else if($Delivery_method == 107)
							{
								$Voucher_status= 'Collected'; 
							}
						}
						elseif($Order_det['Voucher_status']==19) //Shipped
						{
							$Voucher_status = '	Out for delivery';
						}
						elseif($Order_det['Voucher_status']==21) //Cancel
						{
							$Voucher_status= 'Cancel';
						}
						elseif($Order_det['Voucher_status']==22) //'Return Initiated'
						{
							$Voucher_status = 'Return Initiated';
						}
						elseif($Order_det['Voucher_status']==18) //Ordered
						{
							$Voucher_status = 'Ordered';
						} 
						elseif($Order_det['Voucher_status']==23) //Returned
						{
							$Voucher_status = 'Returned';
						} 
						elseif($Order_det['Voucher_status']==111) //Returned
						{
							$Voucher_status = 'Accepted';
						} 
						else
						{
							$Voucher_status = " ";
						} ?>
					<tr>
						<th colspan="4" class="text-right">Status</th>
						<td><?php echo $Voucher_status; ?></td>
					</tr>
				</tfoot>
			</table>
		<?php if($Delivery_method==29) { ?>
			<div class="row addresses">
				<div class="col-sm-6">
					<h3 class="text-uppercase">Delivery address</h3>
					<p><?php echo $Order->Cust_name; ?>
						<br><?php echo App_string_decrypt($Order->Cust_address); ?>
						<br><?php echo $Order->City_name; ?>, <?php echo $Order->Country_name; ?>.
						<br><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>&nbsp;<?php echo App_string_decrypt($Order->Cust_phnno); ?>
						<br><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>&nbsp;<?php echo App_string_decrypt($Order->Cust_email); ?>
					</p>
				</div>
			</div>
			<?php } else if($Delivery_method==28 || $Delivery_method==107) 
			{ 
				$outlet_address = $ci_object->Report_model->GetTakeAwayAddress($Company_id,$Seller);
				
				if($Delivery_method == 28) 
				{ 
					$Delivery_type_lable = 'Pick-Up';
				}
				else if($Delivery_method == 107) 
				{
					$Delivery_type_lable = 'In-Store';
				}
				else
				{
					$Delivery_type_lable = '';
				}
			?>
			<div class="row addresses">
				<div class="col-sm-6">
					<h3 class="text-uppercase"><?php echo $Delivery_type_lable; ?> Address</h3>
					<p><?php echo $outlet_address->Seller_name; ?>
						<?php if($Delivery_method == 107) { ?>
						<br><?php echo 'Table No. : '.$Table_no; ?>
						<?php } ?>
						<br><?php echo App_string_decrypt($outlet_address->Current_address); ?>
						<br><?php echo $outlet_address->City_name; ?>, <?php echo $outlet_address->Country_name; ?>, <?php echo $outlet_address->Zipcode; ?>.
						<br><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>&nbsp;<?php echo App_string_decrypt($outlet_address->Phone_no); ?>
						<br><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>&nbsp;<?php echo App_string_decrypt($outlet_address->User_email_id); ?>
					</p>
				</div>
			</div>
			<?php } ?>
		</div>	
	</div>
	<div class="modal-footer">
		<button type="button" id="close_modal" class="btn btn-primary">Close</button>
	</div>
</div>
<script>
$(document).ready(function() 
{	
	$( "#close_modal" ).click(function(e)
	{
		$('#receipt_myModal').hide();
		$("#receipt_myModal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
});
</script>
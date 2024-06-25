<?php $this->load->view('header/header'); 
$ci_object = &get_instance();
$ci_object->load->model('shopping/Shopping_model');
$ci = &get_instance();
$ci->load->helper('encryption_val');
?>
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>
<section class="content-header">
<?php 
if($Order_details!=NULL)
{
	foreach($Order_details as $Order_det)
	{
		$Bill_no=$Order_det["Bill_no"];
	} ?>
	<h1 style="float:left;">Order No. : <?php echo $Bill_no; ?></h1>	&nbsp; &nbsp; 
	<button type="button" class="btn btn-primary" style="text-transform: none;" onclick="Reorder('<?php echo $Bill_no; ?>');">REORDER ALL ITEMS</button>
<?php }
?>

</section>
<?php if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?>
	<script>
			BootstrapDialog.show({
			closable: false,
			title: 'Application Information',
			message: 'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
			buttons: [{
				label: 'OK',
				action: function(dialog) {
					window.location='<?php echo base_url()?>index.php/Cust_home/home';
				}
			}]
		});
		runjs(Title,msg);
	</script>
<?php } ?>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-12 clearfix" id="basket">
			<!--<p class="lead text-center">Order <strong><?php //echo $Order->Voucher_no; ?></strong> was placed on <strong><?php //echo $Order->Trans_date; ?></strong> and is currently <strong>Being <?php //echo $Order->Delivery_status; ?></strong>.</p>-->
			<section class="content-header" style="display:none;" id="error_display">
				<h1 class="text-center"></h1>
				<div class="row">	 
					<div class="col-md-6 col-md-offset-3" id="popup">
						<div class="alert alert-success text-center" role="alert" id="popup_info"></div>
					</div>
				</div>
			</section>
			<div class="box">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th colspan="2">Menu Item</th>
								<th>Condiments</th>
								<!--<th>Item size</th>-->
								<th>Quantity</th>								
								<th>Unit price (<?php echo $Symbol_of_currency; ?>)</th>
								<th>Total Amount (<?php echo $Symbol_of_currency; ?>)</th>
								<th>&nbsp;</th>
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
									
									$sub_total =  $Order_det['Purchase_amount'];
									$Shipping_cost=$Order_det['Shipping_cost'];
									
									$Bill_no=$Order_det["Bill_no"];
									$Company_id=$Order_det["Company_id"];
									$Voucher_no=$Order_det['Voucher_no'];
									$Delivery_method=$Order_det['Delivery_method'];
									$Seller=$Order_det['Seller'];
									$Table_no=$Order_det['Table_no'];
									
									$Mpesa_TransID=$Order_det['Mpesa_TransID'];
																				
									$Item_id = string_encrypt($Order_det['Company_merchandise_item_id'], $key, $iv);	
									$Company_merchandise_item_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Item_id);
									
				//********* sandeep ***************
									$MainItemInfo = $this->Shopping_model->get_main_item($Order_det["Item_code"],$Company_id);
							//	print_r($MainItemInfo); 
									$getCondiment = $this->Shopping_model->get_transaction_item_condiments($Bill_no,$Order_det["Item_code"],$Company_id);
	
									foreach($getCondiment as $n)
									{
										$side_item_codes[] = $n["Condiment_Item_code"];
									}
				//********* sandeep ***************
								?>
									<tr>
										<td>
											<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo urlencode($Company_merchandise_item_id); ?>">
												<img src="<?php echo $Order_det['Thumbnail_image1']; ?>" alt="<?php echo $Order_det['Merchandize_item_name']; ?>">	
											</a>
										</td>
										<td>
											<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo urlencode($Company_merchandise_item_id); ?>">
												<?php echo $Order_det['Merchandize_item_name']; 
												foreach($MainItemInfo as $MainItem){
												if($MainItem['Merchandize_item_name'] != NULL && in_array($MainItem["Main_or_side_item_code"],$side_item_codes)){ ?>
													<a href="#">
														<?php echo "+".$MainItem['Merchandize_item_name']; ?>
													</a>
												<?php }
													 }
												?>
											</a>
										</td>
										
										<td><?php if($Order_det['remark2']!=NULL) { echo $Order_det['remark2']; } else { echo "-"; } ?></td>
										<!--<td> <?php  /*
												if($Order_det['Item_size'] == 1)
												{
												  $size = "Small";
												}
												elseif($Order_det['Item_size'] == 2)
												{	
													$size = "Medium";
												}
												elseif($Order_det['Item_size'] == 3)
												{
													$size = "Large";
												}
												elseif($Order_det['Item_size'] == 4)
												{
													$size = "Extra Large";
												}
												else
												{
													$size = "-";
												}
												echo $size; */
												 ?>
										</td> -->	
										<td><?php echo $Order_det['Quantity']; ?></td>
										<?php $Unit_price=$Order_det['Purchase_amount']/$Order_det['Quantity']; ?>
										<td><?php echo number_format((float)$Unit_price, 2) ?></td>
										<td><?php echo number_format( (float)($Order_det['Purchase_amount']), 2); ?></td>
										<td>   
										  <button type="button" class="btn btn-primary" style="text-transform: none;" onclick="add_to_cart1('<?php echo $Order_det['Company_merchandise_item_id']; ?>','<?php echo $Order_det["Item_code"]; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$Order_det['Merchandize_item_name']); ?>','<?php echo $Order_det['Billing_price']; ?>',29,'<?php echo $Order_det['Merchandize_Partner_branch']; ?>','<?php echo $Order_det['Company_merchandise_item_id']; ?>','<?php echo $Order_det['Item_size']; ?>','<?php echo $Order_det['Item_Weight']; ?>','<?php echo $Order_det['Weight_unit_id']; ?>','<?php echo $Order_det['Merchandize_Partner_id']; ?>','<?php echo $Order_det['Partner_state']; ?>','<?php echo $Order_det['Partner_Country']; ?>','<?php echo $Order_det['Seller_id']; ?>','<?php echo $Order_det['Merchant_flag']; ?>','<?php echo $Order_det['Cost_price']; ?>','<?php echo $Order_det['VAT']; ?>','<?php echo $Order_det['Merchandize_category_id']; ?>','<?php echo $Order_det['remark2']; ?>','<?php echo $Order_det['remark3']; ?>','<?php echo $Order_det["Bill_no"]; ?>','<?php echo $Order_det['Combo_meal_flag']; ?>');">REORDER</button>
										</td>
										
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
							
							$ShippingcostAmt1=round($ShippingcostAmt);
							$CODAmount1 = round($CODAmount);
							$MpesaPaidAmount1 = round($MpesaPaidAmount);
							
							if($REDEEM_Points!=0)
							{	
								
								$RedeemAmount = ($SubtotalAmt+$ShippingcostAmt1)-($MpesaPaidAmount1+$CODAmount1);
							}
							else
							{
								$RedeemAmount=0;
							} 
							// $RedeemAmount = ($SubtotalAmt+$ShippingcostAmt1)-$Paid_amount;
							?>		
								<tr><td colspan="5">&nbsp;</td></tr>
						</tbody>
						<tfoot>
							<tr>
								<th colspan="5" class="text-right">Subtotal</th>
								<td><?php echo $Symbol_of_currency." ". number_format((float)$SubtotalAmt, 2); ?></td>
							</tr>
							<?php if($ShippingcostAmt1 > 0) { ?>
							<tr>
								<th colspan="5" class="text-right">Delivery Cost</th>
								<td><?php echo $Symbol_of_currency." ".number_format((float)$ShippingcostAmt1, 2); ?></td>
							</tr>
							<?php } ?>		
							<?php /* ?><tr>
								<th colspan="5" class="text-right">Redeem Amount</th>
								<td> <?php  echo $Symbol_of_currency." ".number_format((float)$RedeemAmount, 2); ?> </td>
							</tr> <?php */ ?>
							
							<tr>
								<th colspan="5" class="text-right">Mpesa Paid Amount</th>
								<td colspan="2"><?php echo $Symbol_of_currency." ".number_format((float)$MpesaPaidAmount1, 2);?>&nbsp;<?php if($MpesaPaidAmount1 !=0){ echo '('.$Mpesa_TransID.')'; } ?></td>
							</tr>
							<tr>
								<th colspan="5" class="text-right"><?php if($Order_det['Voucher_status']==20) { ?> COD Amount <?php } else { ?> Amount Due <?php } ?> </th>
								<td><?php echo $Symbol_of_currency." ".number_format((float)$CODAmount1, 2);?></td>
							</tr>
							
							<?php
								if($Order_det['Voucher_status']==20) //Delivered 
								{
									if($Delivery_method == 28) //Take Away
									{
										$Voucher_status = 'Collected';
									}
									else if($Delivery_method == 29)  // Delivery
									{
										$Voucher_status = 'Delivered';
									}
									else if($Delivery_method == 107)  // In-Store
									{
										$Voucher_status = 'Collected'; 
									}
									else
									{
										$Voucher_status = ' ';
									}
								}
								elseif($Order_det['Voucher_status']==19) //Out For Delivery
								{
									$Voucher_status = 'Out for delivery';
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
								elseif($Order_det['Voucher_status']==111) //Accepted
								{
									$Voucher_status = 'Accepted';
								} 
								else
								{
									$Voucher_status = "";
								}
								
								?>
							<tr>
								<th colspan="5" class="text-right">Status</th>
								<td><?php echo $Voucher_status; ?></td>
							</tr>
						</tfoot>
					</table>
				</div>
				
				<?php
					// $ci_object = &get_instance();
					// $ci_object->load->model('shopping/Shopping_model');
					$Count_item_offer = $ci_object->Shopping_model->get_purchased_item_offers_details($Voucher_no,$Bill_no,$Company_id);
					
					$Count_offers=count($Count_item_offer);
					
				if($Count_offers > 0)
				{
			?>	
				<div class="table-responsive">				
					<table class="table">
						<thead>
							<tr>
								<th>Order No</th>
								<th>Voucher No.</th>
								<th>offer items</th>
								<th>Quantity</th>							
							</tr>
						</thead>
						<tbody>
						
						<?php
								
						foreach($Count_item_offer as $offers)
						{
							$Bill_no=$Order_det["Bill_no"];
							$Company_id=$Order_det["Company_id"];

							$Item_id = string_encrypt($offers['Company_merchandise_item_id'], $key, $iv);	
							$Company_merchandise_item_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Item_id);
						?>								
							<tr>
							<td><?php echo $offers['Bill_no']; ?></td>	
							<td><?php echo $offers['Voucher_no']; ?></td>	
								<td>
									<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo urlencode($Company_merchandise_item_id); ?>">
										<img src="<?php echo $offers['Thumbnail_image1']; ?>" alt="<?php echo $offers['Merchandize_item_name']; ?>">
										<?php echo $offers['Merchandize_item_name']; ?>
									</a>
								</td>
								<td><?php echo $offers['Quantity']; ?></td>	
							</tr>
					<?php 
						} 
					?>				
						<tr><td colspan="5">&nbsp;</td></tr>
						</tbody>
					</table>
				</div>
				<?php 
				} 
			?>
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
					$outlet_address = $ci_object->Shopping_model->GetTakeAwayAddress($Company_id,$Seller);
					
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
							<?php if($Delivery_method == 107 && $Table_no != NULL) { ?>
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
			<!-- /.box -->
		</div>
	</div>
</section>
<?php $this->load->view('header/footer'); ?>
<script>
function add_to_cart1(serial,Itemcode,name,price,Redemption_method,Branch,Company_merchandise_item_id,Item_size,Item_Weight,Weight_unit_id,Partner_id,Partner_state,Partner_Country_id,Seller_id,Merchant_flag,Cost_price,VAT,Product_category_id,remark2,remark3,Bill_no,Combo_meal_flag)
{
	// Branch=document.getElementById("Delivery_"+Company_merchandise_item_id).value;	
	// var price=document.getElementById("size_points").innerHTML;
	// var price = $("#size_points1").val();
	// var Item_size = $("#Itemsize").val();
	// alert('2Item_size'+Item_size);
	// alert(Itemcode);
	
	show_loader();
	
	$.ajax({
		type: "POST",
		data: { id:serial,Company_merchandize_item_code:Itemcode, name:name,price:price,Delivery_method:29,Branch:Branch,Item_size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id,Partner_id:Partner_id,Partner_state:Partner_state,Partner_Country_id:Partner_Country_id,Seller_id:Seller_id,Merchant_flag:Merchant_flag,Cost_price:Cost_price,VAT:VAT,Product_category_id:Product_category_id,Condiments_name:remark2,Condiments_code:remark3,Bill:Bill_no,Combo_meal_flag:Combo_meal_flag},
		url: "<?php echo base_url()?>index.php/Shopping/Reorder_add_to_cart",
		success: function(data)
		{
			if(data.cart_success_flag == 1)
			{
				ShowPopup('Product '+name+' is added to Cart Successfuly..!!');				
				// $('.shoppingCart_total').html('$'+data.cart_total);
				// location.reload(true);
				// url: "<?php echo base_url()?>index.php/Shopping/view_cart"
				window.location.replace("<?php echo base_url()?>index.php/Shopping/view_cart");
			}
			else
			{
				ShowPopup('Error adding Product '+name+' to Cart. Please try again..!!');
				// $('.shoppingCart_total').html('$'+data.cart_total);				
				location.reload(true);
			}
		}
	});
}
function Reorder(Bill_no)
{
	show_loader();
	
	$.ajax({
		type: "POST",
		data: {Order_no:Bill_no},
		url: "<?php echo base_url()?>index.php/Shopping/Reorder",
		success: function(data)
		{
			if(data.cart_success_flag == 1)
			{
				ShowPopup('Order is added to Cart Successfuly..!!');				
				// $('.shoppingCart_total').html('$'+data.cart_total);
				// location.reload(true);
				window.location.replace("<?php echo base_url()?>index.php/Shopping/view_cart");
			}
			else
			{
				ShowPopup('Error adding Order to Cart. Please try again..!!');
				// $('.shoppingCart_total').html('$'+data.cart_total);				
				location.reload(true);
			}
		}
	});
}
function ShowPopup(x)
{
	$('#popup_info').html(x);
	$('#popup').show();
	$('#error_display').show();
	setTimeout('HidePopup()', 12000);
}
function HidePopup()
{
	$('#popup').hide();
	$('#error_display').hide();
}
</script>
<style>
#popup 
{
	display:none;
}
</style>
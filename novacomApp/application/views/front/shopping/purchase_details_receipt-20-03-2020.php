<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$ci_object = &get_instance();
$ci_object->load->model('shopping/Shopping_model');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Purchase Details</title>	
<?php $this->load->view('front/header/header');
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?> 	
</head>
<body>
	<?php 
		if($Ecommerce_flag==1) {						
			$cart_check = $this->cart->contents();
			// var_dump($cart_check);
			if(!empty($cart_check)) {
				$cart = $this->cart->contents(); 
				$grand_total = 0; 
				$item_count = COUNT($cart);
			}
		}
		if($item_count <= 0 ) {
			$item_count=0;
		}
		else {
			$item_count = $item_count;
		}						
		if($Ecommerce_flag==1)
		{
			$wishlist = $this->wishlist->get_content();
			if(!empty($wishlist)) {
				
				$wishlist = $this->wishlist->get_content();
				$item_count2 = COUNT($wishlist); 
				
				foreach ($wishlist as $item2) {
					
					$Product_details2 = $this->Shopping_model->get_products_details($item2['id']);
				}
			} 
		}
		if($item_count2 <= 0 ) {
			$item_count2=0;
		}
		else {
			$item_count2 = $item_count2;
		}
	?> 
    <div id="application_theme" class="section pricing-section" style="min-height:650px;">
		<div class="container">
			<div class="section-header">
				<p><a href="<?php echo base_url(); ?>index.php/Shopping/my_orders" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<?php /* ?><p id="Extra_large_font">Voucher No. <?php echo $Order->Voucher_no; ?></p> <?php  */?>
				<p id="Extra_large_font">Order Details</p>
			</div>

			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">				
					<!-- Main Card -->
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
						<!-- 1 card -->
						<div class="pricing-details">
							<div class="row">
								<div class="col-md-12" align="center">
									<div class="row " align="center">
									<?php						
										
										
								$sub_total = 0;
								$Subtotal = array();
								$Shippingcost = array();
								$Paid_amount = array();
								$Mpesa_Paid_Amount = array();
								$COD_Amount = array();
								$RedeemPoints = array();								
								foreach($Order_details as $Order_det)
								{
									
									$Subtotal[] =$Order_det['Purchase_amount'];
									$Shippingcost[] =$Order_det['Shipping_cost'];
									$Paid_amount[] =$Order_det['Paid_amount'];
									$Mpesa_Paid_Amount[] =$Order_det['Mpesa_Paid_Amount'];
									$COD_Amount[] =$Order_det['COD_Amount'];
									$RedeemPoints[]=$Order_det['Redeem_points'];
									
									
									// $sub_total = $sub_total + ($Order_det['Quantity'] * $Order_det['Purchase_amount']);
									$sub_total =  $Order_det['Purchase_amount'];		
									$Bill_no=$Order_det["Bill_no"];
									$Company_id=$Order_det["Company_id"];
									$Voucher_no=$Order_det['Voucher_no'];
									$Shipping_cost=$Order_det['Shipping_cost'];
									$Company_merchandise_item_id=$Order_det['Company_merchandise_item_id'];
									$Thumbnail_image1=$Order_det['Thumbnail_image1'];
									$Merchandize_item_name=$Order_det['Merchandize_item_name'];
									$Quantity=$Order_det['Quantity'];
									$Delivery_method=$Order_det['Delivery_method'];
									$Seller=$Order_det['Seller'];
									$Mpesa_TransID=$Order_det['Mpesa_TransID'];
									
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
										$size = "";
									}	
									
									$VoucherStatus=$Order_det['Voucher_status'];

									if($Order_det['Voucher_status']==20)//Delivered 
									{
										$Voucher_status = ('Delivered');
									}
									elseif($Order_det['Voucher_status']==19)//Shipped
									{
										$Voucher_status = ('Shipped');
										
									}
									elseif($Order_det['Voucher_status']==21)//Cancel
									{
										$Voucher_status= ('Cancel');
										
									}
									elseif($Order_det['Voucher_status']==22)//'Return Initiated'
									{
										$Voucher_status = ('Return Initiated');
										
									}
									elseif($Order_det['Voucher_status']==18) //Ordered
									{
										$Voucher_status = ('Ordered');
										
									} 
									elseif($Order_det['Voucher_status']==23) //Returned
									{
										$Voucher_status = ('Returned');
																		
									} 
									else
									{
										$Voucher_status = "";										
									}
									
									
									
									//********* sandeep ***************
									$MainItemInfo = $this->Shopping_model->get_main_item($Order_det["Item_code"],$Company_id);
							//	print_r($MainItemInfo); 
									$getCondiment = $this->Shopping_model->get_transaction_item_condiments($Bill_no,$Order_det["Item_code"],$Company_id);
	
									foreach($getCondiment as $n)
									{
										$side_item_codes[] = $n["Condiment_Item_code"];
									}
									//********* sandeep ***************
				
									/* $Redeem_points = $Order_det['Redeem_points'] ;
									$calculate_redeem_amounts=round($Redeem_points/$Redemptionratio);
									$Grand_total=($Shipping_cost+$sub_total-$calculate_redeem_amounts); */
                                  
								  //  echo"<br>---calculate_redeem_amounts---".$calculate_redeem_amounts;
								  ?>
								  
									<!--<div class="col-xs-12 text-left"  style="width:100%">
										<div class="col-xs-4" style="width: 20%;float:left;padding-left: 10px;">
											<img src="<?php echo $Thumbnail_image1; ?>" alt="" class="img-rounded img-responsive" width="80">
										</div>
										<div class="col-xs-8" style="width:65%;float:left">
											<strong id="Large_font"><?php echo $Merchandize_item_name; ?></strong><br>
										</div>
									</div>-->										
								<div class="col-xs-12 text-left" align="center" style="width:100%">											
									<div style="overflow-x:auto;float: left;margin-left: 35px;" align="center">
										<table align="center">
											<tr>
												<td><strong id="Medium_font"><img src="<?php echo $Thumbnail_image1; ?>" alt="" class="img-rounded img-responsive" width="80"></strong></td>
												<td><span id="Value_font">:<b><?php echo $Merchandize_item_name; 
												foreach($MainItemInfo as $MainItem){
												if($MainItem['Merchandize_item_name'] != NULL && in_array($MainItem["Main_or_side_item_code"],$side_item_codes)){ ?>
													<a href="#">
														<?php echo "+".$MainItem['Merchandize_item_name']; ?>
													</a>
												<?php }
													 }
												?>
												</b></span></td>												  
											</tr>
											<?php  if($Order_det['remark2'] != ""){ ?>
												<tr>
												
													<td><strong id="Medium_font">Condiments</strong></td>
													<td><span id="Value_font">:&nbsp;<?php 
													if($Order_det['remark2'] != ""){
														echo $Order_det['remark2'];
													} else {
														echo "-";
													}
													 ?></span></td>												  
												</tr>
											<?php  } ?>
											<tr>
												<td><strong id="Medium_font">Quantity</strong></td>
												<td><span id="Value_font">:&nbsp;<?php echo $Quantity; ?></span></td>												  
											</tr>
											<tr>
												<td><strong id="Medium_font">Unit Price</strong></td>
												<td><?php $Unit_price=$Order_det['Purchase_amount']/$Order_det['Quantity']; ?>
													<span id="Value_font">:&nbsp;<?php echo $Symbol_of_currency." ".number_format((float)$Unit_price, 2) ?></span></td>												  
											</tr>
											<tr>
												<td><strong id="Medium_font">Amount</strong></td>
												<td><span id="Value_font">:&nbsp;<?php echo $Symbol_of_currency." ".number_format( (float)($Order_det['Purchase_amount']), 2); ?></span></td>												  
											</tr>
											<tr>
												<td colspan="2">
													<button type="button" id="button" onclick="add_to_cart1('<?php echo $Order_det['Company_merchandise_item_id']; ?>','<?php echo $Order_det["Item_code"]; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$Order_det['Merchandize_item_name']); ?>','<?php echo $Order_det['Billing_price']; ?>',29,'<?php echo $Order_det['Merchandize_Partner_branch']; ?>','<?php echo $Order_det['Company_merchandise_item_id']; ?>','<?php echo $Order_det['Item_size']; ?>','<?php echo $Order_det['Item_Weight']; ?>','<?php echo $Order_det['Weight_unit_id']; ?>','<?php echo $Order_det['Merchandize_Partner_id']; ?>','<?php echo $Order_det['Partner_state']; ?>','<?php echo $Order_det['Partner_Country']; ?>','<?php echo $Order_det['Seller_id']; ?>','<?php echo $Order_det['Merchant_flag']; ?>','<?php echo $Order_det['Cost_price']; ?>','<?php echo $Order_det['VAT']; ?>','<?php echo $Order_det['Merchandize_category_id']; ?>','<?php echo $Order_det['remark2']; ?>','<?php echo $Order_det['remark3']; ?>','<?php echo $Order_det["Bill_no"]; ?>','<?php echo $Order_det['Combo_meal_flag']; ?>');">
														Reorder 
													</button>
													
													
													
													
												</td>												  
											</tr>													
																			
												
										</table>
										<hr />
									</div>
									</div>
									
								  
								<?php 
								
								
									$Redeem_points = $Order_det['Redeem_points'] ;
									$calculate_redeem_amounts=round($Redeem_points/$Redemptionratio);
									$Grand_total=($Shipping_cost+$sub_total-$calculate_redeem_amounts);
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
								if($REDEEM_Points != 0)
								{										
									$RedeemAmount = ($SubtotalAmt+$ShippingcostAmt1)-($MpesaPaidAmount1+$CODAmount1);
								}
								else
								{
									$RedeemAmount=0;
								}
								
								
								/* echo "--VoucherStatus--".$VoucherStatus."---<br>";
								echo "--Redemptionratio--".$Redemptionratio."---<br>";
								echo "--Redeem_points--".$Redeem_points."----<br>";
								echo "--calculate_redeem_amounts--".$calculate_redeem_amounts."---<br>"; */
								
								?>	
								
								
									<div class="col-xs-12 text-left" align="center" style="width:100%">											
										<div style="overflow-x:auto;float: left;margin-left: 35px;" align="center">
										<table align="center">
												<tr>
													<td colspan="2" align="center">
														<button type="button" id="button" onclick="Reorder('<?php echo $Bill_no; ?>');">
															Reorder All Items 
														</button>
													</td>												  
												</tr>
													<tr>
														<td colspan="2" align="center"><hr /><span id="Extra_large_font">Payment Details</span><hr /></td>
													</tr>									
														
														<tr>
															<td><strong id="Medium_font">Sub-Total</strong></td>
															<td>
																<span id="Value_font">:&nbsp;<?php echo $Symbol_of_currency." ". number_format((float)$SubtotalAmt, 2); ?></span></td>										  
														</tr>
														<?php if($ShippingcostAmt1 > 0 ) { ?>
														<tr>
															<td><strong id="Medium_font">Delivery Cost</strong></td>
															<td><span id="Value_font">:&nbsp;<?php echo $Symbol_of_currency." ".number_format((float)$ShippingcostAmt1, 2); ?></span></td>												  
														</tr>
														<?php } ?>
														<?php /***** Hide cahnge Ravi--24-09-2019------ 
														<tr>
															<td><strong id="Medium_font">Redeemed Amount</strong></td>
															<td><span id="Value_font">:&nbsp;<?php echo $Symbol_of_currency." ".number_format( (float)($RedeemAmount), 2); ?></span></td>												  
														</tr>
														----------Hide cahnge Ravi--24-09-2019-------********/ ?>
														
														<tr>
															<td><strong id="Medium_font">Mpesa Paid Amount</strong></td>
															<td><span id="Value_font">:<?php echo $Symbol_of_currency." ".number_format((float)$MpesaPaidAmount1, 2);?> <?php if($Mpesa_TransID !=0 ||  $Mpesa_TransID !="") { ?>&nbsp;(<?php echo $Mpesa_TransID;?>) <?php } ?> </span></td>												  
														</tr>
														
														<tr>
															<?php if($VoucherStatus == 20 ) { ?>
																<td><strong id="Medium_font">COD Amount</strong></td>
															<?php } else { ?>
																<td><strong id="Medium_font">Amount Due</strong></td>
															<?php }?>
															<td><span id="Value_font">:<?php  echo $Symbol_of_currency." ".number_format((float)$CODAmount1, 2);?></span></td>												  
														</tr>
														
														
														
														
														
														
														
														<?php 
														// echo "---Seller--".$Seller."---<br>";
														// echo "---Delivery_method--".$Delivery_method."---<br>";
														?>
														
														<?php if($Delivery_method==29) {

														
														// $str_arr = explode (",",$Order->Cust_address);
														$Cust_address=App_string_decrypt($Order->Cust_address);
														$str_arr = explode(",",$Cust_address);
														$str_arr0 =$str_arr[0];
														$str_arr1 =$str_arr[1];
														$str_arr2 =$str_arr[2];
														$str_arr3 =$str_arr[3];
														
														// $Current_address=$str_arr0.",".$str_arr1.",".$str_arr2.",".$str_arr3;
														?>
														
														<tr>
															<td colspan="2" align="center"><hr /><span id="Extra_large_font">Delivery Address</span><hr /></td>
														</tr>														
														<tr>
															<td><strong id="Medium_font">Member Name</strong></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $Order->Cust_name; ?></span></td>												  
														</tr>
														<tr>
															<td><span id="Medium_font">Estate/ Building No</span></td>
															<td id="tabbleTD" ><span id="Value_font">:<?php echo $str_arr0; ?></span></td>										  
														</tr>
														<tr>
															<td><span id="Medium_font">House Number/ Floor</span></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $str_arr1; ?></span></td>										  
														</tr>
														<tr>
															<td><span id="Medium_font">Street/ Road</span></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $str_arr2; ?></span></td>										  
														</tr>
														<tr>
															<td><span id="Medium_font">Additional</span></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $str_arr3; ?></span></td>										  
														</tr>
														
														
														<?php /* ?>
														<tr>
															<td><strong id="Medium_font">Address Line 1</strong></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $Order->Cust_address; ?></span></td>												  
														</tr>														
														<tr>
															<td><strong id="Medium_font">City</strong></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $Order->City_name; ?></span></td>												  
														</tr>
														<tr>
															<td><strong id="Medium_font">State</strong></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $Order->State_name; ?></span></td>												  
														</tr>
														<tr>
															<td><strong id="Medium_font">Country</strong></td>
															<td id="tabbleTD"><span id="Value_font">: <?php echo $Order->Country_name; ?></span></td>												  
														</tr>
														<tr>
															<td><strong id="Medium_font">Zipcode</strong></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $Order->Cust_zip; ?></span></td>												  
														</tr>
														
														<tr>
															<td><strong id="Medium_font">Contact No</strong></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo substr($Order->Cust_phnno, 2); ?></span></td>												  
														</tr>
														<tr>
															<td><strong id="Medium_font">Contact Email</strong></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $Order->Cust_email; ?></span></td>												  
														</tr><?php */ ?>
														<?php } ?>
														<?php if($Delivery_method==28) {
															$outlet_address = $ci_object->Shopping_model->GetTakeAwayAddress($Company_id,$Seller);
															
															// echo $this->db->last_query();															
															// print_r($outlet_address);
															
															// $str_arr = explode (",",$outlet_address->Current_address);
															/* $str_arr = explode(",",$outlet_address->Current_address);
															$str_arr0 =App_string_decrypt($str_arr[0]);
															$str_arr1 =App_string_decrypt($str_arr[1]);
															$str_arr2 =App_string_decrypt($str_arr[2]);
															$str_arr3 =App_string_decrypt($str_arr[3]); */
															
															$Current_address=App_string_decrypt($outlet_address->Current_address);
															$str_arr = explode(",",$Current_address);
															$str_arr0 =$str_arr[0];
															$str_arr1 =$str_arr[1];
															$str_arr2 =$str_arr[2];
															$str_arr3 =$str_arr[3];
															
															
														?>
														
														<tr>
															<td colspan="2" align="center"><hr /><span id="Extra_large_font">Pick Up Address</span><hr /></td>
														</tr>													
														<tr>
															<td><span id="Medium_font">Outlet Name</span></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $outlet_address->Seller_name; ?></span></td>												  
														</tr>														
														<tr>
															<td><span id="Medium_font">Estate/ Building No</span></td>
															<td id="tabbleTD" ><span id="Value_font">:<?php echo $str_arr0; ?></span></td>										  
														</tr>
														<tr>
															<td><span id="Medium_font">House Number/ Floor</span></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $str_arr1; ?></span></td>										  
														</tr>
														<tr>
															<td><span id="Medium_font">Street/ Road</span></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $str_arr2; ?></span></td>										  
														</tr>
														<tr>
															<td><span id="Medium_font">Additional</span></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $str_arr3; ?></span></td>										  
														</tr>
														<?php /* ?>
														<tr>
															<td><strong id="Medium_font">Address Line 1</strong></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $outlet_address->Current_address; ?></span></td>												  
														</tr>														
														<tr>
															<td><strong id="Medium_font">City</strong></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $outlet_address->City_name; ?></span></td>												  
														</tr>
														<tr>
															<td><strong id="Medium_font">State</strong></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $outlet_address->State_name; ?></span></td>												  
														</tr>
														<tr>
															<td><strong id="Medium_font">Country</strong></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $outlet_address->Country_name; ?></span></td>												  
														</tr>
														<tr>
															<td><strong id="Medium_font">Zipcode</strong></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $outlet_address->Zipcode; ?></span></td>												  
														</tr>												
														<tr>
															<td><strong id="Medium_font">Contact No</strong></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $outlet_address->Phone_no; ?></span></td>												  
														</tr>
														<tr>
															<td><strong id="Medium_font">Contact Email</strong></td>
															<td id="tabbleTD"><span id="Value_font">:<?php echo $outlet_address->User_email_id; ?></span></td>												  
														</tr>
														
														<?php */ ?>
														
														
														<?php } ?>
																								
										</table>
										
										<table align="center">					
												
											<?php
											
											
											$Count_item_offer = $this->Shopping_model->get_purchased_item_offers_details($Voucher_no,$Bill_no,$Company_id);
											
											$Count_offers=count($Count_item_offer);
												
											if($Count_offers > 0)
											{
												foreach($Count_item_offer as $offers)
												{
													$Bill_no=$offers["Bill_no"];
													$Company_id=$offers["Company_id"];
													$Voucher_no=$offers["Voucher_no"];
													$Thumbnail_image1_free=$offers["Thumbnail_image1"];
													$Merchandize_item_name_free=$offers["Merchandize_item_name"];
													$Quantity=$offers["Quantity"];
												}
												
												?>
													
														
														
													<tr>
														<td colspan="2" align="center"><hr />Free Item Details<hr /></td>
													</tr>									
													<tr>
														<td>
															
																
															<img src="<?php echo $Thumbnail_image1; ?>" alt="" class="img-rounded img-responsive" width="80">
																
														
														</td>
														<td>
															<strong id="Medium_font">
															<?php echo $Merchandize_item_name; ?></strong>
															
														</td>												  
													</tr>
													<tr>
														<td><strong id="Medium_font">Quantity</strong></td>
														<td><span id="Value_font">:<?php echo $Quantity; ?></span></td>												  
													</tr>
													<tr>
														<td><strong id="Medium_font">Order No</strong></td>
														<td><span id="Value_font">:<?php echo $Bill_no; ?></span></td>												  
													</tr>
													<tr>
														<td><strong id="Medium_font">Voucher No</strong></td>
														<td><span id="Value_font">:<?php echo $Voucher_no; ?></span></td>												  
													</tr>
													<tr>
														<td><strong id="Medium_font">Unit Price</strong></td>
														<td><?php $Unit_price=$Order_det['Purchase_amount']/$Order_det['Quantity']; ?>
															<span id="Value_font">:&nbsp;<?php echo $Symbol_of_currency." ".number_format((float)$Unit_price, 2) ?></span></td>										  
													</tr>
													<tr>
														<td><strong id="Medium_font">Total Paid</strong></td>
														<td><span id="Value_font">:&nbsp;<?php echo $Symbol_of_currency." ".number_format( (float)($Order_det['Purchase_amount']), 2); ?></span></td>												  
													</tr>													
													<tr>
														<td colspan="2" align="center"><hr />Delivery Address<hr /></td>
													</tr>													
													<tr>
														<td><strong id="Medium_font">Member Name</strong></td>
														<td id="tabbleTD"><span id="Value_font">:<?php echo $Order->Cust_name; ?></span></td>												  
													</tr>
													<tr>
														<td><strong id="Medium_font">Address Line 1</strong></td>
														<td id="tabbleTD"><span id="Value_font">:<?php echo $Order->Cust_address; ?></span></td>												  
													</tr>														
													<tr>
														<td><strong id="Medium_font">City</strong></td>
														<td id="tabbleTD"><span id="Value_font">:<?php echo $Order->City_name; ?></span></td>												  
													</tr>
													<tr>
														<td><strong id="Medium_font">State</strong></td>
														<td id="tabbleTD"><span id="Value_font">:<?php echo $Order->State_name; ?></span></td>												  
													</tr>
													<tr>
														<td><strong id="Medium_font">Country</strong></td>
														<td id="tabbleTD"><span id="Value_font">: <?php echo $Order->Country_name; ?></span></td>												  
													</tr>
													<tr>
														<td><strong id="Medium_font">Zipcode</strong></td>
														<td id="tabbleTD"><span id="Value_font">:<?php echo $Order->Cust_zip; ?></span></td>												  
													</tr>
													<tr>
														<td><strong id="Medium_font">Contact No</strong></td>
														<td id="tabbleTD"><span id="Value_font">:<?php echo substr($Order->Cust_phnno, 2); ?></span></td>												  
													</tr>
													<tr>
														<td><strong id="Medium_font">Contact Email</strong></td>
														<td id="tabbleTD"><span id="Value_font">:<?php echo $Order->Cust_email; ?></span></td>												  
													</tr>
											<?php } ?>														
										</table>
									</div>
								</div>
							<!--</div> -->
							</div> 
							<?php //} ?>
							</div>
						</div>
					
						<hr />
									
					</div>		
					<!-- End -->
				</div>

			</div>
		</div>
    </div>

			
	
 <?php $this->load->view('front/header/footer');?> 

<script>
function add_to_cart1(serial,Itemcode,name,price,Redemption_method,Branch,Company_merchandise_item_id,Item_size,Item_Weight,Weight_unit_id,Partner_id,Partner_state,Partner_Country_id,Seller_id,Merchant_flag,Cost_price,VAT,Product_category_id,remark2,remark3,Bill_no,Combo_meal_flag)
{
	
	
	$.ajax({
		type: "POST",
		data: { id:serial,Company_merchandize_item_code:Itemcode, name:name,price:price,Delivery_method:29,Branch:Branch,Item_size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id,Partner_id:Partner_id,Partner_state:Partner_state,Partner_Country_id:Partner_Country_id,Seller_id:Seller_id,Merchant_flag:Merchant_flag,Cost_price:Cost_price,VAT:VAT,Product_category_id:Product_category_id,Condiments_name:remark2,Condiments_code:remark3,Bill:Bill_no,Combo_meal_flag:Combo_meal_flag},
		url: "<?php echo base_url()?>index.php/Shopping/Reorder_add_to_cart",
		success: function(data)
		{
			if(data.cart_success_flag == 1)
			{
				// ShowPopup('Product '+name+' is added to Cart Successfuly..!!');				
				// $('.shoppingCart_total').html('$'+data.cart_total);
				// location.reload(true);
				// url: "<?php echo base_url()?>index.php/Shopping/view_cart"
				window.location.replace("<?php echo base_url()?>index.php/Shopping/view_cart");
			}
			else
			{
				// ShowPopup('Error adding Product '+name+' to Cart. Please try again..!!');
				// $('.shoppingCart_total').html('$'+data.cart_total);				
				location.reload(true);
			}
		}
	});
}
function Reorder(Bill_no)
{
	// show_loader();	
	$.ajax({
		
		type: "POST",
		data: {Order_no:Bill_no},
		url: "<?php echo base_url()?>index.php/Shopping/Reorder",
		success: function(data)
		{
			if(data.cart_success_flag == 1)
			{
				// ShowPopup('Order is added to Cart Successfuly..!!');				
				// $('.shoppingCart_total').html('$'+data.cart_total);
				// location.reload(true);
				window.location.replace("<?php echo base_url()?>index.php/Shopping/view_cart");
			}
			else
			{
				// ShowPopup('Error adding Order to Cart. Please try again..!!');
				// $('.shoppingCart_total').html('$'+data.cart_total);				
				location.reload(true);
			}
		}
	});
}
</script>
<style>
	.pricing-table .pricing-details ul li {
		padding: 10px;
		font-size: 12px;
		border-bottom: 1px solid #eee;
		color: #ffffff;
		font-weight: 600;
	}	
	.pricing-table
	{
		padding: 12px 12px 0 12px;
		margin-bottom: 0 !important;
		background: #fff;
	}
	
	address{font-size: 13px;}
	
	.main-xs-3
	{
		width: 26%;
		padding: 10px 10px 0 10px;
	}
	
	.main-xs-6
	{
		width: 48%;
		padding: 10px 10px 0 10px;
	}
</style>
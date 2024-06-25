<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title?></title>	
	<?php $this->load->view('front/header/header'); 
	$ci_object = &get_instance();
	$ci_object->load->helper(array('encryption_val'));
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?> 
</head>
<body>   
   <?php 
	// echo"--Ecommerce_flag---".$Ecommerce_flag."--<br>"; 
		$cart_check = $this->cart->contents();
			// var_dump($cart_check);
                if(!empty($cart_check)) {
                    $cart = $this->cart->contents(); 
                    $grand_total = 0; 
                    $item_count = COUNT($cart); 
                }		
		if($item_count <= 0 ) {
			$item_count=0;
		}
		else {
			$item_count = $item_count;
		}
		$wishlist = $this->wishlist->get_content();
		if(!empty($wishlist)) {
                    
			$wishlist = $this->wishlist->get_content();
			$item_count2 = COUNT($wishlist); 
			foreach ($wishlist as $item2) {

					$Product_details2 = $this->Shopping_model->get_products_details($item2['id']);
			}
		}		
		if($item_count2 <= 0 ) {
			$item_count2=0;
		}
		else {
			$item_count2 = $item_count2;
		}		
		// echo"--item_count2---".$item_count2."--<br>"; id=""
/* delivery_type='+delivery_type+'&delivery_outlet='+delivery_outlet+'&Address_type='+Address_type' */
		?> 
	<?php  echo form_open('Shopping/update_cart'); ?>
        <div id="application_theme" class="section pricing-section" style="min-height:520px;">
            <div class="container">
                <div class="section-header">          
                        <p><a href="<?php echo base_url(); ?>index.php/Shopping/checkout2?delivery_type=<?php echo $_SESSION['delivery_type']; ?>&delivery_outlet=<?php echo $_SESSION['delivery_outlet']; ?>&Address_type=<?php echo $_SESSION['Address_type']; ?>" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                        <p id="Extra_large_font">Order Review</p>
                </div>
                <div class="row pricing-tables">			
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">				
                        <!-- Main Card -->
        <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
                        <?php if(!empty($cart_check)) { ?>	<!-- 1 card -->
                        <?php 
                            foreach($this->cart->contents() as $cart_item) {
                            $Product_details = $this->Shopping_model->get_products_details($cart_item['id']);
                        ?>								
                        <div class="pricing-details">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row ">
                                        <div class="col-xs-4" style="padding: 2px 8px 0px 8px">
                                           <!-- <img src="<?php //echo $Product_details->Thumbnail_image1; ?>" alt="<?php //echo $Product_details->Merchandize_item_name; ?>" class="img-rounded img-responsive" width="70" height="70">-->
                                        </div>										
                                        <div class="col-xs-8 text-left" style="width: 65%;">
                                            <address>
												<?php
															// echo"<br>---Combo_meal_flag----".$Product_details->Combo_meal_flag;				
															if($Product_details->Combo_meal_flag ==1 ) {
																
																$MerchandizeIteName = explode('+', $Product_details->Merchandize_item_name);
																$itemName= $MerchandizeIteName[0];
															} else {
																
																$itemName= $Product_details->Merchandize_item_name;
															}
														?>
                                                <strong id="Medium_font"><?php echo $itemName;

												if($cart_item["Main_item"] != NULL)
													{
														foreach($cart_item["Main_item"] as $b3){
															if($b3["Merchandize_item_name"] != NULL)
															{
																echo "+".$b3["Merchandize_item_name"];
															}
														}
													}
													
												?></strong><br>
												<address>
													<strong id="Small_font">
														<?php  echo $cart_item["options"]["remark2"];
														?>
													</strong><br>
												</address>
												<address> 
														<strong id="Small_font">Unit Price </strong>
														<strong id="Value_font" style="float: right;" ><?php
															$grand_total = $grand_total + $cart_item['subtotal'];
															echo $Symbol_of_currency.' '.number_format($cart_item['price'], 2);
															?>
														</strong><br>
												</address>
												<?php //echo"<br>----SideCondiments_TotalPrice----".$cart_item['SideCondiments_TotalPrice']; ?>
												<?php if($cart_item['SideCondiments_TotalPrice']) { ?>
												<address> 
														<strong id="Small_font">Condiments Price </strong>
														<strong id="Value_font" style="float: right;" ><?php
															 echo $Symbol_of_currency.' '.number_format( ($cart_item['MainItem_TotalPrice'] + $cart_item['SideCondiments_TotalPrice']) * $cart_item['qty'], 2);
															?>
														</strong><br>
												</address>
												<?php } ?>
												<address> 
														<strong id="Small_font">Sub Total</strong>
														<strong id="Value_font" style="float: right;" ><?php
															// $grand_total = $grand_total + $item['subtotal'];
														 echo $Symbol_of_currency.' '.number_format((float)$cart_item['subtotal'], 2);
															?>
														</strong><br>
												</address>
                                                <div id="Best">													
                                                        <strong id="Small_font">Quantity </strong>: 
                                                        <strong id="Value_font"><?php echo $cart_item['qty']; ?> </strong>
													<?php /*  ?>														
														<strong id="Value_font" style="margin-left: 10%;"><?php
                                                        $grand_total = $grand_total + $cart_item['subtotal'];
                                                        echo $Symbol_of_currency.' '.number_format((float)$cart_item['subtotal'], 2);
                                                        ?></strong>
													<?php  */ ?>
                                                </div>
                                            </address>
                                        </div>
                                    </div>
								</div>
                            </div>
						</div> <hr />
						<?php }
							
							/*

								$_SESSION["Redeem_amount"]=$Redeem_amount; 
								$_SESSION["Final_Grand_total"]=$_SESSION['Grand_total']-$_SESSION["Redeem_amount"];
								$_SESSION["Final_Grand_total"]=$_SESSION['Grand_total']; 

								echo"---Redeem_amount----".$_SESSION["Redeem_amount"]."---<br>";
								echo"---Final_Grand_total----".$_SESSION["Final_Grand_total"]."---<br>";
								echo"---Grand_total----".$_SESSION['Grand_total']."---<br>";

							*/
							
							// echo"---Grand_total----".$_SESSION['Grand_total']."---<br>";
							
                            ?>		
                            <!-- 4 card -->
                            <div class="pricing-details">
                                <div class="row">
                                    <div class="col-md-12" align="center" style="width:100%">
										<div style="overflow-x:auto;">
											<table>
												<tr>
														<?php 
															$Name   = 	$delivery_outlet_details->First_name . ' ' . $delivery_outlet_details->Last_name;		
															// $str_arr = explode(",",$delivery_outlet_details->Current_address);
															
															/* $str_arr = explode(",",$delivery_outlet_details->Current_address);
															$str_arr0 =App_string_decrypt($str_arr[0]);
															$str_arr1 =App_string_decrypt($str_arr[1]);
															$str_arr2 =App_string_decrypt($str_arr[2]);
															$str_arr3 =App_string_decrypt($str_arr[3]);
															
															$Current_address=$str_arr0.",".$str_arr1.",".$str_arr2.",".$str_arr3; */
															
															
															$Current_address=App_string_decrypt($delivery_outlet_details->Current_address);
															$str_arr = explode(",",$Current_address);
															$str_arr0 =$str_arr[0];
															$str_arr1 =$str_arr[1];
															$str_arr2 =$str_arr[2];
															$str_arr3 =$str_arr[3];
															
															// var_dump($Current_address);
															
														?>
															<td colspan="2" align="center"><hr />
																<span id="Medium_font">
																	All orders should be collected from the <?php echo $Name; ?> Branch, <?php echo $str_arr2; ?>
																</span>
															</td>
													
													
												</tr>
													<?php if($delivery_outlet_details->Order_preparation_time != "") { ?>												
													<tr>
															
														<td colspan="2" align="center"><hr />
															<span id="Medium_font">
																The order will be ready within <?php echo $delivery_outlet_details->Order_preparation_time; ?>
															</span>
														</td>
														
														
													</tr>	
												<?php } ?>													
												<tr>
													<td colspan="2" align="center"><hr /><span id="Extra_large_font">Payment Details</span><hr /></td>
												</tr>
												<tr>
													<td><strong id="Medium_font">Sub-Total</strong></td>
													<td><span id="Value_font">:<?php echo $Symbol_of_currency; ?>&nbsp;</span>
													
													<input type="text" class="txt"  value="<?php echo $_SESSION['Sub_total']; ?>" style="width: 76px;" readonly>
													</td>												  
												</tr>
												<?php if($_SESSION['delivery_type']==29) { ?>
													<tr>
														<td><strong id="Medium_font">Delivery Cost</strong></td>
														<td>
															
															<span id="Value_font" >:&nbsp;<?php echo $Symbol_of_currency; ?>
															</span>
														
															<input type="text" class="txt"  value="<?php echo number_format($_SESSION['Total_Shipping_Cost'],2); ?>" style="width: 76px;" readonly> 
														
														
														</td>												  
													</tr>
												<?php } ?>
												<?php if($Company_Details->Loyalty_enabled ==1) { ?> 
												<tr>
													<td><strong id="Medium_font">Less Redeemed Amt</strong></td>
													<td>
													
													<?php 
													
													// echo "<br>---DiscountAmt-----".$DiscountAmt; 
													// echo "<br>---Sub_total-----".$_SESSION['Sub_total'];
													
													// $RedeemedAmt=($_SESSION['Sub_total'] - $DiscountAmt); 
													// echo "<br>---RedeemedAmt-----".$RedeemedAmt; 
													
													?>
													<?php if($_SESSION['Final_Grand_total'] < 0)  { ?> 
													
														<span id="Value_font">:&nbsp;<?php echo $Symbol_of_currency; ?>&nbsp;</span>
														
														<input type="text" class="txt"  value="<?php echo $_SESSION['Grand_total']; ?>" style="width: 76px;" readonly> 
														
													<?php } else { ?>  
															
															<span id="Value_font">:<?php echo $Symbol_of_currency; ?>&nbsp;</span>
															
															<?php 
															if($_SESSION["Redeem_amount"]){
																$_SESSION["Redeem_amount"]=$_SESSION["Redeem_amount"];
															} else {
																$_SESSION["Redeem_amount"]='0.00';
															}
																
															?>
															<input type="text" class="txt"  value="<?php echo number_format($_SESSION["Redeem_amount"],2); ?>" style="width: 76px;" readonly> 
															
													<?php } ?>
													
													
													
													
													</td>												  
												</tr>
												<?php } ?>
												
												
												<?php if($DiscountAmt > 0) { ?> 
												<tr>
													<td><strong id="Medium_font">Discount Amt</strong></td>
													<td><span id="Value_font">:<?php echo $Symbol_of_currency; ?>&nbsp;</span>
													
													<input type="text" class="txt"  value="<?php echo number_format($DiscountAmt,2); ?>" style="width: 76px;" readonly>
													</td>												  
												</tr>
												<?php } ?>
													<?php if($_SESSION['VoucherDiscountAmt'] > 0) { ?>
													<tr>
														<td><strong id="Medium_font">Voucher Discount</strong></td>
														<td><span id="Value_font">:<?php echo $Symbol_of_currency; ?> &nbsp;</span>
														<input type="text" class="txt"  value="<?php echo number_format($_SESSION['VoucherDiscountAmt'],2); ?>" style="width: 76px;" readonly>
														</td>
													</tr> 
												<?PHP } ?>
												<?php if($PaymentMethod==6){ ?>
												<tr>
													<td><strong id="Medium_font">Less mPesa Amt.</strong></td>
													<td><span id="Value_font">:&nbsp;<?php echo $Symbol_of_currency; ?>&nbsp;</span>
													<input type="text" class="txt"  value="<?php echo number_format($mpesa_BillAmount,2); ?>" style="width: 76px;" readonly>
													</td>
												</tr>
												<?php } ?>
												<tr>
												
													<?php /* echo"---Final_Grand_total---(".$_SESSION['Final_Grand_total'].")"; ?>
													<?php echo"---mpesa_BillAmount---(".$mpesa_BillAmount.")"; */ ?>
													
													
													
													<td><strong id="Medium_font">Total Due Amount</strong></td>
													<td>
													
														<?php if($_SESSION['Final_Grand_total'] < 0)  { ?> 
													
														<span id="Value_font">:&nbsp;<?php echo $Symbol_of_currency; ?>&nbsp;</span>
														
														<input type="text" class="txt"  value="0.00" style="width: 76px;" readonly>
														
													<?php } else { ?>  
															
															<span id="Value_font">:&nbsp;<?php echo $Symbol_of_currency; ?>&nbsp;</span>
															
															<input type="text" class="txt"  value="<?php echo  number_format($_SESSION['Final_Grand_total']-$mpesa_BillAmount,2); ?>" style="width: 76px;" readonly>
															
													<?php } ?>
														
													</td>												  
												</tr>
												<tr>
													<?php 
													 // echo "---delivery_type----".$_SESSION['delivery_type']; 
													 // echo "---PaymentMethod----".$PaymentMethod; 
													// print_r($customer_delivery_details->Address);
													// print_r($delivery_outlet_details);
													?>
													<?php if($_SESSION['delivery_type'] == 29) { ?>
														<td colspan="2" align="center"><hr /><span id="Extra_large_font">Delivery Address</span><hr /></td>
													<?php } else if($_SESSION['delivery_type']==28){ ?>
														<td colspan="2" align="center"><hr /><span id="Extra_large_font">Pick-Up</span><hr /></td>
													<?php } else if($_SESSION['delivery_type']==107){ ?>
														<td colspan="2" align="center"><hr /><span id="Extra_large_font">In-Store Order</span><hr /></td>
													<?php } ?> 													
													<?php
														
														// print_r($_SESSION['delivery_type']);
														// print_r($delivery_outlet_details);
														if($_SESSION['delivery_type'] == 29 )
														{
															// echo "<br>--29";
															$str_arr=App_string_decrypt($customer_delivery_details->Address);													
															$str_arr = explode(",",$str_arr);													
															$str_arr0 =$str_arr[0];
															$str_arr1 =$str_arr[1];
															$str_arr2 =$str_arr[2];
															$str_arr3 =$str_arr[3];
															
															
															
															$customer_address=$str_arr0.",".$str_arr1.",".$str_arr2.",".$str_arr3;
															
															
															$Name= 		$customer_delivery_details->Contact_person;
															$Address=   $customer_address;
															$Zipcode=  	$customer_delivery_details->Zipcode;
															$Phone =		App_string_decrypt($customer_delivery_details->Phone_no);
															$city_name =    	$customer_delivery_details->city_name;
															$state_name =    	$customer_delivery_details->state_name;
															$country_name =    	$customer_delivery_details->country_name;
															
															// $str_arr = explode(",",$customer_delivery_details->Address);
														}
														else if($_SESSION['delivery_type']==28 )
														{
															// echo "<br>--28";
															
															/* $str_arr2 = explode(",",$delivery_outlet_details->Current_address);
															$str_arr20 =App_string_decrypt($str_arr2[0]);
															$str_arr21 =App_string_decrypt($str_arr2[1]);
															$str_arr22 =App_string_decrypt($str_arr2[2]);
															$str_arr23 =App_string_decrypt($str_arr2[3]);
															print_r($delivery_outlet_details->Current_address);
															$Outlet_address1=$str_arr20.",".$str_arr21.",".$str_arr22.",".$str_arr23; */
															
															$Name   = 	$delivery_outlet_details->First_name . ' ' . $delivery_outlet_details->Last_name;											
															$Address=   $Current_address;
															$Phone  =	App_string_decrypt($delivery_outlet_details->Phone_no);												
															$Zipcode=  	$delivery_outlet_details->Zipcode;
															
															$city_name  =   $delivery_outlet_details->city_name;
															$state_name  =   $delivery_outlet_details->state_name;
															$country_name  =   $delivery_outlet_details->country_name;												
															// $str_arr = explode(",",$delivery_outlet_details->Current_address);												
														}
														else if($_SESSION['delivery_type']==107){
															
															// echo "<br>--107";
															
															/* $str_arr2 = explode(",",$delivery_outlet_details->Current_address);
															$str_arr20 =App_string_decrypt($str_arr2[0]);
															$str_arr21 =App_string_decrypt($str_arr2[1]);
															$str_arr22 =App_string_decrypt($str_arr2[2]);
															$str_arr23 =App_string_decrypt($str_arr2[3]);
															
															$Outlet_address1=$str_arr20.",".$str_arr21.",".$str_arr22.",".$str_arr23; */
															
															$Customer_Name = $Enroll_details->First_name. ' ' . $Enroll_details->Last_name;
															$Name   = 	$delivery_outlet_details->First_name . ' ' . $delivery_outlet_details->Last_name;											
															$Address=   $Current_address;
															$Phone  =	App_string_decrypt($delivery_outlet_details->Phone_no);															
															$Zipcode=  	$delivery_outlet_details->Zipcode;
															
															$city_name  =   $delivery_outlet_details->city_name;
															$state_name  =   $delivery_outlet_details->state_name;
															$country_name  =   $delivery_outlet_details->country_name;												
															// $str_arr = explode(",",$delivery_outlet_details->Current_address);
														}
														// $Current_address=$str_arr0.",".$str_arr1.",".$str_arr2.",".$str_arr3;
														// var_dump($str_arr0);
													?>
														
												</tr>
												<?php if($_SESSION['delivery_type']==107){ ?>
												<tr>													
													<td><span id="Value_font"><?php echo $Customer_Name; ?></span></td>
												</tr>
												<?php } ?>
												<tr>													
													<td><span id="Value_font"><?php echo $Name; ?></span></td>
												</tr>
												<?php if($_SESSION['delivery_type']==107 && $_SESSION["TableNo"] != "" ){ ?>
												<tr>													
													<td><span id="Value_font">Table No. :<?php echo $_SESSION["TableNo"]; ?></span></td>
												</tr>
												<?php } ?>
												<tr>													
													<td><span id="Value_font"><?php echo $str_arr0; ?></span></td>
												</tr>
												<tr>													
													<td><span id="Value_font"><?php echo $str_arr1; ?></span></td>
												</tr>
												<tr>													
													<td><span id="Value_font"><?php echo $str_arr2; ?></span></td>
												</tr>
												<tr>													
													<td><span id="Value_font"><?php echo $str_arr3; ?></span></td>
												</tr>
												<tr>
													<td><span id="Value_font"><?php echo $Phone; ?></span></td>
												</tr>
												
																							
											</table>
										</div>
										<hr />
                                      
                                    </div>
                                </div>
                            </div>
                            <!-- 4 card -->
							<?php /* ?>
                            <div class="pricing-details">
                                <div class="row">
                                    <div class="col-md-12">									
                                            
										
								<div class="col-xs-12 text-right" >
								<?php											// print_r($New_shipping_details);
									if($New_shipping_details != "")
									{
										$Name= 		$New_shipping_details['firstname1'] . ' ' . $New_shipping_details['lastname1'];
										$Address=   $New_shipping_details['address1'];
										$Zipcode=  	$New_shipping_details['zip1'];
										$Phone=		$New_shipping_details['phone1'];
										$Email=    	$New_shipping_details['email1'];
									}
									else
									{
										$Name   = 	$Enroll_details->First_name . ' ' . $Enroll_details->Last_name;
										$Address=   $Enroll_details->Current_address;
										$Zipcode=  	$Enroll_details->Zipcode;
										$Phone  =	$Enroll_details->Phone_no;
										$Email  =   $Enroll_details->User_email_id;
									}											
								?>
								<strong id="Medium_font" align="left" style="margin-right: 84px;">Delivery Information</strong><br>
									<span align="left" style="line-height: 22px;">
											<strong id="Medium_font">Name</strong><br>
											<strong id="Medium_font">Address</strong><br>
											<strong id="Medium_font">Zipcode</strong><br>
											<strong id="Medium_font">Phone no </strong><br>
											<strong id="Medium_font">Email id</strong>
									</span>
									<span align="left" >

											 <span id="Value_font">:&nbsp;<?php echo $Name; ?></span><br>
											 <span id="Value_font">:&nbsp;<?php echo $Address; ?></span><br>
											 <span id="Value_font">:&nbsp;<?php echo $Zipcode; ?></span><br>
											 <span id="Value_font">:&nbsp;<?php echo $Phone; ?></span><br>
											 <span id="Value_font">:&nbsp;<?php echo $Email; ?></span>
									</span>											
								</div>
								</div>
								</div>
							</div>
						<hr> 
						<?php */ ?>
						
						<!-- Cart Details -->
							
            <div class="pricing-details">
                    <div class="row">
							<?php /* ?>
                            <div class="col-xs-4 main-xs-6 text-left" >
                                    <button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return Go_to_payment(<?php echo $_SESSION['delivery_type']; ?>,<?php echo $_SESSION['delivery_outlet']; ?>,<?php echo $_SESSION['Address_type']; ?>);" > Back</button>
                            </div>
							<?php */ ?>

                            <div class="col-xs-4 main-xs-6 text-center" style="width:100%" >
                                    <?php if($PaymentMethod == 3) { ?>
                                           <button type="button" id="button1" class="b-items__item__add-to-cart"  onclick="return Go_to_DoExpressCheckoutPayment();"> Place Order</button>
                                       <?php } else { ?>                                    
                                        <button type="button" id="button1" class="b-items__item__add-to-cart"  onclick="return Go_to_CheckoutPayment(<?php echo $_SESSION['delivery_type']; ?>,<?php echo $_SESSION['delivery_outlet']; ?>,<?php echo $_SESSION['Address_type']; ?>);"> Place Order</button>


										







                                   <?php } ?> 
                            </div>
                    </div>
            </div>
            <hr>
            <?php } ?>	
            <!-- 6th Sub -->
            <?php if(empty($cart_check)) { ?>
				<div class="pricing-details">
					<div class="row">
						<div class="col-md-12">			
							<address>
								<button type="button" id="button1" onclick="return Go_to_Shopping();">Menu</button>
							</address>
						</div>
					</div>
				</div>

            <?php } ?>
									
        </div>		
					<!-- End -->
    </div>
				
				

</div>
</div>
</div>
	<?php echo form_close(); ?>	
	
   <!-- Loader -->	
    <div class="container" >
        <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm" style="margin-top: 65%;">
              <!-- Modal content-->
              <div class="modal-content" id="loader_model">
                    <div class="modal-body" style="padding: 10px 0px;;">
                      <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
                    </div>							
              </div>						  
            </div>
        </div>					  
    </div>
    <!-- Loader -->     
   <?php $this->load->view('front/header/footer');?> 
 
<script>
	
    /* var delivery_type='<?php echo $delivery_type; ?>';
	var delivery_outlet='<?php echo $delivery_outlet; ?>';
	var Address_type='<?php echo $Address_type; ?>'; */
	
    function Go_to_CheckoutPayment(delivery_type,delivery_outlet,Address_type)
    { 
        setTimeout(function() 
        {
                $('#myModal').modal('show');
                window.location='<?php echo base_url()?>index.php/shopping/CheckoutPayment?delivery_type='+delivery_type+'&delivery_outlet='+delivery_outlet+'&Address_type='+Address_type;
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
            
        },500000);
    }   
    function Go_to_DoExpressCheckoutPayment()
    { 
        setTimeout(function() 
        {
                $('#myModal').modal('show');	
                 window.location='<?php echo base_url()?>index.php/express_checkout/DoExpressCheckoutPayment';
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
           
        },500000);
    }
    function Go_to_payment(delivery_type,delivery_outlet,Address_type)
    { 
        setTimeout(function() 
        {
			$('#myModal').modal('show');	
			// window.location.href='<?php echo base_url()?>index.php/Shopping/checkout2';
			window.location.href='<?php echo base_url()?>index.php/Shopping/checkout2?delivery_type='+delivery_type+'&delivery_outlet='+delivery_outlet+'&Address_type='+Address_type;
			
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
           
        },20000);
    }
    function Go_to_Shopping()
    { 
        setTimeout(function() 
        {
                $('#myModal').modal('show');	
                window.location.href='<?php echo base_url(); ?>index.php/Shopping';
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
            
        },20000);
    }
function place_order(flag)
{	
    if(flag==1)
    {
            window.location='<?php echo site_url('express_checkout/DoExpressCheckoutPayment'); ?>';
    }
    else
    {
            window.location='<?php echo site_url('shopping/CheckoutPayment'); ?>';
    }
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
	.footer-xs {
		padding: 10px;
		color: #000;
		width: 33.33%;
		border-right: 1px solid #eee;
	}
	
	.main-xs-3
	{
		width: 26%;
		padding: 10px 10px 0 10px;
	}
	
	.main-xs-6
	{
		width: 50%;
		padding: 10px 10px 0 10px;
	}
	
	.txt {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            border-left-color: -moz-use-text-color;
            border-left-style: none;
            border-left-width: medium;
            border-top-color: -moz-use-text-color;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border-top-style: none;
            border-top-width: medium;
            margin-left: 0;
            outline-color: -moz-use-text-color;
            outline-style: none;
            outline-width: medium;
            padding-bottom: 2%;
            padding-left: 1%;
            padding-right: 8%;
            padding-top: 4%;
            width: 100px;
			text-align: right;
      }
	
</style>
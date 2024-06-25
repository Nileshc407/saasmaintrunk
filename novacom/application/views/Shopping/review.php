<?php
$this->load->view('header/header');
$ci_object = &get_instance();
$ci_object->load->library('session');
$session_data = $this->session->userdata('shopping_cart');
$shopping_cart = $session_data['shopping_cart'];

$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];

$delivery_session_data = $this->session->userdata('delivery_session');
$delivery_type=$delivery_session_data['delivery_type'];
$delivery_outlet=$delivery_session_data['delivery_outlet'];
$delivery_outlet_details = $this->Igain_model->get_enrollment_details($delivery_outlet);
$Outlet_name = $delivery_outlet_details->First_name.' '.$delivery_outlet_details->Last_name;
$Order_preparation_time = $delivery_outlet_details->Order_preparation_time;
$Outlet_table_no_flag = $delivery_outlet_details->Table_no_flag;
$ci = &get_instance();
$ci->load->helper('encryption_val');
?>
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>

<section class="content-header">
    <h1>Checkout - Order Review</h1>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12 clearfix" id="checkout">
            <?php
            if(@$this->session->flashdata('error_code'))
            {
            ?>
                <script>
                    var Title = "Application Information";
                    var msg = '<?php echo $this->session->flashdata('error_code'); ?>';
                    runjs(Title,msg);
                </script>
            <?php
            }
            ?>
            <div class="box">
                <ul class="nav nav-pills nav-justified">	
                    <li class="active"><a href="#" style="background-color: #332005;border: none;"><i class="fa fa-eye"></i> &nbsp; Review Order</a></li>
                </ul>
                <div class="content">
                    <div class="table-responsive">
                        <table class="table" style="border: 1px solid #ddd;">
                            <thead>
								<tr>
									<th>Menu Item</th>
									<th>Condiments</th>
									<th>Price (<b><?php echo $Symbol_of_currency; ?></b>)</th>
									<th>Quantity</th>
									<th>Condiments Total Price (<b><?php echo $Symbol_of_currency; ?></b>)</th>
									 <th>Total (<b><?php echo $Symbol_of_currency; ?></b>)</th>
								</tr>
                            </thead>
                            <tbody>
                                <?php
									 foreach($this->cart->contents() as $cart_item) {
									?>
                                            <tr>
												<td>
													<?php echo $cart_item['name']; 
													//print_r($cart_item["Main_item"]);
													
													if($cart_item["Main_item"] != NULL)
													{
														foreach($cart_item["Main_item"] as $b3){
															if($b3["Merchandize_item_name"] != NULL)
															{
																echo "+".$b3["Merchandize_item_name"];
															}
														}
													}
													?>
												</td>
												<td>
													<?php 
													echo $cart_item["options"]["remark2"];
														
													?>
												</td>
												
												<td><?php echo number_format($cart_item['price'],2); ?></td>
												
												<td><?php echo $cart_item['qty']; ?></td>
												<td><?php echo number_format( ($cart_item['MainItem_TotalPrice'] + $cart_item['SideCondiments_TotalPrice']) * $cart_item['qty'], 2); ?></td>
												<td>&nbsp;<?php echo number_format($cart_item['subtotal'],2); ?></td>
                                            </tr>
                                    <?php
                                    }
                                    ?>
                            </tbody>
                        </table>
                    </div>
                </div>
						<?php if($_REQUEST['address_flag'] != '') { } else { 
							$delivery_outlet_address1 = (explode(",",$delivery_outlet_details->Current_address)); 
							$outlet_address_line22 = $delivery_outlet_address1['2'];
						?> 
						<span id="Order_note" style="padding: 0px 13%; font-size: 15px;"><b><?php echo 'All Orders Should be Collected from the '.$Outlet_name.' Branch, '.$outlet_address_line22; ?></b></span><br><br>
						<?php } 
						
						if($Order_preparation_time!=Null) { ?>
						<span id="Order_note" style="padding: 0px 29%; font-size: 15px;"><b><?php echo 'The order will be ready within '.$Order_preparation_time.'.'; ?></b></span><br><br>
						<?php } ?>
						
                        <div class="content">
							<?php 			
							if($_REQUEST['address_flag'] != '') { ?> 
								<div class="col-md-4 column clearfix">
									<p><strong>Delivery Information</strong></p>
									<p> <?php
									
										$address = (explode(",",App_string_decrypt($Address_type_details->Address))); 
										 
										$address_line1 = $address['0'];
										$address_line2 = $address['1'];
										$address_line3 = $address['2'];
										$address_line4 = $address['3'];
										
										echo $Address_type_details->Contact_person."<br>";
										// echo $Address_type_details->Address."<br>";
										echo $address_line1.',<br>';
										echo $address_line2.',<br>';
										echo $address_line3.',<br>';
										if($address_line4!=Null) { echo $address_line4.',<br>'; }
										echo $Address_type_details->city_name.", ".$Address_type_details->country_name.".<br>";
										echo App_string_decrypt($Address_type_details->Phone_no)."<br>";
									?>
										
									</p>
								</div>
						<?php 	} 
								else 	
								{ 
									$delivery_type=$delivery_session_data['delivery_type']; 
									
									if($delivery_type == 1) 
									{ 
										$Delivery_type_lable = 'Pick-Up';
									}
									else if($delivery_type == 2) 
									{
										$Delivery_type_lable = 'In-Store';
									}
									else
									{
										$Delivery_type_lable = '';
									}
							?>
									<div class="col-md-4 column clearfix">
										<!--<p><strong>Take Away</strong></p>-->
										<p><strong><?php echo $Delivery_type_lable; ?></strong></p>
										<p>
										<?php
											$delivery_outlet_address = (explode(",",App_string_decrypt($delivery_outlet_details->Current_address))); 
										 
											$outlet_address_line1 = $delivery_outlet_address['0'];
											$outlet_address_line2 = $delivery_outlet_address['1'];
											$outlet_address_line3 = $delivery_outlet_address['2'];
											$outlet_address_line4 = $delivery_outlet_address['3'];
											
											echo $delivery_outlet_details->First_name.' '.$delivery_outlet_details->Last_name."<br>";
											/* echo $delivery_outlet_details->Current_address."<br>"; */
											if($delivery_type == 2)
											{
												$table_no_session_data = $this->session->userdata('table_no_session');
												$Session_table_no=$table_no_session_data['Table_no'];
												if($Outlet_table_no_flag == 1) {
												echo "Table No. : ".$Session_table_no."<br>";
												}
											}
											echo $outlet_address_line1.",<br>";
											echo $outlet_address_line2.",<br>";
											echo $outlet_address_line3.",<br>";
											if($outlet_address_line4!=Null) { echo $outlet_address_line4.',<br>'; }
											//echo $delivery_outlet_details->Zipcode."<br>";
											echo App_string_decrypt($delivery_outlet_details->Phone_no)."<br>";
										?>
										</p>
									</div>
							<?php } ?>								

							<div class="col-md-4 column clearfix">
								<div class="table-responsive">
								<?php if($Outlet_name !="") {  echo "<b>Outlet Name : </b>".$Outlet_name."" ; } else { echo "<b>Outlet Name : - </b>"; }  ?>
								</div>
							</div>
							<div class="col-md-4 column clearfix">
								<div class="table-responsive">
									<table class="table" style="border: 1px solid #ddd;">
										<tbody>
											<tr>
												<td><strong> Subtotal</strong></td>
												<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo number_format($Sub_total,2); ?></td>
											</tr>
											<?php if($_SESSION['Total_Shipping_Cost'] > 0) { ?>
											<tr>
												<td><strong> Total Delivery Cost</strong></td>
												<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php 
												echo number_format($_SESSION['Total_Shipping_Cost'],2); ?></td>
											</tr>
											<?php } ?>
											<?php if($Loyalty_enabled == 1) { ?>
											<tr>
												<td><strong>Less Redeemed Amt.</strong></td>
												<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo number_format($Redeem_amount,2); ?></td>
											</tr> 
											<?php } if($DiscountAmt > 0) { ?>
												<tr>
												<td><strong>Discount Amt.</strong></td>
												<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo number_format($DiscountAmt,2); ?></td>
												</tr> 
											<?PHP } ?>
											
											<?php if($_SESSION['VoucherDiscountAmt'] > 0) { ?>
												<tr>
												<td><strong>Voucher Discount</strong></td>
												<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo number_format($_SESSION['VoucherDiscountAmt'],2); ?></td>
												</tr> 
											<?PHP } ?>

											<?php if($PaymentMethod==6 && $mpesa_BillAmount > 0) { ?>
											<tr>
												<td><strong>Less mPesa Amt.</strong></td>
												<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo number_format($mpesa_BillAmount,2); ?></td>
											</tr>
											<?php } ?>
											<tr>
												<td><strong>Balance to Pay</strong></td>
												<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php  echo number_format($Final_Grand_total-$mpesa_BillAmount,2); ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
                        </div>

						<hr>
						<div class="box-footer" style="padding:10px;margin-top:10px;background: #fff;border-top:none">
							<div class="row" >
								<div class="col-md-6 col-xs-6">	 <?php /*
									<a href="<?php echo base_url()?>index.php/Shopping/checkout2/?address_flag=<?php echo $delivery_address_type; ?>" class="btn btn-default">
									<i class="fa fa-backward" aria-hidden="true"></i>&nbsp; Payment </a> */?>
								</div>
								<div class="col-md-6 col-xs-6" align="right" >
										 <?php if($PaymentMethod == 3) { ?>                                    
                                        <a class="btn btn-template-main" href="javascript:void(0);" onclick="place_order(1);">
                                            Place Order
                                        </a>
                                    
                                    <?php } else { ?>                                    
                                        <a class="btn btn-template-main" href="javascript:void(0);" onclick="place_order(2);">
                                            Place Order
                                        </a>
                                    <?php } ?> 	
								</div>
							</div>
						</div>
                </div>
            </div>
        </div>
</section>
<?php $this->load->view('header/loader');?> 
<?php $this->load->view('header/footer');?>
<script>
function place_order(flag)
{
	show_loader();
	if(flag==1)
	{
		window.location='<?php echo site_url('express_checkout/DoExpressCheckoutPayment'); ?>';
	}
	else
	{
		window.location='<?php echo site_url('shopping/CheckoutPayment/?address_flag='.$_REQUEST["address_flag"].''); ?>';
	}
}
</script>

<style>
<?php if($smartphone_flag == 1) { ?>

@media only screen and (min-width: 320px) {
  #checkout .nav li {
    height: 8%; 
	}
}
@media only screen and (min-width: 375px) {
   #checkout .nav li {
    height: 8%; 
	}
}
@media only screen and (min-width: 425px) {
   #checkout .nav li {
    height: 8%; 
	}
}
@media only screen and (min-width: 768px) {
  #checkout .nav li {
    height: 9%; 
	}
}
@media only screen and (min-width: 1024px) {
   #checkout .nav li {
    height: 10%; 
	}
}
@media only screen and (min-width: 1440px) {
   #checkout .nav li {
    height: 10%; 
	}
}

@media only screen and (min-width: 368px){
	#checkout .nav li {
    height: 14%;
	}
}
<?php } ?>
</style>
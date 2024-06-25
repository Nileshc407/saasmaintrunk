<?php
$this->load->view('header/header');
$cart_check = $this->cart->contents();

$ci_object = &get_instance();
$ci_object->load->model('shopping/Shopping_model');
$ci_object->load->model('Igain_model');

$Cust_current_bal = $Enroll_details -> Current_balance;
$Cust_Blocked_points = $Enroll_details -> Blocked_points;
$Debit_points = $Enroll_details -> Debit_points;
$Available_bal=$Cust_current_bal-($Cust_Blocked_points+$Debit_points);
if($Available_bal<0)
{
	$Available_bal=0;
}
else
{
	$Available_bal=$Available_bal;
}

$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];

$delivery_session_data = $this->session->userdata('delivery_session');
$delivery_type=$delivery_session_data['delivery_type'];
$delivery_outlet=$delivery_session_data['delivery_outlet'];
$delivery_outlet_details = $this->Igain_model->get_enrollment_details($delivery_outlet);
$Outlet_name = $delivery_outlet_details->First_name.' '.$delivery_outlet_details->Last_name;
?>
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>
<script src="<?php echo $this->config->item('base_url2')?>assets/shopping2/js/jquery.min.js"></script>
	
<section class="content-header">
	<h1>Checkout - Cart Details</h1>
</section>
	<!-- Main content -->
	<section class="content">
        <div class="row">
			<?php if(empty($cart_check)) { ?>
				<div class="col-md-12">
					<p class="text-muted lead text-center">Your Shopping Cart is Empty. Please click on Continue shopping to Add items to Cart.</p>
					<p class="text-center">
						<a href="<?php echo base_url()?>index.php/Shopping" class="btn btn-template-main">
							<i class="fa fa-chevron-left"></i>&nbsp;Continue shopping
						</a>
					</p>
				</div>
			<?php } ?>
			
			<?php if ($cart = $this->cart->contents()) { $grand_total = 0; $i = 1; $item_count = COUNT($cart); ?>
			
			<div class="col-md-12 clearfix" id="checkout">
				<div class="box">
					 <form method="post" onsubmit="return redeem_check();"  action="<?php echo base_url()?>index.php/Shopping/checkout2">
						<ul class="nav nav-pills nav-justified">
							<li class="active" ><a href="#" style="background-color:#332005; border:none;"><i class="fa fa-shopping-cart"></i> &nbsp; Cart Details</a></li>
						</ul>
						<?php 
							/* print_r($customer_delivery_details);							
							echo"---<br>";
							print_r($delivery_outlet_details);							
							echo"--delivery_address_type--".$delivery_address_type."---<br>";
							echo"--delivery_type--".$delivery_type."---<br>";
							echo"--delivery_outlet--".$delivery_outlet."---<br>";  */
						?>
						<div class="content">
							
							<div class="table-responsive"  style="overflow-x: hidden;">
								<table class="table" style="border: 1px solid #ddd;">
									<thead>
									<tr>
										<th colspan="3">Menu Item</th>
										<th>Condiments</th>
										<th>Quantity</th>
										<th colspan="3">Outlet Name</th>
										<th>Unit Price (<b><?php echo $Symbol_of_currency; ?></b>)</th>
										<th>Condiments Price (<b><?php echo $Symbol_of_currency; ?></b>)</th>
										<th>Total Cost&nbsp;(<?php echo $Symbol_of_currency; ?>)</th>
										<!--<th>Remove</th>-->
									</tr>
								</thead>
								<tbody>
									<?php 
									/* echo"--Shipping_charges_flag--".$Shipping_charges_flag."---<br>";
									echo"--City--".$delivery_outlet_details->City."---<br>"; */
									$Exist_Delivery_method=0;
									$Shipping_cost=0;
									$Weighted_avg_shipping_cost=0;
									$Total_Weighted_avg_shipping_cost[]=0;
									if($Shipping_charges_flag==2) //Delivery_price
									{
										if($delivery_type==0)
										{	
											$Get_shipping_cost = $ci_object->Igain_model->Get_delivery_price_master_citywise($delivery_outlet_details->City);
											$Shipping_cost= $Get_shipping_cost->Delivery_price;
											if($Shipping_cost == "" ){
												$Shipping_cost=0;
											}
											$Total_Weighted_avg_shipping_cost[]=$Shipping_cost;
										}
									}
									
									foreach ($cart as $item) 
									{
										$Product_details = $ci_object->Shopping_model->get_products_details($item['id']);
										
										$Partner_state=$item["options"]["Partner_state"];
										$Partner_Country_id=$item["options"]["Partner_Country_id"];
										
										/* echo"--Shipping_charges_flag--".$Shipping_charges_flag."---<br>";
										echo"--delivery_type--".$delivery_type."---<br>";
										echo "<br><b>Weight_in_KG </b>".$Weight_in_KG."---<br>"; 
										echo "<br><b>Standard_charges </b>".$Standard_charges."---<br>";  */ 
										
										
										if($Shipping_charges_flag==1)//Standard Charges
										{
											if($delivery_type==0)
											{
												$Cost_Threshold_Limit2=round($Cost_Threshold_Limit);
												// echo "<br><b>subtotal </b>".$item['subtotal'];
												// echo "<br><b>Cost_Threshold_Limit2 </b>".$Cost_Threshold_Limit2;
												if($item['subtotal'] >= $Cost_Threshold_Limit2)
												{	
													$Shipping_cost=round($Standard_charges);
													if($Shipping_cost == "" ){
														$Shipping_cost=0;
													}
													// $Weight_in_KG=1.0;
													/* echo "<br><b>Shipping_cost </b>".$Shipping_cost;
													echo "<br><b>Weight_in_KG </b>".$Weight_in_KG;
													echo "<br><b>Single_Item_Weight_in_KG </b>".$Single_Item_Weight_in_KG; */
													$Weighted_avg_shipping_cost=round(($Shipping_cost/$Weight_in_KG)*$Single_Item_Weight_in_KG);
													
													if($Weighted_avg_shipping_cost == 0 || $Weighted_avg_shipping_cost == 'inf'){
														$Weighted_avg_shipping_cost=0;
													}
													
													// echo "<br><b>Weighted_avg_shipping_cost </b>".$Weighted_avg_shipping_cost;
													
													$Total_Weighted_avg_shipping_cost[]=$Weighted_avg_shipping_cost;
												}
												else
												{
													$Shipping_cost=0;
													$Weighted_avg_shipping_cost=0;
													$Total_Weighted_avg_shipping_cost[]=0;
												}
												// echo "<br><b>Standard_charges </b>".$Standard_charges;
											}
										}
										
										
										/* echo"---Weighted_avg_shipping_cost---".$Weighted_avg_shipping_cost."---<br>";
										if($Weighted_avg_shipping_cost =="" ){
											$Weighted_avg_shipping_cost=0;
										} else {
											$Weighted_avg_shipping_cost=$Weighted_avg_shipping_cost;
										} */
										
										$Sub_Total[]=$item["Total_points"];
										$Company_merchandise_item_id = $Product_details->Company_merchandise_item_id;													
										$Item_id = string_encrypt($Company_merchandise_item_id, $key, $iv);	
										$Company_merchandise_item_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Item_id);
										// echo"--Shipping_charges_flag--".$Shipping_charges_flag."---<br>";
									?>
								
										<tr>
											<td>
												<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo urlencode($Company_merchandise_item_id); ?>">
													<img src="<?php echo $Product_details->Thumbnail_image1; ?>" alt="<?php echo $Product_details->Merchandize_item_name; ?>">
													
												</a>
											</td>											
											<td>
												<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo urlencode($Company_merchandise_item_id); ?>">
													<?php
													echo $Product_details->Merchandize_item_name;
													
													if($item["Main_item"] != NULL)
													{
														foreach($item["Main_item"] as $b3){

															if($b3["Merchandize_item_name"] != NULL)
															{
																echo "+".$b3["Merchandize_item_name"];
															}
														}
													}
													?>
												</a>
											</td>
											<td></td>
											<td>
												<?php 
												
											//	print_r($item["options"]['RequiredCondiments']);
												echo $item["options"]["remark2"];
	
												?>
											</td>
											<td align="center"><?php echo $item['qty']; ?> </td>											
											<?php // if($item["options"]['Merchant_flag'] ==1) 
											if($Outlet_name !="") 
											{
												// $get_enrollment = $ci_object->Igain_model->get_enrollment_details($item["options"]['Seller_id']);
												// $merchant_name = $get_enrollment->First_name.' '.$get_enrollment->Last_name;
												$merchant_name = $Outlet_name;
											}
											else
											{
												$merchant_name = "-";
											}
											?>		
											
											<td colspan="3"> 
											<?php
												echo $merchant_name;
											 ?>
											</td>
											<td><?php echo number_format( $item['price'], 2); ?></td>
											<td><?php echo number_format( ($item['MainItem_TotalPrice'] + $item['SideCondiments_TotalPrice']) * $item['qty'], 2); ?></td>
											<td style="width:150px;" id="Item_subtotal_<?php echo $item['rowid']; ?>">
												<?php
												$grand_total = $grand_total + $item['subtotal'];
												echo number_format((float)$item['subtotal'], 2);
												?>
											</td>
											<?php /*
											<!--
											<td>
												<a href="<?php echo base_url()?>index.php/Shopping/remove/?rowid=<?php echo $item['rowid']; ?>">
													<i class="fa fa-trash-o"></i>
												</a>
												<?php
												echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
												echo form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']);
												echo form_hidden('cart[' . $item['id'] . '][name]', $Product_details->Merchandize_item_name);
												echo form_hidden('cart[' . $item['id'] . '][price]', $Product_details->Billing_price);
												?>
											</td>--> */ ?>
										</tr>
									
									<?php }
											// echo "Address_type-----".$customer_delivery_details->Address_type;
										if($delivery_type==0){
											$_SESSION['Address_type']=$customer_delivery_details->Address_type;
										} else {
											$_SESSION['Address_type']="";
										}
										
										$_SESSION['DeliveryType']=$delivery_type;
										$_SESSION['DeliveryOutlet']=$DeliveryOutlet;
										
										$_SESSION['Total_Shipping_Cost']=array_sum($Total_Weighted_avg_shipping_cost);
										$_SESSION['Sub_total']=$grand_total;
										if($grand_total < $DiscountAmt)
										{
											$DiscountAmt = $grand_total;
										}
										
										$_SESSION['DiscountAmt']=$DiscountAmt;
										$_SESSION['Grand_total']=($grand_total+$_SESSION['Total_Shipping_Cost']) - $DiscountAmt;
									?>
								</tbody>
								<tfoot>
									<tr>
										<th colspan="8">&nbsp;</th>
										<th colspan="2">Sub Total</th>
											<td><?php echo $Symbol_of_currency; ?>&nbsp;<?php echo number_format($_SESSION['Sub_total'],2); ?></td>
										<td>&nbsp;</td>
									</tr>
									<?php if($_SESSION['Total_Shipping_Cost']>0) { ?>
									<tr>
										<th colspan="8">&nbsp;</th>
										<th colspan="2">Total Delivery Cost</th>
											<td><?php echo $Symbol_of_currency; ?>&nbsp;<?php echo number_format($_SESSION['Total_Shipping_Cost'],2); ?></td>
										<td>&nbsp;</td>
									</tr>
									<?php } 
									
									if($DiscountAmt > 0) { 
									?>
									<tr>
										<th colspan="8">&nbsp;</th>
										<th colspan="2">Discount</th>
											<td><?php echo $Symbol_of_currency; ?>&nbsp;<?php echo number_format($DiscountAmt,2); ?></td>
										<td>&nbsp;</td>
									</tr>
									<?php } ?>
									<tr>
										<th colspan="8">&nbsp;</th>
										<th colspan="2">Grand Total</th>
										<td>
											
											<?php echo $Symbol_of_currency; ?>&nbsp;<?php echo  number_format($_SESSION['Grand_total'],2); ?> <?php /* ?> ( ~ <?php
													$Equi_Redeem=ceil($_SESSION['Grand_total'] * $Redemptionratio);
													echo floor($Equi_Redeem).' '.$Currency_name; 
													?> ) <?php */ ?>
										</td>
										<td>&nbsp;</td>
									</tr>
										
										<tr><th colspan="5" style="border-top: medium none"></th></tr>
							<?php if($Loyalty_enabled == 1){ ?>			
										<tr> 
											<th colspan="6" > Redeem Points ? </th>
											<th>
											<label class="radio-inline">
											<input type="radio"  name="redeem_by" id="inlineRadio2" value="1" onclick="show_redeem_div(this.value,'1');" <?php if($Cart_redeem_point != 0){ echo 'checked="checked"';} ?>>Yes
											</label>
											
											</th>
											<th>
											<label class="radio-inline">
											<input type="radio" <?php if($Cart_redeem_point == 0){ echo 'checked="checked"';} ?> name="redeem_by" id="inlineRadio3" value="2" onclick="show_redeem_div(this.value,'0');cal_redeem_amt(this.value);" >No
											</label>
											</th>
										
											<th colspan="2"> 
											</th>
											<th colspan="2">
										
											</th>
										</tr>
										
										<tr id="Equivalent" style="display:none;">
											<th colspan="6" > <?php echo $Currency_name; ?> Balance : <?php echo $Available_bal; ?></th>
											
											<th colspan="2"> <label id="redeem_label" style="display:none;">&nbsp;<?php echo $Currency_name; ?> Redeem </label> 
											</th>
											<th>
											<input type="text" id="point_redeem" name="point_redeem" size="6" style="display:none;"  onblur="cal_redeem_amt(1);" 
											onkeyup="this.value=this.value.replace(/\D/g,'')"> 
											</th>
											<th>Equivalent &nbsp; (<?php echo $Symbol_of_currency; ?>)</th>
											<th>
												<input type='text' style="border:none;" name='redeem_amt' id='redeem_amt' value="0" size='6' readOnly> 
											</th>
										</tr>
								<?php } ?>		
										<tr> 
											<th colspan="6"> Use Voucher </th>
											<th>
											<label class="radio-inline">
											<input type="radio"  name="redeem_by_voucher" id="inlineRadio4" value="1" onclick="show_voucher_div(this.value);" >Yes
											</label>
											</th>
											<th>
											<label class="radio-inline">
											<input type="radio" name="redeem_by_voucher" checked id="inlineRadio5" value="2" onclick="show_voucher_div(this.value);" >No
											</label>
											</th>
										
											<th colspan="2" style="justify-content:flex-end; ">
											
											</th>
											<th colspan="2">
											
											</th>
										</tr>
										
										<tr>
										<th colspan="6">
										</th>
										<th colspan="2" style="justify-content:flex-end; ">
											<span id="voucher_label" style="display:none;">
											 <a href="#" onclick="javascript:getDiscountVouchers()" data-toggle="tooltip" data-placement="top" title="view my vouchers">Select<i class="fa fa-ticket" aria-hidden="true"></i></a>
											</span>
											</th>
											<th colspan="2">
											<span class="voucher_label2" style="display:none;">
											<input type="text" id="redeem_voucher" name="redeem_voucher" size="10"   onblur="get_voucher_amt(this.value);" placeholder="Enter Voucher"
											><br>
											</span>
											</th>
											<th colspan="2">
											<span class="voucher_label2" style="display:none;">
											<?php echo $Symbol_of_currency; ?>
											<input type="text" id="redeem_voucher_amt" name="redeem_voucher_amt" size="6"  style="border:none;" placeholder="Balance" readonly > 
											</span>
											</th>
										</tr>
										<tr>
											
											<th colspan="8" ></th>
											<th colspan="2" >Total &nbsp; (<?php echo $Symbol_of_currency; ?>)</th>
											<th>
												<b><?php //echo $Symbol_of_currency; ?></b><?php //echo number_format($grand_total, 2); ?>
												<input style="border:none;" type='text' id='total_bill_amount' name='total_bill_amount' size='6' readOnly>
											</th>											
										</tr>
									
									</tfoot>
								</table>
							</div>
						</div>	
						<hr>
						<div class="box-footer" style="padding:0px;margin-top:10px;background: #fff;border-top:none">
							<div class="row" >
								<div class="col-md-6 col-xs-6">
									<a href="<?php echo base_url()?>index.php/Shopping/view_cart" class="btn btn-default">
										<i class="fa fa-backward" aria-hidden="true"></i>&nbsp; View Cart
									</a>
								</div>
								<div class="col-md-6 col-xs-6" align="right">
									<!--<input type="submit" class="btn btn-template-main" id="Payment" value="Payment Method" >
									<i class="fa fa-forward" aria-hidden="true"></i>-->
									<button type="submit" class="btn btn-template-main" id="Payment" >
										Payment &nbsp;<i class="fa fa-forward" aria-hidden="true"></i>
									</button>
								</div>
							</div>
						</div><br>
						<input type="hidden" name="address_flag" value="<?php echo $delivery_address_type; ?>">
						<input type="hidden" name="hidden_Equi_Redeem" value="<?php echo $Equi_Redeem; ?>">
						<!--<input type="text" name="Address_type" value="<?php echo $customer_delivery_details->Address_type; ?>">
						<input type="text" name="DeliveryType" value="<?php echo $delivery_type; ?>">
						<input type="text" name="DeliveryOutlet" value="<?php echo $delivery_outlet; ?>">-->
					</form>
				</div>
			</div>
			<?php } ?>
		</div>
		
<!-- Modal -->
	<div id="vouchers_modal" class="modal fade" role="dialog" style="overflow:auto;">
		<div class="modal-dialog" style="width: 70%;" id="Show_vouchers">
			<div class="modal-content" >
				<div class="modal-header">
				  <h4 class="modal-title"><b>Discount Vouchers</b></h4>
				</div>
				<div class="modal-body">
					<div class="table-responsive" id="Show_item_info">
						<div class="table-responsive">
							<table class="table table-hover">
								<thead>
									<tr>
										<th> select</th><th> Voucher Number </th><th>Value (in <?php echo $Symbol_of_currency; ?>)</th><th> Valid Till </th>
									</tr>
								</thead>
								<tbody>
								<?php if(count($DiscountVouchers) > 0){
										foreach($DiscountVouchers as $v){
								?>
									<tr>
										<th><input type='radio' name='radio_voucher' onclick='setVoucher("<?php echo $v['Gift_card_id']; ?>","<?php echo $v['Card_balance']; ?>")'></th>
										<?php 
										
										echo "<th>".$v['Gift_card_id']."</th><th>".$v['Card_balance']."</th><th>".$v['Valid_till']."</th>";
										?>
									</tr>
								<?php }
								} ?>	
								</tbody>
							</table>	
						</div>
					</div>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn btn-primary" aria-label="Close" id="close_modal2" align="center" >Close&nbsp;<i class="fa fa-forward" aria-hidden="true"></i></button>
				</div>

			</div>
		</div>
	</div>
<!-- Modal -->	

	</section>
<!--*************************************-->	
<script type="text/javascript">

/* 
$('.close').click({
	$('#Show_vouchers').hide();	
});

 */
function getDiscountVouchers()
{
	//alert("called me");
	$('#vouchers_modal').show();	
	$("#vouchers_modal").addClass("in");	
}

$("#close_modal").click(function(e)
{
	$('#vouchers_modal').hide();
	$("#vouchers_modal").removeClass( "in" );
});

$("#close_modal2").click(function(e)
{
	$('#vouchers_modal').hide();
	$("#vouchers_modal").removeClass( "in" );
});

function setVoucher(Gift_card_id,Card_balance)
{
//	alert(Gift_card_id+"---"+Card_balance)
	var purchase_amt = '<?php echo $_SESSION['Grand_total']; ?>';
	var redeem_amt = $("#redeem_amt").val();
	var TotalGrand = parseInt(Card_balance) + parseInt(redeem_amt);
	if(TotalGrand > purchase_amt)
	{
		$("#redeem_voucher").removeAttr("required");
		$("#voucher_label").hide();
		$(".voucher_label2").hide();
		$("#point_redeem").removeAttr("readonly");
		$("#redeem_voucher").val(0);
		$("#redeem_voucher_amt").val("");
		$("#Payment").attr("disabled", false);
		
		var Title = "Application Information";
		var msg = 'Total purchase amount is less than voucher value, please try other voucher';
		runjs(Title,msg);
		
		return false;
	}
//	alert(parseInt(purchase_amt)+"--"+redeem_amt+"--"+ parseInt(TotalGrand));
	var new_purchase_amt = parseInt(purchase_amt) - parseInt(TotalGrand);
	
	if(new_purchase_amt < 0){
		new_purchase_amt = 0;
	}
	

	
	$("#redeem_voucher").val(Gift_card_id);
	$("#redeem_voucher_amt").val(Card_balance);
	$("#redeem_voucher_amt").attr("readonly",'true');
	$("#total_bill_amount").val(new_purchase_amt.toFixed(2));
	$("#close_modal2").text("Applay");
	$("#Payment").attr("disabled", false);
}

$(function () 
{	
	var Cart_redeem_point = '<?php echo $Cart_redeem_point; ?>';
	var ratio_value2 = '<?php echo $Redemptionratio;?>';
	var grand_total2 = '<?php echo $_SESSION['Grand_total']; ?>';
	var Redeem_amount = '<?php echo $_SESSION['Redeem_amount']; ?>';
	
	if(Cart_redeem_point != 0)
	{
		$("#redeem_label").show();
		$("#point_redeem").show();
		$("#Equivalent").show();
		$("#point_redeem").val(Cart_redeem_point);

		// var EquiRedeem2 = (Cart_redeem_point/ratio_value2).toFixed(2);
		var EquiRedeem2 = Redeem_amount;
		$("#redeem_amt").val(EquiRedeem2);

		var Total_bill2 = (grand_total2 - EquiRedeem2).toFixed(2);
		if(Total_bill2 < 0)
		{
			//$("#redeem_by").show();
			document.getElementById("inlineRadio3").checked = true;
			show_redeem_div(2,0);
			
			$("#redeem_amt").val(0);

			Total_bill2 = grand_total2;
			
		}
		$("#total_bill_amount").val(Total_bill2);
	}
	else
	{
		$("#total_bill_amount").val(grand_total2);
	}
});

function cal_redeem_amt(redeemBY)
{
	var bal = '<?php echo $Available_bal; ?>';
	var Currency_name = '<?php echo $Currency_name; ?>';
	var purchase_amt = '<?php echo $_SESSION['Grand_total']; ?>';
	var ratio_value = '<?php echo $Redemptionratio;?>';
	var reedem = $("#point_redeem").val();
	var grand_total = '<?php echo $_SESSION['Grand_total']; ?>';
	
	/* alert('bal : '+bal);
	 alert('reedem : '+reedem);
	alert('purchase_amt'+purchase_amt);
	alert('ratio_value'+ratio_value);
	alert('grand_total'+grand_total);
	alert('reedem'+reedem); */
	
	var bal1 = parseInt(bal);
	var reedem1 = parseInt(reedem);
	
	if(bal1 < reedem1)
	{
		var Title = "Application Information";
		var msg = 'Insufficient '+Currency_name+' Balance';
		runjs(Title,msg);
		
		$('#redeem_amt').val(0);
		$('#point_redeem').val(0);
		$('#total_bill_amount').val(grand_total.toFixed(2));
		$("#Payment").attr("disabled", true);
		return false;
	}
	else
	{
		$.ajax(
			{
				type:"POST",
				data:{Current_balance:bal,grand_total:grand_total,Redeem_points:reedem,ratio_value:ratio_value, redeemBY:redeemBY},
				url: "<?php echo base_url()?>index.php/Shopping/cal_redeem_amt_contrl/",
				//datatype:"json",
				success: function(data)
				{
					if(data.Error_flag == 0)
					{
						let redeem_voucher_amt = $("#redeem_voucher_amt").val();
						$('#redeem_amt').val(data.EquiRedeem);
						let totalGrand = (data.Grand_total - redeem_voucher_amt).toFixed(2);
						if(totalGrand < 0){
							totalGrand = 0;
						}
						$('#total_bill_amount').val(totalGrand);
						$("#Payment").attr("disabled", false);
					}
					if(data.Error_flag == 1)
					{
						var Title = "Application Information";
						var msg = 'Equivalent Redeem Amount is More than Total Bill Amount';
						runjs(Title,msg);
						
						$('#redeem_amt').val(0);
						$('#point_redeem').val(0);
						$('#total_bill_amount').val(grand_total.toFixed(2));
						$("#Payment").attr("disabled", true);
						return false;
						
					}
					if(data.Error_flag == 2)
					{
						var Title = "Application Information";
						var msg = 'Insufficient '+Currency_name+' Balance';
						runjs(Title,msg);
						
						$('#redeem_amt').val(0);
						$('#point_redeem').val(0);
						$('#total_bill_amount').val(grand_total.toFixed(2));
						$("#Payment").attr("disabled", true);
						return false;
					}

					if(data.Error_flag == 3)
					{
						$('#redeem_amt').val(0);
						$('#point_redeem').val(0);
						$('#total_bill_amount').val(grand_total.toFixed(2));
						$("#Payment").attr("disabled", false);
					}							
				}
		});
	}
}

function show_redeem_div(redeem_flag,div_flag)
{
	var purchase_amt = '<?php echo $_SESSION['Grand_total']; ?>';
	
	if(div_flag==1 && redeem_flag == 1)
	{
		$("#point_redeem").attr("required","required");
		$("#redeem_label").show();
		$("#point_redeem").show(); 
		$("#Equivalent").show(); 
		$("#Payment").attr("disabled", true);
	}
	else if(div_flag==0 && redeem_flag == 2)
	{
		$("#point_redeem").removeAttr("required");
		$("#redeem_label").hide();
		$("#point_redeem").hide();
		$("#Equivalent").hide();
		$("#point_redeem").val(0);
		$("#total_bill_amount").val(parseFloat(purchase_amt).toFixed(2));
		$("#Payment").attr("disabled", false);
		
	}
}	
//******** discount voucher ******************
function show_voucher_div(voucherFlag)
{
	
	var purchase_amt = '<?php echo $_SESSION['Grand_total']; ?>';
	let redeem_voucher_amt = $("#redeem_amt").val();
	//alert(redeem_voucher_amt);
	if(redeem_voucher_amt > 0)
	{
		var purchase_amt = parseInt(purchase_amt) - parseInt(redeem_voucher_amt);
		
		if(purchase_amt < 0)
		{
			purchase_amt = 0;
		}
	}
	
	if(voucherFlag == 1)
	{
		$("#redeem_voucher").attr("required","required");
		$("#voucher_label").show();
		$(".voucher_label2").show();
		$("#point_redeem").attr("readonly","true");
		$("#Payment").attr("disabled", true);
	}
	else if(voucherFlag == 2)
	{
		$("#redeem_voucher").removeAttr("required");
		$("#voucher_label").hide();
		$(".voucher_label2").hide();
		$("#point_redeem").removeAttr("readonly");
		$("#redeem_voucher").val(0);
		$("#redeem_voucher_amt").val("");
		$("#total_bill_amount").val(parseFloat(purchase_amt).toFixed(2));
		$("#Payment").attr("disabled", false);
	}
}

function get_voucher_amt(GiftCard)
{
	var purchase_amt = $("#total_bill_amount").val();
	if(GiftCard != "")
	{
	$.ajax({
		type:"POST",
		data:{GiftCardId:GiftCard,Grand_total:purchase_amt},
		url:"<?php echo base_url()?>index.php/Shopping/get_gift_voucher_amt/",
		success:function(opt){
		
				if(opt == 0)
				{
					$("#redeem_voucher").val("");
					var Title = "Application Information";
					var msg = 'Invalid Voucher Or Voucher Amount is More than Total Bill Amount';
					runjs(Title,msg);
					return false;
				}
				
				if(opt > 0)
				{
					var new_purchase_amt = (parseInt(purchase_amt) - parseInt(opt)).toFixed(2);
					$("#redeem_voucher_amt").val(opt);
					$("#total_bill_amount").val(new_purchase_amt);
					$("#Payment").attr("disabled", false);
				}
				
			}
		});
	}
}
//******** discount voucher ******************
//$('#Payment').click (function()
function redeem_check()
{ 
		// var radio_val = $("input[type=radio]:checked").val();
		 
		// if($('#inlineRadio2').is(':checked', false))
		// if($('#inlineRadio2').is(':checked'))
		
		// alert(document.getElementById("inlineRadio3").checked);
		/*if(document.getElementById("inlineRadio3").checked == true)
		{
			return true; 
		}*/
	
	if($('#inlineRadio2').prop('checked'))
	{
		var point_redeem = $('#point_redeem').val();
		
		if(point_redeem == 0)
		{
			var Title = "Application Information";
			var msg = 'Please redeem points greater than 0';
			runjs(Title,msg);
			
			return false;
		}	
	}
	else
	{
		return true;
	}
}
</script>
<?php $this->load->view('header/footer');?>
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
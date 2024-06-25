<?php
$this->load->view('header/header');
$cart_check = $this->cart->contents();

$ci_object = &get_instance();
$ci_object->load->model('shopping/Shopping_model');

  //var_dump($Enroll_details);
 // var_dump($Company_Redemptionratio); 
 
  $Redemptionratio = $Company_Redemptionratio;
 
$Cust_current_bal = $Enroll_details -> Current_balance;
$Cust_Blocked_points = $Enroll_details -> Blocked_points;
 
?>

	<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>
	<script src="<?php echo $this->config->item('base_url2')?>assets/shopping2/js/jquery.min.js"></script>
	<section class="content-header">
		<h1>Checkout</h1>
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
				
					<?php /* <form method="post" action="<?php echo base_url()?>index.php/Shopping/place_order"> */ ?>

						<ul class="nav nav-pills nav-justified">
							<li><a href="<?php echo base_url()?>index.php/Shopping/checkout"><i class="fa fa-map-marker"></i><br>Your Details</a></li>
							<li class="active"><a href="#"><i class="fa fa-shopping-cart"></i><br>Cart Details</a></li>
							<li class="disabled"><a href="#"><i class="fa fa-money"></i><br>Payment Method</a></li>							
							<li class="disabled"><a href="#"><i class="fa fa-eye"></i><br>Review Order</a></li>
							<li class="disabled"><a href="#"><i class="fa fa-check"></i><br>Order Confirmed</a></li>
						</ul>

						<div class="content">
							
							<div class="table-responsive">
								<table class="table" style="border: 1px solid #ddd;">
									<thead>
										<tr>
											<th colspan="2">Product</th>
											<th>Quantity</th>
											<th>Unit price</th>
											<th>Sub-Total</th>
										</tr>
									</thead>
									
									<tbody>
									
										<?php 
										$order_sub_total = 0; $shipping_cost = 99; $tax = 0;
										foreach ($cart as $item) 
										{									
											$Product_details = $ci_object->Shopping_model->get_products_details($item['id']);
											?>
									
											<tr>
												<td>
													<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $Product_details->Company_merchandise_item_id; ?>">
														<img src="<?php echo $Product_details->Thumbnail_image1; ?>" alt="<?php echo $Product_details->Merchandize_item_name; ?>">
													</a>
												</td>
												
												<td>
													<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $Product_details->Company_merchandise_item_id; ?>"><?php echo $Product_details->Merchandize_item_name; ?></a>
												</td>
												
												<td><?php echo $item['qty']; ?></td>
												
												<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo number_format($Product_details->Billing_price, 2); ?></td>
												
												<td>
													<?php
													$grand_total = $grand_total + $item['subtotal'];
													echo "<b>".$Symbol_of_currency."</b> ".number_format($item['subtotal'], 2);
													?>
												</td>
											</tr>
										
										<?php } ?>
										
									</tbody>
									<tfoot>
										<tr><th colspan="5" style="border-top: medium none"></th></tr>
										<tr><th colspan="5" style="border-top: medium none"></th></tr>
										<tr><th colspan="5" style="border-top:  medium none;"></th></tr>
										<tr>
											<th colspan="3" style="border-top: 1px solid #ddd;"></th>
											<th style="border-top: 1px solid #ddd;">Sub Total</th>
											<th style="border-top: 1px solid #ddd;">
												<b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo number_format($grand_total, 2); ?>
											</th>
										</tr>
										
										<tr><th colspan="5" style="border-top: medium none"></th></tr>
										
										<tr> 
											<th colspan="2"  style="border-top: 1px solid #ddd;"> Wish to redeem </th>
											<th  style="border-top: 1px solid #ddd;">
											<label class="radio-inline">
											<input type="radio"  name="redeem_by" id="inlineRadio2" value="1" onclick="show_redeem_div(this.value,'1');" <?php if($Cart_redeem_point != 0){ echo 'checked="checked"';} ?>>Yes
											</label>
											<label class="radio-inline">
											<input type="radio" <?php if($Cart_redeem_point == 0){ echo 'checked="checked"';} ?> name="redeem_by" id="inlineRadio3" value="0" onclick="show_redeem_div(this.value,'0');cal_redeem_amt(this.value);" >No
											</th>
										
											<th style="border-top: 1px solid #ddd;"> <label id="redeem_label" style="display:none;"> Point Redeem </label> </th>
											<th style="border-top: 1px solid #ddd;">
											
											<input type="text" id="point_redeem" name="point_redeem" size="6" style="display:none;" required onblur="cal_redeem_amt(1);" 
											onkeyup="this.value=this.value.replace(/\D/g,'')"> </th>
										
										</tr>
										
										<tr id="Equivalent" style="display:none;">
											<th colspan="3" style="border-top: 1px solid #ddd;"></th>
											<th style="border-top: 1px solid #ddd;">Equivalent</th>
											<th style="border-top: 1px solid #ddd;">
												<input type='text' name='redeem_amt' id='redeem_amt' value="0" size='6' readOnly> 
											</th>
										</tr>
										<tr>
											<th colspan="3" style="border-top: 1px solid #ddd;"></th>
											<th style="border-top: 1px solid #ddd;">Total</th>
											<th style="border-top: 1px solid #ddd;">
												<b><?php //echo $Symbol_of_currency; ?></b><?php //echo number_format($grand_total, 2); ?>
												<input type='text' id='total_bill_amount' name='total_bill_amount' size='6' readOnly>
											</th>
										</tr>
									</tfoot>
								</table>

							</div>
							
						</div>

						<div class="box-footer">
							<div class="pull-left">
								<a href="<?php echo base_url()?>index.php/Shopping/checkout" class="btn btn-default">
									<i class="fa fa-chevron-left"></i>&nbsp;Back to Your Details
								</a>
							</div>
							<div class="pull-right">
								<a href="<?php echo base_url()?>index.php/Shopping/checkout2" class="btn btn-template-main">
									Continue to Payment Method&nbsp;<i class="fa fa-chevron-right"></i>
								</a>
							</div>
						</div>
						
					<!--</form>-->
					
				</div>
			
			</div>
			
			<?php /* <div class="col-md-3">
			
				<div class="box" id="order-summary">
					<div class="box-header">
						<h3>Order summary</h3>
					</div>
					<p class="text-muted">Shipping and additional costs are calculated based on the values you have entered.</p>

					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<td>Order subtotal</td>
									<th>$<?php echo number_format($order_sub_total, 2); ?></th>
								</tr>
								<tr>
									<td>Shipping and handling</td>
									<th>$<?php echo number_format($shipping_cost, 2); ?></th>
								</tr>
								<tr>
									<td>Tax</td>
									<th>$<?php echo number_format($tax, 2); ?></th>
								</tr>
								<tr class="total">
									<td>Total</td>
									<th>
										$<?php echo number_format($order_total, 2); ?>
									</th>
								</tr>
							</tbody>
						</table>
					</div>

				</div>

			</div> */ ?>
			
			<?php } ?>
			
		</div>
	</section>
<!--*************************************-->	
		
<script type="text/javascript">
$(function () 
{
	var Cart_redeem_point = '<?php echo $Cart_redeem_point; ?>';
	var ratio_value2 = '<?php echo $Redemptionratio;?>';
	var grand_total2 = '<?php echo $grand_total; ?>';
	if(Cart_redeem_point != 0)
	{
		$("#redeem_label").show();
		$("#point_redeem").show();
		$("#Equivalent").show();
		$("#point_redeem").val(Cart_redeem_point);
		
		var EquiRedeem2 = (Cart_redeem_point/ratio_value2).toFixed(2);
		$("#redeem_amt").val(EquiRedeem2);
		
		var Total_bill2 = (grand_total2 - EquiRedeem2);
		$("#total_bill_amount").val(Total_bill2);
	}
	else
	{
		$("#total_bill_amount").val(grand_total2);
	}
});

	function cal_redeem_amt(redeemBY)
	{		
		
		 var bal = '<?php echo $Cust_current_bal - $Cust_Blocked_points; ?>';
		 var purchase_amt = '<?php echo $grand_total; ?>';
		 var ratio_value = '<?php echo $Redemptionratio;?>';
	     var reedem = $("#point_redeem").val();
		 var grand_total = '<?php echo $grand_total; ?>';
		 
		 // alert('redeemBY '+redeemBY);
		 // alert('bal '+bal);
		 // alert('purchase_amt '+purchase_amt);
		 // alert('reedem '+reedem);
		 // alert('ratio_value '+ratio_value);
		
		
		
		$.ajax({
					type:"POST",
					data:{Current_balance:bal,grand_total:grand_total,Redeem_points:reedem,ratio_value:ratio_value, redeemBY:redeemBY},
					 url: "<?php echo base_url()?>index.php/Express_checkout/cal_redeem_amt_contrl/",
					 //datatype:"json",
					 success: function(data)
					{
					
						//console.log(data.Error_flag);
						
						if(data.Error_flag == 0)
						{
							// alert("sdfsdf");
							$('#redeem_amt').val(data.EquiRedeem);
							$('#total_bill_amount').val(data.Grand_total);
						}
						if(data.Error_flag == 1)
						{
						   alert("Equivalent Redeem Amount is More than Total Bill Amount");
						   $('#redeem_amt').val(0);
						   $('#point_redeem').val(0);
						   $('#total_bill_amount').val(grand_total);
						}
						if(data.Error_flag == 2)
						{
						  alert("Insufficient Point Balance !!! ");
						   $('#redeem_amt').val(0);
						   $('#point_redeem').val(0);
						   $('#total_bill_amount').val(grand_total);
						}
						
						if(data.Error_flag == 3)
						{
						   $('#redeem_amt').val(0);
						   $('#point_redeem').val(0);
						   $('#total_bill_amount').val(grand_total);
						}
							/* json = eval("(" + data + ")");
							if(data !== "")
							{
								$('#redeem_amt').val(json[0].Redeem_amount);
								 $('#balance_to_pay').val(purchase_amt - (json[0].Redeem_amount));
								
								if(json[0].Error_flag == 4)
								{
								  $('#reedem').val("0");
								  $('#balance_to_pay').val(purchase_amt);
								  $('#redeem_amt').val("0");
								  alert("Equivalent Redeem Amount is More than Total Bill Amount");
								}
								else if(json[0].Error_flag == 3)
								{
								 $('#reedem').val("0");
								  $('#balance_to_pay').val(purchase_amt);
								  $('#redeem_amt').val("0");
								  alert("Insufficient Point Balance !!! ");
								  
								}
								else if(json[0].Error_flag == 2)
								{
								  alert("Invalid Company Key");
								}
							}
							else
							{
								$('#redeem_amt').val("");
								$('#balance_to_pay').val("");
							} */
							
					}
				});
		
		/*var EquiRedeem = (reedem/ratio_value).toFixed(2);
		document.getElementById("redeem_amt").value = EquiRedeem;
		
		if(EquiRedeem > parseInt(purchase_amt))
		{
			alert('Equivalent Amount is more than purchase amount');
		   
			document.getElementById("point_redeem").value = '';
			document.getElementById("redeem_amt").value = '';
			document.getElementById("total_bill_amount").value = grand_total;
		}
		else
		{
			if(redeemBY == 1 && parseInt(reedem) >= parseInt(bal))
			{
				alert('Insufficient Current Points Balance.');
				document.getElementById("point_redeem").value = '';
				document.getElementById("total_bill_amount").value = grand_total;
			}
			else
			{
				var Total_bill = (grand_total - EquiRedeem);
				document.getElementById("total_bill_amount").value = Total_bill;
			}
		}*/
	
	}
</script>

<script>
	function show_redeem_div(redeem_flag,div_flag)
	{
		if(div_flag==1 && redeem_flag == 1)
		{
			$("#point_redeem").attr("required","required");
			$("#redeem_label").show();
			$("#point_redeem").show(); 
			$("#Equivalent").show(); 
		}
		else if(div_flag==0 && redeem_flag == 0)
		{
			$("#point_redeem").removeAttr("required");
			$("#redeem_label").hide();
			$("#point_redeem").hide();
			$("#Equivalent").hide();
		}
	}
</script>
<!--***************************************************--->
<?php $this->load->view('header/footer');?>
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
							
							<li class="active"><a href="#"><i class="fa fa-shopping-cart"></i> &nbsp; Cart Details</a></li>
							
							
						</ul>

						<div class="content">
							
							<div class="table-responsive">
								<table class="table" style="border: 1px solid #ddd;">
									<thead>
									<tr>
										<th colspan="3">Product</th>
										<th>Quantity</th>
										<th>Merchant Name</th>
										<th>Size</th>
										<th>Total Cost&nbsp;(<?php echo $Symbol_of_currency; ?>)</th>
										<th>Shipping Cost&nbsp;(<?php echo $Symbol_of_currency; ?>)</th>
										<th>Remove</th>
									</tr>
								</thead>
								
								<tbody>
								
									<?php 
									
									$Exist_Delivery_method=0;
									foreach ($cart as $item) 
									{
										$Product_details = $ci_object->Shopping_model->get_products_details($item['id']);
										
										$Partner_state=$item["options"]["Partner_state"];
										$Partner_Country_id=$item["options"]["Partner_Country_id"];
										
										if($item["options"]["Redemption_method"]==29)
										{
											$Exist_Delivery_method=1;
											$Weight_in_KG=0;
											$Weight=0;
											foreach($cart as $rec) 
											{
												
												if(($rec["options"]["Partner_state"]==$Partner_state) && ($rec["options"]["Redemption_method"]==29))
												{
													
													
													$Total_weight_same_location=($rec["options"]["Item_Weight"]*$rec["qty"]);
												
													$lv_Weight_unit_id=$rec["options"]["Weight_unit_id"];
													$kg=1;
													switch ($lv_Weight_unit_id)
													{
														case 2://gram
														$kg=0.001;break;
														case 3://pound
														$kg=0.45359237;break;
													}
													
													$Weight_in_KG=($Total_weight_same_location*$kg)+$Weight_in_KG;
													  
												}
												
												
											}
											
											/*******Single Weight convert into KG****/

											$kg2=1;
											switch ($item["options"]["Weight_unit_id"])
											{
												case 2://gram
												$kg2=0.001;break;
												case 3://pound
												$kg2=0.45359237;break;
											}
											
											/**************************/
											
											
											$Single_Item_Weight_in_KG=($item["options"]["Item_Weight"]*$item["qty"]*$kg2);
											
											
										}
										else
										{
											$Total_Weighted_avg_shipping_cost[]=0;
											$Weighted_avg_shipping_cost="-";
										}

										if($Shipping_charges_flag==2)//Delivery_price
										{
											if($item["options"]["Redemption_method"]==29)
											{
												$Get_shipping_cost = $ci_object->Igain_model->Get_delivery_price_master($Partner_Country_id,$Partner_state,$To_Country,$To_State,$Weight_in_KG,1);
												$Shipping_cost= $Get_shipping_cost->Delivery_price;
												$Weighted_avg_shipping_cost=(($Shipping_cost/$Weight_in_KG)*$Single_Item_Weight_in_KG);
												$Weighted_avg_shipping_cost=number_format((float)$Weighted_avg_shipping_cost, 2);
												$Total_Weighted_avg_shipping_cost[]=$Weighted_avg_shipping_cost;
											
											}
										}
										elseif($Shipping_charges_flag==1)//Standard Charges
										{
											if($item["options"]["Redemption_method"]==29)
											{
												$Cost_Threshold_Limit2=round($Cost_Threshold_Limit);
												if($item['subtotal'] >= $Cost_Threshold_Limit2)
												{	
													$Shipping_cost=round($Standard_charges);
													$Weighted_avg_shipping_cost=round(($Shipping_cost/$Weight_in_KG)*$Single_Item_Weight_in_KG);
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
										else
										{
											$Shipping_cost=0;
											$Weighted_avg_shipping_cost=0;
											$Total_Weighted_avg_shipping_cost[]=0;
										}
										
										
										$Sub_Total[]=$item["Total_points"];
										$Company_merchandise_item_id = $Product_details->Company_merchandise_item_id;													
										$Item_id = string_encrypt($Company_merchandise_item_id, $key, $iv);	
										$Company_merchandise_item_id = preg_replace("/[^(\x20-\x7f)]*/s", "", $Item_id);
										
										?>
								
								
										<tr>
											<td>
												<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo urlencode($Company_merchandise_item_id); ?>">
													<img src="<?php echo $Product_details->Thumbnail_image1; ?>" alt="<?php echo $Product_details->Merchandize_item_name; ?>">
												</a>
											</td>											
											<td colspan="2">
												<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo urlencode($Company_merchandise_item_id); ?>"><?php echo $Product_details->Merchandize_item_name; ?></a>
											</td>											
											<td align="center"><?php echo $item['qty']; ?> </td>											
											<?php if($item['Merchant_flag'] ==1) 
											{
											$get_enrollment = $ci_object->Igain_model->get_enrollment_details($item['Seller_id']);
											$merchant_name = $get_enrollment->First_name.' '.$get_enrollment->Last_name;
											}
											else
											{
											$merchant_name = "-";
											}
											?>						
											<td> 
											<?php
												echo $merchant_name;
											 ?>
											</td>
											<td>
												<?php 
													if($item['options']['Item_size'] == 1)
													{
													  $size = "Small";
													}
													elseif($item['options']['Item_size'] == 2)
													{	
														$size = "Medium";
													}
													elseif($item['options']['Item_size'] == 3)
													{
														$size = "Large";
													}
													elseif($item['options']['Item_size'] == 4)
													{
														$size = "Extra Large";
													}
													else
													{
														$size = "-";
													}
													echo $size;
												?>
											</td>
											
											<td id="Item_subtotal_<?php echo $item['rowid']; ?>">
												<?php
												$grand_total = $grand_total + $item['subtotal'];
												echo number_format((float)$item['subtotal'], 2);
												?>
											</td>
												
											<td><?php echo number_format($Weighted_avg_shipping_cost,2);?></td>
											
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
											</td>
										</tr>
									
									<?php }
										$_SESSION['Total_Shipping_Cost']=array_sum($Total_Weighted_avg_shipping_cost);
										$_SESSION['Sub_total']=$grand_total;
										$_SESSION['Grand_total']=($grand_total+$_SESSION['Total_Shipping_Cost']);

									?>
									
								</tbody>
								<tfoot>
									<tr>
										<th colspan="5">&nbsp;</th>
										<th colspan="3">Sub Total</th>
											<td><?php echo $Symbol_of_currency; ?>&nbsp;<?php echo number_format($_SESSION['Sub_total'],2); ?></td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<th colspan="5">&nbsp;</th>
										<th colspan="3">Total Shipping Cost</th>
											<td><?php echo $Symbol_of_currency; ?>&nbsp;<?php echo number_format($_SESSION['Total_Shipping_Cost'],2); ?></td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<th colspan="5">&nbsp;</th>
										<th colspan="3">Grand Total</th>
											<td><?php echo $Symbol_of_currency; ?>&nbsp;<?php echo  number_format($_SESSION['Grand_total'],2); ?></td>
										<td>&nbsp;</td>
									</tr>
										
										<tr><th colspan="5" style="border-top: medium none"></th></tr>
										
										<tr> 
											<th colspan="5" > Wish to redeem </th>
											<th colspan="2" >
											<label class="radio-inline">
											<input type="radio"  name="redeem_by" id="inlineRadio2" value="1" onclick="show_redeem_div(this.value,'1');" <?php if($Cart_redeem_point != 0){ echo 'checked="checked"';} ?>>Yes
											</label>
											<label class="radio-inline"> 
											<input type="radio" <?php if($Cart_redeem_point == 0){ echo 'checked="checked"';} ?> name="redeem_by" id="inlineRadio3" value="0" onclick="show_redeem_div(this.value,'0');cal_redeem_amt(this.value);" >No
											</label>
											</th>
										
											<th> <label id="redeem_label" style="display:none;">&nbsp;Points Redeem </label> 
											</th>
											<th>
											<input type="text" id="point_redeem" name="point_redeem" size="6" style="display:none;"  onblur="cal_redeem_amt(1);" 
											onkeyup="this.value=this.value.replace(/\D/g,'')"> 
											</th>
										</tr>
										
										<tr id="Equivalent" style="display:none;">
											<th colspan="5" >Current Point Balance : <?php echo $Available_bal; ?></th>
											<th  colspan="3">Equivalent &nbsp; (<?php echo $Symbol_of_currency; ?>)</th>
											<th>
												<input type='text' name='redeem_amt' id='redeem_amt' value="0" size='6' readOnly> 
											</th>
										</tr>
										<tr>
											<th colspan="5" ></th>
											<th colspan="3" >Total &nbsp; (<?php echo $Symbol_of_currency; ?>)</th>
											<th>
												<b><?php //echo $Symbol_of_currency; ?></b><?php //echo number_format($grand_total, 2); ?>
												
												<input type='text' id='total_bill_amount' name='total_bill_amount' size='6' readOnly>
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
									
									
									<a href="<?php echo base_url()?>index.php/Shopping/checkout" class="btn btn-default">
										<i class="fa fa-backward" aria-hidden="true"></i>&nbsp; Your Details
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
							
						</div>
						
					</form>
					
				</div>
			
			</div>
			
			<?php } ?>
			
		</div>
	</section>
<!--*************************************-->	
		
<script type="text/javascript">

    $(function () 
    {	
        var Cart_redeem_point = '<?php echo $Cart_redeem_point; ?>';
        var ratio_value2 = '<?php echo $Redemptionratio;?>';
        var grand_total2 = '<?php echo $_SESSION['Grand_total']; ?>';
	
        if(Cart_redeem_point != 0)
        {
            $("#redeem_label").show();
            $("#point_redeem").show();
            $("#Equivalent").show();
            $("#point_redeem").val(Cart_redeem_point);

            var EquiRedeem2 = (Cart_redeem_point/ratio_value2).toFixed(2);
            $("#redeem_amt").val(EquiRedeem2);

            var Total_bill2 = (grand_total2 - EquiRedeem2).toFixed(2);
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
        var purchase_amt = '<?php echo $_SESSION['Grand_total']; ?>';
        var ratio_value = '<?php echo $Redemptionratio;?>';
        var reedem = $("#point_redeem").val();
        var grand_total = '<?php echo $_SESSION['Grand_total']; ?>';
		/* alert('bal'+bal);
		alert('purchase_amt'+purchase_amt);
		alert('ratio_value'+ratio_value);
		alert('grand_total'+grand_total);
		alert('reedem'+reedem); */
        $.ajax(
            {
                type:"POST",
                data:{Current_balance:bal,grand_total:grand_total,Redeem_points:reedem,ratio_value:ratio_value, redeemBY:redeemBY},
                url: "<?php echo base_url()?>index.php/Express_checkout/cal_redeem_amt_contrl/",
                //datatype:"json",
                success: function(data)
                {
                    if(data.Error_flag == 0)
                    {
                        $('#redeem_amt').val(data.EquiRedeem.toFixed(2));
                        $('#total_bill_amount').val(data.Grand_total.toFixed(2));
                    }
                    if(data.Error_flag == 1)
                    {
						var Title = "Application Information";
						var msg = 'Equivalent Redeem Amount is More than Total Bill Amount';
						runjs(Title,msg);
                        $('#redeem_amt').val(0);
                        $('#point_redeem').val(0);
                        $('#total_bill_amount').val(grand_total);
                    }
                    if(data.Error_flag == 2)
                    {
						var Title = "Application Information";
						var msg = 'Insufficient Point Balance';
						runjs(Title,msg);
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
                }
        });
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
        }
        else if(div_flag==0 && redeem_flag == 0)
        {
            $("#point_redeem").removeAttr("required");
            $("#redeem_label").hide();
            $("#point_redeem").hide();
            $("#Equivalent").hide();
			$("#point_redeem").val(0);
			$("#total_bill_amount").val(purchase_amt);
        }
    }
	
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
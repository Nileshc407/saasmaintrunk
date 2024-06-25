<?php 
$this->load->view('header/header');
$cart_check = $this->cart->contents();
$ci_object = &get_instance();
$ci_object->load->model('shopping/Shopping_model');
$ci_object->load->model('Igain_model');

?>
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>

<section class="content-header">
	<h1>My Cart</h1>	 
</section>
	<!-- Main content -->
	<section class="content">
		<?php
		  /* if (@$this->session->flashdata('Redeem_flash')) {
			?>
			<script>
			  var Title = "Application Information";
			  var msg = '<?php echo $this->session->flashdata('Redeem_flash'); ?>';
			  runjs(Title, msg);
			</script>
			<?php
			} */
		?> 
        <div class="row">
			<?php if(empty($cart_check)) { ?>
				<div class="col-md-12">
					<p class="text-muted lead text-center">Your Cart is Empty. Please click below to Add items to the Cart.</p>
					<p class="text-center">
						<a href="<?php echo base_url()?>index.php/Shopping" class="btn btn-template-main">
							<i class="fa fa-chevron-left"></i>&nbsp;Add Item
						</a>
					</p>
				</div>
			<?php } ?>
			
			<?php if ($cart = $this->cart->contents()) { $grand_total = 0; $i = 1; $item_count = COUNT($cart); ?>
			<div class="col-md-12">
				<p class="text-muted lead text-center">You currently have <?php echo $item_count; ?> item(s) in your cart.</p>
			</div>
			<div class="col-md-12 clearfix" id="basket">
				<div class="box">
					<?php  echo form_open('Shopping/update_cart'); ?>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th colspan="3">Menu Item</th>
										<th>Condiments</th>
										<th>Quantity</th>
										<th colspan="3">Outlet Name</th>
										<th>Unit Price (<b><?php echo $Symbol_of_currency; ?></b>)</th>
										<th>Condiments Price (<b><?php echo $Symbol_of_currency; ?></b>)</th>
										<th>Total Cost&nbsp;(<?php echo $Symbol_of_currency; ?>)</th>
										<!--<th>Delivery Cost&nbsp;(<?php echo $Symbol_of_currency; ?>)</th>-->
										<th>Remove</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									// print_r($cart);
									$Exist_Delivery_method=0;
									if(isset($_SESSION["To_Country"]))
									{
										 $To_Country=$_SESSION["To_Country"];
										 $To_State=$_SESSION["To_State"];
									}
									
									foreach ($cart as $item) 
									{
									//	print_r($item);
										
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
											  // echo "<br><b>Shipping_cost </b>".$Shipping_cost;
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
											}
										}
										else
										{
											$Shipping_cost=0;
											$Weighted_avg_shipping_cost=0;
											$Total_Weighted_avg_shipping_cost[]=0;
										}
										 // echo "<br><b>Shipping_cost </b>".$Shipping_cost;
										 
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
												
											//	print_r($item['RequiredCondiments']);
												echo $item["options"]["remark2"];
	
												?>
											</td>
											
											<td style="width: 15%;">
												<?php /*<input type="text" name="cart[<?php echo $item['id']; ?>][qty]" id="qty_<?php echo $item['rowid']; ?>" value="<?php echo $item['qty']; ?>" onchange="Update_item_cart('<?php echo $item['rowid']; ?>');" class="form-control"> */ ?>
												<button type="button" class="<?php echo $item['id']; ?> decr" id="Best_decr" id="button1" onclick="Update_item_cart('<?php echo $item['rowid']; ?>','<?php echo $item['id']; ?>',0);">-</button>
												
												<input type="text" value="<?php echo $item['qty']; ?>" id="qty_<?php echo $item['id']; ?>"  name="cart[<?php echo $item['id']; ?>][qty]" style="text-align: center;" readonly />
												
												<button type="button" class="<?php echo $item['id']; ?> incr" id="Best_incr" onclick="Update_item_cart('<?php echo $item['rowid']; ?>','<?php echo $item['id']; ?>',1);">+</button>
											</td>
											
											<?php if($item["options"]['Merchant_flag'] ==1) 
											{
												$get_enrollment = $ci_object->Igain_model->get_enrollment_details($item["options"]['Seller_id']);
												$merchant_name = $get_enrollment->First_name.' '.$get_enrollment->Last_name;
											}
											else
											{
												$merchant_name = "-";
											}
											?>						
											<td colspan="3"> 
												<?php echo $merchant_name; ?>
											</td>
											<td><?php echo number_format( $item['price'], 2); ?></td>
											<td><?php echo number_format( ($item['MainItem_TotalPrice'] + $item['SideCondiments_TotalPrice']) * $item['qty'], 2); ?></td>
											<td id="Item_subtotal_<?php echo $item['rowid']; ?>">
												<?php
												$grand_total = $grand_total + $item['subtotal'];
												echo number_format((float)$item['subtotal'], 2);
												?>
											</td>
												
											<!--<td><?php //echo number_format($Weighted_avg_shipping_cost,2);?></td> -->
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
										// $_SESSION['Total_Shipping_Cost']=array_sum($Total_Weighted_avg_shipping_cost);
										$_SESSION['Sub_total']=$grand_total;
										// $_SESSION['Grand_total']=($grand_total+$_SESSION['Total_Shipping_Cost']);
										$_SESSION['Grand_total']=($grand_total);
									?>
								</tbody>
								<tfoot>
									<tr>
										<th colspan="6">&nbsp;</th>
										<th colspan="4">Sub Total</th>
											<td><?php echo $Symbol_of_currency; ?>&nbsp;<?php echo number_format($_SESSION['Sub_total'],2); ?></td>
										<td>&nbsp;</td>
									</tr>
									<!--<tr>
										<th colspan="5">&nbsp;</th>
										<th colspan="3">Total Delivery Cost</th>
											<td><?php //echo $Symbol_of_currency; ?>&nbsp;<?php //echo number_format($_SESSION['Total_Shipping_Cost'],2); ?></td>
										<td>&nbsp;</td>
									</tr>-->
									<tr>
										<th colspan="6">&nbsp;</th>
										<th colspan="4">Grand Total</th>
											<td><?php echo $Symbol_of_currency; ?>&nbsp;<?php echo  number_format($_SESSION['Grand_total'],2); ?></td>
										<td>&nbsp;</td>
									</tr>
								</tfoot>
							</table>
						</div>
						<!-- /.table-responsive -->
						<hr>
						<div class="box-footer" style="padding:0px;margin-top:10px;background: #fff;border-top:none">
							<div class="row">
								<div class="col-md-6 col-xs-6">
									<a href="<?php echo base_url()?>index.php/Shopping" class="btn btn-default"><i class="fa fa-backward" aria-hidden="true"></i> Add More</a>
								</div>		
								
								<div class="col-md-6 col-xs-6" align="right">
									<a href="" class="btn btn-template-main" data-toggle="modal" data-target="#myModal1">
										Checkout &nbsp;<i class="fa fa-forward" aria-hidden="true"></i> 
									</a>
								</div> 
								<!--<?php //echo base_url()?>index.php/Shopping/checkout-->
							</div>
						</div><br>
					<?php echo form_close(); ?>	
				</div>
			</div>			
			<?php } ?>
		</div>
	</section>
	<?php 
		$delivery_session_data = $this->session->userdata('delivery_session');
		$delivery_type=$delivery_session_data['delivery_type'];
		$delivery_outlet=$delivery_session_data['delivery_outlet'];
	?>
		<div class="modal fade" id="myModal1" role="dialog" align="center" >
			<div class="modal-dialog modal-md">
				<!-- Modal content-->
				<div class="modal-content">
					<!--<div class="modal-header">
						<h4 class="modal-title">Select Delivery Type</h4>
					</div> -->
				   <div class="modal-body">
						<form id="jsform" action="<?php echo base_url()?>index.php/Shopping/checkout" method="POST" onsubmit="return Validate_form();" >
							<div class="panel panel-default">	
								<div class="panel-heading"><label for="">Select Order Type</label></div>
								<div class="form-group">
									<label class="checkbox-inline"><input type="radio" name="delivery_type"  value="2" <?php if( $delivery_type == 2){echo 'checked=checked'; } ?> onclick="hide_table_no_block(this.value)">In-Store</label>
									
									<?php /*<label class="checkbox-inline"><input type="radio" name="delivery_type" <?php if($delivery_type == 0){echo 'checked=checked'; } ?> value="0" onclick="hide_table_no_block(this.value)">Delivery</label> */ ?>
									
									<?php /*<label class="checkbox-inline"><input type="radio" name="delivery_type" checked value="1">Take Away</label>*/ ?>
									
									<label class="checkbox-inline"><input type="radio" name="delivery_type" value="1" <?php if($delivery_type=="" || $delivery_type == 1){echo 'checked=checked'; } ?> onclick="hide_table_no_block(this.value)">Pick-Up</label>
								</div> 	
							</div> <br>		
							<div class="panel panel-default">	
								<div class="panel-heading"><label for="">Select Outlet</label></div>
								<div class="form-group" id="Take_away_div"><br/>
									<!--<label for="delivery_outlet">Select Outlet</label>-->
									<select class="form-control select2" id="delivery_outlet" name="delivery_outlet" onchange="check_outlet_status(this.value); show_table_no_block(this.value);">
										<?php 
											$Current_time = date("H:i:s");
											$Current_day = date("l");
											$day_of_week = date('N', strtotime($Current_day));
											
											if($delivery_outlet == "")
											{
												echo '<option value="">Select Outlet </option>';
											}
											
											foreach($Sellerdetails as $row)
											{
												$Get_city_name = $ci_object->Igain_model->Get_cities($row['State']);
												/*******AMIT KAMBLE 01-10-2019******Get Working Hours******/
												$Get_outlet_working_hours = $ci_object->Shopping_model->Get_merchant_working_hours($row['Enrollement_id'],$day_of_week);
												
												if($Get_outlet_working_hours != NULL)
												{
													if(!($Current_time >= $Get_outlet_working_hours->Open_time && $Current_time <= $Get_outlet_working_hours->Close_time))
													{
														$Outlet_status = " :- Closed";
													}
													else
													{
														$Outlet_status = " :- Open";
													}
												}
												/**********************************************************/
												foreach($Get_city_name as $City)
												{
													if($City->id==$row['City'])
													{
														$City_name=$City->name;
													}
												}
												
												if($To_City==$row['City']){
											?>
											   <option value="<?php echo $row['Enrollement_id']; ?>" <?php if($delivery_outlet == $row['Enrollement_id']){echo 'selected=selected'; } ?>> <?php echo "<b style=\"color:red\">".$row['First_name'].' '.$row['Last_name'].'</b> - '.App_string_decrypt($row['Current_address']).'('.$City_name.')'; ?>  <?php echo $Outlet_status; ?></option>
											<?php 
											}}
										?>
										<?php 
											
											foreach($Sellerdetails as $row)
											{
												/*******AMIT KAMBLE 01-10-2019******Get Working Hours******/
												$Get_outlet_working_hours = $ci_object->Shopping_model->Get_merchant_working_hours($row['Enrollement_id'],$day_of_week);
												
												if($Get_outlet_working_hours != NULL)
												{
													if(!($Current_time >= $Get_outlet_working_hours->Open_time && $Current_time <= $Get_outlet_working_hours->Close_time))
													{
														$Outlet_status2 = " :- Closed";
													}
													else
													{
														$Outlet_status2 = " :- Open";
													}
												}
												/**********************************************************/
												
												if($To_City!=$row['City']){
											?>
											   <option value="<?php echo $row['Enrollement_id']; ?>"  <?php if($delivery_outlet == $row['Enrollement_id']){echo 'selected=selected'; } ?>> <?php echo "<b style=\"color:red\">".$row['First_name'].' '.$row['Last_name'].'</b> - '.App_string_decrypt($row['Current_address']).'('.$City_name.')'; ?>  <?php echo $Outlet_status2; ?></option>
											<?php 
											}}
										?>
									</select>
									<label class="checkbox-inline text-danger" id="delivery_sms"></label>
								</div>
							</div>
							
							<div class="form-group" id="outlet_status2"></div>
							
							<div class="form-group" id="outlet_status" style="display:none;">
								<font color="red">No Orders Can be Placed at Selected Outlet !!!</font>
							</div>
							
							<div class="form-group" id="Table_no_block" style="display:none;">
								<label for="">Table No.</label>
								<input class="form-control" type="text" name="Table_no" id="Table_no" placeholder="Enter Table Number" maxlength="10" style="width: 210px;text-align:center;">
							</div>
							
							<div class="form-group">
								<button type="submit" name="Checkout" value="Checkout" id="Checkout" class="btn btn-primary">Checkout&nbsp;<i class="fa fa-forward" aria-hidden="true"></i></button>
							</div> <br>
							
							<div class="panel panel-default" id="Instore_confirm_block" style="display:none;">	
								<div class="panel-heading"><label for="">In-Store Order</label></div>
								<div class="form-group">
									<br/>You are placing a In-Store Order<br/><br/>
									Please confirm you are at<br/>
									<span id="Outlet_name_block"></span><br/>
									<span id="Table_block" style="display:none;">Table Number : <span id="Entered_table"></span></span><br/>
									<span id="Outlet_address_block"></span><br/><br/>
									<div class="form-group">
										<button type="button" name="Process_order" value="00" id="Process_order" class="btn btn-primary">I am at the Restaurant&nbsp;<i class="fa fa-forward" aria-hidden="true"></i></button>
										<button type="button" name="Cancel_order" value="11" id="Cancel_order" class="btn btn-primary"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;Cancel In-Store Order</button>
									</div>
								</div> 	
							</div><br>	
						</form>
				   </div>       
				</div>    
				<!-- Modal content-->
			</div>
		</div>
<?php $this->load->view('header/loader');?> 
<?php $this->load->view('header/footer');?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $('.select2').select2();
</script>
<style>
.select2{
	width: 98% !IMPORTANT;
}
#popup 
{
    display:none;
}
#popup2 
{
    display:none;
}
</style>
<script type="text/javascript" charset="utf-8">
$( document ).ready(function() 
{
	var delivery_type = '<?php echo $delivery_type ?>';
	var delivery_outlet = '<?php echo $delivery_outlet ?>';
	if(delivery_type == 2)
	{
		if(delivery_outlet !="")
		{
			$.ajax(
			{
				type: "POST",
				data: {Outlet_id:delivery_outlet},
				url: "<?php echo base_url() ?>index.php/Cust_home/Get_outlet_details",
				dataType: "json",
				success: function (json)
				{
					if(json['Table_no_flag'] == 1)
					{
						$('#Table_no_block').css("display","");  
						$("#Table_no").attr("required","required");
					}
					else
					{
						$('#Table_no_block').css("display","none");  
						$("#Table_no").removeAttr("required");	
						$('#Instore_confirm_block').css("display","none"); 
					}
				}
			}); 
		}
		else
		{
			$('#Table_no_block').css("display","");  
			$("#Table_no").attr("required","required");
		}
		
		// $('#Table_no_block').css("display","");
		// $("#Table_no").attr("required","required");		 
	}
	else
	{
		$('#Table_no_block').css("display","none");  
		$("#Table_no").removeAttr("required");
	}
});
function Validate_form()
{
	if ($('input[name="delivery_type"]:checked').length == 0) 
	{      
		return false; 
	} 
	else 
	{
		// console.log($('input[name="delivery_type"]:checked').val());
		
		var delivery_type = $("input[name=delivery_type]:checked").val();
		
		if($('#delivery_outlet').val()=="")
		{	
			setTimeout(function()
			{	
				$('#delivery_sms').html('Please select outlet');
			}, 0);
			
			setTimeout(function(){
				
				$('#delivery_sms').css('color:red');
				$('#delivery_sms').html('');
				
			}, 3000);
			
			return false;
		}
		else if(delivery_type == 2)
		{
			// alert('In-Store');
			var TableNumber = $("#Table_no").val();
			var Outlet_id = $("#delivery_outlet").val();
			
			$('#Instore_confirm_block').css("display",""); 
			
			$.ajax(
			{
				type: "POST",
				data: {Outlet_id:Outlet_id},
				url: "<?php echo base_url() ?>index.php/Cust_home/Get_outlet_details",
				dataType: "json",
				success: function (json)
				{
					$('#Outlet_name_block').html(json['Outlet_name']);
					$('#Outlet_address_block').html(json['Outlet_address']);
					if(json['Table_no_flag'] == 1)
					{
						$('#Table_block').css("display",""); 
						$("#Entered_table").html(TableNumber);		
					}
				}
			}); 
					
			return false;
		}
		else
		{
			$('#Instore_confirm_block').css("display","none"); 
		}
			show_loader();
		return true;
	}
	// return true;
}
$('#Process_order').click(function()
{
	document.getElementById('jsform').submit();
	show_loader();
	return true;
});
$('#Cancel_order').click(function()
{
	location.reload();
	show_loader();
	return true;
});

function show_table_no_block(Outlet_id)
{
	var show_flag = $("input[name=delivery_type]:checked").val();
	// var Outlet_id = $("#delivery_outlet").val();
	
	if(show_flag == 2)
    {	
		$.ajax(
		{
			type: "POST",
			data: {Outlet_id:Outlet_id},
			url: "<?php echo base_url() ?>index.php/Cust_home/Get_outlet_details",
			dataType: "json",
			success: function (json)
			{
				if(json['Table_no_flag'] == 1)
				{
					$('#Table_no_block').css("display","");  
					$("#Table_no").attr("required","required");
				}
				else
				{
					$('#Table_no_block').css("display","none");  
					$("#Table_no").removeAttr("required");	
					$('#Instore_confirm_block').css("display","none"); 
				}
			}
		});
    }
    else
    {
        $('#Table_no_block').css("display","none");  
		$("#Table_no").removeAttr("required");	
		$('#Instore_confirm_block').css("display","none"); 
    }
}
function hide_table_no_block(show_flag)
{
	var Outlet_id = $("#delivery_outlet").val();
	
	if(show_flag != 2)
    {	
		$('#Table_no_block').css("display","none");  
		$("#Table_no").removeAttr("required");	
		$('#Instore_confirm_block').css("display","none"); 
    }
    else
    {
		if(Outlet_id !="")
		{
			$.ajax(
			{
				type: "POST",
				data: {Outlet_id:Outlet_id},
				url: "<?php echo base_url() ?>index.php/Cust_home/Get_outlet_details",
				dataType: "json",
				success: function (json)
				{
					if(json['Table_no_flag'] == 1)
					{
						$('#Table_no_block').css("display","");  
						$("#Table_no").attr("required","required");
					}
					else
					{
						$('#Table_no_block').css("display","none");  
						$("#Table_no").removeAttr("required");	
						$('#Instore_confirm_block').css("display","none"); 
					}
				}
			}); 
		}
		else
		{
			$('#Table_no_block').css("display","");  
			$("#Table_no").attr("required","required");
		}
    }
}
function check_outlet_status(Enroll_id)
{
	$("#Checkout").hide();

	var Outlet = delivery_outlet.options[delivery_outlet.selectedIndex].text;
	var res = Outlet.split("-");
	var Outlet2 = res[0];
	 $.ajax(
    {
        type: "POST",
        data: { Enroll_id:Enroll_id },
        url: "<?php echo base_url()?>index.php/Shopping/Get_outlet_working_hours",
        success: function(data)
        {
           if(data==0)//close
		   {
			  // $("#Checkout").attr("disabled", true);
			   
			   $("#outlet_status").show();
			   $("#outlet_status2").show();
			   $("#outlet_status2").html('<font color="red">'+Outlet2+' is Currently Closed</font>');
		   }
		   else if(data==2)//close
		   {
			 //  $("#Checkout").attr("disabled", true);

			   $("#outlet_status2").show();
			   $("#outlet_status2").html('<font color="red">'+Outlet2+' is Currently not processing online Orders</font>');
		   }
		   else
		   {
			 //  $("#Checkout").attr("disabled", false);
			   $("#Checkout").show();
			   $("#outlet_status").hide();
			   $("#outlet_status2").hide();
		   }
			
        }
    });
	
}
/* function hide_show_type(type){
	
	// console.log(type);
	if(type ==0){
		$('#Take_away_div').css('display','none');
	}
	else {
		$('#Take_away_div').css('display','block');
	}
	
} */


$("[type='number']").keypress(function (evt) 
{
    evt.preventDefault();
});

function remove_item(rowid)
{
	$.ajax({
		type: "POST",
		data: { id:serial, name:name, price:price, picture:picture },
		url: "<?php echo base_url()?>index.php/Shopping/remove",
		success: function(data)
		{
			if(data == 1)
			{
				$('#myModal').hide();
				$("#myModal").removeClass( "in" );
				$('.modal-backdrop').remove();
		
				var Title = "Successful";
				var msg = 'Product '+name+' is added to Cart Successfuly..!!';
				runjs(Title,msg);
			}
			else
			{
				$('#myModal').hide();
				$("#myModal").removeClass( "in" );
				$('.modal-backdrop').remove();
				
				var Title = "Invalid Data Information";
				var msg = 'Error adding Product '+name+' to Cart. Please try again..!!';
				runjs(Title,msg);
			}
		}
	});
}

function Show_updatelink(RowId)
{
    $('#Update_div_'+RowId).show();
}

function Hide_updatelink(RowId)
{
    $('#Update_div_'+RowId).hide();
}

function Update_item_cart(RowId,id,type)
{
	show_loader();
    // var Quantity = $('#qty_'+RowId).val();
	var Quantity = $('#qty_'+id).val();
	if(type==0)
	{
		Quantity=parseInt(Quantity) - 1;
	}
	else if(type==1)
	{
		Quantity=parseInt(Quantity) + 1;
	}
	
    var Symbol_of_currency = '<?php echo $Symbol_of_currency; ?>';
    
    $.ajax(
    {
        type: "POST",
        data: { Quantity:Quantity, RowId:RowId },
        url: "<?php echo base_url()?>index.php/Shopping/Update_item_quantity",
        success: function(data)
        {
            if(data.Error_flag == 0)
            {
               /* $('#Item_unitprice_'+RowId).html('<b>' + Symbol_of_currency +'</b> ' + data.Item_unitprice);
                $('#Item_subtotal_'+RowId).html('<b>' + Symbol_of_currency +'</b> ' + data.Item_subtotal);
                $('#Cart_grandTotal').html('<b>' + Symbol_of_currency +'</b> ' + data.grand_total);
                */
                // ShowPopup('Quantity Updated Successfuly..!!');
                $('#Update_div_'+RowId).hide();
            }
            else if(data.Error_flag == -2)
            {
               // ShowPopup('Error Updataing Quantity. Quantity should be greater than 0. Please Tray Again.');
                $('#Update_div_'+RowId).hide();
            }
            else
            {
                //ShowPopup('Error Updataing Quantity. Please Tray Again.');
                $('#Update_div_'+RowId).hide();
            }
			location.reload(); 
        }
    });
}    

function ShowPopup(x)
{
    $('#popup_info').html(x);
    $('#popup').show();
    setTimeout('HidePopup()', 9000);
}

function HidePopup()
{
    $('#popup').hide();
}
</script>
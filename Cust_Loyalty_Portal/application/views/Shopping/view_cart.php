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
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>

	<section class="content-header">
		<h1>Your Shopping Cart</h1>	 
	</section>

	<!-- Main content -->
	<section class="content">
            
            <div class="row">	
                <div class="col-md-6 col-md-offset-3" id="popup">
                    <div class="alert alert-success text-center" role="alert" id="popup_info"></div>
                </div>
            </div>
            
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
									// print_r($cart);
									$Exist_Delivery_method=0;
									if(isset($_SESSION["To_Country"]))
									{
										 $To_Country=$_SESSION["To_Country"];
										 $To_State=$_SESSION["To_State"];
									}
									
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
												 // echo '<br>if('.$rec["options"]["Partner_state"].'=='.$Partner_state.')';
												
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
											
											<td  colspan="2">
												<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo urlencode($Company_merchandise_item_id); ?>"><?php echo $Product_details->Merchandize_item_name; ?></a>
												
											</td>
											<?php /*
											<td>
											 <input type="text" name="cart[<?php echo $item['id']; ?>][qty]" id="qty_<?php echo $item['rowid']; ?>" value="<?php echo $item['qty']; ?>" onchange="Update_item_cart('<?php echo $item['rowid']; ?>');" class="form-control"  >
											</td> */?>
											<td style="width: 15%;">
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
									
								</tfoot>
							</table>

						</div>
						<!-- /.table-responsive -->
						<hr>
						<div class="box-footer" style="padding:0px;margin-top:10px;background: #fff;border-top:none">
						
							<div class="row">
								<div class="col-md-6 col-xs-6">
									<a href="<?php echo base_url()?>index.php/Shopping" class="btn btn-default"><i class="fa fa-backward" aria-hidden="true"></i> Shopping</a>
								</div>						
								
								<div class="col-md-6 col-xs-6" align="right">
									<a href="<?php echo base_url()?>index.php/Shopping/checkout" class="btn btn-template-main">
										Checkout &nbsp;<i class="fa fa-forward" aria-hidden="true"></i> 
									</a>
								</div>
							</div>
							
						</div>

					<?php echo form_close(); ?>	

				</div>
			</div>
			
			<?php } ?>
			
		</div>
	</section>
		<?php $this->load->view('header/loader');?> 
<?php $this->load->view('header/footer');?>
        
<style>
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
                ShowPopup('Error Updataing Quantity. Quantity should be greater than 0. Please Tray Again.');
                $('#Update_div_'+RowId).hide();
            }
            else
            {
                ShowPopup('Error Updataing Quantity. Please Tray Again.');
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
    setTimeout('HidePopup()', 2000);
}

function HidePopup()
{
    $('#popup').hide();
}
</script>
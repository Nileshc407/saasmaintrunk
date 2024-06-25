<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('front/header/header'); 

$ci_object = &get_instance();
$ci_object->load->model('shopping/Shopping_model');
$ci_object->load->model('Igain_model');
$ci_object->load->helper(array('encryption_val'));

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
<body style="background-image:url('<?php echo base_url(); ?>assets/img/order-bg.jpg')">
	<div id="wrapper">
		<div class="custom-header">
			<div class="container">
				<div class="heading-wrap">
					<div class="icon back-icon">
						<a href="<?php echo base_url();?>index.php/Shopping/my_orders"></a>
					</div>
					<h2>My Order</h2>
				</div>
			</div>
		</div>
		<?php
				$sub_total = 0;
				$Subtotal = array();
				$Shippingcost = array();
				$Paid_amount = array();
				$Mpesa_Paid_Amount = array();
				$COD_Amount = array();
				$RedeemPoints = array();
				$Redeem_amount = array();
				
			foreach($Order_details as $Order_det)
			{
					$Subtotal[] =$Order_det['Purchase_amount'];
					$Shippingcost[] =$Order_det['Shipping_cost'];
					$Paid_amount[] =$Order_det['Paid_amount'];
					$Mpesa_Paid_Amount[] =$Order_det['Mpesa_Paid_Amount'];
					$COD_Amount[] =$Order_det['COD_Amount'];
					$RedeemPoints[]=$Order_det['Redeem_points'];
					$Redeem_amount[]=$Order_det['Redeem_amount'];
					
					
					$Billdiscount[]=$Order_det['Bill_discount'];
					$Itemcategory_discount[]=$Order_det['Item_category_discount'];
					$Total_discount[]=$Order_det['Total_discount'];
					$Total_discount_final=$Order_det['Total_discount'];
			
					// $sub_total = $sub_total + ($Order_det['Quantity'] * $Order_det['Purchase_amount']);
					$sub_total =  $Order_det['Purchase_amount'];		
					$Bill_no=$Order_det["Bill_no"];
					$Manual_billno=$Order_det["Manual_billno"];
					$Order_no=$Order_det["Order_no"];
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
					$TransType=$Order_det['Trans_type'];
					
					// echo"--Merchandize_item_name-----".$Order_det["Merchandize_item_name"]."----<br>";
					
					if($Order_det['Voucher_status']==20)//Delivered 
					{
						if($Order_det['Delivery_method']==28){
							$Voucher_status= 'Collected'; 
						} elseif($Order_det['Delivery_method']==29) {
							$Voucher_status= 'Delivered'; 
						} else{
							
							$Voucher_status=''; 
						}																	
					}
					elseif($Order_det['Voucher_status']==19)//Shipped
					{
						$Voucher_status=  'Shipped';
					}
					elseif($Order_det['Voucher_status']==21)//Cancel
					{
						$Voucher_status= 'Cancelled'; 
					}
					elseif($Order_det['Voucher_status']==22)//'Return Initiated'
					{
						$Voucher_status = 'return-initiated';
					}
					elseif($Order_det['Voucher_status']==18) //Ordered
					{
						$Voucher_status =  'Ordered'; 
					} 
					elseif($Order_det['Voucher_status']==23) //Returned
					{
						$Voucher_status = 'Returned';					
					} 
					else
					{
						$Voucher_status = "";
					}
				$Order_date = $Order_det['Trans_date'];
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
			$Redeemamount11 = array_sum($Redeem_amount);			
		?>
		<?php 
		if($Delivery_method == 29 && $TransType == 12){
			$Deliverymethod="Delivery";
		}
		else if($Delivery_method==28 && $TransType == 12){
			$Deliverymethod="Pick up";
		} else if($Delivery_method==28 && $TransType == 29){
			$Deliverymethod="Take Away";
		} else{
			$Deliverymethod="Take Away";
		}
		$outlet_address = $ci_object->Shopping_model->GetTakeAwayAddress($Company_id,$Seller);
		?>
		<div class="custom-body transparent">
			<div class="order-body detail">
				<div class="card">
				  <div class="card-header">
				  <?php echo date("M d, Y, g:i A",strtotime($Order_date)); ?>
				    <span class="float-right"><?php echo $Voucher_status; ?></span>
				  </div>
				  <div class="card-body">
				  	<div class="card">
				  	<div class="order-datail">
				    <p><strong>Order No: </strong> <?php if($TransType == 29) { echo $Order_no; } else {  echo $Bill_no; } ?></p>
				    <p><strong>Total: </strong> <?php echo $Symbol_of_currency." ". number_format((float)$SubtotalAmt, 2); ?></p>
					</div>
					</div>
					<div class="card">
				  	<div class="order-datail">
				    <p><strong>Order Type: </strong> <?php echo $Deliverymethod; ?></p>
				    <p><strong>Outlet: </strong><?php echo $outlet_address->Seller_name; ?></p>
				    <p><strong>Bill No: </strong> <?php if($Manual_billno != Null ) { echo $Manual_billno; } else { echo $Order_no; } ?></p>
					</div>
				  	</div>
				  	<div class="card">
					<?php
						// var_dump($Order_details);
						
						$Outlet_status_flag=0;
						$Current_time = date("H:i:s");
						$Current_day = date("l");
						$day_of_week = date('N', strtotime($Current_day));
						
						$sub_total = 0;
						$Subtotal = array();
						$Shippingcost = array();
						$Paid_amount = array();
						$Mpesa_Paid_Amount = array();
						$COD_Amount = array();
						$RedeemPoints = array();
						$Redeem_amount = array();
						
						
						$DisountAmt=array();
						$Billdiscount=array();
						$Itemcategory_discount=array();
						$Total_discount=array();
						$TotalDiscount=array();
						$Total_discount_final=0;
						foreach($Order_details as $Order_det)
						{
							$Subtotal[] =$Order_det['Purchase_amount'];
							$Shippingcost[] =$Order_det['Shipping_cost'];
							$Paid_amount[] =$Order_det['Paid_amount'];
							$Mpesa_Paid_Amount[] =$Order_det['Mpesa_Paid_Amount'];
							$COD_Amount[] =$Order_det['COD_Amount'];
							$RedeemPoints[]=$Order_det['Redeem_points'];
							$Redeem_amount[]=$Order_det['Redeem_amount'];
							
							
							$Billdiscount[]=$Order_det['Bill_discount'];
							$Itemcategory_discount[]=$Order_det['Item_category_discount'];
							$Total_discount[]=$Order_det['Total_discount'];
							$Total_discount_final=$Order_det['Total_discount'];
								
							// $sub_total = $sub_total + ($Order_det['Quantity'] * $Order_det['Purchase_amount']);
							$sub_total =  $Order_det['Purchase_amount'];		
							$Bill_no=$Order_det["Bill_no"];
							$Manual_billno=$Order_det["Manual_billno"];
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
							$TransType=$Order_det['Trans_type'];
								
						 // echo"--Merchandize_item_name-----".$Order_det["Merchandize_item_name"]."----<br>";
							
							
							//********* sandeep ***************
							$MainItemInfo = $this->Shopping_model->get_main_item($Order_det["Item_code"],$Company_id);
					//	print_r($MainItemInfo); 
							$getCondiment = $this->Shopping_model->get_transaction_item_condiments($Bill_no,$Order_det["Item_code"],$Company_id);

							foreach($getCondiment as $n)
							{
								$side_item_codes[] = $n["Condiment_Item_code"];
							}
					?>
				  	<div class="order-datail space-between">
				    	<strong><?php echo $Merchandize_item_name; 
						/*foreach($MainItemInfo as $MainItem){
						if($MainItem['Merchandize_item_name'] != NULL && in_array($MainItem["Main_or_side_item_code"],$side_item_codes)){ ?>
								<?php echo "+".$MainItem['Merchandize_item_name']; ?>
						<?php }
							 } */
						?></strong>
						<?php /*  if($Order_det['remark2'] != "") { ?>
								( <strong id="Value_font">Condiments</strong>
								<span id="Value_font">:&nbsp;<?php 
								if($Order_det['remark2'] != ""){
									echo $Order_det['remark2'];
								} else {
									echo "-";
								}
								 ?></span> )
						<?php  } */ ?>
				    	<span><?php echo $Quantity; ?></span>
				    	<span><?php $Unit_price=$Order_det['Purchase_amount']/$Order_det['Quantity']; ?>
						<?php echo number_format((float)$Unit_price, 2) ?></span> 
						<?php
							$item_name= preg_replace('#[^\w()/.%\-&]#',' ',$Order_det['Merchandize_item_name']);
							$Merchandize_item_name = garbagereplace($item_name);
							// echo "<br>----Merchandize_item_name----".$Merchandize_item_name;
							/* preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$Order_det['Merchandize_item_name']) */
						?>
						
						<?php 
													
												// echo "<br>----Table_no----".$Table_no;
													$Delivery_method=$Order_det['Delivery_method'];
													$Table_no = $Order_det['Table_no'];
													$Seller=$Order_det['Seller'];
													
													$Get_outlet_working_hours = $ci_object->Shopping_model->Get_outlet_working_hours($Seller,$day_of_week);			
													// echo"---Get_outlet_working_hours---".$Get_outlet_working_hours."---<br>";
													// $Get_outlet_working_hours=1;
													if($Get_outlet_working_hours==2)
													{
														
														$Outlet_status = " :- Closed";
														$Outlet_status_flag =0;
														
														?>
														
														<font style="color:red;font-size:10px;">Currently not processing Reorder!</font>
														
													<?php 
													}
													else
													{  
														$Outlet_status = " :- Open";
														$Outlet_status_flag =1; 
														
														?>
														
													<?php if($TransType == 12) { ?>	
													
														<a href="#" id="button" class="return-order" onclick="add_to_cart1('<?php echo $Order_det['Company_merchandise_item_id']; ?>','<?php echo $Order_det["Item_code"]; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$Order_det['Merchandize_item_name']); ?>','<?php echo $Order_det['Billing_price']; ?>',29,'<?php echo $Order_det['Merchandize_Partner_branch']; ?>','<?php echo $Order_det['Company_merchandise_item_id']; ?>','<?php echo $Order_det['Item_size']; ?>','<?php echo $Order_det['Item_Weight']; ?>','<?php echo $Order_det['Weight_unit_id']; ?>','<?php echo $Order_det['Merchandize_Partner_id']; ?>','<?php echo $Order_det['Partner_state']; ?>','<?php echo $Order_det['Partner_Country']; ?>','<?php echo $Order_det['Seller']; ?>','<?php echo $Order_det['Merchant_flag']; ?>','<?php echo $Order_det['Cost_price']; ?>','<?php echo $Order_det['VAT']; ?>','<?php echo $Order_det['Merchandize_category_id']; ?>','<?php echo $Order_det['remark2']; ?>','<?php echo $Order_det['remark3']; ?>','<?php echo $Order_det["Bill_no"]; ?>','<?php echo $Order_det['Combo_meal_flag']; ?>','<?php echo $Order_det['Delivery_method']; ?>','<?php echo $Order_det['Table_no']; ?>');"> Reorder</a>
														
													<?php } ?>
													<?php 
													}													
													?>
						
						
						
				    	<?php /* ?><a href="#" class="return-order" onclick="add_to_cart1('<?php echo $Order_det['Company_merchandise_item_id']; ?>','<?php echo $Order_det["Item_code"]; ?>','<?php echo $Merchandize_item_name; ?>','<?php echo $Order_det['Billing_price']; ?>',29,'<?php echo $Order_det['Merchandize_Partner_branch']; ?>','<?php echo $Order_det['Company_merchandise_item_id']; ?>','<?php echo $Order_det['Item_size']; ?>','<?php echo $Order_det['Item_Weight']; ?>','<?php echo $Order_det['Weight_unit_id']; ?>','<?php echo $Order_det['Merchandize_Partner_id']; ?>','<?php echo $Order_det['Partner_state']; ?>','<?php echo $Order_det['Partner_Country']; ?>','<?php echo $Order_det['Seller_id']; ?>','<?php echo $Order_det['Merchant_flag']; ?>','<?php echo $Order_det['Cost_price']; ?>','<?php echo $Order_det['VAT']; ?>','<?php echo $Order_det['Merchandize_category_id']; ?>','<?php echo $Order_det['remark2']; ?>','<?php echo $Order_det['remark3']; ?>','<?php echo $Order_det["Bill_no"]; ?>','<?php echo $Order_det['Combo_meal_flag']; ?>');" >Reorder</a> <?php */ ?>
					</div>
				<?php	
						$Redeem_points = $Order_det['Redeem_points'] ;
						$calculate_redeem_amounts=round($Redeem_points/$Redemptionratio);
						$Grand_total=($Shipping_cost+$sub_total-$calculate_redeem_amounts);
					} 
						function garbagereplace($string) {

							$garbagearray = array('@','#','$','%','^','&','*','(',')','');
							$garbagecount = count($garbagearray);
							for ($i=0; $i<$garbagecount; $i++) {
								$string = str_replace($garbagearray[$i], ' ', $string);
							}

							return $string;
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
						$Redeemamount11 = array_sum($Redeem_amount);								
						if($REDEEM_Points != 0)
						{										
							// $RedeemAmount = ($SubtotalAmt+$ShippingcostAmt1)-($MpesaPaidAmount1+$CODAmount1);
							$RedeemAmount = $Redeemamount11;
						}
						else
						{
							$RedeemAmount=0;
						}
						
						$Billdiscount1 = array_sum($Billdiscount);	
						$Itemcategory_discount1 = array_sum($Itemcategory_discount);	
						$Total_discount1 = array_sum($Total_discount);	
					?>
					<?php if($Outlet_status_flag==1) { 
					 if($TransType == 12) {  ?>
						<div class="reorder-group">
							<a href="JavaScript:void(0);" class="btn btn-link lg" onclick="Reorder('<?php echo $Bill_no; ?>','<?php echo $Seller; ?>','<?php echo $Delivery_method; ?>','<?php echo $Table_no; ?>');">Reorder All</a>
						</div>
					 <?php } } ?>
				  	</div>
				  </div>	  
				</div>		
			</div>
		</div>
<?php $this->load->view('front/header/footer');?>

<script>
function add_to_cart1(serial,Itemcode,name,price,Redemption_method,Branch,Company_merchandise_item_id,Item_size,Item_Weight,Weight_unit_id,Partner_id,Partner_state,Partner_Country_id,Seller_id,Merchant_flag,Cost_price,VAT,Product_category_id,remark2,remark3,Bill_no,Combo_meal_flag,Delivery_method,Table_no)
{
	
	
	$.ajax({
		type: "POST",
		data: { id:serial,Company_merchandize_item_code:Itemcode, name:name,price:price,Delivery_method:Delivery_method,Branch:Branch,Item_size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id,Partner_id:Partner_id,Partner_state:Partner_state,Partner_Country_id:Partner_Country_id,Seller_id:Seller_id,Merchant_flag:Merchant_flag,Cost_price:Cost_price,VAT:VAT,Product_category_id:Product_category_id,Condiments_name:remark2,Condiments_code:remark3,Bill:Bill_no,Combo_meal_flag:Combo_meal_flag,TableNo:Table_no},
		url: "<?php echo base_url()?>index.php/Shopping/Reorder_add_to_cart",
		success: function(data)
		{
			console.log(data.cart_success_flag);
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


function Reorder(Bill_no,Seller,Delivery_method,Table_no)
{
	// show_loader();	
	$.ajax({
		
		type: "POST",
		data: {Order_no:Bill_no,Seller:Seller,Delivery_method:Delivery_method,Table_no:Table_no},
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

		
<script>
/*
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
} */ 
</script>
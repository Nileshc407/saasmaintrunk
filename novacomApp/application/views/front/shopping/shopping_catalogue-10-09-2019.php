<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title?></title>	
<?php $this->load->view('front/header/header'); 
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?> 	
</head>
<body>
	<?php 
		if($Ecommerce_flag==1) {						
			$cart_check = $this->cart->contents();
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
<form  name="Search_items" method="POST" action="<?php echo base_url()?>index.php/Shopping/Search_items" enctype="multipart/form-data">
<div id="application_theme" class="section pricing-section">
	<div class="container">
		<div class="section-header">          
			<p><a href="<?php echo base_url(); ?>index.php/Cust_home/load_shopping" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font">Order Online</p>
		</div>			
		<div class="row pricing-tables">
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px; ">		
				<!-- Loader -->	
				<div class="container" >
					<div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog modal-sm" style="margin-top: 65%;">
							<div class="modal-content" id="loader_model">
								<div class="modal-body" style="padding: 10px 0px;;">
								  <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
								</div>							
							</div>						  
						</div>
					</div>					  
				</div>
				<!-- Loader -->	
				<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
					<!----Search Box---->
						<div class="pricing-details">
							<address style="margin-top: -40px; margin-left:-15px;"> 
								<a href="<?php echo base_url(); ?>index.php/Shopping"><span id="button5" onclick="Page_refresh();"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/refresh.png" style="width: 20px"></span></a>						
							   <input type="text" name="Search_key" placeholder="Search" id="Search_mail" class="txt" autocomplete="off">
							   <a href="#">
								<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/search.png" id="search" onclick="form_submit();">
							   </a>
							</address> 
						</div>
					<!----Search Box---->
				<?php					
					if($Redemption_Items != NULL)
					{
						foreach ($Redemption_Items as $product)
						{			
							$Branches = $Redemption_Items_branches[$product['Company_merchandize_item_code']];						
							$Count_item_offer = $this->Shopping_model->get_count_item_offers($product["Company_merchandise_item_id"],$product['Company_id']);
							
							$Get_Partner_details = $this->Igain_model->Get_Company_Partners_details($product["Partner_id"]);
							$Partner_state=$Get_Partner_details->State;
							$Partner_Country=$Get_Partner_details->Country_id;
							if($product['Size_flag'] == 1) 
							{ 
								$Get_item_price = $this->Redemption_Model->Get_item_details($Company_id,$product['Company_merchandize_item_code']);	
								$Billing_price = $Get_item_price->Billing_price;
								$Item_size=$Get_item_price->Item_size;
							} 
							else 
							{
								$Item_size="0";
								$Billing_price = $product['Billing_price'];	
							}
							foreach ($Branches as $Branches2)
							{
								$DBranch_code=$Branches2['Branch_code'];
								$DBranch_id=$Branches2['Branch_id'];
							} 
							?>							
						<input type="hidden" name="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" id="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" value="<?php echo $DBranch_code; ?>">	
							<div class="pricing-details" id="Search_result">
								<div class="row">
									<div class="col-md-12">
										<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $product['Company_merchandise_item_id']; ?>"> 
										<div class="row">
											<div class="col-xs-4 b-items__item" style="padding: 10px;">
												<img src="<?php echo $product['Thumbnail_image1']; ?>" alt="" class="b-items__item__img" width="60"> 
											</div>											
											<div class="col-xs-8 text-left" style="width: 66%;">
												<address style="border:none;">
													<strong id="Medium_font"><?php echo $product['Merchandize_item_name']; ?></strong><br>
												</address>											
												<span id="Small_font"><strong><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo $Billing_price; ?></strong></span>
												
												<!-- Offer -->
												<?php if($Count_item_offer >= 1 )
												{
												?>											
													<span>
													<a href="#" data-toggle="collapse" data-target="#<?php echo $product['Company_merchandise_item_id']; ?>">
													<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/item_offer.png" style="float:right; width:60px;">
													</a>
													<div id="<?php echo $product['Company_merchandise_item_id']; ?>" class="collapse">
													<?php
													foreach($Redemption_Items_offers_array[$product['Company_merchandise_item_id']] as $prod)
													{											
														if($product['Offer_flag']==1)
														{		
															$Offer_id=$prod['Offer_id'];
															$Buy_item=$prod['Buy_item'];
															$Free_item=$prod['Free_item'];
															$Free_item_id=$prod['Free_item_id'];
																
															$Offer_item_details= $this->Shopping_model->Get_Merchandize_Item_details($prod["Free_item_id"]);
																
															if($Buy_item!= "" && $Buy_item != '0' && $Free_item != "" && $Free_item != '0' ) 
															{ 
														?>
															<h6 id="Small_font"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/offer.png" style="width:15px;"> Buy <b><?php echo $Buy_item ?></b> Get <b><?php echo $Free_item ?></b> <?php echo $Offer_item_details->Merchandize_item_name; ?>
																</h6>
														<?php			
															}
															else
															{
															?>
																NO any Offers on this Items
															<?php
															} 
														}								
													}
													?>
												</div>
												</span>	
												<?php 
												}							
												?>
												<!-- Offer -->
											</div>
										</div>
										</a>
										<div class="row">
											<div id="alert_div_<?php echo $product["Company_merchandise_item_id"];?>" style="float: right;margin: 0 auto;"></div>
											<div class="col-xs-4 main-xs-6">
												 <button type="button" id="button" class="b-items__item__add-to-cart" onclick="add_to_wishlist('<?php echo $product["Company_merchandise_item_id"]; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$product["Merchandize_item_name"]); ?>','<?php echo $Billing_price; ?>');"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/wishlist.png" alt="" class="img-rounded img-responsive" width="15" style="margin-top: -4px;"> Wish List</button>
											</div>
											
											<div class="col-xs-4 main-xs-6">
												 <button type="button" id="button" class="b-items__item__add-to-cart" onclick="add_to_cart('<?php echo $product["Company_merchandise_item_id"]; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$product["Merchandize_item_name"]); ?>','<?php echo $Billing_price; ?>',29,29,<?php echo $product['Company_merchandise_item_id']; ?>,'<?php echo $Item_size; ?>',<?php echo $product['Item_Weight']; ?>,<?php echo $product['Weight_unit_id']; ?>,<?php echo $product['Partner_id']; ?>,'<?php echo $Partner_state; ?>','<?php echo $Partner_Country; ?>',<?php echo $product['Seller_id']; ?>,<?php echo $product['Merchant_flag']; ?>,'<?php echo $product['Cost_price']; ?>','<?php echo $product['VAT']; ?>','<?php echo $product['Merchandize_category_id']; ?>','<?php echo $product['Company_merchandize_item_code']; ?>','<?php echo $product['Thumbnail_image1']; ?>');"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/cart.png" alt="" class="img-rounded img-responsive" width="15" style="margin-top: -4px;"> Add to Cart</button>
											</div>
										</div>							
									</div>
								</div>
								<hr style="background:white;">
							</div>
						<?php 
						}
					}
					else
					{ ?>
						<div class="row">							
							<div class="col-xs-8 text-left" style="width: 100%;">
								<address style="text-align:center;border:none;">
									<strong id="Medium_font">No Item Found</strong><br>
								</address>	
							</div>
						</div>
					<?php
					}
					?>	
				</div>
			</div>
		</div>
	</div>				
</div>
<div class="footer" >
	<div class="row" id="Footer_font">			
		<div class="col-xs-3 footer-xs">
			<a href="<?php echo base_url()?>index.php/Shopping/view_wishlist">		
			<div class="b-cart"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/wishlist.png" alt="" class="img-rounded img-responsive" width="15"> <input type="text" id="wishlist_count" readonly="readonly" value="<?php echo $item_count2; ?>"> </div>
			 <span id="foot_txt">Wish List</span>				
			</a>
		</div>
		<div class="col-xs-3 footer-xs">
			<a href="<?php echo base_url()?>index.php/Shopping/view_cart">
			 <div class="b-cart"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/cart.png" alt="" class="img-rounded img-responsive" width="15"> <input type="text" id="cart_count" readonly="readonly" value="<?php echo $item_count; ?>"> </div>				 
			 <span id="foot_txt">Cart</span>
			 </a>
		</div>
		<div class="col-xs-3 footer-xs">
			<a href="<?php echo base_url()?>index.php/Shopping/filters">				
			 <div class="b-cart"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/filter.png" alt="" class="img-rounded img-responsive" width="15"></div>				 
			 <span id="foot_txt">Filters</span>				
			</a>
		</div>
	</div>
</div>	
</form>			
<?php $this->load->view('front/header/footer');?> 
<script>
	function form_submit()
	{
		setTimeout(function() 
		{
				$('#myModal').modal('show'); 
		}, 0);
		setTimeout(function() 
		{ 
				$('#myModal').modal('hide'); 
		},2000);

		document.Search_items.submit();
	} 
	
	function Page_refresh()
	{
		setTimeout(function() 
		{
			$('#myModal').modal('show'); 
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide'); 
		},2000);
		
		// window.location.reload();
	}
	function add_to_cart(serial,name,price,Redemption_method,Branch,Company_merchandise_item_id,Item_size,Item_Weight,Weight_unit_id,Partner_id,Partner_state,Partner_Country_id,Seller_id,Merchant_flag,Cost_price,VAT,Product_category_id,Company_merchandize_item_code,Item_image1)
	{
		var input = $('#cart_count');
		input.val(parseInt(input.val()) + 1);
		setTimeout(function() 
		{
			$('#myModal').modal('show');	
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide');	
		},2000); 
		
		Branch=document.getElementById("Delivery_"+Company_merchandise_item_id).value;
		$.ajax(
		{
				type: "POST",
				data: { id:serial, name:name, price:price, Delivery_method:29, Branch:Branch ,Item_size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id,Partner_id:Partner_id,Partner_state:Partner_state,Partner_Country_id:Partner_Country_id,Seller_id:Seller_id,Merchant_flag:Merchant_flag,Cost_price:Cost_price,VAT:VAT,Product_category_id:Product_category_id,Company_merchandize_item_code:Company_merchandize_item_code,Item_image1:Item_image1},
				url: "<?php echo base_url()?>index.php/Shopping/add_to_cart",
				success: function(data)
				{					 
					if(data.cart_success_flag == 1)
					{
						var msg1 = 'Item added to Cart Successfuly';
						$('#alert_div_'+Company_merchandise_item_id).show();
						$('#alert_div_'+Company_merchandise_item_id).css("color","green");
						$('#alert_div_'+Company_merchandise_item_id).html(msg1);
						setTimeout(function(){ $('#alert_div_'+Company_merchandise_item_id).hide(); }, 3000);
					}
					else
					{
						 var msg1 = 'Error adding item to Cart. Please try again';
						$('#alert_div_'+Company_merchandise_item_id).show();
						$('#alert_div_'+Company_merchandise_item_id).css("color","red");
						$('#alert_div_'+Company_merchandise_item_id).html(msg1);
						setTimeout(function(){ $('#alert_div_'+Company_merchandise_item_id).hide(); }, 3000);
					}
				}
		});
	}	
	function add_to_wishlist(serial,name,price)
	{
		var input1 = $('#wishlist_count');
		input1.val(parseInt(input1.val()) + 1);
		setTimeout(function() 
		{
			$('#myModal').modal('show');	
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide');	
		},2000);
		
		$.ajax(
		{
			type: "POST",
			data: { id:serial, name:name, price:price },
			url: "<?php echo base_url()?>index.php/Shopping/add_to_wishlist",
			success: function(data)
			{
				if(data.cart_success_flag == 1)
				{	
					var msg1 = 'Product '+name+' is added to Wishlist';
					$('#alert_div_'+serial).show();
					$('#alert_div_'+serial).css("color","green");
					$('#alert_div_'+serial).html(msg1);
					setTimeout(function(){ $('#alert_div_'+serial).hide(); }, 3000);
				}
				else
				{
					var msg1 = 'Product '+name+' is added to Wishlist. Please try again!!';
					$('#alert_div_'+serial).show();
					$('#alert_div_'+serial).css("color","red");
					$('#alert_div_'+serial).html(msg1);
					setTimeout(function(){ $('#alert_div_'+serial).hide(); }, 3000);
				}
			}
		});
	}
</script>
<style>
	ul>li>a{
		margin: 30%;
		text-decoration: underline;
	}
	address 
	{
		
		padding: 0;
		border-radius: 50px;
		margin: 4% 2%;
		/* color: #ffffff; */
	}
	#txt 
	{
		border: none;
		padding: 1% 0 0 0;
		width: 56%;
		outline: none;
		background: none;
		margin-left: 16%;
		color: #ffffff;
		height: 29px;
	}
	.main-xs-6
	{
		width: 50%;
		padding: 10px 10px 0 10px;
	}
	#button5{		
		padding: 0 2%;
		border-radius: 2px;
		margin: 15% 3%;
		color:<?php echo $Button_font_details[0]['Button_font_color'];?>;
	}
</style>
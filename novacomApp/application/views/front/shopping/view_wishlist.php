<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
    <div id="application_theme" class="section pricing-section">
		<div class="container" >
			<div class="section-header">          
				<p><a href="<?php echo base_url(); ?>index.php/Shopping" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font">Wish List</p>
			</div>
			
			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;    min-height: 400px;">
										
<!-- Loader -->	
<div class="container" >
	<div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-sm" style="margin-top: 65%;">
		  <!-- Modal content-->
		  <div class="modal-content" id="loader_model">
				<div class="modal-body" style="padding: 10px 0px;;">
				  <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
				</div>							
		  </div>						  
		</div>
	</div>					  
</div>
<!-- Loader -->	
		<?php
		// print_r($wishlist);
		if($wishlist != NULL)
		{
			foreach ($wishlist as $item) 
			{									
				$Product_details = $this->Shopping_model->get_products_details($item['id']);		
				// echo"---Merchandize_item_name----".$Product_details->Merchandize_item_name."---<br>";
				
				$Branches = $Redemption_Items_branches[$Product_details->Company_merchandize_item_code];
				
				$Count_item_offer = $this->Shopping_model->get_count_item_offers($Product_details->Company_merchandise_item_id,$Product_details->Company_id);
				// var_dump($Count_item_offer);
				// echo"---Count_item_offer----".$Count_item_offer."---<br>";
			 
				$Get_Partner_details = $this->Igain_model->Get_Company_Partners_details($Product_details->Partner_id);
				$Partner_state=$Get_Partner_details->State;
				$Partner_Country=$Get_Partner_details->Country_id;
				if($Product_details->Size_flag == 1) 
				{ 
					$Get_item_price = $this->Redemption_Model->Get_item_details($Company_id,$Product_details->Company_merchandize_item_code);	
					$Billing_price = $Get_item_price->Billing_price;
					$Item_size=$Get_item_price->Item_size;
				} 
				else 
				{
					$Item_size="0";
					$Billing_price = $Product_details->Billing_price;
					
				}
				// echo "Item_size ".$Item_size;
				// print_r($Branches);
				foreach ($Branches as $Branches2){
					$DBranch_code=$Branches2['Branch_code'];
					$DBranch_id=$Branches2['Branch_id'];
				}
				?>	
				
				<input type="hidden" name="Delivery_<?php echo $Product_details->Company_merchandise_item_i; ?>" id="Delivery_<?php echo $Product_details->Company_merchandise_item_id; ?>" value="<?php echo $DBranch_code; ?>">	
				
				<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
					<div class="pricing-details">
						<div class="row">
							<div class="col-md-12">
								<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $Product_details->Company_merchandise_item_id; ?>"> 
								<div class="row">
									<div class="col-xs-4 b-items__item" style="padding: 10px;">
										<img src="<?php echo $Product_details->Thumbnail_image1; ?>" alt="" class="b-items__item__img" width="60"> 
									</div>											
									<div class="col-xs-8 text-left" style="width: 66%;">
										<address style="border:none;">
											<strong id="Medium_font"><?php echo $Product_details->Merchandize_item_name; ?></strong><br>
										</address>
										<span id="Small_font"><strong><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo $Billing_price; ?></strong></span>
										
										<!-- Offer -->
										<?php if($Count_item_offer >= 1 )
										{
											// echo"---Count_item_offer---".$Count_item_offer."<br>";
										?>
											
											<span>
												<a href="#" data-toggle="collapse" data-target="#<?php echo $Product_details->Company_merchandise_item_id; ?>">
													<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/item_offer.png" style="float:right; width:60px;">
												</a>
												<div id="<?php echo $Product_details->Company_merchandise_item_id; ?>" class="collapse">
												<?php
												
												// var_dump($Redemption_Items_offers);
												
												foreach($Redemption_Items_offers_array[$Product_details->Company_merchandise_item_id] as $prod)
												{			
													// echo"---Product_details---".$Product_details->Company_merchandise_item_id."<br>";																	
													if($Product_details->Offer_flag==1)
													{												
														$Offer_id=$prod['Offer_id'];
														$Buy_item=$prod['Buy_item'];
														$Free_item=$prod['Free_item'];
														$Free_item_id=$prod['Free_item_id'];
														// echo"---Offer_id---".$Offer_id."<br>";
														// echo"---Free_item_id---".$Free_item_id."<br>";
														$Offer_item_details= $this->Shopping_model->Get_Merchandize_Item_details($prod["Free_item_id"]);
														// echo"---Merchandize_item_name---".$Offer_item_details->Merchandize_item_name."<br>";
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
								<div class="row text-left">
									<div class="col-xs-4 main-xs-6">
										
										<button type="button" id="button" onclick="add_to_cart('<?php echo $Product_details->Company_merchandise_item_id; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$Product_details->Merchandize_item_name); ?>','<?php echo $Billing_price; ?>',29,29,<?php echo $Product_details->Company_merchandise_item_id; ?>,'<?php echo $Item_size; ?>',<?php echo $Product_details->Item_Weight; ?>,<?php echo $Product_details->Weight_unit_id; ?>,<?php echo $Product_details->Partner_id; ?>,'<?php echo $Partner_state; ?>','<?php echo $Partner_Country; ?>',<?php echo $Product_details->Seller_id; ?>,<?php echo $Product_details->Merchant_flag; ?>,'<?php echo $Product_details->Cost_price; ?>','<?php echo $Product_details->VAT; ?>'); move_to_cart('<?php echo $item['rowid']; ?>');"  >
										<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/cart.png" alt="" class="img-rounded img-responsive" width="15"> Move to cart
										</button>
										
										<a href="<?php echo base_url()?>index.php/Shopping/remove_wishlist/?rowid=<?php echo $item['rowid']; ?>" title="Remove" data-toggle="tooltip" data-placement="top" id="Small_font">
											 <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/remove.png" alt="" class="img-rounded img-responsive" width="20">Remove
										</a>
									</div>
									
									<!--<div class="col-xs-4 main-xs-6" >
										
										
										<button type="button" id="button" onclick="window.location.href='<?php echo base_url()?>index.php/Shopping/remove_wishlist/?rowid=<?php echo $item['rowid']; ?>'"  style="margin-left: 11%;width: 75%;" >
										<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/cart.png" alt="" class="img-rounded img-responsive" width="15"> Remove
										</button>
										
										
										<a href="<?php echo base_url()?>index.php/Shopping/remove_wishlist/?rowid=<?php echo $item['rowid']; ?>" title="Remove" id="button" data-toggle="tooltip" data-placement="top">
											 <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/remove.png" alt="" class="img-rounded img-responsive" width="20">Remove
										</a>
									
									</div>-->
								</div>							
							</div>
						</div>
					</div>
				</div>					
			<?php 
			}
		}
		else
		{ ?>
			<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
				<div class="row">
															
					<div class="col-xs-8 text-left" style="width: 100%;">
						<address style="text-align:center;border:none;">
							<strong id="Medium_font">No Item Found</strong><br>
						</address>									
						<!-- Offer -->
						<!-- Offer -->
					</div>
				</div>
			</div>
		<?php
		}
			?>	
				<?php /* if(!empty($pagination)) { ?>
					<div class="col-md-4 col-sm-6 col-xs-12 pricing-table wow fadeInUp" id="front_head">
						<?php echo $pagination; ?>
					</div>
					
				<?php
				} */
			?>
			</div>	
		</div>
	</div>				
</div>	
<?php $this->load->view('front/header/footer');?> 	
<script>	
	function add_to_cart(serial,name,price,Redemption_method,Branch,Company_merchandise_item_id,Item_size,Item_Weight,Weight_unit_id,Partner_id,Partner_state,Partner_Country_id,Seller_id,Merchant_flag,Cost_price,VAT,Company_merchandize_item_code,Item_image1)
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
			data: { id:serial, name:name, price:price, Delivery_method:29, Branch:Branch ,Item_size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id,Partner_id:Partner_id,Partner_state:Partner_state,Partner_Country_id:Partner_Country_id,Seller_id:Seller_id,Merchant_flag:Merchant_flag,Cost_price:Cost_price,VAT:VAT,Company_merchandize_item_code:Company_merchandize_item_code,Item_image1:Item_image1},
			url: "<?php echo base_url()?>index.php/Shopping/add_to_cart",
			success: function(data)
			{
				// alert(data);
				if(data.cart_success_flag == 1)
				{

						// ShowPopup('Product '+name+' is added to Cart Successfuly..!!');				
						// $('.shoppingCart_total').html('$'+data.cart_total);
						// location.reload(true);
				}
				else
				{
						// ShowPopup('Error adding Product '+name+' to Cart. Please try again..!!');
						// $('.shoppingCart_total').html('$'+data.cart_total);				
						// location.reload(true);
				}
			}
		});
	}
	function move_to_cart(rowid)
	{	
		setTimeout(function() 
		{
			$('#myModal').modal('show');	
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide');	
		},2000);
		
		$.ajax({
			type: "POST",
			data: {rowid:rowid },
			url: "<?php echo base_url()?>index.php/Shopping/move_to_cart",
			success: function(data)
			{
				if(data.cart_success_flag == 1)
				{
					// ShowPopup('Product '+name+' is Moved to Cart..!!');				
					$('.shoppingCart_total').html('$'+data.cart_total);
					location.reload(true);
				}
				else
				{
					// ShowPopup('Error Moving Product '+name+' to Cart. Please try again..!!');
					$('.shoppingCart_total').html('$'+data.cart_total);				
					location.reload(true);
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
		border: 1px solid #ffffff;
		padding: 0;
		border-radius: 50px;
		margin: 4% 2%;
		/* color: #ffffff; */
	}
	#txt 
	{
		border: none;
		padding: 1% 0 0 0;
		width: 75%;
		outline: none;
		background: none;
		margin-left: 16%;
		color: #ffffff;
		height: 35px;
	}
	.main-xs-6
	{
		width: 100%;
		padding: 10px 10px 0 10px;
	}
</style>
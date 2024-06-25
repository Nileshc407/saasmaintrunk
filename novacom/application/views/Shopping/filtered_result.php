<?php
$wishlist = $this->wishlist->get_content();
$ci_object = &get_instance();
$ci_object->load->model('Redemption_Model');
$ci_object->load->model('Igain_model');
$Wishlist_item = array();
if( !empty($wishlist) )
{
    foreach ($wishlist as $item) 
    {
        $Wishlist_item[$item['id']] = $item['id'];
    }
}
	if($Filter_result != NULL)
	{
		foreach ($Filter_result as $product)
		{ ?>
			<div class="col-md-3">
				<?php 
					$ci_object = &get_instance();
					$ci_object->load->model('shopping/Shopping_model');
					$Count_item_offer = $ci_object->Shopping_model->get_count_item_offers($product["Company_merchandise_item_id"],$product['Company_id']);
					// echo"---Company_merchandise_item_id---".$product["Company_merchandise_item_id"]."<br>";
					// echo"---Count_item_offer---".$Count_item_offer."<br>";
				if($Count_item_offer >= 1 )
				{
				?>
					<img src="<?php echo $this->config->item('base_url2')?>images/special-offers1.png" style="height:70px;margin-bottom:-22px;z-index: 1;margin-top: -57px;">
				<?php 
				}
				else
				{ ?>
					<br>
				<?php 
				}
				?>
				<div class="product">
					<div class="small-box bg-aqua" style="z-index: 0; background-color: #fab900 ! important;"">
						<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $product['Company_merchandise_item_id']; ?>" class="cd-trigger small-box-footer" >
							<i class="fa fa-eye"></i> Quick Details
						</a>
					</div>
					
					<?php 								
					if($Count_item_offer >= 1 )
					{
						// echo"---Count_item_offer---".$Count_item_offer."<br>";
					?>	
						<div class="popover__wrapper">								  
								<h2 class="popover__title">Click for Offer</h2>								  
							<div class="push popover__content">	
								<?php
								foreach($Redemption_Items_offers_array[$product['Company_merchandise_item_id']] as $prod)
								{											
									if($product['Offer_flag']==1)
									{												
										$Offer_id=$prod['Offer_id'];
										$Buy_item=$prod['Buy_item'];
										$Free_item=$prod['Free_item'];
										$Free_item_id=$prod['Free_item_id'];
										// echo"---Offer_id---".$Offer_id."<br>";
										// echo"---Free_item_id---".$Free_item_id."<br>";
										$Offer_item_details= $ci_object->Shopping_model->Get_Merchandize_Item_details($prod["Free_item_id"]);
										// echo"---Merchandize_item_name---".$Offer_item_details->Merchandize_item_name."<br>";
										if($Buy_item!= "" && $Buy_item != '0' && $Free_item != "" && $Free_item != '0' ) 
										{ 
											?>
											<p class="popover__message"> <i class="fa fa-gift" aria-hidden="true"></i> Buy <b><?php echo $Buy_item ?></b> Get <b><?php echo $Free_item ?></b> <?php echo $Offer_item_details->Merchandize_item_name; ?>
											</p>
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
						</div>
						<style>
							.popover__title {
						  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
						  font-size: 17px;
						  line-height: 36px;
						  text-decoration: none;
						  color: rgb(228, 68, 68);
						  text-align: center;
						}

						.popover__wrapper {
							position: relative;
							margin-top: -30px;
							display: inline-block;
						}
						.popover__content {
							opacity: 0;
							visibility: hidden;
							position: absolute;
							left: -47px;
							transform: translate(0,10px);
							background-color: #00add7;
							color: #fff;
							padding: 1.5rem;
							box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.26);
							width: 200px;
						}
						.popover__content:before {
							position: absolute;
							z-index: -1;
							content: '';
							right: calc(50% - 10px);
							top: -8px;
							border-style: solid;
							border-width: 0 10px 10px 10px;
							border-color: transparent transparent #BFBFBF transparent;
							transition-duration: 0.3s;
							transition-property: transform;
						}
						.popover__wrapper:hover .popover__content {
							z-index: 10;
							opacity: 1;
							visibility: visible;
							transform: translate(0,-20px);
							transition: all 0.5s cubic-bezier(0.75, -0.02, 0.2, 0.97);
						}
						.popover__message {
						  text-align: center;
						}
						</style>
													
					<?php 								
					}
					?>	
					<?php  /*
					<div class="image" id="Source_img_<?php echo $product["Company_merchandise_item_id"]; ?>">
						<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $product['Company_merchandise_item_id']; ?>">
							<img src="<?php echo $product['Thumbnail_image1']; ?>" alt=""  style="height:200px;" alt="Item Preview">
						</a>
					</div>
					*/ ?>
					<div class="text">
						<h5 style="min-height: 35px;"><a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $product['Company_merchandise_item_id']; ?>"><?php echo $product['Merchandize_item_name']; ?></a></h5>
						<p class="price">Price - <b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo $product['Billing_price']; ?></p>
						
						<?php
							// echo"Merchat_id---".$product['Seller_id']."<br/>";
							// echo "Category_id----".$product['Merchandize_category_id']; 
						?>
					
						<?php 
							$Get_Partner_details = $ci_object->Igain_model->Get_Company_Partners_details($product["Partner_id"]);
							$Partner_state=$Get_Partner_details->State;
							$Partner_Country=$Get_Partner_details->Country_id;
							
							if($product['Size_flag'] == 1) 
							{ 
								$Get_item_price = $ci_object->Redemption_Model->Get_item_details($Company_id,$product['Company_merchandize_item_code']);	
								$Billing_price = $Get_item_price->Billing_price;
								$Item_size=$Get_item_price->Item_size;
							
							} 
							else 
							{
								$Item_size="0";
								$Billing_price = $product['Billing_price'];
								
							}
							foreach ($Branches as $Branches2){
										$DBranch_code=$Branches2['Branch_code'];
										$DBranch_id=$Branches2['Branch_id'];
							} ?>
							
							<input type="hidden" name="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" id="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" value="<?php echo $DBranch_code; ?>">	
									
						<div class="text">
							<p class="text-center"> 
								<!--								
								<button type="button" class="btn btn-template-main" onclick="add_to_cart('<?php //echo $product["Company_merchandise_item_id"]; ?>','<?php //echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$product["Merchandize_item_name"]); ?>','<?php //echo $product["Billing_price"]; ?>');" style="width: 70%;padding: 6px 2px;">
									<i class="fa fa-shopping-cart"></i> Add to cart
								</button> -->
								
								<button type="button" class="btn btn-template-main" onclick="add_to_cart('<?php echo $product["Company_merchandise_item_id"]; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$product["Merchandize_item_name"]); ?>','<?php echo $Billing_price; ?>',29,29,<?php echo $product['Company_merchandise_item_id']; ?>,'<?php echo $Item_size; ?>',<?php echo $product['Item_Weight']; ?>,<?php echo $product['Weight_unit_id']; ?>,<?php echo $product['Partner_id']; ?>,'<?php echo $Partner_state; ?>','<?php echo $Partner_Country; ?>',<?php echo $product['Seller_id']; ?>,<?php echo $product['Merchant_flag']; ?>,'<?php echo $product['Cost_price']; ?>','<?php echo $product['VAT']; ?>','<?php echo $product['Merchandize_category_id']; ?>');" style="width: 70%;padding: 6px 2px;">
								<i class="fa fa-shopping-cart"></i> Add to cart
								</button>

								<?php
								$Style = "";										
								if (array_key_exists($product['Company_merchandise_item_id'], $Wishlist_item))
								{
									if( $Wishlist_item[$product['Company_merchandise_item_id']] == $product['Company_merchandise_item_id'])
									{
										$Style = "style='background: #38a7bb none repeat scroll 0 0;border-color: #38a7bb;color: #ffffff;padding: 8.7px 5px;'";
								?>	

										<button type="button" class="btn btn-template-main" <?php echo $Style; ?> data-toggle="tooltip" data-placement="top" title="Already Added to wishlist">
											<i class="fa fa-heart-o"></i>
										</button>

								<?php 
									}
								}
								else
								{
								?>
<?php /*
									<button type="button" class="btn btn-template-main" onclick="add_to_wishlist('<?php echo $product["Company_merchandise_item_id"]; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$product["Merchandize_item_name"]); ?>','<?php echo $product["Billing_price"]; ?>');" data-toggle="tooltip" data-placement="top" title="Add to wishlist" style="padding: 8.7px 5px;">
										<i class="fa fa-heart-o"></i>
									</button>  */ ?>

								<?php
								}
								?>
							</p>
						</div>
					 </div>
				</div>
			</div>        
	<?php
		}
	}
?>

<script>
$('.cd-trigger').on('click', function(event)
{
    var Company_merchandise_item_id = $('#TriggerItem').val();    
    $.ajax(
    {
        type: "POST",
        data: { Company_merchandise_item_id:Company_merchandise_item_id },
        url: "<?php echo base_url()?>index.php/Shopping/Get_itemDetails",
        success: function(data)
        {
            $('body').attr('class','skin-blue sidebar-mini overlay-layer');
            $('#Quick_image').html('<li class="selected"><img src="'+data.Item_image1+'"></li>');   /*<li><img src="'+data.Item_image2+'"></li><li><img src="'+data.Item_image3+'"></li><li><img src="'+data.Item_image4+'"></li>*/
            $('#Quick_name').html(data.Merchandize_item_name);
            $('#Quick_desc').html(data.Merchandise_item_description);
            
            $("#Popup_addcart").attr("onclick","add_to_cart("+Company_merchandise_item_id+",'"+data.Merchandize_item_name+"','"+data.Billing_price+"');");
            $("#Popup_wishlist").attr("onclick","add_to_wishlist("+Company_merchandise_item_id+",'"+data.Merchandize_item_name+"','"+data.Billing_price+"');");
            
            var image = $('#Source_img_'+Company_merchandise_item_id).find('img');            
            var finalWidth = 400;   var maxQuickWidth = 750;            
            animateQuickView(image, finalWidth, maxQuickWidth, 'open');
        }
    });
});

function add_to_cart(serial,name,price,Redemption_method,Branch,Company_merchandise_item_id,Item_size,Item_Weight,Weight_unit_id,Partner_id,Partner_state,Partner_Country_id,Seller_id,Merchant_flag,Cost_price,VAT,Product_category_id) 
{	 
	 show_loader();
	
		Branch=document.getElementById("Delivery_"+Company_merchandise_item_id).value;
		
	$.ajax(
        {
            type: "POST",
            data: { id:serial, name:name, price:price, Delivery_method:29, Branch:Branch ,Item_size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id,Partner_id:Partner_id,Partner_state:Partner_state,Partner_Country_id:Partner_Country_id,Seller_id:Seller_id,Merchant_flag:Merchant_flag,Cost_price:Cost_price,VAT:VAT,Product_category_id:Product_category_id},
            url: "<?php echo base_url()?>index.php/Shopping/add_to_cart",
            success: function(data)
            {
				if(data.cart_success_flag == 1)
				{
					ShowPopup('Product '+name+' is added to Cart Successfuly..!!');				
					$('.shoppingCart_total').html('$'+data.cart_total);
					location.reload(true);
				}
				else
				{
					ShowPopup('Error adding Product '+name+' to Cart. Please try again..!!');
					$('.shoppingCart_total').html('$'+data.cart_total);				
					location.reload(true);
				}
            }
	});
}
</script>
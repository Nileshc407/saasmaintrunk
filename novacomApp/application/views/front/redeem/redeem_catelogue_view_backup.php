<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $title?></title>	
    <?php $this->load->view('front/header/header'); ?> 	
</head>
<body>
    <?php 
        //print_r($Redeemtion_details2);
        $item_count=0;
        foreach($Redeemtion_details2 as $item)
        {
            
            $item_count=$item_count+$item["Total_points"]; 
        }
        
        if($item_count <= 0 ) {
                $item_count=0;
        }
        else {
                $item_count = $item_count;
        }						
       
    ?> 
    <div id="application_theme" class="section pricing-section" style="min-height: 550px;">
        <div class="container" >
            <div class="section-header">          
                <p><a href="<?php echo base_url(); ?>" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                <p style="font-size: 17px; margin-left: -3%;">Redemption Catalogue</p>
            </div>
			
            <div class="row pricing-tables">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px; ">
                    <!-- Loader -->	
                    <div class="container" >
                            <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog modal-sm" style="margin-top: 65%;">
                                      <!-- Modal content-->
                                      <div class="modal-content" id="loader_model">
                                            <div class="modal-body" style="padding: 10px 0px;;">
                                              <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
                                            </div>							
                                      </div>						  
                                    </div>
                            </div>					  
                    </div>
                    <!-- Loader -->	
                    <?php
                    //print_r($Redemption_Items);                                        
                    if($Redemption_Items != NULL) {
                        foreach ($Redemption_Items as $product){			
                            // echo"---Merchandize_item_name----".$product['Merchandize_item_name']."---<br>";
                            $Branches = $Redemption_Items_branches[$product['Company_merchandize_item_code']];							
                            foreach ($Branches as $Branches2){
                                $DBranch_code=$Branches2['Branch_code'];
                            }						 
                            if($product['Size_flag'] == 1) 
                            { 
                                $Get_item_price = $this->Redemption_Model->Get_item_details($Company_id,$product['Company_merchandize_item_code']);	
                                $Billing_price_in_points = $Get_item_price->Billing_price_in_points;
                                $price_item=$Get_item_price->Billing_price_in_points;
                                $Item_size=$Get_item_price->Item_size;
                            } 
                            else 
                            {
                                $Item_size="0";
                                $price_item=$Billing_price_in_points = $product['Billing_price_in_points'];
                                $product['Billing_price_in_points'];
                            }
                            ?>	
                    
                           
                                <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
                                    <div class="pricing-details">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row ">
                                                        <div class="col-xs-4 b-items__item" style="padding: 10px;">
                                                                <img src="<?php echo $product['Thumbnail_image1']; ?>" alt="" class="b-items__item__img" width="80">
                                                        </div>											
                                                        <div class="col-xs-8 text-left" style="width: 64%;">
                                                               
                                                                <strong id="Medium_font"><?php echo $product['Merchandize_item_name']; ?></strong><br>                                                        
                                                                 <strong id="Small_font"><?php echo $price_item; ?></strong><br> 
                                                                        
                                                        </div>
                                                </div>
                                                <div class="row">
                                                     <?php  if($product['Delivery_method']==0) { ?>
                                                        <div class="col-xs-3 main-xs-3">                                                       	
                                                            <input type="radio" name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" value="28" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,1);">
                                                            <span>
                                                                 <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/pick-up.png" alt="" class="img-rounded img-responsive" width="15">
                                                                <br><span class="card-span" id="Small_font">Pick-up</span>
                                                            </span>
                                                            <div  style="display:none;    width: 100px;" id="<?php echo $product['Company_merchandise_item_id']; ?>">
                                                                <br><span class="card-span" id="Small_font">Partner Location</span>
                                                                <select  name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" required>
                                                                        <option value=""><?php echo ('Select'); ?></option>
                                                                        <?php foreach ($Branches as $Branches3){?>
                                                                        <option value="<?php echo $Branches3['Branch_code']; ?>"><?php echo $Branches3['Branch_name']; ?></option>
                                                                        <?php } ?>
                                                                </select>							
                                                            </div>
                                                        </div>											
                                                        <div class="col-xs-3 main-xs-3">
                                                            <input type="radio" value="29"  name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,0);" checked>
                                                            <span>
                                                                 <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/delivery.png" alt="" class="img-rounded img-responsive" width="15">
                                                                <br><span class="card-span" id="Small_font" >Delivery</span>
                                                            </span>
                                                        </div>
                                                    <?php } elseif($product['Delivery_method']==28) { ?>
                                                    
                                                            <div class="col-xs-3 main-xs-3">                                                       	
                                                                <input type="radio" name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" value="28" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,1);">
                                                                <span>
                                                                     <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/pick-up.png" alt="" class="img-rounded img-responsive" width="15">
                                                                    <br><span class="card-span" id="Small_font">Pick-up</span>
                                                                </span>
                                                                <div  style="display:none;    width: 100px;" id="<?php echo $product['Company_merchandise_item_id']; ?>">
                                                                    <br><span class="card-span" id="Small_font">Partner Location</span>

                                                                    <select  name="location_<?php echo $product['Company_merchandise_item_id']; ?>" id="location_<?php echo $product['Company_merchandise_item_id']; ?>" required>
                                                                            <option value=""><?php echo ('Select'); ?></option>
                                                                            <?php foreach ($Branches as $Branches3){?>
                                                                            <option value="<?php echo $Branches3['Branch_code']; ?>"><?php echo $Branches3['Branch_name']; ?></option>
                                                                            <?php } ?>
                                                                    </select>							
                                                                </div>
                                                             </div>
                                                    <?php } else { ?>
                                                        <div class="col-xs-3 main-xs-3">
                                                            <input type="radio" value="29"  name="Delivery_method_<?php echo $product['Company_merchandise_item_id']; ?>" onclick="Show_branch(<?php echo $product['Company_merchandise_item_id']; ?>,0);" checked>
                                                            <span>
                                                               <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/delivery.png" alt="" class="img-rounded img-responsive" width="15">
                                                                <br><span class="card-span" id="Small_font" >Delivery</span>
                                                            </span>
                                                        </div>
                                                    
                                                    <?php } ?>
                                                    <div class="col-xs-6 text-right" style="width: 45%;">
                                                        <span id="button" class="b-items__item__add-to-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to cart</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php /* ?>
                            <input type="hidden" name="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" id="Delivery_<?php echo $product['Company_merchandise_item_id']; ?>" value="<?php echo $DBranch_code; ?>">	
                            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
                                <div class="pricing-details">
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
                                                        <span id="Small_font"><strong></b>&nbsp;<?php echo $Billing_price_in_points; ?></strong></span>
                                                </div>
                                            </div>
                                            </a>
                                            <div class="row">
                                                <div class="col-xs-4 main-xs-6">
                                                         <!--<span id="button" class="b-items__item__add-to-cart"><i class="fa fa-heart" aria-hidden="true"></i> Add to wishlist</span>-->
                                                         <button type="button" id="button" class="b-items__item__add-to-cart" onclick="add_to_wishlist('<?php echo $product["Company_merchandise_item_id"]; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$product["Merchandize_item_name"]); ?>','<?php echo $Billing_price_in_points; ?>');"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/wishlist.png" alt="" class="img-rounded img-responsive" width="15" style="margin-top: -4px;"> Wish List</button>
                                                </div>
                                                <div class="col-xs-4 main-xs-6">
                                                         <!--<span id="button" class="b-items__item__add-to-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to cart</span>-->
                                                         <button type="button" id="button" class="b-items__item__add-to-cart" onclick="add_to_cart('<?php echo $product["Company_merchandise_item_id"]; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$product["Merchandize_item_name"]); ?>','<?php echo $Billing_price_in_points; ?>',29,29,<?php echo $product['Company_merchandise_item_id']; ?>,'<?php echo $Item_size; ?>',<?php echo $product['Item_Weight']; ?>,<?php echo $product['Weight_unit_id']; ?>,<?php echo $product['Partner_id']; ?>,<?php echo $product['Seller_id']; ?>,<?php echo $product['Merchant_flag']; ?>,'<?php echo $product['Cost_price']; ?>','<?php echo $product['VAT']; ?>','<?php echo $product['Company_merchandize_item_code']; ?>','<?php echo $product['Thumbnail_image1']; ?>');"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cart.png" alt="" class="img-rounded img-responsive" width="15" style="margin-top: -4px;"> Cart</button>
                                                </div>
                                            </div>																					
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php */ ?>
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
                </div>
            </div>
        </div>	
    </div>
					
    	
	
		
	<?php $this->load->view('front/header/footer');?> 
	<script>
            
            function Show_branch(Company_merchandise_item_id,flag)
            {
                    if(flag==1)
                    {
                            document.getElementById(Company_merchandise_item_id).style.display="";
                    }
                    else
                    {
                            document.getElementById(Company_merchandise_item_id).style.display="none";
                    }

            }
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
	
	function add_to_wishlist(serial,name,price)
	{
		// alert('---serial---'+serial+'---name---'+name+'---price---'+price);
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
					// alert(data.cart_success_flag);
						if(data.cart_success_flag == 1)
						{
								// ShowPopup('Product '+name+' is added to Wishlist..!!');				
								// $('.shoppingCart_total').html('$'+data.cart_total);
								// location.reload(true);
						}
						else
						{
								// ShowPopup('Error adding Product '+name+' to Wishlist. Please try again..!!');
								// $('.shoppingCart_total').html('$'+data.cart_total);				
								// location.reload(true);
						}
				}
		});
	}
	</script>
	<style>
            
        .main-xs-3
	{
		width: 27%;
		padding: 0 0 0 10px;
	}
	ul>li>a{
		margin: 30%;
		text-decoration: underline;
	}
	
	
	#icon
	{
		width: 3%;
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
                /* width: 50%;*/
		padding: 10px 10px 0 10px;
	}
	

	</style>
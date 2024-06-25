<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Item Description</title>
	<?php $this->load->view('front/header/header'); 
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?>

<?php /*  ?>
<script src="<?php echo $this->config->item('base_url2')?>js_slider/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo $this->config->item('base_url2')?>css_slider/etalage.css">
<script src="<?php echo $this->config->item('base_url2')?>js_slider/jquery.etalage.min.js"></script>

<?php */  ?>
 <script src="<?php echo base_url();?>assets/js/jquery-min.js"></script>
<script>
jQuery(document).ready(function($){
	$('#etalage').etalage({
		thumb_image_width: 250,
		thumb_image_height: 350,
		source_image_width: 900,
		source_image_height: 900,
		show_hint: true,
		click_callback: function(image_anchor, instance_id){
			alert('Callback example:\nYou clicked on an image with the anchor: "'+image_anchor+'"\n(in Etalage instance: "'+instance_id+'")');
		}
	}); 
});
</script>

<style>
* {box-sizing: border-box;}
body {font-family: Verdana, sans-serif;}
.mySlides {display: none;}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Caption text */
.text {
  color: #f2f2f2;
  font-size: 15px;
  padding: 8px 12px;
  position: absolute;
  bottom: 8px;
  width: 100%;
  text-align: center;
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* The dots/bullets/indicators */
.dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
</style>
</head>
<body> 
   <?php 
        $Count_item_offer = $this->Shopping_model->get_count_item_offers($Product_details->Company_merchandise_item_id,$Product_details->Company_id);
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
        } else {
                $item_count = $item_count;
        }
        if($Ecommerce_flag==1)
        {
                $wishlist = $this->wishlist->get_content();
                if(!empty($wishlist)) {

                        $wishlist = $this->wishlist->get_content();
                        $item_count2 = COUNT($wishlist); 
                } 
        }
        if($item_count2 <= 0 ) {
                $item_count2=0;
        } else {
                $item_count2 = $item_count2;
        }

        ?>
           	
    <div id="application_theme" class="section pricing-section">
		<div class="container">
			<div class="section-header">          
				<p><a href="<?php echo base_url(); ?>index.php/Shopping" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                <p id="Extra_large_font">Item Details</p>
			</div>
			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">	<!-- 1st Card -->
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
						<div class="pricing-details">
							<div class="row">
								<div class="col-md-12">
								
									<div class="slideshow-container">

										<div class="mySlides fade">
										  <img src="<?php echo $Product_details->Item_image1; ?>" style="width:20%;">
										</div>
										<div class="mySlides fade">
										  <img src="<?php echo $Product_details->Item_image2; ?>" style="width:20%;">
										</div>
										<div class="mySlides fade">
										  <img src="<?php echo $Product_details->Item_image3; ?>" style="width:20%;">
										</div>

									</div>
									<br>

										<div style="text-align:center">
										  <span class="dot"></span> 
										  <span class="dot"></span> 
										  <span class="dot"></span> 
										</div>
								</div>
							</div>
						</div>
					</div>
					
					<br>
					<!-- 2nd Card -->
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
                <div class="pricing-details">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row ">
                                <div class="col-xs-12 " style="width: 100%;">
                                    <address>
                                        <div>
                                                <?php 
                                                        $Get_item_price1 = $this->Redemption_Model->Get_item_details1($Company_id,$Product_details->Company_merchandize_item_code);

                                                        foreach($Get_item_price1 as $Item_pricesz)
                                                        {
                                                                // echo $Item_pricesz->Billing_price;	
                                                                if($Item_pricesz->Item_size == 1)
                                                                {
                                                                        $Size = "S";
                                                                        $Small=1;
                                                                }
                                                                elseif($Item_pricesz->Item_size == 2)
                                                                {
                                                                        $Size = "M";
                                                                        $Medium=2;
                                                                }
                                                                elseif($Item_pricesz->Item_size == 3)
                                                                {
                                                                        $Size="L";
                                                                        $Large=3;
                                                                }
                                                                elseif($Item_pricesz->Item_size == 4)
                                                                {
                                                                        $Size="XL";
                                                                        $ExtraLarge=4;
                                                                }
                                                        } 

                                                        $Get_Partner_details = $this->Igain_model->Get_Company_Partners_details($Product_details->Partner_id);
                                                        $Partner_state=$Get_Partner_details->State;
                                                        $Partner_Country=$Get_Partner_details->Country_id;

                                                        /* echo"---Item_size------".$Item_pricesz->Item_size."<br>";
                                                        echo"---Item_Weight------".$Product_details->Item_Weight."<br>";
                                                        echo"---Company_merchandise_item_id------".$Product_details->Company_merchandise_item_id."<br>";
                                                        echo"---Merchandize_item_name------".$Product_details->Merchandize_item_name."<br>";
                                                        echo"---Billing_price------".$Product_details->Billing_price."<br>";
                                                        echo"---Weight_unit_id------".$Product_details->Weight_unit_id."<br>";
                                                        echo"---Partner_id------".$Product_details->Partner_id."<br>";
                                                        echo"---Partner_state------".$Partner_state."<br>";
                                                        echo"---Partner_Country------".$Partner_Country."<br>";
                                                        echo"---Seller_id------".$Product_details->Seller_id."<br>";
                                                        echo"---Merchant_flag------".$Product_details->Merchant_flag."<br>";
                                                        echo"---Cost_price------".$Product_details->Cost_price."<br>";
                                                        echo"---VAT------".$Product_details->VAT."<br>"; */

                                                        ?>																
                                                <!--<a href="#"><span id="button">Wishlist <i class="fa fa-heart X" aria-hidden="true"></i> </span></a>-->
												
												<?php
													/* echo"<br>---Combo_meal_flag----".$Product_details->Combo_meal_flag; */				
													if($Product_details->Combo_meal_flag ==1 ) {
														
														$MerchandizeIteName = explode('+', $Product_details->Merchandize_item_name);
														$itemName= $MerchandizeIteName[0];
													} else {
														
														$itemName= $Product_details->Merchandize_item_name;
													}
												?>
                                                 <font id="Large_font"><?php echo $itemName; ?></font><br>
                                                <font id="Small_font">Price :</font> <font id="Value_font"><?php echo $Symbol_of_currency; ?></font>&nbsp;<b id="Value_font" ><b id="size_points" ><?php echo $Product_details->Billing_price; ?></b> <br><br>
                                                <div id="alert_div_<?php echo $Product_details->Company_merchandise_item_id;?>" style="margin: 0 auto;"></div>
                                                   <?php /* ?> <button type="button" id="button"  onclick="add_to_wishlist('<?php echo $Product_details->Company_merchandise_item_id; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$Product_details->Merchandize_item_name); ?>','<?php echo $Product_details->Billing_price; ?>');" ><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/wishlist.png" alt="" class="img-rounded img-responsive" width="15" style="margin-top: -4px;"> Wish List</button>
													<?php */ ?>

                                                <button type="button" id="button" class="b-items__item__add-to-cart" onclick="add_to_cart('<?php echo $Product_details->Company_merchandise_item_id; ?>','<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s','',$Product_details->Merchandize_item_name); ?>','<?php echo $Product_details->Billing_price; ?>',29,29,<?php echo $Product_details->Company_merchandise_item_id; ?>,'<?php echo $Item_pricesz->Item_size; ?>',<?php echo $Product_details->Item_Weight; ?>,<?php echo $Product_details->Weight_unit_id; ?>,<?php echo $Product_details->Partner_id; ?>,'<?php echo $Partner_state; ?>','<?php echo $Partner_Country; ?>',<?php echo $Product_details->Seller_id; ?>,<?php echo $Product_details->Merchant_flag; ?>,'<?php echo $Product_details->Cost_price; ?>','<?php echo $Product_details->VAT; ?>','<?php echo $Product_details->Merchandize_category_id; ?>','<?php echo $Product_details->Merchandize_item_name; ?>','<?php echo $Product_details->Company_merchandize_item_code; ?>');"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/cart.png" alt="" class="img-rounded img-responsive" width="15" style="margin-top: -4px;"> Add to Cart</button>
                                                <?php 
													
                                                if($Count_item_offer >= 1 )
                                                {
                                                ?>
                                                    <a href="#" data-toggle="collapse" data-target="#<?php echo $Product_details->Company_merchandise_item_id; ?>"><span id="button"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/offer_tag.png" alt="" class="img-rounded img-responsive" width="15" style="margin-top: -4px;"> Offers  </span></a>
                                                <?php } ?>
                                        </div>
                                            <?php 								
                                            if($Count_item_offer >= 1 )
                                            {
                                            ?>
                                            <div id="<?php echo $Product_details->Company_merchandise_item_id; ?>" class="collapse">
                                            <?php
                                                if($Product_details->Offer_flag==1)
                                                {
                                                    foreach($Product_offers as $offers)
                                                    {
                                                        $Offer_item_details= $this->Shopping_model->Get_Merchandize_Item_details($offers["Free_item_id"]);?>
                                                        <div id="Value_font" style="margin-left:19px;"> <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/offer.png" style="width:15px;"> Buy <?php echo $offers['Buy_item'];?> Get <?php echo $offers['Free_item'] ?>  <?php echo $Offer_item_details->Merchandize_item_name; ?> free
                                                                    </div>

                                                        <?php 								
                                                    }
                                                }
                                            ?>
                                            </div>
                                            <?php } ?>
                                        
                                        
                                    </address>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
					
            <br>
            <!-- 3rd Card -->
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
                <div class="pricing-details">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row ">																				
                                <div class="col-xs-8 text-left" id="desc1">											
                                    <strong id="Medium_font" >Item Description :</strong><br>										
                                    <span id="Value_font"><?php echo $Product_details->Merchandise_item_description; ?></span><br>
                                </div>
                            </div>																											
                        </div>
                    </div>
                </div>
            </div>
					<?php
                                    $Small=0;
                                    $Medium=0;
                                    $Large=0;
                                    $ExtraLarge=0;
                                    $Get_Partner_details = $this->Igain_model->Get_Company_Partners_details($Product_details->Partner_id);
                                    $Partner_state=$Get_Partner_details->State;
                                    $Partner_Country=$Get_Partner_details->Country_id;

                                    $Branch_code = $this->Igain_model->get_partner_branch($Company_id,$Product_details->Company_merchandize_item_code);	
                                    $DBranch_code=$Branch_code->Branch_code;
                                ?>
					  <input type="hidden" name="Delivery_<?php echo $Product_details->Company_merchandise_item_id; ?>" id="Delivery_<?php echo $Product_details->Company_merchandise_item_id; ?>" value="<?php echo $DBranch_code; ?>">
            <br>
            <!-- 4th Card -->
			<?php  /* ?>
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
                <div class="pricing-details">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row ">	
                                <?php
                                    $Small=0;
                                    $Medium=0;
                                    $Large=0;
                                    $ExtraLarge=0;
                                    $Get_Partner_details = $this->Igain_model->Get_Company_Partners_details($Product_details->Partner_id);
                                    $Partner_state=$Get_Partner_details->State;
                                    $Partner_Country=$Get_Partner_details->Country_id;

                                    $Branch_code = $this->Igain_model->get_partner_branch($Company_id,$Product_details->Company_merchandize_item_code);	
                                    $DBranch_code=$Branch_code->Branch_code;
                                ?>

                                                        <input type="hidden" name="Delivery_<?php echo $Product_details->Company_merchandise_item_id; ?>" id="Delivery_<?php echo $Product_details->Company_merchandise_item_id; ?>" value="<?php echo $DBranch_code; ?>">

                                                                    <div class="col-xs-8 text-left" id="desc1">	
                                                                            <strong id="Medium_font">Product Specification </strong><br>	
                                                                    </div>										
                                                                    <?php 
                                                                    // echo"----Colour_flag----->".$Product_details->Colour_flag ."<br>";
                                                                    if($Product_details->Brand_flag ==0 || $Product_details->Colour_flag ==0 || $Product_details->Weight_flag ==0 || $Product_details->Dimension_flag ==0 || $Product_details->Manufacturer_flag ==0) 
                                                                    { 
                                                                    ?>
                                                                            <div class="col-xs-8 text-left" id="desc1">	
                                                                                    <strong id="Medium_font">No Specification </strong><br>	
                                                                            </div>

                                                                    <?php } ?>
                                                                            <?php if($Product_details->Size_flag == 1) 
                                                                            { ?>

                                                                                    <div class="col-xs-8 text-left" id="desc1">	

                                                                                            <span id="Small_font" style="margin:0px;display: inline;">Select Size : <?php if($Product_details->Size_chart == 1) { ?> <a id="Small_font"  href="#" data-toggle="modal" data-target="#Size_chart"><span id="Small_font" style="margin-left: 31%;text-decoration: underline;">Size Chart </span></a> <?php } ?> </span><br>
                                                                                            <?php						 
                                                                                                    $Get_item_price1 = $this->Redemption_Model->Get_item_details1($Company_id,$Product_details->Company_merchandize_item_code);

                                                                                                    foreach($Get_item_price1 as $Item_pricesz)
                                                                                                    {
                                                                                                            // echo $Item_pricesz->Billing_price;	
                                                                                                            if($Item_pricesz->Item_size == 1)
                                                                                                            {
                                                                                                                    $Size = "S";
                                                                                                                    $Small=1;
                                                                                                            }
                                                                                                            elseif($Item_pricesz->Item_size == 2)
                                                                                                            {
                                                                                                                    $Size = "M";
                                                                                                                    $Medium=2;
                                                                                                            }
                                                                                                            elseif($Item_pricesz->Item_size == 3)
                                                                                                            {
                                                                                                                    $Size="L";
                                                                                                                    $Large=3;
                                                                                                            }
                                                                                                            elseif($Item_pricesz->Item_size == 4)
                                                                                                            {
                                                                                                                    $Size="XL";
                                                                                                                    $ExtraLarge=4;
                                                                                                            }
                                                                                                            ?>
                                                                                                            <a href="javascript:Change_points_by_size('<?php echo $Item_pricesz->Billing_price;?>','<?php echo $Item_pricesz->Item_size; ?>','<?php echo $Item_pricesz->Item_weight; ?>','<?php echo $Item_pricesz->Item_Dimension; ?>');" style="margin: 6px;"><div id="<?php echo $Item_pricesz->Item_size; ?>" class="circle" > <h5 id="Medium_font" style="font-size: 20px;"> <?php echo $Size; ?> </h5></div></a>

                                                                                            <?php	} ?>

                                                                                            <br>

                                                                                    </div>
                                                                    <?php } ?>

                                                            <?php 
                                                                    if($Product_details->Merchant_flag ==1) 
                                                                    {										
                                                                            $get_enrollment = $this->Igain_model->get_enrollment_details($Product_details->Seller_id);	
                                                                            $Merchent_name = $get_enrollment->First_name.' '.$get_enrollment->Last_name;	
                                                                            // echo $get_enrollment->First_name.' '.$get_enrollment->Last_name;
                                                                    ?>	
                                                                            <div class="col-xs-8 text-left" id="desc1">												
                                                                                    <span id="Small_font"> Merchant Name:</span><br>
                                                                                    <span id="Small_font"><?php echo $Merchent_name; ?></span><br>
                                                                            </div>
                                                            <?php } ?>


                                                            <?php 
                                                            // echo"----Colour_flag----->".$Product_details->Colour_flag ."<br>";
                                                            if($Product_details->Brand_flag ==1 || $Product_details->Colour_flag ==1 || $Product_details->Weight_flag ==1 || $Product_details->Dimension_flag ==1 || $Product_details->Manufacturer_flag ==1) 
                                                            { 
                                                            ?>

                                                                <div class="col-xs-8 text-left" id="desc1">											
                                                                    <?php if($Product_details->Brand_flag ==1) { ?>									
                                                                        <span id="Small_font">Brand : <font id="Value_font"><?php echo $Product_details->Item_Brand; ?></font></span><br>
                                                                    <?php } ?>
                                                                    <?php if($Product_details->Colour_flag ==1) { ?>
                                                                        <span id="Small_font">Color : <input type="color" value="<?php echo $Product_details->Item_Colour; ?>" disabled style="padding: 0px;border: none;background: none;width: 30px;height: 30px;"></span><br>
                                                                    <?php } ?>
                                                                    <?php /* if($Product_details->Weight_flag == 1) {
                                                                            $Get_Code_decode = $this->Igain_model->Get_codedecode_row($Product_details->Weight_unit_id);
                                                                    ?>
                                                                        <span id="Small_font">Weight : <font id="Weight"><?php echo $Product_details->Item_Weight; ?></font> <font id="Value_font"><?php echo $Get_Code_decode->Code_decode; ?> </font></span><br>
                                                                    <?php } ?>
                                                                    <?php if($Product_details->Manufacturer_flag ==1) { ?>
                                                                        <span id="Small_font">Manufacturer By :<font id="Value_font"> <?php echo $Product_details->Item_Manufacturer; ?></font></span><br>
                                                                    <?php } ?>
                                                                    <?php if($Product_details->Dimension_flag ==1) { ?>
                                                                        <span id="Small_font">Dimension : <font id="Dimension"> <font id="Value_font"><?php echo $Product_details->Item_Dimension; ?>(Lenght X Width X Height)</font></span><br>
                                                                    <?php } ?>
                                                                </div>
                                                            <?php } ?>

                                                            </div>																											
                                                    </div>
                                            </div>
                                    </div>
                            </div>
							
							<?php */ ?>

                            <br>


                    </div>

            </div>
    </div>
</div>
	
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
	
	<!------------------Size_chart modal--------------------->
	<div id="Size_chart" class="modal fade" >
	  <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
			 <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h5 class="modal-title" id="Large_font" >Size Chart</h5>
			  <?php if($Product_details->Size_chart == 1) 
			  { ?>
				<img src="<?php echo $Product_details->Size_chart_image; ?>" class="img-responsive" style="width: 100%;">
			<?php } ?>
			<?php //echo $Item_details->Size_chart_image; ?>
			</div>
		</div>
	  </div>
	</div>
	<!------------------Size_chart modal--------------------->
	
	
	<!-- Condements Modal -->

	<div class="modal fade" id="item_info_modal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-sm">
			
			<div class="modal-content" >
					
				<div class="modal-body" style="padding: 10px 0px;">
				  <div class="table-responsive" id="Show_item_info"></div>
				  
				</div>							
			</div>						  
		</div>
	</div>
	<!-- Condements Modal -->
	
<?php if($Product_details->Size_flag == 1) { ?>
<!--<input type="hidden" id="Itemsize" value="1">-->
<input type="hidden" id="Itemsize" value="1">
<?php } else { ?>
<input type="hidden" id="Itemsize" value="0">
<?php } ?>
    <?php $this->load->view('front/header/footer');?> 

<style>
    b, strong
    {
            font-weight: normal;
    }
    #Weight, #Dimension{
        color:<?php echo $Value_font_details[0]['Value_font_color']; ?>;
		font-family:<?php echo $Value_font_details[0]['Value_font_family']; ?>;
		font-size:<?php echo $Value_font_details[0]['Value_font_size']; ?>
    }	
	.pricing-table .pricing-details ul li {
		padding: 10px;
		font-size: 12px;
		border-bottom: 1px solid #eee;
		color: #ffffff;
		font-weight: 600;
	}	
	.pricing-table
	{
		padding: 12px 12px 0 12px;
		margin-bottom: 0 !important;
		/* background: #fff; */
	}	
	
	.footer-xs {
		padding: 10px;
		color: #000;
		width: 33.33%;
		border-right: 1px solid #eee;
	}	
	.mySlides
        {
            background:none !IMPORTANT; 
        }
	.fade
	{	
            background: rgba(21, 19, 19, 0.55);
	}	
	/* Carousel Css Started */
	.carousel-indicators li {
		width: 12px;
		height: 12px;
		margin: 0;
		background-color: #ffffff;
		border: 1px solid <?php echo $Button_font_details[0]['Button_border_color'];?>;
	}	
	.carousel-indicators {
		position: absolute;
		bottom: 10px;
		left: 50%;
		z-index: 15;
		width: 60%;
		padding-left: 0;
		margin: 17% 2px -2% -30%;
		text-align: center;
		list-style: none;
	}	
	#smbtn{
		margin: 2%;
	}
	/* Carousel Css Ended */
	
	#desc1{
		width:100%;
		padding: 0% 2% 2% 4%;
	}		
	#img{
		width:69%;
		margin-left: 16%;
	}
	.carousel-indicators .active {
		width: 12px;
		height: 12px;
		margin: 0;
		background-color: <?php echo $Button_font_details[0]['Button_border_color'];?>;
	}		
	#foot1{
		padding:0 2%;
		line-height: 35%;
	}
	.circle {
		height: 50px;
		width: 50px;
		display: table-cell;
		text-align: center;
		vertical-align: middle;
		border-radius: 50%;
		background:<?=$General_details[0]['Header_color']; ?>;
		border: 2px solid <?php echo $Button_font_details[0]['Button_border_color'];?>;
	}		
</style>
<script>
var slideIndex = 0;
showSlides();
function showSlides() {		
	var i;
	var slides = document.getElementsByClassName("mySlides");
	var dots = document.getElementsByClassName("dot");
	for (i = 0; i < slides.length; i++) {
	   slides[i].style.display = "none";  
	}
	slideIndex++;
	if (slideIndex > slides.length) {slideIndex = 1}    
	for (i = 0; i < dots.length; i++) {
		dots[i].className = dots[i].className.replace(" active", "");
	}
	slides[slideIndex-1].style.display = "block";  
	dots[slideIndex-1].className += " active";	
		
	setTimeout(showSlides, 2000);    // Change image every 2 seconds
}

function add_to_cart(serial,name,price,Redemption_method,Branch,Company_merchandise_item_id,Item_size,Item_Weight,Weight_unit_id,Partner_id,Partner_state,Partner_Country_id,Seller_id,Merchant_flag,Cost_price,VAT,Product_category_id,Item_name,Company_merchandize_item_code)
{	
	var input = $('#cart_count');
	input.val(parseInt(input.val()) + 1);
	setTimeout(function() 
	{
		// $('#myModal').modal('show');
		
		// var Item_Weight=document.getElementById("Weight").innerHTML;
		var Item_Weight=1;
		 // alert('Item_Weight'+Item_Weight);
		 // alert('Weight_unit_id'+Weight_unit_id);
		// show_loader();
		Branch=document.getElementById("Delivery_"+Company_merchandise_item_id).value;
		var price=document.getElementById("size_points").innerHTML;
		var Item_size = $("#Itemsize").val();
		// alert('2Item_size'+Item_size);
		$.ajax({
			type: "POST",
			data: { id:serial, name:name, price:price, Delivery_method:29, Branch:Branch ,Item_size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id,Partner_id:Partner_id,Partner_state:Partner_state,Partner_Country_id:Partner_Country_id,Seller_id:Seller_id,Merchant_flag:Merchant_flag,Cost_price:Cost_price,VAT:VAT,Product_category_id:Product_category_id,Item_name:Item_name,Company_merchandize_item_code:Company_merchandize_item_code},
			url: "<?php echo base_url()?>index.php/Shopping/add_to_cart",
			success: function(data)
			{
				// alert(data.cart_success_flag);
				if(data.cart_success_flag == 1)
				{
					// ShowPopup('Product '+name+' is added to Cart Successfuly..!!');				
					// $('.shoppingCart_total').html('$'+data.cart_total);
					var msg1 = 'Item added to Cart Successfuly';
					$('#alert_div_'+Company_merchandise_item_id).show();
					$('#alert_div_'+Company_merchandise_item_id).css("color","green");
					$('#alert_div_'+Company_merchandise_item_id).html(msg1);
					setTimeout(function(){ $('#alert_div_'+Company_merchandise_item_id).hide(); }, 3000);
											
					// location.reload(true);
					window.location.href='<?php echo base_url(); ?>index.php/Shopping/view_cart';
				}
				else
				{
					/* var msg1 = 'Error adding item to Cart. Please try again';
					$('#alert_div_'+Company_merchandise_item_id).show();
					$('#alert_div_'+Company_merchandise_item_id).css("color","green");
					$('#alert_div_'+Company_merchandise_item_id).html(msg1);
					setTimeout(function(){ $('#alert_div_'+Company_merchandise_item_id).hide(); }, 3000);
					// ShowPopup('Error adding Product '+name+' to Cart. Please try again..!!');
					// $('.shoppingCart_total').html('$'+data.cart_total);				
					location.reload(true); */
					
					$('#item_info_modal').modal('show');
					$("#Show_item_info").html(data.transactionReceiptHtml);
				}
			}
			});      
   }, 0);
	
	/* setTimeout(function() 
	{ 
		$('#myModal').modal('hide');	
	},3000); */       
}

function add_to_wishlist(serial,name,price)
{	
	var input1 = $('#wishlist_count');
	input1.val(parseInt(input1.val()) + 1);
	setTimeout(function() 
	{
	
	$('#myModal').modal('show');		
	var Size = $("#Itemsize").val();
	$.ajax({
		type: "POST",
		data: { id:serial, name:name, price:price,Size:Size },
		url: "<?php echo base_url()?>index.php/Shopping/add_to_wishlist",
		success: function(data)
		{
			// alert(data.cart_success_flag);
			if(data.cart_success_flag == 1)
			{
				// ShowPopup('Product '+name+' is added to Wishlist..!!');				
				// $('.shoppingCart_total').html('$'+data.cart_total);
                                
				var msg1 = 'Product '+name+' is added to Wishlist';
				$('#alert_div_'+serial).show();
				$('#alert_div_'+serial).css("color","green");
				$('#alert_div_'+serial).html(msg1);
				setTimeout(function(){ $('#alert_div_'+serial).hide(); }, 3000);
				location.reload(true);
			}
			else
			{
				// ShowPopup('Error adding Product '+name+' to Wishlist. Please try again..!!');
				// $('.shoppingCart_total').html('$'+data.cart_total);
				var msg1 = 'Error adding Product '+name+' to Wishlist. Please try again..!!';
				$('#alert_div_'+serial).show();
				$('#alert_div_'+serial).css("color","green");
				$('#alert_div_'+serial).html(msg1);
				setTimeout(function(){ $('#alert_div_'+serial).hide(); }, 3000);
				location.reload(true);
			}
		}
	});      
   }, 0);
	setTimeout(function() 
	{ 
		$('#myModal').modal('hide');	
	},3000);       
}
/* 
function Change_points_by_size(Points,Size,Weight,Dimension)
{
	setTimeout(function() 
	{
		$('#myModal').modal('show');	
	}, 0);
	setTimeout(function() 
	{ 
		$('#myModal').modal('hide');	
	},1000);
	var small_item=<?php echo $Small;?>;
	var medium_item=<?php echo $Medium;?>;
	var large_item=<?php echo $Large;?>;
	var ExtraLarge_item=<?php echo $ExtraLarge;?>;
	
		if(Size!=small_item && small_item!=0)
		{		
			document.getElementById(small_item).style.backgroundColor = "#45aed6";
		}
	
		if(Size!=medium_item && medium_item!=0)
		{		
		document.getElementById(medium_item).style.backgroundColor = "#45aed6";
		}
		
		if(Size!=large_item && large_item!=0)
		{		
			document.getElementById(large_item).style.backgroundColor = "#45aed6";
		}
		if(Size!=ExtraLarge_item && ExtraLarge_item!=0)
		{		
			document.getElementById(ExtraLarge_item).style.backgroundColor = "#45aed6";
		}
	
	document.getElementById(Size).style.backgroundColor = "#A9A9A9";
	
	document.getElementById("size_points").innerHTML=Points;
	document.getElementById("Itemsize").value=Size;
	
	<?php 
	if($Product_details->Weight_flag == 1)
 { ?>
	document.getElementById("Weight").innerHTML=Weight;
<?php }
 if($Product_details->Dimension_flag == 1)
 { ?>
	document.getElementById("Dimension").innerHTML=Dimension;
<?php } ?>
} */
</script>


<script>



function Show_next(flag)
{
	// console.log(flag);	
	// $("[style]").removeAttr("style");
	$(flag).css("display",""); 
	 // $('#row_'+flag).removeAttr('style'); 
}


var radio_count = 0;
function Show_next_required(flag)
{
	$(flag).css("display","");
	//$("#Click_ok").css("display","none");
	
	var Condiments_compulsary = '<?php echo $Condiments_compulsary; ?>';

	if ($("input[name^='Required_Condiments']:checked").val())
	{
		radio_count = radio_count+1;
	}
	if ($("input[name='Main_Required_Que_set']:checked").val())
	{
		radio_count = radio_count+1;
	}
	if ($("input[name='Main_Required_Condiments_set']:checked").val())
	{
		radio_count = radio_count+1;
	}
	//alert(Condiments_compulsary+"---"+radio_count);
	if(radio_count == Condiments_compulsary)
	{
		$("#Click_ok").css("display","");
	} 
	else
	{
		return false;	
	}
}

</script>
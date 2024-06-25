<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Redemption Product Details</title>
<?php $this->load->view('front/header/header'); 
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; } 
?>
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
        //print_r($Redeemtion_details2);
        $item_count=0;
        if($Redeemtion_details2 != NULL) {
            foreach($Redeemtion_details2 as $item) {                
                $item_count=$item_count+$item["Total_points"]; 
            }
        }
        if($item_count <= 0 ) {
            $item_count=0;
        }
        else {
            $item_count = $item_count;
        }
        
        // $Curr_balance=$Enroll_details->Current_balance-$Enroll_details->Blocked_points;
		
		$Curr_balance=$Enroll_details->Total_balance;  
		
		$Current_point_balance = ($Curr_balance-$Enroll_details->Debit_points);
				
		if($Current_point_balance<0)
		{
		 $Current_point_balance=0;
		}
		else
		{
			$Current_point_balance=$Current_point_balance;
		}
    ?>
   <?php foreach($Item_details as $Item_details){
        $Branches = $Redemption_Items_branches[$Item_details->Company_merchandize_item_code];
        //print_r($Branches);
        } ?>
        <?php foreach ($Branches as $Branches2){
            $DBranch_code=$Branches2['Branch_code'];
        } ?>
        <input type="hidden" name="Delivery_<?php echo $Item_details->Company_merchandise_item_id; ?>" id="Delivery_<?php echo $Item_details->Company_merchandise_item_id; ?>" value="<?php echo $DBranch_code; ?>">
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
        <div id="application_theme" class="section pricing-section" style="min-height: 550px;">
            <div class="container">
                <div class="section-header">          
                    <p><a href="<?php echo base_url(); ?>index.php/Redemption_Catalogue" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
                    <p id="Extra_large_font">Item Details</p>	
                </div>
                
		<div class="sticky-container">
            <ul class="sticky">
                <li> 
				
				<img width="32" height="32" id="cur_bal_left" alt="" src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" />
				<img width="32" height="32" id="cur_bal_right" style="display:none" alt="" src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/right.png" />
				
                    <p id="home_menu"><font style="font-size:11px">Wallet Balance</font><br><font style="font-size:16px"><?php echo $Current_point_balance; ?></font> <font style="font-size:11px"><?php echo $Company_Details->Currency_name; ?> </font></p>
                </li>
            </ul>
        </div>
		
            <div class="row pricing-tables">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">				
                    <!-- 1st Card -->
                    <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
                        <div class="pricing-details">
                            <div class="row">
                                <div class="col-md-12">	
                                    <div class="slideshow-container">
                                        <div class="mySlides fade" style="background:none">
                                            <img src="<?php echo $Item_details->Item_image1; ?>" width="50">
                                        </div>
                                        <div class="mySlides fade" style="background:none">
                                            <img src="<?php echo $Item_details->Item_image2; ?>" width="50">
                                        </div>
                                        <div class="mySlides fade" style="background:none">
                                            <img src="<?php echo $Item_details->Item_image3; ?>" width="50">
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
                                            
                                        <?php  if($Item_details->Delivery_method==0){ ?>
                                                <span class="col-xs-6 main-xs-6">
                                                   <input type="radio" name="Delivery_method_<?php echo $Item_details->Company_merchandise_item_id; ?>" value="28" onclick="Show_branch(<?php echo $Item_details->Company_merchandise_item_id; ?>,1);" style="margin:-3%;">
                                                   <span>
                                                           <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/pick-up.png" width="20">
                                                           <br><span id="Small_font">&nbsp;Pickup</span>
                                                   </span>                                                            
                                                   
                                               </span>
                                               <span class="col-xs-6 main-xs-6">
                                                       <input type="radio" value="29"  name="Delivery_method_<?php echo $Item_details->Company_merchandise_item_id; ?>" onclick="Show_branch(<?php echo $Item_details->Company_merchandise_item_id; ?>,0);" checked style="margin:-3%;">
                                                       <span>
                                                           <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/delivery.png"  width="20">
                                                           <br><span id="Small_font">&nbsp;Delivery</span>
                                                       </span>
                                               </span>
                                                    <div style="display:none;margin-bottom: 3%;width: 100%;" id="<?php echo $Item_details->Company_merchandise_item_id; ?>" >
                                                        <select class="txt" name="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" id="location_<?php echo $Item_details->Company_merchandise_item_id; ?>">
                                                               <option value="">Select</option>
                                                               <?php foreach ($Branches as $Branches3){?>
                                                               <option value="<?php echo $Branches3['Branch_code']; ?>"><?php echo $Branches3['Branch_name']; ?></option>
                                                               <?php } ?>
                                                       </select>							
                                                   </div> 
                                            <?php }elseif($Item_details->Delivery_method==28){ ?>         
                                               
                                                <span class="col-xs-6 main-xs-6">
                                                    <input type="radio" name="Delivery_method_<?php echo $Item_details->Company_merchandise_item_id; ?>" value="28" onclick="Show_branch(<?php echo $Item_details->Company_merchandise_item_id; ?>,1);" style="margin:-3%;">
                                                    <span>
                                                           <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/pick-up.png"  width="20">
                                                           <br><span id="Small_font">&nbsp;Pickup</span>
                                                    </span>                                                            
                                                    <div style="display:none;" id="<?php echo $Item_details->Company_merchandise_item_id; ?>" style="margin-bottom: 6%;">
                                                        <select  class="txt" name="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" id="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" required>
                                                            <option value=""><?php echo ('Select'); ?></option>
                                                            <?php foreach ($Branches as $Branches3){?>
                                                            <option value="<?php echo $Branches3['Branch_code']; ?>"><?php echo $Branches3['Branch_name']; ?></option>
                                                            <?php } ?>
                                                        </select>							
                                                    </div> 
                                                </span>
                                            <?php }else{ ?>
                                            
                                                <span class="col-xs-6 main-xs-6">
                                                       <input type="radio" value="29"  name="Delivery_method_<?php echo $Item_details->Company_merchandise_item_id; ?>" onclick="Show_branch(<?php echo $Item_details->Company_merchandise_item_id; ?>,0);" checked style="margin:-3%;">
                                                       <span>
                                                           <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/delivery.png"  width="20">
                                                           <br><span id="Small_font">&nbsp;Delivery</span>
                                                       </span>
                                               </span>
                                                <input type="hidden" name="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" id="location_<?php echo $Item_details->Company_merchandise_item_id; ?>" value="0">
                                            <?php }?>
                                                                
                                           
                                        </div> 
                                    </div>
                                </div>
                                    </div>
                            </div>
                    </div>
                    <br>
                    <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
                        <div class="pricing-details">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row ">
                                        <div class="col-xs-12 " style="width: 100%;">
                                            <address>
                                                <div>
                                                    <?php 
                                                        $Get_item_price1 = $this->Redemption_Model->Get_item_details1($Company_id,$Item_details->Company_merchandize_item_code);
                                                        if( $Get_item_price1 != NULL){
                                                        foreach($Get_item_price1 as $Item_pricesz)  {
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
                                                        } 

                                                       /* echo"---Item_size------".$Item_pricesz->Item_size."<br>";
                                                        echo"---Item_Weight------".$Item_details->Item_Weight."<br>";
                                                        echo"---Company_merchandise_item_id------".$Item_details->Company_merchandise_item_id."<br>";
                                                        echo"---Merchandize_item_name------".$Item_details->Merchandize_item_name."<br>";
                                                        echo"---Billing_price------".$Item_details->Billing_price."<br>";
                                                        echo"---Weight_unit_id------".$Item_details->Weight_unit_id."<br>";
                                                        echo"---Partner_id------".$Item_details->Partner_id."<br>";
                                                        echo"---Partner_state------".$Partner_state."<br>";
                                                        echo"---Partner_Country------".$Partner_Country."<br>";
                                                        echo"---Seller_id------".$Item_details->Seller_id."<br>";
                                                        echo"---Merchant_flag------".$Item_details->Merchant_flag."<br>";
                                                        echo"---Cost_price------".$Item_details->Cost_price."<br>";
                                                        echo"---VAT------".$Item_details->VAT."<br>"; */

                                                        
                                                    if($Item_details->Size_flag == 1) 
                                                    { 
                                                        $Get_item_price = $this->Redemption_Model->Get_item_details($Company_id,$Item_details->Company_merchandize_item_code);	
                                                        $Billing_price_in_points = $Get_item_price->Billing_price_in_points;
                                                        $Item_size=$Get_item_price->Item_size;
                                                    } 
                                                    else 
                                                    { 
                                                        $Item_size="0";
                                                        $Billing_price_in_points = $Item_details->Billing_price_in_points;	
                                                    }
                                                    ?>
                                                    <?php
                                                    $Small=0;
                                                    $Medium=0;
                                                    $Large=0;
                                                    $ExtraLarge=0;

                                                /* if($Item_details->Size_flag == 1) 
                                                { 
                                                    $Get_item_price = $this->Redemption_Model->Get_item_details($Company_id,$Item_details->Company_merchandize_item_code);	
                                                    $Billing_price_in_points = $Get_item_price->Billing_price_in_points;
                                                    $Item_size=$Get_item_price->Item_size;
                                                } 
                                                else 
                                                { 
                                                    $Item_size="0";
                                                    $Billing_price_in_points = $Item_details->Billing_price_in_points;	
                                                } */
                                                ?>
                                                     
                                                     <span id="Large_font"><?php echo $Item_details->Merchandize_item_name; ?></span><br>
                                                     <span id="Small_font"><?php echo $Company_Details->Currency_name; ?> :&nbsp;<b id="Value_font" ><b id="size_points" ><?php echo $Billing_price_in_points; ?></b> </span><br>
                                                     <input type="hidden" id="Change_size_points" value="<?php echo $Billing_price_in_points; ?>">	
                                                     <div id="alert_div_<?php echo $Item_details->Company_merchandise_item_id; ?>"></div>
                                                    <button type="button" id="button" class="b-items__item__add-to-cart" onclick="return add_to_cart('<?php echo $Item_details->Company_merchandize_item_code; ?>','<?php echo $Item_details->Delivery_method; ?>',location_<?php echo $Item_details->Company_merchandise_item_id; ?>.value,'<?php echo $Item_details->Merchandize_item_name; ?>','<?php echo $Billing_price_in_points; ?>','<?php echo $Item_size; ?>',<?php echo $Item_details->Company_merchandise_item_id; ?>);"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/redeem.png" alt="" class="img-rounded img-responsive" width="15"   style="margin-top: -4px;"> Add to cart</button>
                                                   
                                            </div>
                                                                
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
                                            <strong id="Medium_font" >Product Description :</strong><br>										
                                            <span id="Value_font"><?php echo $Item_details->Merchandise_item_description; ?></span><br>                                            
                                        </div>
                                    </div>																											
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- 4th Card -->
                    <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
                        <div class="pricing-details">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">	
                                        <input type="hidden" name="Delivery_<?php echo $Item_details->Company_merchandise_item_id; ?>" id="Delivery_<?php echo $Item_details->Company_merchandise_item_id; ?>" value="<?php echo $DBranch_code; ?>">
                                            <div class="col-xs-8 text-left" id="desc1">	
                                                <strong id="Medium_font">Product Specification </strong><br>	
                                            </div>										
                                                <?php 
                                                // echo"----Colour_flag----->".$Item_details->Colour_flag ."<br>";
                                                if($Item_details->Brand_flag ==0 && $Item_details->Colour_flag ==0 && $Item_details->Weight_flag ==0 && $Item_details->Dimension_flag ==0 && $Item_details->Manufacturer_flag ==0 && $Item_details->Merchant_flag ==0) 
                                                { 
                                                ?>
                                                    <div class="col-xs-8 text-left" id="desc1">	
                                                        <strong id="Medium_font">No Specification </strong><br>	
                                                    </div>

                                                <?php } ?>
                                                <?php if($Item_details->Size_flag == 1) { ?>
                                                    <div class="col-xs-8 text-left" id="desc1">	
                                                        <span id="Small_font" style="margin:0px;display: inline;">Select Size : <?php if($Item_details->Size_chart == 1) { ?> <a id="Small_font"  href="#" data-toggle="modal" data-target="#Size_chart"><span id="Small_font" style="margin-left: 31%;text-decoration: underline;">Size Chart </span></a> <?php } ?> </span><br>
                                                            <?php						 
                                                                $Get_item_price1 = $this->Redemption_Model->Get_item_details1($Company_id,$Item_details->Company_merchandize_item_code);
                                                                foreach($Get_item_price1 as $Item_pricesz) {	
                                                                    if($Item_pricesz->Item_size == 1) {
                                                                        $Size = "S";
                                                                        $Small=1;
                                                                    } elseif($Item_pricesz->Item_size == 2){
                                                                        $Size = "M";
                                                                        $Medium=2;
                                                                    } elseif($Item_pricesz->Item_size == 3){
                                                                        $Size="L";
                                                                        $Large=3;
                                                                    } elseif($Item_pricesz->Item_size == 4){
                                                                            $Size="XL";
                                                                            $ExtraLarge=4;
                                                                    }
                                                            ?>
                                                        <a href="javascript:Change_points_by_size('<?php echo $Item_pricesz->Billing_price_in_points;?>','<?php echo $Item_pricesz->Item_size; ?>','<?php echo $Item_pricesz->Item_weight; ?>','<?php echo $Item_pricesz->Item_Dimension; ?>');"><div id="<?php echo $Item_pricesz->Item_size; ?>" class="circle" > <h5 id="Small_font" style="margin-top:20%;color:#ffffff;" > <?php echo $Size; ?> </h5></div></a>
                                                            <?php } ?>
                                                            <br>

                                                    </div>
                                                <?php } ?>

                                                <?php 
                                                    if($Item_details->Merchant_flag ==1) {										
                                                        $get_enrollment = $this->Igain_model->get_enrollment_details($Item_details->Seller_id);	
                                                        $Merchent_name = $get_enrollment->First_name.' '.$get_enrollment->Last_name;	
                                                        // echo $get_enrollment->First_name.' '.$get_enrollment->Last_name;
                                                        ?>	
                                                        <div class="col-xs-8 text-left" id="desc1">												
                                                            <span id="Small_font"> Merchant Name:</span>
                                                            <span id="Value_font"><?php echo $Merchent_name; ?></span><br>
                                                        </div>
                                                <?php } ?>


                                                <?php 
                                                // echo"----Colour_flag----->".$Item_details->Colour_flag ."<br>";
                                                if($Item_details->Brand_flag ==1 || $Item_details->Colour_flag ==1 || $Item_details->Weight_flag ==1 || $Item_details->Dimension_flag ==1 || $Item_details->Manufacturer_flag ==1) { 
                                                ?>

                                                    <div class="col-xs-8 text-left" id="desc1">											
                                                        <?php if($Item_details->Brand_flag ==1) { ?>									
                                                        <span id="Small_font">Brand :<font id="Value_font"> <?php echo $Item_details->Item_Brand; ?></font></span><br>
                                                        <?php } ?>
                                                        <?php if($Item_details->Colour_flag ==1) { ?>
                                                        <span id="Small_font">Color : <input type="color" id="Value_font" value="<?php echo $Item_details->Item_Colour; ?>" disabled style="padding: 0px;border: none;background: none;width: 30px;height: 30px;"></span><br>
                                                        <?php } ?>
                                                        <?php if($Item_details->Weight_flag == 1) {
                                                               $Get_Code_decode = $this->Igain_model->Get_codedecode_row($Item_details->Weight_unit_id);
                                                        ?>
                                                        <span id="Small_font">Weight : <font id="Value_font"> <b id="Weight"><?php echo $Item_details->Item_Weight; ?></b> <?php echo $Get_Code_decode->Code_decode; ?></font> </span><br>
                                                            <input type="hidden" id="hidden_weight" value="<?php echo $Item_details->Item_Weight; ?>">
                                                            <input type="hidden" id="hidden_weight_unit_id" value="<?php echo $Item_details->Weight_unit_id; ?>">
                                                        <?php } ?>
                                                        <?php if($Item_details->Manufacturer_flag ==1) { ?>
                                                            <span id="Small_font">Manufacturer By : <font id="Value_font"><?php echo $Item_details->Item_Manufacturer; ?></font></span><br>
                                                        <?php } ?>
                                                        <?php if($Item_details->Dimension_flag ==1) { ?>
                                                        <span id="Small_font">Dimension : <font id="Value_font"><b id="Dimension"> <?php echo $Item_details->Item_Dimension; ?></b> (Lenght X Width X Height)</font></span><br>
                                                        <?php } ?>
                                                    </div>
                                                <?php } ?>

                                    </div>																											
                                            </div>
                                    </div>
                            </div>
                    </div>

                                <br>
					
					
                </div>

            </div>
        </div>
    </div>
   	
    <!------------------Size_chart modal--------------------->
        <div id="Size_chart" class="modal fade" >
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title" id="Large_font" >Size Chart</h5>
                        <?php if($Item_details->Size_chart == 1) 
                        { ?>
                            <img src="<?php echo $Item_details->Size_chart_image; ?>" class="img-responsive" style="width: 100%;">
                        <?php } ?>
                        <?php //echo $Item_details->Size_chart_image; ?>
                </div>
            </div>
          </div>
        </div>
    <!------------------Size_chart modal--------------------->
	
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

<?php if($Item_details->Size_flag == 1) { ?>
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
            background: #fff;
	}
	
	
	
	.footer-xs {
            padding: 10px;
            color: #000;
            width: 33.33%;
            border-right: 1px solid #eee;
	}
	
	
	/* .fade
	{	
            background:rgba(21, 19, 19, 0.55);
	} */
        
	
	/* Carousel Css Started */
	.carousel-indicators li {
		width: 12px;
		height: 12px;
		margin: 0;
		background-color: #ffffff;
		border: 1px solid #1fa07f;
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
		background-color: #1fa07f;
	}
	
	
	#foot1{
		padding:0 2%;
		line-height: 35%;
	}
	
	.circle {
		height: 40px;
		width: 40px;
		display: table-cell;
		text-align: center;
		vertical-align: middle;
		border-radius: 50%;
		background:rgb(69, 174, 214);
		border: 2px solid #1fa07f;
	}
        
         @media screen and (min-width: 320px) {
            #cart_count {
			<?php if(strlen($item_count) == 1 || strlen($item_count) == 2 ) { ?>
					width: 7%;
			<?php } elseif(strlen($item_count) == 3 ){ ?>
					width: 9%;
			<?php } elseif(strlen($item_count) == 4 ){  ?> 
					width: 11%;
			 <?php } elseif(strlen($item_count) == 5 ){ ?> 
					width: 13%; 
			 <?php } elseif(strlen($item_count) == 6 ){ ?> 
					width: 15%; 
			<?php } ?>
				width: 20%; 
				margin-left:-10%;
                height: 30px;
                text-align: center;
                border: none;
                position: absolute;
                font-size: 11px;
                padding: 0px;
                line-height: .9;
                background: red;
                color: white;
                border-radius: 5%;
            }
        }
        @media screen and (min-width: 768px) {
            #cart_count {
               <?php if(strlen($item_count) == 1 || strlen($item_count) == 2 ) { ?>
					width: 7%;
			<?php } elseif(strlen($item_count) == 3 ){ ?>
					width: 9%;
			<?php } elseif(strlen($item_count) == 4 ){  ?> 
					width: 6%;
			 <?php } elseif(strlen($item_count) == 5 ){ ?> 
					width: 6%; 
			 <?php } elseif(strlen($item_count) == 6 ){ ?> 
					width: 6%; 
			<?php } ?>
			
                margin-left:-9%;
                height: 30px;
                text-align: center;
                border: none;
                position: absolute;
                font-size: 11px;
                padding: 0px;
                line-height: .9;
                background: red;
                color: white;
                border-radius: 5%;
            }
        }
        
        
         input[type='radio']:after {
       content: " ";
    display: inline-block;
    position: relative;
   
    margin: 0 5px 4px 0;
    width: 13px;
    height: 13px;
    border-radius: 11px;
    border: 1.8px solid #ef888e;
    background-color: white;
    
    
    
    /*content: " ";
    display: inline-block;
    position: relative;
    top: 5px;
    margin: 0 5px 4px 0;
    width: 13px;
    height: 13px;
    border-radius: 11px;
    border: 1.8px solid #ef888e;
    background-color: transparent; */
    }

    input[type='radio']:checked:after {
       
        width: 15px;
        height: 15px;
        border-radius: 15px;
        top: -2px;
        left: -1px;
        position: relative;
        background-color: #ef888e;
        content: '';
        display: inline-block;
        visibility: visible;
        border: 2px solid white; 
       
           /* border-radius: 11px;
    width: 7px;
    height: 7px;
    position: absolute;
    top: 8px;
    left: 8.8px;
    content: " ";
    display: block;
    background: #ef888e; */
        
        
    }
    
    .txt {
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    border-left-color: -moz-use-text-color;
    border-left-style: none;
    border-left-width: medium;
    border-top-color: -moz-use-text-color;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    border-top-style: none;
    border-top-width: medium;
    margin-left: 0;
    outline-color: -moz-use-text-color;
    outline-style: none;
    outline-width: medium;
    padding-bottom: 2%;
    padding-left: 1%;
    padding-right: 1%;
    padding-top: 4%;
    width: 66%;
}



.sticky-container {

padding: 0px;
margin: 0px;
position: fixed;
right: -119px;
top: 130px;
width: 157px;
z-index:9999;
}
.sticky li {
list-style-type: none;
<?php  if (!empty($General_details[0]['Application_image_flag']=='yes')) { ?>
        background-image: url("<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'application', 'value',$Company_id); ?>");
        background-repeat: no-repeat;
        background-size: cover;
<?php  } else { ?>

         background:<?php echo $General_details[0]['Theme_color']; ?>;
<?php  }    ?>;

color: #efefef;

padding: 0px;
margin: 100px 0px 1px 0px;
-webkit-transition: all 0.25s ease-in-out;
-moz-transition: all 0.25s ease-in-out;
-o-transition: all 0.25s ease-in-out;
transition: all 0.25s ease-in-out;
cursor: pointer;
filter: url("data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\'><filter id=\'grayscale\'><feColorMatrix type=\'matrix\' values=\'0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0.3333 0.3333 0.3333 0 0 0 0 0 1 0\'/></filter></svg>#grayscale");
filter: gray;

}
.sticky li:hover {
	
margin-left: -75px;
}
.sticky li img {
float: left;
margin: 5px 5px;
margin-right: 3px;
}
.sticky li p {

margin: 0px;

}
li>p{
	line-height: 22px;

}
		
</style>

<script> 
    
	
	$(document).ready(function() {
    $('#cur_bal_left').click(function(e) {  
    
		    $("#cur_bal_left").hide();
		    $("#cur_bal_right").show();
			$(".sticky li").css("margin-left","-105px");

    });
	$('#cur_bal_right').click(function(e) {  
    
		    $("#cur_bal_left").show();
		    $("#cur_bal_right").hide();
			
		    $(".sticky li").css("margin-left","0");

    });
});
    
    
    
    function add_to_cart(Company_merchandize_item_code,Delivery_method,location,Merchandize_item_name,Points,Item_size,Company_merchandise_item_id)
    {
       
        var Points=document.getElementById("Change_size_points").value;
        var Item_size=document.getElementById("Itemsize").value;
        var Checked_Delivery_method = $("input[name=Delivery_method_"+Company_merchandise_item_id+"]:checked").val();
        var Item_Weight=document.getElementById("hidden_weight").value;
        var Weight_unit_id=document.getElementById("hidden_weight_unit_id").value;
        if(Checked_Delivery_method==29)
        {
           location=document.getElementById("Delivery_"+Company_merchandise_item_id).value;
        } 
             
       /* alert('Company_merchandize_item_code: '+Company_merchandize_item_code);
        alert('Delivery_method: '+Delivery_method);
        alert('location: '+location);
        alert('Merchandize_item_name: '+Merchandize_item_name);
        alert('Points: '+Points);
        alert('Item_size: '+Item_size);
        alert('Company_merchandise_item_id: '+Company_merchandise_item_id);  
        alert('Item_Weight: '+Item_Weight);  
        alert('Weight_unit_id: '+Weight_unit_id); 
        return false;  */
        
        if(location=="" && Checked_Delivery_method==28)//Pick up
        {
            //ShowPopup(' <?php echo ('Please Select Partner Location'); ?>"'+Merchandize_item_name+'" !!');	
                
            var msg1 = 'Please Select Partner Location '+Merchandize_item_name+' ';
            $('#alert_div_'+Company_merchandise_item_id).show();
            $('#alert_div_'+Company_merchandise_item_id).css("color","red");
            $('#alert_div_'+Company_merchandise_item_id).html(msg1);
            setTimeout(function(){ $('#alert_div_'+Company_merchandise_item_id).hide(); }, 3000);
            // $('#alert_div_'+Company_merchandise_item_id).focus();
            return false; 
        }
        else
        {
            // var Total_balance = <?php echo $Enroll_details->Total_balance;?>;
			var Total_balance = '<?php echo $Current_point_balance;?>';
            //var Current_redeem_points=document.getElementById("Total_Redeem_points").innerHTML;
            // var Current_redeem_points=$("#cart_count").val();
            var Current_redeem_points= '<?php echo $item_count;?>';
             Current_redeem_points=(parseInt(Current_redeem_points)+parseInt(Points));
            if(Current_redeem_points > Total_balance)
            {
                var msg1 = 'Insufficient <?php echo $Company_Details->Alise_name; ?> Wallet Balance';
                $('#alert_div_'+Company_merchandise_item_id).show();
                $('#alert_div_'+Company_merchandise_item_id).css("color","red");
                $('#alert_div_'+Company_merchandise_item_id).html(msg1);
                setTimeout(function(){ $('#alert_div_'+Company_merchandise_item_id).hide(); }, 3000);
                return false; 
            }
            else
            {       
                setTimeout(function() 
                {
                    $('#myModal').modal('show'); 
                    
                    $.ajax({
                    type: "POST",
                    data: { Company_merchandize_item_code:Company_merchandize_item_code, Delivery_method:Checked_Delivery_method, location:location, Points:Points,Current_redeem_points:Current_redeem_points,Total_balance:Total_balance,Size:Item_size,Item_Weight:Item_Weight,Weight_unit_id:Weight_unit_id },
                    url: "<?php echo base_url()?>index.php/Redemption_Catalogue/add_to_cart",
                    success: function(data)
                    {
                        if(data.cart_success_flag == 1)
                        {
                            if(parseInt(data.cart_total)>Total_balance)
                            {
                                   var msg1 = 'Insufficient <?php echo $Company_Details->Alise_name; ?> Wallet Balance';
                                    $('#alert_div_'+Company_merchandise_item_id).show();
                                    $('#alert_div_'+Company_merchandise_item_id).css("color","red");
                                    $('#alert_div_'+Company_merchandise_item_id).html(msg1);
                                    setTimeout(function(){ $('#alert_div_'+Company_merchandise_item_id).hide(); }, 3000);
                                    return false;
                            }
                            else
                            {
                                var msg1 = 'Item added to Cart Successfully';
                                $('#alert_div_'+Company_merchandise_item_id).show();
                                $('#alert_div_'+Company_merchandise_item_id).css("color","green");
                                $('#alert_div_'+Company_merchandise_item_id).html(msg1);
                                setTimeout(function(){

                                $('#alert_div_'+Company_merchandise_item_id).hide(); 
                                    window.top.location.reload();
                                }, 4000);
                            }
                        }
                        else
                        {
                            var msg1 = 'Error adding Item '+Merchandize_item_name+' to Cart. Please try again..!!';
                            $('#alert_div_'+Company_merchandise_item_id).show();
                            $('#alert_div_'+Company_merchandise_item_id).css("color","red");
                            $('#alert_div_'+Company_merchandise_item_id).html(msg1);
                            setTimeout(function(){ $('#alert_div_'+Company_merchandise_item_id).hide(); }, 3000);
                        }
                    }
                    });
                    
                    
                }, 0);
                setTimeout(function() 
                { 
                        $('#myModal').modal('hide');	
                },3000);
                
                
            }
        }
    }
    
    
    
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
    document.getElementById("Change_size_points").value=Points;
    document.getElementById("Itemsize").value=Size;
    <?php 
        if($Item_details->Weight_flag == 1)
     { ?>
        document.getElementById("Weight").innerHTML=Weight;
    <?php }
     if($Item_details->Dimension_flag == 1)
     { ?>
        document.getElementById("Dimension").innerHTML=Dimension;
    <?php } ?>
    }
 
</script>
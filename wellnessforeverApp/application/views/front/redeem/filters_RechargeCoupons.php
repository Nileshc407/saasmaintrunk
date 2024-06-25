<!DOCTYPE html>
<html lang="en">
  <head>
   <title>Redemption Filter</title>
    <!-- Bootstrap CSS -->
   <?php $this->load->view('front/header/header'); ?>
   
  </head>
  <body>        
	<?php
		//var_dump($Gender_flag);
	echo form_open_multipart('Redemption_Catalogue/filters_RechargeCoupons'); ?>
    <!-- Start Pricing Table Section -->
    <div id="application_theme" class="section pricing-section" style="min-height: 550px;">
      <div class="container" >
        <div class="section-header">    
            <p><a href="<?php echo base_url(); ?>index.php/Redemption_Catalogue/RechargeCoupons" ><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
            <p id="Extra_large_font">Filter</p>
        </div>

        <div class="row pricing-tables">
          

          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">    										
									
              <div class="pricing-details">
				
                <ul>					
                    <li>
                        <a href="#" id="link" >
                            <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/points.png" id="icon1"> &nbsp;&nbsp; <font id="Medium_font">Sort by <?php echo $Company_Details->Currency_name; ?> </font>
                            <i class="fa fa-angle-right" style="float:right; font-size: 22px;"></i>
                        </a>
                        <div id="demo1" style="overflow-y:scroll;height:50px;">
                            <span id="desc2">
                                    <input type="radio" name="SortbyPoints" value="1" checked><font id="Value_font"> <?php echo $Company_Details->Currency_name; ?> : Low-High</font><br>
                                    <input type="radio" name="SortbyPoints" value="2"><font id="Value_font"> <?php echo $Company_Details->Currency_name; ?> : High-Low</font><br>
                                    <input type="radio" name="SortbyPoints" value="3"> <font id="Value_font">Recently Added</font>
                            </span>
                        </div>
                    </li>
					
                    <li>
                        <a href="" id="link" >
                            <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/merchants.png" id="icon1"> &nbsp;&nbsp;<font id="Medium_font"> Merchants</font>
                            <i class="fa fa-angle-right" style="float:right; font-size: 22px;"></i>
                        </a>
                        <div id="demo2" style="overflow-y:scroll;height:50px;">
                            <span id="desc2">
                                <input type="radio" name="Sort_merchants" id="Sort_merchants" value="0" <?php if($Merchant_filter == 0){echo "checked=checked";}?> > <font id="Value_font">All</font><br>
                                 <?php if($Sellers!=NULL) { foreach ($Sellers as $Sellers) { ?>	
                                <input type="radio" name="Sort_merchants" id="Sort_merchants<?php echo $Sellers['Enrollement_id']; ?>" value="<?php echo $Sellers['Enrollement_id']; ?>"> <font id="Value_font"> <?php echo $Sellers['First_name'].' '.$Sellers['Last_name']; ?></font><br>
                                <?php } } ?>
                            </span>
                        </div>
                    </li>

                    <li>
                        <a href="#" id="link" >
                            <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/categories.png" id="icon1"> &nbsp;&nbsp; <font id="Medium_font">Categories </font>
                            <i class="fa fa-angle-right" style="float:right; font-size: 22px;"></i>
                        </a>
                        <div id="demo3" style="overflow-y:scroll;height:50px;">
                            <span id="desc2">
                                <input type="radio" name="Sort_cat" name="Sort_cat_0" value="0"  <?php if($Category_filter == 0){echo "checked=checked";}?>> <font id="Value_font">All</font><br>
                                <?php if($Merchandize_category!=NULL) { foreach ($Merchandize_category as $MerchandizeCat) { ?>
                                <input type="radio" name="Sort_cat" id="Sort_cat_<?php echo $MerchandizeCat->Merchandize_category_id; ?>" class="flat-red" value="<?php echo $MerchandizeCat->Merchandize_category_id; ?>" <?php if($Category_filter == $MerchandizeCat->Merchandize_category_id){echo "checked=checked";}?> >
                                <font id="Value_font"> <?php echo $MerchandizeCat->Merchandize_category_name; ?></font> <br>
                                <?php } } ?>
                            </span>
                        </div>
                    </li>

                    <li>
                        <a href="#" id="link" >
                            <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/brand.png" id="icon1"> &nbsp;&nbsp; <font id="Medium_font">Brand  </font>
                            <i class="fa fa-angle-right" style="float:right; font-size: 22px;"></i>
                        </a>
                        <div id="demo4" style="overflow-y:scroll;height:50px;">
                            <span id="desc2">
                                <input type="radio" name="Sort_brand" id="Sort_brand" class="flat-red" value="0" <?php if($brand_filter == 0){echo "checked=checked";}?> >&nbsp;&nbsp;
                                <font id="Value_font">All</font> <br>
                                <?php if($Item_brand!=NULL) { foreach($Item_brand as $brand) { ?>
                                        <input type="radio" name="Sort_brand" id="Sort_brand<?php echo $brand->Item_Brand; ?>" class="flat-red" value="<?php echo $brand->Item_Brand; ?>" <?php //if($brand_filter == $brand->Item_Brand){echo "checked=checked";} ?> >&nbsp;&nbsp;
                                         <font id="Value_font"><?php echo $brand->Item_Brand; ?></font><br>
                                <?php } } ?>
                            </span>
                        </div>
                    </li>

                   <li>
                        <a href="#" id="link" >
                            <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/gender.png" id="icon1"> &nbsp;&nbsp; <font id="Medium_font">Gender</font>
                            <i class="fa fa-angle-right" style="float:right; font-size: 22px;"></i>
                        </a>
                        <div id="demo5" style="overflow-y:scroll;height:40px;">
                                <span id="desc2">
                                       
                                     <?php 
                                        if($Gender_flag!=NULL) {    
                                        foreach($Gender_flag as $Gender) {
                                        
                                           
                                            if($Gender->Gender_flag==0)
                                            {
                                                $gender_flag='Both';
                                            }
                                            if($Gender->Gender_flag==1)
                                            {
                                                $gender_flag='Men';
                                            }
                                            if($Gender->Gender_flag==2)
                                            {
                                                $gender_flag='Women';
                                            }
                                         
                                         ?>
                                                <input type="radio" name="Sort_gender" id="Sort_gender<?php echo $Gender->Gender_flag; ?>" class="flat-red" value="<?php echo $Gender->Gender_flag; ?>" >&nbsp;&nbsp; <font id="Value_font"><?php echo $gender_flag; ?> </font><br>
                                               
                                        
                                 <?php } } ?>
                                </span>
                        </div>
                    </li>
                </ul>
				 <button type="submit" name="submit" id="button"> Apply</button>
				 <button type="Reset" name="Reset" id="button"> Reset</button>
              </div>             
            </div>
          </div>
        </div>
      </div>
    </div>
	<?php echo form_close(); ?>
    <!-- End Pricing Table Section -->	
<?php $this->load->view('front/header/footer');?> 
<style>	
	.pricing-table .pricing-details ul li {
		padding: 10px;
		font-size: 13px;
		border-bottom: 1px solid #eee;
		color: #7d7c7c;
	}	
	.pricing-table .pricing-details span {
		display: inline-block;
		font-size: 13px;
		font-weight: 400;
		color: #000000;
		margin-bottom: 20px;
		margin-left: 16%;
	}	
	#icon1{
		width: 10%;
		margin-left: -3%;
	}	
</style>
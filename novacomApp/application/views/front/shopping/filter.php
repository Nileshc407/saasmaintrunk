<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $title?></title>
<?php $this->load->view('front/header/header'); ?>  
</head>
<body>        
<?php 
	echo form_open_multipart('Shopping/filters'); ?>
    <!-- Start Pricing Table Section -->
    <div id="application_theme" class="section pricing-section" style="min-height:500px;">
      <div class="container" >
        <div class="section-header">    
			<p><a href="<?php echo base_url(); ?>index.php/Shopping" ><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font">Filter</p>
        </div>
        <div class="row pricing-tables">          
          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">    								
			<div class="pricing-details">				
                <ul>					
					<li>
						<a href="#" id="link" >
							<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/points.png" id="icon1"> &nbsp;&nbsp; <font id="Medium_font" style="    font-weight: bold;">Sort by <?php echo $Company_Details->Currency_name; ?></font>
							<i class="fa fa-angle-right" style="float:right; font-size: 22px;"></i>
						</a>
						<div id="demo1">
							<span id="desc2">
								<input type="radio" name="SortbyPoints" value="1" checked><font id="Value_font"> <?php //echo $Company_Details->Currency_name; ?>Price: Low-High</font>
								<br>
								<br>
								<input type="radio" name="SortbyPoints" value="2"><font id="Value_font"> <?php //echo $Company_Details->Currency_name; ?>Price: High-Low</font>
								<br>
								<br>
								<input type="radio" name="SortbyPoints" value="3"> <font id="Value_font">Recently Added</font>
							</span>
						</div>
					</li>
				<?php /*  ?>					
					<li>
						<a href="" id="link">
							<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/merchants.png" id="icon1"> &nbsp;&nbsp;<font id="Medium_font"> Outlets </font>
							<i class="fa fa-angle-right" style="float:right; font-size: 22px;"></i>
						</a>
						<div id="demo2">
							<span id="desc2"  style="overflow-y: scroll;height: 100px;">
								<input type="radio" name="Sort_merchants" id="Sort_merchants" value="0" <?php if($Merchant_filter == 0){echo "checked=checked";}?> > <font id="Value_font">All</font><br>
								 <?php foreach ($Sellers as $Sellers) { ?>	
								<input type="radio" name="Sort_merchants" id="Sort_merchants<?php echo $Sellers['Enrollement_id']; ?>" value="<?php echo $Sellers['Enrollement_id']; ?>"> <font id="Value_font"> <?php echo $Sellers['First_name'].' '.$Sellers['Last_name']; ?></font><br>
								<?php } ?>
								
							</span>
						</div>
					</li>
					<?php */ ?>					
					<li>
						<a href="#" id="link">
							<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/categories.png" id="icon1"> &nbsp;&nbsp; <font id="Medium_font" style="    font-weight: bold;">Categories </font>
							<i class="fa fa-angle-right" style="float:right; font-size: 22px;"></i>
						</a>
						<div id="demo3">
							<span id="desc2">
								<input type="radio" name="Sort_cat" name="Sort_cat_0" value="0"  <?php if($Category_filter == 0){echo "checked=checked";}?>> <font id="Value_font">All</font>
								<br>
								<br>
								<?php foreach ($Merchandize_category as $MerchandizeCat) { ?>
								 <input type="radio" name="Sort_cat" id="Sort_cat_<?php echo $MerchandizeCat->Merchandize_category_id; ?>" class="flat-red" value="<?php echo $MerchandizeCat->Merchandize_category_id; ?>" <?php if($Category_filter == $MerchandizeCat->Merchandize_category_id){echo "checked=checked";}?> >
                                <font id="Value_font"> <?php echo $MerchandizeCat->Merchandize_category_name; ?></font>
								<br>
								<br>
								<?php } ?>
							</span>
						</div>
					</li>
					<?php /* ?>	
					<li>
						<a href="#" id="link">
							<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/brand.png" id="icon1"> &nbsp;&nbsp; <font id="Medium_font">Brand  </font>
							<i class="fa fa-angle-right" style="float:right; font-size: 22px;"></i>
						</a>
						<div id="demo4"  style="overflow-y: scroll;height: 100px;">
							<span id="desc2">
								 <input type="radio" name="Sort_brand" id="Sort_brand" class="flat-red" value="0" <?php if($brand_filter == 0){echo "checked=checked";}?> >&nbsp;&nbsp;
                                     <font id="Value_font">   All</font> <br>
								<?php foreach($Item_brand as $brand) { ?>
									<input type="radio" name="Sort_brand" id="Sort_brand<?php echo $brand->Item_Brand; ?>" class="flat-red" value="<?php echo $brand->Item_Brand; ?>" <?php if($brand_filter == $brand->Item_Brand){echo "checked=checked";}?> >&nbsp;&nbsp;
										<font id="Value_font"><?php echo $brand->Item_Brand; ?></font><br>
								<?php } ?>
							</span>
						</div>
					</li>
					
					<li>
						<a href="#" id="link">
							<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/gender.png" id="icon1"> &nbsp;&nbsp; <font id="Medium_font">Gender</font>
							<i class="fa fa-angle-right" style="float:right; font-size: 22px;"></i>
						</a>
						<div id="demo5">
							<span id="desc2">							
								<input type="radio" name="Sort_gender" id="Sort_gender<?php echo $Gender->Gender_flag; ?>" class="flat-red" value="0" <?php if($_REQUEST["Sort_by_gender_flag"]==0){echo "checked=checked";}?> >&nbsp;&nbsp; <font id="Value_font">Both </font><br>								
								<input type="radio" name="Sort_gender" id="Sort_gender<?php echo $Gender->Gender_flag; ?>" class="flat-red" value="1" <?php if($_REQUEST["Sort_by_gender_flag"]==1){echo "checked=checked";}?> >&nbsp;&nbsp; <font id="Value_font">Men </font><br>								
								<input type="radio" name="Sort_gender" id="Sort_gender<?php echo $Gender->Gender_flag; ?>" class="flat-red" value="2" <?php if($_REQUEST["Sort_by_gender_flag"]==2){echo "checked=checked";}?> >&nbsp;&nbsp; <font id="Value_font">Women</font>									
							</span>
						</div>
					</li>
					<?php */ ?>	
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
	.pricing-table .pricing-details ul li {
		padding: 1px;
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
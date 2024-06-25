<!DOCTYPE html>
<html lang="en">
<head>
    <title>Redeem with <?php echo $Company_Details->Alise_name; ?></title>	
<?php $this->load->view('front/header/header'); 
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
?> 
</head>
<body>
	<?php 
		$item_count=0;
		if($Redeemtion_details2 != NULL) {
			foreach($Redeemtion_details2 as $item)
			{

				$item_count=$item_count+$item["Total_points"]; 
			}
		}
		if($item_count <= 0 ) 
		{
			$item_count=0;
		}
		else
		{
			$item_count = $item_count;
		}
		$Curr_balance=$Enroll_details->Current_balance-$Enroll_details->Blocked_points; 
	?>     
    <!-- Start Pricing Table Section -->
    <div id="application_theme" class="section pricing-section" style="min-height: 500px;">
      <div class="container">
			<div class="section-header">          
				<p><a href="<?php echo base_url(); ?>index.php/Cust_home/front_home" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font" style="margin-left: -3%;">Redeem with <?php echo $Company_Details->Alise_name; ?></p>
			</div>
        <div class="row pricing-tables">
          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">        
              <div class="pricing-details">				
                <ul>
					<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/Gift_cards">
						<li>
							<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/card.png" id="icon1"> &nbsp;&nbsp; <span id="Medium_font">Gift Cards</span>						
							<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" id="icon" align="right"> 
						</li>
					</a>
					<a href="<?php echo base_url()?>index.php/Redemption_Catalogue/RechargeCoupons">
						<li>
							<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/coupons.png" id="icon1"> &nbsp;&nbsp; <span id="Medium_font">Recharge Coupons</span>
							<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" id="icon" align="right"> 
						</li>
					</a>
					<a href="<?php echo base_url()?>index.php/Redemption_Catalogue">
						<li>
							<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/catalogue.png" id="icon1"> &nbsp;&nbsp; <span id="Medium_font">Catalogue</span>
							<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right.png" id="icon" align="right"> 
						</li>
					</a>					
                </ul>
              </div>             
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Pricing Table Section -->
	
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
				<!-- Modal content-->
			  </div>
		 </div>       
	</div>
	<!-- Loader -->
<?php $this->load->view('front/header/footer'); ?> 
<style>
	
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
</style>
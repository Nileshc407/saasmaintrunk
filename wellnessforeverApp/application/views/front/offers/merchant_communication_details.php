<!DOCTYPE html>
<html lang="en">
  <head>
     <title>Offer Detail</title>	
	<?php $this->load->view('front/header/header'); 
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?> 
  </head>
<body> 
   <?php $this->load->view('front/header/menu'); ?>
    <div id="application_theme" class="section pricing-section" style="min-height: 350px;">
		<div class="container">
			<div class="section-header">          
				<!--<p><a href="<?=base_url()?>index.php/Cust_home/MerchantCommunication" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>-->
				<p id="Extra_large_font" style="margin-left: -3%;">Offer Detail</p>
			</div>
			<?php
			foreach($MerchantCommunication as $comm_details)
			{
				$Photograph = $comm_details['Photograph'];
				
					if($Photograph=="")
					{
						$Photograph='images/no_image.jpeg';
					}
			?>	
			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
				
					<!-- 1st Card -->
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
						<div class="pricing-details">
							<div class="row">
								<div class="col-md-12">
									<div class="row ">
										<div class="col-xs-12 " style="width: 100%;">
											<address>
												<div class="col-xs-12" style="padding: 10px;">
													<img src="<?php echo $this->config->item('base_url2') ?><?php echo $Photograph; ?>" alt="" class="img-rounded img-responsive" width="30%;">
												</div>
												<span id="Large_font" ><strong style=""><?php echo $comm_details['communication_plan']; ?></strong></span>
											</address>
											<address>
												<span id="black_txt"><strong style="padding:0 2%;"><?php echo $comm_details['Offer_description1'];?></strong></span>
											</address><br />
											
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<br>
					<!-- 2nd Card 
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
						<div class="pricing-details">
							<div class="row">
								<div class="col-md-12">
									<div class="row ">
										<div class="col-xs-12 " style="width: 100%;">
											<address>
												<span id="black_txt"><strong style="padding:0 2%;"><?php //echo $comm_details['Offer_description1'];?></strong></span>
											</address><br />
										</div> 
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- 2nd Card -->
					
				</div>

			</div>
		<?php } ?>
		</div>
    </div>

	
 <?php $this->load->view('front/header/footer'); ?> 

<style>
p>img{
	width: 90%;
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
	
	address{
		font-size: 13px;
	}
	
	.footer-xs {
		padding: 10px;
		color: #000;
		width: 33.33%;
		border-right: 1px solid #eee;
		line-height: 10px;
	}
	
	.main-xs-3
	{
		width: 26%;
		padding: 10px 10px 0 10px;
	}
	
	.main-xs-6
	{
		width: 48%;
		padding: 10px 10px 0 10px;
	}
	
	#action{
		margin-bottom: 5px; 
		width: 235%;
		color: #ff3399;
	}	
	
	#txt{
		border-left: none;
		border-right: none;
		border-top: none;
		padding: 5% 0 0 0;
		outline: none;
	}
</style>
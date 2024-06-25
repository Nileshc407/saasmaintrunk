<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Referral Detail</title>	
	<?php $this->load->view('front/header/header'); 
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } 
	$Menu_access_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Menu_access', 'value',$Company_id);
 $Menu_access_details = json_decode($Menu_access_data, true); ?> 	
  </head>
<body> 
   
    <div id="application_theme" class="section pricing-section" style="min-height: 500px;">
		<div class="container">
			<div class="section-header">          
				<p><a href="<?=base_url()?>index.php/Cust_home/MerchantReferralOffers" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font" style="margin-left: -3%;">Referral Offer</p>
			</div>
		<?php
			$todays = date("Y-m-d");
			foreach($MerchantReferralOffers as $offer_details)
			{
				if( ($todays >= $offer_details['From_date']) && ($todays <= $offer_details['Till_date']) )
				{ 		
					$Photograph = $offer_details['Photograph'];
				
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
												<strong id="Large_font" style="padding: 0px 0px 0 8px;">Referral Rule For 
										<?php 	if($offer_details['Referral_rule_for'] == '1')
												{
													echo "Enrollment";
												}
												else
												{
													echo "Transaction";
												} ?> 
												</strong>
											</address>
											<span style="color: #ff3399;margin-bottom: 0; font-size: 12px;"><strong></strong></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<br>
					<!-- 2nd Card -->
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
						<div class="pricing-details">
							<div class="row">
								<div class="col-md-12">
									<div class="row ">
										<div class="col-xs-12 " style="width: 100%;">
											<address>
												<span ><strong id="Small_font">Campaign Start Date :</strong> <strong id="Value_font"><?php echo $offer_details['From_date'];?></strong></span><br><br>
												<span ><strong id="Small_font">Campaign End Date :</strong> <strong id="Value_font"><?php echo $offer_details['Till_date']; ?></strong></span><br><br>
												<?php if($offer_details['Refree_topup']!=0) { ?>
												<span ><strong id="Small_font">Refree Topup :</strong> <strong id="Value_font"><?php echo $offer_details['Refree_topup']; ?></strong></span><br><br>
												<?php } 
												if($offer_details['Customer_topup']!=0) { ?>
												<span ><strong id="Small_font">Member Topup :</strong> <strong id="Value_font"><?php echo $offer_details['Customer_topup']; ?></strong></span><br><br>
												<?php } ?>
											</address><br />
										</div> 
										
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>

			</div>
	<?php	}
		} ?>
		</div>
    </div>
	
 <?php $this->load->view('front/header/footer'); ?> 

<style>
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
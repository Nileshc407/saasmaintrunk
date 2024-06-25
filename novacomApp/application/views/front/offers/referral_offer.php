<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Offers</title>	
<?php $this->load->view('front/header/header'); 
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } 
$Menu_access_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Menu_access', 'value',$Company_id);
 $Menu_access_details = json_decode($Menu_access_data, true); ?> 	
</head>
<body>
<div id="application_theme" class="section pricing-section" style="min-height: 500px;">
    <div class="container" id="top_container">
       <div class="section-header">          
			<p><a href="<?=base_url()?>index.php/Cust_home/front_home" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font" style="margin-left: -3%;">Referral Offers</p>
		</div>
		
        <div class="row pricing-tables">
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
				<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
					<div class="pricing-details">
						<strong>
							<span class="Medium_font mr-5">
								<a id="Small_font" href="<?php echo base_url();?>index.php/Cust_home/merchantoffers">Transaction</a>
							</span>|
							<span id="ud" class="Medium_font mr-5">
								<a id="Small_font" href="<?php echo base_url();?>index.php/Cust_home/MerchantReferralOffers">Referral</a>
							</span>|
							<span class="Medium_font">
								<a href="<?php echo base_url();?>index.php/Cust_home/MerchantCommunication">Offers</a>
							</span>
						</strong>
				<?php 
					$Referral_Offers_flag=0;
					foreach($SellerReferralOffers as $Referral_Offers)
					{
						if($Referral_Offers != false)
						{
							$Referral_Offers_flag=1;
						}
					}			
					if($Referral_Offers_flag==1)
					{
						foreach($SellerReferralOffers as $Referral_Offers)
						{
							if($Referral_Offers != false)
							{
								$Photograph=$Referral_Offers->Photograph;
								if($Photograph=="")
								{
									$Photograph='images/no_image.jpeg';
								}
								?>
								<?php
										if($Referral_Offers->Referral_rule_for == '1')
										{
											$ruleFor="Enrollment";
										}
										else
										{
											$ruleFor="Transaction";
										}
										?>
								<div class="row" >
									<div class="col-md-12">
									<a href="<?=base_url()?>index.php/Cust_home/Referral_Offers_Detail?refid=<?php echo $Referral_Offers->refid;?>&Company_id=<?php echo $Referral_Offers->Company_id;?>">
										<div class="row" id="Lulu">
											<div class="col-xs-4" style="padding: 10px;">
												<img src="<?php echo $this->config->item('base_url2') ?><?php echo $Photograph; ?>" alt="" class="img-rounded img-responsive" width="80">
											</div>											
											<div class="col-xs-8 text-left" id="detail">
												<strong id="Large_font"><?php echo $Referral_Offers->First_name.' '.$Referral_Offers->Last_name; ?></strong><br>						
												<span id="Medium_font"><strong>Referral Rule For : <?php echo $ruleFor; ?></strong></span><br />
												<!--<span id="Small_font"><strong>Customer TopUp :<?php echo $Referral_Offers->Customer_topup.',';?> Refree TopUp :<?php echo $Referral_Offers->Refree_topup;?></strong></span>--> <br />
											</div> 
										</div>
									</a>
									</div>
								</div><hr>
							<?php 
							}
						}
					}
					else
					{ ?>
						<div class="row ">
							<div class="col-xs-12 " style="width: 100%;">	
							<br/>
								<span id="Medium_font" class="uppercase">Currently No Referral Offer Available</span>
							</div>
						</div>
		<?php		}	?>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('front/header/footer'); ?> 
<style>
	#ud
	{
		border-bottom: 1px solid #d8d5d5;
	}
	a
	{
		color: #7d7c7c;
	}
	#icon {
    width: 4%;
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
	
	address{font-size: 13px;}
	
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
	#prodname{
		color: #7d7c7c;
		font-size:13px;
	}
	#img{
		float: right;
		width: 10%;
		margin: -18px -15px auto;
	}
	#detail {
		line-height: 160%;
		width: 63%;
		margin-top: 10px;
	}
</style>

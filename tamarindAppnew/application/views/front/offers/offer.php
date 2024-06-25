<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <title><?=$title?></title>	
	<?php $this->load->view('front/header/header');
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } 	?> 	
  </head>
<body> 
   
    <div id="application_theme" class="section pricing-section">
		<div class="container" id="top_container">
			<div class="section-header">          
				<p><a href="<?php echo base_url(); ?>index.php/Cust_home/front_home" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font">Offers</p>
			</div>
			
			<!-- A1 -->
			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
						<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
							<div class="pricing-details">
							<?php 
								$LTY_Offers_flag=0;
								foreach($SellerLoyaltyOffers as $LTY_Offers)
								{
									if($LTY_Offers)
									{
										$LTY_Offers_flag=1;
									}
								}						
								// echo"LTY_Offers_flag-----------".$LTY_Offers_flag;	
								
								if($LTY_Offers_flag==1)
								{
								?>
								<div class="row" style="background: #d6d6d633;">
									<div class="col-md-12">
										<div class="row" id="Lulu">
											<div class="col-xs-4" style="padding: 2px;">
												<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/merchant_offer.png" alt="" class="img-rounded img-responsive" width="55%;">
											</div>											
											<div class="col-xs-8 text-left" id="detail">
												<strong id="Extra_large_font" >Outlet Offer</strong><br />
											</div>
										</div>
									</div>
								</div><hr>
								
								<?php 
									foreach($SellerLoyaltyOffers as $LTY_Offers) 
									{
										if($LTY_Offers)
										{
											$Photograph = $LTY_Offers->Photograph;
											if($Photograph=="")
											{
												$Photograph='images/no_image.jpeg';
											}
											
										$str = substr($LTY_Offers->Loyalty_name,0,2);
										if($str=='BA')
										{
											$str1='Balance to pay Amount';
										}
										if($str=='PA')	
										{
											$str1='Purchase Amount';
										}
									?>
										<div class="row" > 
											<div class="col-md-12">
												<a href="<?=base_url()?>index.php/Cust_home/Loyalty_Offers_Detail?LoyaltyId=<?php echo $LTY_Offers->Loyalty_id;?>&Company_id=<?php echo $LTY_Offers->Company_id;?>">
													<div class="row" id="Lulu">
														<div class="col-xs-4" style="padding: 10px;">
															<img src="<?php echo $this->config->item('base_url2') ?><?php echo $Photograph; ?>" alt="" class="img-rounded img-responsive" width="80">
														</div>											
														<div class="col-xs-8 text-left" id="detail">
															<strong id="Large_font"><?php echo $LTY_Offers->First_name.' '.$LTY_Offers->Last_name; ?></strong><br />							
															<span id="Medium_font" ><strong><?php echo $LTY_Offers->Loyalty_name;?></strong></span><br />
															<span id="Small_font"><strong><?php if($LTY_Offers->Loyalty_at_transaction!= '0.00') { ?><?php echo $LTY_Offers->Loyalty_at_transaction ." %  On Every Transaction"; } else { echo "Get ". $LTY_Offers->discount." %  discount on  ". $LTY_Offers->Loyalty_at_value ." ". $str1; } ?></strong></span><br />
														</div>
													</div>
												</a>
											</div>
										</div><hr>
									<?php 
										}
									}
								}
							?>	
							</div>
						</div>
				</div>
			</div>
			
			<!-- A2 -->
			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
				
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
							?>
						<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
							<div class="pricing-details">
								
								<!-- 0 -->
								<div class="row" style="background: #d6d6d633;">
									<div class="col-md-12">
										<div class="row" id="Lulu">
											<div class="col-xs-4" style="padding: 2px;">
												<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/referral_offer.png" alt="" class="img-rounded img-responsive" width="55%;">
											</div>											
											<div class="col-xs-8 text-left" id="detail">
												<strong id="Extra_large_font">Referral Offer</strong><br />
											</div>
										</div>
									</div>
								</div><hr>
								
							<?php 
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
								?>		
							</div>
						</div>
						<?php 			
						}
						?>
					
				</div>

			</div>
			
			<!-- A3 --> 
			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
					<?php 
						$COMM_Offers_flag=0; 
						foreach($MerchantCommunication as $COMM_Offers) 
						{
							if($COMM_Offers)
							{	
									$COMM_Offers_flag=1;
							}
						}
						if($COMM_Offers_flag==1)
						{ ?>
						<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
							<div class="pricing-details">
								<div class="row" style="background: #d6d6d633;">
									<div class="col-md-12">
										<div class="row" id="Lulu">
											<div class="col-xs-4" style="padding: 2px;">
												<img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/communication_offer.png" alt="" class="img-rounded img-responsive" width="55%;">
											</div>											
											<div class="col-xs-8 text-left" id="detail">
												<strong id="Extra_large_font">Offer</strong><br />
											</div>
										</div>
									</div>
								</div><hr>	
							<?php 
								foreach($MerchantCommunication as $COMM_Offers) 
								{
									$Photograph=$COMM_Offers->Photograph;
									if($Photograph=="")
									{
										$Photograph='images/no_image.jpeg';
									}
									if($COMM_Offers)
									{
										// $result_offer= mb_substr($COMM_Offers->communication_plan, 0, 20);
										
									?>
									<div class="row" >
										<div class="col-md-12">
										<a href="<?=base_url()?>index.php/Cust_home/Merchant_Communication_Detail?Communication_id=<?php echo $COMM_Offers->Communication_id;?>&Company_id=<?php echo $COMM_Offers->Company_id;?>">
											<div class="row" id="Lulu">
												<div class="col-xs-4" style="padding: 10px;">
													<img src="<?php echo $this->config->item('base_url2') ?><?php echo $Photograph; ?>" alt="" class="img-rounded img-responsive" width="80">
												</div>											
												<div class="col-xs-8 text-left" id="detail">
													<strong id="Large_font"><?php echo $COMM_Offers->First_name.' '.$COMM_Offers->Last_name; ?></strong><br />							
													<span id="Medium_font"><strong><?php echo $COMM_Offers->communication_plan;  ?></strong></span>
													
												</div>
											</div>
										</a>
										</div>
									</div><hr>
								<?php
									}
								} ?>
								
							</div>
						</div>
						<?php   } ?>
				</div>

			</div> 
		</div>
    </div>
	 
 <?php $this->load->view('front/header/footer'); ?> 
<style>
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
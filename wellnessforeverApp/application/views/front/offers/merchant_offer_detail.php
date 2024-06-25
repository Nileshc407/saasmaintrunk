<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Transaction Offer</title>	
	<?php $this->load->view('front/header/header'); 
	$ci_object = &get_instance();
	$ci_object->load->helper(array('encryption_val'));
	if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } 
	
	$Menu_access_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Menu_access', 'value',$Company_id);
	$Menu_access_details = json_decode($Menu_access_data, true); ?> 	
  </head>
<body>   
    <div id="application_theme" class="section pricing-section" style="min-height: 500px;">
		<div class="container">
			<div class="section-header">          
				<p><a href="<?=base_url()?>index.php/Cust_home/merchantoffers" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font" style="margin-left: -3%;">Offer Detail</p>
			</div>

			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
				<?php 
				foreach($MerchantLoyaltyDetails as $offer_details)
				{
				if($offer_details['Tier_name'] == NULL)
				{
					$Lp_tier_name = "ALL";
				}
				else
				{
					$Lp_tier_name = $offer_details['Tier_name'];
				}
				
				$str = substr($offer_details['Loyalty_name'],0,2);
				if($str=='BA')
				{
					$str1='Balance to pay Amount';
				}
				if($str=='PA')	
				{
					$str1='Purchase Amount';
				}
					
				$Photograph = $offer_details['Photograph'];
				
				if($Photograph=="")
				{
					$Photograph='images/no_image.jpeg';
				}
				
				

		?>
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s"  id="front_head">
						<div class="pricing-details">
							<div class="row">
								<div class="col-md-12">
									<div class="row ">
										<div class="col-xs-12 " style="width: 100%;padding: 5px;">
											<address>
												<div class="col-xs-12" style="padding: 10px;">
													<img src="<?php echo $this->config->item('base_url2') ?><?php echo $Photograph; ?>" alt="" class="img-rounded img-responsive" width="30%;">
												</div>
												<strong id="Large_font"><?php 
												
												/* // echo "--Current_address---".$offer_details['Current_address']."<br>";
												$str_arr = explode(",",$offer_details['Current_address']);
												$str_arr0 =App_string_decrypt($str_arr[0]);
												$str_arr1 =App_string_decrypt($str_arr[1]);
												$str_arr2 =App_string_decrypt($str_arr[2]);
												$str_arr3 =App_string_decrypt($str_arr[3]);
												
												$Current_address=$str_arr0.",".$str_arr1.",".$str_arr2.",".$str_arr3; */
												$Current_address =App_string_decrypt($offer_details['Current_address']);
												echo $Current_address; ?></strong><br/><br/>
												<strong id="Large_font"><?php echo $offer_details['Loyalty_name']; ?></strong><br>
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
												<span id="black_txt"><strong id="Small_font">Offer Detail :</strong><br><strong id="Value_font"><?php if($offer_details['Loyalty_at_transaction'] != '0.00') { echo $offer_details['Loyalty_at_transaction']." %  On Every Transaction"; } else { echo "Get ".$offer_details['discount']." %  discount on  ".$offer_details['Loyalty_at_value']." ".$str1; } ?></strong></span><br><br>
												<span id="black_txt"><strong id="Small_font">Validity :</strong><br><strong id="Value_font"><?php echo date('d-M-Y',strtotime($offer_details['From_date']))." To ". date('d-M-Y',strtotime($offer_details['Till_date'])); ?></strong></span><br><br>
												<span id="black_txt"><strong id="Small_font">For Whom :</strong><br><strong id="Value_font">	<?php echo $Lp_tier_name.' '."Tier Members"; ?></strong></span>
											</address><br />
											
											
										</div> 
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php }?>
				</div>

			</div>
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
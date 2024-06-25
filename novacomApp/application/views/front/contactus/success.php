<!DOCTYPE html>
<html lang="en">
<head>
    <title>Success</title>	
	<?php $this->load->view('front/header/header'); 
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?> 
</head>
<body> 
	<div id="application_theme" class="section pricing-section" style="min-height: 500px;">
		<div class="container">
			<div class="section-header">          
				<p><a href="<?php echo base_url();?>index.php/Cust_home/contactus_App" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font" style="margin-left: -3%;">Contact Us</p>
			</div>
			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" style="background:#ffffff;">
						<div class="pricing-details">
							<div class="row">
								<div class="col-md-12">
								<?php $Img='assets/icons/'.$Img.'.png'?>
								<img src="<?php echo base_url(); ?><?php echo $Img; ?>" alt="" class="img-rounded img-responsive" style="width:20%; border-radius: 3%;">
									<br>
									<strong id="Message"><?php echo $Success_Message; ?></strong>
								</div>
							</div>
						</div><hr>														 
							<button type="button" id="button" align="center" onclick="window.location.href='<?php echo base_url();?>index.php/Cust_home/<?php echo $redirect_url;?>'"> <?php echo $Button_lable;?></button>
							
							<button type="button" id="button" align="center" onclick="window.location.href='<?php echo base_url();?>index.php/Cust_home/home'">Go To Home</button>
						<br>				
					</div>		
				</div>
			</div>
		</div>
	</div>
	

<?php $this->load->view('front/header/footer');?> 
<style>
	#Message
	{
		color:<?php echo $MColor; ?>;
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
	
	html{
         <?php  if (!empty($General_details[0]['Application_image_flag']=='yes')) { ?>
		background-image: url("<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'application', 'value',$Company_id); ?>");
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
		<?php  } else { ?>
			
			 background:<?php echo $General_details[0]['Theme_color']; ?>;
		<?php  }    ?>;
                
    }

	
	.footer-xs {
		padding: 10px;
		color: #000;
		width: 33.33%;
		border-right: 1px solid #eee;
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
	
	.X{
		color:#1fa07f;
	}
	#button{
		padding: 1% 3%;
		margin: 8% 4%;
		font-size: 12px;
	}
</style>
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
				<p><a href="<?php echo base_url();?>index.php/Cust_home/transferpointsApp" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/left.png" id="arrow"></a></p>
				<p id="Extra_large_font" style="margin-left: -3%;">Transfer With <?php echo $Company_Details->Alise_name; ?></p>
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
							<button type="button" id="button" align="center" onclick="window.location.href='<?php echo base_url();?>index.php/Cust_home/transferpointsApp'">Transfer <?php echo $Company_Details->Currency_name; ?></button>
							<button type="button" id="button" align="center" onclick="window.location.href='<?php echo base_url();?>index.php/Cust_home/home'">Go To Home</button>
						<br>				
					</div>		
				</div>
			</div>
		</div>
	</div>
	<div class="footer">
		<div class="row" id="foot1">
			<div class="col-xs-3 footer-xs" id="Footer_font">
				<a href="<?php echo base_url(); ?>index.php/Cust_home/home"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/home.png" class="img-responsive" id="flat"><br />
				<span id="foot_txt">Home</span></a>
			</div>
			<div class="col-xs-3 footer-xs" id="Footer_font">
                <a href="<?php echo base_url()?>index.php/Beneficiary/Load_beneficiary">
                    <div class="b-cart"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/buyjoy.png" alt="" class="img-responsive" id="flat">  </div>	
					<span id="foot_txt">Buy with-<?php echo $Company_Details->Alise_name; ?></span>
                </a>
            </div>
            <div class="col-xs-3 footer-xs" id="Footer_font">
				<a href="<?php echo base_url();?>index.php/Cust_home/Redeemption_menu">
				<img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/redeem.png" class="img-responsive" id="flat"><br />
				<span id="foot_txt">Redeem with-<?php echo $Company_Details->Alise_name; ?></span></a>
			</div>
		</div>
	</div>
</body>	
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
	
	body{background: linear-gradient(to bottom right, #41c5a2, #c1c2e7);background-repeat: no-repeat;}

	.card-span {

		color: #1fa07f !important;
		font-size: 12px !important;
		display: inline;
	}
	
	.footer-card-span {

		color: #000 !important;
		font-size: 12px !important;
		text-transform: uppercase;
		display: inline;
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
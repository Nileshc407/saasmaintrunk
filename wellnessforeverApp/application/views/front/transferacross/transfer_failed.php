<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo $title?></title>	
	<?php $this->load->view('front/header/header');
		if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }	?>         
  </head>
<body> 
   
    <div id="application_theme" class="section pricing-section" style="min-height:720px;">
		<div class="container">
			<div class="section-header">          
				<p><a href="<?php echo base_url(); ?>index.php/Beneficiary/Beneficiary_Points_Transfer" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font">Purchase</p>
			</div>

			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
				
					<!-- Main Card -->
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
						
						<!-- 4 card -->
						<div class="pricing-details">
							<div class="row">
								<div class="col-md-12">
								<img src="<?php echo base_url(); ?>assets/icons/Fail.png" alt="" class="img-rounded img-responsive" style="width:20%; border-radius: 3%;">
								<br>
									<strong id="Large_font" style="color:#FF0000;">You have entered invalid data for purchase</strong>
								</div>
							</div>
						</div><hr>
						
						<div class="pricing-details">
							<div class="row">
								<div class="col-xs-4 main-xs-6" >
									<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="window.location.href='<?php echo base_url(); ?>index.php/Beneficiary/Load_beneficiary'" >Go To Purchase</button>
								</div>
								
								<div class="col-xs-4 main-xs-6" >									 
										<button type="button" id="button1" class="b-items__item__add-to-cart"  onclick="window.location.href='<?php echo base_url(); ?>index.php/Cust_home/home'"> Go To Home</button>
								</div>
							</div>
						</div>
								
						<br>		
									
					</div>		
					<!-- End -->
				</div>

			</div>
		</div>
    </div>
    
	
    <?php $this->load->view('front/header/footer');?> 
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
	
	address{font-size: 13px;}
	
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
</style>
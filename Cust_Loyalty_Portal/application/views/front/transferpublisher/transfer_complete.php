<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Purchase</title>	
	<?php $this->load->view('front/header/header'); 
	if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; }
	?> 
	
  </head>
<body> 
   
    <div id="application_theme" class="section pricing-section" style="min-height:520px;">
		<div class="container">
			<div class="section-header">          
				<p><a href="<?php echo base_url(); ?>index.php/Beneficiary/Beneficiary_Points_Transfer" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/left.png" id="arrow"></a></p>
				<p id="Extra_large_font">Transfer</p>
			</div>

			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
				
					<!-- Main Card -->
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
						
						<!-- 4 card -->
						<div class="pricing-details">
							<div class="row">
								<div class="col-md-12">
								<img src="<?php echo base_url(); ?>assets/icons/success.png" alt="" class="img-rounded img-responsive" style="width:20%; border-radius: 3%;">
								<br>
								<strong id="Large_font" style="color:#41ad41;">Transfer Done</strong>
								</div>
							</div>
						</div><hr>
						
						<div class="pricing-details">
							<div class="row">
								<div class="col-xs-4 main-xs-6" >
									<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="window.location.href='<?php echo base_url(); ?>index.php/Transfer_publisher/From_publisher'" >Go To Transfer</button>
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
    <div class="footer">
        <div class="row" id="foot1">
            <div class="col-xs-3 footer-xs" id="Footer_font">
                <a href="<?php echo base_url(); ?>index.php/Cust_home/home"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/home.png" alt="" class="img-responsive" id="flat"><br />
                <span id="foot_txt">Home</span>
                </a>
            </div>			
            <div class="col-xs-3 footer-xs" id="Footer_font">
                <a href="<?php echo base_url(); ?>index.php/Beneficiary/Add_Beneficiary_Category">		
				<img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/beneficiary.png" alt="" class="img-responsive" id="flat">  <br />
                    <span id="foot_txt">(+)Membership</span>				
                </a>
            </div>          
			<div class="col-xs-3 footer-xs" id="Footer_font">
				<a href="<?php echo base_url();?>index.php/Cust_home/Redeemption_menu">
				<img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/redeem.png" class="img-responsive" id="flat"><br />
				<span id="foot_txt">Redeem with-<?php echo $Company_Details->Alise_name; ?></span></a>
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
	
	body{background: linear-gradient(to bottom right, #41c5a2, #c1c2e7);background-repeat: no-repeat;}
	
	.btn 
	{
		color: #1fa07f;
		border-color: #1fa07f;
		background-color: #fff;
		padding: 7px;
		font-size: 12px;
		font-weight: bold;
		border-radius: 15px;
	}
	
	.card-span {

		color: #1fa07f !important;
		font-size: 12px !important;
		display: inline;
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
	
	/* #button1{
		border: 1px solid #1fa07f;
		padding: 4% 4%;
		border-radius: 15px;
		margin-left: 5%;
		color: #1fa07f;
	} */
	
	#action{
		margin-bottom: 5px; 
		width: 235%;
		color: #ff3399;
	}	
	
	#prodname{
		color: #7d7c7c;
	}
	
	#prodname1{
		color: #ff3399;
		margin-left: 60%;
		font-size:12px;
	}
	
	#bill{
		color: #ff3399;
		font-weight:bold;
	}
	
	#bill1{
		margin-left:42%;
	}
	
	#sub{
		color: #7d7c7c;
		font-size: 12px;
	}
	
	#button{
		border: 1px solid #1fa07f;
		padding: 1% 3%;
		border-radius: 15px;
		margin: 8% 4%;
		color: #1fa07f;
		font-size: 12px;
	}
	
	
</style>
<!DOCTYPE html>
<html lang="en">
<head>

<title>View Notification</title>	
<?php $this->load->view('front/header/header'); 
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } 
?> 
</head>
<body>
    <div id="application_theme" class="section pricing-section" style="min-height: 550px;">
		<div class="container">
			<div class="section-header">
				<p><a href="<?=base_url()?>index.php/Cust_home/mailbox" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font" style="margin-left: -3%;">Notification</p>
			</div>
			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s">
						<div class="pricing-details">
							<div class="row">
								<div class="col-md-12 text-left">
									<span id="Value_font"><?php echo $Notifications->Offer;?></span><hr>
									 <input type="hidden" name="note" value="<?php echo $Notifications->Id; ?>" class="form-control" />
									<span id="desc2">From: </span><span id="value_font"><?php echo $Notifications->Company_primary_email_id; ?></span>
									<span style="padding: 0%;">
										<?php echo $Notifications->Offer_description; ?>
									</span>
								</div>
							</div>
						</div>
					</div>			
				</div>
			</div>
		</div>
    </div>
	
<?php $this->load->view('front/header/footer'); ?> 
<style>

p>img{
	width: 100%;
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
	
	.card-span {

		color: #1fa07f !important;
		font-size: 12px !important;
		display: inline;
	}
	.main-xs-3
	{
		width: 27%;
		padding: 10px 10px 0 10px;
	}
	
	.main-xs-6
	{
		width: 45%;
		padding: 10px 10px 0 10px;
	}
	
	.X{
		color:#1fa07f;
	}
	
	#action{
		margin-bottom: 5px; 
		width: 235%;
		color: #ff3399;
	}	
	
	
	
	#icon{
		font-size:17px;
	}
	
	#text5{
		font-size:11px;
	}
	
	/* Carousel Css Started */
	.carousel-indicators li {
		width: 12px;
		height: 12px;
		margin: 0;
		background-color: #ffffff;
		border: 1px solid #1fa07f;
	}
	
	.carousel-indicators {
		position: absolute;
		bottom: 10px;
		left: 50%;
		z-index: 15;
		width: 60%;
		padding-left: 0;
		margin: 17% 2px -2% -30%;
		text-align: center;
		list-style: none;
	}
	
	
	/* Carousel Css Ended */
	
	
	#desc2{		
		color: #7d7c7c;
		margin-bottom: 4%; 
		font-size: 12px;
	}
	
	#img{
		width:100%;
		padding-bottom: 5%;
	}
	
	.carousel-indicators .active {
		width: 12px;
		height: 12px;
		margin: 0;
		background-color: #1fa07f;
	}

	
	hr {
    margin-top: 3px;
    margin-bottom: 10px;
	}
	
	.half{
		width:50%;
	}
</style>
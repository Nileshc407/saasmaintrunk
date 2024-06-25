<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Home</title>	
<?php $this->load->view('front/header/header'); ?> 	
</head>
<body>
<?php 	
    $Menu_access_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Menu_access', 'value',$Company_id);
    $Menu_access_details = json_decode($Menu_access_data, true);
    $General_data = $this->General_setting_model->get_type_name_by_id('frontend_settings', 'General', 'value',$Company_id);
    $General_details = json_decode($General_data, true);	
	$item_count=0;
	$ecom_item_count=0;
	
	if($Redeemtion_details2 != NULL) {
		foreach($Redeemtion_details2 as $item)
		{

			$item_count=$item_count+$item["Total_points"]; 
		}
	}
	if($item_count <= 0 ) {
			$item_count=0;
	}
	else {
			$item_count = $item_count;
	}
	
	if($Ecommerce_flag==1) {						
		$cart_check = $this->cart->contents();
		if(!empty($cart_check)) {
			$cart = $this->cart->contents(); 
			$grand_total = 0; 
			$ecom_item_count = COUNT($cart);  
		}
	}
	if($ecom_item_count <= 0 ) {
		$ecom_item_count=0;
	}
	else {
		$ecom_item_count = $ecom_item_count;
	}        
?>
    <section id="application_theme" class="section">
	<div class="container" >
	<br>
		<div class="row">
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Cust_home/dashboard">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'dashboard', 'value',$Company_id); ?>" id="icon">
						
					</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Cust_home/profile">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'profile', 'value',$Company_id); ?>" id="icon">
						
					</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Beneficiary/Add_publisher_menu">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?>images/icon/template_icon/membership.png" id="icon">
						
					</div>
				</a>
			</div>

			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Beneficiary/Load_beneficiary">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?>images/icon/template_icon/buywithjoy.png" id="icon">
						
					</div>
				</a>
			</div>                    
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Cust_home/Redeemption_menu">
					<div class="item-boxes">
					<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'redeem', 'value',$Company_id); ?>" id="icon">
						<?php if($item_count > 0 ) { ?>	
						<span id="dot" class="top-right"><span id="notify_count"><?php if($item_count >= 999) { echo "999+"; } else { echo $item_count; } ?></span>
						</span>
						<?php } ?>	
						  
					</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Cust_home/Transfer_points_menu">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'transfer_points', 'value',$Company_id); ?>" id="icon">
						
					</div>
				</a>
			</div>	
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Cust_home/getsurvey">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'survey', 'value',$Company_id); ?>" id="icon">
						
						
					</div>
				</a>
			</div>			
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Cust_home/Load_mystatement_APP">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'statement', 'value',$Company_id); ?>" id="icon">
						
					</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Cust_home/mailbox">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'notification', 'value',$Company_id); ?>" id="icon">
						<span id="dot" class="top-right"><span id="notify_count"><?php if($NotificationsCount->Open_notify >= 999) { echo "999+"; } else { echo $NotificationsCount->Open_notify; } ?></span>
						</span>
						
					</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url();?>index.php/Cust_home/contactus_App">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'contact', 'value',$Company_id); ?>" id="icon">
						
					</div>
				</a>
			</div>
		</div>
	</div>
    </section>
<?php $this->load->view('front/header/footer'); ?> 	
<style>
	#icon{width:64% !important;}
	.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9 {
		position: relative;
		width: 50%;
		min-height: 1px;
		padding: 7px;
		margin-bottom: -21px;
	}	
	@media only screen and (min-width: 320px) 
	{
		.top-right 
		{
			position: absolute;
			top: 6px;
			right: 42px;
			color:white;
		}
		.bottom-right 
		{
			position: absolute;
			bottom: 8px;
			right: 16px;
			color:white;
		}
	}	
	@media only screen and (min-width: 768px) 
	{
		.top-right 
		{
			position: absolute;
			top: 6px;
			right: 70px;
			color:white;
		}
		.bottom-right
		{
			position: absolute;
			bottom: 8px;
			right: 16px;
			color:white;
		}
	}	
	#dot 
	{
		height: 26%;
		width: 20%;
		background-color: red;
		border-radius: 23%;
		display: inline-block;
		padding: 6px;
	}
    #notify_count
	{
		text-align: center;
		margin: 0 auto;
    }
	.item-boxes 
	{
		text-align: center;
		padding: 0px;
		border-radius: 4px;
		margin-bottom: 15px;
		webkit-transition: all 0.3s ease 0s;
		-moz-transition: all 0.3s ease 0s;
		transition: all 0.3s ease 0s;
                
	}
	.section 
	{
		/* padding: 80px 0; */
		padding: 0px 0 0px 0;
	}
</style>
<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Home</title>	
<?php $this->load->view('front/header/header'); ?> 	
</head>
<script>
	setTimeout(function() 
	{
		$('#myModal').modal('show'); 
	}, 0);
	setTimeout(function() 
	{ 
		$('#myModal').modal('hide'); 
	},2000);
</script>
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
    <section id="application_theme" class="section" style="min-height:549px;">
	<div class="container" >
	<br>
		<div class="row">
		<?php if($Menu_access_details[0]['Dashboard_flag']==1 && $Company_Details->Dashboard_flag==1) { ?>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Cust_home/dashboard">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'dashboard', 'value',$Company_id); ?>" id="icon">
						
					</div>
				</a>
			</div>
			<?php } 
			if($Menu_access_details[0]['Profile_flag']==1 && $Company_Details->Profile_flag==1) { ?>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Cust_home/profile">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'profile', 'value',$Company_id); ?>" id="icon">
						
					</div>
				</a>
			</div>
			 <?php }
			 if($Menu_access_details[0]['Add_membership_flag']==1 && $Company_Details->Add_membership_flag==1) { ?>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Beneficiary/Add_publisher_menu">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Add_membership', 'value',$Company_id); ?>" id="icon">					
					</div>
				</a>
			</div>
			<?php } 
			if($Menu_access_details[0]['Buy_miles_flag']==1 && $Company_Details->Buy_miles_flag==1) { ?>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Beneficiary/Load_beneficiary">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'Buy_miles', 'value',$Company_id); ?>" id="icon">						
					</div>
				</a>
			</div>  
			<?php } 
			if($Menu_access_details[0]['Ecommerce_flag']==1 && $Company_Details->Ecommerce_flag==1)
			{ ?>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Cust_home/load_shopping">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'offers', 'value',$Company_id); ?>" id="icon">
					</div>
				</a>
			</div>
		<?php } else if($Menu_access_details[0]['Offer_flag']==1 && $Company_Details->Offer_flag==1) { ?>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Cust_home/merchantoffers">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'offers', 'value',$Company_id); ?>" id="icon">
					</div>
				</a>
			</div>
			<?php } 
			if($Menu_access_details[0]['Redeem_flag']==1 && $Company_Details->Redeem_flag==1) { ?>			
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
			<?php } 
			if($Menu_access_details[0]['Transfer_flag']==1 && $Company_Details->Transfer_flag==1 && $Company_Details->Transfer_accross_flag==1) { ?>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Cust_home/Transfer_points_menu">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'transfer_points', 'value',$Company_id); ?>" id="icon">
						
					</div>
				</a>
			</div>
			<?php }
			else
			{ ?>
				<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Cust_home/transferpointsApp">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'transfer_points', 'value',$Company_id); ?>" id="icon">
						
					</div>
				</a>
			</div>
			
		<?php	}
			if(($Menu_access_details[0]['Promo_code_applicable']==1 || $Menu_access_details[0]['Auction_bidding_applicable']==1 )  && ( $Company_Details->Promo_code_applicable==1 ||  $Company_Details->Auction_bidding_applicable==1 )) { ?>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url();?>index.php/Cust_home/Load_playGame_App">
					<div class="item-boxes">
					<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'games', 'value',$Company_id); ?>" id="icon">
					</div>
				</a>
			</div>
		<?php } 
			if($Menu_access_details[0]['Survey_flag']==1 && $Company_Details->Survey_flag==1) { ?>			
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url()?>index.php/Cust_home/getsurvey">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'survey', 'value',$Company_id); ?>" id="icon">
						
						
					</div>
				</a>
			</div>
			<?php } 
			if($Menu_access_details[0]['My_statement_flag']==1 && $Company_Details->My_statement_flag==1) { ?>			
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
						<?php if($NotificationsCount->Open_notify > 0 ) { ?>
						<span id="dot" class="top-right"><span id="notify_count"><?php if($NotificationsCount->Open_notify >= 999) { echo "999+"; } else { echo $NotificationsCount->Open_notify; } ?></span>
						</span>
						<?php } ?>
						
					</div>
				</a>
			</div>
			<?php } 
			if($Menu_access_details[0]['Contact_flag']==1 && $Company_Details->Contact_flag==1) { ?>
			<div class="col-md-4 col-sm-6 col-xs-6">
				<a href="<?php echo base_url();?>index.php/Cust_home/contactus_App">
					<div class="item-boxes">
						<img src="<?php echo $this->config->item('base_url2'); ?><?php echo $this->General_setting_model->get_type_name_by_id('frontend_settings', 'contact', 'value',$Company_id); ?>" id="icon">
						
					</div>
				</a>
			</div>
			<?php } ?>
		</div>
	</div>
	  <!-- Loader -->	
		<div class="container" >
			<div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-sm" style="margin-top: 65%;">
				  <!-- Modal content-->
				  <div class="modal-content" id="loader_model">
						<div class="modal-body" style="padding: 10px 0px;;">
						  <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
						</div>							
				  </div>						  
				</div>
			</div>					  
		</div>
		<!-- Loader -->	
    </section>
<?php $this->load->view('front/header/footer'); ?> 	
<style>
<?php /* if($Company_id ==3){
	?>
	#icon{width:65% !important}
	<?php
} else if($Company_id ==4) {
	?>
	#icon{width:100% !important;}
	<?php
}  */?>
#icon{
	/* width:65% !important; */
    width: 45% !important;
    margin-top: 18px;}
	
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
	/* .selected{
     box-shadow:0px -2px 1px 3px <?php echo $General_details[0]['Theme_color']; ?>; 
	} */
</style>
<script>
	$('img').click(function(){
		// $('.selected').removeClass('selected');
		// $(this).addClass('selected');
		
		setTimeout(function() 
		{
			$('#myModal').modal('show'); 
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide'); 
		},2000);
	});	
</script>
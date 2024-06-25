<?php 
	$Photograph=$Enroll_details->Photograph;
	if($Photograph=="")
	{
		// $Photograph='images/No_Profile_Image.jpg';
		// $Photograph="images/dashboard_profile.png";
		$Photograph=base_url()."assets/img/user.jpg";
		
	} else {
		
		$Photograph=$this->config->item('base_url2').$Photograph;
		
	}
	
	$Company_License_type=$Company_Details->Company_License_type;
	
?>
<nav id="sidebar">
		<div id="dismiss">&nbsp;</div>

		<div class="sidebar-header d-flex align-items-center">
			<div class="userImg"><img src="<?php echo $Photograph; ?>"></div>
			<h3><?php echo ucwords($Enroll_details->First_name); ?></h3>
		</div>

		<ul class="list-unstyled">
			<!--<li><a href="<?php echo base_url(); ?>index.php/Cust_home/MerchantCommunication"><i><img src="<?php echo base_url(); ?>assets/img/member-benefits-icon.svg"></i> Member Benefits</a></li>-->
			<li><a href="<?php echo base_url(); ?>index.php/Cust_home/select_brand"><i><img src="<?php echo base_url(); ?>assets/img/select-brand-icon.svg" style="width: 35px;"></i> Select Brand</a></li>
			<li><a href="<?php echo base_url(); ?>index.php/Cust_home/works"><i><img src="<?php echo base_url(); ?>assets/img/profile-icon.svg" style="width: 35px;"></i> Using Points</a></li>
			
			<li><a href="<?php echo base_url()?>index.php/Cust_home/transferpointsApp"><i><img src="<?php echo base_url(); ?>assets/img/transactions-icon.svg"></i> Transfer Points</a></li>
			<li><a href="<?php echo base_url()?>index.php/Redemption_Catalogue"><i><img src="<?php echo base_url(); ?>assets/img/rewards-icon.svg" style="width: 33px;" ></i>Rewards Catalogue</a></li>
			<?php if($Company_License_type == 120 ) {  ?>
			<li><a href="<?php echo base_url()?>index.php/Redemption_Catalogue/eVoucher_catalogue"><i><img src="<?php echo base_url(); ?>assets/img/rewards-icon.svg" style="width: 41px;" ></i>eVoucher Gift Card</a></li>
			<?php } ?>
			
			<?php if($Company_License_type != 121) { ?>
			<li><a href="<?php echo base_url()?>index.php/Cust_home/promocode"><i><img src="<?php echo base_url(); ?>assets/img/vouchers-icon.svg"></i> Submit Promo Code</a></li>
			
			<li><a href="<?php echo base_url()?>index.php/Cust_home/auctionbidding"><i><img src="<?php echo base_url(); ?>assets/img/points-history-icon.svg"></i> Bid for Auction</a></li>
			<?php } ?>
			<?php if($Company_License_type == 120 ) {  ?>
			<li><a href="<?php echo base_url(); ?>index.php/Cust_home/getsurvey"><i><img src="<?php echo base_url(); ?>assets/img/select-brand-icon.svg" style="width: 35px;"></i>Take Survey</a></li>
			<?php }  ?>
			<li><a href="<?php echo base_url(); ?>index.php/Cust_home/settings"><i><img src="<?php echo base_url(); ?>
			assets/img/settings-icon.svg" style="width: 35px;"></i> Settings</a></li>
			<li><a href="<?php echo base_url(); ?>index.php/Cust_home/contactus"><i><img src="<?php echo base_url(); ?>assets/img/contact-us-icon.svg" style="width: 35px;"></i> Contact Us</a></li>
		</ul>
</nav>

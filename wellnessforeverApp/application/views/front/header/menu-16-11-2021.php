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
?>
<nav id="sidebar">
		<div id="dismiss">&nbsp;</div>

		<div class="sidebar-header d-flex align-items-center">
			<div class="userImg"><img src="<?php echo $Photograph; ?>"></div>
			<h3><?php echo ucwords($Enroll_details->First_name); ?></h3>
		</div>

		<ul class="list-unstyled">
			<!--<li><a href="<?php echo base_url(); ?>index.php/Cust_home/MerchantCommunication"><i><img src="<?php echo base_url(); ?>assets/img/member-benefits-icon.svg"></i> Member Benefits</a></li>-->
			<li><a href="<?php echo base_url(); ?>index.php/Cust_home/select_brand"><i><img src="<?php echo base_url(); ?>assets/img/select-brand-icon.svg"></i> Select Brand</a></li>
			<li><a href="<?php echo base_url(); ?>index.php/Cust_home/works"><i><img src="<?php echo base_url(); ?>assets/img/how-works-icon.svg"></i> Using Cool Beans</a></li>
			<li><a href="<?php echo base_url(); ?>index.php/Cust_home/settings"><i><img src="<?php echo base_url(); ?>assets/img/settings-icon.svg"></i> Settings</a></li>
			<li><a href="<?php echo base_url(); ?>index.php/Cust_home/contactus"><i><img src="<?php echo base_url(); ?>assets/img/contact-us-icon.svg"></i> Contact Us</a></li>
		</ul>
</nav>

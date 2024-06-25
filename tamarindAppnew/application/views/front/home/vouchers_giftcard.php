<?php 
$this->load->view('front/header/header');
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
if($Current_point_balance<0){
	$Current_point_balance=0;
}else{
	$Current_point_balance=$Current_point_balance;
}
$Photograph=$Enroll_details->Photograph;
if($Photograph=="")
{
	// $Photograph='images/No_Profile_Image.jpg';
	// $Photograph="images/dashboard_profile.png";
	$Photograph=base_url()."assets/images/profile.jpg";
	
} else {
	
	$Photograph=$this->config->item('base_url2').$Photograph;
	
}
?> 
	<header>
		<div class="container">
			<div class="text-center">
				<div class="back-link">
					<a href="<?php echo base_url(); ?>index.php/Cust_home/front_home"><span>My Voucher</span></a>
				</div>
			</div>
		</div>
	</header>
		<div class="custom-body">
			<div class="container">
				
				<div class="profile-box">
					<div class="avtar sm">
						<img src="<?php echo $Photograph; ?>" alt="">
					</div>
					<h2><?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name ; ?></h2>
				</div>
			</div>
			<div class="login-box min-height mt-0">
					<div class="category-box voucher grid">
						<div class="grid-row">
						<a href="<?php echo base_url(); ?>index.php/Cust_home/discount_vouchers"><div class="item">
							<div class="img">
							<img src="<?php echo base_url(); ?>assets/images/voucher1.png">
							</div>
							<p>Discount Voucher</p></a>
							
						</div>
						<a href="<?php echo base_url(); ?>index.php/Cust_home/value_vouchers"><div class="item">
							<div class="img">
							<img src="<?php echo base_url(); ?>assets/images/voucher2.png">
							</div>
							<p>Value Voucher</p> </a>
							
						</div>
						</div>
						

					</div>
			</div>
		</div>
<?php $this->load->view('front/header/footer');  ?>
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
					<a href="<?php echo base_url(); ?>index.php/Cust_home/Vouchers_giftcard"><span> Discount Vouchers</span></a>
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
			
			<?php if($DiscountVouchers) { ?>
			<div class="login-box">
					<p class="md-font">Provide Voucher code to cashier 
					upon final payment </p>
				<?php foreach($DiscountVouchers as $discount) {?>
					<div class="discount-box bg-primary">
						<div class="gift-card">
						<div class="br-logo">
							<img src="<?php echo base_url(); ?>assets/images/coupon.png" class="img-fluid">
						</div>
						<div class="disc-content">
							<p>Discount Voucher</p>
							<dt><?php echo $discount->Discount_percentage; ?>%</dt>
							<div class="code mt-3">
								<span>voucher Code:</span>
								<div class="code-box">
									<?php echo $discount->Gift_card_id; ?>
								</div>
							</div>
						</div>
						</div>
						<p class="terms">Terms and Conditions Apply <br>
						<b>Valid until <?php echo date('d M, Y',strtotime($discount->Valid_till)) ?></b></p>
					</div>
				<?php } ?>

					

					
			</div>
			<?php } else { ?>
				<div class="login-box">
					<h3 class="text-center"> No Voucher found </h3>
				</div>
			
			<?php } ?>
		</div>
<?php $this->load->view('front/header/footer');  ?>
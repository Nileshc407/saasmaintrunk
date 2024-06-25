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
					<a href="<?php echo base_url(); ?>index.php/Cust_home/front_home"><span>Gift Cards</span></a>
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
			<?php if($MyGiftCard) { ?>
			<div class="login-box">
					<p class="md-font">Provide gift cards code to cashier upon final payment</p>
				<?php foreach($MyGiftCard as $gift) {?>
					<div class="discount-box bg-primary">
						<div class="gift-card">
						<div class="br-logo">
							<img src="<?php echo base_url(); ?>assets/images/coupon.png" class="img-fluid">
						</div>
						<div class="disc-content">
							<p>Gift Cards</p>
							<dt><?php echo $gift->Card_value; ?></dt>
							<div class="code mt-3">
								<span>GIFT CARD CODE:</span>
								<div class="code-box">
									<?php echo $gift->Gift_card_id; ?>
								</div>
							</div>
						</div>
						</div>
						<p class="terms">Terms and Conditions Apply <br>
						<b>Valid until <?php echo date('d M, Y',strtotime($gift->Valid_till)) ?></b></p>
						<?php if($gift->Card_balance > 0) { ?>
						<div class="submit-field">
							<button type="submit" class="submit-btn" style="line-height: 40px;" onclick="window.location.href='<?php echo base_url(); ?>index.php/Cust_home/Send_gift_card/?Gift_card_id=<?php echo $gift->Gift_card_id; ?>'">Send Gift Card</button>
						</div> 
						<?php } ?>
					</div>
					
				<?php } ?>
			</div>
			<?php } else { ?>
				<div class="login-box">
					<h3 class="text-center"> No gift card found </h3>
				</div>
			
			<?php } ?>
		</div>
<?php $this->load->view('front/header/footer');  ?>
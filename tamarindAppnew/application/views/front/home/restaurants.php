<?php 
$this->load->view('front/header/header');
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
if($Current_point_balance<0){
	$Current_point_balance=0;
}else{
	$Current_point_balance=$Current_point_balance;
}
/* $Photograph=$Enroll_details->Photograph;
if($Photograph=="")
{
	// $Photograph='images/No_Profile_Image.jpg';
	// $Photograph="images/dashboard_profile.png";
	$Photograph=base_url()."assets/images/profile.jpg";
	
} else {
	
	$Photograph=$this->config->item('base_url2').$Photograph;
	
} */
?> 
	<header>
		<div class="container">
			<div class="text-center">
				<div class="back-link">
					<a href="<?php echo base_url(); ?>index.php/Cust_home/front_home"><span>Our Brands</span></a>
				</div>
			</div>
		</div>
	</header>
	
		<div class="custom-body">
			<?php if($FetchSellerdetails) { ?>
			<div class="login-box mt-0">
				<div class="category-box grid">
				
				
					
					<?php /*  foreach($FetchSellerdetails as $seller) { ?>
						<div class="grid-row">
							
								<div class="item">
									<div class="img">
									<img src="<?php echo base_url(); ?>assets/images/restaurants5.png">
									</div>
									<h3><?php echo $seller['First_name'].' '.$seller['Last_name'] ?></h3>
									<p class="food-name">Restaurant</p>
									<a class="more-link" href="">See More </a>
								</div>
								<!--<div class="item">
									<div class="img">
									<img src="<?php echo base_url(); ?>assets/images/restaurants5.png">
									</div>
									<h3><?php echo $seller['First_name'].' '.$seller['Last_name'] ?></h3>
									<p class="food-name">Restaurant</p>
									<a class="more-link" href="">See More </a>
								</div>-->						
							
						</div>
					<?php } */ ?>
					
						<?php foreach(array_chunk($FetchSellerdetails, 2) as $group){ ?>
								<div class="grid-row">								
									<?php foreach ($group as $item) { 
									
									// $Photograph='qr_code_profiles/'.$enroll.'profile.png';
									$Photograph=$item['Photograph'];
									
									
									// echo "----Photograph-----".$Photograph."---<br>";
									
									if($Photograph=="images/No_Profile_Image.jpg" || $Photograph=="images/No_Profile_Image.jpg")
									{
										$Photograph=base_url()."assets/images/restaurants5.png";
										
									} else {
										
										$Photograph=$this->config->item('base_url2').$Photograph;
										
									}
									
									?>
										<div class="item">
											<div class="img">
												<!--<img src="<?php echo base_url(); ?>assets/images/restaurants5.png">-->
												<img src="<?php echo $Photograph; ?>">
											</div>
											<!--<h3><?php //echo $item['First_name'].' '.$seller['Last_name']; ?></h3>
											<p class="food-name">Restaurant</p>-->
											<a class="more-link" href="<?php echo base_url(); ?>index.php/Cust_home/brands_details?Brand_id=<?php echo $item['Enrollement_id']; ?>">See More </a>
										</div>
									<?php } ?>								
								</div>
						<?php } ?>
				</div>
			</div>
			<?php } else { ?>
				<div class="login-box">
					<h3 class="text-center"> No brand available </h3>
				</div>
			
			<?php } ?>
		</div>
<?php $this->load->view('front/header/footer');  ?>
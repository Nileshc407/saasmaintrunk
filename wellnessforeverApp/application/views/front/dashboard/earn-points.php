<?php $this->load->view('front/header/header'); ?>

<?php
	$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
	if($Current_point_balance<0){
		$Current_point_balance=0;
	}else{
		$Current_point_balance=$Current_point_balance;
	}
	
?>
	
		
<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;">
			<!--<img style="height: 44px;" src="<?php echo base_url(); ?>assets/img/default-black-top.png">-->
			</div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
			
				<div class="leftRight"><button id="sidebarCollapse" onclick="location.href = '<?php echo base_url(); ?>index.php/Cust_home/works';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				
				
				<?php if($pt=='EARN') { ?>
										
				<div><h1>Earn Points</h1></div>
				
			<?php } else if($pt=='COLLECT') { ?> 
			
				<div><h1>Collect Stamps</h1></div>
				
			<?php } else if($pt=='REDEEM') { ?> 
			
					<div><h1>Redeem Points</h1></div>
			<?php } ?>
				
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>
			
				
						<main class="padTop1 padBottom">
						<div class="container">
							<div class="row">
								
								<div class="col-12 howWorkWrapper">
									<section class="howWorkSliderHldr">
										<div class="howWorkSlide">
											<div><img src="<?php echo base_url(); ?>assets/img/work-img1.jpg" alt=" "></div>
											<div><img src="<?php echo base_url(); ?>assets/img/work-img2.jpg" alt=" "></div>
											<div><img src="<?php echo base_url(); ?>assets/img/work-img3.jpg" alt=" "></div>
											<div><img src="<?php echo base_url(); ?>assets/img/work-img4.jpg" alt=" "></div>
											<div><img src="<?php echo base_url(); ?>assets/img/work-img5.jpg" alt=" "></div>
										</div>
									</section>
									<div class="workPointWrapper">
										<?php if($pt=='EARN') { ?>
										
										<span class="redTxt">Dine at</span> any of our restaurants and provide your 4 digit Code
											to the cashier upon settling your bill to earn your points.
										
									<?php } else if($pt=='COLLECT') { ?> 
										<span class="redTxt">Receive stamps</span> when purchasing our any of our stamp collection items.Collect the required amount of stamps and get a free voucher to redeem on your next item
									<?php } else if($pt=='REDEEM') { ?> 
									
											<span class="redTxt">Use your</span>  points towards payment of your bill. Provide your 4 Digit Code to the cashier when settling your bill, then Confirm or Deny Redemtion of your points from your App Notification screen.
									<?php } ?>
										
									</div>
								</div>
							</div>
						</div>
					</main>
					
				
				
					
		

	<?php $this->load->view('front/header/footer');  ?>
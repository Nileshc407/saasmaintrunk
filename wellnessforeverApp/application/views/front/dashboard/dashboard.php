<?php 
$this->load->view('front/header/header'); 
$this->load->view('front/header/menu');   
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
	$Total_topup_amt=$Enroll_details->Total_topup_amt;
	if($Current_point_balance<0){
		$Current_point_balance=0;
	}else{
		$Current_point_balance=$Current_point_balance;
	}
	$total_gain_points=$total_gain_points->Total_gained_points;
	if($total_gain_points){
		$TotalGainPoints=$total_gain_points; 
	}else{
		$TotalGainPoints=0;
	}	
	$Total_Transfer_points=$Total_transfer->Total_Transfer_points;
	
	if($Total_Transfer_points){
		$Total_Transfer_points=$Total_transfer->Total_Transfer_points;
	}else{
		$Total_Transfer_points=0;
	}
	if($Enroll_details->Total_reddems){
		$Total_reddems=$Enroll_details->Total_reddems;
	}else{
		$Total_reddems=0;
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
		<div class="row">
			<div class="col-12" style="height: 22px;">
			<!--<img style="height: 44px;" src="<?php echo base_url(); ?>assets/img/default-black-top.png">-->
			</div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
			
				<div class="leftRight"><button id="sidebarCollapse"><img src="<?php echo base_url(); ?>assets/img/menu.svg"></button></div>
				<div><img src="<?php echo base_url(); ?>assets/img/digicoffeehouselogoinApp.png"></div>
				<div class="leftRight"><button onclick="location.href = '<?php echo base_url(); ?>index.php/Cust_home/Redeem_points_QRCode';"><img src="<?php echo base_url(); ?>assets/img/qrcode-scan.svg"></button></div>
			</div>
		</div>
	</div>
</header>
<main class="padTop padBottom">
	<div class="container">
		<div class="row">
			<!--<div class="col-12 d-flex userNamePoint align-items-center">
				<div class="mr-auto"><h1>Hello, <?php echo ucwords($Enroll_details->First_name); ?></h1></div>
				<div class="pointMain">Java House Cool Beans </div>
				<div class="pointMain"><img src="<?php echo base_url(); ?>assets/img/home-point-start.svg"> <?php echo $Current_point_balance; ?> </div>
			</div>
			<div class="col-12 d-flex userNamePoint align-items-center pt-2">
				<div class="userSubTxt mr-auto">Where will you go today?</div>
				<div class="pointMain"><?php echo $Company_Details->Currency_name; ?> 8068</div>
			</div> -->
			
			
			<div class="col-12 d-flex userNamePoint align-items-center">
				<div class="mr-auto"><h1>Hello, <?php echo ucwords($Enroll_details->First_name); ?></h1></div>
				<div class="pointMain"><?php echo $Company_Details->Currency_name; ?> </div>
			</div>
			<div class="col-12 d-flex userNamePoint align-items-center">
				<div class="mr-auto">&nbsp;</div>
				<div class="pointMain"><img src="<?php echo base_url(); ?>assets/img/home-point-start.svg"> <?php echo $Current_point_balance; ?></div>
			</div>
			<div class="col-12 d-flex userNamePoint align-items-center pt-2">
				<div class="userSubTxt mr-auto">Where will you go today?</div>
				<div class="pointMain"><?php echo $Currency_Symbol; ?> <?php echo number_format($Current_point_balance / $Company_Details->Redemptionratio,0); ?></div>
			</div>
		</div>
	</div>
	<section class="homeSlider">
		<div class="homeSlide">
			<div class="item">
				<img src="<?php echo base_url(); ?>assets/img/home-slide1.jpg" alt=" ">
			</div>
			<div class="item">
				<img src="<?php echo base_url(); ?>assets/img/home-slide2.jpg" alt=" ">
			</div>
			<div class="item">
				<img src="<?php echo base_url(); ?>assets/img/home-slide3.jpg" alt=" ">
			</div>
		</div>
	</section>
	<div class="container">
		<div class="row">
			<div class="col-12 homeTxt">
			<h4 class="text-center">The Digi Coffee House Family </h4>
			<br>
				<p>With over 22 years of nurturing business, Digi Coffee House Group has one of the region’s most valuable
				brand portfolios, leading value share positions across multiple categories in North Africa.
				In a thriving industry with strong relative growth within the guest experience space, Digi Coffee House Group is uniquely positioned for sustained growth.</p>
			</div>
			<div class="col-12 selectBrandBtn">
				<a href="<?php echo base_url(); ?>index.php/Cust_home/select_brand" class="redBtn w-100">Select Your Brand</a>
			</div>
		</div>
	</div>
</main>
<?php $this->load->view('front/header/footer');  ?>
<?php 
$this->load->view('front/header/header'); 
$this->load->view('front/header/menu');   
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
/* 	$Total_topup_amt=$Enroll_details->Total_topup_amt;
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
		
	} */
?>
<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;">
			<!--<img style="height: 44px;" src="<?php echo base_url(); ?>assets/img/default-black-top.png">-->
			</div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
			
				<div class="leftRight"><button id="sidebarCollapse"><img src="<?php echo base_url(); ?>assets/img/menu.svg"></button></div>
				<div><img src="<?php echo base_url(); ?>assets/img/java-group-icon.svg"></div>
				<div class="leftRight"><button onclick="location.href = 'qr-code.html';"><img src="<?php echo base_url(); ?>assets/img/qrcode-scan.svg"></button></div>
			</div>
		</div>
	</div>
</header>

<main class="padTop padBottom">
	<div class="container">
		<div class="row">
            <div class="col-12 pointMainWrapper">
                <div class="CurrPoints">
                    <div class="d-flex align-items-center mb-3">
                        <div class="pointIcon"><img src="img/point-icon.svg"></div>
                        <div class="pointTxt">
                            <h2>8068 <span class="txt">Points</span></h2>
                            <h2><span class="txt">KES</span> 8068 </h2>
                        </div>
                    </div>
                    
                    <a href="qr-code.html" class="whiteBtn w-100 text-center">Redeem points</a>
                </div>
                <ul class="pointMenu">
                    <li>
                        <a href="points-history.html" class="cf w-100">
                            <div class="cardMain d-flex align-items-center">
                                <div class="icon"><img src="img/points-history-icon.svg"></div>
                                <div class="titleTxtMain">
									<h2>My Points History</h2>
									<div class="brandTxt">Lorem Ipsum is simply dummy text</div>
								</div>
                                <div class="rightIcon ml-auto"><img src="img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="stamp-select-your-brand.html" class="cf w-100">
                            <div class="cardMain d-flex align-items-center">
                                <div class="icon"><img src="img/stamp-collections-icon.svg"></div>
                                <div class="titleTxtMain">
									<h2>My Stamp Collections</h2>
									<div class="brandTxt">Lorem Ipsum is simply dummy text</div>
								</div>
                                <div class="rightIcon ml-auto"><img src="img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="vouchers.html" class="cf w-100">
                            <div class="cardMain d-flex align-items-center">
                                <div class="icon"><img src="img/vouchers-icon.svg"></div>
                                <div class="titleTxtMain">
									<h2>My Vouchers</h2>
									<div class="brandTxt">Lorem Ipsum is simply dummy text</div>
								</div>
                                <div class="rightIcon ml-auto"><img src="img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="gift-card.html" class="cf w-100">
                            <div class="cardMain d-flex align-items-center">
                                <div class="icon"><img src="img/giftcard-icon.svg"></div>
                                <div class="titleTxtMain">
									<h2>Gift Cards</h2>
									<div class="brandTxt">Lorem Ipsum is simply dummy text</div>
								</div>
                                <div class="rightIcon ml-auto"><img src="img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
		</div>
	</div>
</main>
<?php $this->load->view('front/header/footer');  ?>
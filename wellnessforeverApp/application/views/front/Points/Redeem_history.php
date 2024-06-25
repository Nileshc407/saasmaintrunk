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
				<div><img src="<?php echo base_url(); ?>assets/img/digicoffeehouselogoinApp.png"></div>
				<div class="leftRight"><button onclick="location.href = '<?php echo base_url(); ?>index.php/Cust_home/Redeem_points_QRCode';"><img src="<?php echo base_url(); ?>assets/img/qrcode-scan.svg"></button></div>
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
                        <div class="pointIcon"><img src="<?php echo base_url(); ?>assets/img/point-icon.svg"></div>
                        <div class="pointTxt">
                            <h2><?php echo $Current_point_balance; ?> <span class="txt"><?php echo $Currency_name; ?></span></h2>
                            <h2><span class="txt"><?php echo $Symbol_of_currency; ?></span> <?php echo ($Current_point_balance*$Redemptionratio); ?> </h2>
                        </div>
                    </div>
                    
                    <a href="<?php echo base_url().'index.php/Cust_home/Redeem_points_QRCode'; ?>" class="whiteBtn w-100 text-center">Redeem points</a>
                </div>
                <ul class="pointMenu">
                    <li>
                        <a href="<?php echo base_url().'index.php/Cust_home/Points_history'; ?>" class="cf w-100">
                            <div class="cardMain d-flex align-items-center">
                                <div class="icon"><img src="<?php echo base_url(); ?>assets/img/points-history-icon.svg"></div>
                                <div class="titleTxtMain">
									<h2>My Points History</h2>
									 <!--<div class="brandTxt">Lorem Ipsum is simply dummy text Lorem Ipsum</div>-->
								</div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url().'index.php/Cust_home/select_stamp_brand'; ?>" class="cf w-100">
                            <div class="cardMain d-flex align-items-center">
                                <div class="icon"><img src="<?php echo base_url(); ?>assets/img/stamp-collections-icon.svg"></div>
                                <div class="titleTxtMain">
									<h2>My Stamp Collections</h2>
									 <!--<div class="brandTxt">Lorem Ipsum is simply dummy text Lorem Ipsum</div>-->
								</div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url().'index.php/Cust_home/My_vouchers'; ?>" class="cf w-100">
                            <div class="cardMain d-flex align-items-center">
                                <div class="icon"><img src="<?php echo base_url(); ?>assets/img/vouchers-icon.svg"></div>
                                <div class="titleTxtMain">
									<h2>My Vouchers</h2>
									 <!--<div class="brandTxt">Lorem Ipsum is simply dummy text Lorem Ipsum</div>-->
								</div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
					<?php /* ?>
                    <li>
                        <a href="gift-card.html" class="cf w-100">
                            <div class="cardMain d-flex align-items-center">
                                <div class="icon"><img src="<?php echo base_url(); ?>assets/img/giftcard-icon.svg"></div>
                                <div class="titleTxtMain">
									<h2>Gift Cards</h2>
									 <!--<div class="brandTxt">Lorem Ipsum is simply dummy text Lorem Ipsum</div>-->
								</div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
					<?php */ ?>
                </ul>
            </div>
		</div>
	</div>
</main>

<?php $this->load->view('front/header/footer');  ?>
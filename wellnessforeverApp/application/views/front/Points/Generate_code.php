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


<main class="qrCodeWrapper">
	<div class="container">
		<div class="row">
			<div class="col-12">
                <div class="closeBtn"><a href="<?php echo base_url().'index.php/Cust_home/redeem_history'; ?>"><img src="<?php echo base_url(); ?>assets/img/close-icon1.svg"></a></div>
                <div class="qrCodeHldr">
                    <div class="logoMain"><img src="<?php echo base_url(); ?>assets/img/digicoffeehouselogo2.png"></div>
                    <h2><?php echo ($Enroll_details->First_name.' '.$Enroll_details->Last_name); ?></h2>
                    <div class="pointMain"><?php echo $Current_point_balance; ?> <span class="txt"><?php echo $Currency_name; ?></div>
                    <div class="qrCodeMain flex-column">
                        <div class="sucessfully">4 Digit Code Generated Sucessfully.</div>
                        <div class="codeMain"><?php echo $pin; ?></div>
                        <div class="expiresMain">Expires in 05 minutes</div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</main>
<?php //$this->load->view('front/header/footer');  ?>
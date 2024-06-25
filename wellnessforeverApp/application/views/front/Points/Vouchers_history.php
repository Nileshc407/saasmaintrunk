<?php 
$this->load->view('front/header/header'); 
$this->load->view('front/header/menu');   
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
	$ci_object = &get_instance(); 
	$ci_object->load->model('Igain_model');
?>


<header>

	<div class="container">
			<div class="row">
			<div class="col-12" style="height: 22px;">
			<!--<img style="height: 44px;" src="<?php echo base_url(); ?>assets/img/default-black-top.png">-->
			</div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
				<div class="leftRight"><button onclick="location.href = '<?php echo base_url(); ?>index.php/Cust_home/Redeem_history';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>Vouchers History</h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>

<main class="padTop padBottom">
	<div class="container vouchersWrapper">
		<?php 
		// print_r($Used_stamp_voucher);
		if($Used_stamp_voucher !=Null){ 
		?>
		<div class="row">
		<?php
			foreach($Used_stamp_voucher as $row){ 
				
				// echo "--Seller_id---".$row->Seller_id."----<br>";
					$SellerDetails1= $ci_object->Igain_model->get_enrollment_details($row->Seller_id);
					// echo "--Sub_seller_Enrollement_id---".$SellerDetails1->Sub_seller_Enrollement_id."----<br>";
					$SellerDetails= $ci_object->Igain_model->get_enrollment_details($SellerDetails1->Sub_seller_Enrollement_id);
					// echo "--First_name---".$SellerDetails->First_name.' '.$SellerDetails->Last_name."----<br>";
					
					$Lastname= substr($SellerDetails->Last_name,0,8);
					$Photograph=$SellerDetails->Photograph;
					
					?>
			<div class="col-6 pr-2">
				<div class="vouchersHldr">
                    <div class="logoMain"><img src="<?php echo base_url(); ?>assets/brand-<?php echo $row->Seller_id;?>/logo/logo.png"></div>
                    <h2><?php echo $row->Gift_card_id; ?></h2>
                    <div class="dateMain">&nbsp;&nbsp;&nbsp;&nbsp;Used on <?php echo date('d-M-Y',strtotime($row->Update_date)); ?></div>
                    <div class="usedTxt redTxt">USED</div>
                    <div class="discountHldr bgRed">
                        <?php echo $row->Offer_name; ?>
                    </div>
                </div>
			</div>
            <?php
					
				} ?>
		</div>
      <?php
					
				
				
			}
			if($Expired_stamp_voucher !=Null){ 
		?>
		<div class="row">
		<?php
			foreach($Expired_stamp_voucher as $row){ 
				
				// echo "--Seller_id---".$row->Seller_id."----<br>";
					$SellerDetails1= $ci_object->Igain_model->get_enrollment_details($row->Seller_id);
					// echo "--Sub_seller_Enrollement_id---".$SellerDetails1->Sub_seller_Enrollement_id."----<br>";
					$SellerDetails= $ci_object->Igain_model->get_enrollment_details($SellerDetails1->Sub_seller_Enrollement_id);
					// echo "--First_name---".$SellerDetails->First_name.' '.$SellerDetails->Last_name."----<br>";
					
					$Lastname= substr($SellerDetails->Last_name,0,8);
					$Photograph=$SellerDetails->Photograph;
					
					?>
			<div class="col-6 pr-2">
				<div class="vouchersHldr">
                    <div class="logoMain"><img src="<?php echo base_url(); ?>assets/brand-<?php echo $row->Seller_id;?>/logo/logo.png"></div>
                    <h2><?php echo $row->Gift_card_id; ?></h2>
                    <div class="dateMain">Expired on <?php echo date('d-M-Y',strtotime($row->Update_date)); ?></div>
                    <div class="usedTxt redTxt">EXPIRED</div>
                    <div class="discountHldr bgRed">
                        <?php echo $row->Offer_name; ?>
                    </div>
                </div>
			</div>
            <?php
					
				} ?>
		</div>
      <?php
			}

			if($Expired_stamp_voucher == Null && $Used_stamp_voucher == Null ){   ?>
			
				<div class="row">
							<div class="col-12 pr-2">
								<h6 class="text-center dark-bg p-2"><b>No records found</b></h6>
							</div>
						</div>
			<?php } ?>
	</div>
</main>
	
<?php $this->load->view('front/header/footer');  ?>
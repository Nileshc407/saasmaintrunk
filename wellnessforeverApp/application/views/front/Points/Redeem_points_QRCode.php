<?php 
$this->load->view('front/header/header'); 
$this->load->view('front/header/menu');   
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);

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
                    <div class="qrCodeMain">
                        <img src="<?php echo base_url(); ?>assets/img/qr-code.svg">
                    </div>
                </div>
                <a href="<?php echo base_url();?>index.php/Cust_home/Generate_code" class="whiteBtn w-100 text-center mt-5">Generate Code</a>
			</div>
		</div>
	</div>
</main>
<?php //$this->load->view('front/header/footer');  ?>
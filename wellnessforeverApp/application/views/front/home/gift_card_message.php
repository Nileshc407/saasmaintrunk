<?php $this->load->view('front/header/header');
$this->load->view('front/header/menu'); ?>
	
	<div class="custom-body">
		<div class="login-box point-transfer mt-3">
		<div class="msg-box confirmation">
			<a href="<?php echo base_url(); ?>index.php/Cust_home/front_home" class="close-icon"></a>
			<div class="confirm-icon text-center">
				<img src="<?php echo base_url(); ?>assets/img/confirm.png" class="img-fluid w-80">
				<p>Thanks for your Gift Card Purchase!</p>
			</div><br>
			
			<div class="text">
				<p><span class="value">Gift Card No :</span> <?php echo $gift_cardid; ?> </p>
				<p><span class="value">Amount :</span> <?php echo $Symbol_of_currency.' '.$gift_amt; ?> </p>
				<p><span class="value">Valid Till :</span> <?php echo $Valid_till; ?> </p>
				
			</div>
		</div>
		</div>
	</div>
<?php $this->load->view('front/header/footer'); ?>
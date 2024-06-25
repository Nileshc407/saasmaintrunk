<?php $this->load->view('front/header/header'); ?>
<body style="background-image:url('<?php echo base_url(); ?>assets/img/notification-bg.jpg')">
	<div id="wrapper">
		<div class="custom-header">
			<div class="container">
				<div class="heading-wrap">
					<div class="icon back-icon">
						<a href="<?php echo base_url(); ?>index.php/Cust_home/CheckoutGiftCard"></a>
					</div>
					<h2>Confirmation</h2>
				</div>
			</div>
		</div>
		<div class="custom-body msg-box-body">
			<div class="msg-box confirmation">
				<a href="<?php echo base_url(); ?>index.php/Cust_home/front_home" class="close-icon"></a>
				<div class="confirm-icon text-center">
					<img src="<?php echo base_url(); ?>assets/img/confirm.png" class="img-fluid w-80">
					<p>Thanks for your Gift Card Purchase!</p>
				</div>
				
				<div class="text">
					<p><span class="value">Gift Card No :</span> <?php echo $gift_cardid; ?> </p>
					<p><span class="value">Amount :</span> <?php echo $Symbol_of_currency.' '.$gift_amt; ?> </p>
					<p><span class="value">Valid Till :</span> <?php echo $Valid_till; ?> </p>
					
				</div>
			</div>
		</div>
<?php $this->load->view('front/header/footer'); ?>
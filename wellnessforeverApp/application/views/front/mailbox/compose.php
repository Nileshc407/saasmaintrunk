<?php  $this->load->view('front/header/header');  
$this->load->view('front/header/menu');  ?>
<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;"></div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
				<div class="leftRight"><button onclick="location.href = '<?php echo base_url();?>index.php/Cust_home/mailbox';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1><?php echo $Notifications->Offer; ?></h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>
<main class="padTop padBottom">
	<?php echo $Notifications->Offer_description; ?>
</main>
<?php $this->load->view('front/header/footer'); ?>
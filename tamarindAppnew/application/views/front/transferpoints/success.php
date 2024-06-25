<?php $this->load->view('front/header/header'); 
$this->load->view('front/header/menu');?>
	<!--<header>
		<div class="container">
			<div class="text-center">
				<div class="back-link">
					<a href="<?php //echo base_url();?>index.php/Cust_home/transferpointsApp"><span>Confirmation</span></a>
				</div>
			</div>
		</div>
	</header>-->
	<div id="custom-body">
		<div class="login-box point-transfer mt-3">
			<div class="msg-box confirmation">
				<a href="<?php echo base_url();?>index.php/Cust_home/front_home" class="close-icon"></a>
				<div class="confirm-icon text-center">
					<img src="<?php echo base_url(); ?>assets/images/confirm.png" class="img-fluid w-80">
					<p id="Message"><?php echo $Success_Message; ?></p><br>
				</div>
			</div>
		</div>
	</div>
<?php $this->load->view('front/header/footer');  ?>		
<style>
#Message
{
	color:<?php echo $MColor; ?>;
}
</style>
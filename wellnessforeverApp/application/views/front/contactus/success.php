<?php $this->load->view('front/header/header'); ?>
<body style="background-image:url('<?php echo base_url(); ?>assets/img/notification-bg.jpg')">
	<div id="wrapper">
		<div class="custom-header">
			<div class="container">
				<div class="heading-wrap">
					<div class="icon back-icon" onclick="window.location.href='<?php echo base_url();?>index.php/Cust_home/front_home'">
						<a href="#" ></a>
					</div>
					<h2>Confirmation</h2>
				</div>
			</div>
		</div>
		<div class="custom-body msg-box-body">
			<div class="msg-box confirmation">
				<a href="<?php echo base_url();?>index.php/Cust_home/front_home" class="close-icon"></a>
				<div class="confirm-icon text-center">
				<?php $Img='assets/img/'.$Img.'.png'; ?>
					<img src="<?php echo base_url(); ?><?php echo $Img; ?>" class="img-fluid w-80">
					<p id="Message"><?php echo $Success_Message; ?></p><br>
				</div>
			</div>
<?php $this->load->view('front/header/footer');  ?>		
<style>
#Message
{
	color:<?php echo $MColor; ?>;
}
</style>
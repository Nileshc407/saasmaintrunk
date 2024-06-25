<?php
$this->load->view('front/header/header');
$this->load->view('front/header/menu');
?>
	<div id="custom-body">
		<div class="login-box point-transfer mt-3">
			<div class="msg-box confirmation">
				<a href="<?php echo base_url();?>index.php/Cust_home/mailbox" class="close-icon"></a>
				<div class="confirm-icon text-center">
					<img src="<?php echo base_url(); ?>assets/images/confirm.png" class="img-fluid w-80">
					<p id="Message"><?php echo "<br>4 Digit Code Generated Successfully.."; ?></p>
					<p><?php echo "<br><b style='font-size: xx-large;'> $pin </b><br><br> Expires in $pin_valid_till minutes"; ?></p>
				</div>
			</div>
		</div>
	</div>
<?php $this->load->view('front/header/footer'); ?> 
<style>
#Message
{
	color:#00FF00;
}
</style>
<script>
/*function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            // timer = duration;
			window.location.href = "<?php echo base_url(); ?>index.php/Cust_home/front_home";
        }
    }, 1000);
}

window.onload = function () {
	var duration1 = '<?php echo $pin_valid_till; ?>';
    // var fiveMinutes = 60 * 5,
    var seconds = 60;
    var fiveMinutes = seconds * duration1,
        display = document.querySelector('#time');
    startTimer(fiveMinutes, display);
};*/
</script>
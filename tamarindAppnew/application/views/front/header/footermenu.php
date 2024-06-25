<?php if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?>
<div class="footer">	
		<div class="row" id="foot1">		
			<div class="col-xs-2 footer-xs" id="Footer_font">
				<a href="<?php echo base_url();?>index.php/Cust_home/mailbox"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/notification.png" class="img-responsive" id="flat"><br />
				
			</div>
		
			<div class="col-xs-2 footer-xs" id="Footer_font">
					<a href="<?php echo base_url();?>index.php/Shopping"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/menu.png" class="img-responsive" id="flat"><br />
					
			</div>
			
			<div class="col-xs-2 footer-xs" id="Footer_font">
				<a href="<?php echo base_url();?>index.php/Cust_home/front_home"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/home.png" class="img-responsive" id="flat"><br />
				
			</div>
			<div class="col-xs-2 footer-xs" id="Footer_font">
				<a href="<?php echo base_url();?>index.php/Cust_home/MerchantCommunication"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/offers.png" class="img-responsive" id="flat"><br />
				
			</div>
			<div class="col-xs-2 footer-xs" id="Footer_font">
				<a href="<?php echo base_url();?>index.php/Shopping/view_cart"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $foot_icon; ?>/cart.png" class="img-responsive" id="flat"><br />
				
			</div>
		</div>
	</div>
<?php 
$this->load->view('front/header/header');
// $this->load->view('front/header/menu'); 
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
?>
<header>
	<div class="container">
		<div class="text-center">
			<div class="back-link">
				<a href="<?php echo base_url();?>index.php/Cust_home/front_home"><span>Contact Us</span></a>
			</div>
		</div>
	</div>
</header>
<div class="custom-body">
	<div class="login-box mt-0">
		<div class="cart_list light-box contact">
			<h2 class="cont-hd">Booking Contact</h2>
				<div class="item p-0">
					<div class="infoin">
					<h2>Carnivore</h2>
					<div class="contact-dt">
						<b>NAIROBI</b>
						<dt>
							<a href="tel:0722 204647">+254 722204647</a>
							<a href="tel:0722 204648">+254 722204648</a>
							<a href="tel:0732 611606">+254 732611606</a>
							<a href="tel:0205 141300">+254 205141300</a>
						</dt>
					</div>
					</div>
					<?php if($smartphone_flag==2) { /*iOS*/ ?>
						<a href="tel://+254722204647">
							<div class="phone-icon"><img src="<?php echo base_url()?>/assets/images/call.svg"></div>
						</a>
					<?php } else { ?>
					
						<a href="JavaScript:void(0)" onclick="ok.performClick('+254-722-204-647');">
							<div class="phone-icon"><img src="<?php echo base_url()?>/assets/images/call.svg"></div>
						</a>
					<?php }  ?>
					
				</div>
				<hr>
					<div class="item p-0">
						<div class="infoin">
						<h2>Tamambo Karen</h2>
						<div class="contact-dt">
							<b>NAIROBI</b>
							<dt>
								<a href="tel:0719 346349">+254 719346349</a>
								<a href="tel:0719 865481">+254 719865481</a>
							</dt>
						</div>
						</div>
						<?php if($smartphone_flag==2) { /*iOS*/ ?>
							<a href="tel://+254719346349">
								<div class="phone-icon"><img src="<?php echo base_url()?>/assets/images/call.svg"></div>
							</a>
						<?php } else { ?>
						
							<a href="JavaScript:void(0)" onclick="ok.performClick('+254-719-346-349');">
								<div class="phone-icon"><img src="<?php echo base_url()?>/assets/images/call.svg"></div>
							</a>
						<?php }  ?>
					</div>
					<hr>
					<div class="item p-0">
						<div class="infoin">
						<h2>Roast by Carnivore</h2>
						<div class="contact-dt">
							<b>NAIROBI</b>
							<dt>
								<a href="tel:0702 722722">+254 702722722</a>
								<a href="tel:0701 715373">+254 701715373</a>
							</dt>
						</div>
						</div>
						<?php if($smartphone_flag==2) { /*iOS*/ ?>
							<a href="tel://+254702722722">
								<div class="phone-icon"><img src="<?php echo base_url()?>/assets/images/call.svg"></div>
							</a>
						<?php } else { ?>
						
							<a href="JavaScript:void(0)" onclick="ok.performClick('+254-702-722-722');">
								<div class="phone-icon"><img src="<?php echo base_url()?>/assets/images/call.svg"></div>
							</a>
						<?php }  ?>
					</div>
					<hr>
					<div class="item p-0">
						<div class="infoin">
						<h2>Kengele's Lavington</h2>
						<div class="contact-dt">
							<b>NAIROBI</b>
							<dt>
								<a href="tel:0700 554554">+254 700554554</a>
							</dt>
						</div>
						</div>
						<?php if($smartphone_flag==2) { /*iOS*/ ?>
							<a href="tel://+254700554554">
								<div class="phone-icon"><img src="<?php echo base_url()?>/assets/images/call.svg"></div>
							</a>
						<?php } else { ?>
						
							<a href="JavaScript:void(0)" onclick="ok.performClick('+254-700-554-554');">
								<div class="phone-icon"><img src="<?php echo base_url()?>/assets/images/call.svg"></div>
							</a>
						<?php }  ?>
					</div>
					<hr>
					<div class="item p-0">
						<div class="infoin">
						<h2>Tamarind Mombasa</h2>
						<div class="contact-dt">
							<b>NAIROBI</b>
							<dt>
								<a href="tel:0722 205160">+254 722205160</a>
								<a href="tel:0725 959552">+254 725959552</a>
								<a href="tel:041 4474600">+254 414474600</a>
								<a href="tel:041 4474601">+254 414474601</a>
								<a href="tel:041 4474602">+254 414474602</a>
							</dt>
						</div>
						</div>
						<?php if($smartphone_flag==2) { /*iOS*/ ?>
							<a href="tel://+254722205160">
								<div class="phone-icon"><img src="<?php echo base_url()?>/assets/images/call.svg"></div>
							</a>
						<?php } else { ?>						
							<a href="JavaScript:void(0)" onclick="ok.performClick('+254-722-205-160');">
								<div class="phone-icon"><img src="<?php echo base_url()?>/assets/images/call.svg"></div>
							</a>
						<?php } ?>
					</div>
					<hr>
					<div class="item p-0">
						<div class="infoin">
						<h2>Tamarind Tree Hotel</h2>
						<div class="contact-dt">
							<b>NAIROBI</b>
							<dt>
								<a href="tel:0719 240000">+254 719240000</a>
								<a href="tel:0709 240000">+254 709240000</a>
							</dt>
						</div>
						</div>
						<?php if($smartphone_flag==2) { /*iOS*/ ?>
							<a href="tel://+254719240000">
								<div class="phone-icon"><img src="<?php echo base_url()?>/assets/images/call.svg"></div>
							</a>
						<?php } else { ?>						
							<a href="JavaScript:void(0)" onclick="ok.performClick('+254-719-240-000');">
								<div class="phone-icon"><img src="<?php echo base_url()?>/assets/images/call.svg"></div>
							</a>
						<?php } ?>
					</div>
					<hr>
			
					<h2 class="cont-hd mb-1">Customer Care</h2>
						<div class="item p-0">
							<div class="infoin">
							<div class="contact-dt">
								<b>Email:</b>
								<dt class="ml-1"><a href="mailto:tamarind-treats@tamarind.co.ke">tamarind-treats@tamarind.co.ke</a></dt>
							</div>
							</div>
						</div>
						<hr>
					<h2 class="cont-hd mb-1">Follow us on</h2>
					<div class="item p-0 mb-0">
						<ul class="social-icon">
							<li><a href=""><img src="<?php echo base_url()?>/assets/images/facebook.svg"></a></li>
							<li><a href=""><img src="<?php echo base_url()?>/assets/images/twitter.svg"></a></li>
							<li><a href=""><img src="<?php echo base_url()?>/assets/images/instagram.svg"></a></li>
						</ul>
					</div>
			
		</div>
	</div>
</div>
<?php $this->load->view('front/header/footer');  ?>	
<?php 
$this->load->view('front/header/header'); 
$this->load->view('front/header/menu');  
$ci_object = &get_instance();
$ci_object->load->helper('encryption_val');
?>
<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;">
			<!--<img style="height: 44px;" src="<?php echo base_url(); ?>assets/img/default-black-top.png">-->
			</div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
			
				<div class="leftRight"><button id="sidebarCollapse" onclick="location.href = '<?php echo base_url(); ?>index.php/Cust_home/set_brand?brndID=<?php echo $_SESSION['brndID']; ?>';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>Location</h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>
<main class="padTop1">
	<div class="container">
		<div class="row">
			<div class="col-12 locationWrapper px-0">
				<div class="locationSearch">
                    <input type="text" placeholder="Search.." name="search">
                </div>
                <div class="locationHldr scrollbarMain">
                    <ul class="addressHldr">
                        <a target="_blank" href="https://maps.google.it/maps?q=<?php echo $BrandAddress; ?>">
                            <li class="d-flex align-items-center">
                                <div class="addImg">
                                    <img src="<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/logo/logo.png">
                                </div>
                                <div class="addressMain">
                                    
									
									
                                   <p><?php echo $BrandAddress; ?></p>
                                    <p><?php echo $BrandPhoneno; ?></p>
                                    <p><?php echo $Brandemail; ?></p>
                                </div>
                            </li>
                        </a>
						<?php 
						
							//print_r($Sub_Seller_details);
						
							if($Sub_Seller_details) {
								
								foreach($Sub_Seller_details as $seller)
								{
									
								
								?>
								
								<li class="d-flex align-items-center">
									<div class="addImg">
										<img src="<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/logo/logo.png">
									</div>
									<div class="addressMain">
										<p><?php echo App_string_decrypt($seller['Current_address']); ?></p>
										<p><?php echo App_string_decrypt($seller['Phone_no']); ?></p>
										<p><?php echo App_string_decrypt($seller['User_email_id']); ?></p>
									</div>
								</li>
							<?php } 
						} ?>
						
						
						
						
                    </ul>
                </div>
				<div class="map">
				
				<iframe width="640" height="480" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.it/maps?q=<?php echo $BrandAddress; ?>&output=embed"></iframe>

                    <!--<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.8518303744804!2d36.79978901530814!3d-1.2611551359563569!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f176b6c7c6349%3A0xfe581c3cea3aa14a!2sPlanet%20Yogurt%20Sarit!5e0!3m2!1sen!2sin!4v1631179150694!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy"></iframe>-->
                </div>
			</div>
		</div>
	</div>
</main>


<?php $this->load->view('front/header/footer');  ?>

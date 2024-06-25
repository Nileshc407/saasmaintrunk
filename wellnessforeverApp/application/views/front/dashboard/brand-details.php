<?php 
$this->load->view('front/header/header'); 
$this->load->view('front/header/menu');  
?>
<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;">
			<!--<img style="height: 44px;" src="<?php echo base_url(); ?>assets/img/default-black-top.png">-->
			</div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
			
				<div class="leftRight"><button id="sidebarCollapse" onclick="location.href = '<?php echo base_url(); ?>index.php/Cust_home/front_home';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>Select Your Brand</h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>
<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;">
				<!--<img style="height: 44px;" src="<?php echo base_url(); ?>assets/img/default-black-top.png">-->
			</div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
				<div class="leftRight"><button id="sidebarCollapse" onclick="location.href = '<?php echo base_url(); ?>index.php/Cust_home/select_brand';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><img src="<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/logo/logo.png" style="width:141px"></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>
<main class="padTop1 padBottom">
	<div class="container">
		<div class="row">
            
			<div class="col-12 brandHomeWrapper">
                <section class="brandHomeSliderHldr">
                    <div class="brandHomeSlide">
                        <div>
							<img src="<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/img/home-slide1.jpg" alt=" ">
						</div>
                        <!--<div>
							<img src="<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/img/home-slide1.jpg" alt=" ">
						</div>
                        <div>
							<img src="<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/img/home-slide1.jpg" alt=" ">
						</div>-->
                    </div>
                </section>
				<ul class="brandMenuHldr">
                    <li>
                        <a class="cf w-100" href="<?php echo base_url(); ?>index.php/Cust_home/special_offer">
                            <div class="cardMain d-flex align-items-center">
                                <div class="icon"><img src="<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/img/offer-icon.svg"></div>
                                <div class="titleTxtMain">
                                    <h2>Special Offers</h2>
                                    <!--<div class="brandTxt">Lorem Ipsum is simply dummy text Lorem Ipsum</div>-->
                                </div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="cf w-100" href="<?php echo base_url(); ?>index.php/Cust_home/aboutus">
                            <div class="cardMain d-flex align-items-center">
                                <div class="icon"><img src="<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/img/about-icon.svg"></div>
                                <div class="titleTxtMain">
                                    <h2>About Us</h2>
                                     <!--<div class="brandTxt">Lorem Ipsum is simply dummy text Lorem Ipsum</div>-->
                                </div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="cf w-100" href="<?php echo base_url(); ?>index.php/Cust_home/contactus_App">
                            <div class="cardMain d-flex align-items-center">
                                <div class="icon"><img src="<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/img/contact-us-icon.svg"></div>
                                <div class="titleTxtMain">
                                    <h2>Contact Us</h2>
                                     <!--<div class="brandTxt">Lorem Ipsum is simply dummy text Lorem Ipsum</div>-->
                                </div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="cf w-100" href="<?php echo base_url(); ?>index.php/Cust_home/location?brndID=<?php echo $_SESSION['brndID']; ?>">
                            <div class="cardMain d-flex align-items-center">
                                <div class="icon"><img src="<?php echo base_url(); ?>assets/brand-<?php echo $_SESSION['brndID']; ?>/img/location-icon.svg"></div>
                                <div class="titleTxtMain">
                                    <h2>Location</h2>
                                    <!--<div class="brandTxt">Lorem Ipsum is simply dummy text Lorem Ipsum</div>-->
                                </div>
                                <div class="rightIcon ml-auto"><img src="<?php echo base_url(); ?>assets/img/right-icon.svg"></div>
                            </div>
                        </a>
                    </li>
                </ul>
			</div>
		</div>
	</div>
</main>
<?php $this->load->view('front/header/footer');  ?>

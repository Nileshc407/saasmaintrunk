<?php $this->load->helper('form'); 
foreach($Company_details as $Company)
{
	$Company_name = $Company['Company_name'];
	$Company_id = $Company['Company_id'];
	$Company_address = $Company['Company_address'];
	$Company_primary_email_id = $Company['Company_primary_email_id'];
	$Website = $Company['Website'];
	$Company_primary_phone_no = $Company['Company_primary_phone_no'];
	$Company_logo = $Company['Company_logo'];
	$Cust_apk_link = $Company['Cust_apk_link'];
	$Cust_ios_link = $Company['Cust_ios_link'];	
	$Facebook_link = $Company['Facebook_link'];
	$Twitter_link = $Company['Twitter_link'];
	$Linkedin_link = $Company['Linkedin_link'];
	$Googlplus_link = $Company['Googlplus_link'];
	$Country = $Company['Country'];
	$Company_contactus_email_id = $Company['Company_contactus_email_id'];
}
foreach($Company_partner_cmp as $partnerCMP)
{
	$partner_cmp_name=$partnerCMP['Company_name'];
	$partner_cmp_website=$partnerCMP['Website'];
}
?>
 <?php /*
if(@$this->session->flashdata('error_code')) {
?>
<script>
	var Title = "Application Information";
	var msg = '<?php echo $this->session->flashdata('error_code'); ?>';
	alert(msg);
	// runjs(Title,msg);
	return false;
</script>
<?php } */ ?>

<html style="font-size: 16px;">
  <!DOCTYPE html>
<html lang="zxx">


<head>
    <meta charset="utf-8" />
    <title><?php echo $Company_name; ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="keywords" content="" />
    <!--<meta name="description" content="Sloppy - Food & Resturant Landing Page Template" />-->
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700;900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&amp;display=swap" rel="stylesheet">
    <!-- Favicon -->
    <!--<link rel="icon" type="image/png" href="<?php echo base_url() ; ?>foodassets/img/favicon.png">-->
    <!-- Site All Style Sheet Css -->
    <link href="<?php echo base_url() ; ?>foodassets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ; ?>foodassets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ; ?>foodassets/css/icofont.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ; ?>foodassets/css/et-line.css" rel="stylesheet" />
    <link href="<?php echo base_url() ; ?>foodassets/css/themify-icons.css" rel="stylesheet" />
    <link href="<?php echo base_url() ; ?>foodassets/css/magnific-popup.css" rel="stylesheet" />
    <link href="<?php echo base_url() ; ?>foodassets/css/animate.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ; ?>foodassets/css/owl.carousel.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ; ?>foodassets/css/owl.theme.default.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ; ?>foodassets/css/swiper.min.css" rel="stylesheet" />
    <!-- Site Main Style Sheet Css -->
    <link href="<?php echo base_url() ; ?>foodassets/css/style.css" rel="stylesheet" />
    <link href="<?php echo base_url() ; ?>foodassets/css/responsive.css" rel="stylesheet" />
</head>

<body>

    <!-- Start Preloader Area -->
    <div class="preloader">
        <div class="preloader-wapper">
            <div>
                <div class="spinner-loader"><div></div><div></div></div>
            </div>
        </div>
    </div>
    <!-- End Preloader Area -->

    <!-- Start Header Navbar Area -->
    <header class="header-navber-area">
        <div class="nav-top-bar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="call-to-action">
                            <p><i class="icofont-envelope"></i> Email: <a href="mailto:<?php echo $Company_primary_email_id; ?>"><?php echo $Company_primary_email_id; ?></a></p>
                            <p><i class="icofont-phone"></i> Phone: <a href="tel:<?php echo $Company_primary_phone_no; ?>"><?php echo $Company_primary_phone_no; ?></a></p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <ul class="top-social">
                            <li><a href="#"><i class="icofont-facebook"></i></a></li>
                            <li><a href="#"><i class="icofont-twitter"></i></a></li>
                            <li><a href="#"><i class="icofont-dribbble"></i></a></li>
                            <li><a href="#"><i class="icofont-behance"></i></a></li>
                            <li><a href="#"><i class="icofont-rss-feed"></i></a></li>
                        </ul>
                        <div class="opening-hours">
                            <p><i class="icofont-wall-clock"></i> Opening Hours : 8:30am - 10:30pm</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		 <?php
	$message = $this->session->flashdata('error_code');	
	if(isset($message))
	{ ?>
		<div class="alert alert-danger" role="alert">
		 <?php echo $message; ?>
		</div>
		
	<?php 	
		$this->session->unset_userdata('error_code');
	}
?>
        <nav class="navbar navbar-b navbar-trans navbar-expand-lg" id="mainNav"><?php if(!isset($_REQUEST['User_login'])){ ?>
            <div class="container">
                <a class="navbar-brand js-scroll" href="index.html">
                    <p class="white-logo"></p>
                    <p class="black-logo"></p>
                    <img src="<?php echo  $this->config->item('base_url2').''.$Company_logo;?>" class="white-logo" alt="logo" style="width:115px;height:65px;">
                    <img src="<?php echo  $this->config->item('base_url2').''.$Company_logo;?>" class="black-logo" alt="logo" style="width:115px;height:65px;">
                </a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation"> <span></span>  <span></span>  <span></span> 
                </button>
				
                <div class="navbar-collapse collapse justify-content-end" id="navbarDefault">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link js-scroll active" href="#slider-home">Home</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll" href="#about">About</a></li>
                         <li class="nav-item"><a class="nav-link js-scroll" href="#gallery">Gallery</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll" href="#menu">How it works</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll" href="#login">Sign in</a></li>
						<li class="nav-item"><a class="nav-link js-scroll" href="#contact">Contact</a></li>
					</ul>
				</div>
				
</div><?php } ?>
</nav>
</header>
<!-- End Header Navbar Area -->
<?php if(!isset($_REQUEST['User_login'])){ ?>
<!-- Start Slider Are -->
<header id="slider-home" class="slider slider-prlx">
    <div class="swiper-container parallax-slider">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="bg-img valign" data-background="<?php echo base_url() ; ?>foodassets/img/slider-2.jpg" data-overlay-dark="6">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2 col-md-12">
                                <div class="caption">
                                    <h1>Delicious Food</h1>
                                    <p>These are specifically for the type of food that the hotel caters to their guests. Hotel Guest and Customer Feedback Forms – Specifically for the customers</p>
<!-- <div class="home-button-box home-slider-btn">
<a href="#about" class="button home-btn-1 js-scroll ">Discover More</a>
<a href="#0" class="button home-btn-2 js-scroll">Book a Table</a>
</div> -->
</div>
</div>
</div>
</div>
</div>
</div>
<div class="swiper-slide">
    <div class="bg-img valign" data-background="<?php echo base_url() ; ?>foodassets/img/slide.jpg" data-overlay-dark="6">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-12">
                    <div class="caption">
                        <h1>Family Food Recipes</h1>
                        <p>These are specifically for the type of food that the hotel caters to their guests. Hotel Guest and Customer Feedback Forms – Specifically for the customers</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- slider setting -->
<div class="control-text">
    <div class="swiper-button-prev swiper-nav-ctrl prev-ctrl cursor-pointer">
        <span class="arrow prv"></span>
    </div>
    <div class="swiper-button-next swiper-nav-ctrl next-ctrl cursor-pointer">
        <span class="arrow nxt"></span>
    </div>
</div>
<div class="swiper-pagination"></div>
</div>
</header>
<!-- End Slider Area -->

<!-- About Section Start -->
<section id="about" class="about-area section-padding">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12 wow fadeInLeft" data-wow-delay="0.2s">
                <div class="about-content">
                    <div class="about-content-text">
                        <h5> Welcome Dear Member!!!</h5>
                        <h2>Just ​Shop, Share and Earn</h2>
                        <p>Get Rewarded for being our Customer. <?php echo '<b>'.$Loyalty_name.'</b>'; ?> is the name​ of
						our Loyalty program. </p><p>It is our way of saying thank you for being a patron. We reward you with
						Loyalty points whenever you purchase of our business outlets or just follow us
						on social media !</p><p>We want our loyal customers the best of the Experiences for being part of our
						community! Enjoy the journey with us!</p>
                        

                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 wow fadeInLeft" data-wow-delay="0.4s">
                <div class="about-image">
                    <img src="<?php echo base_url() ; ?>foodassets/img/abt.jpg" alt="About image">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Section End -->

<!-- Shop Now Section Start -->
<section id="menu" class="shop-area section-padding">
    <div class="container">
        <div class="section-title">
            <h5>How you can start</h5>
            <h2>EARNING POINTS</h2>
        </div>
        <div class="col-md-12">
            <div class="row">
                <!-- <div id="product-shop-slide" class="owl-carousel owl-theme owl-loaded owl-drag"> -->
                    <div class="col-md-3">
                        <div class="product-shop-item">
                            <div class="product-item-content">
                                <!--<div class="shop-ribbon">45% Off</div>-->
                                <div class="item-image img-align">
                                    <a href="#" class="product-item-image-link"><img src="<?php echo base_url() ; ?>foodassets/img/shop/PurchaseN.png" alt="shop-image"></a>
<!--  <div class="item-add-to-cart">
<ul class="cart">
<li><a href="#" class="product-item-cart-link"><i class="fa fa-shopping-cart"></i></a></li>
<li><a href="#" class="product-item-cart-link"><i class="fa fa-heart"></i></a></li>
</ul>
</div> -->
</div>
<div class="product-item-details">
    <h3>Purchase</h3>
    <p>Get <?php echo round($Loyalty_at_transaction); ?> Points when you do your 100 <?php echo $Symbol_of_currency; ?></p>

</div>
</div>
</div>
</div>
<div class="col-md-3">
    <div class="product-shop-item">
        <div class="product-item-content">
            <!--<div class="shop-ribbon">30% Off</div>-->
            <div class="item-image img-align">
                <a href="#" class="product-item-image-link"><img src="<?php echo base_url() ; ?>foodassets/img/shop/joiningN.png" alt="shop-image"></a>

            </div>
            <div class="product-item-details">
                <h3>Joining</h3>
                <p><?php if($Joining_bonus_points > 0){ echo $Joining_bonus_points;}else{echo 'X';} ?> Points when you join our loyalty program</p>

            </div>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="product-shop-item">
        <div class="product-item-content">
            <!--<div class="shop-ribbon">30% Off</div>-->
            <div class="item-image img-align">
                <a href="#" class="product-item-image-link"><img src="<?php echo base_url() ; ?>foodassets/img/shop/refern.png" alt="shop-image"></a>

            </div>
            <div class="product-item-details">
                <h3>Refferal</h3>
                <p>X Points when you refer your friend to join our program</p>

            </div>
        </div>
    </div>
</div>
<div class="col-md-3">
    <div class="product-shop-item">
        <div class="product-item-content">
            <!--<div class="shop-ribbon">30% Off</div>-->
            <div class="item-image img-align">
                <a href="#" class="product-item-image-link"><img src="<?php echo base_url() ; ?>foodassets/img/shop/sharen.png" alt="shop-image"></a>

            </div>
            <div class="product-item-details">
                <h3>Share on media</h3>
                <p>X Points when you share on Social Media</p>

            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</section>
<!-- Contact Section Start -->
<!-- Gallery Section Start -->
<section id="gallery" class="gallery-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="section-title">
                    <h5>Delicious Food Gallery</h5>
                    <h2>Happy Customer</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <!--<div class="col-md-12">-->
            <!--    <div class="gallery-list">-->
            <!--        <ul class="nav" id="gallery-flters">-->
            <!--            <li class="filter filter-active" data-filter=".all">all</li>-->
            <!--            <li class="filter" data-filter=".breakfast">Break Fast</li>-->
            <!--            <li class="filter" data-filter=".lunch">Lunch</li>-->
            <!--            <li class="filter" data-filter=".dinner">Dinner</li>-->
            <!--            <li class="filter" data-filter=".dessert">Dessert</li>-->
            <!--        </ul>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="gallery-container">
                <!-- gallery-item -->
                <div class="col-lg-4 col-md-6 gallery-grid-item all lunch dessert">
                    <div class="gallery-item">
                        <img src="<?php echo base_url() ; ?>foodassets/img/gallery/gallery-1.jpg" alt="image">
                        <div class="gallery-img-overlay">
                            <div class="gallery-content">
                                <div class="info">
                                    <h6>Break Fast</h6>
                                </div>
                                <a href="<?php echo base_url() ; ?>foodassets/img/gallery/gallery-1.jpg" class="popimg"> 
                                    <span class="icon"><i class="icon-pictures"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- gallery-item -->
                <div class="col-lg-4 col-md-6 gallery-grid-item all dinner breakfast">
                    <div class="gallery-item">
                        <img src="<?php echo base_url() ; ?>foodassets/img/gallery/gallery-2.jpg" alt="image">
                        <div class="gallery-img-overlay">
                            <div class="gallery-content">
                                <div class="info">
                                    <h6>Lunch</h6>
                                </div>
                                <a href="<?php echo base_url() ; ?>foodassets/img/gallery/gallery-2.jpg" class="popimg"> 
                                    <span class="icon"><i class="icon-pictures"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- gallery-item -->
                <div class="col-lg-4 col-md-6 gallery-grid-item all lunch dessert">
                    <div class="gallery-item">
                        <img src="<?php echo base_url() ; ?>foodassets/img/gallery/gallery-3.jpg" alt="image">
                        <div class="gallery-img-overlay">
                            <div class="gallery-content">
                                <div class="info">
                                    <h6>Dinner</h6>
                                </div>
                                <a href="<?php echo base_url() ; ?>foodassets/img/gallery/gallery-3.jpg" class="popimg"> 
                                    <span class="icon"><i class="icon-pictures"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</section>
<?php } ?>
<!-- Gallery Section End -->
<section id="login" class="contact-area section-padding">
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-6 col-md-12 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="col-lg-12 col-md-12">
                        <div class="section-title">
                            <h2>Sign In Now</h2>
                           <?php if(!isset($_REQUEST['User_login'])){ ?>  <p>Allready a Member</p><?php } ?>
                        </div>
                    </div>
                    
                    <div class="form-container-box">
                        <form class="contact-form form" id="contact-form"  method="POST">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <input id="cust_email" type="email" name="email" placeholder="Enter Your Email Address" required="required" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <input id="Cust_password" type="password" name="password" placeholder="Enter Your Password" required="required" />
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="button"  <?php if(!isset($_REQUEST['User_login'])){ ?> onclick="javascript:Member_login(Cust_password.value,cust_email.value);" <?php }else{?> onclick="javascript:Merchant_login(Cust_password.value,cust_email.value);"<?php } ?>>Submit</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
				<?php if(!isset($_REQUEST['User_login'])){ ?>
                <div class="col-lg-6 col-md-12 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="col-lg-12 col-md-12">
                        <div class="section-title">
                            <h2>Sign up Now</h2>
                            <p>Not a Member yet?</p>
                        </div>
                    </div>
                   
                    <div class="form-container-box">
                        <form class="contact-form form" id="contact-form"  method="POST">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <input id="first_name" type="text" name="first_name" placeholder="Enter Your First Name" required="required" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <input id="last_name" type="text" name="last_name" placeholder="Enter Your Last Name" required="required" />
                                    </div>
                                </div>
                               
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <input id="phno" type="text" name="phno" placeholder="Enter Your Mobile No" required="required" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <input id="email_id" type="email" name="email" placeholder="Enter Your Email Address" required="required" />
                                    </div>
                                </div>
                              
                                <div class="col-md-12">
                                    <button type="submit" class="button"  onclick="javascript:Member_registration(first_name.value,last_name.value,phno.value,email_id.value);" >Submit</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
				<?php } ?>
            </div>
        </div>
    </div>
</section>
<?php if(!isset($_REQUEST['User_login'])){ ?>
<section id="contact" class="contact-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="section-title">
                    <h5>Contact us</h5>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="contact-box">
                    <h3><?php echo $Company_name; ?></h3>
                    <p><a href="#"><i class="icofont-google-map"></i> <?php echo $Company_address; ?></a></p>
                    <p><a class="contact-info-link" href="tel:50530722233"><i class="icofont-phone"></i> <?php echo $Company_primary_phone_no; ?></a></p>
                    <p><a class="contact-info-link" href="mailto:info@example.com"><i class="icofont-envelope"></i><?php echo $Company_primary_email_id; ?></a></p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="contact-box">
                    <h3>Opening Hours</h3>
                    <p class="opening-hours">Sun - Fri </p>
                    <p class="opening-hours">Saturday</p>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- Contact Section End -->

<!-- Footer Section Start -->
<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="footer-copyright-text">
                    <p>Powered By MiracleCartes</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="footer-link">
				<div class="footer-copyright-text">
                    <p> © Copyright 2020-2025 Miracle Smart Cards Pvt Lvt. All rights reserved </p>
                </div>
                   
                </div>
            </div>
        </div>
    </div>
</footer><?php } ?>
<!-- Footer Section End -->

<!-- Back to Top Start -->
<div class="back-to-top">
    <i class="fa fa-caret-up"></i><i class="fa fa-caret-up"></i>
</div>
<!-- Back to Top End -->

<!-- Site All Jquery Js -->
<script src="<?php echo base_url() ; ?>foodassets/js/jquery-3.5.1.min.js"></script>
<script src="<?php echo base_url() ; ?>foodassets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url() ; ?>foodassets/js/plugins.js"></script>
<script src="<?php echo base_url() ; ?>foodassets/js/swiper.min.js"></script>
<script src="<?php echo base_url() ; ?>foodassets/js/wow.min.js"></script>
<!--Site Main js-->
<script src="<?php echo base_url() ; ?>foodassets/js/main.js"></script>
</body>


</html>
<div id="loadingDiv" style="display:none;">
		<div>
			<h7>Please wait...</h7>
		</div>
	</div>
<script>
function Member_registration(first_name,last_name,phno,email_id)
{
	// alert('first_name '+first_name+'  last_name '+last_name+'  phno '+phno+'  email_id '+email_id);
	if(first_name=="")
	{
		var Title = "Application Information";
		var msg = "Please Enter First Name !!!";
		$('#membererror').show();
		$('#membererror2').html(msg);
		// runjs(Title,msg);
		return false;
	}
	if(last_name=="")
	{
		var Title = "Application Information";
		var msg = "Please Enter Last Name !!!";
		$('#membererror').show();
		$('#membererror2').html(msg);
		// runjs(Title,msg);
		return false;
	}
	if(phno=="")
	{
		var Title = "Application Information";
		var msg = "Please Enter Mobile No. !!!";
		$('#membererror').show();
		$('#membererror2').html(msg);
		// runjs(Title,msg);
		return false;
	}
	if(email_id=="")
	{
		var Title = "Application Information";
		var msg = "Please Enter Email ID !!!";
		$('#membererror').show();
		$('#membererror2').html(msg);
		// runjs(Title,msg);
		return false;
	}
	document.getElementById("loadingDiv").style.display="";
	var Company_id=<?php echo $Company_id; ?>;
	var Country=<?php echo $Country; ?>;
	// alert('<?php echo base_url()?>index.php/Cust_home/enroll_new_member_website/?first_name='+first_name+'&last_name='+last_name+'&phno='+phno+'&email='+email_id+'&Company_id='+Company_id);
	
	window.location='<?php echo base_url()?>index.php/Cust_home/enroll_new_member_website/?first_name='+first_name+'&last_name='+last_name+'&phno='+phno+'&userEmailId='+email_id+'&Company_id='+Company_id+'&Country='+Country+'&flag=1';
}
function Member_login(password,username)
{
	// alert('username '+username+'  password '+password);
	if(username=="")
	{
		var Title = "Application Information";
		var msg = "Please Enter User Email ID !!!";
		$('#membererror').show();
		$('#membererror2').html(msg);
		// runjs(Title,msg);
		return false;
	}
	if(password=="")
	{
		var Title = "Application Information";
		var msg = "Please Enter Password !!!";
		$('#membererror').show();
		$('#membererror2').html(msg);
		// runjs(Title,msg);
		return false;
	}
	document.getElementById("loadingDiv").style.display="";
	// alert('<?php echo base_url()?>index.php/login/?flag=2&email='+username+'&password='+password);
	window.location='<?php echo base_url()?>index.php/login/?flag=2&email='+username+'&password='+password;
}
function Merchant_login(password,username)
{
	// alert('username '+username+'  password '+password);
	if(username=="")
	{
		var Title = "Application Information";
		var msg = "Please Enter User Email ID !!!";
		$('#usererror').show();
		$('#erroruser').html(msg);
		// alert(msg);
		// runjs(Title,msg);
		return false;
	}
	if(password=="")
	{
		var Title = "Application Information";
		var msg = "Please Enter Password !!!";
		$('#usererror').show();
		$('#erroruser').html(msg);
		// alert(msg);
		// runjs(Title,msg);
		return false;
	}
	
	
	var Company_id=<?php echo $Company_id; ?>;
	// alert('Company_id '+Company_id);
	document.getElementById("loadingDiv").style.display="";
	window.location='<?php echo $this->config->item('base_url2')?>index.php/Login/?username='+username+'&password='+password+'&Company_id='+Company_id;
}
function MemberForgotPassword(Forgotemail)
{
	// alert('Forgotemail '+Forgotemail);
	if(Forgotemail=="")
	{
		var Title = "Application Information";
		var msg = "Please Enter User Email ID !!!";
		$('#membererror').show();
		$('#membererror2').html(msg);
		// alert(msg);
		// runjs(Title,msg);
		return false;
	}
	var Company_id=<?php echo $Company_id; ?>;
	document.getElementById("loadingDiv").style.display="";
	window.location='<?php echo base_url()?>index.php/Cust_home/forgot/?flag=2&email='+Forgotemail+'&Company_id='+Company_id;
}
function ForgotPassword(Forgotemail)
{
	// alert('Forgotemail '+Forgotemail);
	if(Forgotemail=="")
	{
		var Title = "Application Information";
		var msg = "Please Enter User Email ID !!!";
		$('#usererror').show();
		$('#erroruser').html(msg);
		// alert(msg);
		// runjs(Title,msg);
		return false;
	}
	var Company_id=<?php echo $Company_id; ?>;
	document.getElementById("loadingDiv").style.display="";
	window.location='<?php echo $this->config->item('base_url2')?>index.php/Login/Send_password_website/?email='+Forgotemail+'&Company_id='+Company_id;
}
$('#phno').change(function()
{	
	var Country = '<?php echo $Country; ?>';
	var Company_id = '<?php echo $Company_id; ?>';
	var phno = $('#phno').val();	
	
		$.ajax({
			type: "POST",
			data: { phno: phno,Company_id:Company_id, Country:Country},
			url: "<?php echo base_url()?>index.php/Cust_home/check_phone_number",
			success: function(data)
			{
				if(data == 1)
				{
					$("#phno").val("");
					
					var Title = "Application Information";
					var msg = 'Phone Number Already Exist';
					$('#membererror').show();
					$('#membererror2').html(msg);
					// runjs(Title,msg);
					return false;					
				}
				else
				{
				}
			}
		});
	
});
 
$('#userEmailId').change(function()
{	
	var Company_id = '<?php echo $Company_id; ?>';
	var userEmailId = $('#userEmailId').val();
	
		$.ajax({
			type: "POST",
			data: { userEmailId: userEmailId, Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/Cust_home/check_email_id",
			success: function(data)
			{
				if(data == 1)
				{
					$("#userEmailId").val("");
					document.getElementById('userEmailId').placeholder="Email Id Already Exist!";
					var Title = "Application Information";
					var msg = 'Email Id Already Exist';
					$('#membererror').show();
					$('#membererror2').html(msg);
					return false;
				
				}
				else
				{
					/* var Title = "Application Information";
					var msg = 'Please Enter Email Id';
					runjs(Title,msg);
					return false; */
				}
			}
		});
	
});
		
function Send_password(Email_id)
{		
	
	var email_id = $('#email_id').val();
	if( email_id == "" )
	{
		document.getElementById("email_id").placeholder="Please Enter Email Address !!!";
	}
	else
	{
		show_loader();
		$.ajax(
		{
			type: "POST",
			data:{ Email_id:Email_id,flag:'2'},
			url: "<?php echo $this->config->item('base_url2')?>index.php/Login/Send_password",
			success: function(data)
			{
				
				if(data.length == 25)
				{					
					BootstrapDialog.show({
						closable: false,
						title: 'Valid Data Operation',
						message: 'Password sent to your Email Address Successfuly !!!',
						buttons: [{
							label: 'OK',
							action: function(dialog) 
							{
								location.reload(); 
							}
						}]
					});					
				} 
				else
				{
					BootstrapDialog.show({
						closable: false,
						title: 'In-Valid Data Operation',
						message: 'Password Not Sent!!!',
						buttons: [{
							label: 'OK',
							action: function(dialog) 
							{
								location.reload(); 
							}
						}]
					});
				}
			}
		});	
	}	
}

$( document ).ready( function() {
	$('.carousel').carousel();
});
</script>
<style>
.topmenu{
	margin-left:10%;font-size: 18px;line-height: 52px;font-weight: 700;
}
.color-heading {
    color: #eef2f7;
}
#loadingDiv
{
  position:fixed;
  top:0px;
  right:0px;
  width:100%;
  height:100%;
  background-color:#666;
  background-image:url('<?php echo $this->config->item('base_url2') ?>images/loading.gif');
  background-repeat:no-repeat;
  background-position:center;
  z-index:10000000;
  opacity: 0.4;
  filter: alpha(opacity=40); /* For IE8 and earlier */
}

.alert2 {
  padding: 20px;
  background-color: #25dac5;
  color: white;
      width: 80%;
    margin-left: 10%;
}

.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

.closebtn:hover {
  color: black;
}
</style>
		
<?php $this->load->helper('form'); ?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>iGainSPark | Log in</title>
	<!-- core CSS -->
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/owl.transitions.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/prettyPhoto.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/main.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/responsive.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/AdminLTE.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="<?php echo $this->config->item('base_url2')?>images/logo_igain.ico">
	<script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/jquery.js"></script>
	<script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/bootstrap.min.js"></script>
	<link href="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
	<script src="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/js/bootstrap-dialog.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->config->item('base_url2')?>assets/bootstrap-dialog/js/alert_function.js"></script>
	
	
</head>

<?php
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
}

foreach($Company_partner_cmp as $partnerCMP)
{
	$partner_cmp_name=$partnerCMP['Company_name'];
	$partner_cmp_website=$partnerCMP['Website'];
}
?>
			
<body id="home" class="homepage">
<?php
if(@$this->session->flashdata('login_success'))
{
?>
	<script>
		var Title = "Application Information";
		var msg = '<?php echo $this->session->flashdata('login_success'); ?>';
		runjs(Title,msg);
	</script>
<?php
}			// var_dump($Enroll_details);
?>
    <header id="header">
        <nav id="main-menu" class="navbar navbar-default navbar-fixed-top" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo $this->config->item('base_url'); ?> ">
						<!--<img src="http://demo.igainspark.com/companyLogos/mumbaikar.jpg" height="57" alt="logo">-->
						<img src="<?php echo $this->config->item('base_url2').$Company_logo; ?>" height="57" alt="logo">
					</a>
                </div>
				
                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="scroll active"><a href="#home">Home</a></li>
                        <li class="scroll"><a href="#services">Loyalty Points</a></li>
                        <li class="scroll"><a href="#portfolio">Our Merchants</a></li>
                        <li class="scroll"><a href="#about">About Us</a></li>
                        <li class="scroll"><a href="#meet-team">Contact Us</a></li>                        
                        <li class="scroll"><a href="#" data-toggle="modal" data-target="#Cust_login_Modal">Customer Login</a></li>  
                                            
                        <li class="scroll"><a href="<?php echo $this->config->item('base_url2'); ?>" target="_blank">Merchant Login</a></li>                        
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
    </header><!--/header-->

    <section id="main-slider">
        <div class="owl-carousel">
            <div class="item" style="background-image: url(<?php echo $this->config->item('base_url2')?>assets/portal_assets/images/slider/bg1.jpg);">
                <div class="slider-inner">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="carousel-content">
                                    <h2><span>ACCUMULATE REWARD POINTS</span></h2>
									<h4 style="color:#fff;">WHENEVER YOU BUY AT ANY OF OUR SERVICE OUTLETS</h4>
                                    <p>We not only give you good service but also reward you for helping us serve you!  Come and Experience Service Par Excellence!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/.item-->
             <div class="item" style="background-image: url(<?php echo $this->config->item('base_url2')?>assets/portal_assets/images/slider/bg2.jpg);">
                <div class="slider-inner">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="carousel-content">
                                    <h2><span>OFFERS RAINING !</span> </h2>
									<h4 style="color:#fff;">RUSH AND GET IT!</h4>
                                    <p>We Pamper our Loyal Customers of the Ongoing Offers ! We also let them know their Next Service due for their Vehicle!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--/.item-->
        </div><!--/.owl-carousel-->
    </section><!--/#main-slider-->

    <section id="services" >
        <div class="container">

            <div class="section-header">
                <h2 class="section-title text-center wow fadeInDown">Loyalty Points Rewards</h2>
            </div>

            <div class="row">
                <div class="features">
                    <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="0ms">
                        <div class="media service-box">
                            <div class="pull-left">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">How to Earn Points</h4>
                                <p>Just walk into any of our outlets , request for the enrolment form from any of our representatives in the lounge, fill the form and hand it back to them. You get instantly enrolled on the program and your membership card is handed to you. Also You instantly get an email with your login details, membership number and PIN to your loyalty account, plus a link with which you can download our easy to use mobile app</p>
                            </div>
                        </div>
                    </div><!--/.col-md-4-->

                    <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="100ms">
                        <div class="media service-box">
                            <div class="pull-left">
                                <i class="fa fa-thumbs-up"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">How to Accumulate Points</h4>
                                <p>Points can be accumulated whenever you make payments for services purchased at any of our outlets. Simply inform the representative that you would like to accumulate your loyalty points after you must have been handed your payment receipt. The staff in charge will request for your loyalty card and loyalty membership number and also the payment receipt. These information are then inputted on the loyalty platform with the amount paid, and the equivalent points to the payment made is then stored on the loyalty account. A confirmation email is immediately sent to the customer, with details of the transaction clearly stated.</p>
                            </div>
                        </div>
                    </div><!--/.col-md-4-->

                    <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="200ms">
                        <div class="media service-box">
                            <div class="pull-left">
                                <i class="fa fa-leaf"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">How to redeem points</h4>
                                <p>Points accumulated over a period of time can be redeemed at any our locations from the first day of accumulation. Walk into our outlet, go through the menu, and decide on the items you would like to purchase. Also take note of the points equivalent of the price in Euros. Make your choice and inform the staff of you intention to redeem your loyalty points. Your food and drinks will be prepared for you, and your loyalty points deducted. An email with the details of the transaction would be sent your registered email address, while a notification is sent to your mobile app.</p>
                            </div>
                        </div>
                    </div><!--/.col-md-4-->
                
                </div>
            </div><!--/.row-->    
        </div><!--/.container-->
    </section><!--/#services-->

    <section id="portfolio">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title text-center wow fadeInDown">Our Merchants</h2>
                <p class="text-center wow fadeInDown">Here are some of our Merchants where points can be gained and redeemed</p>
            </div>

            <article class="entry">
				<div class="entry-content">
					<div class="google-map-wrap" itemscope itemprop="hasMap" itemtype="http://schema.org/Map">
						<div id="google-map" class="google-map"></div>
					</div>
					
					<?php
					$locations = array();
					foreach ($Seller_details as $row) 
					{
						$Latitude=$row['Latitude'];
						$Longitude=$row['Longitude'];
						$Current_address=$row['Current_address'];
						$name=$row['First_name'].' '.$row['Last_name'];
						
						$locations[] = array
						(
							'google_map' => array(
								'lat' => $Latitude,
								'lng' => $Longitude,
							),
							'location_address' => $Current_address,
							'location_name'    => $name,
						);
					}
					$map_area_lat = isset( $locations[0]['google_map']['lat'] ) ? $locations[0]['google_map']['lat'] : '';
					$map_area_lng = isset( $locations[0]['google_map']['lng'] ) ? $locations[0]['google_map']['lng'] : '';
					?>
					
					<script>
						jQuery( document ).ready( function($) 
						{
							var is_touch_device = 'ontouchstart' in document.documentElement;
							var map = new GMaps(
							{
								el: '#google-map',
								lat: '<?php echo $map_area_lat; ?>',
								lng: '<?php echo $map_area_lng; ?>',
								scrollwheel: false,
								draggable: ! is_touch_device
							});
							var bounds = [];

							<?php
							foreach( $locations as $location )
							{												
								$name = trim($location['location_name']);
								$addr = trim($location['location_address']);
								$map_lat = $location['google_map']['lat'];
								$map_lng = $location['google_map']['lng'];
							?>
								
								var latlng = new google.maps.LatLng(<?php echo $map_lat; ?>, <?php echo $map_lng; ?>);
								bounds.push(latlng);													
								map.addMarker(
								{
									lat: <?php echo $map_lat; ?>,
									lng: <?php echo $map_lng; ?>,
									title: '<?php echo $name; ?>',
									infoWindow: 
									{
										content: '<p><?php echo $name.'-'.$addr ?></p>'
									}
								});
							<?php } ?>

							map.fitLatLngBounds(bounds);
							var $window = $(window);
							function mapWidth()
							{
								var size = $('.google-map-wrap').width();
								$('.google-map').css({width: size + 'px', height: (size/2) + 'px'});
							}
							mapWidth();
							$(window).resize(mapWidth);
						});
					</script>
					
				</div>
			</article>
			
        </div>
    </section>

    <section id="about">
        <div class="container">

            <div class="section-header">
                <h2 class="section-title text-center wow fadeInDown">About Us</h2>
            </div>

             <div class="row">
                <div class="col-sm-12 wow fadeInRight">
                    <h3 class="column-title">About Loyalty Program</h3>
                    <p>The Red Reward Loyalty program was designed to reward all our loyal customers who have been with us over the years. We have kept improving on the benefits on offer, and have continuously made it better every year. We want to include many more members offering complementary products and
					services. Benefits of being a loyalty member and card holder are numerous.They include;</p>

                    <ul style="font-size: 13px;font-family:'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif">
					<li>Exclusive access to the Cafe lounge</li>
					<li>Exclusive access to the Book Festival held twice a Year by Book Shop</li>
					<li>Exclusive access to flowers buke for shows,Festival and events in our Flower Shop</li>
					<li>Pass for Flower Exhibition held in the Suite 308, Level 3, NG Tower, Ebene Cybercity, Mauritius held twice a Year</li>
					<li>In every Event you stand a chance to win exciting prizes and gifts</li>
					
					</ul>

                </div>
            </div>
        </div>
    </section><!--/#about-->
	
	<section id="meet-team">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title text-center wow fadeInDown">Contact Us</h2>
            </div>

            <div class="divider"></div>

            <div class="row">
                <div class="col-sm-4">
                    <h3 class="column-title">Our Address</h3>
					
					<?php
					foreach($Company_details as $Company) {
					?>
					<address>
						<h4><strong><?php echo $Company_name; ?></strong></h4><br>
						<div class="pull-left">
							<abbr title="Address">
								<i class="fa fa-home"></i>
							</abbr>
                        </div>
						&nbsp;&nbsp;
						<?php echo $Company_address; ?><br><br>
						
						<div class="pull-left">
							<abbr title="Email ID">
								<i class="fa fa-envelope"></i>
							</abbr>
                        </div>
						&nbsp;&nbsp;
						<?php echo $Company_primary_email_id; ?> <br><br>
						
						<?php if($Website != "") { ?>
						<div class="pull-left">
							<abbr title="Company Website">
								<i class="fa fa-globe"></i>
							</abbr>
                        </div>
						&nbsp;&nbsp;
						<a href="<?php echo $Website; ?>" target="_blank" >Visit Company Website</a> <br><br>
						<?php } ?>
						
						<div class="pull-left">
							<abbr title="Phone Number">
								<i class="fa fa-phone"></i>
							</abbr>
                        </div>
						&nbsp;&nbsp;
						<?php echo $Company_primary_phone_no; ?> <br>
					</address>
					<?php } ?>
                </div>

                <div class="col-sm-4">
                    <h3 class="column-title">FAQs</h3>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        How do i join the scheme?
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                   To enrol, simply request for our loyalty membership form at any of our outlets
                                </div>
                            </div>
                        </div>
						
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        How can i accumulate more points?
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    You earn loyalty points every time you make purchases at any of our outlets, please insist that your transaction for the day is added to your loyalty account.
                                </div>
                            </div>
                        </div>
						
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                       How can I access my account?
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                  On enrolment, you'd receive your login details and instructions on how to download the mobile app and login to our loyalty website.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

				<div class="col-sm-4">
					<?php if($Facebook_link != "" || $Twitter_link != "" || $Linkedin_link != "" || $Googlplus_link != "") { ?>
                    <h3 class="column-title">Find Us On</h3>					
					<table class="table">
						<tr>
							<?php if($Facebook_link != "") { ?>
								<td align="center" style="border: 1px solid rgb(255, 255, 255);">
									<a href="<?php echo $Facebook_link; ?>" target="_blank" style="font-size: 40px;">
										<i class="fa fa-facebook-square"></i>
									</a>
								</td>
							<?php } ?>
							
							<?php if($Twitter_link != "") { ?>
								<td align="center" style="border: 1px solid rgb(255, 255, 255);">
									<a href="<?php echo $Twitter_link; ?>" target="_blank" style="font-size: 40px;">
										<i class="fa fa-twitter-square"></i>
									</a>
								</td>
							<?php } ?>
							
							<?php if($Linkedin_link != "") { ?>
								<td align="center" style="border: 1px solid rgb(255, 255, 255);">
									<a href="<?php echo $Linkedin_link; ?>" target="_blank" style="font-size: 40px;">
										<i class="fa fa-linkedin-square"></i>
									</a>
								</td>
							<?php } ?>
							
							<?php if($Googlplus_link != "") { ?>
								<td align="center" style="border: 1px solid rgb(255, 255, 255);">
									<a href="<?php echo $Googlplus_link; ?>" target="_blank" style="font-size: 40px;">
										<i class="fa fa-google-plus-square"></i>
									</a>
								</td>
							<?php } ?>
						</tr>
						
					</table>
					<?php } ?>
				
					<?php if($Cust_apk_link != "" || $Cust_ios_link != "") { ?>
                    <h3 class="column-title">Get Our Mobile Apps</h3>
					<table class="table">
						<tr>
							<?php if($Cust_apk_link != "") { ?>
								<td align="center" style="border: 1px solid rgb(255, 255, 255);">
									<a href="<?php echo $Cust_apk_link; ?>" target="_blank">
										<img src="<?php echo $this->config->item('base_url2')?>images/Gooogle_Play.png" width="60" height="50" class="img-responsive" alt="Google Play">
									</a>
								</td>
							<?php } ?>
							
							<?php if($Cust_ios_link != "") { ?>
								<td align="center" style="border: 1px solid rgb(255, 255, 255);">
									<a href="<?php echo $Cust_ios_link; ?>" target="_blank">
										<img src="<?php echo $this->config->item('base_url2')?>images/iOs_app_store.png" width="60" height="50" class="img-responsive" alt="iOS Store">
									</a>
								</td>
							<?php } ?>
						</tr>
						
						<tr>
							<?php if($Cust_apk_link != "") { ?>
								<td align="center" style="border: 1px solid rgb(255, 255, 255);">
									Available On Android
								</td>
							<?php } ?>
							
							<?php if($Cust_ios_link != "") { ?>
								<td align="center" style="border: 1px solid rgb(255, 255, 255);">
									Available On IOS
								</td>
							<?php } ?>
						</tr>
					</table>
					<?php } ?>
                </div>
				

            </div>
        </div>
    </section><!--/#meet-team-->
	
	<?php
	if(@$this->session->flashdata('error_code'))
	{
	?>
		<script>
			var Title = "Application Information";
			var msg = '<?php echo $this->session->flashdata('error_code'); ?>';
			runjs(Title,msg);
		</script>
	<?php
	}
	?>
				
	<!-- Modal -->
	<div class="modal fade" id="Cust_login_Modal" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
			
				<div class="login-box">					
					<div class="login-box-body">
						<p class="login-box-msg" style="font-size: 20px;"><strong>Customer Sign In</strong></p>
						<form action="<?php echo base_url()?>index.php/login" method="post" >
							<div class="form-group has-feedback">
								<input type="email" name="email" class="form-control" placeholder="Email" required>
								<span><?php echo form_error('email'); ?></span>
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>							
							<div class="form-group has-feedback">
								<input type="password" name="password"  class="form-control" placeholder="Password" required>
								<span class="glyphicon glyphicon-lock form-control-feedback"></span>
								<span><?php echo form_error('password'); ?></span>
							</div>							
							<div class="row">
								<div class="col-xs-6">
									<button type="submit"  class="btn btn-primary btn-block btn-flat">Sign In</button>		
									<input type="hidden" name="flag" value="2" >
								</div>
								<div class="col-xs-6">
									<button type="button" class="btn btn-primary btn-block btn-flat" data-dismiss="modal">Cancel</button>								
								</div>
							</div>
							
							<br>
							<div class="row">
								<div class="col-xs-6">								
									<a href="#" data-toggle="modal" data-target="#New_Membership_Registration" id="NewRegistration">Register New Member</a>
								</div>
								<div class="col-xs-6">								
									<a href="#" data-toggle="modal" data-target="#Cust_forgot_Modal" id="ForgotPassword">I forgot my password</a>
								</div>
							</div>
							<br>
							<div class="row">
								<div class="col-xs-12" >		
										<a href="<?php echo base_url()?>index.php/Auth_oa2/session/facebook" title="Facebook Connect"><img src="<?php echo $this->config->item('base_url2'); ?>images/facebook.png" width="130px"></a>
										
										<a href="<?php echo base_url()?>index.php/Auth_oa2/session/google"  title="Google"><img src="<?php echo $this->config->item('base_url2'); ?>images/google.png" width="130px"></a>
								</div>
							</div>							
						</form>

					</div>
				</div>
				
			</div>
		
				
		
			<!-- Modal content-->
		  
		</div>
	</div>
	<!-- Modal -->
	
	<!-- Modal Forgot Password -->
	<div class="modal fade" id="Cust_forgot_Modal" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				
				<div class="login-box">					
					<div class="login-box-body">
						<p class="login-box-msg" style="font-size: 20px;"><strong>Forgot Password</strong></p>
						<form action="<?php echo base_url()?>index.php/Cust_home/forgot" method="post" >
							<div class="form-group has-feedback">
								<input type="email" name="email" class="form-control" placeholder="Email" required>
								<input type="hidden" class="form-control"  name="Company_id" id="Company_id" value="3" >
								<input type="hidden" class="form-control"  name="flag"  value="2" >
								<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
							</div>
							
							<div class="row">
								<div class="col-xs-6">
									<button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>									
								</div>
							</div>
							<br>
						</form>

					</div>
				</div>
				
			</div>
			
			
			<!-- Modal content-->
		  
		</div>
	</div>
	<!-- Modal -->
	
	
	
	
	
	<!-- Modal Register New Membership -->
	<div class="modal fade" id="New_Membership_Registration" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				
				<div class="login-box">					
					<div class="login-box-body">
						<p class="login-box-msg" style="font-size: 20px;"><strong>Register New Membership</strong></p>
						<form action="<?php echo base_url()?>index.php/Cust_home/enroll_new_member_website" method="post" >
							<div class="form-group has-feedback">
								<input type="text" name="first_name" class="form-control" placeholder="First name" required>
							</div>
							<div class="form-group has-feedback">
								<input type="text" name="last_name" class="form-control" placeholder="Last name" required>
							</div>
							<div class="form-group has-feedbackP">								
								<input type="text"  class="form-control" name="phno"   id="phno" placeholder="Mobile" onkeyup="this.value=this.value.replace(/\D/g,'')" required>
								<span style="font-size: 10px; font-style: italic; color: red;">(* Enter Phone No without Dial Code)</span>
							</div>							
							<div class="form-group has-feedbackE"> 
								<input type="email" class="form-control" name="userEmailId"   id="userEmailId" placeholder="Email" required/>
							</div>							
							<div class="row">
								<div class="col-xs-6">
									<button type="submit" name="register" class="btn btn-primary btn-block btn-flat">Register</button>
									
									<input type="hidden" class="form-control"  name="Country" id="Country" value="<?php echo $Country; ?>" >
									<input type="hidden" class="form-control"  name="Company_id" id="Company_id" value="<?php echo $Company_id; ?>" >
								</div>
								<div class="col-xs-6">
									<button type="button" class="btn btn-primary btn-block btn-flat" data-dismiss="modal">Cancel</button>								
								</div>
							</div>
							<br>
						</form>

					</div>
				</div>
				
			</div>
			
			
			<!-- Modal content-->
		  
		</div>
	</div>
	<!-- Modal -->

    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                   &copy; Copyright 2012-2020 <a target="_blank" href="http://miraclecartes.com/" title="Miracle Smart Card Pvt. Ltd">Miracle Smart Card Pvt. Ltd.</a> All rights reserved
                </div>
				
				
                <div class="col-sm-6">		
                    
					<ul class="social-icons">
                        <li><a href="skype:rakesh_jadhav?chat"><i class="fa fa-skype"></i></a></li>
                        <li><a href="http://www.linkedin.com/company/2237238" target="_blank"><i class="fa fa-linkedin"></i></a></li>
						<li>
							Powered By <a target="_blank" href="<?php echo $partner_cmp_website; ?>" title="<?php echo $partner_cmp_name; ?>"><?php echo $partner_cmp_name; ?></a> 
						</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer><!--/#footer-->

    
    
    <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/owl.carousel.min.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/mousescroll.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/smoothscroll.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/jquery.prettyPhoto.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/jquery.isotope.min.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/jquery.inview.min.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/wow.min.js"></script>
    <script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/main.js"></script>


</body>
</html>

<style>
.modal-dialog 
{
    z-index: 9999999;
}
</style>
 <script>
 
 $('#phno').change(function()
{	
	var Country = '<?php echo $Country; ?>';
	var Company_id = '<?php echo $Company_id; ?>';
	var phno = $('#phno').val();	
	if( $("#phno").val() == "" )
	{
		var Title = "Application Information";
		var msg = 'Please Enter Phone Number';
		runjs(Title,msg);
		return false;
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { phno: phno,Company_id:Company_id, Country:Country},
			url: "<?php echo base_url()?>index.php/Cust_home/check_phone_number",
			success: function(data)
			{
				if(data.length == 30)
				{
					$("#phno").val("");
					document.getElementById('phno').placeholder="Phone Number Already Exist!";
					var Title = "Application Information";
					var msg = 'Phone Number Already Exist';
					runjs(Title,msg);
					return false;
					
				}
				else
				{
					
				}
			}
		});
	}
});
 
 $('#userEmailId').change(function()
{	
	var Company_id = '<?php echo $Company_id; ?>';
	var userEmailId = $('#userEmailId').val();
	
	if( $("#userEmailId").val() == "" )
	{
		var Title = "Application Information";
		var msg = 'Please Enter Email Id';
		runjs(Title,msg);
		return false;
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { userEmailId: userEmailId, Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/Cust_home/check_email_id",
			success: function(data)
			{
				if(data.length == 26)
				{
					$("#userEmailId").val("");
					document.getElementById('userEmailId').placeholder="Email Id Already Exist!";
					var Title = "Application Information";
					var msg = 'Email Id Already Exist';
					runjs(Title,msg);
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
	}
});
 </script>
 <script>
$("#ForgotPassword").click(function()
{
	$('#Cust_login_Modal').hide();
	$("#Cust_login_Modal").removeClass( "in" );
	$('.modal-backdrop').remove();
});

$("#NewRegistration").click(function()
{
	$('#Cust_login_Modal').hide();
	$("#Cust_login_Modal").removeClass( "in" );
	$('.modal-backdrop').remove();
});

</script>

	<!------------------------------------------Google Map---------------------------------------------->
	<script type='text/javascript' src='http://demo1.igainspark.com/Company_17/assets/jquery-migrate.js'></script>
	<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
	<script type='text/javascript' src='http://demo1.igainspark.com/Company_17/assets/gmaps.js'></script>
	<!------------------------------------------Google Map---------------------------------------------->
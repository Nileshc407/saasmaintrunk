<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" >
		<title><?php echo $Company_name; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="<?php echo $this->config->item('base_url2')?>SAAS/i/favicon.png" type="image/x-icon">
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@100;200;300;400;500;600;700;800;900&family=DM+Sans:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
		<!-- Bootstrap 4.5.2 CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<!-- Slick 1.8.1 jQuery plugin CSS (Sliders) -->
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
		<!-- Fancybox 3 jQuery plugin CSS (Open images and video in popup) -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
		<!-- AOS 2.3.4 jQuery plugin CSS (Animations) -->
		<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
		<!-- FontAwesome CSS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
		<!-- Startup CSS (Styles for all blocks) - Remove ".min" if you would edit a css code -->
		<link href="<?php echo $this->config->item('base_url2')?>SAAS/css2/style.min.css" rel="stylesheet" />
		<!-- jQuery 3.5.1 -->
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	</head> 
	<body>
<!-- Form 1 -->
	
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
		
			
					
				
				
	<?php if(isset($_REQUEST['User_login'])){?>
	
	
	<!-----------------------------------------User_login ----------------------------------------------->		
	<section class="pt-120 pb-120 bg-dark form_1" data-bg-src="<?php echo  $this->config->item('base_url2');?>images/Maintrunkbgimage.png" data-bg-src-2x="<?php echo  $this->config->item('base_url2');?>SAAS/i/form_1_bg@2x.jpg" >
	
		<?php if($this->session->flashdata('error_code')){?>
				<div class="alert2">
				  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
				 <strong> <?php echo $this->session->flashdata('error_code'); ?></strong>
				</div>
				<br>
		<?php } ?>		
		
		<?php if($this->session->flashdata('messege')){?>
				<div class="alert2">
				  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
				 <strong> <?php echo $this->session->flashdata('messege'); ?></strong>
				</div>
				<br>
		<?php } ?>		
		
		<div style="display:none;" id="usererror">
			<div class="alert2" >
					  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
					 <strong><span id='erroruser'></span></strong>
					
			</div>
			<br>
		</div>
		
		<div class="container px-xl-0" style="margin-left: -20%;" id="signin11">
			<!--<form action="<?php echo $this->config->item('base_url2')?>index.php/Login/" method="post" class="bg-light mx-auto mw-430 radius10 pt-40 px-50 pb-30">-->
			<div  class="bg-light mx-auto mw-430 radius10 pt-40 px-50 pb-30">
				
				
				<div class="mb-20 input_holder aos-animate text-center">
					<img src="<?php echo  $this->config->item('base_url2').''.$Company_logo;?>" width="300px" height="100px">	
				</div>
				<div class="mb-20 input_holder aos-animate">
					<input type="email"name="username" id="Merchant_email" placeholder="Email Address" class="input border-gray focus-action-1  placeholder-heading w-full">
				</div>
				<div class="mb-20 input_holder aos-animate">
					<input type="Password" name="password"  id="password" placeholder="Password" class="input border-gray focus-action-1  placeholder-heading w-full">
				</div>
				<div class="aos-animate">
					<button class="btn mt-25 action-1 w-full" onclick="javascript:Merchant_login(password.value,Merchant_email.value);">
					<input type="hidden" name="Outlet_Website" id="Outlet_Website" value="<?php  echo $Outlet_Website; ?>" >
						<input type="hidden" name="flag" value="2">
						<input type="hidden"  name="Company_id" id="Company_id" value="<?php echo $Company_id; ?>" >
						Sign In
					</button>
				</div>
				<div class="mt-25 f-18 medium color-heading aos-animate">
					<span>
						&nbsp;
					</span>
					<a href="#" onclick="javascript:$('#signin11').hide();$('#forgot2').show();" class="link action-1 float-right">
						Forgot Password
					</a>
				</div>
				
				
				
			</div>
			<!--</form>-->
		</div>
		
			<div class="container px-xl-0" style="margin-left: -20%;display:none;" id="forgot2">
			<!--<form action="<?php //echo $this->config->item('base_url2')?>index.php/Login/Send_password_website/?flag=2" method="post" class="bg-light mx-auto mw-430 radius10 pt-40 px-50 pb-30">-->
			<div class="bg-light mx-auto mw-430 radius10 pt-40 px-50 pb-30">
				<h2 class="mb-20 small text-center aos-animate" style="font-size: 30px;" >
					Forgot Password
				</h2>
				<div class="mb-20 input_holder aos-animate">
					<input type="email" name="email" id="Forgotemail" placeholder="Email Address" class="input border-gray focus-action-1  placeholder-heading w-full">
				</div>
				
				<div class="aos-animate">
					<button class="btn mt-25 action-1 w-full"  onclick="javascript:ForgotPassword(Forgotemail.value);">
						<input type="hidden" class="form-control"  name="flag"  value="2" >
						<input type="hidden"  name="Company_id" id="Company_id" value="<?php echo $Company_id; ?>" >
						Submit
					</button>
				</div>
				<div class="mt-25 f-18 medium color-heading aos-animate">
					<span>
						&nbsp;
					</span>
					<a href="#" onclick="javascript:$('#signin11').show();$('#forgot2').hide();" class="link action-1 float-right">
						Sign In
					</a>
				</div>
				
			</div>
			<!--</form>-->
		</div>
		
	</section>
	<!-----------------------------------------User_login END----------------------------------------------->
	
	<?php } else { ?>
	<div class="row">
				<div class="col-sm-3">					
					<img src="<?php echo  $this->config->item('base_url2').''.$Company_logo;?>" width="200px" height="100px">			
									
				</div>	
				<div class="col-sm-7">					
					<div class="form-group">
						<label for="" class="topmenu" onclick="javascript:$('#about').hide();$('#signin').hide();$('#home').show();$('#contact').hide();$('.topmenu').css('color', '#1e0e62');$(this).css('color', '#38b6d0');" style="color:#38b6d0;">Home</label>
						<label for="" class="topmenu"  onclick="javascript:$('#home').hide();$('#signin').hide();$('#about').show();$('#contact').hide();$('.topmenu').css('color', '#1e0e62');$(this).css('color', '#38b6d0');">About Loyalty Program</label>		
						<label for="" class="topmenu" onclick="javascript:$('#home').hide();$('#about').hide();$('#signin').show();$('#signin1').show();$('#signup').hide();$('#forgot').hide();$('#contact').hide();$('.topmenu').css('color', '#1e0e62');$(this).css('color', '#38b6d0');">Sign In</label>
						<label for="" class="topmenu" onclick="javascript:$('#home').hide();$('#about').hide();$('#signin').hide();$('#signin1').hide();$('#signup').hide();$('#forgot').hide();$('#contact').show();$('.topmenu').css('color', '#1e0e62');$(this).css('color', '#38b6d0');">Contact Us</label>
					</div>				
									
				</div>					
	</div>	
	
	
	<section class="pt-120 pb-120 bg-dark form_1" data-bg-src="<?php echo  $this->config->item('base_url2');?>images/Customerhomebg.png" data-bg-src-2x="<?php echo  $this->config->item('base_url2');?>SAAS/i/form_1_bg@2x.jpg" id="home">
		<?php if($this->session->flashdata('error_code')){?>
				<div class="alert2">
				  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
				 <strong> <?php echo $this->session->flashdata('error_code'); ?></strong>
				</div>
				<br>
		<?php } ?>	
		<?php if($this->session->flashdata('messege')){?>
				<div class="alert2">
				  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
				 <strong> <?php echo $this->session->flashdata('messege'); ?></strong>
				</div>
				<br>
		<?php } ?>
		<div class="container px-xl-0" >
		<h2 class="mb-40 small  aos-animate" style="font-size:30px;">
					Welcome Dear Member!!
		</h2>
				
				
				
				
				<div class="mt-25 f-18 medium color-heading  aos-animate" >
					<span style="font-size:18px;text-align:left;">
						Loyalty Program Name  is  the name of our Loyalty program.  <br><br>
						It is our way of saying thank you for  being a patron.We reward you with Loyalty points  whenever you purchase  of our business outlets or just follow us on social media !
						<br><br>
						We want our loyal  customers the best of the Experiences for being part of our community!<br><br>Enjoy the journey with us!

					</span>
					
				</div>
		
		
		
		</div>
		
	</section>
		
	<section class="pt-120 pb-120 bg-dark form_1" data-bg-src="<?php echo  $this->config->item('base_url2');?>images/Customerloyaltybg.png" data-bg-src-2x="<?php echo  $this->config->item('base_url2');?>SAAS/i/form_1_bg@2x.jpg" id="about" style="display:none;">
		<div class="row">
			<div class="col-sm-2">	</div>		
			<div class="col-sm-4">	
				<div class="container px-xl-0" >
				<h2 class="mb-40 small  aos-animate" style="font-size:30px;">
							How to Earn Points
						</h2>
						
						
						
						
						<div class="mt-25 f-18 medium color-heading  aos-animate" >
							<span style="font-size:18px;text-align:left;">
								Whenever you purchase from our business outlets   you will earn points based in the Loyalty Rule.
								<br><br>
								For example you may earn 5  Point s for every 100 Rupees  you purchase   at Item either online or from our outlet stores.

							</span>
							
						</div>
				
				
				
				</div>
			</div>
			<div class="col-sm-1">	</div>		
			<div class="col-sm-5">	
				<div class="container px-xl-0" >
				<h2 class="mb-40 small  aos-animate" style="font-size:30px;">
							How to Redeem Points
						</h2>
						
						
						
						
						<div class="mt-25 f-18 medium color-heading  aos-animate" >
							<span style="font-size:18px;text-align:left;">
								You can redeem the points you have accumulated during your next purchase or you can redeem against any merchandizing Items  made available.
								
							</span>
							
						</div>
				
				
				
				</div>
			</div>
			<div class="col-sm-2">	</div>		
			<div class="col-sm-10">	
			<br>
			<h2 class="mb-40 small  aos-animate" style="font-size:30px;">
							So SIGN UP and become a Member we want to win rewards and more!

						</h2>
			</div>				
		</div>
		
	</section>
		
	
	<section class="pt-120 pb-120 bg-dark form_1" data-bg-src="<?php echo  $this->config->item('base_url2');?>images/CustomerSigninbg.png" data-bg-src-2x="<?php echo  $this->config->item('base_url2');?>SAAS/i/form_1_bg@2x.jpg" id="signin" style="display:none;">
		
			
		
				
		
		<div style="display:none;" id="membererror">
			<div class="alert2" >
					  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
					 <strong><span id='membererror2'></span></strong>
					
			</div>
			<br>
		</div>
		
		
		<div class="container px-xl-0" style="margin-left: -20%;" id="signin1">
			<div  class="bg-light mx-auto mw-430 radius10 pt-40 px-50 pb-30">
				<h2 class="mb-20 small text-center aos-animate" style="font-size: 30px;" >
					Sign In Now
				</h2>
				<div class="mb-20 input_holder aos-animate">
					<input type="email" name="email" id="cust_email" placeholder="Email Address" class="input border-gray focus-action-1  placeholder-heading w-full">
				</div>
				<div class="mb-20 input_holder aos-animate">
					<input type="Password" name="password"  id="Cust_password" placeholder="Password" class="input border-gray focus-action-1  placeholder-heading w-full">
				</div>
				<div class="aos-animate">
					<button class="btn mt-25 action-1 w-full" onclick="javascript:Member_login(Cust_password.value,cust_email.value);">
						<input type="hidden" name="flag" value="2">
						<input type="hidden"  name="Company_id" id="Company_id" value="<?php echo $Company_id; ?>" >
						Sign In
					</button>
				</div>
				<div class="mt-25 f-18 medium color-heading aos-animate">
					<span>
						&nbsp;
					</span>
					<a href="#" onclick="javascript:$('#signin1').hide();$('#signup').hide();$('#forgot').show();" class="link action-1 float-right">
						Forgot Password
					</a>
				</div>
				
				<div class="mt-25 f-18 medium color-heading aos-animate">
					<span style='color:#4c5a6b;'>
						Not a Member yet? 
					</span>
					<a href="#" onclick="javascript:$('#signin1').hide();$('#signup').show();$('#forgot').hide();" class="link action-1 float-right">
						Sign Up
					</a>
				</div>
				
			</div>
		</div>
		<div class="container px-xl-0" style="margin-left: -20%;display:none;" id="forgot">
			<div  class="bg-light mx-auto mw-430 radius10 pt-40 px-50 pb-30">
				<h2 class="mb-20 small text-center aos-animate" style="font-size: 30px;" >
					Forgot Password
				</h2>
				<div class="mb-20 input_holder aos-animate">
					<input type="email" name="email" id="Custemail" placeholder="Email Address" class="input border-gray focus-action-1  placeholder-heading w-full">
				</div>
				
				<div class="aos-animate">
					<button class="btn mt-25 action-1 w-full" onclick="javascript:MemberForgotPassword(Custemail.value);">
						<input type="hidden" class="form-control"  name="flag"  value="2" >
						<input type="hidden"  name="Company_id" id="Company_id" value="<?php echo $Company_id; ?>" >
						Submit
					</button>
				</div>
				<div class="mt-25 f-18 medium color-heading aos-animate">
					<span>
						&nbsp;
					</span>
					<a href="#" onclick="javascript:$('#signin1').show();$('#signup').hide();$('#forgot').hide();" class="link action-1 float-right">
						Sign In
					</a>
				</div>
				
			</div>
		</div>
		<div class="container px-xl-0" style="margin-left: -20%;display:none;" id="signup">
			<div  class="bg-light mx-auto mw-430 radius10 pt-40 px-50 pb-30">
				<h2 class="mb-20 small text-center aos-animate" style="font-size: 30px;">
					Sign Up Now
				</h2>
				<div class="mb-20 input_holder aos-animate">
					<input type="text" name="first_name" id="first_name" placeholder="First Name" class="input border-gray focus-action-1  placeholder-heading w-full">
				</div>
				<div class="mb-20 input_holder aos-animate">
					<input type="text" name="last_name" id="last_name" placeholder="Last Name" class="input border-gray focus-action-1  placeholder-heading w-full">
				</div>
				<div class="mb-20 input_holder aos-animate">
					<input type="text" name="phno" id="phno"  placeholder="Mobile No." class="input border-gray focus-action-1  placeholder-heading w-full">
				</div>
				<div class="mb-20 input_holder aos-animate">
					<input  type="email" name="email"   id="email_id" placeholder="Email ID" class="input border-gray focus-action-1  placeholder-heading w-full">
				</div>
				
				<div class="aos-animate" onclick="javascript:Member_registration(first_name.value,last_name.value,phno.value,email_id.value);">
					<button class="btn mt-25 action-1 w-full">
						<input type="hidden" class="form-control"  name="Country" id="Country" value="<?php echo $Country; ?>" >
						<input type="hidden"  name="Company_id" id="Company_id" value="<?php echo $Company_id; ?>" >
						Register
					</button>
				</div>
				<div class="mt-25 f-18 medium color-heading aos-animate">
					<span  style='color:#4c5a6b;'>
						Already have an account? 
					</span>
					<a href="#" onclick="javascript:$('#signin1').show();$('#signup').hide();$('#forgot').hide();" class="link action-1 float-right">
						Sign In
					</a>
				</div>
				
			</div>
		</div>
	</section>
		
	<section class="pt-120 pb-120 bg-dark form_1" data-bg-src="<?php echo  $this->config->item('base_url2');?>images/CustomerSigninbg.png" data-bg-src-2x="<?php echo  $this->config->item('base_url2');?>SAAS/i/form_1_bg@2x.jpg" id="contact" style="display:none;">
		<div class="row">
			<div class="col-sm-2">	</div>		
			<div class="col-sm-4">	
				<div class="container px-xl-0" >
				<h2 class="mb-40 small  aos-animate" style="font-size:30px;">
							<?php echo $Company_name; ?>
						</h2>
						
						
						
						
						<div class="mt-25 f-18 medium color-heading  aos-animate" >
							<span style="font-size:18px;text-align:left;">
								
								<?php echo $Company_address; ?><br>
								<?php echo $Company_primary_email_id; ?><br>
								<?php echo $Company_primary_phone_no; ?>

							</span>
							
						</div>
				
				
				
				</div>
			</div>
			<div class="col-sm-2">	</div>		
			<div class="col-sm-10">	
			<br>
			<br>
			
			</div>				
		</div>
		
	</section>
		
	
	<?php } ?>
	
		<!-- forms alerts --
		<div class="alert alert-success alert-dismissible fixed-top alert-form-success" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			Thanks for your message!
		</div>
		<div class="alert alert-warning alert-dismissible fixed-top alert-form-check-fields" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			Please, fill in required fields.
		</div>
		<div class="alert alert-danger alert-dismissible fixed-top alert-form-error" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<div class="message">An error occurred while sending data :( Please, check if your hosting supports PHP and check how to set form data sending <a href="https://designmodo.com/startup/documentation/#form-handler" target="_blank" class="link color-transparent-white">here</a>.</div>
		</div>

		<!-- gReCaptcha popup (uncomment if you need a recaptcha integration) -->
		<!--
		<div class="bg-dark op-8 grecaptcha-overlay"></div>
		<div class="bg-light radius10 w-350 h-120 px-20 pt-20 pb-20 grecaptcha-popup">
			<div class="w-full h-full d-flex justify-content-center align-items-center">
				<div id="g-recaptcha" data-sitekey="PUT_YOUR_SITE_KEY_HERE"></div>
			</div>
		</div>
		<script src="https://www.google.com/recaptcha/api.js?render=explicit" async defer></script>
		-->
		<!-- Bootstrap 4.5.2 JS -->
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
		<!-- Fancybox 3 jQuery plugin JS (Open images and video in popup) -->
		<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
		<!-- 
			Google maps JS API 
			Don't forget to replace the key "AIzaSyDP6Ex5S03nvKZJZSvGXsEAi3X_tFkua4U" to your own! 
			Learn how to get a key: https://help.designmodo.com/article/startup-google-maps-api/ 
		-->
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyDP6Ex5S03nvKZJZSvGXsEAi3X_tFkua4U"></script>
		<!-- Slick 1.8.1 jQuery plugin JS (Sliders) -->
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
		<!-- AOS 2.3.4 jQuery plugin JS (Animations) -->
		<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
		<!-- Maskedinput jQuery plugin JS (Masks for input fields) -->
		<script src="<?php echo $this->config->item('base_url2')?>SAAS/js2/jquery.maskedinput.min.js"></script>
		<!-- Startup JS (Custom js for all blocks) -->
		<script src="<?php echo $this->config->item('base_url2')?>SAAS/js2/script.js"></script>
		
		<!-- Modal -->
	<div id="loadingDiv" style="display:none;">
		<div>
			<h7>Please wait...</h7>
		</div>
	</div>
	
	</body>
</html>

	
	
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
	window.location='<?php echo base_url()?>index.php/Cust_home/forgot/?email='+Forgotemail+'&Company_id='+Company_id;
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
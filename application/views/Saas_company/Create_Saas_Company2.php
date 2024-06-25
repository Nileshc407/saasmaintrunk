<?php
$URL= base_url();
header("Content-Security-Policy: X-Frame-Options: 'DENY'");
header("Content-Security-Policy: X-Frame-Options: 'SAMEORIGIN'");
header("Content-Security-Policy: default-src 'self'");
header("Content-Security-Policy: img-src 'self' $URL");
header("Content-Security-Policy: default-src 'self' img-src");
header("Content-Security-Policy: font-src stackpath.bootstrapcdn.com");
header("Content-Security-Policy: connect-src 'self'");
header("Content-Security-Policy: object-src 'self'");
header("Content-Security-Policy: media-src 'self'");
header("Content-Security-Policy: frame-src 'none'");
header("Content-Security-Policy: script-src 'none'");
header("Content-Security-Policy: child-src 'none'");



?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>iGainspark SaaS</title>
	<!-- <link rel="shortcut icon" href="http://miraclecartes.com/img/favicon.ico" type="image/x-icon">-->
	<link rel="shortcut icon" href="<?php echo base_url(); ?>images/favicon.ico" type="image/x-icon">
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!-- Font-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>SAAS/css/opensans-font.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>SAAS/fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<!-- Main Style Css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>SAAS/css/style.css"/>
	<!-- Main js -->
	<script src="<?php echo base_url(); ?>SAAS/js/jquery-3.3.1.min.js"></script>
	<script src="<?php echo base_url(); ?>SAAS/js/jquery.steps.js"></script>
	<script src="<?php echo base_url(); ?>SAAS/js/main.js"></script>
	
	<script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'></script>
	<link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
	

</head>
<body style='background-image: url("<?php echo base_url();?>images/backgroundimage3.png") !important; width:100%  !important;'>

<style>
#cover-spin1 {
    position:fixed;
    width:100%;
    left:0;right:0;top:0;bottom:0;
    background-color: rgba(255,255,255,0.4);
    z-index:9999;
    display:none;
}
::placeholder {
  color: #e6e1d5 !important;
  opacity: 1!important;
}
</style>

<?php

// $title = "What's wrong with CSS?";
// $url_title = url_title($title);
// echo base_url("images/icons/edit.png");

// unset($_SESSION['Verification_code']);
// session_destroy($_SESSION['Verification_code']);
// echo '_SESSIONVerification_code '.$_SESSION['Verification_code'];



?>
	
	<div class="page-content" style='background-image: url("<?php echo base_url();?>images/backgroundimage3.png") !important; width:100%  !important;'>
					
		<div class="form-v1-content" >
			<div class="wizard-form">
			<?php 	 
						if(@$this->session->flashdata('error_code'))
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('error_code'); ?>
							</div>
				<?php 	} ?>
		        <form class="form-register" action="<?php echo base_url();?>index.php/Register_saas_company/insert_saas_company_master" method="post" id="myForm" enctype="multipart/form-data">
		        	<div id="form-total" >
					
						 <!-- SECTION 1 -->
						 <input type="hidden" id="section" value="1">
						 <input type='hidden' name="Verification_codeVal" id="Verification_codeVal" >
						
			            <h2 class="headingX">
						
			            	<p class="step-icon" onclick="$('#section').val(01);$('#next').attr('href', '#next');"><span >01</span></p>
			            	<span class="step-text"   onclick="$('#section').val(01);$('#next').attr('href', '#next');">Welcome</span>
							
			            </h2>
						
			            <section>
			                <div class="inner">
			                	
								<div class="form-row">
			                		<div class="form-holder form-holder-2">
			                		<br>
			                			<div class="plan-total">
		                					<span class="plan-title"><b>Dear Customer ,</span>
											<br><br>
		                					<p class="plan-text">Thank You for showing interest in selecting Our Loyalty Platform for your customers.</b></p>
											<br>
		                					<p class="plan-text">This is your first positive step  to "Create Customers for Life"! </p>
											<br>
		                					<p class="plan-text">To embark  on this  journey, we will need some basic information i.e. the Loyalty License  to use  (Basic, Standard OR Enhanced), some information about you and your company and some basic loyalty rules which will help you get started!</p>
											<br>
		                					<p class="plan-text">Once you enter these details, you will receive an Email within next 1-2  hours with application configured and with complete access details to the Loyalty application</p>
											<br>
		                					<p class="plan-text">So, get strapped and relax. We will always be there at support@miraclecartes.com for any help you need now and later!!</p>
										
		                				</div>
			                			
										
			                		</div>
									<label  style="font-size: 14px; color: #666;font-weight: 600;margin: 0;padding-top: 5px;">
									 <input id="Terms_and_Conditions" name="Terms_and_Conditions" type="checkbox"  value="0" > Yes, you agree to the <a href="https://www.miraclecartes.com/saas/term-condition.html" target="_blank">Terms & Conditions</a> as well.
									</label>
									<br><br>
			                	</div>
									
								
								
								
							</div>
			            </section>  
						<h2>
			            	<p class="step-icon"   onclick="$('#section').val(02);$('#next').attr('href', '#next');"><span >02</span></p>
			            	<span class="step-text"  onclick="$('#section').val(02);$('#next').attr('href', '#next');">Loyalty License</span>
			            </h2>
			            <section>
						
						
						
			                <div class="inner" style="padding:0px;">
			                	<div class="wizard-header">
									<h3 class="heading">Choose Loyalty License</h3>									
								</div>
								
								<?php /* ?> height:1047px;
									<div class="form-row">
										<div class="form-holder form-holder-2">
											<input type="radio" class="radio" name="Company_License_type" id="plan-1" value="121" checked>
											<label class="plan-icon plan-1-label" for="plan-1">
												<p class="step-icon" style="color: #666; font-size: 30px; font-weight: 900; margin-left: 14px;  margin-top: 11px;"><span >01</span></p>
											</label>
											<div class="plan-total">
												<span class="plan-title" style="font-size: 20px;">Standard</span>
												<p class="plan-text" style="margin-left: 90px;">Start with this Standard License and enroll unlimited Customers who will  Earn & Redeem points. However, get access to configure more like :<br><br>
												<ul style="margin-left: 66px;font-size: 13px;"  class="plan-text ul_licence">
												  <li>Set Multiple Loyalty Rules</li>
												  <li>Issue Instant Discounts and Vouchers</li>
												  <li>Have a Referral Bonus & Joining Bonus</li>
												  <li>Draft and Send Communication to Customers</li>
												</ul>
											
													</p>
													<p class="plan-text" style="margin-left: 400px;"><a onclick="standard_more();" href="#">more...</a></p>
													<!--
												<p class="plan-text" style="margin-left: 400px;"><a href="javascript:$('#License_model').modal('show');$('#model_header').html('Standard Loyalty License');$('#std').show();$('#enh').hide();">more...</a></p>-->
													
											</div>
											<input type="radio" class="radio" name="Company_License_type" id="plan-2" value="120">
											<label class="plan-icon plan-2-label" for="plan-2">
													<p class="step-icon" style="color: #666; font-size: 30px; font-weight: 900; margin-left: 14px;  margin-top: 11px;"><span >02</span></p>
											</label>
											<div class="plan-total">
												<span class="plan-title" style="font-size: 20px;">Enhance</span>
												<p class="plan-text" style="margin-left: 90px;">With enhanced License you get access to above Standard and much more like :
												<br><br>
												<ul style="margin-left: 66px;font-size: 13px;"  class="plan-text ul_licence">
												  <li>Create Merchandizing Catalogue</li>
												  <li>Set Trigger-based Notifications</li>
												  <li>Create & Send Surveys </li>
												  <li>Social Media Connect</li>
												  <li>Create Engaging Campaigns</li>
												</ul>
											</p>
											<p class="plan-text" style="margin-left: 400px;"><a onclick="enhance_more();" href="#">more...</a></p>
											<!--
											<p class="plan-text" style="margin-left: 400px;"><a href="javascript:$('#License_model').modal('show');$('#model_header').html('Enhance Loyalty License');$('#enh').show();$('#std').hide();">more...</a></p>-->
											</div>
											
										</div>
									</div>
									
									<?php */ ?>
									
									
									<div class="container">
										  <!--Section: Content-->
										  <section class="text-center">
											
											

											
											

											<div class="row">

											  <!--Grid column-->
											  <div class="col-md-6" style="padding:2px;">

												<!-- Card -->
												<div class="card">

												  <div class="card-header bg-info">
													<p class="text-uppercase small mb-2 text-white"><strong>Features</strong></p>
													
												  </div>

												  <div class="card-body">
														<ul class="list-group list-group-flush">
													  <li class="list-group-item newCSS">Enrollments <legend class="mb-0">( Members enrolled in Tiers)</legend></li>
													   <li class="list-group-item newCSS">CSV / Excel Data Upload <legend class="mb-0">( Enrollment and Transaction)</legend></li>
													  
													  <li class="list-group-item newCSS">Loyalty Portal <legend class="mb-0">( For Business and Members of Business)</legend></li>
													  <li class="list-group-item newCSS">Loyalty Campaigns <legend class="mb-0">( Loyalty Rule, Referral Rule, Gift Cards, Offers (Stamps))</legend></li>
													  <li class="list-group-item newCSS">Gamifications<legend class="mb-0">( Promo Campaign, Auction Bidding)</legend></li>
													  <li class="list-group-item newCSS">Discounts<legend class="mb-0">(Implement Discount Rules)</legend></li>
													  <li class="list-group-item newCSS">Personalization of Email Notifications<legend class="mb-0">( Emails sent to Members can be customized with own design etc.)</legend></li>
													  <li class="list-group-item newCSS">Create Merchandizing Redemption Catalogue<legend class="mb-0">( Create own Merchandizing Catalogue Items to be made available for members to Redeem)</legend></li>
													  <li class="list-group-item newCSS">eGifting Catalogue made available<legend class="mb-0">( E-Vouchers and E-Gift Cards from 12000 brands made available.<br>
													  The value of those consumed by the members of the business will be billed to the Business at the End of Month)
													  </legend></li>
													  <li class="list-group-item newCSS">Surveys<legend class="mb-0">( Create own Surveys and send to Customers and know your Promoters , Detractors and passive Customers)</legend></li>
													  <li class="list-group-item newCSS">Loyalty APP<legend class="mb-0">( Android and iOS APP for Members of the Business)</legend></li>
													  <li class="list-group-item newCSS">Basic Reporting<legend class="mb-0">( Dashboard, Enrollment Report, Transaction Report)</legend></li>
													  <li class="list-group-item newCSS">Enhanced Reporting & Segmentation 
														<legend class="mb-0">( Basic Reporting + Segmentation Feature, Audit Tracking, Bussiness Liability, High Value , Order Report etc.)</legend></li>													  
													  <li class="list-group-item newCSS">API Integration<legend class="mb-0">( if the Business needs integration with any 3rd party System e.g. PoS, E-commerce etc. We make APIs available and help in integration)</legend></li>
													  <li class="list-group-item newCSS">Support & Help<legend class="mb-0">( Made available through Email and Chat )</legend></li>
													  <li class="list-group-item newCSS">Call Center<legend class="mb-0">( Made available through Voice,Email and Chat )</legend></li>

													</ul>
													
												  </div>

												  

												</div>
												<!-- Card -->

											  </div>
											  <!--Grid column-->

											  <!--Grid column-->
											  <div class="col-md-2" style="padding:2px;">

												<!-- Card close-thick-->
												<div class="card">

												  <div class="card-header bg-info py-3">
													<p class="text-uppercase small mb-2 text-white"><strong>Basic<br> <legend class="blink mb-0">(Free)</legend></strong></p>
													
												  </div>

												  <div class="card-body">
													<ul class="list-group list-group-flush">
													  <li class="list-group-item"><legend class="mb-0">Upto <?php echo $Basic_limit; ?> members</legend></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/close-thick.svg"></li>
													 <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													 
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/close-thick.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/close-thick.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/close-thick.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/close-thick.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/close-thick.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/close-thick.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/close-thick.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/close-thick.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													 <li class="list-group-item"><img src="<?php echo base_url();?>images/close-thick.svg"></li>
													 
													</ul>
												  </div>

												  <div class="card-footer bg-white py-3">
													  <div class="btn-group btn-group-toggle" data-toggle="buttons">
														<label class="btn btn-outline-info active" onclick="showOff(1)"  id="chk1">
															<input type="radio" name="Company_License_type" id="option1" autocomplete="off" value="121" checked> Subscribe
														</label>
														<!--<button type="button" class="btn btn-primary btn-sm">Select</button>-->
													  </div>
												  </div>

												</div>
												<!-- Card -->

											  </div>
											  <!--Grid column-->

											  <!--Grid column-->
											  <div class="col-md-2" style="padding:2px;">

												<!-- Card -->
												<div class="card border border-primary">

												  <div class="card-header bg-info">
													<p class="text-uppercase small mb-2 text-white"><strong>Standard</strong></p>
													<legend class="mb-0 text-white">$ 149<?php //echo $Standard_Monthly_price; ?>/month</legend>
												  </div>

												  <div class="card-body">
													<ul class="list-group list-group-flush">
													  <li class="list-group-item"><legend class="mb-0">Upto <?php echo $Standard_limit; ?> members</legend></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/close-thick.svg"></li>
													   <li class="list-group-item"><img src="<?php echo base_url();?>images/close-thick.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/close-thick.svg"></li>
													</ul>
												  </div>
												  <div class="card-footer bg-white py-3">
													 <div class="btn-group btn-group-toggle" data-toggle="buttons" onclick="showOff(2)">
														<label class="btn btn-outline-info" id="chk2" >
															<input type="radio" name="Company_License_type" id="option2"  autocomplete="off" value="253" > Subscribe
														</label>
														<!--<button type="button" class="btn btn-info btn-sm">Select</button>-->
													  </div>
												  </div>
												</div>
												<!-- Card -->
											  </div>

											  <!--Grid column-->
											  <div class="col-md-2" style="padding:2px;">
												<!-- Card -->
												<div class="card">
												  <div class="card-header bg-info">
													<p class="text-uppercase small mb-2 text-white"><strong>Enhanced</strong></p>
													<legend class="mb-0 text-white">$ 249<?php //echo $Standard_Monthly_price; ?>/month</legend>
													<!--<legend class="mb-0 text-white">$<?php echo $Enhance_Monthly_price; ?>/month</legend>-->
												  </div>
												  <div class="card-body">
													<ul class="list-group list-group-flush">
													  <li class="list-group-item"><legend class="mb-0">Upto <?php echo $Enhance_limit; ?> members</legend></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  <li class="list-group-item"><img src="<?php echo base_url();?>images/check-bold.svg"></li>
													  
													</ul>
												  </div>
												  <div class="card-footer bg-white py-3">
													 <div class="btn-group btn-group-toggle" data-toggle="buttons"   onclick="showOff(3)">
													
													  <label class="btn btn-outline-info" id="chk3">
														<input type="radio" name="Company_License_type" id="option3" autocomplete="off" value="120"> Subscribe
													  </label>
													</div>
													<!--<button type="button" class="btn btn-info btn-sm">Select</button>-->
												  </div>
												</div>
												<!-- Card -->
											  </div>
											  <!--Grid column-->
											</div>
										  </section>
										  <!--Section: Content-->
										</div>
								
								
								
								
							</div>
			            </section>
		        		<!-- SECTION 1 -->
			            <h2>
			            	<p class="step-icon"  onclick="$('#section').val(03);$('#next').attr('href', '#next');"><span>03</span></p>
			            	<span class="step-text"    onclick="$('#section').val(03);$('#next').attr('href', '#next');">Bussiness Information</span>
			            </h2>
			            <section>
			                <div class="inner">
			                	<div class="wizard-header">
									<h3 class="heading">Bussiness Information</h3>
									<p>Please enter business related information here  </p>
								</div>
								<div class="form-row  form-row-date">
									<div class="form-holder  form-holder-2">
										<fieldset>
											<legend id="input1"><span style="color:red;"> * </b></span>Bussiness Name</legend>
											<input type="text" class="form-control" id="Company_name" name="Company_name"  required placeholder="e.g. Deere Coffee House" onkeypress="return isSpecialCharacters(event,this.id);">
										</fieldset>
									</div>
									
									
									
								</div>
								<div class="form-row  form-row-date">
								
									
									<div class="form-holder   form-holder-2" id="input8">
												<legend id="input16"><span style="color:red;"> * </b></span>Select Bussiness Type</legend>
												<select name="Company_type" id="Company_type"  style="width: 100%;" required>
													<option value=""  selected  >Select </option>
													<?php 
														foreach($Company_type as $Company_type)
														{
															// if($Company_type->Code_decode_id==240 || $Company_type->Code_decode_id==242){
															echo "<option value=".$Company_type->Code_decode_id." >".$Company_type->Code_decode."</option>";
															// }
														}
													?>
												</select>
												
									</div>
									
								</div>
								<div class="form-row form-row-date">
									<div class="form-holder form-holder-2">
										<!--<label class="special-label">Business Owner:</label>-->
										<div class="form-row">
											<div class="form-holder">
												<fieldset>
													<legend  id="input2"><span style="color:red;"> * </b></span>First Name</legend>
													<input type="text" class="form-control" id="First_name" name="First_name"  required placeholder="e.g. John" onkeypress="return isSpecialCharacters(event,this.id);">
												</fieldset>
											</div>
								
									<div class="form-holder">
												<fieldset>
													<legend id="input3"><span style="color:red;"> * </b></span>Last Name</legend>
													<input type="text" class="form-control" id="Last_name" name="Last_name"  required placeholder="e.g. Deere" onkeypress="return isSpecialCharacters(event,this.id);">
												</fieldset>
									</div>
									
										</div>
									</div>
								</div>
								<div class="form-row form-row-date">
									<div class="form-holder form-holder-2">
										
										<div class="form-row">
											<div class="form-holder">
												<fieldset>
													<legend  id="input5"><span style="color:red;"> * </b></span>Phone Number</legend>
													<input type="text" class="form-control" id="Company_primary_phone_no"  onkeyup="this.value=this.value.replace(/\D/g,'')" name="Company_primary_phone_no"  required placeholder="e.g. 123456789"   onchange="javascript:check_userdata(this.value,2);" maxlength='10'>
													<div class="help-block form-text with-errors form-control-feedback" id="help-block2"></div>	
												</fieldset>
											</div>	
											<div class="form-holder">
												<fieldset>
													<legend  id="input4"><span style="color:red;"> * </b></span>Email ID</legend>
													<input type="email" name="Company_primary_email_id" id="Company_primary_email_id" class="form-control" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" required placeholder="e.g. JohnD@deere.com"  onchange="javascript:check_userdata(this.value,1);">
													<!--onchange="javascript:check_userdata(this.value,1);"-->
													<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>	
												</fieldset>
												 <div class="card-footer bg-white py-3">
													 <div class="btn-group btn-group-toggle" data-toggle="buttons">
													
													 <button type="button" class="btn btn-info btn-sm" onclick="VerifyEmail(Company_primary_email_id.value);">Verify Email</button>
													</div>
													<p id='please' style='color:green;display:none;'><br>Please wait...</p>
													<!--<button type="button" class="btn btn-info btn-sm">Verify Email</button>-->
												  </div>
										
											</div>
										
											
										</div>
									</div>
								</div>
								
								
								
								<div class="form-row form-row-date" id="VerificationCodeblock"  style="display:none;margin-top: -45px;">
									<p style="color:green;">Please check your Email for the Verification Code and enter below.</p>
									<p style="color:grey;font-size:10px;">( NOTE: Please do check your Spam or Junk folder too) </p>
									<div class="form-holder form-holder-2">
										
										<div class="form-row">
											<div class="form-holder">
												<fieldset>
													<legend  id="input4"><span style="color:red;"> * </b></span>Verification Code</legend>
													<input type="text" class="form-control" id="VerificationCode"  onkeyup="this.value=this.value.replace(/\D/g,'')" name="VerificationCode"      maxlength='6' placeholder="Enter Veification Code" >	
												</fieldset>
												
											</div>
										
											<div class="form-holder">
													
													 <button type="button" class="btn btn-info btn-sm" onclick="VerifyVerificationCode(VerificationCode.value);"  style="margin-top: 10px;">Submit</button>
												
											</div>
										</div>
									</div>
								</div>
								<p style="color:green;"  id="VerificationCodemsg"  ></p>
								<p style="color:red;"  id="VerificationCodeerrmsg"  ></p>
								
								
								<div class="form-row form-row-date" style="display:none;" id="VeriftHide1">
									<div class="form-holder form-holder-2">
										
										<div class="form-row">
											
											
											<div class="form-holder" id="">
												<legend id="input14"><span style="color:red;"> * </b></span>Select Outlets</legend>
												<select name="Seller_licences_limit" id="Seller_licences_limit"  style="width: 100%;"  >
													<option value=""  selected  >Select</option>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
													<option value="5">5</option>
													
													</select>
													
												
											</div>
											
											
											<div class="form-holder">
														<fieldset>
															<legend  id="input7"><span style="color:red;"> * </b></span>Loyalty Domain Name</legend>
															<input type="text" class="form-control" id="Domain_name" name="Domain_name"  required placeholder="e.g. DeereWeb"   onchange="javascript:check_userdata(this.value,3);"  onkeypress="return isOnlyCharacters(event,this.id);"  onkeyup="return $('#Domain_name').val($('#Domain_name').val().replace(/\s/g, ''));">
															<div class="help-block form-text with-errors form-control-feedback" id="help-block3"></div>	
															
														</fieldset>
														<font color="#f74d40" size='1.5px'>(Note:Please Enter Domain name without space)</font> 
											</div>
										</div>
										
									</div>
								</div>
								
								
								
								<div class="form-row form-row-date"   style="display:none;"  id="VeriftHide2">
									<div class="form-holder form-holder-2" >
										
										<div class="form-row">
											<div class="form-holder" id="">
												<legend id="input14"><span style="color:red;"> * </b></span>Select Country</legend>
												<select name="Country" id="Country"  style="width: 100%;" onchange='javascript:var id = $(this).children(":selected").attr("id");$("#timezone_entry").val(id);var m = $("#timezone_entry option:selected").text();$("#timezone_entry2").val(m);' >
													<option value=""  selected  >Select</option>
													<!--<option value="101" id='IN'>India</option>
													<option value="69" id="ET">Ethiopia</option>
													<option value="192" id="SN">Senegal</option>
													<option value="207" id="SD">Sudan</option>
													<option value="229" id="AE">United Arab Emirates</option>-->
													<?php 
														foreach($Country_array as $Country)
														{
															if($Country['Gifting_flag']==0){continue;}
															echo "<option value=".$Country['id']."  id=".$Country['sortname']." >".$Country['name']."</option>";
														}
													?>
												</select>
												
											</div>
											<div class="form-holder"  id="input9">
												<input type='hidden' name="timezone_entry2" id="timezone_entry2" value=''>
												<legend id="input15"><span style="color:red;"> * </b></span>Select Time Zone</legend>
												<select name="timezone_entry" id="timezone_entry"  style="width: 100%;" >
													<option value=""  selected>Select </option>
													<?php
													/* $zones = timezone_identifiers_list();
													foreach ($zones as $zone)
													{
														echo "<option  value=".$zone.">".$zone."</option>";
													} */
													foreach($Timezones as $Timezones)
														{
															echo "<option value=".$Timezones['Country_code']."  >".$Timezones['Timezone']."</option>";
														}
												?>
												</select>
												
											</div>
											
										</div>
										
									</div>
								</div>
							
								<div class="form-row form-row-date"  style="display:none;"  id="VeriftHide3">
									<div class="form-holder form-holder-2">
										
										<div class="form-row">
											<div class="form-holder">
												<!--<fieldset>
													<legend  id="input10">Address</legend>
													<input type="text" class="form-control"  style="height:50px !important;" id="Company_address" name="Company_address"  required placeholder="e.g. MG Road,Mumbai">
													
													
												</fieldset>-->
												<legend  id="input10"><span style="color:red;"> * </b></span>Address</legend> 
												<textarea  style="border: 2px solid #e5e5e5;
													border-radius: 4px;
													outline: none;
													font-weight: 600;
													font-size: 14px;
													font-family: 'Open Sans', sans-serif;
													padding: 0 20px;" rows="4" cols="26"  placeholder="e.g. 5th Block, 40th Downing Street, P.O Box 411001"  id="Company_address" name="Company_address" onkeypress="return isSpecialCharacters(event,this.id);" ></textarea>
											</div>
											<div class="form-holder">
											<font color="#f74d40" size='1.5px'>(You can upload logo upto 500kb)</font> 
											<div class="upload-btn-wrapper">
											  <button class="btn">Upload Bussiness Logo</button>
											  <input type="file" id="Company_logo" name="Company_logo"   style="cursor:pointer;" onchange="readImage(this,'#CompanyLogo1');" />
											<br>
											
											 <div class="thumbnail" id="Logo" style="width:100px; display:none;"><br>
									<img src="" id="CompanyLogo1" class="img-responsive">
									</div>
											</div>
											
											
																						<!--
														<fieldset>
															<legend>Upload Bussiness Logo</legend>
															<input type="file" class="form-control" id="Company_logo" name="Company_logo"  required>
														</fieldset>-->
											</div>
										</div>
										
									</div>
								</div>
								<!--<p style="color:red;text-align:center;display:none;" id="error">Please fill all the blanks</b></p>-->
								<span style="color:red;font-size: 14px;" class="special-label">  * Required Fields </b></span>
							</div>
			            </section>	<!-- SECTION 3 -->
			            <h2>
			            	<p class="step-icon"  onclick="$('#section').val(04);$('#next').attr('href', '#next');"><span>04</span></p>
			            	<span class="step-text"   onclick="$('#section').val(04);$('#next').attr('href', '#next');">Loyalty Information</span>
			            </h2>
			            <section>
						
			                <div class="inner">
			                	<div class="wizard-header">
									<h3 class="heading">Configure Loyalty Rule</h3>
									<p>Please enter basic loyalty configuration related information here  </p>
									
								</div>
									
								<div class="form-row">
									<div class="form-holder  form-holder-2">
									
									<div class="plan-total">
		                					<span class="plan-title">a) Set Loyalty Rule Program Name</span>
		                			
		                				</div>

										<fieldset>
											<legend  id="input11"><span style="color:red;"> * </b></span>Loyalty Rule Name</legend>
											<input type="text" class="form-control" id="Loyalty_name" name="Loyalty_name" placeholder="e.g. ABC Summer Bonanza"  required onkeypress="return isSpecialCharacters(event,this.id);">
										</fieldset>
									</div>
									
								</div>
			                
								
							
							
							
								<div class="form-row form-row-date">
									<div class="form-holder form-holder-2">
									
									<div class="plan-total">
		                					<span class="plan-title">b) Issue Loyalty Points on either</span>
		                			
		                				</div>
										
										<div class="form-row">
											<div class="form-holder">
												<div class="wrapper wrapper_radio">
													  <input type="radio"  name="loyalty_rule_setup" id="PA" value="PA" checked  onclick="javascript:$('#trans').html('Total Purchase');">
													  <label for="PA"  class="special-label" style="font-size: 14px;">Total Purchase</label>
												</div>
												
											<!--
												<input type="radio" class="radio" name="loyalty_rule_setup" id="plan-3" value="PA" checked  onclick="javascript:$('#trans').html('Total Purchase');">
			                			<label class="plan-icon plan-3-label" for="plan-3" style=" width: 40px; height: 40px;">
		                					<img src="<?php echo base_url(); ?>uploads/purchase2.jpg" alt="pay-3" style="height:20px;width:20px;">
			                			</label>
										<label class="special-label">Total Purchase</label>
			                			-->
											</div>
											<div class="form-holder">
											<div class="wrapper wrapper_radio">
													 <input type="radio"  name="loyalty_rule_setup" id="BA" value="BA" onclick="javascript:$('#trans').html('Paid Amount');">
													  <label for="BA"  class="special-label" style="font-size: 14px;">Paid Amount</label>
												</div>
											<!--
												<input type="radio" class="radio" name="loyalty_rule_setup" id="plan-4" value="BA" onclick="javascript:$('#trans').html('Paid Amount');">
			                			<label class="plan-icon plan-4-label" for="plan-4" style=" width: 40px; height: 40px;">
			                					<img src="<?php echo base_url(); ?>uploads/balance.png" alt="pay-4" style="height:20px;width:20px;">
			                			</label>
										<label class="special-label">Paid Amount</label>
			                			-->
											</div>
											
											
										</div>
										
									</div>
								</div>
							
									<div class="form-row" style="margin-top: -20px !important;">
									<div class="form-holder  form-holder-2">
									<div class="plan-total">
		                					<span class="plan-title">c) Set Loyalty Points Issuance Percentage on <span id='trans'>Total Purchase</span></span>
		                			
		                				</div>
										
										<fieldset>
													<legend   id="input12"><span style="color:red;"> * </b></span>Issuance Percentage</legend>
													<input type="text" class="form-control" id="Loyalty_at_transaction" name="Loyalty_at_transaction"  required onkeypress="return isDecimal(event,this.id);"  placeholder="e.g. Enter Percentage as 2.5,2 etc">
												</fieldset>
												<legend   ><font color='red' id="issueerror"></font></legend>
									</div>
									
								</div>
								
									<div class="form-row">
									<div class="form-holder  form-holder-2">
									<div class="plan-total">
		                					<span class="plan-title">d) Set Redemption Ratio <br><font color="#f74d40" size='1.5px'>(e.g. if Redemption Ratio = 4 implies 1 INR = 4 Points)</font> </span>
		                			
		                				</div>
										
										<fieldset>
													<legend   id="input13"><span style="color:red;"> * </b></span>Redemption Ratio</legend>
													<input type="text" class="form-control" id="Redemptionratio" name="Redemptionratio"  required  onkeypress="return isDecimal(event,this.id);" placeholder="eg.Enter Redemption Ratio as 4,5 etc">
												</fieldset>
												<legend  id="redeerror" style="display:none;"><font color='red'>Redemption Ratio Should be Greater than 0</font></legend>
									</div>
									
								</div>
								
									
									<div class="form-row form-row-date">
									<div class="form-holder form-holder-2">
										<div class="plan-total">
		                					<span class="plan-title">e) Select Joining and/or Refferral Bonus?</span>
		                			
		                				</div>
										
										<div class="form-row">
											<div class="form-holder">
											 <div class="wrapper">
												  <input id="Joining_bonus" name="Joining_bonus" type="checkbox"  value="0" onclick="javascript:Bonus_points_toggle(1);">
												  <label for="Joining_bonus"  class="special-label" style="font-size: 14px;">Joining Bonus</label>
											</div>
											<!--
												<input type="radio" class="radio" name="Joining_bonus" id="plan-5" value="0" onclick="javascript:Bonus_points_toggle(1);">
													<label class="plan-icon plan-5-label" for="plan-5" style=" width: 40px; height: 40px;">
														<img src="<?php echo base_url(); ?>uploads/bonus.png" alt="pay-5" style="height:20px;width:20px;">
													</label>
													<div class="plan-total">
													<label class="special-label">Joining Bonus</label>
												
													</div>
													-->
											</div>
											<div class="form-holder">
											 <div class="wrapper">
												  <input id="Refferral_bonus" name="Refferral_bonus" type="checkbox"  value="0" onclick="javascript:Bonus_points_toggle(2);">
												  <label for="Refferral_bonus"  class="special-label" style="font-size: 14px;">Refferral Bonus</label>
											</div>
											<!--
												<input type="radio" class="radio" name="Refferral_bonus" id="plan-6" value="0"  onclick="javascript:Bonus_points_toggle(2);">
													<label class="plan-icon plan-6-label" for="plan-6" style=" width: 40px; height: 40px;">
															<img src="<?php echo base_url(); ?>uploads/referral.png" alt="pay-6" style="height:20px;width:20px;">
													</label>
													<div class="plan-total">
													<label class="special-label">Refferral Bonus</label>
													
													</div>
													-->
											</div>
											
											
										</div>
										
									</div>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-2">
										<!--<label class="special-label">Business Owner:</label>-->
										<div class="form-row" style="margin-top:-40px !important;">
										
											<div class="form-holder" id="Joining" style="display:none;">
												<fieldset>
													<legend>Enter Joining Bonus Points</legend>
													<input type="text" class="form-control" id="Joining_bonus_points" name="Joining_bonus_points"  required placeholder="e.g 100,150 etc."  onkeyup="this.value=this.value.replace(/\D/g,'')">
												</fieldset>
											</div>
								
											<div class="form-holder" id="join2">
												
													&nbsp;
													
												
											</div>
								
									<div class="form-holder" id="RefferralPoints" style="display:none;">
												<fieldset>
													<legend>Enter Refferral Bonus Points</legend>
													<input type="text" class="form-control" id="Refferral_bonus_points" name="Refferral_bonus_points"  required placeholder="e.g 100,150 etc." onkeyup="this.value=this.value.replace(/\D/g,'')" >
												</fieldset>
									</div>
									
										</div>
									</div>
									<br><br><br><br><br>
								</div>
								
								
									
								
								<span style="color:red;font-size: 14px;" class="special-label">  * Required Fields </b></span>
								
							</div>
							
			            </section>
			
			            		
						<!-- SECTION 2 --
			            <h2>
			            	<p class="step-icon"><span>02</span></p>
			            	<span class="step-text">Connect Bank Account</span>
			            </h2>
			            <section>
			                <div class="inner">
			                	<div class="wizard-header">
									<h3 class="heading">Connect Bank Account</h3>
									<p>Please enter your infomation and proceed to the next step so we can build your accounts.</p>
								</div>
								<div class="form-row">
									<div class="form-holder form-holder-1">
										<input type="text" name="find_bank" id="find_bank" placeholder="Find Your Bank" class="form-control" required>
									</div>
								</div>
								<div class="form-row-total">
									<div class="form-row">
				                		<div class="form-holder form-holder-2 form-holder-3">
				                			<input type="radio" class="radio" name="bank-1" id="bank-1" value="bank-1" checked>
				                			<label class="bank-images label-above bank-1-label" for="bank-1">
				                				<img src="<?php echo base_url(); ?>images/form-v1-1.png" alt="bank-1">
				                			</label>
											<input type="radio" class="radio" name="bank-2" id="bank-2" value="bank-2">
											<label class="bank-images label-above bank-2-label" for="bank-2">
												<img src="<?php echo base_url(); ?>images/form-v1-2.png" alt="bank-2">
											</label>
											<input type="radio" class="radio" name="bank-3" id="bank-3" value="bank-3">
											<label class="bank-images label-above bank-3-label" for="bank-3">
												<img src="<?php echo base_url(); ?>images/form-v1-3.png" alt="bank-3">
											</label>
				                		</div>
				                	</div>
				                	<div class="form-row">
				                		<div class="form-holder form-holder-2 form-holder-3">
				                			<input type="radio" class="radio" name="bank-4" id="bank-4" value="bank-4">
				                			<label class="bank-images bank-4-label" for="bank-4">
				                				<img src="<?php echo base_url(); ?>images/form-v1-4.png" alt="bank-4">
				                			</label>
											<input type="radio" class="radio" name="bank-5" id="bank-5" value="bank-5">
											<label class="bank-images bank-5-label" for="bank-5">
												<img src="<?php echo base_url(); ?>images/form-v1-5.png" alt="bank-5">
											</label>
											<input type="radio" class="radio" name="bank-6" id="bank-6" value="bank-6">
											<label class="bank-images bank-6-label" for="bank-6">
												<img src="<?php echo base_url(); ?>images/form-v1-6.png" alt="bank-6">
											</label>
				                		</div>
				                	</div>
								</div>
							</div>
			            </section>
			           -->
		        	</div>
		        </form>
			</div>
		</div>
	</div>
	<!-------------------- Loyalty License - Start -------------------->
  
<div aria-hidden="true" aria-labelledby="mySmallModalLabel" id="License_model" class="modal fade bd-example-modal-sm" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false" style="overflow: unset !important;left:20% !important;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" >
		 <div class="modal-header">
				<span class="plan-title" style="font-size: 22px;font-family: 'Open Sans', sans-serif;" id="model_header"></span>
				<span aria-hidden="true" aria-label="Close" class="close" data-dismiss="modal" type="button" style="cursor:pointer;font-size: 18px;color: #666;font-weight: 600;">Close</span>
			  </div>
		<!--background-color: transparent;-->
            <div class="modal-body text-center">
			
                    <div class="inner">
			                	
								<div class="form-row">
			                		<div class="form-holder form-holder-2" style="padding: 30px;">
			                			
			                			
			                			<div class="plan-total" id="std"  style="display:none;">
		                					<span class="plan-title" style="font-size: 22px;margin-left:10px;    font-family: 'Open Sans', sans-serif;">Basic</span>
		                					<p class="plan-text" >
											
											<table style="font-size: 16px;"  class="plan-text ul_licence" border="0px">	
											<tr>
												
												<td ><span  class="bullet">Set Multiple Loyalty Rules</td>
												<td><span  class="bullet">Issue Instant Discounts and Vouchers</span></td>
											</tr>
											<tr>
												
												<td><span  class="bullet">Have a Referral Bonus & Joining Bonus</span></td>
												<td><span  class="bullet">Draft and Send Communication to Customers</span></td>
											</tr>
											<tr>
												
												<td><span  class="bullet">Loyalty Portal on Secure CLOUD</span></td>
												<td><span  class="bullet">Unlimited Customer Enrollment</span></td>
											</tr>
											<tr>
												
												<td><span  class="bullet">Configurable Loyalty Campaign</span></td>
												<td><span  class="bullet">Gift Card , Referral Program</span></td>
											</tr>
											</table>
											<!--<ul style="font-size: 16px; line-height: 2.6;"  class="plan-text ul_licence">
												
											  <li>Set Multiple Loyalty Rules</li>
											  <li>Issue Instant Discounts and Vouchers</li>
											  <li>Have a Referral Bonus & Joining Bonus</li>
											  <li>Draft and Send Communication to Customers</li>
											  <li>Loyalty Portal on Secure CLOUD</li>
											  <li>Unlimited Customer Enrollment	</li>
											  <li>Configurable Loyalty Campaign	</li>
											  <li>Gift Card , Referral Program	</li>
											</ul>-->
										
											</p>
												
		                				</div>
			                			
			                		
			                			<div class="plan-total" id="enh" style="display:none;">
		                					<span class="plan-title" style="font-size: 22px;margin-left:10px;    font-family: 'Open Sans', sans-serif;">Standard ++</span>
		                					<p class="plan-text">
											
											<table style="font-size: 16px;"  class="plan-text ul_licence" border="0px">	
											<tr>
												
												<td ><span  class="bullet">Create Merchandizing Catalogue</span></td>
												<td><span  class="bullet">Set Trigger-based Notifications</span></td>
											</tr>
											<tr>
												
												<td><span  class="bullet">Create & Send Surveys</span></td>
												<td><span  class="bullet">Social Media Connect</span></td>
											</tr>
											<tr>
												
												<td><span  class="bullet">Create Engaging Campaigns</span></td>
												<td><span  class="bullet">Loyalty Dashboard</span></td>
											</tr>
											<tr>
												
												<td width="330"><span  class="bullet">Gamification I  <span style="font-size:12px;"><br>&nbsp;&nbsp;&nbsp;&nbsp;( Campaigns like Auction Bidding, Promo Code )</span></span></td>
												<!--<td style=" word-wrap:break-word;"><span  class="bullet">Gamification II <span style="font-size:12px;"><br>&nbsp;&nbsp;&nbsp;&nbsp;( Campaigns linked to Game to issue Points when played Games like - Tetris, Candy Crush, Sudoko, Maze )</span></span></td>-->
											</tr>
											</table>
											<!--
											<ul style="font-size: 16px; "  class="plan-text ul_licence">
											  <li>Create Merchandizing Catalogue</li>
											  <li>Set Trigger-based Notifications</li>
											  <li>Create & Send Surveys </li>
											  <li>Social Media Connect</li>
											  <li>Create Engaging Campaigns</li>
											  <li>Loyalty Dashboard	</li>
											  <li>Gamification I ( Campaigns like Auction Bidding, Promo Code )	</li>
											  <li>Gamification II ( Campaigns linked to Game to issue Points when played Games like - Tetris, Candy Crush, Sudoko, Maze )</li>
											  <li>Survey Module	</li>
											</ul>-->
										</p>
		                				</div>
										
			                		</div>
			                	</div>
								
			
				
							
						
								
					</div>
            </div>            
        </div>
    </div>
</div>

<!-------------------- Loyalty License - End -------------------->
	<!-------------------- Loader Model - Start -------------------->
  <div id="cover-spin"></div>
  <div id="cover-spin1"><img style="margin-left:45%;margin-top: 15%;" src="<?php echo base_url(); ?>images/loader.gif" width="10%"></div>
<!--
<div aria-hidden="true" aria-labelledby="mySmallModalLabel" id="loader_model" class="modal fade bd-example-modal-sm" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="-webkit-box-shadow:none;border:1px !important; left:0;right:0;top:0;bottom:0;"><!--background-color: transparent;--
            <div class="modal-body text-center">
                <img alt="" src="<?php //echo base_url(); ?>images/loader2.gif" >
            </div>            
        </div>
    </div>
</div>-->



<!-------------------- Loader Model - End -------------------->
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>

<script>

function show_loader() {
    // $('#loader_model').modal('show');
	$('#cover-spin1').show(0);
}

function VerifyEmail(email)
{
	// alert(email);
	$('#VerificationCodeblock').hide();
	if(email != '')
	{
			
			$('#VeriftHide1').hide();
		   $('#VeriftHide2').hide();
		   $('#VeriftHide3').hide();
		   $('#VerificationCodemsg').html('');
		   $('#VerificationCodeerrmsg').html('');
		check_userdata(email,1);
		$('#please').show();
		$.ajax({
			  type: "POST",
			  data: {email: email},
			  url: "<?php echo base_url()?>index.php/Register_saas_company/Verify_email",
			  success: function(json)
			  {
				  // alert('json Verification_code '+json['Verification_code']);
				 
				  if(json['Verification_code'])
				  {
					 $('#VerificationCodeblock').show();
					 $('#please').hide();
				  }
			  }
		});
	}
}
function VerifyVerificationCode(INPCODE)
{
	
	
	
	
	$.ajax({
			  type: "POST",
			  data: {INPCODE: INPCODE},
			  url: "<?php echo base_url()?>index.php/Register_saas_company/Verify_emailCode",
			  success: function(json)
			  {
				  // alert(json['Verified_flag']);
				   if(json['Verified_flag']==1)
					 {
						 // alert('ok');
						  // id="VeriftHide1"
						   $('#VeriftHide1').show();
						   $('#VeriftHide2').show();
						   $('#VeriftHide3').show();
							$('#VerificationCodemsg').html('Your given Email ID Verified Successfully !!!');
							$('#VerificationCodeerrmsg').html('');
						  
						   $('#VerificationCodeblock').hide();
					 }
					 else
					 {
						 $('#VeriftHide1').hide();
						   $('#VeriftHide2').hide();
						   $('#VeriftHide3').hide();
						   $('#VerificationCodeerrmsg').html('Incorrect Verification Code !!!');
						 // alert('NOT ok');
					 }
			  }
		});
		
		
	
	
}
function form_submit(id)
{
	var section = $('#section').val();
	// alert(section);
	// $("#next").attr("href", "#next");
	// if(id=='previous'){$("#next").attr("href", "#next");}
	/* $("#next").attr("href", "#next");
	$("#previous").attr("href", "#next");
	if(id=='previous'){$("#previous").attr("href", "");}
	 alert('--id -'+id);  */
	 // alert('--section -'+section); 
	// window.location = "http://www.google.com/";
	/* {
			$('#error').hide();
			$('#section').val(4);
			$("#next").attr("href", "#next");
			
			
			// $("#myForm").submit();
			// show_loader();
		}
		else
		{
			$('#error').show();
			$("#next").attr("href", "");
			// $('#next').prop('disabled', false);alert();
		} */
		$("#next").attr("href", "#next");
		if(document.getElementById("Terms_and_Conditions").checked==false)
		{
			$("#next").attr("href", "");
		}
		else
		{ 
			$("#next").attr("href", "#next");
		}
	if(section==1)
	{
		if(document.getElementById("Terms_and_Conditions").checked==true)
		{
			$('#section').val(2);
		}
		
	}
	 if(section==2)
	{
		$('#section').val(3);
	}
	 
	if(section==3)
	{
		// $("#next").hide();
	
		
		
		if ($('#Company_name').val() == "") {
            $("#input1").css("color", "red");
            $("#Company_name").focus();
        }
		else
		{
			$("#input1").css("color", "");
		}
		
		 if ($('#First_name').val() == "") { 
            $("#input2").css("color", "red");
            $("#First_name").focus();
        }
		else
		{
			$("#input2").css("color", "");
		}
		
		 if ($('#Last_name').val() == "") {
            $("#input3").css("color", "red");
            $("#Last_name").focus();
        }
		else
		{
			$("#input3").css("color", "");
		}
		
		 if ($('#Company_primary_email_id').val() == "") {
            $("#input4").css("color", "red");
            $("#Company_primary_email_id").focus();
        }
		else
		{
			$("#input4").css("color", "");
		}
		
		 if ($('#Company_primary_phone_no').val() == "") {
            $("#input5").css("color", "red");
            $("#Company_primary_phone_no").focus();
        }
		else
		{
			$("#input5").css("color", "");
		}
		
		 if ($('#Seller_licences_limit').val() == "") {
            $("#input6").css("color", "red");
            $("#Seller_licences_limit").focus();
        }
		else
		{
			$("#input6").css("color", "");
			 if ($('#Seller_licences_limit').val() == "0") {
				$('#Seller_licences_limit').val('');
				 $("#input6").css("color", "red");
				$("#Seller_licences_limit").focus();
				$("#Outleterror").show();
				
			}
		}
		
		 if ($('#Domain_name').val() == "") {
            $("#input7").css("color", "red");
            $("#Domain_name").focus();
        }
		else
		{
			$("#input7").css("color", "");
		}
		
		 if ($('#Country').val() == "") {
             // $("#Country").css("border", "1px solid red");//border: 2px solid #e5e5e5;
			 $("#input14").css("color", "red");//border: 2px solid #e5e5e5;
           
        }
		else
		{
			  // $("#Country").css("border", "1px solid #e5e5e5");//border: 2px solid #e5e5e5;
			  $("#input14").css("color", "");//border: 2px solid #e5e5e5;
		}
		 if ($('#Company_type').val() == "") {
             // $("#Company_type").css("border", "1px solid red");//border: 2px solid #e5e5e5;
			 $("#input16").css("color", "red");//border: 2px solid #e5e5e5;
           
        }
		else
		{
			  // $("#Company_type").css("border", "1px solid #e5e5e5");//border: 2px solid #e5e5e5;
			  $("#input16").css("color", "");//border: 2px solid #e5e5e5;
		}
		
		 if ($('#timezone_entry').val() == "") {
            // $("#timezone_entry").css("border", "1px solid red");//border: 2px solid #e5e5e5;
			$("#input15").css("color", "red");//border: 2px solid #e5e5e5;
           
        }
		else
		{
			  // $("#timezone_entry").css("border", "1px solid #e5e5e5");//border: 2px solid #e5e5e5;
			  $("#input15").css("color", "");//border: 2px solid #e5e5e5;
		}
		 if ($('#Company_address').val() == "") {
            $("#input10").css("color", "red");//border: 2px solid #e5e5e5;
            $("#Company_address").focus();
        }
		else
		{
			 $("#input10").css("color", "");
		}
		
		if ($('#Company_primary_email_id').val() != "") {
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				if(!emailReg.test($('#Company_primary_email_id').val())) {
					$("#input4").css("color", "red");
					$("#Company_primary_email_id").focus();
				}
				
		}
			  
		if( $('#Company_name').val() != "" &&  $('#First_name').val() != "" &&  $('#Last_name').val() != "" && $('#Company_address').val() != "" &&  $('#Company_primary_email_id').val() != ""  && $('#Company_primary_phone_no').val() != ""  && $('#Domain_name').val() != ""  && $('#Seller_licences_limit').val() != "" && $('#Country').val() != "" && $('#timezone_entry').val() != "" && $('#Company_type').val() != "")
		{
			$('#error').hide();
			$('#section').val(4);
			$("#next").attr("href", "#next");
			
			
			// $("#myForm").submit();
			// show_loader();
		}
		else
		{
			$('#error').show();
			$("#next").attr("href", "");
			// $('#next').prop('disabled', false);alert();
		}
			
		
			
	}
	if(section==4)
	{
		  
		if ($('#Loyalty_name').val() == "") {
            $("#input11").css("color", "red");
            $("#Loyalty_name").focus();
        }
		else
		{
			$("#input11").css("color", "");
		}
		if ($('#Loyalty_at_transaction').val() == "") {
            $("#input12").css("color", "red");
            $("#Loyalty_at_transaction").focus();
        }
		else
		{
			$("#input12").css("color", "");
			$("#issueerror").html('');
			 if ($('#Loyalty_at_transaction').val() == 0) {
				$('#Loyalty_at_transaction').val('');
				 $("#input12").css("color", "red");
				$("#Loyalty_at_transaction").focus();
				$("#issueerror").html('Issuance Percentage Should be Greater than 0');
				
			}
			 if ($('#Loyalty_at_transaction').val() > 100) {
				$('#Loyalty_at_transaction').val('');
				 $("#input12").css("color", "red");
				$("#Loyalty_at_transaction").focus();
				$("#issueerror").html('Issuance Percentage Should not be Greater than 100');
				
			}
		}
		if ($('#Redemptionratio').val() == "") {
            $("#input13").css("color", "red");
            $("#Redemptionratio").focus();
        }
		else
		{
			$("#input13").css("color", "");
			 if ($('#Redemptionratio').val() == 0) {
				$('#Redemptionratio').val('');
				 $("#input13").css("color", "red");
				$("#Redemptionratio").focus();
				$("#redeerror").show();
				
			}
		}
		
		if( $('#Loyalty_name').val() != "" &&  $('#Loyalty_at_transaction').val() != "" &&  $('#Redemptionratio').val() != "" )
		{
			$('#error').hide();
			if( $('#Company_name').val() != "" &&  $('#First_name').val() != "" &&  $('#Last_name').val() != "" && $('#Company_address').val() != "" &&  $('#Company_primary_email_id').val() != ""  && $('#Company_primary_phone_no').val() != ""  && $('#Domain_name').val() != ""  && $('#Seller_licences_limit').val() != "" && $('#Country').val() != "" && $('#timezone_entry').val() != "" && $('#Company_type').val() != "")
			{
				
			
				if($('#section').val()==4)
				{
					show_loader();
				/* 	$.ajax({
					type:"POST",
					data:{Loyalty_name:$('#Loyalty_name').val()},
					url:'<?php echo base_url()?>index.php/Register_saas_company/insert_saas_company_master',
					success:function(opData2){
						
						$('#complete').html('complete');

					}
				}); */
					$("#myForm").submit();
				}
			}
			
		}
		else
		{
			$('#error').show();
		}
		
	}
	
	// alert('---'+id);
	
}



function check_userdata(inpData,flag)
{
	if( inpData != "" )
	{
		if(flag==1){var inpData = $("#Company_primary_email_id").val();}
		if(flag==2){var inpData = $("#Company_primary_phone_no").val();}
		if(flag==3){var inpData = $("#Domain_name").val();}
		
		$.ajax({
			  type: "POST",
			  data: {inpData: inpData, flag: flag},
			  url: "<?php echo base_url()?>index.php/Register_saas_company/check_userdata",
			  success: function(data)
			  {
				  // alert(inpData);
				  // alert(data);
				  // alert(inpData.length);
					if(data == 1)
					{
						
						
						var msg1 = '<font size="1px" color="red">Already exist</font>';
						
						
						$("#Company_primary_email_id").addClass("form-control has-error");
						if(flag==1){$('#help-block1').html(msg1);$("#Company_primary_email_id").val('');}
						if(flag==2){$('#help-block2').html(msg1);$("#Company_primary_phone_no").val('');}
						if(flag==3){$('#help-block3').html(msg1);$("#Domain_name").val('');}
						// setTimeout(function(){ $('.help-block2').hide(); }, 3000);
						return false; 
					}
					else
					{
						
						$("#help-block1").html("");
						$("#help-block2").html("");
						$("#help-block3").html("");
						
						var msg1 = '<font size="1px" color="red">Invalid Phone number</font>';
						var msg2 = '<font size="1px" color="red">Invalid Email ID</font>';
						
					if(flag==2)	{ if(inpData.length<10){$('#help-block2').html(msg1);$("#Company_primary_phone_no").val('');}}
					
						 if(flag==1){
							var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
							  if(!regex.test(inpData)) {
								  $('#VerificationCodeblock').hide();
								  $('#help-block1').html(msg2);$("#Company_primary_email_id").val('');
								return false;
							  }else{
								// $('#please').show();	   
								return true;
							  }
							  
						} 
					
					
					
					}
			  }
		});
	}

}


function Bonus_points_toggle(evt)
{
	
	if(evt==1)//Joining
	{
		if($('#Joining_bonus').val()==1)
		{
			$('#Joining').hide();
			$('#join2').show();
			$('#Joining_bonus').val(0);
			// $('.plan-5-label').css('background','#999');
		}
		else
		{
			$('#Joining_bonus').val(1);
			$('#Joining').show();
			$('#join2').hide();
			// $('.plan-5-label').css('background','#68c0c7');
		}
	}
	else //Refferral
	{
		if($('#Refferral_bonus').val()==1)
		{
			$('#RefferralPoints').hide();
			$('#Refferral_bonus').val(0);
			// $('.plan-6-label').css('background','#999');
		}
		else
		{
			$('#Refferral_bonus').val(1);
			$('#RefferralPoints').show();
			// $('.plan-6-label').css('background','#68c0c7');
		}
	}
}
function isDecimal(evt,id)
{ 
	var Input = $('#'+id);
   Input.val(Input.val().replace(/[^0-9\.]/g, ''));
   if ((evt.which != 46 || Input.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
   {
     evt.preventDefault();
   }

   
 }

function isSpecialCharacters(e,id)
{ 
		var regex = new RegExp("^[a-zA-Z0-9\'/' '\,\.\-\]");
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		
		const subst='';
		if(e.charCode == 39) {
			e.charCode = 0;
			return false;
		}
		
		if(regex.test(str)) {
			
			return true;
		}
		else
		{
			e.preventDefault();
			return false;
		} 
		
 }

function isOnlyCharacters(e,id)
{ 
		var regex = new RegExp("^[a-zA-Z0-9\'/' '\,\-\]");
		var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
		
		const subst='';
		if(e.charCode == 39) {
			e.charCode = 0;
			return false;
		}
		
		if(regex.test(str)) {
			
			return true;
		}
		else
		{
			e.preventDefault();
			return false;
		} 
		
 }

function readImage(input,div_id) 
{
	document.getElementById('Logo').style.display="";
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function (e) {
			$(div_id)
				.attr('src', e.target.result)
				.height(100);
		};

		reader.readAsDataURL(input.files[0]);
	}
}
function standard_more()
{
	$('#License_model').modal('show');$('#model_header').html('Standard Loyalty License');$('#std').show();$('#enh').hide();
}
function enhance_more()
{
	$('#License_model').modal('show');$('#model_header').html('Enhance Loyalty License');$('#enh').show();$('#std').hide();
}


function showOff(id){
	
	if(id==1){
		
		$('#chk3').removeClass('active');
		$('#chk2').removeClass('active');
	} 
	if(id==2){
		
		$('#chk3').removeClass('active');
		$('#chk1').removeClass('active');
	}
	if(id==3){
		
		$('#chk1').removeClass('active');
		$('#chk2').removeClass('active');
	}
}
</script>
	<style>
								
	.upload-btn-wrapper {
	  position: relative;
	  overflow: hidden;
	  display: inline-block;
	}

	.btn {
	  border: 2px solid #999;
	  color: #999;
	  background-color: white;
	  padding: 8px 20px;
	  border-radius: 8px;
	  font-size: 12px;
	  font-weight: bold;
	}

	.upload-btn-wrapper input[type=file] {
	  font-size: 100px;
	  position: absolute;
	  left: 0;
	  top: 0;
	  opacity: 0;
	}
</style>

<style>

/*style wrapper to give some space*/
.wrapper {
    position: relative;
	cursor:pointer;
}

/*style label to give some more space*/
.wrapper label {
    display: block;
    padding: 12px 0 12px 48px;
	cursor:pointer;
}

/*style and hide original checkbox*/
.wrapper input {
  height: 40px;
  left: 0;
  opacity: 0;
  position: absolute;
  top: 0;
  width: 40px;
  cursor:pointer;
}

/*position new box*/
.wrapper input + label::before {
 border: 2px solid;
    content: "";
    height: 20px;
    left: 18px;
    position: absolute;
    top: 10px;
    width: 20px;
    color: #68c0c7;
    cursor: pointer;
}

/*create check symbol with pseudo element*/
.wrapper input + label::after {
    color: #68c0c7;
    content: "";
    border: 3px solid;
    border-left: 0;
    border-top: 0;
    height: 18px;
    left: 24px;
    opacity: 0;
    position: absolute;
    top: 9px;
    transform: rotate(
45deg
);
    transition: opacity 0.2s ease-in-out;
    width: 10px;
    cursor: pointer;
}

/*reveal check for 'on' state*/
.wrapper input:checked + label::after {
  opacity: 1;
  cursor:pointer;
}

.wrapper_radio input + label::after {
    color: #68c0c7;
    content: "";
    opacity: 0;
    border: 8px solid;
    border-radius: 50%;
    position: absolute;
    left: 20px;
    top: 12px;
    height: 0px;
    width: 0px;
    transition: opacity 0.2s ease-in-out;
    cursor: pointer;
}
.ul_licence {
  list-style: none;
   columns: 2;
       font-family: 'Open Sans', sans-serif;
}

.ul_licence li::before {

  content: "\2022";
  color: #68c0c7;
  font-weight: bold;
  display: inline-block; 
  width: 1em;
  margin-left: -1em;
 
}
td{
  vertical-align: top;
  text-align: left;
   word-wrap:break-word;

}
.bullet{
    display:list-item;
    list-style:disc inside;
    padding:5px 0 0 14px;
    margin:0;
	
 word-wrap:break-word;
}
.card-header{
	height: 80px;
}
.mb-0{
	font-size: 11px;
	color: #000;
}
.list-group-item{
	 height:100px;
	 padding: 5px;
	 text-align: left;	 
	font-size: 15px;
    font-weight: 500;
    color: #1366ac;
}
.list-group-item img{
	 position: absolute;
    top: 30%;
    right: 39%;
}

.blink {
  /* animation: blink-animation 1s steps(5, start) infinite;
  -webkit-animation: blink-animation 1s steps(5, start) infinite; */
      color: yellow;
}
@keyframes blink-animation {
  to {
    visibility: hidden;
  }
}
@-webkit-keyframes blink-animation {
  to {
    visibility: hidden;
  }
}
legend{
	width: auto;
}
.inner .form-row .form-holder fieldset{
	padding: 1;

}
.form-control:focus{
	box-shadow:none;
}
.newCSS{
	    // color: #ccc;
    font-weight: 600;
    font-size: 15px;
    padding: 25px 0 8px;
    padding: 6px 0 8px;
}
</style>
<script src="<?php echo base_url(); ?>assets/js/validation.js"></script> 
<script type="text/javascript">
/*----------------------------DISABLE INSPECT ELEMENT-----------------------------*/
document.addEventListener('contextmenu', event => event.preventDefault());//DISABLE RIGHT CLICK

document.onkeydown = function(e) {
if(event.keyCode == 123) {
return false;
}
if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)){
return false;
}
if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)){
return false;
}

}
/*----------------------------DISABLE INSPECT ELEMENT----XXX-------------------------*/
</script>
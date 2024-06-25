<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Miraclecartes SaaS</title>
	<link rel="shortcut icon" href="http://miraclecartes.com/img/favicon.ico" type="image/x-icon">
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
	<!--<link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>-->

</head>
<body>
	<div class="page-content">
		<div class="form-v1-content">
			<div class="wizard-form">
		        <form class="form-register" action="<?php echo base_url();?>index.php/Register_saas_company/insert_saas_company_master" method="post" id="myForm">
		        	<div id="form-total">
					<p style="color:red;text-align:center;display:none;" id="error">Please fill the blanks</b></p>
						 <!-- SECTION 1 -->
						 <input type="hidden" id="section" value="01">
			            <h2>
			            	<p class="step-icon"><span >01</span></p>
			            	<span class="step-text">Welcome</span>
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
		                					<p class="plan-text">To embark  on this  journey, we will need some basic information i.e. the Loyalty License  to use  ( Standard OR Enhanced), some information about you and your company and some basic loyalty rules which will help you get started!</p>
											<br>
		                					<p class="plan-text">Once you enter these details, you will receive an Email within next 1-2  hours with application configured and with complete access details to the Loyalty application</p>
											<br>
		                					<p class="plan-text">So, get strapped  and relax. We will  always be an < email > or  < Phone No. > away for any help you need now and later!!</p>
											<br>
		                					<p class="plan-text">Yes, you agree to the < Terms & Conditions > as well.</p>
		                				</div>
			                			
										
			                		</div>
			                	</div>
								
			
				
								
								
								
							</div>
			            </section>  
						<h2>
			            	<p class="step-icon"><span >02</span></p>
			            	<span class="step-text">E-Commerce</span>
			            </h2>
			            <section>
			                <div class="inner">
			                	<div class="wizard-header">
									<h3 class="heading">Choose Online Ecommerce Portal</h3>
									
								</div>
								<input type="text" class="radio" name="Ecommerce_portal" id="Ecommerce_portal" value="shopify" checked>
								<div class="form-row-total">
									<div class="form-row">
				                		<div class="form-holder form-holder-2 form-holder-3">
				                			<input type="radio" class="radio" name="Ecommerce" id="bank-1" value="bank-1" checked  onclick="$('#Ecommerce_portal').val('shopify');">
				                			<label class="bank-images label-above bank-1-label" for="bank-1">
				                				<img src="<?php echo base_url(); ?>uploads/shopify.png" alt="bank-1" style="width: 85px;">
				                			</label>
											
											<input type="radio" class="radio" name="Ecommerce" id="bank-2" value="bank-2" onclick="$('#Ecommerce_portal').val('prestashop');">
											<label class="bank-images label-above bank-2-label" for="bank-2">
												<img src="<?php echo base_url(); ?>uploads/prestashop.png" alt="bank-2" style="width: 100px;">
											</label>
											<input type="radio" class="radio" name="Ecommerce" id="bank-3" value="bank-3"  onclick="$('#Ecommerce_portal').val('mangento');">
											<label class="bank-images label-above bank-3-label" for="bank-3">
												<img src="<?php echo base_url(); ?>uploads/mangento.png" alt="bank-3">
											</label>
				                		</div>
				                	</div>
				                	<div class="form-row">
				                		<div class="form-holder form-holder-2 form-holder-3">
				                			<input type="radio" class="radio" name="Ecommerce" id="bank-4" value="bank-4"  onclick="$('#Ecommerce_portal').val('woo');">
				                			<label class="bank-images bank-4-label" for="bank-4">
				                				<img src="<?php echo base_url(); ?>uploads/woo.png" alt="bank-4" style="width: 140px;">
				                			</label>
											
											
				                		</div>
				                	</div>
								</div>
								<!--
								<div class="form-row">
			                		<div class="form-holder form-holder-2">
			                			<input type="radio" class="radio" name="Company_License_type" id="plan-1" value="121" checked>
			                			<label class="plan-icon plan-1-label" for="plan-1">
		                					<img src="<?php echo base_url(); ?>uploads/shopify.png" alt="pay-1" style="height:50px;width:50px;">
			                			</label>
			                			<div class="plan-total">
		                					<span class="plan-title" style="font-size: 20px;">SHOPIFY</span>
		                					
		                				</div>
										
			                		</div>
			                		<div class="form-holder  form-holder-2">
			                			<input type="radio" class="radio" name="Company_License_type" id="plan-1" value="121" checked>
			                			<label class="plan-icon plan-1-label" for="plan-1">
		                					<img src="<?php echo base_url(); ?>uploads/prestashop.png" alt="pay-1" style="height:50px;width:50px;">
			                			</label>
			                			<div class="plan-total">
		                					<span class="plan-title" style="font-size: 19px;">PRESTASHOP</span>
		                					
		                				</div>
										
			                		</div>
			                	</div>
								<br><br><br><br>
								<div class="form-row">
			                		<div class="form-holder form-holder-2">
			                			<input type="radio" class="radio" name="Company_License_type" id="plan-1" value="121" checked>
			                			<label class="plan-icon plan-1-label" for="plan-1">
		                					<img src="<?php echo base_url(); ?>uploads/woo.png" alt="pay-1" style="height:50px;width:50px;">
			                			</label>
			                			<div class="plan-total">
		                					<span class="plan-title" style="font-size: 20px;">WOO COMMERCE</span>
		                					
		                				</div>
										
			                		</div>
			                		<div class="form-holder  form-holder-2">
			                			<input type="radio" class="radio" name="Company_License_type" id="plan-1" value="121" checked>
			                			<label class="plan-icon plan-1-label" for="plan-1">
		                					<img src="<?php echo base_url(); ?>uploads/mangento.png" alt="pay-1" style="height:50px;width:50px;">
			                			</label>
			                			<div class="plan-total">
		                					<span class="plan-title" style="font-size: 20px;">MAGENTO</span>
		                					
		                				</div>
										
			                		</div>
			                	</div>
								<br><br>
								<div class="form-row">
			                		<div class="form-holder form-holder-2">
			                			<input type="radio" class="radio" name="Company_License_type" id="plan-1" value="121" checked>
			                			<label class="plan-icon plan-1-label" for="plan-1">
		                					<img src="<?php echo base_url(); ?>uploads/basic2.png" alt="pay-1" style="height:50px;width:50px;">
			                			</label>
			                			<div class="plan-total">
		                					<span class="plan-title" style="font-size: 20px;">Others</span>
		                					
		                				</div>
										
			                		</div>
			                		
			                	</div>-->
								
			
				
								
			
				
								
								
								
							</div>
			            </section>
						
						<h2>
			            	<p class="step-icon"><span >03</span></p>
			            	<span class="step-text">Loyalty License</span>
			            </h2>
			            <section>
			                <div class="inner">
			                	<div class="wizard-header">
									<h3 class="heading">Choose Loyalty License</h3>
									
								</div>
								<div class="form-row">
			                		<div class="form-holder form-holder-2">
			                			<input type="radio" class="radio" name="Company_License_type" id="plan-1" value="121" checked>
			                			<label class="plan-icon plan-1-label" for="plan-1">
		                					<img src="<?php echo base_url(); ?>uploads/basic2.png" alt="pay-1" style="height:50px;width:50px;">
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
			                					<img src="<?php echo base_url(); ?>uploads/enhance2.png" alt="pay-1" style="height:50px;width:50px;">
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
								
			
				
								
								
								
							</div>
			            </section>
		        		<!-- SECTION 1 -->
			            <h2>
			            	<p class="step-icon"><span>04</span></p>
			            	<span class="step-text">Company Information</span>
			            </h2>
			            <section>
			                <div class="inner">
			                	<div class="wizard-header">
									<h3 class="heading">Company Information</h3>
									<p>Please enter your infomation and proceed to the next step so we can build your accounts.  </p>
								</div>
								<div class="form-row">
									<div class="form-holder  form-holder-2">
										<fieldset>
											<legend id="input1">Company Name</legend>
											<input type="text" class="form-control" id="Company_name" name="Company_name"  required placeholder="e.g. Deere Coffee House">
										</fieldset>
									</div>
									
								</div>
								<div class="form-row form-row-date">
									<div class="form-holder form-holder-2">
										<!--<label class="special-label">Business Owner:</label>-->
										<div class="form-row">
											<div class="form-holder">
												<fieldset>
													<legend  id="input2">First Name</legend>
													<input type="text" class="form-control" id="First_name" name="First_name"  required placeholder="e.g. John">
												</fieldset>
											</div>
								
									<div class="form-holder">
												<fieldset>
													<legend id="input3">Last Name</legend>
													<input type="text" class="form-control" id="Last_name" name="Last_name"  required placeholder="e.g. Deere">
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
													<legend  id="input4">Email ID</legend>
													<input type="email" name="Company_primary_email_id" id="Company_primary_email_id" class="form-control" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" required placeholder="e.g. JohnD@deere.com">
												</fieldset>
											</div>
										
											<div class="form-holder">
												<fieldset>
													<legend  id="input5">Phone Number</legend>
													<input type="text" class="form-control" id="Company_primary_phone_no"  onkeyup="this.value=this.value.replace(/\D/g,'')" name="Company_primary_phone_no"  required placeholder="e.g. 123456789">
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
													<legend  id="input6">No. of Outlets</legend>
													<input type="text" class="form-control" id="Seller_licences_limit" name="Seller_licences_limit" onkeyup="this.value=this.value.replace(/\D/g,'')"  required placeholder="e.g. 1,2,4,6 etc.">
												</fieldset>
											</div>
											<div class="form-holder">
														<fieldset>
															<legend  id="input7">Domain Name</legend>
															<input type="text" class="form-control" id="Domain_name" name="Domain_name"  required placeholder="e.g. DeereWeb">
														</fieldset>
											</div>
										</div>
										
									</div>
								</div>
								
								
								
								<div class="form-row form-row-date"  >
									<div class="form-holder form-holder-2" >
										
										<div class="form-row">
											<div class="form-holder" id="input8">
												
												<select name="Country" id="Country"  style="width: 100%;" >
													<option value=""  selected  >Select Country</option>
													<option value="101">India</option>
													<?php 
														foreach($Country_array as $Country)
														{
															echo "<option value=".$Country['id'].">".$Country['name']."</option>";
														}
													?>
												</select>
												
											</div>
											<div class="form-holder"  id="input9">
												
												<select name="timezone_entry" id="timezone_entry"  style="width: 100%;">
													<option value=""  selected>Select Time Zone</option>
													<?php
													$zones = timezone_identifiers_list();
													foreach ($zones as $zone)
													{
														echo "<option  value=".$zone.">".$zone."</option>";
													}
												?>
												</select>
												
											</div>
											
										</div>
										
									</div>
								</div>
							
								<div class="form-row form-row-date">
									<div class="form-holder form-holder-2">
										
										<div class="form-row">
											<div class="form-holder">
												<!--<fieldset>
													<legend  id="input10">Address</legend>
													<input type="text" class="form-control"  style="height:50px !important;" id="Company_address" name="Company_address"  required placeholder="e.g. MG Road,Mumbai">
													
													
												</fieldset>-->
												<legend  id="input10">Address</legend> 
												<textarea  style="border: 2px solid #e5e5e5;
													border-radius: 4px;
													outline: none;
													font-weight: 600;
													font-size: 14px;
													font-family: 'Open Sans', sans-serif;
													padding: 0 20px;" rows="4" cols="19"  placeholder="e.g. 5th Block, 40th Downing Street, P.O Box 411001"  id="Company_address" name="Company_address"></textarea>
											</div>
											<div class="form-holder">
											<font color="#f74d40" size='1.5px'>(You can upload logo upto 500kb)</font> 
											<div class="upload-btn-wrapper">
											  <button class="btn">Upload Company Logo</button>
											  <input type="file" id="Company_logo" name="Company_logo"   style="cursor:pointer;" onchange="readImage(this,'#CompanyLogo1');" />
											<br>
											
											 <div class="thumbnail" id="Logo" style="width:100px; display:none;"><br>
									<img src="" id="CompanyLogo1" class="img-responsive">
									</div>
											</div>
											
											
																						<!--
														<fieldset>
															<legend>Upload Company Logo</legend>
															<input type="file" class="form-control" id="Company_logo" name="Company_logo"  required>
														</fieldset>-->
											</div>
										</div>
										
									</div>
								</div>
								
							</div>
			            </section>	<!-- SECTION 3 -->
			            <h2>
			            	<p class="step-icon"><span>05</span></p>
			            	<span class="step-text">Loyalty Information</span>
			            </h2>
			            <section>
						
			                <div class="inner">
			                	<div class="wizard-header">
									<h3 class="heading">Configure Loyalty Rule</h3>
									
								</div>
									
								<div class="form-row">
									<div class="form-holder  form-holder-2">
									
									<div class="plan-total">
		                					<span class="plan-title">a) Set Loyalty Rule Program Name</span>
		                			
		                				</div>

										<fieldset>
											<legend  id="input11">Loyalty Rule Name</legend>
											<input type="text" class="form-control" id="Loyalty_name" name="Loyalty_name" placeholder="e.g. ABC Summer Bonanza"  required>
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
													<legend   id="input12">Issuance Percentage</legend>
													<input type="text" class="form-control" id="Loyalty_at_transaction" name="Loyalty_at_transaction"  required onkeypress="return isNumberKey2(event);" placeholder="e.g. Enter Percentage as 2.5,2 etc">
												</fieldset>
									</div>
									
								</div>
								
									<div class="form-row">
									<div class="form-holder  form-holder-2">
									<div class="plan-total">
		                					<span class="plan-title">d) Set Redemption Ratio <br><font color="#f74d40" size='1.5px'>(e.g. if Redemption Ratio = 4 implies 1 INR = 4 Points)</font> </span>
		                			
		                				</div>
										
										<fieldset>
													<legend   id="input13">Redemption Ratio</legend>
													<input type="text" class="form-control" id="Redemptionratio" name="Redemptionratio"  required  onkeypress="return isNumberKey2(event);" placeholder="eg.Enter Redemption Ratio as 4,5 etc">
												</fieldset>
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
													<input type="text" class="form-control" id="Joining_bonus_points" name="Joining_bonus_points"  required placeholder="e.g 100,150 etc."  onkeypress="return isNumberKey2(event);">
												</fieldset>
											</div>
								
											<div class="form-holder" id="join2">
												
													&nbsp;
													
												
											</div>
								
									<div class="form-holder" id="RefferralPoints" style="display:none;">
												<fieldset>
													<legend>Enter Refferral Bonus Points</legend>
													<input type="text" class="form-control" id="Refferral_bonus_points" name="Refferral_bonus_points"  required placeholder="e.g 100,150 etc."  onkeypress="return isNumberKey2(event);">
												</fieldset>
											</div>
									
										</div>
									</div>
								</div>
								
								
									
								
								
								
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
  
<div aria-hidden="true" aria-labelledby="mySmallModalLabel" id="loader_model" class="modal fade bd-example-modal-sm" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content" style="-webkit-box-shadow:none;border:0px !important;"><!--background-color: transparent;-->
            <div class="modal-body text-center">
                <img alt="" src="<?php echo base_url(); ?>images/loader2.gif" >
            </div>            
        </div>
    </div>
</div>

<!-------------------- Loader Model - End -------------------->
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>

<script>
// show_loader();

function show_loader() {
    $('#loader_model').modal('show');
}
function form_submit(id)
{
	var section = $('#section').val();
	
	 // alert('--section -'+section); 
	// window.location = "http://www.google.com/";
	if(section==1)
	{
		$('#section').val(2);
	}
	 if(section==2)
	{
		$('#section').val(3);
	}
	 
	if(section==3)
	{

	
		$("#next").attr("href", "http://www.google.com/")
		
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
             $("#Country").css("border", "1px solid red");//border: 2px solid #e5e5e5;
           
        }
		else
		{
			  $("#Country").css("border", "1px solid #e5e5e5");//border: 2px solid #e5e5e5;
		}
		
		 if ($('#timezone_entry').val() == "") {
            $("#timezone_entry").css("border", "1px solid red");//border: 2px solid #e5e5e5;
           
        }
		else
		{
			  $("#timezone_entry").css("border", "1px solid #e5e5e5");//border: 2px solid #e5e5e5;
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
			  
		if( $('#Company_name').val() != "" &&  $('#First_name').val() != "" &&  $('#Last_name').val() != "" && $('#Company_address').val() != "" &&  $('#Company_primary_email_id').val() != ""  && $('#Company_primary_phone_no').val() != ""  && $('#Domain_name').val() != ""  && $('#Seller_licences_limit').val() != "" && $('#Country').val() != "" && $('#timezone_entry').val() != "")
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
		}
		if ($('#Redemptionratio').val() == "") {
            $("#input13").css("color", "red");
            $("#Redemptionratio").focus();
        }
		else
		{
			$("#input13").css("color", "");
		}
		
		if( $('#Loyalty_name').val() != "" &&  $('#Loyalty_at_transaction').val() != "" &&  $('#Redemptionratio').val() != "" )
		{
			$('#error').hide();
			if($('#section').val()==3)
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
		else
		{
			$('#error').show();
		}
		
	}
	
	// alert('---'+id);
	
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
function isNumberKey2(evt)
{	
  var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode != 46 && charCode > 31 
	&& (charCode < 48 || charCode > 57))
	 return false;

  return true;
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
    left: 22px;
    top: 14px;
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
</style>
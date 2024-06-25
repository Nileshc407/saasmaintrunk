<?php $this->load->view('header/header'); 
$linc_limit = $Company_details->Seller_licences_limit;
$remain_lic = $linc_limit - $Total_merchants;
?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php
				$attributes = array('id' => 'formValidate');
				echo form_open_multipart('Enrollmentc/enrollment',$attributes); 
			?>
				<div class="element-wrapper">
					<h6 class="element-header">ENROLLMENT 
					</h6>
					<?php if($Super_seller == 1 || $userId == 3 )
						{ ?>
						<div class="alert alert-warning" role="alert">
						<strong> <?php echo "Max no. of Sub Outlet(s) Enrollment Allowed = <b> $linc_limit ;  </b> Balance No. of Outlet(s) Enrollment entitled = <b>$remain_lic ; </b>"; ?></strong>
						</div>
				<?php	}
					?>
					<?php
						/*$linc_limit = $Company_details->Seller_licences_limit;
						$remain_lic = $linc_limit - $Total_merchants;

						if($Super_seller == 1 || $userId == 3 )
						{
							// echo "<FONT SIZE=\"3\" FACE=\"courier\" COLOR=WHITE><MARQUEE  BEHAVIOR=SCROLL HSPACE=25 VSPACE=30 BGColor=#b237ff>Max no. of Sub Outlet(s) Enrollment Allowed = <b> $linc_limit &nbsp;&nbsp;</b>; Balance No. of Outlet(s) Enrollment entitled = <b>$remain_lic </b>!!! </MARQUEE></FONT>";
						} */
					?>
					<div class="element-box">
					<?php
						if(@$this->session->flashdata('success_code'))
						{ ?>	
							<div class="alert alert-success alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('success_code'); ?>
							</div>
				<?php 	} ?>
					<?php
						if(@$this->session->flashdata('error_code'))
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('error_code'); ?>
							</div>
				<?php 	} ?>
							<div class="row">
								<div class="col-sm-6">										
								  <div class="form-group">
									<label for=""> Company Name</label>
									<select class="form-control" name="Company_id" required>
									  <?php
										foreach($Company_array as $Company)
										{
											echo "<option value=".$Company['Company_id'].">".$Company['Company_name']."</option>";
										}
										?>
									</select>
								  </div>
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>First Name</label>
									<input type="text" class="form-control" name="firstName" id="firstName" data-error="Please enter first name" placeholder="Enter first name" required="required">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div> 
								  
								  <div class="form-group">
									<label for=""> Middle Name</label>
									<input type="text" class="form-control" name="middleName" id="middleName" data-error="Please enter middle name" placeholder="Enter middle name" />
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div> 
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Last Name</label>
									<input type="text" class="form-control" name="lastName" id="lastName" data-error="Please enter last name" placeholder="Enter last name" required="required">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								   <div class="form-group">
									<label for=""><span class="required_info">* </span>Country</label>
									<select class="form-control" name="country" id="country_id" onchange="Get_states(this.value);" required="required" data-error="Please select country">
									<option value="">Select country</option>
									  <?php
										echo "<option value=".$Country_array->Country_id.">".$Country_array->Country_name."</option>";
										?>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group" id="Show_States">
									<label for="">State</label>
									<select class="form-control" name="state" id="state" onchange="Get_cities(this.value);" >
									<option value="">Select country first</option>					
									</select>
								  </div> 

								  <div class="form-group" id="Show_Cities">
									<label for="">City</label>
									<select class="form-control" name="city" id="city">
									<option value="">Select state first</option>
									</select>
								  </div>
								  
								  <div class="form-group">
									<label><span class="required_info">* </span>Address</label>
									<textarea class="form-control" rows="3" name="currentAddress"  id="currentAddress" data-error="Please enter address" required="required" placeholder="Enter address"></textarea>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
									<label for=""> Zip/Postal Code/P.O Box</label>
									<input type="text" class="form-control" name="zip" id="zip" data-error="Please enter zip/postal code/p.o box" placeholder="Enter zip/postal code/p.o box" onkeyup="this.value=this.value.replace(/\D/g,'')">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
									<label for=""> District</label>
									<input type="text" class="form-control" name="district" id="district" data-error="Please enter district" placeholder="Enter district">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>									  
								</div>											
								<div class="col-sm-6">
								  <div class="form-group">
									<label for=""><span class="required_info" style="color:red;">* </span>User Type</label>
									<select class="form-control" name="User_id" id="User_id" onchange="hide_show_merchant(this.value);hide_user_type(this.value)" data-error="Please select user type" required="required" >
									<option value="">Select user type</option>
									  <?php
									  // $remain_lic=0;
										foreach($UserType_array as $UserType)
										{
											if($Company_details->Call_center_flag==1)
											{
												echo "<option value=".$UserType['User_id'].">".$UserType['User_type']."</option>";
											}
											else
											{
												if($remain_lic > 0){
														
													echo "<option value=".$UserType['User_id'].">".$UserType['User_type']."</option>";
													
												} else if($UserType['User_id'] != 2 && ( $UserType['User_id'] == 1 || $UserType['User_id'] == 4 || $UserType['User_id'] == 5 || $UserType['User_id'] == 6  || $UserType['User_id'] == 7 )){
													
													echo "<option value=".$UserType['User_id'].">".$UserType['User_type']."</option>";
												}
											}
										} ?>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group" id="MercahndizeCategory_div" style="display:none">
									<label for=""><span class="required_info">* </span>Outlet Item Category</label>
									<input type="text" class="form-control" name="MercahndizeCategory" id="MercahndizeCategory" data-error="Please enter Outlet item category" placeholder="Enter Outlet item category">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group" id="MPartner_block1"  style="display:none;">
									<label for=""><span class="required_info">* </span>Link to Merchandize Partner</label>
									<select class="form-control" name="Merchandize_Partner_ID" id="Merchandize_Partner_ID" onchange="get_baranches(this.value);" data-error="Please select merchandize partner">
									<option value="">Select merchandize partner</option>
									  <?php
										foreach($Partner_Records as $Partner)
										{
											echo '<option value="'.$Partner->Partner_id.'">'.$Partner->Partner_name.'</option>';
										}
										?>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div> 
								  
								  <div class="form-group" id="MPartner_block2" style="display:none;">
									<label for=""><span class="required_info">* </span>Link to Merchandize Partner Branch</label>
									<select class="form-control" name="Merchandize_Partner_Branch" id="Merchandize_Partner_Branch" data-error="Please select partner branches">
									<option value="">Link to partner branches</option>
									 
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
								   <label for=""> Date of Birth (MM/DD/YYYY)</label>
									<input class="single-daterange form-control" placeholder="Enter date of birth" type="text"  name="dob" id="datepicker"/>
								  </div>
								 
								  <div class="form-group">
									<label for="">Sex(Male/Female)</label>
									<select class="form-control" name="sex" id="sex">
										<option value="">Select sex</option>
										<option value="Male">Male</option>
										<option value="Female">Female</option> 
									</select>
								  </div>
								
								  <div class="form-group">
									<label for="">Profession</label>
									<input type="text" class="form-control" name="qualifi" id="qualifi" data-error="Please enter profession" placeholder="Enter profession">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								 
								 <div class="form-group">
									<label for=""><span class="required_info">* </span>Phone No <span class="required_info">(Please enter without '+' and country code) </span></label>
									<input type="text" class="form-control" name="phno" id="phno" data-error="Please enter phone no." placeholder="Enter phone no." onkeyup="this.value=this.value.replace(/\D/g,'')" maxlength="9" required="required">
									<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
								 </div> 
								 
								 <div class="form-group">
									<label for="">Email ID?</label>
									<div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input class="form-check-input" name="email_validity" type="radio" onclick="mailgenrator(this.value);"  value="1" required="required" checked>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input class="form-check-input" name="email_validity" type="radio" onclick="mailgenrator(this.value);" value="0" required="required">No</label>
									  </div> 
									</div>
								  </div>
								   
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>User Email ID</label>
									<input type="text" class="form-control" name="userEmailId" id="userEmailId" data-error="Please enter user email" placeholder="Enter user email id" onblur="validateEmail(this.value);" required="required">
									<div class="help-block form-text with-errors form-control-feedback" id="help-block2"></div>									
								  </div>
								 
								  <div class="form-group">
									<label for="">Photograph<br><font color="RED" align="center" size="0.8em"><i>You can upload logo upto 500kb  </i></font> </label>
									<div class="upload-btn-wrapper">
										<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
										<input type="file" name="file" id="file" onchange="readImage(this,'#image1');"/>
									</div>
									<div class="thumbnail" id="profile_pic" style="width:100px; display:none;">
										<img src="" id="image1" class="img-responsive">
									</div>
								  </div>
								  
								   
								  <div id="Membership_Id" style="display:none">
								   <div class="form-group">
									<label for=""> Membership ID</label>
									<?php
										if($Company_details->card_decsion == '1') { ?>
										<input type="text" name="cardid2" class="form-control" value="<?php echo $Company_details->next_card_no; ?>" readonly />

									<?php } else { ?>
										<input type="text" maxlength="16" name="cardid" id="cardId"  class="form-control" placeholder="Enter membership id" data-error="Please enter membership id" />
									<?php } ?>
									<div class="help-block form-text with-errors form-control-feedback" id="help-block3"></div>
								   </div>
								  </div>
								 
								 <?php
									if($Enroll_details->Refrence == '1' && $referral_rule_count > 0 && $Company_details->Allow_preorder_services==0)
									{ ?>
									<div class="form-group" id="refree_div" style="display:none">
										<label for="">Reference</label>
										<div class="col-sm-8" style=" margin-top:7px;">
										
										  <div class="form-check" style="float:left;">
											<label class="form-check-label">
											<input class="form-check-input" name="Refrence" type="radio" id="Refrence1" onclick="hide_show_refrence(this.value);" value="1">Yes</label>
										  </div>
										  
										  <div class="form-check" style="margin-left:50px;">
											<label class="form-check-label">
											<input class="form-check-input" name="Refrence" type="radio" id="Refrence2" onclick="hide_show_refrence(this.value);" value="0" checked>No</label>
										  </div>											  
										</div>
								    </div>
								  
									<div class="form-group" id="Refree" style="display:none;">
										<label for="">Refree Membership ID </label>
										
										<input type="text" name="Refree_name" id="Refree_name"  class="form-control" placeholder="Enter refree membership id" data-error="Please enter refree membership id" autocomplete="off"/>
										<div class="help-block form-text with-errors form-control-feedback" id="help-block11"></div>
										<input type="hidden" name="Enrollment_id" id="EnrollmentId" value=""/>
									</div>
							<?php
									}
									?>
									
									
									<?php 
									// echo "---Enable_company_meal_flag-----".$Company_details->Enable_company_meal_flag;
									if($Company_details->Enable_company_meal_flag == 1) { ?> 									
										
										<div class="form-group" id="Select_Staff" >
											<label for="">Is it Staff?</label>
											<div class="col-sm-8" style=" margin-top:7px;">
											  <div class="form-check" style="float:left;">
												<label class="form-check-label">
												<input class="form-check-input" name="Staff_flag" type="radio" value="1">Yes</label>
											  </div>
											  
											  <div class="form-check" style="margin-left:50px;">
												<label class="form-check-label">
												<input class="form-check-input" name="Staff_flag" type="radio" value="0" checked>No</label>
											  </div> 
											</div>
										  </div>		
										
									<?php } ?>
									
									<div class="form-group" id="Select_tier">
										<label for=""> Select Tier</label> <!---- onchange="get_tier_details(this.value);"--->
										<select class="form-control" name="member_tier_id" id="member_tier_id">
										
										<option value="">Select Tier</option>
										  <?php
											foreach($Tier_list as $Tier)
											{
												echo '<option value="'.$Tier->Tier_id.'">'.$Tier->Tier_name.'</option>';
											}
											?>
										</select>
									</div>	
									
									<?php //echo $Company_details->Enable_company_meal_flag; ?> 
									
									<?php if($Company_details->Enable_company_meal_flag == 1) { ?> 									
										
										<div class="form-group" id="Meal_balance_div" style="display:none;">
											<label for="">Meal Balance </label>
											
											<input type="text" name="Meal_balance" id="Meal_balance"  class="form-control" placeholder="Please enter meal balance" data-error="Please enter meal balance" autocomplete="off"/>
											<div class="help-block form-text with-errors form-control-feedback"></div>
											
										</div>		
										
									<?php } ?>
									<div class="form-group" id="Select_hobies">
										<label for=""> Hobbies/Interest</label>
										<select class="form-control select2" multiple="true" name="hobbies[]">
										<option value="">Select Hobbies/Interest</option>
										  <?php
											foreach($Hobbies_list as $hob)
											{
												echo "<option value=".$hob->Id.">".$hob->Hobbies."</option>";
											}
											?>
										</select>
									</div> 
									
									
									
									<?php if($Company_details->Label_1 !="" || $Company_details->Label_2 !="" || $Company_details->Label_3 !=""
							  || $Company_details->Label_4 !="" || $Company_details->Label_5 !="" ) { ?>
									<!------------Additional Fields for---18-05-2017------------->
										<div id="additional_fields" style="display:none">
											<?php if($Company_details->Label_1 !="" ) { ?>
											<div class="form-group">
												<label for=""><?php echo $Company_details->Label_1; ?></label>
												<input type="text" name="Label_1_value" class="form-control" placeholder="Enter <?php echo $Company_details->Label_1; ?>" />
											</div>
											<?php } ?>
											<?php if($Company_details->Label_2 !="" ) { ?>
											<div class="form-group">
												<label for=""><?php echo $Company_details->Label_2; ?></label>
												<input type="text" name="Label_2_value" class="form-control" placeholder="Enter <?php echo $Company_details->Label_2; ?>" />
											</div>
											<?php } ?>
											<?php if($Company_details->Label_3 !="" ) { ?>
											<div class="form-group">
												<label for=""><?php echo $Company_details->Label_3; ?></label>
												<input type="text" name="Label_3_value" class="form-control" placeholder="Enter <?php echo $Company_details->Label_3; ?>" />
											</div>
											<?php } ?>
											<?php if($Company_details->Label_4 !="" ) { ?>
											<div class="form-group">
												<label for=""><?php echo $Company_details->Label_4; ?></label>
												<input type="text" name="Label_4_value" class="form-control" placeholder="Enter <?php echo $Company_details->Label_4; ?>" />
											</div>
											<?php } ?>
											<?php if($Company_details->Label_5 !="" ) { ?>
											<div class="form-group">
												<label for=""><?php echo $Company_details->Label_5; ?></label>
												<input type="text" name="Label_5_value" class="form-control" placeholder="Enter <?php echo $Company_details->Label_5; ?>" />
											</div>
											<?php } ?>
										</div>
										<?php } ?>
									<!-------Additional Fields for Enrollment---18-05-2017-------->
								</div>
							</div>
							
							<div id="Merchant_div" style="display:none;">
								<fieldset class="form-group">
								<legend><span>Merchants Specific Details</span></legend>
								<div class="row" >
									<div class="col-sm-6">
									<label for=""><span class="required_info">* </span>Starting Series Of Bill No.(For Loyalty Transaction)</label>
										<div class="row">
										<div class="col-sm-3">
										
										<div class="form-group">
											
											<script>
												document.write("<select name=\"loyalty_bill_year\" id=\"loyalty_bill_year\"  class=\"form-control\" style=\"width:100 !important;\">");
												var currentTime = new Date();
												var year = currentTime.getFullYear();
												for(i=0;i<4;i++){
												var dateVar = year + i;
												document.write('<option value=\"' + dateVar + '\">' + dateVar + '</option>');
												}
												document.write("</select>");
											</script>
											</div>
											</div>
											<div class="col-sm-9">
											<div class="form-group">
											<input type="text" name="Purchase_Bill_no" id="Purchase_Bill_no" class="form-control" placeholder="Enter Starting series of Loyalty Trans. Bill No."  onkeypress="return isNumberKey2(event)" data-error="Please enter starting series of bill no.(for loyalty transaction)"/>
											<div class="help-block form-text with-errors form-control-feedback"></div>
										</div>
										</div>
										</div>
										<div class="row">
										<div class="col-sm-12">
											<label for=""><span class="required_info">* </span>Starting Series Of Bill No.(For Bonus Point)</label>
											</div>
										<div class="col-sm-3">
										
										<div class="form-group">
											<script>
												document.write("<select name=\"bonus_bill_year\" id=\"bonus_bill_year\"  class=\"form-control\" style=\"width:100 !important;\">");
												var currentTime = new Date();
												var year = currentTime.getFullYear();
												for(i=0;i<4;i++){
												var dateVar = year + i;
												document.write('<option value=\"' + dateVar + '\">' + dateVar + '</option>');
												}
												document.write("</select>");
										</script>
										</div>
											</div>
											<div class="col-sm-9">
											<div class="form-group">
											<input type="text" name="Topup_Bill_no" id="Topup_Bill_no" class="form-control" placeholder="Enter Starting series of Bonus Point Bill no."  onkeypress="return isNumberKey2(event)" data-error="Please enter starting series of Bill no.(for bonus point)"/>
											<div class="help-block form-text with-errors form-control-feedback"></div>
										</div>
										</div>
										</div>
										
										
										
										<div class="row"  id="Retailers_Payment" >
										<div class="col-sm-12">
											<label for=""><span class="required_info">* </span>Starting Series Of Bill No.(For Outlet)</label>
											</div>
										<div class="col-sm-3">
										
										<div class="form-group">
											<script>
												document.write("<select name=\"Retailers_Payment_year\" id=\"Retailers_Payment_year\"  class=\"form-control\" style=\"width:100 !important;\">");
												var currentTime = new Date();
												var year = currentTime.getFullYear();
												for(i=0;i<4;i++){
												var dateVar = year + i;
												document.write('<option value=\"' + dateVar + '\">' + dateVar + '</option>');
												}
												document.write("</select>");
											</script>
										</div>
											</div>
											<div class="col-sm-9">
											<div class="form-group">
											<input type="text" name="RetailersPaymentBill_no" id="RetailersPaymentBill_no" class="form-control" placeholder="Enter Starting series of Outlet Bill no."  onkeypress="return isNumberKey2(event)" data-error="Please enter starting series of bill no.(for Outlet Bill)"/>
											<div class="help-block form-text with-errors form-control-feedback"></div>
										</div>
										</div>
										</div>
										
										
										<div class="form-group">
											<label for=""><span class="required_info">* </span>Redemption Ratio</label>
											<input type="text" name="Seller_Redemptionratio" id="Seller_Redemptionratio"  class="form-control" placeholder="Enter redemption ratio"  onkeypress="return isNumberKey2(event)" value="<?php echo $Company_details->Redemptionratio;?>" data-error="Please enter redemption ratio"/>
											<div class="help-block form-text with-errors form-control-feedback"></div>
										</div>
										<div class="form-group">
											<label for=""><span class="required_info">* </span>Redemption Limit</label>
											<input type="text" name="Seller_Redemptionlimit" id="Seller_Redemptionlimit"  class="form-control" placeholder="Enter Redemption limit"  onkeypress="return isNumberKey2(event)" data-error="Please enter point redemption limit"/>
											<div class="help-block form-text with-errors form-control-feedback"></div>
										</div>
										<div class="form-group" id="Retailers_PaymentRatio" >
											<label for=""><span class="required_info">* </span>Outlet Billing Ratio</label>
											<input type="text" name="Seller_Paymentratio" id="Seller_Paymentratio"  class="form-control" placeholder="Enter Outlet billing ratio"  onkeypress="return isNumberKey2(event)" data-error="Please enter Outlet billing ratio"/>
											<div class="help-block form-text with-errors form-control-feedback"></div>
										</div>
										<div class="form-group">
											<label for=""><span class="required_info">* </span>Outlet Sales Tax<span class="required_info"> (Please enter sales tax in %)</span></label>
											<input type="text" name="Seller_sales_tax" id="Seller_sales_tax"  class="form-control" placeholder="Enter sales tax"  onkeypress="return isNumberKey2(event)"  data-error="Please enter Outlet sales tax"/>
											<div class="help-block form-text with-errors form-control-feedback"></div>
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1"> Outlet Api Url</label>
											<input type="text" name="Seller_api_url" id="Seller_api_url" class="form-control" placeholder="Enter Outlet Api Url">
										</div>
										<div class="form-group">
									<label for="exampleInputEmail1"> Outlet Payment Api Url</label>
									<input type="text" name="Seller_api_url2" id="Seller_api_url2" class="form-control" placeholder="Enter Outlet Payment Api Url">
								</div>
										<div class="form-group">
									<label for="exampleInputEmail1"> Outlet Goods Till Number</label>
									<input type="text" name="Seller_goods_till_number" id="Seller_goods_till_number" class="form-control" placeholder="Enter Outlet Goods Till Number">
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1"> Outlet Order preparation time<span class="required_info"> (eg. x minutes)</span></label>
									<input type="text" name="Order_preparation_time" id="Order_preparation_time" class="form-control" placeholder="Enter Order preparation time">
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1">Outlet Table No. Applicable ? </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<label class="radio-inline">
										<input type="radio" name="Table_no_flag" id="Table_no_flag" value="1">Yes
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="radio" name="Table_no_flag" id="Table_no_flag" value="0" checked>No
									</label>
								</div>
								
									<div class="form-group">
									<label for="exampleInputEmail1">MPESA Authorization Code</label>
									<input type="text" name="Mpesa_auth_key" id="Mpesa_auth_key" class="form-control" placeholder="Enter MPESA Authorization Code">
								</div>
								
										<div class="form-group">
											<label for="">Website</label>
											<input type="text" name="Website"  id="Website" class="form-control" placeholder="Enter website" />
										</div>
									</div>
									<div class="col-sm-6" >
										<div class="form-group" >
											<label for="">Time Zone</label>
											<select class="form-control" name="Time_Zone" id="Time_Zone">
											<option value="">Select Time Zone</option>
											<?php
												$zones = timezone_identifiers_list();
												foreach ($zones as $zone)
												{
													if($Enroll_details->timezone_entry == $zone)
													{
													?>
													<option selected value="<?php echo $zone; ?>"><?php echo $zone; ?></option>
													<?php
													}
													else
													{
														echo "<option  value=".$zone.">".$zone."</option>";
													}
												}
											?>
											</select>
										</div>
										<?php
										// echo $Company_details->Allow_preorder_services;
										if($Company_details->Allow_preorder_services==0 ) {?>
										<div class="form-group">
											<label for="">Referred by:</label>
											<label class="radio-inline">
												<input type="radio" name="Refrence" id="Refrence" value="1">Yes
												
												<input type="radio" name="Refrence" id="Refrence" value="0" checked>No
											</label>
										</div>
										<?php } ?>
										<?php if($Enroll_details->User_id == 3 ) { ?>
										<div class="form-group">
											<label for="">Company Admin</label>
											<label class="radio-inline">
												<input type="radio" name="Super_seller" id="Super_seller" value="1" checked>Yes
												
												<input type="radio" name="Super_seller" id="Super_seller"  value="0"  >No
											</label>
										</div>
										<?php } ?>

										<div class="form-group" id="sub_merchant">
											<label for="">Is it Sub Outlet Admin ?</label>
											<label class="radio-inline">
												<input type="radio" name="Sub_seller_admin" onclick="hideshow_subseller(this.value);Show_Admin_list(this.value);" id="Sub_seller_admin1" value="1" checked>Yes</label>
												<label class="radio-inline">
												
												<input type="radio" name="Sub_seller_admin" onclick="hideshow_subseller(this.value);Show_Admin_list(this.value);" id="Sub_seller_admin" value="0" >No
											</label>
										</div>

										<!--<div class="form-group" id="SubSeller_Admin" style="display:none">
											<label for="">Assign the Sub Outlet Admin:</label>
											<label class="radio-inline">
												<input type="radio" name="SubSeller_Admin"  onclick="Show_Admin_list(this.value);SubSeller_Admin_hide(this.value);" id="SubSeller_Admin" value="1">Yes
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" name="SubSeller_Admin" onclick="Show_Admin_list(this.value);SubSeller_Admin_hide(this.value);" id="SubSeller_Admin" value="0">No
											</label>
										</div> -->

										<div class="form-group" id="Seller_Admin_list" style="display:none">
											<label for="">Select Sub Outlet Admin</label>
											<select class="form-control" name="Sub_seller_Enrollement_id" id="Sub_seller_Enrollement_id" data-error="Please select sub Outlet admin">
											<option value="">Select</option>
											<?php foreach($Subseller_details as $subseller)
											{
												echo $subseller['Enrollement_id'];
											?>
												<option value="<?php echo $subseller['Enrollement_id']; ?>"><?php echo $subseller['First_name'].' '.$subseller['Last_name']; ?></option>

											<?php
											}
											?>
											</select>
											<div class="help-block form-text with-errors form-control-feedback" id="help-block4"></div>
										</div>
										<?php if($Company_details->Allow_preorder_services==1 ) { ?>
										<div class="form-group">
											<label for="">Per Order Services</label>&nbsp;&nbsp;
											<label class="radio-inline">
												<input type="radio" name="Allow_services" id="Allow_services" value="1" >Ordering ahead</label>
												<label class="radio-inline">
												&nbsp;&nbsp;
												<input type="radio" name="Allow_services"  id="Allow_services" value="2" >Scheduling Services
												</label>
												<label class="radio-inline">
												&nbsp;&nbsp;
												<input type="radio" name="Allow_services"  id="Allow_services" value="3" checked >Both
												</label>
										</div>
										<?php } ?>

										<div align="left" id="cordinates_div1" ><font color="RED" align="center" size="0.8em"><i>For Location Based Service ( LBS) it is important to Enter the Current Address, Zip/Postal Code, City, State and Country.  </i></font></div>
										<div class="form-group">
											<label for="">Latitude</label>
											<input type="text" name="Latitude2"  id="Latitude2" class="form-control"readonly />
										</div>
										<div class="form-group">
											<label for="">Longitude</label>
											<input type="text" name="Longitude2"  id="Longitude2" class="form-control" readonly />
										</div>
									</div>
								</div>
								</fieldset>
							</div>
																
							<!-----------Call Center---21-08-2017---Nilesh-------------->
							<div id="Call_center_div" style="display:none;">
							 <fieldset class="form-group">
								<legend><span>Call Center  Specific Details</span></legend>
								<div class="row" >
									<div class="col-sm-6" >
										<div class="form-group" id="sub_merchant">
											<label for="">Is it Supervisor ?</label>
											<label class="radio-inline">
												<input type="radio" name="Supervisor" id="Supervisor" onclick="hideshow_supervisor(this.value);" value="1" checked>Yes</label>
												<label class="radio-inline">
												
												<input type="radio" name="Supervisor" id="Supervisor" onclick="hideshow_supervisor(this.value);" id="Sub_seller_admin" value="0" >No
											</label>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group" id="Supervisor_list_div" style="display:none">
											<label for="">Select Supervisor </label>
											<select class="form-control" name="Supervisor_Enrollement_id" id="Supervisor_Enrollement_id" data-error="Please select supervisor">
											<option value="">Select</option>
											<?php
											foreach($Call_center_details as $subseller)
											{
												echo $subseller['Enrollement_id'];
											?>
												<option value="<?php echo $subseller['Enrollement_id']; ?>"><?php echo $subseller['First_name'].' '.$subseller['Last_name']; ?></option>

											<?php
											}
											?>
											</select>
											<div class="help-block form-text with-errors form-control-feedback"></div>
										</div>
									</div>
								</div>
							   </fieldset>
							</div>
							<!-------------Call Center---21-08-2017---Nilesh----------->
							
							<!---------------Finance User--Nilesh----------->
							<div id="Finance_user_div" style="display:none;">
								<fieldset class="form-group">
								<legend><span>Staff User Specific Details</span></legend>
								<div class="row">
									<div class="col-sm-6" >
										<div class="form-group" id="sub_merchant">
											<label for="">A Department / Outlet head ?</label>
											<label class="radio-inline">
												<input type="radio" name="Supervisor1" id="Supervisor1" onclick="hideshow_supervisor1(this.value);" value="1" checked>Yes</label>
												<label class="radio-inline">
												
												<input type="radio" name="Supervisor1" id="Supervisor1" onclick="hideshow_supervisor1(this.value);" id="Sub_seller_admin" value="0" >No
											</label>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group" id="Supervisor_list_div1" style="display:none">
											<label for="">Select Department / Outlet or Head</label>
											<select class="form-control" name="Supervisor_Enrollement_id1" id="Supervisor_Enrollement_id1" data-error="Please select finance manager">
											<option value="">Select</option>
											<?php
											 foreach($Finance_user_details as $Finance_user)
											{
												//echo $Finance_user['Enrollement_id'];
											?>
												<option value="<?php echo $Finance_user->Enrollement_id; ?>"><?php echo $Finance_user->First_name.' '.$Finance_user->Last_name; ?></option>

											<?php
											}
											?>
											</select>
											<div class="help-block form-text with-errors form-control-feedback"></div>
										</div>
									</div>
								
								</div>
								</fieldset>
							</div>
							<!-------------Finance User----------->
						
						  <div class="form-buttons-w" align="center">
							<button class="btn btn-primary" type="submit" id="Register">Submit</button>
							<button class="btn btn-primary" type="reset">Reset</button>
						  </div>
						
					</div>
				</div>
				<?php echo form_close(); ?>	
				<!--</form>-->

				<!--------------Table------------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					   Enrollments
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<th>Action</th>
									<th>User Type</th>
									<th>Name</th>
									<th>Membership ID</th>
									<th>Phone Number</th>
									<th>Email ID</th>
									<th>Current <?php echo 	$Company_details->Currency_name; ?> Balance</th>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<th>Action</th>
									<th>User Type</th>
									<th>Name</th>
									<th>Membership ID</th>
									<th>Phone Number</th>
									<th>Email ID</th>
									<th>Current <?php echo 	$Company_details->Currency_name; ?> Balance</th>
								</tr>
							</tfoot>
							<tbody>
						<?php
							if($results != NULL)
							{
								foreach($results as $row)
								{
									if($row->User_id==1)
									{
										$User_type="Member";
									}
									else if($row->User_id==5) 
									{
										$User_type="Merchandize Partner";
									}
									else if($row->User_id==6) 
									{
										$User_type="Call Center User";
									}
									else if($row->User_id==7)
									{
										$User_type="Finance User";
									}
									else
									{
										$User_type="Outlet";
									}
									if($row->Card_id=='0')
									{
										$Card_id="-";
									}
									else
									{
										$Card_id=$row->Card_id;
									}
									if($Company_details-> Seller_topup_access==0 && $row->User_id!=1)
									{
										$Current_balance="-";
									}
									else
									{
										$Current_balance=($row->Current_balance-$row->Blocked_points);
									}
									/***********encrypt value*******************/
									// $Encrypt_Enrollement_id = urlencode($this->encrypt->encode($row->Enrollement_id));
							?>
								<tr>
									<td class="row-actions">
										<a href="<?php echo base_url()?>index.php/Enrollmentc/edit_enrollment/?Enrollement_id=<?php echo $row->Enrollement_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
						
										<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Enrollement_id;?>','<?php echo $row->First_name.' '.$row->Last_name; ?>','','Enrollmentc/delete_enrollment/?Enrollement_id');" data-target="#deleteModal" data-toggle="modal" title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
									</td>
									<td><?php echo $User_type;?></td>
									<td><?php echo $row->First_name.' '.$row->Last_name;?></td>
									<td><?php echo $Card_id;?></td>
									<td><?php echo App_string_decrypt($row->Phone_no);?></td>
									<td><?php echo App_string_decrypt($row->User_email_id);?></td>
									<td><?php echo $row->Current_balance;?></td>
								</tr>
					<?php 		}
							}	?>
							</tbody>
						</table>
					  </div>
					</div>
				</div>
				<!--------------Table--------------->
			</div>
		</div>	
	</div>
</div>
<?php $this->load->view('header/footer'); ?>
<script>

/* 08-03-2021 */
/* function get_tier_details(tier_id)
{
	// alert(tier_id);
			
		$("#Meal_balance_div").css('display','inline');
		
		// var tier_id =tier_id;
		var Company_id = '<?php echo $Company_id; ?>';
		$.ajax({
			
			  type: "POST",
			  data: {tier_id: tier_id, Company_id: Company_id},
			  url: "<?php echo base_url()?>index.php/Enrollmentc/Fetch_tier_details",
			  // dataType: "json",
			  success: function(data)
			  {
				  console.log(data);
					$('#Meal_balance').val(data);
			  }
		});
		
} */

	$('#member_tier_id').change(function()
	{ 
		if( $("#member_tier_id").val() != "" )
		{
			$("#Meal_balance_div").css('display','inline');
			
			var member_tier_id = $("#member_tier_id").val();
			var Company_id = '<?php echo $Company_id; ?>';
			
			$.ajax({
					
				type: "POST",
				async: false,
				data: {tier_id: member_tier_id,Company_id:Company_id},
				url: "<?php echo base_url()?>index.php/Enrollmentc/fetch_tier_details",
				dataType: "json",
				success: function(json)
				{
					 console.log(json['Redeemtion_limit']);
					$('#Meal_balance').val(json['Redeemtion_limit']);
				}
			});
		}
	});
	
/* 08-03-2021 */
function get_baranches(Partner_id)
{
	var Company_id = '<?php echo $Company_id; ?>';

	$.ajax({
		type:"POST",
		data:{Partner_id:Partner_id, Company_id:Company_id},
		url: "<?php echo base_url()?>index.php/CatalogueC/Get_Partner_Branches",
		success: function(data)
		{
			$('#Merchandize_Partner_Branch').html(data.Get_Partner_Branches2);
		}
	});
}
function hide_show_merchant(selectVal)
{
	if(selectVal =='2' || selectVal =='4'  )
	{
		$("#Merchant_div").show();
		$("#Merchant_div1").show();
		$("#MercahndizeCategory_div").show();
		$("#Membership_Id").hide();
		$("#additional_fields").hide();
		$("#refree_div").hide();
		$("#MPartner_block1").hide();
		$("#MPartner_block2").hide();
		$("#Select_hobies").hide();
		$("#Select_tier").hide();
		$("#Select_Staff").hide();
		$("#Call_center_div").hide();
		$("#Finance_user_div").hide();
	}
	else if(selectVal =='5')
	{
		$("#Merchant_div").hide();
		$("#Merchant_div1").hide();
		$("#Membership_Id").hide();
		$("#additional_fields").hide();
		$("#refree_div").hide();
		$("#MPartner_block1").show();
		$("#MPartner_block2").show();
		$("#Select_hobies").hide();
		$("#Select_tier").hide();
		$("#Select_Staff").hide();
		$("#MercahndizeCategory_div").hide();
		$("#Call_center_div").hide();
		$("#Finance_user_div").hide();
	}
	else if(selectVal =='6')
	{
		$("#Merchant_div").hide();
		$("#Merchant_div1").hide();
		$("#Membership_Id").hide();
		$("#additional_fields").hide();
		$("#refree_div").hide();
		$("#MPartner_block1").hide();
		$("#MPartner_block2").hide();
		$("#Select_hobies").hide();
		$("#Select_tier").hide();
		$("#Select_Staff").hide();
		$("#MercahndizeCategory_div").hide();
		$("#Call_center_div").show();
		$("#Finance_user_div").hide();

	}
	else if(selectVal =='7')
	{
		$("#Merchant_div").hide();
		$("#Merchant_div1").hide();
		$("#Membership_Id").hide();
		$("#additional_fields").hide();
		$("#refree_div").hide();
		$("#MPartner_block1").hide();
		$("#MPartner_block2").hide();
		$("#Select_hobies").hide();
		$("#Select_tier").hide();
		$("#Select_Staff").hide();
		$("#MercahndizeCategory_div").hide();
		$("#Call_center_div").hide();
		$("#Finance_user_div").show();

	}
	else
	{
		$("#Merchant_div").hide();
		$("#Merchant_div1").hide();
		$("#Membership_Id").show();
		$("#additional_fields").show();
		$("#refree_div").show();
		$("#MPartner_block1").hide();
		$("#MPartner_block2").hide();
		$("#Select_hobies").show();
		$("#Select_tier").show();
		$("#Select_Staff").show();
		$("#MercahndizeCategory_div").hide();
		$("#Call_center_div").hide();
		$("#Finance_user_div").hide();
		document.getElementById("Refrence2").checked=true;

	}
}
function hideshow_subseller(selectVal)
{
	if(selectVal =='0' )
	{
		$("#SubSeller_Admin").show();
		$("#Seller_Admin_list").hide();
	}
	else
	{
		$("#SubSeller_Admin").hide();
		$("#Seller_Admin_list").hide();
	}
}
function hideshow_supervisor(selectVal)
{
	if(selectVal =='1' )
	{
		$("#Supervisor_list_div").hide();
		$("#Supervisor_Enrollement_id").removeAttr("required");
	}
	else
	{
		$("#Supervisor_list_div").show();
		$("#Supervisor_Enrollement_id").attr("required","required");
	}
}
function hideshow_supervisor1(selectVal)
{
	if(selectVal =='1' )
	{
		$("#Supervisor_list_div1").hide();
		$("#Supervisor_Enrollement_id1").removeAttr("required");
	}
	else
	{
		$("#Supervisor_list_div1").show();
		$("#Supervisor_Enrollement_id1").attr("required","required");
	}
}

function hide_show_refrence(refree)
{
	if(refree == 1)
	{
		$("#Refree").show();
		$("#Refree_name").attr("required","required");
	}
	else
	{
		$("#Refree").hide();
		$("#Refree_name").removeAttr("required");
	}
}
function mailgenrator(email_flag)
{ 
	var phno = $("#phno").val();

	if(email_flag==0)
	{
		if(phno!="")
		{ 
			var domain =  '<?php echo $Company_details->Domain_name; ?>';
			var emailis = phno+"@"+domain;
			$("#userEmailId").val(emailis);
			$("#userEmailId").removeClass("has-error");
			$('#userEmailId').css("border-color","#e8ebf2");
			$("#help-block2").html("");
		}
		else
		{
			var msg1 = 'Phone number is compulsary for non exist email id';
			$('#help-block2').show();
			$('#help-block2').html(msg1);
			$("#userEmailId").addClass("form-control has-error");
			// setTimeout(function(){ $('.help-block2').hide(); }, 3000);
			return false;
		} 
	}
	else if(email_flag==1)
	{
		var msg1 = 'Please enter email id';
		$("#userEmailId").val("");
		$('#help-block2').show();
		$('#help-block2').html(msg1);
		$("#userEmailId").addClass("form-control has-error");
	}
	/* else
	{
		 document.getElementById("userEmailId").value='';
		$("#help-block2").html("");
	} */
}
$(document).ready(function()
{		
	/*$('#userEmailId').blur(function()
	{
		if( $("#userEmailId").val() != "" )
		{
			var userEmailId = $("#userEmailId").val();
			var Company_id = '<?php echo $Company_id; ?>';
			$.ajax({
				  type: "POST",
				  data: {userEmailId: userEmailId, Company_id: Company_id},
				  url: "<?php echo base_url()?>index.php/Enrollmentc/check_userEmailId",
				  success: function(data)
				  {
						$('#message1').html(data);
				  }
			});
		}
	});
	
	$('#cardId').blur(function()
	{ 
		if( $("#cardId").val() != "" )
		{
			var cardId = $("#cardId").val();
			var Company_id = '<?php echo $Company_id; ?>';
			$.ajax({
				  type: "POST",
				  data: {cardid: cardId, Company_id: Company_id},
				  url: "<?php echo base_url()?>index.php/Enrollmentc/check_card_id",
				  success: function(data)
				  {
						$('#message2').html(data);
				  }
			});
		}
	}); */
});
</script>
<script>
$('#Register').click(function()
{
	if( $('#User_id').val() != "" && $('#firstName').val() != "" && $('#lastName').val() != "" && $('#currentAddress').val() != "" && $('#phno').val() != "" && $('#userEmailId').val() != "" && $('#country_id').val() != "" )
	{
		if($('#User_id').val() == 1)
		{
				
				
			if($('#member_tier_id').val() == ""){
				
				return false;
			}	
				
			var RefrenceVAL = $("input[name=Refrence]:checked").val();
			// alert(RefrenceVAL)
			if( RefrenceVAL == 1)
			{
				if( $('#Refree_name').val() != "" )
				{
					show_loader();
					return true;
				}
			}
			else
			{
				show_loader();
				return true;
			}
		}
		else if( ($('#User_id').val() == 2 || $('#User_id').val() == 4) && $("#Time_Zone").val() != "" && $("#city").val() != ""&& $("#district").val() != ""&& $("#state").val() != "" && $('#Seller_Redemptionratio').val() != "" && $('#Seller_Redemptionlimit').val() != ""&& $('#Seller_sales_tax').val() != "" && $('#Topup_Bill_no').val() != "" && $('#Purchase_Bill_no').val() != "" && $('#MercahndizeCategory').val() != "" && $('#RetailersPaymentBill_no').val() != "" && $('#Seller_Paymentratio').val() != "")
		{
			//var radioVAL = $("input[name=Super_seller]:checked").val();
			var Sub_seller_admin1 = $("input[name=Sub_seller_admin]:checked").val();

			/* if(radioVAL == 0 || radioVAL == 1 )
			{
				show_loader();
			}
			 */

			if(Sub_seller_admin1 == 1 )
			{
				show_loader();
				return true;
			}
			else
			{
				if($('#Sub_seller_Enrollement_id').val() != "")
				{
					show_loader();
					return true;
				}
			}
		}
	
	}
});

function search_enrollement(search_data)
{
	// document.getElementById("enrollement_records").style.display="none";
	if(search_data!="")
	{
		var Company_id = '<?php echo $Company_id; ?>';
			$.ajax({
				type:"POST",
				data:{search_data:search_data, Company_id:Company_id},
				url: "<?php echo base_url()?>index.php/Enrollmentc/search_enrollement",
				success : function(data)
				{
					//alert(data);
					document.getElementById("enrollement_records").innerHTML=data;
				}
			});
	}
	else
	{
		var Title = "Application Information";
		var msg = 'Please Enter Member Name/ Phone No./ Email ID/ Membership ID to Search Member !!!';
		runjs(Title,msg);
	}
}

function validateEmail(emailID)
{
	if(emailID != "")
	{
		var n = emailID.indexOf("@");
		var n1 = emailID.lastIndexOf(".");
		//alert(n+"sdffd--"+n1);

		if(n < 0 || n1 < 0 || n1 < n)
		{
			document.getElementById("userEmailId").value = "";
			document.getElementById("help-block1").innerHTML = "";
			return false;
		}
	}
}


</script>

<script>
var remain_lic=<?php echo $remain_lic;?>;
function hide_user_type(input_val)
{
	if(input_val == 1)
	{
		/* 08-03-2021  */		
			$("#member_tier_id").attr("required","required");
		/* 08-03-2021 */
	}
	else if(input_val == 2 || input_val == 4  )
	{
		// $("#city").attr("required","required");
		// $("#district").attr("required","required");
		// $("#state").attr("required","required");
		$("#Purchase_Bill_no").attr("required","required");
		$("#Topup_Bill_no").attr("required","required");
		$("#Time_Zone").attr("required","required");
		$("#Seller_Redemptionratio").attr("required","required");
		$("#Seller_Redemptionlimit").attr("required","required");
		$("#Seller_sales_tax").attr("required","required");
		$("#Refrence").attr("required","required");
		$("#Super_seller").attr("required","required");
		$("#MercahndizeCategory").attr("required","required");
		$("#RetailersPaymentBill_no").attr("required","required");
		$("#Seller_Paymentratio").attr("required","required");


		$("#Merchandize_Partner_ID").removeAttr("required");
		$("#Merchandize_Partner_Branch").removeAttr("required");
		if(remain_lic==0)
		{
			document.getElementById("Sub_seller_admin1").checked=false;
			document.getElementById("Sub_seller_admin1").disabled=true;
			document.getElementById("Sub_seller_admin").checked=true;
			hideshow_subseller(0);
			Show_Admin_list(0);
		}
		/* 08-03-2021  */		
			$("#member_tier_id").removeAttr("required");
		/* 08-03-2021 */

	}
	else if(input_val == 5)
	{
		$("#Merchandize_Partner_ID").attr("required","required");
		$("#Merchandize_Partner_Branch").attr("required","required");
		$("#MercahndizeCategory").removeAttr("required");
		$("#city").removeAttr("required");
		$("#district").removeAttr("required");
		$("#state").removeAttr("required");
		$("#Purchase_Bill_no").removeAttr("required");
		$("#Topup_Bill_no").removeAttr("required");
		/* 08-03-2021  */		
			$("#member_tier_id").removeAttr("required");
		/* 08-03-2021 */
	}
	else
	{
		$("#Purchase_Bill_no").removeAttr("required");
		$("#Merchandize_Partner_ID").removeAttr("required");
		$("#Merchandize_Partner_Branch").removeAttr("required");
		$("#MercahndizeCategory").removeAttr("required");
		$("#city").removeAttr("required");
		$("#district").removeAttr("required");
		$("#state").removeAttr("required");
		
		/* 08-03-2021  */		
			// $("#member_tier_id").attr("required","required");
			$("#member_tier_id").removeAttr("required");
		/* 08-03-2021 */
	}
}
/*
$(function()
{
	$( "#datepicker" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	});
}); */
</script>
 
<script>

/****************Autocomplete*****************/
 $("#Refree_name").autocomplete({	
 
	source:"<?php echo base_url()?>index.php/Enrollmentc/autocomplete_customer_names", // path to the get_birds method
	change: function (event, ui)
	{
		if (!ui.item) { this.value = ''; }
	} 
}); 
/*
$('#Refree_name').blur(function()
{	
	if( $("#Refree_name").val() != "" )
	{
		var CardId = $("#Refree_name").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{Membership_id:CardId,Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/Enrollmentc/Fetch_member_details",
			dataType: "json",
			success: function(json)
			{	
				if(json == 0)
				{
					$("#Refree_name").val("");
					var msg1 = 'Please enter valid membership id';
					$('#help-block11').show();
					$('#help-block11').html(msg1);
					$("#Refree_name").addClass("form-control has-error");
					// setTimeout(function(){ $('.help-block11').hide(); }, 3000);
					return false;
				}
				else
				{
					if(json['Error_flag'] == 1001) // Status Is OK
					{	
						$('#Refree_name').val(json['Member_name']+'-'+json['card_id']);
						$("#Refree_name").removeClass("has-error");
						$("#help-block11").html("");
					}
					else if(json['Error_flag'] == 2003) //Unable to Locate membership id
					{	
						$("#Refree_name").val("");
						var msg1 = 'Please enter valid membership id.';
						$('#help-block11').show();
						$('#help-block11').html(msg1);
						$("#Refree_name").addClass("form-control has-error");
						// setTimeout(function(){ $('.help-block11').hide(); }, 3000);
						return false;
					}						
				}
			}
		});
	}
	else
	{
		var msg1 = 'Please enter membership id';
		$('#help-block11').show();
		$('#help-block11').html(msg1);
		$("#Refree_name").addClass("form-control has-error");
		// setTimeout(function(){ $('.help-block11').hide(); }, 3000);
		return false;
	}
}); */

/***************Autocomplete********************/

$('#phno').blur(function()
{	
	if( $("#phno").val() != "" )
	{
		var Phone_no = $("#phno").val();
		var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
		var Country_id = '<?php echo $Enroll_details->Country; ?>';
		
		$.ajax({
			  type: "POST",
			  data: {Phone_no: Phone_no, Company_id: Company_id, Country_id: Country_id},
			  url: "<?php echo base_url()?>index.php/Enrollmentc/check_phone_no",
			  success: function(data)
			  {
				if(data.length == 13)
				{
					$("#phno").val("");
					var msg1 = 'Already exist';
					$('#help-block1').show();
					$('#help-block1').html(msg1);
					$("#phno").addClass("form-control has-error");
					// setTimeout(function(){ $('#help-block1').hide(); }, 3000);
					return false;
				}
				else if(data.length != 13)
				{
					$("#phno").removeClass("has-error");
					$("#help-block1").html("");
					
				}
				else
				{
					var email_flag = $("input[name=email_validity]:checked").val();
					if(email_flag==0)
					{
						mailgenrator(email_flag);
					}
				}
			  }
		});
	}
	else
	{
		var msg1 = 'Please enter phone number';
		$('#help-block1').show();
		$('#help-block1').html(msg1);
		setTimeout(function(){ $('#help-block1').hide(); }, 3000);
		return false;
	}
});

$('#userEmailId').blur(function()
{
	if( $("#userEmailId").val() != "" )
	{
		var userEmailId = $("#userEmailId").val();
		var userId = $("#User_id").val();
		var Company_id = '<?php echo $Company_id; ?>';

		$.ajax({
			  type: "POST",
			  data: {userEmailId: userEmailId, Company_id: Company_id, userId: userId},
			  url: "<?php echo base_url()?>index.php/Enrollmentc/check_userEmailId",
			  success: function(data)
			  {
					if(data.length == 13)
					{
						$("#userEmailId").val("");
						var msg1 = 'Already exist';
						$('#help-block2').show();
						$('#help-block2').html(msg1);
						$("#userEmailId").addClass("form-control has-error");
						// setTimeout(function(){ $('.help-block2').hide(); }, 3000);
						return false; 
					}
					else
					{
						$("#userEmailId").removeClass("has-error");
						$("#help-block2").html("");
					}
			  }
		});
	}
	else
	{
		$("#userEmailId").val("");
		var msg1 = 'Please enter email id';
		$('#help-block2').show();
		$('#help-block2').html(msg1);
		$("#userEmailId").addClass("form-control has-error");
		// setTimeout(function(){ $('.help-block2').hide(); }, 3000);
		return false;
	}
});

$('#cardId').blur(function()
{
	if( $("#cardId").val()  == "" )
	{
		$("#cardId").val("");
		var msg1 = 'Please enter membership id';
		$('#help-block3').show();
		$('#help-block3').html(msg1);
		$("#cardId").addClass("form-control has-error");
		// setTimeout(function(){ $('.help-block3').hide(); }, 3000);
		return false;
		
		// has_error(".has-feedback","#glyphicon2","#help-block2","Please Enter Valid Membership ID..!!");
	}
	else
	{
		var cardId = $("#cardId").val();
		var Company_id = '<?php echo $Company_id; ?>';
		$.ajax({
			  type: "POST",
			  data: {cardid: cardId, Company_id: Company_id},
			  url: "<?php echo base_url()?>index.php/Enrollmentc/check_card_id",
			  success: function(data)
			{
				if(data.length == 13)
				{
					$('#cardId').val('');
					var msg1 = 'Already exist';
					$('#help-block3').show();
					$('#help-block3').html(msg1);
					$("#cardId").addClass("form-control has-error");
					// setTimeout(function(){ $('.help-block3').hide(); }, 3000);
					return false;
				}
				else
				{
					$("#cardId").removeClass("has-error");
					$("#help-block3").html("");
				}
			}
		});
	}
});

$('#Sub_seller_Enrollement_id').change(function()
{
	if( $("#Sub_seller_Enrollement_id").val()  == "" )
	{
		// has_error(".has-feedback","#glyphicon2","#help-block2","Please Enter Valid Membership ID..!!");
		$('#Sub_seller_Enrollement_id').val('');
		var msg1 = 'Please select sub Outlet admin';
		$('#help-block4').show();
		$('#help-block4').html(msg1);
		$("#Sub_seller_Enrollement_id").addClass("form-control has-error");
		// setTimeout(function(){ $('.help-block4').hide(); }, 3000);
		return false;
	}
	else
	{
		var Sub_seller_enrollID = $("#Sub_seller_Enrollement_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		$.ajax({
			  type: "POST",
			  data: {Sub_sellerEnrollID: Sub_seller_enrollID, Company_id: Company_id},
			  url: "<?php echo base_url()?>index.php/Enrollmentc/get_redemption_ratio",
			  success: function(data)
			  {
				$('#Seller_Redemptionratio').val(data);
			  }
		});
	}
});

/*******************Phone No. Validation******************/
function isNumberKey2(evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode

  if (charCode != 46 && charCode > 31
	&& (charCode < 48 || charCode > 57))
	 return false;

  return true;
}

$('#currentAddress').blur(function()
{
	get_location_details(country_id,currentAddress,zip,city,district,state);
});
$('#country_id').click(function()
{
	get_location_details(country_id,currentAddress,zip,city,district,state);
});
$('#zip').blur(function()
{
	get_location_details(country_id,currentAddress,zip,city,district,state);
});
$('#city').blur(function()
{
	get_location_details(country_id,currentAddress,zip,city,district,state);
});
$('#district').blur(function()
{
	get_location_details(country_id,currentAddress,zip,city,district,state);
});
$('#state').blur(function()
{
	get_location_details(country_id,currentAddress,zip,city,district,state);
});

function get_location_details(country_id,currentAddress,zip,city,district,state)
{
	var country_id = $('#country_id').val();
	var currentAddress = $('#currentAddress').val();
	var zip = $('#zip').val();
	var city = document.getElementById("city").options[document.getElementById("city").selectedIndex].text;
	var district = $('#district').val();
	var state = document.getElementById("state").options[document.getElementById("state").selectedIndex].text;
	
	$.ajax({
		type: "POST",
		data: {country_id: country_id, currentAddress: currentAddress, zip: zip, city: city, district: district, state: state},
		url: "<?php echo base_url()?>index.php/Enrollmentc/get_long_latt_merchant",
		success: function(data)
		{
			var Location=new Array();
			Location = data.split("*");
			
			document.getElementById("Latitude").value=Location[0];
			document.getElementById("Latitude2").value=Location[0];
			document.getElementById("Longitude").value=Location[1];
			document.getElementById("Longitude2").value=Location[1];
		}
	});
}

/* function submerchant(submerchant)
{
	if(submerchant == 1)
	{
		$('#sub_merchant').css("display","none");
	}
	else
	{
		$('#sub_merchant').css("display","inline");
	}
} */

function Show_Admin_list(adminSel)
{
	var lic_limit='<?php echo $remain_lic; ?>';
	if(adminSel =='1' )
	{
		if(lic_limit == 0)
		{
			// var Title = "Application Information";
			var msg = "Your Murchant Licence Limit is Over Please Contact Administrator";
			// runjs(Title,msg);
			alert(msg);
			// $("#Register").attr("disabled","disabled");
		}
		else
		{
			$("#Seller_Admin_list").hide();
		}
		$("#Sub_seller_Enrollement_id").removeAttr("required");
	}
	else
	{
		$("#Sub_seller_Enrollement_id").attr("required","required");
		$("#Seller_Admin_list").show();
		// $("#Register").removeAttr('disabled');
	}
}

$('#phno').bind("cut copy paste",function(e) {
  e.preventDefault();
});

$('#cardid').bind("cut copy paste",function(e) {
  e.preventDefault();
});

$('#userEmailId').bind("cut copy paste",function(e) {
  e.preventDefault();
});

function Get_states(Country_id)
{
	$.ajax({
		type: "POST",
		data: {Country_id: Country_id},
		url: "<?php echo base_url()?>index.php/Company/Get_states",
		success: function(data)
		{
			$("#Show_States").html(data.States_data);
		}
	});
}
function Get_cities(State_id)
{	
	$.ajax({
		type: "POST",
		data: {State_id: State_id},
		url: "<?php echo base_url()?>index.php/Company/Get_cities",
		success: function(data)
		{
			$("#Show_Cities").html(data.City_data);
		}
	});
}
function readImage(input,div_id) 
{
	document.getElementById('profile_pic').style.display="";
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
/******************************************/






</script>
<style>
.thumbnail {
    display: block;
    padding: 4px;
    margin-bottom: 20px;
    line-height: 1.42857143;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    -webkit-transition: border .2s ease-in-out;
    -o-transition: border .2s ease-in-out;
    transition: border .2s ease-in-out;
}
.thumbnail>img 
{
    margin-right: auto;
    margin-left: auto;
}
.img-responsive, .thumbnail>img {
    display: block;
    max-width: 100%;
    height: auto;
}
</style>
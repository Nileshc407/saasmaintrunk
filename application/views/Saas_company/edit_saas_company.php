<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Company/update_company',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">COMPANY PROFILE</h6>
					<div class="element-box">
					<div class="alert alert-danger alert-dismissible fade show" role="alert" id="alert_box" style="display:none;"></div>
				<?php  
						if(@$this->session->flashdata('success_code'))
						{ ?>	
							<div class="alert alert-success alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('success_code')."<br>".$this->session->flashdata('data_code'); ?>
							</div>
				<?php 	} 
						if(@$this->session->flashdata('error_code'))
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('error_code')."<br>".$this->session->flashdata('data_code'); ?>
							</div>
				<?php 	} ?>
							<div class="row">
								<div class="col-sm-6">	
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Company Name</label>
									<input type="text" class="form-control" name="cname" id="cname" data-error="Please enter company name" placeholder="Enter company name" required="required" value="<?php echo $record->Company_name; ?>">
									<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
								  </div> 
								  
								  <div class="form-group">
									<label><span class="required_info">* </span>Company Address</label>
									<textarea class="form-control" rows="3" name="caddress" id="caddress" placeholder="Enter company address" data-error="Please enter company address" required="required"><?php echo $record->Company_address; ?></textarea>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Country</label>
									<select class="form-control" name="country" id="country" data-error="Please select country" required="required" onchange="Get_states(this.value);">
									<?php 
										foreach($Country_array as $Country)
										{?>
											<option value="<?php echo $Country['id'];?>" <?php if($record->Country == $Country['id']){echo "selected";} ?>><?php echo $Country['name'];?></option>
										<?php }
									?>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group" id="Show_States">
									<label for=""><span class="required_info">* </span>State</label>
									<select class="form-control" name="state" id="state" onchange="Get_cities(this.value);" data-error="Please select state">
									<?php 
										foreach($States_array as $rec)
										{?>
											<option value="<?php echo $rec->id;?>" <?php if($record->State == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
										<?php }
									?>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								 </div>
								 
								<div class="form-group" id="Show_Cities">
									<label for=""><span class="required_info">* </span> City</label>
									<select class="form-control" name="city" id="city" data-error="Please select city">
									<?php 
										foreach($City_array as $rec)
										{?>
											<option value="<?php echo $rec->id;?>" <?php if($record->City == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
										<?php }
									?>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								
								
								
								<div class="form-group">
									<label for="">&nbsp;District</label>
									<input type="text" name="district" class="form-control" placeholder="Enter district" value="<?php echo $record->District; ?>">
								</div>
								
								  <div class="form-group">
								   <label for=""><span class="required_info">* </span>Registration Date <span class="required_info">(* click inside textbox) MM/DD/YYYY </span></label>
									<input class="single-daterange form-control" placeholder="Select registration date" type="text" name="regdate" id="datepicker" data-error="Please select registration date" value="<?php echo date("m/d/y",strtotime($record->Comp_regdate)); ?>" disabled />
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Company Domain Name</label>
									<input type="text" name="domain" id="domain" class="form-control" placeholder="Enter company domain name" required="required" data-error="Please enter company domain name" value="<?php echo $record->Domain_name; ?>" disabled>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Company Logo <br><span class="required_info" align="center" size="0.8em"><i>You can upload logo upto 500kb </i></span></label><br>
									
									<?php if($record->Company_logo != ""){ ?>
									<div class="thumbnail" id="Logo" style="width:100px;">
									<img src="<?php echo base_url().$record->Company_logo; ?>" id="CompanyLogo1" class="img-responsive">
									</div>
									<?php } ?>
									
									<div class="thumbnail" id="Logo" style="width:100px; display:none;">
									<img src="" id="CompanyLogo1" class="img-responsive">
									</div>
									
                                    <input type="file" name="file" <?php if($record->Company_logo == ""){echo "required";} ?> id="CompanyLogo" onchange="readImage(this,'#CompanyLogo1');" data-error="Please select company logo" />
									<div class="help-block form-text with-errors form-control-feedback"></div>
								 </div>
								 
								 <div class="form-group">
									<label for=""><span class="required_info">* </span>No. of Merchant License</label>
									<input type="text" name="no_of_licensce" id="no_of_licensce" class="form-control" placeholder="Enter no. of merchant license" required="required" data-error="Please enter no. of merchant license" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $record->Seller_licences_limit; ?>" disabled  >
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Primary Email Address</label>
									<input type="email" name="primaryemailId" id="primaryemailId" class="form-control" placeholder="Enter primary email address" required="required" data-error="Please enter primary email address" value="<?php echo $record->Company_primary_email_id; ?>"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								<div class="form-group">
									<label for=""><span class="required_info">* </span>Contact Email Address</label>
									<input type="email" name="Company_contactus_email_id" id="Company_contactus_email_id" class="form-control" placeholder="Enter contact email address" required="required" data-error="Please enter contact email address" value="<?php echo $record->Company_contactus_email_id; ?>"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								<div class="form-group">
									<label for=""><span class="required_info">* </span>Finance Email Address</label>
									<input type="email" name="Company_finance_email_id" id="Company_finance_email_id" class="form-control" placeholder="Enter finance email address" required="required" data-error="Please enter finance email address" value="<?php echo $record->Company_finance_email_id; ?>"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								<div class="form-group">
									<label for=""><span class="required_info">* </span>Primary Contact No.</label>
									<input type="text" name="primaryphoneno" id="primaryphoneno" class="form-control" placeholder="Enter primary contact no." required="required" data-error="Please enter primary contact no." onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $record->Company_primary_phone_no; ?>"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								<div class="form-group">
									<label for=""><span class="required_info">* </span>Secondary Contact No.</label>
									<input type="text" name="secondaryphoneno" id="secondaryphoneno" class="form-control" placeholder="Enter secondary contact no." required="required" data-error="Please enter secondary contact no." onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $record->Company_secondary_phone_no; ?>"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								  
								   <fieldset class="form-group">
									<legend><span>Customer URL Links</span></legend>
									<div class="form-group">
										<label for="">Company Website Link</label>
										<input type="text" name="url" id="url" class="form-control" placeholder="Enter company website url" value="<?php echo $record->Website; ?>" disabled >
									</div>
									<div class="form-group">
										<label for="">Member Website Link</label>
										<input type="text" name="Cust_website" id="Cust_website" class="form-control" placeholder="Enter member website url" value="<?php echo $record->Cust_website; ?>"disabled>
									</div>
									
									<div class="form-group">
										<label for="">APK Link</label>
										<input type="text" name="cust_apk_link" id="cust_apk_link" class="form-control" placeholder="Enter apk link" value="<?php echo $record->Cust_apk_link; ?>" disabled>
									</div>
									<div class="form-group">
										<label for="">IOS Link</label>
										<input type="text" name="cust_ios_link" id="cust_ios_link" class="form-control" placeholder="Enter ios link" value="<?php echo $record->Cust_ios_link; ?>" disabled>
									</div>
									<div class="form-group">
										<label for="">Facebook Link</label>
										<input type="text" name="facebook_link" id="facebook_link" class="form-control" placeholder="Enter facebook link" value="<?php echo $record->Facebook_link; ?>" >
									</div>
									<div class="form-group">
										<label for="">GooglePlus Link</label>
										<input type="text" name="gplus_link" id="gplus_link" class="form-control" placeholder="Enter googlePlus link" value="<?php echo $record->Googlplus_link; ?>">
									</div>
									<div class="form-group">
										<label for="">LinkedIn Link</label>
										<input type="text" name="linked_link" id="linked_link" class="form-control" placeholder="Enter linkedIn link" value="<?php echo $record->Linkedin_link; ?>">
									</div>
									<div class="form-group">
										<label for="">Twitter Link</label>
										<input type="text" name="twitter_link" id="twitter_link" class="form-control" placeholder="Enter twitter link" value="<?php echo $record->Twitter_link; ?>">
									</div>
								   </fieldset> 
								   
								  					
								</div>
								  
								
								<div class="col-sm-6">
								
									<div class="form-group">
								 <label for="exampleInputEmail1"><span class="required_info">*</span> License Type</label>
									<select class="form-control" name="Company_License_type" id="Company_License_type"  required>
										
										<?php
										if($License_type != NULL)
										{
											foreach($License_type as $License_type)
											{
												if($record->Company_License_type==$License_type->Code_decode_id)
												 {
											?>
											
												<option value="<?php echo $License_type->Code_decode_id;?>"  ><?php echo $License_type->Code_decode; ?></option>
											
											<?php
												 }											
											}
										}
										?>
									</select>
										
								</div>
							  <div class="form-group">
								 <label for="exampleInputEmail1"><span class="required_info">*</span> Period of Licence Usage</label>
									<select class="form-control" name="Company_Licence_period2" id="Company_Licence_period2"  required  onchange="Get_license_expiry_date(this.value);" disabled>
										
										 
										  <option value="30" <?php if($record->Company_Licence_period==30){echo'selected';} ?> >1 Month</option>
										  <option value="90" <?php if($record->Company_Licence_period==90){echo'selected';} ?> >3 Months</option>
										  <option value="180" <?php if($record->Company_Licence_period==180){echo'selected';} ?> >6 Months</option>
										  <option value="365" <?php if($record->Company_Licence_period==365){echo'selected';} ?> >1 Year</option>
									</select>
										<input type="hidden" name="Company_Licence_period" id="Company_Licence_period"  value="<?php echo $record->Company_Licence_period; ?>">
									<div id="period_date" style="color:red;"></div>	
										
							  </div>
							  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Membership Card Process</label>
									<select class="form-control" name="card_decsion" id="card_decsion" data-error="Please select membership card process" onchange="get_carddecsion(this.value);" required="required" disabled>
										<option value="">Select</option>
										<option value="0" <?php if($record->card_decsion == 0){echo "selected";} ?>>Manual</option>
										<option value="1"<?php if($record->card_decsion == 1){echo "selected";} ?>>Automatic</option>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
									<input type="hidden" name="card_decsion" value="<?php echo $record->card_decsion; ?>">
								  </div>
								  <?php if($record->card_decsion == 1){?>
								  <div class="form-group"  id="card_decsion_block">
									<label for=""><span class="required_info">* </span>Starting Membership Card no. series.</label>
									<input type="text" name="start_card_no" id="start_card_no" class="form-control" placeholder="Enter starting membership card no. series." value="<?php echo $record->Start_card_series; ?>" disabled />
								 </div>	
								  <?php } else { ?>
								   <div class="form-group"  id="card_decsion_block" style="display:none;">
									<label for=""><span class="required_info">* </span>Starting Membership Card no. series.</label>
									<input type="text" name="start_card_no" id="start_card_no" class="form-control" placeholder="Enter starting membership card no. series." value="<?php echo $record->Start_card_series; ?>" disabled />
								 </div>	
								 <?php	} ?>	
								  <div class="form-group" id="redem">
									<label for=""><span class="required_info">* </span>Redemption Ratio<span class="required_info"> <?php echo '('.$Symbol_currency.' 1 = "X" Points)'; ?></span></label>
									<input type="text" class="form-control" name="redemptionratio" id="redemptionratio" placeholder="Enter value of  'x'" data-error="Please enter value of 'x'" onkeypress="return isNumberKey2(event);" onchange="javascript:Set_ratio();" required="required" value="<?php echo $record->Redemptionratio; ?>"  >
									<span class="required_info"><?php echo 'e.g. if  X = 4 then '.$Symbol_currency.' 1 = 4 Points'; ?></span>
									<div class="help-block form-text with-errors form-control-feedback" id="help-block2"></div>
									<input type="hidden" value="0" id="ratio_changed_flag" name="ratio_changed_flag">
								  </div>
								  
								 
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Company Currency Name</label>
									<input type="text" class="form-control" name="Currency_name" id="Currency_name" placeholder="Enter currency name" data-error="Please enter currency name" required="required" value="<?php echo $record->Currency_name; ?>" >
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  
								  
								  <fieldset class="form-group">
									<legend><span>Enable Functionality</span></legend> 
								  
									
									<div class="form-group">
									 <label for="">Member Joining Bonus</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Joining_bonus" id="inlineRadio11" value="1" onclick="javascript:toggleme12(this.value);" <?php if($record->Joining_bonus == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Joining_bonus" id="inlineRadio21" value="0" <?php if($record->Joining_bonus == 0){echo "checked";} ?> onclick="javascript:toggleme12(this.value);">No</label>
									  </div> 
									 </div>
								    </div>
									<?php if($record->Joining_bonus == 1){?>
									<div class="form-group" id="div_JBonus">
										<label for=""><span class="required_info">* </span>Member Joining Bonus Points</label>
										<input type="text" class="form-control" name="Joining_bonus_points" id="Joining_bonus_points" placeholder="Enter member joining bonus ponits" data-error="Please enter member joining bonus ponits" onkeypress="return isNumberKey2(event);" value="<?php echo $record->Joining_bonus_points; ?>" required="required">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } else { ?>
									<div class="form-group" id="div_JBonus" style="display:none;">
										<label for=""><span class="required_info">* </span>Member Joining Bonus Points</label>
										<input type="text" class="form-control" name="Joining_bonus_points" id="Joining_bonus_points" placeholder="Enter member joining bonus ponits" data-error="Please enter member joining bonus ponits" onkeypress="return isNumberKey2(event);">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php }  ?>
									
									<!-- sandeep gift card 10-05-2020 -->		  
								
									<div class="form-group" >
									 <label for="">Gift Card Functionality</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Gift_card_flag" value="1" onclick="toggle_gift_card_div(this.value);" <?php if($record->Gift_card_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Gift_card_flag" value="0" onclick="toggle_gift_card_div(this.value);" <?php if($record->Gift_card_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
							<?php if($record->Gift_card_flag == 1){ ?>
									<div class="form-group" id="gift_div_2">
										<label for=""><span class="required_info">* </span>Gift Card Validity In Days</label>
										<input type="text" class="form-control" name="Gift_card_validity_days" id="Gift_card_validity_days" onkeypress="return isNumberKey2(event);" placeholder="Enter gift card validity" data-error="Please enter gift card validity in days" value="<?php echo $record->Gift_card_validity_days ;?>">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									
									<div class="form-group" id="gift_div_3">
										<label for=""><span class="required_info">* </span>Minimum Gift Card Amount</label>
										<input type="text" class="form-control" name="Minimum_gift_card_amount" id="Minimum_gift_card_amount" onkeypress="return isNumberKey2(event);" placeholder="Enter gift card minimum amount" data-error="Please enter gift card minimum amount" value="<?php echo $record->Minimum_gift_card_amount ;?>">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
								 
									
							<?php } else {?>
									<div class="form-group" id="gift_div_2" style="display:none">
										<label for=""><span class="required_info">* </span>Gift Card Validity In Days</label>
										<input type="text" class="form-control" name="Gift_card_validity_days" id="Gift_card_validity_days" onkeypress="return isNumberKey2(event);" placeholder="Enter gift card validity" data-error="Please enter gift card validity in days" value="">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									
									<div class="form-group" id="gift_div_3" style="display:none">
										<label for=""><span class="required_info">* </span>Minimum Gift Card Amount</label>
										<input type="text" class="form-control" name="Minimum_gift_card_amount" id="Minimum_gift_card_amount" onkeypress="return isNumberKey2(event);" placeholder="Enter gift card minimum amount" data-error="Please enter gift card minimum amount" value="">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
								 
									
									
							<?php } ?>	
					<!-- sandeep gift card 10-05-2020 -->
									<div class="form-group">
									 <label for="">Notification Send to Email?</label>
										 <div class="col-sm-8" style=" margin-top:7px;">
										  <div class="form-check" style="float:left;">
											<label class="form-check-label">
											<input type="radio" class="form-check-input" name="Notification_send_to_email" value="1"  <?php if($record->Notification_send_to_email == 1){echo "checked";} ?>>Yes</label>
										  </div>
										  
										  <div class="form-check" style="margin-left:50px;">
											<label class="form-check-label">
											<input type="radio" class="form-check-input" name="Notification_send_to_email" value="0" <?php if($record->Notification_send_to_email == 0){echo "checked";} ?>>No</label>
										  </div> 
									 </div>
									</div>
									
									<!--<legend><span>Company Meal Card</span></legend>-->
									
									
									<div class="form-group">
									 <label for="">Enable Points as Discount</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
										  <div class="form-check" style="float:left;">
											<label class="form-check-label">
											<input type="radio" class="form-check-input" name="Points_as_discount_flag" value="1" <?php if($record->Points_as_discount_flag == 1){echo "checked";} ?>  onclick="toggle_points_discount(this.value);">Yes</label>
										  </div>
										  
										  <div class="form-check" style="margin-left:50px;">
											<label class="form-check-label">
											<input type="radio" class="form-check-input" name="Points_as_discount_flag" value="0" <?php if($record->Points_as_discount_flag == 0){echo "checked";} ?> onclick="toggle_points_discount(this.value);">No</label>
										  </div> 
									 </div>
								    </div>
									<?php if($record->Points_as_discount_flag == 1) { ?>
									<div class="form-group"  id="points_discount_1">
									 <label for="">Discount Code</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
										 <input type="text" name="Discount_code" id="Discount_code" class="form-control" placeholder="Enter Discount code" value="<?php echo $record->Discount_code;?>">
									 </div>
								    </div>
									<?php } else { ?>
									<div class="form-group"  id="points_discount_1" style="display:none"> 
									 <label for="">Discount Code</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
										 <input type="text" name="Discount_code" id="Discount_code" class="form-control" placeholder="Enter Discount code">
									 </div>
								    </div>
									<?php } ?>
									<div class="form-group">
									 <label for="">Enable Voucher as Discount</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
										  <div class="form-check" style="float:left;">
											<label class="form-check-label">
											<input type="radio" class="form-check-input" name="Voucher_as_discount_flag" value="1" <?php if($record->Voucher_as_discount_flag == 1){echo "checked";} ?>  onclick="toggle_voucher_discount(this.value);">Yes</label>
										  </div>
										  
										  <div class="form-check" style="margin-left:50px;">
											<label class="form-check-label">
											<input type="radio" class="form-check-input" name="Voucher_as_discount_flag" value="0" <?php if($record->Voucher_as_discount_flag == 0){echo "checked";} ?> onclick="toggle_voucher_discount(this.value);">No</label>
										  </div> 
									 </div>
								    </div>
									<?php if($record->Voucher_as_discount_flag == 1) { ?>
									<div class="form-group" id="voucher_discount_1">
									 <label for="">Voucher Discount Code</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
										 <input type="text" name="Voucher_discount_code" id="Voucher_discount_code" class="form-control" placeholder="Enter Voucher Discount code" value="<?php echo $record->Voucher_discount_code;?>">
									 </div>
								    </div>
									<?php } else { ?>
									<div class="form-group" id="voucher_discount_1" style="display:none">
									 <label for="">Voucher Discount Code</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
										 <input type="text" name="Voucher_discount_code" id="Voucher_discount_code" class="form-control" placeholder="Enter Voucher Discount code">
									 </div>
								    </div>
									<?php } ?>
								  </fieldset> 
								  <fieldset class="form-group">
									<legend><span>Enable Auto Process Notification</span></legend>
									<div class="form-group">
									 <label for="">Birthday Wish</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_birthday_flag" value="1" <?php if($record->Cron_birthday_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_birthday_flag" value="0" <?php if($record->Cron_birthday_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Tier Upgrade/Downgrade</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_tier_flag" value="1" <?php if($record->Cron_tier_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_tier_flag" value="0" <?php if($record->Cron_tier_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">eVoucher Expiry</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_evoucher_expiry_flag" onclick="Show_evoucher_expiry_flag(this.value);" value="1" <?php if($record->Cron_evoucher_expiry_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_evoucher_expiry_flag" value="0" onclick="Show_evoucher_expiry_flag(this.value);" <?php if($record->Cron_evoucher_expiry_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									<?php if($record->Cron_evoucher_expiry_flag == 1) { ?>
									<div class="form-group" id="voucher_block">
										<label for=""><span class="required_info">* </span>eVoucher Expiry Period in Days</label>
										<input type="text" class="form-control" name="Evoucher_expiry_period" id="Evoucher_expiry_period" placeholder="Enter e-voucher expiry period in days" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter e-voucher expiry period in days" value="<?php echo $record->Evoucher_expiry_period; ?>" required="required">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } else { ?>
									<div class="form-group" id="voucher_block" style="display:none;">
										<label for=""><span class="required_info">* </span>eVoucher Expiry Period in Days</label>
										<input type="text" class="form-control" name="Evoucher_expiry_period" id="Evoucher_expiry_period" placeholder="Enter e-voucher expiry period in days" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter e-voucher expiry period in days" value="">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } ?>
									<div class="form-group">
									 <label for="">Points Expiry</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_points_expiry_flag" onclick="Show_points_expiry_flag(this.value);" value="1" <?php if($record->Cron_points_expiry_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_points_expiry_flag" value="0" onclick="Show_points_expiry_flag(this.value);" <?php if($record->Cron_points_expiry_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									<?php if($record->Cron_points_expiry_flag == 1) { ?>
									<div class="form-group" id="points_expiry_block">
										<label for=""><span class="required_info">* </span>Points Expiry Period in Days</label>
										<input type="text" name="Points_expiry_period" id="Points_expiry_period" class="form-control" placeholder="Enter points expiry period in days" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter points expiry period in days" value="<?php echo $record->Points_expiry_period; ?>" required="required">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
								
									<div class="form-group" id="points_expiry_block2">
										<label for=""><span class="required_info">* </span>Deduct Points for expiry in % <span class="required_info"> (It should be less than 100%)</span></label>
										<input type="text" name="Deduct_points_expiry" id="Deduct_points_expiry" class="form-control" placeholder="Enter deduct points for expiry in %" onkeypress="return isNumberKey2(event);" data-error="Please enter deduct points for expiry in %" value="<?php echo $record->Deduct_points_expiry; ?>" required="required">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } else { ?>
									<div class="form-group" id="points_expiry_block" style="display:none;">
										<label for=""><span class="required_info">* </span>Points Expiry Period in Days</label>
										<input type="text" name="Points_expiry_period" id="Points_expiry_period" class="form-control" placeholder="Enter points expiry period in days" onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter points expiry period in days" value="">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
								
									<div class="form-group" id="points_expiry_block2" style="display:none;">
										<label for=""><span class="required_info">* </span>Deduct Points for expiry in % <span class="required_info"> (It should be less than 100%)</span></label>
										<input type="text" name="Deduct_points_expiry" id="Deduct_points_expiry" class="form-control" placeholder="Enter deduct points for expiry in %" onkeypress="return isNumberKey2(event);" data-error="Please enter deduct points for expiry in %" value="">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } ?>
									
									
									<div class="form-group">
									 <label for="">Survey Notification</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_survey_flag" value="1" <?php if($record->Cron_survey_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_survey_flag" value="0" <?php if($record->Cron_survey_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Trigger Notification</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_trigger_flag" value="1" <?php if($record->Cron_trigger_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_trigger_flag" value="0" <?php if($record->Cron_trigger_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Communication Notification</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_communication_flag" value="1" <?php if($record->Cron_communication_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_communication_flag" value="0" <?php if($record->Cron_communication_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
								  </fieldset>
								
								</div>
							</div>
						  <div class="form-buttons-w" align="center">
							
							<button class="btn btn-primary" type="submit" id="Register">Save</button>
							
							<input type="hidden" name="Company_id" value="<?php echo $record->Company_id; ?>" class="form-control">
							<input type="hidden" name="Company_logo2" value="<?php echo $record->Company_logo; ?>" class="form-control">
							<input type="hidden" name="Localization_logo2" value="<?php echo $record->Localization_logo; ?>" class="form-control">
						  </div>
					</div>
				</div>
				<?php echo form_close(); ?>	
				
				
			</div>
		</div>	
	</div>
</div>
<!---------------In-Activate modal start---------------->	
<div aria-hidden="true" aria-labelledby="mySmallModalLabel" class="modal fade bd-example-modal-sm show" id="MakeInactive" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Confirmation
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="arg11" id="arg11" value=""/>
                <input type="hidden" name="arg22" id="arg22" value=""/>
                <input type="hidden" name="arg33" id="arg33" value=""/>
                <input type="hidden" name="argUrl1" id="argUrl1" value=""/>
                Are you sure to In-Activate the Company for <b id="arg22"></b> ?<br><span id="arg33"></span>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
                <button class="btn btn-primary" type="button" onclick="confirmed_inactive(arg11.value, arg22.value, arg33.value, argUrl1.value)">OK</button>
            </div>
        </div>
    </div>
</div>
<!------------In-Activate modal end------------->
<!-------------Activate modal start------------->	
<div aria-hidden="true" aria-labelledby="mySmallModalLabel" class="modal fade bd-example-modal-sm show" id="MakeActive" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Confirmation
                </h5>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="arg111" id="arg111" value=""/>
                <input type="hidden" name="arg222" id="arg222" value=""/>
                <input type="hidden" name="arg333" id="arg333" value=""/>
                <input type="hidden" name="argUrl1" id="argUrl11" value=""/>
                Are you sure to Activate the Company for <b id="arg222"></b> ?<br><span id="arg333"></span>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
                <button class="btn btn-primary" type="button" onclick="confirmed_active(arg111.value, arg222.value, arg333.value, argUrl11.value)">OK</button>
            </div>
        </div>
    </div>
</div>
<!---------------Activate modal end---------------->
<?php $this->load->view('header/footer'); ?>
<script>
$('#Register').click(function()
{
	
	var Joining_bonus = $("input[name=Joining_bonus]:checked").val();
	var Joining_bonus_points=$('#Joining_bonus_points').val();
	var Company_logo = '<?php echo $record->Company_logo; ?>';
	
	var Joining_bonus_flag=0;		
			
	if((Joining_bonus==1 &&  Joining_bonus_points!= "") || (Joining_bonus==0))
	{

		 Joining_bonus_flag=1;
	}


				  
	if( $('#cname').val() != "" && $('#country').val() != "" && $('#state').val() != "" && $('#city').val() != "" && $('#caddress').val() != "" && $('#primarycnt').val() != "" &&  Company_logo != "" && Joining_bonus_flag == 1 )
	{
		if($('#primaryphoneno').val() != "" &&  $('#primaryemailId').val() != "" &&  $('#Evoucher_expiry_period').val() != "") 
		{
			show_loader();
			
		}
	}
	
	var btn_class_name = this.className ;
	if(btn_class_name=="btn btn-primary")
	{
		show_loader();
	}
});


function toggleme12(flag1)
{
	var flags2 = flag1;
	if(flags2 == 0)
	{
		$("#Joining_bonus_points").removeAttr("required");
		document.getElementById('div_JBonus').style.display = "none";
	}
	else
	{
		document.getElementById('div_JBonus').style.display = "";
		$("#Joining_bonus_points").attr("required","required");
	}
}

function get_carddecsion(card_decsion) 
{		
	if(card_decsion==1)	
	{
		document.getElementById('card_decsion_block').style.display = "";
		$("#start_card_no").attr("required","required");
	}
	else
	{
		document.getElementById('card_decsion_block').style.display = "none";
		$("#start_card_no").removeAttr("required");
	}
}



//****** gift card 10-05-2020 ***********
function toggle_gift_card_div(GiftFlag) 
{
	if(GiftFlag==1)	
	{
		document.querySelector('#gift_div_2').style.display = "";
		document.querySelector('#gift_div_3').style.display = "";
		document.querySelector('#gift_div_4').style.display = "";
		
		$("#Gift_card_validity_days").attr("required","required");
		$("#Minimum_gift_card_amount").attr("required","required");
	}
	else
	{
		document.querySelector('#gift_div_2').style.display = "none";
		document.querySelector('#gift_div_3').style.display = "none";
		document.querySelector('#gift_div_4').style.display = "none";
		
		$("#Gift_card_validity_days").removeAttr("required");
		$("#Minimum_gift_card_amount").removeAttr("required");
	}
}
//****** gift card 10-05-2020 ***********
function toggle_points_discount(disFlag) 
{
	if(disFlag==1)	
	{
		document.querySelector('#points_discount_1').style.display = "";
		$("#Discount_code").attr("required","required");
	}
	else
	{
		document.querySelector('#points_discount_1').style.display = "none";
		$("#Discount_code").removeAttr("required");
	}
}
function toggle_voucher_discount(disFlag) 
{
	if(disFlag==1)	
	{
		document.querySelector('#voucher_discount_1').style.display = "";
		$("#Voucher_discount_code").attr("required","required");
	}
	else
	{
		document.querySelector('#voucher_discount_1').style.display = "none";
		$("#Voucher_discount_code").removeAttr("required");
	}
}




$('#Deduct_points_expiry').change(function()
{
	var Deduct_points_expiry=$('#Deduct_points_expiry').val();
	if(Deduct_points_expiry>100)
	{
		$('#Deduct_points_expiry').val('');
		$('#alert_box').show();			
		$("#alert_box").html('Please enter less than 100% for points expiry deduction');
		jQuery("#alert_box").attr("tabindex",-1).focus();
		setTimeout(function(){ $('#alert_box').hide(); }, 4000);
		return false;
	}
});

function Show_points_expiry_flag(flag)
{	
    if(flag == 1)
    {
        $('#points_expiry_block').css("display","");
        $('#points_expiry_block2').css("display","");
		$("#Points_expiry_period").attr("required","required");
		$("#Deduct_points_expiry").attr("required","required");
    }
    else
    {
        $('#points_expiry_block').css("display","none");
        $('#points_expiry_block2').css("display","none");
		$("#Points_expiry_period").removeAttr("required")
		$("#Deduct_points_expiry").removeAttr("required")
    }
}
 <?php
		if($record->Cron_points_expiry_flag == 1)
		{ ?>
			$('#points_expiry_block').css("display","");
			$('#points_expiry_block2').css("display","");
<?php	} 
		if($record->Cron_evoucher_expiry_flag == 1)
		{ ?>
			$('#voucher_block').css("display","");
<?php	}
		if($record->Allow_membershipid_once == 1)
		{ ?>
			$('#Membershipid_redirection').css("display",""); 
			$("#Membership_redirection_url").attr("required","required");
<?php	} ?>
 
function Show_evoucher_expiry_flag(flag)
{
    if(flag == 1)
    {
        $('#voucher_block').css("display","");
		$("#Evoucher_expiry_period").attr("required","required");
    }
    else
    {
        $('#voucher_block').css("display","none");
		$("#Evoucher_expiry_period").removeAttr("required");	
    }
}


function Set_ratio()
{
	document.getElementById('ratio_changed_flag').value=1;
	$('#alert_box').show();			
	$("#alert_box").html('If you Modify the Redemption Ratio, it will Update the Points Value for all the Merchandizing Items of the Company');
	jQuery("#alert_box").attr("tabindex",-1).focus();
	setTimeout(function(){ $('#alert_box').hide(); }, 4000);
	return false;
}


$(function() 
{
	$( "#datepicker" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	});
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
function readImage1(input,div_id) 
{
	document.getElementById('Logo1').style.display="";
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
function Inactive_me(arg1, arg2, arg3, argUrl) 
{
    $(".modal-body #arg11").val(arg1);
    $(".modal-body #arg11").html(arg1);

    $(".modal-body #arg22").val(arg2);
    $(".modal-body #arg22").html(arg2);

    $(".modal-body #arg33").val(arg3);
    $(".modal-body #arg33").html(arg3);

    $(".modal-body #argUrl1").val(argUrl);
}

function confirmed_inactive(arg1, arg2, arg3, argUrl) 
{
    if (argUrl)
    {
        var url = '<?php echo base_url(); ?>index.php/' + argUrl + '=' + arg1;
        $('#MakeInactive').modal('hide');
        show_loader();
        setTimeout(function () {
            window.location = url;
        }, 3000)
        return true;
    } 
	else
    {
        return false;
    }
}
function Active_me(arg1, arg2, arg3, argUrl) 
{
    $(".modal-body #arg111").val(arg1);
    $(".modal-body #arg111").html(arg1);

    $(".modal-body #arg222").val(arg2);
    $(".modal-body #arg222").html(arg2);


    $(".modal-body #arg333").val(arg3);
    $(".modal-body #arg333").html(arg3);

    $(".modal-body #argUrl11").val(argUrl);
}
function confirmed_active(arg1, arg2, arg3, argUrl) 
{
    if (argUrl)
    {
        var url = '<?php echo base_url(); ?>index.php/' + argUrl + '=' + arg1;
        $('#MakeActive').modal('hide');
        show_loader();
        setTimeout(function () {
            window.location = url;
        }, 3000)
        return true;
    } 
	else
    {
        return false;
    }
}
// Get_license_expiry_date("<?php echo $record->Company_Licence_period; ?>");
$('#period_date').html('Expiry date will be <?php echo $_SESSION["Expiry_license"]; ?>');
function Get_license_expiry_date(period) 
{
	
	if(period==30)
	{	
		<?php $val = date('Y-m-d',strtotime($_SESSION["Expiry_license"].'+30 day'));?> 
		var Expdate = '<?php echo $val;?>'
		$('#period_date').html('Expiry date will be '+Expdate);
	}
	else if(period==60) 
	{	
		<?php $val = date('Y-m-d',strtotime($_SESSION["Expiry_license"].'+60 day'));?> 
		var Expdate = '<?php echo $val;?>'
		$('#period_date').html('Expiry date will be '+Expdate);
	}
	else if(period==90) 
	{	
		<?php $val = date('Y-m-d',strtotime($_SESSION["Expiry_license"].'+90 day'));?> 
		var Expdate = '<?php echo $val;?>'
		$('#period_date').html('Expiry date will be '+Expdate);
	}
	else if(period==365) 
	{	
		<?php $val = date('Y-m-d',strtotime($_SESSION["Expiry_license"].'+365 day'));?> 
		var Expdate = '<?php echo $val;?>'
		$('#period_date').html('Expiry date will be '+Expdate);
	}
	else if(period==730) 
	{	
		<?php $val = date('Y-m-d',strtotime($_SESSION["Expiry_license"].'+730 day'));?> 
		var Expdate = '<?php echo $val;?>'
		$('#period_date').html('Expiry date will be '+Expdate);
	}
	else  
	{	
		<?php $val = date('Y-m-d',strtotime($_SESSION["Expiry_license"].'+1095 day'));?> 
		var Expdate = '<?php echo $val;?>'
		$('#period_date').html('Expiry date will be '+Expdate);
	}
	
}
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
<link href="<?php echo base_url(); ?>assets/icon_fonts_assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
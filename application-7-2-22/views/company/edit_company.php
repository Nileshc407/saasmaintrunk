<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Company/update_company',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">EDIT COMPANY</h6>
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
									<label for=""><span class="required_info">* </span>Language</label>
									<select class="form-control" name="Country_language" id="Country_language" required="required" data-error="Please select language">
									<option value="<?php echo $record->Country_language; ?>"><?php echo $record->Country_language; ?></option>
									<option value="English">English</option>
									<option value="Afrikanns">Afrikanns</option>
									  <option value="Albanian">Albanian</option>
									  <option value="Arabic">Arabic</option>
									  <option value="Armenian">Armenian</option>
									  <option value="Basque">Basque</option>
									  <option value="Bengali">Bengali</option>
									  <option value="Bulgarian">Bulgarian</option>
									  <option value="Catalan">Catalan</option>
									  <option value="Cambodian">Cambodian</option>
									  <option value="Chinese (Mandarin)">Chinese (Mandarin)</option>
									  <option value="Croation">Croation</option>
									  <option value="Czech">Czech</option>
									  <option value="Danish">Danish</option>
									  <option value="Dutch">Dutch</option>
									  <option value="Estonian">Estonian</option>
									  <option value="Fiji">Fiji</option>
									  <option value="Finnish">Finnish</option>
									  <option value="French">French</option>
									  <option value="Georgian">Georgian</option>
									  <option value="German">German</option>
									  <option value="Greek">Greek</option>
									  <option value="Gujarati">Gujarati</option>
									  <option value="Hebrew">Hebrew</option>
									  <option value="Hindi">Hindi</option>
									  <option value="Hungarian">Hungarian</option>
									  <option value="Icelandic">Icelandic</option>
									  <option value="Indonesian">Indonesian</option>
									  <option value="Irish">Irish</option>
									  <option value="Italian">Italian</option>
									  <option value="Japanese">Japanese</option>
									  <option value="Javanese">Javanese</option>
									  <option value="Korean">Korean</option>
									  <option value="Latin">Latin</option>
									  <option value="Latvian">Latvian</option> 
									  <option value="Lithuanian">Lithuanian</option>
									  <option value="Macedonian">Macedonian</option>
									  <option value="Malay">Malay</option>
									  <option value="Malayalam">Malayalam</option>
									  <option value="Maltese">Maltese</option>
									  <option value="Maori">Maori</option>
									  <option value="Marathi">Marathi</option>
									  <option value="Mongolian">Mongolian</option>
									  <option value="Nepali">Nepali</option>
									  <option value="Norwegian">Norwegian</option>
									  <option value="Persian">Persian</option>
									  <option value="Polish">Polish</option>
									  <option value="Portuguese">Portuguese</option>
									  <option value="Punjabi">Punjabi</option>
									  <option value="Quechua">Quechua</option>
									  <option value="Romanian">Romanian</option>
									  <option value="Russian">Russian</option>
									  <option value="Samoan">Samoan</option>
									  <option value="Serbian">Serbian</option>
									  <option value="Slovak">Slovak</option>
									  <option value="Slovenian">Slovenian</option>
									  <option value="Spanish">Spanish</option>
									  <option value="Swahili">Swahili</option>
									  <option value="Swedish ">Swedish </option>
									  <option value="Tamil">Tamil</option>
									  <option value="Tatar">Tatar</option>
									  <option value="Telugu">Telugu</option>
									  <option value="Thai">Thai</option>
									  <option value="Tibetan">Tibetan</option>
									  <option value="Tonga">Tonga</option>
									  <option value="Turkish">Turkish</option>
									  <option value="Ukranian">Ukranian</option>
									  <option value="Urdu">Urdu</option>
									  <option value="Uzbek">Uzbek</option>
									  <option value="Vietnamese">Vietnamese</option>
									  <option value="Welsh">Welsh</option>
									  <option value="Xhosa">Xhosa</option>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								
								<div class="form-group">
									<label for="">&nbsp;District</label>
									<input type="text" name="district" class="form-control" placeholder="Enter district" value="<?php echo $record->District; ?>">
								</div>
								<div class="form-group">
									<label for=""><span class="required_info">* </span>Primary Contact Name</label>
									<input type="text" name="primarycnt" id="primarycnt" class="form-control" placeholder="Enter primary contact name" required="required" data-error="Please enter primary contact name" value="<?php echo $record->Company_primary_contact_person; ?>"/>
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
								  
								  <div class="form-group">
								   <label for=""><span class="required_info">* </span>Registration Date <span class="required_info">(* click inside textbox) MM/DD/YYYY </span></label>
									<input class="single-daterange form-control" placeholder="Select registration date" type="text" name="regdate" id="datepicker" data-error="Please select registration date" value="<?php echo date("m/d/y",strtotime($record->Comp_regdate)); ?>"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Company Registration No.</label>
									<input type="text" name="cregno" id="cregno" class="form-control" placeholder="Enter company registration no." required="required" data-error="Please enter company registration no." onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $record->Company_reg_no; ?>"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Company Domain Name</label>
									<input type="text" name="domain" id="domain" class="form-control" placeholder="Enter company domain name" required="required" data-error="Please enter company domain name" value="<?php echo $record->Domain_name; ?>">
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
									<input type="text" name="no_of_licensce" id="no_of_licensce" class="form-control" placeholder="Enter no. of merchant license" required="required" data-error="Please enter no. of merchant license" onkeyup="this.value=this.value.replace(/\D/g,'')" value="<?php echo $record->Seller_licences_limit; ?>" >
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  <fieldset class="form-group">
									<legend><span>Notification Share on Social Media</span></legend>
									<div class="form-group">
										<label for=""> Share Type</label>
										&nbsp;&nbsp;<br>
										<label class="radio-inline">
											<input type="radio" name="Share_type" onclick="Show_share_limit(this.value);" value="1"  <?php if($record->Share_type == 1){echo "checked";} ?>>
											Share Once
										</label>
										<label class="radio-inline">
											<input type="radio" name="Share_type" onclick="Show_share_limit(this.value);" value="0" <?php if($record->Share_type == 0){echo "checked";} ?>>
											Share Multiple Time
										</label>
										<input type="hidden" name="Old_Share_type" value="<?php echo $record->Share_type; ?>" />
									</div>
									<div class="form-group" id="Share_limit_div" <?php if($record->Share_type == 1){echo "style='display: none;'";} ?>>
										<label for="">Share Limit</label>
										<input type="text" name="Share_limit" id="Share_limit" class="form-control" placeholder="Enter share limit" value="<?php echo $record->Share_limit; ?>">
									</div>
									<div class="form-group">
										<label for="">Facebook Share Points</label>
										<input type="text" name="Facebook_share_points" id="Facebook_share_points" class="form-control" placeholder="Enter facebook share points" value="<?php echo $record->Facebook_share_points; ?>">
									</div>
									<div class="form-group">
										<label for="">Twitter Share Points</label>
										<input type="text" name="Twitter_share_points" id="Twitter_share_points" class="form-control" placeholder="Enter twitter share points" value="<?php echo $record->Twitter_share_points; ?>">
									</div>
									<div class="form-group">
										<label for="">Google Plus Share Points</label>
										<input type="text" name="Google_share_points" id="Google_share_points" class="form-control" placeholder="Enter google plus share points" value="<?php echo $record->Google_share_points; ?>" >
									</div>
								   </fieldset>
								   <fieldset class="form-group">
									<legend><span>Customer URL Links</span></legend>
									<div class="form-group">
										<label for="">Company Website Link</label>
										<input type="text" name="url" id="url" class="form-control" placeholder="Enter company website url" value="<?php echo $record->Website; ?>">
									</div>
									<div class="form-group">
										<label for="">Member Website Link</label>
										<input type="text" name="Cust_website" id="Cust_website" class="form-control" placeholder="Enter member website url" value="<?php echo $record->Cust_website; ?>">
									</div>
									
									<div class="form-group">
										<label for="">APK Link</label>
										<input type="text" name="cust_apk_link" id="cust_apk_link" class="form-control" placeholder="Enter apk link" value="<?php echo $record->Cust_apk_link; ?>">
									</div>
									<div class="form-group">
										<label for="">IOS Link</label>
										<input type="text" name="cust_ios_link" id="cust_ios_link" class="form-control" placeholder="Enter ios link" value="<?php echo $record->Cust_ios_link; ?>" >
									</div>
									<div class="form-group">
										<label for="">Facebook Link</label>
										<input type="text" name="facebook_link" id="facebook_link" class="form-control" placeholder="Enter facebook link" value="<?php echo $record->Facebook_link; ?>">
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
								   
								   <fieldset class="form-group">
									<legend><span>Enable Dashboard Graph</span></legend>
									<div class="form-group">
									 <label for="">Active Vs Inactive Members Graph</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Active_Vs_inactive_member_graph_flag" value="1" <?php if($record->Active_Vs_inactive_member_graph_flag == 1){echo "checked";} ?> >Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Active_Vs_inactive_member_graph_flag" value="0" <?php if($record->Active_Vs_inactive_member_graph_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Member Enrollment Graph</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Member_enrollments_graph_flag" value="1" <?php if($record->Member_enrollments_graph_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Member_enrollments_graph_flag" value="0" <?php if($record->Member_enrollments_graph_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">No. of Loyalty Trans. Vs No. of Redeem Trans. Graph</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag" value="1" <?php if($record->No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag" value="0" <?php if($record->No_of_loyalty_tras_Vs_no_of_redeem_tras_graph_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Total Issued Points Vs Total Redeem Points Graph</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Total_point_issued_Vs_total_points_redeemed_graph_flag" value="1" <?php if($record->Total_point_issued_Vs_total_points_redeemed_graph_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Total_point_issued_Vs_total_points_redeemed_graph_flag" value="0" <?php if($record->Total_point_issued_Vs_total_points_redeemed_graph_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Total Issued Quantity Vs Total Used Quantity Graph</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Total_quantity_issued_Vs_total_quantity_used_graph_flag" value="1" <?php if($record->Total_quantity_issued_Vs_total_quantity_used_graph_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Total_quantity_issued_Vs_total_quantity_used_graph_flag" value="0" <?php if($record->Total_quantity_issued_Vs_total_quantity_used_graph_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Partner Issued Quantity Vs Partner Used Quantity Graph</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Partner_qnty_issued_Vs_partner_qnty_used_graph_flag" value="1" <?php if($record->Partner_qnty_issued_Vs_partner_qnty_used_graph_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Partner_qnty_issued_Vs_partner_qnty_used_graph_flag" value="0" <?php if($record->Partner_qnty_issued_Vs_partner_qnty_used_graph_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									<div class="form-group">
									 <label for="">Purchase Order Snapshot Graph</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Transaction_Order_Types_graph_flag" value="1"  <?php if($record->Transaction_Order_Types_graph_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Transaction_Order_Types_graph_flag" value="0"  <?php if($record->Transaction_Order_Types_graph_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									<div class="form-group">
									 <label for="">Show Members Suggestion</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Member_suggestions_flag" value="1" <?php if($record->Member_suggestions_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Member_suggestions_flag" value="0" <?php if($record->Member_suggestions_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Show Happy Members</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Happy_member_flag" value="1" <?php if($record->Happy_member_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Happy_member_flag" value="0" <?php if($record->Happy_member_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Show Worry Members</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Worry_member_flag" value="1" <?php if($record->Worry_member_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Worry_member_flag" value="0" <?php if($record->Worry_member_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									<div class="panel panel-default">
									
									<legend><span>Provision for Order , Payment and Delivery URLs, KEY etc</span></legend>
									<div class="panel-body">
										<div class="form-group">
											<label for="exampleInputEmail1">Order api encryption key </label>
											<input type="text" name="Company_orderapi_encryptionkey" class="form-control" placeholder="Enter Order Api Encryption Key"  value="<?php echo $record->Company_orderapi_encryptionkey; ?>" />
										</div>
										
										<div class="form-group">
											<label for="exampleInputEmail1">Payment getway api encryption key </label>
											<input type="text" name="Company_api_encryptionkey" class="form-control" placeholder="Enter Payment Getway Api Encryption Key" value="<?php echo $record->Company_api_encryptionkey; ?>"//>
										</div>
										
										<div class="form-group">
											<label for="exampleInputEmail1">Delivery partner url 1 </label>
											<input type="text" name="Delivery_partner_url" class="form-control" placeholder="Enter Delivery Partner URL 1" value="<?php echo $record->Delivery_partner_url; ?>"  />
										</div>
										
										<div class="form-group">
											<label for="exampleInputEmail1">Delivery partner url 2 </label>
											<input type="text" name="Delivery_partner_url2" class="form-control" placeholder="Enter Delivery Partner URL 2"  value="<?php echo $record->Delivery_partner_url2; ?>" />
										</div>
										
										<div class="form-group">
											<label for="exampleInputEmail1">Delivery api key</label>
											<input type="text" name="Delivery_api_key1" class="form-control" placeholder="Enter Delivery Api Key 1" value="<?php echo $record->Delivery_api_key1; ?>" />
										</div>
									<!--	
										<div class="form-group">
											<label for="exampleInputEmail1">Delivery api key 2</label>
											<input type="text" name="Delivery_api_key2" class="form-control" placeholder="Enter Delivery Api Key 2" />
										</div>
									-->
														
									</div>						
								</div>
							<!---------------Nilesh 8-7-2020- Dpo credit card-------------->
								<div class="panel panel-default">									
									<legend><span>Provision for DPO Credit Card Payment URLs, KEY etc</span></legend>
									<div class="panel-body">
										<div class="form-group">
											<label for="exampleInputEmail1">Dpo Company id </label>
											<input type="text" name="Dpo_company_id" class="form-control" placeholder="Enter Dpo Company id"  value="<?php echo $record->Dpo_company_id; ?>" />
										</div>
										
										<div class="form-group">
											<label for="exampleInputEmail1">API End point </label>
											<input type="text" name="End_point" class="form-control" placeholder="Enter End point" value="<?php echo $record->End_point; ?>"/>
										</div>
										
										<div class="form-group">
											<label for="exampleInputEmail1">Payment url </label>
											<input type="text" name="Payment_url" class="form-control" placeholder="Enter Payment url" value="<?php echo $record->Payment_url; ?>"  />
										</div>
										
										<div class="form-group">
											<label for="exampleInputEmail1">Redirect url </label>
											<input type="text" name="Redirect_url" class="form-control" placeholder="Enter Redirect url"  value="<?php echo $record->Redirect_url; ?>" />
										</div>
										
										<div class="form-group">
											<label for="exampleInputEmail1">Back url</label>
											<input type="text" name="Back_url" class="form-control" placeholder="Enter Back url" value="<?php echo $record->Back_url; ?>" />
										</div>
										
										<div class="form-group">
											<label for="exampleInputEmail1">PTL</label>
											<input type="text" name="PTL" class="form-control" placeholder="Enter PTL" value="<?php echo $record->PTL; ?>" />
										</div>
										
										<div class="form-group">
											<label for="exampleInputEmail1">Service type</label>
											<input type="text" name="Service_type" class="form-control" placeholder="Enter Service type" value="<?php echo $record->Service_type; ?>" />
										</div>			
									</div>						
								</div>
							<!---------------Nilesh 8-7-2020- Dpo credit card-------------->
							<!----------Nilesh 20-8-2020--------------->
								<div class="panel panel-default">
									
									<legend><span>Provision for App Name, Redeem Request Validity etc</span></legend>
									<div class="panel-body">
										<div class="form-group">
											<label for="exampleInputEmail1"><span class="required_info">* </span>App folder name </label>
											<input type="text" name="App_folder_name" id="App_folder_name" class="form-control" placeholder="Enter App folder name" value="<?php echo $record->App_folder_name; ?>" required />
										</div>
										
										<div class="form-group">
											<label for="exampleInputEmail1">Redeem request validity <span class="required_info"> format (hours:minutes:seconds)</span></label>
											<input type="text" name="Redeem_request_validity" id="Redeem_request_validity" class="form-control" placeholder="Enter Redeem request validity" value="<?php echo $record->Redeem_request_validity; ?>" />
										</div>
									</div>						
								</div>
								<div class="panel panel-default">
									<legend><span>Provision for Pos Transaction Otp Code Generation etc</span></legend>
									<div class="panel-body">
										<div class="form-group" >
										 <label for="">Code Generation Functionality</label>
										 <div class="col-sm-8" style=" margin-top:7px;">
										  <div class="form-check" style="float:left;">
											<label class="form-check-label">
											<input type="radio" class="form-check-input" name="Use_pin_flag" value="1" onclick="toggle_Use_pin_div(this.value);" <?php if($record->Use_pin_number_as_card_id == 1){echo "checked";} ?>>Yes</label>
										  </div>
										  
										  <div class="form-check" style="margin-left:50px;">
											<label class="form-check-label">
											<input type="radio" class="form-check-input" name="Use_pin_flag" value="0" onclick="toggle_Use_pin_div(this.value);" <?php if($record->Use_pin_number_as_card_id == 0){echo "checked";} ?>>No</label>
										  </div> 
										 </div>
										</div>
										<?php if($record->Use_pin_number_as_card_id == 1){ ?>
										<div class="form-group" id="Otp_div">
											<label for="exampleInputEmail1">Otp Code validity <span class="required_info"> format (hours:minutes:seconds)</span></label>
											<input type="text" name="Otp_code_validity" id="Otp_code_validity" class="form-control" placeholder="Enter Otp Code validity" value="<?php echo $record->Pin_number_validity; ?>" />
										</div>
										<?php } else { ?>
											<div class="form-group" id="Otp_div" style="display:none">
											<label for="exampleInputEmail1">Otp Code validity <span class="required_info"> format (hours:minutes:seconds)</span></label>
											<input type="text" name="Otp_code_validity" id="Otp_code_validity" class="form-control" placeholder="Enter Otp Code validity"/>
										</div>
										<?php } ?>
									</div>						
								</div>
							<!----------Nilesh 20-8-2020--------------->
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
									<select class="form-control" name="Company_Licence_period" id="Company_Licence_period"  required  onchange="Get_license_expiry_date(this.value);">
										
										  <option value="30" <?php if($record->Company_Licence_period==30){echo'selected';} ?> >30 Days</option>
										  <option value="60" <?php if($record->Company_Licence_period==60){echo'selected';} ?> >60 Days</option>
										  <option value="90" <?php if($record->Company_Licence_period==90){echo'selected';} ?> >90 Days</option>
										  <option value="365" <?php if($record->Company_Licence_period==365){echo'selected';} ?> >1 Year</option>
										  <option value="730" <?php if($record->Company_Licence_period==730){echo'selected';} ?> >2 Years</option>
										  <option value="1095" <?php if($record->Company_Licence_period==1095){echo'selected';} ?> >3 Years</option>
									</select>
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
									<input type="text" name="start_card_no" id="start_card_no" class="form-control" placeholder="Enter starting membership card no. series." value="<?php echo $record->Start_card_series; ?>" readonly />
								 </div>	
								  <?php } else { ?>
								   <div class="form-group"  id="card_decsion_block" style="display:none;">
									<label for=""><span class="required_info">* </span>Starting Membership Card no. series.</label>
									<input type="text" name="start_card_no" id="start_card_no" class="form-control" placeholder="Enter starting membership card no. series." value="<?php echo $record->Start_card_series; ?>" readonly />
								 </div>	
								 <?php	} ?>	
								  <div class="form-group" id="redem">
									<label for=""><span class="required_info">* </span>Redemption Ratio<span class="required_info"> <?php echo '('.$Symbol_currency.' 1 = "X" Points)'; ?></span></label>
									<input type="text" class="form-control" name="redemptionratio" id="redemptionratio" placeholder="Enter value of  'x'" data-error="Please enter value of 'x'" onkeypress="return isNumberKey2(event);" onchange="javascript:Set_ratio();" required="required" value="<?php echo $record->Redemptionratio; ?>">
									<span class="required_info"><?php echo 'e.g. if  X = 4 then '.$Symbol_currency.' 1 = 4 Points'; ?></span>
									<div class="help-block form-text with-errors form-control-feedback" id="help-block2"></div>
									<input type="hidden" value="0" id="ratio_changed_flag" name="ratio_changed_flag">
								  </div>
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Customer Notification Distance<span class="required_info"> (in Kilometeres Only)</span></label>
									<input type="text" class="form-control" name="noti_distance" id="noti_distance" placeholder="Enter customer notification distance" data-error="Please enter customer notification distance" onkeypress="return isNumberKey2(event);" required="required" value="<?php echo $record->Distance; ?>">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Compnay Currency Name</label>
									<input type="text" class="form-control" name="Currency_name" id="Currency_name" placeholder="Enter currency name" data-error="Please enter currency name" required="required" value="<?php echo $record->Currency_name; ?>" >
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <fieldset class="form-group">
									<legend><span>Company Privacy</span></legend>
									<div class="form-group">
										<label for="">Company User Name</label>
										<input type="text" name="C_user_name" id="C_user_name" class="form-control" placeholder="Enter company user name" data-error="Please enter company user name" required="required" value="<?php echo $record->Company_username; ?>">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<div class="form-group">
										<label for="">Company Password</label>
										<input type="password" name="C_password" id="C_password" class="form-control" placeholder="Enter company password" data-error="Please enter company password" required="required" value="<?php echo $record->Company_password; ?>" >
										<div class="help-block form-text with-errors form-control-feedback"></div>
										<input type="checkbox" id="showHide"> Show Password 
									</div>
									
									<div class="form-group">
										<label for="">Company Encryption Key</label>
										<input type="text" name="C_Encryptionkey" id="C_Encryptionkey" class="form-control" placeholder="Enter company encryption key" data-error="Please enter company encryption key" required="required" value="<?php echo $record->Company_encryptionkey; ?>">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
								   </fieldset> 
								  
								  <fieldset class="form-group">
									<legend><span>Enable Functionality</span></legend> 
								   <div class="form-group">
									 <label for="">Enable Coalition</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="enb_coalition" id="enb_coalition" value="1" onclick="show_coalition(this.value)" <?php if($record->Coalition == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="enb_coalition" id="enb_coalition" value="0" <?php if($record->Coalition == 0){echo "checked";} ?> onclick="show_coalition(this.value)">No</label>
									  </div> 
									 </div>
								    </div>
									<?php if($record->Coalition == 1){ ?>
								    <div class="form-group" id="Coalition_points">
									  <label for=""><span class="required_info">* </span>Coalition Points Percentage</label>
									  <input type="text" name="Coalition_points_percentage" id="Coalition_points_percentage"  class="form-control" placeholder="Enter coalition points percentage" data-error="Please enter coalition points percentage" value="<?php echo $record->Coalition_points_percentage; ?>">
									  <div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } else { ?>
									<div class="form-group" id="Coalition_points" style="display:none" >
									<label for=""><span class="required_info">* </span>Coalition Points Percentage</label>
									<input type="text" name="Coalition_points_percentage" id="Coalition_points_percentage"  class="form-control" placeholder="Enter coalition points percentage">
								</div>
								<?php } ?>
									<div class="form-group">
									 <label for="">Merchant Top Up Access</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="top_access" id="inlineRadio1" value="1" onclick="javascript:toggleme11(this.value);" <?php if($record->Seller_topup_access == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="top_access" id="inlineRadio2" value="0" <?php if($record->Seller_topup_access == 0){echo "checked";} ?> onclick="javascript:toggleme11(this.value);" >No</label>
									  </div> 
									 </div>
								    </div>
									<?php if($record->Seller_topup_access == 1){ ?>
									<div class="form-group" id="div_company">
										<label for=""><span class="required_info">* </span>Opening Deposit Amount<br><span class="required_info" align="center" size="0.8em"><i>(For company deposit)</i></span></label>
										<input type="text" class="form-control" name="amt_deposit" id="amt_deposit" onkeyup="this.value=this.value.replace(/\D/g,'');" placeholder="Enter opening deposit amount" data-error="Please enter opening deposit amount" value="<?php echo $record->Deposit_amount; ?>" required="required">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>	
									<div class="form-group" id="div_company2">
										<label for=""><span class="required_info">* </span>Threshold Value<br><span class="required_info" align="center" size="0.8em"><i>(For merchant Transaction)</i></span></label>
										<input type="text" class="form-control" name="amt_threshold" id="amt_threshold" onkeyup="this.value=this.value.replace(/\D/g,'');" placeholder="Enter threshold value"data-error="Please enter threshold value" value="<?php echo $record->Threshold_Merchant; ?>" required="required">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } else { ?>
									 <div class="form-group" id="div_company" style="display:none;">
										<label for=""><span class="required_info">* </span>Opening Deposit Amount  <br><span class="required_info" align="center" size="0.8em"><i>(For company deposit)</i></span></label>
										<input type="text" name="amt_deposit" id="amt_deposit" onkeyup="this.value=this.value.replace(/\D/g,'')" class="form-control" placeholder="Enter opening deposit amount" data-error="Please enter opening deposit amount" />
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<div class="form-group" id="div_company2" style="display:none;">
										<label for=""><span class="required_info">* </span>Threshold Value  <br><span class="required_info" align="center" size="0.8em"><i>(For merchant Transaction)</i></span></label>
										<input type="text" name="amt_threshold" id="amt_threshold"  onkeyup="this.value=this.value.replace(/\D/g,'')" class="form-control" placeholder="Enter threshold value" data-error="Please enter threshold value" />
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>	
									<?php } ?>
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
									<div class="form-group">
									 <label for="">Enable Sms</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="sms_decsion" id="inlineRadio1" value="1" onclick="javascript:toggleme(this.value);" <?php if($record->Sms_enabled == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="sms_decsion" id="inlineRadio2" value="0" <?php if($record->Sms_enabled == 0){echo "checked";} ?> onclick="javascript:toggleme(this.value);">No</label>
									  </div> 
									 </div>
								    </div>
									<?php if($record->Sms_enabled == 1){ ?>
									<div class="form-group"  id="sms_block">
										<label for=""><span class="required_info">* </span>Sms Limit</label>
										<?php if($record->Available_sms <=10 ) { ?>
										<input type="text" class="form-control" name="sms" id="sms" placeholder="Enter sms limit" data-error="Please enter sms limit" onkeypress="return isNumberKey2(event);" value="<?php echo $record->Available_sms; ?>">
										<?php } else { ?> 
										<input type="text" class="form-control" name="sms" id="sms" placeholder="Enter sms limit" data-error="Please enter sms limit" onkeypress="return isNumberKey2(event);" value="<?php echo $record->Available_sms; ?>" readonly>
										<?php }?>
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<div class="form-group"  id="sms_api_block">
										<label for="sms_api_link"><span class="required_info">* </span>Sms Api Link</label>
										<input type="text" class="form-control" name="sms_api_link" id="sms_api_link"placeholder="Enter sms api link" data-error="Please enter sms api link" value="<?php echo $record->Sms_api_link; ?>" required="required">	
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<div class="form-group" id="sms_api_auth_block">
										<label for="sms_api_auth_key"><span class="required_info">* </span>Sms Api Auth Key</label>
										<input type="text" class="form-control" name="sms_api_auth_key" id="sms_api_auth_key" placeholder="Enter sms api auth key" data-error="Please enter sms api auth key" value="<?php echo $record->Sms_api_auth_key; ?>" required="required">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } else { ?>
									<div class="form-group"  id="sms_block" style="display:none;">
										<label for=""><span class="required_info">* </span>Sms Limit</label>
										<input type="text" class="form-control" name="sms" id="sms" placeholder="Enter sms limit" data-error="Please enter sms limit" onkeypress="return isNumberKey2(event);">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<div class="form-group"  id="sms_api_block" style="display:none;">
										<label for="sms_api_link"><span class="required_info">* </span>Sms Api Link</label>
										<input type="text" class="form-control" name="sms_api_link" id="sms_api_link"placeholder="Enter sms api link" data-error="Please enter sms api link">	
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<div class="form-group" id="sms_api_auth_block" style="display:none;">
										<label for="sms_api_auth_key"><span class="required_info">* </span>Sms Api Auth Key</label>
										<input type="text" class="form-control" name="sms_api_auth_key" id="sms_api_auth_key" placeholder="Enter sms api auth key" data-error="Please enter sms api auth key">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } ?>
									<div class="form-group">
									 <label for="">Enable Discount</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="discount_flag" value="1" <?php if($record->Discount_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="discount_flag" value="0" <?php if($record->Discount_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Member Pin Number</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Pin_no_applicable" value="1" <?php if($record->Pin_no_applicable == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Pin_no_applicable" value="0" <?php if($record->Pin_no_applicable == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Merchant Pin Number</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Allow_merchant_pin" value="1" <?php if($record->Allow_merchant_pin == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Allow_merchant_pin" value="0" <?php if($record->Allow_merchant_pin == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Allow Membershipid Once</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Allow_membershipid_once" value="1" onclick="show_url(this.value);" <?php if($record->Allow_membershipid_once == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Allow_membershipid_once" value="0" onclick="show_url(this.value);" <?php if($record->Allow_membershipid_once == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									<div class="form-group" id="Membershipid_redirection" style="display:none;">
										<label for=""><span class="required_info">* </span>Membershipid Redirection URL</label>
										<input type="text" class="form-control" name="Membership_redirection_url" id="Membership_redirection_url" placeholder="Enter membershipid redirection url" data-error="Please enter membershipid redirection url" value="<?php echo $record->Membership_redirection_url ?>">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									
									<div class="form-group">
									 <label for="">Allow Merchandize Item for Enrollment</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Allow_redeem_item_enrollment" value="1" <?php if($record->Allow_redeem_item_enrollment == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Allow_redeem_item_enrollment" value="0" <?php if($record->Allow_redeem_item_enrollment == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Allow Preorder Services</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Allow_preorder_services" <?php if($record->Allow_preorder_services == 1){echo "checked";} ?> value="1">Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Allow_preorder_services" value="0" <?php if($record->Allow_preorder_services == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Promo Code</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Promo_code_applicable" value="1" <?php if($record->Promo_code_applicable == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Promo_code_applicable" value="0" <?php if($record->Promo_code_applicable == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Auction Bidding</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Auction_bid_applicable" value="1" <?php if($record->Auction_bidding_applicable == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Auction_bid_applicable" value="0" <?php if($record->Auction_bidding_applicable == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Profile Complete Bonus</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Profile_complete_flag" onclick="show_profile_bonus(this.value);" value="1" <?php if($record->Profile_complete_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Profile_complete_flag" onclick="show_profile_bonus(this.value);" value="0" <?php if($record->Profile_complete_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									<?php if($record->Profile_complete_flag == 1)	{ ?>
									<div class="form-group" id="Bonus_points">						
										<label for=""><span class="required_info">* </span>Profile Complete Bonus Points</label>
										<input type="text" class="form-control" name="Profile_complete_points" id="Profile_complete_points" onkeypress="return isNumberKey2(event);" placeholder="Enter profile complete bonus points" data-error="Please enter profile complete bonus points" value="<?php echo round($record->Profile_complete_points); ?>" required="required">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } else { ?>
									<div class="form-group" id="Bonus_points" style="display:none">						
										<label for=""><span class="required_info">* </span>Profile Complete Bonus Points </label> 
										<input type="text" class="form-control" name="Profile_complete_points" id="Profile_complete_points" onkeypress="return isNumberKey2(event);" placeholder="Enter profile complete bonus points" data-error="Please enter profile complete bonus points"value=""/>
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } ?>
									<div class="form-group">
									 <label for="">First Time App Login Bonus</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="App_login_flag" onclick="show_applogin_bonus(this.value);" value="1" <?php if($record->App_login_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="App_login_flag" onclick="show_applogin_bonus(this.value);" value="0" <?php if($record->App_login_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									<?php if($record->App_login_flag == 1){ ?>
									<div class="form-group" id="app_points">						
										<label for=""><span class="required_info">* </span>First Time App Login Bonus Points</label>
										<input type="text" name="App_login_points" id="App_login_points"  class="form-control" onkeypress="return isNumberKey2(event);" placeholder="Enter app login bonus points" data-error="Please enter app login bonus points" value="<?php echo round($record->App_login_points); ?>" required="required">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php }	else { ?>
									<div class="form-group" id="app_points" style="display:none">						
										<label for=""><span class="required_info">* </span>First Time App Login Bonus Points</label>
										<input type="text" name="App_login_points" id="App_login_points"  class="form-control" onkeypress="return isNumberKey2(event);" placeholder="Enter app login bonus points" data-error="Please enter app login bonus points" value="">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } ?>
								
									<div class="form-group">
									 <label for="">eCommerce Module</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Ecommerce_flag" onclick="enable_ecommerce_return_policy(this.value);" value="1" <?php if($record->Ecommerce_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Ecommerce_flag" onclick="enable_ecommerce_return_policy(this.value);" value="0" <?php if($record->Ecommerce_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									<?php if($record->Ecommerce_flag == 1) { ?>
									<div class="form-group" id="eCommerce_return_policy">
										<label for=""><span class="required_info">* </span>eCommerce Item Return Policy in Days</label>
										<input type="text" class="form-control" name="return_policy" id="return_policy"  onkeypress="return isNumberKey2(event);" placeholder="Enter eCommerce item return policy in days" data-error="Please enter eCommerce item return policy in days" value="<?php echo $record->Ecommerce_return_policy_in_days; ?>" required="required">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } else { ?>
									<div class="form-group" id="eCommerce_return_policy" style="display:none">
										<label for=""><span class="required_info">* </span>eCommerce Item Return Policy in Days</label>
										<input type="text" class="form-control" name="return_policy" id="return_policy"  onkeypress="return isNumberKey2(event);" placeholder="Enter eCommerce item return policy in days" data-error="Please enter eCommerce item return policy in days" value="">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } ?>
									<div class="form-group">
									 <label for="">Enable White Labeling</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="white_labels" onclick="toggle_label_block(this.value);" value="1" <?php if($record->Localization_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="white_labels" onclick="toggle_label_block(this.value);" value="0" <?php if($record->Localization_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									<?php if($record->Localization_flag == 1){ ?>
									<div class="form-group" id="label_block">
										<label for=""><span class="required_info">* </span>Upload White Labeling Logo<br>
										<font color="RED" align="center" size="0.8em"><i>You can upload logo upto 500kb  </i></font></label>
										<?php if($record->Localization_logo != "" && $record->Localization_flag == 1){ ?>
										<div class="thumbnail" id="Logo1" style="width:100px;">
										<img src="<?php echo base_url().$record->Localization_logo; ?>" id="CompanyLogo2" class="img-responsive">
										</div>
										<?php } ?>
										<div class="thumbnail" id="Logo1" style="width:100px; display:none;">
										<img src="" id="CompanyLogo2" class="img-responsive">
										</div>
										<input type="file" tabindex="23" name="white_label" id="white_label" data-error="Please select white labeling logo" onchange="readImage1(this,'#CompanyLogo2');">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } else { ?>
									<div class="form-group" id="label_block" style="display:none;">
										<label for=""><span class="required_info">* </span>Upload White Labeling Logo<br>
										<font color="RED" align="center" size="0.8em"><i>You can upload logo upto 500kb  </i></font></label>
										<?php if($record->Localization_logo != "" && $record->Localization_flag == 1){ ?>
										<div class="thumbnail" id="Logo1" style="width:100px;">
										<img src="<?php echo base_url().$record->Localization_logo; ?>" id="CompanyLogo2" class="img-responsive">
										</div>
										<?php } ?>
										<div class="thumbnail" id="Logo1" style="width:100px; display:none;">
										<img src="" id="CompanyLogo2" class="img-responsive">
										</div>
										<input type="file" tabindex="23" name="white_label" id="white_label" data-error="Please select white labeling logo" onchange="readImage1(this,'#CompanyLogo2');">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } ?>
									<div class="form-group">
									 <label for="">Enable Survey Analysis</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Survey_analysis" value="1"  <?php if($record->Survey_analysis == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Survey_analysis" value="0" <?php if($record->Survey_analysis == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Text Direction</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Text_direction" value="rtl" <?php if($record->Text_direction == "rtl"){echo "checked";} ?>>Right to Left</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:112px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Text_direction" value="ltr" <?php if($record->Text_direction == "ltr"){echo "checked";} ?>>Left to Right</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Call Center Module</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Call_center_flag" onclick="enable_ticketno(this.value);" value="1" <?php if($record->Call_center_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Call_center_flag" onclick="enable_ticketno(this.value);" value="0" <?php if($record->Call_center_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									<?php if($record->Call_center_flag == 1) { ?>
									<div class="form-group" id="ticketno_series_div">
										<label for=""><span class="required_info">* </span>Call Center Ticket Number Starting Series</label>
										<input type="text" class="form-control" name="ticketno_series" id="ticketno_series"   onkeypress="return isNumberKey2(event);" placeholder="Enter call center ticket starting series" data-error="Please enter call center ticket starting series" value="<?php echo $record->Callcenter_query_ticketno_series;	?>" required="required">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } else { ?>
									<div class="form-group" id="ticketno_series_div" style="display:none">
										<label for=""><span class="required_info">* </span>Call Center Ticket Number Starting Series</label>
										<input type="text" class="form-control" name="ticketno_series" id="ticketno_series"   onkeypress="return isNumberKey2(event);" placeholder="Enter call center ticket starting series" data-error="Please enter call center ticket starting series" value="" >
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } ?> 
									<div class="form-group">
									 <label for="">Channel Partner</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Beneficiary_flag" onclick="enable_beneficiary_company(this.value);" value="1" <?php if($record->Beneficiary_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Beneficiary_flag" onclick="enable_beneficiary_company(this.value);" value="0" <?php if($record->Beneficiary_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div> 
									<?php if($record->Beneficiary_flag == 1){?>
									<div class="form-group" id="beneficiary_company_div">
										<label for=""><span class="required_info">* </span>Select Channel Company</label><br>
										<select class="form-control select2" id="beneficiary_company" name="Beneficiary_company[]" multiple="true" data-error="Please select Channel Partner company" style="width:470px;" required="required">
										<?php	
											foreach($company_beneficiary as $companybeneficiary)
											{
												$company_benefi[]=$companybeneficiary->Register_beneficiary_id;
											}
											foreach($beneficiary_company as $beneficiarycmpny)
											{
												if(in_array($beneficiarycmpny->Register_beneficiary_id, $company_benefi))
												{ ?>
													<option value="<?php echo $beneficiarycmpny->Register_beneficiary_id;?>" selected ><?php echo $beneficiarycmpny->Beneficiary_company_name;?></option>
												<?php 
												} else {
												?>
													<option value="<?php echo $beneficiarycmpny->Register_beneficiary_id;?>"><?php echo $beneficiarycmpny->Beneficiary_company_name;?></option>
												<?php }
											}
										?>
										</select>
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } else { ?>
									<div class="form-group" id="beneficiary_company_div" style="display:none;">
										<label for=""><span class="required_info">* </span>Select Beneficiary Company</label><br>
										<select class="form-control select2" id="beneficiary_company" name="Beneficiary_company[]" multiple="true" data-error="Please select beneficiary company" style="width:470px;">
										<?php
										foreach($beneficiary_company as $beneficiarycompany)
										{ ?>
											<option value="<?php echo $beneficiarycompany->Register_beneficiary_id;?>">
											<?php echo $beneficiarycompany->Beneficiary_company_name;?></option>
										<?php } ?>
										</select>
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } ?>
									<div class="form-group">
										<label for="">Shipping Charges</label>
										<div class="col-sm-8">
										  <div class="form-check">
											<label class="form-check-label">
											<input class="form-check-input" type="radio" name="Shipping_charges_flag" onclick="toggle_shipping_charges(this.value);" value="0" <?php if($record->Shipping_charges_flag == 0){echo "checked";} ?>>Free</label>
										  </div>
										  <div class="form-check">
											<label class="form-check-label">
											<input class="form-check-input" type="radio" name="Shipping_charges_flag" onclick="toggle_shipping_charges(this.value);"value="1" <?php if($record->Shipping_charges_flag == 1){echo "checked";} ?>>Standard Charges</label>
										  </div>
										  <div class="form-check">
											<label class="form-check-label">
											<input class="form-check-input" type="radio" name="Shipping_charges_flag" onclick="toggle_shipping_charges(this.value);"value="2" <?php if($record->Shipping_charges_flag == 2){echo "checked";} ?>>Based on Delivery Price</label>
										  </div>
										</div>
									</div>
									<?php if($record->Shipping_charges_flag == 1){?>
									<div class="form-group" id="Shipping_charges_div1" style="display:block">
										<label for=""><span class="required_info">* </span>Enter Cost Threshold Limit</label>
										<input type="text" class="form-control" name="Cost_Threshold_Limit" id="Cost_Threshold_Limit" onkeypress="return isNumberKey2(event);" placeholder="Enter cost threshold limit" data-error="Please enter cost threshold limit" value="<?php echo $record->Cost_Threshold_Limit ;?>" required="required">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									
									<div class="form-group" id="Shipping_charges_div" style="display:block">
										<label for=""><span class="required_info">* </span>Enter Standard Charges</label>
										<input type="text" class="form-control" name="Standard_charges" id="Standard_charges" onkeypress="return isNumberKey2(event);" placeholder="Enter standard charges" data-error="Please enter standard charges" value="<?php echo $record->Standard_charges ;?>" required="required">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php }else{ ?>
									<div class="form-group" id="Shipping_charges_div1" style="display:none">
										<label for=""><span class="required_info">* </span>Enter Cost Threshold Limit</label>
										<input type="text" class="form-control" name="Cost_Threshold_Limit" id="Cost_Threshold_Limit" onkeypress="return isNumberKey2(event);" placeholder="Enter cost threshold limit" data-error="Please enter cost threshold limit">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									
									<div class="form-group" id="Shipping_charges_div" style="display:none">
										<label for=""><span class="required_info">* </span>Enter Standard Charges</label>
										<input type="text" class="form-control" name="Standard_charges" id="Standard_charges" onkeypress="return isNumberKey2(event);" placeholder="Enter standard charges" data-error="Please enter standard charges">
										<div class="help-block form-text with-errors form-control-feedback"></div>
									</div>
									<?php } ?>
									
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
								 
									
									<div class="form-group" id="gift_div_4">
									 <label for="">Points Used For Purchase Of Gift Card?</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Points_used_gift_card" value="1"  <?php if($record->Points_used_gift_card == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Points_used_gift_card" value="0" <?php if($record->Points_used_gift_card == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
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
								 
									
									<div class="form-group" id="gift_div_4" style="display:none">
									 <label for="">Points Used For Purchase Of Gift Card?</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Points_used_gift_card" value="1">Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Points_used_gift_card" value="0" checked >No</label>
									  </div> 
									 </div>
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
									 </fieldset> 
									 <fieldset class="form-group">
									<!--<legend><span>Company Meal Card</span></legend>-->
									<div class="form-group">
									 <label for="">Enable Company Meal</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
										  <div class="form-check" style="float:left;">
											<label class="form-check-label">
											<input type="radio" class="form-check-input" name="Enable_company_meal_flag" value="1" <?php if($record->Enable_company_meal_flag == 1){echo "checked";} ?>>Yes</label>
										  </div>
										  
										  <div class="form-check" style="margin-left:50px;">
											<label class="form-check-label">
											<input type="radio" class="form-check-input" name="Enable_company_meal_flag" value="0" <?php if($record->Enable_company_meal_flag == 0){echo "checked";} ?>>No</label>
										  </div> 
									 </div>
								    </div>
									<div class="form-group">
									 <label for="">Enable Redeem Auto Confirm</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
										  <div class="form-check" style="float:left;">
											<label class="form-check-label">
											<input type="radio" class="form-check-input" name="Redeem_auto_confirm_flag" value="1" <?php if($record->Redeem_auto_confirm_flag == 1){echo "checked";} ?>>Yes</label>
										  </div>
										  
										  <div class="form-check" style="margin-left:50px;">
											<label class="form-check-label">
											<input type="radio" class="form-check-input" name="Redeem_auto_confirm_flag" value="0" <?php if($record->Redeem_auto_confirm_flag == 0){echo "checked";} ?>>No</label>
										  </div> 
									 </div>
								    </div>
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
									 <label for="">Freebies Once Year</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_freebies_once_flag" value="1" <?php if($record->Cron_freebies_once_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_freebies_once_flag" value="0" <?php if($record->Cron_freebies_once_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
									<div class="form-group">
									 <label for="">Freebies Other Benefit</label>
									 <div class="col-sm-8" style=" margin-top:7px;">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_freebies_other_benefit_flag" value="1" <?php if($record->Cron_freebies_other_benefit_flag == 1){echo "checked";} ?>>Yes</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:50px;">
										<label class="form-check-label">
										<input type="radio" class="form-check-input" name="Cron_freebies_other_benefit_flag" value="0" <?php if($record->Cron_freebies_other_benefit_flag == 0){echo "checked";} ?>>No</label>
									  </div> 
									 </div>
								    </div>
									
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
								  <fieldset class="form-group">
									<legend><span>Additional Fields for Enrollment</span></legend>
									<div class="form-group">
										<label for="">Label 1</label>
										<input type="text" name="Label_1" class="form-control" placeholder="Enter label 1" value="<?php echo $record->Label_1; ?>">
									</div>
								  
									<div class="form-group">
										<label for="">Label 2</label>
										<input type="text" name="Label_2" class="form-control" placeholder="Enter label 2" value="<?php echo $record->Label_2; ?>">
									</div>
									
									<div class="form-group">
										<label for="">Label 3</label>
										<input type="text" name="Label_3" class="form-control" placeholder="Enter label 3"  value="<?php echo $record->Label_3; ?>">
									</div>
									
									<div class="form-group">
										<label for="">Label 4</label>
										<input type="text" name="Label_4" class="form-control" placeholder="Enter label 4" value="<?php echo $record->Label_4; ?>">
									</div>
									
									<div class="form-group">
										<label for="">Label 5</label>
										<input type="text" name="Label_5" class="form-control" placeholder="Enter label 5" value="<?php echo $record->Label_5; ?>">
									</div>
								  </fieldset> 
								</div>
							</div>
						  <div class="form-buttons-w" align="center">
							<?php if($_SESSION['Logged_user_id'] == 3){?>
							<button class="btn btn-primary" type="submit" id="Register">Update</button>
							<?php } ?>
							<input type="hidden" name="Company_id" value="<?php echo $record->Company_id; ?>" class="form-control">
							<input type="hidden" name="Company_logo2" value="<?php echo $record->Company_logo; ?>" class="form-control">
							<input type="hidden" name="Localization_logo2" value="<?php echo $record->Localization_logo; ?>" class="form-control">
						  </div>
					</div>
				</div>
				<?php echo form_close(); ?>	
				
				<!--------------Table------------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					   Active Companies
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<th>Action</th>
									<th>Company Name</th>
									<th>Company Address</th>
									<th>Pri. Contact Name</th>
									<th>Pri. Email Address</th>
									<th>Pri. Contact No.</th>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<th>Action</th>
									<th>Company Name</th>
									<th>Company Address</th>
									<th>Pri. Contact Name</th>
									<th>Pri. Email Address</th>
									<th>Pri. Contact No.</th>
								</tr>
							</tfoot>
							<tbody>
						<?php
							if($results != NULL)
							{
								foreach($results as $row)
								{	?>
								<tr>
									<td class="row-actions">
										<a href="<?php echo base_url()?>index.php/Company/edit_company/?Company_id=<?php echo $row->Company_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
					
										<a class="danger" href="javascript:void(0);" onclick="Inactive_me('<?php echo $row->Company_id;?>','<?php echo $row->Company_name; ?>','','Company/inactive_company/?Company_id');" data-target="#MakeInactive" data-toggle="modal" title="Make-Inactive"><i class="os-icon os-icon-ui-15"></i></a>
										
									</td>
									<td><?php echo $row->Company_name; ?></td>
									<td><?php echo $row->Company_address;?></td>
									<td><?php echo $row->Company_primary_contact_person;?></td>
									<td><?php echo $row->Company_primary_email_id;?></td>
									<td><?php echo $row->Company_primary_phone_no;?></td>
								</tr>
					<?php 		}
							}	?>
							</tbody>
						</table>
					  </div>
					</div>
				</div>
				<!--------------Table-------------->
				<!--------------Table------------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					<h6 class="form-header">
					 In-Active Companies
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<th>Action</th>
									<th>Company Name</th>
									<th>Company Address</th>
									<th>Pri. Contact Name</th>
									<th>Pri. Email Address</th>
									<th>Pri. Contact No.</th>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<th>Action</th>
									<th>Company Name</th>
									<th>Company Address</th>
									<th>Pri. Contact Name</th>
									<th>Pri. Email Address</th>
									<th>Pri. Contact No.</th>
								</tr>
							</tfoot>
							<tbody>
						<?php
							if($results2 != NULL)
							{
								foreach($results2 as $row)
								{
							?>
								<tr>
									<td class="row-actions">
										<a href="javascript:void(0);" onclick="Active_me('<?php echo $row->Company_id;?>','<?php echo $row->Company_name; ?>','','Company/Active_company/?Company_id');" data-target="#MakeActive" data-toggle="modal" title="Make-Active"><i class="fa fa-check-square-o"></i></a>
									</td>
									<td><?php echo $row->Company_name; ?></td>
									<td><?php echo $row->Company_address;?></td>
									<td><?php echo $row->Company_primary_contact_person;?></td>
									<td><?php echo $row->Company_primary_email_id;?></td>
									<td><?php echo $row->Company_primary_phone_no;?></td>
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
	var top_access = $("input[name=top_access]:checked").val();
	var Joining_bonus = $("input[name=Joining_bonus]:checked").val();
	var Joining_bonus_points=$('#Joining_bonus_points').val();
	var sms_decsion = $("input[name=sms_decsion]:checked").val();
	var white_labels = $("input[name=white_labels]:checked").val();
	var Call_center_flag = $("input[name=Call_center_flag]:checked").val();
	var Beneficiary_flag = $("input[name=Beneficiary_flag]:checked").val();
	var Company_logo = '<?php echo $record->Company_logo; ?>';
	
	var top_access_flag=0;		
	var Joining_bonus_flag=0;		
	var sms_decsion_flag=0;		
	var white_labels_flag=0;	
	var enb_coalition_flag=0;
	var enb_coalition_flag=0;		

	if((Call_center_flag==1) && ( $("#ticketno_series").val() == ""  || $("#ticketno_series").val() == 0 ))
	{
		$('#alert_box').show();			
		$("#alert_box").html('Please enter more than 0 call center ticket number series');
		jQuery("#alert_box").attr("tabindex",-1).focus();
		setTimeout(function(){ $('#alert_box').hide(); }, 4000);
		return false;
	}
	
	if((top_access==1 && $('#amt_deposit').val() != "" && $('#amt_threshold').val() != "") || (top_access==0))
	{
		 top_access_flag=1;
	}
	if((Joining_bonus==1 &&  Joining_bonus_points!= "") || (Joining_bonus==0))
	{

		 Joining_bonus_flag=1;
	}
	if((sms_decsion==1 && $('#sms').val() != "") || (sms_decsion==0))
	{
		 sms_decsion_flag=1;
	}
	if((white_labels==1) || (white_labels==0))
	{
		 white_labels_flag=1;
	}
	if(enb_coalition==1 && $('#Coalition_points_percentage').val() != "" ) 
	{
		 enb_coalition_flag=1;
	}
				  
	if($('#C_user_name').val() != "" && $('#C_password').val() != "" && $('#C_Encryptionkey').val() != "" && $('#cname').val() != "" && $('#country').val() != "" && $('#state').val() != "" && $('#city').val() != "" && $('#caddress').val() != "" && $('#primarycnt').val() != "" && $('#no_of_licensce').val() != "" && $('#redemptionratio').val() != "" && $('#noti_distance').val() != "" && $('#Company_finance_email_id').val() != "" && Company_logo != "" && top_access_flag == 1 && Joining_bonus_flag == 1 && sms_decsion_flag == 1 && enb_coalition_flag== 1)
	{
		if($('#primaryphoneno').val() != "" &&  $('#primaryemailId').val() != "" &&  $('#Evoucher_expiry_period').val() != "") 
		{
			if(white_labels==1 && $("#white_label").val() != "")
			{
				// show_loader();
			}
			if(enb_coalition_flag==1 )
			{
				// show_loader();
			}
			if(white_labels==0)
			{
				// show_loader();
			}
		}
	}
	if(Beneficiary_flag == 1)
	{
		if($('#beneficiary_company').val() == "")
		{
			$('#alert_box').show();			
			$("#alert_box").html('Please Select Beneficiary Company');
			jQuery("#alert_box").attr("tabindex",-1).focus();
			setTimeout(function(){ $('#alert_box').hide(); }, 4000);
			return false;
		}
	}
	
	var btn_class_name = this.className ;
	if(btn_class_name=="btn btn-primary")
	{
		show_loader();
	}
});
function show_url(url_flag)
{
	if(url_flag == 1)
    {	
        $('#Membershipid_redirection').css("display","");  
		
		var coal_points=$('#Coalition_points_percentage').val();
	}
    else
    {
        $('#Membershipid_redirection').css("display","none");  
	}
} 
function make_inactive_company(Company_id,Company_name,flag)
{	
	if(flag==1)
	{
		var url = '<?php echo base_url()?>index.php/Company/inactive_company/?Company_id='+Company_id+'&company_flag=1';
		BootstrapDialog.confirm("Are you sure to In-Activate the Company for '"+Company_name+"' ?", function(result) 
		{
			if (result == true)
			{
				show_loader();
				window.location = url;
				return true;
			}
			else
			{
				return false;
			}
		});
	}
	else
	{
		var url = '<?php echo base_url()?>index.php/Company/inactive_company/?Company_id='+Company_id+'&company_flag=2';
		BootstrapDialog.confirm("Are you sure to Activate the Company for '"+Company_name+"' ?", function(result) 
		{
			if (result == true)
			{
				show_loader();
				window.location = url;
				return true;
			}
			else
			{
				return false;
			}
		});
	}
}
function toggleme11(flag1)
{
	var flags = flag1;
	 
	if(flags == 0)
	{
		$("#amt_deposit").removeAttr("required");
		$("#amt_threshold").removeAttr("required");
		
		document.getElementById('div_company').style.display = "none";
		document.getElementById('div_company2').style.display = "none";
	}
	else
	{
		document.getElementById('div_company').style.display = "";
		document.getElementById('div_company2').style.display = "";
		
		$("#amt_threshold").attr("required","required");
		$("#amt_deposit").attr("required","required");
	}
}
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
function toggle_label_block(flag) 
{		
	if(flag==1)	
	{
		document.getElementById('label_block').style.display = "";
		$("#white_label").attr("required","required");
	}
	else
	{
		document.getElementById('label_block').style.display = "none";
		$("#white_label").removeAttr("required");
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
function toggle_Use_pin_div(Use_pin) 
{
	if(Use_pin==1)	
	{
		document.querySelector('#Otp_div').style.display = "";
		$("#Otp_code_validity").attr("required","required");
	}
	else
	{
		document.querySelector('#Otp_div').style.display = "none";
		$("#Otp_code_validity").removeAttr("required");
	}
}
function enable_ticketno(Tflag) 
{		
	if(Tflag==1)	
	{
		document.getElementById('ticketno_series_div').style.display = "";
		$("#ticketno_series").attr("required","required");
	}
	else
	{
		document.getElementById('ticketno_series_div').style.display = "none";
		$("#ticketno_series").removeAttr("required");
	}
}
function enable_ecommerce_return_policy(Tflag) 
{		
	if(Tflag==1)	
	{
		document.getElementById('eCommerce_return_policy').style.display = "";
		$("#return_policy").attr("required","required");
	}
	else
	{
		document.getElementById('eCommerce_return_policy').style.display = "none";
		$("#return_policy").removeAttr("required");
	}
}
function enable_beneficiary_company(Tflag) 
{		
	if(Tflag==1)	
	{
		document.getElementById('beneficiary_company_div').style.display = "";
		$("#beneficiary_company").attr("required","required");
	}
	else
	{
		document.getElementById('beneficiary_company_div').style.display = "none";
		$("#beneficiary_company").removeAttr("required");
	}
}
	
function toggleme(flag)
{
	var flag = flag;
	//alert(flag);
	if(flag == 0)
	{
		document.getElementById('sms_block').style.display = "none";
		document.getElementById('sms_api_block').style.display = "none";
		document.getElementById('sms_api_auth_block').style.display = "none";
		$("#sms").removeAttr("required");
		$("#sms_api_link").removeAttr("required");
		$("#sms_api_auth_key").removeAttr("required");
	}
	else if(flag == 1)
	{
		document.getElementById('sms_block').style.display = "";
		document.getElementById('sms_api_block').style.display = "";
		document.getElementById('sms_api_auth_block').style.display = "";
		$("#sms").attr("required","required");
		$("#sms_api_link").attr("required","required");
		$("#sms_api_auth_key").attr("required","required");
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
function Show_share_limit(Share_type)
{
    if(Share_type == 0)
    {
        $('#Share_limit_div').css("display","");
        $('#Share_limit').val("0");
        //$('#Share_limit').prop('required', true);
    }
    else
    {
        $('#Share_limit_div').css("display","none");
        $('#Share_limit').val("0");
        //$('#Share_limit').prop('required', false);
    }
}

function show_coalition(coal_flag)
{
	if(coal_flag == 1)
    {		
        $('#Coalition_points').css("display","");  
		$("#Coalition_points_percentage").attr("required","required");
    }
    else
    {
        $('#Coalition_points').css("display","none");  
		$("#Coalition_points_percentage").removeAttr("required");	
    }
}

function show_profile_bonus(profileData)
{
	if(profileData == 1)
    {		
        $('#Bonus_points').css("display","block");  		
		$("#Profile_complete_points").attr("required","required");
    }
    else
    {
        $('#Bonus_points').css("display","none");  
		$("#Profile_complete_points").removeAttr("required");	
    }
}
function show_applogin_bonus(AppData)
{
	if(AppData == 1)
    {		
        $('#app_points').css("display","block");  		
		$("#App_login_points").attr("required","required");
    }
    else
    {
        $('#app_points').css("display","none");  
		$("#App_login_points").removeAttr("required");	
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
function toggle_shipping_charges(flag) 
{		
	if(flag==1)	
	{
		document.getElementById('Shipping_charges_div').style.display = "";
		document.getElementById('Shipping_charges_div1').style.display = "";
		$("#Standard_charges").attr("required","required");
		$("#Cost_Threshold_Limit").attr("required","required");
	}
	else
	{
		document.getElementById('Shipping_charges_div').style.display = "none";
		document.getElementById('Shipping_charges_div1').style.display = "none";
		$("#Standard_charges").removeAttr("required");
		$("#Cost_Threshold_Limit").removeAttr("required");
	}
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
$("#showHide").click(function() 
{
	if ($("#C_password").attr("type") == "password") 
	{
		$("#C_password").attr("type", "text");
	} 
	else 
	{
		$("#C_password").attr("type", "password");
	}
});
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

function Get_license_expiry_date(period) 
{		
	
	if(period==30)
	{	
		<?php $val = date('Y-m-d',strtotime('+30 day'));?> 
		var Expdate = '<?php echo $val;?>'
		$('#period_date').html('Expiry date will be '+Expdate);
	}
	else if(period==60) 
	{	
		<?php $val = date('Y-m-d',strtotime('+60 day'));?> 
		var Expdate = '<?php echo $val;?>'
		$('#period_date').html('Expiry date will be '+Expdate);
	}
	else if(period==90) 
	{	
		<?php $val = date('Y-m-d',strtotime('+90 day'));?> 
		var Expdate = '<?php echo $val;?>'
		$('#period_date').html('Expiry date will be '+Expdate);
	}
	else if(period==365) 
	{	
		<?php $val = date('Y-m-d',strtotime('+365 day'));?> 
		var Expdate = '<?php echo $val;?>'
		$('#period_date').html('Expiry date will be '+Expdate);
	}
	else if(period==730) 
	{	
		<?php $val = date('Y-m-d',strtotime('+730 day'));?> 
		var Expdate = '<?php echo $val;?>'
		$('#period_date').html('Expiry date will be '+Expdate);
	}
	else  
	{	
		<?php $val = date('Y-m-d',strtotime('+1095 day'));?> 
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
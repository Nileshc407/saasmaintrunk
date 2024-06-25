<?php $this->load->view('header/header'); ?>
<script src="<?php echo base_url()?>assets/tinymce/tinymce.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/table/plugin.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/paste/plugin.dev.js"></script>
<script src="<?php echo base_url()?>assets/tinymce/plugins/spellchecker/plugin.dev.js"></script>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-lg-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
			   COMMUNICATION
			  </h6>
			  <div class="element-box">
			
					<!-----------------------------------Flash Messege-------------------------------->

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
						if(@$this->session->flashdata('communication_error_code'))
						{ ?>	
							<div class="alert alert-success alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							  <?php echo $this->session->flashdata('communication_error_code'); ?>
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
					<!-----------------------------------Flash Messege-------------------------------->
				
				<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Administration/communication',$attributes); ?>	
				<div class="row">
				<div class="col-sm-6">					
					<div class="form-group">
						<label for=""><span class="required_info">*</span> Company Name</label>
							<select class="form-control" name="companyId" id="companyId" required >
								<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
							</select>									
					</div>						
					<div class="form-group">
						<label for=""><span class="required_info">*</span> Merchant Name</label>
							<select class="form-control" name="sellerId" id="sellerId" required>
							<option value="">Select Merchant</option>
							<?php
							if($Logged_user_id > 2 || $Super_seller == 1)
							{
								// echo '<option value="0">All Merchant</option>';
								// echo '<option value="'.$enroll.'">'.$LogginUserName.'</option>';
								echo '<option value="'.$enroll.'">'.$LogginUserName.' (Company Admin) '.'</option>';									
							}
							foreach($company_sellers as $sellers)
							{
							?>
								<option value="<?php echo $sellers->Enrollement_id; ?>"><?php echo $sellers->First_name." ".$sellers->Last_name; ?></option>
							<?php
							}
							?>
							</select>
					</div>
					
					<div class="form-group">
						<div class="form-check" >
						<label class="form-check-label">
							<input type="radio" class="form-check-input comm_type" name="r1"   id="r1" value="1" >Create New Communication							
						</label>
						 </div> 
						<div class="form-check" >
						<label class="form-check-label">								
							<input type="radio"  class="form-check-input comm_type" name="r1" id="r2" value="2" >Send Existing Communication
						
						</label>
						 </div> 
						<div class="form-check" >
						<label class="form-check-label">
							
							<input type="radio" name="r1" class="form-check-input comm_type"  id="r3" value="3" >Send Multiple Communication <!-- data-toggle="modal" data-target="#myModal"  -->
						</label>
						 </div> 
						 <div class="help-block form-text with-errors form-control-feedback" id="comm_type" ></div>
					</div>						
					<div id="create_new_offer" >							
						<legend><span>Create New Communication</span></legend>							
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Name of Communication</label>
								<input type="text" name="offer" id="offer_name" class="form-control" placeholder="Name of Communication" />									
							</div>	
							<div class="form-group">
								<label for="">
									<span class="required_info" style="color:red;">*</span> Valid From <span class="required_info" style="color:red;font-size:10px;">(click inside textbox)</span>
								</label>
								<div class="input-group">
									<input type="text" name="start_date" id="datepicker1" class="single-daterange form-control"  required />			
									<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
								</div>
							</div>								
							<div class="form-group">
								<label for="">
									<span class="required_info" style="color:red;">*</span> Valid Till <span class="required_info" style="color:red;">(click inside textbox)</span>
								</label>
								<div class="input-group">
									<input type="text" name="end_date" id="datepicker2" class="single-daterange form-control" required />			
									<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
								</div>
							</div>
							<div class="form-group">
								<label for="">Select Variable</label>
								<select class="form-control" name="Variable" id="Variable" onchange="insert_vaiable(this.value)">
								<option value="">Select Variable</option>
								<?php									
								foreach($Template_variables as $variables)
								{
									?>
										<option value="<?php echo $variables['Code_decode']; ?>"><?php echo $variables['Code_decode']; ?></option>
									<?php
								}
								?>
								</select>									
							</div>								
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Details of Communication</label>
								<textarea cols="80" class="form-control" id="offerdetails1" name="offerdetails" rows="10" ></textarea>
							</div>
							<!---------------------Schedule Communication--------------------------------->
							<div class="form-group">
								<label for="">Communication Related to</label>
								<select class="form-control"  name="Offer_related_to" id="Offer_related_to">
								<option value="">Select Hobbies/Interest</option>
									<?php
										foreach($Hobbies_list as $hob)
										{
											echo "<option value=".$hob->Id.">".$hob->Hobbies."</option>";
										}
									?>
								</select>								
							</div>
							
							<div class="form-group">								
								<label for=""> Share Image <br> <span class="required_info"><i>* Image should be less than 800kb. The Image resolution should be around 600 pixels (H) X 400 pixels (V)</i></span> </label>	<br>
								<div class="upload-btn-wrapper">
								<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
								<input type="file" name="file" id="file" onchange="readURL(this);"/>
								</div>								
								<img id="blah" src="#" class="img-responsive left-block" style="display:none" />		
							</div>
							<!---------------------Birthday Communication--------------------------------->
							<div class="form-group" id="Link_to_birthday_div">
								<div class="row">
									<div class="col-md-6">
										<label for=""> Link to Birthday </label>
									</div>
									<div class="col-md-6">									
										<div class="row">	
											<div class="col-md-3">	
												<label class="form-check-label">
													<input type="radio" name="Birthday_flag" class="form-check-input" id="Birthday_flag" onclick="hide_show_birthday(this.value)" value="1">Yes			
													<!-------hide_show_birthday---------->					
												</label>
											</div>
											<div class="col-md-3">	
												<label class="radio-inline">										
													<input type="radio" name="Birthday_flag"  class="form-check-input" id="Birthday_flag" onclick="hide_show_birthday(this.value)" checked value="0">No									
												</label>
											</div>
										</div>										
									</div>
								</div>
							</div>
							<!---------------------Birthday Communication--------------------------------->
							<!---------------------Schedule Communication--------------------------------->
							<?php if($Company_details->Cron_communication_flag  == 1 ){  ?>
								<div class="form-group" id="schedule_communication_flag">
								
									<div class="row">
										<div class="col-md-6">
											<label for=""> Schedule Communication </label>
										</div>
										<div class="col-md-6">									
											<div class="row">	
												<div class="col-md-3">	
													<label class="form-check-label">
														<input type="radio" class="form-check-input"  name="Schedule_flag" id="Schedule_flag" onclick="hide_show_criteria(this.value)" value="1">Yes								
													</label>
												</div>
												<div class="col-md-3">	
													<label class="form-check-label">										
														<input type="radio" class="form-check-input"  name="Schedule_flag" id="Schedule_flag" onclick="hide_show_criteria(this.value)" value="0" checked >No									
													</label>
												</div>
											</div>										
										</div>
									</div>
									
									
									<!--<label for=""> Schedule Communication </label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<label class="form-check-label">
										<input type="radio" class="form-check-input"  name="Schedule_flag" id="Schedule_flag" <?php //if($Company_details->Cron_communication_flag  == 0 ){echo 'disabled'; } ?> onclick="hide_show_criteria(this.value)" value="1">Yes								
									</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<label class="form-check-label">										
										<input type="radio" class="form-check-input"  name="Schedule_flag" id="Schedule_flag" onclick="hide_show_criteria(this.value)" value="0" checked >No									
									</label>-->								
								</div>
								<div class="form-group" id="Sch_Criteria" style="display:none;">								
											
										<div class="row">	
											<div class="col-md-6">
													<label for=""><span class="required_info">*</span>Schedule Criteria </label>
											</div>
											<div class="col-md-6">
												<div class="row">
													<div class="form-check col-md-12">
														<label class="form-check-label">
															<input type="radio" name="Schedule_criteria" id="Schedule_criteria" onclick="hide_show_schedule(this.value)" class="form-check-input"  value="3">Quarterly								
														</label>
													</div>
													<div class="form-check col-md-12" >
														<label class="form-check-label">										
															<input type="radio" name="Schedule_criteria" id="Schedule_criteria"  onclick="hide_show_schedule(this.value)" class="form-check-input"  value="2">Monthly									
														</label>
													</div>
													<div class="form-check col-md-12" >
														<label class="form-check-label">										
															<input type="radio" name="Schedule_criteria" id="Schedule_criteria" onclick="hide_show_schedule(this.value)" class="form-check-input"  value="1">Weekly									
														</label>
													</div>
													<div class="form-check col-md-12" >
														<label class="form-check-label">										
															<input type="radio" name="Schedule_criteria" id="Schedule_criteria" onclick="hide_show_schedule(this.value)" class="form-check-input"  value="4">Selected Day									
														</label>
													</div>						
												</div>
											</div>
										</div>
									
									<br>
									<div class="form-group" id="Sch_Weekly" style="display:none">
										
										<div class="row">	
											<div class="col-md-5">
												<label for="">Schedule Weekly
													<span class="required_info"><br>(Select starting day)</span> 
												</label>
											</div>
											<div class="col-md-7">
												<div class="row">
													<div class="form-check col-md-12">
														<label class="radio-inline">
															<input type="radio" name="Schedule_weekly" id="Schedule_weekly" value="1">Monday								
														</label>
													</div>
													<div class="form-check col-md-12" >
														<label class="radio-inline">
															<input type="radio" name="Schedule_weekly" id="Schedule_weekly" value="2">Tuesday								
														</label>
													</div>
													<div class="form-check col-md-12" >
														<label class="radio-inline">
															<input type="radio" name="Schedule_weekly" id="Schedule_weekly" value="3">Wednesday								
														</label>
													</div>
													<div class="form-check col-md-12" >
														<label class="radio-inline">
															<input type="radio" name="Schedule_weekly" id="Schedule_weekly" value="4">Thursday								
														</label>
													</div>
													<div class="form-check col-md-12" >
														<label class="radio-inline">
															<input type="radio" name="Schedule_weekly" id="Schedule_weekly" value="5">Friday								
														</label>
													</div>
													<div class="form-check col-md-12" >
														<label class="radio-inline">
															<input type="radio" name="Schedule_weekly" id="Schedule_weekly" value="6">Saturday								
														</label>
													</div>
													<div class="form-check col-md-12" >
														<label class="radio-inline">
															<input type="radio" name="Schedule_weekly" id="Schedule_weekly" value="7">Sunday								
														</label>
													</div>						
												</div>
											</div>
										</div>
									</div>
									<div class="form-group" id="Select_day" style="display:none;">
										<div class="row">
											<div class="col-md-4">
												<label for="">
													<span class="required_info">*</span> Select Day <br><span class="required_info">(* click inside textbox)</span>
												</label>
											</div>
											<div class="col-md-8">									
												<input type="text" name="Select_day_date" id="datepicker3" class="form-control" placeholder="Select Day Date" />	
												<span class="input-group-addon" id="basic-addon23"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>										
											</div>
										</div>
									</div>
							
								</div>	
								
								<!---------------------Schedule Communication--------------------------------->
							<br>
							<?php } ?>
							<!---------------------Schedule Communication--------------------------------->
							
								<div class="form-group" id="Link_to_lbs_div" >								
									<!--<label for=""> Link to LBS </label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<label class="form-check-label">
										<input type="radio" name="Link_to_lbs" class="form-check-input"   id="Link_to_lbs" value="1">Yes								
									</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<label class="radio-inline">										
										<input type="radio" name="Link_to_lbs"  class="form-check-input"  id="Link_to_lbs" checked value="0">No									
									</label>-->	
									
									
									<div class="row">
										<div class="col-md-6">
											<label for=""> Link to LBS </label>
										</div>
										<div class="col-md-6">									
											<div class="row">	
												<div class="col-md-3">	
													<label class="form-check-label">
														<input type="radio" name="Link_to_lbs" class="form-check-input"   id="Link_to_lbs" value="1">Yes								
													</label>
												</div>
												<div class="col-md-3">	
													<label class="radio-inline">										
														<input type="radio" name="Link_to_lbs"  class="form-check-input"  id="Link_to_lbs" checked value="0">No									
													</label>
												</div>
											</div>										
										</div>
									</div>
								</div>
								
								
								<!---------------------Voucher--------------------------------->
									<div class="form-group" id="Link_to_voucher_div">								
										
										<!--<label for=""> Link to Voucher </label>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;
										<label class="form-check-label">
											<input type="radio" name="Link_to_voucher" class="form-check-input"  onclick="hide_show_voucher(1)" id="Link_to_voucher" value="1">Yes								
										</label>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<label class="radio-inline">										
											<input type="radio" name="Link_to_voucher"  class="form-check-input"  id="Link_to_voucher" onclick="hide_show_voucher(0)" checked value="0">No									
										</label> -->
										
										
										<div class="row">
											<div class="col-md-6">
												<label for=""> Link to Voucher </label>
											</div>
											<div class="col-md-6">									
												<div class="row">	
													<div class="col-md-3">	
														<label class="form-check-label">
															<input type="radio" name="Link_to_voucher" class="form-check-input"  onclick="hide_show_voucher(1)" id="Link_to_voucher" value="1">Yes								
														</label>
													</div>
													<div class="col-md-3">	
														<label class="radio-inline">										
															<input type="radio" name="Link_to_voucher"  class="form-check-input"  id="Link_to_voucher" onclick="hide_show_voucher(0)" checked value="0">No									
														</label>
													</div>
												</div>										
											</div>
										</div>
										
										
										
										
										
										
									</div>
									<div class="form-group" id="voucher_type_div">								
										<!--<label for="">Voucher Type </label>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<label class="form-check-label">
											<input type="radio" name="Voucher_type" class="form-check-input"  onclick="hide_show_voucher_type(1);get_vouchers(122);" id="Voucher_type" value="122">Revenue Voucher								
										</label>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<label class="radio-inline">										
											<input type="radio" name="Voucher_type"  class="form-check-input"  id="Voucher_type" onclick="hide_show_voucher_type(0);get_vouchers(123);" value="123">Product Voucher									
										</label>-->
										
										
										<div class="row">
											<div class="col-md-6">
												<label for="">Voucher Type </label>
											</div>
											<div class="col-md-6">									
												<div class="row">	
													<div class="col-md-12">	
														<label class="form-check-label">
															<input type="radio" name="Voucher_type" class="form-check-input"  onclick="hide_show_voucher_type(1);get_vouchers(122);" id="Voucher_type" value="122">Revenue Voucher								
														</label>
													</div>
													<div class="col-md-12">	
														<label class="radio-inline">										
															<input type="radio" name="Voucher_type"  class="form-check-input"  id="Voucher_type" onclick="hide_show_voucher_type(0);get_vouchers(123);" value="123">Product Voucher									
														</label>
													</div>
												</div>										
											</div>
										</div>
										
									</div>
									<div class="form-group" id="Revenue_voucher_div">
										<!--<legend style="color: red;"><span>Revenue Voucher:</span></legend>
										<div class="form-group">								
											<select class="form-control" name="Voucher_id" id="Revenue_voucher">											
											</select>								
										</div> -->
										
											<div class="row">
												<div class="col-md-4">
													<label for="">Revenue Voucher: </label>
												</div>
												<div class="col-md-8">									
													<select class="form-control" name="Voucher_id" id="Revenue_voucher">											
													</select>										
												</div>
											</div>
										
										
									</div>
									<div class="form-group" id="Product_voucher_div">
										<!--<legend style="color: black;"><span>Product Voucher:</span></legend>
										<div class="form-group">								
											<select class="form-control" name="Voucher_id" id="Product_voucher">											
											</select>								
										</div>	-->

										<div class="row">
											<div class="col-md-4">
												<label for="">Product Voucher: </label>
											</div>
											<div class="col-md-8">									
												<select class="form-control" name="Voucher_id" id="Product_voucher">											
												</select>										
											</div>
										</div>
										
									</div>
								<!---------------------Voucher--------------------------------->
								
					</div>
									
					<div class="form-group" id="send_exist_offer">
						<legend><span>Send Existing Communication</span></legend>
						
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Select Active Communication</label>
								<select class="form-control" name="activeoffer" id="activeoffer">
									<option value="">Select Merchant First</option>
								</select>								
							</div>		
									
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Details of Communication</label>
								<textarea class="form-control" rows="4" name="offerdetails1" id="offerdetails" placeholder="Select Offer First" readonly></textarea>
							</div>
						
						
						<div class="form-group">
							<label for="">Social Sharing</label>
							
							<label class="form-check-label" style="margin-left:10px;">
								<input type="checkbox" name="facebook_social" value="1">
								<img src="<?php echo base_url()?>images/facebook.gif" width="50%">
								
							</label>
							
							<label class="form-check-label" style="margin-left:10px;">
								<input type="checkbox" name="twitter_social" value="1">
								<img src="<?php echo base_url()?>images/twitter.gif"  width="50%">
							</label>
							
							<label class="form-check-label" style="margin-left:10px;">
								<input type="checkbox" name="googleplus_social" value="1">
								<img src="<?php echo base_url()?>images/gplus.gif" width="50%">
							</label>
						
							
						
						</div>
						
						
					</div>
						
					<!-- Modal -->
					<div id="myModal1" class="modal fade" role="dialog" style="overflow: scroll;">
						<div class="modal-dialog"  style="margin-top:18%;width: 100%;" width="100%">

						<!-- Modal content-->
							<div class="modal-content" style="width:900px;margin-left:-16%;">
								<div class="modal-header">
									<h5 class="modal-title text-center">Communication</h5>
								</div>
								<div class="modal-body">
									<div class="table" id="show_multiple_offer"></div>
								</div>
								<!--
								<div class="modal-footer">
									<button type="button" id="close_modal" class="btn btn-primary">Save Applied Rule(s)</button>
									<button type="button" id="close_modal12" class="btn btn-primary">Close</button>
								</div>-->
							</div>

						</div>
					</div>						
						
					<div class="form-group" id="multiple_social" style="display:none;">
						<label for="">Social Sharing</label>
						
							<label class="form-check-label" style="margin-left:10px;">
								<input type="checkbox" name="facebook_social1" value="1">
								<img src="<?php echo base_url()?>images/facebook.gif" width="50%">
								
							</label>
							
							<label class="form-check-label" style="margin-left:10px;">
								<input type="checkbox" name="twitter_social1" value="1">
								<img src="<?php echo base_url()?>images/twitter.gif"  width="50%">
							</label>
							
							<label class="form-check-label" style="margin-left:10px;">
								<input type="checkbox" name="googleplus_social1" value="1">
								<img src="<?php echo base_url()?>images/gplus.gif" width="50%">
							</label>
						
					</div>							
						
					<div class="form-group"  id="send_communication_to" style="display:none;">
						
						<label for=""><span class="required_info">* </span>Communication for</label>
						
							<div class="col-sm-6" >
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" type="radio" name="r2" id="r21" value="1">Single Member</label>
							  </div>
							  
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" type="radio" name="r2"  id="r22" value="2">All Members</label>
							  </div> 
							  
							  <div class="form-check"  id="key_sch">
								<label class="form-check-label">
								<input class="form-check-input" type="radio" name="r2"  id="r23" value="3">Key Members</label>
							  </div> 
							  
							  <div class="form-check"  id="worry_sch">
								<label class="form-check-label">
								<input class="form-check-input" type="radio" name="r2"   id="r24" value="4">Worry Members</label>
							  </div> 
							  
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" type="radio" name="r2"  id="r25" value="5">Tier Based Members</label>
							  </div> 
							  
							  <div class="form-check"  id="hobbie" style="display:none;">
								<label class="form-check-label">
								<input class="form-check-input" type="radio" name="r2"  "r26" value="6">Hobbies/Intrested Members</label>
							  </div> 
							  
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" type="radio" name="r2"  id="r27" value="7">Segment Based Members</label>
							  </div> 
							  
							</div>
						
					</div>
												
							
					<div class="panel panel-default" id="send_to_single">
						<legend><span>Send to Single Member</span></legend>
						
							<div class="form-group" id="block1" >
							<label for=""><span class="required_info">*</span> Membership ID</label>
							<input type="text" id="mailtoone_memberid" name="mailtoone_memberid" class="form-control"  placeholder="Enter Membership ID" value="" />								
									
						</div>
					
					
							<div class="form-group" id="Member_details" >
							 <label for=""><b>Enrolled Member Details:</b></label>
								
									<div class="form-group">
										<label for="">Member Name</label>
										<input type="text" name="mailtoone" id="mailtoone" class="form-control" readonly />	
									</div>
									
									<div class="form-group">
										<label for="">Member Email ID</label>
										<input type="text" id="member_email" name="member_email" class="form-control" readonly />	
									</div>
									
									<div class="form-group">
										<label for="">Member Phone No.</label>
										<input type="text" name="mailtoone_phnno" id="mailtoone_phnno" class="form-control"  readonly />	
									</div>
									
									<div class="form-group">
										<input type="hidden" name="Enrollment_id" id="MemberEnrollmentId" value=""/>
									</div>
								
							</div>
				
					</div>
					
					<div class="form-group" id="send_to_all">
						<legend><span>Send to All Members:</span></legend>
							<div class="form-group">								
								<select class="form-control" name="mailtoall">
									<option value="0">All Members</option>
								</select>								
							</div>							
						
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group" id="send_to_key">
								<legend><span>Send to Key Members:</span></legend>
								
									<div class="form-group">								
										<select class="form-control" name="mailtokey" id="mailtokey">
											<option value="">Purchase more than</option>
											<option value="1">2 times in last 3 months</option>
											<option value="2">3 times in last 3 months</option>
											<option value="3">5 times in last 3 months</option>
										</select>								
									</div>
								
							</div>
							<div class="form-group" id="send_to_worry">
								<legend><span>Send to Worry Members:</span></legend>
								
									<div class="form-group">								
										<select class="form-control" name="mailtoworry" id="mailtoworry">
											<option value="">No Purchase in</option>
											<option value="1">last 1 month</option>
											<option value="2">last 2 months</option>
											<option value="3">last 3 months</option>
										</select>							
									</div>
								
							</div>
						</div>
							
						<div class="col-sm-6">	
							<br>
							<div class="form-group" id="key_worry_customers">
								<label for="" id="key_wory_heading">Key / Worry Members</label>:
								
									<div class="form-group">								
										<select multiple class="form-control select2" name="key_worry_cust[]" id="KeyWorryCust">
											<option value="">Choose Members</option>
										</select>								
									</div>
								
							</div>
						</div>
							
					</div>
						
						
						
					<div class="form-group" id="Segment_block" style="display:none;">
						<div class="row">
						<legend><span>Send to Segment Members:</span></legend>
						<div class="col-sm-6">
						<button type="button" name="submit"  id="Segment" class="btn btn-primary" onclick="makeCharts('light','#FFFFFF','');" data-toggle="modal" data-target="#Segment_handeler">Show Segment Handlers</button>
						</div>
							<div class="col-sm-6">								
								<select class="form-control" name="Segment_code" id="Segment_code" onchange="Show_criteria(this.value);">
									<option value="">Select Segment</option>
									<?php										
									foreach($Segments_list as $Segments)
									{
										echo '<option value="'.$Segments->Segment_code.'">'.$Segments->Segment_name.'</option>';
									}
									?>
								</select>
								<br/>
								<div id="Segment_Criteria" style="display:none;">
									<label for="">&nbsp;Segment Criteria</label>
									<textarea class="form-control" rows="3" name="S_Criteria" id="S_Criteria" readonly>
									</textarea>
								</div>
														
							</div>
							</div>
					</div>
					<div class="form-group" id="send_to_tier">
						<legend><span>Send to Tier Members:</span></legend>
						
							<div class="form-group">								
								<select class="form-control" name="mailtotier" id="mailtotier">
									<option value="">Select Tier</option>
									<?php										
									foreach($Tier_list as $Tier)
									{
										echo '<option value="'.$Tier->Tier_id.'">'.$Tier->Tier_name.'</option>';
									}
									?>
								</select>								
							</div>							
						
					</div>
					
					<button type="submit" name="submit" value="Register" id="Register" class="btn btn-primary">Submit</button>								
													
					<button type="submit" name="submit" value="Send" id="Send" class="btn btn-primary">Send</button>								
					<button type="reset" class="btn btn-primary">Reset</button>
					
					<input type="hidden" name="Company_id" value="<?php echo $Company_id; ?>"/>
		
				</div>
				<!---------------------------Communication Preview---------------------------------------------->	
					
					<div class="col-sm-6">
						<div class="element-box">
							<h5 class="form-header"> Communication Preview</h5>
							<div class="panel-body">
								
								<div class="table-responsive">
									<table class="table">
									
										<!--<tr>
											<td style="border: medium none;">
												<img class="fix" src="<?php //echo base_url()?>images/comm.jpg" width="100%" border="0" alt="" />
											</td>
										</tr>
										
										<tr>
											<td style="border: medium none;padding: 0 0 15px 0; font-size: 18px; line-height: 28px; font-weight: bold;color: #153643; font-family: Tahoma;">
												Dear Customer,
											</td>
										</tr>-->
										
										<tr>
											<td style="border: medium none;color: #153643; font-family: Tahoma;font-size: 12px; line-height: 22px;" id="Offer_description"></td>
										</tr>
									
									</table>
								</div>
							</div>						
						</div>						
					</div>	
			<!---------------------------Communication Preview---------XXX------------------------------------->			
					
				</div>	
					
					
				  
				  
				<?php echo form_close(); ?>		  
			  </div>
			  
			</div>
		  </div>
		</div>
		
	</div>


	<!--------------Table------------->
	<div class="content-panel">             
		<div class="element-wrapper">											
			<div class="element-box">
			  <h5 class="form-header">
			  Communication
			  </h5>  
				<span class="required_info">(Please Click on Status Button(Active/Inactive) to Change the Status)</span>	
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
							
							<th class="text-center">Action</th>
							<th class="text-center">Communication</th>
							<th class="text-center">Merchant Name</th>
							<th class="text-center">Scheduled</th>
							
							
							<th class="text-center">Start Date</th>
							<th class="text-center">End Date</th>
							<th class="text-center">Status</th>
							<!--<th class="text-center">Communication Details</th>-->
						</tr>
						
					</thead>						
					
					<tbody>
				<?php
				$todays = date("Y-m-d");
				
				if($results != NULL)
				{
					foreach($results as $row)
					{
						if( ($todays >= $row->From_date) && ($todays <= $row->Till_date) )
						{
							$class = 'style="color:#00b300;"';
						}
						else
						{
							$class = "";
						}
						
						
						$offer_description = substr($row->description, 0, 255);
						
						if($row->Schedule_id == "" || $row->Schedule_id == '0')
						{
							$Schedule='No';
						}
						else
						{
							$Schedule='Yes';
						}					
						
					?>
						<tr>
							
							<td class="row-actions">
								<a href="<?php echo base_url()?>index.php/Administration/edit_communication_offer/?id=<?php echo $row->id;?>&seller_id=<?php echo $row->seller_id;?>" title="Edit">
									<i class="os-icon os-icon-ui-49"></i>
								</a>
								
								<a href="javascript:void(0);" class="danger"   onclick="delete_me('<?php echo $row->id;?>','<?php echo $row->communication_plan;?>','','Administration/delete_communication_offer/?path=Administration/communication&id');" title="Delete"  data-target="#deleteModal" data-toggle="modal" >
									<i class="os-icon os-icon-ui-15"></i>
								</a> 
																
							</td>
							<td><?php echo $row->communication_plan; ?></td>
							<td class="text-center"><?php echo $row->First_name." ".$row->Last_name; ?></td>
							<td class="text-center"><?php echo $Schedule; ?></td>
							
							
							<td <?php echo $class; ?>><?php echo $row->From_date; ?></td>
							<td <?php echo $class; ?>><?php echo $row->Till_date; ?></td>
							<!--<td><?php echo $offer_description; ?></td>-->
							<td class="text-center">
								<a href="<?php echo base_url()?>index.php/Administration/communication_acivate_deactivate/?id=<?php echo $row->id;?>&seller_id=<?php echo $row->seller_id;?>&activate=<?php echo $row->activate;?>" title="Active/Inactive">
									<?php if($row->activate == "yes"){ ?>
										<span class="btn btn-success btn-sm" >Active</span>
									<?php } else { ?>
										<span class="btn btn-danger btn-sm" >Inactive</span>
									<?php } ?>
								</a>								
							</td>
						</tr>
					<?php
					}
				}
				?>		
					</tbody>
				</table>
			  </div>
			</div>
		</div>
	</div> 
	<!--------------Table--------------->




<!----------------Segment Handlers Graph----modal----------------->
	<div class="modal fade" id="Segment_handeler" role="dialog" style="width:90%;height:100%; margin-left: 100px;">
		<div class="modal-dialog">
			<div class="modal-content">
				<!--------Modal header--------->
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="column-title" align="center">Segment Handlers</h4>
				</div>
				<!---------Modal header------------->
				<!-----------Graph Theme----------->
				<div class="row">
					<div class="col-md-2">
						<div class="dropdown">
							<button class="btn btn-defualt dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								Graph Themes
								<span class="glyphicon glyphicon-cog"></span>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
								<li>
									<a href="javascript:void(0);" onclick="makeCharts('light', '#ffffff','');">
										<img width="36" height="35" alt="theme_light" class="attachment-full size-full wp-post-image" src="<?php echo base_url()?>images/dashboard_images/LightTheme.png" kasperskylab_antibanner="on">
										Light
									</a>
								</li>				
								<li>
									<a href="javascript:void(0);" onclick="makeCharts('dark', '#282828','');">
										<img width="36" height="35" alt="theme_dark" class="attachment-full size-full wp-post-image" src="<?php echo base_url()?>images/dashboard_images/DarkTheme.png" kasperskylab_antibanner="on">
										Dark
									</a>
								</li>				
								<li>
									<a href="javascript:void(0);" onclick="makeCharts('chalk', '#282828','<?php echo base_url()?>images/chalk_bg.jpg');">
										<img width="36" height="35" alt="theme_chalk" class="attachment-full size-full wp-post-image" src="<?php echo base_url()?>images/dashboard_images/ChalkTheme.jpg" kasperskylab_antibanner="on">
										Chalk
									</a>
								</li>				
								<li>
									<a href="javascript:void(0);" onclick="makeCharts('patterns', '#ffffff','');">
										<img width="35" height="35" alt="theme_pattern" class="attachment-full size-full wp-post-image" src="<?php echo base_url()?>images/dashboard_images/PatternTheme.jpg" kasperskylab_antibanner="on">
										Pattern
									</a>
								</li>
							</ul>
						</div>
					</div> <!--
					<div class="col-md-2 pull-right">
						<strong>Export to : </strong>
						<a onclick="exportCharts();" href="javascript:void(0);" >
							<img class="img-responsive img-thumbnail" src="<?php echo base_url(); ?>images/pdf.png" width="50" alt="PDF Dump" title="PDF Dump"/>
						</a>
					</div>-->
				</div>
				<!----------Graph Theme------------>
				<!----------modal body------------>
			   <div class="modal-body">
				   <div class="row">
						<div class="col-xs-6">		
							<div class="modal-content">
								<div id="Sex_wise_member_graph" style="width:100%;height:350px;"></div>	
							</div>		  		  
						</div>	
						<div class="col-xs-6">		
							<div class="modal-content">
								<div id="City_wise_member_sex_graph" style="width:100%;height:350px;"></div>	
							</div>
						</div>						
					</div>
					<div class="row">
						<div class="col-xs-6">		
							<div class="modal-content">
								<div id="Age_wise_member_graph" style="width:100%;height:350px;"></div>	
							</div>		  		  
						</div>	
						<div class="col-xs-6">		
							<div class="modal-content">
								<div id="Cumulative_purchase_wise_member_graph" style="width:100%;height:350px;"></div>	
							</div>
						</div>						
					</div>							
				</div><br/>
				<!----------modal body------------>				
			</div>
		</div>
	



	
</div>			
<?php $this->load->view('header/footer'); ?>

<!-- Modal -->
<div id="ImageModal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width: 40%;">

	<!-- Modal content-->
		<div class="modal-content" style="margin-top:10%;">
			<form id="uploadForm" name='upload' action="" enctype="multipart/form-data">
				<div class="modal-header">
					<h4 class="modal-title text-center">Upload Image</h4>
				</div>
				<div class="modal-body">
					<div class="panel panel-default">				
						<div class="panel-body" id="Upload_offer_image">
							<div class="form-group">
								<label for="exampleInputEmail1"><span class="required_info">*</span> Select Image to Upload</label>
								<input type="file" name="file" />								
							</div>
							
							<span class="required_info"><i>* Image should be less than 800kb. The Image resolution should be around 600 pixels (H) X 400 pixels (V)</i></span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="Upload" class="btn btn-primary">Upload</button>
					<button type="button" id="close_modal4" class="btn btn-primary">Close</button>
				</div>
			</form>
		</div>

	</div>
</div>
<!-- Modal -->

<script>	
	tinymce.init(
	{
		
		
		selector: "textarea#offerdetails1",
		theme: "modern",
		height : 250,
		paste_data_images: true,
		convert_urls : false,
		 plugins: [
			" textcolor colorpicker advlist link image lists hr anchor pagebreak fullscreen preview code table"
		], 		
		file_browser_callback: fileBrowserCallBack,
		menubar: false,
		relative_urls: false,
		toolbar1: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | print preview media code | forecolor backcolor emoticons",	//link image |
		toolbar2: " hr | fontselect | fontsizeselect | tablecontrols | table",
		
		
		
		setup : function(editor)
		{
			  editor.on('keyup', function(e) {
				var htmlContent = tinyMCE.activeEditor.getContent();
				$('#Offer_description').html(htmlContent);
				//alert('htmlContent '+htmlContent);
				$('input[name=offerdetails]').val(htmlContent);
			});
		}
	});
	
	function fileBrowserCallBack(field_name, url, type, win)
	{
		$('.mce-window').css("z-index","0");
		$('.modal').css("z-index","9999999");
		$('#ImageModal').show();
		$("#ImageModal").addClass( "in" );	
		$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );	

			
		
	}
	
	$(document).ready(function (e)
	{		
		$("#uploadForm").on('submit',(function(e) 
		{
			
			e.preventDefault();
                        // var mce = window.top.tinyMCE.activeEditor;
			$.ajax(
			{
				url: "<?php echo base_url()?>index.php/Administration/upload_offer_images", // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,        // To send DOMDocument or non processed data file it is set to false
				success: function(data)   // A function to be called if request succeeds
				{
					/* alert(data.image_name);
					alert(data.message); */
					if(data.message == '1')
					{
						$('.mce-window').css("z-index","65536");
						
						$('#ImageModal').hide();
						$("#ImageModal").removeClass( "in" );
						$('.modal-backdrop').remove();
						
							// mce.windowManager.close();
							var Content_to_insert = "<img src='"+data.image_name+"' />";
							//tinyMCE.activeEditor.execCommand("mceInsertContent", true, Content_to_insert);
							
							  $('.mce-placeholder').val(data.image_name);
							  
					}
					else
					{
						return false;
					}
				}
			});
		}));
	});
	/*
	tinymce.init(
	{
		selector: "textarea#offerdetails1",
		theme: "modern",
		height : 250,
		paste_data_images: true,
		convert_urls : false,
		plugins: [
			"advlist link image lists hr anchor pagebreak fullscreen preview code table"
		],
		file_browser_callback: fileBrowserCallBack,
		menubar: false,
		relative_urls: false,
		toolbar1: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | print preview media code | forecolor backcolor emoticons",	//link image |
		
		setup : function(editor)
		{
			  editor.on('keyup', function(e) {
				var htmlContent = tinyMCE.activeEditor.getContent();
				$('#Offer_description').html(htmlContent);
				alert('htmlContent** '+htmlContent);
				$('input[name=offerdetails]').val(htmlContent);
			});
		}
	});*/
	
	tinymce.init(
	{
		selector: "textarea#offerdetails",
		theme: "modern",
		height : 250,
		paste_data_images: true,
		convert_urls : false,
		plugins: [
			
			"advlist link image lists hr anchor pagebreak fullscreen preview code table"
		],
	 
	
		file_browser_callback: fileBrowserCallBack,
		menubar: false,
		relative_urls: false,
		toolbar1: "preview",	
		
		setup : function(editor)
		{
			  editor.on('keyup', function(e) {
				var htmlContent = tinyMCE.activeEditor.getContent();
				$('#Offer_description').html(htmlContent);
				$('input[name=offerdetails1]').val(htmlContent);
			});
		}
	});	
	
</script>




<script>

function insert_vaiable(vaiable){
	// alert("---vaiable----"+vaiable); 	
	 tinymce.activeEditor.execCommand('mceInsertContent', false, vaiable);	
}

$('#Register').click(function()
{
          
	if( ($('input[name=r1]:checked').val() == 1) )
	{
			//var htmlContent = tinyMCE.activeEditor.getContent();

			var htmlContent = tinyMCE.get('offerdetails1').getContent();
			var ContentLength = htmlContent.length;
			
			if( $('#offer_name').val() != "" && $('#datepicker1').val() != "" && $('#datepicker2').val() != "")
			{
				/* alert("-----Schedule_flag-------"+$('input[name=Schedule_flag]:checked').val());
				alert("-----Schedule_criteria-------"+$('input[name=Schedule_criteria]:checked').val());
				alert("-----Schedule_weekly-------"+$('input[name=Schedule_weekly]:checked').val());
				alert("-----Selected Date-------"+$("#datepicker3" ).val()); */
				// alert("-----ContentLength---1----"+ContentLength);				
				if(ContentLength == 0)
				{
					// alert("-----ContentLength----2---"+ContentLength);	
					var Title1 = "Application Information";
					var msg1 = 'Please Enter Offer Details!.';
					runjs(Title1,msg1);
					return false;
				}
				// return false;
				// alert("---Link_to_voucher for----"+$('input[name=Link_to_voucher]:checked').val());
				// return false;
				if(($('input[name=Schedule_flag]:checked').val() == 1))
				{
					// alert("-----Schedule_flag-------"+$('input[name=Schedule_flag]:checked').val());					 
					// if(($('input[name=Schedule_flag]:checked').val() == 1))
					if(($('input[name=Schedule_criteria]').is(":checked") == false))
					{			
						var Title1 = "Application Information";
						var msg1 = 'Please select schedule criteria  !.';
						runjs(Title1,msg1);
						return false;
					}
					if(($('input[name=Schedule_criteria]:checked').val() == 1))
					{
						// alert("-----Schedule_flag---Weekly----"+$('input[name=Schedule_criteria]:checked').val());
						if(($('input[name=Schedule_weekly]').is(":checked") == false))
						{			
							var Title1 = "Application Information";
							var msg1 = 'Please select any one week days !.';
							runjs(Title1,msg1);
							return false;
						}						
					}
					if(($('input[name=Schedule_criteria]:checked').val() == 4))
					{
						// alert("-----Schedule_flag---Select----"+$('input[name=Schedule_criteria]:checked').val());
						// alert("---datepicker3----"+$("#datepicker3" ).val());
						
						if($("#datepicker3" ).val()== "")
						{
							var Title1 = "Application Information";
							var msg1 = 'Please select day date!.';
							runjs(Title1,msg1);
							return false;
						}
					}
					// alert("---Link_to_voucher for----"+$('input[name=Link_to_voucher]:checked').val());
					return false;
					if(($('input[name=Link_to_voucher]:checked').val() == 1)){
						
						alert('Checked');
						return false; 
						/* var Title1 = "Application Information";
						var msg1 = 'Please select communication for !.';
						runjs(Title1,msg1);
						return false; */
					}
					// alert("---Communication for----"+$('input[name=r2]:checked').val()); 
					if(($('input[name=r2]').is(":checked") == false))
					{
						var Title1 = "Application Information";
						var msg1 = 'Please select communication for !.';
						runjs(Title1,msg1);
						return false;
					}
					
					if(($('input[name=r2]').is(":checked") == true))
					{
						if(($('input[name=r2]:checked').val() == 1))
						{
							/* if($("#datepicker3" ).val()== "")
							{
								var Title1 = "Application Information";
								var msg1 = 'Please select day date!.';
								runjs(Title1,msg1);
								return false;
							} */
							if($("#mailtoone_memberid" ).val()== "" || $("#mailtoone_memberid" ).val()== '0')
							{
								var Title1 = "Application Information";
								var msg1 = 'Please enter membership id!.';
								runjs(Title1,msg1);
								return false;
							}
						}
						if(($('input[name=r2]:checked').val() == 5))
						{
							if($("#mailtotier" ).val()== "")
							{
								var Title1 = "Application Information";
								var msg1 = 'Please select Tier !.';
								runjs(Title1,msg1);
								return false;
							}
						}
						if(($('input[name=r2]:checked').val() == 7))
						{
							if($("#Segment_code" ).val()== "")
							{
								var Title1 = "Application Information";
								var msg1 = 'Please select Segment !.';
								runjs(Title1,msg1);
								return false;
							}
						}
					}
					
				}
				else
				{
					show_loader();
				
					return true;
				}
				
			}
			
		}
		else if( ($('input[name=r1]').is(":checked") == false) )
		{
			var Title1 = "Application Information";
			var msg1 = 'Please Select Atleast One Option';
			document.getElementById("comm_type").innerHTML=msg1;
			return false;
		}
});

$(".comm_type").click(function() {
	
	document.getElementById("comm_type").innerHTML='';
})

$('#Send').click(function()
{
	if( $('#companyId').val() != "" && $('#sellerId').val() != "" )
	{
		var r1Value = $('input[name=r1]:checked').val();
		if(r1Value == 2)
		{
			if( $('#activeoffer').val() != "" )
			{
				if( $('input[name=r2]').is(":checked") == true )
				{
					var r2Value = $('input[name=r2]:checked').val();
					if( r2Value == 1 )
					{
						if( $('#mailtoone').val() != "" )
						{
							show_loader();
						}
					}
					if( r2Value == 2 )
					{
						show_loader();
					}
					if( r2Value == 3 )
					{
						if( $('#mailtokey').val() != "" )
						{
							if( $('#KeyWorryCust').val() != null )
							{
								show_loader();
							}
						}
					}
					if( r2Value == 4 )
					{
						if( $('#mailtoworry').val() != "" )
						{
							if( $('#KeyWorryCust').val() != null )
							{
								show_loader();
							}
						}
					}
				}
				else
				{
					var Title2 = "Application Information";
					var msg2 = 'Please Select Atleast One Option from Send Communication To';
					runjs(Title2,msg2);
					return false;
				}
			}
		}
		if(r1Value == 3)
		{
			if( $('input[name=r2]').is(":checked") == true )
			{
				var r2Value = $('input[name=r2]:checked').val();			
				if( r2Value == 1 )
				{
					if( $('#mailtoone').val() != "" )
					{
						show_loader();
					}
				}
				if( r2Value == 2 )
				{
					show_loader();
				}
				if( r2Value == 3 )
				{
					if( $('#mailtokey').val() != "" )
					{
						if( $('#KeyWorryCust').val() != null )
						{
							show_loader();
						}
					}
				}
				if( r2Value == 4 )
				{
					if( $('#mailtoworry').val() != "" )
					{
						if( $('#KeyWorryCust').val() != null )
						{
							show_loader();
						}
					}
				}
			}
			else
			{
				var Title3 = "Application Information";
				var msg3 = 'Please Select Atleast One Option from Send Communication To';
				runjs(Title3,msg3);
				return false;
			}
		}
	}
});

/******************************Show Hide*********************************/
	$('#r1').click(function()
	{
		// alert('---Create New Communication---');
		
		$( "#create_new_offer" ).show();
		$( "#send_exist_offer" ).hide();
		$( "#send_communication_to" ).show();
		// $( "#send_communication_to" ).hide();
		$( "#Send" ).hide();
		$( "#Register" ).show();
		$( "#key_worry_customers" ).hide();
		$("#offer_name").attr("required","required");
		
		$("#datepicker1").attr("required","required");
		$("#datepicker2").attr("required","required");
		//$("#offerdetails1").attr("required","required");
		$("#activeoffer").removeAttr("required");
		$("#KeyWorryCust").removeAttr("required");
		$("#mailtoone").removeAttr("required");
		$( "#send_to_tier" ).hide();
		// $("#r1").attr("required","required");
		// $("#r2").removeAttr("required");
		// $("#r3").removeAttr("required");
		$( "#send_to_single" ).hide();
		$( "#multiple_social" ).hide();
		// $( "#multiple_social" ).show();
		$("#Segment_block").hide();
		document.getElementById('Create').innerHTML = 'Create Communication for!';
	});

	$('#r2').click(function()
	{
		$("#send_exist_offer").show();
		$("#send_communication_to").show();
		$("#Send").show();
		$("#create_new_offer").hide();
		$("#Register").hide();
		$("#key_worry_customers").hide();
		$("#offer_name").removeAttr("required");
		
		$("#datepicker1").removeAttr("required");
		$("#datepicker2").removeAttr("required");
		$("#offerdetails1").removeAttr("required");
		$("#activeoffer").attr("required","required");
		$("#send_to_tier").hide();
		// $("#r1").removeAttr("required");
		// $("#r2").removeAttr("required");
		// $("#r3").attr("required","required");
		// $("#r21").attr("required","required");
		$("#KeyWorryCust").removeAttr("required");
		$("#multiple_social").hide();
		$("#Segment_block").hide();
		document.getElementById('Create').innerHTML = 'Send Communication to!';
	});
	
	$('#r3').click(function()
	{
		$( "#send_exist_offer" ).hide();
		$( "#send_communication_to" ).show();
		$( "#Send" ).show();
		$( "#create_new_offer" ).hide();
		$( "#Register" ).hide();
		$( "#key_worry_customers" ).hide();
		$( "#hobbie" ).hide();
		$("#offer_name").removeAttr("required");
		
		$("#datepicker1").removeAttr("required");
		$("#datepicker2").removeAttr("required");
		$("#offerdetails1").removeAttr("required");
		$("#activeoffer").removeAttr("required");
		$("#KeyWorryCust").removeAttr("required");
		$( "#multiple_social" ).show();
		// $("#r1").attr("required","required");
		// $("#r2").removeAttr("required");
		// $("#r3").removeAttr("required");
		// $("#r21").attr("required","required");
		$( "#send_to_tier" ).hide();
				$("#Segment_block").hide();
		var Seller_id = $("#sellerId").val();
		if(Seller_id == "")
		{
			var Title = "Application Information";
			var msg = 'Please Select Merchant First';
			runjs(Title,msg);
		}
		else
		{
			$.ajax({
				type: "POST",
				data: {Seller_id: Seller_id,Comm_type:0},
				url: "<?php echo base_url()?>index.php/Administration/show_multiple_offers",
				success: function(data)
				{
					$("#show_multiple_offer").html(data.multipleOfferHtml);	
					$('#myModal1').show();
					$("#myModal1").addClass( "in" );	
					$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
				}
			});
		}
	});

	$('#r21').click(function()
	{
		$( "#send_to_single" ).show();
		$( "#send_to_all" ).hide();
		$( "#send_to_key" ).hide();
		$( "#send_to_worry" ).hide();	
		$( "#key_worry_customers" ).hide();
		
		$( "#mailtoone_memberid" ).attr("required","required");
		$( "#mailtoone" ).attr("required","required");
		$( "#mailtokey" ).removeAttr("required");
		$( "#mailtoworry" ).removeAttr("required");
		$("#KeyWorryCust").removeAttr("required");
		
		$( "#send_to_tier" ).hide();
		$("#mailtotier").removeAttr("required");
		$("#Segment_code").removeAttr("required");
				$("#Segment_block").hide();
	});
	
	$('#r22').click(function()
	{
		$( "#send_to_single" ).hide();
		$( "#send_to_all" ).show();
		$( "#send_to_key" ).hide();
		$( "#send_to_worry" ).hide();
		$( "#key_worry_customers" ).hide();
		$( "#mailtoone_memberid" ).removeAttr("required");
		$( "#mailtokey" ).removeAttr("required");
		$( "#mailtoone" ).removeAttr("required");
		$( "#mailtoworry" ).removeAttr("required");
		$("#KeyWorryCust").removeAttr("required");
		$( "#send_to_tier" ).hide();
		$("#mailtotier").removeAttr("required");
		$("#Segment_code").removeAttr("required");
				$("#Segment_block").hide();
	});
	
	$('#r23').click(function()
	{
		$( "#send_to_single" ).hide();
		$( "#send_to_all" ).hide();
		$( "#send_to_key" ).show();
		$( "#send_to_worry" ).hide();
		$( "#mailtoone_memberid" ).removeAttr("required");
		$( "#mailtokey" ).attr("required","required");
		$( "#mailtoone" ).removeAttr("required");
		$( "#mailtoworry" ).removeAttr("required");
		$( "#key_worry_customers" ).show();
		$("#KeyWorryCust").attr("required","required");
		$('#key_wory_heading').html("Key Members");
		$( "#send_to_tier" ).hide();
		$("#mailtotier").removeAttr("required");
		$("#Segment_code").removeAttr("required");
				$("#Segment_block").hide();
	});
	
	$('#r24').click(function()
	{
		$( "#send_to_single" ).hide();
		$( "#send_to_all" ).hide();
		$( "#send_to_key" ).hide();
		$( "#send_to_worry" ).show();
		$( "#mailtoone_memberid" ).removeAttr("required");
		$( "#mailtoworry" ).attr("required","required");
		$( "#mailtoone" ).removeAttr("required");
		$( "#mailtokey" ).removeAttr("required");
		$( "#key_worry_customers" ).show();
		$("#KeyWorryCust").attr("required","required");
		$('#key_wory_heading').html("Worry Members");
		$( "#send_to_tier" ).hide();
		$("#mailtotier").removeAttr("required");
		$("#Segment_code").removeAttr("required");
				$("#Segment_block").hide();
	});
	
	$('#r25').click(function()
	{
		$( "#send_to_single" ).hide();
		$( "#send_to_all" ).hide();
		$( "#send_to_key" ).hide();
		$( "#send_to_worry" ).hide();
		$( "#key_worry_customers" ).hide();
		$( "#mailtoone_memberid" ).removeAttr("required");
		$( "#mailtokey" ).removeAttr("required");
		$( "#mailtoone" ).removeAttr("required");
		$( "#mailtoworry" ).removeAttr("required");
		$("#KeyWorryCust").removeAttr("required");
		$("#Segment_code").removeAttr("required");
		$( "#send_to_tier" ).show();
		$("#mailtotier").attr("required","required");
				$("#Segment_block").hide();
	});
	
	$('#r26').click(function()
	{
		$( "#send_to_single" ).hide();
		$( "#send_to_all" ).hide();
		$( "#send_to_key" ).hide();
		$( "#send_to_worry" ).hide();
		$( "#key_worry_customers" ).hide();
		$( "#mailtoone_memberid" ).removeAttr("required");
		$( "#mailtokey" ).removeAttr("required");
		$( "#mailtoone" ).removeAttr("required");
		$( "#mailtoworry" ).removeAttr("required");
		$("#KeyWorryCust").removeAttr("required");
		$( "#send_to_tier" ).hide();
		$("#mailtotier").removeAttr("required");
		$("#Segment_code").removeAttr("required");
		$("#Segment_block").hide();
	});
	
	$('#r27').click(function()
	{
		$( "#send_to_single" ).hide();
		$( "#send_to_all" ).hide();
		$( "#send_to_key" ).hide();
		$( "#send_to_worry" ).hide();
		$( "#key_worry_customers" ).hide();
		$( "#mailtoone_memberid" ).removeAttr("required");
		$( "#mailtokey" ).removeAttr("required");
		$( "#mailtoone" ).removeAttr("required");
		$( "#mailtoworry" ).removeAttr("required");
		$("#KeyWorryCust").removeAttr("required");
		$("#send_to_tier").hide();
		$("#mailtotier").removeAttr("required");
		$("#Segment_code").attr("required","required");
		$("#Segment_block").show();
	});
	
/******************************Show Hide*********************************/


/********************************Voucher-19-02-2020************************************/
	function hide_show_voucher(vInput) {
		
		if(vInput=='1')
		{
			$("#voucher_type_div").show();
			
		} else  {
			
			$("#voucher_type_div").hide();
			$("#Revenue_voucher_div").hide();
			$("#Product_voucher_div").hide();
		}
	}
	function hide_show_voucher_type(vType) {	
	
		if(vType=='1') {
			
			$("#Revenue_voucher_div").show();
			$("#Product_voucher_div").hide();
			
		} else {
			
			$("#Revenue_voucher_div").hide();
			$("#Product_voucher_div").show();
		}
	}
	function get_vouchers(VoucherType){
		
		console.log(VoucherType);
		
		if(VoucherType)
		{
			$.ajax({
				type: "POST",
				data: {VoucherType: VoucherType,Company_id:'<?php echo $Company_id; ?>'},
				url: "<?php echo base_url()?>index.php/Voucher_creation/Get_voucher_details",
				dataType: 'json',
				success: function(data)
				{ 
					// console.log(data);
					$('#Revenue_voucher').find('option').remove(); 
					$('#Product_voucher').find('option').remove(); 
					$.each(data, function( index, value ) 
					{ 			
						if(value['Voucher_type']==122){
							$('#Revenue_voucher').append('<option value=' + value['Voucher_id'] + '>' + value['Voucher_name'] + '</option>');
						} else if(value['Voucher_type']==123){
						
							$('#Product_voucher').append('<option value=' + value['Voucher_id'] + '>' + value['Voucher_name'] + '</option>');
						}
						
						
					})
						
				}
			});
		}
		/* else
		{
			$("#Segment_Criteria").hide();
		} */
		
	}

/********************************Voucher-19-02-2020************************************/


$(document).ready(function() 
{	
	$( "#create_new_offer" ).hide();
	$( "#send_exist_offer" ).hide();
	$( "#send_communication_to" ).hide();
	$( "#send_to_single" ).hide();
	$( "#send_to_all" ).hide();
	$( "#send_to_key" ).hide();
	$( "#send_to_worry" ).hide();
	$( "#send_to_tier" ).hide();
	$( "#key_worry_customers" ).hide();
	$( "#Send" ).hide();
	$("#mailtoone_phnno").val("");
	$("#mailtoone_memberid").val("");
	
	/********************************Voucher-19-02-2020************************************/		
		$("#voucher_type_div").hide();
		$("#Product_voucher_div").hide();
		$("#Revenue_voucher_div").hide();								
	/********************************Voucher-19-02-2020************************************/
	
	$( "#close_modal" ).click(function(e)
	{
		 var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });

		if(val == "")
		{
			var Title = "Application Information";
			var msg = 'Please Select at least one Communication Offer';
			runjs(Title,msg);
			return false;
		}
		$('#myModal1').hide();
		$("#myModal1").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
	
	$( "#close_modal12" ).click(function(e)
	{
		$('#myModal1').hide();
		$("#myModal1").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
	
	$( "#close_modal3" ).click(function(e)
	{
		$('#ImageModal').hide();
		$("#ImageModal").removeClass( "in" );
		$('.modal-backdrop').remove();
	});
	
	$( "#close_modal4" ).click(function(e)
	{
		$('.mce-window').css("z-index","65536");
                $('#ImageModal').hide();
                $("#ImageModal").removeClass( "in" );
                $('.modal-backdrop').remove();
	});
	
	$('#offer_name').blur(function()
	{
		if( $("#sellerId").val() != "")
		{
			if($("#offer_name").val() == "")
			{
				$("#offer_name").val("");
				has_error(".has-feedback","#glyphicon",".help-block","Please Enter Name of Offer");
			}
			else
			{
				var communication_plan = $("#offer_name").val();
				var Seller_id = $("#sellerId").val();
				$.ajax({
					type: "POST",
					data: {communication_plan: communication_plan, Seller_id: Seller_id},
					url: "<?php echo base_url()?>index.php/Administration/check_communication_offer",
					success: function(data)
					{
						if(data.length == 13)
						{
							$("#offer_name").val("");
							has_error(".has-feedback","#glyphicon",".help-block",data);
						}
						else
						{
							has_success(".has-feedback","#glyphicon",".help-block",data);
						}
						
					}
				});
			}
		}
		else
		{
			$("#offer_name").val(" ");
			has_error(".has-feedback","#glyphicon",".help-block","Please Select Seller First!!");
		}
	});
	
	$('#sellerId').change(function()
	{
		var sellerID = $("#sellerId").val();
		$.ajax({
			type:"POST",
			data:{Seller_id:sellerID,Comm_type:0, Company_id:'<?php echo $Company_id; ?>'},
			url: "<?php echo base_url()?>index.php/Administration/get_communication_offers",
			success: function(data)
			{
				$('#activeoffer').html(data);
			}				
		});
	});
	
	$('#activeoffer').change(function()
	{
		var offerid = $("#activeoffer").val();
		$.ajax({
			type:"POST",
			data:{offerid:offerid},
			dataType: "json",
			url: "<?php echo base_url()?>index.php/Administration/get_offer_details",
			success: function(json)
			{
				// $('#offerdetails').val(data);
				$('#offerdetails').html(json['offer_description']);
				$('#Offer_description').html(json['offer_description']);
				tinyMCE.get('offerdetails').setContent(json['offer_description']);
				tinymce.activeEditor.getBody().setAttribute('contenteditable', false);
				
				if((json['offer_hobbie_id']) > 0)
				{
					$("#hobbie").show();
				}
				else
				{
					$("#hobbie").hide();
				}
			}				
		});
	});
	
	/*********************************Autocomplete***************************************/
		$("#mailtoone").autocomplete({
			source: "<?php echo base_url()?>index.php/Administration/autocomplete_customer_names" // path to the get_birds method
		});
	/*********************************Autocomplete***************************************/
	/*
	$('#mailtoone').blur(function()
	{
		var Cust_name = $("#mailtoone").val();
		var Company_id = '<?php echo $Company_id; ?>';
		if( $("#mailtoone").val() == "")
		{
			$("#mailtoone_phnno").val("");				
			$("#mailtoone_memberid").val("");				
			$("#EnrollmentId").val("");
		}
		else
		{
			$.ajax({
				type: "POST",
				data: {Cust_name: Cust_name, Company_id: Company_id},
				dataType: "json",
				url: "<?php echo base_url()?>index.php/Administration/get_phnno_memberid",
				success: function(json)
				{
					if( (json == "" || json == null) )
					{
						$("#mailtoone").val("");
						$("#mailtoone_phnno").val("");				
						$("#mailtoone_memberid").val("");				
						$("#EnrollmentId").val("");	
					}
					else
					{
						$("#mailtoone_phnno").val(json[0].Phone_no);				
						$("#mailtoone_memberid").val(json[0].Card_id);				
						$("#EnrollmentId").val(json[0].Enrollement_id);				
					}
				}
			});
		}
	});*/
	
	$('#mailtokey').change(function()
	{
		var mailtokey = $("#mailtokey").val();
		var Seller_id = $("#sellerId").val();
		var Company_id = '<?php echo $Company_id; ?>';
		var r2Value = $('input[name=r2]:checked').val();
		$.ajax({
			type:"POST",
			data:{Seller_id:Seller_id, Company_id:Company_id, r2Value:r2Value, mailtokey:mailtokey},
			url: "<?php echo base_url()?>index.php/Administration/get_key_worry_customers",
			success: function(data)
			{
				$('#KeyWorryCust').html(data.get_key_worry_customers);
				$('#key_wory_heading').html("Key Members");
			}				
		});
	});
	
	$('#mailtoworry').change(function()
	{
		var mailtokey = $("#mailtoworry").val();
		var Seller_id = $("#sellerId").val();
		var Company_id = '<?php echo $Company_id; ?>';
		var r2Value = $('input[name=r2]:checked').val();
		$.ajax({
			type:"POST",
			data:{Seller_id:Seller_id, Company_id:Company_id, r2Value:r2Value, mailtokey:mailtokey},
			url: "<?php echo base_url()?>index.php/Administration/get_key_worry_customers",
			success: function(data)
			{
				$('#KeyWorryCust').html(data.get_key_worry_customers);
				$('#key_wory_heading').html("Worry Members");
			}				
		});
	});
	
});

function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
					.css('display','inline')
                    .attr('src', e.target.result)
                    .width(100)
                    .height(100);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
$('#mailtoone_memberid').blur(function()
	{
		if( $("#mailtoone_memberid").val() == "" || $("#mailtoone_memberid").val() == 0 )
		{
			$('#mailtoone_memberid').val('');
			// has_error(".has-feedback","#glyphicon1",".help-block1","Please Enter Membership Card ID..!!");
			has_error("#block1","#glyphicon1","#Membership_help","Please Enter Membership Card ID..!!");
			
			$("#mailtoone").val("");
			$("#member_email").val("");
			$("#mailtoone_phnno").val("");
			$("#MemberEnrollmentId").val("");
		}
		else
		{
			var cardId = $("#mailtoone_memberid").val();
			var Company_id = '<?php echo $Company_id; ?>';
			
			$.ajax({
				  type: "POST",
				  data: {cardid: cardId, Company_id: Company_id},
				  dataType: "json",
				  url: "<?php echo base_url()?>index.php/Transactionc/validate_card_id",
				  success: function(json)
				  {
					  
						if(json['Card_id'] == 0)
						{
							$('#mailtoone_memberid').val('');
							// has_error(".has-feedback","#glyphicon1",".help-block1","Invalid Membership Card ID!");	
							has_error("#block1","#glyphicon1","#Membership_help","Invalid Membership Card ID..!!");
							
							$("#mailtoone").val("");
							$("#member_email").val("");
							$("#mailtoone_phnno").val("");
							$("#MemberEnrollmentId").val("");
						}
						else
						{
							// has_success(".has-feedback","#glyphicon1",".help-block1",data);	
							//has_success("#block1","#glyphicon1","#Membership_help"," ");
							
							var Member_name = json['First_name']+" "+json['Last_name'];
							var Member_email = json['User_email_id'];
							var Member_phn = json['Phone_no'];
							var Member_Enrollement_id = json['Enrollement_id'];
							
							$("#mailtoone").val(Member_name);
							$("#member_email").val(Member_email);
							$("#mailtoone_phnno").val(Member_phn);
							$("#MemberEnrollmentId").val(Member_Enrollement_id);
						}
				  }
			});
		}
	});	
	
/******calender *********/
$(function() 
{
	$( "#datepicker1" ).datepicker({
		 minDate: 0,
		changeMonth: true,
		yearRange: "-80:+10",
		changeYear: true
	});
	
	$( "#datepicker2" ).datepicker({
		 minDate: 0,
		changeMonth: true,
		yearRange: "-80:+10",
		changeYear: true
	});
	
	/* $( "#datepicker3" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+2",
		changeYear: true
	}); */
		
});

$(function () {
     $("#datepicker3").datepicker({
         minDate: 0,
		 changeMonth: true,
		yearRange: "-80:+10",
		changeYear: true

     });
 });
/******calender *********/
function delete_communication_offer(offer_id,seller_id,offerName)
{	
	BootstrapDialog.confirm("Are you sure to Delete the Offer - '"+offerName+"' ?", function(result) 
	{
		var url = '<?php echo base_url()?>index.php/Administration/delete_communication_offer/?id='+offer_id+'&seller_id='+seller_id+'&url=1';
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
function hide_show_birthday(inputVal)
{
	// alert('-birthday-'+inputVal); //Schedule_flag
	if(inputVal==1)
	{
		$("#schedule_communication_flag").hide();
		$("#r23").hide();
		$("#r24").hide();
		$("#key_sch").hide();
		$("#worry_sch").hide();
		$("#hobbie").hide();
		$("#Select_day").hide();
		$("#Sch_Weekly").hide();
		$("#Sch_Criteria").hide();
		$("#send_communication_to").hide();
		$("#Sch_Mothly").show();
		$("#Link_to_lbs_div").hide();
	}
	else
	{
		$("#schedule_communication_flag").show();
		$("#r23").show();
		$("#r24").show();
		$("#key_sch").show();
		$("#worry_sch").show();
		$("#hobbie").show();
		$("#Select_day").hide();
		$("#send_communication_to").show();
		$("#Sch_Weekly").hide();
		$("#Sch_Mothly").hide();
		$("#Sch_Criteria").hide();
		$("#Link_to_lbs_div").show();
	}
}
function hide_show_criteria(inputVal)
{
	// alert('-criteria-'+inputVal); //Schedule_flag
	if(inputVal==1)
	{
		$("#Sch_Criteria").show();
		// $("#r23").hide();
		// $("#r24").hide();
		// $("#key_sch").hide();
		// $("#worry_sch").hide();
		// $("#hobbie").hide();
		// $("#Select_day").hide();
		// $("#Sch_Weekly").hide();
		// $("#send_communication_to").show();
		// $("#Sch_Mothly").show();
		$("#Link_to_lbs_div").hide();
	}
	else
	{
		$("#Sch_Criteria").hide();
		// $("#r23").show();
		// $("#r24").show();
		// $("#key_sch").show();
		// $("#worry_sch").show();
		// $("#hobbie").show();
		// $("#Select_day").hide();
		// $("#send_communication_to").hide();
		// $("#Sch_Weekly").hide();
		// $("#Sch_Mothly").hide();
		$("#Link_to_lbs_div").show();
	}
}
function hide_show_schedule(inputSch)
{
	// alert(inputVal);
	if(inputSch=='1') //weekly
	{
		$("#Sch_Criteria").show();
		// $("#Sch_Mothly").hide();
		$("#Sch_Weekly").show();
		$("#Select_day").hide();
	}
	else if(inputSch=='3') //quaterly
	{
		$("#Sch_Criteria").show();
		// $("#Sch_Mothly").hide();
		$("#Sch_Weekly").hide();
		$("#Select_day").hide();
	}
	else if(inputSch=='2') //monthly
	{
		$("#Sch_Criteria").show();
		// $("#Sch_Mothly").hide();
		$("#Sch_Weekly").hide();
		$("#Select_day").hide();
		
	}
	else
	{
		$("#Sch_Criteria").show();
		// $("#Sch_Mothly").hide();
		$("#Sch_Weekly").hide();
		$("#Select_day").show();
	}
}
function Show_criteria(Segment_id)
{
	if(Segment_id !=0)
	{
		$.ajax({
			type: "POST",
			data: {Segment_id: Segment_id,Company_id:'<?php echo $Company_id; ?>'},
			url: "<?php echo base_url()?>index.php/Administration/Get_Segment_Criteria",
			success: function(data)
			{ 
				$("#Segment_Criteria").show();
				$("#S_Criteria").html(data.Criteria_data);			
			}
		});
	}
	else
	{
		$("#Segment_Criteria").hide();
	}
}
</script>
<!-- ************************************AM Graph************************************* -->
<script src="<?php echo base_url()?>amcharts/amcharts.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>amcharts/serial.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>amcharts/plugins/dataloader/dataloader.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/themes/light.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/themes/dark.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/themes/chalk.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/themes/black.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/themes/patterns.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>amcharts/plugins/export/export.js"></script>
<script src="<?php echo base_url()?>amcharts/pie.js" type="text/javascript"></script>
<!-- ************************************AM Graph************************************* -->
<!---------------------Map-----------------
<!--<script src="https://www.amcharts.com/lib/3/ammap.js"></script>
<script src="https://www.amcharts.com/lib/3/maps/js/worldLow.js"></script>
<script src="https://www.amcharts.com/lib/3/maps/js/continentsLow.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<script type="text/javascript">
-----------------Map-------------------->
<script type="text/javascript">	
	/* 
// makeCharts("light", "#FFFFFF","");	
function makeCharts(theme, bgColor, bgImage)
{ 
	// sow_segment_handlers	
	var Company_id='<?php echo $Company_id;?>';	
	var chart1;
	var chart2;
	var chart3;
	var chart4;
	var chart5;

	chart1 = AmCharts.makeChart("Sex_wise_member_graph",
	{ 
		type: "pie",
		startDuration: 1,
		addClassNames: true,
		theme: theme,
		titles: [{
			text: "Male Vs Female Vs Other Members",
			size: 12
		}],
		legend:{
			position:"bottom",
			autoMargins:true,
			equalWidths:true,
			markerType: "circle",
			horizontalGap:"20"
		},
		radius: "28%",			
		defs: {
			filter: [{
				id: "shadow",
				width: "200%",
				height: "200%",
				feOffset: {
				result: "offOut",
				"in": "SourceAlpha",
				dx: 0,
				dy: 0
			},
			feGaussianBlur: {
				result: "blurOut",
				"in": "offOut",
				stdDeviation: 5
			},
			feBlend: {
				"in": "SourceGraphic",
				"in2": "blurOut",
				"mode": "normal"
			}
			}]
		},			
		dataProvider: <?php echo $Chart_data1; ?>,
		valueField: "value1",
		titleField: "category",
		backgroundAlpha:"1",
		
		balloon: {
			adjustBorderColor: false,
			horizontalPadding: 10,
			verticalPadding: 8
		},
		
		balloonText: "<span style='font-size:12px;'>[[category]]:<br><span style='font-size:20px;'>[[value1]]</span> </span>",			
		depth3D: 10,
		angle: 30			
	});	
	
	var chart2 = AmCharts.makeChart("City_wise_member_sex_graph", 
	{
		"type": "serial",
		theme: theme,
		titles: [{
		text: "Distribution of Customer Profile Gender Wise",
		size: 12
		}],
		"legend": {
			"autoMargins": false,
			"borderAlpha": 0.2,
			"equalWidths": false,
			"horizontalGap": 10,
			"markerSize": 10,
			"useGraphSettings": true,
			"valueAlign": "left",
			"valueWidth": 0
		},
		"dataProvider": <?php echo $Chart_data2; ?>,
		"valueAxes": [{
			"stackType": "100%",
			"axisAlpha": 0,
			"gridAlpha": 0,
			"labelsEnabled": false,
			"position": "left"
		}],
		"graphs": [{
			"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
			"fillAlphas": 0.9,
			"fontSize": 11,
			"labelText": "[[percents]]%",
			"lineAlpha": 0.5,
			"title": "Male Members",
			"type": "column",
			"valueField": "MaleMember"
		}, {
			"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
			"fillAlphas": 0.9,
			"fontSize": 11,
			"labelText": "[[percents]]%",
			"lineAlpha": 0.5,
			"title": "Female Members",
			"type": "column",
			"valueField": "FemaleMember"
		}, {
			"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
			"fillAlphas": 0.9,
			"fontSize": 11,
			"labelText": "[[percents]]%",
			"lineAlpha": 0.5,
			"title": "Not Mentioned Members",
			"type": "column",
			"valueField": "OtherMember"
		}],
		"marginTop": 30,
		"marginRight": 0,
		"marginLeft": 0,
		"marginBottom": 40,
		"autoMargins": false,
		"categoryField": "City",
		"categoryAxis": {
		"gridPosition": "start",
		"axisAlpha": 0,
		"gridAlpha": 0
		}
	});
	
	var chart3 = AmCharts.makeChart("Age_wise_member_graph", 
	{
		"type": "serial",
		theme: theme,
		titles: [{
		text: "Distribution of Customer Profile Age Wise",
		size: 12
		}],
		"legend": {
			"autoMargins": false,
			"borderAlpha": 0.2,
			"equalWidths": false,
			"horizontalGap": 10,
			"markerSize": 10,
			"useGraphSettings": true,
			"valueAlign": "left",
			"valueWidth": 0
		},
		"dataProvider": <?php echo $Chart_data3; ?>,
		"valueAxes": [{
			"stackType": "100%",
			"axisAlpha": 0,
			"gridAlpha": 0,
			"labelsEnabled": false,
			"position": "left"
		}],
		"graphs": [{
			"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
			"fillAlphas": 0.9,
			"fontSize": 11,
			"labelText": "[[percents]]%",
			"lineAlpha": 0.5,
			"title": "Young Members(15-30 yrs)",
			"type": "column",
			"valueField": "YoungMember"
		}, {
			"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
			"fillAlphas": 0.9,
			"fontSize": 11,
			"labelText": "[[percents]]%",
			"lineAlpha": 0.5,
			"title": "Middle Age Members(31-45 yrs)",
			"type": "column",
			"valueField": "MiddleAgeMember"
		}, {
			"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
			"fillAlphas": 0.9,
			"fontSize": 11,
			"labelText": "[[percents]]%",
			"lineAlpha": 0.5,
			"title": "Senior Members(46-60 yrs)",
			"type": "column",
			"valueField": "SeniorMember"
		}, {
			"balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
			"fillAlphas": 0.9,
			"fontSize": 11,
			"labelText": "[[percents]]%",
			"lineAlpha": 0.5,
			"title": "Old Age Members(>60 yrs)",
			"type": "column",
			"valueField": "OldMember"
		}],
		"marginTop": 30,
		"marginRight": 0,
		"marginLeft": 0,
		"marginBottom": 40,
		"autoMargins": false,
		"categoryField": "City",
		"categoryAxis": {
		"gridPosition": "start",
		"axisAlpha": 0,
		"gridAlpha": 0
		}
	});
	
}

function exportCharts() 
{
	 // alert('Export');
	var images = [];
	var pending = AmCharts.charts.length;
	for ( var i = 0; i < AmCharts.charts.length; i++ ) 
	{
		var chart = AmCharts.charts[ i ];		
		chart.export.capture( {}, function() {
		this.toJPG( {}, function( data ) {
			images.push( {
				"image": data,
				"fit": [ 523.28, 769.89 ]
			} );
			pending--;
			if ( pending === 0 ) 
			{
				// all done - construct PDF
				chart.export.toPDF( {
					content: images
				}, function( data ) {
					this.download( data, "application/pdf", "<?php echo $Graph_name; ?>" );
				} );
			}
      } );
    } );
  }
} */
</script>
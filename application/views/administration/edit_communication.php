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
					<?php } 
					
						foreach($Offer_details as $offer)
						{
							$communication_id = $offer->id;
							$communication_plan = $offer->communication_plan;
							$Comm_type = $offer->Comm_type;
							$communication_seller_id = $offer->seller_id;
							$Hobbie_id = $offer->Hobbie_id;
							$Link_to_lbs = $offer->Link_to_lbs;
							$communication_description = $offer->description;
							$Schedule_flag = $offer->Schedule_flag;
							$Schedule_criteria = $offer->Schedule_criteria;
							$Schedule_criteria_value = $offer->Schedule_criteria_value;
							$Schedule_comm_for = $offer->Schedule_comm_for;
							$Custom_date = $offer->Custom_date;
							$Membership_id = $offer->Membership_id;
							$Schedule_comm_value = $offer->Schedule_comm_value;
							$From_date = date("d M Y",strtotime($offer->From_date));
							$Till_date = date("d M Y",strtotime($offer->Till_date));
							$Facebook = $offer->Facebook;
							$Twitter = $offer->Twitter;
							$Google = $offer->Google;
							$Share_file_path = $offer->Share_file_path;
							$Share_description = $offer->Share_description;
							$Link_to_voucher = $offer->Link_to_voucher;
							$Voucher_type = $offer->Voucher_type;
							$Voucher_id = $offer->Voucher_id;
							$Voucher_name = $offer->Voucher_name;
							$Birthday_flag = $offer->Birthday_flag;
							$Employee_flag = $offer->Employee_flag;
							$Parent_id = $offer->Parent_id;
							$Tier_id = $offer->Tier_id;
							$Segment_code = $offer->Segment_code;
						}	
						$Business_tier_members=$Schedule_members;
						$Employee=$Schedule_members;
						$Residents=$Schedule_members;
						$All_members=$Schedule_members;
						//echo"---Birthday_flag---".$Birthday_flag."---<br>";
					?>
					<!-----------------------------------Flash Messege-------------------------------->
				<?php if($Company_details->Cron_communication_flag  == 0 && $Comm_schedule == '1')
			{
			?>
				
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
				  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
				  <span aria-hidden="true"> &times;</span></button>
				  <span>Please ensure that the Scheduled Communication Flag  is Enabled at the Company to this change effected. Currently it is Disabled. Please contact the Company Admin to make the necessary change</span>
				</div>
			<?php
			}
			?>
				<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Administration/update_communication',$attributes); ?>	
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
								<?php
								if($Logged_user_id > 2 || $Super_seller == 1)
								{
									echo '<option value="'.$enroll.'">'.$LogginUserName.' (Company Admin) '.'</option>';								
								}
								foreach($company_sellers as $sellers)
								{
									if($communication_seller_id == $sellers->Enrollement_id)
									{
									?>
										<option selected value="<?php echo $sellers->Enrollement_id; ?>"><?php echo $sellers->First_name." ".$sellers->Last_name; ?></option>
									<?php
									}
									else
									{
										?>
										<option value="<?php echo $sellers->Enrollement_id; ?>"><?php echo $sellers->First_name." ".$sellers->Last_name; ?></option>
										<?php
									}
								}
								?>
								</select>
						</div>
						
						<div class="form-group" style="display:none;">
							<div class="form-check" >
							<label class="form-check-label">
								<input type="radio" name="r1" checked class="form-check-input"  id="r1" value="1" >Create New Communication							
							</label>
							 </div> 
							<div class="form-check" >
							<label class="form-check-label">								
								<input type="radio"  class="form-check-input" name="r1" id="r2" value="2" >Send Existing Communication
							
							</label>
							 </div> 
							<div class="form-check" >
							<label class="form-check-label">
								
								<input type="radio" name="r1" class="form-check-input"  id="r3" value="3" >Send Multiple Communication <!-- data-toggle="modal" data-target="#myModal"  -->
							</label>
							 </div> 
						</div>
						
					<div id="create_new_offer">
							
							<legend><span>Create New Communication</span></legend>
							
								<div class="form-group">
									<label for=""><span class="required_info">*</span> Name of Communication</label>
									<input type="text" name="offer" id="offer_name" class="form-control" placeholder="Name of Communication"  value="<?php echo $communication_plan; ?>" />
								
								</div>								
							
					
								
								
								
							  <div class="form-group">
									<label for="">
										<span class="required_info" style="color:red;">*</span> Valid From <span class="required_info" style="color:red;font-size:10px;">(click inside textbox)</span>
									</label>
									<div class="input-group">
										<input type="text" name="start_date" id="datepicker1" class="single-daterange form-control"  required   value="<?php echo date('m/d/Y',strtotime($From_date)) ?>"  />			
										<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
									</div>
								</div>
								
								<div class="form-group">
									<label for="">
										<span class="required_info" style="color:red;">*</span> Valid Till <span class="required_info" style="color:red;">(click inside textbox)</span>
									</label>
									<div class="input-group">
										<input type="text" name="end_date" id="datepicker2" class="single-daterange form-control" required    value="<?php echo date('m/d/Y',strtotime($Till_date)) ?>" />			
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
									
									
										
										<textarea cols="80" class="form-control" id="offerdetails1" name="offerdetails" rows="10" ><?php echo $communication_description; ?> </textarea>
									  
									 
								</div>
								<!---------------------Schedule Communication--------------------------------->
								<div class="form-group">
								<label for="">Communication Related to</label>
								<select class="form-control"  name="Offer_related_to" id="Offer_related_to">
									<option value="">Select Hobbies/Interest</option>
								<?php
								
									foreach($Hobbies_list as $hob)
									{
										if($Hobbie_id == $hob->Id)
										{
											echo "<option selected value=".$hob->Id.">".$hob->Hobbies."</option>";
										}
										else
										{
											echo "<option value=".$hob->Id.">".$hob->Hobbies."</option>";
										}
									}
								?>	
									
									
								</select>								
							</div>
							<?php /* ?>
								<div class="form-group">								
									<label for=""> Share Image <br> <span class="required_info"><i>* Image should be less than 800kb. The Image resolution should be around 600 pixels (H) X 400 pixels (V)</i></span> </label><br>
									<div class="upload-btn-wrapper">
								<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
								<input type="file" name="file" id="file" onchange="readURL(this);"/>
								</div>
								
											
									<?php 
									
									
									if($Share_file_path == "")
									{ ?>
										<img id="blah" src="#" class="img-responsive left-block" style="display:none" />
										<!--<img src="<?php //echo $Share_file_path; ?>" class="img-responsive center-block" alt="Share Image" style="width:80% !important">
										
										<img src="<?php //echo base_url().$Company_details->Company_logo; ?>" class="img-responsive center-block" alt="Share Image" style="width:80% !important">-->
									<?php 
									}
									else 
									{
										 //echo"---Share_file_path--edit-".$Share_file_path."<br>";
									?>
										<img  id="blah" src="<?php echo $Share_file_path; ?>" class="img-responsive center-block" alt="Share Image" style="width:25% !important">
										
									<?php 
									} 
									?>
									<input type="hidden" name="Share_file_path" value="<?php echo $Share_file_path; ?>" class="form-control" />
								</div>
								<?php */ ?>
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
														<input type="radio" name="Birthday_flag" class="form-check-input" id="Birthday_flag" onclick="hide_show_birthday(this.value)" <?php if($Birthday_flag  == 1 ){echo "checked";}else{echo "disabled";}?> value="1">Yes			
														<!-------hide_show_birthday---------->					
													</label>
												</div>
												<div class="col-md-3">	
													<label class="radio-inline">										
														<input type="radio" name="Birthday_flag"  class="form-check-input" id="Birthday_flag" onclick="hide_show_birthday(this.value)" <?php if($Birthday_flag  == 0 ) {echo "checked";}else{echo "disabled";}?> value="0">No									
													</label>
												</div>
											</div>										
										</div>
									</div>
								</div>
								<!---------------------Birthday Communication--------------------------------->
								<?php if($Company_details->Cron_communication_flag  == 1 ){?>
								<div class="form-group"  <?php if($Birthday_flag  == 1 ){echo 'style="display:none;"';}?>  id="schedule_communication_flag">								
									<div class="row">
										<div class="col-md-6">
											<label for=""> Schedule Communication </label>
										</div>
										<div class="col-md-6">									
											<div class="row">	
												<div class="col-md-3">	
													<label class="form-check-label">
														<input type="radio" name="Schedule_flag" class="form-check-input" id="Schedule_flag"onclick="hide_show_criteria(this.value)" <?php if($Schedule_flag  == 1 ){echo "checked";}else{echo "disabled";}?> value="1">Yes			
														<!-------hide_show_birthday---------->					
													</label>
												</div>
												<div class="col-md-3">	
													<label class="radio-inline">										
														<input type="radio" name="Schedule_flag"  class="form-check-input" id="Schedule_flag" onclick="hide_show_criteria(this.value)" <?php if($Schedule_flag  == 0 ) {echo "checked";}else{echo "disabled";}?> value="0">No									
													</label>
												</div>
											</div>										
										</div>
									</div>							
								</div>
								<?php  } ?>
								
								
								
								<div class="form-group" id="Sch_Criteria"  <?php if($Schedule_criteria ==0 ){echo 'style="display:none;"'; } ?>  >	
									<div class="row">	
									<div class="col-md-6">
													<label for=""><span class="required_info">*</span>Schedule Criteria </label>
											</div>
									<div class="col-md-6" >
										<div class="row">	
												<div class="col-md-6">	
									 <label class="radio-inline">
											<input type="radio" name="Schedule_criteria" id="Schedule_criteria" onclick="hide_show_schedule(this.value)" class="form-check-input"  value="3" <?php if($Schedule_criteria==3){echo "checked";}else{echo "disabled";}?> >Quarterly								
										</label>
										
										<label class="radio-inline">									
											<input type="radio" name="Schedule_criteria" id="Schedule_criteria"  onclick="hide_show_schedule(this.value)" class="form-check-input"  value="2" <?php if($Schedule_criteria==2){echo "checked";}else{echo "disabled";}?> >Monthly									
										</label>
										
										<label class="radio-inline">								
											<input type="radio" name="Schedule_criteria" id="Schedule_criteria" onclick="hide_show_schedule(this.value)" class="form-check-input"  value="1" <?php if($Schedule_criteria==1){echo "checked";}else{echo "disabled";}?> >Weekly									
										</label>
										
										<label class="radio-inline">									
											<input type="radio" name="Schedule_criteria" id="Schedule_criteria" onclick="hide_show_schedule(this.value)" class="form-check-input"  value="4" <?php if($Schedule_criteria==4){echo "checked";}else{echo "disabled";}?> >Selected Day									
										</label>
													
									</div>						
									</div>						
								</div>
								</div>
								<div class="form-group" id="Sch_Weekly"  <?php if($Schedule_criteria !=1){echo 'style="display:none;"'; } ?> >								
									<label for="">Schedule Weekly<span class="required_info">&nbsp;&nbsp;(Select starting day)</span> </label><br>
									<label class="radio-inline" style="margin-left: 10px;">
										<input type="radio" name="Schedule_weekly" id="Schedule_weekly" value="1" <?php if($Schedule_criteria_value==1){echo "checked";}else{echo "disabled";}?>>Monday								
									</label>
									<label class="radio-inline">
										<input type="radio" name="Schedule_weekly" id="Schedule_weekly" value="2"<?php if($Schedule_criteria_value==2){echo "checked";}else{echo "disabled";}?>>Tuesday								
									</label>
									<label class="radio-inline">
										<input type="radio" name="Schedule_weekly" id="Schedule_weekly" value="3"<?php if($Schedule_criteria_value==3){echo "checked";}else{echo "disabled";}?>>Wednesday								
									</label>
									<label class="radio-inline">
										<input type="radio" name="Schedule_weekly" id="Schedule_weekly" value="4"<?php if($Schedule_criteria_value==4){echo "checked";}else{echo "disabled";}?>>Thursday								
									</label>
									<label class="radio-inline">
										<input type="radio" name="Schedule_weekly" id="Schedule_weekly" value="5"<?php if($Schedule_criteria_value==5){echo "checked";}?>>Friday								
									</label>
									<label class="radio-inline">
										<input type="radio" name="Schedule_weekly" id="Schedule_weekly" value="6"<?php if($Schedule_criteria_value==6){echo "checked";}?>>Saturday								
									</label>
									<label class="radio-inline">
										<input type="radio" name="Schedule_weekly" id="Schedule_weekly" value="7"<?php if($Schedule_criteria_value==7){echo "checked";}else{echo "disabled";}?>>Sunday								
									</label>			
								</div>
								<div class="form-group" id="Select_day"    <?php if($Schedule_criteria !=4){echo 'style="display:none;"'; } ?>  >
									<label for="">
										<span class="required_info">*</span> Select Day <span class="required_info">(* click inside textbox)</span>
									</label>
									<div class="input-group">
										<input type="text" name="Select_day_date" id="datepicker3" class="form-control" placeholder="Select Day Date" value="<?php echo date('Y-m-d',strtotime($Custom_date)); ?>" />	
										<span class="input-group-addon" id="basic-addon23"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>										
										
									</div>
								</div>
								<!---------------------Schedule Communication--------------------------------->
								</div>		
								
									<!---------------------Voucher--------------------------------->
									<?php 
										$Link_to_voucher = $offer->Link_to_voucher;
										$Voucher_type = $offer->Voucher_type;
										$Voucher_id = $offer->Voucher_id;
										$Voucher_name = $offer->Voucher_name;
										
										/* echo"---Link_to_voucher--".$Link_to_voucher."---<br>";
										echo"---Voucher_type--".$Voucher_type."---<br>";
										echo"---Voucher_id--".$Voucher_id."---<br>";
										echo"---Voucher_name--".$Voucher_name."---<br>"; */
									
									?>
									<div class="form-group" id="Link_to_voucher_div">	
									<div class="row">
										<div class="col-md-6">
											<label for=""> Link to Voucher </label>
										</div>
										<div class="col-md-6">									
											<div class="row">	
												<div class="col-md-3">	
													<label class="form-check-label">
														<input type="radio" name="Link_to_voucher" class="form-check-input" id="Link_to_voucher" onclick="hide_show_voucher(1)" <?php if($Link_to_voucher  == 1 ){echo "checked";}else{echo "disabled";}?> value="1">Yes			
														<!-------hide_show_birthday---------->					
													</label>
												</div>
												<div class="col-md-3">	
													<label class="radio-inline">										
														<input type="radio" name="Link_to_voucher"  class="form-check-input" id="Link_to_voucher" onclick="hide_show_voucher(0)"  <?php if($Link_to_voucher  == 0 ) {echo "checked";}else{echo "disabled";}?> value="0">No									
													</label>
												</div>
											</div>										
										</div>
									</div>
									</div>
									<div class="form-group" id="voucher_type_div">			<div class="row">
										<div class="col-md-3">
											<label for=""> Voucher Type </label>
										</div>
										<div class="col-md-9">									
											<div class="row">	
												<div class="col-md-3">	
													<label class="form-check-label">
											<input type="radio" name="Voucher_type" readonly class="form-check-input"  onclick="hide_show_voucher_type(1);get_vouchers(1);" id="Voucher_type" value="1" <?php if($Voucher_type==1){echo "checked";}else{echo "disabled";} ?> >Revenue Voucher								
										</label>
												</div>
												<div class="col-md-3">	
													<label class="radio-inline">										
											<input type="radio" name="Voucher_type"  readonly class="form-check-input"  id="Voucher_type" onclick="hide_show_voucher_type(0);get_vouchers(2);" value="2" <?php if($Voucher_type==2){echo "checked";}else{echo "disabled";} ?>>Product Voucher									
										</label>
												</div>
												<div class="col-md-3">	
													<label class="radio-inline">										
											<input type="radio" name="Voucher_type" readonly  class="form-check-input"  id="Voucher_type" onclick="hide_show_voucher_type(0);get_vouchers(3);" value="3" <?php if($Voucher_type==3){echo "checked";}else{echo "disabled";} ?>>Discount Voucher									
										</label>
												</div>
											</div>										
										</div>
									</div>
									</div>
									
									<?php if($Voucher_type==1){  ?>
									<div class="form-group" id="Revenue_voucher_div">
									
										<label for="">Revenue Voucher: </label>
										<div class="form-group">								
											<select class="form-control" name="Voucher_id" id="Revenue_voucher" readonly>
												<option value="<?php echo $Voucher_id; ?>"><?php echo $Voucher_name; ?></option>
											</select>								
										</div>
									</div>
									<?php }  ?>
									<?php if($Voucher_type==2){  ?>
									<div class="form-group" id="Product_voucher_div">
										<label for="">Product Voucher: </label>
										<div class="form-group">								
											<select class="form-control" name="Voucher_id" id="Product_voucher" readonly>
												<option value="<?php echo $Voucher_id; ?>"><?php echo $Voucher_name; ?></option>
											</select>								
										</div>
									</div>
									<?php } ?>
									<?php if($Voucher_type==3){  ?>
									<div class="form-group" id="Product_voucher_div">
										<label for="">Discount Voucher: </label>
										<div class="form-group" readonly>								
											<select class="form-control" name="Voucher_id" id="Discount_voucher">
												<option value="<?php echo $Voucher_id; ?>"><?php echo $Voucher_name; ?></option>
											</select>								
										</div>
									</div>
									<?php }  ?>
									
									
								<!---------------------Voucher--------------------------------->
									
						</div>
									
						<div class="form-group" id="send_exist_offer" style="display:none;">
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
							
							
							<!--01-06-2022----<div class="form-group" id="multiple_social" style="display:none;">
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
							
								
							
							</div>-->
							
							
						</div>
						
						<!-- Modal -->
						<div id="myModal1" class="modal fade" role="dialog">
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
						<!----style="display:none;" ---->
						<div class="form-group" id="multiple_social"  >
							<label for="">Social Sharing</label>
							
								<label class="form-check-label" style="margin-left:10px;">
									<input type="checkbox" name="facebook_social1" value="1" <?php if($Facebook == 1){echo 'checked'; } ?> onclick="hide_show_socila_image_div(1);">
									<img src="<?php echo base_url()?>images/facebook.gif" width="50%">
									
								</label>
								
								<label class="form-check-label" style="margin-left:10px;">
									<input type="checkbox" name="twitter_social1" value="1" <?php if($Twitter == 1){echo 'checked'; } ?> onclick="hide_show_socila_image_div(1);" >
									<img src="<?php echo base_url()?>images/twitter.gif"  width="50%" onclick="hide_show_socila_image_div(1);">
								</label>
								
								<label class="form-check-label" style="margin-left:10px;">
									<input type="checkbox" name="googleplus_social1" value="1"  <?php if($Google == 1){echo 'checked'; } ?> onclick="hide_show_socila_image_div(1);" >
									<img src="<?php echo base_url()?>images/gplus.gif" width="50%">
								</label>
							
						</div>
						
						<div class="form-group" id="share_image_div" >								
									<label for=""> Share Image <br> <span class="required_info"><i>* Image should be less than 800kb. The Image resolution should be around 600 pixels (H) X 400 pixels (V)</i></span> </label><br>
									<div class="upload-btn-wrapper">
								<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
								<input type="file" name="file" id="file" onchange="readURL(this);"/>
								</div>
								
											
									<?php 
									
									
									if($Share_file_path == "")
									{ ?>
										<img id="blah" src="#" class="img-responsive left-block" style="display:none" />
										<!--<img src="<?php //echo $Share_file_path; ?>" class="img-responsive center-block" alt="Share Image" style="width:80% !important">
										
										<img src="<?php //echo base_url().$Company_details->Company_logo; ?>" class="img-responsive center-block" alt="Share Image" style="width:80% !important">-->
									<?php 
									}
									else 
									{
										 //echo"---Share_file_path--edit-".$Share_file_path."<br>";
									?>
										<img  id="blah" src="<?php echo $Share_file_path; ?>" class="img-responsive center-block" alt="Share Image" style="width:25% !important">
										
									<?php 
									} 
									?>
									<input type="hidden" name="Share_file_path" value="<?php echo $Share_file_path; ?>" class="form-control" />
						</div>
						<div class="form-group" id="Share_description_div">
							<label for=""> Share description </label>
							<div class="input-group">									
								<textarea class="form-control" rows="3" name="Share_description" id="Share_description">
								<?php echo $Share_description; ?></textarea>
							</div>
						</div>
						
						
											
						<?php //echo $Schedule_comm_for; ?>
						<div class="form-group"  id="send_communication_to"   <?php if($Schedule_flag  == 0 ){echo 'style="display:none;"';}?>  >
							
							<label for=""><span class="required_info">* </span>Communication To</label>
							
								<div class="col-sm-6" >
								  <div class="form-check" >
									<label class="form-check-label">
									<input class="form-check-input" type="radio" name="Member_radio" id="r21" value="1"  onclick="Toggle_member_comm(this.value);"  <?php if($Comm_type==1){echo "checked";}else{echo "disabled";}?> >Single Member</label>
								  </div>
								  
								  <div class="form-check" >
									<label class="form-check-label">
									<input class="form-check-input" type="radio" name="Member_radio"  id="r22" value="2"  onclick="Toggle_member_comm(this.value);"  <?php if($Comm_type==2){echo "checked";}else{echo "disabled";}?> >All Members</label>
								  </div> 
								<!--  
								  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" type="radio" name="Member_radio"  value="3"  onclick="Toggle_member_comm(this.value);"   <?php if($Comm_type==3){echo "checked";}else{echo "disabled";}?> >Business Members</label>
							  </div> 
							  
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input" type="radio" name="Member_radio" value="4"  onclick="Toggle_member_comm(this.value);"  <?php if($Comm_type==4){echo "checked";}else{echo "disabled";}?> >Individiual Members</label>
							  </div> 
								  -->
								 
								 <div class="form-check"  id="key_sch">
								<label class="form-check-label">
								<input class="form-check-input commclass" type="radio" name="Member_radio"  value="3"  onclick="Toggle_member_type(this.value);"  <?php if($Comm_type==3){echo "checked";}else{echo "disabled";}?> >Key Members</label>
							  </div> 
							  
							  <div class="form-check"  id="worry_sch">
								<label class="form-check-label">
								<input class="form-check-input commclass" type="radio" name="Member_radio"    value="4" onclick="Toggle_member_type(this.value);"  <?php if($Comm_type==4){echo "checked";}else{echo "disabled";}?>>Worry Members</label>
							  </div> 
							  
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input commclass" type="radio" name="Member_radio"   value="5" onclick="Toggle_member_type(this.value);"  <?php if($Comm_type==5){echo "checked";}else{echo "disabled";}?>>Tier Based Members</label>
							  </div> 
							  
							  
							  
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input commclass" type="radio" name="Member_radio" value="7" onclick="Toggle_member_type(this.value);"  <?php if($Comm_type==7){echo "checked";}else{echo "disabled";}?>>Segment Based Members</label>
							  </div> 
							  
							 
							  
								
								
								
								</div>
							
						</div>
						<!--						
					<div class="form-group" id="ind_block"   <?php if($Comm_type!=4 ){echo 'style="display:none;"';}?>>
						<legend><span>Select Individiual Member Type:</span></legend>
						
							 
							  <div class="form-check" >
								&nbsp;&nbsp;&nbsp;&nbsp;
								<label class="form-check-label">
								<input class="form-check-input" type="radio" name="Employee_flag" value="1"  onclick="$('#parent_block').show();$('.commclass').prop('checked', false);$('#Employee_tier_block' ).hide();$('#Employee_tier_block2' ).hide();$('#send_to_tierInd' ).hide();$('#Ind_block2').hide(); "  <?php if($Employee_flag==1){echo "checked";}else{echo "disabled";}?>  >Employees</label>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<label class="form-check-label">
								<input class="form-check-input" type="radio" name="Employee_flag" value="0"  onclick="$('#parent_block').hide();$('.commclass').prop('checked', false); $('#Employee_tier_block' ).hide();$('#Employee_tier_block2' ).hide();$('#send_to_tierInd' ).hide();$('#Ind_block2').hide(); "  <?php if($Employee_flag==0){echo "checked";}else{echo "disabled";}?> >Residents</label>
							  </div> 	
							<br>
					<div class="form-group" id="parent_block"  <?php if($Employee_flag!=1){echo  'style="display:none;"';}?> >
						<legend><span>Select Member Companies :</span></legend>
						
							<div class="form-group">								
								<select class="form-control" name="Parent_id" id="Parent_id" onchange="Change_parent();">
									<option value="">Select</option>
									  <?php
										if($Dmcc_parent_members != NULL) 
										{
											foreach($Dmcc_parent_members as $rec)
											{
												if($Parent_id == $rec->Enrollement_id)
												{
													echo "<option value=".$rec->Enrollement_id." id=".$rec->Tier_id." selected>".$rec->First_name.''.$rec->Last_name."</option>";
												}
												else
												{
													echo "<option value=".$rec->Enrollement_id." id=".$rec->Tier_id." >".$rec->First_name.''.$rec->Last_name."</option>";
												}
												
											}
										}
										
										?>
									</select>								
							</div>							
						
					</div>		
						
					</div> 
							
						<div class="form-group"  id="Communicationfor" <?php if($Birthday_flag  == 1 ||  $Comm_type <= 2){echo 'style="display:none;"'; } ?>>
						
						<label for=""><span class="required_info">* </span>Communication for</label>
						 
							<div class="col-sm-6" >
							  <div class="form-check"  id="key_sch">
								<label class="form-check-label">
								<input class="form-check-input commclass" type="radio" name="r2"  value="8"  onclick="Toggle_member_type(this.value); "  <?php if($Schedule_comm_for==8){echo "checked";}else{echo "disabled";}?>>All Members</label>
							  </div> 
							  <div class="form-check"  id="key_sch">
								<label class="form-check-label">
								<input class="form-check-input commclass" type="radio" name="r2"  value="3"  onclick="Toggle_member_type(this.value);"  <?php if($Schedule_comm_for==3){echo "checked";}else{echo "disabled";}?> >Key Members</label>
							  </div> 
							  
							  <div class="form-check"  id="worry_sch">
								<label class="form-check-label">
								<input class="form-check-input commclass" type="radio" name="r2"    value="4" onclick="Toggle_member_type(this.value);"  <?php if($Schedule_comm_for==4){echo "checked";}else{echo "disabled";}?>>Worry Members</label>
							  </div> 
							  
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input commclass" type="radio" name="r2"   value="5" onclick="Toggle_member_type(this.value);"  <?php if($Schedule_comm_for==5){echo "checked";}else{echo "disabled";}?>>Tier Based Members</label>
							  </div> 
							  
							  
							  
							  <div class="form-check" >
								<label class="form-check-label">
								<input class="form-check-input commclass" type="radio" name="r2" value="7" onclick="Toggle_member_type(this.value);"  <?php if($Schedule_comm_for==7){echo "checked";}else{echo "disabled";}?>>Segment Based Members</label>
							  </div> 
							  
							 
							  
							</div>
						
					</div>
												
						-->		
							
							
						<div class="panel panel-default" id="send_to_single" <?php if($Comm_type !=1 ){echo 'style="display:none;"'; } ?> >
						
						
							<legend><span>Send to Single Member</span></legend>
							
								<div class="form-group" id="block1" >
									<label for=""><span class="required_info">*</span> Membership ID/ Mobile No.</label>
									<input type="text" id="mailtoone_memberid" name="mailtoone_memberid" class="form-control"  placeholder="Enter Membership ID" value="<?php echo $Membership_id; ?>"  />								
											
								</div>
						
						
								<div class="form-group" id="Member_details" >
								 <label for=""><b>Enrolled Member Details:</b></label>
									
										<div class="form-group">
											<label for="">Member Name</label>
											<input type="text" name="mailtoone" id="mailtoone" class="form-control" readonly value="<?php echo $member_name; ?>" />	
										</div>
										
										<div class="form-group">
											<label for="">Member Email ID</label>
											<input type="text" id="member_email" name="member_email" class="form-control" readonly value="<?php echo $member_email; ?>" />	
										</div>
										
										<div class="form-group">
											<label for="">Member Phone No.</label>
											<input type="text" name="mailtoone_phnno" id="mailtoone_phnno" class="form-control"  readonly value="<?php echo $member_phone; ?>" />	
										</div>
										
										<div class="form-group">
											<input type="hidden" name="Enrollment_id" id="MemberEnrollmentId" value="<?php echo $Enrollment_id; ?>"/>
										</div>
									
								</div>
					
						</div>
						
						<div class="form-group" id="send_to_all" <?php if($Comm_type !=2){echo 'style="display:none;"'; } ?> >
							<legend><span>Send to All Members:</span></legend>
								<div class="form-group">								
									<select class="form-control" name="mailtoall">
										<option value="0">All Members</option>
									</select>								
								</div>							
							
						</div>
						<div class="row"  <?php if($Comm_type <= 2 ){echo 'style="display:none;"';}?>>
							<div class="col-sm-6">
								<div class="form-group" id="send_to_key"  <?php if($Comm_type!=3){echo 'style="display:none;"';}?>>
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
								<div class="form-group" id="send_to_worry"  <?php if( $Comm_type!=4 ){echo 'style="display:none;"';}?>>
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
								
							<div class="col-sm-6"   <?php if(($Comm_type > 2 && $Comm_type < 5) ){echo  'style="display:block;"';}else{echo  'style="display:none;"';}?>>	
								<br>
								<div class="form-group" id="key_worry_customers">
									<label for="" id="key_wory_heading">Key / Worry Members</label>:
									
										<div class="form-group">								
											<select multiple class="form-control" name="key_worry_cust[]" id="KeyWorryCust">
												<?php
													foreach($Schedule_members as $Schedule_members)
													{
														echo '<option value="'.$Schedule_members->Enrollment_id.'" selected>'.$Schedule_members->First_name.' '.$Schedule_members->Last_name.'</option>';
													}
												?>
											</select>								
										</div>
									
								</div>
							</div>
								
					</div>
						
							<!------------------All Members------------------------->
							
						<div class="form-group" id="All_membersBlock"  <?php if($Comm_type==8){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?> >
						<legend><span>Select All Members:</span></legend>
						
							<div class="form-group">								
								<select class="form-control" name="All_members[]" id="All_members" multiple>
								<?php
											foreach($All_members as $All_members)
											{
												echo '<option value="'.$All_members->Enrollment_id.'" selected>'.$All_members->First_name.' '.$All_members->Last_name.'</option>';
											}
										?>
								</select>								
							</div>							
						
						</div>
						<!------------------All ---------------------------------->
						
						<div class="form-group" id="Segment_block"  <?php if($Comm_type !=7){echo 'style="display:none;"'; } ?> >
							<div class="row">
							<legend><span>Send to Segment Members:</span></legend>
							<!--<div class="col-sm-6">
							<button type="button" name="submit"  id="Segment" class="btn btn-primary" onclick="makeCharts('light','#FFFFFF','');" data-toggle="modal" data-target="#Segment_handeler">Show Segment Handlers</button>
							</div>-->
								<div class="col-sm-12">								
									<select class="form-control" name="Segment_code" id="Segment_code" >
										<?php										
										foreach($Segments_list as $Segments)
										{
											
											if($Segments->Segment_code  == $Segment_code)
											{
												echo '<option value="'.$Segments->Segment_code.'" selected>'.$Segments->Segment_name.'</option>';
											}
											else{
												echo '<option value="'.$Segments->Segment_code.'">'.$Segments->Segment_name.'</option>';
											}											
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
						
						<div class="form-group" id="send_to_tier" <?php if(($Comm_type==5) ){echo  'style="display:block;"';}else{echo  'style="display:none;"';}?>>
						<legend><span>Select Tier:</span></legend>
						
							<div class="form-group">								
								<select class="form-control" name="mailtotier" id="mailtotier">
									<option value="">Select Tier</option>
									<option value="0" <?php if($Tier_id==0){echo 'selected';} ?>>All Tiers</option>
									<?php										
									foreach($Ind_Tier_list as $Tier)
									{
										if($Tier_id==$Tier->Tier_id)
										{
											echo '<option value="'.$Tier->Tier_id.'" selected>'.$Tier->Tier_name.'</option>';
										}
										else
										{
											echo '<option value="'.$Tier->Tier_id.'" >'.$Tier->Tier_name.'</option>';
										}
										
									}
									?>
								</select>								
							</div>							
						
					</div>
					
						<div class="form-group" id="Business_block"   <?php if(($Comm_type==5) ){echo  'style="display:block;"';}else{echo  'style="display:none;"';}?>>
						<legend><span>Select  Members:</span></legend>
						
							<div class="form-group">								
								<select class="form-control" name="Business_Users[]" id="Business_Users" multiple>
										<?php
													foreach($Business_tier_members as $Business_tier_members)
													{
														echo '<option value="'.$Business_tier_members->Enrollment_id.'" selected>'.$Business_tier_members->First_name.' '.$Business_tier_members->Last_name.'</option>';
													}
												?>
								</select>								
							</div>							
						
					</div>
						
				
						<div class="form-group" id="send_to_tierInd"   <?php if(($Comm_type==4 && $Employee_flag==0 && $Comm_type==5) ){echo  'style="display:block;"';}else{echo  'style="display:none;"';}?>>
						<legend><span>Select Individiual Tier:</span></legend>
						
							<div class="form-group">								
								<select class="form-control" name="IndTier" id="IndTier">
									<option value="">Select Tier</option>
									<option value="0" <?php if($Tier_id==0){echo 'selected';} ?>>All Tiers</option>
									<?php										
									foreach($Ind_Tier_list as $Tier)
									{
										if($Tier_id==$Tier->Tier_id)
										{
											echo '<option value="'.$Tier->Tier_id.'" selected>'.$Tier->Tier_name.'</option>';
										}
										else
										{
											echo '<option value="'.$Tier->Tier_id.'" >'.$Tier->Tier_name.'</option>';
										}
									}
									?>
								</select>								
							</div>							
						
					</div>
					
						<div class="form-group" id="Ind_block2"      <?php if(($Comm_type==4 && $Employee_flag==0 && $Comm_type==5) ){echo  'style="display:block;"';}else{echo  'style="display:none;"';}?>>
						<legend><span>Select Residents:</span></legend>
						
							<div class="form-group">								
								<select class="form-control" name="Residents[]" id="Residents" multiple>
										<?php
													foreach($Residents as $Residents)
													{
														echo '<option value="'.$Residents->Enrollment_id.'" selected>'.$Residents->First_name.' '.$Residents->Last_name.'</option>';
													}
												?>
								</select>								
							</div>							
						
					</div>
						
					
					
						<div class="form-group" id="Employee_tier_block"   <?php if(($Comm_type==4 && $Employee_flag==1 && $Comm_type==5) ){echo  'style="display:block;"';}else{echo  'style="display:none;"';}?>>
							<legend><span> Member Companies Tier:</span></legend>
						
							<div class="form-group">								
								<select class="form-control" name="Parent_tier_id" id="Parent_tier_id"  disabled>
										  <?php
											foreach($Business_Tier_list as $Tier)
											{
												echo '<option value="'.$Tier->Tier_id.'">'.$Tier->Tier_name.'</option>';
											}
											?>
										</select>							
							</div>							
						
						</div>
					
						<div class="form-group" id="Employee_tier_block2"  <?php if(($Comm_type==4 && $Employee_flag==1 && $Comm_type==5) ){echo  'style="display:block;"';}else{echo  'style="display:none;"';}?>>
							<legend><span>Select Employees:</span></legend>
						
							<div class="form-group">								
								<select class="form-control" name="Employee[]" id="Employee" multiple>
										<?php
													foreach($Employee as $Employee)
													{
														echo '<option value="'.$Employee->Enrollment_id.'" selected>'.$Employee->First_name.' '.$Employee->Last_name.'</option>';
													} 
												?>
								</select>								
							</div>							
						
						</div>
						
					
						
							<input type="hidden" name="communication_id" value="<?php echo App_string_encrypt($communication_id); ?>" >
						<input type="hidden" name="Comm_type" value="0" >
						
						<button type="submit" name="submit" value="Register" id="Register" class="btn btn-primary">Update</button>										
						<!--<button type="reset" class="btn btn-primary">Reset</button>-->
						<input type="hidden" name="Company_id" value="<?php echo $Company_details->Company_id; ?>"/>
					
				  
		
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
											<td id="Offer_description"><?php echo $communication_description; ?></td>
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
						
						if($row->Schedule_flag == '0')
						{
							$Schedule='No';
						}
						else
						{
							$Schedule='Yes';
						}		
						
						$Encrypt_comm_id = App_string_encrypt($row->id);
						$Encrypt_comm_id = str_replace('+', 'X', $Encrypt_comm_id);
						$_SESSION[$Encrypt_comm_id]=$row->id;	
					?>
						<tr>
							
							<td class="row-actions">
								<a href="<?php echo base_url()?>index.php/Administration/edit_communication_offer/?id=<?php echo $Encrypt_comm_id;?>" title="Edit">
									<i class="os-icon os-icon-ui-49"></i>
								</a>
								<?php  if($_SESSION['Edit_Privileges_Delete_flag']==1){ ?>
								<a href="javascript:void(0);" class="danger"   onclick="delete_me('<?php echo $row->id;?>','<?php echo $row->communication_plan;?>','','Administration/delete_communication_offer/?path=Administration/communication&id');" title="Delete"  data-target="#deleteModal" data-toggle="modal" >
									<i class="os-icon os-icon-ui-15"></i>
								</a> 
									<?php } ?>							
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
<script  type="text/javascript">	
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
					if(data.message == '1')
					{
						/*$('.mce-window').css("z-index","65536");
						$('#ImageModal').hide();
						$("#ImageModal").removeClass( "in" );
						$('.modal-backdrop').remove();
						// $('#mceu_41-inp').val("<?php echo base_url()?>"+data.image_name);	//for localhost
						$('#mceu_41-inp').val("<?php echo base_url()?>"+data.image_name);
						*/
						
						$('.mce-window').css("z-index","65536");
						$('#ImageModal').hide();
						$("#ImageModal").removeClass( "in" );
						$('.modal-backdrop').remove();
						$('#mceu_41-inp').val("<?php echo base_url()?>"+data.image_name);
                                                // mce.windowManager.close();
                                                var Content_to_insert = "<img src='"+data.image_name+"' />";
                                                tinyMCE.activeEditor.execCommand("mceInsertContent", true, Content_to_insert);						
					}
					else
					{
						return false;
					}
				}
			});
		}));
	});
	var tools="styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | print preview media code | forecolor backcolor emoticons";
	
	tinymce.init(
	{
		
		selector: "textarea#offerdetails1",
		theme: "modern",
		height : 250,
		paste_data_images: true,
		convert_urls : false,
		plugins: [
			"textcolor colorpicker advlist link image lists hr anchor pagebreak fullscreen preview code table"
		],
		file_browser_callback: fileBrowserCallBack,
		menubar: false,
		relative_urls: false,
		toolbar1: tools,	//link image |
		toolbar2: "hr | fontselect | fontsizeselect | tablecontrols | table",
		
		setup : function(editor)
		{
			  editor.on('keyup', function(e) {
				var htmlContent = tinyMCE.activeEditor.getContent();
				
				$('#Offer_description').html(htmlContent);
				$('input[name=offerdetails]').val(htmlContent);
			});
			
			
			
			editor.on('load', function(e) {
				var htmlContent = tinyMCE.activeEditor.getContent();
				
				// $('#Offer_description').html(htmlContent);
				$('input[name=offerdetails1]').val(htmlContent);
			});
		}
	});
	
	tinymce.init(
	{
		//alert();
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
				// alert('1');
				$('#Offer_description').html(htmlContent);
				$('input[name=offerdetails1]').val(htmlContent);
			});
			
			  editor.on('load', function(e) {
				var htmlContent = tinyMCE.activeEditor.getContent();
				// alert('2');
				// $('#Offer_description').html(htmlContent);
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
          
	if( $('#companyId').val() != "" && $('#sellerId').val() != "" )
	{

		var htmlContent = tinyMCE.get('offerdetails1').getContent();
		var ContentLength = htmlContent.length;		
		if( $('#offer_name').val() != "" && $('#datepicker1').val() != "" && $('#datepicker2').val() != "" && htmlContent != "")
		{
			// show_loader();
			
				if(ContentLength == 0)
				{
					var Title1 = "Application Information";
					var msg1 = 'Please Enter Offer Details!.';
					runjs(Title1,msg1);
					return false;
				}
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
						
						if($("#datepicker3" ).val()== "" || $("#datepicker3" ).val()== '0000-00-00')
						{
							var Title1 = "Application Information";
							var msg1 = 'Please select day date!.';
							runjs(Title1,msg1);
							return false;
						}
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
});




/********************************Voucher-19-02-2020************************************/

	var Linktovoucher=<?php echo $Link_to_voucher; ?>;
	console.log('--Linktovoucher-----'+Linktovoucher);
	
	if(Linktovoucher==0){
		$("#voucher_type_div").hide();
		$("#Revenue_voucher_div").hide();
		$("#Product_voucher_div").hide();
	}	
	var Vouchertype=<?php echo $Voucher_type; ?>;
	console.log('--Vouchertype-----'+Vouchertype);	
	if(Vouchertype==122){
		$("#Revenue_voucher_div").show();
		$("#Product_voucher_div").hide();
	}
	if(Vouchertype==123){
		$("#Revenue_voucher_div").hide();
		$("#Product_voucher_div").show();
	}
	
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
		
		// console.log(VoucherType);
		
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
		
	}

/********************************Voucher-19-02-2020************************************/


/******************************Show Hide*********************************/

/******************************Show Hide*********************************/
function Toggle_member_comm(Member)
{
	// alert('Member '+Member);
	$( "#mailtoone_memberid" ).removeAttr("required");
	$( "#Communicationfor" ).hide();
	$( "#send_to_single" ).hide();
	$( "#send_to_all" ).hide();
	$( "#ind_block" ).hide();
	
	$( "#send_to_key" ).hide();
	$( "#key_worry_customers" ).hide();
	$( "#send_to_worry" ).hide();
	$( "#Business_block" ).hide();
	$( "#send_to_tier" ).hide();
	$( "#Segment_block" ).hide();
	// $('input[name=r2]').checked=false;
	$(".commclass").attr("data-type", "uncheck");
	$(".commclass").prop("checked", false);
	if(Member==1)//Single
	{
		$( "#send_to_single" ).show();
		$( "#mailtoone_memberid" ).attr("required","required");
	}
	if(Member==2)//All
	{
		$( "#send_to_all" ).show();
	}
	if(Member==3)//Business
	{
		$( "#Communicationfor" ).show();
	}
	if(Member==4)//Individiual
	{
		$( "#Communicationfor" ).show();
		$( "#ind_block" ).show();
	}
}
function Toggle_member_type(Member_type)
{
	// alert('Member_type '+Member_type);
	$( "#send_to_key" ).hide();
	$( "#key_worry_customers" ).hide();
	$( "#send_to_worry" ).hide();
	$( "#Business_block" ).hide();
	$( "#send_to_tier" ).hide();
	$( "#Segment_block" ).hide();
	
	$("#send_to_tier" ).hide();
	$("#Business_block").hide();
	
	$("#send_to_tierInd" ).hide();
	$("#Ind_block2").hide(); 
	
	$("#Employee_tier_block" ).hide();
	$("#Employee_tier_block2" ).hide();
	$("#All_membersBlock" ).hide();
	if(Member_type==8)//All
	{
		$( "#All_membersBlock" ).show();
		var Tier_id = 0;
		var Employee_flag = 0;
		var Member_radio = $('input[name=Member_radio]:checked').val();	
		if(Member_radio==3)//Business
		{
			var Business_flag = 1;
		}
		else //Individiual
		{
			var Business_flag = 0;
			var Employee_flag = $('input[name=Employee_flag]:checked').val();
			if(Employee_flag==1)//Employee
			{
				var Employee_flag = 1;
				var Tier_id=$('#Parent_id').children(':selected').attr('id');
				// alert(Tier_id);
				// Change_parent();
			}
		}
		
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{Tier_id:Tier_id, Company_id:Company_id,Business_flag:Business_flag,Employee_flag:Employee_flag},
			url: "<?php echo base_url()?>index.php/Administration/get_tiers_customers",
			success: function(data)
			{
				$('#All_members').html(data.get_tiers_customers);
			}				
		});
	}
	if(Member_type==3)//Key
	{
		$( "#key_worry_customers" ).show();
		$( "#send_to_key" ).show();
	}
	if(Member_type==4)//Worry
	{
		$( "#send_to_worry" ).show();
		$( "#key_worry_customers" ).show();
	}
	if(Member_type==5)//Tier
	{
		var Member_radio = $('input[name=Member_radio]:checked').val();	
		if(Member_radio==3)//Business
		{
			$("#send_to_tier" ).show();
			$("#Business_block").show();
		}
		else //Individiual
		{
			var Employee_flag = $('input[name=Employee_flag]:checked').val();
			if(Employee_flag==0)//Resident
			{
				
				$("#send_to_tierInd" ).show();
				$("#Ind_block2").show(); 
			}
			else{
				var Parent_id = $("#Parent_id").val(); 
				$("#Employee_tier_block" ).show();
				$("#Employee_tier_block2" ).show();
				Change_parent();
			}
			
		}
		
	}
	if(Member_type==7)//sEGMENT
	{
		$("#Segment_block").show();
	}
	
}
	
		
	
	$('#mailtotier').change(function()
	{
		var Business_tier = $("#mailtotier").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{Tier_id:Business_tier, Company_id:Company_id,Business_flag:1,Employee_flag:0},
			url: "<?php echo base_url()?>index.php/Administration/get_tiers_customers",
			success: function(data)
			{
				$('#Business_Users').html(data.get_tiers_customers);
			}				
		});
	});
	$('#IndTier').change(function()
	{
		var IndTier = $("#IndTier").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{Tier_id:IndTier, Company_id:Company_id,Business_flag:0,Employee_flag:0},
			url: "<?php echo base_url()?>index.php/Administration/get_tiers_customers",
			success: function(data)
			{
				$('#Residents').html(data.get_tiers_customers);
			}				
		});
	});
	
	function Change_parent()
	{
		var Tier_check = $('input[name=r2]:checked').val();
		var Employee_flag = $('input[name=Employee_flag]:checked').val();
		var id=$('#Parent_id').children(':selected').attr('id');
		$('#Parent_tier_id').val(id);
		var Company_id = '<?php echo $Company_id; ?>';
		
		if(Tier_check==5)//Tier
		{
			
			$('#Select_tier3').show();
			$('#Employee_tier_block2').show();
			
			
			$.ajax({
				type:"POST",
				data:{Tier_id:id, Company_id:Company_id,Business_flag:0,Employee_flag:Employee_flag},
				url: "<?php echo base_url()?>index.php/Administration/get_tiers_customers",
				success: function(data)
				{
					// alert(data.get_tiers_customers);
					$('#Employee').html(data.get_tiers_customers);
				}				
			});
		}
		if(Tier_check==8)//All
		{
			
			$.ajax({
				type:"POST",
				data:{Tier_id:id, Company_id:Company_id,Business_flag:0,Employee_flag:Employee_flag},
				url: "<?php echo base_url()?>index.php/Administration/get_tiers_customers",
				success: function(data)
				{
					$('#All_members').html(data.get_tiers_customers);
				}				
			});
		}
	}



	$('#mailtokey').change(function()
	{
		Parent_id=0;
		var mailtokey = $("#mailtokey").val();
		var Seller_id = $("#sellerId").val();
		var Company_id = '<?php echo $Company_id; ?>';
		var r2Value = $('input[name=r2]:checked').val();
		var Member_radio = $('input[name=Member_radio]:checked').val();
		if(Member_radio==3){Member_radio=1;}//Business
		if(Member_radio==4)//Individiual
		{
			Member_radio=0;
			var Employee_flag = $('input[name=Employee_flag]:checked').val();
			if(Employee_flag==1)
			{
				var Parent_id = $("#Parent_id").val();
			}
		}
		$.ajax({
			type:"POST",
			data:{Seller_id:Seller_id, Company_id:Company_id, r2Value:r2Value, mailtokey:mailtokey, Member_radio:Member_radio, Parent_id:Parent_id},
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
		var Member_radio = $('input[name=Member_radio]:checked').val();
		// alert(Member_radio);
		if(Member_radio==3){Member_radio=1;}//Business
		if(Member_radio==4)//Individiual
		{
			Member_radio=0;
			var Employee_flag = $('input[name=Employee_flag]:checked').val();
			if(Employee_flag==1)
			{
				var Parent_id = $("#Parent_id").val();
			}
		}
		$.ajax({
			type:"POST",
			data:{Seller_id:Seller_id, Company_id:Company_id, r2Value:r2Value, mailtokey:mailtokey, Member_radio:Member_radio, Parent_id:Parent_id},
			url: "<?php echo base_url()?>index.php/Administration/get_key_worry_customers",
			success: function(data)
			{
				$('#KeyWorryCust').html(data.get_key_worry_customers);
				$('#key_wory_heading').html("Worry Members");
			}				
		});
	});
	
	
	$('#r1').click(function()
	{
		// alert('---Create New Communication---');
		
		$( "#create_new_offer" ).show();
		$( "#send_exist_offer" ).hide();
		$( "#send_communication_to" ).hide();
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
		// $( "#multiple_social" ).hide();
		$( "#multiple_social" ).show();
		$( "#share_image_div" ).hide();
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
		// $("#multiple_social").hide();	
		$("#multiple_social").show();
		$("#share_image_div" ).hide();
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
		$( "#share_image_div" ).hide();
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
	
	
	/* hide_show_socila_image_div  01-06-2022 */
	
		$(document).ready(function (e)
		{
			var facebook_social1 = $('input[name=facebook_social1]:checked').val();
			var twitter_social1 = $('input[name=twitter_social1]:checked').val();
			var googleplus_social1 = $('input[name=googleplus_social1]:checked').val();
			
			// alert('---existing----facebook_social1---)'+facebook_social1+'----twitter_social1---)'+twitter_social1+'--googleplus_social1---)'+googleplus_social1);
			
			if( (facebook_social1==1) || (twitter_social1==1) || (googleplus_social1==1) ){
				
				$( "#share_image_div" ).show();
				$( "#Share_description_div" ).show();
				
			} else {
				
				$( "#share_image_div" ).hide();
				$( "#Share_description_div" ).hide();
			}
		});
	
	
		function hide_show_socila_image_div(inputVal){			
			
			var facebook_social1 = $('input[name=facebook_social1]:checked').val();
			var twitter_social1 = $('input[name=twitter_social1]:checked').val();
			var googleplus_social1 = $('input[name=googleplus_social1]:checked').val();
			
			// alert('facebook_social1---)'+facebook_social1+'----twitter_social1---)'+twitter_social1+'--googleplus_social1---)'+googleplus_social1);
			
			if( (facebook_social1==1) || (twitter_social1==1) || (googleplus_social1==1) ){
				
				$( "#share_image_div" ).show();
				$( "#Share_description_div" ).show();
				
			} else {
				
				$( "#share_image_div" ).hide();
				$( "#Share_description_div" ).hide();
			} 
			
		}
	/* hide_show_socila_image_div  01-06-2022 */
	

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
				$("#Business_block").hide();
				$("#Ind_block").hide();
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
				$("#Business_block").hide();
				$("#Ind_block").hide();
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
				$("#Business_block").hide();
				$("#Ind_block").hide();
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
				$("#Business_block").hide();
				$("#Ind_block").hide();
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
				$("#Business_block").show();
				$("#Ind_block").hide();
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
		$("#Business_block").hide();
				$("#Ind_block").hide();
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
		$("#Business_block").hide();
				$("#Ind_block").hide();
	});
	
	$('#r28').click(function()//Business
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
		$("#Segment_block").hide();
		
		$("#Business_block").show();
				$("#Ind_block").hide();
	});
	
	$('#r29').click(function()//Ind
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
		$("#Segment_block").hide();
		$("#Business_block").hide();
				$("#Ind_block").show();
	});
	
 /******************************Show Hide*********************************/


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
						// alert(json['First_name']);
						// has_success(".has-feedback","#glyphicon1",".help-block1",data);	
						// has_success("#block1","#glyphicon1","#Membership_help"," ");
						// alert();
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
	

$(document).ready(function() 
{	
	
	var offerIS = '<?php echo $communication_plan; ?>';
	
	$('#offer_name').blur(function()
	{
		if( $("#sellerId").val() != "")
		{
		
			
			if($("#offer_name").val() == "")
			{
				$("#offer_name").val("");
				has_error(".has-feedback","#glyphicon",".help-block","Please Enter Name of Offer");
			}
			else if($("#offer_name").val() != offerIS)
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
	
	
	
	
});


/******calender *********/
$("#datepicker1").datepicker({
  minDate: 0,
  yearRange: "-80:+2",
  changeMonth: true,
  changeYear: true,
  onSelect: function(date) {
    $("#datepicker1").datepicker('option', 'minDate', date);
  }
});
 
$("#datepicker2").datepicker({
	
	 minDate: 0,
  yearRange: "-80:+2",
  changeMonth: true,
  changeYear: true,
	onSelect: function(date) {
		$("#datepicker2").datepicker('option', 'minDate', date);
	}
	
});
$("#datepicker3").datepicker({
	
	 minDate: 0,
  yearRange: "-80:+2",
  changeMonth: true,
  changeYear: true,
	onSelect: function(date) {
		$("#datepicker3").datepicker('option', 'minDate', date);
	}
	
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
	// alert('-birthday-'+inputVal); //Schedule_flag send_communication_to
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
		$("#send_communication_to").hide();
		$("#Sch_Weekly").hide();
		// $("#Sch_Mothly").hide();
		$("#Link_to_lbs_div").show();
	}
}

function hide_show_criteria(inputVal)
{
	// alert(inputVal);
	$( "#Communicationfor" ).hide();
	$( "#send_to_single" ).hide();
	$( "#send_to_all" ).hide();
	$( "#ind_block" ).hide();
	
	$( "#send_to_key" ).hide();
	$( "#key_worry_customers" ).hide();
	$( "#send_to_worry" ).hide();
	$( "#Business_block" ).hide();
	$( "#send_to_tier" ).hide();
	$( "#Segment_block" ).hide();
	
	$("#send_to_tierInd" ).hide();
	$("#Ind_block2").hide(); 
	
	$("#Employee_tier_block" ).hide();
	$("#Employee_tier_block2" ).hide();
	
	if(inputVal=='1')
	{
		$("#Sch_Criteria").show();
		$("#r23").hide();
		$("#r24").hide();
		$("#key_sch").hide();
		$("#worry_sch").hide();
		$("#hobbie").hide();
		$("#Select_day").hide();
		$("#Sch_Weekly").hide();
		$("#send_communication_to").show();
		$("#Link_to_lbs_div").hide();
		// $("#Sch_Weekly").show();
		// $("#Sch_Weekly").show();
	}
	else
	{
		$("#Sch_Criteria").hide();
		$("#r23").show();
		$("#r24").show();
		$("#key_sch").show();
		$("#worry_sch").show();
		$("#hobbie").show();
		$("#Select_day").hide();
		$("#send_communication_to").hide();
		$("#Sch_Weekly").hide();
		$("#Segment_block").hide();
		$("#send_to_single").hide();
		$("#send_to_tier").hide();
		$("#send_to_all").hide();
		$("#Link_to_lbs_div").show();
		// $("#Sch_Mothly").hide(); $("#Segment_block").show();
		// $("#Sch_Weekly").hide();
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


</script>

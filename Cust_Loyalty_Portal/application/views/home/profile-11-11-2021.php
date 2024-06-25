
<?php $this->load->view('header/header'); 
/* echo"Membershi_ID------".$Membershi_ID."<br>";
echo"Card_id------".$Card_id."<br>"; */
$ci = &get_instance();
$ci->load->helper('encryption_val');

$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
				
if($Current_point_balance<0)
{
	$Current_point_balance=0;
}
else
{
	$Current_point_balance=$Current_point_balance;
}

?> 

<form method="POST" action="<?php echo base_url()?>index.php/Cust_home/updateprofile" enctype="multipart/form-data">
	<section class="content-header">
		<h1>My Profile</h1>	  
	</section>
	
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
		
			<?php if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== ""){ ?>
			<script>
					BootstrapDialog.show({
					closable: false,
					title: 'Application Information',
					message: 'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
					buttons: [{
						label: 'OK',
						action: function(dialog) {
							window.location='<?php echo base_url()?>index.php/Cust_home/home';
						}
					}]
				});
				runjs(Title,msg);
			</script>
		<?php } ?>
	<section class="content">

		<div class="row">
		
            <div class="col-md-3">
				<div class="box box-primary">
					<div class="box-body box-profile">	
					
						<?php 
						if($Enroll_details->Photograph == "")
						{
						?>
						
							<img src="<?php echo $this->config->item('base_url2')?>images/no_image.jpeg" class="profile-user-img img-responsive img-circle" id="no_image">
						
						<?php 
						}
						else
						{
						?>
						
							<img class="profile-user-img img-responsive img-circle" src="<?php echo $this->config->item('base_url2')?><?php echo $Enroll_details->Photograph; ?>" id="no_image" alt="Member profile picture">
						
						<?php
						}
						?>
						
						<h3 class="profile-username text-center"><?php echo $Enroll_details->First_name.' '.$Enroll_details->Last_name; ?></h3>
						
						<p class="text-muted text-center"><?php echo $Enroll_details->Qualification; ?></p>
						
						<div class="form-group">
							<label for="exampleInputFile"></label>
							<input type="file" name="image1" id="image1"  onchange="readImage(this,'#no_image');"/>
						</div>
						
						<ul class="list-group list-group-unbordered">
							
							<li class="list-group-item"> 
								<?php 
								$Profile_complete_flag=1;
								if($Profile_complete_flag==1) 
								{ 
									?>
									<div class="col-md-4">
										<script src="<?php echo $this->config->item('base_url2')?>assets/portal_assets/js/progress-circle.js"></script>	
										<link href="<?php echo $this->config->item('base_url2')?>assets/portal_assets/css/circle.css" rel="stylesheet">
											<div id="circle"></div>        
											<script>
											( function( $ ){
												$( '#circle' ).progressCircle();
												<!-- $( '#submit' ).click( function() { -->
													var nPercent        = <?php echo $Customer_profile_status; ?>;
													var showPercentText = 1;
													var thickness       = 10;
													var circleSize      =100;

													$( '#circle' ).progressCircle({
														nPercent        : nPercent,
														showPercentText : showPercentText,
														thickness       : thickness,
														circleSize      : circleSize
													});
												<!-- }) -->
											})( jQuery );
											</script> 				
													
									</div>
									<?php
								}
								?>
								<br>
								<br>
								<br>
								<br>
								<br><b id="profile">Profile Status</b>
								<br>
								
								
							</li>
							<li class="list-group-item">
								<b>Tier </b> <a class="pull-right"><?php echo $Tier_details->Tier_name; ?></a>
							</li>
							<li class="list-group-item">
								<b>Current Balance</b> <a class="pull-right"><?php echo round($Current_point_balance); ?></a>
							</li>
							<li class="list-group-item">
								<b>Bonus <?php echo $Company_Details->Currency_name; ?></b> <a class="pull-right"><?php echo round($Enroll_details->Total_topup_amt); ?></a>
							</li>
							<li class="list-group-item">
								<b>Redeem <?php echo $Company_Details->Currency_name; ?></b> <a class="pull-right"><?php echo round($Enroll_details->Total_reddems); ?></a>
							</li>
							<li class="list-group-item">
								<b>Blocked <?php echo $Company_Details->Currency_name; ?></b> <a class="pull-right"><?php echo round($Enroll_details->Blocked_points); ?></a>
							</li>
							<li class="list-group-item">
								<b>Purchase Amount</b> <a class="pull-right"><?php echo round($Enroll_details->total_purchase); ?></a>
							</li>
							<li class="list-group-item">
								<b>Gift Card Balance</b> <a class="pull-right"><?php echo round($Gift_card_details->Gift_balance); ?></a>
							</li>
												
						</ul>
						<ul class="list-group list-group"><b>Hobbies and Interest</b>
							<li class="list-group-item" style="border: none;">
								<?php 
									$Hobbie_array= array();
									foreach($Hobbies_interest as $hobbies) 
									{ 
										$Hobbie_array[]=$hobbies['Hobbie_id'];
									} 
								?>						
								
							</li>
							
								<a href="#Change_hobbie" data-toggle="modal"  class="pull-right" >Add or Change</a>
																			
						</ul>
					</div>
				</div>
             
            </div>	
								
			<div class="col-md-9 nav-tabs-custom" style="padding: 10px;">
				
				<div class="row">
				
					<div class="col-md-6">				
						<div class="box box-primary">
							<div class="box-body">
							
								<div class="form-group has-feedback">
									<label for="inputName" class="col-sm-5 control-label">First Name</label>
									<input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $Enroll_details->First_name?>" placeholder="First Name" required>						
								</div>
								
								<div class="form-group has-feedback">
									  <label for="inputName" class="col-sm-5 control-label">Middle Name</label>                       
									  <input type="text" name="middleName" class="form-control" id="middleName" value="<?php echo $Enroll_details->Middle_name?>" placeholder=" Middle Name">                       
								</div>
								
								<div class="form-group has-feedback">
									 <label for="inputName" class="col-sm-5 control-label">Last Name</label>
									<input type="text" name="lastName" class="form-control" id="lastName" value="<?php echo $Enroll_details->Last_name?>" placeholder=" Last Name" required>
								</div>
								<div class="form-group has-feedback">
									 <label for="inputName" class="col-sm-5 control-label">Profession</label>
									<input type="text" name="Profession" class="form-control" id="Profession" value="<?php echo $Enroll_details->Qualification?>" placeholder=" Profession" >
								</div>
								<div class="form-group has-feedback">
									 <label for="inputName" class="col-sm-5 control-label">Experience<span style="font-size: 12px; font-style: italic; color: red;">(* In Years)</span></label>
									<input type="text" name="Experience" class="form-control" id="Experience" value="<?php echo $Enroll_details->Experience?>" placeholder=" Experience" >
								</div>								  
								<div class="form-group has-feedback" id="has-feedbackEmail"> 
									<label for="inputEmail" class="col-sm-5 control-label">Email</label>                      
									<input type="email" class="form-control" name="userEmailId" value="<?php echo App_string_decrypt($Enroll_details->User_email_id); ?>" id="userEmailId" placeholder="Email" required> 
									
									<span class="glyphicon" id="glyphiconEmail" aria-hidden="true"></span>						
									<div class="help-blockE" id="help-blockEmail"></div>
									
									<!--<a href="#"  id="Change_Email_Id"  class="pull-right" class="pull-right" >Change Email Id</a> 
									
									<a href="#"  id="Cancel_Email_Id"  style="display:none;float: right; margin-right: 16px;" >Cancel</a>-->							
								</div>
								
								<div class="form-group has-feedback" id="has-feedbackPhno">
									<label for="inputName" class="col-sm-5 control-label" style="width:100%;">Phone No
										&nbsp;&nbsp;<span style="font-size: 9px; font-style: italic; color: red;">(* Enter Phone No without Dial Code)</span>
									</label>
										
									<input type="text"  class="form-control" name="phno"  onkeyup="this.value=this.value.replace(/\D/g,'')"  value="<?php echo $phnumber; ?>" id="phno" placeholder="Phone No." onkeyup="this.value=this.value.replace(/\D/g,'')" required>
									<span class="glyphicon" id="glyphiconPhno" aria-hidden="true"></span>						
									<div class="help-blockP" id="help-blockPhno"></div>
										
									<!--<a href="#"  id="Change_Mobile_No"  class="pull-right" class="pull-right" >Change Phone No</a> 
										
									<a href="#"  id="Cancel_Mobile_No"  style="display:none;float: right; margin-right: 16px;" >Cancel</a>-->                     
								</div>
								
								<div class="form-group has-feedback">
									<label for="currentAddress" class="col-sm-5 control-label">Address</label>
									<textarea class="form-control" id="currentAddress" rows="4" cols="50" name="currentAddress" placeholder="Address" required><?php echo $Enroll_details->Current_address; ?></textarea>
								</div>
							
							</div>					
						</div>					
					</div>
					
					<div class="col-md-6">				
						<div class="box box-primary">
							<div class="box-body">
							<!----------------------AMIT 17-11-2017-------START------------------->
								<div class="form-group">
								
									<label for="exampleInputEmail1"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;Country</label>
									<select class="form-control" name="country" id="country" required onchange="Get_states(this.value);">
									
									<?php 
											foreach($Country_array as $Country)
											{ ?>
												<?php if($Enroll_details->Country == $Country['id']){ ?>
												
													<option value="<?php echo $Country['id'];?>"><?php echo $Country['name'];?></option>
													
												<?php } ?>
												
											<?php }
										?>
									</select>							
								</div>
								
								<div class="form-group" id="Show_States">
								
									<label for="exampleInputEmail1"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;State</label>
									<select class="form-control" name="state" id="state" required onchange="Get_cities(this.value);">
									
									<?php 
											foreach($States_array as $rec)
											{?>
												<option value="<?php echo $rec->id;?>" <?php if($Enroll_details->State == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
											<?php }
										?>	
									</select>							
								</div>
								
								<div class="form-group" id="Show_Cities">
								
									<label for="exampleInputEmail1"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span>&nbsp;City</label>
									<select class="form-control" name="city" id="city" required >
									
										<?php 
											foreach($City_array as $rec)
											{?>
												<option value="<?php echo $rec->id;?>" <?php if($Enroll_details->City == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
											<?php }
										?>	
									</select>							
								</div>
								<div class="form-group has-feedback">
									<label for="inputName" class="col-sm-5 control-label">District</label>
									<input type="text" class="form-control" name="district" value="<?php echo $Enroll_details->District; ?>" id="district" placeholder="District">                       
								</div>
								<div class="form-group has-feedback">
									  <label for="inputName" class="col-sm-5 control-label">Zip Code</label>
									  <input type="text" class="form-control" name="zip" value="<?php echo $Enroll_details->Zipcode; ?>" id="zip" placeholder="Zip Code" onkeyup="this.value=this.value.replace(/\D/g,'')" >
								</div>
								<!----------------------AMIT 17-11-2017-------END------------------->
							<!--
								<div class="form-group has-feedback">
									<label for="inputName" class="col-sm-5 control-label">State</label>
									<input type="text" class="form-control" name="state" value="<?php echo $Enroll_details->State; ?>" id="phno" placeholder="state">
								</div>
								
								<div class="form-group has-feedback">
									<label for="inputName" class="col-sm-5 control-label">District</label>
									<input type="text" class="form-control" name="district" value="<?php echo $Enroll_details->District; ?>" id="phno" placeholder="District">                       
								</div>
								
								<div class="form-group has-feedback">
									<label for="inputName" class="col-sm-5 control-label">city</label>
									<input type="text" class="form-control" name="city" value="<?php echo $Enroll_details->City; ?>" id="city" placeholder="city" required>
								   
								</div>
								
								<div class="form-group has-feedback">
									  <label for="inputName" class="col-sm-5 control-label">Zip Code</label>
									  <input type="text" class="form-control" name="zip" value="<?php echo $Enroll_details->Zipcode; ?>" id="zip" placeholder="Zip Code" onkeyup="this.value=this.value.replace(/\D/g,'')" >
								</div>
								
								<div class="form-group has-feedback">
									<label for="inputName" class="col-sm-5 control-label">Country</label>
									<select class="form-control" name="country" required >
										<option value="">Select Country</option>
										<?php 
										foreach($Country_array as $Country)
										{
										?>
											<option value="<?php echo $Country['Country_id']; ?>" <?php if($Enroll_details->Country_id == $Country['Country_id']){echo "selected";} ?> ><?php echo $Country['Country_name']; ?></option>
										<?php
										}
										?>
									</select>
								</div>
								-->
								<div class="form-group has-feedback">
									<label for="startDate" class="col-sm-5 control-label">Birth Date</label>
									<input type="text" class="form-control" id="datepicker1" name="dob" value="<?php echo date('d-M-Y', strtotime( $Enroll_details->Date_of_birth)); ?>" placeholder="Date of birth">
								</div>
								<div class="form-group has-feedback">
									<label for="startDate" class="col-sm-5 control-label">Anniversary Date</label>
									<input type="text" class="form-control" id="datepicker2" name="Wedding_annversary_date" value="<?php echo date('d-M-Y', strtotime( $Enroll_details->Wedding_annversary_date)); ?>" placeholder="Date of birth">
								</div>
								<div class="form-group has-feedback">
									<label for="startDate" class="col-sm-5 control-label">Sex(Male/Female)</label>
									<select class="form-control" name="Sex"  >
										<option value="">Select</option>
										
										<?php if($Enroll_details->Sex=='Male') 
										{ 
										?>	
											<option selected value="Male">Male</option> 
											<option value="Female" >Female</option>
										<?php  
										} 										
										else if($Enroll_details->Sex=='Female') 
										{
										?>										
											<option  value="Male">Male</option> 
											<option value="Female" selected >Female</option>
										<?php 
										}
										else 
										{
										?>
											<option  value="Male">Male</option> 
											<option value="Female" >Female</option>
										<?php 
										}											
										?>						
									</select>
								</div>
								<div class="form-group has-feedback">
									<label for="startDate" class="col-sm-5 control-label">Marital Status</label>
									<select class="form-control" name="Marital_status"  >
										<option value="">Select Status</option>
										
										<?php if($Enroll_details->Married=='Single') 
										{ 
										?>	
											<option selected value="Single">Single</option> 
											<option value="Married" >Married</option>
										<?php  
										} 										
										else if($Enroll_details->Married=='Married') 
										{
										?>										
											<option value="Married" selected>Married</option>
											<option value="Single">Single</option> 
										<?php 
										}
										else 
										{
										?>
											<option value="Married" >Married</option>
											<option value="Single">Single</option> 
										<?php 
										}											
										?>						
									</select>
								</div>
							
							</div>
							
							<div class="box-footer">
								<button type="submit" name="submit" value="Register" id="Register" class="btn btn-primary btn-block btn-flat">Submit</button>
								<a href="#myModal1" data-toggle="modal"  class="pull-right" >Change Password</a>
							</div>
							<div class="box-footer">
								<a href="#myModal4" data-toggle="modal"  class="pull-right" >Change Pin</a>
								<a href="#myModal5" data-toggle="modal"  class="pull-left" >Re-send Pin</a>
							</div>
							
						</div>					
					</div>					
				</div>									
				<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>" class="form-control" />
				<input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>" class="form-control" />
				<input type="hidden" name="User_id" value="<?php echo $Enroll_details->User_id; ?>" class="form-control" />
				<input type="hidden" name="membership_id" value="<?php echo $Enroll_details->Card_id; ?>" class="form-control" />
				<input type="hidden" name="Password" value="<?php echo $Enroll_details->User_pwd; ?>" class="form-control" />				
			</div>			
		</div>		  
			<div id="myModal1" class="modal fade" role="dialog">
				  <div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">					
					  <div class="modal-header">
						<h4 class="modal-title" style="background-color:#dd4b39;color:#fff;text-align:center">Change Password</h4>
					  </div>
					  <div class="modal-body">
						<div class="form-group has-feedback" id="has-feedback1">
							  <label for="inputName" class="col-sm-5 control-label">Old Password</label>
							  <input type="password" class="form-control" name="old_Password" id="old_Password" placeholder="Old Password">
							  <span class="glyphicon" id="glyphicon1" aria-hidden="true"></span>						
							  <div class="help-block" id="help-block1" ></div>                       
						</div>
					    <div class="form-group">
						  <label for="inputName" class="control-label">New Password</label>
                          <input type="password" class="form-control" name="new_Password"  id="new_Password" placeholder="New Password" >
							<input type="checkbox" id="showHide" class="form-control" /><label class="control-label" for="showHide" id="showHideLabel">Show Password</label>
						</div>
						<br>
					    <div class="form-group">
							<label for="inputName" class="control-label">Confirm Password</label>
							<input type="password" class="form-control" name="confirm_Password"   id="confirm_Password" placeholder="Confirm Password" >
						</div>
						
						<div class="form-group">
							<label for="inputName" class="control-label"><span class="required_info" style="font-size: 12px; font-style: italic; color: red;">*</span> Password Policy</label>
								<ul class="list-group" >
									<li class="list-group-item" style="padding:0px 0px 0px 3px">
										<span class="glyphicon glyphicon-remove" id="6_characters" ></span>  Password is minimum 6 characters
									</li>
									<li class="list-group-item"  style="padding:0px 0px 0px 3px">
										<span class="glyphicon glyphicon-remove" id="One_Capital" ></span>  One Upper Case Letter
									</li>
									<li class="list-group-item"  style="padding:0px 0px 0px 3px">
										<span class="glyphicon glyphicon-remove" id="One_Lower" ></span>  One Lower Case Letter
									</li>
									<li class="list-group-item"  style="padding:0px 0px 0px 3px">
										<span class="glyphicon glyphicon-remove" id="Special_Character" ></span>  Special Character 
									</li>
									<li class="list-group-item"  style="padding:0px 0px 0px 3px">
										<span class="glyphicon glyphicon-remove" id="One_Number" ></span>  One Number 
									</li>
								</ul>							
						</div>
					  <div class="modal-footer"> <!--onclick="Change_password(old_Password.value,new_Password.value,confirm_Password.value)" -->
						<button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-default" name="change_pwd" id="change_pwd" >Submit</button>
					  </div>
					</div>

				  </div>
				</div>
			</div>
				<!-- Modal Change Password end-->
				
				<!-- Modal Change Pin -->
				<div id="myModal4" class="modal fade" role="dialog">
				  <div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
					
					  <div class="modal-header">
						<h4 class="modal-title" style="background-color:#dd4b39;color:#fff;text-align:center">Change Pin</h4>
					  </div>
					  <div class="modal-body">
						  <div class="form-group has-feedback" id="has-feedback11">
							  <label for="inputName" class="col-sm-5 control-label">Old Pin </label>
							  <input type="password" class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')" name="old_pin" id="old_pin" placeholder="Old Pin">
							  <span class="glyphicon" id="glyphicon11" aria-hidden="true"></span>						
							  <div class="help-block" id="help-block11" ></div>                       
						</div>
					    <div class="form-group has-feedback" id="has-feedback21">
						  <label for="inputName" class="col-sm-5 control-label">New Pin</label>
                          <input type="password" class="form-control" name="new_pin" onkeyup="this.value=this.value.replace(/\D/g,'')"  id="new_pin" placeholder="New Pin" >
						  <span class="glyphicon" id="glyphicon21" aria-hidden="true"></span>						
						  <div class="help-block" id="help-block21"></div>
                       
					  </div>
					    <div class="form-group has-feedback" id="has-feedback31">
						  <label for="inputName" class="col-sm-5 control-label">Confirm Pin</label>
                          <input type="password" class="form-control" name="confirm_pin"  onkeyup="this.value=this.value.replace(/\D/g,'')" id="confirm_pin" placeholder="Confirm Pin" >
						  <span class="glyphicon" id="glyphicon31" aria-hidden="true"></span>						
						  <div class="help-block" id="help-block31"></div>
                       
					  </div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-default" name="change_pin" id="change_pin" onclick="Change_pin(old_pin.value,new_pin.value,confirm_pin.value)" >Submit</button>
					  </div>
					</div>

				  </div>
				</div>
				<!-- Modal Change Pin End -->
				
				<!-- Modal Forgot Pin -->
				<div id="myModal5" class="modal fade" role="dialog">
				  <div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">					
					  <div class="modal-header">
						<h4 class="modal-title" style="background-color:#dd4b39;color:#fff;text-align:center">Re-send Pin</h4>
					  </div>
					  <div class="modal-body">
						  <div class="form-group has-feedback" id="has-feedback12">
							  <label for="inputName" class="col-sm-5 control-label">User Email ID</label>
							  <input type="text" class="form-control" readonly name="User_email_id" value="<?php echo App_string_decrypt($Enroll_details->User_email_id); ?>" id="User_email_id" >
							  <span class="glyphicon" id="glyphicon12" aria-hidden="true"></span>						
							  <div class="help-block" id="help-block12" ></div>                       
							</div>
							<div class="form-group has-feedback" id="has-feedback22">
							  <label for="inputName" class="col-sm-5 control-label">User Phone No</label>
							  <input type="text" class="form-control" readonly name="Phone_No"  id="Phone_No" value="<?php echo App_string_decrypt($Enroll_details->Phone_no); ?>"  >
							  <span class="glyphicon" id="glyphicon22" aria-hidden="true"></span>						
							  <div class="help-block" id="help-block22"></div>                       
							</div>					   
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
						<!--<button type="button" class="btn btn-default" name="send_pin" id="send_pin" onclick="send_pin(User_email_id.value,Phone_No.value)" >Send Pin</button>-->
						
						<button type="button" class="btn btn-default" name="change_pin" id="change_pin" onclick="send_pin()" >Send Pin</button>
						
						
					  </div>
					</div>

				  </div>
				</div>
				<!-- Modal Change Pin End -->
				
				
				 <!-- Modal Change Hobbie -->
		 <div id="Change_hobbie" class="modal fade" role="dialog">
				  <div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
					
					  <div class="modal-header">
						<h4 class="modal-title" style="background-color:#dd4b39;color:#fff;text-align:center">Update Hobbies and Interest</h4>
					  </div>
					  <div class="modal-body">
									<?php
										// print_r($Hobbie_array);
									foreach($All_hobbies as $alhobe)
									{
											
											
										if($alhobe['Id']==1)
										{
											$img_icon='fashion.png';
										}
										else if($alhobe['Id']==2)
										{
											$img_icon='travel.png';
										}
										else if($alhobe['Id']==3)
										{
											$img_icon='game.png';
										}
										else if($alhobe['Id']==4)
										{
											$img_icon='reading.png';
										}
										else if($alhobe['Id']==5)
										{
											$img_icon='music.png';
										}
										else if($alhobe['Id']==6)
										{
											$img_icon='cooking.png';
										}
										else if($alhobe['Id']==7)
										{
											$img_icon='drama.png';
										}
										else if($alhobe['Id']==8)
										{
											$img_icon='electronic.png';
										}
										else if($alhobe['Id']==9)
										{
											$img_icon='drink.png';
										}
										else if($alhobe['Id']==10)
										{
											$img_icon='fitness.png';
										}
										else if($alhobe['Id']==11)
										{
											$img_icon='sports.png';
										}
										else if($alhobe['Id']==12)
										{
											$img_icon='paint.png';
										}
										else 
										{
											$img_icon='adventure.png';
										}
											
											
											if(in_array( $alhobe['Id'],$Hobbie_array)) 
											{
											?>	
												
												<div class="col-md-3" >	
												<br>
												<img class="profile-user-img img-responsive " src="<?php echo $this->config->item('base_url2')?>images/icon/<?php echo $img_icon;?>" id="<?php echo $alhobe['Id']; ?>" alt="<?php echo $alhobe['Hobbies']; ?>"  style="border:1px solid #d2d6de" onclick="getchecked(<?php echo $alhobe['Id']; ?>)">												
												<input name="hobbies" type="checkbox"  class="roundedTwo" id="chk_<?php echo $alhobe['Id']; ?>" value="<?php echo $alhobe['Id']; ?>" checked >
												<label style="font-size: 11px;" ><?php echo $alhobe['Hobbies']; ?></label>
												</div>
												
											<?php
											}
											else
											{
											?>	
												<div class="col-md-3" >	
												<br>
												<img class="profile-user-img img-responsive " src="<?php echo $this->config->item('base_url2')?>images/icon/<?php echo $img_icon;?>" id="<?php echo $alhobe['Id']; ?>" alt="<?php echo $alhobe['Hobbies']; ?>"  style="border:1px solid #d2d6de" onclick="getchecked(<?php echo $alhobe['Id']; ?>)">																					
												<input name="hobbies" type="checkbox" class="roundedTwo"  id="chk_<?php echo $alhobe['Id']; ?>"  value="<?php echo $alhobe['Id']; ?>"  >
												<label style="font-size: 11px;" ><?php echo $alhobe['Hobbies']; ?></label>
												</div>	
											<?php
											}
											
										}
										
										?>					
											
						<font id="feedback55" style="color:red;display:none"  >Please Select at least anyone hobbie</font>
						
					</div>
						<div class="modal-footer">
							<br><br><br><br>
							<button type="button" class="btn btn-default" name="Change_hobbies1" id="Change_hobbies1" onclick="Change_hobbies()" >Submit</button>
							<button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
						</div>
							
				  </div>
				</div>
				<!-- Modal Change Hobbie end-->

        </section><!-- /.content -->

<?php /* ?>		
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<?php  */ ?>

<?php $this->load->view('header/loader');?>
<?php $this->load->view('header/footer');?>




<style type="text/css">
.demo { position: relative; }
.demo i {position: absolute; bottom: 10px; right: 24px; top: auto; cursor: pointer;}
	  
.login-box {  
	float: left;
    margin: 0% auto;
    padding: 7px;
	width: 360px;   
}

.dropdown-menu
{
	cursor: pointer !Important;
}
.day
{
	background-color: #fff;
	border-color: #3071a9;
	color: #000;
	border-radius:4px;
} 
#login {
    float: none !important;
	margin-top: 588px !important;
}
</style>	

<script>

$(document).ready(function()
{
    $("#Change_Mobile_No").click(function()
	{	
		document.getElementById('phno').readOnly = false;
		document.getElementById('phno').value = '';
		document.getElementById('Cancel_Mobile_No').style.display = 'inline';      
    });
	
	$("#Cancel_Mobile_No").click(function()
	{	
		document.getElementById('phno').value = '<?php echo $Enroll_details->Phone_no; ?>';	
		document.getElementById('phno').readOnly = true;
		document.getElementById('Cancel_Mobile_No').style.display = 'none';
		has_success("#has-feedbackPhno","#glyphiconPhno","#help-blockPhno","");      
    });
	
	
	$("#Change_Email_Id").click(function()
	{	
		document.getElementById('userEmailId').readOnly = false;
		document.getElementById('userEmailId').value = '';
		document.getElementById('Cancel_Email_Id').style.display = 'inline';      
    });
	
	$("#Cancel_Email_Id").click(function()
	{	
		document.getElementById('userEmailId').value = '<?php echo $Enroll_details->User_email_id; ?>';	
		document.getElementById('userEmailId').readOnly = true;
		document.getElementById('Cancel_Email_Id').style.display = 'none'; 
		has_success("#has-feedbackEmail","#glyphiconEmail","#help-blockEmail","");     
    });	
});

function hide_show(ImageId)
{	
	document.getElementById('no_image').style.display = 'block';
	document.getElementById('no_image1').style.display = 'none';
}

$('#new_Password').blur(function()
{
	if( $('#new_Password').val() == "" || $('#new_Password').val() == 0 )
	{
		$("#new_Password").val("");
		has_error("#has-feedback2","#glyphicon2","#help-block2","New Password should not be blank.");
	}
	else
	{
		has_success("#has-feedback2","#glyphicon2","#help-block2"," ");
	}
});
		
$('#confirm_Password').blur(function()
{
	if( $('#confirm_Password').val() == "" || $('#confirm_Password').val() == 0 )
	{
		$("#confirm_Password").val("");
		has_error("#has-feedback3","#glyphicon3","#help-block3","Confirm Password should not be blank.");
	}
	else if( $('#new_Password').val() !=  $('#confirm_Password').val())
	{
		has_error("#has-feedback3","#glyphicon3","#help-block3","Confirm Password should be same as New Password.");
	}
	else
	{
		has_success("#has-feedback3","#glyphicon3","#help-block3"," ");
	}
});

function Change_password(old_Password,new_Password,confirm_Password)
{
	if( $('#old_Password').val() == "" || $('#old_Password').val() == null )
	{
		has_error("#has-feedback1","#glyphicon1","#help-block1","Please enter old Password.");
		return false;
	}
	else if( $('#new_Password').val() !=  $('#confirm_Password').val())
	{
		has_error("#has-feedback3","#glyphicon3","#help-block3","Confirm Password should be same as New Password.");
		return false;
	}
	else if($('#new_Password').val() == "" && $('#confirm_Password').val() == "")
	{
		has_error("#has-feedback2","#glyphicon2","#help-block2","New Password should not be blank.");
		has_error("#has-feedback3","#glyphicon3","#help-block3","Confirm Password should be blank.");
		return false;
	}
	else 
	{
		show_loader();
		var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
		var Enrollment_id = '<?php echo $Enroll_details->Enrollement_id; ?>';				
		$.ajax
		({
			type: "POST",
			data:{ old_Password:old_Password, Company_id:Company_id,Enrollment_id:Enrollment_id,new_Password:new_Password},
			url: "<?php echo base_url()?>index.php/Cust_home/changepassword",
			success: function(data)
			{	
				location.reload();
				/*if(data.length == 29)
				{								
					BootstrapDialog.show
					({
						closable: false,
						title: 'Application Information',
						message: 'Password Changed Successfuly',
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
					BootstrapDialog.show
					({
						closable: false,
						title: 'Application Information',
						message: 'Password Not Changed',
						buttons: [{
							label: 'OK',
							action: function(dialog)
							{
								location.reload(); 
							}
						}]
					});
				}*/
			}
		});
	}
}







function Change_hobbies()
{	
		show_loader();
		var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
		var Enrollment_id = '<?php echo $Enroll_details->Enrollement_id; ?>';	
		var checkValues = $('input[name=hobbies]:checked').map(function()
		{
			return $(this).val();
			
		}).get();

		if(checkValues == null || checkValues==0)
		{
			$("#feedback55").show();
			return false;
		}
		
		$.ajax({
			url : "<?php echo base_url()?>index.php/Cust_home/update_hobbies",
			type: 'post',
		   data:{ Company_id:Company_id,Enrollment_id:Enrollment_id,new_hobbies:checkValues},
			success:function(data)
			{
					location.reload(); 
				/*if(data.length == 1)
						{
							BootstrapDialog.show
							({
								closable: false,
								title: 'Application Information',
								message: 'Hobbies Upadated Successfully',
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
							BootstrapDialog.show
							({
								closable: false,
								title: 'Application Information',
								message: 'Hobbies Upadated Un-successfully',
								buttons: [{
									label: 'OK',
									action: function(dialog)
									{
										location.reload(); 
									}
								}]
							});
						}*/
			}
		});
       
	
 }



	
	
function Change_pin(old_pin,new_pin,confirm_pin)
{
	if( $('#old_pin').val() == "" || $('#old_pin').val() == null )
	{
		has_error("#has-feedback1","#glyphicon11","#help-block11","Please enter old Pin.");
		return false;
	}
	else if( $('#new_pin').val() !=  $('#confirm_pin').val())
	{
		has_error("#has-feedback31","#glyphicon31","#help-block31","Confirm Pin should be same as New Pin.");
		return false;
	}
	else if($('#new_pin').val() == "" && $('#confirm_pin').val() == "")
	{
		has_error("#has-feedback21","#glyphicon21","#help-block21","New Pin should not be blank.");
		has_error("#has-feedback31","#glyphicon31","#help-block31","Confirm Pin should be blank.");
		return false;
	}
	else 
	{
		show_loader();
		var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
		var Enrollment_id = '<?php echo $Enroll_details->Enrollement_id; ?>';				
		$.ajax
		({
			type: "POST",
			data:{ old_pin:old_pin, Company_id:Company_id,Enrollment_id:Enrollment_id,new_pin:new_pin},
			url: "<?php echo base_url()?>index.php/Cust_home/changepin",
			success: function(data)
			{	
				//alert(data.length);
				location.reload();
				/*if(data.length == 24)
				{
					BootstrapDialog.show
					({
						closable: false,
						title: 'Application Information',
						message: 'Pin Changed Successfuly',
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
					BootstrapDialog.show
					({
						closable: false,
						title: 'Application Information',
						message: 'Pin Not Changed',
						buttons: [{
							label: 'OK',
							action: function(dialog)
							{
								location.reload(); 
							}
						}]
					});
				}*/
			}
		});
	}
}

$('#old_Password').blur(function()
{	
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var Enrollment_id = '<?php echo $Enroll_details->Enrollement_id; ?>';
	var old_Password = $('#old_Password').val();
	
	if( $("#old_Password").val() == "" )
	{
		has_error("#has-feedback1","#glyphicon1","#help-block1","Old Password does not Match.");
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { old_Password: old_Password, Company_id:Company_id,Enrollment_id: Enrollment_id},
			url: "<?php echo base_url()?>index.php/Cust_home/checkoldpassword",
			success: function(data)
			{				
				if(data == 0)
				{
					$("#old_Password").val("");
					has_error("#has-feedback1","#glyphicon1","#help-block1","Password not Match..Please Enter Correct Password..!!");
				}
				else
				{
					has_success("#has-feedback1","#glyphicon1","#help-block1","");
				}
			}
		});
	}
});

$('#old_pin').blur(function()
{	
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var Enrollment_id = '<?php echo $Enroll_details->Enrollement_id; ?>';
	var old_pin = $('#old_pin').val();
	
	if( $("#old_pin").val() == "" )
	{
		has_error("#has-feedback11","#glyphicon11","#help-block11","Old Pin does not Match.");
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { old_pin: old_pin, Company_id:Company_id,Enrollment_id: Enrollment_id},
			url: "<?php echo base_url()?>index.php/Cust_home/checkoldpin",
			success: function(data)
			{			
				if(data == 0)
				{
					
					$("#old_pin").val("");
					has_error("#has-feedback11","#glyphicon11","#help-block11","Pin not Match..Please Enter Correct Pin..!!");
				}
				else
				{
					has_success("#has-feedback11","#glyphicon11","#help-block11","");
				}
			}
		});
	}
});

$('#userEmailId').change(function()
{	
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var userEmailId = $('#userEmailId').val();
	
	if( $("#userEmailId").val() == "" )
	{
		has_error("#has-feedbackEmail","#glyphiconEmail","#help-blockEmail","Please Enter Email Id..!!");
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { userEmailId: userEmailId, Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/Cust_home/check_email_id",
			success: function(data)
			{
				//alert(data);
				if(data == 0)
				{
					has_success("#has-feedbackEmail","#glyphiconEmail","#help-blockEmail","Available");
				}
				else
				{
					$("#userEmailId").val("");
					document.getElementById('userEmailId').placeholder="Email Id Already Exist!";
					has_error("#has-feedbackEmail","#glyphiconEmail","#help-blockEmail","Not Available");
				}
			}
		});
	}
});

$('#phno').change(function()
{	
	var Country = '<?php echo $Enroll_details->Country; ?>';
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var phno = $('#phno').val();
	
	if( $("#phno").val() == "" )
	{
		has_error("#has-feedbackPhno","#glyphiconPhno","#help-blockPhno","Please Enter Phone Number..!!");
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { phno: phno,Company_id:Company_id, Country:Country},
			url: "<?php echo base_url()?>index.php/Cust_home/check_phone_number",
			success: function(data)
			{	
				if(data == 0)
				{
					has_success("#has-feedbackPhno","#glyphiconPhno","#help-blockPhno","Available");
				}
				else
				{
					$("#phno").val('')
					document.getElementById('phno').placeholder="Phone Number Already Exist!";
					has_error("#has-feedbackPhno","#glyphiconPhno","#help-blockPhno","Not Available");
				}
			}
		});
	}
});




function send_pin()
{
		show_loader();
		var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
		var Enrollment_id = '<?php echo $Enroll_details->Enrollement_id; ?>';				
		$.ajax
		({
			type: "POST",
			data:{Company_id:Company_id,Enrollment_id:Enrollment_id},
			url: "<?php echo base_url()?>index.php/Cust_home/send_pin",
			success: function(data)
			{	
				
				location.reload(); 
				/*if(data.length == 21)
				{
					
					BootstrapDialog.show
					({
						closable: false,
						title: 'Application Information',
						// message: 'Successfuly Send Pin Send on your Email ID please...Please check email Id ',
						message: 'Your Pin sent on your email ID Successfully',
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
					BootstrapDialog.show
					({
						closable: false,
						title: 'Application Information',
						message: 'Send Pin  on your Email is Un-successful...Please Contact Administrator',
						buttons: [{
							label: 'OK',
							action: function(dialog)
							{
								location.reload(); 
							}
						}]
					});
				}*/
			}
		});
}


</script>
<style>
.prog-circle
{
	margin: 0 0.1em 0.1em 50px !Important; 
}
.prog-circle .fill, .prog-circle .bar {
  border                : 0.08em solid #31859c;
}
img{margin:10px;cursor:pointer;}
.selected{
     box-shadow:0px 12px 22px 1px #367F8C; 
	
}
.roundedTwo {
  width: 20px;
  height: 20px;
  position: relative;
  margin: 20px auto;
  background: #fcfff4;
  background: linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
  border-radius: 50px;
  box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);  
  
   
   
  }
 @media (min-width: 320px) and (max-width: 460px)  {
	 
  #profile
  {
	margin-left: -100px;
  }
  .prog-circle
	{
		margin: 0 0.1em 0.1em 85px !Important; 
	}
    
 }


</style>
<script>
$('img').click(function(){
    $('.selected').removeClass('selected');
    $(this).addClass('selected');
});

function getchecked(imdID)
	{
		if(document.getElementById('chk_'+imdID).checked== true)
		{
			document.getElementById('chk_'+imdID).checked=false;
		}
		else
		{
			document.getElementById('chk_'+imdID).checked = true; 
		}
		
		
		
        
        
	}
	/***********************AMIT 17-11-2017************************/
function Get_states(Country_id)
{
	  // alert(Country_id);
	$.ajax({
		type: "POST",
		data: {Country_id: Country_id},
		url: "<?php echo base_url()?>index.php/Cust_home/Get_states",
		success: function(data)
		{
			// alert(data.States_data);
			$("#Show_States").html(data.States_data);	
			
		}
	});
}
function Get_cities(State_id)
{
	 // alert(State_id);
	$.ajax({
		type: "POST",
		data: {State_id: State_id},
		url: "<?php echo base_url()?>index.php/Cust_home/Get_cities",
		success: function(data)
		{
			// alert(data.City_data);
			$("#Show_Cities").html(data.City_data);	
			
		}
	});
}
/************************************************************************/	








$(document).ready(function() {
  $("#showHide").click(function() {
	if ($("#new_Password").attr("type") == "password") {
      $("#new_Password").attr("type", "text");

    } else {
      $("#new_Password").attr("type", "password");
    }
  });
});


/* $(function() 
{
	$( "#datepicker1" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	}); 
	$( "#datepicker2" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	}); 
}); */


Validate_array = new Array();

$("#change_pwd").click(function()
{
	var ucase = new RegExp("[A-Z]+");
	var lcase = new RegExp("[a-z]+");
	var num = new RegExp("[0-9]+");
	// var special = new RegExp("/^[a-zA-Z0-9- ]*$/");
	var new_password=$("#new_Password").val();
	var Confirm_Password=$("#confirm_Password").val();
	var Error_count=0;
	
		if(new_password.length >= 6 )
		{			
			$("#6_characters").removeClass("glyphicon glyphicon-remove");
			$("#6_characters").addClass("glyphicon glyphicon-ok");	
			// Element was found, remove it.
			
		}
		else
		{			
			$("#6_characters").removeClass("glyphicon glyphicon-ok");
			$("#6_characters").addClass("glyphicon glyphicon-remove");
			// return false;
			Error_count++;
		}
		if(num.test(new_password) == true )
		{
			$("#One_Number").removeClass("glyphicon glyphicon-remove");
			$("#One_Number").addClass("glyphicon glyphicon-ok");
			
		}
		else
		{										
			$("#One_Number").removeClass("glyphicon glyphicon-ok");
			$("#One_Number").addClass("glyphicon glyphicon-remove");		
			// return false;	

				Error_count++;
		}
		if(ucase.test(new_password) == true )
		{
			$("#One_Capital").removeClass("glyphicon glyphicon-remove");
			$("#One_Capital").addClass("glyphicon glyphicon-ok");
			
		}
		else
		{
			$("#One_Capital").removeClass("glyphicon glyphicon-ok");
			$("#One_Capital").addClass("glyphicon glyphicon-remove");
			// return false;	
				Error_count++;
		}		
		if (/^[a-zA-Z0-9- ]*$/.test(new_password) == false) 
		{
			$("#Special_Character").removeClass("glyphicon glyphicon-remove");
			$("#Special_Character").addClass("glyphicon glyphicon-ok");
			
		}
		else
		{
			$("#Special_Character").removeClass("glyphicon glyphicon-ok");
			$("#Special_Character").addClass("glyphicon glyphicon-remove");		
			// return false;
			Error_count++;
		}
		if(lcase.test(new_password) == true  )
		{
			$("#One_Lower").removeClass("glyphicon glyphicon-remove");
			$("#One_Lower").addClass("glyphicon glyphicon-ok");
			
		}
		else
		{
			$("#One_Lower").removeClass("glyphicon glyphicon-ok");
			$("#One_Lower").addClass("glyphicon glyphicon-remove");			
			// return false;
				Error_count++;
		}		
	if(Error_count == 0)
	{
		// alert('----Error_count------'+Error_count);
		var n = Confirm_Password.localeCompare(new_password);
		if( n == 0 )
		{
			// alert('----n--if----'+n);
			
			show_loader();
			var old_Password=$("#old_Password").val();
			Change_password(old_Password,new_password,Confirm_Password)
			return true;
			// document.getElementById("password_match").style.display="";
		}
		else
		{
			// alert('----n---else---'+n);
			$('#password_match').modal('show');
			// document.getElementById("password_match").style.display="";
			return false;
		}
		return true;
	}
	else
	{
		return false;
	}
	
	
});





</script>
<style>

.glyphicon-ok{
	color: green;
}
.glyphicon-remove
{
	color: red;
}
</style>
<style type="text/css">
#showHide {
  width: 15px;
  height: 15px;
  float: left;
}
#showHideLabel {
  float: left;
  padding-left: 5px;
}
input[type=checkbox]
{
  -webkit-appearance:checkbox;
}
</style>
<div id="password_match" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header" style="background-color:#428bca;color:#fff">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Application Information</h4>
		  </div>
		  <div class="modal-body">
			<p>New Password and Confirm New Password did not match !</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>

	</div>
</div>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
   <script type="text/javascript">
  $(function() {
  
    $( "#datepicker1" ).datepicker({
      changeMonth: true,
	  yearRange: "-80:+0",
      changeYear: true
    });
	
	$( "#datepicker2" ).datepicker({
      changeMonth: true,
	  yearRange: "-80:+0",
      changeYear: true
    });
	
  });

  </script>
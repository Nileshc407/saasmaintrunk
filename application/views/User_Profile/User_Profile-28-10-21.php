<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">User Profile</h6>
                    <div class="element-box">
                        <?php
                          if (@$this->session->flashdata('success_code')) {
                            ?>	
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('success_code') . ' ' . $this->session->flashdata('data_code'); ?>
                            </div>
                          <?php } ?>
                        <?php
                          if (@$this->session->flashdata('error_code')) {
                            ?>	
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('error_code') . ' ' . $this->session->flashdata('data_code'); ?>
                            </div>
                          <?php } ?>


                        <?php
                          $attributes = array('id' => 'formValidate');
                          echo form_open_multipart('User_Profile/Update_Profile', $attributes);
                        ?>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for=""> <span class="required_info">*</span> First Name</label>
									<input class="form-control" data-error="Enter first name" placeholder="Enter first name" required="required" type="text" name="First_name" id="First_name" value="<?php echo $Records->First_name;?>">
									<div class="help-block form-text with-errors form-control-feedback" id="firstName">
									</div>
								</div>
								<div class="form-group">
									<label for=""> <span class="required_info">*</span> Last Name</label>
									<input class="form-control" data-error="Enter Last Name" placeholder="Enter Last Name" required="required" type="text" name="Last_name" id="Last_name" value="<?php echo $Records->Last_name;?>">
									<div class="help-block form-text with-errors form-control-feedback" id="LastName">
									</div>
								</div>
								<div class="form-group">
									<label for=""> <span class="required_info">*</span> Address</label>
									<textarea class="form-control" rows="3" name="Current_address"  id="Current_address" data-error="Please enter address" required="required" ><?php echo App_string_decrypt($Records->Current_address); ?></textarea>
									<div class="help-block form-text with-errors form-control-feedback" id="CurrentAddress">
									</div>
								</div>
								<div class="form-group">
									<label for=""> <span class="required_info">*</span> Country</label>
									<select class="form-control " name="country" id="country" required="required" data-error="Please select country" onchange="Get_states(this.value);">
									<option value="">Select Country</option>
									 <?php
										if($Country_array != NULL)
										{
											foreach($Country_array as $Country)
											{
											?>											
												<option value="<?php echo $Country['id'];?>" <?php if($Records->Country_id == $Country['id']){echo "selected";} ?>><?php echo $Country['name'];?></option>											
											<?php
											}
										}
										?>
									</select>
								
									<div class="help-block form-text with-errors form-control-feedback" id="countryID">
									</div>
								</div>
								<div class="form-group" id="Show_States">
									<label for=""> <span class="required_info">*</span> State</label>
									<select class="form-control " name="state" id="state" required="required" data-error="Please select state" onchange="Get_cities(this.value);">
									<option value="">Select State</option>
									 <?php
										if($States_array != NULL)
										{
											foreach($States_array as $rec)
											{
											?>											
												<option value="<?php echo $rec->id;?>" <?php if($Records->State == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>											
											<?php
											}
										}
										?>
									</select>
								
									<div class="help-block form-text with-errors form-control-feedback" id="StateID">
									</div>
								</div>
								<div class="form-group" id="Show_Cities">
									<label for=""> <span class="required_info">*</span> City</label>
									<select class="form-control " name="city" id="city" required="required" data-error="Please select city">
									<option value="">Select City</option>
									 <?php
										if($City_array != NULL)
										{
											foreach($City_array as $rec)
											{
												?>											
													<option value="<?php echo $rec->id;?>" <?php if($Records->City == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>									
												<?php
											}
										}
										?>
									</select>								
									<div class="help-block form-text with-errors form-control-feedback" id="CityID">
									</div>
								</div>
								<div class="form-group">
									<label for="">  Qualification</label>
									<input class="form-control" placeholder="Enter Qualification" type="text" name="Qualification" id="Qualification" value="<?php echo $Records->Qualification;?>">
									</div>
								
								<div class="form-group">
									<label for="">Phone No.</label>
									<input class="form-control" data-error="Enter Phone No" placeholder="Enter Phone No" required="required" type="text" name="Phone_no" id="Phone_no" value="<?php echo App_string_decrypt($Records->Phone_no);?>" readonly>
									<div class="help-block form-text with-errors form-control-feedback" id="PhoneNo">
									</div>
								</div>								
							</div>
							<div class="col-sm-6">
								<?php if($Company_details->Seller_topup_access==1){?>
									<div class="form-group">
										<label for="">Current Balance</label>
										<input class="form-control" type="text" value="<?php echo $Records->Current_balance;?>" >									
									</div>
								<?php } ?>
								<div class="form-group">
									<label for="">Photograph </label>
									<?php if($Records->Photograph == ""){ ?>
									<div class="thumbnail" >
										 <img alt="<?php echo $Records->First_name; ?>" class="img-fluid img-thumbnail" id="profile_pic" src="<?php echo base_url(); ?>images/no_image.jpeg">
									</div>
									<?php } else { ?>
									<div class="thumbnail" style="width:100px;">
										<img alt="<?php echo $Records->First_name; ?>" class="img-fluid img-thumbnail" id="profile_pic" src="<?php echo base_url().$Records->Photograph; ?>">
									</div>
									<?php } ?>
									<input type="file" name="file" onchange="readImage(this,'#profile_pic');"/>
									<input type="hidden" name="file_exist" value="<?php echo $Records->Photograph;?>"/>
								</div>
								<div class="form-group">
									<label for="">User email id</label>
									<input class="form-control" type="text" value="<?php echo App_string_decrypt($Records->User_email_id);?>" readonly>
									
								</div>
								<div class="form-group">
									
									<button class="btn btn-primary"  data-toggle="modal" data-target="#myModal33" type="button">Change Password</button>
									<?php if($Company_details->Pin_no_applicable == 1){ ?>
									<button class="btn btn-primary" data-toggle="modal" data-target="#myModal4" type="button">Change Pin</button>
									<button class="btn btn-primary" data-toggle="modal" data-target="#send_pin" type="button">Resend Pin</button>
									<?php } ?>
								</div>
								
							</div>
						</div>
						<div class="form-buttons-w" align="center">
							<button class="btn btn-primary" id="submit" type="submit"> Update</button>
						</div>
					</div>
						
						<?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</div>



				  
			<!-- Modal -->
				<div id="myModal33" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" >
				  <div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
					
					  <div class="modal-header">
						<h4 class="modal-title">Change Password</h4>
					  </div>
					  <div class="modal-body">
						  <div class="form-group has-feedback" id="has-feedback1">
						  <label for="">Old Password</label>
                          <input type="password" class="form-control" name="old_Password" id="old_Password" placeholder="Old Password">
						  
						  <div class="help-block form-text with-errors form-control-feedback" id="OldPassword"></div>
                       
					  </div>
					    <div class="form-group has-feedback" id="has-feedback2">
						 <label for="">New Password</label>
                          <input type="password" class="form-control" name="new_Password"  id="new_Password" placeholder="New Password">
						  <div class="help-block form-text with-errors form-control-feedback" id="NewPassword"></div>
                       
					  </div>
					    <div class="form-group has-feedback"  id="has-feedback3">
						 <label for="">Confirm Password</label>
                          <input type="password" class="form-control" name="confirm_Password"   id="confirm_Password" placeholder="Confirm Password">
						   <div class="help-block form-text with-errors form-control-feedback" id="ConfirmPassword"></div>
                       
					  </div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-default" name="change_pwd" id="change_pwd" onclick="Change_password(old_Password.value,new_Password.value,confirm_Password.value)" >Submit</button>
						<div class="help-block form-text with-errors form-control-feedback" id="ChangePassword"></div>
					  </div>
					</div>

				  </div>
				</div>
				
				<div id="myModal4" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" >
				  <div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content">
					
					  <div class="modal-header">
						<h4 class="modal-title">Change Pin</h4>
					  </div>
					  <div class="modal-body">
							<div class="form-group has-feedback" id="has-feedback12">
							
							<input type="password" class="form-control" name="old_Pin" id="old_Pin" placeholder="Enter Old Pin">
							<div class="help-block form-text with-errors form-control-feedback" id="OldPin"></div>
                       
							</div>
					    <div class="form-group has-feedback" id="has-feedback21">
						
						 <input type="password" class="form-control" name="New_Pin"  id="New_Pin" placeholder="Enter New Pin">
						 <div class="help-block form-text with-errors form-control-feedback" id="NewPin"></div>
                       
					  </div>
					    <div class="form-group has-feedback"  id="has-feedback31">
						
						 <input type="password" class="form-control" name="confirm_Pin"   id="confirm_Pin" placeholder="Confirm New Pin">
						  <div class="help-block form-text with-errors form-control-feedback" id="ConfirmPin"></div>
                       
					  </div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-default" name="change_pin" id="change_pin" onclick="Change_pin(old_Pin.value,New_Pin.value,confirm_Pin.value)" >Submit</button>
						<div class="help-block form-text with-errors form-control-feedback" id="ChangePin"></div>
					  </div>
					</div>

				  </div>
				</div>
				
				
			<div id="send_pin" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg"  role="dialog" >
				  <div class="modal-dialog modal-md">
					<!-- Modal content-->
					<div class="modal-content">					
					  <div class="modal-header">
					
						<h4 class="modal-title" >Resend Pin</h4>
					  </div>
					  <div class="modal-body">
						  <div class="form-group has-feedback" >
						  <label for="exampleInputEmail1">Email Address</label>
						  <input type="text" class="form-control" readonly name="email_id" id="email_id" value="<?php echo $Records->User_email_id; ?>">
						 
                       
					  </div>
					    <div class="form-group has-feedback" >
						 <input type="text" class="form-control" name="Phone_no"  readonly id="Phone_no"  value="<?php echo $Records->Phone_no; ?>">
						 
                       
					  </div>					    
					  </div>
					  <div class="modal-footer"> 
						<button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-default" onclick="javascript:resend_pin();" >Send Pin</button>
						<div class="help-block form-text with-errors form-control-feedback" id="ResendPin"></div>
					  </div>
					</div>

				  </div>
			</div>





<div id="receipt_myModal" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<h5 class="modal-title" id="exampleModalLabel">
				   Receipt Details
				</h5>-->
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
			  </div>
			  <div class="modal-body">
				<div  id="show_transaction_receipt"></div>
			  </div>
			  <div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button>
			  </div>
			</div>
		</div>
    </div>
	
	
<?php $this->load->view('header/footer'); ?>

<script>
function readImage(input,div_id) 
{
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
/***********************AMIT 17-11-2017************************/
function Get_states(Country_id)
{
	 // alert(Country_id);
	$.ajax({
		type: "POST",
		data: {Country_id: Country_id},
		url: "<?php echo base_url()?>index.php/Company/Get_states",
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
		url: "<?php echo base_url()?>index.php/Company/Get_cities",
		success: function(data)
		{
			// alert(data.City_data);
			$("#Show_Cities").html(data.City_data);	
			
		}
	});
}
/************************************************************************/
function resend_pin()
{
	show_loader();
		var Company_id = '<?php echo $Company_id; ?>';
		var Enrollment_id = '<?php echo $Enrollement_id; ?>';	
				
		$.ajax
		({
			
			type: "POST",
			data:{Company_id:Company_id,Enrollment_id:Enrollment_id},
			url: "<?php echo base_url()?>index.php/User_Profile/send_pin",
			success: function(data)
			{	
				
				//alert("Send Pin-------"+data.length);
				if(data.length == 19)
				{			
					/* BootstrapDialog.show
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
					}); */	


						setTimeout(function(){
									$('#ResendPin').html("Successfuly Send Pin Send on your Email ID please...Please check email Id");
									$('#ResendPin').css("color","green");
								}, 0);
								
								setTimeout(function(){
								   window.location.reload();
								}, 3000);
				} 
				else
				{
					/* BootstrapDialog.show
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
					}); */
					
							setTimeout(function(){
									$('#ResendPin').html("Send Pin  on your Email is Un-successful...Please Contact Administrator");
									$('#ResendPin').css("color","red");
								}, 0);
								
								setTimeout(function(){
								   window.location.reload();
								}, 3000);
				}
			}
		});
}

		$('#new_Password').blur(function()
		{
			if( $('#new_Password').val() == "" || $('#new_Password').val() == 0 )
			{
				$("#new_Password").val("");
				// has_error("#has-feedback2","#glyphicon2","#help-block2","Please Enter Valid Password");
				
				$('#NewPassword').html("Please Enter New Valid Password");
				$("#new_Password").addClass("form-control has-error");
			}
			else
			{
				// has_success("#has-feedback2","#glyphicon2","#help-block2"," ");
			}
		});
		
		$('#confirm_Password').blur(function()
		{
			if( $('#confirm_Password').val() == "" || $('#confirm_Password').val() == 0 )
			{
				$("#confirm_Password").val("");
				// has_error("#has-feedback3","#glyphicon3","#help-block3","Please Enter Valid Password");
				
				$('#ConfirmPassword').html("Please Enter Confirm Valid Password");
				$("#confirm_Password").addClass("form-control has-error");
				
			}
			else if( $('#new_Password').val() !=  $('#confirm_Password').val())
			{
				$("#confirm_Password").val("");
				// has_error("#has-feedback3","#glyphicon3","#help-block3","Confirm Password should be same as New Password.");
				
				$('#ConfirmPassword').html("Confirm Password should be same as New Password");
				$("#confirm_Password").addClass("form-control has-error");
				
			}
			else
			{
				// has_success("#has-feedback3","#glyphicon3","#help-block3"," ");
			}
		});
		
			$('#old_Password').blur(function()
			{	
			//alert();
				var Company_id = '<?php echo $Company_id; ?>';
				var Enrollment_id = '<?php echo $Enrollement_id; ?>';
				var old_Password = $('#old_Password').val();
				//alert(old_Password);
				if( old_Password == "" )
				{
					$("#old_Password").val("");
					 // var error_text="<font color='red'>Please Enter Old Password !!!</font>";
					// has_error("#has-feedback1","#glyphicon1","#help-block1","Please Enter Old Password"); 
					//document.getElementById("old_Password").placeholder="Please Enter Old Password";
					
					$('#OldPassword').html("Please Enter Old Password");
					$("#old_Password").addClass("form-control has-error");
				}
				else
				{
					$.ajax({
						type: "POST",
						data: { old_Password: old_Password, Company_id:Company_id,Enrollment_id: Enrollment_id},
						url: "<?php echo base_url()?>index.php/User_Profile/check_old_password",
						success: function(data)
						{
							//alert("old_Password----------"+data.length);
							if(data.length == 42)
							{
								$("#old_Password").val("");
								// var error_text="<font color='red'>Please Enter Correct Password !!!</font>";
								// has_error("#has-feedback1","#glyphicon1","#help-block1","Please Enter Correct Password");
								
								$('#OldPassword').html("Please Enter Old Password");
								$("#old_Password").addClass("form-control has-error");
							}
							else
							{
								// has_success("#has-feedback1","#glyphicon1","#help-block1",data);
							}
						}
					});
				}
			});
			
				
		function Change_password(old_Password,new_Password,confirm_Password)
		{			
			if( old_Password == "" || old_Password == null )
			{
				/* has_error("#has-feedback1","#glyphicon1","#help-block1","");
				document.getElementById("old_Password").placeholder="Please Enter Old Password"; */
				
				$('#OldPassword').html("Please Enter Old Password");
				$("#old_Password").addClass("form-control has-error");
			}
			else if( $('#new_Password').val() !=  $('#confirm_Password').val())
			{
				// has_error("#has-feedback3","#glyphicon3","#help-block3","Confirm Password should be same as New Password.");
				$('#ConfirmPassword').html("Confirm Password should be same as New Password");
				$("#confirm_Password").addClass("form-control has-error");
				return false;
			}
			else if($('#new_Password').val() == "" && $('#confirm_Password').val() == "")
			{
				// has_error("#has-feedback2","#glyphicon2","#help-block2","New Password should not be blank.");
				// has_error("#has-feedback3","#glyphicon3","#help-block3","Confirm Password should be blank.");
				
				$('#NewPassword').html("New Password should not be blank");
				$("#new_Password").addClass("form-control has-error");
				
				
				$('#ConfirmPassword').html("Confirm Password should not be blank");
				$("#confirm_Password").addClass("form-control has-error");
				return false;
			}
			else 
			{
				show_loader();
				var Company_id = '<?php echo $Company_id; ?>';
				var Enrollment_id = '<?php echo $Enrollement_id; ?>';				
				$.ajax({
						type: "POST",
						data:{ old_Password:old_Password, Company_id:Company_id,Enrollment_id:Enrollment_id,new_Password:new_Password},
						url: "<?php echo base_url()?>index.php/User_Profile/change_password",
						success: function(data)
						{
						//	alert("Change Password Success----------"+data);
							
							if(data.length == 29)
							{
								
								/* BootstrapDialog.show({
								closable: false,
								title: 'Valid Data Operation',
								message: 'Password Changed Successfuly !!!',
								buttons: [{
								label: 'OK',
								action: function(dialog) {
								location.reload(); 
										}
									}]
								}); */
								
								
								// $('#ChangePassword').html("Password Changed Successfuly");
								// $('#ChangePassword').css("color","green");
								
								setTimeout(function(){
									$('#ChangePassword').html("Password Changed Successfuly");
									$('#ChangePassword').css("color","green");
								}, 0);
								
								setTimeout(function(){
								   window.location.reload();
								}, 3000);
								
				
								
							} 
							else
							{	
														
								
								setTimeout(function(){
									$('#ChangePassword').html("New Password cannot be same as Old Password");
									$('#ChangePassword').css("color","red");
								}, 0);
								
								setTimeout(function(){
								   window.location.reload();
								}, 3000);
								
								
			
								/* BootstrapDialog.show({
								closable: false,
								title: 'In-Valid Data Operation',
								message: 'New Password cannot be same as Old Password !!!',
								buttons: [{
								label: 'OK',
								action: function(dialog) {
								location.reload(); 
										}
									}]
								}); */
							}
						}
					});
				
				
			}
		}
		
	  </script>
	  <script>
	  $('#old_Pin').blur(function()
			{	
			//alert();
				var Company_id = '<?php echo $Company_id; ?>';
				var Enrollment_id = '<?php echo $Enrollement_id; ?>';
				var old_Pin = $('#old_Pin').val();
				if( old_Pin == "" )
				{
					$("#old_Pin").val("");
					 // var error_text="<font color='red'>Please Enter Old Pin !!!</font>";
					// has_error("#has-feedback12","#glyphicon12","#help-block12","Please Enter Old Pin"); 
					$('#OldPin').html("Please Enter Old Pin");
					$("#old_Pin").addClass("form-control has-error");
				}
				else
				{
					$.ajax({
						type: "POST",
						data: { old_Pin: old_Pin, Company_id:Company_id,Enrollment_id: Enrollment_id},
						url: "<?php echo base_url()?>index.php/User_Profile/check_old_pin",
						success: function(data)
						{
							// alert("old_Pin-Check----------"+data.length);
							if(data.length == 37)
							{
								
								$("#old_Pin").val("");								
								// var error_text="<font color='red'>Please Enter Correct Pin !!!</font>";
								// has_error("#has-feedback12","#glyphicon12","#help-block12","Please Enter Correct Pin"); 
								$('#OldPin').html("Please Enter Correct Pin");
								$("#old_Pin").addClass("form-control has-error");
								
							}
							else
							{
								$('#OldPin').html("");
								$("#old_Pin").removeClass("has-error");
								// has_success("#has-feedback12","#glyphicon12","#help-block12",data);
							}
						}
					});
				}
			});
			
			
		function Change_pin(old_Pin,New_Pin,confirm_Pin)
		{	
			if( old_Pin == "" || old_Pin == null )
			{
				// has_error("#has-feedback12","#glyphicon12","#help-block12","");
				// document.getElementById("old_Pin").placeholder="Please Enter Old Pin";
				$('#OldPin').html("Please Enter Old Pin");
				$("#old_Pin").addClass("form-control has-error");
			}			
			else if( $('#New_Pin').val() !=  $('#confirm_Pin').val())
			{
				// has_error("#has-feedback31","#glyphicon31","#help-block31","Confirm Pin should be same as New Pin");
				$('#ConfirmPin').html("Confirm Pin should be same as New Pin");
				// $("#old_Pin").addClass("form-control has-error");
				return false;
			}
			else if($('#New_Pin').val() == "" && $('#confirm_Pin').val() == "")
			{
				has_error("#has-feedback21","#glyphicon21","#help-block21","New Pin should not be blank.");
				has_error("#has-feedback31","#glyphicon31","#help-block31","Confirm Pin should be blank.");
				
				$('#NewPin').html("New Pin should not be blank");
				$("#New_Pin").addClass("form-control has-error");
				
				$('#ConfirmPin').html("Confirm Pin should be blank");
				$("#confirm_Pin").addClass("form-control has-error");
				
				return false;
			}
			else 
			{
				show_loader();
				var Company_id = '<?php echo $Company_id; ?>';
				var Enrollment_id = '<?php echo $Enrollement_id; ?>';				
				$.ajax({
						type: "POST",
						data:{ old_Pin:old_Pin, Company_id:Company_id,Enrollment_id:Enrollment_id,New_Pin:New_Pin},
						url: "<?php echo base_url()?>index.php/User_Profile/change_pin",
						success: function(data)
						{
							//alert("old_Pin-Success----------"+data.length);
							if(data.length == 24)
							{
								
								/* BootstrapDialog.show({
								closable: false,
								title: 'Valid Data Operation',
								message: 'Pin Changed Successfuly !!!',
								buttons: [{
								label: 'OK',
								action: function(dialog) {
								location.reload(); 
										}
									}]
								}); */
								
								setTimeout(function(){
									$('#ChangePin').html("Pin Changed Successfuly");
									$('#ChangePin').css("color","green");
								}, 0);
								
								setTimeout(function(){
								   window.location.reload();
								}, 3000);
								
							} 
							else
							{
								/* BootstrapDialog.show({
								closable: false,
								title: 'In-Valid Data Operation',
								message: 'New Pin cannot be same as Old Pin !!!',
								buttons: [{
								label: 'OK',
								action: function(dialog) {
								location.reload(); 
										}
									}]
								}); */
								
								
								setTimeout(function(){
									$('#ChangePin').html("New Pin cannot be same as Old Pin");
									$('#ChangePin').css("color","red");
								}, 0);
								
								setTimeout(function(){
								   window.location.reload();
								}, 3000);
							}
						}
					});
				
				
			}
		}
		

</script>


<script>
$('#Register').click(function()
{
	
		show_loader();
	
});

</script>

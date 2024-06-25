<?php $this->load->view('header/header');
$_SESSION["Enrollment_image"]=$results->Photograph;
$_SESSION["Edit_Enrollement_id"]=$results->Enrollement_id;
// print_r($_SESSION['Edit_Privileges_Delete_flag']);
 ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
				<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Enrollmentc/Update_CallCenterUserEnrollment/',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">EDIT CALLCENTER USER ENROLLMENT</h6>
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
									<select class="form-control" name="Company_id">
									  <?php
										foreach($Fetched_Companys as $Company)
										{
											?>
											<option value="<?php echo $Company['Company_id']; ?>" <?php if($results->Company_id == $Company['Company_id']){echo "selected";} ?> ><?php echo $Company['Company_name']; ?></option>
											<?php
										}
										?>
									</select>
								  </div>
								  
								 
								  
								  <div class="form-group" id="fname" >
									<label for=""><span class="required_info">* </span>First Name</label>
									<input type="text" class="form-control" name="firstName" id="firstName" value="<?php echo $results->First_name; ?>" data-error="Please enter first name" placeholder="Enter first name" required="required">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div> 
								  
								  <div class="form-group" id="mname" >
									<label for=""> Middle Name</label>
									<input type="text" class="form-control" name="middleName" id="middleName" value="<?php echo $results->Middle_name; ?>" data-error="Please enter middle name" placeholder="Enter middle name" />
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div> 
								  
								  <div class="form-group" id="lname" >
									<label for=""><span class="required_info" >* </span>Last Name</label>
									<input type="text" class="form-control" name="lastName" id="lastName" value="<?php echo $results->Last_name; ?>" data-error="Please enter last name" placeholder="Enter last name" required="required">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>Country</label>
									<select class="form-control" name="country" id="country_id" required="required" onchange="Get_states(this.value);" data-error="Please select country">
									<option value="">Select Country</option>
									  
									<?php
										foreach($Country_array as $Country)
										{
											?>
											 <?php if($results->Country == $Country['id']) {	?>

													<option value="<?php echo $Country['id'];?>" selected><?php echo $Country['name'];?></option>

											 <?php } 
										}
									?>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group" id="Show_States">
									<label for=""><span class="required_info">* </span>State</label>
									<select class="form-control" name="state" id="state" data-error="Please select state" onchange="Get_cities(this.value);">
									<?php
											foreach($States_array as $rec)
											{ ?>
												<option value="<?php echo $rec->id;?>" <?php if($results->State == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
									<?php   }
										?>									
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div> 

								  <div class="form-group" id="Show_Cities">
									<label for=""><span class="required_info" style="color:red;">* </span>City</label>
									<select class="form-control" name="city" id="city" data-error="Please select city">
									<?php
											foreach($City_array as $rec)
											{ ?>
												<option value="<?php echo $rec->id;?>" <?php if($results->City == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
									<?php 	}
										?>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
									<label><span class="required_info" style="color:red;">* </span>Address</label>
									<textarea class="form-control" rows="3" name="currentAddress" id="currentAddress" placeholder="Enter address" data-error="Please enter address" required="required"><?php echo App_string_decrypt($results->Current_address); ?></textarea>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
									<label for=""> Zip/Postal Code/P.O Box</label>
									<input type="text" class="form-control" name="zip" id="zip" data-error="Enter zip/postal code/p.o box" placeholder="Enter zip/postal code/p.o box" value="<?php echo $results->Zipcode; ?>" onkeyup="this.value=this.value.replace(/\D/g,'')">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group">
									<label for=""> District</label>
									<input type="text" class="form-control" name="district" id="district" data-error="Please enter district" placeholder="Enter district" value="<?php echo $results->District; ?>">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
															  
								</div>											
								<div class="col-sm-6">
								  
								
								  <div class="form-group">
								   <label for=""> Date of Birth (MM/DD/YYYY)</label>
									<input class="single-daterange form-control" placeholder="Select date of birth" type="text"  name="dob" id="datepicker"  value="<?php echo date("m/d/Y",strtotime($results->Date_of_birth)) ; ?>"/>
								  </div>
								 
								  <div class="form-group">
									<label for="">Gender</label>
									<select class="form-control" name="sex" id="sex">
										<option value="">Select</option>
										<option value="Male" <?php if($results->Sex == "Male"){echo "selected";} ?>>Male</option>
										<option value="Female" <?php if($results->Sex == "Female"){echo "selected";} ?>>Female</option>
									</select>
								  </div>
								
								  <div class="form-group">
									<label for="">Profession</label>
									<input type="text" class="form-control" name="qualifi" id="qualifi" data-error="Enter Profession" placeholder="Enter profession" value="<?php echo $results->Qualification; ?>">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								 
								 <div class="form-group">
									<label for=""><span class="required_info">* </span>Phone No. <span class="required_info" style="color:red;">(Please enter without '+' and country code) </span></label>
									<input type="text" class="form-control" name="phno" id="phno" data-error="Please enter phone no." placeholder="Enter phone no." onkeyup="this.value=this.value.replace(/\D/g,'')" maxlength="10" value="<?php echo $phnumber; ?>" required>
									<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
								 </div> 
								  
								  <div class="form-group">
									<label for=""><span class="required_info">* </span>User Email ID</label>
									<input type="text" class="form-control" name="userEmailId" id="userEmailId" data-error="Please enter user email" placeholder="Enter user email id" value="<?php echo App_string_decrypt($results->User_email_id); ?>" required>
									<div class="help-block form-text with-errors form-control-feedback" id="help-block2"></div>
								  </div>
								 
								  <div class="form-group">
									<label for="">Photograph<br><font color="RED" align="center" size="0.8em"><i>You can upload logo upto 500kb  </i></font> </label>
									<div class="upload-btn-wrapper">
										<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
										<input type="file" name="file" onchange="readImage(this,'#profile_pic');"/>
									</div>
									<?php if($results->Photograph == ""){ ?>
									<div class="thumbnail" style="width:100px;">
										 <img alt="" class="img-responsive" id="profile_pic" src="<?php echo base_url(); ?>images/no_image.jpeg">
									</div>
									<?php } else { ?>
									<div class="thumbnail" style="width:100px;">
										<img alt="" class="img-responsive" id="profile_pic" src="<?php echo base_url().$results->Photograph; ?>">
									</div>
									<?php } ?>
								  </div>
								  
							
								</div>
							</div>
						
						
					
						<div>
							<fieldset class="form-group">
								<legend><span class="required_info">* </span><span>Call Center  Specific Details</span></legend>
								<div class="row">
								<div class="col-sm-6" >
									<div class="form-group" id="sub_merchant">
										<label for="">Is it Supervisor ?</label>
										<label class="radio-inline">
											<input type="radio" name="Supervisor" id="Supervisor" onclick="hideshow_supervisor(this.value);" value="1" <?php if($results->Sub_seller_admin==1){echo "checked";} ?> >Yes</label>
											<label class="radio-inline">
											
											<input type="radio" name="Supervisor" id="Supervisor2" onclick="hideshow_supervisor(this.value);" id="Sub_seller_admin" value="0" <?php if($results->Sub_seller_admin==0){echo "checked";} ?> >No
										</label>
									</div>
								</div>
								<div class="col-sm-6">
									<?php if($results->Sub_seller_Enrollement_id !=0 ) { ?>
									<div class="form-group" id="Supervisor_list_div">
										<label for="">Select Supervisor </label>
										<select class="form-control" name="Sub_seller_Enrollement_id" id="Sub_seller_Enrollement_id" >
										<option value="">Select</option>
										<?php
										foreach($Call_center_details as $calluser)
										{	
										?>
											<option value="<?php echo $calluser['Enrollement_id']; ?>" <?php if($results->Sub_seller_Enrollement_id==$calluser['Enrollement_id']){echo "selected=selected";} ?>><?php echo $calluser['First_name'].' '.$calluser['Last_name']; ?></option>
										<?php
										}
										?>
										</select>
									</div>
									<?php
										}
										else
										{
										?>

											<div class="form-group" id="Supervisor_list_div" style="display:none">
												<label for="">Select Supervisor </label>
												<select class="form-control" name="Sub_seller_Enrollement_id" id="Sub_seller_Enrollement_id" data-error="Please select supervisor">
												<option value="">Select</option>
												<?php
												foreach($Call_center_details as $calluser)
												{
												?>
													<option value="<?php echo $calluser['Enrollement_id']; ?>"><?php echo $calluser['First_name'].' '.$calluser['Last_name']; ?></option>
												<?php
												}
												?>
												</select>
												<div class="help-block form-text with-errors form-control-feedback"></div>
											</div>

										<?php
										}
										?>
								</div>
							</div>
							</fieldset>
						</div>
					
					<?php if($_SESSION['Edit_Privileges_Edit_flag']==1){ ?>
						  <div class="form-buttons-w" align="center">
						 
							<button class="btn btn-primary" type="submit" id="Register">Save</button>
						  </div>
						<?php } ?>
					</div>
				</div>
				<?php echo form_close(); ?>	
				<!--------------Table------------->	 
				<?php if($_SESSION['Edit_Privileges_View_flag']==1){ ?>
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					   CallCenter Users
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<th>Action</th>
									<th>Name</th>
									<th>Phone Number</th>
									<th>Email ID</th>
									<th>Supervisor </th>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<th>Action</th>
									<th>Name</th>
									<th>Phone Number</th>
									<th>Email ID</th>
									<th>Supervisor </th>
								</tr>
							</tfoot>
							<tbody>
						<?php
							if($results12 != NULL)
							{ 
								foreach($results12 as $row)
								{
									
									/***********encrypt value*******************/
									$Encrypt_Enrollement_id = App_string_encrypt($row->Enrollement_id);
									$Encrypt_Enrollement_id = str_replace('+', 'X', $Encrypt_Enrollement_id);
									$_SESSION[$Encrypt_Enrollement_id]=$row->Enrollement_id;
							?>
								<tr>
									<td class="row-actions">
										<?php if($_SESSION['Edit_Privileges_Edit_flag']==1){ ?>
										<a href="<?php echo base_url()?>index.php/Enrollmentc/Edit_CallCenterUserEnrollment/?Enrollement_id=<?php echo $Encrypt_Enrollement_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
										<?php } if($_SESSION['Edit_Privileges_Delete_flag']==1){ ?>
										<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $Encrypt_Enrollement_id;?>','<?php echo $row->First_name.' '.$row->Last_name; ?>','<?php if($row->User_id==1 && $row->Parent_flag==1){echo 'Please Note that the Subsidiary & Employee linked to this Parent Member will get Inactive also';}?>','Enrollmentc/delete_enrollment/?Enrollement_id');" data-target="#deleteModal" data-toggle="modal" title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
										<?php } ?>
									</td>
									<td><?php echo $row->First_name.' '.$row->Last_name;?></td>
									<td><?php echo App_string_decrypt($row->Phone_no);?></td>
									<td><?php echo App_string_decrypt($row->User_email_id);?></td>
									<td><?php if($row->Sub_seller_Enrollement_id==0){echo 'Yes';}else{echo 'No';}?></td>
								</tr>
					<?php 		}
							}	?>
							</tbody>
						</table>
					  </div>
					</div>
				</div>
				<?php }	?>
				<!--------------Table--------------->
			</div>
		</div>	
	</div>
</div>
<?php $this->load->view('header/footer'); ?>
<script>



$('#Register').click(function()
{
	
	if(  $('#currentAddress').val() != "" && $('#phno').val() != "" && $('#userEmailId').val() != "" && $('#country_id').val() != "" && $("#city").val() != ""&& $("#state").val() != "" )
	{
		
			show_loader();
			return true;
		
		
	
	}
});

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
		var msg1 = 'Please enter valid email id';
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

</script>
<script>

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
			  data: {userEmailId: userEmailId, Company_id: Company_id, userId: 6},
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
		var msg1 = 'Please enter valid email id';
		$('#help-block2').show();
		$('#help-block2').html(msg1);
		$("#userEmailId").addClass("form-control has-error");
		// setTimeout(function(){ $('.help-block2').hide(); }, 3000);
		return false;
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
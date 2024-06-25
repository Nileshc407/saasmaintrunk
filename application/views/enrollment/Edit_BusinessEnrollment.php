<?php $this->load->view('header/header');

// print_r($_SESSION['Edit_Privileges_Delete_flag']);
 ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
				<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Enrollmentc/update_bussiness_enrollment/?Enrollment_id='.$results->Enrollement_id,$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">EDIT ENROLLMENT</h6>
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
								  
								   <div class="form-group" id="Business_org_name">
									<label for=""><span class="required_info">* </span>Name of Business Organisation</label>
									<input type="text" class="form-control" name="Business_org_name" id="Business_org_name2" data-error="Please enter Business Organisation name" placeholder="Enter Business Organisation name" value="<?php echo $results->First_name; ?>"  >
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
								<?php

									$User_id = $results->User_id;

									if($User_id == '1')
									{
								?>
										<div class="form-group">
											<label for="">Membership ID</label>
											<input type="text" readonly name="membership_id" value="<?php echo $results->Card_id; ?>" class="form-control" placeholder="Enter Membership ID" />
										</div>
							<?php
									}
								?>								  
								</div>											
								<div class="col-sm-6">
								   
									<div class="form-group" id="Select_bussiness3" >
									
									<div class="col-sm-12">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input class="form-check-input" name="Parent_flag" type="radio"   value="1"  checked  onclick='$("#Select_bussiness2").show();$("#Select_bussiness4").hide();$("#Select_tier3").hide();$("#Select_tier").show();'  <?php if($results->Parent_flag==1){echo "checked";}else{echo "disabled";} ?>>Parent</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:100px;">
										<label class="form-check-label">
										<input class="form-check-input" name="Parent_flag" type="radio"  value="0"  onclick='$("#Select_bussiness2").hide();$("#Select_bussiness4").show();$("#Select_tier3").hide();$("#Select_tier").hide();$("#Select_tier2").hide();'  <?php if($results->Parent_flag==0){echo "checked";}else{echo "disabled";} ?>>Subsidiary</label>
									  </div> 
									</div>
								  </div>
									
									
									<div class="form-group" id="Select_bussiness2" >
									
									<div class="col-sm-12">
									  <div class="form-check" style="float:left;">
										<label class="form-check-label">
										<input class="form-check-input" name="Participating_flag" type="radio"   value="1"   <?php if($results->Participating_flag==1){echo "checked";}?>>Participating Members</label>
									  </div>
									  
									  <div class="form-check" style="margin-left:180px;">
										<label class="form-check-label">
										<input class="form-check-input" name="Participating_flag" type="radio"  value="0"  <?php if($results->Participating_flag==0){echo "checked";}?>>Non-Participating Members</label>
									  </div> 
									</div>
								  </div>
								  
								
								  
								  <div class="form-group"  id="Select_bussiness4" style="display:none">
									<label for=""><span class="required_info">* </span>Select Parent</label>
									<select class="form-control" name="Parent_id" id="Parent_id" onchange="Change_parent();">
									
									  <?php
										if($Dmcc_parent_members != NULL) 
										{
											foreach($Dmcc_parent_members as $rec)
											{
												if($results->Parent_id==$rec->Enrollement_id)
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
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								
								 
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
								  <?php 
										if($results->Business_flag == '1' && $results->Parent_flag != 0){
									?>
										
										<div class="form-group" id="Select_tier">
										<label for=""> Select Business Tier</label> <!---- onchange="get_tier_details(this.value);"--->
										<select class="form-control" name="Bussiness_tier_id" id="member_tier_id" data-error="Please select tier">
										
										
										  <?php
											foreach($Bussi_Tier_list as $Tier)
											{
												if($results->Tier_id == $Tier->Tier_id)
												{
													echo '<option selected value="'.$Tier->Tier_id.'">'.$Tier->Tier_name.'</option>';
												}
												else //if($Super_seller == 1)
												{
													echo '<option value="'.$Tier->Tier_id.'">'.$Tier->Tier_name.'</option>';
												}
												
											}
											?>
										</select>
									</div>	
										<?php }else{ ?>
									<div class="form-group" id="Select_tier3"  >
										<label for=""> Parent Tier</label> <!---- onchange="get_tier_details(this.value);"--->
										<select class="form-control" name="Parent_tier_id" id="Parent_tier_id"  disabled>
										  <?php
											foreach($AllTier_list as $Tier)
											{
												if($results->Tier_id == $Tier->Tier_id)
												{
													echo '<option selected value="'.$Tier->Tier_id.'">'.$Tier->Tier_name.'</option>';
												}
												else //if($Super_seller == 1)
												{
													echo '<option value="'.$Tier->Tier_id.'">'.$Tier->Tier_name.'</option>';
												}
											}
											?>
										</select>
									</div>	
									<?php } ?>
									<input type="hidden" id="Parent_tier" name="Parent_tier" value="0">
								 
								<?php if($User_id == '1' && $results->Refrence > 0 ) { ?>
									<div class="form-group">
										<label for="">Referred By </label>
										<select class="form-control" readonly >
										<option value="<?php echo $Refree_name; ?>"><?php echo $Refree_name; ?></option>
										</select>
									</div>
								<?php } ?>
							
							
							
								</div>
							</div>
						
							<?php if($User_id == '1')
							{ ?>
							<div>								
								<fieldset class="form-group">
								<legend><span class="required_info">* </span><span>Member Specific Details</span></legend>
								<div class="row">
									<div class="col-sm-6" >
										<div class="form-group">

											<label for="">Total Credit-Topup <?php echo 	$Company_details->Currency_name; ?></label>
											<input type="text" name="Total_topup_amt" readonly value="<?php echo $results->Total_topup_amt; ?>" class="form-control"  />
										</div>
										<div class="form-group">
											<label for="">Total Issued <?php echo 	$Company_details->Currency_name; ?></label>
											<input type="text" name="Total_reddems" readonly value="<?php echo $Total_gained_points; ?>" class="form-control" />
										</div>
										<div class="form-group">
											<label for="">Total Used <?php echo 	$Company_details->Currency_name; ?></label>
											<input type="text" name="Total_reddems" readonly value="<?php echo $results->Total_reddems; ?>" class="form-control" />
										</div>
										

									</div>
									<div class="col-sm-6" >
										<div class="form-group">
											<label for="">Total Balance <?php echo 	$Company_details->Currency_name; ?></label>
											<input type="text" name="Current_balance" readonly value="<?php echo $results->Current_balance; ?>" class="form-control" />
										</div>
										
									</div>
								
								</div>
								</fieldset>
								<input type="hidden" readonly name="Time_Zone" readonly value="<?php echo $results->timezone_entry; ?>" class="form-control" />
							</div>
							<?php } ?>
							
					<?php if($_SESSION['Edit_Privileges_Edit_flag']==1){ ?>
						  <div class="form-buttons-w" align="center">
						  <input type="hidden" name="Enrollment_image" value="<?php echo $results->Photograph; ?>" class="form-control" />
						  <input type="hidden" name="Business_user_linked_id" value="<?php echo $results->Business_user_linked_id; ?>" class="form-control" />
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
					  Individual Enrollments
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<th>Action</th>
									<th>Type</th>
									<th>Name</th>
									<th>Membership ID</th>
									<th>Phone Number</th>
									<th>Email ID</th>
									<th>Tier Name</th>
									<th>Current <?php echo 	$Company_details->Currency_name; ?> Balance</th>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<th>Action</th>
									<th>Type</th>
									<th>Name</th>
									<th>Membership ID</th>
									<th>Phone Number</th>
									<th>Email ID</th>
									<th>Tier Name</th>
									<th>Current <?php echo 	$Company_details->Currency_name; ?> Balance</th>
								</tr>
							</tfoot>
							<tbody>
						<?php
							if($results12 != NULL)
							{ 
								foreach($results12 as $row)
								{
									
									if($row->Parent_flag=='1'){$Type="Parent";}else{$Type="Subsidiary";}
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
										<?php if($_SESSION['Edit_Privileges_Edit_flag']==1){ ?>
										<a href="<?php echo base_url()?>index.php/Enrollmentc/Edit_BusinessEnrollment/?Enrollement_id=<?php echo $row->Enrollement_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
										<?php } if($_SESSION['Edit_Privileges_Delete_flag']==1){ ?>
										<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $row->Enrollement_id;?>','<?php echo $row->First_name.' '.$row->Last_name; ?>','<?php if($row->User_id==1 && $row->Parent_flag==1){echo 'Please Note that the Subsidiary & Employee linked to this Parent Member will get Inactive also';}?>','Enrollmentc/delete_enrollment/?Enrollement_id');" data-target="#deleteModal" data-toggle="modal" title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
										<?php } ?>
									</td>
									<td><?php echo $Type;?></td>
									<td><?php echo $row->First_name.' '.$row->Last_name;?></td>
									<td><?php echo $Card_id;?></td>
									<td><?php echo App_string_decrypt($row->Phone_no);?></td>
									<td><?php echo App_string_decrypt($row->User_email_id);?></td>
									<td><?php echo $row->Tier_name;?></td>
									<td><?php echo $row->Current_balance;?></td>
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
var User_id = '<?php echo $results->User_id; ?>';
// alert(User_id);
if(User_id==1)
{
		$("#Select_bussiness").show();
		$("#Select_bussiness2").show();
		$("#Select_bussiness3").show();
		$("#Business_org_name").show();
		$("#fname").hide();$("#mname").hide();$("#lname").hide();
		$("#firstName").removeAttr("required");
					$("#lastName").removeAttr("required");
		$("#dob").hide();$("#gender").hide();$("#Profession").hide();
		$("#Select_tier").show();
		$("#Select_tier").attr("required","required");
		var Business_flag = 1;
		var Parent_flag = $("input[name=Parent_flag]:checked").val();
		// alert(Business_flag);
		if(Business_flag==0){$("#fname").show();$("#mname").show();$("#lname").show();$("#Business_org_name").hide();$("#Select_bussiness2").hide();$("#Select_bussiness3").hide();$("#dob").show();$("#gender").show();$("#Profession").show();$("#Select_tier2").show();$("#Select_bussiness5").show();$("#Select_bussiness4").show();$("#Select_tier2").attr("required","required");$("#Select_tier").removeAttr("required");
			var Employee_flag = $("input[name=Employee_flag]:checked").val();
			// alert(Employee_flag);
			if(Employee_flag==0){$("#Select_bussiness4").hide();}
		}
		
		if(Parent_flag==0){$("#Select_bussiness2").hide();$("#Select_bussiness4").show();}
		
		
		
}
else
{
	$("#Business_org_name").hide();
}
function Change_parent()
{
	var id=$('#Parent_id').children(':selected').attr('id');
	// alert(id);
	$('#Select_tier3').show();
	$('#Select_tier').hide();
	$('#Select_tier2').hide();
	$('#Parent_tier_id').val(id); 
	$('#Parent_tier').val(id); 
	// $('#Parent_tier_id').find('option').remove().end().append("<option value='whatever'>text</option>").val('whatever');
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
function Show_Admin_list(adminSel)
{
	if(adminSel =='1' )
	{
		$("#Seller_Admin_list").show();
	}
	else
	{
		$("#Seller_Admin_list").hide();
	}
}
function hide_show_refrence(refree)
{
	if(refree == 1)
	{
		$("#Refree").show();
	}
	else
	{
		$("#Refree").hide();
	}
}
function hideshow_supervisor(selectVal)
{
	if(selectVal =='1' )
	{
		$("#Supervisor_list_div").hide();
		$("#Sub_seller_Enrollement_id").removeAttr("required")
	}
	else
	{
		$("#Supervisor_list_div").show();
		$("#Sub_seller_Enrollement_id").attr("required","required");
	}
}
function hideshow_supervisor1(selectVal)
{
	if(selectVal =='1' )
	{
		$("#Supervisor_list_div1").hide();
		$("#Sub_seller_Enrollement_id1").removeAttr("required");
	}
	else
	{
		$("#Supervisor_list_div1").show();
		$("#Sub_seller_Enrollement_id1").attr("required","required");
	}
}
</script>
<script>
$('#Register').click(function()
{
	if(  $('#firstName').val() != "" && $('#lastName').val() != ""  && $('#currentAddress').val() != "" && $('#phno').val() != "" && $('#userEmailId').val() != "" && $('#city').val() != "" && $('#state').val() != ""  && $('#country_id').val() != "" )
	{

		if($('#User_id').val() == 1)
		{
			show_loader();
		}
		else if( ($('#User_id').val() == 2 || $('#User_id').val() == 4) && $("#Time_Zone").val() != "" && $('#Seller_Redemptionratio').val() != "" && $('#Topup_Bill_no').val() != "" && $('#Purchase_Bill_no').val() != "" && $('#Payment_Bill_no').val() != "" && $('#Seller_Paymentratio').val() != "")
		{

			var radioVAL = $("input[name=Super_seller]:checked").val();

			if(radioVAL == 0 || radioVAL == 1 )
			{
				show_loader();
			}
		}
		else if($('#User_id').val() == 6)
		{
			if($('#Sub_seller_Enrollement_id').val() != "")
			{
				show_loader();
			}
		}
		else if($('#User_id').val() == 7)
		{
			if($('#Sub_seller_Enrollement_id1').val() != "")
			{
				show_loader();
			}
		}
	}
});
</script>
<script>
$(document).ready(function()
{
	/*$( "#datepicker" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	}); */
});

function isNumberKey2(evt)
{
  var charCode = (evt.which) ? evt.which : event.keyCode
  // alert(charCode);
  if (charCode != 46 && charCode > 31
	&& (charCode < 48 || charCode > 57))
	 return false;

  return true;
}

$(document).ready(function()
{
	$('#phno').blur(function()
	{ 
		if( $("#phno").val() != "" )
		{
			var Phone_no = $("#phno").val();
			var Company_id = '<?php echo $results->Company_id; ?>';
			var Country_id = '<?php echo $results->Country; ?>';
			var Phone = '<?php echo $results->Phone_no; ?>';

			if(Phone != Phone_no)
			{
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
							// setTimeout(function(){ $('.help-block1').hide(); }, 3000);
							return false;
							
						}
						else
						 {
							$("#phno").removeClass("has-error");
							$("#help-block1").html("");
						 }
				  }
				});
			}
			// else
			// {
				// has_success(".has-feedback","#glyphicon","#help-block","");
			// }
		}
		else
		{
			var msg1 = 'Please enter phone number';
			$('#help-block1').show();
			$('#help-block1').html(msg1);
			$("#phno").addClass("form-control has-error");
			// setTimeout(function(){ $('.help-block1').hide(); }, 3000);
			return false;
		}
	});

	$('#userEmailId').blur(function()
	{
		if( $("#userEmailId").val() != "" )
		{
			var emailID = '<?php echo $results->User_email_id; ?>';

			if(emailID != $("#userEmailId").val() )
			{
			var userEmailId = $("#userEmailId").val();
			var userId = $("#User_id").val();
			var Company_id = '<?php echo $results->Company_id; ?>';

			$.ajax({
				  type: "POST",
				  data: {userEmailId: userEmailId, Company_id: Company_id, userId:1},
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
				$("#userEmailId").removeClass("has-error");
				$("#help-block2").html("");
			}
		}
		else
		{
			var msg1 = 'Please enter email id';
			$('#help-block2').show();
			$('#help-block2').html(msg1);
			$("#userEmailId").addClass("form-control has-error");
			// setTimeout(function(){ $('.help-block2').hide(); }, 3000);
			return false;
		}
	});
});

/*function delete_enrollment(Enroll_id,user_name,User_id)
{
	var User_type = "";
	var msg2 = "";
	if(User_id == 1)
	{
		User_type = "Member";
	}
	else
	{
		User_type = "User";
	}
	if(User_id == 2)
	{
		var msg2 = "<br><br>Please Note that Merchandise Item linked to this Outlet will be made inactive.";
	}
	else{
		var msg2 = "";
	}
								
	$.confirm({
		title: 'Enrollment Delete Confirmation',
		content: "Are you sure to Delete the "+User_type+" "+user_name+" ?"+msg2,
		icon: 'fa fa-question-circle',
		animation: 'scale',
		closeAnimation: 'scale',
		opacity: 0.5,
		buttons: {
			'confirm': {
				text: 'OK',
				btnClass: 'btn-default',
				action: function () {
					
					$.ajax({
							type: "POST",
							data: {Enrollement_id: Enroll_id},
							url: "<?php echo base_url()?>index.php/Enrollmentc/delete_enrollment",
							success: function(data)
							{
								$.MessageBox("Enrollment Deleted Successfuly!!");
								window.location.replace("<?php echo base_url()?>index.php/Enrollmentc/enrollment");
							}
						});
				}
			},
			cancel: function () {
			},
		}
	}); 
} */

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
			document.getElementById("Longitude").value=Location[1];
		}
	});
}

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
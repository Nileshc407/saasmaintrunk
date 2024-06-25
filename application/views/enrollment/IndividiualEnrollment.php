<?php $this->load->view('header/header'); 
// echo "Privileges_Delete_flag ".$_SESSION['Privileges_Add_flag'];
// print_r($Privileges_Delete_flag);
if($remain_lic<0){
	$remain_lic=0;
}
// echo "<br>-----remain_lic--1--)".$remain_lic."---";

/* $_SESSION['Privileges_Add_flag'] = $Privileges->Add_flag;
$_SESSION['Privileges_Edit_flag'] = $Privileges->Edit_flag;
$_SESSION['Privileges_View_flag'] = $Privileges->View_flag;
$_SESSION['Privileges_Delete_flag'] = $Privileges->Delete_flag; */

$_SESSION['Edit_Privileges_Add_flag'] = $_SESSION['Privileges_Add_flag'];
$_SESSION['Edit_Privileges_Edit_flag'] = $_SESSION['Privileges_Edit_flag'];
$_SESSION['Edit_Privileges_View_flag'] = $_SESSION['Privileges_View_flag'];
$_SESSION['Edit_Privileges_Delete_flag'] = $_SESSION['Privileges_Delete_flag'];

// print_r($_SESSION['Privileges_Delete_flag']);

$this->load->model('Saas_model');
$ci_object = &get_instance();
$Member_count = $ci_object->Saas_model->Get_member_enrollment_count($Company_id);
$License_details = $ci_object->Saas_model->Get_saas_license_details();
foreach($License_details as $License_details)	
{
	if($License_details->License_type_id==$Company_details->Company_License_type)
	{
		$Member_limit = $License_details->Member_limit;
	}

}
// echo $Member_count;
?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php
				$attributes = array('id' => 'formValidate');
				echo form_open_multipart('Enrollmentc/IndividiualEnrollment',$attributes); 
			?>
			
				<div class="element-wrapper">
					<h6 class="element-header">MEMBER ENROLLMENT 
					</h6>
					
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
					<?php
						if($Member_count >= $Member_limit)
						{ ?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
							  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
							  <span aria-hidden="true"> &times;</span></button>
							 Company work in progress. Will be up soon.Sorry for the inconvenience!
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
								  
								   <div class="form-group" id="fname" >
									<label for=""><span class="required_info">* </span>First Name</label>
									<input type="text" class="form-control" name="firstName" id="firstName" data-error="Please enter first name" placeholder="Enter first name" required="required">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div> 
								  
								  <div class="form-group" id="mname">
									<label for=""> Middle Name</label>
									<input type="text" class="form-control" name="middleName" id="middleName" data-error="Please enter middle name" placeholder="Enter middle name" />
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div> 
								  
								  <div class="form-group" id="lname">
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
								  
									
								  
								
								  
								  <div class="form-group" >
								   <label for=""> Date of Birth (MM/DD/YYYY)</label>
									<input class="single-daterange form-control" placeholder="Enter date of birth" type="text"  name="dob" id="datepicker"/>
								  </div>
								 
								  <div class="form-group"  >
									<label for="">Gender</label>
									<select class="form-control" name="sex" id="sex">
										<option value="0">Select</option>
										<option value="Male">Male</option>
										<option value="Female">Female</option> 
									</select>
								  </div>
								
								  <div class="form-group"  id="Profession" style="display:none">
									<label for="">Profession</label>
									<input type="text" class="form-control" name="qualifi" id="qualifi" data-error="Please enter profession" placeholder="Enter profession">
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								 
								 <div class="form-group">
									<label for=""><span class="required_info">* </span>Phone No. <span class="required_info">(Please enter without '+' and country code) </span></label>
									<input type="text" class="form-control" name="phno" id="phno" data-error="Please enter phone no." placeholder="Enter phone no." onkeyup="this.value=this.value.replace(/\D/g,'')" maxlength="10" required="required">
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
								  
								   
								  <div id="Membership_Id">
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
									if($Enroll_details->Refrence == '1' && $referral_rule_count > 0 )
									{ ?>
									<div class="form-group" id="refree_div" >
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
									
									
									
								<div class="form-group" id="Select_tier2">
										<label for=""> Select Tier</label> <!---- onchange="get_tier_details(this.value);"--->
										<select class="form-control" name="Indi_tier_id" id="member_tier_id" data-error="Please select tier" required>
										
										<option value="">Select Tier</option>
										  <?php
											foreach($IndTier_list as $Tier)
											{
												echo '<option value="'.$Tier->Tier_id.'">'.$Tier->Tier_name.'</option>';
											}
											?>
										</select>
									</div>	
									
									
									
									
									
								</div>
							</div>
							
							
						<?php if($Member_count <= $Member_limit){ ?>
						<?php if($_SESSION['Privileges_Add_flag']==1 ){ ?>
						  <div class="form-buttons-w" align="center">
							<button class="btn btn-primary" type="submit" id="Register">Submit</button>
							<button class="btn btn-primary" type="reset">Reset</button>
						  </div>
						<?php } }?>
					</div>
				</div>
				<?php echo form_close(); ?>	
				<!--</form>-->

				<!--------------Table------------->	 
				<?php if($_SESSION['Privileges_View_flag']==1){ ?>
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					  Member Enrollments
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<th>Action</th>
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
							if($results != NULL)
							{ 
								foreach($results as $row)
								{
									
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
									$Full_name= $row->First_name.' '.$row->Last_name;
									/***********encrypt value*******************/
									$Encrypt_Enrollement_id = App_string_encrypt($row->Enrollement_id);
									$Encrypt_Enrollement_id = str_replace('+', 'X', $Encrypt_Enrollement_id);
									$_SESSION[$Encrypt_Enrollement_id]=$row->Enrollement_id;
							?>
								<tr>
									<td class="row-actions">
										<?php if($_SESSION['Privileges_Edit_flag']==1){ ?>
										<a href="<?php echo base_url()?>index.php/Enrollmentc/Edit_IndividiulEnrollment/?Enrollement_id=<?php echo $Encrypt_Enrollement_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
										<?php } if($_SESSION['Privileges_Delete_flag']==1){ ?>
										<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $Encrypt_Enrollement_id;?>','<?php echo $row->First_name.' '.$row->Last_name; ?>','<?php if($row->User_id==1 && $row->Parent_flag==1){echo 'Please Note that the Subsidiary & Employee linked to this Parent Member will get Inactive also';}?>','Enrollmentc/delete_member/?Enrollement_id');" data-target="#deleteModal" data-toggle="modal" title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
										<?php } ?>
									</td>
									<td><?php echo $Full_name;?></td>
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
				<?php } ?>
				<!--------------Table--------------->
			</div>
		</div>	
	</div>
</div>
<?php $this->load->view('header/footer'); ?>
<script>


$('#Register').click(function()
{
	
	if(  $('#currentAddress').val() != "" && $('#phno').val() != "" && $('#userEmailId').val() != "" && $('#country_id').val() != "" && $("#city").val() != ""&& $("#state").val() != ""  && $("#member_tier_id").val() != "" )
	{
		// alert($('#User_id').val());

				
				var Refrence_flag = '<?php echo $Enroll_details->Refrence; ?>';
				var referral_rule_count = '<?php echo $referral_rule_count;?>';
								
			var RefrenceVAL = $("input[name=Refrence]:checked").val();
			// alert('RefrenceVAL '+RefrenceVAL);
			// alert('Refrence_flag '+Refrence_flag);
			// alert('referral_rule_count '+referral_rule_count);
			
			
				var Bussiness = 0;
				// alert('Bussiness '+Bussiness);
				if(Bussiness==1)//Bussiness
				{
					$("#firstName").removeAttr("required");
					$("#lastName").removeAttr("required");
					
				}
				else
				{
					$("#Business_org_name2").removeAttr("required");
					// $("#member_tier_id").removeAttr("required");
					// $("#member_tier_id").attr("required","required");
				}
				 if(Refrence_flag ==1 && referral_rule_count > 0 &&  RefrenceVAL == 1)
				{
					// alert('Refree_name '+$('#Refree_name').val());
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
});



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
var remain_lic=<?php echo $remain_lic;?>;
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
		var userId = 1;
		var Company_id = '<?php echo $Company_id; ?>';

		$.ajax({
			  type: "POST",
			  data: {userEmailId: userEmailId, Company_id: Company_id, userId: 1},
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
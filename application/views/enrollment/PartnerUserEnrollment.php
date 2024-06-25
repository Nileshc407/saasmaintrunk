<?php $this->load->view('header/header'); 

/* $_SESSION['Privileges_Add_flag'] = $Privileges->Add_flag;
$_SESSION['Privileges_Edit_flag'] = $Privileges->Edit_flag;
$_SESSION['Privileges_View_flag'] = $Privileges->View_flag;
$_SESSION['Privileges_Delete_flag'] = $Privileges->Delete_flag; */

$_SESSION['Edit_Privileges_Add_flag'] = $_SESSION['Privileges_Add_flag'];
$_SESSION['Edit_Privileges_Edit_flag'] = $_SESSION['Privileges_Edit_flag'];
$_SESSION['Edit_Privileges_View_flag'] = $_SESSION['Privileges_View_flag'];
$_SESSION['Edit_Privileges_Delete_flag'] = $_SESSION['Privileges_Delete_flag'];

// print_r($_SESSION['Privileges_Delete_flag']);
$ci_object = &get_instance();
?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php
				$attributes = array('id' => 'formValidate');
				echo form_open_multipart('Enrollmentc/PartnerUserEnrollment',$attributes); 
			?>
				<div class="element-wrapper">
					<h6 class="element-header">Partner USER ENROLLMENT 
					</h6>
					<?php /*if($Super_seller == 1 || $userId == 3 )
						{ ?>
						<div class="alert alert-warning" role="alert">
						<strong> <?php echo "Max no. of Members(s) Enrollment Allowed = <b> $linc_limit ;  </b> Balance No. of Members(s) Enrollment entitled = <b>$remain_lic ; </b>"; ?></strong>
						</div>
				<?php	}*/
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
								  
								 
								  
								  <div class="form-group" id="fname">
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
								 
								   <div class="form-group" id="MPartner_block1"  >
									<label for=""><span class="required_info" style="color:red;">* </span>Link to Merchandize Partner</label>
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
								  
								  <div class="form-group" id="MPartner_block2">
									<label for=""><span class="required_info" style="color:red;">* </span>Link to Merchandize Partner Branch</label>
									<select class="form-control" name="Merchandize_Partner_Branch" id="Merchandize_Partner_Branch" data-error="Please select partner branches">
									<option value="">Link to partner branches</option>
									 
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								  </div>
								  
								  <div class="form-group"  id="dob" >
								   <label for=""> Date of Birth (MM/DD/YYYY)</label>
									<input class="single-daterange form-control" placeholder="Enter date of birth" type="text"  name="dob" id="datepicker"/>
								  </div>
								 
								  <div class="form-group"  id="gender" >
									<label for="">Gender</label>
									<select class="form-control" name="sex" id="sex">
										<option value="0">Select</option>
										<option value="Male">Male</option>
										<option value="Female">Female</option> 
									</select>
								  </div>
								
								  <div class="form-group"  id="Profession" >
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
								  
								   
									
								</div>
							</div>
							
						
							
						<?php if($_SESSION['Privileges_Add_flag']==1){ ?>
						  <div class="form-buttons-w" align="center">
							<button class="btn btn-primary" type="submit" id="Register">Submit</button>
							<button class="btn btn-primary" type="reset">Reset</button>
						  </div>
						<?php } ?>
					</div>
				</div>
				<?php echo form_close(); ?>	
				<!--</form>-->

				<!--------------Table------------->	 
				<?php if($_SESSION['Privileges_View_flag']==1){ ?>
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					   Partner Users
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<th>Action</th>
									<th>Name</th>
									<th>Phone Number</th>
									<th>Email ID</th>
									<th>Partner Name</th>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<th>Action</th>
									<th>Name</th>
									<th>Phone Number</th>
									<th>Email ID</th>
									<th>Partner Name</th>
								</tr>
							</tfoot>
							<tbody>
						<?php
							if($results != NULL)
							{ 
								foreach($results as $row)
								{
									$Partner_details = $ci_object->Catelogue_model->Get_Company_Partners_details($row->Merchandize_Partner_ID);
						
									$Partner_name= $Partner_details->Partner_name;
									$Encrypt_Enrollement_id = App_string_encrypt($row->Enrollement_id);
									
									$Encrypt_Enrollement_id = str_replace('+', 'X', $Encrypt_Enrollement_id);
									$_SESSION[$Encrypt_Enrollement_id]=$row->Enrollement_id;
							?>
								<tr>
									<td class="row-actions">
										<?php if($_SESSION['Privileges_Edit_flag']==1){ ?>
										<a href="<?php echo base_url()?>index.php/Enrollmentc/Edit_PartnerUserEnrollment/?Enrollement_id=<?php echo $Encrypt_Enrollement_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
										<?php } if($_SESSION['Privileges_Delete_flag']==1){ ?>
										<a class="danger" href="javascript:void(0);" onclick="delete_me('<?php echo $Encrypt_Enrollement_id;?>','<?php echo $row->First_name.' '.$row->Last_name; ?>','<?php if($row->User_id==1 && $row->Parent_flag==1){echo 'Please Note that the Subsidiary & Employee linked to this Parent Member will get Inactive also';}?>','Enrollmentc/delete_partnerenrollment/?Enrollement_id');" data-target="#deleteModal" data-toggle="modal" title="Delete"><i class="os-icon os-icon-ui-15"></i></a>
										<?php } ?>
									</td>
									<td><?php echo $row->First_name.' '.$row->Last_name;?></td>
									<td><?php echo App_string_decrypt($row->Phone_no);?></td>
									<td><?php echo App_string_decrypt($row->User_email_id);?></td>
									<td><?php echo $Partner_name;?></td>
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
	
	if( $('#currentAddress').val() != "" && $('#phno').val() != "" && $('#userEmailId').val() != "" && $('#country_id').val() != "" && $("#city").val() != ""&& $("#state").val() != "" )
	{
		
			show_loader();
			return true;
			
	
	}
});


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
function mailgenrator(email_flag)
{ 
	var phno = $("#phno").val();

	if(email_flag==0)
	{
		if(phno!="")
		{ 
			var domain =  '<?php echo $Domain_name; ?>';
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


$('#phno').blur(function()
{	
	if( $("#phno").val() != "" )
	{
		var Phone_no = $("#phno").val();
		var Company_id = '<?php echo $Company_id; ?>';
		var Country_id = '<?php echo $Country_id; ?>';
		
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
			  data: {userEmailId: userEmailId, Company_id: Company_id, userId: 4},
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
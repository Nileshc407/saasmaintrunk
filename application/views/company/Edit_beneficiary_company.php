<?php 
$this->load->view('header/header');
$todays = date("Y-m-d");
 ?>

<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				EDIT Channel Partner COMPNAY
			  </h6>
			  <div class="element-box">
			 <?php
					if(@$this->session->flashdata('success_code'))
					{ ?>	
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('success_code')."<br>".$this->session->flashdata('data_code'); ?>
						</div>
				<?php $this->session->unset_userdata('success_code'); $this->session->unset_userdata('data_code');
				} ?>
				<?php
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code')."<br>".$this->session->flashdata('data_code'); ?>
						</div>
				<?php $this->session->unset_userdata('error_code');
						$this->session->unset_userdata('data_code');
				} ?>
				
				
				<?php  $attributes = array('id' => 'formValidate');
					echo form_open_multipart('Company/update_beneficiary_company',$attributes); ?>
				<div class="row">
					<div class="col-sm-6">
				<!--
					<div class="form-group">
						<label for=""><?php echo $Company_name; ?> Company</label>
						<label class="radio-inline">
						<input type="radio" name="link_flag" onclick="enable_beneficiary_company(this.value);"  <?php if($record->Igain_link_flag == 1) { ?> checked <?php } else { ?> disabled <?php } ?> value="1"> Yes</label>
						<label class="radio-inline">
						<input type="radio" name="link_flag" onclick="enable_beneficiary_company(this.value);" <?php if($record->Igain_link_flag == 0) { ?> checked <?php } else { ?> disabled <?php } ?> value="0" > No
						</label>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					</div>
						 --> 	
					<div class="form-group">
						<label for="exampleInputEmail1"><span class="required_info">*</span> Channel Category</label>
						<select class="form-control" name="Publishers_Category" id="Publishers_Category" required="required" data-error="Please select category">
							<?php if($record->Publishers_category!=0) { ?>
								<option value="<?php echo $record->Publishers_category; ?>"><?php echo $record->Code_decode; ?></option>
								<?php } else { ?> <option value="0">Select Category</option> <?php }?>	
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>						
					</div>		  		
								 
				  
				  <div class="form-group" id="bcname1">
					<label for=""> <span class="required_info">*</span> Channel Company Name </label>								
					<input class="form-control"  name="bcname" id="bcname"  type="text" placeholder="Enter Channel Partner Company Name" value="<?php echo $record->Beneficiary_company_name; ?>" required="required" data-error="Please enter Channel Partner company name">
					<div class="help-block form-text with-errors form-control-feedback" id="pname"></div>
				  </div> 
				  	
					<div class="form-group" id="beneficiary_company_logo">
						<img id="blah" src="<?php echo base_url().$record->Company_logo; ?>"  class="img-responsive left-block" />
						<label for=""> Company Logo<br><font color="RED" align="center" size="0.8em"><i>You can upload logo upto 500kb  </i></font> </label>
						<div class="upload-btn-wrapper">
						<button class="file-btn"><i class="fa fa-cloud-upload"></i></button>
						<input type="file" name="file" id="file" onchange="readURL(this);" id="CompanyLogo2"/>
						</div>
	
					</div>
				   
				    <div class="form-group" id="Company_user_name1">
					<label for=""> <span class="required_info">*</span> Company User Name </label>
					<input class="form-control"  name="Company_user_name" id="Company_user_name"  type="text" placeholder="Enter Company User Name"  required="required"  value="<?php echo $record->Company_username; ?>" data-error="Please enter company user name">
					<div class="help-block form-text with-errors form-control-feedback" id="comp_username"></div>
					</div> 
					
					<div class="form-group" id="Company_password1">
					<label for=""> <span class="required_info">*</span> Company Password </label>
					<input class="form-control"  name="Company_password" id="Company_password"  type="password" placeholder="Enter Company Password" value="<?php echo $record->Company_password; ?>" required="required" data-error="Please enter company password"> <input type="checkbox" id="showHide"> Show Password 
					<div class="help-block form-text with-errors form-control-feedback" id="comp_password"></div>
					</div> 
					
					<div class="form-group" id="Company_encryptionkey1">
					<label for=""> <span class="required_info">*</span> Company Encryption key </label>
					<input class="form-control"  name="Company_encryptionkey" id="Company_encryptionkey"  type="text" placeholder="Enter Company Encryption key" value="<?php echo $record->Company_encryptionkey; ?>" required="required" data-error="Please enter company encryption key">
					<div class="help-block form-text with-errors form-control-feedback"></div>
					</div>
					<div class="form-group">
								<label for=""><span class="required_info">* </span> Contact Name</label>
								<input type="text" class="form-control" name="beneficiarycnt" id="beneficiarycnt" data-error="Please enter contact name" placeholder="Please Enter Contact Name" value="<?php echo $record->Contact_name; ?>"  required="required">
								<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						<div class="form-group" id="beneficiaryphoneno1">
								<label for=""><span class="required_info">* </span>Phone Number</label>
								<input type="text" class="form-control" name="beneficiaryphoneno" id="beneficiaryphoneno" data-error="Please enter phone number" placeholder="Phone Number" required="required" value="<?php echo $record->Contact_phone_no; ?>" onkeyup="this.value=this.value.replace(/\D/g,'')">
								<div class="help-block form-text with-errors form-control-feedback" id="phno_err"></div>
						</div>	
					<!--
					<div class="form-group" id="redem">
					<label for=""> <span class="required_info">*</span> Redemption Ratio <font color="RED" align="center" size="0.8em"><i>($1="X" Points, for e.g. if X=4 then $1=4 Points and 1 Points= $2)</i></font> </label>
					<input class="form-control"  name="redemptionratio" id="redemptionratio"  type="text" placeholder="Enter Redemption Ratio" value="<?php echo $record->Redemptionratio; ?>"  required="required" data-error="Please enter redemption ratio" onkeypress="return isNumberKey2(event);">
					<div class="help-block form-text with-errors form-control-feedback"></div>
					</div>
					
					<div class="form-group" >
					<label for=""> <span class="required_info">*</span> Buy Rate </label>
					<input class="form-control"  name="Buy_rate" id="Buy_rate"  type="text" placeholder="Enter Buy rate"  required="required" value="<?php echo $record->Buy_rate; ?>" data-error="Please enter buy rate" onkeypress="return isNumberKey2(event);">
					<div class="help-block form-text with-errors form-control-feedback"></div>
					</div>
					
					<div class="form-group" >
					<label for=""> <span class="required_info">*</span> Tax </label>
					<input class="form-control"  name="Tax" id="Tax"  type="text" placeholder="Enter Tax"  required="required" data-error="Please enter tax" value="<?php echo $record->Tax; ?>" onkeypress="return isNumberKey2(event);">
					<div class="help-block form-text with-errors form-control-feedback"></div>
					</div>
					
					<?php 
					if($record->Igain_link_flag == 0)
					{ ?>
					<div class="form-group" id="url_div">
						<div class="form-group" id="Authentication_url1">
						<label for=""> <span class="required_info">*</span> Authentication url </label>
						<input class="form-control"  name="Authentication_url" id="Authentication_url"  type="text" placeholder="Enter Authentication url"  value="<?php echo $record->Authentication_url; ?>" required="required" data-error="Please enter authentication url">
						<div class="help-block form-text with-errors form-control-feedback" id="Auth_url_error"></div>
						</div>
						
						<div class="form-group" id="Transaction_url1">
						<label for=""> <span class="required_info">*</span> Transaction url </label>
						<input class="form-control"  name="Transaction_url" id="Transaction_url"  type="text" placeholder="Enter Transaction url" value="<?php echo $record->Transaction_url; ?>" required="required" data-error="Please enter transaction url">
						<div class="help-block form-text with-errors form-control-feedback" id="trn_url_error"></div>
						</div>
					</div>
					
					<?php 
					}
					?>
					-->
					</div>
					<div class="col-sm-6">	
					<!--
						<div class="form-group">
						<label for=""> Send Purchased File</label>
						<label class="radio-inline">
							<input type="radio" name="Cron_purchased_miles_flag" <?php if($record->Cron_purchased_miles_flag == 1) { echo "checked"; } ?> value="1"> Yes
						</label>
						<label class="radio-inline">
							<input type="radio" name="Cron_purchased_miles_flag" <?php if($record->Cron_purchased_miles_flag == 0) { echo "checked"; } ?> value="0" > No
						</label>
						</div>
					-->
						<div class="form-group">
						<label for=""> <span class="required_info">*</span> Company Address </label>								
						<textarea class="form-control"  name="bcaddress" id="bcaddress"  placeholder="Enter Company Address"  required="required" data-error="Please enter address"><?php echo $record->Address; ?></textarea>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div> 
					  
						<div class="form-group">
						<label for=""><span class="required_info">* </span>Country</label>
						<select class="form-control" name="country" id="country" required="required" onchange="Get_states(this.value);" data-error="Please select country">
						<option value="">Select Country</option>
						<option value="101">India</option>
						 <?php 
							foreach($Country_array as $Country)
							{
						?>
								<option value="<?php echo $Country['id'];?>" <?php if($record->Country == $Country['id']){echo "selected";} ?>><?php echo $Country['name'];?></option>
							<?php 
							}
							?>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
				  
					  <div class="form-group" id="Show_States">
						<label for="">State</label>
						<select class="form-control" name="state" id="state" onchange="Get_cities(this.value);" data-error="Please select state">
						<?php 
							foreach($States_array as $rec)
							{
						?>
								<option value="<?php echo $rec->id;?>" <?php if($record->State == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
						<?php 
							}
						?>					
						</select>
						
					  </div> 

					  <div class="form-group" id="Show_Cities">
						<label for="">City</label>
						<select class="form-control" name="city" id="city" data-error="Please select city">
						<?php 
							foreach($City_array as $rec)
							{
						?>
								<option value="<?php echo $rec->id;?>" <?php if($record->City == $rec->id){echo "selected";} ?>><?php echo $rec->name;?></option>
						<?php 
							}
						?>
						</select>
					  </div> 
					  
						<div class="form-group">
								<label for=""><span class="required_info">* </span> Currency</label>
								<input type="text" class="form-control" name="Currency" id="Currency" data-error="Please enter currency" value="<?php echo $record->Currency; ?>" placeholder="Currency" required="required">
								<div class="help-block form-text with-errors form-control-feedback"></div>
						</div>
						
						
						<div class="form-group"  id="beneficiaryemailId11">
								<label for=""><span class="required_info">* </span>Email Address-1 </label>
								<input type="email" class="form-control" name="beneficiaryemailId" id="beneficiaryemailId" onblur="EmailValidation('#beneficiaryemailId',this.value,1);" data-error="Please enter email address 1" value="<?php echo $record->Contact_email_id; ?>" placeholder="Email Address-1" required="required">
								<div class="help-block form-text with-errors form-control-feedback" id="email_1_err"></div>
						</div>
						<div class="form-group"  id="beneficiaryemailId22">
								<label for=""><span class="required_info">* </span>Email Address-2 </label>
								<input type="email" class="form-control" name="beneficiaryemailId1" id="beneficiaryemailId1" onblur="EmailValidation('#beneficiaryemailId1',this.value,2);" data-error="Please enter email address 2" value="<?php echo $record->Contact_email_id1; ?>"  placeholder="Email Address-2" required="required">
								<div class="help-block form-text with-errors form-control-feedback" id="email_2_err"></div>
						</div>
						<div class="form-group"  id="beneficiaryemailId33">
								<label for=""><span class="required_info">* </span>Email Address-3 </label>
								<input type="email" class="form-control" name="beneficiaryemailId2" id="beneficiaryemailId2" onblur="EmailValidation('#beneficiaryemailId2',this.value,3);" value="<?php echo $record->Contact_email_id2; ?>" data-error="Please enter email address 3" placeholder="Email Address-3" required="required">
								<div class="help-block form-text with-errors form-control-feedback" id="email_3_err"></div>
						</div>
						
						<input type="hidden" name="BCompany_id" id="BCompany_id" value="<?php echo $record->Register_beneficiary_id; ?>" class="form-control" />
						<input type="hidden" name="Igain_link_flag" id="Igain_link_flag" class="form-control" placeholder="Enter Transaction url"  value="<?php echo $record->Igain_link_flag; ?>">
						<input type="hidden" name="Company_logo2" value="<?php echo $record->Company_logo; ?>" class="form-control" />
					</div>
				</div>
					<div class="form-buttons-w" align="center">
					<button class="btn btn-primary" type="submit" id="Register">Submit</button>
					<button class="btn btn-primary" type="reset">Reset</button>
					</div>
					<?php echo form_close(); ?>		  
			</div>			
			</div>
			
			<!-------------------- START - Data Table -------------------->
	           
		<div class="element-wrapper">                
				<div class="element-box">
				  <h5 class="form-header">
				   Active Channel Partner Companies
				  </h5>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
							<th class="text-center">Action</th>
							<th class="text-center">Company Name</th>
							<th class="text-center">Company Address</th>
							<th class="text-center">Contact Name</th>
							<th class="text-center">Email Address</th>
							<th class="text-center">Contact No.</th>
							
							</tr>
						</thead>	
						<tfoot>
							<tr>
							<th class="text-center">Action</th>
							<th class="text-center">Company Name</th>
							<th class="text-center">Company Address</th>
							<th class="text-center">Contact Name</th>
							<th class="text-center">Email Address</th>
							<th class="text-center">Contact No.</th>
							
							</tr>
						</tfoot>		

						<tbody>
						<?php
							if($results != NULL)
							{
								foreach($results as $row)
								{
								?>
									<tr>
										<td class="row-actions">
											<a href="<?php echo base_url()?>index.php/Company/edit_beneficiary_company/?Beneficiary_Company_id=<?php echo $row->Register_beneficiary_id;?>" title="Edit">
												<i class="os-icon os-icon-ui-49"></i>
											</a>

											<a  class="danger" href="javascript:void(0);" onclick="Inactive_me('<?php echo $row->Register_beneficiary_id;?>','<?php echo $row->Beneficiary_company_name; ?>','');"  data-target="#MakeInactive" data-toggle="modal" title="Make-Inactive">
												<i class="os-icon os-icon-ui-15"></i>
											</a>
										</td>
										<td><?php echo $row->Beneficiary_company_name;?></td>
										<td><?php echo $row->Address;?></td>
										<td><?php echo $row->Contact_name;?></td>
										<td><?php echo $row->Contact_email_id;?></td>
										<td><?php echo $row->Contact_phone_no;?></td>
										
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
	
	
			<div class="element-wrapper">                
				<div class="element-box">
				  <h5 class="form-header">
				   In-Active Channel Partner Companies
				  </h5>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
							<th>Action</th>
							<th>Company Name</th>
							<th>Company Address</th>
							<th>Contact Name</th>
							<th>Email Address</th>
							<th>Contact No.</th>
							
							</tr>
						</thead>	
						<tfoot>
							<tr>
							<th>Action</th>
							<th>Company Name</th>
							<th>Company Address</th>
							<th>Contact Name</th>
							<th>Email Address</th>
							<th>Contact No.</th>
							
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
											
											
											<a href="javascript:void(0);" onclick="Active_me('<?php echo $row->Register_beneficiary_id;?>','<?php echo $row->Beneficiary_company_name; ?>','');" data-target="#MakeActive" data-toggle="modal" title="Make-Active">
												<i class="fa fa-check-square-o"></i>
											</a>
										</td>
										<td><?php echo $row->Beneficiary_company_name;?></td>
										<td><?php echo $row->Address;?></td>
										<td><?php echo $row->Contact_name;?></td>
										<td><?php echo $row->Contact_email_id;?></td>
										<td><?php echo $row->Contact_phone_no;?></td>
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
<!--------------------  END - Data Table  -------------------->


		  </div>
		</div>
	</div>
</div>			

<!-- msg popup modal -->

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

                Are you sure to In-Activate the Company for <b id="arg22"></b> ?<br><span id="arg33"></span>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
                <button class="btn btn-primary" type="button" onclick="confirmed_inactive(arg11.value, arg22.value, arg33.value)">OK</button>
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
                Are you sure to Activate the Company for <b id="arg222"></b> ?<br><span id="arg333"></span>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancel</button>
                <button class="btn btn-primary" type="button" onclick="confirmed_active(arg111.value, arg222.value, arg333.value)">OK</button>
            </div>
        </div>
    </div>
</div>
<!---------------Activate modal end---------------->
<!-- msg popup modal -->

<?php $this->load->view('header/footer'); ?>
<script>

$(document).ready(function() 
{
  $("#showHide").click(function() 
  {
	if ($("#Company_password").attr("type") == "password") 
	{
		$("#Company_password").attr("type", "text");
    } 
	else 
	{
		$("#Company_password").attr("type", "password");
    }
  });
});

$('#Register').click(function()
{
	if(!document.querySelector("#Register").classList.contains('disabled')){
		show_loader();
	}
});

$('#bcname').blur(function()
{	
	if($("#bcname").val() != "")
	{
		var bcname = $("#bcname").val();
		$.ajax({
			type: "POST",
			data: {bcname: bcname},
			url: "<?php echo base_url()?>index.php/Company/Check_beneficiary_company",
			success: function(data)
			{	
				// alert(data.length);
				if(data.length == 13)
				{							
					$("#bcname").val("");
					var msg1 = 'Already exist';
					$("#bcname").addClass("form-control has-error");
					$('#pname').show();
					$("#pname").html(msg1);
				}
				else
				{
					$('#pname').html("");
					$("#bcname").removeClass("has-error");
				}
			}
		});
	}	
});	
$('#Authentication_url').blur(function()
{	
	if($("#Authentication_url").val() != "")
	{
		var Authentication_url = $("#Authentication_url").val();
		$.ajax({
			type: "POST",
			data: {Authentication_url: Authentication_url},
			url: "<?php echo base_url()?>index.php/Company/Check_Authentication_url",
			success: function(data)
			{	
				// alert(data.length);
				if(data.length == 13)
				{							
					$("#Authentication_url").val("");
					var msg1 = 'Already exist';
					$("#Authentication_url").addClass("form-control has-error");
					$('#Auth_url_error').show();
					$("#Auth_url_error").html(msg1);
				}
				else
				{
					$('#Auth_url_error').html("");
					$("#Authentication_url").removeClass("has-error");
				}
			}
		});
	}	
});	
$('#Transaction_url').blur(function()
{	
	if($("#Transaction_url").val() != "")
	{
		var Transaction_url = $("#Transaction_url").val();
		$.ajax({
			type: "POST",
			data: {Transaction_url: Transaction_url},
			url: "<?php echo base_url()?>index.php/Company/Check_Transaction_url",
			success: function(data)
			{	
				//alert(data.length);
				if(data.length == 13)
				{							
					$("#Transaction_url").val("");
					var msg1 = 'Already exist';
					$("#Transaction_url").addClass("form-control has-error");
					$('#trn_url_error').show();
					$("#trn_url_error").html(msg1);
				}
				else
				{
					$('#trn_url_error').html("");
					$("#Transaction_url").removeClass("has-error");
				}
			}
		});
	}	
});	


//$('#beneficiaryemailId').blur(function()
function EmailValidation(id,email,flag)
{	
	
	if(flag == 1)
	{
		var API_url = "<?php echo base_url()?>index.php/Company/Check_contatct_email";
	}
	if(flag == 2)
	{
		var API_url = "<?php echo base_url()?>index.php/Company/Check_contatct_email1";
	}
	if(flag == 3)
	{
		var API_url = "<?php echo base_url()?>index.php/Company/Check_contatct_email2";
	}
	
	//alert(id+"---"+email+"--"+API_url);
	
	if(email != "")
	{
		var beneficiaryemailId = email;
		var n = beneficiaryemailId.indexOf("@"); 
		var n1 = beneficiaryemailId.lastIndexOf("."); 	
		//alert($(id).val());
		
		if(n < 0 || n1 < 0 || n1 < n)
		{
			$(id).val("");
			$(id).addClass("form-control has-error");
			$('#email_'+flag+'_err').show();
			$('#email_'+flag+'_err').html('Enter valid email id');
			return false;
		}
		else
		{
			$.ajax({
			type: "POST",
			data: {beneficiaryemailId: beneficiaryemailId},
			url: API_url,
				success: function(data)
				{	
					//alert(data.length);
					if(data.length >= 12)
					{							
						$(id).val("");
						var msg1 = 'Already exist';
						$(id).addClass("form-control has-error");
						$('#email_'+flag+'_err').show();
						$('#email_'+flag+'_err').html(msg1);
					}
					else
					{
						$('#email_'+flag+'_err').html("");
						$(id).removeClass("has-error");
					}
				}
			});
		}

	}	
}

	
$('#beneficiaryphoneno').blur(function()
{	
	if($("#beneficiaryphoneno").val() != "")
	{
		var beneficiaryphoneno = $("#beneficiaryphoneno").val();
		$.ajax({
			type: "POST",
			data: {beneficiaryphoneno: beneficiaryphoneno},
			url: "<?php echo base_url()?>index.php/Company/Check_contatct_phoneno",
			success: function(data)
			{	
				//alert(data.length);
				if(data.length == 13)
				{							
					$("#beneficiaryphoneno").val("");
					var msg1 = 'Already exist';
					$("#beneficiaryphoneno").addClass("form-control has-error");
					$('#phno_err').show();
					$("#phno_err").html(msg1);
				}
				else
				{
					$("#beneficiaryphoneno").removeClass("has-error");
					$("#phno_err").html("");
				}
			}
		});
	}	
});


function Inactive_me(arg1, arg2, arg3) 
{
    $(".modal-body #arg11").val(arg1);
    $(".modal-body #arg11").html(arg1);

    $(".modal-body #arg22").val(arg2);
    $(".modal-body #arg22").html(arg2);


    $(".modal-body #arg33").val(arg3);
    $(".modal-body #arg33").html(arg3);
}

function confirmed_inactive(arg1, arg2, arg3) 
{
    if (arg1)
    {
        var url = '<?php echo base_url()?>index.php/Company/inactive_beneficiary_company/?Company_id='+arg1+'&company_flag=1';
		
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

function Active_me(arg1, arg2, arg3) 
{
    $(".modal-body #arg111").val(arg1);
    $(".modal-body #arg111").html(arg1);

    $(".modal-body #arg222").val(arg2);
    $(".modal-body #arg222").html(arg2);


    $(".modal-body #arg333").val(arg3);
    $(".modal-body #arg333").html(arg3);
}
function confirmed_active(arg1, arg2, arg3) 
{
    if (arg1)
    {
        var url = '<?php echo base_url()?>index.php/Company/inactive_beneficiary_company/?Company_id='+arg1+'&company_flag=2';
		
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

function enable_beneficiary_company(Tflag) 
{		
	if(Tflag==1)	
	{
		document.getElementById('beneficiary_company_div').style.display = "";
		document.getElementById('beneficiary_company_logo').style.display = "none";
		document.getElementById('url_div').style.display = "none";
		$("#beneficiary_company").attr("required","required");
		$("#Authentication_url").removeAttr("required");
		$("#Transaction_url").removeAttr("required");
		$("#CompanyLogo2").removeAttr("required");
		$('#bcname').attr("readonly","readonly");
		$('#bcaddress').attr("readonly","readonly");							
		$('#country').attr("readonly","readonly");							
		$('#state').attr("readonly","readonly");							
		$('#city').attr("readonly","readonly");					
		$('#beneficiarycnt').attr("readonly","readonly");			
		$('#beneficiaryemailId').attr("readonly","readonly");				
		$('#beneficiaryemailId1').attr("readonly","readonly");				
		$('#beneficiaryemailId2').attr("readonly","readonly");				
		$('#beneficiaryphoneno').attr("readonly","readonly"); 
		$('#Company_user_name').attr("readonly","readonly"); 
		$('#Company_password').attr("readonly","readonly"); 
		$('#Company_encryptionkey').attr("readonly","readonly"); 
		$('#redemptionratio').attr("readonly","readonly"); 
		
	}
	else
	{
		document.getElementById('beneficiary_company_div').style.display = "none";
		document.getElementById('beneficiary_company_logo').style.display = "";		
		document.getElementById('url_div').style.display = "";
		$("#beneficiary_company").removeAttr("required");
		$("#Authentication_url").attr("required","required");
		$("#Transaction_url").attr("required","required");
		$("#CompanyLogo2").attr("required","required");
		$('#bcname').val("");
		$('#bcaddress').val("");								
		$('#country').val("");								
		$('#state').val("");								
		$('#city').val("");								
		$('#beneficiarycnt').val("");				
		$('#beneficiaryemailId').val("");					
		$('#beneficiaryemailId1').val("");					
		$('#beneficiaryemailId2').val("");					
		$('#beneficiaryphoneno').val("");	
		$('#Company_user_name').val("");	
		$('#Company_password').val("");	
		$('#Company_encryptionkey').val("");	
		$('#redemptionratio').val("");	
		$('#Company_logo').val("");	
		
		$('#bcname').removeAttr("readonly");
		$('#bcaddress').removeAttr("readonly");						
		$('#country').removeAttr("readonly");						
		$('#state').removeAttr("readonly");								
		$('#city').removeAttr("readonly");							
		$('#beneficiarycnt').removeAttr("readonly");			
		$('#beneficiaryemailId').removeAttr("readonly");				
		$('#beneficiaryemailId1').removeAttr("readonly");				
		$('#beneficiaryemailId2').removeAttr("readonly");				
		$('#beneficiaryphoneno').removeAttr("readonly");
		$('#Company_user_name').removeAttr("readonly");
		$('#Company_password').removeAttr("readonly");
		$('#Company_encryptionkey').removeAttr("readonly");
		$('#redemptionratio').removeAttr("readonly");
		 
		 
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

function get_company_details(Company_id) 
{	 
	if(Company_id != "" && Company_id != 0 )
	{	
		$.ajax({
				type:"GET",
				data:{Company_id:Company_id},
				url: "<?php echo base_url()?>index.php/Company/get_company/",
				success: function(data)
				{		
					json = eval("(" + data + ")");
				
					if(json[0].Error_flag == 1)
					{	
						var msg = "Company Record Not Found";
						$("#beneficiary_company").addClass("form-control has-error");
						$('#beneficiary_com_err').show();
						$("#beneficiary_com_err").html(msg);
					}							
					if(data !== "")
					{	
						$('#bcname').val(json[0].Company_name);
						$('#Company_user_name').val(json[0].Company_username);
						$('#Company_password').val(json[0].Company_password);
						$('#Company_encryptionkey').val(json[0].Company_encryptionkey);
						$('#redemptionratio').val(json[0].Company_Redemptionratio);
						$('#Company_logo').val(json[0].Company_logo);
						$('#bcaddress').val(json[0].Company_address);								
						$('#country').val(json[0].Country);								
						$('#state').val(json[0].State);								
						$('#city').val(json[0].City);
						$("#country").prepend('<option selected="selected" value='+json[0].Country_id+'>'+json[0].Country+'</option>');
						$("#state").prepend('<option selected="selected" value='+json[0].State_id+'>'+json[0].State+'</option>');
						$("#city").prepend('<option selected="selected" value='+json[0].City_id+'>'+json[0].City+'</option>');
						$('#beneficiarycnt').val(json[0].Company_contact_person);				
						$('#beneficiaryemailId').val(json[0].primary_email_id);					
						$('#beneficiaryemailId1').val(json[0].contact_email_id);					
						$('#beneficiaryphoneno').val(json[0].contact_phone_no);					
					}	
				}
			});
	}	
}

function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
					.css('display','inline')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(160);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
	

/***********************AMIT 17-11-2017************************/
function Get_states(Country_id)
{
	 //alert(Country_id);
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
</script>
<?php $this->load->view('header/header'); 
$ci_object = &get_instance();
$ci_object->load->model('CallCenter_model');
$ci_object->load->model('Igain_model'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				EDIT CALL CENTER RESOLUTION PRIORITY LEVEL
			  </h6>
			   <div class="element-box">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Call_center/Update_Resolution_priority_levels',$attributes); ?> 
				  <?php
					if(@$this->session->flashdata('success_code'))
					{ ?>	
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						 <?php echo $this->session->flashdata('success_code'); ?>
						</div>
				<?php 		
					} ?>
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
							<label for=""><span class="required_info">* </span>Enter Priority Level</label>
							<input class="form-control" type="text" name="PriorityLevel" id="PriorityLevel" placeholder="Enter priority level" data-error="Please enter priority level" value="<?php echo $Resolution_levels_details->Resolution_priority_levels ?>" onkeypress="return isNumberKey(event)" required="required">
							<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
						  </div>
						  
						  <div class="form-group" id="Levelname">
							<label for=""><span class="required_info">* </span>Enter Level Name</label>
							<input class="form-control" type="text" name="Level_name" id="Level_name" placeholder="Enter level name" data-error="Please enter level name" value="<?php echo $Resolution_levels_details->Level_name ?>" required="required">
							<div class="help-block form-text with-errors form-control-feedback" id="help-block2"></div>
						  </div>
						  
						  <div class="form-group" id="No_of_days_expected_resolve">
							<label for=""><span class="required_info">* </span>Enter No. of Hours to Resolve</label>
							<input class="form-control" type="text" name="days_expected_resolve" id="days_expected_resolve" placeholder="Enter no. of hours to resolve" data-error="Please enter no. of hours to resolve" onkeypress="return isNumberKey(event)" value="<?php echo $Resolution_levels_details->No_of_days_expected_resolve ?>" required="required">
							<div class="help-block form-text with-errors form-control-feedback" id="help-block3"></div>
						  </div>
						</div>
						<div class="col-sm-6">					
						  <div class="form-group" id="User_Type">
						  <h6>Contact Details for First Level Escalation</h6>
							<label for=""><span class="required_info">* </span>Select User Type</label>
							<select class="form-control" name="usertype" id="usertype" data-error="Please select user type" required="required">
							<option value="">Select User Type</option>
							 <?php
								if($UserType != NULL)
								{
									foreach($UserType as $row1)
									{
									?>		
										<option value="<?php echo $row1->User_id; ?>" <?php if($Resolution_levels_details->User_type_id == $row1->User_id) { ?> selected <?php  } ?> ><?php echo $row1->User_type; ?> </option>
									<?php	
									}
								}
							 ?>
							</select>
							<div class="help-block form-text with-errors form-control-feedback"></div>
						  </div>
						  <div class="form-group" id="User_Name">
							<label for=""><span class="required_info">* </span>Select User Name</label>
							<select class="form-control" id="UserName" name="UserName" data-error="Please select user name" required="required">
							<?php $get_enrollment = $ci_object->Igain_model->get_enrollment_details($Resolution_levels_details->Enrollment_id); ?>
							<option value="<?php echo $Resolution_levels_details->Enrollment_id; ?>"> <?php echo $get_enrollment->First_name.' '.$get_enrollment->Last_name; ?> </option>
							</select>	
							<div class="help-block form-text with-errors form-control-feedback"></div>						
						 </div>
						</div>
					</div>					
					<div class="form-buttons-w" align="center">
					 <button class="btn btn-primary" type="submit" id="Register">Submit</button>
					 <button class="btn btn-primary" type="reset">Reset</button>
					 <input type="hidden" name="Resolution_id" value="<?php echo $Resolution_levels_details->Resolution_id ; ?>">
				    </div>
					<?php echo form_close(); ?>
				</div>
			</div> 
			<!--------------Table------------->	 
			<div class="element-wrapper">											
				<div class="element-box">
				  <h6 class="form-header">
				   Resolution Priority Level Master
				  </h6>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Action</th>
								<th>Priority Level</th>
								<th>Level Name</th>
								<th>No. of Hours</th>
								<th>User Type</th>
								<th>User Name</th>
								</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Action</th>
								<th>Priority Level</th>
								<th>Level Name</th>
								<th>No. of Hours</th>
								<th>User Type</th>
								<th>User Name</th>
							</tr>
						</tfoot>
						<tbody>
					<?php
						$todays = date("Y-m-d");	
						if($CallCenterresolutionpriority != NULL)
						{
							foreach($CallCenterresolutionpriority as $row)
							{
								if($row->User_type_id == 2)
								{
								   $UserType ='Merchant';
								}
								if($row->User_type_id == 3)
								{
								   $UserType ='Admin';
								}
								if($row->User_type_id == 4)
								{
								  $UserType = 'Partner admin';
								}
								if($row->User_type_id == 5)
								{
								   $UserType ='Merchandize Partner User';
								}	
								if($row->User_type_id == 6)
								{
								   $UserType ='Call Center User';
								}
							?>
							<tr>
								<td class="row-actions">
									<a href="<?php echo base_url()?>index.php/Call_center/Edit_Resolution_priority_levels/?Resolution_id=<?php echo $row->Resolution_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
								</td>
								<td><?php echo $row->Resolution_priority_levels;?></td>
								<td><?php echo $row->Level_name;?></td>
								<td><?php echo $row->No_of_days_expected_resolve;?></td>
								<td><?php echo $UserType;?></td>
							<?php $get_enrollment = $ci_object->Igain_model->get_enrollment_details($row->Enrollment_id); ?>
								<td><?php echo $get_enrollment->First_name.' '.$get_enrollment->Last_name;?></td>
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
<?php $this->load->view('header/footer'); ?>

<script>
$('#Register').click(function()
{     
	if( $('#PriorityLevel').val() != "" && $('#Level_name').val() != "" && $('#days_expected_resolve').val() != "" && $('#usertype').val() != ""&& $('#UserName').val() != "")
	{
		show_loader();
		return true;
	}
});   

$('#usertype').change(function()
{	
	var User_id = $("#usertype").val();
	var Company_id = '<?php echo $Company_id ; ?>';
	
	$.ajax({
		type:"POST",
		data:{User_id:User_id, Company_id:Company_id},
		url: "<?php echo base_url()?>index.php/Call_center/Get_SuperSeller_user_name",
		success: function(data)
		{
			$('#UserName').html(data.Get_User_Names1);
		}				
	});
});

$('#PriorityLevel').blur(function()   
{	
	if($("#PriorityLevel").val() == "")
	{
		$("#PriorityLevel").val("");
		$("#PriorityLevel").addClass("form-control has-error");
		$("#help-block1").html("Please enter priority level");
	}
	else
	{
		var PriorityLevel = $("#PriorityLevel").val();
		var Company_id ='<?php echo $Company_details->Company_id; ?>';
		$.ajax({
			type: "POST",
			data: {PriorityLevel: PriorityLevel, Company_id: Company_id},
			url: "<?php echo base_url()?>index.php/Call_center/Check_Resolution_priority_levels",
			success: function(data)
			{	
				
				if(data.length == 13)
				{							
					$("#PriorityLevel").val("");
					$("#PriorityLevel").addClass("form-control has-error");
					$("#help-block1").html("Already exist");
				}
				else
				{
					$("#PriorityLevel").removeClass("has-error");
					$("#help-block1").html("");
				}
			}
		});
	}	
});	
$('#Level_name').blur(function()   
{	
	if($("#Level_name").val() == "")
	{
		$("#Level_name").val("");
		$("#Level_name").addClass("form-control has-error");
		$("#help-block2").html("Please enter level name");
	}
	else
	{
		var Level_name = $("#Level_name").val();
		var Company_id ='<?php echo $Company_details->Company_id; ?>';
		$.ajax({
			type: "POST",
			data: {Level_name: Level_name, Company_id: Company_id},
			url: "<?php echo base_url()?>index.php/Call_center/Check_Resolution_priority_levels_name",
			success: function(data)
			{	
				
				if(data.length == 13)
				{							
					$("#Level_name").val("");
					$("#Level_name").addClass("form-control has-error");
					$("#help-block2").html("Already exist");
				}
				else
				{
					$("#Level_name").removeClass("has-error");
					$("#help-block2").html("");
				}
			}
		});
	}
});	
function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 
	&& (charCode < 48 || charCode > 57))
	 return false;

  return true;
}
</script>
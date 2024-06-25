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
				CALL CENTER ESCALATION MATRIX
			  </h6>
			  <div class="element-box">
				  <div class="col-sm-8">
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
			<?php 	$attributes = array('id' => 'formValidate');
					echo form_open_multipart('Call_center/Call_center_escalation_levels',$attributes); ?>
						
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>Enter No. of Unresolved Days</label>
						<input class="form-control" type="text" name="Unresolved_Days" id="Unresolved_Days" placeholder="Enter no. of unresolved days" data-error="Please enter no. of unresolved days" onkeypress="return isNumberKey(event)" required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
				      </div>
					 
					  <div class="form-group" id="User_Type">
						<label for=""><span class="required_info">* </span>Select User Type</label>
						<select class="form-control" name="usertype" id="usertype" data-error="Please select user type" required="required">
						<option value="">Select user type</option>
						 <?php
						if($UserType != NULL)
						{
							foreach($UserType as $row1)
							{
						?>		
							<option value="<?php echo $row1->User_id; ?>" ><?php echo $row1->User_type; ?> </option>
					<?php	}
						}
						 ?> 
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  <div class="form-group" id="User_Name">
							<label for=""><span class="required_info">* </span>Select User Name</label>
							<select class="form-control" id="UserName" name="UserName[]" data-error="Please select user name" required="required">
							<option value="">Select user name</option>
							</select>	
							<div class="help-block form-text with-errors form-control-feedback"></div>						
					  </div>
					  
					  <div class="form-buttons-w">
						<button class="btn btn-primary" type="submit" id="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
					  </div>
					<?php echo form_close(); ?>		  
				  </div>
				</div>
			</div>
			<!--------------Table------------->	 
			<div class="element-wrapper">											
				<div class="element-box">
				  <h6 class="form-header">
				  Escalation Matrix Master
				  </h6>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Action</th>
								<th>No. of Unresolved Days</th>
								<th>User Type</th>
								<th>User Name</th>
								</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Action</th>
								<th>No. of Unresolved Days</th>
								<th>User Type</th>
								<th>User Name</th>
							</tr>
						</tfoot>
						<tbody>
					<?php
						$todays = date("Y-m-d");	
						if($CallCenterescalationMatrix != NULL)
						{
							foreach($CallCenterescalationMatrix as $row)
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
									<a href="<?php echo base_url()?>index.php/Call_center/Edit_Call_center_escalation_levels/?Escalation_matrix_id=<?php echo $row->Escalation_matrix_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
								</td>
								
								<td><?php echo $row->No_of_unresolved_days;?></td>
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
	if( $('#Unresolved_Days').val() != "" && $('#usertype').val() != "" && $('#UserName').val() != "")
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
		url: "<?php echo base_url()?>index.php/Call_center/Get_SuperSeller_user_name1",
		success: function(data)
		{	
			$('#UserName').html(data.Get_User_Names1);
		}				
	});
});

$('#Unresolved_Days').blur(function()   
{	
	if($("#Unresolved_Days").val() == "")
	{
		$("#Unresolved_Days").val("");
		$("#Unresolved_Days").addClass("form-control has-error");
		$("#help-block1").html("Please enter no. of unresolved days");
	}
	else
	{
		var Unresolved_Days = $("#Unresolved_Days").val();
		var Company_id ='<?php echo $Company_details->Company_id; ?>';
		$.ajax({
			type: "POST",
			data: {Unresolved_Days: Unresolved_Days, Company_id: Company_id},
			url: "<?php echo base_url()?>index.php/Call_center/Check_No_of_Unresolved_Days",
			success: function(data)
			{	
				if(data.length == 13)
				{							
					$("#Unresolved_Days").val("");
					$("#Unresolved_Days").addClass("form-control has-error");
					$("#help-block1").html("Already exist");
				}
				else
				{
					$("#Unresolved_Days").removeClass("has-error");
					$("#help-block1").html("");
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
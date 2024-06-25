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
				CALL CENTER QUERY TYPE
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
					echo form_open_multipart('Call_center/Call_center_query_type',$attributes); ?>
					
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>Query Type</label>
						<input class="form-control" type="text" name="Query_type_name" id="Query_type_name" placeholder="Enter query type" data-error="Please enter query type" required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
						<br/><h6>Contact Details for Resolve Query</h6>
					  </div> 
					  
					  <div class="form-group" id="User_Type">
						<label for=""><span class="required_info">* </span>Select User Type</label>
						<select class="form-control" name="usertype" id="usertype" data-error="Please select user type" required="required">
						<option value="">Select User Type </option>
						 <?php
							if($UserType != NULL) 
							{
								foreach($UserType as $row1)
								{?>		
								<option value="<?php echo $row1->User_id; ?>" ><?php echo $row1->User_type; ?> </option>
						<?php	}
							}
							 ?>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  
					  <div class="form-group" id="User_Name"> 
							<label for=""><span class="required_info" >* </span>Select User Name</label>
							<select class="form-control select2" id="UserName" name="UserName[]" data-error="Please select user name" required="required" multiple="true">
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
				   Qurey Type Master
				  </h6>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Action</th>
								<th>Query Type</th>
								<th>User Type</th>
								<th>User Name</th>
								</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Action</th>
								<th>Query Type</th>
								<th>User Type</th>
								<th>User Name</th>
							</tr>
						</tfoot>
						<tbody>
					<?php
					$todays = date("Y-m-d");
						if($CallCenterQueryType != NULL)
						{
							foreach($CallCenterQueryType as $row)
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
									<a href="<?php echo base_url()?>index.php/Call_center/Edit_Call_center_query_type/?Query_type_id=<?php echo $row->Query_type_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
								</td>
								<td><?php echo $row->Query_type_name;?></td>
								<td><?php echo $UserType;?></td>
								
								<?php $data['get_user'] = $ci_object->CallCenter_model->Fetch_query_user_id($Company_id,$row->Query_type_id); ?>
								
								<td>
								<?php 
									foreach($data['get_user'] as $get_user)
									{
										$get_enrollment = $ci_object->Igain_model->get_enrollment_details($get_user->Enrollment_id);	?>							
										<?php echo $get_enrollment->First_name.' '.$get_enrollment->Last_name."<br>";
									} ?> 
								</td>
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
	if( $('#Query_type_name').val() != "" && $('#usertype').val() != "" && $('#UserName').val() != "")
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
		url: "<?php echo base_url()?>index.php/Call_center/Get_user_name",
		
		success: function(data)
		{
			$('#UserName').html(data.Get_User_Names1);		
		}				
	});
});

$('#Query_type_name').blur(function()
{	
	if($("#Query_type_name").val() == "")
	{
		$("#Query_type_name").val("");				
		$("#help-block1").html("Please enter query type");
		$("#Query_type_name").addClass("form-control has-error");
	}
	else
	{
		var Query_type_name = $("#Query_type_name").val();
		var Company_id ='<?php echo $Company_details->Company_id; ?>';
		$.ajax({
			type: "POST",
			data: {Query_type_name: Query_type_name, Company_id: Company_id},
			url: "<?php echo base_url()?>index.php/Call_center/Check_Call_center_query_type",
			success: function(data)
			{	
				if(data.length == 13)
				{							
					$("#Query_type_name").val("");
					$("#help-block1").html("Already exist");
					$("#Query_type_name").addClass("form-control has-error");
				}
				else
				{
					$("#Query_type_name").removeClass("has-error");
					$("#help-block1").html("");
				}
			}
		});
	}	
});	
</script>
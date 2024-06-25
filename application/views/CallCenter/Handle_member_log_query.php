<?php $this->load->view('header/header');  ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				MEMBER PROFILE -<?php echo $results->First_name.' '.$results->Last_name." (".$results->Card_id.")";?>
			  </h6>
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
					echo form_open_multipart('Call_center/callcenter_querylog_master',$attributes); ?>
						  <div class="os-tabs-w" style="width:100%;">
						<div class="os-tabs-controls os-tabs-complex">
						  <ul class="nav nav-tabs">
							<li class="nav-item" style="width:25%;">
							  <a aria-expanded="false" class="nav-link"  href="<?php echo base_url()?>index.php/Call_center/edit_handle_member_home"><span class="tab-label">Profile</span></a>
							</li>
							<li class="nav-item"  style="width:30%;">
							  <a aria-expanded="false" class="nav-link"  href="<?php echo base_url()?>index.php/Call_center/edit_handle_member_transaction"><span class="tab-label">Transaction Details</span></a>
							</li>
							<li class="nav-item"  style="width:24%;">
							  <a aria-expanded="false" class="nav-link" href="<?php echo base_url()?>index.php/Call_center/edit_handle_member_query_record"><span class="tab-label">Query Records</span></a>
							</li>
							<li class="nav-item"  >
							  <a aria-expanded="true" class="nav-link active"  href="<?php echo base_url()?>index.php/Call_center/edit_handle_member_log_query"><span class="tab-label">Log Query</span></a>
							</li>
						   
						  </ul>
						</div>
					</div>
				<div class="element-box">
					<div class="row">
						<div class="col-md-6">
								<?php $Fname = $results->First_name; $Lname = $results->Last_name; ?>
											
							<div class="form-group">
								<label for="">Member Name</label>
								<input type="text" name="Cust_name"  id="Cust_name"  readonly value="<?php echo $Fname.' '.$Lname; ?>" class="form-control" />
							</div>	
							<div class="form-group">
								<label for="">Membership ID </label>
								<input type="text" readonly name="membershipId"  id="membershipId" value="<?php echo $results->Card_id; ?>" class="form-control"/>									
							</div>
							
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Query Type  </label>
								<select class="form-control" name="Query_Type" id="Query_Type" required>
								<option value="">Select Query Type</option>
								<?php								
								foreach($query_type as $query_type)
								{	
								?>
								<option value="<?php echo $query_type->Query_type_id; ?>"><?php echo $query_type->Query_type_name; ?></option>
								<?php
								}
								?>
								</select>	
							</div>
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Sub Query Type  </label>
								<select class="form-control" id="Sub_query_type" name="Sub_query_type" required>
								<option value="">Select Sub Query </option>
								</select>
							</div>	
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Query Details  </label>
								<textarea class="form-control z2" rows="4" name="Query_detail" id="Query_detail" required></textarea>
							</div>	
							
						</div>
						
						
						<div class="col-md-6">
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Type of Call  </label>
								<select class="form-control" id="CallType" name="CallType" required>
								<option value="">Select Call Type </option>
								<option value="Inbound">Inbound </option>
								<option value="Outbound">Outbound </option>
								</select>
							</div>	
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Communication Type  </label>
								<select class="form-control" id="Comm_type" name="Comm_type" required>
								<option value="">Select Communication Type </option>
								<option value="Email">Email </option>
								<option value="Voice">Voice </option>
								</select>
							</div>
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Query Priority  </label>
								<select class="form-control" id="Query_priority" name="Query_priority" required>
								<option value="">Select Query priority  </option>
								<?php 
								foreach($prioritylevel as $prioritylevel)
								{	
								?>
								<option value="<?php echo $prioritylevel->Resolution_priority_levels; ?>"><?php echo $prioritylevel->Level_name; ?></option>
								<?php
								}
								?>
								</select>
							</div>
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Expected Closure Date And Time  </label>
								<input class="form-control" type="text" name="exptime" id="exptime" readonly="readonly">
								
							</div>
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Have you been able to resolve this Query ?  </label><br>
								<label class="radio-inline">
								<input type="radio" name="Query_status" onclick="show_closeremark_div(this.value,'1');"  value="1" required >Yes
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="Query_status" onclick="show_closeremark_div(this.value,'1');"  checked value="2" required>No
								</label>
							</div>
							<div class="form-group"  id="Closure"  style="display:none;" >
								<label for=""><span class="required_info">*</span> Closure Remarks  </label>
								<textarea class="form-control z2" rows="3" name="Closerremark" id="Closerremark" ></textarea>
							</div>
								
						</div>
					</div>
					<div class="form-buttons-w"  align="center">
						<input type="hidden" name="Enrollment_id" value="<?php echo $results->Enrollement_id; ?>" class="form-control" />
						<input type="hidden" name="Enrollment_image" value="<?php echo $results->Photograph; ?>" class="form-control" />
						<input type="hidden" name="User_id" value="<?php echo $results->User_id; ?>" class="form-control" />
					<button class="btn btn-primary" name="submit" id="Register"  type="submit">Submit</button>
					<button type="reset" class="btn btn-primary">Reset </button>
				 </div>
				</div>
			</div>
			
		  </div>
		</div>
</div>				
	
 </div>

			
<?php echo form_close(); ?>
<?php $this->load->view('header/footer'); ?>


<script>
	$(document).ready(function() 
	{
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			yearRange: "-80:+0",
			changeYear: true
		});
		$( "#datepicker1" ).datepicker({
			changeMonth: true,
			yearRange: "-80:+0",
			changeYear: true
		});
	});
	
$('#Query_Type').change(function()
{	
	var Query_Type = $("#Query_Type").val();
	var Company_id = '<?php echo $Company_id ; ?>';
	
	$.ajax({
		type:"POST",
		data:{QueryTypeId:Query_Type, Company_id:Company_id},
		url: "<?php echo base_url()?>index.php/Call_center/Get_Sub_Query",
		
		success: function(data)
		{
			$('#Sub_query_type').html(data.Get_Sub_query_Names1);		
		}				
	});
});

$('#Query_priority').change(function()
{	
	var Query_priority = $("#Query_priority").val();
	var Company_id = '<?php echo $Company_id ; ?>';
	
	$.ajax({
		type:"POST",  
		data:{Query_priority:Query_priority, Company_id:Company_id},
		url: "<?php echo base_url()?>index.php/Call_center/Get_Expected_closure_time",
		
		success: function(data)
		{
			json = eval("(" + data + ")");		
			$('#exptime').val(json[0].Expected_closure1);		
		}				
	});
});

function show_closeremark_div(redeem_flag,div_flag)
	{
	// alert(div_flag);
		if(div_flag==1 && redeem_flag == 1)
		{
			// $("#Closure").show();	
			document.getElementById('Closure').style.display = "";	
			$("#Closerremark").Attr("required","required");
		}
		else if(div_flag==1 && redeem_flag == 2)
		{				
			// $("#Closure").hide();
			document.getElementById('Closure').style.display = "none";
			$("#Closerremark").removeAttr("required");
		}
	}

</script>
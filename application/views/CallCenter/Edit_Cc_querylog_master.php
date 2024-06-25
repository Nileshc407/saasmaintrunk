<?php 
	$this->load->view('header/header');
	$ci_object = &get_instance();
	$ci_object->load->model('CallCenter_model');
	$ci_object->load->model('Igain_model'); 
	?>
<?php $get_enrollment = $ci_object->CallCenter_model->get_cust_details($Querylog_details->Membership_id,$Company_id); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				 Member Log Query Update - <?php echo $get_enrollment->First_name.' '.$get_enrollment->Last_name." (".$Querylog_details->Membership_id.")";?> 
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
					echo form_open_multipart('Call_center/Update_callcenter_querylog_master',$attributes); ?>
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
								<input type="text" name="Cust_name"  id="Cust_name"  readonly value="<?php echo $get_enrollment->First_name.' '.$get_enrollment->Last_name; ?>" class="form-control" />
							</div>	
							<div class="form-group">
								<label for="">Membership ID </label>
								<input type="text" readonly name="membershipId"  id="membershipId" value="<?php echo $Querylog_details->Membership_id; ?>" class="form-control"/>									
							</div>
							<div class="form-group">
								<label for=""><span class="required_info">*</span>Ticket Number	 </label>
								<input type="text" name="Ticket_number" id="Ticket_number" readonly value="<?php echo $Querylog_details->Querylog_ticket; ?>" class="form-control"/>									
							</div>
							<?php 
								$GetTicketInfo = $ci_object->CallCenter_model->Get_ticket_info($Querylog_details->Querylog_ticket,$Company_id); 
								$QryType = $GetTicketInfo->Query_type_id;
								$GetQryInfo = $ci_object->CallCenter_model->Get_Call_center_query_type($Company_id,$QryType); 
								
								$GetSubQryInfo = $ci_object->CallCenter_model->Get_Call_center_sub_query($Company_id,$GetTicketInfo->Sub_query_type_id);
								
								$GetPriority = $ci_object->CallCenter_model->Get_Resolution_priority_levels($Company_id,$GetTicketInfo->Resolution_priority_levels); 
							?>
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Query Type  </label>
								<select class="form-control" name="querytype" id="querytype" required>
								<option value="<?php echo $GetQryInfo->Query_type_name; ?>"><?php echo $GetQryInfo->Query_type_name; ?></option>
								
								</select>	
							</div>
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Sub Query Type  </label>
								<select class="form-control" id="subquery" name="subquery" required>
								<option value="<?php echo $GetSubQryInfo->Sub_query; ?>"><?php echo $GetSubQryInfo->Sub_query; ?></option>
								</select>
							</div>	
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Query Details  </label>
								<textarea class="form-control z2" rows="4" name="Query_detail" id="Query_detail" readonly><?php echo $Querylog_details->Query_details; ?></textarea>
							</div>	
							
						</div>
						
						
						<div class="col-md-6">
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Type of Call  </label>
								<select class="form-control" id="CallType" name="CallType" required>
									<option value="">Select Call Type </option>
									<option value="Inbound" <?php if($Querylog_details->Call_type == 'Inbound') { ?> selected <?php } ?>>Inbound </option>
									<option value="Outbound" <?php if($Querylog_details->Call_type == 'Outbound') { ?> selected <?php } ?>>Outbound </option>
									</select>
							</div>	
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Communication Type  </label>
								<select class="form-control" id="Comm_type" name="Comm_type" required>
								<option value="">Select Communication Type </option>
								<option value="Email" <?php if($Querylog_details->Communication_type == 'Email') { ?> selected <?php } ?>>Email </option>
								<option value="Voice" <?php if($Querylog_details->Communication_type == 'Voice') { ?> selected <?php } ?>>Voice </option>
								</select>
							</div>
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Query Priority  </label>
								<select class="form-control" id="QueryPriority" name="QueryPriority" required>
								<option value="<?php echo $GetPriority->Level_name; ?>"><?php echo $GetPriority->Level_name; ?></option>
								
								</select>
							</div>
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Expected Closure Date And Time  </label>
								<input class="form-control" type="text" name="exptime" id="exptime" readonly="readonly" value="<?php echo $Querylog_details->Closure_date; ?>">
								
							</div>
							<div class="form-group">
								<label for=""><span class="required_info">*</span> Query Status</label><br>
								<select class="form-control" id="QryStatus" required name="QryStatus" onclick="javascript:hideseller(this.value);">
								<option value="">Select Query Status</option>
								<option value="Close">Close</option>
								<option value="Forward">Forward</option>
								</select>
								</div>
							
								<div class="form-group"  id="close">
								<label for="exampleInputEmail1"><span class="required_info">*</span> Closure Remarks  </label>
								<textarea class="form-control z2" rows="4" name="Closerremark" id="Closerremark" required></textarea>
								</div>
								
								<div class="Forward" id="Forward" style="display:none;">
									
									<div class="form-group">
										<label for=""><span class="required_info">*</span>Interaction Details </label>
										<textarea class="form-control z2" rows="3" name="Interaction_detail" id="Interaction_detail" required></textarea>
									</div>
								
								
							
									<div class="form-group">
										<label for=""><span class="required_info">*</span>User Type </label>
										<select class="form-control" id="usertype" id="usertype" required>
										<option value="">Select User Type</option>
										<option value="6">Call Center User</option>
										</select>
									</div>
										
								
											<div class="form-group">
												<label for=""><span class="required_info">*</span>User Name </label>
												<select class="form-control" name="UserName" id="UserName" required>
												<option value="">Select User Name</option>
												</select>
											</div>
										
										
								</div>
						</div>
					</div>
					<div class="form-buttons-w"  align="center">
						<input type="hidden" name="QueryLogId" id="QueryLogId" value="<?php echo $Querylog_details->Query_log_id; ?>" class="form-control"/>
						<input type="hidden" name="CustEnrollId" id="CustEnrollId" value="<?php echo $get_enrollment->Enrollement_id; ?>" class="form-control"/>
						<input type="hidden" name="Qlogdate" id="Qlogdate" value="<?php echo $Querylog_details->Creation_date; ?>" class="form-control"/>
						
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

function hideseller(id)
{
	var data = id;
	
	if(data == "Forward")
	{
		document.getElementById('Forward').style.display = "";
		document.getElementById('close').style.display = "none";
		// $("#Forward").show();			
		// $("#close").hide();	
		$("#Closerremark").removeAttr("required");			
		$("#Interaction_detail").attr("required","required");
		$("#usertype").attr("required","required");	
		$("#UserName").attr("required","required");	
	}		
	if(data == "Close")
	{
		document.getElementById('close').style.display = "";
		document.getElementById('Forward').style.display = "none";
		// $("#Forward").hide();
		// $("#close").show();		
		$("#Interaction_detail").removeAttr("required");		
		$("#usertype").removeAttr("required");		
		$("#UserName").removeAttr("required");	
		$("#Closerremark").attr("required","required");	
	}
} 
$('#usertype').change(function()
{	
	var User_id = $("#usertype").val();
	var Company_id = '<?php echo $Company_id ; ?>';
	// var queryTypeId = "<?php echo $GetTicketInfo->Query_type_id; ?>";
	
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

function receipt_details1(Querylog_ticket)
{	
	var Company_id = '<?php echo $Company_id; ?>';
	
	$.ajax({
		type: "POST",
		data: {TicketNo: Querylog_ticket, Company_id:Company_id},
		url: "<?php echo base_url()?>index.php/Call_center/Query_interaction_details",
		success: function(data)
		{
		
			$("#show_transaction_receipt").html(data.transactionReceiptHtml);	
			$('#receipt_myModal').modal('show');
		}
	});
}
</script>
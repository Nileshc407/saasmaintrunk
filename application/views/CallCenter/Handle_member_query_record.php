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
					echo form_open_multipart('Call_center/member_query_record',$attributes); ?>
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
							  <a aria-expanded="false" class="nav-link active" href="<?php echo base_url()?>index.php/Call_center/edit_handle_member_query_record"><span class="tab-label">Query Records</span></a>
							</li>
							<li class="nav-item"  >
							  <a aria-expanded="true" class="nav-link"  href="<?php echo base_url()?>index.php/Call_center/edit_handle_member_log_query"><span class="tab-label">Log Query</span></a>
							</li>
						   
						  </ul>
						</div>
					</div>
	
			  <div class="element-box">
					<div class="row">
					
						<div class="col-md-6">
							
							<div class="form-group">
								<label for=""><span class="required_info">*</span>Ticket Number</label>
								<input type="text" name="TicketNo" id="TicketNo"  class="form-control" placeholder="Enter Ticket Number"required/>									
							</div>
						
						</div>
						<div class="col-md-6">
							
							
							<div class="form-group">
								<label for=""><span class="required_info">*</span>Query Status</label>
								<select class="form-control" id="Query_status" name="Query_status" required>
								<option value="">Select Query Status</option>
								<?php 
								foreach($Memberquerystatus as $status)
								{	
								?>
								<option value="<?php echo $status->Query_status; ?>"><?php echo $status->Query_status; ?></option>
								<?php
								}
								?>
								</select>									
							</div>											
						</div>	
					</div>
					<div class="form-buttons-w"  align="center">
					<input type="hidden" id="Enrollment_id" name="Enrollment_id" value="<?php echo $results->Enrollement_id; ?>" class="form-control" />
					<input type="hidden" name="Enrollment_image" value="<?php echo $results->Photograph; ?>" class="form-control" />
					<input type="hidden" name="User_id" value="<?php echo $results->User_id; ?>" class="form-control" />
					<button type="button" name="Search"  ID="Search"  class="btn btn-primary" onclick="search_query_record();">Search</button>
				 </div>
				</div>
			</div>
			
		  </div>
		</div>
</div>				
	<!--------------Table------------->
	<div class="content-panel"   id="Search_query">             
		<div class="element-wrapper">											
			<div class="element-box">
			  <h5 class="form-header">
			   Member Query Records
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
							<th class="text-center">Ticket</th>
							<th class="text-center">Query Type</th>
							<th class="text-center">Priority</th>
							<th class="text-center">Query Status</th>
							<th class="text-center">Interactions</th>
						</tr>
						
					</thead>						
					
					<tbody>
				<?php
									$todays = date("Y-m-d");
									
									if($Memberquery != NULL)
									{
										foreach($Memberquery as $row)
										{							
											
										?>
										<tr>		
											<td class="text-center"><?php echo $row->Querylog_ticket;?>
											</td>
											<?php $QueryName = $ci_object->CallCenter_model->get_query_details($row->Query_type_id,$Company_id); ?>
											<td><?php echo $QueryName->Query_type_name; ?></td>	
											<?php $PriorityName = $ci_object->CallCenter_model->Get_Priority_level_detail($row->Resolution_priority_levels,$Company_id); ?>
											<td class="text-center">
											
												<?php if($PriorityName->Resolution_priority_levels==1){ echo '<span class="badge badge-success-inverted" href="#"   style="width: 100%;">'.$PriorityName->Level_name.'</span>';} ?>
												<?php if($PriorityName->Resolution_priority_levels==2){ echo '<span class="badge badge-danger-inverted" href="#"   style="background-color: #fbe4a0 !important;width: 100%;">'.$PriorityName->Level_name.'</span>';} ?>
												<?php if($PriorityName->Resolution_priority_levels==3){ echo '<span class="badge badge-danger-inverted" href="#" style="width: 100%;background-color: #ffb3b3 !important;">'.$PriorityName->Level_name.'</span>';} ?>
												<?php if($PriorityName->Resolution_priority_levels==4){ echo '<span class="badge badge-primary-inverted" href="#"   style="width: 100%;">'.$PriorityName->Level_name.'</span>';} ?>
												
												
											</td>
											<td class="text-center">
											<?php
											if($row->Query_status=='Forward'){ echo '<div class="status-pill green" title="Forward" data-placement="top"  data-toggle="tooltip"></div>';} 
											
											 if($row->Query_status=='Closed'){ echo '<div class="status-pill red" title="Closed" data-placement="top"  data-toggle="tooltip"></div>';} ?>
											
											
											</td>	
											<?php $get_enrollment = $ci_object->Igain_model->get_enrollment_details($row->Create_User_id); ?>
											<td class="text-center">
											<a href="javascript:void(0);" id="receipt_details" onclick="receipt_details1('<?php echo $row->Querylog_ticket; ?>');" title="Details">
											<i class="os-icon os-icon-grid-10" ></i>
											</a>								
											</td>											
											
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
	</div> 
	<!--------------Table--------------->
    
 </div>

			
<?php echo form_close(); ?>
<?php $this->load->view('header/footer'); ?>

<!-- Modal -->

	
	<div id="receipt_myModal" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<h5 class="modal-title" id="exampleModalLabel">
				   Receipt Details
				</h5>-->
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
			  </div>
			  <div class="modal-body">
				<div  id="show_transaction_receipt"></div>
			  </div>
			  <div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button>
			  </div>
			</div>
		</div>
    </div>
<!-- Modal -->
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
	
function search_query_record()
{	 
	var Query_status = $("#Query_status").val();
	var TicketNo = $("#TicketNo").val();
	var Enrollment_id = $("#Enrollment_id").val();
	var Company_id = '<?php echo $Company_id; ?>';
			$.ajax({
				type:"POST",
				data:{TicketNo:TicketNo, Query_status:Query_status, Enrollment_id:Enrollment_id,Company_id:Company_id},
				url: "<?php echo base_url()?>index.php/Call_center/search_memeber_query",
				success : function(data)
				{ 
					//alert(data);
					document.getElementById("Search_query").innerHTML=data;
				}
			});
}
function receipt_details1(Querylog_ticket)
{	
	var Company_id = '<?php echo $Company_id; ?>';
	//alert("--Bill_no--"+Bill_no+"--Seller_id--"+Seller_id+"--Trans_id--"+Trans_id);
	// var Transaction_type = 3;
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
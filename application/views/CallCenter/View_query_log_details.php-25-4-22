<?php $this->load->view('header/header'); 
 $ci_object = &get_instance();
$ci_object->load->model('CallCenter_model');
$ci_object->load->model('Igain_model');
 ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				View Query Details
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
					echo form_open_multipart('Call_center/view_query_log_details',$attributes); ?>
				
				<div class="element-box">
					<div class="row">
					
							
										<div class="col-md-4">
											<div class="form-group">
												<label for="">
												<span class="required_info"> * </span>	Enter Query Log Ticket</label>
												<input type="text" name="Log_ticket"  id="Log_ticket"  class="form-control" placeholder="Query Log Ticket"  />									
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label for="">
												<span class="required_info"> * </span> Query Priority Level</label>
												<select  class="form-control" name="querypriority" id="querypriority">
												<option value="">Select Priority Level</option>
										<?php 	if($get_prioritylevel != NULL)
												{
													foreach($get_prioritylevel as $get_prioritylevel2)
													{		
												?> <option value="<?php echo $get_prioritylevel2->Resolution_priority_levels; ?>"> <?php echo $get_prioritylevel2->Level_name; ?> </option>
												<?php
													}
												} ?>
												</select>									
											</div>
										</div>
										<div class="col-md-4">		
											<div class="form-group">
												<label for=""> Expected Closure Date<span class="required_info"> (* click inside textbox)</span></label>
												<input type="text" name="Expected_closure_date" id="datepicker1"  class="form-control" />	<!--single-daterange  -->								
											</div>
										</div>
						
					</div>
					<div class="form-buttons-w"  align="center">
						
					<button class="btn btn-primary" name="submit" id="Register"  type="submit">Search</button>
					<button type="reset" class="btn btn-primary" onclick="javascript:window.location='view_query_log_details';">Refresh </button>
				 </div>
				 
				
				</div>
				
<!--------------------
      START - Basic Table
      --------------------				
<div class="element-wrapper">
  <div class="element-box">
    <h5 class="form-header">
      Query Log Tickets Assigned to <?php echo $LogginUserName; ?>
    </h5>
  
    <div class="table-responsive">
      
      <table class="table table-striped table-bordered">
	  <?php				
				if($Assign_qry != NULL)
				{ ?>
        <thead>
          <tr>
           <th class="text-center">Action</th>
			<th class="text-center">Ticket</th>
			<th class="text-center">Query Priority</th>
			<th class="text-center">Member Name</th>
			<th class="text-center">Query Type</th>
			<th class="text-center">Creation Date</th>
			<th class="text-center">Created By</th>
			<th class="text-center">Expected Close Date</th>
			<th class="text-center">Query Status</th>
			<th class="text-center">Interactions</th>
          </tr>
        </thead>
        <tbody>
			<?php				
				
					foreach($Assign_qry as $row)
					{	?>													
						<tr>
							
							<td  class="text-center"><a href="<?php echo base_url()?>index.php/Call_center/Edit_Cc_querylog/?Child_query_log_id=<?php echo $row->Child_query_log_id;?>"  title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
							</td>
							<td class="text-center"><?php echo $row->Querylog_ticket;?>
							</td>
							<td class="text-center">
											
							<?php if($row->Resolution_priority_levels==1){ echo '<div class="badge badge-success-inverted" href=""  style="width: 100%;">'.$row->Level_name.'</div>';} ?>
							<?php if($row->Resolution_priority_levels==2){ echo '<div class="badge badge-danger-inverted" href=""  style="background-color: #fbe4a0 !important;width: 100%;">'.$row->Level_name.'</div>';} ?>
							<?php if($row->Resolution_priority_levels==3){ echo '<div class="badge badge-danger-inverted" href="" style="background-color: #ffb3b3 !important;width: 100%;">'.$row->Level_name.'</div>';} ?>
							<?php if($row->Resolution_priority_levels==4){ echo '<div class="badge badge-primary-inverted" href="" style="width: 100%;">'.$row->Level_name.'</div>';} ?>
							
							
						</td>
							<?php $get_enrollment = $ci_object->CallCenter_model->get_cust_details($row->Membership_id,$Company_id); ?>
							<td class="text-center"><?php echo $get_enrollment->First_name.' '.$get_enrollment->Last_name; ?>
							</td>
							<?php $get_queryName = $ci_object->CallCenter_model->get_query_details($row->Query_type_id,$Company_id); ?>
							<td class="text-center"><?php echo $get_queryName->Query_type_name; ?>
							</td>
							<td class="text-center"><?php echo $row->Creation_date;?>
							</td>
							<?php $get_enrollment = $ci_object->Igain_model->get_enrollment_details($row->Create_User_id); ?>
							<td class="text-center"><?php echo $get_enrollment->First_name.' '.$get_enrollment->Last_name; ?>
							</td>
							
							<td class="text-center"><?php echo $row->Closure_date;?>
							</td>
								<td class="text-center">
							<?php
							if($row->Query_status=='Forward'){ echo '<div class="status-pill green" title="Forward" data-placement="top"  data-toggle="tooltip"></div>';} 
							
							 if($row->Query_status=='Closed'){ echo '<div class="status-pill red" title="Closed" data-placement="top"  data-toggle="tooltip"></div>';} ?>
							
							
							</td>
							<td class="text-center">
							<a href="javascript:void(0);" id="receipt_details" onclick="receipt_details1('<?php echo $row->Querylog_ticket; ?>');" title="Details"><i class="os-icon os-icon-grid-10" ></i>
							</a>								
							</td>
						</tr>									
			<?php	}
				}else {echo '<span class="required_info">No Records Found !!!</span>';} ?>		
						
        </tbody>
      </table>
     
    </div>
  </div>
</div>
 <!--------------------
      END - Basic Table
      -------------------->				
<div class="element-wrapper">
  <div class="element-box">
    <h5 class="form-header">
      All Query Log Tickets (Forward) 
    </h5>
    
    <div class="table-responsive">
      <!--------------------
      START - Basic Table
      -------------------->
      <table class="table table-striped table-bordered">
		<?php				
	if($Forward_qury != NULL)
	{ ?>
        <thead>
          <tr>
           <th class="text-center">Action</th>
			<th class="text-center">Ticket</th>
			<th class="text-center">Query Priority</th>
			<th class="text-center">Member Name</th>
			<th class="text-center">Query Type</th>
			
			<th class="text-center">Creation Date</th>
			<th class="text-center">Created By</th>
			<th class="text-center">Expected Close Date</th>
			<th class="text-center">Query Status</th>
			<th class="text-center">Interactions</th>
          </tr>
        </thead>
       <tbody>														
							<?php				
			
				foreach($Forward_qury as $row)
				{	?>													
					<tr>
						
						<td class="text-center"><a href="<?php echo base_url()?>index.php/Call_center/Edit_Cc_querylog/?Child_query_log_id=<?php echo $row->Child_query_log_id;?>"  title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
						</td>
						<td class="text-center"><?php echo $row->Querylog_ticket;?>
						</td>
						<td class="text-center">
											
							<?php if($row->Resolution_priority_levels==1){ echo '<div class="badge badge-success-inverted" href=""  style="width: 100%;">'.$row->Level_name.'</div>';} ?>
							<?php if($row->Resolution_priority_levels==2){ echo '<div class="badge badge-danger-inverted" href=""  style="background-color: #fbe4a0 !important;width: 100%;">'.$row->Level_name.'</div>';} ?>
							<?php if($row->Resolution_priority_levels==3){ echo '<div class="badge badge-danger-inverted" href="" style="background-color: #ffb3b3 !important;width: 100%;">'.$row->Level_name.'</div>';} ?>
							<?php if($row->Resolution_priority_levels==4){ echo '<div class="badge badge-primary-inverted" href="" style="width: 100%;">'.$row->Level_name.'</div>';} ?>
							
						</td>
						<?php $get_enrollment = $ci_object->CallCenter_model->get_cust_details($row->Membership_id,$Company_id); ?>
						<td class="text-center"><?php echo $get_enrollment->First_name.' '.$get_enrollment->Last_name; ?>
						</td>
						<?php $get_queryName = $ci_object->CallCenter_model->get_query_details($row->Query_type_id,$Company_id); ?>
						<td class="text-center"><?php echo $get_queryName->Query_type_name; ?>
						</td>
						
						
						<td class="text-center"><?php echo $row->Creation_date;?>
						</td>
						<?php $get_enrollment = $ci_object->Igain_model->get_enrollment_details($row->Create_User_id); ?>
						<td class="text-center"><?php echo $get_enrollment->First_name.' '.$get_enrollment->Last_name; ?>
						</td>
						
						<td class="text-center"><?php echo $row->Closure_date;?>
						</td>
							<td class="text-center">
							<?php
							if($row->Query_status=='Forward'){ echo '<div class="status-pill green" title="Forward" data-placement="top"  data-toggle="tooltip"></div>';} 
							
							 if($row->Query_status=='Closed'){ echo '<div class="status-pill red" title="Closed" data-placement="top"  data-toggle="tooltip"></div>';} ?>
							
							
							</td>
						<td class="text-center">
						<a href="javascript:void(0);" id="receipt_details" onclick="receipt_details1('<?php echo $row->Querylog_ticket; ?>');" title="Details"><i class="os-icon os-icon-grid-10" ></i>
						</a>								
						</td>
					</tr>									
		<?php	}
			} else {echo '<span class="required_info">No Records Found !!!</span>';}  ?>												
							</tbody> 
      </table>
      <!--------------------
      END - Basic Table
      -------------------->
    </div>
  </div>
</div>
				
<div class="element-wrapper">
  <div class="element-box">
    <h5 class="form-header">
      All Query Log Tickets (Closed)
    </h5>
  
    <div class="table-responsive">
      <!--------------------
      START - Basic Table
      -------------------->
      <table class="table table-striped table-bordered">
	  				<?php				
			if($closed_qury != NULL)
			{ ?>
        <thead>
          <tr>
            <th class="text-center">Ticket</th>
			<th class="text-center">Query Priority</th>
			<th class="text-center">Member Name</th>
			<th class="text-center">Query Type</th>
			
			<th class="text-center">Creation Date</th>
			<th class="text-center">Query Status</th>
			<th class="text-center">Interactions</th>
          </tr>
        </thead>
       <tbody>														
								<?php				
			
				foreach($closed_qury as $row)
				{	?>													
					<tr>
						<td class="text-center"><?php echo $row->Querylog_ticket;?>
						</td>
						<td class="text-center">
											
							<?php if($row->Resolution_priority_levels==1){ echo '<div class="badge badge-success-inverted" href=""  style="width: 100%;">'.$row->Level_name.'</div>';} ?>
							<?php if($row->Resolution_priority_levels==2){ echo '<div class="badge badge-danger-inverted" href=""  style="background-color: #fbe4a0 !important;width: 100%;">'.$row->Level_name.'</div>';} ?>
							<?php if($row->Resolution_priority_levels==3){ echo '<div class="badge badge-danger-inverted" href="" style="background-color: #ffb3b3 !important;width: 100%;">'.$row->Level_name.'</div>';} ?>
							<?php if($row->Resolution_priority_levels==4){ echo '<div class="badge badge-primary-inverted" href="" style="width: 100%;">'.$row->Level_name.'</div>';} ?>
							
							
						</td>
						<?php $get_enrollment = $ci_object->CallCenter_model->get_cust_details($row->Membership_id,$Company_id); ?>
						<td class="text-center"><?php echo $get_enrollment->First_name.' '.$get_enrollment->Last_name; ?>
						</td>
						
						<?php $get_queryName = $ci_object->CallCenter_model->get_query_details($row->Query_type_id,$Company_id); ?>
						<td class="text-center"><?php echo $get_queryName->Query_type_name; ?>
						</td>
						
						<td class="text-center"><?php echo $row->Creation_date; ?>
						</td>
							<td class="text-center">
							<?php
							if($row->Query_status=='Forward'){ echo '<div class="status-pill green" title="Forward" data-placement="top"  data-toggle="tooltip"></div>';} 
							
							 if($row->Query_status=='Closed'){ echo '<div class="status-pill red" title="Closed" data-placement="top"  data-toggle="tooltip"></div>';} ?>
							
							
							</td>	
						<td class="text-center">
						<a href="javascript:void(0);" id="receipt_details" onclick="receipt_details1('<?php echo $row->Querylog_ticket; ?>');" title="Details"><i class="os-icon os-icon-grid-10" ></i>
						</a>								
						</td>
					</tr>									
		<?php	}
			}  else {echo '<span class="required_info">No Records Found !!!</span>';}   ?>													
							</tbody> 
      </table>
      <!--------------------
      END - Basic Table
      -------------------->
    </div>
  </div>
</div>
	
			</div>
			
		  </div>
		</div>
</div>				
	
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
	
function receipt_details(Bill_no,Seller_id,Trans_id)
{	
	//alert("--Bill_no--"+Bill_no+"--Seller_id--"+Seller_id+"--Trans_id--"+Trans_id);
	var Transaction_type = 2;
	$.ajax({
		type: "POST",
		data: {Bill_no: Bill_no, Seller_id:Seller_id,Trans_id:Trans_id,Transaction_type:Transaction_type},
		url: "<?php echo base_url()?>index.php/Transactionc/transaction_receipt",
		success: function(data)
		{
			$("#show_transaction_receipt").html(data.transactionReceiptHtml);	
			$('#receipt_myModal').modal('show');
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
/*function search_transaction_record()
{	 
	var from_date = $("#datepicker").val();  
	var to_date = $("#datepicker1").val();
	var Enrollment_id = $("#Enrollment_id").val();
	var Company_id = '<?php echo $Company_id; ?>';
			$.ajax({
				type:"POST",
				data:{from_date:from_date,to_date:to_date,Enrollment_id:Enrollment_id,Company_id:Company_id},
				url: "<?php echo base_url()?>index.php/Call_center/search_memeber_transaction",
				success : function(data)
				{ 
					//alert(data);
					document.getElementById("Search_tran").innerHTML=data;
				}
			});
}*/
</script>
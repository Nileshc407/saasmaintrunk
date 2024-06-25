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
				CALL CENTER QUERY SETUP
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
					echo form_open_multipart('Call_center/Call_center_sub_queries',$attributes); ?>
						
					  <div class="form-group" id="User_Type">
						<label for=""><span class="required_info">* </span>Select Query Type</label>
						<select class="form-control" name="Querytype" id="Querytype" data-error="Please select query type" required="required">
						<option value="">Select Query Type</option>
						 <?php
						if($Querytype != NULL)
						{
							foreach($Querytype as $row1)
							{	?>		
								<option value="<?php echo $row1->Query_type_id; ?>" ><?php echo $row1->Query_type_name; ?> </option>
					<?php	}
						} ?>
						</select>
						<div class="help-block form-text with-errors form-control-feedback"></div>
					  </div>
					  <div class="form-group">
						<label for=""><span class="required_info">* </span>Enter Sub Query</label>
						<input class="form-control" type="text" name="Sub_Query" id="Sub_Query" placeholder="Enter sub query" data-error="Please enter sub query" required="required">
						<div class="help-block form-text with-errors form-control-feedback" id="help-block1"></div>
					  </div>
					  
					  <div class="form-group">
						<label><span class="required_info">* </span>Enter Remarks</label>
						<textarea class="form-control" rows="3" name="subqueryreemark" id="subqueryreemark" data-error="Please enter remarks" required="required" ></textarea>
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
				   Qurey Setup Master
				  </h6>                  
				  <div class="table-responsive">
					<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
						<thead>
							<tr>
								<th>Action</th>
								<th>Query Type</th>
								<th>Sub Query</th>
								<th>Remark</th>
								</tr>
						</thead>						
						<tfoot>
							<tr>
								<th>Action</th>
								<th>Query Type</th>
								<th>Sub Query</th>
								<th>Remark</th>
							</tr>
						</tfoot>
						<tbody>
					<?php
						$todays = date("Y-m-d");	
						if($CallCenterSubQueryType != NULL)
						{
							foreach($CallCenterSubQueryType as $row)
							{	?>
							<tr>
								<td class="row-actions">
									<a href="<?php echo base_url()?>index.php/Call_center/Edit_Call_center_sub_query/?Query_id=<?php echo $row->Query_id;?>" title="Edit"><i class="os-icon os-icon-ui-49"></i></a>
								</td>
								
								<?php $get_Qurey_name=$ci_object->CallCenter_model->Call_center_queryTypeName($row->Query_type_id); ?>
								
								<td><?php echo $get_Qurey_name->Query_type_name;?></td>
								<td><?php echo $row->Sub_query;?></td>
								<td><?php echo $row->Query_remarks;?></td>
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
	if( $('#Querytype').val() != "" && $('#Sub_Query').val() != "" && $('#subqueryreemark').val() != "")
	{
		show_loader();
		return true;
	}
});   

$('#Sub_Query').blur(function()
{	
	if($("#Sub_Query").val() == "")
	{
		$("#Sub_Query").val("");
		$("#help-block1").html("Please enter sub query");
		$("#Sub_Query").addClass("form-control has-error");
	}
	else
	{
		var Sub_Query = $("#Sub_Query").val();
		var Company_id ='<?php echo $Company_details->Company_id; ?>';
		$.ajax({
			type: "POST",
			data: {Sub_Query: Sub_Query, Company_id: Company_id},
			url: "<?php echo base_url()?>index.php/Call_center/Check_Call_center_Sub_query",
			success: function(data)
			{						
				if(data.length == 13)
				{							
					$("#Sub_Query").val("");
					$("#help-block1").html("Already exist");
					$("#Sub_Query").addClass("form-control has-error");
				}
				else
				{
					$("#Sub_Query").removeClass("has-error");
					$("#help-block1").html("");
				}
			}
		});
	}	
});	
</script>
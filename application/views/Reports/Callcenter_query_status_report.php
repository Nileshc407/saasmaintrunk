<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Cc_query_status_reports',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">CALL CENTER QUERY STATUS REPORT</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
									<div class="form-group">
									<label for="exampleInputEmail1"><span class="required_info">*</span> Select Query Type</label>
									<select class="form-control" name="Query_Type" id="Query_Type" required  data-error="Please Select Query Type">
										<option value="">Select Query Type</option>
										<option value="0">All</option>
										<?php								
										foreach($query_type as $query_type)
										{	
										?>
										<option value="<?php echo $query_type->Query_type_id; ?>"><?php echo $query_type->Query_type_name; ?></option>
										<?php
										}
										?>
									</select>	
										<div class="help-block form-text with-errors form-control-feedback"></div>	
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1"><span class="required_info">*</span> Select Query Status</label>
										
										<select class="form-control" name="Query_status" id="Query_status" required data-error="Please Select Query Status">
											<option value="">Select Query Status</option>							
											<option value="0">All</option>				
											<option value="Closed ">Closed</option>				
											<option value="Forward">Forward</option>								
										</select>		
									<div class="help-block form-text with-errors form-control-feedback"></div>			
									</div>	
								<div class="form-group">
									<label for="exampleInputEmail1">Membership ID </label>
									<div class="form-group">
									<input type="text" class="form-control" name="Membership" id="Membership">							
									</div>
								</div>
							  
							</div>
							<div class="col-sm-6">
							<div class="form-group">
						<label for="">
							<span class="required_info">*</span> From Date <span class="required_info">(* click inside textbox)</span>
						</label>
						<div class="input-group">
							<input type="text" name="start_date" id="datepicker1" class="single-daterange form-control" placeholder="Start Date" />			
							<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
						</div>
					</div>
					<div class="form-group">
						<label for="">
							<span class="required_info">*</span> Till Date<span class="required_info">(* click inside textbox)</span>
						</label>
						<div class="input-group">
							<input type="text" name="end_date" id="datepicker2" class="single-daterange form-control" placeholder="End Date" />			
							<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
						</div>
					</div>
					
							  
							</div>
						</div>
					  <div class="form-buttons-w" align="center">
						<button class="btn btn-primary" name="submit" type="submit" id="Register" value="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
					  </div>
				
		<?php echo form_close(); ?>
			</div>
		</div>
		<?php 
	 
		$From_date=date("Y-m-d",strtotime($_REQUEST["start_date"]));
		$To_date=date("Y-m-d",strtotime($_REQUEST["end_date"]));
		$Query_Type=$_REQUEST["Query_Type"];
		$Query_status1=$_REQUEST["Query_status"];
		$Membership=$_REQUEST["Membership"];
			
	?>
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">Query Status Report
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
									
									<th>Call Center User</th>
									<th>Membership Id</th>
									<th>Query Type</th>
									<th>Query</th>
									<th>Query Status</th>
									<th>Query Register Date</th>
									<th>Query Close Date</th>	
								
							</thead>						
							<tfoot>
									<th>Call Center User</th>
									<th>Membership Id</th>
									<th>Query Type</th>
									<th>Query</th>
									<th>Query Status</th>
									<th>Query Register Date</th>
									<th>Query Close Date</th>	
							</tfoot>
							<tbody>
							<?php
								 
									foreach($Query_status as $row)
									{	
										echo "<td>".$row->Full_name1."</td>";
										echo "<td>".$row->Membership_id."</td>";
										echo "<td>".$row->Query_type_name."</td>";
										echo "<td>".$row->Query_details."</td>";
										echo "<td>".$row->Query_status."</td>";
										echo "<td>".$row->Creation_date."</td>";					
										echo "<td>".$row->Closure_date."</td>";					
										echo "</tr>";
									}
								
							?>
							</tbody>
						</table>
						
						<?php if($Query_status != NULL){ ?>
						
						<a href="<?php echo base_url()?>index.php/Reportc/export_Cc_query_status_reports/?Query_Type=<?php echo $Query_Type; ?>&start_date=<?php echo $From_date; ?>&end_date=<?php echo $To_date; ?>&Membership=<?php echo $Membership; ?>&Company_id=<?php echo $Company_id; ?>&Query_status1=<?php echo $Query_status1; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
						</a>						

						<a href="<?php echo base_url()?>index.php/Reportc/export_Cc_query_status_reports/?Query_Type=<?php echo $Query_Type; ?>&start_date=<?php echo $From_date; ?>&end_date=<?php echo $To_date; ?>&Membership=<?php echo $Membership; ?>&Company_id=<?php echo $Company_id; ?>&Query_status1=<?php echo $Query_status1; ?>&pdf_excel_flag=2">
							<button class="btn btn-danger" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button>
						</a>
				<?php } ?>

					  </div>
					</div>
				</div>
				<!-----------Table------------>
			
			</div>
		</div>	
	</div>
</div>


<?php $this->load->view('header/footer'); ?>


<script>
$('#Register').click(function()
{

	 if($('#Query_Type').val() != ""  && $('#Query_status').val() != "" )
		{
			show_loader();
		} 
});



/******calender *********/
$(function() 
{
	$( "#datepicker1" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	});
	
	$( "#datepicker2" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	});
		
});
/******calender *********/
</script>

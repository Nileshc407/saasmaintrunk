<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Audit_Tracking_Report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">COMPANY ACTIVITY LOG REPORT</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							   <div class="form-group">
							   <label for=""><span class="required_info">* </span>From Date <span class="required_info">(* click inside textbox)</span></label>
								<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1" data-error="Please select from date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							   
							  <div class="form-group">
								<label for=""><span class="required_info">* </span>Menu Option</label>
								<select class="form-control" name="Transaction_from" id="Transaction_from" data-error="Please select menu option" required="required">
								<option value="">Select menu option</option>
								<option value="0">All</option>
								<?php								
									foreach($Transaction_from as $Transaction_from)
									{	?>
										<option value="<?php echo $Transaction_from->Transaction_from; ?>"><?php echo $Transaction_from->Transaction_from; ?></option>
							<?php   } ?>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
							  <div class="form-group">
								<label for=""> Enter User</label>
								<input type="text" class="form-control" name="enter_user" id="enter_user" placeholder="Enter user">
							  </div>
							</div>
							<div class="col-sm-6">
							  <div class="form-group">
							   <label for=""><span class="required_info">* </span>Till Date <span class="required_info">(* click inside textbox)</span></label>
								<input class="single-daterange form-control" placeholder="End Date" type="text"  name="end_date" id="datepicker2" data-error="Please select till date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
							 <div class="form-group">
								<label for=""><span class="required_info">* </span>User Type</label>
								<select class="form-control" name="User_type" id="User_type" data-error="Please select user type" required="required">
								<option value="">Select user type</option>							
								<option value="0">All user type</option>	
								<?php								
									foreach($User_type as $User_type)
									{ ?>
										<option value="<?php echo $User_type->User_id; ?>"><?php echo $User_type->User_type; ?></option>
							<?php   } ?>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
							  <div class="form-group">
								<label for=""><span class="required_info">* </span>Operation Mode</label>
								<select class="form-control" name="Mode" id="Mode" data-error="Please select operation" required="required">
								<option value="">Select operation</option>
								<option value="0">All</option>
								<option value="1">Insert</option>
								<option value="2">Update</option>
								<option value="3">Delete</option>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							</div>
						</div>
					  <div class="form-buttons-w" align="center">
						<button class="btn btn-primary" type="submit" id="Register" value="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
					  </div>
					</div>
				</div>
				<?php echo form_close(); ?>	
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					  Company Activity Log Report
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<th>Transction Date</th>
									<th>Who did</th>
									<th>User Type</th>
									<th>What was Done</th>
									<th>Menu Option</th>
									<th>To Whom</th>
									<th>Type of Operation</th>
									<th>Operation Value</th>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<th>Transction Date</th>
									<th>Who did</th>
									<th>User Type</th>
									<th>What was Done</th>
									<th>Menu Option</th>
									<th>To Whom</th>
									<th>Type of Operation</th>
									<th>Operation Value</th>
								</tr>
							</tfoot>
							<tbody>
						<?php
							if($Audit_Tracking != NULL)
							{
								$To_date=date("Y-m-d",strtotime($_REQUEST["end_date"])); 
								$From_date=date("Y-m-d",strtotime($_REQUEST["start_date"]));
								$Transaction_from=$_REQUEST["Transaction_from"];
								$enter_user=$_REQUEST["enter_user"];
								$User_type=$_REQUEST["User_type"];
								$Mode=$_REQUEST["Mode"];
								
								foreach($Audit_Tracking as $row)
								{	
									if($row->Operation_type == 1)
									{
									  $Operation_type = 'Insert';
									}
									if($row->Operation_type == 2)
									{
									  $Operation_type = 'Update';
									}
									if($row->Operation_type == 3)
									{
									  $Operation_type = 'Delete';
									}
									if($row->From_userid == 1)
									{
									  $Ofrom_userId = 'Customer';
									}
									if($row->From_userid == 2)
									{
									  $Ofrom_userId = 'Merchant';
									}
									if($row->From_userid == 3)
									{
									  $Ofrom_userId = 'Admin';
									}
									if($row->From_userid == 4)
									{
									  $Ofrom_userId = 'Partner admin';
									}
									if($row->From_userid == 5)
									{ 
									  $Ofrom_userId = 'Merchandize Partner User';
									}
									if($row->From_userid == 5)
									{ 
									  $Ofrom_userId = 'Merchandize Partner User';
									}
									if($row->From_userid == 6)
									{ 
									  $Ofrom_userId = 'Call Center User';
									}
									if($row->From_userid == 7)
									{ 
									  $Ofrom_userId = 'Staff Users';
									}
									echo "<tr>";
									echo "<td>".$row->Date."</td>";
									echo "<td>".$row->Transaction_by."</td>";
									echo "<td>".$row->From_userid."</td>";
									echo "<td>".$row->Transaction_type."</td>";
									echo "<td>".$row->Transaction_from."</td>";					
									echo "<td>".$row->Transaction_to."</td>";					
									echo "<td>".$row->Operation_type."</td>";
									echo "<td>".$row->Operation_value."</td>";
									echo "</tr>"; 
								}
							}	?>
							</tbody>
						</table>
						<?php if($Audit_Tracking != NULL){?>
						<a href="<?php echo base_url()?>index.php/Reportc/export_audit_tracking_report/?Transaction_from=<?php echo $Transaction_from; ?>&start_date=<?php echo $From_date; ?>&end_date=<?php echo $To_date; ?>&enter_user=<?php echo $enter_user; ?>&User_type=<?php echo $User_type; ?>&Mode=<?php echo $Mode; ?>&Company_id=<?php echo $Company_id; ?>&pdf_excel_flag=1">
						<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button></a>
						
						<a href="<?php echo base_url()?>index.php/Reportc/export_audit_tracking_report/?Transaction_from=<?php echo $Transaction_from; ?>&start_date=<?php echo $From_date; ?>&end_date=<?php echo $To_date; ?>&enter_user=<?php echo $enter_user; ?>&User_type=<?php echo $User_type; ?>&Mode=<?php echo $Mode; ?>&Company_id=<?php echo $Company_id; ?>&pdf_excel_flag=2">
						<button class="btn btn-danger" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button></a>
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
	if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "" && $('#Transaction_from').val() != ""  && $('#User_type').val() != "" )
	{
		// show_loader();
	}
	
	var btn_class_name = this.className ;
	if(btn_class_name=="btn btn-primary")
	{
		show_loader();
	}
});
/**********calender*********/
$(function() 
{
	$( "#datepicker1" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+2",
		changeYear: true
	});
	
	$( "#datepicker2" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+2",
		changeYear: true
	});
		
});
/*********calender*********/
</script>
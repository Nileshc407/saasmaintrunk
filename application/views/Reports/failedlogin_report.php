<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/failedlogin_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">COMPANY FAILED LOGIN REPORT</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							   <div class="form-group">
							   <label for=""><span class="required_info">* </span>From Date <span class="required_info">(* click inside textbox)</span></label>
								<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1" data-error="Please select from date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							   
							  <div class="form-group">
								<label for=""><span class="required_info">* </span>User Type</label>
								<select class="form-control" name="User_type" id="User_type" data-error="Please select user type" required="required">
													
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
								<label for=""><span class="required_info">* </span>Source</label>
								<select class="form-control" name="Source" id="Source" data-error="Please select Source" required="required">
												
								<option value="0">All</option>	
								<option value="4">Backend Application</option>	
								<option value="3">Member Website</option>	
								<option value="2">iOS APP</option>	
								<option value="1">Android APP</option>	
								
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
							</div>
							<div class="col-sm-6">
							  <div class="form-group">
							   <label for=""><span class="required_info">* </span>Till Date <span class="required_info">(* click inside textbox)</span></label>
								<input class="single-daterange form-control" placeholder="End Date" type="text"  name="end_date" id="datepicker2" data-error="Please select till date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
							 <div class="form-group">
								<label for=""><span class="required_info">*</span>Report Type</label>
								<select class="form-control" name="Report_type" id="Report_type" data-error="Please select Report Type" required="required">
										
								<option value="1">Details</option>	
								<option value="0">Summary</option>	
								
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
							  <div class="form-group">
								<label for=""> Enter User/ Member</label>
								<input type="text" class="form-control" name="enter_user" id="enter_user" placeholder="Enter user">
							  </div>
							</div>
						</div>
					  <div class="form-buttons-w" align="center">
						<button class="btn btn-primary" type="submit" id="Register" value="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
					  </div>
					</div>
				</div>
				<?php echo form_close(); 
				
				$To_date=date("Y-m-d",strtotime($_REQUEST["end_date"])); 
				$From_date=date("Y-m-d",strtotime($_REQUEST["start_date"]));
				$Transaction_from=$_REQUEST["Transaction_from"];
				$enter_user=$_REQUEST["enter_user"];
				$User_type=$_REQUEST["User_type"];
				$Report_type=$_REQUEST["Report_type"];
				$Source=$_REQUEST["Source"];
				?>	
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					  Company Failed Login Report
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<?php if($Report_type == 1) { ?> <th>Date</th> <?php } ?> 
									
									<th>Name</th>
									<th>Email Address</th>
									<?php if($Report_type == 1) { ?><th>Attempted Password</th><?php } ?> 
									<th>User Type</th>
									<th>Total Attempts</th>
									<?php if($Report_type == 1) { ?><th>Source</th><?php } ?> 
									
								</tr>
							</thead>						
							<tfoot>
								<tr>
								<?php if($Report_type == 1) { ?> <th>Date</th> <?php } ?> 
									
									<th>Name</th>
									<th>Email Address</th>
									<?php if($Report_type == 1) { ?><th>Attempted Password</th><?php } ?> 
									<th>User Type</th>
									<th>Total Attempts</th>
									<?php if($Report_type == 1) { ?><th>Source</th><?php } ?>
																		
								</tr>
							</tfoot>
							<tbody>
						<?php
							if($Failed_login != NULL)
							{
								
								
								foreach($Failed_login as $row)
								{	
									
									
									if($row->FirstName == ""){
										$enroll='Not-Enrolled';
									} else {
										$enroll= $row->FirstName.' '.$row->LastName;
									}
									
									$arr = json_decode($row->Location, true);
									// echo $arr["ip_address"];  
									// echo $arr["Location"]["country"];  
									
									if($arr == ""){
										$arr1='';
									} else {
										$arr1= " ( IP Address: ".$arr["ip_address"].', Country: '.$arr["Location"]["country"]." ) ";
									}
									
									
									
									echo "<tr>";
									if($Report_type == 1) { echo "<td>".$row->Date."</td>"; }
									echo "<td>".$enroll. "</td>";
									echo "<td>".$row->EmailAddress."</td>";
									if($Report_type == 1) {echo "<td>".$row->AttemptedPassword."</td>";}
									echo "<td>".$row->UserType."</td>";
									echo "<td>".$row->FailedAttempts."</td>";
									if($Report_type == 1) {echo "<td>".$row->Source."<br><div style='width:200px;word-break:break-word;'> ".$arr1." </div></td>";}
									// if($Report_type == 1) {echo "<td>".$row->Location."</td>";}
									echo "</tr>"; 
								}
							}	?>
							</tbody>
						</table>
						<?php if($Failed_login != NULL){?>
						<a href="<?php echo base_url()?>index.php/Reportc/export_failedlogin_report/?Transaction_from=<?php echo $Transaction_from; ?>&start_date=<?php echo $From_date; ?>&end_date=<?php echo $To_date; ?>&enter_user=<?php echo $enter_user; ?>&User_type=<?php echo $User_type; ?>&Source=<?php echo $Source; ?>&Company_id=<?php echo $Company_id; ?>&Report_type=<?php echo $Report_type; ?>&pdf_excel_flag=1">
						<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button></a>
						
						<a href="<?php echo base_url()?>index.php/Reportc/export_failedlogin_report/?Transaction_from=<?php echo $Transaction_from; ?>&start_date=<?php echo $From_date; ?>&end_date=<?php echo $To_date; ?>&enter_user=<?php echo $enter_user; ?>&User_type=<?php echo $User_type; ?>&Source=<?php echo $Source; ?>&Company_id=<?php echo $Company_id; ?>&Report_type=<?php echo $Report_type; ?>&pdf_excel_flag=2">
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
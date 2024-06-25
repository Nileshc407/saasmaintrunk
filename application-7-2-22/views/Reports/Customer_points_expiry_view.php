<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Customer_points_expiry',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">MEMBER <?php echo $Company_details->Currency_name; ?> EXPIRY REPORT</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							
								<div class="form-group">
								<label for=""> <span class="required_info">* </span>Company Name </label>
								<select class="form-control " name="Company_id"  required="required">

								 <option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
								</select>
								</div>

								<div class="form-group">
									<label for="exampleInputEmail1"></label>		
									<label class="radio-inline">
										<input type="radio"  name="Expiry_flag" id="Expiry_flag" onclick="toggle(this.value)" value="1" checked ><?php echo $Company_details->Currency_name; ?> Expiry		
										<input type="radio"   name="Expiry_flag" id="Expiry_flag" onclick="toggle(this.value)" value="2" > <?php echo $Company_details->Currency_name; ?> to be Expiry
									</label>
								</div>
								
							</div>
							<div class="col-sm-6">
							  
							<div class="form-group" id="date_block1">
							   <label for=""><span class="required_info">* </span>From Date </label>
								<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1"  data-error="Please select from date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>

							  <div class="form-group" id="date_block2">
							   <label for=""><span class="required_info">* </span>Till Date </label>
								<input class="single-daterange form-control" placeholder="End Date" type="text"  name="end_date" id="datepicker2" data-error="Please select till date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
								<div class="form-group" id="days_block" style="display:none;">
									<label for=""><span class="required_info">* </span>When to be expiry Days  </label>
									<select class="form-control" name="days" id="days" data-error="Please select days">
										<option value="">Select Days</option>
										<option value="30">30 Days</option>
										<option value="60">60 Days</option>
										<option value="90">90 Days</option>
									</select>
									
									<div class="help-block form-text with-errors form-control-feedback" id="days_err"></div>
								</div>
								

							</div>
						</div>
					  <div class="form-buttons-w" align="center">
						<button class="btn btn-primary" type="submit" id="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
					  </div>
				
		<?php echo form_close(); ?>
			</div>
		</div>
	<?php 
	$Expiry_flag = 1;
	
	?>
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>

								<?php if($Expiry_flag==1){ //Details?>
								<tr>
									<th>Expired Date</th>
									<th>Member Name</th>
									<th>Membership ID</th>
									<th>User Email ID</th>
									<th>Current Balance</th>
									<th><?php echo "Expired ".$Company_details->Currency_name; ?></th>

								</tr>
								<?php } else { //Summary?>
								<tr>
									<th>When to Expiry Date</th>
									<th>Member Name</th>
									<th>Membership ID</th>
									<th>User Email ID</th>
									<th>Current Balance</th>
									<th><?php echo $Company_details->Currency_name." to be Expired"; ?></th>
								</tr>
								<?php } ?>
							</thead>						
							<tfoot>
								
								<?php if($Expiry_flag==1){ //Details?>
								<tr>
									<th>Expired Date</th>
									<th>Member Name</th>
									<th>Membership ID</th>
									<th>User Email ID</th>
									<th>Current Balance</th>
									<th><?php echo "Expired ".$Company_details->Currency_name; ?></th>

								</tr>
								<?php } else { //Summary?>
								<tr>
									<th>When to Expiry Date</th>
									<th>Member Name</th>
									<th>Membership ID</th>
									<th>User Email ID</th>
									<th>Current Balance</th>
									<th><?php echo $Company_details->Currency_name." to be Expired"; ?></th>
								</tr>
								<?php } ?>

							</tfoot>
							<tbody>
						<?php
						if(Trans_Records != NULL)
						{ 	
							$start_date = date("Y-m-d",strtotime($_REQUEST["start_date"]));
							$end_date = date("Y-m-d",strtotime($_REQUEST["end_date"]));
							$Expiry_flag =$_REQUEST["Expiry_flag"];
							$days =$_REQUEST["days"];
							$lv_Company_id =$_REQUEST["Company_id"];
		
							if($Expiry_flag==1)//Points Expiry
							{
								echo ' <h6 class="form-header"> Members '.$Company_details->Currency_name.' Expiry details </h6>';
							}
							else
							{
								$days = $_REQUEST["days"];
								echo '<h6 class="form-header"> Members '.$Company_details->Currency_name.' to be Expiry in '.$days.' days </h6>';
							}
					
							if($Trans_Records != NULL)
							{
								$Points_expiry_period=$Company_details->Points_expiry_period;
								$Deduct_points_expiry=$Company_details->Deduct_points_expiry;
								
									
								foreach($Trans_Records as $row)
								{
									$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
									$Membership_ID=$row->Membership_ID;
									$Enrollement_id=$row->Enrollement_id;
									if($Expiry_flag==1)//Points Expiry
									{
										/* $start_date = $_REQUEST["start_date"];
										$end_date = $_REQUEST["end_date"]; */
										echo "<tr>";
										echo "<td>".date("Y-m-d",strtotime($row->Expired_Date))."</td>";
										echo "<td>".$Full_name."</td>";
										echo "<td>".$row->Membership_ID."</td>";
										echo "<td>".$row->User_email_id."</td>";
										echo "<td>".round($row->Total_Balance)."</td>";
										echo "<td>".$row->Expired_points."</td>";
										echo "</tr>";
											
									}
									else
									{
										$days = $_REQUEST["days"];
										$Deduct_balance=round(($row->Total_Balance*$Deduct_points_expiry)/100);
										if($Deduct_balance==0)
										{
											$Deduct_balance=1;
										}
										/******************Calculate Days*********************************************/
										$Transaction_date=date("m-d-Y",strtotime($row->Trans_date));
										$tUnixTime = time();
										list($month, $day, $year) = EXPLODE('-', $Transaction_date);
										$timeStamp = mktime(0, 0, 0, $month, $day, $year);
										$num_days= ceil(abs($timeStamp - $tUnixTime) / 86400);
										////*************************************************************************/
										//echo "<br><br>Membership_ID ".$row->Membership_ID."  Trans_date ".$row->Trans_date." "."  num_days".$num_days." "."  remain ".($Points_expiry_period-$days);
										if($num_days<=$days)
										{
											//$When_to_expiry_date=date("Y-m-d",strtotime($row->Trans_date));
											$When_to_expiry_date=date("Y-m-d",strtotime($row->Trans_date ."+$Points_expiry_period days"));
											echo "<tr>";
											echo "<td>".$When_to_expiry_date."</td>";
											echo "<td>".$Full_name."</td>";
											echo "<td>".$row->Membership_ID."</td>";
											echo "<td>".$row->User_email_id."</td>";
											echo "<td>".round($row->Total_Balance)."</td>";
											echo "<td>".$Deduct_balance."</td>";
											echo "</tr>";
										}
									}
										
								}
							}
						}
						?>
							</tbody>
						</table>
					<?php	if($Trans_Records != NULL)
							{
						?>
							<a href="<?php echo base_url()?>index.php/Reportc/export_Customer_points_expiry/?Company_id=<?php echo $lv_Company_id; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&Expiry_flag=<?php echo $Expiry_flag; ?>&days=<?php echo $days; ?>&Points_expiry_period=<?php echo $Points_expiry_period; ?>&Deduct_points_expiry=<?php echo $Deduct_points_expiry; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/export_Customer_points_expiry/?Company_id=<?php echo $lv_Company_id; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&Expiry_flag=<?php echo $Expiry_flag; ?>&days=<?php echo $days; ?>&Points_expiry_period=<?php echo $Points_expiry_period; ?>&Deduct_points_expiry=<?php echo $Deduct_points_expiry; ?>&pdf_excel_flag=2">
							<button class="btn btn-danger" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button>
							</a>
						<?php 
							} 
							
							?>
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
	if(!document.querySelector("#Register").classList.contains('disabled')){
		show_loader();
	}
});
	
function toggle(flag)
	{
		
		if(flag=="1")
		{
			$("#datepicker1").attr("required","required");
			$("#datepicker2").attr("required","required");
			$("#days").removeAttr("required");
			$("#days").removeClass("form-control has-error"); 
			
			document.getElementById("date_block1").style.display="";
			document.getElementById("date_block2").style.display="";
			document.getElementById("days_block").style.display="none";
		}
		else
		{
			$("#days").attr("required","required");	
			$("#days").addClass("form-control has-error");
			$("#days_err").show();
			
			$("#datepicker1").removeAttr("required");	
			$("#datepicker2").removeAttr("required");	
			
			document.getElementById("date_block1").style.display="none";
			document.getElementById("date_block2").style.display="none";
			document.getElementById("days_block").style.display="";
		}
	
	}

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
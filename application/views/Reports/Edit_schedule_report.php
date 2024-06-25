<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Auto_Process_Reports/Update_schedule_report',$attributes);
					$count_rec= count($Edit_Records);
					$ci_object = &get_instance(); 

					foreach($Edit_Records as $Edit_Records)
						{
							 $Edit_Records->Report_id = $Edit_Records->Report_id;
							 $Edit_Records->Brand_id = $Edit_Records->Brand_id;
							 $Edit_Records->Schedule = $Edit_Records->Schedule;
							 $Edit_Records->Primary_users_id = $Edit_Records->Primary_users_id;
							 $Edit_Records->Primary_user_type = $Edit_Records->Primary_user_type;
							 $Edit_Records->Other_user_type = $Edit_Records->Other_user_type;
							 $Edit_Records->Other_users_id = $Edit_Records->Other_users_id;
							 if($Edit_Records->Other_users_id != 0)
							 {
								$Other_users_id[] = $Edit_Records->Other_users_id;
							 }
							 // $Other_users[$Edit_Records->Other_users_id] = $Edit_Records->First_name.' '.$Edit_Records->Last_name;
							 
						}
						// print_r($Other_users_id);
						$Old_schedule = $Edit_Records->Report_id.'*'.$Edit_Records->Brand_id.'*'.$Edit_Records->Schedule.'*'.$Edit_Records->Primary_user_type;
						// echo $Old_schedule;
						/* foreach($Other_users as $key => $val)
						{
							echo "key :".$key;
							echo "val :".$val;
						} */
				?>
				<div class="element-wrapper">
					<h6 class="element-header">Edit Schedule Report</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							

								<div class="form-group">
								<label for=""> Report </label>
								<select class="form-control " name="report_id" id="report_id" required="required" data-error="Please select Report" >
									<option value="">Select Report</option>
									<option value="1" <?php if($Edit_Records->Report_id ==1){echo 'selected';}?>>Order Report</option>
									<option value="2" <?php if($Edit_Records->Report_id ==2){echo 'selected';}?>>Item Sales Report</option>
									<option value="3" <?php if($Edit_Records->Report_id ==3){echo 'selected';}?>>Loyalty Order Report</option>
									<option value="4" <?php if($Edit_Records->Report_id ==4){echo 'selected';}?>>Points Report</option>

								</select>
								
								</div>
								
								<div class="form-group">
									<label for=""><span class="required_info">* </span>Business/Merchant Name</label>
									<select class="form-control" name="Brand_id" ID="Brand_id" required>
										<option value="">Select Business/Merchant</option>
										<?php
										
										
										//echo $Logged_user_id."-----".$Super_seller;
											if($Logged_user_id > 2 || $Super_seller == 1)
											{
												if($Edit_Records->Brand_id == $enroll)
												{
													echo '<option value="'.$enroll.'" selected>'.$LogginUserName.'</option>';
												}
												else
												{
													echo '<option value="'.$enroll.'">'.$LogginUserName.'</option>';
												}
												
											}							
												foreach($Seller_array as $seller_val)
												{
													if($Edit_Records->Brand_id == $seller_val->Enrollement_id)
													{
														echo "<option value=".$seller_val->Enrollement_id." selected>".$seller_val->First_name." ".$seller_val->Last_name."</option>";
													}
													else
													{
														echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
													}
													
												}
											?> 
								</select>
							</div>
							<br><br>
								<div class="form-group">
									<label for=""><b>Primary Recipient</b></label>
								</div>
							
								
							   	<div class="form-group">
						<label for=""> <span class="required_info">* </span>User Type </label>
						<select class="form-control " name="user_type" id="user_type" required="required" data-error="Please select user type" onchange="get_primary_users(this.value);">
						<option value="">Select User Type</option>
						 <?php
							if($User_types != NULL)
							{
								foreach($User_types as $row1)
								{
									if($row1['User_id']!=1 && $row1['User_id']!=2 && $row1['User_id']!=3)
									{
										if($Edit_Records->Primary_user_type == $row1['User_id'])
										{
										
								?>
								
								<option value="<?php echo $row1['User_id'] ?>" selected><?php echo $row1['User_type'] ?></option>
								
								<?php
										}
										else
										{
											?>
								
											<option value="<?php echo $row1['User_id'] ?>"><?php echo $row1['User_type'] ?></option>
								
								<?php
										}
									}
								}
							}
							?>
							</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>	
							
							   	<div class="form-group">
						<label for=""> <span class="required_info">* </span> User </label>
						<select class="form-control " name="Primary_users" id="Primary_users" required="required" data-error="Please select User">
						<option value="">Select User</option>
								
							</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>	
								
								
								
							</div>
							<div class="col-sm-6">
							  
								 <div class="form-group">
								
									<br>
									  <div class="form-check ml-2" style="float:left;">
										<label class="form-check-label"><input class="form-check-input" name="Schedule"  <?php if($Edit_Records->Schedule == 'Daily'){echo 'checked';}?> type="radio" value="Daily" required="required">Daily</label>
									  </div>
									  
									  
									  <div class="form-check ml-2" style="float:left;">
										<label class="form-check-label"><input class="form-check-input" name="Schedule"  type="radio" value="Weekly" required="required" <?php if($Edit_Records->Schedule == 'Weekly'){echo 'checked';}?>>Weekly</label>
									  </div>
									  
									  
									  <div class="form-check ml-2" style="float:left;">
										<label class="form-check-label"><input class="form-check-input" name="Schedule"  type="radio" value="Monthly"   required="required" <?php if($Edit_Records->Schedule == 'Monthly'){echo 'checked';}?>>Monthly</label>
									  </div>
									  
									  
								  </div>
								

								  <div class="form-group"  style="margin-top:-1%;">
								  <br><br><br><br><br><br><br><br>
									<label for=""><b>Other Recipient</b></label>
								</div>
								
									<div class="form-group">
						<label for=""> <span class="required_info">* </span>User Type </label>
						<select class="form-control " name="user_type2" id="user_type2"  onchange="get_other_users(this.value);" data-error="Please select user type">
						<option value="">Select User Type</option>
						 <?php
							if($User_types != NULL)
							{
								foreach($User_types as $row1)
								{
									if($row1['User_id']!=1 && $row1['User_id']!=2 && $row1['User_id']!=3)
									{
										if($Edit_Records->Other_user_type == $row1['User_id'])
										{
										
								?>
								
								<option value="<?php echo $row1['User_id'] ?>" selected><?php echo $row1['User_type'] ?></option>
								
								<?php
										}
										else
										{
											?>
								
											<option value="<?php echo $row1['User_id'] ?>"><?php echo $row1['User_type'] ?></option>
								
								<?php
										}
									}
								}
							}
							?>
							</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>	
								
								
								  	<div class="form-group">
						<label for=""> <span class="required_info">* </span>User </label>
						<select class="form-control " name="Other_users[]" id="Other_users"  data-error="Please select User" multiple>
								<?php 
								if($Other_users_id != NULL)
								{
									foreach($Other_users_id as  $val)
									{
										$result31 = $ci_object->Igain_model->get_enrollment_details($val);

										echo "<option value='".$val."' selected>".$result31->First_name.' '.$result31->Last_name."</option>";
									}
								}
									
								?>
							</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>	
								
							</div>
							
							

							
							</div>
						</div>
					  <div class="form-buttons-w" align="center">
					  <input type="hidden" name="Old_schedule" value="<?php echo $Old_schedule;?>">
						<button class="btn btn-primary" name="submit" type="submit" id="Register" value="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
					  </div>
				
		<?php echo form_close(); ?>
			</div>
		</div>

				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					<?php echo 'Schedule Report';
					?>
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>

							
							<tr>
							<th class="text-center">Action</th>
							<th>Report Name</th>
							<th>Business/Merchant Name</th>
							<th>Schedule</th>
							<th>Primary User Type</th>
							<th>Primary Recipient</th>
							<th>Other User Type</th>
							<th>Other Recipient</th>
							
							</tr>

							</thead>						
							<tfoot>
								<tr>
								<th class="text-center">Action</th>
							<th>Report Name</th>
							<th>Business/Merchant Name</th>
							<th>Schedule</th>
							<th>Primary User Type</th>
							<th>Primary Recipient</th>
							<th>Other User Type</th>
							<th>Other Recipient</th>
							</tr>
								

							</tfoot>
							<tbody>
						<?php
						// print_r($Edit_Records)
						
						if(count($Trans_Records) > 0)
						{
							foreach($Trans_Records as $row)
							{
								if($row->Report_id==1)
								{
									$Report_name='Order Report';
								}
								elseif($row->Report_id==2)
								{
									$Report_name='Item Sales Report';

								}
								elseif($row->Report_id==3)
								{
									$Report_name='Loyalty Order Report';

								}
								elseif($row->Report_id==4)
								{
									$Report_name='Points Report';

								}
								$result = $ci_object->Igain_model->get_enrollment_details($row->Primary_users_id);
								$result3 = $ci_object->Igain_model->get_enrollment_details($row->Other_users_id);
								$result2 = $ci_object->Auto_process_model->get_user_type($row->Other_user_type);
								// print_r($result);
								echo "<tr>";
								?>
								<td class="row-actions">
									<a href="<?php echo base_url()?>index.php/Auto_Process_Reports/Edit_schedule_report/?Report_id=<?php echo $row->Report_id;?>&Primary_users_id=<?php echo $row->Primary_users_id;?>&Primary_user_type=<?php echo $row->Primary_user_type;?>&Brand_id=<?php echo $row->Brand_id;?>" title="Edit">
										<i class="os-icon os-icon-ui-49"></i>
									</a>
								
									<a href="javascript:void(0);" onclick="delete_me('<?php echo $row->Report_id.'*'.$row->Brand_id.'*'.$row->Primary_user_type.'*'.$row->Schedule.'*'.$row->id;?>','<?php echo $row->Schedule; ?>','','Auto_Process_Reports/delete_schedule/?id');" title="Delete" data-target="#deleteModal" data-toggle="modal">
										<i class="os-icon os-icon-ui-15"></i>
									</a>
								
								</td>
												<?php
								echo "<td>".$Report_name."</td>";
								echo "<td>".$row->First_name.' '.$row->Last_name."</td>";
								echo "<td>".$row->Schedule."</td>";
								echo "<td>".$row->User_type."</td>";
								echo "<td>".$result->First_name.' '.$result->Last_name."</td>";
								echo "<td>".$result2->User_type."</td>";
								echo "<td>".$result3->First_name.' '.$result3->Last_name."</td>";
								
								echo "</tr>";
								
							}
						}
						?>
							</tbody>
						</table>
						<?php 
						if($Trans_Records != NULL)
						{ 
						/*
						?>
							<a href="<?php echo base_url()?>index.php/Reportc/Loyalty_Order_Transactions_Report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&Outlet_id=<?php echo $Outlet_id; ?>&report_id=<?php echo $report_id; ?>&Brand_id=<?php echo $Brand_id; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/Loyalty_Order_Transactions_Report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&Outlet_id=<?php echo $Outlet_id; ?>&report_id=<?php echo $report_id; ?>&Brand_id=<?php echo $Brand_id; ?>&pdf_excel_flag=2">
							<button class="btn btn-danger" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button>
							</a>
					<?php 
					*/
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
	 if($('#report_id').val() != ""  && $('#Brand_id').val() != "" && $('#user_type').val() != "" && $('#Primary_users').val() != ""  && $('#Schedule').val() != "" )
		{
			show_loader();
		} 

});

get_primary_users('<?php echo $Edit_Records->Primary_user_type;?>');
// get_other_users('<?php echo $Edit_Records->Other_user_type;?>');
	// $('#user_type').change(function()
	function get_primary_users(user_type)
	{
		// var user_type = $("#user_type").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{user_type:user_type,Company_id:Company_id,flag:'1'},
			url:'<?php echo base_url()?>index.php/Auto_Process_Reports/get_users_by_usertype',
			success:function(opData4){
			
				$('#Primary_users').html(opData4);
				$("select#Primary_users").val('<?php echo $Edit_Records->Primary_users_id; ?>'); 
			}
		});
	}	
	// });
	// $('#user_type2').change(function()
		function get_other_users(user_type)	{
		// var user_type = $("#user_type2").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		$.ajax({
			type:"POST",
			data:{user_type:user_type,Company_id:Company_id,flag:'2'},
			url:'<?php echo base_url()?>index.php/Auto_Process_Reports/get_users_by_usertype',
			success:function(opData4){
			
				$('#Other_users').html(opData4);

			}
		});
		}
		// });
			
	

</script>

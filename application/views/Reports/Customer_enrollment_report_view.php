<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Customer_enrollment_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">MEMBER ENROLLMENT REPORT</h6>  
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
								<label for=""> <span class="required_info">* </span>Source </label>
								<select class="form-control " name="Source" id="Source" required="required" data-error="Please select Business/Merchant name">
								<option value="0">All</option>
								<option value="APK">APP</option>
								<option value="Website">Website</option>
								</select>
								
								<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							  
							</div>
							<div class="col-sm-6">
							  
							<div class="form-group">
							   <label for=""><span class="required_info">* </span>From Date</label>
								<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1"  required="required" data-error="Please select from date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>

							  <div class="form-group">
							   <label for=""><span class="required_info">* </span>Till Date </label>
								<input class="single-daterange form-control" placeholder="End Date" type="text"  name="end_date" id="datepicker2" required="required" data-error="Please select till date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
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
		
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					  Member Enrollement Details
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>

								<tr>
									<th>Membership ID</th>
									<th>Member Name</th>
									<th>Joined Date</th>
									<th>Total Purchase Amount <?php echo "($Symbol_currency)"; ?></th>
									<th>Total Gained  <?php echo $Company_details->Currency_name; ?></th>
									<th>Total Redeemed  <?php echo $Company_details->Currency_name; ?></th>
									<th>Current Balance</th>
									<th>Gift Card Purchase Amount <?php echo "($Symbol_currency)"; ?></th>
									<th>Gift Card Redeemed Amount <?php echo "($Symbol_currency)"; ?></th>
									<th>Source</th>
								</tr>
							</thead>						
							<tfoot>
								
								<tr>
									<th>Membership ID</th>
									<th>Member Name</th>
									<th>Joined Date</th>
									<th>Total Purchase Amount <?php echo "($Symbol_currency)"; ?></th>
									<th>Total Gained  <?php echo $Company_details->Currency_name; ?></th>
									<th>Total Redeemed  <?php echo $Company_details->Currency_name; ?></th>
									<th>Current Balance</th>
									<th>Gift Card Purchase Amount <?php echo "($Symbol_currency)"; ?></th>
									<th>Gift Card Redeemed Amount <?php echo "($Symbol_currency)"; ?></th>
									<th>Source</th>		   
								</tr>

							</tfoot>
							<tbody>
					<?php
				
					if(isset($_REQUEST["submit"]) && ($Trans_Records != NULL))
					{ 
					
						$To_date=date("Y-m-d",strtotime($_REQUEST["end_date"]));
						$From_date=date("Y-m-d",strtotime($_REQUEST["start_date"]));
						$report_type=$_REQUEST["report_type"];
						$Source=$_REQUEST["Source"];
			
				
						
							if($Trans_Records != NULL)
							{
								
								$ci_object = &get_instance(); 

								foreach($Trans_Records as $row)
								{
									$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
									$Membership_ID=$row->Membership_ID;
									$Enrollement_id=$row->Enrollement_id;
									$Show_member=0;
									
									
									$Active="<font color='green'>Yes</font>";
									if($row->User_activated=="No")
									{
										$Active="<font color='red'>No</font>";
									}
									$start_date = $_REQUEST["start_date"];
									$end_date = $_REQUEST["end_date"];
									
								
									$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
									$Total_current_balance=round($row->Total_current_balance);
										
											
									?>
												<tr>
												<td><?php echo $row->Membership_ID;?></td>
												<td><?php echo $Full_name;?></td>
													<td><?php echo date('Y-m-d',strtotime($row->joined_date));?></td>
													
													<td><?php echo $row->Total_Purchase_Amount;?></td>
													<td><?php echo $row->Total_Gained_Points;?></td>
													
													<td><?php echo $row->Total_Redeemed_Points;?></td>
												<td><?php echo $Total_current_balance; ?> </td>
												<td><?php echo $row->Gift_card_purchase_amt;?></td>
												<td><?php echo $row->Gift_card_redeem_amt;?></td>

												<td><?php echo $row->Source; ?> </td>

												</tr>
								<?php		
								}
										
								
							}
					}
				?>
							</tbody>
						</table>
				<?php if($Trans_Records != NULL)
						{
					?>
							<a href="<?php echo base_url()?>index.php/Reportc/export_customer_enrollment_report/?Company_id=<?php echo $Company_id; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&Source=<?php echo $Source; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/export_customer_enrollment_report/?Company_id=<?php echo $Company_id; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&Source=<?php echo $Source; ?>&pdf_excel_flag=2">
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

	 if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "" && $('#Source').val() != "")
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
<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Saas_invoice_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Saas Invoice Report</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							
								<div class="form-group">
								<div class="form-group">
							   <label for=""><span class="required_info">* </span>From Date <span class="required_info">(* click inside textbox)</span></label>
								<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1" data-error="Please select from date"/>
							  </div>
							  <div class="form-group">
								<label for=""><span class="required_info">* </span>Country</label>
								<select class="form-control" name="Country" ID="Country" required>
									<option value="0">All</option>
									<option value="India">India</option>
									<option value="1">Outside India</option>
								
								</select>
								</div>
								<div class="form-group">
								<label for=""><span class="required_info">* </span>Payment Status</label>
								<select class="form-control" name="PaymentStatus" ID="PaymentStatus" required>
									<option value="0">All</option>
									<option value="captured">Success</option>
									<option value="failed">Failed</option>
									<option value="1">Not Initiated</option>
								
								</select>
							  </div>
							  
							  <div class="form-group">
								<label for=""><span class="required_info">* </span>Report Type</label>
								<select class="form-control" name="ReportType" ID="ReportType" required>
									<option value="0">Detail</option>
									<option value="1">Summary</option>
								
								</select>
							  </div>
							  
							  
							  </div>
							 
					  
								
								
							</div>
							<div class="col-sm-6">
								 <div class="form-group">
							   <label for=""><span class="required_info">* </span>Till Date <span class="required_info">(* click inside textbox)</span></label>
								<input class="single-daterange form-control" placeholder="End Date" type="text"  name="end_date" id="datepicker2" data-error="Please select till date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
									<div class="form-group">
								<label for=""> <span class="required_info">* </span>Company Name </label>
								<select class="form-control " name="Saas_Company_id"  required="required">
								<option value="0">All</option>
								<?php
									foreach($Company_details as $Company_details)
									{
										if($Company_details["Company_id"]==1){continue;}
										echo '<option value="'.$Company_details["Company_id"].'">'.$Company_details["Company_name"].'</option>';
									}
								
								?>
								 
								</select>
								</div>	
								
								<div class="form-group">
								<label for=""><span class="required_info">* </span>License Type</label>
								<select class="form-control" name="LicenseType" ID="LicenseType" required>
									<option value="0">All</option>
									<option value="121">Basic</option>
									<option value="253">Standard</option>
									<option value="120">Enhance</option>
								
								</select>
							  </div>
								
								<div class="form-group">
								<label for=""><span class="required_info">* </span>Payment Type</label>
								<select class="form-control" name="Payment_type" ID="Payment_type" required>
									<option value="2">All</option>
									<option value="0">Company License</option>
									<option value="1">Gifting Partner</option>
								
								</select>
							  </div>
								
							</div>
							<!--
							<div class="form-group">
								
								<label class="radio-inline">&nbsp;&nbsp;
									<input type="radio"  name="select_cust" id="select_cust" onclick="toggel_cust(this.value)" value="1" checked >&nbsp;Earned	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio"   name="select_cust" id="select_cust" onclick="toggel_cust(this.value)" value="2" >&nbsp;Redeemed
								</label>
							</div>-->
						</div>
					  <div class="form-buttons-w" align="center">
						<button class="btn btn-primary" name="submit" type="submit" id="Register" value="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
					  </div>
				
		<?php echo form_close(); ?>
			</div>
		</div>
		<style>
.required_info
{
	text-color:red !important;
	font-color:red !important;
	color:red !important;
}
</style>
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					 <h6 class="form-header"><?php $ReportType = $_REQUEST["ReportType"]; if($ReportType==0){echo 'Saas Invoice Report Details';}else {echo 'Saas Invoice Report Summary';}?></h6>
					
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
							<?php
								
								if($ReportType==0)//Details
								{
							?>
							<tr>
							<th>Payment Date</th>
							<th>Company</th>
							<th>Currency</th>
							<th>License Type</th>
							<th>Period</th>
							<th>Invoice No.</th>
							<th>Total Invoice Amount</th>
							<th>Paid Amount</th>
							<th>Payment Status</th>
							<th>Payment Reference ID</th>
							</tr>
								<?php }else{ ?>
								<tr>
									<th>Company</th>
									<th>Currency</th>
									<th>License Type</th>
									<th>Total Invoice</th>
									<th>Total CGST</th>
									<th>Total SGST</th>
									<th>Total IGST</th>
									<th>Total Invoice Amount</th>
									<th>Total Paid Amount</th>
									<th>Payment Status</th>
								</tr>
								<?php } ?>
								</thead>
								<tfoot>
								
								<?php
								if($ReportType==0)//Details
								{
							?>
									<tr>
									<th>Payment Date</th>
									<th>Company</th>
									<th>Currency</th>
									<th>License Type</th>
									<th>Period</th>
									<th>Invoice No.</th>
									<th>Total Invoice Amount</th>
									<th>Paid Amount</th>
									<th>Payment Status</th>
									<th>Payment Reference ID</th>
									</tr>
								<?php }else{ ?>
								<tr>
									<th>Company</th>
									<th>Currency</th>
									<th>License Type</th>
									<th>Total Invoice</th>
									<th>Total CGST</th>
									<th>Total SGST</th>
									<th>Total IGST</th>
									<th>Total Invoice Amount</th>
									<th>Total Paid Amount</th>
									<th>Payment Status</th>
								</tr>
								<?php } ?>
							
								</tfoot>
							<tbody>
						<?php
						$todays = date("Y-m-d");
						$start_date = date('Y-m-d',strtotime($_REQUEST["start_date"]));
						$end_date = date('Y-m-d',strtotime($_REQUEST["end_date"]));
						$Country = $_REQUEST["Country"];
						$PaymentStatus = $_REQUEST["PaymentStatus"];
						$ReportType = $_REQUEST["ReportType"];
						$Saas_Company_id = $_REQUEST["Saas_Company_id"];
						$LicenseType = $_REQUEST["LicenseType"];
						 $Payment_type = $_REQUEST["Payment_type"];
						 
						if($Trans_Records != NULL)
						{
							// if($seller_id=='0'){$Brand_name='All';}
							foreach($Trans_Records as $row)
							{
								if($row->License_type==121)//Basic
								{
									$row->License_type='Basic';
								}
								if($row->License_type==253)//Standard
								{
									$row->License_type='Standard';
								}
								
								if($row->License_type==120)//Enhance
								{
									$row->License_type='Enhance';
								}
								
								if($row->Currency=='India'){$row->Currency='INR';}else{$row->Currency='USD';}
								if($row->Payment_type=='0'){$row->Payment_type='Company License';}else{$row->Payment_type='Gifting Partner';}
								
								if($row->Email_sent==1){$row->Email_sent='Yes';}else{$row->Email_sent='No';}
								if($row->Payment_Reference_Id==''){$row->Payment_Reference_Id='-';}
								
								$row->Payment_status=$row->Payment_status;
								if($row->Payment_status==NULL){$row->Payment_status='Not Initiated';}
							
								if($row->Period=='30'){$row->Period='Monthly';}
								if($row->Period=='90'){$row->Period='Quaterly';}
								if($row->Period=='180'){$row->Period='Bi-Anually';}
								if($row->Period=='365'){$row->Period='Anually';}
								
								$Company_details = $this->Igain_model->get_company_details($row->Company_name);
								$row->Company_name=$Company_details->Company_name;
								if($ReportType==0)//Details
								{
									echo "<tr>";
									echo "<td>".$row->Bill_date."</td>";
									echo "<td>".$row->Company_name."</td>";
									echo "<td>".$row->Currency."</td>";
									echo "<td>".$row->License_type."</td>";
									echo "<td>".$row->Period."</td>";
									echo "<td>".$row->Bill_no."</td>";
									echo "<td>".$row->Total_invoice_amount."</td>";
									echo "<td>".$row->Paid_Amount."</td>";
									echo "<td>".$row->Payment_status."</td>";
									
									echo "<td>".$row->Payment_Reference_Id."</td>";
									// echo "<td>".$Email_sent."</td>";
									// echo "<td>".number_format(round($row->Earned_amt),2)."</td>";
									echo "</tr>";
								}
								else
								{
									echo "<tr>";
									echo "<td>".$row->Company_name."</td>";
									echo "<td>".$row->Currency."</td>";
									echo "<td>".$row->License_type."</td>";
									echo "<td>".$row->Total_invoice."</td>";
									echo "<td>".$row->Total_CGST."</td>";
									echo "<td>".$row->Total_SGST."</td>";
									echo "<td>".$row->Total_IGST."</td>";
									echo "<td>".$row->TotalInvoiceAmount."</td>";
									echo "<td>".$row->TotalPaidAmount."</td>";
									echo "<td>".$row->Payment_status."</td>";
									
									// echo "<td>".$Email_sent."</td>";
									echo "</tr>";
								}
									
							}
						}
						?>
						
							</tbody>
						</table>
				<?php 
						if($Trans_Records != NULL)
						{ 
						$start_date = date('Y-m-d',strtotime($_REQUEST["start_date"]));
						$end_date = date('Y-m-d',strtotime($_REQUEST["end_date"]));
						$Country = $_REQUEST["Country"];
						$PaymentStatus = $_REQUEST["PaymentStatus"];
						$ReportType = $_REQUEST["ReportType"];
						$Saas_Company_id = $_REQUEST["Saas_Company_id"];
						$LicenseType = $_REQUEST["LicenseType"];
						?>
							<a href="<?php echo base_url()?>index.php/Reportc/Saas_invoice_report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&Country=<?php echo $Country; ?>&PaymentStatus=<?php echo $PaymentStatus; ?>&ReportType=<?php echo $ReportType; ?>&Saas_Company_id=<?php echo $Saas_Company_id; ?>&LicenseType=<?php echo $LicenseType; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/Saas_invoice_report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&Country=<?php echo $Country; ?>&PaymentStatus=<?php echo $PaymentStatus; ?>&ReportType=<?php echo $ReportType; ?>&Saas_Company_id=<?php echo $Saas_Company_id; ?>&LicenseType=<?php echo $LicenseType; ?>&pdf_excel_flag=2">
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
	 if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "" && $('#seller_id').val() != "" )
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

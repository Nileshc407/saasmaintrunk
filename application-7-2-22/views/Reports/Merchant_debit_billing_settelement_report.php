<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Merchant_debit_billing_Settlement_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Merchant Debit Billing & Settlement Report</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							  <div class="form-group">
								<label for=""><span class="required_info">* </span>Company Name</label>
								<select class="form-control" name="Company_id" id="Company_id" data-error="Please select company" required="required">
									<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
							  <div class="form-group">
								<label for=""><span class="required_info">* </span>Merchant Name</label>
								<select class="form-control" name="seller_id" id="seller_id" data-error="Please select merchant name" required="required">
								<?php if(($userId == 2 && $Super_seller==1) ){ ?>
									<option value="">Select merchant</option>
									<option value="0">All merchant</option>
								<?php } 
									foreach($company_sellers as $sellers)
									{ ?>
										<option value="<?php echo $sellers['Enrollement_id'] ?>"><?php echo $sellers['First_name']." ".$sellers['Last_name']; ?></option><?php
									} ?>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
							  <div class="form-group">
								<label for=""><span class="required_info">* </span>Settlement Status</label>
								<select class="form-control" name="Billing_status" id="Billing_status" data-error="Please select settlement status" required="required">
									<option value="2">All</option>
									<option value="1">Setteled</option>
									<option value="0">Pending</option>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							</div>
							<div class="col-sm-6">
							   <div class="form-group">
							    <label for=""><span class="required_info">* </span>From Date <span class="required_info">(* click inside textbox)</span></label>
								<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1" data-error="Please select from date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
							  <div class="form-group">
							   <label for=""><span class="required_info">* </span>Till Date <span class="required_info">(* click inside textbox)</span></label>
								<input class="single-daterange form-control" placeholder="End Date" type="text"  name="end_date" id="datepicker2" data-error="Please select till date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
							  <div class="form-group">
								<label for=""><span class="required_info">* </span>Type of Report</label>
								<select class="form-control" name="report_type" id="report_type" data-error="Please select report type" required="required">
								<option value="">Select report type</option>
								<option value="0">Detail report</option>
								<option value="1">Summary report</option>
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
				<div class="element-box">				
					<div class="element-wrapper">	
					  <h6 class="form-header">
					  Merchant Debit Billing & Settlement Report<?php if($Report_type == 0) { echo " Details"; } else { echo " Summary";} ?>
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
				<?php 	if($Report_type==0)
						{ ?>
							<thead>
								<tr>
									<th>Creation Date/Settlement Date</th>
									<th>Merchant Name</th>
									<th>Invoice No.</th>
									<th><?php echo $Company_details->Currency_name; ?> Debited</th>
									<th>Cancellation Amt (<?php echo $Symbol_of_currency ?>)</th>
									<th>Invoice Amt (<?php echo $Symbol_of_currency ?>)</th>
									<th>Settlement Amt (<?php echo $Symbol_of_currency ?>)</th>
									<th>Paid Amt (<?php echo $Symbol_of_currency ?>)</th>
									<th>Status</th>
									<!--<th>Payment Type</th>
									<th>Bank Name</th>
									<th>Branch Name</th>
									<th>Credit/Cheque No.</th>-->
									
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<th>Creation Date/Settlement Date</th>
									<th>Merchant Name</th>
									<th>Invoice No.</th>
									<th><?php echo $Company_details->Currency_name; ?> Debited</th>
									<th>Cancellation Amt (<?php echo $Symbol_of_currency ?>)</th>
									<th>Invoice Amt (<?php echo $Symbol_of_currency ?>)</th>
									<th>Settlement Amt (<?php echo $Symbol_of_currency ?>)</th>
									<th>Paid Amt (<?php echo $Symbol_of_currency ?>)</th>
									<th>Status</th>
									<!--<th>Payment Type</th>
									<th>Bank Name</th>
									<th>Branch Name</th>
									<th>Credit/Cheque No.</th>-->
								</tr>
							</tfoot>
				<?php 	}
						else if($Report_type==1)
						{ ?>
							<thead>
								<tr>
									<th>Creation Date</th>
									<th>Merchant Name</th>
									<th>Invoice No.</th>
									<th><?php echo $Company_details->Currency_name; ?> Debited</th>
									<th>Cancellation Amt (<?php echo $Symbol_of_currency ?>)</th>
									<th>Invoice Amt (<?php echo $Symbol_of_currency ?>)</th>
									<th>Settlement Amt (<?php echo $Symbol_of_currency ?>)</th>
									<th>Status</th>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<th>Creation Date</th>
									<th>Merchant Name</th>
									<th>Invoice No.</th>
									<th><?php echo $Company_details->Currency_name; ?> Debited</th>
									<th>Cancellation Amt (<?php echo $Symbol_of_currency ?>)</th>
									<th>Invoice Amt (<?php echo $Symbol_of_currency ?>)</th>
									<th>Settlement Amt (<?php echo $Symbol_of_currency ?>)</th>
									<th>Status</th>
								</tr>
							</tfoot>
				<?php	} ?>
							<tbody>
						<?php
							if($Seller_billing_details!=NULL)
							{
								$lv_Merchant_id=0;
								foreach($Seller_billing_details as $row)
								{ 	
									$Merchant_id=$row->Seller_id;
									$sellerName=$row->Merchant_name;
									if($lv_Merchant_id != $Merchant_id) //&& $report_type!=2
									{ 
										// echo "<tr style='background:#dff0d8;'><td colspan='16' style='color:blue;'>".$sellerName." - Invoice No. - ".$row->Bill_no." </td></tr>";
									} 
									
									if($Report_type==0)
									{
										if($row->Bill_Creation_date!=NULL)
										{
											$TransDate=$row->Bill_Creation_date;
										}
										else if($row->Settlement_date!=NULL)
										{
											$TransDate=$row->Settlement_date;
										}
								?>				
									<tr>						
										<td><?php echo $TransDate;?></td>			
										<td><?php echo $row->Merchant_name; ?></td>
										<td><?php echo $row->Bill_no; ?></td>
										<td><?php echo $row->Point_debited; ?></td>
										<td><?php echo $row->Cancellation_amount; ?></td>
										<td><?php echo $row->Bill_amount; ?></td>
										<td><?php echo $row->Settlement_amount; ?></td>
										<td><?php echo $row->Paid_amount; ?></td>
										<td <?php if($row->Settlement_flag=='Settled') { ?> style="color:green;"<?php } else if($row->Settlement_flag=='Pending') { ?> style="color:red;" <?php } ?>><?php echo $row->Settlement_flag; ?></td>
										<?php /*<td><?php echo $row->Pay_type; ?></td>
										<td><?php echo $row->Bank_name; ?></td>
										<td><?php echo $row->Branch_name; ?></td>
										<td><?php echo $row->Credit_Cheque_number; ?> */?>
									</tr>
						<?php
									}
									else if($Report_type==1)
									{   ?>
									<tr>	
										<td><?php echo $row->Bill_Creation_date;?></td>			
										<td><?php echo $row->Merchant_name; ?></td>
										<td><?php echo $row->Bill_no; ?></td>
										<td><?php echo $row->Point_debited; ?></td>
										<td><?php echo $row->Cancellation_amount; ?></td>
										<td><?php echo $row->Bill_amount; ?></td>
										<td><?php echo $row->Settlement_amount; ?></td>
										<td <?php if($row->Settlement_flag=='Settled') { ?> style="color:green;"<?php } else if($row->Settlement_flag=='Pending') { ?> style="color:red;" <?php } ?>><?php echo $row->Settlement_flag; ?></td>
									</tr>
							<?php	}
								}
								  $lv_Merchant_id=$Merchant_id;
							}	?>
							</tbody>
						</table>
						<?php if($Seller_billing_details != NULL){ ?>
						
							<a href="<?php echo base_url(); ?>index.php/Reportc/Export_merchant_debit_billing_report/?Report_type=<?php echo $Report_type;?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date;?>&seller_id=<?php echo $seller_id; ?>&Billing_status=<?php echo $Billing_status;?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
							
							<a href="<?php echo base_url(); ?>index.php/Reportc/Export_merchant_debit_billing_report/?Report_type=<?php echo $Report_type;?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date;?>&seller_id=<?php echo $seller_id; ?>&Billing_status=<?php echo $Billing_status; ?>&pdf_excel_flag=2">
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
<?php $this->load->view('header/footer'); ?>

<script>
$('#Register').click(function()
{
	if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "")
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
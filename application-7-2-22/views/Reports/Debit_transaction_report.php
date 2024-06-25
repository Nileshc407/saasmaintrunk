<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Debit_transaction_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Debit Transaction Report</h6>  
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
								<label for=""><span class="required_info">* </span>Type of Report</label>
								<select class="form-control" name="report_type" id="report_type" data-error="Please select report type" required="required">
								<option value="">Select report type</option>
								<option value="0">Detail report</option>
								<option value="1">Summary report</option>
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
					  Debit Transaction Report<?php if($Report_type == 0) { echo " Details"; } else { echo " Summary";} ?>
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
				<?php 	if($Report_type==0)
						{ ?>
							<thead>
								<tr>
									<th>Trans Date</th>
									<th>Merchant Name</th>
									<th>Member Name</th>
									<th>Membership ID</th>
									<th>Bill No.</th>
									<th>Cancellation Amount (<?php echo $Symbol_of_currency ?>)</th>	
									<th>Debited <?php echo $Company_details->Currency_name; ?> </th>
									<th>Credited Redeem <?php echo $Company_details->Currency_name; ?> </th>
									<th>Remarks</th>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<th>Trans Date</th>
									<th>Merchant Name</th>
									<th>Member Name</th>
									<th>Membership ID</th>
									<th>Bill No.</th>
									<th>Cancellation Amount (<?php echo $Symbol_of_currency ?>)</th>	
									<th>Debited <?php echo $Company_details->Currency_name; ?> </th>
									<th>Credited Redeem <?php echo $Company_details->Currency_name; ?> </th>
									<th>Remarks</th>
								</tr>
							</tfoot>
				<?php 	}
						else if($Report_type==1)
						{ ?>
							<thead>
								<tr>
									<th>Merchant Name</th>
									<th>Cancellation Amount (<?php echo $Symbol_of_currency ?>)</th>	
									<th>Debited <?php echo $Company_details->Currency_name; ?> </th>
									<th>Credited Redeem <?php echo $Company_details->Currency_name; ?> </th>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<th>Merchant Name</th>
									<th>Cancellation Amount (<?php echo $Symbol_of_currency ?>)</th>	
									<th>Debited <?php echo $Company_details->Currency_name; ?> </th>
									<th>Credited Redeem <?php echo $Company_details->Currency_name; ?> </th>
								</tr>
							</tfoot>
					
				<?php	} ?> 
							<tbody>
						<?php 
							$lv_Merchant_id=0;
							if($Debit_trans_details != NULL)
							{	
								foreach($Debit_trans_details as $row)
								{	
									$Merchant_id=$row->Seller_id;
									$sellerName=$row->Merchant_name;
									if($lv_Merchant_id != $Merchant_id && $Report_type==1)
									{
										//echo "<tr style='background:#dff0d8;'><td colspan='4' style='color:blue;'>".$sellerName."</td></tr>";
									}
									if($Report_type==0)
									{									
									?> 
									<tr>
										<td><?php echo $row->Trans_date;?></td>			
										<td><?php echo $row->Merchant_name; ?></td>
										<td><?php echo $row->Member_name; ?></td>
										<td><?php echo $row->Membership_Id; ?></td>
										<td><?php echo $row->Bill_no; ?></td>
										<td><?php echo $row->Cancellation_amount; ?></td>
										<td><?php echo $row->Debited_points; ?></td>
										<td><?php echo $row->Credited_redeem_points; ?></td>
										<td><?php echo $row->Remarks; ?></td>
									</tr>
								<?php 
									}
									else if($Report_type==1)
									{ 
								?>
									<tr>
										<td><?php echo $row->Merchant_name;?></td>			
										<td><?php echo $row->Total_cancellation_amount; ?></td>
										<td><?php echo $row->Total_debited_points; ?></td>
										<td><?php echo $row->Total_credited_points; ?></td>
									</tr>
							<?php   }				    
								} 
								 $lv_Merchant_id=$Merchant_id; 
							} ?> 
							</tbody>
						</table>
						<?php if($Debit_trans_details != NULL){ ?>
						
							<a href="<?php echo base_url(); ?>index.php/Reportc/Export_debit_transaction_report/?Report_type=<?php echo $Report_type;?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date;?>&seller_id=<?php echo $seller_id; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
							
							<a href="<?php echo base_url(); ?>index.php/Reportc/Export_debit_transaction_report/?Report_type=<?php echo $Report_type;?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date;?>&seller_id=<?php echo $seller_id; ?>&pdf_excel_flag=2">
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
function receipt_details(Bill_no,Seller_id,Trans_id,Transaction_type)
{
	$.ajax({
		type: "POST",
		data: {Bill_no: Bill_no, Seller_id:Seller_id,Trans_id:Trans_id,Transaction_type:Transaction_type},
		url: "<?php echo base_url()?>index.php/Coal_Transactionc/transaction_receipt",
		success: function(data)
		{
			$("#show_transaction_receipt").html(data.transactionReceiptHtml);	
			$('#receipt_myModal').modal('show');
		}
	});
}
</script>
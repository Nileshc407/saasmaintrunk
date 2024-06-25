<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Publisher_billing_Settlement_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">PUBLISHER SETTLEMENT REPORT</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">									
								<div class="form-group">
									<label for=""><span class="required_info">* </span>From Date <span class="required_info">(* click inside textbox)</span></label>
									<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1" data-error="Please select from date" />
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>							   
								<div class="form-group">
									<label for=""><span class="required_info">* </span>Publishers Name</label>
									<select class="form-control" name="seller_id" id="seller_id" data-error="Please select publisher" required="required">									
									<option value="0">All Publishers</option>
									<?php	
									if($loyalty_publishers!=NULL)
									{
										foreach($loyalty_publishers as $publishers)
										{	
										?>
											<option value="<?php echo $publishers['Publishers_id']; ?>"><?php echo $publishers['Publishers_name']; ?></option>
										<?php 									
										} 
									}
									?>
									</select>
									<div class="help-block form-text with-errors form-control-feedback" id="PublishersID"></div>
								</div>								
							</div>
							<div class="col-sm-6">
								<div class="form-group">
								   <label for=""><span class="required_info">* </span>Till Date <span class="required_info">(* click inside textbox)</span></label>
									<input class="single-daterange form-control" placeholder="End Date" type="text"  name="end_date" id="datepicker2" data-error="Please select till date"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>							  
								<div class="form-group">
									<label for=""><span class="required_info">* </span>Report Type</label>
									<select class="form-control" name="report_type" id="report_type" data-error="Please select report type" required="required">
										<option value="0">Detail Report</option>
										<option value="1">Summary Report</option>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								<div class="form-group">
									<label for="exampleInputEmail1"><span class="required_info">*</span> Status</label>
									<select class="form-control" name="Billing_status" id="Billing_status" data-error="Please select status" required="required">
										<option value="2">All</option>
										<option value="1">Settled</option>
										<option value="0">Pendding</option>
									</select>	
									<div class="help-block form-text with-errors form-control-feedback" id="Status"></div>
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
				
				
				<?php 	
				
					if($Publisher_billing_details != "") { ?>	
				
				
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					  <?php echo $Company_details->Currency_name; ?> Usage Report<?php if($Report_type == 0) { echo " Details"; } else { echo " Summary";} ?>
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<?php if($Report_type == 0) { ?>
									
										<th>Settled Date</th>
										<th>Name</th>
										<th>Invoice No.</th>
										<th>Purchased Miles </th>
										<th>Purchased Amount (<?php echo $Symbol_of_currency ?>)</th>										
										<th>Invoice Amount (<?php echo $Symbol_of_currency ?>)</th>
										<th>Settled Amount (<?php echo $Symbol_of_currency ?>)</th>
										<th>Paid Amount (<?php echo $Symbol_of_currency ?>)</th>
										<th>Settled Status</th>
										<th>Payment Type</th>
										<!--<th>Bank Name</th>
										<th>Branch Name</th>
										<th>Credit/Cheque No.</th> -->
					
					
										
									<?php 	
									} else if($Report_type==1) { ?>
									
										<th>Settled Date</th>
										<th>Name</th>
										<th>Invoice No.</th>
										<th>Purchased Miles </th>
										<th>Purchased Amount (<?php echo $Symbol_of_currency ?>)</th>
										
										<th>Invoice Amount (<?php echo $Symbol_of_currency ?>)</th>
										<th>Settled Amount (<?php echo $Symbol_of_currency ?>)</th>
										<th>Settled Status</th>
									
								<?php } ?>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<?php if($Report_type == 0) { ?>	
									
										<th>Settled Date</th>
										<th>Publisher Name</th>
										<th>Invoice No.</th>
										<th>Purchased Miles </th>
										<th>Purchased Amount (<?php echo $Symbol_of_currency ?>)</th>										
										<th>Invoice Amount (<?php echo $Symbol_of_currency ?>)</th>
										<th>Settled Amount (<?php echo $Symbol_of_currency ?>)</th>
										<th>Paid Amount (<?php echo $Symbol_of_currency ?>)</th>
										<th>Settled Status</th>
										<th>Payment Type</th>
										<!--<th>Bank Name</th>
										<th>Branch Name</th>
										<th>Credit/Cheque No.</th> -->
					
					
										
									<?php 	
									} else if($Report_type==1) { ?>
									
										<th>Creation Date</th>
										<th>Publisher Name</th>
										<th>Invoice No.</th>
										<th>Purchased Miles </th>
										<th>Purchased Amount (<?php echo $Symbol_of_currency ?>)</th>										
										<th>Invoice Amount (<?php echo $Symbol_of_currency ?>)</th>
										<th>Settled Amount (<?php echo $Symbol_of_currency ?>)</th>
										<th>Settled Status</th>
									
								<?php } ?>
								</tr>
							</tfoot>
							<tbody>
							<?php
							
								$lv_Merchant_id=0;
								foreach($Publisher_billing_details as $row)
								{	
									
									$Merchant_id=$row->Seller_id;
									$sellerName=$row->Publisher_name;
									if($lv_Merchant_id != $Merchant_id) //&& $report_type!=2
									{
										// echo "<tr class='success'><td colspan='16' style='color:blue;'>".$sellerName." - Invoice No. - ".$row->Bill_no." </td></tr>";
										
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
										<td><?php echo $row->Publisher_name; ?></td>
										<td><?php echo $row->Bill_no; ?></td>
										<td><?php echo $row->Purchased_miles; ?></td>
										
										<td><?php echo $row->Bill_purchased_amount; ?></td>
										
										<td><?php echo $row->Bill_amount; ?></td>
										<td><?php echo $row->Settlement_amount; ?></td>
										<td><?php echo $row->Paid_amount; ?></td>
										<td><?php echo $row->Settlement_flag; ?></td>
										<td><?php echo $row->Pay_type; ?></td>
										<!--<td><?php echo $row->Bank_name; ?></td>
										<td><?php echo $row->Branch_name; ?></td>
										<td><?php echo $row->Credit_Cheque_number; ?></td> -->
									</tr>
						<?php
									}
									else if($Report_type==1)
									{   ?>
										<tr>	
										<td><?php echo $row->Bill_Creation_date;?></td>			
										<td><?php echo $row->Publisher_name; ?></td>
										<td><?php echo $row->Bill_no; ?></td>
										<td><?php echo $row->Purchased_miles; ?></td>
										<td><?php echo $row->Bill_purchased_amount; ?></td>
										
										<td><?php echo $row->Bill_amount; ?></td>
										<td><?php echo $row->Settlement_amount; ?></td>
										<td><?php echo $row->Settlement_flag; ?></td>
									</tr>
							<?php	}
									
								}
								 $lv_Merchant_id=$Merchant_id;
								
								
									?>
							</tbody>
						</table>
						
						<?php //if($Publisher_billing_details != NULL){ ?>
						<a href="<?php echo base_url(); ?>index.php/Reportc/Export_publisher_billing_report/?Report_type=<?php echo $Report_type;?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date;?>&seller_id=<?php echo $seller_id; ?>&Billing_status=<?php echo $Billing_status;?>&pdf_excel_flag=1">
						
						<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button></a>
						
						<a href="<?php echo base_url(); ?>index.php/Reportc/Export_publisher_billing_report/?Report_type=<?php echo $Report_type;?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date;?>&seller_id=<?php echo $seller_id; ?>&Billing_status=<?php echo $Billing_status; ?>&pdf_excel_flag=2">
						
						
						<button class="btn btn-danger" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button></a>
						
					  </div>
					</div>
				</div>
				
				<?php } else { ?>
				
					<div class="element-wrapper">											
						<div class="element-box">
							<h6 class="form-header text-center">
								No Record Founds
							</h6> 
						</div>
					</div>
				
				<?php } ?>
				<!-----------Table------------>
			</div>
		</div>	
	</div>
</div>
<?php $this->load->view('header/footer'); ?>
<script>
$('#Register').click(function()
{
	if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "" && $('#transaction_type_id').val() != ""  && $('#seller_id').val() != "" )
	{
		show_loader();
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
<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Points_usage_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">PUBLISHER POINTS USAGE REPORT</h6>  
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
									<option value="">Select Publishers</option>
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
								<div class="form-group">
									<label for="exampleInputEmail1"><span class="required_info">*</span> Status</label>
									<select class="form-control" name="Usage_status" id="Usage_status" data-error="Please select status" required="required">
										<option value="0">All</option>
										<?php								
										foreach($Buy_Miles_Status as $Miles_Status)
										{
										?>
											<option value="<?php echo $Miles_Status->Code_decode_id; ?>"><?php echo $Miles_Status->Code_decode; ?></option>
										<?php									
										}
										?>
									</select>	
									<div class="help-block form-text with-errors form-control-feedback" id="Status"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
								   <label for=""><span class="required_info">* </span>Till Date <span class="required_info">(* click inside textbox)</span></label>
									<input class="single-daterange form-control" placeholder="End Date" type="text"  name="end_date" id="datepicker2" data-error="Please select till date"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							  
								<div class="form-group">
									<label for="exampleInputEmail1"><span class="required_info">*</span>Transaction Type</label>
									<select class="form-control" name="transaction_type_id" id="transaction_type_id" data-error="Please select transaction type" required="required">
										<option value="0">All Transaction Type</option>
										<?php								
										foreach($transaction_types as $transaction)
										{
											if($transaction->Trans_type_id==25)
											{
											?>
												<option value="<?php echo $transaction->Trans_type_id; ?>"><?php echo $transaction->Trans_type; ?></option>
											<?php
											}
										}
										?>
									</select>	
									<div class="help-block form-text with-errors form-control-feedback" id="TransType"></div>
								</div>
							  
								<div class="form-group">
									<label for=""><span class="required_info">* </span>Report Type</label>
									<select class="form-control" name="report_type" id="report_type" data-error="Please select report type" required="required">
										<option value="0">Detail Report</option>
										<option value="1">Summary Report</option>
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
					  <?php echo $Company_details->Currency_name; ?> Usage Report<?php if($Report_type == 0) { echo " Details"; } else { echo " Summary";} ?>
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<?php if($Report_type == 0) { ?>
										<th>Trans Date</th>
										<th>Publishers Name</th>
										<th>Member Name</th>
										<th>Membership ID</th>
										<th>Bill No.</th>
										<th>Remarks</th>
										
									<?php } ?>
									<th>Status</th>
									<th><?php if($Report_type == 0) { echo "Purchase Miles/Points"; }else { echo "Total Purchase Miles/Points"; } ?></th>
									<th><?php if($Report_type == 0) { echo "Used ".$Company_details->Currency_name; }else { echo "Total Used ".$Company_details->Currency_name; } ?></th>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<?php if($Report_type == 0) { ?>
										<th>Trans Date</th>
										<th>Publishers Name</th>
										<th>Member Name</th>
										<th>Membership ID</th>
										<th>Bill No.</th>
										<th>Remarks</th>
										
									<?php } ?>
									<th>Status</th>
									<th><?php if($Report_type == 0) { echo "Purchase Miles/Points"; }else { echo "Total Purchase Miles/Points"; } ?></th>
									<th><?php if($Report_type == 0) { echo "Used ".$Company_details->Currency_name; }else { echo "Total Used ".$Company_details->Currency_name; } ?></th>
								</tr>
							</tfoot>
							<tbody>
							<?php
								$lv_Merchant_id=0;
								foreach($Seller_report_details as $row)
								{	
									$Merchant_id=$row->Merchant_id;
									$Publishers_id=$row->Publishers_id;
									$sellerName=$row->Merchant_name;
									$PublishersName=$row->PublishersName;
									if($lv_Merchant_id!=$Publishers_id && $Report_type==1)//&& $report_type!=2
									{
										echo "<tr class='success'><td colspan='16' style='color:blue;'>".$PublishersName." </td></tr>";
									} 
									if($row->Bonus_points==0 )
									{
										$row->Bonus_points="-";
									}
									if($row->purchase_amt==0 )
									{
										$row->purchase_amt="-";
									}
									if($row->reedem_pt==0)
									{
										$row->reedem_pt="-";
									}
									if($row->balance_to_pay==0)
									{
										$row->balance_to_pay="-";
									}
									if($row->loyalty_pts_gain==0)
									{
										$row->loyalty_pts_gain="-";
									}
									if($row->coalition_Loyalty_pts==0)
									{
										$row->coalition_Loyalty_pts="-";
									}
									if($row->Manual_billno=="")
									{
										$Bill_no=$row->Bill_no;
									}
									else
									{
										$Bill_no=$row->Manual_billno;
									}	
								?>					
									<tr>									
										<?php if($Report_type == 0) 
										{
										?>
											<td class="text-center"><?php echo date('Y-m-d',strtotime($row->Trans_date)); ?></td>
											<td><?php echo $PublishersName;?></td>
											<td><?php echo $row->Member_name;?></td>
											<td><?php echo $row->Membership_ID; ?></td>
											<td><?php if($Bill_no!=""){echo $Bill_no; }else {echo "-";}?></td>
											<td class="text-center"><?php echo $row->Remarks; ?></td>
										
										<?php 
										} 
										?>
										<td class="text-center"><?php echo $row->status; ?></td>
										<td class="text-center"><?php echo $row->purchase_amt; ?></td>
										<td class="text-center"><?php echo $row->reedem_pt; ?></td>
									</tr>
								<?php
								$lv_Merchant_id=$Publishers_id; 
								}
								?>
							</tbody>
						</table>
						
						<?php if($Seller_report_details != NULL){ ?>
						<a href="<?php echo base_url()?>index.php/Reportc/export_Points_usage_report/?Report_type=<?php echo $Report_type; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&pdf_excel_flag=1">
						<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button></a>
						
						<a href="<?php echo base_url()?>index.php/Reportc/export_Points_usage_report/?Report_type=<?php echo $Report_type; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&pdf_excel_flag=2">
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
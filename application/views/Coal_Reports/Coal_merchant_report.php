<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Coal_Reportc/merchant_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Outlet Transaction Report</h6>  
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
							  
							  <?php
								if($Super_seller == 1)
								{
							?>
								<div class="form-group">
								<label for=""> <span class="required_info">* </span>Business/Merchant </label>
								<select class="form-control" name="brand_id" id="brand_id" data-error="Please select brand" required>
									<option value="">Select Business/Merchant</option>
									<?php
									
											foreach($sub_sellers as $sellerA)
											{
											?>
												<option value="<?php echo $sellerA->Enrollement_id; ?>"><?php echo $sellerA->First_name." ".$sellerA->Last_name; ?></option>
											<?php
											}
									?>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>								
								</div>
								
								<div class="form-group">
								<label for=""><span class="required_info">* </span>Outlet Name</label>
								<select class="form-control" name="seller_id" id="seller_id" data-error="Please select outlet name" required="required">

									<option value="">Select Business/Merchant</option>	
								</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								
							<?php
								}
								else
								{
							?>
							  <div class="form-group">
								<label for=""><span class="required_info">* </span>Outlet Name</label>
								<select class="form-control" name="seller_id" id="seller_id" data-error="Please select outlet name" required="required">
								<?php if($Super_seller > 0 || $Sub_seller_admin > 0){?>
									<option value="0">All</option>
									
									<?php
									}
											foreach($company_sellers as $sellers)
											{
											?>
												<option value="<?php echo $sellers->Enrollement_id; ?>"><?php echo $sellers->First_name." ".$sellers->Last_name; ?></option>
											<?php
											}
									?>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							<?php } ?>  
							  <div class="form-group">
								<label for=""><span class="required_info">* </span>Transaction Type</label>
								<select class="form-control" name="transaction_type_id" id="transaction_type_id" data-error="Please select transaction type" required="required">
									<option value="">Select transaction type</option>
									<option value="0">All</option>
								<?php								
									foreach($transaction_types as $transaction)
									{
									if($transaction->Trans_type_id==1 || $transaction->Trans_type_id==2 || $transaction->Trans_type_id==3 || $transaction->Trans_type_id==4 || $transaction->Trans_type_id==10 || $transaction->Trans_type_id==12 || $transaction->Trans_type_id==29)
										{ ?>
										<option value="<?php echo $transaction->Trans_type_id; ?>"><?php echo $transaction->Trans_type; ?></option>	<?php
										}
									}	?>
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
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					  Outlet Transaction Report<?php if($Report_type == 0) { echo " Details"; }else{echo " Summary";} ?>
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
								<!--	<?php if($Report_type == 0) { ?><th>Reciept</th><?php } ?>-->
									<?php if($Report_type == 0) { ?><th>Trans Date</th><?php } ?>
									<?php if($Report_type == 1) { ?><th>Trans Type</th><?php } ?> 
									<?php if($Report_type == 0) { ?><th>Outlet</th><?php } ?>
									<?php if($Report_type == 0) { ?><th>EHP_Order_No</th><?php } ?>
									<?php if($Report_type == 0) { ?><th>POS Bill No.</th><?php } ?>
									<?php if($Report_type == 0) { ?><th>Membership ID/Gift Card No.</th><?php } ?>
									
									<?php if($Report_type == 0) { ?><th>Member Name</th><?php } ?>
									
									<th><?php if($Report_type == 0) { echo "Purchase Amt (".$Symbol_currency.") "; }else { echo "Total Purchase Amt (".$Symbol_currency.") "; } ?></th>
									
									<th><?php if($Report_type == 0) { echo "Bonus ".$Company_details->Currency_name." Issued"; }else { echo "Total Bonus ".$Company_details->Currency_name; } ?></th>
									
									<th><?php if($Report_type == 0) { echo "Redeemed ".$Company_details->Currency_name; }else { echo "Total Redeemed ".$Company_details->Currency_name; } ?></th>
									
									<?php if($Report_type == 1) { echo "<th>Total Voucher Redeemed</th>"; } ?>
									
									<?php if($Report_type == 1) { echo "<th>Total Voucher Amt (".$Symbol_currency.") </th>"; } ?>
									
									<?php /* if($Report_type == 0) { echo "<th>Qty</th>"; }?>
									<?php if($Report_type == 0) { echo '<th>Remarks </th>'; } */ ?>
								</tr>
							</thead>						
							<tfoot>
								<tr>
							<!--		<?php if($Report_type == 0) { ?><th>Reciept</th><?php } ?>-->
									<?php if($Report_type == 0) { ?><th>Trans Date</th><?php } ?>
									<?php if($Report_type == 1) { ?><th>Trans Type</th><?php } ?> 
									<?php if($Report_type == 0) { ?><th>Merchant Name</th><?php } ?>
									<?php if($Report_type == 0) { ?><th>EHP_Order_No</th><?php } ?>
									<?php if($Report_type == 0) { ?><th>POS Bill No.</th><?php } ?>
									<?php if($Report_type == 0) { ?><th>Membership ID/Gift Card No.</th><?php } ?>
									
									<?php if($Report_type == 0) { ?><th>Member Name</th><?php } ?>
									
									<th><?php if($Report_type == 0) { echo "Purchase Amt (".$Symbol_currency.") "; }else { echo "Total Purchase Amt (".$Symbol_currency.") "; } ?></th>
									
									<th><?php if($Report_type == 0) { echo "Bonus ".$Company_details->Currency_name." Issued"; }else { echo "Total Bonus ".$Company_details->Currency_name; } ?></th>
									
									<th><?php if($Report_type == 0) { echo "Redeemed ".$Company_details->Currency_name; }else { echo "Total Redeemed ".$Company_details->Currency_name; } ?></th>
									
									<?php if($Report_type == 1) { echo "<th>Total Voucher Redeemed</th>"; } ?>
									
									<?php if($Report_type == 1) { echo "<th>Total Voucher Amt (".$Symbol_currency.") </th>"; } ?>
									
									<?php /* if($Report_type == 0) { echo "<th>Qty</th>"; }?>
									<?php if($Report_type == 0) { echo '<th>Remarks </th>'; } */ ?>
								</tr>
							</tfoot>
							<tbody>
						<?php
							$lv_Merchant_id=0;
							if($Seller_report_details != NULL)
							{	
								foreach($Seller_report_details as $row)
								{	
									$Merchant_id=$row->Merchant_id;
									$sellerName=$row->Merchant_name;
									if($lv_Merchant_id!=$Merchant_id && $Report_type==1) //&& $report_type!=2
									{
										echo "<tr class='success' style='background:#dff0d8;'><td colspan='14' style='color:blue;'>".$sellerName." </td></tr>";
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
									/* if($row->POS_bill_no=="")
									{
										$Bill_no=$row->EHP_Order_no;
									}
									else
									{
										$Bill_no=$row->POS_bill_no;
									} */
								?>
								<tr>
									<?php /*if($Report_type == 0) 
									{?>
									<!--<td>
										<a href="javascript:void(0);" id="receipt_details"  onclick="receipt_details('<?php echo $row->EHP_Order_no; ?>',<?php echo $row->Merchant_id; ?>,<?php echo $row->Trans_id; ?>,<?php echo $row->Trans_type_id; ?>);" title="Receipt">
											<i class="os-icon os-icon-ui-49"></i>
										</a>								
									</td> -->
									<?php } */ 
									if($Report_type == 0) 
									{?>
										<td><?php echo date('Y-m-d',strtotime($row->Trans_date)); ?></td>
							  <?php } ?>
								<?php if($Report_type == 1) { ?><td><?php echo $row->Trans_type;?></td><?php } ?>
								<?php 
									if($Report_type == 0) 
									{?>
										<td><?php echo $sellerName;?></td>
							  <?php }

									if($Report_type == 0) 
									{ ?>
										<td><?php echo $row->EHP_Order_no; ?></td>
							  <?php }
									if($Report_type == 0) 
									{ ?>
										<td><?php echo $row->POS_bill_no; ?></td>
							  <?php }
									if($Report_type == 0) 
									{ ?>
										<td><?php echo $row->Membership_ID; ?></td>
							  <?php } 							  
									if($Report_type == 0) 
									{ ?>
										<td><?php echo $row->Member_name;?></td>
							  <?php } 
									
								?>
							  
									<td><?php echo number_format($row->purchase_amt,2); ?></td>
									<td><?php echo $row->Bonus_points; ?></td>
									
									<td><?php echo $row->reedem_pt; ?></td>
									
								<?php if($Report_type == 1) {?>	<th><?php echo $row->Voucher_redeemed; ?></th> <?php }
									 if($Report_type == 1) { ?><th><?php echo number_format($row->Voucher_amount,2);?></th> 
								<?php 
										}
								/*	if($Report_type == 0) 
									{ ?>
										<td><?php if($row->Quantity!=0){echo $row->Quantity;}else{echo "-";} ?></td>
							  <?php } 
									if($Report_type == 0) 
									{ ?>
										<td><?php echo $row->Remarks; ?></td>
							  <?php } */ ?>	
								</tr>
							<?php $lv_Merchant_id=$Merchant_id;  
							    } 	
							} ?>
							</tbody>
						</table>
						<?php if($Seller_report_details != NULL){ ?>
							<a href="<?php echo base_url()?>index.php/Coal_Reportc/export_merchant_report/?Report_type=<?php echo $Report_type; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
							
							<a href="<?php echo base_url()?>index.php/Coal_Reportc/export_merchant_report/?Report_type=<?php echo $Report_type; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&pdf_excel_flag=2">
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
	if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "" && $('#seller_id').val() != "")
	{
		// show_loader();
	}
	
	var btn_class_name = this.className ;
	if(btn_class_name=="btn btn-primary")
	{
		show_loader();
	}
});

//**** 04-05-2020 *** sandeep ***********
$('#brand_id').change(function()
	{
		var brand_id = $("#brand_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		
		$.ajax({
			type:"POST",
			data:{seller_id:brand_id,Company_id:Company_id},
			url:'<?php echo base_url()?>index.php/Reportc/get_outlet_by_subadmin',
			success:function(opData4){
				$('#seller_id').html(opData4);
			}
		});
			
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
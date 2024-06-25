<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Partner_Merchandzie_Catalogue_Report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">PARTNER MERCHANDZIE CATALOGUE REPORT</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							<div class="form-group">
						<label for="">Company Name</label>
						<select class="form-control" name="Company_id" required>
							<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
						</select>							
					</div> 
					<div class="form-group">
						<label for=""><span class="required_info">*</span> Select Merchandize Partner</label>
							<select class="form-control" name="Partner_id" id="Partner_id" required data-error="Please Select Merchandize Partner">
							<option value="">Select Merchandize Partner</option>							
							<?php if($Super_seller == 1 ) { ?>
							<option value="0">All Partners</option>
							<?php } ?>
							<?php								
								foreach($Partner_Records as $Partner)
								{
									if($Partner->Partner_type!=4) //Not Shipping Partner
									{
										if($Merchandize_Partner_ID==$Partner->Partner_id)
										{
											echo '<option value="'.$Partner->Partner_id.'">'.$Partner->Partner_name.'</option>';
										}
										if($Super_seller == 1 ) 
										{
											echo '<option value="'.$Partner->Partner_id.'">'.$Partner->Partner_name.'</option>';
										}
									}										
								}
							?>
							</select>	
							<div class="help-block form-text with-errors form-control-feedback"></div>			
					</div>
					<div class="form-group">
						<label for=""><span class="required_info">*</span> Select Partner Branches</label>
							<select  class="form-control" name="partner_branches" id="partner_branches" required>
							<option value="0">All</option>
							</select>												
					</div>
					<div class="form-group">
						<label for=""><span class="required_info">*</span>Transaction Type</label>
						<?php
							unset($transaction_types[4]);
							unset($transaction_types[5]);
						?>
						<select class="form-control" name="transaction_type_id" id="transaction_type_id" required>
						<option value="0">Both</option>
							<?php								
							foreach($transaction_types as $transaction)
							{
								// if($transaction->Trans_type_id ==10) // Redemption
								if($transaction->Trans_type_id ==10 || $transaction->Trans_type_id ==12) // Redemption/online purchase
								{
							?>									
								<option value="<?php echo $transaction->Trans_type_id; ?>"><?php echo $transaction->Trans_type; ?></option>
							<?php
								}
							}
							?>
						</select>							
					</div>
					<div class="form-group">
						<label for=""><span class="required_info">*</span> Report Type </label>
						<select class="form-control" name="report_type" ID="report_type" required>
							<option value="1">Details</option>
							<option value="2">Summary</option>
						</select>							
					</div>
							  
							</div>
							<div class="col-sm-6">
							<div class="form-group">
						<label for="">
							<span class="required_info">*</span> From Date <span class="required_info">(* click inside textbox)</span>
						</label>
						<div class="input-group">
							<input type="text" name="start_date" id="datepicker1" class="single-daterange form-control" placeholder="Start Date" required/>			
							<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
						</div>
					</div>
					<div class="form-group">
						<label for="">
							<span class="required_info">*</span> Till Date<span class="required_info">(* click inside textbox)</span>
						</label>
						<div class="input-group">
							<input type="text" name="end_date" id="datepicker2" class="single-daterange form-control" placeholder="End Date" required/>			
							<span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
						</div>
					</div>
					<div class="form-group">
						<label for=""><span class="required_info">*</span> Select Delivery Method</label>
							<select class="form-control" name="Delivery_method" id="Delivery_method">
								<option value="0">Both</option>
								<option value="28">In-Person</option>
								<option value="29">Delivery</option>			
							</select>									
					</div>
					<div class="form-group">
						<label for=""><span class="required_info">*</span> Select Voucher Status</label>
						<select class="form-control" name="Voucher_status" id="Voucher_status">
							<option value="0">All</option>
							<!--<option value="Issued">Issued</option>
							<option value="Used">Used</option>
							<option value="Expired">Expired</option>-->	
						</select>									
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
		<?php 
	 
		$end_date=date("Y-m-d",strtotime($_REQUEST["end_date"]));
		$start_date=date("Y-m-d",strtotime($_REQUEST["start_date"]));
		$Partner_id=$_REQUEST["Partner_id"];
		$partner_branches=$_REQUEST["partner_branches"];	
		$transaction_type_id = $_REQUEST["transaction_type_id"];				
		$Delivery_method = $_REQUEST["Delivery_method"];
		$Voucher_status1=$_REQUEST["Voucher_status"];
		$report_type=$_REQUEST["report_type"];
			
	?>
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
						<?php if($report_type == 1)
						{ 
							echo "Partner Merchandzie Catalogue Report details";
						}
						else
						{ 
							echo "Partner Merchandzie Catalogue Report Summary";
						} 
						?>
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
									
									<?php if($report_type == 1)
									{ ?>
									<tr>
										<th>Trans Date</th>
										<th>Trans Type</th>
										<th>Partner Name</th>
										
										<th>Membership ID</th>
										
										<!--<th>Item Code</th>-->
										<th>Item Name</th>
										
										<!--<th>Item Size</th>-->
										<!--<th>Purchase Amount <?php //echo '('.$Symbol_of_currency.')';?> </th>
										<th>Shipping Cost</th>-->
										
										<th>Total Redeemed <?php echo $Company_details->Currency_name; ?> </th>						
											
										<th>Voucher Status</th>		
										<th>Cost Payable to Partner</th>							
										<th>Payment Status</th>							
										<!--<th>Delivery Method</th>		
										<th>Remarks</th>-->
									</tr>
							<?php 	}
									else
									{  ?>
									<tr>
										<th>Month</th>
										<th>partner Name</th>
										<th>Partner Branch</th>
										<th>Voucher Status</th>
										<th>Total Quantity</th>
										<!--<th>Total Purchase Amount <?php // echo '('.$Symbol_of_currency.')';?></th>-->
										<th>Total Redeemed <?php echo $Company_details->Currency_name; ?> </th>
										<th>Total Cost Payable to Partner</th>							
									</tr>							
						<?php		}
								?>
								
							</thead>						
							<tfoot>
									<?php if($report_type == 1)
									{ ?>
									<tr>
										<th>Trans Date</th>
										<th>Trans Type</th>
										<th>Partner Name</th>
										
										<th>Membership ID</th>
										
										<!--<th>Item Code</th>-->
										<th>Item Name</th>
										
										<!--<th>Item Size</th>-->
										<!--<th>Purchase Amount <?php //echo '('.$Symbol_of_currency.')';?> </th>
										<th>Shipping Cost</th>-->
										
										<th>Total Redeemed <?php echo $Company_details->Currency_name; ?> </th>						
										
										<th>Voucher Status</th>		
										<th>Cost Payable to Partner</th>							
										<th>Payment Status</th>							
										<!--<th>Delivery Method</th>		
										<th>Remarks</th>-->
									</tr>
							<?php 	}
									else
									{  ?>
									<tr>
										<th>Month</th>
										<th>partner Name</th>
										<th>Partner Branch</th>
										<th>Voucher Status</th>
										<th>Total Quantity</th>
										<!--<th>Total Purchase Amount <?php // echo '('.$Symbol_of_currency.')';?></th>-->
										<th>Total Redeemed <?php echo $Company_details->Currency_name; ?> </th>
										<th>Total Cost Payable to Partner</th>							
									</tr>							
						<?php		}
								?>
							</tfoot>
							<tbody>
						<?php
						$todays = date("Y-m-d");						
						if($Trans_Records != NULL)
						{
							foreach($Trans_Records as $row)
							{
								if($report_type == 1)
								{
								
									if($row->Status== "Used" || $row->Status== "Expired")
									{
										$color="red";
									}
									else
									{
										$color="green";
									}
									if($row->Payment_to_partner_flag== "Paid")
									{
										$color1="green";
									}
									else
									{
										$color1="red";
									}
									echo "<tr>";								
										echo "<td>".date("Y-m-d", strtotime($row->Trans_date))."</td>";		
										echo "<td>".$row->Trans_type."</td>";		
										echo "<td>".$row->Partner_name."</td>";		
										//echo "<td>".$row->Branch_name."</td>";		
										echo "<td>".$row->Card_id."</td>";		
										//echo "<td>".$row->First_name.' '.$row->Last_name."</td>";	// echo "<td>".$row->Item_code."</td>";
										echo "<td>".$row->Merchandize_item_name."</td>";
										//echo "<td>".$row->Quantity."</td>";
										// echo "<td>".$row->Item_size."</td>";
										
										/*									
										echo "<td>".$row->Purchase_amount."</td>";
										echo "<td>".$row->Shipping_cost."</td>";						
										echo "<td>".$row->Redeem_points_per_Item."</td>";
										*/
										
										//echo "<td>".$row->Redeem_points."</td>";
										echo "<td>".$row->Total_Redeem_points."</td>";
										
										/*
										if($row->Trans_type =="Redemption")
										{
											echo "<td>".($row->Redeem_points*$row->Quantity)."</td>";
										}
										else
										{
											echo "<td>".$row->Redeem_points."</td>";
										}
										*/
										
										//echo "<td>".$row->Voucher_no."</td>";
										echo "<td style='color:$color;'>".$row->Status."</td>";
										echo "<td>".$row->Cost_payable_partner."</td>";
										echo "<td style='color:$color1;'>".$row->Payment_to_partner_flag."</td>";
									echo "</tr>";	
								}
								else
								{
									echo "<tr>";
										echo "<td>".$row->Trans_monthyear."</td>";		
										echo "<td>".$row->Partner_name."</td>";		
										echo "<td>".$row->Branch_name."</td>";		
										echo "<td>".$row->Status."</td>";	
										echo "<td>".$row->total_voucher."</td>";	
										//echo "<td>".$row->total_purchase_amt."</td>";	
										echo "<td>".$row->Total_points."</td>";	
										echo "<td>".$row->Total_cost_pay_to_partnet."</td>";	
									echo "</tr>";	
								}
							}
						}
						?>
							</tbody>
						</table>
						
						<?php if($Trans_Records != NULL){ ?>
						
						<a href="<?php echo base_url()?>index.php/Reportc/export_partner_merchandzie_catalogue_report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&partner_branches=<?php echo $partner_branches; ?>&Partner_id=<?php echo $Partner_id; ?>&transaction_type_id=<?php echo $transaction_type_id; ?>&Delivery_method=<?php echo $Delivery_method; ?>&Voucher_status=<?php echo $Voucher_status1; ?>&report_type=<?php echo $report_type; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
						</a>						

						<a href="<?php echo base_url()?>index.php/Reportc/export_partner_merchandzie_catalogue_report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&partner_branches=<?php echo $partner_branches; ?>&Partner_id=<?php echo $Partner_id; ?>&transaction_type_id=<?php echo $transaction_type_id; ?>&Delivery_method=<?php echo $Delivery_method; ?>&Voucher_status=<?php echo $Voucher_status1; ?>&report_type=<?php echo $report_type; ?>&pdf_excel_flag=2">
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


<?php $this->load->view('header/footer'); ?>

<!-- Modal -->
<div id="receipt_myModal" class="modal fade" role="dialog" style="overflow:auto;">
	<div class="modal-dialog" style="width: 90%;margin-top:20%;" id="show_transaction_receipt">


		<div class="modal-content">
			<div class="modal-header">

			<div class="modal-body">
				<div class="table-responsive" ></div>
			</div>
			
		</div>
	
	</div>
</div>
<!-- Modal -->


<script>
$('#Register').click(function()
{
	if($('#datepicker2').val() != ""  && $('#datepicker1').val() != ""  && $('#Partner_id').val() != "" )
	{		
		show_loader();
	} 
});
$('#Partner_id').change(function()
{	
	var Partner_id = $("#Partner_id").val();
	var Company_id = '<?php echo $Company_id; ?>';
	$.ajax({
		type:"POST",
		data:{Partner_id:Partner_id, Company_id:Company_id},
		url: "<?php echo base_url()?>index.php/CatalogueC/Get_Partner_Branches",
		success: function(data)
		{
			$('#partner_branches').html(data.Get_Partner_Branches2);	
		}				
	});
});
function pagination_item(limit)
{			
	show_loader();
	limit=(limit*10);
	var start_date='<?php echo $start_date; ?>';
	var end_date='<?php echo $end_date; ?>';
	var Partner_id='<?php echo $Partner_id; ?>';
	var partner_branches='<?php echo $partner_branches; ?>';
	var transaction_type_id='<?php echo $transaction_type_id; ?>';
	var Delivery_method='<?php echo $Delivery_method; ?>';
	var Voucher_status='<?php echo $Voucher_status1; ?>';
	var report_type='<?php echo $report_type; ?>';
	
	window.location='Partner_Merchandzie_Catalogue_Report?page_limit='+limit+'&Partner_id='+Partner_id+'&start_date='+start_date+'&end_date='+end_date+'&partner_branches='+partner_branches+'&transaction_type_id='+transaction_type_id+'&Delivery_method='+Delivery_method+'&Voucher_status='+Voucher_status+'&report_type='+report_type+'&submit';
}
/******calender *********/
$(function() 
{
	$( "#datepicker1" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	});	
	$( "#datepicker2" ).datepicker({
		changeMonth: true,
		yearRange: "-80:+0",
		changeYear: true
	});	
});
/******calender *********/
/*********************Nilesh*****************************/
$('#Delivery_method').change(function()
{	
	var Delivery_method = $("#Delivery_method").val();
	var Company_id = '<?php echo $Company_id; ?>';
	$.ajax({
		type:"POST",
		data:{Delivery_method:Delivery_method,Company_id:Company_id},
		url: "<?php echo base_url()?>index.php/Reportc/Get_Voucher_status",
		success: function(data)
		{
			//alert(data)
			$('#Voucher_status').html(data.Get_Voucher_ststus2);
		}				
	});
});
/*********************Nilesh*****************************/
</script>
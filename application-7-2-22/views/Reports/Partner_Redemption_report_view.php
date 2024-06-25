<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Partner_Redemption_Report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">PARTNER REDEMPTION REPORT</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							
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
							<div class="col-sm-6">
							
							 <div class="form-group">
								<label for=""><span class="required_info">*</span> Select Partner Branches</label>
									<select  class="form-control" name="partner_branches" id="partner_branches" required>
									<option value="0">All</option>
										
									</select>		
												
							</div>
							  
							  <div class="form-group">
								<label for="exampleInputEmail1"><span class="required_info">*</span> Select Voucher Status</label>
									<select class="form-control" name="Voucher_status" id="Voucher_status"   >
									<option value="0">All Status</option>
									<option value="30">Issued</option>
									<option value="31">Used</option>
									<option value="32">Expired</option>
									
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
		$Voucher_status=$_REQUEST["Voucher_status"];
		
			
?>
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
						Partner Redemption Report details
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
									
								<tr>
								<th>Details</th>
								<th>Transaction Date</th>
								<th>M. Partner Name</th>
								<th>M. Partner Branch</th>
								<th>Item Code</th>
								
								
								<th>Total Redeemed <?php echo $Company_details->Currency_name; ?></th>
								<th>Voucher No.</th>
								<th>Voucher Status</th>
								<th>Cost Payable to Partner</th>
								
								
								</tr>
								
							</thead>						
							<tfoot>
								<tr>
								<th>Details</th>
								<th>Transaction Date</th>
								<th>M. Partner Name</th>
								<th>M. Partner Branch</th>
								<th>Item Code</th>
								
								<th>Total Redeemed <?php echo $Company_details->Currency_name; ?></th>
								<th>Voucher No.</th>
								<th>Voucher Status</th>
								<th>Cost Payable to Partner</th>
								
								
								</tr>
							</tfoot>
							<tbody>
						<?php
						$todays = date("Y-m-d");
						
						
					
						if($Trans_Records != NULL)
						{
							
							$lv_Enrollement_id=0;
							
							foreach($Trans_Records as $row)
							{
								$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
								$Card_id=$row->Card_id;
								$Enrollement_id=$row->Enrollement_id;
								
								/* if($lv_Enrollement_id!=$Enrollement_id)
								{
									echo "<tr class='success'><td colspan='12'>".$Full_name." (".$Card_id.")</td></tr>";
								} */
								
								
									if($row->Voucher_status=="Issued" || $row->Voucher_status=="Ordered")
									{
										$color="green";
									}
									else
									{
										$color="red";
									}
									
									echo "<tr>";?>
									
									<td class="text-center">
								<a href="javascript:void(0);" id="receipt_redemption_details" onclick="receipt_redemption_details(<?php echo $row->Company_id; ?>,<?php echo $row->Card_id; ?>,'<?php echo $row->Voucher_no; ?>');" title="Receipt">
									<i class="os-icon os-icon-ui-49"></i>
								</a>								
								</td>
									<?php 
									
									echo "<td>".$row->Trans_date."</td>";
									echo "<td>".$row->Partner_name."</td>";
									echo "<td>".$row->Branch_name."</td>";
									echo "<td>".$row->Item_code."</td>";
									
									
									
									echo "<td>".$row->Redeem_points*$row->Quantity."</td>";
									echo "<td>".$row->Voucher_no."</td>";
									
									echo "<td style='color:$color;'>".$row->Voucher_status."</td>";
									echo "<td>".($row->Cost_payable_to_partner*$row->Quantity)."</td>";
									echo "</tr>";
					
								
								
						   
								$lv_Enrollement_id=$Enrollement_id;
							}
						}
						?>
							</tbody>
						</table>
						
						<?php if($Trans_Records != NULL){ ?>
						<a href="<?php echo base_url()?>index.php/Reportc/export_partner_update_voucher_status/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&partner_branches=<?php echo $partner_branches; ?>&Partner_id=<?php echo $Partner_id; ?>&Voucher_status=<?php echo $Voucher_status; ?>&pdf_excel_flag=1">Update Details
						<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
						</a>
						<a href="<?php echo base_url()?>index.php/Reportc/export_partner_update_voucher_status/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&partner_branches=<?php echo $partner_branches; ?>&Partner_id=<?php echo $Partner_id; ?>&Voucher_status=<?php echo $Voucher_status; ?>&pdf_excel_flag=2">
							<button class="btn btn-danger" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button>
						</a>
						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						
						<a href="<?php echo base_url()?>index.php/Reportc/export_partner_redempion_report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&partner_branches=<?php echo $partner_branches; ?>&Partner_id=<?php echo $Partner_id; ?>&Voucher_status=<?php echo $Voucher_status; ?>&pdf_excel_flag=1">All
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
						</a>						

						<a href="<?php echo base_url()?>index.php/Reportc/export_partner_redempion_report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&partner_branches=<?php echo $partner_branches; ?>&Partner_id=<?php echo $Partner_id; ?>&Voucher_status=<?php echo $Voucher_status; ?>&pdf_excel_flag=2">
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
				//alert(data)
				$('#partner_branches').html(data.Get_Partner_Branches2);
			
			}				
		});
	});


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


function receipt_redemption_details(Company_id,Card_id,Voucher_no)
{	
	$.ajax({
		type: "POST",
		data: {Company_id: Company_id, Card_id:Card_id,Voucher_no:Voucher_no},
		url: "<?php echo base_url()?>index.php/Reportc/Partner_redemption_receipt",
		success: function(data)
		{
			$("#show_transaction_receipt").html(data.transactionReceiptHtml);	
			$('#receipt_myModal').show();
			$("#receipt_myModal").addClass( "in" );	
			$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
		}
	});
}
/******calender *********/
</script>

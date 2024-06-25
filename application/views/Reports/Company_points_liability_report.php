<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Company_points_liability_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Company <?php echo $Company_details->Currency_name; ?> Liability Report</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">
							  <div class="form-group">
							   <label for=""><span class="required_info">* </span>From Date <span class="required_info">(* click inside textbox)</span></label>
								<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1" data-error="Please select from date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							</div>
							<div class="col-sm-6">
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
					  <?php if($liability_report != NULL || $liability_report1 != NULL || $liability_report2 != NULL) { ?>
						<h6 class="form-header">Company <?php echo $Company_details->Currency_name; ?> Liability Report -- From Date : <?php echo $From_date; ?> To Date : <?php echo $To_date; ?>
					    </h6> 
					<?php
					
						if($liability_report != NULL) { ?>
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
								<tr style="background-color: #D9EDF7;">		
									<th class="text-left" colspan="3" style='color:blue;'>ISSUED <?php echo $Company_details->Currency_name; ?></th>			
								</tr>
								<tr style="background-color: #D9EDF7;">		
									<th class="text-center">Merchant Name</th>
									<th class="text-center"><?php echo $Company_details->Currency_name; ?> Issued</th>
									<th class="text-center">Equivalent (<?php echo $Symbol_of_currency; ?>) Excluding Tax</th>					
								</tr>
								</thead>				
								<tbody>
								<?php
									foreach($liability_report as $row)
									{	?>								
										<tr>	
											<td class="text-center"><?php echo $row->Merchant_name; ?></td>		
											<td class="text-center"><?php echo $row->Total_points_issued; ?></td>	
											<td class="text-center"><?php echo $row->EquivalentAED; ?></td>			
										</tr>
							<?php   } ?>
								</tbody> 
							</table>
						</div> 
						<?php } 
						if($liability_report1 != NULL || $liability_report2 != NULL) { ?>
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
								<tr style="background-color: #D9EDF7;">		
									<th class="text-left" colspan="4" style='color:blue;'>USED <?php echo $Company_details->Currency_name; ?></th>					
								</tr>
								<?php if($liability_report1 != NULL) { ?>
								<tr >		
									<th class="text-left" colspan="4" style='color:red;'>FROM PUBLISHER</th>	
								</tr>
								<tr style="background-color: #D9EDF7;">		
									<th class="text-center">Publisher Name</th>
									<th class="text-center">Pending </th>
									<th class="text-center">Approved</th>					
									<th class="text-center">Cancelled</th>					
								</tr>
								<?php } ?>
								</thead>				
								<tbody>
								<?php 
									foreach($liability_report1 as $row)
									{	
										if($row->Beneficiary_company!=0) { ?>								
										<tr>	
											<td class="text-center"><?php echo $row->Publisher_name; ?></td>		
											<td class="text-center"><?php echo $row->Pending_Redeem_points; ?></td>		<td class="text-center"><?php echo $row->Approved_Redeem_points; ?></td>	<td class="text-center"><?php echo $row->Cancelled_Redeem_points; ?></td>			
										</tr>
							<?php  		 }  
									} ?>
								</tbody> 
							</table>
						</div>
						<?php } 
						if($liability_report2 != NULL) { ?>
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
								<tr>		
									<th class="text-left" colspan="3" style='color:red;'>FROM CATALOGUE</th>	
								</tr>
								<tr style="background-color: #D9EDF7;">		
									<th class="text-center">Merchant Name</th>
									<th class="text-center">Ordered <span class="required_info">(Ordered / Shipped / Issued/)</span></th>
									<th class="text-center">Fulfilled <span class="required_info">(Used / Delivered)</span></th>									
								</tr>
								</thead>				
								<tbody>
								<?php 
									foreach($liability_report2 as $row)
									{	
										if($row->Merchant_id!=0)
										{ ?>								
											<tr>	
												<td class="text-center"><?php echo $row->Merchant_name; ?></td>		
												<td class="text-center"><?php echo $row->Ordered_Redeem_points; ?></td>	<td class="text-center"><?php echo $row->Fulfilled_Redeem_points; ?></td>
											</tr>
								<?php   } 
									}  ?>
								</tbody> 
							</table>
						</div>
						<?php } 
						if($liability_report3 != NULL || $liability_report4 != NULL) { ?>
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
								<tr style="background-color: #D9EDF7;">		
									<th class="text-left" colspan="3" style='color:blue;'>SETTLEMENT</th>					
								</tr>
								<tr>		
									<th class="text-left" colspan="3" style='color:red;'>MERCHANTS</th>	
								</tr>
								<tr style="background-color: #D9EDF7;">		
									<th class="text-center">Merchant Name</th>
									<th class="text-center">Invoiced (<?php echo $Symbol_of_currency; ?>) Including Tax</th>
									<th class="text-center">Settled (<?php echo $Symbol_of_currency; ?>)</th>									
								</tr>
								</thead>				
								<tbody>
								<?php 
									foreach($liability_report3 as $row)
									{	
										if($row->Merchant_id!=0)
										{ ?>								
											<tr>	
												<td class="text-center"><?php echo $row->Merchant_name; ?></td>		
												<td class="text-center"><?php echo $row->MInvoiced_AED; ?></td>	<td class="text-center"><?php echo $row->MSettled_AED; ?></td>
											</tr>
								<?php   } 
									}  ?>
								</tbody> 
							</table>
						</div>
						<?php } 
						if($liability_report4 != NULL) { ?>
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
								<tr >		
									<th class="text-left" colspan="3" style='color:red;'>PUBLISHERS</th>	
								</tr>
								<tr style="background-color: #D9EDF7;">		
									<th class="text-center">Publisher Name</th>
									<th class="text-center">Invoiced (<?php echo $Symbol_of_currency; ?>) Including Tax</th>
									<th class="text-center">Settled (<?php echo $Symbol_of_currency; ?>)</th>									
								</tr>
								</thead>				
								<tbody>
								<?php 
									foreach($liability_report4 as $row)
									{	
										if($row->Publisher_id!=0)
										{ ?>								
											<tr>	
												<td class="text-center"><?php echo $row->Publisher_name1; ?></td>		
												<td class="text-center"><?php echo $row->PInvoiced_AED; ?></td>	<td class="text-center"><?php echo $row->PSettled_AED; ?></td>
											</tr>
								<?php   } 
									}  ?>
								</tbody> 
							</table>
						</div>
						<?php } ?><br/>							
						<a href="<?php echo base_url()?>index.php/Reportc/export_company_points_liability_report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&pdf_excel_flag=2">
						<button class="btn btn-danger" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button>
						</a>
					<?php
					}
					else
					{ ?>	
						<div class="alert alert-danger" role="alert">
							<h6 align="center">No Records Found</h6>
						</div>
			<?php 	} ?>
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
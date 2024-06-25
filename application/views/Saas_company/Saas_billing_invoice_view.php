<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Saas_invoice',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">SAAS BILLING INVOICE</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							
								<div class="form-group">
								<label for=""> <span class="required_info">* </span>Company Name </label>
								<select class="form-control" name="Company_id"  id="Company_id" required="required">
								<option value="">Select Company</option>
								<?php if($Partner_clients != Null){  
								foreach($Partner_clients as $row){
								if($row['Company_id'] !=1)	{ ?>
								 <option value="<?php echo $row['Company_id']; ?>"><?php echo $row['Company_name']; ?></option>
								<?php } }
								} ?>
								</select>
								</div>
								<div class="form-group">
								<label for=""> <span class="required_info">* </span>Payment Type </label>
								<select class="form-control" name="Payment_type"  id="Payment_type" required="required">
								<option value="">Select Payment Type</option>
								<option value="0">Company License Payment</option>
								<option value="1">E-Gifting Account TopUp</option>
								</select>
								</div>
						
							   <div class="form-group">
								<label for="">Invoice Number </label>
								<input type="text" class="form-control" name="Invoice_no" id="Invoice_no" placeholder="Please enter invoice number">
								
								<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							  
							</div>
							<div class="col-sm-6">
							  
							<div class="form-group">
							   <label for="">From Date</label>
								<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1" data-error="Please select from date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>

							  <div class="form-group">
							   <label for="">Till Date </label>
								<input class="single-daterange form-control" placeholder="End Date" type="text"  name="end_date" id="datepicker2" data-error="Please select till date"/>
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
		<?php if($_REQUEST["Payment_type"] == 0) { ?>
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					 Saas Billing invoice
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>

								<tr>
									<th>#</th>
									<th>Date</th>
									<th>Company</th>
									<th>Country</th>
									<th>Currency</th>
									<th>License Type</th>
									<th>License Period</th>
									<th>Invoice No</th>
									<th>Invoice Amount</th>
									<th>Reference Id</th>
									<th>Email Sent</th>
								</tr>
							</thead>						
							<tfoot>
								
								<tr>
									<th>#</th>
									<th>Date</th>
									<th>Company</th>
									<th>Country</th>
									<th>Currency</th>
									<th>License Type</th>
									<th>License Period</th>
									<th>Invoice No</th>
									<th>Invoice Amount</th>
									<th>Reference Id</th>
									<th>Email Sent</th>		   
								</tr>

							</tfoot>
							<tbody>
					<?php
				
					if(isset($_REQUEST["submit"]) && ($Payment_record != NULL))
					{ 
							if($Payment_record != NULL)
							{
								foreach($Payment_record as $row)
								{ 
								if($row->Country_name == "India")
								{
									$Currency = "INR";
								}
								else
								{
									$Currency = "USD";
								}
								
								if($row->License_type == 120)
								{
									$License = "Enhance";
								}
								else if($row->License_type == 121)
								{
									$License = "Basic";
								}
								else if($row->License_type == 253)
								{
									$License = "Standard";
								}
								else
								{
									$License="";
								}
								if($row->Email_sent == 1)
								{
									$Email_sent = "Yes";
								}
								else
								{
									$Email_sent = "No";
								}
								?>
									<tr>
									<td>
									
										<a href="<?php echo base_url()?>index.php/Saas_invoice/Download/?Company_id=<?php echo $row->Company_id; ?>&Payment_id=<?php echo $row->Payment_id; ?>">
										<i class="fa fa-download" aria-hidden="true" style="font-size:20px;" title="Download Invoice"></i>	
										<!--<button class="btn btn-danger" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button>-->
										</a>
										
									</td>
									<td><?php 
										$date2=date_create($row->Bill_date);
										$Bill_date = date_format($date2,"d M Y");  
										echo $Bill_date;?></td>
									<td><?php echo $row->Company_name;?></td>
									<td><?php echo $row->Country_name;?></td>
									<td><?php echo $Currency;?></td>
									<td><?php echo $License;?></td>
									<td><?php if($row->Period >0){ echo $row->Period." Days"; }?></td>
									<td><?php echo $row->Bill_no;?></td>
									<td><?php echo $row->Bill_amount;?></td>
									<td><?php echo $row->Razorpay_payment_id;?></td>
									<td><?php echo $Email_sent;?></td>
									</tr>
								<?php		
								}
										
								
							}
					}
				?>
							</tbody>
						</table>
					  </div>
					</div>
				</div>
		<?php  } else if($_REQUEST["Payment_type"] == 1) { ?>
		<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					 E-Gifting Catalogue Billing invoice
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>

								<tr>
									<th>#</th>
										<th>Date</th>
										<th>Company</th>
										<th>Country</th>
										<th>Currency</th>
										<th>Invoice No.</th>
										<th>TopUp Amount</th>
										<th>Reference Id</th>
										<th>Email Sent</th>
								</tr>
							</thead>						
							<tfoot>
								
								<tr>
									<th>#</th>
										<th>Date</th>
										<th>Company</th>
										<th>Country</th>
										<th>Currency</th>
										<th>Invoice No.</th>
										<th>TopUp Amount</th>
										<th>Reference Id</th>
										<th>Email Sent</th>		   
								</tr>

							</tfoot>
							<tbody>
					<?php
				
					if(isset($_REQUEST["submit"]) && ($Payment_record != NULL))
					{ 
							if($Payment_record != NULL)
							{
								foreach($Payment_record as $row)
								{ 
								if($row->Country_name == "India")
								{
									$Currency = "INR";
								}
								else
								{
									$Currency = "USD";
								}
								
			
								if($row->Email_sent == 1)
								{
									$Email_sent = "Yes";
								}
								else
								{
									$Email_sent = "No";
								}
								?>
									<tr>
									<td>
									
										<a href="<?php echo base_url()?>index.php/Gift_payment/Download/?Company_id=<?php echo $row->Company_id; ?>&Payment_id=<?php echo $row->Payment_id; ?>">
										<i class="fa fa-download" aria-hidden="true" style="font-size:20px;" title="Download Invoice"></i>	
										</a>
										
									</td>
									<td><?php 
										$date2=date_create($row->Bill_date);
										$Bill_date = date_format($date2,"d M Y");  
										echo $Bill_date;?></td>
									<td><?php echo $row->Company_name;?></td>
									<td><?php echo $row->Country_name;?></td>
									<td><?php echo $Currency;?></td>
									<td><?php echo $row->Bill_no;?></td>
									<td><?php echo $row->Bill_amount;?></td>
									<td><?php echo $row->Razorpay_payment_id;?></td>
									<td><?php echo $Email_sent;?></td>
									</tr>
								<?php		
								}
										
								
							}
					}
				?>
							</tbody>
						</table>
					  </div>
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

	 if($('#Company_id').val() != "" && '#Payment_type').val() != "")
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
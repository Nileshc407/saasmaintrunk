<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open('Reportc/deposite_topup_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Deposit/Merchant Topup Report</h6>  
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
								<label for=""><span class="required_info">* </span>Transaction Type</label>
								<select class="form-control" name="Trans_type" id="Trans_type" data-error="Please select transaction type" required="required" onchange="javascript:showhideseller(this.value);">
								<option value="">Select transaction type</option>
								<option value="1">All</option> 
									<?php
										foreach($Transaction_type_array as $Transaction_type)
										{
											if($Transaction_type->Trans_type_id==5 || $Transaction_type->Trans_type_id==6)
											{
												echo "<option value=".$Transaction_type->Trans_type_id.">".$Transaction_type->Trans_type."</option>";
											}
										}
									?>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
							  <div class="form-group" id="block2" style="display:none;">
								<label for=""><span class="required_info">* </span>Merchant Name</label>
								<select class="form-control" name="seller_id" id="seller_id" data-error="Please select merchant">
									<option value="">Select merchant</option>
									<option value="0">All merchant</option>
									<?php
										foreach($Seller_array as $seller_val)
										{
											echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
										}
									?>
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
					  Deposit/Merchant Topup Transaction
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<th>Company Name</th>
									<th>Merchant Name</th>
									<th>Transaction Date</th>
									<th>Exception Transaction</th>
									<th>Transaction Type</th>
									<th>Topup Amount</th>	
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<th>Company Name</th>
									<th>Merchant Name</th>
									<th>Transaction Date</th>
									<th>Exception Transaction</th>
									<th>Transaction Type</th>
									<th>Topup Amount</th>
								</tr>
							</tfoot>
				
							<tbody>
							<?php 
								$todays = date("Y-m-d");
								if($results2 != NULL)
								{	
									foreach($results2 as $row)
									{	
										$except = $row->Exception_flag;
										$exc = $row->Exception_completed;
										
										if($except == 0)
										{
											$except_rpt='No';
										}
										else
										{									
											$except_rpt='Yes';
										}							
									?> 
										<tr>
											<td><?php echo $row->Company_name;?></td>			
											<td><?php echo $row->First_name." ".$row->Last_name;?></td>
											<td><?php echo date("Y-m-d",strtotime($row->Transaction_date));?></td>
											<td><?php echo  $except_rpt; ?></td>
											<td><?php echo $row->Trans_type; ?></td>
											<td><?php echo $row->Amt_transaction;?></td>
										</tr>
							<?php 	    
									}  
								} ?> 
							</tbody>
						</table> 
						<?php if($results2 != NULL){ ?>
						
							<a href="<?php echo base_url()?>index.php/Reportc/export_deposit_topup_report/?pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
							
							<a href="<?php echo base_url()?>index.php/Reportc/export_deposit_topup_report/?pdf_excel_flag=2">
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
function showhideseller(flag)
{	
	if(flag==5)
	{
		document.getElementById("block2").style.display="none";
	 
		jQuery('#seller_id').removeAttr("required");
	}
	else if(flag==1)
	{
		document.getElementById("block2").style.display="";
		jQuery('#seller_id').removeAttr("required");
	}
	else
	{
		document.getElementById("block2").style.display="";
		jQuery('#seller_id').attr("required","required");
	}
}
</script>
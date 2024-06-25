<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Beneficiary_transfer_point_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">BENEFICIARY COMPANY LIABILITY REPORT</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">									
								<div class="form-group">
									<label for=""><span class="required_info">* </span>From Date <span class="required_info">(* click inside textbox)</span></label>
									<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1" data-error="Please select from date" />
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>							   
								<div class="form-group">
									<label for=""><span class="required_info">* </span>Company Name</label>
									<select class="form-control" name="Company_id" id="Company_id" data-error="Please select company" required="required">									
									
									<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
									<?php	
									if($Get_Beneficiary_Company1!=NULL)
									{
										foreach($Get_Beneficiary_Company1 as $Get_Company1)
										{	
											$Reference_company_id = $Get_Company1->Reference_company_id;									
											$Get_Beneficiary_Company = $ci_object->Report_model->Get_Beneficiary_Company_Details($Reference_company_id);											
											foreach($Get_Beneficiary_Company as $Get_Beneficiary_)
											{ ?>
											
												<option value="<?php echo $Get_Beneficiary_->E_Company_id; ?>"><?php echo $Get_Beneficiary_->E_Company_name; ?></option>
											<?php	
											
											} 									
										} 
									}
									?>
									</select>
									<div class="help-block form-text with-errors form-control-feedback" id="CompanyID"></div>
								</div>								
							</div>
							<div class="col-sm-6">
								<div class="form-group">
								   <label for=""><span class="required_info">* </span>Till Date <span class="required_info">(* click inside textbox)</span></label>
									<input class="single-daterange form-control" placeholder="End Date" type="text"  name="end_date" id="datepicker2" data-error="Please select till date"/>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>				
								<div class="form-group">
									<label for=""><span class="required_info">*</span>Transaction Type</label>
									<?php
									unset($transaction_types[4]);
									unset($transaction_types[5]);
									?>
									<select class="form-control" name="transaction_type_id" id="transaction_type_id" data-error="Please select transaction type" required="required">
										
										<option value="0">All Transaction Type</option>
										<?php								
										foreach($transaction_types as $transaction)
										{
											if($transaction->Trans_type_id !=2 && $transaction->Trans_type_id !=3 && $transaction->Trans_type_id !=4 && $transaction->Trans_type_id !=5 && $transaction->Trans_type_id !=6 && $transaction->Trans_type_id !=7 && $transaction->Trans_type_id !=8 &&$transaction->Trans_type_id !=9 && $transaction->Trans_type_id !=10 && $transaction->Trans_type_id !=11 && $transaction->Trans_type_id !=12 && $transaction->Trans_type_id !=13 && $transaction->Trans_type_id !=14 && $transaction->Trans_type_id !=15 && $transaction->Trans_type_id !=16 && $transaction->Trans_type_id !=17 && $transaction->Trans_type_id !=18 && $transaction->Trans_type_id !=19 &&  $transaction->Trans_type_id !=20 && $transaction->Trans_type_id !=22 && $transaction->Trans_type_id !=23 )//Game Campaign & Redemption
											{
											?>
												<option value="<?php echo $transaction->Trans_type_id; ?>"><?php echo $transaction->Trans_type; ?></option>
											<?php
											}
										}
										?>
									</select>
										<div class="help-block form-text with-errors form-control-feedback" id="TransactionType"></div>									
								</div>
								<div class="form-group">
									<label for=""><span class="required_info">* </span>Report Type</label>
									<select class="form-control" name="report_type" id="report_type" data-error="Please select report type" required="required">
										<option value="1">Detail Report</option>
										<option value="2">Summary Report</option>
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
				
				
				<?php 	
				
					if(($Trans_Records != NULL)) {
						
						$To_date=date("Y-m-d",strtotime($_REQUEST["end_date"]));
						$From_date=date("Y-m-d",strtotime($_REQUEST["start_date"]));
						$report_type=$_REQUEST["report_type"];
						$Tier_id=$_REQUEST["Tier_id"];
						
					?>	
				
				
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					  <?php if($report_type==1){ echo 'Beneficiary Company Liability Report details';}
							else{echo 'Beneficiary Company Liability Report Summary';} ?>
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
								<tr>
									<?php
									 //Details
									if($report_type == 2) 
									{  
									?>
									
										<th>Company Name</th>     
										<th>Total Transfered <?php echo $Company_details->Currency_name; ?></th>                             
										<th>Total Recived <?php echo $Company_details->Currency_name; ?></th>
					
					
										
									<?php 	
									} else if($report_type==1) { 
									 //Summary
									?>
									
										<th>Transaction Date</th>
										<th>From Company</th>
										<th>From Member</th>
										<th>From Membership</th>
										<!--<th>Transaction Type</th>-->			
										<th>To Company</th>
										<th>To Member</th>
										<th>To Membership</th>
										<th>Transfer <?php echo $Company_details->Currency_name; ?></th>
										<th>Received <?php echo $Company_details->Currency_name; ?></th>
										<th>Remarks</th>
									
								<?php } ?>
								</tr>
							</thead>						
							<tfoot>
								<tr>
									<?php
									 //Details
									if($report_type == 2) 
									{  
									?>
									
										<th>Company Name</th>                             
										<th>Total Transfered <?php echo $Company_details->Currency_name; ?></th>                             
										<th>Total Recived <?php echo $Company_details->Currency_name; ?></th>
					
					
										
									<?php 	
									} else if($report_type==1) { 
									 //Summary
									?>
									
										<th>Transaction Date</th>
										<th>From Company</th>
										<th>From Member</th>
										<th>From Membership</th>		
										<th>To Company</th>
										<th>To Member</th>
										<th>To Membership</th>
										<th>Transfer <?php echo $Company_details->Currency_name; ?></th>
										<th>Received <?php echo $Company_details->Currency_name; ?></th>
										<th>Remarks</th>
									
								<?php } ?>
								</tr>
							</tfoot>
							<tbody>
							<?php
							
								$lv_Merchant_id=0;
								$todays = date("Y-m-d");
								$start_date=date("Y-m-d",strtotime($_REQUEST["start_date"]));
								$end_date=date("Y-m-d",strtotime($_REQUEST["end_date"]));
								$report_type=$_REQUEST["report_type"];
								$transaction_type_id=$_REQUEST["transaction_type_id"];
								$Company_id=$_REQUEST["Company_id"];
								$lv_Company_id=0;
								foreach($Trans_Records as $row)
								{
									$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
									$Membership_ID=$row->Membership_ID;
									$Company_name=$row->Company_name;
									$rowCompany_id=$row->Company_id;
									// $Tier_name=$row->Tier_name;
									
									if($lv_Company_id!=$rowCompany_id && $report_type==2)
									{
										// echo "<tr class='success'><td colspan='14'><b>".$Company_name." (".$Membership_ID.")   Tier : ". $Tier_name." </b></td></tr>";
										
										// echo "<tr class='success'><td colspan='14'><b>".$Company_name."</b></td></tr>";
									}
									
									if($report_type==1)//Details
									{
								
										if($row->From_Beneficiary_company_name=="")
										{
											$row->From_Beneficiary_company_name="-";
										}
										if($row->To_Beneficiary_company_name=="")
										{
											$row->To_Beneficiary_company_name="-";
										}
										if($row->To_Beneficiary_cust_name=="")
										{
											$row->To_Beneficiary_cust_name="-";
										}
										if($row->Transfer_to=='0')
										{
											$row->Transfer_to="-";
										}
										if($row->Transfer_points==0)
										{
											$row->Transfer_points="-";
										}
										if($row->Recived_point==0)
										{
											$row->Recived_point="-";
										}
										if($row->Coalition_Loyalty_pts==0)
										{
											$row->Coalition_Loyalty_pts="-";
										}
						
										echo "<tr>";
										
										?>
														
										<?php echo "<td>".$row->Trans_date."</td>";
										echo "<td>".$row->From_Beneficiary_company_name."</td>";
										echo "<td>".$Full_name."</td>";
										echo "<td>".$Membership_ID."</td>";
										// echo "<td>".$row->Trans_type."</td>";
										
										echo "<td>".$row->To_Beneficiary_company_name."</td>";
										echo "<td>".$row->To_Beneficiary_cust_name."</td>";
										echo "<td>".$row->Transfer_to."</td>";									 
										echo "<td>".$row->Transfer_points."</td>";
										echo "<td>".$row->Recived_point."</td>";
										echo "<td>".$row->Remarks."</td>";
										echo "</tr>";
									}
									else
									{
										if($row->Total_Transfer_Points==0)
										{
											$row->Total_Transfer_Points="-";
										}
										if($row->Total_Recived_Points==0)
										{
											$row->Total_Recived_Points="-";
										}
										
											?>
										<tr>

											<td><?php echo $Company_name;?></td>
											<td><?php echo $row->Total_Transfer_Points;?></td>
											<td><?php echo $row->Total_Recived_Points;?></td>
										</tr>
									<?php   
									}
									
									$lv_Company_id=$rowCompany_id;
								}								
								
									?>
							</tbody>
						</table>
						
						<?php //if($Publisher_billing_details != NULL){ ?>
						<a href="<?php echo base_url()?>index.php/Reportc/export_customer_Beneficiary_transfer_point_report/?report_type=<?php echo $report_type; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&transaction_type_id=<?php echo $transaction_type_id; ?>&Company_id=<?php echo $Company_id; ?>&pdf_excel_flag=1">
						
						<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button></a>
						
						<a href="<?php echo base_url()?>index.php/Reportc/export_customer_Beneficiary_transfer_point_report/?report_type=<?php echo $report_type; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&transaction_type_id=<?php echo $transaction_type_id; ?>&Company_id=<?php echo $Company_id; ?>&pdf_excel_flag=2">
						
						
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
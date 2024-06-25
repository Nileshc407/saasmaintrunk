<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Customer_High_Value_Trans_Report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">MEMBER HIGH VALUE TRANSACTION REPORT</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							
								<div class="form-group">
								<label for=""> <span class="required_info">* </span>Company Name </label>
								<select class="form-control " name="Company_id"  required="required">

								 <option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
								</select>
								</div>
						
								<div class="form-group" id="cust_block_segment">
									<label for=""> Select Segment </label>
									<select class="form-control " name="Segment_code" id="Segment_code">
									<option value="">Select Segment</option>
									 <?php										
										foreach($Segments_list as $Segments)
										{
											echo '<option value="'.$Segments->Segment_code.'">'.$Segments->Segment_name.'</option>';
										}
										?>
									</select>
								</div>
								
							   <div class="form-group">
								<label for=""> <span class="required_info">* </span>Transaction Type </label>
								<select class="form-control " name="Criteria" id="Criteria" required="required" data-error="Please select transaction type">
								<option value="">Select</option>
								<option value="1">Purchase Amount</option>
								<option value="2">Gained <?php echo $Company_details->Currency_name; ?> </option>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								
								<div class="form-group">
									<label for="exampleInputEmail1"> </label>		
									<label class="radio-inline">
										<input type="radio"  name="Value_type" id="Value_type" onclick="toggel_cust(this.value)" value="1" checked >High Value	
										<input type="radio"   name="Value_type" id="Value_type" onclick="toggel_cust(this.value)" value="2" >Total High Value
									</label>
								</div>
								
							</div>
							<div class="col-sm-6">
							  
							<div class="form-group">
							   <label for=""><span class="required_info">* </span>From Date </label>
								<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1"  required="required" data-error="Please select from date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>

							  <div class="form-group">
							   <label for=""><span class="required_info">* </span>Till Date </label>
								<input class="single-daterange form-control" placeholder="End Date" type="text"  name="end_date" id="datepicker2" required="required" data-error="Please select till date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
								<div class="form-group">
									<label for=""><span class="required_info">* </span>Select Operator  </label>
									<select class="form-control" name="Operatorid" id="Operatorid"  onchange="javascript:check_operator2(this.value);" required="required" data-error="Please select operator">
										<option value=""> Select Operator </option>
										<option value="="> = </option>
										<option value="!="> != </option>
										<option value=">"> > </option>
										<option value=">="> >= </option>
										<option value="<"> < </option>
										<option value="<="> <= </option>
										<option value="Between"> Between </option>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
								
								<div class="form-group">
									<label for=""><span class="required_info">*</span> Enter Criteria Value</label>
									<input type="text" id="Criteria_value"   name="Criteria_value" class="form-control" placeholder="Enter Criteria Value"    onkeyup="this.value=this.value.replace(/\D/g,'')" required="required" data-error="Please enter criteria value" />
									
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
									
								<div class="form-group" id="Criteria_value2_block" style="display:none;">
									<label for=""><span class="required_info">*</span> Enter Criteria Value 2</label>
									<input type="text" id="Criteria_value2"   name="Criteria_value2" class="form-control" placeholder="Enter Criteria Value 2"    onkeyup="this.value=this.value.replace(/\D/g,'')" data-error="Please enter criteria value 2" />
									
									<div class="help-block form-text with-errors form-control-feedback"></div>
								</div>
							</div>
						</div>
					  <div class="form-buttons-w" align="center">
						<button class="btn btn-primary" name="submit" type="submit" id="Register" value="Register">Submit</button>
						<button class="btn btn-primary" type="reset">Reset</button>
					  </div>
				
		<?php echo form_close(); 		
			$Value_type = $_REQUEST["Value_type"];
		?>
			</div>
		</div>
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
						Member High Value Transaction details
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>

								<?php if($Value_type==1){ //Details?>
								<tr>
								<th>Transaction Date</th>
								<th>Membership ID</th>
								<th>Member Name</th>
								<th>Transaction Type</th>
								<th>Bill No.</th>
								<th>Purchase Amount <?php echo "($Symbol_of_currency)"; ?></th>
								<th>Redeemed <?php echo $Company_details->Currency_name; ?> </th>
								<th>Gained <?php echo $Company_details->Currency_name; ?> </th>
								<th>Balance Paid</th>

								</tr>
								<?php } else { //Summary?>
								<tr>
									<th>Member Name</th>
									<th>Membership ID</th>
									<th>Transaction Type</th>
									<th>Total Purchase Amount <?php echo "($Symbol_of_currency)"; ?></th>
									<th>Total Redeemed <?php echo $Company_details->Currency_name; ?> </th>
									<th>Total Gained <?php echo $Company_details->Currency_name; ?> </th>
									<th>Total Balance Paid</th>
								</tr>
								<?php } ?>
							</thead>						
							<tfoot>
								
								<?php if($Value_type==1){ //Details?>
								<tr>
								<th>Transaction Date</th>
								<th>Membership ID</th>
								<th>Member Name</th>
								<th>Transaction Type</th>
								<th>Bill No.</th>
								<th>Purchase Amount <?php echo "($Symbol_of_currency)"; ?> </th>
								<th>Redeemed <?php echo $Company_details->Currency_name; ?> </th>
								<th>Gained <?php echo $Company_details->Currency_name; ?> </th>
								<th>Balance Paid</th>

								</tr>
								<?php } else { //Summary?>
								<tr>
									<th>Member Name</th>
									<th>Membership ID</th>
									<th>Transaction Type</th>
									<th>Total Purchase Amount <?php echo "($Symbol_of_currency)"; ?></th>
									<th>Total Redeemed <?php echo $Company_details->Currency_name; ?> </th>
									<th>Total Gained <?php echo $Company_details->Currency_name; ?> </th>
									<th>Total Balance Paid</th>
								</tr>
								<?php } ?>

							</tfoot>
							<tbody>
				<?php
						
					if(isset($_REQUEST["submit"]) && ($Trans_Records != NULL))
					{ 	

						$Company_id = $_REQUEST["Company_id"];
						$start_date = date("Y-m-d",strtotime($_REQUEST["start_date"]));
						$end_date = date("Y-m-d",strtotime($_REQUEST["end_date"]));
						
						$Operatorid = $_REQUEST["Operatorid"];
						$Criteria = $_REQUEST["Criteria"];
						$Criteria_value = $_REQUEST["Criteria_value"];
						$Segment_code = $_REQUEST["Segment_code"];
									

						if($Operatorid==1)
						{
							$Criteria_value2 =0;
						}
						else
						{
							$Criteria_value2 =$_REQUEST["Criteria_value2"];
						}
							if($Trans_Records != NULL)
							{
								$lv_Enrollement_id=0;
								
								foreach($Trans_Records as $row)
								{
									$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
									$Membership_ID=$row->Membership_ID;
									//$Enrollement_id=$row->Enrollement_id;
									$Show_member=0;
									
									
									if($row->Redeem_points==0)
									{
										$row->Redeem_points="-";
									}
	
									$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
									$Current_balance=$row->Current_balance;
									if($Value_type==1)//High Value
									{
										?>
										<tr>
									
										<td><?php echo $row->Trans_date;?></td>
										<td><?php echo $row->Membership_ID;?></td>
										<td><?php echo $Full_name;?></td>
												
										<td><?php echo $row->Trans_type;?></td>
										<td><?php echo $row->Bill_no;?></td>
										<td><?php echo $row->Purchase_amount;?></td>
										<td><?php echo $row->Redeem_points;?></td>
										<td><?php echo $row->Loyalty_pts;?></td>
										<td><?php echo $row->balance_to_pay;?></td>
									
										</tr>
						<?php   
									}
									else
									{ 
										
								?>
											<tr>
												<td><?php echo $Full_name;?></td>
												<td><?php echo $row->Membership_ID;?></td>
												<td><?php echo $row->Trans_type;?></td>
												<td><?php echo $row->Total_Purchase_Amount; ?> </td>
												<td><?php echo $row->Total_Redeemed_Points;?></td>
												<td><?php echo $row->Total_Gained_Points;?></td>
												<td><?php echo $row->Total_balance_to_pay;?></td>
											</tr>
							<?php		 
									}
									//	$lv_Enrollement_id=$Enrollement_id;
								
								}
							}
					}
							?>
							</tbody>
						</table>
				<?php   if($Trans_Records != NULL)
						{
						?>
							<a href="<?php echo base_url()?>index.php/Reportc/export_customer_high_value_report/?Company_id=<?php echo $Company_id; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&Value_type=<?php echo $Value_type; ?>&Operatorid=<?php echo $Operatorid; ?>&Criteria=<?php echo $Criteria; ?>&Criteria_value=<?php echo $Criteria_value; ?>&Criteria_value2=<?php echo $Criteria_value2; ?>&Segment_code=<?php echo $Segment_code; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/export_customer_high_value_report/?Company_id=<?php echo $Company_id; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&Value_type=<?php echo $Value_type; ?>&Operatorid=<?php echo $Operatorid; ?>&Criteria=<?php echo $Criteria; ?>&Criteria_value=<?php echo $Criteria_value; ?>&Criteria_value2=<?php echo $Criteria_value2; ?>&Segment_code=<?php echo $Segment_code; ?>&pdf_excel_flag=2">
							<button class="btn btn-danger" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button>
							</a>
				<?php 	} ?>
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

	 if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "" && $('#Criteria').val() != ""  && $('#Criteria_value').val() != ""   && $('#Operatorid').val() != "" )
		{
			
			var Operatorid = $('#Operatorid').val();
			//alert(Operatorid);
			if(Operatorid != "Between" )
			{
				show_loader();
			}
			
			
			if(Operatorid == "Between" )
			{
				if($('#Criteria_value2').val() != "")
				{
					show_loader();
				}
				
			}
			
		}
});
	
	function check_operator2(operator)
	{
		
		if(operator=="Between")
		{
			$("#Criteria_value2").attr("required","required");
			document.getElementById("Criteria_value2_block").style.display="";
		}
		else
		{
			$("#Criteria_value2").removeAttr("required");	
				document.getElementById("Criteria_value2_block").style.display="none";
		}
	
	}

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
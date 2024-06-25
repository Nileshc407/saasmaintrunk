<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Member_loyalty_orders_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Member Points Report</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							
								<div class="form-group">
								<label for=""><span class="required_info">* </span>Business/Merchant Name</label>
								<select class="form-control" name="seller_id" ID="seller_id" required>
									<option value="">Select Business/Merchant</option>
									<?php
									
										echo '<option value="0">All Brands</option>';
									if($Logged_user_id > 2 || $Super_seller == 1)
										{
											echo '<option value="'.$enroll.'">'.$LogginUserName.'</option>';
										}							
											foreach($Seller_array as $seller_val)
											{
												echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
											}
									
									?> 
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							 
							 <div class="form-group">
								<label for="">Linked Outlet Name</label>
								<select class="form-control" multiple name="Outlet_id[]" ID="Outlet_id" required>
									<option value="0">Select Business/Merchant First</option>

								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
					  
								<div class="form-group has-feedback">
					
									<label for="exampleInputEmail1">Membership ID</label>
									<input type="text" id="Single_cust_membership_id"   name="membership_id" class="form-control" placeholder="Enter Membership ID"   onblur="MembershipID_validation(this.value);"/>

									<input type="hidden" name="Company_id" class="form-control" value="<?php echo $Company_details->Company_id; ?>"/>							
									<span class="glyphicon" id="glyphicon" aria-hidden="true"></span>
									<div class="help-block"></div>
								</div>
								
							</div>
							<div class="col-sm-6">

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
								 
								<div class="form-group">
								<label for="exampleInputEmail1"><span class="required_info">*</span> Report Type </label>
								<select class="form-control" name="report_type" ID="report_type" onchange="toggleRptType(this.value);" required>
									<option value="1">Detail</option>
									<option value="2">Summary</option>
								</select>							
								</div>
							
							<div class="form-group" id="channelgroup">
								<label for=""> Channel </label>
								<select class="form-control " name="transaction_from" id="channel_id" required="required" data-error="Please select source">
									<option value="0">All</option>
									<option value="12">Online</option>
									<option value="2">POS</option>
									<option value="29">3rd Party Online</option>

								</select>
								
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
								<div class="form-group" id="Third" style="display:none;">
								<label for=""> <span class="required_info">* </span>Channel Company </label>
								<select class="form-control" name="Channel_id[]" id="Channel_id" multiple>
									<?php
									if($Channel_partner != NULL){
									foreach($Channel_partner as $Channel_partner)
									{ ?>
										<option value="<?php echo $Channel_partner->Register_beneficiary_id; ?>" selected><?php echo $Channel_partner->Beneficiary_company_name; ?></option>
										<?php		
									}
									}
								?>
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
		
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					  <?php if($report_type==1){ echo '<h6 class="form-header">Member Points Report details</h6>'; }
							else if($report_type==2){echo '<h6 class="form-header">Member Points Report Summary</h6>'; }
					?>
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
							<?php if($report_type==1){ //Details?>
								<tr>
									
								<!--	<th>Sequence No</th>-->
									<th>Date</th>
									<th>POS Bill No</th>
									
									<th>Membership ID</th>
									<th>Member Name</th>
									<th>Outlet</th>
									
									<th>Bill Amt <?php echo '('.$Symbol_of_currency.')';?></th>
									<th>Discount <?php echo '('.$Symbol_of_currency.')';?></th>
									<th>Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th>
									<th>Earned <?php echo $Company_details->Currency_name; ?></th> 
									<th>Redeemed <?php echo $Company_details->Currency_name; ?></th>
								<!--	<th>Discount Amt <?php echo '('.$Symbol_of_currency.')';?></th> -->
								<!--	<th>Voucher Amt <?php echo '('.$Symbol_of_currency.')';?></th>-->
								
								<!--	<th>Redeemed Amt <?php echo '('.$Symbol_of_currency.')';?></th> -->
									<!--<th>Mpesa TransId</th>
									<th>Mpesa Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th> -->
									<!--<th>COD Amount <?php echo '('.$Symbol_of_currency.')';?></th>-->
								<!--	<th>Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th> -->
								
								<!--	<th>Earned Amt</th> -->

								</tr>
								<?php }
								if($report_type==2){ //summary?>
								<tr>

								
									<th>Membership ID</th>  
									<th>Member Name</th>
									<th>Outlet Visits</th>
									<th>Online Purchased</th>
									<th>Online Bill Amt <?php echo '('.$Symbol_of_currency.')';?></th>
									<th>POS Bill Amt <?php echo '('.$Symbol_of_currency.')';?></th>
									<th>Bill Amt <?php echo '('.$Symbol_of_currency.')';?></th>
									
								<!--	<th>Discount Amt <?php echo '('.$Symbol_of_currency.')';?></th>
									<th>Voucher Amt <?php echo '('.$Symbol_of_currency.')';?></th>	 -->	
									<th>Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th>
									<th>Earned <?php echo $Company_details->Currency_name; ?></th>					
									<th>Redeemed <?php echo $Company_details->Currency_name; ?></th> 
								<!--	<th>Redeemed Amt <?php echo '('.$Symbol_of_currency.')';?></th>-->
									<!--<th>Mpesa TransId</th>
									<th>Mpesa Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th> -->
									<!--<th>COD Amount <?php echo '('.$Symbol_of_currency.')';?></th>-->
								<!--	 -->
									 
								<!--	<th>Earned Amt</th>-->

								</tr>
								<?php } ?>
								</thead>
								<tfoot>
								<?php if($report_type==1){ //Details?>
								<tr>
									<!--	<th>Sequence No</th>-->
									<th>Date</th>
									<th>POS Bill No</th>
									
									<th>Membership ID</th>
									<th>Member Name</th>
									<th>Outlet</th>
									
									<th>Bill Amt <?php echo '('.$Symbol_of_currency.')';?></th>
									<th>Discount <?php echo '('.$Symbol_of_currency.')';?></th>
									<th>Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th>
									<th>Earned <?php echo $Company_details->Currency_name; ?></th> 
									<th>Redeemed <?php echo $Company_details->Currency_name; ?></th>
								<!--	<th>Discount Amt <?php echo '('.$Symbol_of_currency.')';?></th> -->
								<!--	<th>Voucher Amt <?php echo '('.$Symbol_of_currency.')';?></th>-->
								
								<!--	<th>Redeemed Amt <?php echo '('.$Symbol_of_currency.')';?></th> -->
									<!--<th>Mpesa TransId</th>
									<th>Mpesa Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th> -->
									<!--<th>COD Amount <?php echo '('.$Symbol_of_currency.')';?></th>-->
								<!--	 -->
								
								<!--	<th>Earned Amt</th> -->
								</tr>
								<?php } 
								if($report_type==2){ //summary?>
								<tr>
									<th>Membership ID</th>  
										<th>Member Name</th>
										<th>Outlet Visits</th>
										<th>Online Purchased</th>
										<th>Online Bill Amt <?php echo '('.$Symbol_of_currency.')';?></th>
										<th>POS Bill Amt <?php echo '('.$Symbol_of_currency.')';?></th>
										<th>Bill Amt <?php echo '('.$Symbol_of_currency.')';?></th>
										
									<!--	<th>Discount Amt <?php echo '('.$Symbol_of_currency.')';?></th>
										<th>Voucher Amt <?php echo '('.$Symbol_of_currency.')';?></th>	 -->	
										<th>Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th>
										<th>Earned <?php echo $Company_details->Currency_name; ?></th>					
										<th>Redeemed <?php echo $Company_details->Currency_name; ?></th> 
									<!--	<th>Redeemed Amt <?php echo '('.$Symbol_of_currency.')';?></th>-->
										<!--<th>Mpesa TransId</th>
										<th>Mpesa Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th> -->
										<!--<th>COD Amount <?php echo '('.$Symbol_of_currency.')';?></th>-->
										
										 
									<!--	<th>Earned Amt</th>-->
								</tr>
								<?php } ?>
								</tfoot>
							<tbody>
						<?php
						$ci_object = &get_instance(); 
							$todays = date("Y-m-d");
						  $lv_Company_id = $_REQUEST["Company_id"];
						  $start_date = $_REQUEST["start_date"];
						  $end_date = $_REQUEST["end_date"];
						  $report_type = $_REQUEST["report_type"];
						  $Outlet_id = $_REQUEST["Outlet_id"];
						  $transaction_from = $_REQUEST["transaction_from"];
						  $Voucher_status = $_REQUEST["Voucher_status"];
						  $membership_id = $_REQUEST["membership_id"];
						  
						if($select_cust==2)//Single Customer 
						{
							$Single_cust_membership_id=$_REQUEST["membership_id"];
						}
						else
						{
							$Single_cust_membership_id=0;
						}
					
						if(count($Trans_Records) > 0)
						{
							//print_r($Trans_Records[0]);die;
							
							//$From_date=$_REQUEST["start_date"];
							//echo '<table  class="table table-bordered table-hover">';
							$lv_Enrollement_id=0;
							
							foreach($Trans_Records as $row)
							{
								$Member_name=$row->Member_name;
								$Card_id=$row->Membership_ID;
								$Enrollement_id=$row->Enrollement_id;
								
								/*if($lv_Enrollement_id!=$Enrollement_id)
								{
									echo "<tr class='success'><td colspan='13'>".$Full_name." (".$Card_id.")</td></tr>";
								}*/
								
								$color="green";
								$VoucherStatus = "-";	

									if($row->Order_status == 18)
									{
										$VoucherStatus = "Ordered";
									}
									if($row->Order_status == 19)
									{
										$VoucherStatus = "Shipped";
									}
									if($row->Order_status == 20)
									{
										if($row->Order_type == 28)
										{
											$VoucherStatus = "Collected";
										}
										else if($row->Order_type == 29)
										{
											$VoucherStatus = "Delivered";
										}
										else
										{
											$VoucherStatus = " ";
										}
									}
									if($row->Order_status == 21)
									{
										$VoucherStatus = "Cancel";
										$color="red";
									}
								if($row->Channel == 12)
								{
									$TransType = "Online";
								}
								
								if($row->Channel == 2)
								{
									$TransType = "POS";
								}
								if($row->Channel == 29)
								{
									$Channel_name = $ci_object->Report_model->Get_beneficiary_company($row->Channel_id);
									$TransType = $Channel_name->Beneficiary_company_name;
									
								}
								
								
								if($report_type==1)//Details
								{
									
									echo "<tr>";
									
								//	echo "<td>".$row->Sequence_no."</td>";
									echo "<td>".$row->Date."</td>";
									echo "<td>".$row->POS_bill_no."</td>";
									
									//echo "<td>".$row->Pos_billno."</td>";
									
									echo "<td>".$Card_id."</td>";
									echo "<td>".$Member_name."</td>"; 
									//echo "<td>".$TransType."</td>";
									echo "<td>".$row->Outlet."</td>";
									echo "<td>".number_format(round($row->Bill_amt),2)."</td>";
									echo "<td>".number_format(round($row->Discount_amt),2)."</td>";
									echo "<td>".number_format(round($row->Paid_amt),2)."</td>";
									echo "<td>".round($row->Earned_pts)."</td>";
									echo "<td>".round($row->Redeemed_pts)."</td>";
									
									//echo "<td>".number_format(round($row->Discount_amt),2)."</td>";
									//	echo "<td>".number_format(round($row->Voucher_amt),2)."</td>";
								
									//echo "<td>".number_format(round($row->Redeemed_amt),2)."</td>";
								
								//	echo "<td>".number_format(round($row->Total_mpesa_amount),2)."</td>";
									//echo "<td>".number_format(round($row->Total_cash_amount),2)."</td>";
								//	
								
								//	echo "<td>".number_format(round($row->Earned_amt),2)."</td>";
									//echo "<td style='color:$color;'>".$VoucherStatus."</td>";
	
									echo "</tr>";
								}
								else
								{ 
									echo "<tr>";
									echo "<td>".$Card_id."</td>";
									echo "<td>".$Member_name."</td>"; 
									echo "<td>".$row->Outlet_visits."</td>"; 
									echo "<td>".$row->Online_purchased."</td>"; 
									echo "<td>".number_format(round($row->Online_Bill_amt),2)."</td>";
									echo "<td>".number_format(round($row->POS_Bill_amt),2)."</td>";
									echo "<td>".number_format(round($row->Bill_amt),2)."</td>";
									echo "<td>".number_format(round($row->Paid_amt),2)."</td>";
									echo "<td>".round($row->Earned_pts)."</td>";
								//	echo "<td>".number_format(round($row->Discount_amt),2)."</td>";
								//	echo "<td>".number_format(round($row->Voucher_amt),2)."</td>";
									echo "<td>".round($row->Redeemed_pts)."</td>";
								//	echo "<td>".number_format(round($row->Redeemed_amt),2)."</td>";
									//echo "<td>".$row->Mpesa_TransID."</td>";
								//	echo "<td>".number_format(round($row->Total_mpesa_amount),2)."</td>";
									//echo "<td>".number_format(round($row->Total_cash_amount),2)."</td>";
									
								
								//	echo "<td>".number_format(round($row->Earned_amt),2)."</td>";
									//echo "<td style='color:$color;'>".$VoucherStatus."</td>";
	
	
									echo "</tr>";
								}
								$lv_Enrollement_id=$Enrollement_id;
							}
						}
						?>
						
							</tbody>
						</table>
				<?php 
					if($Trans_Records != NULL)
						{ 
						
						?>
							<a href="<?php echo base_url()?>index.php/Reportc/Member_loyalty_orders_report/?report_type=<?php echo $report_type; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&membership_id=<?php echo $membership_id; ?>&transaction_from=<?php echo $transaction_from; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/Member_loyalty_orders_report/?report_type=<?php echo $report_type; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&membership_id=<?php echo $membership_id; ?>&transaction_from=<?php echo $transaction_from; ?>&pdf_excel_flag=2">
							<button class="btn btn-danger" type="button"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button>
							</a>
					<?php 
						} 
						
					?>
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
	 if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "" && $('#seller_id').val() != "" )
		{
			show_loader();
		} 

});

$('#channel_id').change(function()
	{
		var channel_id = $("#channel_id").val();
		if(channel_id == 29){
		$("#Third").show();
		}
		else{
			$("#Third").hide();
		}
			
	});
function show_status(value15)
{
	if(value15 == 2){
		$("#OrderStatus").hide();
	}
	else{
		$("#OrderStatus").show();
	}
}

function MembershipID_validation(MembershipID)
{
		
		var Company_id = '<?php echo $Company_id; ?>';
		
		if( MembershipID != "" )
		{

		$.ajax({
				type:"POST",
				data:{MembershipID:MembershipID, Company_id:Company_id},
				url: "<?php echo base_url()?>index.php/Reportc/MembershipID_validation",
				success : function(data)
				{ 
					// alert(data.length);
					if(data.length == 14)
					{
						$("#Single_cust_membership_id").val("");
						
						has_error(".has-feedback","#glyphicon",".help-block","Membership ID not Exist.!!");
					}
					else
					{
						has_success(".has-feedback","#glyphicon",".help-block",data);
					}
				}
			});
		}
}
	
function toggleRptType(ch)
{
	if(ch == 2)
	{
		$("#channelgroup").hide();
	}
	else{
		
		$("#channelgroup").show();
	
	}
}

	$('#seller_id').change(function()
	{
		var seller_id = $("#seller_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		
		$.ajax({
			type:"POST",
			data:{seller_id:seller_id,Company_id:Company_id},
			url:'<?php echo base_url()?>index.php/Reportc/get_outlet_by_subadmin',
			success:function(opData4){
				$('#Outlet_id').html(opData4);
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
/******calender *********/

</script>
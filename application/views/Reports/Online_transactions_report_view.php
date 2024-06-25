<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Customer_Order_Transactions_Report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Member Orders Report</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							<?php
								if($Super_seller == 1)
								{
							?>
								<div class="form-group">
								<label for=""> <span class="required_info">* </span>Business/Merchant </label>
								<select class="form-control" name="brand_id" id="brand_id" required data-error="Please select brand">
									<option value="">Select Business/Merchant</option>
									<?php
											echo '<option value="0">All Brands</option>';
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
								<label for=""> <span class="required_info">* </span>Outlet </label>
								<select class="form-control" name="Outlet_id[]" id="Outlet_id" required data-error="Please select outlet name" multiple>

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
								<label for=""> <span class="required_info">* </span>Outlet </label>
								<select class="form-control" name="Outlet_id[]" id="Outlet_id" required data-error="Please select outlet name" multiple>
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
							
								<div class="form-group" id="OrderStatus">
								<label for="exampleInputEmail1"><span class="required_info">*</span> Order Status</label>
									<select class="form-control" name="Voucher_status" id="Voucher_status">
										<option value="0">All</option>
										<option value="18">Ordered</option>
										<!--<option value="19">Shipped</option>-->
										<option value="20">Delivered/Collected</option>
										<!--<option value="21">Cancel</option>-->				
									</select>									
								</div>
								
							
								<div class="form-group">
									<label for="exampleInputEmail1"> Transaction from </label>		
										<label class="radio-inline">
										&nbsp;&nbsp;<input type="radio" onclick="show_status(this.value);" name="transaction_from" value="0" checked >&nbsp;All							
									</label>						
									<label class="radio-inline">							
										<input type="radio"  onclick="show_status(this.value);" name="transaction_from"  value="2" >&nbsp;POS
									</label>
									<label class="radio-inline">							
										<input type="radio" onclick="show_status(this.value);"  name="transaction_from"  value="12" >&nbsp;Online
									</label>
									<label class="radio-inline">							
										<input type="radio" onclick="show_status(this.value);"  name="transaction_from"  value="29" >&nbsp;3rd Party Online
									</label>
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
									<label for="exampleInputEmail1"><span class="required_info">*</span> Report Type </label>
									<select class="form-control" name="report_type" ID="report_type" required>
										<option value="1">Details</option>
										<option value="2">Summary</option>
									</select>							
								</div>
								
								<div class="form-group has-feedback">
					
									<label for="exampleInputEmail1">Membership ID</label>
									<input type="text" id="Single_cust_membership_id"   name="membership_id" class="form-control" placeholder="Enter Membership ID"   onblur="MembershipID_validation(this.value);"/>

									<input type="hidden" name="Company_id" class="form-control" value="<?php echo $Company_details->Company_id; ?>"/>							
									<span class="glyphicon" id="glyphicon" aria-hidden="true"></span>
									<div class="help-block"></div>
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
	$report_type=$_REQUEST["report_type"];
	$To_date=date("Y-m-d",strtotime($_REQUEST["end_date"]));
	$From_date=date("Y-m-d",strtotime($_REQUEST["start_date"]));
	?>
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					<?php if($report_type==1){ echo 'Member Order Report details'; }
							else{echo 'Member Order Report Summary'; }
					?>
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>

								<?php if($report_type==1){ //Details?>
								<tr>
								<th>Membership ID</th>
								<th>Member Name</th>
								<th>Outlet Name</th>
								<th>Order Date</th>
								<th>POS Bill No</th>
								
								<th>Trans Type</th>
								<th>Menu Name</th>
								<th>Category</th>
								<th>Qty</th>
								<!--<th>Condiments</th>-->
								<th>Purchase Amount <?php echo '('.$Symbol_of_currency.')'; ?></th>

								</tr>
								<?php } else { //Summary?>
								<tr>
								<th>Membership ID</th>
								<th>Member Name</th>
								<th>Outlet Name</th>
								
								<th>Order Date</th>
								<th>Online Order No</th>
								<th>POS Bill No</th>
								<th>Trans Type</th>
								<th>Total Purchase Amount <?php echo '('.$Symbol_of_currency.')';?></th>
								<th>Total Gained <?php echo $Company_details->Currency_name; ?></th>
								<th>Redeemed <?php echo $Company_details->Currency_name; ?></th>
							

								</tr>
								<?php } ?>
							</thead>						
							<tfoot>
								
								<?php if($report_type==1){ //Details?>
								<tr>
								<th>Membership ID</th>
								<th>Member Name</th>
								<th>Outlet Name</th>
								<th>Order Date</th>
								<th>POS Bill No</th>
								
								<th>Trans Type</th>
								<th>Menu Name</th>
								<th>Category</th>
								<th>Qty</th>
								<!--<th>Condiments</th>-->
								<th>Purchase Amount <?php echo '('.$Symbol_of_currency.')'; ?></th>


								</tr>
								<?php } else { //Summary?>
								<tr>
								<th>Membership ID</th>
								<th>Member Name</th>
								<th>Outlet Name</th>
								
								<th>Order Date</th>
								<th>Online Order No</th>
								<th>POS Bill No</th>
								<th>Trans Type</th>
								<th>Total Purchase Amount <?php echo '('.$Symbol_of_currency.')';?></th>
								<th>Total Gained <?php echo $Company_details->Currency_name; ?></th>
								<th>Redeemed <?php echo $Company_details->Currency_name; ?></th>
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
									
								if($row->Trans_type == 12)
								{
									$TransType = "Online";
								}
								
								if($row->Trans_type == 2)
								{
									$TransType = "POS";
								}
								
								if($row->Trans_type == 29)
								{
									$Channel_name = $ci_object->Report_model->Get_beneficiary_company($row->Channel_id);
									$TransType = $Channel_name->Beneficiary_company_name;
								}
								
								if($row->Quantity == 0)
								{
									$row->Quantity = "-";
									$row->Menu_name = "-";
								}
								
							
								
								if($report_type==1)//Details
								{
	
									echo "<tr>";
									echo "<td>".$Card_id."</td>";
									echo "<td>".$Member_name."</td>"; 
									echo "<td>".$row->Outlet."</td>";

									echo "<td>".$row->Order_date."</td>";
									// echo "<td>".$row->Order_no."</td>";
									echo "<td>".$row->Pos_billno."</td>";
									
									echo "<td>".$TransType."</td>";

									//echo "<td>".$row->Outlet."</td>";
									echo "<td>".$row->Menu_name."</td>";
									echo "<td>".$row->Category."</td>";
									echo "<td>".$row->Quantity."</td>";
									//echo "<td>".$condiments."</td>";
										echo "<td>".number_format(round($row->Purchase_amount),2)."</td>";
									
									// echo "<td style='color:$color;'>".$VoucherStatus."</td>";
	
									echo "</tr>";
								}
								else
								{
									echo "<tr>";
									echo "<td>".$Card_id."</td>";
									echo "<td>".$Member_name."</td>";
									echo "<td>".$row->Outlet."</td>";
									echo "<td>".$row->Order_date."</td>";
									echo "<td>".$row->Order_no."</td>";
									echo "<td>".$row->Pos_billno."</td>";
									echo "<td>".$TransType."</td>";
									
									echo "<td>".number_format(round($row->Total_purchase_amount),2)."</td>";
									echo "<td>".round($row->Total_gained_pts)."</td>";
									echo "<td>".round($row->Redeemed_points)."</td>";
									
									
									//echo "<td>".number_format(round($row->Total_shipping_cost),2)."</td>";
					// loyalty		echo "<td>".number_format(round($row->Total_redeem_amount),2)."</td>";
									// echo "<td>".$row->Mpesa_TransID."</td>";
									// echo "<td>".number_format(round($row->Total_mpesa_amount),2)."</td>";
									//echo "<td>".number_format(round($row->Total_cash_amount),2)."</td>";
									// echo "<td>".number_format(round($row->Total_paid_amount),2)."</td>";
					// loyalty		echo "<td>".round($row->Total_gained_pts)."</td>";
									// echo "<td style='color:$color;'>".$VoucherStatus."</td>";
	
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
							<a href="<?php echo base_url()?>index.php/Reportc/Customer_Order_Transactions_Report/?report_type=<?php echo $report_type; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&membership_id=<?php echo $membership_id; ?>&transaction_from=<?php echo $transaction_from; ?>&Voucher_status=<?php echo $Voucher_status; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/Customer_Order_Transactions_Report/?report_type=<?php echo $report_type; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&membership_id=<?php echo $membership_id; ?>&transaction_from=<?php echo $transaction_from; ?>&Voucher_status=<?php echo $Voucher_status; ?>&pdf_excel_flag=2">
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
	 if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "" && $('#Outlet_id').val() != "" && $('#report_type').val() != "" )
		{
			show_loader();
		} 

});

//***** 23-09-2019 sandeep ********
function show_status(value15)
{
	if(value15 == 2){
		$("#OrderStatus").hide();
		$("#Third").hide();
	}
	else if(value15 == 29){
		$("#Third").show();
	}
	else{
		$("#Third").hide();
		$("#OrderStatus").show();
	}
}
//***** 23-09-2019 sandeep ********
function pagination_item(limit)
{	
	show_loader();
	limit=(limit*10);
						  
	var Company_id='<?php echo $Company_id; ?>';
	var start_date='<?php echo $start_date; ?>';
	var end_date='<?php echo $end_date; ?>';
	var Outlet_id='<?php echo $Outlet_id; ?>';
	var report_type='<?php echo $report_type; ?>';
	var transaction_type_id='<?php echo $transaction_from; ?>';
	
	var Single_cust_membership_id='<?php echo $membership_id; ?>';
	var Voucher_status='<?php echo $Voucher_status; ?>';

	window.location='Customer_Order_Transactions_Report?page_limit='+limit+'&Company_id='+Company_id+'&start_date='+start_date+'&end_date='+end_date+'&Outlet_id='+Outlet_id+'&report_type='+report_type+'&transaction_from='+transaction_type_id+'&Voucher_status='+Voucher_status+'&membership_id='+Single_cust_membership_id+'&submit';

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
				$('#Outlet_id').html(opData4);
			}
		});
			
	});
//******calender *********/
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
//******calender *********/

</script>

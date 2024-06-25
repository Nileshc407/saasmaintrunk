<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Loyalty_Order_Transactions_Report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Loyalty Report</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							
								<div class="form-group">
								<label for=""><span class="required_info">* </span>Business/Merchant Name</label>
								<select class="form-control" name="seller_id" ID="seller_id" required>
									<option value="">Select Business/Merchant</option>
									<?php
									
									/* for artCafe to link product groups to link sellers **sandeep**13-03-2020***/
									
									//echo $Logged_user_id."-----".$Super_seller;
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
							</div>
							
								<div class="form-group">
									<label for="">Outlet Name</label>
									<select class="form-control"  name="Outlet_id[]" multiple ID="Outlet_id" required>
										<option value="0">Select Business/Merchant First</option>

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
								<label for=""> Channel </label>
								<select class="form-control " name="transaction_from" id="transaction_from" required="required" data-error="Please select source">
									<option value="0">All</option>
									<option value="12">Online</option>
									<option value="2">POS</option>
									<option value="29">3rd Party Online</option>
								</select>
								
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
	<?php 

	$To_date=date("Y-m-d",strtotime($_REQUEST["end_date"]));
	$From_date=date("Y-m-d",strtotime($_REQUEST["start_date"]));
	?>
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					<?php echo 'Loyalty Order Report Summary';
					?>
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>

							
							<tr>
							<th>Outlet</th>
							<th>Channel</th>
							<th>Visits</th>
						<!--	<th>Online Purchase</th>
							<th>Bill Amount Visit</th>
							<th>Bill Amount Online</th> -->
							<th>Total Spend Amt <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Earn Amt <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Redeem Amt <?php echo '('.$Symbol_of_currency.')';?></th>
							
						<!--	<th>Total Discount Amt <?php //echo '('.$Symbol_of_currency.')';?></th> -->
							<th>Voucher Amt <?php echo '('.$Symbol_of_currency.')';?></th>
							<!--<th>Redeem Points</th>-->
							
							<th>Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th>
						<!--	<th>Earn Points</th>-->
							
							
							</tr>

							</thead>						
							<tfoot>
							<tr>
								<th>Outlet</th>
								<th>Channel</th>
								<th>Visits</th>
							<!--	<th>Online Purchase</th>
								<th>Bill Amount Visit</th>
								<th>Bill Amount Online</th> -->
								<th>Total Spend Amt <?php echo '('.$Symbol_of_currency.')';?></th>
								<th>Earn Amt <?php echo '('.$Symbol_of_currency.')';?></th>
								<th>Redeem Amt <?php echo '('.$Symbol_of_currency.')';?></th>
								
							<!--	<th>Total Discount Amt <?php //echo '('.$Symbol_of_currency.')';?></th> -->
								<th>Voucher Amt <?php echo '('.$Symbol_of_currency.')';?></th>
								<!--<th>Redeem Points</th>-->
								
								<th>Paid Amt <?php echo '('.$Symbol_of_currency.')';?></th>
							<!--	<th>Earn Points</th>-->
								
							</tr>
								

							</tfoot>
							<tbody>
						<?php
						$todays = date("Y-m-d");
						  $lv_Company_id = $_REQUEST["Company_id"];
						  $start_date = $_REQUEST["start_date"];
						  $end_date = $_REQUEST["end_date"];
						  $Outlet_id = $_REQUEST["Outlet_id"];
						  $transaction_from = $_REQUEST["transaction_from"];
						  $seller_id = $_REQUEST["seller_id"];
						  $Visits=0;
						  $Bill_amount_visit=0;
						  $Online_purchase=0;
						  $Bill_amount_online=0;
						  
						 $ci_object = &get_instance(); 
						if(count($Trans_Records) > 0)
						{
							foreach($Trans_Records as $row)
							{
								$All_online = array();
								$All_onlineAmt = array();
						 
								if($transaction_from==0 || $transaction_from==2)
								{
									$POS = $ci_object->Report_model->Get_outlet_pos_online_summary($Company_id, $start_date, $end_date, 2,$row->Seller);
									if($POS != NULL)
									{
										foreach($POS as $rec)
										{
											$Visits=$rec->Visits;
											$Bill_amount_visit=$rec->Bill_amount_visit;
										}
									}
									else
									{
										$Visits=0;
										$Bill_amount_visit=0;
									}
								}
								if($transaction_from==0 || $transaction_from==12)
								{
									$ONLINE = $ci_object->Report_model->Get_outlet_pos_online_summary($Company_id, $start_date, $end_date, 12,$row->Seller);
									if($ONLINE != NULL)
									{
										foreach($ONLINE as $rec)
										{
											$Online_purchase=$rec->Online_purchase;
											$Bill_amount_online=$rec->Bill_amount_online;
										}
									}
									else
									{
										$Online_purchase=0;
										$Bill_amount_online=0;
									}
									$All_online[]= $Online_purchase;
									$All_onlineAmt[]= $Bill_amount_online;
								}
								if($transaction_from==0 || $transaction_from==29)
								{
									$ONLINE = $ci_object->Report_model->Get_outlet_pos_online_summary($Company_id, $start_date, $end_date, 29,$row->Seller);
									if($ONLINE != NULL)
									{
										foreach($ONLINE as $rec)
										{
											$Online_purchase=$rec->Online_purchase;
											$Bill_amount_online=$rec->Bill_amount_online;
										}
										$row->Total_spend = $Bill_amount_online;
									}
									else
									{
										$Online_purchase=0;
										$Bill_amount_online=0;
									}
									$All_online[]= $Online_purchase;
									$All_onlineAmt[]= $Bill_amount_online;
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
								if($transaction_from==0 )
								{
									$TransType = "All";
									$row->Total_spend = array_sum($All_onlineAmt) + $Bill_amount_visit;
								}
								echo "<tr>";
								echo "<td>".$row->Outlet."</td>";
								echo "<td>".$TransType."</td>";
								echo "<td>".$Visits."</td>";
								//echo "<td>".$Online_purchase."</td>";
								//echo "<td>".number_format(round($Bill_amount_visit),2)."</td>";
								// echo "<td>".number_format(round($row->Bill_amount_visit),2)."</td>";
								// echo "<td>".number_format(round($row->Bill_amount_online),2)."</td>";
								//echo "<td>".number_format(round($Bill_amount_online),2)."</td>";
								echo "<td>".number_format(round($row->Total_spend),2)."</td>";
								echo "<td>".number_format(round($row->Earned_amt),2)."</td>";
								echo "<td>".number_format(round($row->Redeem_amount),2)."</td>";
								//echo "<td>".number_format(round($row->Total_discount_amount),2)."</td>";
								echo "<td>".number_format(round($row->Voucher_amount),2)."</td>";
								//echo "<td>".round($row->Redeem_points)."</td>";
								
								echo "<td>".number_format(round($row->Paid_amount),2)."</td>";
								// echo "<td>".round($row->Earn_points)."</td>";
								
								echo "</tr>";
								
							}
						}
						?>
							</tbody>
						</table>
						<?php 
						if($Trans_Records != NULL)
						{ 
						
						?>
							<a href="<?php echo base_url()?>index.php/Reportc/Loyalty_Order_Transactions_Report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&Outlet_id=<?php echo $Outlet_id; ?>&transaction_from=<?php echo $transaction_from; ?>&seller_id=<?php echo $seller_id; ?>&Channel_id=<?php echo $Channel_id; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/Loyalty_Order_Transactions_Report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&Outlet_id=<?php echo $Outlet_id; ?>&transaction_from=<?php echo $transaction_from; ?>&seller_id=<?php echo $seller_id; ?>&Channel_id=<?php echo $Channel_id; ?>&pdf_excel_flag=2">
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
	 if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "" && $('#report_type').val() != "" && $('#Outlet_id').val() != ""  && $('#seller_id').val() != "" )
		{
			show_loader();
		} 

});

$('#transaction_from').change(function()
	{
		var transaction_from = $("#transaction_from").val();
		if(transaction_from == 29){
		$("#Third").show();
		}
		else{
			$("#Third").hide();
		}
			
	});
	
	
$(document).ready(function() {
	  var oTable = $('#dataTable1').dataTable();
 
	   // Sort immediately with columns 0 and 1
	   oTable.fnSort( [ [6,'desc'] ] );
	 } );
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
//***** 23-09-2019 sandeep ********

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

<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Member_stamp_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Member Stamp Report</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							
								<div class="form-group">
								<label for=""><span class="required_info">* </span>Business/Merchant Name</label>
								<select class="form-control" name="seller_id" ID="seller_id" required>
									<option value="">Select Business/Merchant</option>
									<?php
									
									echo '<option value="0">All Brands</option>';
									//echo $Logged_user_id."-----".$Super_seller;
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
									<label for="">Voucher Used at Outlet</label>
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
								<label for=""> Status </label>
								<select class="form-control " name="Status" id="Status" required="required" data-error="Please select source">
									<option value="0">Both</option>
									<option value="1">Issued</option>
									<option value="2">Used</option>

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
					<?php echo 'Member Stamp Report';
					?>
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>

							
							<tr>
							<th>Member Name</th>
							<th>Voucher No.</th>
							<th>Issued Outlet</th>
							<th>Issued Date</th>
							<th>Valid Till</th>
							<th>Free Item Name</th>
							<th>Issued Qty</th>
							<th>Value <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Status</th>
							<th>Used Outlet</th>
							<th>Used Date</th>
							</tr>

							</thead>						
							<tfoot>
								<tr>
							<th>Member Name</th>
							<th>Voucher No.</th>
							<th>Issued Outlet</th>
							<th>Issued Date</th>
							<th>Valid Till</th>
							<th>Free Item Name</th>
							<th>Issued Qty</th>
							<th>Value <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Status</th>
							<th>Used Outlet</th>
							<th>Used Date</th>
							</tr>
								

							</tfoot>
							<tbody>
						<?php
						$todays = date("Y-m-d");
					
						  
						 $ci_object = &get_instance(); 
						if(count($Trans_Records) > 0)
						{
							foreach($Trans_Records as $row)
							{
								
								
								echo "<tr>";
								echo "<td>".$row->Issued_to."</td>";
								echo "<td>".$row->Voucher_no."</td>";
								echo "<td>".$row->Issud_Outlet."</td>";

								echo "<td>".date('Y-m-d',strtotime($row->Issued_on))."</td>";
								echo "<td>".date('Y-m-d',strtotime($row->Valid_till))."</td>";
								echo "<td>".$row->Item_name."</td>";
								echo "<td>".$row->Quantity."</td>";
								echo "<td>".number_format(round($row->Cost_price),2)."</td>";
								echo "<td>".$row->Status."</td>";
								
								echo "<td>".$row->Used_Outlet."</td>";
								echo "<td>".$row->Used_date."</td>";

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
							<a href="<?php echo base_url()?>index.php/Reportc/Member_stamp_report/?pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/Member_stamp_report/?pdf_excel_flag=2">
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
/* $(document).ready(function() {
	  var oTable = $('#dataTable1').dataTable();
 
	   // Sort immediately with columns 0 and 1
	   oTable.fnSort( [ [6,'desc'] ] );
	 } ); */
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
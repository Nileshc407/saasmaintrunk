<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Voucher_report_summary',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Member Voucher Summary Report </h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							
								
							<div class="form-group">
							   <label for=""><span class="required_info">* </span>From Date </label>
								<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1"  required="required" data-error="Please select from date"/>
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
							   <label for=""><span class="required_info">* </span>Till Date </label>
								<input class="single-daterange form-control" placeholder="End Date" type="text"  name="end_date" id="datepicker2" required="required" data-error="Please select till date"/>
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
	<?php 

	$To_date=date("Y-m-d",strtotime($_REQUEST["end_date"]));
	$From_date=date("Y-m-d",strtotime($_REQUEST["start_date"]));
	?>
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					<?php echo 'Member Voucher Summary Records';
					?>
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>

							
							<tr>
							<th>Issued To</th>
							<th>No. of Vouchers Issued</th>
							<th>No. of Vouchers Used</th>
							<th>No. of Value Vouchers Issued</th>
							<th>Value of Vouchers Used <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Value of Available <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>No. of % Vouchers Issued</th>
							<th>Total % Vouchers Used</th>
							<th>Total % Vouchers Unused</th>
							</tr>

							</thead>						
							<tfoot>
								<tr>
							<th>Issued To</th>
							<th>No. of Vouchers Issued</th>
							<th>No. of Vouchers Used</th>
							<th>No. of Value Vouchers Issued</th>
							<th>Value of Vouchers Used <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Value of Available <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>No. of % Vouchers Issued</th>
							<th>Total % Vouchers Used</th>
							<th>Total % Vouchers Unused</th>
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
								echo "<td>".$row->Total_Issued_vouchers."</td>";
								echo "<td>".$row->Total_Used_vouchers."</td>";
								echo "<td>".$row->Total_Issued_Value_Vouchers."</td>";
								echo "<td>".number_format(round($row->Used_Value_Vouchers),2)."</td>";
								echo "<td>".number_format(round($row->Available_Value_Vouchers),2)."</td>";
								echo "<td>".$row->Total_Issued_Percenatage_Vouchers."</td>";
								echo "<td>".$row->Used_Percentage_Vouchers."</td>";
								echo "<td>".$row->Unused_Percentage_Vouchers."</td>";

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
							<a href="<?php echo base_url()?>index.php/Reportc/Voucher_report_summary/?pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/Voucher_report_summary/?pdf_excel_flag=2">
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
	 if($('#datepicker2').val() != ""  && $('#datepicker1').val() != ""  )
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
t>

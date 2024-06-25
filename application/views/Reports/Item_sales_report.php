<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Item_sales_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Items Sales Report</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							
								<div class="form-group">
								<label for="">Business/Merchant Name</label>
								<select class="form-control" name="brand_id" ID="brand_id" required>
									<option value="">Select Business/Merchant</option>
									<?php
									
										
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
								<select class="form-control" name="seller_id[]" ID="seller_id">
									<option value="0">All Outlets</option>

								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
					  
							  <!--<div class="form-group" id="if_store_report">
								<label for=""> Business/Merchant </label>
								<select class="form-control" multiple name="seller_id[]" id="seller_id" required="required" data-error="Please select merchant name">

								
									<?php
									/*if($Logged_user_id > 2 || $Super_seller == 1)
									{
										
									
										foreach($company_sellers as $sellers)
										{
											if($sellers['Sub_seller_Enrollement_id'] == $enroll || $sellers['Sub_seller_Enrollement_id'] == 0)
											{
										?>
											<option value="<?php echo $sellers['Enrollement_id'] ?>"><?php echo $sellers['First_name']." ".$sellers['Last_name']; ?></option>
										<?php
											}
										}
									}*/
									?>
								</select>
								
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							-->	
							
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
								<label for=""> Channel </label>
								<select class="form-control " name="channel" id="channel_id" required="required" data-error="Please select source">
									<option value="0">All</option>
									<option value="12">Online</option>
									<option value="2">POS</option>
									<option value="29">3rd Party Online</option>
				
								</select>
								
								<div class="help-block form-text with-errors form-control-feedback"></div>
							</div>
							<div class="form-group" id="Third" style="display:none;">
								<label for=""> <span class="required_info">* </span>Channel Company </label>
								<select class="form-control" name="Bene_Channel_id[]" id="Bene_Channel_id" multiple>
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
					  Item Sales Details
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>

								<tr>
									<th>Item Code</th>
									<th>Item Name</th>
									<th>Category</th>
									<th>Qty Sold </th>
									
									<th>Value Sold <?php echo "($Symbol_currency)"; ?></th>
									
								<!--	<th>Total Redeemed  <?php //echo $Company_details->Currency_name; ?></th>-->
								<!--	<th>Total Gained  <?php //echo $Company_details->Currency_name; ?></th>-->
									<th>Business/Merchant</th>					   
									<th>Channel</th>					   
								</tr>
							</thead>						
							<tfoot>
								
								<tr>
									<th>Item Code</th>
									<th>Item Name</th>
									<th>Category</th>
									<th>Qty Sold </th>
									
									<th>Value Sold <?php echo "($Symbol_currency)"; ?></th>
									
								<!--	<th>Total Redeemed  <?php //echo $Company_details->Currency_name; ?></th>-->
								<!--	<th>Total Gained  <?php //echo $Company_details->Currency_name; ?></th>-->
									<th>Business/Merchant</th>	
									<th>Channel</th>	
														   
								</tr>

							</tfoot>
							<tbody>
					<?php
					$ci_object = &get_instance(); 
					if(isset($_REQUEST["submit"]) && ($Trans_Records != NULL))
					{ 
							if($Trans_Records != NULL)
							{
		
								foreach($Trans_Records as $row)
								{
									if($row->Channel == 12)
									{
										$TransChannel = "Online";
									}
									
									if($row->Channel == 2)
									{
										$TransChannel = "POS";
									}
									
									if($row->Channel == 29)
									{
										$Channel_name = $ci_object->Report_model->Get_beneficiary_company($row->Channel_id);
										$TransChannel = $Channel_name->Beneficiary_company_name;
									}
									
									
									?>
												<tr>
													<td><?php echo $row->Item_code;?></td>
													<td><?php echo $row->Item_name;?></td>
													<td><?php echo $row->Category;?></td>
													<td><?php echo $row->Qty_sold;?></td>
													<td><?php echo number_format(round($row->Value_sold),2); ?> </td>
													
													<!--<td><?php //echo ceil($row->TotalRedeemPoints);?></td>
													<td><?php //echo round($row->TotalLoyaltyPoints);?></td>-->
													<td><?php echo $brand_name;?></td>
													
													<td><?php echo $TransChannel;?></td>
												</tr>
								<?php		
								}
										
								
							}
					}
				?>
							</tbody>
						</table>
				<?php if($Trans_Records != NULL)
						{
					?>
							<a href="<?php echo base_url()?>index.php/Reportc/Item_sales_report/?Company_id=<?php echo $Company_id; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&channel=<?php echo $channel; ?>&brand_id=<?php echo $brand_id; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/Item_sales_report/?Company_id=<?php echo $Company_id; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&channel=<?php echo $channel; ?>&brand_id=<?php echo $brand_id; ?>&pdf_excel_flag=2">
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

	 if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "" && $('#brand_id').val() != "")
		{
			
			show_loader();
			
		} 

});
	
	$('#channel_id').change(function()
	{
		var channell = $("#channel_id").val();
		if(channell == 29){
		$("#Third").show();
		}
		else{
			$("#Third").hide();
		}
			
	});
	$('#brand_id').change(function()
	{
		var brand_id = $("#brand_id").val();
		var Company_id = '<?php echo $Company_id; ?>';
		
		
		$.ajax({
			type:"POST",
			data:{seller_id:brand_id,Company_id:Company_id},
			url:'<?php echo base_url()?>index.php/Reportc/get_outlet_by_subadmin',
			success:function(opData4){
				$('#seller_id').html(opData4);
			}
		});
			
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

$(document).ready(function() {
	  var oTable = $('#dataTable1').dataTable();
 
	   // Sort immediately with columns 0 and 1
	   oTable.fnSort( [ [3,'desc'] ] );
	 } );
		 
</script>
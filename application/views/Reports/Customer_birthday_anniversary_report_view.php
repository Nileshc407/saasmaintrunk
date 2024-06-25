<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Customer_birthday_anniversary_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">MEMBER Birthday & Anniversary REPORT</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							
								<div class="form-group">
							   <label for=""><span class="required_info">* </span>From Date</label>
								<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1"  required="required" data-error="Please select from date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
						
							    <div class="form-check ml-2" style="float:left;">
										<label class="form-check-label"><input class="form-check-input" name="Birth_anni_flag"  type="radio" value="Birthday" checked >Birthday</label>
								 </div>
							    <div class="form-check ml-2" style="float:left;">
										<label class="form-check-label"><input class="form-check-input" name="Birth_anni_flag"  type="radio" value="Anniversary"  >Anniversary</label>
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
		
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					  Member Details
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>

								<tr>
									<th>Membership ID</th>
									<th>Member Name</th>
									<th>Birth Date</th>
									<th>Anniversary Date</th>
									<th>Joined Date</th>
									<th>Total Purchase Amount <?php echo "($Symbol_currency)"; ?></th>
									<th>Total Paid Amount <?php echo "($Symbol_currency)"; ?></th>
									<th>Total Gained  <?php echo $Company_details->Currency_name; ?></th>
									<th>Total Redeemed  <?php echo $Company_details->Currency_name; ?></th>
							
								</tr>
							</thead>						
							<tfoot>
								
								<tr>
									<th>Membership ID</th>
									<th>Member Name</th>
									<th>Birth Date</th>
									<th>Anniversary Date</th>
									<th>Joined Date</th>
									<th>Total Purchase Amount <?php echo "($Symbol_currency)"; ?></th>
									<th>Total Paid Amount <?php echo "($Symbol_currency)"; ?></th>
									<th>Total Gained  <?php echo $Company_details->Currency_name; ?></th>
									<th>Total Redeemed  <?php echo $Company_details->Currency_name; ?></th>
								</tr>

							</tfoot>
							<tbody>
					<?php
				
					if(isset($_REQUEST["submit"]) && ($Trans_Records != NULL))
					{ 
					
						
				
						
							if($Trans_Records != NULL)
							{
								
								$ci_object = &get_instance(); 

								foreach($Trans_Records as $row)
								{
									$Full_name=$row->First_name." ".$row->Last_name;
									$Membership_ID=$row->Membership_ID;
									
									?>
												<tr>
												<td><?php echo $row->Membership_ID;?></td>
												<td><?php echo $Full_name;?></td>
													<td><?php echo date('d M Y',strtotime($row->Date_of_birth));?></td>
													<td><?php echo date('d M Y',strtotime($row->Anniversary_date));?></td>
													<td><?php echo date('d M Y',strtotime($row->joined_date));?></td>
													
													<td><?php echo $row->Total_Purchase_Amount;?></td>
													<td><?php echo $row->Total_Paid_Amount;?></td>
													<td><?php echo $row->Total_Gained_Points;?></td>
													
													<td><?php echo $row->Total_Redeemed_Points;?></td>


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
							<a href="<?php echo base_url()?>index.php/Reportc/Customer_birthday_anniversary_report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/Customer_birthday_anniversary_report/?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&pdf_excel_flag=2">
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

	 if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "" && $('#Source').val() != "")
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

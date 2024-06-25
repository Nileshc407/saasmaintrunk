<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Yearly_loyalty_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">Yearly Loyalty Report</h6>  
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
					  
								
								
							</div>
							<div class="col-sm-6">

								<div class="form-group">
								<label for="exampleInputEmail1"><span class="required_info">*</span>Year</label>
								<select class="form-control" name="Year" ID="Year" >
								<?php
								if($Trans_year != NULL)
								{
									foreach($Trans_year as $Trans_year)
									{
										echo "<option value='".$Trans_year->TransYear."'>".$Trans_year->TransYear."</option>";
									}
								}
									/* $Current_Year =date('Y');
									$From_year = $Current_Year-10;
									echo "<option value='$Current_Year'>$Current_Year</option>";
									for($i=$From_year;$i<$Current_Year;$i++)
									{
										echo "<option value='$i'>$i</option>";
									} */
								?>
									
									
								</select>							
								</div>
							
									<div class="form-group" id="Select_tier">
										<label for=""> Select Tier</label>
										<select class="form-control" name="member_tier_id" id="member_tier_id">
										
										  <?php
											echo "<option value='0'>All Tiers</option>";
											foreach($Tier_list as $Tier)
											{
												echo '<option value="'.$Tier->Tier_id.'">'.$Tier->Tier_name.'</option>';
											}
											?>
										</select>
									</div>	
								
							</div>
							<!--
							<div class="form-group">
								
								<label class="radio-inline">&nbsp;&nbsp;
									<input type="radio"  name="select_cust" id="select_cust" onclick="toggel_cust(this.value)" value="1" checked >&nbsp;Earned	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="radio"   name="select_cust" id="select_cust" onclick="toggel_cust(this.value)" value="2" >&nbsp;Redeemed
								</label>
							</div>-->
						</div>
					  <div class="form-buttons-w" align="center">
					  <input type="hidden" id="Brand_name" name="Brand_name" value="0">
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
					 <h6 class="form-header">Yearly loyalty Report details</h6>
					
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
							<tr>
							<th>Year</th>
							<th>Month</th>
							<th>Business/Merchant</th>
							<th>Outlet</th>
							<th>Tier</th>
							<th>Earned <?php echo $Company_details->Currency_name; ?></th>
							<th>Earned <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Redeemed <?php echo $Company_details->Currency_name; ?></th>
							<th>Redeemed <?php echo '('.$Symbol_of_currency.')';?></th>
							
						</tr>
								</thead>
								<tfoot>
								
								<tr>
							<th>Year</th>
							<th>Month</th>
							<th>Business/Merchant</th>
							<th>Outlet</th>
							<th>Tier</th>
							<th>Earned <?php echo $Company_details->Currency_name; ?></th>
							<th>Earned <?php echo '('.$Symbol_of_currency.')';?></th>
							<th>Redeemed <?php echo $Company_details->Currency_name; ?></th>
							<th>Redeemed <?php echo '('.$Symbol_of_currency.')';?></th>
						</tr>
							
								</tfoot>
							<tbody>
						<?php
						$todays = date("Y-m-d");
						 $Outlet_id = $_REQUEST["Outlet_id"];
						$seller_id = $_REQUEST["seller_id"];
						$Year = $_REQUEST["Year"];
						$Tier = $_REQUEST["member_tier_id"];
						$Brand_name = $_REQUEST["Brand_name"];
						$seller_id = $_REQUEST["seller_id"];
						  
						if(count($Trans_Records) > 0)
						{
							// if($seller_id=='0'){$Brand_name='All';}
							foreach($Trans_Records as $row)
							{
									echo "<tr>";
									echo "<td>".$row->TransYear."</td>";
									echo "<td>".$row->TransMONTH."</td>";
									echo "<td>".$row->Business/Merchant."</td>";
									echo "<td>".$row->Outlet."</td>";
									echo "<td>".$row->Tier_name."</td>";
									echo "<td>".round($row->Earned_pts)."</td>";
									echo "<td>".number_format(round($row->Earned_amt),2)."</td>";
									echo "<td>".round($row->Redeemed_pts)."</td>";
									echo "<td>".number_format(round($row->Redeem_amount),2)."</td>";
									
							}
						}
						?>
						
							</tbody>
						</table>
				<?php 
					if($Trans_Records != NULL)
						{ 
						
						?>
							<a href="<?php echo base_url()?>index.php/Reportc/Yearly_loyalty_report/?Outlet_id=<?php echo $Outlet_id; ?>&seller_id=<?php echo $seller_id; ?>&Year=<?php echo $Year; ?>&Tier=<?php echo $Tier; ?>&Brand_name=<?php echo $Brand_name; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/Yearly_loyalty_report/?seller_id=<?php echo $seller_id; ?>&Year=<?php echo $Year; ?>&Tier=<?php echo $Tier; ?>&Brand_name=<?php echo $Brand_name; ?>&pdf_excel_flag=2">
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
		if(seller_id > 0)
		{
			var Brand_name = $( "#seller_id option:selected" ).text();
			$('#Brand_name').val(Brand_name);
		}
		else
		{
			$('#Brand_name').val(0);
		}
		
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
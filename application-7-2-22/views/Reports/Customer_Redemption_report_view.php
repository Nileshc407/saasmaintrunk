<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Reportc/Customer_Redemption_Report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">MEMBER CATALOGUE REPORT</h6>  
					<div class="element-box">
						<div class="row">
							<div class="col-sm-6">	
							
								<div class="form-group">
								<label for=""> <span class="required_info">* </span>Company Name </label>
								<select class="form-control " name="Company_id"  required="required">

								 <option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
								</select>
								</div>
						
							   <div class="form-group">
								<label for=""> <span class="required_info">* </span>Transaction Type </label>
								<select class="form-control " name="transaction_type_id" id="transaction_type_id" required="required">
								<option value="0">All</option>
								 <?php
									unset($transaction_types[4]);
									unset($transaction_types[5]);
									
									foreach($transaction_types as $transaction)
									{
										if($transaction->Trans_type_id ==10 || $transaction->Trans_type_id ==12 || $transaction->Trans_type_id ==17 || $transaction->Trans_type_id ==20 || $transaction->Trans_type_id ==22)
										{
								?>
										<option value="<?php echo $transaction->Trans_type_id; ?>"><?php echo $transaction->Trans_type; ?></option>
								<?php
										}
									}
								?>
								</select>
								</div>
								
								<div class="form-group">
									<label for="exampleInputEmail1"> Select Member </label>		
									<label class="radio-inline">
										<input type="radio"  name="select_cust" id="select_cust" onclick="toggel_cust(this.value)" value="1" checked >All Members		
										<input type="radio"   name="select_cust" id="select_cust" onclick="toggel_cust(this.value)" value="2" >Single Member
									</label>
								</div>
								
								<div class="form-group" style="display:none;" id="cust_block">
								<label for=""><span class="required_info">*</span> Membership ID </label>
								<input type="text" id="Single_cust_membership_id" name="Single_cust_membership_id" class="form-control" placeholder="Enter Membership ID" onblur="MembershipID_validation(this.value);" data-error="Please enter membership id" />									
								<div class="help-block form-text with-errors form-control-feedback" id="memberErr"></div>
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
									<label for=""><span class="required_info">* </span>Report Type </label>
									<select class="form-control" name="report_type" id="report_type" required="required" data-error="Please select detail/summary">
										<option value="1">Details</option>
										<option value="2">Summary</option>
									</select>
									<div class="help-block form-text with-errors form-control-feedback"></div>
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
									<label for=""><span class="required_info">* </span>Select Delivery Method  </label>
									<select class="form-control" name="Delivery_method" id="Delivery_method">
										<option value="0">Both</option>
										<option value="28">In-Person</option>
										<option value="29">Delivery</option>	
									</select>
								</div>
								
								<div class="form-group">
									<label for=""><span class="required_info">* </span>Select Voucher Status</label>
									<select class="form-control" name="Voucher_status" id="Voucher_status">
										<option value="0">All Status</option>
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
	$report_type=$_REQUEST["report_type"];
	?>
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					<?php if($report_type==1){ echo 'Member Catalogue Report details'; }
							else{echo 'Member Catalogue Report Summary'; }
					?>
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>

								<?php if($report_type==1){ //Details?>
								<tr>
								<th>Transaction Date</th>
								<th>Trans Type</th>
								<th>Membership ID</th>	
								<th>Item Name</th>
								<th>Purchase Amount <?php echo '('.$Symbol_of_currency.')'; ?></th>
								<th>Total Redeemed <?php echo $Company_details->Currency_name; ?></th>
								<th>Voucher Status</th>
								<th>Voucher No.</th>

								</tr>
								<?php } else { //Summary?>
								<tr>
									<th>Month</th>
									<th>partner Name</th>
									<th>Partner Branch</th>
									<th>Voucher Status</th>
									<th>Total Quantity</th>
									<th>Total Purchase Amount <?php echo '('.$Symbol_of_currency.')';?></th>
									<th>Total Redeemed <?php echo $Company_details->Currency_name; ?></th>	
								</tr>
								<?php } ?>
							</thead>						
							<tfoot>
								
								<?php if($report_type==1){ //Details?>
								<tr>
								<th>Transaction Date</th>
								<th>Trans Type</th>
								<th>Membership ID</th>	
								<th>Item Name</th>
								<th>Purchase Amount <?php echo '('.$Symbol_of_currency.')'; ?></th>
								<th>Total Redeemed <?php echo $Company_details->Currency_name; ?></th>
								<th>Voucher Status</th>
								<th>Voucher No.</th>

								</tr>
								<?php } else { //Summary?>
								<tr>
									<th>Month</th>
									<th>partner Name</th>
									<th>Partner Branch</th>
									<th>Voucher Status</th>
									<th>Total Quantity</th>
									<th>Total Purchase Amount <?php echo '('.$Symbol_of_currency.')';?></th>
									<th>Total Redeemed <?php echo $Company_details->Currency_name; ?></th>	
								</tr>
								<?php } ?>

							</tfoot>
							<tbody>
						<?php
							
						if(isset($_REQUEST["submit"]) && ($Trans_Records != NULL))
						{ 	
							$report_type=$_REQUEST["report_type"];
							$Segment_code=$_REQUEST["Segment_code"];
							$todays = date("Y-m-d");
							$start_date=$_REQUEST["start_date"];
							$end_date=$_REQUEST["end_date"];
							$select_cust=$_REQUEST["select_cust"];
							$report_type=$_REQUEST["report_type"];
							$transaction_type_id=$_REQUEST["transaction_type_id"];
							$Delivery_method = $_REQUEST["Delivery_method"];
							$Voucher_status=$_REQUEST["Voucher_status"];
							if($select_cust==2)//Single Customer
							{
								$Single_cust_membership_id=$_REQUEST["Single_cust_membership_id"];
							}
							else
							{
								$Single_cust_membership_id=0;
							}
						
							if($Trans_Records != NULL)
							{
								//print_r($Trans_Records);die;
								
								//$From_date=$_REQUEST["start_date"];
								//echo '<table  class="table table-bordered table-hover">';
								$lv_Enrollement_id=0;
								
								foreach($Trans_Records as $row)
								{
									$Member_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
									$Card_id=$row->Card_id;
									$Enrollement_id=$row->Enrollement_id;
									
									/*if($lv_Enrollement_id!=$Enrollement_id)
									{
										echo "<tr class='success'><td colspan='13'>".$Full_name." (".$Card_id.")</td></tr>";
									}*/
									
									
									
									if($report_type==1)//Details
									{
										if($row->Voucher_status=="Issued" || $row->Voucher_status=="Ordered")
										{
											$color="green";
											$Utilized_date="-";
										}
										else if($row->Voucher_status=="Delivered")
										{
											$color="green";
											$Utilized_date=$row->Update_date;
										}
										else if($row->Voucher_status=="Shipped")
										{
											$color="green";
											$Utilized_date=$row->Update_date;
										}
										else
										{
											$color="red";
											$Utilized_date=$row->Update_date;
										}
										
										$ci_object = &get_instance();
										$ci_object->load->model('Igain_model');
										
										$user_details = $ci_object->Igain_model->get_enrollment_details($row->Update_User_id);
										$Full_name = $user_details->First_name.' '.$user_details->Last_name;
										
										$user_details = $ci_object->Igain_model->get_enrollment_details($row->Seller);
										$Issued_Full_name = $user_details->First_name.' '.$user_details->Last_name;
										
										
										echo "<tr>";
										echo "<td>".$row->Trans_date."</td>";
										echo "<td>".$row->Trans_type."</td>";
										echo "<td>".$Card_id."</td>";
									//	echo "<td>".$Member_name."</td>"; 
										//echo "<td>".$row->Item_code."</td>";
										echo "<td>".$row->Merchandize_item_name."</td>";
									//	echo "<td>".$row->Quantity."</td>";
									//	echo "<td>".$row->Item_size."</td>";
									//	echo "<td>".$row->Partner_name."</td>";
									//	echo "<td>".$row->Branch_name."</td>";
										/* if($row->Topup_amount!=0)
										{
										echo "<td>".$row->Topup_amount."</td>";
										}
										else
										{
											echo "<td>-</td>";
										} */
										if($row->Purchase_amount!=0)
										{
											echo "<td>".$row->Purchase_amount."</td>";
										}
										else
										{
											echo "<td>-</td>";
										}
										// echo "<td>".$row->Purchase_amount."</td>";
									//	echo "<td>".$row->Redeem_points_per_Item."</td>";
										echo "<td>".$row->Total_Redeem_points."</td>";
										echo "<td style='color:$color;'>".$row->Voucher_status."</td>";
										echo "<td>".$row->Voucher_no."</td>";
									//	echo "<td>".$Issued_Full_name."</td>";
									//	echo "<td>".$Utilized_date."</td>";
									//	echo "<td>".$Full_name."</td>";
										echo "</tr>";
									}
									else
									{?>
										
										<td><?php echo $row->Trans_monthyear;?></td>
										<td><?php echo $row->Partner_name; ?> </td>		
										<td><?php echo $row->Branch_name; ?> </td>	
										<td><?php echo $row->Voucher_status;?></td>
										<td><?php echo $row->Total_Quantity;?></td>
										<td><?php echo $row->total_purchase_amt;?></td>	
										<td><?php echo $row->Total_points;?></td>
										
										
										</tr>
							<?php   }
								//	$lv_Enrollement_id=$Enrollement_id;
								}
							}
						}
						?>
							</tbody>
						</table>
						<?php 
						if($Trans_Records != NULL)
						{ 
						
						?>
							<a href="<?php echo base_url()?>index.php/Reportc/export_customer_redempion_report/?report_type=<?php echo $report_type; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&select_cust=<?php echo $select_cust; ?>&Single_cust_membership_id=<?php echo $Single_cust_membership_id; ?>&transaction_type_id=<?php echo $transaction_type_id; ?>&Delivery_method=<?php echo $Delivery_method; ?>&Voucher_status=<?php echo $Voucher_status; ?>&Segment_code=<?php echo $Segment_code; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
							</a>
						
							<a href="<?php echo base_url()?>index.php/Reportc/export_customer_redempion_report/?report_type=<?php echo $report_type; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&select_cust=<?php echo $select_cust; ?>&Single_cust_membership_id=<?php echo $Single_cust_membership_id; ?>&transaction_type_id=<?php echo $transaction_type_id; ?>&Delivery_method=<?php echo $Delivery_method; ?>&Voucher_status=<?php echo $Voucher_status; ?>&Segment_code=<?php echo $Segment_code; ?>&pdf_excel_flag=2">
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

	 if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "" && $('#report_type').val() != "" )
		{
	
			var radioVAL = $("input[name=select_cust]:checked").val()//$('#select_cust').val();
			
			var memberID = $('#Single_cust_membership_id').val();
			
			if( radioVAL == 2 && memberID > 0 )
			{
				show_loader();
			}
			
			if( radioVAL == 1)
			{
				show_loader();
			}

		}  

});
	
function toggel_cust(flag)
{
	if(flag==1)//All
	{
		// document.getElementById("cust_block").style.display="none";
		$("#Tier_id").attr("required","required");
		$("#cust_block").hide();
		$("#cust_block_segment").show();
		$("#Single_cust_membership_id").removeAttr("required");	
		
			
	}
	else
	{
		// document.getElementById("cust_block").style.display="";
		$("#Tier_id").removeAttr("required");
		$("#Single_cust_membership_id").attr("required","required");
		
		$("#cust_block").show();
		$("#cust_block_segment").hide();
		
	}	
	
}
function MembershipID_validation(MembershipID)
	{
		
		var Company_id = '<?php echo $Company_id; ?>';
		
		if( MembershipID == "" )
		{
			var msg1 = 'Please Enter Membership ID!!';
			$('#memberErr').show();
			$('#memberErr').html(msg1);
			
		}
		else
		{
		$.ajax({
				type:"POST",
				data:{MembershipID:MembershipID, Company_id:Company_id},
				url: "<?php echo base_url()?>index.php/Coal_Reportc/MembershipID_validation",
				success : function(data)
				{ 
					//alert(data.length);
					if(data.length >= 13)
					{
						$("#Single_cust_membership_id").val("");
						
						$("#Single_cust_membership_id").addClass("form-control has-error");
						var msg1 = 'Membership id not exist';
						$('#memberErr').show();
						$('#memberErr').html(msg1);
					}
					else
					{
						$('#memberErr').html("");
						$("#Single_cust_membership_id").removeClass("has-error");
					}
				}
			});
		}
	}	
	
	$('#Delivery_method').change(function()
	{	
		var Delivery_method = $("#Delivery_method").val();
		var Company_id = '<?php echo $Company_id; ?>';
		$.ajax({
			type:"POST",
			data:{Delivery_method:Delivery_method,Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/Reportc/Get_Voucher_status",
			success: function(data)
			{
				//alert(data)
				$('#Voucher_status').html(data.Get_Voucher_ststus2);
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
</script>
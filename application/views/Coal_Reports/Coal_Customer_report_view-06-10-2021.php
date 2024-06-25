<?php $this->load->view('header/header'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
			<div class="col-sm-12">
			<?php $attributes = array('id' => 'formValidate');
				echo form_open_multipart('Coal_Reportc/customer_report',$attributes); ?>
				<div class="element-wrapper">
					<h6 class="element-header">MEMBER TRANSACTION REPORT</h6>  
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
							   <label for=""><span class="required_info">* </span>From Date</label>
								<input class="single-daterange form-control" placeholder="Start Date" type="text"  name="start_date" id="datepicker1"  required="required" data-error="Please select from date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>

							  <div class="form-group">
							   <label for=""><span class="required_info">* </span>Till Date </label>
								<input class="single-daterange form-control" placeholder="End Date" type="text"  name="end_date" id="datepicker2" required="required" data-error="Please select till date"/>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
							</div>
							<div class="col-sm-6">
							  
							 <div class="form-group">
								<label for=""><span class="required_info">* </span>Report Type</label>
								<select class="form-control" name="report_type" id="report_type" required="required" data-error="Please select detail/summary">
									<option value="1">Details</option>
									<option value="2">Summary</option>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
							  <div class="form-group">
								<label for=""><span class="required_info">* </span>Transaction Type</label>
								<select class="form-control" name="transaction_type_id" id="transaction_type_id" required="required" data-error="Please select transaction type">
									<option value="">Select Transaction Type</option>
									<option value="0">All Transaction Type</option>
									<?php	
										unset($transaction_types[4]);
										unset($transaction_types[5]);
								
										$transactionTypes = [1,2,3,4,7,8,13,14,15,19];
										
										foreach($transaction_types as $transaction)
										{
											if(in_array($transaction->Trans_type_id,$transactionTypes))
											{
												if($Enable_company_meal_flag==1 && $transaction->Trans_type_id==1){$transaction->Trans_type='Meal Topup';}
											?>
												<option value="<?php echo $transaction->Trans_type_id; ?>"><?php echo $transaction->Trans_type; ?></option>
											<?php
											}
										}
								
									?>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
							 <div class="form-group">
								<label for="exampleInputEmail1"> Select Member &nbsp;&nbsp;</label>		
								<label class="radio-inline">
									<input type="radio"  name="select_cust" id="select_cust" onclick="toggel_cust(this.value)" value="1" checked >All Members		
									<input type="radio"   name="select_cust" id="select_cust" onclick="toggel_cust(this.value)" value="2" >Single Member
								</label>
							</div>
						
							   <div class="form-group" id="cust_block_tier">
								<label for=""><span class="required_info">* </span>Select Tier</label>
								<select class="form-control" name="Tier_id" id="Tier_id" required="required" data-error="Please select tier">
								<option value="0">All Tier</option>
									<?php								
									foreach($tier_details as $tier)
									{							
										?>
										<option value="<?php echo $tier['Tier_id']; ?>"><?php echo $tier['Tier_name']; ?></option>
										<?php							
									}
									?>
								</select>
								<div class="help-block form-text with-errors form-control-feedback"></div>
							  </div>
							  
							<div class="form-group" style="display:none;" id="cust_block">
								<label for=""><span class="required_info">*</span> Membership ID</label>
								<input type="text" id="Single_cust_membership_id" name="Single_cust_membership_id" class="form-control" placeholder="Enter Membership ID" onblur="MembershipID_validation(this.value);" data-error="Please enter membership id" />									
								<div class="help-block form-text with-errors form-control-feedback" id="memberErr"></div>
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
		if($_REQUEST["report_type"]){
			$report_type=$_REQUEST["report_type"];
		}
		else
		{
			$report_type = 1;
		}
		?>	
				<!---------Table--------->	 
				<div class="element-wrapper">											
					<div class="element-box">
					  <h6 class="form-header">
					  <?php if($report_type==1){ echo 'Member Transaction Report details';}
				if($report_type==2){echo 'Member Transaction Report Summary';}?>
					  </h6>                  
					  <div class="table-responsive">
						<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
							<thead>
									<?php if($report_type==1){ //Details?>
								<tr>
								<!--<th>Reciept</th>-->
								<th>Transaction Date</th>
								<th>Member Name</th>
								<th>Membership ID</th>
								<th>Transaction Type</th>
								<th>Bill No.</th>
								
								<th>Purchase Amount <?php echo "($Symbol_currency)"; ?></th>
								<th>Redeemed <?php echo $Company_details->Currency_name; ?></th>
								<?php
									if($Enable_company_meal_flag==1){echo '<th>Meal Topup</th>';}else{echo '<th>Bonus '.$Company_details->Currency_name.'</th>';}
								?>
								
								<!--<th>Gained Points at Merchant</th>
								<th>Coalition Loyalty Points</th>-->
								<th>Transfer <?php echo $Company_details->Currency_name; ?></th>
								<th>Expired <?php echo $Company_details->Currency_name; ?></th>
								
								
								</tr>
								<?php }
								if($report_type==2){ //Summary?>
								<tr>
									<th>Member Name</th>
									<th>Transaction Type</th>
									<th>Total Redeem <?php echo $Company_details->Currency_name; ?></th>
									<!--<th>Total Gained at Merchant</th>
									<th>Total Coalition Loyalty Points</th>-->
									<?php
									if($Enable_company_meal_flag==1){echo '<th>Total Meal Topup</th>';}else{echo '<th>Total Bonus '.$Company_details->Currency_name.'</th>';}
								?>
									
									<th>Total Purchase Amount <?php echo "($Symbol_currency)"; ?></th>
									<th>Total Transfered <?php echo $Company_details->Currency_name; ?></th>
									<th>Total Expired <?php echo $Company_details->Currency_name; ?></th>
														   
								</tr>
								<?php } ?>

							</thead>						
							<tfoot>
								<?php if($report_type==1){ //Details?>
								<tr>
<!--<th>Reciept</th>-->
								<th>Transaction Date</th>
								<th>Member Name</th>
								<th>Membership ID</th>
								<th>Transaction Type</th>
								<th>Bill No.</th>
								<th>Purchase Amount <?php echo "($Symbol_currency)"; ?></th>
								<th>Redeemed <?php echo $Company_details->Currency_name; ?></th>
								<?php
									if($Enable_company_meal_flag==1){echo '<th>Meal Topup</th>';}else{echo '<th>Bonus '.$Company_details->Currency_name.'</th>';}
								?>
								<!--<th>Gained Points at Merchant</th>
								<th>Coalition Loyalty Points</th>-->
								<th>Transfer <?php echo $Company_details->Currency_name; ?></th>
								<th>Expired <?php echo $Company_details->Currency_name; ?></th>
							
								
								</tr>
								<?php }
								if($report_type==2){ //Summary?>
								<tr>
									<th>Member Name</th>
									<th>Transaction Type</th>
									<th>Total Redeem <?php echo $Company_details->Currency_name; ?></th>
									<!--<th>Total Gained at Merchant</th>
									<th>Total Coalition Loyalty Points</th>-->
									<?php
									if($Enable_company_meal_flag==1){echo '<th>Total Meal Topup</th>';}else{echo '<th>Total Bonus '.$Company_details->Currency_name.'</th>';}
								?>
									<th>Total Purchase Amount <?php echo "($Symbol_currency)"; ?></th>
									<th>Total Transfered <?php echo $Company_details->Currency_name; ?></th>
									<th>Total Expired <?php echo $Company_details->Currency_name; ?></th>
														   
								</tr>
								<?php } ?>
							</tfoot>
							<tbody>
					<?php
					if(isset($_REQUEST["submit"]) && ($Trans_Records != NULL))
					{ 
					
						$report_type=$_REQUEST["report_type"];
						$Tier_id=$_REQUEST["Tier_id"];
						$todays = date("Y-m-d");
						$start_date=date("Y-m-d 00:00:00",strtotime($_REQUEST["start_date"]));
						$end_date=date("Y-m-d 23:59:59",strtotime($_REQUEST["end_date"]));
						$select_cust=$_REQUEST["select_cust"];
						$report_type=$_REQUEST["report_type"];
						$transaction_type_id=$_REQUEST["transaction_type_id"];
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

							$lv_Enrollement_id=0;
							
							foreach($Trans_Records as $row)
							{
								// echo"Trans_type------".$row->Trans_type;
								$Full_name=$row->First_name." ".$row->Middle_name." ".$row->Last_name;
								$Membership_ID=$row->Membership_ID;
								$Enrollement_id=$row->Enrollement_id;	
								$Tier_name=$row->Tier_name;
								if($Enable_company_meal_flag==1 && $row->Trans_type == 'Bonus Points')
								{
									$row->Trans_type = 'Meal Topup';
								}
								if($report_type == 1)//Details
								{
									if($row->Purchase_amount==0)
									{
										$row->Purchase_amount="-";
									}
									if($row->Redeem_points==0)
									{
										$row->Redeem_points="-";
									}
									if($row->Paid_amount==0)
									{
										$row->Paid_amount="-";
									}
									if($row->Topup_amount==0)
									{
										$row->Topup_amount="-";
									}
									/* if($row->Loyalty_pts==0)
									{
										$row->Loyalty_pts="-";
									} */
									if($row->Transfer_to==0)
									{
										$row->Transfer_to="-";
									}
									if($row->Transfer_points==0)
									{
										$row->Transfer_points="-";
									}
									if($row->Expired_points==0)
									{
										$row->Expired_points="-";
									}
									if($row->Coalition_Loyalty_pts==0)
									{
										$row->Coalition_Loyalty_pts="-";
									}
									
									
									
									echo "<tr>";
									/*
									if($row->Trans_type == 'Transfer Points')
									{
									?>
									
										<td class="text-center"  width="8%"> -  </td>
				
									<?php
									}
									else
									{
									?>
				
										<td class="text-center"  width="8%">
											<a href="javascript:void(0);" id="receipt_details" onclick="receipt_details2('<?php echo $row->Bill_no; ?>',<?php echo $row->Seller; ?>,<?php echo $row->Trans_id; ?>,<?php echo $row->Trans_type_id; ?>);" title="Receipt">
												<i class="os-icon os-icon-ui-49"></i>
											</a>
										</td><!--<th>Reciept</th>-->
				
									<?php
									}*/
									?>
                                                    
									<?php echo "<td>".$row->Trans_date."</td>";
									echo "<td>".$Full_name."</td>";
									echo "<td>".$Membership_ID."</td>";
									echo "<td>".$row->Trans_type."</td>";
									echo "<td>".$row->Bill_no."</td>";

									echo "<td>".$row->Purchase_amount."</td>";
									echo "<td>".$row->Redeem_points."</td>";
									//echo "<td>".$row->Paid_amount."</td>";
									echo "<td>".$row->Topup_amount."</td>";
									/*echo "<td>".$row->Loyalty_pts."</td>";
									 echo "<td>".$row->Coalition_Loyalty_pts."</td>"; */									 									
									echo "<td>".$row->Transfer_points."</td>";
									echo "<td>".$row->Expired_points."</td>";
									echo "</tr>";
							
								}
								if($report_type==2)
								{
									if($row->Total_Redeem==0)
									{
										$row->Total_Redeem="-";
									}
									/* if($row->Total_Gained_Points==0)
									{
										$row->Total_Gained_Points="-";
									} */
									if($row->Total_Purchase_Amount==0)
									{
										$row->Total_Purchase_Amount="-";
									}
									if($row->Total_Transfer_Points==0)
									{
										$row->Total_Transfer_Points="-";
									}
									if($row->Expired_points==0)
									{
										$row->Expired_points="-";
									}
									if($row->Total_Bonus_Points==0)
									{
										$row->Total_Bonus_Points="-";
									}
									/* if($row->Total_Coalition_Loyalty_pts==0)
									{
										$row->Total_Coalition_Loyalty_pts="-";
									} */
									/* echo"lv_Enrollement_id------".$lv_Enrollement_id."--ggg--";
									echo"Enrollement_id------".$Enrollement_id."--ggg--";
									echo"report_type------".$report_type."--ggg--";
									 */
									 
									/* if($lv_Enrollement_id!=$Enrollement_id && $report_type==2)
									{
										echo "<tr class='success'><td colspan='5'><b>".$Full_name." (".$Membership_ID.")   Tier : ". $Tier_name." </b></td></tr>";
									} */

									?>
										<tr>
										
										  <td><?php echo $Full_name;?></td>
										  <td><?php echo $row->Trans_type;?></td>
										<td><?php echo $row->Total_Redeem;?></td>
										<!--<td><?php //echo $row->Total_Gained_Points;?></td>
										<td><?php //echo $row->Total_Coalition_Loyalty_pts;?></td>-->
										<td><?php echo $row->Total_Bonus_Points;?></td>
										<td><?php echo $row->Total_Purchase_Amount;?></td>
										<td><?php echo $row->Total_Transfer_Points;?></td>
										<td><?php echo $row->Total_Expired_points;?></td>
										</tr>
								<?php   
								}
									$lv_Enrollement_id=$Enrollement_id;
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
						<a href="<?php echo base_url()?>index.php/Coal_Reportc/export_customer_report/?report_type=<?php echo $report_type; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&select_cust=<?php echo $select_cust; ?>&Single_cust_membership_id=<?php echo $Single_cust_membership_id; ?>&transaction_type_id=<?php echo $transaction_type_id; ?>&Tier_id=<?php echo $Tier_id; ?>&pdf_excel_flag=1">
							<button class="btn btn-success" type="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</button>
						</a>
						
						<a href="<?php echo base_url()?>index.php/Coal_Reportc/export_customer_report/?report_type=<?php echo $report_type; ?>&start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>&select_cust=<?php echo $select_cust; ?>&Single_cust_membership_id=<?php echo $Single_cust_membership_id; ?>&transaction_type_id=<?php echo $transaction_type_id; ?>&Tier_id=<?php echo $Tier_id; ?>&pdf_excel_flag=2">
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

	<div id="receipt_myModal" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<h5 class="modal-title" id="exampleModalLabel">
				   Receipt Details
				</h5>-->
				<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
			  </div>
			  <div class="modal-body">
				<div  id="show_transaction_receipt"></div>
			  </div>
			  <div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
			  </div>
			</div>
		</div>
    </div>

<!--Receipt Modal 
<div id="receipt_myModal" class="modal fade" role="dialog" style="overflow:auto;">
	<div class="modal-dialog modal-lg" style="width: 90%;" id="show_transaction_receipt">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-body">
					<div class="table-responsive" id="show_transaction_receipt"></div>
				</div>			
			</div>	
		</div>
	</div>
</div>
<!-- Receipt Modal -->

<?php $this->load->view('header/footer'); ?>
<script>
function receipt_details2(Bill_no,Seller_id,Trans_id,Transaction_type)
{	
	//alert("--Bill_no--"+Bill_no+"--Seller_id--"+Seller_id+"--Trans_id--"+Trans_id);
	//var Transaction_type = 2;
	$.ajax({
		type: "POST",
		data: {Bill_no: Bill_no, Seller_id:Seller_id,Trans_id:Trans_id,Transaction_type:Transaction_type},
		url: "<?php echo base_url()?>index.php/Coal_Transactionc/transaction_receipt",
		success: function(data)
		{
			// alert(data.transactionReceiptHtml);	
			$("#show_transaction_receipt").html(data.transactionReceiptHtml);	
			$('#receipt_myModal').modal('show');
		}
	});
}
$('#Register').click(function()
{
	 if($('#datepicker2').val() != ""  && $('#datepicker1').val() != "" && $('#report_type').val() != ""  && $('#transaction_type_id').val() != "" )
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
		$("#cust_block_tier").show();
		$("#Single_cust_membership_id").removeAttr("required");	
		
			
	}
	else
	{
		// document.getElementById("cust_block").style.display="";
		$("#Tier_id").removeAttr("required");
		$("#Single_cust_membership_id").attr("required","required");
		
		$("#cust_block").show();
		$("#cust_block_tier").hide();
		
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
	


function receipt_details(Enrollement_id,To_date,From_date,Transaction_type)
{	
	// alert("--Bill_no--"+Bill_no+"--Seller_id--"+Seller_id+"--Trans_id--"+Trans_id);
	//var Transaction_type = 2;
	$.ajax({
		type: "POST",
		data: {Enrollement_id: Enrollement_id,To_date: To_date,From_date: From_date,Transaction_type: Transaction_type},
		url: "<?php echo base_url()?>index.php/Coal_Reportc/cust_report_detail",
		success: function(data)
		{
			$("#show_transaction_receipt").html(data.transactionReceiptHtml);	
			$('#receipt_myModal').modal('show');
		}
	});
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
<?php $this->load->view('header/header'); 
$ci_object = &get_instance();
$ci_object->load->model('CallCenter_model');
$ci_object->load->model('Igain_model'); ?>
<div class="content-i">
	<div class="content-box">
		<div class="row">
		  <div class="col-sm-12">
			<div class="element-wrapper">
			  <h6 class="element-header">
				MEMBER PROFILE -<?php echo $results->First_name.' '.$results->Last_name." (".$results->Card_id.")";?>
			  </h6>
			  	  <?php
					if(@$this->session->flashdata('success_code'))
					{ ?>	
						<div class="alert alert-success alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						 <?php echo $this->session->flashdata('success_code'); ?>
						</div>
			<?php 		
					} ?>
				<?php
					if(@$this->session->flashdata('error_code'))
					{ ?>	
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						  <button aria-label="Close" class="close" data-dismiss="alert" type="button">
						  <span aria-hidden="true"> &times;</span></button>
						  <?php echo $this->session->flashdata('error_code'); ?>
						</div>
			<?php 	} ?>
			<?php 	$attributes = array('id' => 'formValidate');
					echo form_open_multipart('Call_center/edit_handle_member_transaction',$attributes); ?>
						  <div class="os-tabs-w" style="width:100%;">
						<div class="os-tabs-controls os-tabs-complex">
						  <ul class="nav nav-tabs">
							<li class="nav-item" style="width:25%;">
							  <a aria-expanded="false" class="nav-link"  href="<?php echo base_url()?>index.php/Call_center/edit_handle_member_home"><span class="tab-label">Profile</span></a>
							</li>
							<li class="nav-item"  style="width:30%;">
							  <a aria-expanded="false" class="nav-link active"  href="<?php echo base_url()?>index.php/Call_center/edit_handle_member_transaction"><span class="tab-label">Transaction Details</span></a>
							</li>
							<li class="nav-item"  style="width:24%;">
							  <a aria-expanded="false" class="nav-link" href="<?php echo base_url()?>index.php/Call_center/edit_handle_member_query_record"><span class="tab-label">Query Records</span></a>
							</li>
							<li class="nav-item"  >
							  <a aria-expanded="true" class="nav-link"  href="<?php echo base_url()?>index.php/Call_center/edit_handle_member_log_query"><span class="tab-label">Log Query</span></a>
							</li>
						   
						  </ul>
						</div>
					</div>
			  <div class="element-box">
					<div class="row">
						
	
					<div class="col-md-6">
							
							<div class="form-group">
								<label for="">From Date<span class="required_info"> (* click inside textbox)</span></label>
								<input type="text" name="from_date"  id="datepicker"  class="single-daterange form-control" required />									
							</div>
							<div class="form-group">
								<label for=""><span class="required_info">*</span>Transaction Type</label>
								<?php
								unset($transaction_types[4]);
								unset($transaction_types[5]);
								?>
								<select class="form-control" name="transaction_type_id" id="transaction_type_id" required>
									<option value="0">All</option>
									<?php								
									foreach($transaction_types as $transaction)
									{
										if($transaction->Trans_type_id ==10 || $transaction->Trans_type_id ==12|| $transaction->Trans_type_id ==1 || $transaction->Trans_type_id ==2 || $transaction->Trans_type_id ==3 || $transaction->Trans_type_id == 4 || $transaction->Trans_type_id ==7 || $transaction->Trans_type_id == 8 || $transaction->Trans_type_id ==13 || $transaction->Trans_type_id ==14 || $transaction->Trans_type_id ==18 || $transaction->Trans_type_id ==17 || $transaction->Trans_type_id ==22)// Redemption
										{
									?>
										
										<option value="<?php echo $transaction->Trans_type_id; ?>"><?php echo $transaction->Trans_type; ?></option>
									<?php
										}
									}
									?>
								</select>							
							</div>
						
						</div>
						<div class="col-md-6">
							
							
							<div class="form-group">
								<label for="">To Date<span class="required_info"> (* click inside textbox)</span></label>
								<input type="text" name="to_date" required id="datepicker1"  class="single-daterange form-control" />									
							</div>
							<div class="form-group">
								<label for=""><span class="required_info">*</span>Merchant Name</label>
								<select class="form-control" name="seller_id" id="seller_id" required>
									<?php if(($userId == 2 && $Super_seller==1) ){ ?>
									<option value="">Select Merchant</option>
									<option value="0">All Merchant</option>
									<?php } ?>

									<?php 
									foreach($company_sellers as $sellers)
									{
										?>
										<option value="<?php echo $sellers['Enrollement_id'] ?>"><?php echo $sellers['First_name']." ".$sellers['Last_name']; ?></option>
										<?php
									}
									?>
								</select>							
							</div>
							
						</div>
					</div>
					<div class="form-buttons-w"  align="center">
					<input type="hidden" name="Enrollment_id" value="<?php echo $results->Enrollement_id; ?>" class="form-control" />
					<input type="hidden" name="Enrollment_image" value="<?php echo $results->Photograph; ?>" class="form-control" />
					<input type="hidden" name="User_id" value="<?php echo $results->User_id; ?>" class="form-control" />
					<button class="btn btn-primary" name="submit" id="Register"  type="submit">Submit</button>
				 </div>
				</div>
			</div>
			
		  </div>
		</div>
</div>				
	<!--------------Table------------->
	<div class="content-panel">             
		<div class="element-wrapper">											
			<div class="element-box">
			  <h5 class="form-header">
			   Member Transactions
			  </h5>                  
			  <div class="table-responsive">
				<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
					<thead>
						<tr>
							<th class="text-center">Date</th>
							<th class="text-center">Transaction Type</th>
							<!--<th class="text-center">Description</th>-->
							<th class="text-center"><?php echo $Company_details->Currency_name; ?> Received</th>
							<?php if($Company_details->Coalition==1) {  ?>	
							<th class="text-center">Coalition <?php echo $Company_details->Currency_name; ?> Received</th>
							<?php }?>
							<th class="text-center"><?php echo $Company_details->Currency_name; ?> Used</th>
							<th class="text-center">Receipt</th>
						</tr>
						
					</thead>						
					
					<tbody>
				<?php		
						
							if($Redeemtion_tran != NULL)
							{
								foreach($Redeemtion_tran as $row)
								{	?>													
									<tr>										
										<td class="text-center"><?php echo date('Y-m-d',strtotime($row->Trans_date));?>
										</td>
										<?php 
											if($row->Trans_type == 1) 
											{ 
												$Trans_type="Bonus Points"; 
											}
											else if($row->Trans_type == 2) 
											{ 
												$Trans_type="Loyalty Transaction"; 
											}
											else if($row->Trans_type == 3) 
											{ 
												$Trans_type="Only Redeem"; 
											}
											else if($row->Trans_type == 4) 
											{ 
												$Trans_type="Gift Card Transaction"; 
											}
											else if($row->Trans_type == 7) 
											{ 
												$Trans_type="Promo Code"; 
											}
											else if($row->Trans_type == 8) 
											{ 
												$Trans_type="Transfer Points"; 
											}
											else if($row->Trans_type == 10) 
											{ 
												$Trans_type="Redemption"; 
											} 
											else if($row->Trans_type == 12)
											{
												$Trans_type="Online Purchase" ; 
											}
											else if($row->Trans_type == 13)
											{
												$Trans_type="Survey Rewards" ; 
											}
											else if($row->Trans_type == 14)
											{
												$Trans_type="Points Expiry" ; 
											}
											else if($row->Trans_type == 17)
											{
												$Trans_type="Purchase Cancel" ; 
											}
											else if($row->Trans_type == 18)
											{
												$Trans_type="Evoucher Expiry" ; 
											}
											else if($row->Trans_type == 22)
											{
												$Trans_type="Purchase Returned" ; 
											}
										?>
										<td class="text-center"><?php echo $Trans_type;?></td>
										
										<?php /* $Item_Name = $ci_object->CallCenter_model->Get_item_name($row->Item_code,$Company_id); ?>
									<?php if($row->Trans_type == 10 || $row->Trans_type == 12 || $row->Trans_type == 17 || $row->Trans_type == 18 || $row->Trans_type == 22) 
											{ 
												$Description_title="Item Name :" ; ?>
												<td><?php echo $Description_title.' '.$Item_Name->Merchandize_item_name;?>
												</td>
									<?php	} 
											else if($row->Trans_type == 8)
											{
												 $Enroll_detaails = $ci_object->CallCenter_model->get_cust_details($row->Card_id2,$Company_id); 
												$Description_title ="Transferred To - " ; ?>
												<td><?php echo $Description_title.' '.$Enroll_detaails->First_name.' '.$Enroll_detaails->Last_name;?>
												</td>
										<?php	
											}
											else if($row->Trans_type == 4)
											{
												$Description_title ="Gift Card " ; ?>
												<td> <?php echo $Description_title.' ('.$row->GiftCardNo.')' ; ?>
												</td>
									<?php	}
											else if($row->Trans_type == 7)
											{
											?>
												<td> <?php echo $row->remark2; ?>
												</td>
									<?php	}
											else if($row->Trans_type == 14)
											{
											?>
												<td> <?php echo 'Expired points('.$row->Expired_points.')'; ?>
												</td>
									<?php	}
											else 
											{  
												$Description_title ="-" ; ?>
												<td> <?php echo $Description_title ; ?>
												</td>
									<?php	} */
									?>
									<?php  if($row->Trans_type == 1 || $row->Trans_type == 17 || $row->Trans_type == 18 || $row->Trans_type == 7 || $row->Trans_type == 13 || $row->Trans_type == 22)
											{ ?>
												<td class="text-center"><?php echo $row->Topup_amount;?></td>
									<?php   }
											else
											{
											?>
												<td class="text-center"><?php echo $row->Loyalty_pts;?></td>
									<?php   } ?>
										</td>
										<?php if($Company_details->Coalition==1) 
										{ ?>
											<td class="text-center"><?php echo $row->Coalition_Loyalty_pts;?></td>
								  <?php } ?>	
										<?php if($row->Trans_type == 8) 
										{ ?>
											<td class="text-center"><?php echo $row->Transfer_points;?></td>
								  <?php } 
										else if($row->Trans_type == 10)
										{ ?>
											<td class="text-center"><?php echo $row->Redeem_points+$row->Shipping_points;?></td>
								  <?php } 
										else
										{ ?>
											<td class="text-center"><?php echo $row->Redeem_points;?></td>
								<?php	}
										?>
										
										<td class="text-center">
											<a href="javascript:void(0);" id="receipt_details" onclick="receipt_details('<?php echo $row->Bill_no; ?>',<?php echo $row->Seller; ?>,<?php echo $row->Trans_id; ?>,<?php echo $row->Trans_type; ?>);" title="Receipt">
											<i class="os-icon os-icon-ui-49"></i>
											</a>
										</td>
									</tr>									
						<?php	}
							} ?>		
					</tbody>
				</table>
			  </div>
			</div>
		</div>
	</div> 
	<!--------------Table--------------->
    
 </div>

			
<?php echo form_close(); ?>
<?php $this->load->view('header/footer'); ?>

<!-- Modal -->
<div id="receipt_myModal" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-md">
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

				<button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button>
			  </div>
			</div>
		</div>
    </div>
<!-- Modal -->
<script>
	$(document).ready(function() 
	{
		$( "#datepicker" ).datepicker({
			changeMonth: true,
			yearRange: "-80:+0",
			changeYear: true
		});
		$( "#datepicker1" ).datepicker({
			changeMonth: true,
			yearRange: "-80:+0",
			changeYear: true
		});
	});

function receipt_details(Bill_no,Seller_id,Trans_id,Transaction_type)//Amit 16-11-2017
{	
	// alert("--Bill_no--"+Bill_no+"--Seller_id--"+Seller_id+"--Trans_id--"+Trans_id+"--Transaction_type--"+Transaction_type);
	// var Transaction_type = 3;
	var Company_id='<?php echo $Company_id;?>';
	$.ajax({
		type: "POST",
		data: {Bill_no: Bill_no,Seller_id:Seller_id,Trans_id:Trans_id,Transaction_type:Transaction_type,Company_id:Company_id},
		url: "<?php echo base_url()?>index.php/Call_center/Cc_transaction_receipt",
		success: function(data)
		{
			$("#show_transaction_receipt").html(data.transactionReceiptHtml);	
			$('#receipt_myModal').modal('show');
		}
	});
}
function search_transaction_record()
{	 
	var transactionType =$("#transaction_type_id").val();
	var from_date = $("#datepicker").val();  
	var to_date = $("#datepicker1").val();
	var seller_id = $("#seller_id").val();
	
	if(from_date == "" || to_date == "" || seller_id == "")
	{ 
		var Title = "Application Information";
		var msg = "Please Select Search Criteria";
		runjs(Title,msg);
		return false;
	}
	else
	{
		show_loader();	
	}
	
	window.location='<?php echo base_url()?>index.php/Call_center/edit_handle_member_transaction/?from_date='+from_date+'&to_date='+to_date+'&transaction_type_id='+transactionType+'&seller_id='+seller_id;
}

function pagination_item(limit)
{		
<?php 
		$transaction_type = $_REQUEST["transaction_type_id"];

		if($transaction_type == "")
		{
			$TransactionType=0;
		}
		else
		{
			$TransactionType = $_REQUEST["transaction_type_id"];
		}
		
		$seller_id1 = $_REQUEST["seller_id"];
		
		if($seller_id1 == "")
		{
			$seller_id=0;
		}
		else
		{
			$seller_id=$_REQUEST["seller_id"];
		}
 ?>
	var transactionType = '<?php echo $TransactionType;?>';
	var from_date ='<?php echo $from_date; ?>';
	var to_date ='<?php echo $to_date; ?>';
	var seller_id = '<?php echo $seller_id;?>';
	
	show_loader();
	limit=(limit*10);
	
	window.location='edit_handle_member_transaction?page_limit='+limit+'&from_date='+from_date+'&to_date='+to_date+'&transaction_type_id='+transactionType+'&seller_id='+seller_id;
}
function Refresh()
{
	show_loader();	
}
</script>
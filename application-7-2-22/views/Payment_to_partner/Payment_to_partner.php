<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">Payment to Partner</h6>
                    <div class="element-box">					
						<?php
                          if(@$this->session->flashdata('success_code')) {
                            ?>	
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('success_code') . ' ' . $this->session->flashdata('data_code'); ?>
                            </div>
                          <?php } ?>
                        <?php
                          if(@$this->session->flashdata('error_code')) {
                            ?>	
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('error_code') . ' ' . $this->session->flashdata('data_code'); ?>
                            </div>
                          <?php } ?>
                       
                        <?php
                          $attributes = array('id' => 'formValidate');
                          echo form_open('Payment_to_partner', $attributes);
                        ?>   
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for=""><span class="required_info">*</span> Company Name</label>									
										<select class="form-control" data-error="Select Company Name" required="required"  name="Company_id" name="Company_id" >
											<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
										</select>							
										<div class="help-block form-text with-errors form-control-feedback" id="CompanyName"></div>
									</div>
									<div class="form-group">
										<label class="col-sm-4 col-form-label">Select Partner Type</label>
										<div class="col-sm-8">
											<div class="form-check">
												<label class="form-check-label">
													<input class="form-check-input" name="Partner_Type"  id="Partner_Type"  type="radio" value="1" onclick="javascript:Get_partner(this.value);">Merchandize
												</label>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<label class="form-check-label">
													<input class="form-check-input" name="Partner_Type" type="radio"  id="Partner_Type" value="4"  onclick="javascript:Get_partner(this.value);">Shipping
												</label>
												<div class="help-block form-text with-errors form-control-feedback" id="PartnerType"></div>
											</div>

										</div>
									</div>
									<div class="form-group" id="Show_Partners">
										<!--<label for=""><span class="required_info">*</span>Select Partner</label>
										<select class="form-control" data-error="Select Partner" required="required" name="Partner_id" ID="Partner_id" >
											<option value="">Select Partner</option>
												<?php 
													foreach($State_records as $rec)
													{
														echo "<option value=".$rec->id.">".$rec->name."</option>";
													}
												?>
											</select>
										<div class="help-block form-text with-errors form-control-feedback" id="SelectPartner"></div>-->
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for=""><span class="required_info">*</span> From Date<span class="required_info">(* click inside textbox)</span> </label>
										<input class="form-control" data-error="Select From Date" placeholder="Select From Date" required="required" type="text" id="datepicker1" name="start_date">
										<div class="help-block form-text with-errors form-control-feedback" id="FromDate"></div>
									</div>
									<div class="form-group">
										<label for=""><span class="required_info">*</span> To Date<span class="required_info">(* click inside textbox)</span> </label>
										<input class="form-control" data-error="Select To Date" placeholder="Select To Date" required="required" type="text" id="datepicker2" name="end_date">
										<div class="help-block form-text with-errors form-control-feedback" id="ToDate"></div>
									</div>
								</div>
							</div>	
								<div class="form-buttons text-center">
									<button class="btn btn-primary" type="submit" name="submit" id="submit" value="submit"> Submit</button>
								</div>
															
                    </div>
                </div>
				<!-------------------- START - Data Table -------------------->	  
				<?php
				if($Trans_Records != NULL)
				{
					
				?>	
                <div class="element-wrapper">                
                    <div class="element-box">
                        <h5 class="form-header">
                            Generated Partener Invoice
                        </h5>                  
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th>#</th>
										<th>Trans date</th>										
										<th>Order No.</th>
										<th>e-Voucher No.</th>										
										<th>Status</th>
										<th>Qty</th>
										<th><?php echo $Company_details->Currency_name; ?> Redeem</th>
										<th>Purchase Amount</th>
										<th>Payable to Partner</th>

                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
										<th>#</th>
										<th>Trans date</th>										
										<th>Order No.</th>
										<th>e-Voucher No.</th>										
										<th>Status</th>
										<th>Qty</th>
										<th><?php echo $Company_details->Currency_name; ?> Redeem</th>
										<th>Purchase Amount</th>
										<th>Payable to Partner</th>
                                    </tr>
                                </tfoot>
                                <tbody>
								<?php
								$Partner_Type=$_REQUEST['Partner_Type'];
								$Partner_id=$_REQUEST['Partner_id'];
								$From_date=$_REQUEST['start_date'];
								$Till_date=$_REQUEST['end_date'];
								$Todays_date=date("Y-m-d");
								foreach ($Trans_Records as $row) {
										
										if($row->Voucher_status==30)
										{
											$Voucher_status='Issued';
										}
										if($row->Voucher_status==31)
										{
											$Voucher_status='Used';
										}								
										if($row->Voucher_status==18)
										{
											$Voucher_status='Ordered';
										}
										if($row->Voucher_status==19)
										{
											$Voucher_status='Shipped';
										}
										if($row->Voucher_status==20)
										{
											$Voucher_status='Delivered';
										}
										if($row->Purchase_amount > 0)
										{
											$Purchase_amount=$row->Purchase_amount;									
										}
										else
										{
											$Purchase_amount='-';
										}
										
										if($row->Total_Redeemed_Points > 0)
										{
											$Total_Redeemed_Points=$row->Total_Redeemed_Points;									
										}
										else
										{
											$Total_Redeemed_Points='-';
										}
										if($Partner_Type !=4)
										{
											$payment=$row->Cost_payable_partner;
										}
										else
										{
											$payment=$row->Shipping_cost;
										}
										
										// echo"-Trans_date--".$row->Trans_date."--<br>";
									?>
                                        <tr>
                                            <td> 
												<input data-type="check" name="TransID[]" id="<?php echo $row->Trans_id; ?>"  value="<?php echo $row->Trans_id; ?>" class="checkbox1" type="checkbox" onClick="Update_Total_Points(<?php echo $row->Trans_id ?>,<?php echo $payment; ?>);Add_product_array(<?php echo $row->Trans_id; ?>);">													
											</td>											
											<td><?php echo date("j, F Y",strtotime($row->Trans_date)); ?></td>
																		
											<td><?php echo $row->Bill_no; ?></td>							
											<td><?php echo $row->Voucher_no; ?></td>							
																	
											<td><?php echo $Voucher_status; ?></td>							
											<td><?php echo $row->Quantity; ?></td>							
											<td><?php echo $Total_Redeemed_Points; ?></td>							
											<td><?php echo $Purchase_amount; ?></td>							
											<td><?php echo $payment; ?></td>							
											
                                        </tr>
								<?php } ?>
                                </tbody>								
								<tr>							
									<td colspan="8"></td>
									<td >Sub Total (<?php echo $Symbol_currency; ?>) </td>
									<td>
										<input   type='text' pattern='[0-9]*'    name="Grand_total"    id="Grand_total" value="0" class="form-control" style="text-align: center;width:90px;" size="10"  readonly>
									
									</td>
								</tr>
                            </table>
                        </div>	



						<br>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label for=""><span class="required_info">*</span> Payment by</label>									
									<select class="form-control" data-error="Select Payment by" required="required"  name="Payment_type" id="Payment_type" onchange="show_payment(this.value)" >
										<?php
											foreach($Payment_array as $Payment)
											{
												echo "<option value=".$Payment->Payment_type_id.">".$Payment->Payment_type."</option>";
											}
										?>
									</select>							
									<div class="help-block form-text with-errors form-control-feedback" id="CompanyName"></div>
								</div>
								<div id="cheque_block" style="display:none;">
								  <div class="panel-heading"><label for="exampleInputEmail1" id="labelME2">Cheque Details</label></div>
									
									<div class="form-group">
										<label for="exampleInputEmail1"><span class="required_info">*</span>Bank Name</label>
										<input type="text" name="Bank_name" id="Bank_name"  data-error="Enter Bank Name" required="required"  class="form-control" placeholder="Enter Bank Name"  />
										<div class="help-block form-text with-errors form-control-feedback" id="BankName"></div>
									</div>									 
									<div class="form-group">
										<label for="exampleInputEmail1"><span class="required_info">*</span>Branch Name of Bank</label>
										<input type="text" name="Branch_name" id="Branch_name" data-error="Enter Branch Name of Bank" required="required" class="form-control" placeholder="Enter Branch Name of Bank"  />
										<div class="help-block form-text with-errors form-control-feedback" id="BranchName"></div>
									</div>
									<div class="form-group">
										<label for="exampleInputEmail1" id="labelME"><span class="required_info">*</span>Cheque/Credit Card Number</label>
										<input type="text" name="Credit_Cheque_number" id="Credit_Cheque_number" data-error="Enter Cheque/Credit Number" required="required" class="form-control" placeholder="Enter Number Cheque/Credit"  />
										<div class="help-block form-text with-errors form-control-feedback" id="CardNumber"></div>
										
									</div>
								</div>									
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label for="">Remarks</label>
									<input type="text" name="Remarks" id="Remarks" class="form-control" placeholder="Remarks" />
								</div>
								<div class="form-group">
									<label for="">Invoice number</label>
									<input type="text"  data-error="Enter Invoice Number" required="required" name="Invoice_number" id="Invoice_number" class="form-control" placeholder="Invoice number" />
									<div class="help-block form-text with-errors form-control-feedback" id="InvoiceNumber"></div>
								</div>
							</div>
						</div>
						
						<div class="form-buttons text-center">	
							<input type="hidden" name="TransIDArray[]" id="TransIDArray" class="form-control"/>							
							<input type="hidden"  name="Company_id"  value="<?php echo $Company_id; ?>">
							<input type="hidden"  name="Partner_Type"  value="<?php echo $Partner_Type; ?>">
							<input type="hidden"  name="Partner_id"  value="<?php echo $Partner_id; ?>">
							<input type="hidden"  name="From_date"  value="<?php echo $From_date; ?>">
							<input type="hidden"  name="Till_date"  value="<?php echo $Till_date; ?>">
							
							<button type="submit" name="Partner_payment" value="Partner_payment" id="Partner_payment" class="btn btn-primary">Submit Payment</button>	
							<div class="help-block form-text with-errors form-control-feedback" id="PartnerPayment"></div>				
						</div>
						
						
                    </div>
                </div>
				<?php
				} else { 
					if(isset($_POST['submit'])){
					?>
					<div class="element-box">
						<div class="form-buttons text-center">	
							No Record Found			
						</div>
					</div>
					
				<?php } 
				}
			?>	
				<!--------------------  END - Data Table  -------------------->					
				<?php echo form_close(); ?>			
			
			
			<!-------------------- START - Data Table -------------------->	  
				<?php
				if($Sattled_Partener != NULL)
				{					
				?>	
                <div class="element-wrapper">                
                    <div class="element-box">
                        <h5 class="form-header">
                            Sattled Partener Invoice
                        </h5>                  
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                       
										<th>Sattled date</th>										
										<th>Invoice No.</th>
										<th>Bill No.</th>										
										<th>Partener Type</th>
										<th>Partener Name</th>
										<th>Amount</th>

                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
									
										<th>Sattled date</th>										
										<th>Invoice No.</th>
										<th>Bill No.</th>										
										<th>Partener Type</th>
										<th>Partener Name</th>
										<th>Amount</th>
                                    </tr>
                                </tfoot>
                                <tbody>
								<?php
								
								foreach ($Sattled_Partener as $row) {
										
										
										if($row->Partner_type ==1)
										{
											$Partner_type="Merchandize";									
										}
										else
										{
											$Partner_type="Shipping";
										}										
										if($row->Total_Redeemed_Points > 0)
										{
											$Total_Redeemed_Points=$row->Total_Redeemed_Points;									
										}
										else
										{
											$Total_Redeemed_Points='-';
										}
										if($row->Partner_type ==1)
										{
											$payment=$row->Cost_payable_partner;
										}
										else
										{
											$payment=$row->Shipping_cost;
										}
										
									?>
                                        <tr>
                                            										
											<td><?php echo date("j, F Y",strtotime($row->Update_date)); ?></td>
											<td><?php echo $row->Invoice_no; ?></td>							
											<td><?php echo $row->Bill_no; ?></td>							
											<td><?php echo $Partner_type; ?></td>							
											<td><?php echo $row->Partner_name; ?></td>
											<td><?php echo $payment; ?></td>											
											
                                        </tr>
								<?php } ?>
                                </tbody>								
								
                            </table>
                        </div>	
						
                    </div>
                </div>
				<?php
				}
			?>	
				<!--------------------  END - Data Table  -------------------->	
			
			
			
			
			</div>	   
        </div>	       		
    </div>
</div>	
<!-- Modal -->
<div id="receipt_myModal" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1">
    <div class="modal-dialog" style="width: 100%;margin-top:180px;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="close_modal" class="close"  data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div  id="show_transaction_receipt"></div>
            </div>
        </div>
    </div>
</div>



<?php $this->load->view('header/footer'); ?>

<style>
    /* Important part */
    .modal-dialog{
        overflow-y: initial !important
    }
    .modal-body{
        height: 500px;
        overflow-y: auto;
    }
    .modal-content{
        width:119%;
    }
</style>
<script>


function Update_Total_Points(Item_id,Redeem_pts)
{
	
	var Product=document.getElementById(Item_id).checked;
	var Total_points=0;
	if(Product==true)
	{
		Total_points=parseFloat(Redeem_pts).toFixed(2);
		var lv_Grand_total=document.getElementById('Grand_total').value;
		var Calc_Grand_total=parseFloat(lv_Grand_total)+parseFloat(Total_points);
		document.getElementById('Grand_total').value=parseFloat(Calc_Grand_total).toFixed(2);
	}
	else
	{
		
		Total_points=parseFloat(Redeem_pts).toFixed(2);
		var lv_Grand_total=document.getElementById('Grand_total').value;
		var Calc_Grand_total=parseFloat(lv_Grand_total)-parseFloat(Total_points);
		document.getElementById('Grand_total').value=parseFloat(Calc_Grand_total).toFixed(2);
		
	}
	if(parseFloat(Calc_Grand_total) > 0)
	{
		document.getElementById("Partner_payment").disabled = false;		
	}
	else
	{
		document.getElementById("Partner_payment").disabled = true;
	}	
}

	function Get_partner(partnertype)
	{
		var Company_id = '<?php echo $Company_id; ?>';		
		$.ajax({
			type: "POST",
			data: {partnertype: partnertype,Company_id:Company_id},
			url:"<?php echo base_url()?>index.php/Payment_to_partner/Get_partner",
			// url: "<?php echo $this->config->item('base_url2')?>index.php/Company/Get_states",
			success: function(data)
			{
				// alert(data.States_data);
				$("#Show_Partners").html(data.Show_Partners);	
				
			}
		});
	}








function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 
	&& (charCode < 48 || charCode > 57))
	 return false;

  return true;
}


$('#submit').click(function()
{
	
	var PartnerLenght = $("[name='Partner_Type']:checked").length;
	// console.log(PartnerLenght);
	if(PartnerLenght == 0 ){
		
		$("#PartnerType").html('Select Partner Type');
		return false;
	} 
	else
	{ 
		$("#PartnerType").html('');
		// return false;
		if($('#Partner_Type').val() != "" && $('#Partner_id').val() != "" &&  $('#datepicker1').val() != "" &&  $('#datepicker2').val() != "")
		{		
			show_loader();

		}
	}
});

$('#Partner_payment').click(function()
{
	$("#Company_id").removeAttr("required");
	$("#Partner_Type").removeAttr("Partner_Type");
	$("#Seller_id").removeAttr("required");
	$("#datepicker1").removeAttr("required");
	$("#datepicker2").removeAttr("required");
	
	
	
	
	
	
	var count_checked = $("[name='TransID[]']:checked").length; // count the checked rows
	console.log(count_checked);
	if(count_checked == 0) 
	{
		
		$("#PartnerPayment").html('Please select atleast one checkbox to Processed Partner Payment');
		return false;
	}
	else {
		
			$("#PartnerPayment").html('');
			
			if($("#Invoice_number").val() =="")
			{
				$("#InvoiceNumber").html('Please enter invoice number');
				$("#Invoice_number").addClass("form-control has-error");
				return false;
			}
			if($('#Payment_type').val() == 2 || $('#Payment_type').val() == 3)
			{
				$("#Bank_name").attr("required","required");
				$("#Branch_name").attr("required","required");
				$("#Credit_Cheque_number").attr("required","required");
				
				$("#BankName").html("Enter Bank Name");
				$("#BranchName").html("Enter Branch Name of Bank");
				$("#CardNumber").html("Enter Cheque/Credit Number");
				
				
				if($('#Bank_name').val() == "" ||  $('#Branch_name').val() == "" ||  $('#Credit_Cheque_number').val() == "")
				{
					
					return false;
					
				} else {
					
					show_loader();
					return true;
				}				
			}
			else
			{
				$("#InvoiceNumber").html('');
				$("#Invoice_number").removeClass("has-error");
				show_loader();
				return true;
			}	
	}
		
	
	// return false;
	// show_loader();
	
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







var cart = [];
function Add_product_array(BillNO)
{
	/* console.log('----BillNO----='+BillNO);
	console.log('----Details----='+Details);
	console.log('----BillAMT----='+BillAMT);
	console.log('----PaidAMT----='+PaidAMT); */
	var count_checked = ($('input[id='+BillNO+']:checked').length);	
	// console.log('----count_checked----='+count_checked);
	indexi = cart.map(function(e) { return e.Item_id; }).indexOf(BillNO);	
	// console.log('----index----='+indexi);
	if(count_checked==1) {
		
		 // var found = jQuery.inArray(Item_id, cart);
		//const index = cart.findIndex(x => x.Item_id === Itemid);
		// console.log('----index----='+indexi);
		var item = { Item_id: BillNO}; 
		if (indexi >= 0 ) {
			// Element was found, remove it.
			cart.splice(indexi, 1,item);
			$('#TransIDArray').val(JSON.stringify(cart));
			
		} else {
			// Element was not found, add it.
			var item = { Item_id: BillNO}; 
			cart.push(item);
			// add_product_quantity_array(Itemid);
			$('#TransIDArray').val(JSON.stringify(cart));
		}
	}
	else{
		
		if (indexi >= 0 ) {
			// Element was found, remove it.
			cart.splice(indexi, 1);
			$('#TransIDArray').val(JSON.stringify(cart));
			
		} 
		
	}
	// console.log(cart);
}




	function show_payment(flag)
	{
		
		if(flag==2 || flag==3)
		{
			$("#cheque_block").show();
		}
		else
		{
			$("#cheque_block").hide();
		}
		
		if(flag==2)
		{
			document.getElementById("labelME").innerHTML = "Cheque Number";
			document.getElementById("labelME2").innerHTML = "Cheque Details";
			 
			$("#Bank_name").attr("required","required");
			$("#Branch_name").attr("required","required");
			$("#Credit_Cheque_number").attr("required","required");
		}
		else if(flag==3)
		{
			document.getElementById("labelME").innerHTML = "Credit Card Number";
			document.getElementById("labelME2").innerHTML = "Credit Card Details";
			
			$("#Bank_name").attr("required","required");
			$("#Branch_name").attr("required","required");
			$("#Credit_Cheque_number").attr("required","required");
		}
		else
		{
			//document.getElementById("labelME").innerHTML = "Number";
			$("#Bank_name").removeAttr("required");
			$("#Branch_name").removeAttr("required");
			$("#Credit_Cheque_number").removeAttr("required");
			
			$("#Bank_name").val("");
			$("#Branch_name").val("");
			$("#Credit_Cheque_number").val("");
				
		}
	}
</script>

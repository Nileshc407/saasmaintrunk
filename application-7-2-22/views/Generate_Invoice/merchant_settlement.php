<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">Merchant Settlement</h6>
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
                          echo form_open('Settlement/Merchant_settlement', $attributes);
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
										<label for=""><span class="required_info">*</span>Merchant Name</label>
										<select class="form-control" data-error="Select Merchant Name" required="required" name="Seller_id" ID="Seller_id" >
											<option value="">Select Merchant</option>	
											<?php
												if($Logged_user_id ==2 && $Super_seller == 1)
												{	
													foreach($Seller_array as $seller_val)
													{	
														echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
													}
												}
												else if($Logged_user_id == 7)
												{		
													foreach($Seller_array as $seller_val)
													{	
														echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";	
													}
												}
												else
												{
													echo '<option value="'.$enroll.'">'.$LogginUserName.'</option>';
												}
											?>
										</select>
										<div class="help-block form-text with-errors form-control-feedback" id="MerchantName"></div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for=""><span class="required_info">*</span> From Date<span class="required_info">(* click inside textbox)</span> </label>
										<input class="form-control" data-error="Select From Date" placeholder="Select From Date" required="required" type="text" id="datepicker1" name="from_Date">
										<div class="help-block form-text with-errors form-control-feedback" id="FromDate"></div>
									</div>
									<div class="form-group">
										<label for=""><span class="required_info">*</span> To Date<span class="required_info">(* click inside textbox)</span> </label>
										<input class="form-control" data-error="Select To Date" placeholder="Select To Date" required="required" type="text" id="datepicker2" name="till_Date">
										<div class="help-block form-text with-errors form-control-feedback" id="ToDate"></div>
									</div>
								</div>
							</div>	
								<div class="form-buttons text-center">	
									<input type="hidden" name="From_bill_date" id="From_bill_date" class="form-control" value="<?php echo $from_Date;?>" />	
									<input type="hidden" name="To_bill_date" id="To_bill_date" class="form-control" value="<?php echo $till_Date;?>" />
									<button class="btn btn-primary" type="submit" name="submit" id="submit" value="submit"> Submit</button>
								</div>
															
                    </div>
                </div>          
           
				<!-------------------- START - Data Table -------------------->	  
				<?php
				if($GeneratedSellerBill != NULL)
				{	
					
				?>	
                <div class="element-wrapper">                
                    <div class="element-box">
                        <h5 class="form-header">
                            Generated Merchant Invoice
                        </h5>                  
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice No.</th>
                                       
                                        <th>Purchased Amount (<?php echo $Symbol_currency; ?>)</th>
                                        <th>Gained <?php echo $Company_details->Currency_name; ?></th>
                                        <th>Invoice Rate</th>
                                        <th>Invoice Tax(%)</th>
                                        <th>Invoice Amount (<?php echo $Symbol_currency; ?>)</th>
                                        <th>Settled Amount (<?php echo $Symbol_currency; ?>)</th>
                                        <th>Balance Amount (<?php echo $Symbol_currency; ?>)</th>
                                       
                                        <th>Payment in (<?php echo $Symbol_currency; ?>)</th>

                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
										<th>#</th>
                                        <th>Invoice Date</th>
                                        <th>Invoice No.</th>
                                      
                                        <th>Purchased Amount (<?php echo $Symbol_currency; ?>)</th>
                                        <th>Gained <?php echo $Company_details->Currency_name; ?></th>
                                        <th>Invoice Rate</th>
                                        <th>Invoice Tax(%)</th>
                                        <th>Invoice Amount (<?php echo $Symbol_currency; ?>)</th>
                                        <th>Settled Amount (<?php echo $Symbol_currency; ?>)</th>
                                        <th>Balance Amount (<?php echo $Symbol_currency; ?>)</th>
                                       
                                        <th>Payment in (<?php echo $Symbol_currency; ?>)</th>
                                    </tr>
                                </tfoot>
                                <tbody>
								<?php foreach ($GeneratedSellerBill as $row) {
										
												/* Add_product_array(<?php echo $row->Trans_id; ?>,'<?php echo $row->Trans_id.'_'.$row->Seller.'_'.$row->Card_id.'_'.$row->Purchase_amount.'_'.$row->Loyalty_pts.'_' . $row->Manual_billno; ?>'); */
									?>
                                        <tr>
                                            <td> 
												<input data-type="check" name="Bill_id[]" id="<?php echo $row->Bill_no; ?>"  value="<?php echo $row->Bill_id.'_'.$row->Seller_id.'_'.$row->Bill_no; ?>" class="checkbox1" type="checkbox" onClick="Calsub_total(this.value);hideSHow(<?php echo $row->Bill_no; ?>);Add_product_array(<?php echo $row->Bill_no; ?>,'<?php echo $row->Bill_id.'_'.$row->Seller_id.'_'.$row->Bill_no; ?>',<?php echo $row->Bill_amount; ?>,0);">													
											</td>
											
											<td><?php echo date("j, F Y",strtotime($row->Creation_date)); ?></td>
											<td><?php echo $row->Bill_no; ?></td>							
																
											<td><?php echo $row->Bill_purchased_amount; ?></td>
																																														<td><?php echo $row->Joy_coins_issued; ?></td>
																																														<td><?php echo $row->Bill_rate; ?></td>
											<td><?php echo $row->Bill_tax; ?></td>
											
											<td><?php echo $row->Bill_amount; ?></td>
											<td><?php echo $row->Settlement_amount; ?></td>
											<td><b><?php echo number_format(($row->Bill_amount - $row->Settlement_amount),4); ?><b></td>
											
											
											
											<td>
												<input type="text" name="Paid_amount_<?php echo $row->Bill_no; ?>" id="Paid_amount_<?php echo $row->Bill_no; ?>"class="form-control" onkeypress="return isNumberKey(event)" placeholder="Enter Amount" onchange="Calsub_total('<?php echo "bill_bill_".$row->Bill_no; ?>');Add_product_array(<?php echo $row->Bill_no; ?>,'<?php echo $row->Bill_id.'_'.$row->Seller_id.'_'.$row->Bill_no; ?>',<?php echo $row->Bill_amount; ?>,this.value);" readonly />
											
												<input type="hidden" value="0" id="Total_points_div_<?php echo $row->Bill_no; ?>">
												<div class="help-block form-text with-errors form-control-feedback" id="CHKBOX_<?php echo $row->Bill_no; ?>"></div>
											</td>
											
											<input type="hidden" name="Bill_amount_<?php echo $row->Bill_no; ?>" id="Bill_amount_<?php echo $row->Bill_no; ?>" class="form-control" value="<?php echo $row->Bill_amount; ?>" />
											
											
											<input type="hidden" name="Settlement_amount_<?php echo $row->Bill_no; ?>" id="Settlement_amount_<?php echo $row->Bill_no; ?>" class="form-control" value="<?php echo $row->Settlement_amount; ?>" />
                                        </tr>
								<?php } ?>
                                </tbody>
								
								<tr>							
									<td colspan="9"></td>
									<td >Sub Total (<?php echo $Symbol_currency; ?>) </td>
									<th colspan="2">
									<input   type='text' pattern='[0-9]*'    name="Grand_total"    id="Grand_total" value="0" class="form-control" style="text-align: center;width:90px;" size="10"  readonly>
									<span class="required_info" id="insufficent_block" style="display:none;">Insufficient Current Balance !!!</span>
									</th>
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
							</div>
						</div>
						
						<div class="form-buttons text-center">	
							<input type="hidden" name="BillIDArray[]" id="BillIDArray" class="form-control"/>
							<button type="submit" name="Processed_Settlement" value="Processed_Settlement" id="Processed_Settlement" class="btn btn-primary">Processed Settlement</button>	
							<div class="help-block form-text with-errors form-control-feedback" id="MerchantSettlement"></div>				
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



	<div id="Trans_info">			
	</div>
	<div id="Referral_Trans_info">			
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
	if($('#Company_id').val() != "" &&  $('#Seller_id').val() != "" &&  $('#datepicker1').val() != "" &&  $('#datepicker2').val() != "")
	{
		show_loader();
	}
	
});

$('#Processed_Settlement').click(function()
{
	$("#Company_id").removeAttr("required");
	$("#Seller_id").removeAttr("required");
	$("#datepicker1").removeAttr("required");
	$("#datepicker2").removeAttr("required");
	
	console.log('Processed_Settlement');
	var count_checked = $("[name='Bill_id[]']:checked").length; // count the checked rows
	if(count_checked == 0) 
	{
		
		/* var Title = "Application Information";
		var msg = 'Please select atleast one checkbox to Processed Settlement';
		runjs(Title,msg); */
		
		console.log('Please select atleast one checkbox to Processed Settlement');
		$("#MerchantSettlement").html('Please select atleast one checkbox to Processed Settlement');
		return false;
	}
	else {
		
		var go = 0;
		var New_bill_amt=0;
		$("[name='Bill_id[]']:checked").each(function () {
		
			
			var Checked_chkbox=$(this).attr("id");
			// alert('--Checked_chkbox-----'+Checked_chkbox);		
			var BillAmt = $('#Bill_amount_'+Checked_chkbox).val();
			var PaidAmt = $('#Paid_amount_'+Checked_chkbox).val();
			var Settlement_amount = $('#Settlement_amount_'+Checked_chkbox).val();
			 
			New_bill_amt = parseFloat(BillAmt-Settlement_amount).toFixed(2);
			  
			 // alert('--BillAmt-----'+parseFloat(BillAmt)+'---PaidAmt---'+parseFloat(PaidAmt)+'--Settlement_amount--'+parseFloat(Settlement_amount));
			 
			 // alert('New_bill_amt---'+New_bill_amt);
			
			if(PaidAmt == "" || PaidAmt == 0) {				
				go = 0;
				/* var Title = "Application Information";
				var msg = 'Please Enter Paid Amount for '+Checked_chkbox+' ';
				runjs(Title,msg); */
				
				// console.log('Please Enter Paid Amount for '+Checked_chkbox+' ');
				$("#CHKBOX_"+Checked_chkbox).html('Please Enter Paid Amount for '+Checked_chkbox+' ');
				
				
				return false;
			} 
			if(parseFloat(PaidAmt) > parseFloat(New_bill_amt))
			{
				go = 0;	
				
				$('#Paid_amount_'+Checked_chkbox).val("");				
				/* var Title = "Application Information";
				var msg = 'Paid Amount is greater than Bill Amount for '+Checked_chkbox+' ';
				runjs(Title,msg); */

				// console.log('Paid Amount is greater than Bill Amount for '+Checked_chkbox+' ');		
				$("#CHKBOX_"+Checked_chkbox).html('Paid Amount is greater than Bill Amount for '+Checked_chkbox+' ');				
				return false;
				
			}
			if(parseFloat(PaidAmt) <= parseFloat(New_bill_amt))
			{				
				go = 1;
				
			}
		});		
		// console.log('--go-----'+go);
		if(go == 1)
		{
			
			if($('#Payment_type').val() == 2 || $('#Payment_type').val() == 3)
			{
				$("#Bank_name").attr("required","required");
				$("#Branch_name").attr("required","required");
				$("#Credit_Cheque_number").attr("required","required");
				
				$("#BankName").html("Enter Bank Name");
				$("#BranchName").html("Enter Branch Name of Bank");
				$("#CardNumber").html("Enter Cheque/Credit Number");
				
				
				if($('#Bank_name').val() != "" &&  $('#Branch_name').val() != "" &&  $('#Credit_Cheque_number').val() != "")
				{
					show_loader();
					return true;
				}
				
			}
			else
			{
				show_loader();
				return true;
			}		
			
		} 
		if(go == 0)
		{			
			return false;
		} 
		
	
	}
		
	
	return false;
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
function Add_product_array(BillNO,Details,BillAMT,PaidAMT)
{
	/* console.log('----BillNO----='+BillNO);
	console.log('----Details----='+Details);
	console.log('----BillAMT----='+BillAMT);
	console.log('----PaidAMT----='+PaidAMT); */
	var count_checked = ($('input[id='+BillNO+']:checked').length);	
	// console.log('----count_checked----='+count_checked);
	indexi = cart.map(function(e) { return e.Bill_no; }).indexOf(BillNO);	
	// console.log('----index----='+indexi);
	if(count_checked==1) {
		
		 // var found = jQuery.inArray(Item_id, cart);
		//const index = cart.findIndex(x => x.Item_id === Itemid);
		// console.log('----index----='+indexi);
		var item = { Bill_no: BillNO,Details: Details,BillAMT:BillAMT,PaidAMT:PaidAMT}; 
		if (indexi >= 0 ) {
			// Element was found, remove it.
			cart.splice(indexi, 1,item);
			$('#BillIDArray').val(JSON.stringify(cart));
			
		} else {
			// Element was not found, add it.
			var item = { Bill_no: BillNO,Details: Details,BillAMT:BillAMT,PaidAMT:PaidAMT}; 
			cart.push(item);
			// add_product_quantity_array(Itemid);
			$('#BillIDArray').val(JSON.stringify(cart));
		}
	}
	else{
		
		if (indexi >= 0 ) {
			// Element was found, remove it.
			cart.splice(indexi, 1);
			$('#BillIDArray').val(JSON.stringify(cart));
			
		} 
		
	}
	// console.log(cart);
}


function hideSHow(NewBill){
	
	var Product=document.getElementById(NewBill).checked;
	if(Product==true)
	{
		document.getElementById('Paid_amount_'+NewBill).readOnly = false;
	}
	else{
		document.getElementById('Paid_amount_'+NewBill).readOnly = true;
	}
	
}
function Calsub_total(BillNo)
{
	var SubTotal1=0;
	var SubTotal = $('#SubTotal').val();
	
	var NewBill;
     
		var arr = BillNo.split("_");
		NewBill=arr[2];
	
	var Product=document.getElementById(NewBill).checked;
	var Total_points=0;
	var Paid_amount=0;
	if(Product==true)
	{
		// alert('checked');
		
		var lv_Grand_total=document.getElementById('Grand_total').value;
		
		var prev_total_points=document.getElementById('Total_points_div_'+NewBill).value;
		var Paid_amount=document.getElementById('Paid_amount_'+NewBill).value;
		if(Paid_amount =="")
		{
			Paid_amount=0;
		}
		var Calc_Grand_total2=parseFloat(lv_Grand_total)-parseFloat(prev_total_points);
		document.getElementById('Total_points_div_'+NewBill).value=Paid_amount;
		Total_points=Paid_amount;
		var Calc_Grand_total=parseFloat(Calc_Grand_total2)+parseFloat(Total_points);
		
		document.getElementById('Grand_total').value=Calc_Grand_total.toFixed(2);
		
		/* alert('NewBill---'+NewBill);
		alert('lv_Grand_total---'+lv_Grand_total);
		alert('prev_total_points---'+prev_total_points);
		alert('Paid_amount---'+Paid_amount);
		alert('Calc_Grand_total2---'+Calc_Grand_total2);
		alert('Calc_Grand_total---'+Calc_Grand_total); */
		
		
	}
	else
	{	
		// alert('Unchecked');		
		var lv_Grand_total=document.getElementById('Grand_total').value;
		
		var prev_total_points=document.getElementById('Total_points_div_'+NewBill).value;
		var Paid_amount=document.getElementById('Paid_amount_'+NewBill).value;
		if(Paid_amount =="")
		{
			Paid_amount=0;
		}
		var Calc_Grand_total2=parseFloat(Paid_amount)-parseFloat(prev_total_points);
		document.getElementById('Total_points_div_'+NewBill).value=Calc_Grand_total2;
		Total_points=Paid_amount;
		var Calc_Grand_total=parseFloat(lv_Grand_total)-parseFloat(Total_points);
		
		document.getElementById('Grand_total').value=Calc_Grand_total.toFixed(2);
		
		document.getElementById('Paid_amount_'+NewBill).value=0;
		
		/* alert('NewBill---'+NewBill);
		alert('lv_Grand_total---'+lv_Grand_total);
		alert('prev_total_points---'+prev_total_points);
		alert('Paid_amount---'+Paid_amount);
		alert('Calc_Grand_total2---'+Calc_Grand_total2);
		alert('Calc_Grand_total---'+Calc_Grand_total); */	
		
	}	
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

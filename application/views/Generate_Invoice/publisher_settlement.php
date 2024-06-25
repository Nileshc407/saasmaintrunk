<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">Publisher Settlement</h6>
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
                          echo form_open('Settlement/Publisher_settlement', $attributes);
                        ?>   
							<div class="row">
								<div class="col-sm-6">
									
									<div class="form-group">
										<label for=""><span class="required_info">*</span>Select Publisher</label>
										<select class="form-control" data-error="Select Publisher" required="required" name="publisher" ID="publisher" onchange="Get_publisher_details(this.value);" >
											<option value="">Select Publisher</option>	
											<?php foreach($Pubblisher as $publisher) { ?>
										
													<option value="<?php echo $publisher['Register_beneficiary_id']; ?>"><?php echo $publisher['Beneficiary_company_name']; ?></option>

											<?php } ?>	
										</select>
										<div class="help-block form-text with-errors form-control-feedback" id="PublisherName"></div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for=""><span class="required_info">*</span> Invoice Number </label>	
										<input type="text" name="Bill_no" id="Bill_no" class="form-control" placeholder="Invoice no" data-error="Enter Invoice Number " required="required"  />						
										<div class="help-block form-text with-errors form-control-feedback" id="InvoiceNumber"></div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for=""><span class="required_info">*</span> From Date<span class="required_info">(* click inside textbox)</span> </label>
										<input class="form-control" data-error="Select From Date" placeholder="Select From Date" required="required" type="text" id="datepicker1" name="from_date">
										<div class="help-block form-text with-errors form-control-feedback" id="FromDate"></div>
									</div>
									<div class="form-group">
										<label for=""><span class="required_info">*</span> Purchased Miles</label>
										<input class="form-control" data-error="Select Purchased Miles"  placeholder="Purchased Miles"  required="required" type="text" id="Purchased_Miles" name="Purchased_Miles"  onchange="Calculate_amount(this.value);">
										<div class="help-block form-text with-errors form-control-feedback" id="PurchasedMiles"></div>
									</div>
									<div class="form-group">
										<label for=""><span class="required_info">*</span> Buy Rate</label>
										<input class="form-control" data-error="Enter Invoice Rate" placeholder="Enter Invoice Rate" required="required" type="text" id="Bill_rate" name="Bill_rate" readonly>
										<div class="help-block form-text with-errors form-control-feedback" id="BillRate"></div>
									</div>
									<div class="form-group">
										<label for=""><span class="required_info">*</span> Purchased Amount Before TAX</label>
										<input class="form-control" data-error="Enter Purchased Amount" placeholder="Purchased Amount" required="required" type="text" id="Bill_purchased_amount" name="Bill_purchased_amount" readonly>
										<div class="help-block form-text with-errors form-control-feedback" id="PurchasedAmount"></div>
									</div>
									<div class="form-group">
										<label for=""><span class="required_info">*</span> Invoice Tax(%). </label>
										<input class="form-control" data-error="Enter Invoice Tax" placeholder="Enter Invoice Tax" required="required" type="text" id="Bill_tax" name="Bill_tax" readonly>
										<div class="help-block form-text with-errors form-control-feedback" id="FromDate"></div>
									</div>
									<div class="form-group">
										<label for=""><span class="required_info">*</span> Invoice Amount After Tax </label>
										<input class="form-control" data-error="Enter Invoice Amount" placeholder="Enter Invoice Amount" required="required" type="text" id="Bill_amount" name="Bill_amount" readonly>
										<div class="help-block form-text with-errors form-control-feedback" id="BillAmount"></div>
									</div>
									<div class="form-group">
										<label for=""><span class="required_info">*</span> Balance To Pay </label>
										<input class="form-control" data-error="Enter Balance to Pay" placeholder="Enter Balance to Pay" required="required" type="text" id="Balance_to_bay" name="Balance_to_bay" readonly>
										<div class="help-block form-text with-errors form-control-feedback" id="BalancePay"></div>
									</div>
									<div class="form-group">
										<label for=""><span class="required_info">*</span> Settled Amount</label>
										<input class="form-control" data-error="Enter Settlement Amount" placeholder="Enter Settlement Amount" onkeypress="return isNumberKey(event)" required="required" type="text" id="Bill_settlement_amount" name="Bill_settlement_amount">
										<div class="help-block form-text with-errors form-control-feedback" id="SettlementAmount"></div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for=""><span class="required_info">*</span> To Date<span class="required_info">(* click inside textbox)</span> </label>
										<input class="form-control" data-error="Select To Date" placeholder="Select To Date" required="required" type="text" id="datepicker2" name="till_Date">
										<div class="help-block form-text with-errors form-control-feedback" id="ToDate"></div>
									</div>
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
										<div class="help-block form-text with-errors form-control-feedback" id="Paymentby"></div>
									</div>
									<div id="cheque_block" style="display:none;">
										<div class="panel-heading"><label for="exampleInputEmail1" id="labelME2">Cheque Details</label></div>
										
										<div class="form-group">
											<label for="exampleInputEmail1"><span class="required_info">*</span>Bank Name</label>
											<input type="text" name="Bank_name" id="Bank_name"    class="form-control" placeholder="Enter Bank Name"  />
											<div class="help-block form-text with-errors form-control-feedback" id="BankName"></div>
										</div>
										 
										<div class="form-group">
											<label for="exampleInputEmail1"><span class="required_info">*</span>Branch Name of Bank</label>
											<input type="text" name="Branch_name" id="Branch_name" class="form-control" placeholder="Enter Branch Name of Bank"  />
											<div class="help-block form-text with-errors form-control-feedback" id="BranchName"></div>
										</div>
										<div class="form-group">
											<label for="exampleInputEmail1" id="labelME"><span class="required_info">*</span>Cheque/Credit Card Number</label>
											<input type="text" name="Credit_Cheque_number" id="Credit_Cheque_number" class="form-control" placeholder="Enter Number Cheque/Credit"  />
											<div class="help-block form-text with-errors form-control-feedback" id="CardNumber"></div>
										</div>
									</div>
									<div class="form-group">
										<label for="">Remarks</label>
										<input type="text" name="Remarks" id="Remarks" class="form-control" placeholder="Remarks" />
									</div>
								</div>
							</div>	
								<div class="form-buttons text-center">	
									<input type="hidden" name="From_bill_date" id="From_bill_date" class="form-control" value="<?php echo $from_Date;?>" />	
									<input type="hidden" name="To_bill_date" id="To_bill_date" class="form-control" value="<?php echo $till_Date;?>" />
									<input type="hidden" name="Company_id" id="Company_id" class="form-control" value="<?php echo $Company_details->Company_id; ?>" />
									<button class="btn btn-primary" type="submit" name="submit" value="Register" id="Register"> Submit</button>
									<button type="reset" id="reset" class="btn btn-primary">Reset</button>
								</div>
															
                    </div>
                </div>          
           
				<!-------------------- START - Data Table ---------id="transaction_report_table"----------->					
                <div class="element-wrapper" id="Settled_Bill_div" style="display:none;">                
                    <div class="element-box">
                        <h5 class="form-header">
                            Settled Invoice Details
                        </h5>                  
                        <div class="table-responsive"> 
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont" >
                                <thead>
                                    <tr>
										<th>Invoice No</th>
										<th>Purchased Amount Before TAX</th>
										<th>Buy rate</th>
										<th>Invoice TAX(%)</th>
										<th>Invoice Amount After Tax</th>
										<th>Settled Amount</th>
										<th>Payment Type</th>
										<th>Bank Name</th>
										<th>Branch Name</th>
										<th>Credit/ Cheque Number</th>
										<th>Remarks</th>

                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
										<th>Invoice No</th>
										<th>Purchased Amount Before TAX</th>
										<th>Buy rate</th>
										<th>Invoice TAX(%)</th>
										<th>Invoice Amount After Tax</th>
										<th>Settled Amount</th>
										<th>Payment Type</th>
										<th>Bank Name</th>
										<th>Branch Name</th>
										<th>Credit/ Cheque Number</th>
										<th>Remarks</th>
                                    </tr>
                                </tfoot>
								
							
                                
								
								
                            </table>
                        </div>
                    </div>
                </div>
				
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


$('#Bill_amount').change(function() // Get All Paid Invoice Details 
{
	var Bill_amount= $('#Bill_amount').val();	 
	
	if($('#Balance_to_bay').val() =="")
	{
		$('#Balance_to_bay').val(Bill_amount);
	}
	
});
function Calculate_amount(PurchasedMiles){
		
	// alert('--PurchasedMiles----'+PurchasedMiles);
		
	var BillTax=$('#Bill_tax').val();
	var BillRate=$('#Bill_rate').val();
	var PurchasedMiles=$('#Purchased_Miles').val();
	var BillPurchasedAmount=$('#Bill_purchased_amount').val();
	var BillAmount=$('#Bill_amount').val();
	var Balancetobay=$('#Balance_to_bay').val();
	
	
		var New_BillPurchasedAmount = parseFloat(PurchasedMiles*BillRate);
		
		
		
		
	
		
		var New_TaxableAmount=parseFloat((New_BillPurchasedAmount*BillTax)/100);
		
		
		
		var New_BillAmount=parseFloat(New_TaxableAmount)+parseFloat(New_BillPurchasedAmount);
		
		New_BillAmount=parseFloat(New_BillAmount).toFixed(4);
		New_BillPurchasedAmount=parseFloat(New_BillPurchasedAmount).toFixed(4)
		$('#Bill_purchased_amount').val(New_BillPurchasedAmount);
		$('#Bill_amount').val(New_BillAmount);		
		$('#Balance_to_bay').val(New_BillAmount);
		
	
		/* alert('--New_BillPurchasedAmount----'+New_BillPurchasedAmount);
		alert('--New_TaxableAmount----'+New_TaxableAmount);
		alert('--New_BillAmount----'+New_BillAmount); */
		
		
	}
	function Get_publisher_details(InputVal)
	{
		console.log("--InputVal--"+InputVal);
		
		var Company_id = '<?php echo $Company_id; ?>';
		var Bill_no = $('#Bill_no').val();
		var publisher = InputVal;
		
		
		if($("#publisher").val() == "" ) {
			
			$("#PublisherName").html("Please Select Publisher");
			$("#publisher").addClass("form-control has-error");
			
		} else {
			
			$("#PublisherName").html("");
			$("#publisher").removeClass("has-error");
			
			
			$.ajax({
				type: "POST",
				data: {Company_id:Company_id,publisher:publisher},
				url: "<?php echo base_url()?>index.php/Settlement/Get_publisher_details",
				dataType: "json",
				success: function(json)
				{
					if(json['Error_flag'] == 1) // Status Is OK
					{
												
						$('#Bill_tax').val(json['Tax']);
						$('#Bill_rate').val(json['Buy_rate']);
							
					} else {
						
						$('#Bill_tax').val("");
						$('#Bill_rate').val("");
					}
				}
				
				});
		}
	}
	
function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 
	&& (charCode < 48 || charCode > 57))
	 return false;

  return true;
}



$('#Register').click(function()
{
	// $("#Company_id").attr("required","required");
	$("#Seller_id").attr("required","required");
	$("#datepicker1").attr("required","required");
	$("#datepicker2").attr("required","required");
	$("#Bill_no").attr("required","required");
	$("#Purchased_Miles").attr("required","required");
	$("#Bill_rate").attr("required","required");
	$("#Bill_purchased_amount").attr("required","required");
	$("#Bill_tax").attr("required","required");
	$("#Bill_amount").attr("required","required");
	$("#Bill_settlement_amount").attr("required","required");
	$("#Payment_type").attr("required","required");
	
	
	if( $('#Company_id').val() != "" &&  $('#Seller_id').val() != "" && $('#Bill_no').val() != "" &&  $('#datepicker1').val() != "" &&  $('#datepicker2').val() != "" &&  $('#Purchased_Miles').val() != "" &&  $('#Bill_rate').val() != "" &&  $('#Bill_purchased_amount').val() != "" &&  $('#Bill_tax').val() != "" &&  $('#Bill_amount').val() != "" &&  $('#Bill_settlement_amount').val() != "" &&  $('#Payment_type').val() != "")
	{
		// var Payment_type = $("#Payment_type").val();
		var Bank_name = $("#Bank_name").val();
		var Branch_name = $("#Branch_name").val();
		var Credit_Cheque_number = $("#Credit_Cheque_number").val();
		var Bill_settlement_amount = $('#Bill_settlement_amount').val();
		var Total_Paid_amount = $('#Total_Paid_amount').val();
		var Bill_amount = $('#Bill_amount').val();
		
		
		var New_bill_amount=parseFloat(Bill_amount).toFixed(4);
		var New_Bill_settlement_amount=parseFloat(Bill_settlement_amount).toFixed(4);
		
		
		
		
		var New_sattled_amount = (parseFloat(Bill_settlement_amount)+parseFloat(Total_Paid_amount)).toFixed(4);

		
		// alert('Bill_amount---'+Bill_amount+'----Bill_settlement_amount------'+Bill_settlement_amount+'----Total_Paid_amount---'+Total_Paid_amount+'---New_sattled_amount---------'+New_sattled_amount+'----New_bill_amount-----'+New_bill_amount);
		//return false;
		if(parseFloat(New_Bill_settlement_amount) < 0 )
		{
			
			var Title = "Application Information";
			var msg = ' Please enter Settled Amount greater than 0.';
			runjs(Title,msg);							
			return false;			
		}
		if( parseFloat(New_sattled_amount)  > parseFloat(New_bill_amount) )
		{
			var Title = "Application Information";
			var msg = 'Settled Amount is greater than Invoice Amount. ';
			runjs(Title,msg);							
			return false;			
		}		
		if($('#Payment_type').val() == 2 || $('#Payment_type').val() == 3)
		{
			$("#Bank_name").attr("required","required");
			$("#Branch_name").attr("required","required");
			$("#Credit_Cheque_number").attr("required","required");
			
			if($('#Bank_name').val() != "" &&  $('#Branch_name').val() != "" &&  $('#Credit_Cheque_number').val() != "")
			{
				show_loader();
			}
			
		}
		else
		{
			show_loader();
		}
		
		
	}
});



$('#Bill_no').change(function() // Get All Paid Invoice Details 
{	
	
		var Company_id = '<?php echo $Company_id; ?>';
		var Bill_no = $('#Bill_no').val();
		var publisher = $('#publisher').val();
		
		if($("#Bill_no").val() == ""  ) //|| (Bill_no.length < 3)
		{
			$("#Bill_no").val("");
			// has_error("#Bill_no_feedback","#glyphicon","#Bill_no_help","Please Enter Valid Invoice Number!!");
			
			$("#InvoiceNumber").html("Please Enter Valid Invoice Number");
			$("#Bill_no").addClass("form-control has-error");
		}
		else if($("#publisher").val() == "" ) {
			
			// $("#Bill_no").val("");
			// has_error("#Bill_no_feedback","#glyphicon","#Bill_no_help","Please select publisher");
			$("#PublisherName").html("Please Select Publisher");
			$("#publisher").addClass("form-control has-error");
			
		}
		else
		{
			
			$("#InvoiceNumber").html("");
			$("#Bill_no").removeClass("has-error");
			$("#PublisherName").html("");
			$("#publisher").removeClass("has-error");
			
			$.ajax({
				type: "POST",
				data: {Bill_no:Bill_no,Company_id:Company_id,publisher:publisher},
				url: "<?php echo base_url()?>index.php/Settlement/get_bill_details",
				dataType: "json",
				success: function(json)
				{
					
					console.log('----Bill_no----get_bill_details---Error_flag---'+json['Error_flag']);
					if(json['Error_flag'] == 1) // Status Is OK
					{	
						  
						  
						$("#transaction_report_table").find("tr:gt(0)").remove();							
						$("#Settled_Bill_div").css("display","block");	
						
						
						$('#Total_Paid_amount').val(json['Total_Paid_amount']);
						 
						var balance_toPay = (parseFloat(json['Billamount']) - parseFloat(json['Total_Paid_amount'])).toFixed(2);
						 
						 $('#Balance_to_bay').val(balance_toPay);
						 
						var tblvals = "";
						var getVals = json['bill_details']; 
						
						
						var t = $('#dataTable1').DataTable();
						var counter = 1;
						$.each(getVals, function(key,value)
						{
							
							tblvals = "<tr><td>"+value['Bill_no']+"</td>";
							tblvals += "<td>"+value['Bill_purchased_amount']+"</td>";
							tblvals += "<td>"+value['Bill_rate']+"</td>";
							tblvals += "<td>"+value['Bill_tax']+"</td>";
							tblvals += "<td>"+value['Bill_amount']+"</td>";
							tblvals += "<td>"+value['Paid_amount']+"</td>";
							tblvals += "<td>"+value['Payment_type']+"</td>";
							tblvals += "<td>"+value['Bank_name']+"</td>";
							tblvals += "<td>"+value['Branch_name']+"</td>";
							tblvals += "<td>"+value['Credit_Cheque_number']+"</td>";
							tblvals += "<td>"+value['Remarks']+"</td></tr>";
							
							// console.log('----tblvals--'+tblvals);
							
							t.row.add([
									value['Bill_no'],
									value['Bill_purchased_amount'],
									value['Bill_rate'],
									value['Bill_tax'],
									value['Bill_amount'],
									value['Paid_amount'],
									value['Payment_type'],
									value['Bank_name'],
									value['Branch_name'],
									value['Credit_Cheque_number'],
									value['Remarks']
								]).draw( false );
						 
								// counter++;
							
							// $("#transaction_report_table>tbody:last-child").append(tblvals);
							// $("tbody").append(tblvals);
							
						
							

								
						});
						
						$("#InvoiceNumber").html("");
						
					}
					if(json['Error_flag'] == 0) // Status Is OK
					{
						
						// console.log("Invoice No records not found");
						$('#Total_Paid_amount').val(0);
						$("#InvoiceNumber").html("Invoice No records not found");
						// var balance_toPay = (parseFloat(json['Billamount']) - parseFloat(json['Total_Paid_amount'])).toFixed(2);
						 
						 // $('#Balance_to_bay').val(balance_toPay);
						/* 						
						$('#Bill_purchased_amount').val("");
						$('#Bill_tax').val("");
						$('#Bill_rate').val("");
						$('#Bill_amount').val("");
						$('#Bill_settlement_amount').val("");
						$('#Purchased_Miles').val("");
						$('#Bill_flag').val("");
						$('#Settlement_flag').val("");							
						$("#Register").show();
						$("#reset").show();
						has_error("#Bill_no_feedback","#glyphicon","#Bill_no_help","Invoice No records not found"); 
						
						*/
						
					}
					
				}
			});
		}
	});
	

$('#publisher').change(function() // Get All Paid Invoice Details 
{	
	console.log('publisher');
	
		var Company_id = '<?php echo $Company_id; ?>';
		var Bill_no = $('#Bill_no').val();
		var publisher = $('#publisher').val();
		
		if($("#Bill_no").val() == "" ) //|| (Bill_no.length < 3) 
		{
			$("#Bill_no").val("");
			// has_error("#Bill_no_feedback","#glyphicon","#Bill_no_help","Please Enter Valid Invoice Number!!");
			
			$("#InvoiceNumber").html("Please Enter Valid Invoice Number");
			$("#Bill_no").addClass("form-control has-error");
			
		}
		else if($("#publisher").val() == "" ) {
			
			// $("#Bill_no").val("");
			// has_error("#Bill_no_feedback","#glyphicon","#Bill_no_help","Please select publisher");
			$("#PublisherName").html("Please select publisher");
			$("#publisher").addClass("form-control has-error");
			
		}
		else
		{
			console.log('publisher-----has-error-----');
			
			$("#InvoiceNumber").html("");
			$("#publisher").removeClass("has-error");
			$("#PublisherName").html("");
			$("#publisher").removeClass("has-error");
			
			
			$.ajax({
				type: "POST",
				data: {Bill_no:Bill_no,Company_id:Company_id,publisher:publisher},
				url: "<?php echo base_url()?>index.php/Settlement/get_bill_details",
				dataType: "json",
				success: function(json)
				{
					
					//alert('----publisher----get_bill_details---Error_flag---'+json['Error_flag']);
					if(json['Error_flag'] == 1) // Status Is OK
					{	
						  
						  
						$("#transaction_report_table").find("tr:gt(0)").remove();							
						$("#Settled_Bill_div").css("display","block");						 
						
						
						$('#Total_Paid_amount').val(json['Total_Paid_amount']);
						 
						var balance_toPay = (parseFloat(json['Billamount']) - parseFloat(json['Total_Paid_amount'])).toFixed(2);
						 
						 $('#Balance_to_bay').val(balance_toPay);
						 
						var tblvals = "";
						var getVals = json['bill_details']; 
						
						var t = $('#dataTable1').DataTable();
						
						$.each(getVals, function(key,value)
						{
							tblvals = "<tr><td>"+value['Bill_no']+"</td>";
							tblvals += "<td>"+value['Bill_purchased_amount']+"</td>";
							tblvals += "<td>"+value['Bill_rate']+"</td>";
							tblvals += "<td>"+value['Bill_tax']+"</td>";
							tblvals += "<td>"+value['Bill_amount']+"</td>";
							tblvals += "<td>"+value['Paid_amount']+"</td>";
							tblvals += "<td>"+value['Payment_type']+"</td>";
							tblvals += "<td>"+value['Bank_name']+"</td>";
							tblvals += "<td>"+value['Branch_name']+"</td>";
							tblvals += "<td>"+value['Credit_Cheque_number']+"</td>";
							tblvals += "<td>"+value['Remarks']+"</td></tr>";
							// $("#transaction_report_table > tbody:last-child").append(tblvals);	

							
							t.row.add([
									value['Bill_no'],
									value['Bill_purchased_amount'],
									value['Bill_rate'],
									value['Bill_tax'],
									value['Bill_amount'],
									value['Paid_amount'],
									value['Payment_type'],
									value['Bank_name'],
									value['Branch_name'],
									value['Credit_Cheque_number'],
									value['Remarks']
								]).draw( false );
							
							
						});
						
					}
					if(json['Error_flag'] == 0) // Status Is OK
					{
						
						$("#Settled_Bill_div").css("display","none");
						$('#Total_Paid_amount').val(0);
						 
						// var balance_toPay = (parseFloat(json['Billamount']) - parseFloat(json['Total_Paid_amount'])).toFixed(2);
						 
						 // $('#Balance_to_bay').val(balance_toPay);
											
						$('#Bill_purchased_amount').val("");
						//$('#Bill_tax').val("");
						//$('#Bill_rate').val("");
						$('#Bill_amount').val("");
						$('#Bill_settlement_amount').val("");
						$('#Purchased_Miles').val("");
						$('#Bill_flag').val("");
						$('#Settlement_flag').val("");							
						$('#Balance_to_bay').val("");							
						
						$('#datepicker1').val("");
						$('#datepicker2').val("");
						$("#datepicker1").removeAttr("readonly");
						$("#datepicker2").removeAttr("readonly");
						
						$("#Purchased_Miles").removeAttr("readonly");
						$("#Payment_type").removeAttr("readonly");
						$("#Bill_settlement_amount").removeAttr("readonly");
						
						
						
						
						// has_error("#Bill_no_feedback","#glyphicon","#Bill_no_help",""); 
						
						
						$("#Register").show();
						$("#reset").show();
						
						
					}
					
				}
			});
		}
	});

	$('#Bill_no').blur(function() // Get Invoice Details 
	{	
		console.log('Bill_no');
		var Company_id = '<?php echo $Company_id; ?>';
		var Bill_no = $('#Bill_no').val();
		var publisher = $('#publisher').val();
		
		if($("#Bill_no").val() == ""  ) //|| (Bill_no.length < 3)
		{
			$("#Bill_no").val("");
			// has_error("#Bill_no_feedback","#glyphicon","#Bill_no_help","Please Enter Valid Invoice Number!!");
			$("#InvoiceNumber").html("Please Enter Valid Invoice Number");
			$("#Bill_no").addClass("form-control has-error");
			
		}
		else if($("#publisher").val() == "" ) {
			
			// $("#Bill_no").val("");
			// has_error("#Bill_no_feedback","#glyphicon","#Bill_no_help","Please select publisher");
			
			$("#PublisherName").html("Please select publisher");
			$("#publisher").addClass("form-control has-error");
			
		}
		else
		{
			
			$("#InvoiceNumber").html("");
			$("#Bill_no").removeClass("has-error");
			$("#PublisherName").html("");
			$("#publisher").removeClass("has-error");
			
			
			$.ajax({
				type: "POST",
				data: {Bill_no:Bill_no,Company_id:Company_id,publisher:publisher},
				url: "<?php echo base_url()?>index.php/Settlement/check_bill_no",
				dataType: "json",
				success: function(json)
				{
					//alert('----Bill_no----check_bill_no---Error_flag---'+json['Error_flag']);
					if(json['Error_flag'] == 1) // Status Is OK
					{	
					
					
						$("#Bill_purchased_amount").attr("readonly","true");
						$("#Bill_tax").attr("readonly","true");
						$("#Bill_rate").attr("readonly","true");
						$("#Bill_amount").attr("readonly","true");
						$("#Purchased_Miles").attr("readonly","true");
						$("#datepicker1").attr("readonly","true");
						$("#datepicker2").attr("readonly","true");
						
						
						
						  
						$('#Bill_purchased_amount').val(json['Bill_purchased_amount']);
						$('#datepicker1').val(json['From_bill_date']);
						$('#datepicker2').val(json['To_bill_date']);
						$('#Bill_tax').val(json['Bill_tax']);
						$('#Bill_rate').val(json['Bill_rate']);
						$('#Bill_amount').val(json['Bill_amount']);
						
						$('#Purchased_Miles').val(json['Joy_coins_issued']);
						$('#Bill_flag').val(json['Bill_flag']);
						$('#Settlement_flag').val(json['Settlement_flag']);
						
						if(json['Settlement_flag']==1 && json['Bill_flag']==1) {
							
							// has_success("#Bill_no_feedback","#glyphicon","#Bill_no_help","Invoice No has been settled. Please see the below table.");
							
							
							$("#Bill_purchased_amount").attr("readonly","true");
							$("#Bill_tax").attr("readonly","true");
							$("#Bill_rate").attr("readonly","true");
							$("#Bill_amount").attr("readonly","true");
							$("#Purchased_Miles").attr("readonly","true");
							$("#Bill_settlement_amount").attr("readonly","true");							
							$("#Balance_to_bay").attr("readonly","true");
							$("#Payment_type").attr("readonly","true");
							
							$("#Bill_settlement_amount").val(json['Bill_amount']);
							
							
							$("#Register").hide();
							$("#reset").hide();
							
							
						} else if(json['Settlement_flag']==0 && json['Bill_flag']==1) {
							
							$("#Bill_purchased_amount").attr("readonly","true");
							$("#Bill_tax").attr("readonly","true");
							$("#Bill_rate").attr("readonly","true");
							$("#Bill_amount").attr("readonly","true");
							$("#Purchased_Miles").attr("readonly","true");
							
							$("#Bill_settlement_amount").removeAttr("readonly");
							$("#Balance_to_bay").attr("readonly","true");
							
							
							$("#Register").show();
							$("#reset").show();
							// has_success("#Bill_no_feedback","#glyphicon","#Bill_no_help","Invoice No has been partially settled. Please see the below table.");
							
						} else {						
							
							$("#Register").show();
							$("#reset").show();
							
							
							$('#datepicker1').val("");
							$('#datepicker2').val("");
							$('#Bill_purchased_amount').val("");
							$('#Bill_tax').val("");
							$('#Bill_rate').val("");
							$('#Bill_amount').val("");
							$('#Bill_settlement_amount').val("");
							$('#Purchased_Miles').val("");
							$('#Bill_flag').val("");
							$('#Settlement_flag').val("");
							// has_success("#Bill_no_feedback","#glyphicon","#Bill_no_help","");
							
						}
							
					}
					if(json['Error_flag'] == 0) // Status Is OK
					{
						$("#Settled_Bill_div").css("display","none");
						$('#Total_Paid_amount').val(0);
						 
						$('#Bill_purchased_amount').val("");
						$('#Bill_amount').val("");
						$('#Bill_settlement_amount').val("");
						$('#Purchased_Miles').val("");
						$('#Bill_flag').val("");
						$('#Settlement_flag').val("");							
						
						$('#datepicker1').val("");
						$('#datepicker2').val("");
						
						
						$("#Purchased_Miles").removeAttr("readonly");
						$("#datepicker1").removeAttr("readonly");
						$("#datepicker2").removeAttr("readonly");
						$("#Payment_type").removeAttr("readonly");
						$("#Bill_settlement_amount").removeAttr("readonly");
						
						
						
						
						
						
						$("#Register").show();
						$("#reset").show();
						$("#Settled_Bill_div").css("display","none");
						
						// has_error("#Bill_no_feedback","#glyphicon","#Bill_no_help","");
						
					}
					
				}
			});
		}
	});

	$('#publisher').blur(function() // Get Invoice Details 
	{	
		
		var Company_id = '<?php echo $Company_id; ?>';
		var Bill_no = $('#Bill_no').val();
		var publisher = $('#publisher').val();
		
		if($("#Bill_no").val() == ""  ) //|| (Bill_no.length < 3)
		{
			$("#Bill_no").val("");
			// has_error("#Bill_no_feedback","#glyphicon","#Bill_no_help","Please Enter Valid Invoice Number!!");
			$("#InvoiceNumber").html("Please Enter Valid Invoice Number");
			$("#publisher").addClass("form-control has-error");
		}
		else if($("#publisher").val() == "" ) {
			
			// $("#Bill_no").val("");
			// has_error("#Bill_no_feedback","#glyphicon","#Bill_no_help","Please select publisher");
			$("#PublisherName").html("Please Select Publisher");
			$("#publisher").addClass("form-control has-error");
			
		}
		else
		{
			
			
			console.log('-publisher--3--');
			$("#InvoiceNumber").html("");
			$("#publisher").removeClass("has-error");
			$("#PublisherName").html("");
			$("#publisher").removeClass("has-error");
			
			$.ajax({
				type: "POST",
				data: {Bill_no:Bill_no,Company_id:Company_id,publisher:publisher},
				url: "<?php echo base_url()?>index.php/Settlement/check_bill_no",
				dataType: "json",
				success: function(json)
				{
					//alert('-----publisher-----check_bill_no---Error_flag---'+json['Error_flag']);
					if(json['Error_flag'] == 1) // Status Is OK
					{	
					
					
						$("#Bill_purchased_amount").attr("readonly","true");
						$("#Bill_tax").attr("readonly","true");
						$("#Bill_rate").attr("readonly","true");
						$("#Bill_amount").attr("readonly","true");
						$("#Purchased_Miles").attr("readonly","true");
						$("#datepicker1").attr("readonly","true");
						$("#datepicker2").attr("readonly","true");
						
						  
						$('#Bill_purchased_amount').val(json['Bill_purchased_amount']);
						$('#datepicker1').val(json['From_bill_date']);
						$('#datepicker2').val(json['To_bill_date']);
						
						$('#Bill_tax').val(json['Bill_tax']);
						$('#Bill_rate').val(json['Bill_rate']);
						$('#Bill_amount').val(json['Bill_amount']);
						
						$('#Purchased_Miles').val(json['Joy_coins_issued']);
						$('#Bill_flag').val(json['Bill_flag']);
						$('#Settlement_flag').val(json['Settlement_flag']);
						
						if(json['Settlement_flag']==1 && json['Bill_flag']==1) {
							
							// has_success("#Bill_no_feedback","#glyphicon","#Bill_no_help","Invoice No has been settled. Please see the below table.");
							
							// $("#InvoiceNumber").html("Invoice No has been settled. Please see the below table");
							$("#InvoiceNumber").html("Invoice No has been partially settled. Please see the below table");
							
							$("#Bill_purchased_amount").attr("readonly","true");
							$("#Bill_tax").attr("readonly","true");
							$("#Bill_rate").attr("readonly","true");
							$("#Bill_amount").attr("readonly","true");
							$("#Purchased_Miles").attr("readonly","true");
							$("#Bill_settlement_amount").attr("readonly","true");							
							$("#Balance_to_bay").attr("readonly","true");
							$("#Payment_type").attr("readonly","true");
							
							$("#Bill_settlement_amount").val(json['Bill_amount']);
							
							
							$("#Register").hide();
							$("#reset").hide();
							
							
						} else if(json['Settlement_flag']==0 && json['Bill_flag']==1) {
							
							$("#Bill_purchased_amount").attr("readonly","true");
							$("#Bill_tax").attr("readonly","true");
							$("#Bill_rate").attr("readonly","true");
							$("#Bill_amount").attr("readonly","true");
							$("#Purchased_Miles").attr("readonly","true");
							
							$("#Bill_settlement_amount").removeAttr("readonly");
							$("#Balance_to_bay").attr("readonly","true");
							
							
							$("#Register").show();
							$("#reset").show();
							// has_success("#Bill_no_feedback","#glyphicon","#Bill_no_help","Invoice No has been partially settled. Please see the below table.");
							
							$("#InvoiceNumber").html("Invoice No has been partially settled. Please see the below table");
							
						} else {						
							
							$("#Register").show();
							$("#reset").show();
							
							
							
							$('#Bill_purchased_amount').val("");
							$('#Bill_tax').val("");
							$('#Bill_rate').val("");
							$('#Bill_amount').val("");
							$('#Bill_settlement_amount').val("");
							$('#Purchased_Miles').val("");
							$('#Bill_flag').val("");
							$('#Settlement_flag').val("");
							// has_success("#Bill_no_feedback","#glyphicon","#Bill_no_help","");
							
						}
						
						
						
							
					}
					if(json['Error_flag'] == 0) // Status Is OK
					{
						$("#Settled_Bill_div").css("display","none");
						$('#Total_Paid_amount').val(0);
						 
						$('#Bill_purchased_amount').val("");
						$('#Bill_amount').val("");
						$('#Bill_settlement_amount').val("");
						$('#Purchased_Miles').val("");
						$('#Bill_flag').val("");
						$('#Settlement_flag').val("");							
						
						$('#datepicker1').val("");
						$('#datepicker2').val("");
						
						$("#Purchased_Miles").removeAttr("readonly");
						$("#datepicker1").removeAttr("readonly");
						$("#datepicker2").removeAttr("readonly");
						$("#Payment_type").removeAttr("readonly");
						$("#Bill_settlement_amount").removeAttr("readonly");
						
						
						
						
						
						
						$("#Register").show();
						$("#reset").show();
						$("#Settled_Bill_div").css("display","none");
						// has_error("#Bill_no_feedback","#glyphicon","#Bill_no_help","");
						
					}
					
				}
			});
		}
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

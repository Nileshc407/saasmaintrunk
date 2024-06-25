<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-7">
                <div class="element-wrapper">
                    <h6 class="element-header">COMPANY DEPOSIT/ MERCHANT TOPUP</h6>
                    <div class="element-box">

						 <?php
                          if (@$this->session->flashdata('success_code')) {
                            ?>	
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('success_code') . ' ' . $this->session->flashdata('data_code'); ?>
                            </div>
                          <?php } ?>
                        <?php
                          if (@$this->session->flashdata('error_code')) {
                            ?>	
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('error_code') . ' ' . $this->session->flashdata('data_code'); ?>
                            </div>
                          <?php } ?>
					
                        <?php
                          $attributes = array('id' => 'formValidate');
                          echo form_open('Administration/insert_deposit_topup', $attributes);
                        ?>
                        <div class="form-group">
                            <label for=""> Company Name</label>
							<select class="form-control" name="Company_id" id="Company_id" data-error="Select Company" required="required" >
								<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
							</select>
						
                            <div class="help-block form-text with-errors form-control-feedback" id="BillNumber"></div>
                        </div>
						<div class="form-group">
							<label for="exampleInputEmail1"><span class="required_info">*</span> Transaction Type </label></label>
							<select class="form-control" name="Trans_type"  id="Trans_type2" onchange="javascript:showhideseller(this.value);" data-error="Select Transaction Type" required="required">
							<option value="">Select Transaction Type</option>
							<?php
								foreach($Transaction_type_array as $Transaction_type)
								{
									if($Transaction_type->Trans_type_id==5 || $Transaction_type->Trans_type_id==6)
									{
										echo "<option value=".$Transaction_type->Trans_type_id.">".$Transaction_type->Trans_type."</option>";
									}
								}
							?>
							</select>			
							<div class="help-block form-text with-errors form-control-feedback" id="TransactionType"></div>
						</div> 						
                                                                     
                        <div class="form-group">
                            <label for="exampleInputEmail1"><span class="required_info">*</span> Transaction Amount</label>
                            <input type="text" name="Amt_transaction" id="Amt_transaction2" value="" data-error="Enter Transaction Amount" required="required" placeholder="Enter Transaction Amount"    onkeypress="return isNumberKey2(event)"class="form-control" />								
                            <div class="help-block form-text with-errors form-control-feedback" id="TransactionAmount"></div>
                        </div>						
						<div class="form-group"  id="block2">
							<label for="exampleInputEmail1"><span class="required_info">*</span> Merchant Name </label></label>
							<select class="form-control" name="Seller_id"  id="Seller_id" onchange="call(this.value);" data-error="Select Merchant" required="required">
							<option value="">Select Merchant</option>
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
							<div class="help-block form-text with-errors form-control-feedback" id="MerchantName"></div>
						</div>  
						                    
						<div class="form-group">
							<label class="col-sm-6 col-form-label">Is it Exception Transaction </label>
							<div class="col-sm-6">
								<div class="form-check">
									<label class="form-check-label">
										<input class="form-check-input" name="Exception_flag"  id="Exception_flag"  type="radio" value="0" onclick="javascript:showhide(this.value);" checked >No
									</label>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<label class="form-check-label">
										<input class="form-check-input" name="Exception_flag" type="radio"  id="Exception_flag" value="1"  onclick="javascript:showhide(this.value);">Yes
									</label>
									<div class="help-block form-text with-errors form-control-feedback" id="ExceptionTransaction"></div>
								</div>

							</div>
						</div>
                        
						<div class="form-group" id="block1">
                            <label for=""> <span class="required_info">*</span> Payment by </label>
                            <select class="form-control" name="Payment_type" id="Payment_type" required  onchange="show_payment(this.value)" >
							<?php
							  foreach ($Payment_array as $Payment) {
								echo "<option value=" . $Payment->Payment_type_id . ">" . $Payment->Payment_type . "</option>";
							  }
							?>
                            </select>
                        </div>
                        <div id="cheque_block" style="display:none;">
                            <div class="panel-heading"><label for="exampleInputEmail1"  id="labelME2">Cheque Details</label></div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Bank Name</label>
                                <input type="text" name="Bank_name" data-error="Enter Bank Name"  id="Bank_name" class="form-control" placeholder="Enter Bank Name"  />
                                <div class="help-block form-text with-errors form-control-feedback" id="BankName"></div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Branch Name of Bank</label>
                                <input type="text" name="Branch_name" data-error="Enter Branch Name of Bank" id="Branch_name" class="form-control" placeholder="Enter Branch Name of Bank"  />
                                <div class="help-block form-text with-errors form-control-feedback" id="BranchName"></div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" id="labelME">Cheque/Credit Card Number</label>
                                <input type="text" name="Cheque" id="Cheque" data-error="Enter Cheque/Credit Card Number"  class="form-control" placeholder="Enter Cheque/Credit Card Number"  />
                                <div class="help-block form-text with-errors form-control-feedback" id="CardNumber"></div>
                            </div>
                        </div>
						<div class="form-group">
							<label for="exampleInputEmail1">Remarks</label>
							<input type="text" name="Remarks" id="Remarks" class="form-control"/>
						</div>
						<?php if ($Pin_no_applicable == 1) { ?>
                            <div class="form-group" id="pin_feedback">
                                <label for=""> Member Pin</label>
                                <input type="text" name="cust_pin" name="cust_pin" class="form-control"  placeholder="Customer Pin" data-error="Enter customer pin" required="required"/>
                                <div class="help-block form-text with-errors form-control-feedback" id="CustomerPin"></div>
                            </div>
                          <?php } ?>
                        <div class="form-buttons-w">                            
                            <button class="btn btn-primary" type="submit"> Submit</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
				<div class="col-md-12" id="GiftCardUserInfo">
					<div class="element-wrapper">
						<h6 class="element-header">Current Balance Details</h6>
						<div class="element-box">	
							<div class="profile-tile">											
								<div class="profile-tile-meta">
									<ul>
										<li>
											Company Balance :<strong id="Company_balance"><?php echo $Company_details->Current_bal; ?></strong>
										</li>												
										<li id="merchant_bal" style="display:block;">
											Merchant Balance :<strong id="Merchant_balance">0</strong>
										</li>										
										
									</ul>								  
								</div>								
							</div>			
						</div>
					</div>
				</div>
            </div>
			
			
			
			
			
			
        </div>	
		
		<!-------------------- START - Data Table -------------------->	  
			<?php if($results != NULL) { ?>
                <div class="element-wrapper">                
                    <div class="element-box">
                        <h5 class="form-header">
                            Transaction Details
                        </h5>                  
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                       
                                        <th>Trans Date</th>										
                                        <th>Trans Type</th>										
                                        <th>Merchant Name</th>
                                        <th>Transaction Amount</th>
										<th>Exeception Transaction</th>
										<th>Payment by</th>
                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
                                       
                                        <th>Trans Date</th>										
                                        <th>Trans Type</th>										
                                        <th>Merchant Name</th>
                                        <th>Transaction Amount</th>
										<th>Exeception Transaction</th>
										<th>Payment by</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                      <?php
									  
										$Todays_date=date("Y-m-d");
										foreach($results as $row)
										{
                                             
											if($row->Exception_flag==1)
											{
												$Exception_flag="Yes";												
											}
											else
											{
												$Exception_flag="No";											
											}
											 if($row->Trans_type_id==5)
											{
												$Full_name="-";												
											}
											else
											{
												$Full_name=$row->First_name." ".$row->Last_name;											
											}
											
											if($row->Payment_type==1)
											{
												$Payment_type="Cash";												
											}
											elseif($row->Payment_type==2)
											{
												$Payment_type="Cheque";
											
											}
											elseif($row->Payment_type==3)
											{
												$Payment_type="Credit";											
											}
											elseif($row->Payment_type==4)
											{
												$Payment_type="Points Only";											
											}
											else
											{
												$Payment_type="-";
											}
                                           ?>
                                        <tr>                                           
                                            <td><?php echo date("Y-m-d",strtotime($row->Transaction_date));?></td>
											<td><?php echo $row->Trans_type;?></td>
											<td><?php echo $Full_name;?></td>
											<td><?php echo $row->Amt_transaction;?></td>
											<td><?php echo $Exception_flag;?></td>
											<td><?php echo $Payment_type;?></td>
                                        </tr>
                                      <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                 <?php } ?>
                
                <!--------------------  END - Data Table  -------------------->
       	
    </div>	

</div>	


<!-- Modal -->
<div id="receipt_myModal" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg" style="width: 100%;margin-top:180px;">
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



 $('#Trans_type2').change(function()
 {
	var Trans_type = $('#Trans_type2').val();
	if(Trans_type==5)//Company Deposit
	{
		document.getElementById('Merchant_balance').innerHTML=0;
		document.getElementById('merchant_bal').style.display="none";
		$("#Seller_id").removeAttr("required");
	}
	else
	{
		document.getElementById('merchant_bal').style.display="";
	}
 });
function isNumberKey2(evt)
	{
	  var charCode = (evt.which) ? evt.which : event.keyCode
	 
	  if (charCode == 46 || charCode > 31 
		&& (charCode < 48 || charCode > 57))
		 return false;

	  return true;
	}

function showhideseller(flag)
	{
		
		if(flag==5)
		{
		 
			$("#block2").css('display','none');
			
			$("#Seller_id").removeAttr("Seller_id");
		}
		else
		{
			// document.getElementById("block2").style.display="";
			$("#block2").css('display','');
			
			$("#Seller_id").attr("required","required");
		}
	}
function call(Seller_id)
{
	// alert(Seller_id);
	
	//var Seller_id = $('#Seller_id').val();
	var Company_id = '<?php echo $Company_id; ?>';
	//document.getElementById("Merchant_balance").innerHTML=Seller_id;
	
		$.ajax({
			type:"POST",
			data:{Seller_id:Seller_id,Company_id:Company_id},
			url:"<?php echo base_url()?>index.php/Administration/get_seller_balance",
			success: function(data)
			{
				// $('#Free_item_id').html(data);
				document.getElementById('Merchant_balance').innerHTML=data;
			}
		});
		
	
}

	function showhide(flag)
	{
		if(flag==1)
		{ 
			document.getElementById("block1").style.display="none"; 
		}
		else
		{
			document.getElementById("block1").style.display="";
		}
	}
	


 




	function show_payment(flag)
	{
		// console.log(flag);

		if (flag == 2 || flag == 3)
		{
			$("#cheque_block").show();
		} 
		else
		{
          $("#cheque_block").hide();
		}
		if (flag == 2)
		{
			document.getElementById("labelME").innerHTML = "Cheque Number";
			document.getElementById("labelME2").innerHTML = "Cheque Details";

			$("#Bank_name").attr("required", "required");
			$("#Branch_name").attr("required", "required");
			$("#Cheque").attr("required", "required");

		} 
		else if (flag == 3)
		{
          document.getElementById("labelME").innerHTML = "Credit Card Number";
          document.getElementById("labelME2").innerHTML = "Credit Card Details";
          $("#Bank_name").attr("required", "required");
          $("#Branch_name").attr("required", "required");
          $("#Cheque").attr("required", "required");

		} 
		else
		{
          $("#Bank_name").removeAttr("required");
          $("#Branch_name").removeAttr("required");
          $("#Cheque").removeAttr("required");
		}
	}

	$('#cust_pin').change(function()
	{		
		var Customer_pin = '<?php echo $Customer_pin; ?>';
		var Entered_pin = $('#cust_pin').val();		
		if((Entered_pin != Customer_pin) || (Entered_pin == ""))
		{
			$('#cust_pin').val("");
			$('#CustomerPin').html("Please Enter Valid Pin Number");
			$("#cust_pin").addClass("form-control has-error");

		} 
		else
		{
			$('#CustomerPin').html("");
			$("#cust_pin").addClass("has-error");
		}
	});
  
  function isNumberKey(evt)
  {
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode != 46 && charCode > 31
              && (charCode < 48 || charCode > 57))
          return false;

      return true;
  }
</script>
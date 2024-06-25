<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-7">
                <div class="element-wrapper">
                    <h6 class="element-header">PERFORM GIFT CARD TRANSACTION</h6>
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
                          echo form_open('Transactionc/transact_giftcard', $attributes);
                        ?>
                        <div class="form-group">
                            <label for=""> Bill No.</label>
                            <input class="form-control" data-error="Enter bill no" required="required" placeholder="Bill No" type="text" id="Billno" name="Billno" class="form-control" placeholder="Bill No" onkeyup="this.value=this.value.replace(/\D/g,'')" >
                            <div class="help-block form-text with-errors form-control-feedback" id="BillNumber"></div>
                        </div>						
                        <div class="form-group">
                            <label for=""> <span class="required_info">*</span>Purchase Amount</label>
                            <input class="form-control" data-error="Enter Purchase Amount" required="required" placeholder="Enter Purchase Amount" type="text" id="Purchase" name="Purchase" onkeyup="this.value=this.value.replace(/\D/g,'')"  class="form-control" placeholder="Enter Purchase Amount">
                            <div class="help-block form-text with-errors form-control-feedback" id="purchaseAMT"></div>
                        </div>                                              
                        <div class="form-group">
                            <label for="exampleInputEmail1">Gift Card Number</label>
                            <input type="text" name="GiftCardNo" id="GiftCardNo" value="" data-error="Enter Gift Card Number" required="required" placeholder="Enter Gift Card Number" class="form-control" />								
                            <div class="help-block form-text with-errors form-control-feedback" id="GiftCardNumber"></div>
                        </div>						
						<div class="form-group">
							<label for="exampleInputEmail1">Gift Card Balance</label>
							<input type="text" name="Balance" id="Balance" class="form-control" placeholder="Gift Card Balance" readonly />			
							<div class="help-block form-text with-errors form-control-feedback" id="GiftCard"></div>
						</div>                     
						<div class="form-group">
							<label for="exampleInputEmail1">Gift Card Redeem Amount</label>
							<input type="text" name="Redeem" id="Redeem" data-error="Enter Gift Card Redeem Amount" required="required" onBlur="javascript:cal_redeem_amt('3');"  onkeyup="this.value=this.value.replace(/\D/g,'')" class="form-control"/>	
							<div class="help-block form-text with-errors form-control-feedback" id="GiftReedemAmount"></div>
						</div>
                        

                       					
                        <div class="form-group">
                            <label for=""> Balance To Pay</label>
                            <input class="form-control" data-error="Enter bill no" required="required" placeholder="Balance To Pay" type="text" name="BalanceToPay" id="BalanceToPay" readonly>
                          
                        </div>
						<div class="form-group">
                            <label for=""> <span class="required_info">*</span> Payment by </label>
                            <select class="form-control" name="payment_by" id="payment_by" required  onchange="show_payment(this.value)" >
							<?php
							  foreach ($PaymentType as $Payment) {
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
                            <label for=""> Remarks</label>
                            <input type="text" name="remark" class="form-control" placeholder="Remarks"/>
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
						<h6 class="element-header">Gift Card Holder Details</h6>
						<div class="element-box">	
							<div class="profile-tile">											
								<div class="profile-tile-meta">
									<ul>
										<li>
											User Name:<strong id="giftcard_name"></strong>
										</li>												
										<li>
											Email ID:<strong id="giftcard_email"></strong>
										</li>										
										<li>
											Phone No.:<strong id="giftcard_phno"></strong>
										</li>													
										<li>
											Gift Card Balance:<strong id="giftcard_balance"></strong>
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
                            Redeem Transaction
                        </h5>                  
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th>Receipt</th>
                                        <th>Transaction Date</th>										
                                        <th>User Name</th>
                                        <th>Gift Card No</th>
										<th>Purchase Amount</th>
										<th>Redeemed Amount</th>
										<th>Walk-in Member</th>
                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
                                        <th>Receipt</th>
                                        <th>Transaction Date</th>
                                        <th>User Name</th>
                                        <th>Gift Card No</th>
										<th>Purchase Amount</th>
                                        <th>Redeemed Amount</th>
                                        <th>Walk-in Member</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                      <?php                                      
                                          foreach($results as $row)
                                          {
                                             
                                              if($row->Trans_type==3)//Just Redeem
                                              {
                                                  $Total_Redeem_Points=$row->Redeem_points;
                                              }
                                              else
                                              {
                                                    $Total_Redeem_Points=$row->Total_Redeem_Points;
                                              }
                                           ?>
                                        <tr>                                           
                                            <td class="row-actions">
                                                <a href="javascript:void(0);" id="receipt_details" onclick="receipt_details('<?php echo $row->Bill_no; ?>',<?php echo $row->Seller; ?>,<?php echo $row->Trans_id; ?>);" title="Receipt" ><i class="os-icon os-icon-ui-49" ></i></a>
                                            </td>
											<td><?php echo date('Y-m-d',strtotime($row->Trans_date)); ?></td>
                                            <td><?php echo $row->User_name; ?></td>
											<td><?php echo $row->Gift_card_id; ?></td>
											<td><?php echo $row->Purchase_amount; ?></td>
											<td><?php echo $row->Redeem_points; ?></td>
											
											<td><?php if($row->Card_id==0){echo "Yes";}else{echo "No";}?></td>
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

<!-- Modal 
<div id="receipt_myModal" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1">
    <div class="modal-dialog modal-lg" style="width: 100%;margin-top:180px;">
       
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="close_modal" class="close"  data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div  id="show_transaction_receipt"></div>
            </div>
        </div>
    </div>
</div>-->
<?php $this->load->view('header/footer'); ?>

<script>
  $('#Billno').blur(function ()
  {
      var Company_id = '<?php echo $Company_id; ?>';
      var Billno = $('#Billno').val();

      if ($("#Billno").val() == "" || (Billno.length < 3))
      {
          $("#Billno").val("");
          $("#BillNumber").html("Please enter valid bill number");
      } else
      {
          $.ajax({
              type: "POST",
              data: {Bill_no: Billno, Company_id: Company_id},
              url: "<?php echo base_url() ?>index.php/Transactionc/check_bill_no",
              success: function (data)
              {
                  if (data == 1)
                  {
                      $("#Billno").val("");
                      $("#BillNumber").html("Already exist");
                      $("#Billno").addClass("form-control has-error");
                  } else
                  {
                      // $("#BillNO").html("Bill Number Available");
                      $("#Billno").removeClass("has-error");
                      $("#BillNumber").html("");
                  }
              }
          });
      }
  });
//***** bill no validation **********/


 

 /*  function receipt_details(Bill_no, Seller_id, Trans_id,Transaction_type)
  {
      // alert("--Bill_no--"+Bill_no+"--Seller_id--"+Seller_id+"--Trans_id--"+Trans_id);
      // return false;
      //var Transaction_type = 1;
      $.ajax({
          type: "POST",
          data: {Bill_no: Bill_no, Seller_id: Seller_id, Trans_id: Trans_id, Transaction_type: Transaction_type},
          url: "<?php echo base_url() ?>index.php/Transactionc/transaction_receipt",
          success: function (data)
          {
              $("#show_transaction_receipt").html(data.transactionReceiptHtml);
              $('#receipt_myModal').show();
              $("#receipt_myModal").addClass("in");
              $("body").append('<div class="modal-backdrop fade in"></div>');
          }
      });
  } */
  
  
function receipt_details(Bill_no,Seller_id,Trans_id)
{	
	//alert("--Bill_no--"+Bill_no+"--Seller_id--"+Seller_id+"--Trans_id--"+Trans_id);
	var Transaction_type = 4;
	$.ajax({
		type: "POST",
		data: {Bill_no: Bill_no, Seller_id:Seller_id,Trans_id:Trans_id,Transaction_type:Transaction_type},
		url: "<?php echo base_url()?>index.php/Transactionc/transaction_receipt",
		success: function(data)
		{
			$("#show_transaction_receipt").html(data.transactionReceiptHtml);	
			$('#receipt_myModal').modal('show');
			
		}
	});
}

  

$('#GiftCardNo').blur(function()
{
	var GiftCardNo = $('#GiftCardNo').val();
	var Company_id = '<?php echo $Company_id; ?>';
	
	if(GiftCardNo != "" && Company_id != "")
	{
		$.ajax({
			type: "POST",
			data: {GiftCardNo: GiftCardNo, Company_id:Company_id},
			url: "<?php echo base_url()?>index.php/Transactionc/get_giftcard_info",
			success: function(data)
			{
				if(data == 0)
				{
					$('#GiftCardNo').val("");
					$('#giftcard_name').html("&nbsp;");
					$('#giftcard_email').html("&nbsp;");
					$('#giftcard_phno').html("&nbsp;");
					$('#giftcard_balance').html("&nbsp;");
					$('#Balance').val("");
					// has_error("#GiftCardNo_feedback","#glyphicon3","#GiftCardNo_help","Please Enter Valid Gift Card No");
					$("#GiftCardNumber").html("Please Enter Valid Gift Card No");
					$("#GiftCardNo").addClass("form-control has-error");
				}
				else
				{
					json = eval("(" + data + ")");
					if( (json[0].Card_balance) != 0 )
					{
						$('#giftcard_name').html(json[0].User_name);
						$('#giftcard_email').html(json[0].Email);
						$('#giftcard_phno').html(json[0].Phone_no);
						$('#giftcard_balance').html(json[0].Card_balance);
						$('#Balance').val(json[0].Card_balance);
						window.Balance=json[0].Card_balance;
						// has_success("#GiftCardNo_feedback","#glyphicon3","#GiftCardNo_help"," ");
						// Invalid Gift Card No or Gift Card Balance is Over. Please Purchase New Gift Card No
						
						$("#GiftCardNumber").html("");
						$("#GiftCardNo").removeClass("has-error");
					}
					else
					{
						$('#GiftCardNo').val("");
						$('#giftcard_name').html("&nbsp;");
						$('#giftcard_email').html("&nbsp;");
						$('#giftcard_phno').html("&nbsp;");
						$('#giftcard_balance').html("&nbsp;");
						$('#Balance').val("");
						// has_error("#GiftCardNo_feedback","#glyphicon3","#GiftCardNo_help","Invalid Gift Card No or Gift Card Balance is Over. Please Purchase New Gift Card No");
						
						// console.log("Invalid Gift Card No or Gift Card Balance is Over. Please Purchase New Gift Card No");
						
						$("#GiftCardNumber").html("Invalid Gift Card No or Gift Card Balance is Over. Please Purchase New Gift Card No");
						$("#GiftCardNo").addClass("form-control has-error");
						
					}
				}
			}
		});
	}
	else
	{
		$('#GiftCardNo').val("");
		$('#giftcard_name').html("&nbsp;");
		$('#giftcard_email').html("&nbsp;");
		$('#giftcard_phno').html("&nbsp;");
		$('#giftcard_balance').html("&nbsp;");
		$('#Balance').val("");		
		$("#GiftCardNumber").html("Please Enter Valid Gift Card No");
		$("#GiftCardNo").addClass("form-control has-error");
	}
});

$('#Redeem').blur(function()
{	
	if( $('#Redeem').val() == 0)
	{
		$("#Redeem").val("");
		$("#GiftReedemAmount").html("Please Enter Valid Redeem Amount");
		$("#Redeem").addClass("form-control has-error");
	}
	else
	{
		document.getElementById("Balance").value=window.Balance;
		var bal = window.Balance;	
		var Purchase = $("#Purchase").val();		
		var Purchase = parseInt($("#Purchase").val());
		var Redeem = parseInt($("#Redeem").val());
		var balance_to_pay = parseInt($("#BalanceToPay").val()); //document.getElementById("BalanceToPay");
		
		if(Redeem <= bal && Redeem <= Purchase)
		{	
			balance_to_pay = Math.round(Purchase - Redeem);
			$("#BalanceToPay").val(balance_to_pay);			
			$("#GiftReedemAmount").html("");
			$("#Redeem").removeClass("has-error");
		}
		else
		{
			$("#Redeem").val("");
			$("#BalanceToPay").val("");
			
			$("#GiftReedemAmount").html("Your Gift Card Balance is Low OR Check your Purchase Amount");
			$("#Redeem").addClass("form-control has-error");
		}
	}
});


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







  $('#cust_pin').change(function ()
  {
      var Customer_pin = '<?php echo $Customer_pin; ?>';
      var Entered_pin = $('#cust_pin').val();

      if ((Entered_pin != Customer_pin) || (Entered_pin == ""))
      {
          $('#cust_pin').val("");
          // has_error("#pin_feedback","#pin_glyphicon","#pin_help","Please Enter Valid Pin Number...!!!");
         
          
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

<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-7">
                <div class="element-wrapper">
                    <h6 class="element-header">Perform Debit Transaction</h6>
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
                          echo form_open('Transactionc/Debit_transaction_ci', $attributes);
                        ?>
                        <h5 class="form-header">

                        </h5>					  
                        <div class="form-group">
                            <label for=""> Membership ID / Phone No.</label>
                            <input class="form-control" data-error="Enter Membership ID or phone no" placeholder="Enter Membership ID or phone no" required="required" type="text" id="cardId" name="cardId" onblur="javascript:Fetch_Member_info(this.value);"  class="form-control">
							<div class="help-block form-text with-errors form-control-feedback" id="MembershipID"></div>
                        </div>
                        <div class="form-group">
                            <label for=""> Bill No.</label>
                            <input class="form-control" data-error="Enter bill no" required="required" placeholder="Enter Bill No" type="text" id="bill_no" name="bill_no" onblur="javascript:Fetch_Trans_info(this.value);" class="form-control" >
                            <div class="help-block form-text with-errors form-control-feedback" id="BillNO"></div>
                        </div>
						<div class="form-group">
                            <label for=""> Bill Date</label>
                            <input class="form-control" type="text" id="Bill_date" name="Bill_date" class="form-control" readonly>
                          
                        </div>						
                        <div class="form-group">
                            <label for=""> <span class="required_info">*</span>Purchase Amount</label>
                            <input class="form-control" type="text" id="purchase_amt" name="purchase_amt" onkeypress="return isNumberKey(event)" class="form-control" readonly>
							<input type="hidden" name="purchase_amt_hidden" id="purchase_amt_hidden" class="form-control" readonly required/>
                            <div class="help-block form-text with-errors form-control-feedback" id="purchaseAMT"></div>
                        </div>
						<div class="form-group" id="Remaining_Amount_Cancellation_div" style="display:none;">
                            <label for=""> Remaining Amount for Cancellation</label>
                            <input class="form-control" data-error="Remaining Amount for Cancellation" required="required" placeholder="Remaining Amount for Cancellation" type="text" id="Remaining_Amount_Cancellation" name="Remaining_Amount_Cancellation" readonly>
							<div class="help-block form-text with-errors form-control-feedback" id="RemainingAmount"></div>					
                        </div>
						<div class="form-group">
							<label for=""><span class="required_info">*</span> Cancellation Amount</label>
							<input type="text" data-error="Enter Cancellation Amount" required="required" name="Cancelle_amt" id="Cancelled_amt" class="form-control" placeholder="Enter Cancellation Amount" onblur="javascript:Validate_cancellation_amt(this.value);" onkeypress="return isNumberKey(event)" onchange="return Convert_value(this.value)"  />
							<div class="help-block form-text with-errors form-control-feedback" id="CancellationAmount"></div>	
							
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
                           
                            <button class="btn btn-primary" type="submit" id="submit"> Submit</button>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="element-wrapper">
                    <h6 class="element-header">Member Details</h6>
                    <div class="element-box">
                        <div class="profile-tile">
                            <a class="profile-tile-box" href="javascript:void(0);"  style="margin-top:-137px">
                                <div class="pt-avatar-w" id="Photograph">
                                        <img src="<?php echo base_url(); ?>images/no_image.jpeg" alt="<?php echo $Full_name; ?> Photograph" style="width:60px;height:60px">
								</div>
                                <div class="pt-user-name" id="Member_name"></div>

                            </a>
                            <div class="profile-tile-meta">
                                <ul>
                                    <li>
                                        Member Tier:<strong id="Tier_name"></strong>
                                    </li>
                                    <li>
                                        Membership Id:<strong><input type="text" name="MemberId" id="Card_id" style="border:none; display:inline;"></strong>
                                    </li>
                                    <br>
                                    <li>
										<?php echo $Company_details->Currency_name; ?> Balance:<strong id="Current_bal"></strong>
                                    </li>
                                    <li>
										<?php echo $Company_details->Currency_name; ?> Earned:<strong id="Gain_pts"></strong>
                                    </li>
									<li>
										Debit <?php echo $Company_details->Currency_name; ?>:<strong id="Debit_points"></strong>
                                    </li>
                                    <hr>
                                    <strong class="p-3">No. of Times :</strong>
                                    <hr>
                                    <li>
                                        Bonus <?php echo $Company_details->Currency_name; ?> Issued:<strong id="Bonu_pts"></strong>
                                    </li>
                                    <li>
                                        Loyalty Transactions: <strong  id="Trans_count"></strong>
                                    </li>
                                    <li> 
                                        <br>
									<!--
                                        <div class="pt-btn">
                                            <a class="btn btn-success btn-sm" href="javascript:void(0);" id="details" >Details</a>
                                        </div> -->
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" id="GiftCardUserInfo"  style="display:none;">
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
        <div id="lp_info">				
        </div>		
    </div>
</div>	


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



	<div id="Trans_info">			
	</div>
	<div id="Referral_Trans_info">			
	</div>
<?php $this->load->view('header/footer'); ?>

<script>
$('#submit').click(function()
{
	var Pin_no_applicable = '<?php echo $Pin_no_applicable; ?>';
	if(Pin_no_applicable == 1)
	{
		// var Customer_pin = '<?php echo $Customer_pin; ?>';
		var Customer_pin = window.pin__no;
		//alert(window.pin__no);
		var Entered_pin = $('#cust_pin').val();
		
		if( (Entered_pin != Customer_pin) || (Entered_pin == "") )
		{
			$('#cust_pin').val("");
			$('#CustomerPin').html("Please Enter Valid Pin Number");
			$('#cust_pin').addClass("form-control has-error");
			// has_error("#pin_feedback","#pin_glyphicon","#pin_help","Please Enter Valid Pin Number...!!!");
			
		}
		else
		{
			// has_success("#pin_feedback","#pin_glyphicon","#pin_help","Valid Pin");
			$('#CustomerPin').html("");
			$('#cust_pin').removeClass("has-error");
		}
		
		if( $('#bill_no').val() != ""  && $('#purchase_amt').val() != ""  && $('#cust_pin').val() != "" && $('#Cancelled_amt').val() != "" )
		{
			show_loader();
		}
	}
	else
	{
		if( $('#bill_no').val() != "" && $('#purchase_amt').val() != "" && $('#Cancelled_amt').val() != "")
		{
			show_loader();
		}
	}
});

//***** bill no validation **********/  
function Fetch_Trans_info(Bill_no) 
{	
	var cardId = $("#Card_id").val();
	//alert(cardId+"----"+Bill_no);
	if(Bill_no != "" && Bill_no != 0 && cardId != "" && cardId != 0 )
	{								
		$.ajax({
			type:"POST",
			data:{Bill_no:Bill_no,Membership_id:cardId},
			url: "<?php echo base_url()?>index.php/Transactionc/Fetch_trans_details/",
			dataType: "json",
			success: function(json)
			{	
				if(json == 0)
				{ 
					$('#BillNO').html('Please Enter Valid Bill No.');
					$("#bill_no").addClass("form-control has-error");
					$("#bill_no").val("");
				}
				else
				{
					if(json['Error_flag'] == 1001) // Status Is OK
					{
						
						$('#BillNO').html('');
						$("#bill_no").removeClass("has-error");
					
						$("#Remaining_Amount_Cancellation_div").css("display","");
						$("#Remaining_Amount_Cancellation").attr("readonly","true");
						
						
						$('#Bill_date').val(json['Trans_date']);
						$('#purchase_amt').val(json['Purchase_amount']);
						$('#purchase_amt_hidden').val(json['Purchase_amount']);
												
						$.ajax({
							type: "POST",
							data: {Bill_no:Bill_no,Membership_id:cardId},
							
							url: "<?php echo base_url()?>index.php/Transactionc/Fetch_transaction_details",
							success: function(data)
							{	
								//alert(data);
								$('#Trans_info').html(data);
							}
						}); 
						
						$.ajax({
							type: "POST",
							data: {Billno:Bill_no},							
							url: "<?php echo base_url()?>index.php/Transactionc/Fetch_reference_transaction_details",
							success: function(data1)
							{	
								$('#Referral_Trans_info').html(data1);
							}
						}); 
					}
					else if(json['Error_flag'] == 2003) //Unable to Locate Bill
					{	
						
						$('#BillNO').html('Please Enter Valid Bill No.');
						$("#bill_no").addClass("form-control has-error");
						$("#bill_no").val("");
						$("#Bill_date").val("");
						$("#purchase_amt").val("");
						//$("#Loyalty_pts").val("");
						//$("#Seller_id1").val("");
						$("#Trans_info").remove();
						$("#Remaining_Amount_Cancellation_div").css("display","none");						
					}						
				}  
			}
		});
	}
	else
	{
		$('#BillNO').html('Please Enter Valid Membership Id / Bill No.');
		$("#bill_no").addClass("form-control has-error");
		
		
		$("#bill_no").val("");
		$("#Bill_date").val("");
		$("#purchase_amt").val("");
		$("#Remaining_Amount_Cancellation_div").css("display","none");
	}
}


//***** bill no validation **********/


//*****Get Member Info**********/
	function Fetch_Member_info(CardId) 
	{	
		if(CardId != "" && CardId != 0 )
		{
			var Img_url= '<?php echo base_url(); ?>';
			var Img_url1= '<?php echo base_url()."images/no_image.jpeg"; ?>';
										
			$.ajax({
				type:"POST",
				data:{Membership_id:CardId},
				url: "<?php echo base_url()?>index.php/Transactionc/Fetch_member_details/",
				dataType: "json",
				success: function(json)
				{	
					if(json == 0)
					{			
						
						$("#cardId").val('');
						$('#MembershipID').html('Please Enter Valid Membership Id');						
						$("#cardId").addClass("form-control has-error");						
					}
					else
					{
						
						if(json['Error_flag'] == 1001) // Status Is OK
						{
							
							$('#MembershipID').html('');						
							 $("#cardId").removeClass("has-error");
							 
							$('#Card_id').val(json['card_id']);
							window.pin__no=json['pinno'];
							
							$('#Member_name').html(json['Member_name']);
							$('#Phone_no').html(json['Phone_no']);
							$('#Tier_name').html(json['Tier_name']);
							$('#Gain_pts').html(json['GainPointAt_Seller']);
							$('#Bonu_pts').html(json['Topup_count']);
							$('#Trans_count').html(json['Purchase_count']);
							$('#Current_bal').html(json['Current_balance']);
							$('#Debit_points').html(json['Debit_points']);
							if(json['Photograph']!="")
							{
							$("#Photograph").html('<img src="'+Img_url +json['Photograph']+'" class="img-responsive">');
							}
							else
							{
								$("#Photograph").html('<img src="'+Img_url1+'" class="img-responsive">');
							}
						}
						else if(json['Error_flag'] == 2003) //Unable to Locate membership id
						{	
							$("#cardId").val('');													
							$('#MembershipID').html('Please Enter Valid Membership Id');						
							$("#cardId").addClass("form-control has-error");
							
							$("#Card_id").html("");
							$("#pinno").html("");
							$("#cardId").html("");
							$('#Member_name').html("&nbsp");
							$('#Phone_no').html("&nbsp");
							$('#Tier_name').html("");
							$('#Gain_pts').html("");
							$('#Bonu_pts').html("");
							$('#Trans_count').html("");
							$('#Current_bal').html("");
							$('#Debit_points').html("");
							$("#Photograph").html('<img src="'+Img_url1+'" class="img-responsive">');
						}						
					}
				}
			});
		}
		else
		{
			
			$('#MembershipID').html('Please Enter Valid Membership Id');						
			$("#cardId").addClass("form-control has-error");
			$("#cardId").val();
			
		}
	}
//*****Get Member Info**********/
function receipt_details(Bill_no,Seller_id,Trans_id)
{	
	var Coalition=<?php echo $Company_details->Coalition; ?>;	
	if(Coalition==1){
		URL="<?php echo base_url()?>index.php/Coal_Transactionc/transaction_receipt";
	} else{
		URL="<?php echo base_url()?>index.php/Transactionc/transaction_receipt";
	}
	var Transaction_type = 2;
	$.ajax({
		type: "POST",
		data: {Bill_no: Bill_no, Seller_id:Seller_id,Trans_id:Trans_id,Transaction_type:Transaction_type},
		url:URL,
		success: function(data)
		{
			$("#show_transaction_receipt").html(data.transactionReceiptHtml);	
			$('#receipt_myModal').modal('show');
		}
	});
}
 
//***** referre membership id validation ********
$('#cust_pin').change(function()
{	
	// var Customer_pin = '<?php echo $Customer_pin; ?>';
	var Customer_pin = window.pin__no;
	var Entered_pin = $('#cust_pin').val();
	
	if( (Entered_pin != Customer_pin) || (Entered_pin == "") )
	{
		$('#cust_pin').val("");
		// has_error("#pin_feedback","#pin_glyphicon","#pin_help","Please Enter Valid Pin Number...!!!");
		
		$('#CustomerPin').html("Please Enter Valid Pin Number");
		$('#cust_pin').addClass("form-control has-error");
		
	}
	else
	{
		// has_success("#pin_feedback","#pin_glyphicon","#pin_help","Valid Pin");		
		$('#CustomerPin').html("");
		$('#cust_pin').removeClass("has-error");
	}
});


function Validate_cancellation_amt(Cancellation_amt)
{	
	var total_cancelle_amt=$("#total_cancelle_amt").val();
	// var purchase_amt=($("#purchase_amt").val());
	var purchase_amt=($("#purchase_amt_hidden").val());
	
	var total_cancelle_amt1 = parseInt(total_cancelle_amt) + parseInt(Cancellation_amt);
	
	if(purchase_amt<total_cancelle_amt1)
	{
		$("#CancellationAmount").html("Please Enter Valid Cancellation Amount");
		$("#Cancelled_amt").addClass("form-control has-error");
		$("#Cancelled_amt").val("");
		
	}
	else{
		$("#CancellationAmount").html("");
		$("#Cancelled_amt").removeClass("has-error");
	}
}
 
function Convert_value(InputVal)
{
	document.getElementById("Cancelled_amt").value = Math.round(InputVal);
}
 


  function isNumberKey(evt)
  {
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode != 46 && charCode > 31
              && (charCode < 48 || charCode > 57))
          return false;

      return true;
  }
 

</script>

<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-7">
                <div class="element-wrapper">
                    <h6 class="element-header">Perform Online Transaction</h6>
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
                          $today = date("Y-m-d");
                          $setLP = array();

                          if ($lp_array != NULL) {
                            foreach ($lp_array as $lp) {
                              if ($today >= $lp->From_date && $today <= $lp->Till_date) {
                                $setLP[] = $lp->Loyalty_id;
                              }
                            }
                          }
                          if ($setLP == "" || $setLP == NULL) {
                            echo "<span class='required_info'><h4>Sorry you can not do transaction, Because Loyalty Rule validity is expired</h4></span><br>";
                          }
                        ?>
						
						
                        <?php
                          $attributes = array('id' => 'formValidate');
                          echo form_open('Transactionc/Joy_purchase_transaction_ci', $attributes);
                        ?>
                        <h5 class="form-header">

                        </h5>					  
                        <div class="form-group">
                            <label for=""> Membership ID / Phone No.</label>
                            <input class="form-control" data-error="Enter Membership ID or phone no" placeholder="Enter Membership ID or phone no" required="required" type="text" id="cardId" name="cardId" value="<?php echo $get_card; ?>"  onblur="javascript:Fetch_Member_info(this.value);"  class="form-control">
							<div class="help-block form-text with-errors form-control-feedback" id="MembershipID"></div>
                        </div>
                        <div class="form-group">
                            <label for=""> Bill No.</label>
                            <input class="form-control" data-error="Enter bill no" required="required" placeholder="Bill No" type="text" id="manual_bill_no" name="manual_bill_no" class="form-control" placeholder="Bill No">
                            <div class="help-block form-text with-errors form-control-feedback" id="BillNO"></div>
                        </div>						
                        <div class="form-group">
                            <label for=""> <span class="required_info">*</span>Purchase Amount</label>
                            <input class="form-control" data-error="Enter Purchase Amount" required="required" placeholder="Enter Purchase Amount" type="text" id="purchase_amt" name="purchase_amt" onchange="return Convert_value(this.value)" onkeypress="return isNumberKey(event)" class="form-control" placeholder="Enter Purchase Amount">
                            <div class="help-block form-text with-errors form-control-feedback" id="purchaseAMT"></div>
                        </div>
                       <?php /* ?>
                        <div class="form-group">
                            <label for=""> Balance Amount to Pay</label>
                            <input class="form-control" data-error="Enter bill no" required="required" placeholder="Enter Balance Amount to Pay" type="text" name="pay_amt" id="balance_to_pay" readonly value="0" class="form-control" placeholder="Enter Balance Amount to Pay ">
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                        
						<?php /* ?>
                        <div class="form-group">
                            <label for=""> <span class="required_info">*</span> Loyalty Rule <span class="required_info"> (  Selected Rules will be apply on Transaction )</span></label>

                            <select class="form-control select2" multiple="true" name="lp_rules[]"   id="lp_rules" onchange="loyalty_program_info(this.value);" data-error="Select loyalty rule" required="required" >
							<?php
							  foreach ($lp_array as $lp) {
								if ($today >= $lp->From_date && $today <= $lp->Till_date) {

								  echo "<option value='" . $lp->Loyalty_name . "' >" . $lp->Loyalty_name . "</option>";
								}
							  }
							?>
                            </select>
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
						<?php */ ?>						
						<div class="form-group">	
							<label for=""> <span class="required_info">*</span> Loyalty Rule <span class="required_info"> (  Selected Rules will be apply on Transaction )</span></label>
							<!--<div id="loyalty_program"></div>-->
							<select class="form-control select2" multiple="true" onchange="loyalty_program_info(this.value);" name="lp_rules[]" id="lp_rules1" data-error="Select loyalty rule" required="required">
								
							</select>
							<div class="help-block form-text with-errors form-control-feedback" id="lpRules"></div>
						</div> 
						<div class="form-group">
                            <label for=""> <span class="required_info">*</span> Payment by </label>
                            <select class="form-control" name="Payment_type" required  onchange="show_payment(this.value)" >
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
                                <input type="text" name="Branch_name" data-error="Enter branch Name of Bank" id="Branch_name" class="form-control" placeholder="Enter branch Name of Bank"  />
                                <div class="help-block form-text with-errors form-control-feedback" id="BranchName"></div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" id="labelME">Cheque/Credit Card Number</label>
                                <input type="text" name="Credit_Cheque_number"  data-error="Enter cheque/credit card number" id="Credit_Cheque_number" class="form-control" placeholder="Enter cheque/credit card number"  />
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
                            <input type="hidden" name="Balance" id="Balance" class="form-control"  />
							<input type="hidden" name="pinno" id="pinno" class="form-control" />
							<input type="hidden" name="Seller_id" id="Seller_id" class="form-control" />
							<input type="hidden" name="Cust_enroll_id" id="Cust_enroll_id" class="form-control" />
							<?php
							if($setLP != NULL)
							{ ?>
                            <button class="btn btn-primary" type="submit" id="submit"> Submit</button>
							<?php
							}
							?>
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
                            <a class="profile-tile-box" href="javascript:void(0);"  style="margin-top:-95px">
                                <div class="pt-avatar-w" id="Photograph">									  
									<?php if ($Photograph == "") { ?>
                                        <img src="<?php echo base_url(); ?>images/no_image.jpeg" alt="<?php echo $Full_name; ?> Photograph" style="width:60px;height:60px">
										<?php } else { ?>
                                        <img src="<?php echo base_url() . $Photograph; ?>" alt="<?php echo $Full_name; ?> Photograph" style="width:60px;height:60px">
									<?php } ?>										
                                </div>
                                <div class="pt-user-name" id="Member_name">
                                    
                                </div>

                            </a>
                            <div class="profile-tile-meta">
                                <ul>
                                    <li>
                                        Member Tier:<strong id="Tier_name"></strong>
                                    </li>
                                    <li>
                                        Membership Id:<strong id="cardId_1"></strong>
                                    </li>
                                    <br>
                                    <li>
										<?php echo $Company_details->Currency_name; ?> Balance:<strong id="Current_bal"></strong>
                                    </li>
                                    <li>
										<?php echo $Company_details->Currency_name; ?> Earned:<strong id="Gain_pts"></strong>
                                    </li>
                                    <hr>
                                    <strong class="p-3">No. of Times :</strong>
                                    <hr>
                                    <li>
                                        Bonus <?php echo $Company_details->Currency_name; ?> Issued:<strong id="Bonu_pts"></strong>
                                    </li>
                                    <li>
                                        Loyalty Transactions: <strong id="Trans_count"></strong>
                                    </li>
                                   <!-- <li> 
										<br>
										<div class="pt-btn">
											<a class="btn btn-success btn-sm" href="javascript:void(0);" id="details" >Details</a>
										</div>
                                    </li>-->
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
    	
	
	
	
	
	 <!-------------------- START - Data Table -------------------->	  
                <div class="element-wrapper">                
                    <div class="element-box">
                        <h5 class="form-header">
                            Issue Loyalty Points
                        </h5>                  
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th>Receipt</th>
                                        <th>Transaction Date</th>
                                        <th>Name</th>
                                        <th>Membership ID</th>
                                        <th>Purchase Amount</th>
                                        <th>Redeem <?php echo $Company_details->Currency_name; ?></th>
                                        <th><?php echo $Company_details->Currency_name; ?> Gained</th>

                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
                                        <th>Receipt</th>
                                        <th>Transaction Date</th>
                                        <th>Name</th>
                                        <th>Membership ID</th>
                                        <th>Purchase Amount</th>
                                        <th>Redeem <?php echo $Company_details->Currency_name; ?></th>
                                        <th><?php echo $Company_details->Currency_name; ?> Gained</th>
                                    </tr>
                                </tfoot>
                                <tbody>
									<?php foreach ($results as $row) { ?>
                                        <tr>
                                            <td class="row-actions">
                                                <a href="javascript:void(0);" onclick="receipt_details('<?php echo $row->Bill_no; ?>',<?php echo $row->Seller; ?>,<?php echo $row->Trans_id; ?>);" title="Receipt" ><i class="os-icon os-icon-ui-49"  
                                                                                                                                                                                                            id="receipt_details"></i></a>
																																														</td>
                                            <td><?php echo date('Y-m-d', strtotime($row->Trans_date)); ?></td>
                                            <td><?php echo $row->First_name . ' ' . $row->Last_name; ?></td>
                                            <td><?php echo $row->Card_id; ?></td>
                                            <td><?php echo $row->Purchase_amount; ?></td>
                                            <td><?php echo $row->Redeem_points; ?></td>
                                            <td><?php echo $row->Loyalty_pts; ?></td>
                                        </tr>
									<?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--------------------  END - Data Table  -------------------->
	</div>
</div>	


<!-- Modal  aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg show" role="dialog" tabindex="-1" style="padding-right: 17px; display: block;"-->

<div id="detail_myModal" aria-labelledby="myLargeModalLabel" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width: 100%;margin-top:170px;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="close_modal1" class="close"  data-dismiss="modal">&times;</button>					
            </div>
            <div class="modal-body">
                <div  id="show_transaction_details"></div>
            </div>					
        </div>

    </div>
</div>	


<!-- Modal -
<div id="receipt_myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width: 100%;margin-top:180px;">
	<!-- Modal content-
        <div class="modal-content">
            <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">
				 Receipt Details
				</h5>
                <button type="button" id="close_modal" class="close"  data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <div  id="show_transaction_receipt"></div>
            </div>

        </div>

    </div>
</div>
-->
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


<?php $this->load->view('header/footer'); ?>

<script>

	/* $('#submit').click(function ()
	{
		$("#lp_rules1").addClass("form-control has-error");
		alert($("#cardId").val());
		alert($("#manual_bill_no").val());
		alert($("#purchaseAMT").val());
		alert($("#cardId").val());
		// show_loader();
		if($("#cardId").val() != "" && $("#manual_bill_no").val() != "" && $("#purchaseAMT").val() != "")
		{
			alert('show_loader();');
			
			show_loader();
		}
		
		return false;
	}) */
		
	/* 	
	$( "#close_modal1" ).click(function(e)
	{
		$('#receipt_myModal').css("display","none");
		$('#receipt_myModal').hide();
		$("#receipt_myModal").removeClass( "in" );
		$('.modal-backdrop').remove();
		
	}); */

function receipt_details(Bill_no, Seller_id, Trans_id)
  {
      // alert("--Bill_no--"+Bill_no+"--Seller_id--"+Seller_id+"--Trans_id--"+Trans_id);
      // return false;
      var Transaction_type = 2;
      $.ajax({
          type: "POST",
          data: {Bill_no: Bill_no, Seller_id: Seller_id, Trans_id: Trans_id, Transaction_type: Transaction_type},
          url: "<?php echo base_url() ?>index.php/Transactionc/transaction_receipt",
          success: function (data)
          {
              $("#show_transaction_receipt").html(data.transactionReceiptHtml);
			  $('#receipt_myModal').modal('show');
              /* $('#receipt_myModal').show();
              $("#receipt_myModal").addClass("in");
              $("body").append('<div class="modal-backdrop fade in"></div>'); */
          }
      });
  }
  
  
  
//***** bill no validation **********/
  $('#purchase_amt').blur(function ()
  {
      // alert($("#purchase_amt").val());
      if ($("#purchase_amt").val() == "" || (purchase_amt.length < 3) || $("#purchase_amt").val() <= 0) {

          $("#purchase_amt").val("");
          $("#purchase_amt").addClass("form-control has-error");
          $("#purchaseAMT").html("Please enter valid purchase amount");
      } else {
          $("#purchase_amt").removeClass("has-error");
          $("#purchaseAMT").html("");
      }
  });

  $('#manual_bill_no').blur(function ()
  {
      var Company_id = '<?php echo $Company_id; ?>';
      var Bill_no = $('#manual_bill_no').val();

      if ($("#manual_bill_no").val() == "" || (Bill_no.length < 3))
      {
          $("#manual_bill_no").val("");
          $("#BillNO").html("Please enter valid bill number");
      } else
      {
          $.ajax({
              type: "POST",
              data: {Bill_no: Bill_no, Company_id: Company_id},
              url: "<?php echo base_url() ?>index.php/Transactionc/check_bill_no",
              success: function (data)
              {
                  if (data == 1)
                  {
                      $("#manual_bill_no").val("");
                      $("#BillNO").html("Already exist");
                      $("#manual_bill_no").addClass("form-control has-error");
                  } else
                  {
                      // $("#BillNO").html("Bill Number Available");
                      $("#manual_bill_no").removeClass("has-error");
                      $("#BillNO").html("");
                  }
              }
          });
      }
  });
//***** bill no validation **********/

 
  function show_payment(flag)
  {
      console.log(flag);

      if (flag == 2 || flag == 3)
      {
          $("#cheque_block").show();
      } else
      {
          $("#cheque_block").hide();
      }
      if (flag == 2)
      {
          document.getElementById("labelME").innerHTML = "Cheque Number";
          document.getElementById("labelME2").innerHTML = "Cheque Details";

          $("#Bank_name").attr("required", "required");
          $("#Branch_name").attr("required", "required");
          $("#Credit_Cheque_number").attr("required", "required");



          $("#BankName").html("Enter bank number");
          $("#BranchName").html("Enter branch number");
          $("#CardNumber").html("Enter card number");

          /* if($("#Bank_name").val() != null) {
           $("#BankName").html("");
           } */


      } else if (flag == 3)
      {
          document.getElementById("labelME").innerHTML = "Credit Card Number";
          document.getElementById("labelME2").innerHTML = "Credit Card Details";
          $("#Bank_name").attr("required", "required");
          $("#Branch_name").attr("required", "required");
          $("#Credit_Cheque_number").attr("required", "required");


          /* 	
           $("#BankName").html("Enter bank number");
           $("#BranchName").html("Enter branch number");
           $("#CardNumber").html("Enter card number"); */

      } else
      {
          //document.getElementById("labelME").innerHTML = "Number";
          $("#Bank_name").removeAttr("required");
          $("#Branch_name").removeAttr("required");
          $("#Credit_Cheque_number").removeAttr("required");
      }
  }

  $('#Bank_name').blur(function ()
  {
      if ($('#Bank_name').val() == null) {

          $("#BankName").html("Enter bank name");

      } else {

          $("#BankName").html("");
      }
  })

  $('#Branch_name').blur(function ()
  {
      if ($('#Branch_name').val() == null) {

          $("#BranchName").html("Enter branch name");

      } else {

          $("#BranchName").html("");
      }


  })
  $('#Credit_Cheque_number').blur(function ()
  {
      if ($('#Credit_Cheque_number').val() == null) {

          $("#CardNumber").html("Enter card number");

      } else {

          $("#CardNumber").html("");
      }

  })

  

  function loyalty_program_info()
  {
      var Company_id = '<?php echo $Company_id; ?>';

      var Lpid = new Array();

      Lpid = $('#lp_rules1').val();

      console.log(Lpid);
      if (Lpid != "") {
		  
          $.ajax({
				type: "POST",
				data: {lp_id: Lpid, Company_id: Company_id},
				url: "<?php echo base_url() ?>index.php/Transactionc/get_loyalty_program_details",
				success: function (data)
				{
					$('#lp_info').html(data);
				}
          });
		  
      } else {
          $('#lp_info').html("");
      }
  }

  
 

  


  $('#details').click(function ()
  {
      var Seller_id = '<?php echo $enroll; ?>';
     /*  var Enrollment_id = '<?php echo $Cust_enrollment_id; ?>';
      var Membership_id = '<?php echo $get_card; ?>'; window.pin__no; */
	  
	  var Enrollment_id = window.Cust_enroll_id;
      var Membership_id = window.Cust_card_id;
	  
      $.ajax({
          type: "POST",
          data: {Seller_id: Seller_id, Enrollment_id: Enrollment_id, Membership_id: Membership_id},
          url: "<?php echo base_url() ?>index.php/Transactionc/show_transaction_details",
          success: function (data)
          {
              $("#show_transaction_details").html(data.transactionDetailHtml);
              $('#detail_myModal').show();
              $("#detail_myModal").addClass("in");
              $("body").append('<div class="modal-backdrop fade in"></div>');
          }
      });
  });

  $('#Promo_code').blur(function ()
  {
      var promoc = $('#Promo_code').val();
      var Company_id = '<?php echo $Company_id; ?>';
      //alert('promo is--'+promoc+'---'+Company_id); 
      if ($('#Promo_code').val('') == "") {

          $("#PromoCode").html("Enter promo code");
          $("#Promo_code").addClass("form-control has-error");

      } else {


          $.ajax({
              type: 'POST',
              data: {PromoCode: promoc, CompID: Company_id},
              url: "<?php echo base_url() ?>index.php/Transactionc/get_promo_points",
              success: function (data)
              {
                  $('#promo_reedem').val(data);
                  window.promo_reedem = data;
                  // alert(data);
                  if (data == 0)
                  {
                      $('#Promo_code').val('');
                      $('#promo_reedem').val('');
                      $("#PromoCode").html("Invalid promo code");
                      $("#Promo_code").addClass("form-control has-error");
                      // has_error("#promo_div","#glyphicon2","#promo_div_help","Invalid Promo Code");
                  } else
                  {
                      // has_success("#promo_div","#glyphicon2","#promo_div_help","Valid Promo Code");
                      // alert('Valid COde');
                      $("#Promo_code").removeClass("has-error");
                      $('#Promo_code').val(promoc);
                      cal_redeem_amt('2');
                  }

              }
          });
      }
  });

  var GiftBal = 0;
  $('#GiftCardNo').blur(function ()
  {
      var GiftCardNo = $('#GiftCardNo').val();
      var MemberCardID = '<?php echo $MembershipID; ?>';
      var Company_id = '<?php echo $Company_id; ?>';   //
      if ($('#GiftCardNo').val() == "") {
          $('#GiftCard').html(" Enter gift card number ");
          $("#GiftCardNo").addClass("form-control has-error");
      } else if (GiftCardNo != "" && Company_id != "")
      {
          $.ajax({
              type: "POST",
              data: {GiftCardNo: GiftCardNo, Company_id: Company_id},
              url: "<?php echo base_url() ?>index.php/Transactionc/get_giftcard_info",
              success: function (data)
              {
                  if (data == 0)
                  {
                      $("#gift_reedem").attr("readonly", "true");
                      $('#GiftCardNo').val("");
                      $('#giftcard_name').html("&nbsp;");
                      $('#giftcard_email').html("&nbsp;");
                      $('#giftcard_phno').html("&nbsp;");
                      $('#giftcard_balance').html("&nbsp;");
                      $('#Balance').val("");
                      // has_error("#GiftCardNo_feedback","#glyphicon3","#GiftCardNo_help","Please Enter Valid Gift Card No");
                      $('#GiftCard').html(" Enter valid gift card number ");
                      $("#GiftCardNo").addClass("form-control has-error");
                  } else
                  {
                      json = eval("(" + data + ")");
                      if ((json[0].Card_balance) != 0 && MemberCardID == json[0].MembershipID)
                      {

                          $("#gift_reedem").removeAttr("readonly");
                          $('#giftcard_name').html(json[0].User_name);
                          $('#giftcard_email').html(json[0].Email);
                          $('#giftcard_phno').html(json[0].Phone_no);
                          $('#giftcard_balance').html(json[0].Card_balance);
                          $('#Balance').val(json[0].Card_balance);
                          var GiftBal = 0;
                          // has_success("#GiftCardNo_feedback","#glyphicon3","#GiftCardNo_help"," ");
                          $("#GiftCardNo").val(GiftCardNo);
                          $('#GiftCard').html("");
                          $("#GiftCardNo").removeClass("has-error");

                      } else
                      {
                          $("#gift_reedem").attr("readonly", "true");
                          $('#GiftCardNo').val("");
                          $('#giftcard_name').html("&nbsp;");
                          $('#giftcard_email').html("&nbsp;");
                          $('#giftcard_phno').html("&nbsp;");
                          $('#giftcard_balance').html("&nbsp;");
                          $('#Balance').val("");
                          // has_error("#GiftCardNo_feedback","#glyphicon3","#GiftCardNo_help","Invalid Gift Card No. or Gift Card Balance is Over. Please Purchase New Gift Card No.");
                          $('#GiftCard').html("Invalid Gift Card No. or Gift Card Balance is Over. Please Purchase New Gift Card No");
                          $("#GiftCardNo").addClass("form-control has-error");
                      }
                  }
              }
          });
      } else
      {
          $("#gift_reedem").attr("readonly", "true");
          $('#GiftCardNo').val("");
          $('#giftcard_name').html("&nbsp;");
          $('#giftcard_email').html("&nbsp;");
          $('#giftcard_phno').html("&nbsp;");
          $('#giftcard_balance').html("&nbsp;");
          $('#Balance').val("");
          // has_error("#GiftCardNo_feedback","#glyphicon3","#GiftCardNo_help","Please Enter Valid Gift Card No");
          //alert("Please Enter Valid Gift Card No---8---");
          $('#GiftCard').html("Please Enter Valid Gift Card No");
          $("#GiftCardNo").addClass("form-control has-error");
      }
  });


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
  function Convert_value(InputVal)
  {
      // alert(InputVal);
      document.getElementById("purchase_amt").value = Math.round(InputVal);
  }
  
   
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
					/* var Title = "In-valid Data Validation";
					var msg='Please Enter Valid Membership Id!';
					runjs(Title,msg); */
					// alert('Please Enter Valid Membership Id!');
					$("#MembershipID").html("Please Enter Valid Membership Id");
					$("#cardId").addClass("form-control has-error");
					$('#lp_rules1').empty();
					$("#cardId").val();
				}
				else
				{
					if(json['Error_flag'] == 1001) // Status Is OK
					{
						$("#MembershipID").html("");
						$("#cardId").removeClass("has-error");
					
					
						// alert(json['card_id']);
						$("#lp_rules").remove();
						// $('#Seller_id').val(json['Seller_id']);
						window.Seller_id=json['Seller_id'];
						// $('#Cust_enroll_id').val(json['Cust_enroll_id']);
						window.Cust_enroll_id=json['Cust_enroll_id'];
						window.Cust_card_id=json['card_id'];
						$('#Card_id').val(json['card_id']);
						$('#cardId_1').html(json['card_id']);
						// $('#pinno').val(json['pinno']);
						window.pin__no=json['pinno'];
						$('#Member_name').html(json['Member_name']);
						$('#Phone_no').html(json['Phone_no']);
						$('#Tier_name').html(json['Tier_name']);
						$('#Gain_pts').html(json['GainPointAt_Seller']);
						$('#Bonu_pts').html(json['Topup_count']);
						$('#Trans_count').html(json['Purchase_count']);
						$('#Current_bal').html(json['Current_balance']);
						
						if(json['Photograph'])
						{
							$("#Photograph").html('<img src="'+Img_url+json['Photograph']+'" class="img-responsive">');
							
						}
						else
						{
							$("#Photograph").html('<img src="http://novacomonline.ehpdemo.online/images/no_image.jpeg" class="img-responsive">');
							
						}
						
						var Loyalty_details=json['Loyalty_details'];
						var HTML1="";
						var HTML2="";
						var HTML3="";
						// console.log(Loyalty_details);
						var Lpid = new Array();
						$('#lp_rules1').empty();
						$.each(Loyalty_details, function(key,value)
						{	
						
							Lpid.push(value['Loyalty_name']);
							$('#lp_rules1')
								.append($("<option selected=\"true\"></option>")
								.attr("value",key['Loyalty_name'])
								.text(value['Loyalty_name'])); 
					
					
						});
						var Company_id = '<?php echo $Company_id; ?>';
						// Lpid = $('#lp_rules').val();					
						// console.log(Lpid);
						$.ajax({
							type: "POST",
							data: { lp_id:Lpid, Company_id:Company_id},
							
							url: "<?php echo base_url()?>index.php/Transactionc/get_loyalty_program_details",
							success: function(data)
							{	
								$('#lp_info').html(data);
							}
						}); 
					}
					else if(json['Error_flag'] == 2003) //Unable to Locate membership id
					{	
											
						$("#MembershipID").html("Please Enter Valid Membership Id");
						$("#cardId").addClass("form-control has-error");
						
						$("#Seller_id").val("");
						$("#Cust_enroll_id").val("");
						$("#Card_id").val("");
						$("#pinno").val("");
						$("#cardId_1").html("");
						$('#Member_name').html("&nbsp");
						$('#Phone_no').html("&nbsp");
						$('#Tier_name').html("");
						$('#Gain_pts').html("");
						$('#Bonu_pts').html("");
						$('#Trans_count').html("");
						$('#Current_bal').html("");
						$("#Photograph").html('<img src="'+Img_url1+'" class="img-responsive">');
						$("#lp_rules").remove();
						
						$('#lp_rules1').empty();
						$("#cardId").val("");
					}						
				}
			}
		});
	}
	else
	{
		$("#MembershipID").html("Please Enter Valid Membership Id");
		$("#cardId").addClass("form-control has-error");
	}
}

</script>

<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-7">
                <div class="element-wrapper">
                    <h6 class="element-header">Perform Transaction</h6>
                    <div class="element-box">
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
                          echo form_open('Transactionc/loyalty_purchase_transaction_ci', $attributes);
                        ?>
                        <h5 class="form-header">

                        </h5>					  
                        <div class="form-group">
                            <label for=""> Membership ID / Phone No.</label>
                            <input class="form-control" data-error="Enter Membership ID or phone no" placeholder="Enter Membership ID or phone no" required="required" type="text" id="cardId" name="cardId" value="<?php echo $get_card; ?>" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for=""> Bill No.</label>
                            <input class="form-control" data-error="Enter bill no" required="required" placeholder="Bill No" type="text" id="manual_bill_no" name="manual_bill_no" class="form-control" placeholder="Bill No">
                            <div class="help-block form-text with-errors form-control-feedback" id="BillNO"></div>
                        </div>						
                        <div class="form-group">
                            <label for=""> <span class="required_info">*</span>Purchase Amount</label>
                            <input class="form-control" data-error="Enter Purchase Amount" required="required" placeholder="Enter Purchase Amount" type="text" id="purchase_amt" name="purchase_amt"  onBlur="javascript:cal_redeem_amt('1');" onchange="return Convert_value(this.value)" onkeypress="return isNumberKey(event)" class="form-control" placeholder="Enter Purchase Amount">
                            <div class="help-block form-text with-errors form-control-feedback" id="purchaseAMT"></div>
                        </div>
                        <div class="form-group">
                            <label for=""> Redeem <?php echo $Company_details->Currency_name; ?></label>
                            <input class="form-control" data-error="Enter bill no" required="required" placeholder="Enter redeem points" type="text" id="reedem" name="points_redeemed" onBlur="javascript:cal_redeem_amt('1');" value="0" onkeyup="this.value = this.value.replace(/\D/g, '')" class="form-control" placeholder="Enter redeem points">
                            <div class="help-block form-text with-errors form-control-feedback" id="RedeemPoints"></div>
                        </div>



                        <!--************ Promo Code Start******************-->	
                          <?php if ($Promo_code_applicable == 1) { ?>
                            <div class="form-group">
                                <label class="col-sm-3 col-form-label">Promo Code?</label>
                                <div class="col-sm-3">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input checked="" class="form-check-input" name="Promo_redeem_by"  id="inlineRadio2"  type="radio" value="1"  onclick="show_redeem_div(this.value, '1');">Yes
                                        </label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label class="form-check-label">
                                            <input class="form-check-input" name="Promo_redeem_by" type="radio"  id="inlineRadio3" value="0"  onclick="show_redeem_div(this.value, '1');" checked>No
                                        </label>
										<div class="help-block form-text with-errors form-control-feedback" id="PromoCodeDiv"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group" id="PromoDiv1" style="display:none;">
                                <label for="exampleInputEmail1">Promo Code</label>
                                <input type="text" name="Promo_code" id="Promo_code" data-error="Enter promo code" value=""  placeholder="Enter Promo Code" class="form-control" />								
                                <div class="help-block form-text with-errors form-control-feedback" id="PromoCode"></div>						

                            </div>
                            <div class="form-group"  id="PromoDiv" style="display:none;">
                                <label for="exampleInputEmail1">Promo Points Redeemed</label>
                                <input type="text" readonly name="promo_points_redeemed" id="promo_reedem"  class="form-control" value="0" />	
                            </div>

                          <?php } ?>			



                        <!--************ Promo Code End******************-->	

                        <!--************ Gift Card Start******************-->	
                        <div class="form-group">
                            <label class="col-sm-3 col-form-label">Gift Card?</label>
                            <div class="col-sm-9">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="Gift_redeem_by" id="inlineRadio4" value="1" onclick="show_redeem_div(this.value, '2');" >Yes
                                    </label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio"  name="Gift_redeem_by" id="inlineRadio5" value="0" onclick="show_redeem_div(this.value, '2');" checked >No
                                    </label>
                                </div>
								<div class="help-block form-text with-errors form-control-feedback" id="GiftCardDiv"></div>

                            </div>

                        </div>
                        <div class="form-group" id="GiftDiv1" style="display:none;">
                            <label for="exampleInputEmail1">Gift Card Number</label>
                            <input type="text" name="GiftCardNo" id="GiftCardNo" value="" data-error="Enter Gift Card Number" placeholder="Enter Gift Card Number"   
                                   class="form-control" />								
                            <div class="help-block form-text with-errors form-control-feedback" id="GiftCard"></div>	


                        </div>
                        <div id="GiftDiv" style="display:none;">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Gift Card Redeem Amount</label>
                                <input type="text" name="gift_points_redeemed" data-error="Enter Gift Card Redeem Amount" id="gift_reedem"  onBlur="javascript:cal_redeem_amt('3');"  onkeyup="this.value = this.value.replace(/\D/g, '')" class="form-control" value="0" />	
                                <div class="help-block form-text with-errors form-control-feedback" id="GiftReedem"></div>
                            </div>
                        </div>

                        <!--************ Gift Card End ******************-->						
                        <div class="form-group">
                            <label for=""> Equivalent Redeem Amount</label>
                            <input class="form-control" data-error="Enter bill no" required="required" placeholder="Equivalent Redeem Amount" type="text" name="redeem_amt" id="redeem_amt" readonly value="0" class="form-control" placeholder="Equivalent Redeem Amount">
                            <div class="help-block form-text with-errors form-control-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for=""> Balance Amount to Pay</label>
                            <input class="form-control" data-error="Enter bill no" required="required" placeholder="Enter Balance Amount to Pay" type="text" name="pay_amt" id="balance_to_pay" readonly value="0" class="form-control" placeholder="Enter Balance Amount to Pay ">
                            <div class="help-block form-text with-errors form-control-feedback"></div>
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
                            <button class="btn btn-primary" id="submit" type="submit"> Submit</button>
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
                                <div class="pt-avatar-w">									  
<?php if ($Photograph == "") { ?>
                                        <img src="<?php echo base_url(); ?>images/no_image.jpeg" alt="<?php echo $Full_name; ?> Photograph" style="width:60px;height:60px">
  <?php } else { ?>
                                        <img src="<?php echo base_url() . $Photograph; ?>" alt="<?php echo $Full_name; ?> Photograph" style="width:60px;height:60px">
  <?php } ?>										
                                </div>
                                <div class="pt-user-name">
                                    <?php echo $Full_name; ?>
                                </div>

                            </a>
                            <div class="profile-tile-meta">
                                <ul>
                                    <li>
                                        Member Tier:<strong><?php echo $Tier_name; ?></strong>
                                    </li>
                                    <li>
                                        Membership Id:<strong><?php echo $MembershipID; ?></strong>
                                    </li>
                                    <br>
                                    <li>
										<?php echo $Company_details->Currency_name; ?> Balance:<strong><?php echo $Current_balance; ?></strong>
                                    </li>
                                    <li>
										<?php echo $Company_details->Currency_name; ?> Earned:<strong><?php echo $Gained_points; ?></strong>
                                    </li>
                                    <hr>
                                    <strong class="p-3">No. of Times :</strong>
                                    <hr>
                                    <li>
                                        Bonus <?php echo $Company_details->Currency_name; ?> Issued:<strong><?php echo $Topup_count; ?></strong>
                                    </li>
                                    <li>
                                        Loyalty Transactions: <strong><?php echo $Purchase_count; ?></strong>
                                    </li>
                                    <li> 
										<br>
										<div class="pt-btn">
											<a class="btn btn-success btn-sm" href="javascript:void(0);" id="details" >Details</a>
										</div>
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


<!-- Modal  aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg show" role="dialog" tabindex="-1" style="padding-right: 17px; display: block;"-->
<div id="detail_myModal" aria-labelledby="myLargeModalLabel" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 100%;margin-top:170px;">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="close_modal" class="close"  data-dismiss="modal">&times;</button>					
            </div>
            <div class="modal-body">
                <div  id="show_transaction_details"></div>
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
  $('#submit').click(function()
  {
    if($('#cardId').val() != ""){      
      show_loader();        
    }
  });
  
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

  function hide_referral_div(input_val)
  {
      if (input_val == 0)
      {
          $("#Refrerral_block").hide();
          $("#referre_membershipID").removeAttr("required");
      } else
      {
          $("#Refrerral_block").show();
          $("#referre_membershipID").attr("required", "required");
      }
  }
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

  function show_redeem_div(redeem_flag, div_flag)
  {
		  
	var balance_to_pay = document.getElementById("balance_to_pay").value;
	
	
	console.log("---redeem_flag------"+redeem_flag+"---div_flag---"+div_flag);
	
		
	/* if(div_flag==1 && redeem_flag == 0){
			
		console.log("--PromoCodeDiv--");
		$('#PromoCodeDiv').html("");
			
	} 
	if(div_flag == 2 && redeem_flag == 0) {
			
		console.log("--GiftCardDiv--");
		$('#GiftCardDiv').html("");
	} */
	
	if(parseInt(balance_to_pay) <= 0 )
	{				  
		if(div_flag==1){
				
			// $('#PromoCodeDiv').html('Sorry, You can not use Promo Code due to Balance Amount to Pay is 0');
				
		} else {
				
			// $('#GiftCardDiv').html('Sorry, You can not Gift Card due to Balance Amount to Pay is 0');
		}			
		// return false;
	} 
	else 
	{
		
		$('#PromoCodeDiv').html("");
		$('#GiftCardDiv').html("");
		
		if (div_flag == 1 && redeem_flag == 1 )
		{
			  $("#Promo_code").attr("required", "required");
			  $("#PromoDiv").show();
			  $("#PromoDiv1").show();
		} 
		else if (div_flag == 1 && redeem_flag == 0)
		{
			  $("#Promo_code").removeAttr("required");
			  $("#PromoDiv").hide();
			  $("#PromoDiv1").hide();
		}
		if (div_flag == 2 && redeem_flag == 1)
		{

			$("#gift_reedem").attr("readonly", "true");
			  if ($("#GiftCardNo").val() != "")
			  {
				  $("#gift_reedem").attr("readonly", "false");
			  }
			  $("#GiftCardNo").attr("required", "required");
			  $("#GiftDiv").show();
			  $("#GiftDiv1").show();
			  $("#GiftCardUserInfo").show();
		} 
		else if (div_flag == 2 && redeem_flag == 0)
		{
			  $("#gift_reedem").val("0");
			  $("#gift_reedem").attr("readonly", "false");
			  $("#GiftCardNo").removeAttr("required");
			  $("#GiftDiv").hide();
			  $("#GiftDiv1").hide();
			  $("#GiftCardUserInfo").hide();

			  cal_redeem_amt(3);
		}
	}
	

  }

  function loyalty_program_info()
  {
      var Company_id = '<?php echo $Company_id; ?>';

      var Lpid = new Array();

      Lpid = $('#lp_rules').val();

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

  var EquivalentRedeem1 = 0;
  var EquivalentRedeem2 = 0;
  var EquivalentRedeem3 = 0;
  var TotalEquivalentRedeem = 0;

  function cal_redeem_amt(redeemBY)
  {

      bal = '<?php echo $Current_balance; ?>';
      var purchase_amt = parseInt(document.getElementById("purchase_amt").value);
      var reedem = $("#reedem").val();
      var redeem_amt1 = document.getElementById("redeem_amt");
      var balance_to_pay = document.getElementById("balance_to_pay");
      var EquivalentRedeem = document.getElementById("redeem_amt").value;

      if (reedem == "")
      {
          reedem = 0;
      } else
      {
          reedem = reedem;
      }
      if (redeemBY == 1 && parseInt(reedem) <= parseInt(bal))
      {

          var ratio_value = '<?php echo $redemptionratio; ?>';


          var EquiRedeem = (reedem / ratio_value).toFixed(2);

          //var EquiRedeem18 = parseInt(EquivalentRedeem) + parseInt(EquiRedeem);
          EquivalentRedeem1 = parseInt(EquiRedeem); //EquiRedeem18;
          redeem_amt1.value = parseInt(EquiRedeem);// EquiRedeem18;	

      } else if (redeemBY == 1)
      {
          document.getElementById("redeem_amt").value = 0;
          document.getElementById("balance_to_pay").value = purchase_amt;
      }

      if (redeemBY == 1 && reedem > 0)
      {
          allow();
      }

      if (redeemBY == 2)
      {
          var PromoredeemBY = $("input[name=Promo_redeem_by]:checked").val();
          var promoReedempts = window.promo_reedem;
          // var calc_redeem_amt=(promoReedempts/redemptionratio);
          var calc_redeem_amt = (promoReedempts / ratio_value);

          if (calc_redeem_amt > purchase_amt)
          {
              //alert('here...');
              $("#promo_reedem").val(0);
              $("#PromoCode").html("Sorry, Your Promo Code equivalnt Redeem amount is more than Purchase Amount");
              return false;
          }

          if (PromoredeemBY == 1 && promoReedempts > 0)
          {


              var EquiRedeem12 = redeem_amt1.value;
              //alert(EquiRedeem12);
              var ratio_value = '<?php echo $redemptionratio; ?>';
              currentredeem12 = (promoReedempts / ratio_value).toFixed(2);
              //var EquiRedeem13 = parseInt(EquiRedeem12) + parseInt(currentredeem12);
              EquivalentRedeem2 = currentredeem12;
              redeem_amt1.value = parseInt(currentredeem12);

          } else
          {
              EquivalentRedeem2 = 0;
              redeem_amt1.value = 0;
          }
      }

      if (redeemBY == 3)
      {
          var Giftredeemby = $("input[name=Gift_redeem_by]:checked").val();

          if (Giftredeemby == 1)
          {
              var gift_reedem = $("#gift_reedem").val();
              var Giftbal = $("#Balance").val();
              //alert(gift_reedem+'----'+Giftbal);

              if (gift_reedem < 0) {

                  $('#gift_reedem').val(0);
                  $('#GiftReedem').html("Enter valid gift redeem points");
                  $("#gift_reedem").addClass("form-control has-error");
                  // return false;
                  cal_redeem_amt('3');

              }
			  else{

                  $('#GiftReedem').html("");
                  $("#gift_reedem").removeClass("has-error");
                  // return true;
              }

              if (parseInt(gift_reedem) > parseInt(purchase_amt))
              {
                  $("#gift_reedem").val(0);
                  /* var Title = "In-valid Data Validation";
                   var msg='Sorry, You can not Redeem '+reedem+' due to Redeem Amount is more than Purchase Amount!';
                   runjs(Title,msg); */
                  // alert('Sorry, You can not Redeem '+reedem+' due to Redeem Amount is more than Purchase Amount--3---');
                  $('#GiftReedem').html('Sorry, You can not Redeem ' + gift_reedem + ' due to Redeem Amount is more than Purchase Amount');
                  $("#gift_reedem").addClass("form-control has-error");
                  return false;
              }

              if (parseInt(gift_reedem) > parseInt(Giftbal))
              {
                  $("#gift_reedem").val(0);
                  // var Title = "In-valid Data Validation";
                  // var msg='Sorry, Your Gift Card Balance Is Low!';
                  // runjs(Title,msg);
                  //alert('Sorry, Your Gift Card Balance Is Low---2-----');
                  
                   $('#GiftReedem').html('Sorry, Your Gift Card Balance Is Low');
                   $("#gift_reedem").addClass("form-control has-error");

                  return false;
              }

              var EquiRedeem14 = redeem_amt1.value;
              //alert("EquiRedeem14---"+EquiRedeem14);

              //var EquiRedeem15 = parseInt(EquiRedeem14) + parseInt(gift_reedem);
              EquivalentRedeem3 = gift_reedem;
              //redeem_amt1.value = parseInt(gift_reedem) //EquiRedeem15;

          }
		  else
          {
              EquivalentRedeem3 = 0;
          }
		

      }

      //alert("EquivalentRedeem1--"+EquivalentRedeem1+"---EquivalentRedeem2---"+EquivalentRedeem2+"---EquivalentRedeem3---"+EquivalentRedeem3);
      TotalEquivalentRedeem = parseInt(EquivalentRedeem1) + parseInt(EquivalentRedeem2) + parseInt(EquivalentRedeem3);

      if (parseInt(TotalEquivalentRedeem) > parseInt(purchase_amt))
      {
          /* var Title = "In-valid Data Validation";
           var msg='Sorry, You can not Redeem '+reedem+' due to Redeem Amount is more than Purchase Amount!';
           runjs(Title,msg); */

          //alert('Sorry, You can not Redeem ' + reedem + ' due to Redeem Amount is more than Purchase Amount----1---');
          $('#RedeemPoints').html('Sorry, You can not Redeem ' + reedem + ' due to Redeem Amount is more than Purchase Amount');
          //$("#gift_reedem").addClass("form-control has-error");
          return false;

      } else
      {
          redeem_amt1.value = TotalEquivalentRedeem;
      }

      balance_to_pay.value = Math.round(purchase_amt - redeem_amt1.value);

      if (isNaN(balance_to_pay.value) || balance_to_pay.value < 0)
      {
          document.getElementById("balance_to_pay").value = purchase_amt;
      } else
      {
          balance_to_pay.value = balance_to_pay.value;
      }
  }
  function allow()
  {
      bal = '<?php echo $Current_balance; ?>';
      var val3 = parseInt(document.getElementById("reedem").value);

      if (val3 > bal)
      {
          document.getElementById("redeem_amt").value = "0";
          document.getElementById("reedem").value = "0";
          cal_redeem_amt(1);

          /* var Title = "In-valid Data Validation";
           //var msg='Sorry, You can not Enter ' +val3 + ' It is greater than Card Balance!';
           var msg='Insufficient Current Points Balance !';
           runjs(Title,msg); */

          //alert('Insufficient Current Points Balance !');
          
           $("#RedeemPoints").html("Insufficient Current Points Balance");
          $("#reedem").addClass("form-control has-error");

          return false;

      } else
      {
          var result = reddem_amt_less_purchase_amt();
          if (result == true)
          {
              var val1 = parseInt(document.getElementById("purchase_amt").value);
              var val2 = parseInt(document.getElementById("redeem_amt").value);
              var x = document.getElementById("redeem_amt").value;

              if (x == null || x == "")
              {
                  val2 = 0;
              }

          }
      }

  }

  function reddem_amt_less_purchase_amt()
  {
      var valpurchase = parseInt(document.getElementById("purchase_amt").value);
      var val3 = parseInt(document.getElementById("redeem_amt").value);
      var val2 = parseInt(document.getElementById("reedem").value);

      if (val3 > valpurchase)
      {
          document.getElementById("reedem").value = "0";
          document.getElementById("redeem_amt").value = '0';
          cal_redeem_amt(1);

          // alert('Sorry, You can not Enter ' +val2 + ' The calculated Redeem Amount is greater than Value of Purchase!');
          /* var Title = "In-valid Data Validation";
           var msg='Sorry, You can not redeem ' +val2 + ' The calculated Redeem Amount is more than Value of Purchase!';
           runjs(Title,msg); */

          // alert('Sorry, You can not redeem ' +val2 + ' The calculated Redeem Amount is more than Value of Purchase---5----');

          $("#RedeemPoints").html("Sorry, You can not redeem " + val2 + " The calculated Redeem Amount is more than Value of Purchase");
          $("#reedem").addClass("form-control has-error");
          return false;
      } else
      {
          $("#RedeemPoints").html("");
          $("#reedem").removeClass("has-error");
          return true;
      }
  }


  $('#details').click(function ()
  {
      var Seller_id = '<?php echo $enroll; ?>';
      var Enrollment_id = '<?php echo $Cust_enrollment_id; ?>';
      var Membership_id = '<?php echo $get_card; ?>';

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
					  $("#PromoCode").html("");
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



  /* $('#gift_reedem').change(function()
   {	
   var gift_reedem = $('#gift_reedem').val();
   
   if(gift_reedem == 0 ){
   
   $('#gift_reedem').val("");		
   $('#GiftReedem').html("Enter gift redeem points greater than 0 ");
   $("#gift_reedem").addClass("form-control has-error");
   
   }else{
   
   $('#GiftReedem').html("");
   $("#gift_reedem").removeClass("has-error");
   }
   }); */

//***** referre membership id validation ********

  $('#referre_membershipID').blur(function ()
  {
      var ref_cardid = $('#referre_membershipID').val();
      var Membership_id = $('#cardId').val();
      var Company_id = '<?php echo $Company_id; ?>';

      if (Membership_id == ref_cardid)
      {
          // has_error("#Refrerral_block","#glyphicon2","#error_msg1","Please Enter Referre Membership ID, Not Your!!");
          alert("Please Enter Referre Membership ID, Not Your");
          
          $('#referre_membershipID').val("");
      } else if (ref_cardid != "")
      {
          $('#error_msg1').hide();

          $('#referre_info_div').show();

          /*  ********************************************************************
           $("#Refree_name").autocomplete({
           source:"<?php echo base_url() ?>index.php/enrollmentc/autocomplete_customer_names" // path to the get_birds method
           }); 
           *****************************************************************/

          $.ajax({
              type: "POST",
              data: {ref_cardid: ref_cardid, Company_id: Company_id},
              url: "<?php echo base_url() ?>index.php/Transactionc/check_referee_details",
              success: function (data)
              {

                  $('#referre_info').html(data);
              }
          });
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

</script>

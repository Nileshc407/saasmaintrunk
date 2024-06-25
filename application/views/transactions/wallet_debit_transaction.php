<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-7">
                <div class="element-wrapper">
                    <h6 class="element-header">PERFORM WALLET DEBIT TRANSACTION</h6>
                    <div class="element-box">
                       
                        <?php
                          $attributes = array('id' => 'formValidate');
                          echo form_open('Transactionc/wallet_debit_done', $attributes);
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
							<input type="hidden"  name="Redeem_type" id="Redeem_type"  value="1" >
						   
						   <div class="form-group" id="Redeem_feedback" >
                                <label for="exampleInputEmail1"> Debit Amount</label>
                                <input type="text" name="Debit_amount" id="Debit_amount" value="" data-error="Enter Debit Amount" required="required" placeholder="Enter Debit Amount" class="form-control" onkeyup="this.value=this.value.replace(/\D/g,'')" />					
                                <div class="help-block form-text with-errors form-control-feedback" id="RedeemPoints"></div>
                            </div>
                            
                            <div class="form-group"  id="Remarks_div">
                                <label for="exampleInputEmail1">Remarks</label>
                                <input type="text" name="Remarks" id="promo_reedem"   placeholder="Remarks" class="form-control"/>	
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="element-wrapper">
                    <h6 class="element-header">Member Details</h6>
                    <div class="element-box">
                        <div class="profile-tile">
                            <a class="profile-tile-box" href="javascript:void(0);">
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
                                        Wallet Balance:<strong><?php echo $Wallet_balance; ?></strong>
                                    </li>
                                    <hr>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
		<div class="element-wrapper">                
			<div class="element-box">											
				<div class="form-buttons text-center" id="submit_id">								  
					<input type="hidden" name="Balance" id="Balance" class="form-control"  />
					<input type="hidden" name="grandTotalPointsValue" id="grandTotalPointsValue" class="form-control" placeholder="Total Points"/>
					<button class="btn btn-primary" type="submit"  id="submit"> Submit</button>							
				</div>
				<div class="help-block form-text with-errors form-control-feedback" id="OnSubmit_error"> </div>
			</div>
		</div>
		
		<?php echo form_close(); ?>		
    </div>	

</div>
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
  $('#manual_bill_no').blur(function ()
  {
      var Company_id = '<?php echo $Company_id; ?>';
      var Bill_no = $('#manual_bill_no').val();

      if ($("#manual_bill_no").val() == "" || (Bill_no.length < 3))
      {
          $("#manual_bill_no").val("");
          $("#BillNO").html("Please enter valid bill number");
      } 
	  else
      {
          $.ajax({
              type: "POST",
              data: {Bill_no: Bill_no, Company_id: Company_id},
              url: "<?php echo base_url() ?>index.php/Transactionc/check_waller_debit_bill_no",
              success: function (data)
              {
                  if (data == 1)
                  {
                      $("#manual_bill_no").val("");
                      $("#BillNO").html("Already exist");
                      $("#manual_bill_no").addClass("form-control has-error");
                  }
				  else
                  {
                      // $("#BillNO").html("Bill Number Available");
                      $("#manual_bill_no").removeClass("has-error");
                      $("#BillNO").html("");
                  }
              }
          });
      }
  });
</script>
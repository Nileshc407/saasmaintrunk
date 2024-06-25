<?php $this->load->view('header/header'); 
$Wallet_flag = $Company_details->Enable_wallet_flag; ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header"> PERFORM WALLET DEBIT TRANSACTION</h6>
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
                          echo form_open('Transactionc/wallet_debit', $attributes);
                        ?>
						<div class="col-sm-8">
                        <div class="form-group">
                            <label for=""> <span class="required_info">*</span> Membership ID / Phone No. <span class="required_info"> (Enter Membership ID or Phone No. without Country Code)</span> </label>
                            <input class="form-control" data-error="Enter Membership ID or Phone No" placeholder="Enter Membership" required="required" type="text" name="cardId" id="cardId" value="<?php if (isset($_SESSION["Set_Membership_id"])) {
                          echo $_SESSION["Set_Membership_id"];  } ?>" <?php if (isset($_SESSION["Set_Membership_id"])) { echo "readonly"; } ?> >
                            <div class="help-block form-text with-errors form-control-feedback"> </div>
                        </div>
                          
						  	<?php if($Wallet_flag == 0) { ?>
							<div class="form-buttons-w">
								<span class='required_info'><h5>Access to Wallet not provided to the Company. Please contact Admin! </h5></span>	
							</div>
							<?php } else { ?>
							<div class="form-buttons-w">
								<button class="btn btn-primary" id="submit" type="submit"> Submit</button>
							</div>
							<?php } ?>
					
                        <?php echo form_close(); ?>
						
						
						</div>
                    </div>
                </div>



			<!-------------------- START - Data Table -------------------->	  
			<?php if($results != NULL) { ?>
                <div class="element-wrapper">                
                    <div class="element-box">
                        <h5 class="form-header">
                            Wallet Debit Transaction
                        </h5>                  
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th>Transaction Date</th>
										 <th>Bill No.</th>
                                        <th>Name</th>
                                        <th>Membership ID</th>
                                       <th>Debit Amount</th>
                                       <th>Remark</th>

                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
                                        <th>Transaction Date</th>
                                        <th>Bill No.</th>
                                        <th>Name</th>
                                        <th>Membership ID</th>
                                       <th>Debit Amount</th>
                                        <th>Remark</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                      <?php
                                      
                                          foreach($results as $row)
                                          {
                                           ?>
                                        <tr>
                                            <td><?php echo date('Y-m-d', strtotime($row->Trans_date)); ?></td>
                                            <td><?php echo $row->Manual_billno; ?></td>
                                            <td><?php echo $row->First_name . ' ' . $row->Last_name; ?></td>
                                            <td><?php echo $row->Card_id; ?></td>
                                            <td><?php echo $row->Wallet_amount; ?></td>
                                            <td><?php echo $row->Remarks; ?></td>
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
<div id="msg_myModal" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
			  <div class="modal-header">
				
				<!--<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>-->
			  </div>
			  <div class="modal-body">
				<span class='required_info'><h5>Access to Wallet not provided to the Company. Please contact Admin! </h5></span>	
			  </div>
			  <div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button"> Ok</button>
			  </div>
			</div>
		</div>
    </div>	
<!-- Modal -
<div id="receipt_myModal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 100%;margin-top:180px;">

     
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
-->








<?php $this->load->view('header/footer'); ?>

<script>
$( document ).ready(function() 
{
	// $('#msg_myModal').modal({backdrop: 'static', keyboard: false}) 
	var Wallet_flag = '<?php echo $Wallet_flag; ?>';
	if(Wallet_flag == '0')
	{
		$('#msg_myModal').modal('show');
	}
});
  $('#submit').click(function ()
  {
    if($('#cardId').val() != ""){      
      show_loader();        
    }
  });
  function receipt_details(Bill_no, Seller_id, Trans_id,Transaction_type)
  {
      // alert("--Bill_no--"+Bill_no+"--Seller_id--"+Seller_id+"--Trans_id--"+Trans_id);
      // return false;
      // var Transaction_type = 3;
      $.ajax({
          type: "POST",
          data: {Bill_no: Bill_no, Seller_id: Seller_id, Trans_id: Trans_id, Transaction_type: Transaction_type},
          url: "<?php echo base_url() ?>index.php/Transactionc/transaction_receipt",
          success: function (data)
          {
              $("#show_transaction_receipt").html(data.transactionReceiptHtml);
              $('#receipt_myModal').modal('show');
			  
          }
      });
  }
 
</script>


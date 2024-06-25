<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">Issue / Credit <?php echo $Company_details->Currency_name; ?></h6>
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
                          echo form_open('Coal_Transactionc/issue_bonus', $attributes);
                        ?>
						<div class="col-sm-8">
							<div class="form-group">
								<label for=""> <span class="required_info">*</span> Membership ID / Phone No. <span class="required_info"> (Enter Membership ID or Phone No. without Country Code)</span> </label>
								<input class="form-control" data-error="Enter Membership ID or Phone No" placeholder="Enter Membership" required="required" type="text" name="cardId" id="cardId" value="<?php if (isset($_SESSION["Set_Membership_id"])) {
							  echo $_SESSION["Set_Membership_id"];
							} ?>" <?php if (isset($_SESSION["Set_Membership_id"])) {
							  echo "readonly";
							} ?> >
								<div class="help-block form-text with-errors form-control-feedback">
								</div>
							</div>
                            <?php if ($Seller_topup_access == 1) { ?>
                            <div class="form-group">
                                <label for="CurrentBalance"> Current Balance</label>
                                <?php
                                if ($Seller_balance < 0) {
                                  $Seller_balance = 0;
                                }
                                ?>
                                <input class="form-control"  type="text" value="<?php echo $Seller_balance; ?>" readonly >
								<?php if ($Threshold_Merchant >= $Seller_balance) { ?>
                                  <div class="help-block form-text with-errors form-control-feedback">
                                      Warning:<i> Your Current Balance has breached the Threshold Balance <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please Topup your balance immediately!!!</i>
                                  </div>
                              </div>	
								<?php }							
							}
							?>


							<div class="form-buttons-w">
								<button class="btn btn-primary" type="submit"  value="Register" id="Register"> Submit</button>
							</div>
						</div>
						<?php echo form_close(); ?>
                    </div>
                </div>



                <!-------------------- START - Data Table -------------------->	
				<?php if($results != NULL)
				{ ?>
					<div class="element-wrapper">                
						<div class="element-box">
							<h5 class="form-header">
								Issue Bonus <?php echo $Company_details->Currency_name; ?>
							</h5>                  
							<div class="table-responsive">
								<table id="dataTable1" width="100%" class="table table-striped table-lightfont">
									<thead>
										<tr>
											<th>Receipt</th>
											<th>Transaction Date</th>
											<th>Name</th>
											<th>Membership ID</th>
										   <th class="text-center">Bonus <?php echo $Company_details->Currency_name; ?> Issued</th>

										</tr>
									</thead>						
									<tfoot>
										<tr>
											<th>Receipt</th>
											<th>Transaction Date</th>
											<th>Name</th>
											<th>Membership ID</th>
											<th>Bonus <?php echo $Company_details->Currency_name; ?> Issued</th>
										</tr>
									</tfoot>
									<tbody>
										  <?php foreach ($results as $row) { ?>
											<tr>
												<td class="row-actions">
													<a href="javascript:void(0);" id="receipt_details" onclick="receipt_details('<?php echo $row->Bill_no; ?>',<?php echo $row->Seller; ?>,<?php echo $row->Trans_id; ?>);" title="Receipt" ><i class="os-icon os-icon-ui-49" ></i></a>
												</td>
												<td><?php echo date('Y-m-d', strtotime($row->Trans_date)); ?></td>
												<td><?php echo $row->First_name . ' ' . $row->Last_name; ?></td>
												<td><?php echo $row->Card_id; ?></td>
												<td><?php echo $row->Topup_amount; ?></td>
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

<?php $this->load->view('header/footer'); ?>

<script>
  $('#Register').click(function ()
  {
    if($('#cardId').val() != ""){      
      show_loader();        
    }
  });
  function receipt_details(Bill_no, Seller_id, Trans_id)
  {
      // alert("--Bill_no--"+Bill_no+"--Seller_id--"+Seller_id+"--Trans_id--"+Trans_id);
      // return false;
      var Transaction_type = 1;
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


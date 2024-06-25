<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">STEP 2: Select Loyalty Rule</h6>
                    <div class="element-box">

						 <?php
						 $attributes = array('id' => 'formValidate');
                         echo form_open('Data_transform/verify_data_file', $attributes);
						  
						  
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
                          <?php }

							if ($file_status == 3 && $UploadData == NULL) {
								echo '<div class="text-center"><font color="red">Valid Transactions not found!</font></div>';
							}
							?>
						<?php
						if ($UploadData != NULL) {  
                        ?>
							<?php /*if ($Super_seller == 1) { ?>
								<div class="form-group" >
									<label for=""> <span class="required_info">*</span>Merchant Name (Business/Merchant)</label>
									<select class="form-control" name="seller_id" id="seller_id" data-error="Select Merchant" required="required" onchange="loyalty_program(this.value);">
									<option value="<?php echo $seller_id; ?>"><?php echo $Selected_seller_name; ?></option>
									</select>
									<div class="help-block form-text with-errors form-control-feedback" id="sellerId"></div>
								</div>	
							<?php } */?>	
							<div class="form-group">
								<label for=""> <span class="required_info">*</span>Loyalty Rule</label>
								<select class="form-control select2" multiple="true" name="lp_rules[]" id="lp_rules" data-error="Please select Loyalty Rules" required="required" onchange="loyalty_program_info(this.value);">
								<?php 
									foreach($lp_array as $lp){
										?>
										<option value="<?php echo $lp->Loyalty_name; ?>" selected="true"><?php echo $lp->Loyalty_name; ?></option>
										<?php
									}
								?>
								
								</select>
								<div class="help-block form-text with-errors form-control-feedback" id="lpRules"></div>
							</div> 							
							<?php /* ?>
							<div class="form-group">
								<label for=""> <span class="required_info">*</span>Loyalty Rule</label>
								<select class="form-control select2" multiple="true" name="lp_rules" id="lp_rules" data-error="Select Merchant" required="required" onchange="loyalty_program_info(this.value);">
									
								</select>
								<div class="help-block form-text with-errors form-control-feedback" id="lpRules"></div>
							</div>  

							<?php */ ?>
							<div class="form-buttons text-center">   
							<?php /* ?>
								<input type="text" name="file_status" value="<?php echo $file_status; ?>" />			
								<input type="text" name="filename" value="<?php echo $filename; ?>" />									
								<input type="text" name="Total_error_count" value="<?php echo $Total_error_count; ?>" />
								<input type="text" name="Total_row" value="<?php echo $Total_row; ?>" />
								<input type="text" name="Error_row" value="<?php echo $Error_row; ?>" />
								<input type="text" name="Success_row" value="<?php echo $Success_row; ?>" />  
								<?php */ ?>
								<input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>" />
								<input type="hidden" name="outlet_id" value="<?php echo $outlet_id; ?>" />
								<input type="hidden" name="Brand_id" value="<?php echo $Brand_id; ?>" />
								<button class="btn btn-primary" type="submit" id="submit" name="submit"> Submit</button>
							</div>
					</div>
					
						<!--<div id="lp_info">	
						
						</div> -->	
						<?php 
						echo form_close(); 
						}
						?>
                </div>
				
				
				<?php
				if ($UploadData != NULL) {  
				?>
				
				<div class="element-wrapper" id="lp_info">                
					<div class="element-box">
						<h5 class="form-header"> Loyalty Rules </h5>                  
						<div class="table-responsive">
							<table id="dataTable2" width="100%" class="table table-striped table-lightfont">
								<thead>
									<tr>
										<th class="text-center">Loyalty Program Name</th>
										<th class="text-center" colspan="2">Validity Of Transaction</th>
										<th class="text-center">Loyalty @ Transaction</th>
										<th class="text-center" colspan="2">Loyalty @ Value</th>
													
									</tr>
									<tr>
										<th class="text-center"></th>
										<th class="text-center">From Date</th>
										<th class="text-center">Till Date</th>
										<th class="text-center"> % <?php echo $Company_details->Currency_name; ?>  Gained</th>
										<th class="text-center">Value</th>
										<th class="text-center"> % <?php echo $Company_details->Currency_name; ?>  Gained</th>
									</tr>
								</thead>
								<tbody>
										<?php
											if($lp_array != NULL)
											{
												
												foreach($lp_array as $rows)
												{
													$lp_name = $rows->Loyalty_name;
													$Loyalty_id = $rows->Loyalty_id;
													$From_date = date("Y-m-d",strtotime($rows->From_date));
													$Till_date = date("Y-m-d",strtotime($rows->Till_date));
													$PABA_val = substr($rows->Loyalty_name,0,2);
													
													$Loyalty_at_transaction = $rows->Loyalty_at_transaction;
													$Loyalty_at_value = $rows->Loyalty_at_value;
													$discount = $rows->discount;
													$SellerID = $rows->Seller;
													$Company_id = $rows->Company_id;
													$todays=date("Y-m-d");
													
													if(($todays >= $From_date) && ($todays <= $Till_date))
													{		
												
													?>
													<tr>

														<td><?php echo $lp_name;?></td>
														
														<?php 
															
															
															if(($todays >= $From_date) && ($todays <= $Till_date))
															{
																echo "<td style='color:green'>".$From_date."</td>";
																echo "<td style='color:green'>".$Till_date."</td>";
															}
															else
															{
																echo "<td>".$From_date."</td>";	
																echo "<td>".$Till_date."</td>";	
															}
														?>

														<td><?php echo $Loyalty_at_transaction;?></td>
														<td><?php echo $Loyalty_at_value;?></td>
														<td><?php echo $discount;?></td>
										
													</tr>
													<?php
													}
												}
											}
											?>							
								</tbody> 
							</table>
						</div>
					</div>
				</div>				
				<?php } ?>
				<!-------------------- End - Loyalty Rule Data Table -------------------->	  
				
				
				<!-------------------- START - Upload_errors Data Table -------------------->	  
				<?php
				/* var_dump($lp_array); */
			  if ($Upload_errors != NULL) {
				?>
                <div class="element-wrapper">                
                    <div class="element-box">
                        <h5 class="form-header">
                            <font color="red">File Upload Errors </font>| <font color="green">Upload File: <?php echo $filename; ?> </font>
                        </h5>                  
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th>Transaction Date</th>
                                        <th>Error</th>
                                        <th>Membership ID</th>
                                       <th>Bill No.</th>
                                       <th>Transaction Amount ( <?php echo $Company_details->Currency_name; ?> )</th>

                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
                                        <th>Transaction Date</th>
                                        <th>Error</th>
                                        <th>Membership ID</th>
										<th>Bill No.</th>
                                        <th>Transaction Amount ( <?php echo $Company_details->Currency_name; ?> )</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                      <?php
										foreach ($Upload_errors as $rower) {
										  ?>
											  <tr>

												  <td><?php echo $rower->Error_transaction_date; ?></td>
												  <td><?php echo "Row no." . $rower->Error_row_no . " " . $rower->Error_in; ?></td>
												  <td><?php echo $rower->Card_id; ?></td>
												  <td><?php echo $rower->Bill_no; ?></td>
												  <td><?php echo $rower->Transaction_amount; ?></td>

											  </tr>
										  <?php
										}
										?>
                                </tbody>
                            </table>
                        </div>
                    </div>
				</div>
				
					<?php if ($UploadData == NULL) { ?>				  
						<div class="form-buttons text-center">
							<button type="submit" name="Upload_files_errors" value="Upload_files_errors" id="Upload_files_errors" class="btn btn-primary">Send Errors</button>
						</div>				  
					<?php } ?>
				<?php } ?>                
                <!--------------------  END - Upload_errors Data Table  -------------------->
				
				<!-------------------- START - UploadData Data Table -------------------->	  
				<?php if ($UploadData != NULL) { ?>
                <div class="element-wrapper">                
                    <div class="element-box">
                        <h5 class="form-header">
                           <font color="green">File Valid Data</font><font color="green" size='1em'>&nbsp;&nbsp;(Loyalty rule will apply on this transactions)</font>
                        </h5>                  
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
										<th>Transaction Date</th>
										<th>Membership Id</th>
										<th>Bill No.</th>
										<th>Transaction Amount ( <?php echo $Company_details->Currency_name; ?> )</th>
										<th>Quantity</th>
										<th>Remarks</th>
										<th>Payment By</th>

                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
                                        <th>Transaction Date</th>
										<th>Membership Id</th>
										<th>Bill No.</th>
										<th>Transaction Amount ( <?php echo $Company_details->Currency_name; ?> )</th>
										<th>Quantity</th>
										<th>Remarks</th>
										<th>Payment By</th>
                                    </tr>
                                </tfoot>
                                <tbody>
									<?php
									$todays = date("Y-m-d");
									foreach($UploadData as $row) {
									?>
										<tr>
											<td><?php echo $row->Pos_Transdate; ?></td>
											<td><?php echo $row->Pos_Customerno; ?></td>
											<td><?php echo $row->Pos_Billno; ?></td>
											<td><?php echo $row->Pos_Billamt; ?></td>
											<td><?php echo $row->Pos_Quantity; ?></td>
											<td><?php echo $row->Remarks; ?></td>
											<td><?php echo $row->Payment_type; ?></td>
										</tr>
									<?php
									}
									?>
                                </tbody>
                            </table>
                        </div>
                    </div>
				</div>
				<?php } ?>                
                <!--------------------  END - UploadData Data Table  -------------------->
				
				
            </div>
           
        </div>
    </div>	
</div>	

	
<?php $this->load->view('header/footer'); ?>
<script>

	
	
	$('#submit').click(function ()
	{
		// alert($('#lp_rules').val());
		// return false;
		
		if ($('#lp_rules').val() != "" &&  $('#seller_id').val() != "")
		{
			
			show_loader();
		  
		}
		
		
	});

$(document).ready(function() {
    $("table[id^='dataTable1']").DataTable( {
        "scrollY": "200px",
        "scrollCollapse": true,
        "searching": true,
        "paging": true,
		 "bDestroy": true
    } );
} );



loyalty_program(<?php echo $seller_id; ?>);


	function loyalty_program(seller_id)
	{

		
      // console.log('--lp seller_id--'+ seller_id);

      $.ajax({
          type: "POST",
          data: {seller_id: seller_id},
          url: "<?php echo base_url() ?>index.php/Data_transform/get_loyalty_program",
		  dataType: "json",
          success: function (json)
          {
			
			  
			/* if(json.Error_flag ==0)
			{ 
				$("#lp_rules").append($('<option selected=\'true\'value=\'\'>Please Select Loyalty Rule</option>'));
			
			}
			else{
				
				var mySelect = $('#lp_rules');
				$.each(json, function(val, text) {				  
					$("#lp_rules").append($('<option selected=\'true\'></option>').val(val).html(text));
				});
			} */
			  
              //$('#seller_loyalty_list').html(data);
          }
      });

	}
	function loyalty_program_info(Loyalty_names)
	{
		<?php if ($Super_seller == 0) { ?>
			  var selected_seller =<?php echo $enroll; ?>;
		<?php } else { ?>
			  var selected_seller = document.getElementById("seller_id").value;
		<?php } ?>
		
		  var Company_id = '<?php echo $Company_id; ?>';
		  var seller_id = "<?php echo $seller_id; ?>";
		  
		  /* alert('--lp Company_id--'+ Company_id);
		   alert('--lp Loyalty_names--'+ Loyalty_names); */
		   // var Loyalty_names='PA-Manson Dhamaka,PA-Winter Bonanza'
		   
		  

			var Lpid = new Array();

			Lpid = $('#lp_rules').val();
			// Lpid = Loyalty_names;
		   
		   // console.log(Lpid);
		   
		    if (Lpid != "") {
		  
			  $.ajax({
				  type: "POST",
				  data: {lp_id: Lpid, Company_id: Company_id,seller_id:seller_id},
				  url: "<?php echo base_url() ?>index.php/Transactionc/get_loyalty_program_details",
				  success: function (data)
				  {
					  $('#lp_info').html(data);
				  }
			  });
			  
			} else {
			  $('#lp_info').html("");
			}
		   
			
		  /* $.ajax({
			  type: "POST",
			  data: {Loyalty_names: Loyalty_names, Company_id: Company_id, selected_seller: selected_seller},
			  url: "<?php echo base_url() ?>index.php/Data_transform/get_loyalty_program_details",
			  success: function (data)
			  {
				  $('#lp_info').html(data);
			  }
		  }); */

	}
	
	
</script>

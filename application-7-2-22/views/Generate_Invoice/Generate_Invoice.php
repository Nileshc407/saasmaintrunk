<?php $this->load->view('header/header'); ?>
<div class="content-i">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">Generate Transaction Invoice</h6>
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
                          echo form_open('Generate_Invoice', $attributes);
                        ?>   
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for=""><span class="required_info">*</span> Company Name</label>									
										<select class="form-control" data-error="Select Company Name" required="required"  name="Company_id" name="Company_id" >
											<option value="<?php echo $Company_details->Company_id; ?>"><?php echo $Company_details->Company_name; ?></option>
										</select>							
										<div class="help-block form-text with-errors form-control-feedback" id="CompanyName"></div>
									</div>
									<div class="form-group">
										<label for=""><span class="required_info">*</span>Merchant Name</label>
										<select class="form-control" data-error="Select Merchant Name" required="required" name="Seller_id" ID="Seller_id" >
											<option value="">Select Merchant</option>	
											<?php
												if($Logged_user_id ==2 && $Super_seller == 1)
												{	
													foreach($Seller_array as $seller_val)
													{	
														echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";
													}
												}
												else if($Logged_user_id == 7)
												{		
													foreach($Seller_array as $seller_val)
													{	
														echo "<option value=".$seller_val->Enrollement_id.">".$seller_val->First_name." ".$seller_val->Last_name."</option>";	
													}
												}
												else
												{
													echo '<option value="'.$enroll.'">'.$LogginUserName.'</option>';
												}
											?>
										</select>
										<div class="help-block form-text with-errors form-control-feedback" id="MerchantName"></div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<label for=""><span class="required_info">*</span> From Date<span class="required_info">(* click inside textbox)</span> </label>
										<input class="form-control" data-error="Select From Date" placeholder="Select From Date" required="required" type="text" id="datepicker1" name="from_Date">
										<div class="help-block form-text with-errors form-control-feedback" id="FromDate"></div>
									</div>
									<div class="form-group">
										<label for=""><span class="required_info">*</span> To Date<span class="required_info">(* click inside textbox)</span> </label>
										<input class="form-control" data-error="Select To Date" placeholder="Select To Date" required="required" type="text" id="datepicker2" name="till_Date">
										<div class="help-block form-text with-errors form-control-feedback" id="ToDate"></div>
									</div>
								</div>
							</div>	
								<div class="form-buttons text-center">	
									<input type="hidden" name="From_bill_date" id="From_bill_date" class="form-control" value="<?php echo $from_Date;?>" />	
									<input type="hidden" name="To_bill_date" id="To_bill_date" class="form-control" value="<?php echo $till_Date;?>" />
									<button class="btn btn-primary" type="submit" name="submit" id="submit" value="submit"> Submit</button>
								</div>
															
                    </div>
                </div>          
           
				<!-------------------- START - Data Table -------------------->	  
				<?php
				if($Invoice_details != NULL)
				{
					
					
				?>	
                <div class="element-wrapper">                
                    <div class="element-box">
                        <h5 class="form-header">
                            Transaction Details
                        </h5>                  
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Trans Date</th>
										 <th>Trans Type</th>
                                        <th>Trans Bill No.</th>
                                       
                                        <th>Membership ID</th>
                                        <th>Purchase Amount (<?php echo $Symbol_currency; ?>)</th>
                                        <th>Gained <?php echo $Company_details->Currency_name; ?></th>
                                        <th>Merchant Name</th>

                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
										<th>#</th>
                                        <th>Trans Date</th>
										 <th>Trans Type</th>
                                        <th>Trans Bill No.</th>
                                       
                                        <th>Membership ID</th>
                                        <th>Purchase Amount (<?php echo $Symbol_currency; ?>)</th>
                                        <th>Gained <?php echo $Company_details->Currency_name; ?> </th>
                                        <th>Merchant Name</th>
                                    </tr>
                                </tfoot>
                                <tbody>
								<?php foreach ($Invoice_details as $row) {
										
										if($row->Trans_type==1)
										{
											$Trans_type='Bonus Points';
										}
										else if($row->Trans_type==2)
										{
											$Trans_type='Loyalty Transaction';
										} else {
											$Trans_type='-';
										}
										if($row->Purchase_amount > 0)
										{
											$Purchase_amount=$row->Purchase_amount;
										} else {
											$Purchase_amount='-';
										}
										
										// echo"--Manual_billno--".$row->Manual_billno."--<br>";

				
									?>
                                        <tr>
                                            <td> 
												<input data-type="check" name="Trans_id[]" id="<?php echo $row->Trans_id; ?>"  value="<?php echo $row->Trans_id.'_'.$row->Seller.'_'.$row->Card_id.'_'.$row->Purchase_amount.'_'.$row->Loyalty_pts.'_'.$row->Manual_billno; ?>"  class="checkbox1" type="checkbox" onClick="Add_product_array(<?php echo $row->Trans_id; ?>,'<?php echo $row->Trans_id.'_'.$row->Seller.'_'.$row->Card_id.'_'.$row->Purchase_amount.'_'.$row->Loyalty_pts.'_' . $row->Manual_billno; ?>');">	
												
											</td>
											<td><?php echo $row->Trans_date; ?></td>
											<td><?php echo $Trans_type; ?></td>
											<td><?php echo $row->Bill_no; ?></td>
											<td><?php echo $row->Card_id; ?></td>											
											<td><?php echo $Purchase_amount; ?></td>
											<td><?php echo $row->Loyalty_pts; ?></td>											
											<td><?php echo $row->Seller_name; ?></td>
                                        </tr>
								<?php } ?>
                                </tbody>
								
								
                            </table>
                        </div>						
						<div class="form-buttons text-center">	
							<input type="hidden" name="TransIDArray[]" id="TransIDArray" class="form-control"/>
							<button type="submit" name="Generate_Invoice" value="Generate_Invoice" id="Generate_Invoice" class="btn btn-primary">Generate Invoice</button>	
							<div class="help-block form-text with-errors form-control-feedback" id="GenerateInvoice"></div>
							
						</div>
                    </div>
                </div>
				<?php
				} else { 
					if(isset($_POST['submit'])){
					?>
					<div class="element-box">
						<div class="form-buttons text-center">	
							No Record Found			
						</div>
					</div>
					
				<?php } 
				}
			?>	
			<!--------------------  END - Data Table  -------------------->				
				<?php echo form_close(); ?>			
			<!-------------------- START - Data Table -------------------->	  
			<?php
			//print_r($InvoiceDetails);
			if($InvoiceDetails != NULL)
			{
			?>	
                <div class="element-wrapper">                
                    <div class="element-box">
                        <h5 class="form-header">
                            Generated Invoice
                        </h5>                  
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                        <th>Download Invoice/ Annexure</th>
                                        <th>Invoice No.</th>
                                        <th>Invoice Date</th>
                                        <th>Merchant Name</th>
                                        <th>Cancelled Amount (<?php echo $Symbol_currency; ?>)</th>
                                        <th>Debited <?php echo $Company_details->Currency_name; ?></th>
                                        <th>Invoice Amount (<?php echo $Symbol_currency; ?>)</th>
										<th>Settlement Amount (<?php echo $Symbol_currency; ?>)</th>
										
										

                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
                                        <th>Download Invoice/ Annexure</th>
                                        <th>Invoice No.</th>
                                        <th>Invoice Date</th>
                                        <th>Merchant Name</th>
                                        <th>Cancelled Amount (<?php echo $Symbol_currency; ?>)</th>
                                        <th>Debited <?php echo $Company_details->Currency_name; ?></th>
                                        <th>Invoice Amount (<?php echo $Symbol_currency; ?>)</th>
                                        <th>Settlement Amount (<?php echo $Symbol_currency; ?>)</th>
										
                                    </tr>
                                </tfoot>
                                <tbody>
								<?php foreach ($InvoiceDetails as $row) { ?>
                                        <tr>
											<td>
												<a href="<?php echo base_url() ?>index.php/Generate_Invoice/DownloadInvoice/?Bill_id=<?php echo $row->Bill_id; ?>&Seller_id=<?php echo $row->Seller_id; ?>&Bill_no=<?php echo $row->Bill_no; ?>&flag=0" title="Invoice">
												<i class="os-icon os-icon-ui-44">Invoice</i>
																						
												</a>
												
												<a href="<?php echo base_url() ?>index.php/Generate_Invoice/DownloadInvoice/?Bill_id=<?php echo $row->Bill_id; ?>&Seller_id=<?php echo $row->Seller_id; ?>&Bill_no=<?php echo $row->Bill_no; ?>&flag=1" title="Annexure">
													<i class="os-icon os-icon-ui-44">Annexure</i>
												</a>
											</td>
											<td><?php echo $row->Bill_no; ?></td>
											<td><?php echo date('j, F Y',strtotime($row->Creation_date)); ?></td>
											<td><?php echo $row->First_name." ".$row->Middle_name." ".$row->Last_name;; ?></td>
											<td><?php echo $row->Bill_purchased_amount; ?></td>
											<td><?php echo $row->Joy_coins_issued; ?></td>
											<td><?php echo number_format($row->Bill_amount, 4);?></td>
											<td><?php echo number_format($row->Settlement_amount, 4); ?></td>
                                        </tr>
								<?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
				<?php
				} else { 
				
					if(isset($_POST['submit'])){
					?>
					<div class="element-box">
						<div class="form-buttons text-center">	
							No Record Found			
						</div>
					</div>					
				<?php } 
				}
			?>	
			
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


$('#submit').click(function()
{
	if( $('#Company_id').val() != "" &&  $('#Seller_id').val() != "" &&  $('#datepicker1').val() != "" &&  $('#datepicker2').val() != "")
	{
		show_loader();
	}
	
});
$('#Generate_Invoice').click(function()
{
	$("#Company_id").removeAttr("required");
	$("#Seller_id").removeAttr("required");
	$("#datepicker1").removeAttr("required");
	$("#datepicker2").removeAttr("required");
	
	// show_loader();
	
	
	var count_checked1 = $("[name='Trans_id[]']:checked").length; // count the checked rows
	if(count_checked1 == 0) 
	{
		// alert("Please select any record to delete.");
		/* var Title = "Application Information";
		var msg = 'Please select atleast one checkbox to Generate Invoice';
		runjs(Title,msg); */
		
		
          $("#GenerateInvoice").html("Please select atleast one checkbox to Generate Invoice");
		  
		  
		return false;
	}
	show_loader();
	
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








var cart1 = [];
function Add_product_array(Itemid,qty)
{
	// console.log('----Itemid----='+Itemid);
	// console.log('----qty----='+qty);
	var count_checked = ($('input[id='+Itemid+']:checked').length);	
	// console.log('----count_checked----='+count_checked);
	indexi = cart1.map(function(e) { return e.Item_id; }).indexOf(Itemid);	
	// console.log('----index----='+indexi);
	if(count_checked==1) {
		
		 // var found = jQuery.inArray(Item_id, cart1);
		//const index = cart1.findIndex(x => x.Item_id === Itemid);
		// console.log('----index----='+indexi);
		var item1 = { Item_id: Itemid,Details: qty }; 
		if (indexi >= 0 ) {
			// Element was found, remove it.
			cart1.splice(indexi, 1,item1);
			$('#TransIDArray').val(JSON.stringify(cart1));
			
		} else {
			// console.log('----Add----=');
			// Element was not found, add it.
			var item1 = { Item_id: Itemid,Details: qty }; 
			cart1.push(item1);
			// add_product_quantity_array(Itemid);
			$('#TransIDArray').val(JSON.stringify(cart1));
		}
	}
	else{
		
		if (indexi >= 0 ) {
			// Element was found, remove it.
			cart1.splice(indexi, 1);
			$('#TransIDArray').val(JSON.stringify(cart1));
			
		} 
		
	}
	
	// console.log(cart1);
}
</script>

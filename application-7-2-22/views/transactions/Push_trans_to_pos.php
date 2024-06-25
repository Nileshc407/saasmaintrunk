<?php $this->load->view('header/header'); ?>
<div class="content-i" style="min-height:900px;">
    <div class="content-box">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">Resend Online Orders To Store</h6>
                        <?php
                          if (@$this->session->flashdata('success_code')) {
                            ?>	
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('success_code'); ?>
                            </div>
                          <?php } ?>
                        <?php
                          if (@$this->session->flashdata('error_code')) {
                            ?>	
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                                    <span aria-hidden="true"> &times;</span></button>
                                <?php echo $this->session->flashdata('error_code'); ?>
                            </div>
                        <?php } ?>
                </div>
				<?php echo form_open('Transactionc/Push_orders'); ?>
                <div class="element-wrapper">                
                    <div class="element-box">
                        <h5 class="form-header">
                            Failed Orders
                        </h5>                  
                        <div class="table-responsive">
                            <table id="dataTable1" width="100%" class="table table-striped table-lightfont">
                                <thead>
                                    <tr>
                                       <th>Select All<br><input type="checkbox"  id="checkAll" class="checkbox21"  onclick="Check_all();" checked></th>
										<th>Order Date</th>
										<th>Online Order no.</th>
										<th>Order Type</th>
										<th>Outlet Name</th>
										<th>Customer Name</th>
										<th>Customer Phone no.</th>
										<th>Purchase Amount (<?php echo $Symbol_of_currency; ?>) </th>
										<th>Mpesa TransID</th>
										<th>View Order</th> 
                                    </tr>
                                </thead>						
                                <tfoot>
                                    <tr>
                                        <th>Select All<br><input type="checkbox"  id="checkAll" class="checkbox21"  onclick="Check_all();" checked></th>
										<th>Order Date</th>
										<th>Online Order no.</th>
										<th>Order Type</th>
										<th>Outlet Name</th>
										<th>Customer Name</th>
										<th>Customer Phone no.</th>
										<th>Purchase Amount (<?php echo $Symbol_of_currency; ?>) </th>
										<th>Mpesa TransID</th>
										<th>View Order</th> 
                                    </tr>
                                </tfoot>
                                <tbody>
										<?php foreach ($result as $row) { ?>
                                        <tr>
                                            <td>
												<input type="checkbox" name="Bill_no[]" value="<?php echo $row->Bill_no; ?>"  class="checkbox2" checked>
											</td>
											<td><?php echo $row->Trans_date; ?></td>
											<td><?php echo $row->Bill_no; ?></td>
											<td><?php if($row->Order_type == 28){ echo 'Pick-Up'; } else if($row->Order_type == 29) { echo 'Delivery'; } else if($row->Order_type == 107) { echo 'In-Store'; } ?></td>
											<td><?php echo $row->Outlet_name; ?></td>
											<td><?php echo $row->Member_name; ?></td>
											<td><?php echo App_string_decrypt($row->Phone_no); ?></td>
											<td><?php echo $row->Purchase_amt_sum; ?></td>
											<td><?php echo $row->Mpesa_TransID; ?></td>
											<td>
												<a href="javascript:void(0);" onclick="Order_details('<?php echo $row->Bill_no; ?>','<?php echo $row->Enrollement_id; ?>');" title="Click Details" ><i class="os-icon os-icon-ui-49" id="receipt_details"></i></a>
											</td>
                                        </tr>
									<?php } ?>
                                </tbody>
                            </table> 
                        </div>
						<?php if($result!=NULL) { ?>
						<button type="submit" name="submit" value="Register" id="Register" class="btn btn-primary">RESEND TO STORE</button>	
						<?php } ?>
                    </div>
                </div>
				<?php echo form_close(); ?>
            </div>
        </div>
    </div>	
</div>
<!-- Modal -->
<div id="receipt_myModal" style="overflow:auto;" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-md" id="show_transaction_receipt">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-body">
					<div class="table-responsive" id="show_transaction_receipt"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div id="receipt_myModal1" aria-hidden="true" aria-labelledby="myLargeModalLabel" class="modal fade bd-example-modal-lg" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
		  <div class="modal-header">
			<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true"> &times;</span></button>
		  </div>
		  <div class="modal-body">
			<div  id="show_transaction_receipt1"></div>
		  </div>
		  <div class="modal-footer">
			<button class="btn btn-secondary" data-dismiss="modal" type="button"> Close</button> 
		  </div>
		</div>
	</div>
</div>
<?php $this->load->view('header/footer'); ?>
<script>
$('#Register').click(function()
{
	var count_checked = $("[name='Bill_no[]']:checked").length; // count the checked rows
	if(count_checked == 0) 
	{
		var Title = "Application Information";
		var msg = 'Please select order to procceed.!!';
		runjs(Title,msg); 
		return false;
	}  
	else
	{
		show_loader();
	}
});

function Check_all()
{ 
	if ($("#checkAll").attr("data-type") === "check") 
	{
		$(".checkbox2").prop("checked", true);
		$("#checkAll").attr("data-type", "uncheck");
	} 
	else 
	{
		$(".checkbox2").prop("checked", false);
		$("#checkAll").attr("data-type", "check");
	} 
}

function Order_details(Bill_no,Enrollement_id) 
{	
	$.ajax({
		type: "POST",
		data: {Bill_no: Bill_no,Enrollement_id:Enrollement_id},
		url: "<?php echo base_url()?>index.php/Reportc/Show_order_details",
		success: function(data)
		{
			$("#show_transaction_receipt").html(data.transactionReceiptHtml);	
			$('#receipt_myModal').show();
			$("#receipt_myModal").addClass( "in" );	
			$( "body" ).append( '<div class="modal-backdrop fade in"></div>' );
		}
	});
}
</script>
<style>
@media (min-width: 768px)
.modal-dialog {
    width: 600px;
    margin: 30px auto;
}

.modal-dialog {
    position: relative;
    width: auto;
	margin-top: 250px;
}
</style>
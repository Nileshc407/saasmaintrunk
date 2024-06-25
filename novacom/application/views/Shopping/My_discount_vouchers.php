<?php $this->load->view('header/header');?>
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
<section class="content-header">
<h1>My Discount Vouchers</h1>	 
</section>
<?php if($Enroll_details->Card_id == '0' || $Enroll_details->Card_id== "") { ?>
<script>
	BootstrapDialog.show({
	closable: false,
	title: 'Application Information',
	message: 'You have not been assigned Membership ID yet ...Please visit nearest outlet.',
	buttons: [{
		label: 'OK',
		action: function(dialog) {
			window.location='<?php echo base_url()?>index.php/Cust_home/home';
		}
	}]
});
runjs(Title,message);
</script>
<?php }	?>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-12" id="customer-orders"> 
			<div class="box">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Voucher No.</th>
								<th>Voucher Values (<?php echo $Symbol_of_currency; ?>)</th>
								<th>Received Date<span style="font-size: 9px; font-style: italic; color: red;"> (m/d/Y)</span></th>
								<th>Validity<span style="font-size: 9px; font-style: italic; color: red;"> (m/d/Y)</span></th>
								<th>Voucher Status</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$Curent_date = date("Y-m-d");
							
							if($MyDiscountVouchers !="")
							{
								foreach($MyDiscountVouchers as $row)
								{ 
									$Validity = $row->Valid_till;  ?>
									<tr>
										<td><?php echo $row->Gift_card_id; ?></td>
										<td><?php echo number_format($row->Card_value,2); ?></td>
										<td><?php echo date('m/d/Y',strtotime($row->Create_date)); ?></td>
										<td><?php echo date('m/d/Y',strtotime($row->Valid_till)); ?></td>
										<td><?php if($row->Card_balance > 0){ echo "<b style='color:green;'>Issued</b>"; } else { echo "<b style='color:red;'>Used</b>"; } ?></td>	
									</tr>
						<?php }
							}
							else
							{ ?>
								<tr>
									<td colspan="4" class="text-center"><b>No Vouchers Found.!!</b></td>
								</tr>	
					<?php	} ?>
						</tbody>
					</table>
				</div>
				<div class="panel-footer"><?php echo $pagination; ?></div>
			</div>
		</div>
	</div>
</section>
<?php $this->load->view('header/footer'); ?>
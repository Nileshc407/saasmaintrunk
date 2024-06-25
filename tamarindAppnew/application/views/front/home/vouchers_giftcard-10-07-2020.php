<?php $this->load->view('front/header/header');
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);		
if($Current_point_balance<0)
{
	$Current_point_balance=0;
}
else
{
	$Current_point_balance=$Current_point_balance;
}		
?> 
<body style="background-image:url('<?php echo base_url(); ?>assets/img/personal-bg.jpg')">
<div id="wrapper">
		<div class="custom-header">
			<div class="container">
				<div class="heading-wrap">
					<div class="icon back-icon">
						<a href="<?php echo base_url();?>index.php/Cust_home/front_home"></a>
					</div>
					<h2>Vouchers</h2>
				</div>
			</div>
		</div>
		<div class="custom-body select-location-body live_tab_show">
			<!-- <ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="active" id="live-tab" data-toggle="tab" href="#Vouchers_view" role="tab" aria-controls="Vouchers_view" aria-selected="true">Vouchers</a>
				</li>
				<li class="nav-item" role="presentation">
					<a id="map-tab" data-toggle="tab" href="#Gift_card_view" role="tab" aria-controls="Gift_card_view" aria-selected="false">Gift Cards</a>
				</li>
			</ul> -->
			
			<?php if($MyDiscountVouchers !="") {  ?>
				<div class="tab-content">
				  <div class="tab-pane fade show active" id="Vouchers_view" role="tabpanel" aria-labelledby="live-tab">
					<div class="custom-body"><?php
						if($MyDiscountVouchers !="")
						{
							foreach($MyDiscountVouchers as $row)
							{ ?>
							<div class="box transition-box">
								<table width="100%">
									<tr>
										<td><b><?php echo $row->Gift_card_id; ?></b></td>
										<td>&nbsp;</td>
										<td style="text-align: right;"><span class="label-box">Issued On</span> <?php echo "<b>".date('d-M-Y',strtotime($row->Create_date))."</b>"; ?></td>								
									</tr>
									<tr>
										<td><b><?php echo $Currency_Symbol.' '.number_format($row->Card_value,2); ?></b></td>
										<td><?php if($row->Card_balance > 0){ echo "<b style='color:green;'>Issued</b>"; } else { echo "<b style='color:red;'>Used</b>"; } ?></td>
										<td style="text-align: right;"><span class="label-box">Valid Till</span> <?php echo "<b>".date('d-M-Y',strtotime($row->Valid_till))."</b>"; ?></td>								
									</tr>
								</table>
							</div> 
						<?php }
						} ?>
					</div>
				  </div>
				  <div class="tab-pane fade show active" id="Gift_card_view" role="tabpanel" aria-labelledby="live-tab">
					<div class="custom-body"><?php
						/* if($MyGiftCard !="")
						{
							foreach($MyGiftCard as $row)
							{ ?>
							<div class="box transition-box">
								<table width="100%">
									<tr>
										<td><b><?php echo $row->Gift_card_id; ?></b></td>
										<td>&nbsp;</td>
										<td style="text-align: right;"><span class="label-box">Issued On</span> <?php echo "<b>".date('d-M-Y',strtotime($row->Create_date))."</b>"; ?></td>								
									</tr>
									<tr>
										<td><b><?php echo $Currency_Symbol.' '.number_format($row->Card_value,2); ?></b></td>
										<td><?php if($row->Card_balance > 0){ echo "<b style='color:green;'>Issued</b>"; } else { echo "<b style='color:red;'>Used</b>"; } ?></td>
										<td style="text-align: right;"><span class="label-box">Valid Till</span> <?php echo "<b>".date('d-M-Y',strtotime($row->Valid_till))."</b>"; ?></td>								
									</tr>
								</table>
							</div> 
						<?php }
						} */ ?>
					</div>
				  </div>
				</div>
			<?php } else { ?>
				
				<div class="box h-100 custom-form ptb-30">
					<div class="row">
						<div class="col-md-12" style="padding:0; margin:0;">
							<div style="position: absolute;top: 50%;left: 25%;">							
								<h6>Vouchers not available </h6>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			
		</div>
<?php $this->load->view('front/header/footer');  ?>	
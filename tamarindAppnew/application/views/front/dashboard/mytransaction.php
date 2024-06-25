<?php 
$this->load->view('front/header/header'); 

$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
if($Current_point_balance<0){
	$Current_point_balance=0;
}else{
	$Current_point_balance=$Current_point_balance;
}
?>
<body style="background-image:url('<?php echo base_url(); ?>assets/img/transition-bg.jpg')">
	<div id="wrapper">
		<div class="custom-header">
			<div class="container">
				<div class="heading-wrap">
					<div class="icon close-icon">
						<a href="<?php echo base_url(); ?>index.php/Cust_home/front_home"></a>
					</div>
					<h2>My Transactions</h2>
				</div>
			</div>
		</div>
		<div class="custom-body">
	<?php 	if($Trans_details !=Null)
			{ 
				foreach($Trans_details as $row)
				{ 
					$Trans_date = date('d-M-Y', strtotime($row->Trans_date));
					$Loyalty_pts = round($row->Loyalty_pts);
					$Redeem_pts = round($row->Redeem_pts);
					$Purchase_amt = number_format($row->Purchase_amt,2);
					
					if($row->TransType == 2){
						$TransType = "POS";
					}else if($row->TransType == 12){
						if($row->Delivery_method == 28) {
							$Delivery_method1 = "Pick Up";
						} else if($row->Delivery_method == 29) { 
							$Delivery_method1 = "Delivery";
						} else if($row->Delivery_method == 107) { 
							$Delivery_method1 = "In-Store";
						} else {
							$Delivery_method1= " ";
						}
						$TransType = "Online - ".$Delivery_method1;
					}else if($row->TransType == 1){
						$TransType = "Bonus";
					}
					else if($row->TransType == 29){
						if($row->Delivery_method == 28) {
							$Delivery_method1 = "Take Away";
						} else if($row->Delivery_method == 29) { 
							$Delivery_method1 = "Delivery";
						} else if($row->Delivery_method == 107) { 
							$Delivery_method1 = "In-Store";
						} else {
							$Delivery_method1= " ";
						}
						$TransType = "Online - ".$Delivery_method1;
						if($row->Manual_billno == Null)
						{
							$row->Manual_billno = $row->Order_no;
						}
					}
					?>
					<div class="box transition-box">
						<p class="date"><?php echo $Trans_date; ?></p>
						<div class="d-flex justify-content-between">
							<div>
								<h2><?php echo $row->Seller_name; ?></h2>
								<h3><?php echo $TransType; ?></h3>
							</div>
							<div class="text-right">
								<div class="label-box">
									Ref <span class="text-green"><?php echo $row->Manual_billno; ?></span>
								</div>
								<div class="label-box" style="line-height:40px;">
									Amount <span class="text-dark"style="line-height:40px;"><?php echo $Purchase_amt; ?></span>
								</div>
							</div>
						</div>
					</div> <?php
				}
			} ?>
		</div>
<?php $this->load->view('front/header/footer');  ?>
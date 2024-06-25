<?php 
$this->load->view('front/header/header');
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
if($Current_point_balance<0){
	$Current_point_balance=0;
}else{
	$Current_point_balance=$Current_point_balance;
}
?> 
	<header>
		<div class="container">
			<div class="text-center">
				<div class="back-link">
					<a href="<?php echo base_url(); ?>index.php/Cust_home/front_home"><span>My Statement</span></a>
				</div>
			</div>
		</div>
	</header>
		<div class="custom-body">
			<div class="container">
				<div class="cart_list light-box">
				<div class="item" style="padding-bottom: 1px; padding-top: 7px;">
					<h3 style="text-align:center"> Current Balance : <?php echo $Current_point_balance; ?> <?php echo $Company_Details->Currency_name; ?></h3>
				</div>
				<?php
				if($Trans_details !=Null){ 
					foreach($Trans_details as $row){ 
						$Trans_date = date('d-M-Y', strtotime($row->Trans_date));
						// $Loyalty_pts = round($row->Loyalty_pts);
						// $Loyalty_pts = floor($row->Loyalty_pts); //28-11-2020
						$Loyalty_pts = round($row->Loyalty_pts);
						$Redeem_pts = round($row->Redeem_pts);
						
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
						}else if($row->TransType == 29){
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
						}else if($row->TransType == 1){
							$TransType = "Bonus";
						}	
				?>
					
						<div class="item">
							<h2><?php //echo $TransType; ?> Ref:<b><?php echo $row->Manual_billno; ?></b> Date: <b><?php echo $Trans_date; ?></b></h2>
							<ul>
								<li><small><?php echo $row->Seller_name; ?></small></li>
							</ul>
							<ul class="foo">
								<li><span>Earned</span><b style="color: var(--primary);"><?php echo $Loyalty_pts; ?></b></li>
								<li><span>Redeemed</span><b><?php echo $Redeem_pts; ?></b></li>
							</ul>
						</div>
						
					<?php
				}
			} else { ?>
						<div class="item text-center">
							<h2>No records found</h2>
						</div>
			<?php }
			?>
				</div>
			</div>
		</div>
<?php $this->load->view('front/header/footer');  ?>
<style>
.cart_list h3 {
    font-size: 17px;
    color: var(--primary);
    font-weight: 600;
    margin: 0 0 10px;
    justify-content: space-between;
</style>
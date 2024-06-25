<?php 
$this->load->view('front/header/header'); 

$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
if($Current_point_balance<0){
	$Current_point_balance=0;
}else{
	$Current_point_balance=$Current_point_balance;
}

$ci_object = &get_instance();
$ci_object->load->model('Igain_model');
?>
<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;"></div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
				<div class="leftRight"><button onclick="location.href = '<?php echo base_url();?>index.php/Cust_home/myprofile';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>Transactions</h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>
<main class="padTop padBottom">
	<div class="container">
		<div class="row">
            <div class="col-12 transactionsWrapper">
                <ul class="transactionsHldr">
                    <!--<li class="mb-3 greyTxt">Today</li>-->
			<?php 	if($Trans_details !=Null)
					{ 
						$LVDatetoPrint = '0';
						foreach($Trans_details as $row)
						{ 
							$Trans_date = date('d-M-Y', strtotime($row->Trans_date));
							
							$date1 = date('Y-m-d',strtotime($row->Trans_date));
							$date2 = date('Y-m-d');
							$diff = abs(strtotime($date2) - strtotime($date1));
							$years = floor($diff / (365*60*60*24));
							$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
							$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
							if($years=='0')	
							{ 
								$years=""; 
							}
							else
							{	
								$years=$years.' Year-'; 
							}
							if($months=='0')
							{ 
								$months=""; 
							}
							else
							{
								$months=$months.' Months-';
							}
							if($days=='0')
							{
								$days="";
							}
							else
							{
								$days=$days.' Days ago';
							}
							if( $years=="" && $months =="" &&  $days== "")
							{
								$DatetoPrint = "Today";
								$Trans_date = date('H:i:s A',strtotime($row->Trans_date));
							}
							else if($months == "")
							{
								$DatetoPrint = "Earlier";
							}
							else
							{
								 // $DatetoPrint = "$years $months $days";
								 $DatetoPrint = date('F',strtotime($row->Trans_date));
							}
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
							$Outlet_logo = $row->Outlet_logo;
							$Outlet_logo = $this->config->item('base_url2').$Outlet_logo;	

							$brandID=$ci_object->Igain_model->get_enrollment_details($row->Seller);
							
						?>
							<?php if($DatetoPrint != $LVDatetoPrint){?>
							<li class="mb-3 greyTxt"><?php echo $DatetoPrint ;?></li>
							<?php } ?>
							<li>
								<div class="cardMain d-flex align-items-center w-100">
									<div class="brandLogo"><img src="<?php echo base_url(); ?>assets/brand-<?php echo $brandID->Sub_seller_Enrollement_id; ?>/logo/logo.png"></div>
									<div class="titleTxtMain d-flex flex-column">
										<div class="cf d-flex align-items-center">
											<div class="flex-grow-1"><h2><?php echo $row->Outlet_name; ?></h2></div>
											<div class="greyTxt"><?php echo $Trans_date; ?></div>
										</div>
										<div class="cf d-flex align-items-center">
											<div class="flex-grow-1"><h2><?php echo $TransType; ?></h2></div>
											<div><span class="greyTxt">Ref </span> <?php echo $row->Manual_billno; ?></div>
										</div>
										<div class="cf d-flex align-items-center">
											<div class="flex-grow-1">&nbsp;</div>
											<div><span class="greyTxt">Amount </span> <b class="redTxt"> <?php echo $Purchase_amt; ?></b></div>
										</div>
									</div>
									
								</div>
							</li>
				<?php	 $LVDatetoPrint = $DatetoPrint;
						}
					} ?>
                </ul>
            </div>
		</div>
	</div>
</main>
<?php $this->load->view('front/header/footer');  ?>
<?php $this->load->view('front/header/header');  
	
	$Cust_current_bal = $Enroll_details -> Current_balance;
    	$Cust_Blocked_points = $Enroll_details -> Blocked_points;
    	$Cust_Debit_points = $Enroll_details -> Debit_points;
	
	/* echo "--Cust_current_bal---".$Cust_current_bal."---<br>";
	echo "--Cust_Blocked_points---".$Cust_Blocked_points."---<br>";
	echo "--Cust_Debit_points---".$Cust_Debit_points."---<br>"; */

	$Current_point_balance1 = $Cust_current_bal-($Enroll_details->Blocked_points+$Enroll_details->Debit_points);					
	if($Current_point_balance1<0)
	{
		$Current_point_balance1=0;
	} 
	else
	{
		$Current_point_balance1=$Current_point_balance1;
	}
	// echo "--Current_point_balance1---".$Current_point_balance1."---<br>";
		$cart_check = $this->cart->contents();
			if(!empty($cart_check)) {
				$cart = $this->cart->contents(); 
				$grand_total = 0; 
				$item_count = COUNT($cart); 
				
				
				
			}
			// var_dump($cart);
		
		if($item_count <= 0 ) {
			$item_count=0;
		}
		else {
			
			$item_count = $item_count;
		}				
		
		$wishlist = $this->wishlist->get_content();
		if(!empty($wishlist)) {
			
			$wishlist = $this->wishlist->get_content();
			$item_count2 = COUNT($wishlist); 
			
			foreach ($wishlist as $item2) {
				
				$Product_details2 = $this->Shopping_model->get_products_details($item2['id']);
			}
		}		
		if($item_count2 <= 0 ) {
			$item_count2=0;
		}
		else {
			$item_count2 = $item_count2;
		}
	  $delivery_type=$_SESSION['delivery_type'];
/*  style="background-image:url('img/select-location.jpg')" */

/* style="background-image:url('<?php echo base_url(); ?>assets/img/menu-bg.jpg')" */

$ItemCodeArray=array();

?>
<body>
	<div id="wrapper">
		<div class="custom-header">
			<div class="container">
				<div class="heading-wrap">
					<div class="icon back-icon">
						<a href="<?php echo base_url(); ?>index.php/Shopping/view_cart"></a>
					</div>
					<h2>Make Payment</h2>
				</div>
			</div>
		</div>
		<div class="custom-body payment-body">
		
		<?php if(!empty($cart_check)) { ?>
		
		<?php
						
						
						if($Shipping_charges_flag==2) //Delivery_price
						{
							if($delivery_type==29)
							{									
								$Get_shipping_cost = $this->Igain_model->Get_delivery_price_master_citywise($delivery_outlet_details->City);
								$Shipping_cost= $Get_shipping_cost->Delivery_price;
								//echo"<br>----Shipping_cost----".$Shipping_cost;
								if($Shipping_cost == "" ){	

									$Shipping_cost=0;										
								}
								$Total_Weighted_avg_shipping_cost[]=$Shipping_cost;				
							}
						}						
					//echo"<br>----Total_Weighted_avg_shipping_cost----".$Total_Weighted_avg_shipping_cost;
					
						foreach ($cart as $item) {

								// echo "--Item_code---".$item["options"]['Company_merchandize_item_code']."---<br>";
								
							$ItemCodeArray[]=$item["options"]['Company_merchandize_item_code'];
							
							$Product_details = $this->Shopping_model->get_products_details($item['id']);
							$Partner_state=$item["options"]["Partner_state"];
							$Partner_Country_id=$item["options"]["Partner_Country_id"];				
							if($delivery_type==29)
							{
								$Exist_Delivery_method=1;
								$Weight_in_KG=0;
								$Weight=0;
								foreach($cart as $rec) 
								{	
									// echo"-----$delivery_outlet_details->State=======$customer_delivery_details->State_id-----";
									
									if($delivery_outlet_details->State==$customer_delivery_details->State_id)
									{
										
										// echo "<br><br><b>Item Weight </b>".$rec["options"]["Item_Weight"]."<b>  Quantity </b>".$rec["qty"]."<b>  Weight_unit_id </b>".$rec["options"]["Weight_unit_id"];
										// $Total_weight_same_location=$Weight+($rec["options"]["Item_Weight"]*$item["qty"]);
										
										$Total_weight_same_location=($rec["options"]["Item_Weight"]*$rec["qty"]);
										
										// echo "<br><br><b>Total_weight_same_location </b>".$Total_weight_same_location;
										
										$lv_Weight_unit_id=$rec["options"]["Weight_unit_id"];
										$kg=1;
										switch ($lv_Weight_unit_id)
										{
											case 2://gram
											$kg=0.001;break;
											case 3://pound
											$kg=0.45359237;break;
										}
										// $Total_weight_same_location=array_sum($Total_weight_same_location);
										$Weight_in_KG=($Total_weight_same_location*$kg)+$Weight_in_KG;
										   //echo "<br><br><b>Total_weight_same_location </b>".$Total_weight_same_location."<b>  Weight_unit_id </b>".$lv_Weight_unit_id."<b>  Weight_in_KG </b>".$Weight_in_KG;
										  // $Weight=$Total_weight_same_location;
										  // $Weight=$Weight_in_KG;
									}									
								}
								/*******Single Weight convert into KG****/

								$kg2=1;
								switch ($item["options"]["Weight_unit_id"])
								{
									case 2://gram
									$kg2=0.001;break;
									case 3://pound
									$kg2=0.45359237;break;
								}
								/**************************/
								$Single_Item_Weight_in_KG=($item["options"]["Item_Weight"]*$item["qty"]*$kg2);
								
								//echo "<br><b>Merchandize_item_name </b>".$Product_details->Merchandize_item_name." <br><b>Weight </b>".$item["options"]["Item_Weight"]." <br><b>Single_Item_Weight_in_KG </b>".$Single_Item_Weight_in_KG." Quantity </b>".$item["qty"]." <br><b>Weight_unit_id </b>".$item["options"]["Weight_unit_id"]." <br><b>Weight_in_KG </b>".$Weight_in_KG." <br><b>Partner_state</b> ".$Partner_state;
							}
							else
							{
								$Total_Weighted_avg_shipping_cost[]=0;
								$Weighted_avg_shipping_cost="-";
							}

							/* if($Shipping_charges_flag==2)//Delivery_price
							{
								if($delivery_type==0)
								{
									// $Get_shipping_cost = $this->Igain_model->Get_delivery_price_master($Partner_Country_id,$Partner_state,$To_Country,$To_State,$Weight_in_KG,1);
									
									$Get_shipping_cost = $this->Igain_model->Get_delivery_price_master($delivery_outlet_details->Country,$delivery_outlet_details->State,$customer_delivery_details->Country_id,$customer_delivery_details->State_id,$Weight_in_KG,1);
									
									// echo $this->db->last_query();
									
									$Shipping_cost= $Get_shipping_cost->Delivery_price;
									$Weighted_avg_shipping_cost=(($Shipping_cost/$Weight_in_KG)*$Single_Item_Weight_in_KG);
									$Weighted_avg_shipping_cost=number_format((float)$Weighted_avg_shipping_cost, 2);
									$Total_Weighted_avg_shipping_cost[]=$Weighted_avg_shipping_cost;
									
									
								 // echo "<br><b>Shipping_cost </b>".$Shipping_cost;
								}
							}
							else */
							
							if($Shipping_charges_flag==1)//Standard Charges
							{
								if($delivery_type==29)
								{
									$Cost_Threshold_Limit2=round($Cost_Threshold_Limit);
									if($item['subtotal'] >= $Cost_Threshold_Limit2)
									{	
										$Shipping_cost=round($Standard_charges);
										$Weighted_avg_shipping_cost=round(($Shipping_cost/$Weight_in_KG)*$Single_Item_Weight_in_KG);
										$Total_Weighted_avg_shipping_cost[]=$Weighted_avg_shipping_cost;
									}
									else
									{
										$Shipping_cost=0;
										$Weighted_avg_shipping_cost=0;
										$Total_Weighted_avg_shipping_cost[]=0;
									}
									// echo "<br><b>Standard_charges </b>".$Standard_charges;
								}
							}
							else
							{
								$Shipping_cost=0;
								$Weighted_avg_shipping_cost=0;
								$Total_Weighted_avg_shipping_cost[]=0;
							}
							
							// echo "<br><b>Shipping_pts </b>".$Shipping_pts;
							// echo "<br><b>Weighted_avg_shipping_pts </b>".$Weighted_avg_shipping_pts;
							$Sub_Total[]=$item["Total_points"];
							
							$grand_total = $grand_total + $item['subtotal'];
					
					// echo "<br><b>--------Shipping_pts----</b>".$Shipping_pts;														
					// echo"<br><b>------grand_total------ </b>".number_format($grand_total+$_SESSION['Total_Shipping_Cost'],2);								
										  
				} ?>
				<?php
					if(@$this->session->flashdata('error_code'))
					{
						?>
						<div class="alert bg-warning alert-dismissible" style="background: #F8E0A4 !important;" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h6 class="form-label"><?php echo $this->session->flashdata('error_code'); ?></h6>
						</div>
						<?php
					}
				?>
		<?php 
		
		echo form_open_multipart('Shopping/CheckoutPayment',array('onsubmit'=>'return Validate_form();','id' => 'SubmitForm')); ?>
			<div class="m_payment_total">
				Cart Total: <span class="float-right"><?php echo $Symbol_of_currency; ?>&nbsp;<?php echo  number_format($grand_total+$_SESSION['Total_Shipping_Cost'],2); ?></span>
			</div>
					<?php 
						$_SESSION['Total_Shipping_Cost']=array_sum($Total_Weighted_avg_shipping_cost);
						$_SESSION['Sub_total']=number_format((float)$grand_total, 2);
						// $_SESSION['Grand_total']=($grand_total+$_SESSION['Total_Shipping_Cost']);
						
						// echo "<br>--DiscountAmt-----".$DiscountAmt;
						if($grand_total < $DiscountAmt)
						{
							$DiscountAmt = $grand_total;
						}
						// echo "<br>--DiscountAmt-----".$DiscountAmt;
						$_SESSION['DiscountAmt']=$DiscountAmt;
						$Grand_total=($grand_total+$_SESSION['Total_Shipping_Cost']) - $DiscountAmt;
						$_SESSION['Grand_total']=($grand_total+$_SESSION['Total_Shipping_Cost']) - $DiscountAmt;
					?>
					
			<?php if($Outlet_status_flag != 1) { ?>
				<div class="checkout-btn-wrap">
					<p style="text-align:center;">Outlet Unable to Process Orders<br> Please Try again Later!</p>					
				</div>
			<?php } ?>
			<?php if($Outlet_status_flag==1) { ?>
			
			<div class="accordion" id="accordion">
				
				<!-- Accordion item 0 -->
				<div class="item">
					<div class="accordion-header">
						<button type="button" class="btn" data-toggle="collapse" data-target="#collapse0" aria-expanded="false" id="giftBlock">
							Gift Card
						</button>
					</div>
					<div id="collapse0" class="collapse" data-parent="#accordion">
						<div class="card-body">
							<select class="form-control" name="gift_card_id" id="gift_card_id">
								<option value="0_0_3">SELECT Gift Card</option>			
									<?php  if($GiftCards) { ?>
									
										<?php foreach($GiftCards as $v0){
										?>
											<option value="<?php echo $v0['Gift_card_id']."_".$v0['Card_balance']."_3"; ?>">									
												Value (<?php echo $v0['Gift_card_id']; ?>): <?php echo $Symbol_of_currency; ?> <?php echo number_format($v0['Card_balance'],2); ?>
												</option>								
											
										<?php }
									} 
								?>		
							</select>
							<div id="GiftCard_msg11"></div>
						</div>
					</div>
				</div>
				
				<!-- Accordion item 1 -->
				<div class="item">
					<div class="accordion-header">
						<button type="button" class="btn" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" id="rdm_voucher">
							Redeem Voucher
						</button>
					</div>
					<div id="collapse1" class="collapse" data-parent="#accordion">
						<div class="card-body">
							<select class="form-control" name="Discount_vouchers" id="Discount_vouchers">
								<option value="0_0">SELECT</option>			
								
									<?php 
									if($DiscountVouchers) { ?>
									<option value="0_0"><b>--Discount Vouchers--</b></option>
									<?php foreach($DiscountVouchers as $v){
										// echo"--".$Card_balance."---".$Discount_percentage."---<br>";
											if($v['Discount_percentage'] > 0){ ?>
												
												<option value="<?php echo $v['Gift_card_id']."_".$v['Discount_percentage']."_2"; ?>">Discount: &nbsp;&nbsp;<?php echo $v['Discount_percentage']; ?> %
												</option>
											
											<?php } else {
											?>
												<option value="<?php echo $v['Gift_card_id']."_".$v['Card_balance']."_1"; ?>">Discount : <?php echo $Symbol_of_currency; ?> <?php echo number_format($v['Card_balance'],2); ?>
												</option>
											<?php 
											}
										}
										
									} ?>
									
									
									<?php  if($RevenueVouchers) { ?>
										<option value="0_0"><b>--Revenue Vouchers--</b></option>
										<?php foreach($RevenueVouchers as $v1){
										?>
											<option value="<?php echo $v1['Gift_card_id']."_".$v1['Card_balance']."_1"; ?>">									
												Discount: <?php echo $Symbol_of_currency; ?> <?php echo number_format($v1['Card_balance'],2); ?>
												</option>								
											
										<?php }
									} 
									?>
									<?php 
									
									if($ProductInPercentageVouchers) { ?>
									<option value="0_0"><b>--Product Vouchers--</b></option>	
									<?php foreach($ProductInPercentageVouchers as $Prod){
										
											foreach($Prod as $v2){
												// echo"--".$Card_balance."---".$Discount_percentage."---<br>";
													if($v2['Discount_percentage'] > 0){ ?>
														
														<option value="<?php echo $v2['Gift_card_id']."_".$v2['Reduce_product_amt']."_21"; ?>"><?php echo $v2['Merchandize_item_name']; ?>:<br><?php echo $v2['Discount_percentage']; ?> %
														<?php echo '(For Qty : '.$v2['Quantity'].')'; ?>
														</option>
													<?php } else {
													?>
														<option value="<?php echo $v2['Gift_card_id']."_".$v2['Card_balance']."_1"; ?>">									
														<?php echo $v2['Merchandize_item_name']; ?>:<br> <?php echo $Symbol_of_currency; ?> <?php echo number_format($v2['Card_balance'],2); ?> <?php echo '(For Qty : '.$v2['Quantity'].')'; ?>
														</option>
													<?php 
													}
											}										
											
										}
										
									} ?>
							</select>
							<div id="Gift_card_msg"></div>
						</div>
					</div>
				</div>
				<!-- Accordion item 2 -->
				<div class="item">
					<div class="accordion-header">
						<button type="button" class="btn" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" id="rdm_points">
							Redeem Points
						</button>
					</div>
					<div id="collapse2" class="collapse" data-parent="#accordion">
						<div class="card-body">
								<h4 class="point-count"> <?php echo $Current_point_balance1.' '.$Company_Details->Currency_name; ?> available</h4>
									<div class="point-field">
									<!------onblur="cal_redeem_amt(1);" -------->
										<input type="text" id="point_redeem" name="point_redeem" size="6" onkeyup="this.value=this.value.replace(/\D/g,'')"  
										 placeholder="Enter <?php echo $Company_Details->Currency_name; ?>" class="form-control"/>
										 <div id="point_redeem_div" style="width:225px;"> </div>
										<button type="button" id="cal_redeem_amt_verify" onclick="cal_redeem_amt(1);" >VERIFY</button>
									</div>
						</div>
					</div>
				</div>
				

				<!-- Accordion item 3 -->
				<div class="item">
				
					<div class="accordion-header">
						<button type="button" class="btn" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" id="rdm_mpesa">
							MPESA
						</button>
					</div>
					<div id="collapse3" class="collapse" data-parent="#accordion">
						<div class="card-body">
							<div class="point-field">
								<input type="text" name="Trans_id" id="Trans_id" onkeyup="this.value=this.value.replace(/\D/g,'')" placeholder="Enter MPESA Phone No. as 7xxxxxxxx" maxlength="9" class="form-control"/>
								
								<button type="button" onclick="Call_API();" id="verfify_button" >PAY</button>
								
							</div>
								<p style="color:#322210;font-style: italic;">Enter MPESA Phone No. as 7xxxxxxxx</p>
								<div style="color:red;font-size:12px;" id="Trans_id_error"></div>
								<div style="color:red;font-size:12px;" id="Verify_mpesa_error"></div>
								<table id="mPesaTable" class="table" align="center" style="width:100%;display:none">		
										<!--<tr id="name_block" style="display:none;">
											<th><strong id="Medium_font">Name:</strong></th>
											<td id="name"></td>
										</tr>
										<tr id="amt_block" style="display:none;">
											<th><strong id="Medium_font">Transaction Amount:</strong></th>
											<td id="BillAmount2"></td>
										</tr>
										<tr>
										<th colspan="2" id="compa_block"></th>
											
										</tr>-->
										<tr  id="reenter_block" style="display:none;">
									
										<td colspan="2" align="center">
											<button type="button"  class="btn btn-light" onclick="javascript:re_enter();" >
												Re-Enter
											</button>		
										</td>
										</tr>
								</table>
								
								<!--<div class="lipa-wrap">
									<div class="lipa-img">
										<img src="<?php //echo base_url(); ?>assets/img/lipa.png" alt=""/>
									</div>
									<div class="buy-good">
										<p>Buy goods</p>
										<h3><?php //echo $delivery_outlet_details->goods_till_number; ?></h3>
									</div>
								</div>-->
						</div>
					</div>
				</div>
			<!----------------Nilesh 09-07-2020------------------>	
				<div class="item">
					<div class="accordion-header">
						<button type="button" class="btn" data-toggle="collapse" data-target="#collapse4" aria-expanded="false">
							Credit Card
						</button>
					</div>
					<div id="collapse4" class="collapse" data-parent="#accordion">
						<div class="card-body">
							<div class="point-field">
								<div>
									<div class="help-block" style="float: center;"></div>
								</div>
								<button type="button" onclick="CreateToken(); setLocalStorage();" id="CreateToken_button">Pay now</button> 
							</div><br>
						</div>
					</div>
				</div>
			<!----------------Nilesh 09-07-2020------------------>
						
			<!--<input type="button" id="Credit_card_btn" onclick="setLocalStorage();" class="cust-btn btn-block btn-green" value="Credit Card" /> -->
			</div>
			
			<?php } ?>
			
			<div class="checkout-total">
			
			
				<?php if($DiscountAmt > 0) {  ?>
					<p id="Loyalty_discount_div">Loyalty discount <?php //echo round($DiscountPercentageValue); ?>
							<?php /* if($DiscountRuleSet==1 ){
									echo"%";
								} else if($DiscountRuleSet==2 ) {
								 echo $Symbol_of_currency;
								} */
							 ?>
							<span class="float-right"><?php echo $Symbol_of_currency; ?> 
							<input type="text" id="Loyalty_discount" name="Loyalty_discount"  
								 placeholder="Loyalty discount" class="txt" value="<?php echo number_format($DiscountAmt,2); ?>" readonly></span>
						</p>
					
				<?php } ?>	
				
				<p id="voucher_label2">Gift Card Amount
					<span class="float-right"><?php echo $Symbol_of_currency; ?> <input type="text" class="txt" id="giftCard_amt"  name="giftCard_amt" class="txt"  value="0.00" readonly>
					
					</span>
				</p>
				
				<p id="voucher_label2">Voucher Applied 
					<span class="float-right"><?php echo $Symbol_of_currency; ?> <input type="text" class="txt" id="redeem_voucher_amt"  name="redeem_voucher_amt" class="txt"  value="0.00" readonly>
					
					</span>
				</p>
				
				<p>Redeem Amount <span class="float-right">
						<?php echo $Symbol_of_currency; ?>&nbsp;<input
																type='text'
																name='redeem_amt'
																id='redeem_amt'
																value="0.00"
																class="txt"
																size='6'
																readOnly></span></p>
																
			<!------------------Nilesh 09-07-2020 credit card ------------------->												
				<p id="PaidByMPESA" style="display:none">Paid By MPESA <span class="float-right"><?php echo $Symbol_of_currency; ?>&nbsp;
				<input type='text' name='Paid_by_MPESA' id='Paid_by_MPESA' value="0.00" class="txt" size='6'readOnly></span></p>
				
				<?php //if($DPOCreditAmt > 0 && $DPOCreditAmt != Null) { ?>
				<?php if($DPOCreditAmt > 0 && $DPOCreditAmt != Null && $RedirectCCDapproval != Null && $RedirectTransactionToken != "") { ?>
				<p>Paid By Credit Card <span class="float-right"><?php echo $Symbol_of_currency; ?>&nbsp;
				<input type='text' name='Paid_by_credit_card' id='Paid_by_credit_card' value="<?php echo $DPOCreditAmt; ?>" class="txt" size='6'readOnly></span></p>
				<?php } ?>												
			<!------------------Nilesh 09-07-2020 credit card ------------------->	
			
				Total Due: <span class="float-right"><?php echo $Symbol_of_currency; ?>&nbsp;<input
																		type='text'
																		id='total_bill_amount'
																		class="txt"
																		name='total_bill_amount'
																		size='6'
																		value="<?php echo number_format($_SESSION['Grand_total'],2); ?>"
																		readOnly></span>
				
				
				<!--<p>Loyalty discount 10% <span class="float-right">Kes 60.00</span></p>
				<p>Voucher Applied <span class="float-right">Kes 100.00</span></p>
				<p>Points Redeemed <span class="float-right">Kes 100.00</span></p>

				Total Due: <span class="float-right">360.00</span> -->
			</div>
		<!----------------Nilesh 09-07-2020--------------------->
			<input type="hidden" name="RedirectTransactionToken" id="RedirectTransactionToken">
			<input type="hidden" name="RedirectCCDapproval" id="RedirectCCDapproval">
			<input type="hidden" name="DPOCreditAmt" id="DPOCreditAmt" value="0">
		<!----------------Nilesh 09-07-2020--------------------->
			<?php if($Outlet_status_flag==1) {?>
			<div class="checkout-btn-wrap">
				<p style="color:red;text-align:center;display:none" id="total_bill_amount_error"></p>
				<input type="submit" id="Payment" class="cust-btn btn-block btn-green" value="CHECK OUT" />
				<input type="hidden" name="BillAmount" id="BillAmount" value="0">
				<input type="hidden" name="BillRefNumber" id="BillRefNumber" value="">
				<input type="hidden" name="Mpesa_TransID" id="Mpesa_TransID" value="0">
				<input type="hidden" name="VoucherDiscountAmt" id="VoucherDiscountAmt" value="0">
				<input type="hidden" name="Redeemed_discount_voucher" id="Redeemed_discount_voucher" value="0">
				<input type="hidden" name="redeem_by_voucher" id="redeem_by_voucher" value="1">
				<input type="hidden" name="redeem_voucher" id="redeem_voucher" value="0">
				<input type="hidden" name="gift_card_voucher" id="gift_card_voucher" value="0">
				<input type="hidden" name="discount_voucher_percentage" id="discount_voucher_percentage" value="1">
				<input type="hidden" name="discount_voucher_percentage_value" id="discount_voucher_percentage_value" value="1">
				
				<input type="hidden" name="PaymentMethodBy" id="PaymentMethodBy" value="0">
				
			</div>
			<?php } ?>
			
			<?php echo form_close();  ?>
			
			<?php } else { 
			
					$_SESSION['delivery_type']=""; 
					$_SESSION['delivery_outlet']="";
					$_SESSION['Address_type']="";
					$_SESSION['TableNo']="";
				?>
									
						<h4 class="text-white text-center">Your cart is empty.</h4>
						<br>
						<div class="checkout-btn-wrap d-flex">
							<button type="button" class="btn btn-light bordered m-3" onclick="window.location.href='<?php echo base_url(); ?>index.php/Shopping'" >Add Items</button>
						</div>
				
			<?php } ?>	
		</div>
		<?php $this->load->view('front/header/footer');  ?>
		
		<?php /* var_dump($ItemCodeArray); */  ?>
	
	
	<!-- Loader Modal -->
		<div class="modal fade" id="loader-modal" data-keyboard="false" data-backdrop="static"  tabindex="-1" role="dialog" aria-labelledby="loaderlabel">
			<div class="vertical-alignment-helper">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content" style="height: 180px;">
						<div class="modal-header custom">
							<div class="modal-body">
								<div class="loadingSpinner">
									<div class="spinner-wave">
										<div></div>
										<div></div>
										<div></div>
										<div></div>
										<div></div>
									</div>
									<span class="text-center"><b>Please, wait...</b></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!-- /Loader Modal -->
	
		
		
		<style>
		.point-field input.form-control{
			background: white !IMPORTANT;
			color: #7E746B !IMPORTANT;
		}
		.txt{
			width: 110px;
			border: none;
			background: transparent;
			color: #fff;
			text-align: right;
		}
		</style>
   <script type="text/javascript">
   
	
   
	
	$('select').each(function(){

      var $this = $(this), numberOfOptions = $(this).children('option').length;
	
		var idr = $(this).attr("id");

      $this.addClass('select-hidden'); 
      $this.wrap('<div class="select"></div>');
	  
      if(idr == "gift_card_id")
	  {
		$this.after('<div class="select-styled" id="gift"></div>');
	  }
	  
	   if(idr == "Discount_vouchers")
	  {
		$this.after('<div class="select-styled" id="discount"></div>');
	  }
  
      var $styledSelect = $this.next('div.select-styled');
      $styledSelect.text($this.children('option').eq(0).text());
    
      var $list = $('<ul />', {
          'class': 'select-options'
      }).insertAfter($styledSelect);
    
      for (var i = 0; i < numberOfOptions; i++) {
		  
		   
          $('<li />', {
              text: $this.children('option').eq(i).text(),
              rel: $this.children('option').eq(i).val(),
              id: $this.children('option').eq(i).val()
          }).appendTo($list);
      }
    
      var $listItems = $list.children('li');
    
      $styledSelect.click(function(e) {
		   // alert('Click on SELECT');
		var total_bill_amount = $("#total_bill_amount").val();
		
		var PaymentMethodBy = $("#PaymentMethodBy").val();
		
		/* if(total_bill_amount != 0  ) {  */
		if(PaymentMethodBy == 0  ) { 
				
          e.stopPropagation();
          $('div.select-styled.active').not(this).each(function(){
              $(this).removeClass('active').next('ul.select-options').hide();
          });
          $(this).toggleClass('active').next('ul.select-options').toggle();
		  
		} else {
			
			// alert('in else ');
		}
		  
      });
    
      $listItems.click(function(e) {
		 
          e.stopPropagation();
          $styledSelect.text($(this).text()).removeClass('active');
          $this.val($(this).attr('rel'));
          $this.val($(this).attr('id'));
			
			/* var VCode=$this.val();
			var VoucherLi = VCode.split("_");		
			var VoucherValue = VoucherLi[0];			
		  
			$this.val($(this).attr('id'+VoucherValue)); */
		  
		  
          $list.hide();
		  
		  console.log("Voucher Value-----("+$this.val()+")");
		  
			var giftVal31 = $this.val();
		 	var fields3 = giftVal31.split("_");
			var DiscountPercentageFlag3 = fields3[2];

			
			/* --------setVoucher---------29-05-2020--------------- */
			if(DiscountPercentageFlag3 == 3)
			{
				//if($this.val() != '0_0'){
					
					setGiftVoucher($this.val());
					
				//}
			}
			else if(DiscountPercentageFlag3 != 3)
			{
				if($this.val() != '0_0'){
					
					setVoucher($this.val());
					
				} else {

					setVoucher('0_0');
				}
			}				
			/* --------setVoucher---------29-05-2020--------------- */
			
		  
		  
      });
	  
      $(document).click(function() {
          $styledSelect.removeClass('active');
          $list.hide();
      });
  
  }); 
  
	/* -----------CommaFormatted------29-05-2020--------------- */
		function CommaFormatted(amount) {
			var delimiter = ","; // replace comma if desired
			var a = amount.split('.',2)
			var d = a[1];
			var i = parseInt(a[0]);
			if(isNaN(i)) { return ''; }
			var minus = '';
			if(i < 0) { minus = '-'; }
			i = Math.abs(i);
			var n = new String(i);
			var a = [];
			while(n.length > 3) {
				var nn = n.substr(n.length-3);
				a.unshift(nn);
				n = n.substr(0,n.length-3);
			}
			if(n.length > 0) { a.unshift(n); }
			n = a.join(delimiter);
			if(d.length < 1) { amount = n; }
			else { amount = n + '.' + d; }
			amount = minus + amount;
			return amount;
		}
	/* -----------CommaFormatted------29-05-2020--------------- */
	
	
	/* -----------Payment type discount------03-07-2020--------------- */
	function ApplyPaymentRule(PaymentTypeId)
	{
		var CartTotal = '<?php echo  number_format($grand_total+$_SESSION['Total_Shipping_Cost'],2); ?>';
		CartTotal = CartTotal.split(',').join('');
		
		var lp_discount = '<?php echo $DiscountAmt; ?>';
				
		var redeem_voucher_amt = $("#redeem_voucher_amt").val();
		redeem_voucher_amt = redeem_voucher_amt.split(',').join('');
		
		var redeem_amt = $("#redeem_amt").val();
		redeem_amt = redeem_amt.split(',').join('');
		//var purchase_amt1 = $("#total_bill_amount").val();
		var purchase_amt = parseInt(CartTotal) - (parseInt(lp_discount) + parseInt(redeem_voucher_amt) + parseInt(redeem_amt));
		
		//var purchase_amt = purchase_amt1.split(',').join('');
		if(parseInt(purchase_amt) > 0)
		{			
		//alert(parseInt(purchase_amt));
			 $.ajax({
					type: "POST",
					data: {PaymentTypeId: PaymentTypeId, Grand_total:parseInt(purchase_amt)},
					url: "<?php echo base_url()?>index.php/Shopping/get_payment_type_discount",
					success: function(opt)
					{
						/* var PaymentDis = opt.discount;
						
						var new_purchase_amt22 = parseInt(purchase_amt) - parseInt(PaymentDis);
						var new_amt4 = CommaFormatted(parseFloat(new_purchase_amt22).toFixed(2));
						$("#total_bill_amount").val(new_amt4);
						
						
						var new_lp_discount = parseFloat(lp_discount) + parseFloat(PaymentDis);
						var new_lp_discount2 = CommaFormatted(parseFloat(new_lp_discount).toFixed(2));
						$("#Loyalty_discount").val(new_lp_discount2); */
					}
			});
			
			
			/* 08-07-2020
				$("#rdm_voucher").attr("disabled",true);
				$("#rdm_points").attr("disabled",true); 
			*/
		}
		
	}
	/* -----------Payment type discount------03-07-2020--------------- */
	
	/* -----------setVoucher------29-05-2020--------------- */
		/* function setVoucher(Gift_card_id,Card_balance) */
		function setGiftVoucher(Gift_cardval)
		{
			
			var fields22 = Gift_cardval.split("_");
		
			var Gift_card_id = fields22[0];
			var Card_balance = fields22[1];
			var DiscountPercentageFlag = fields22[2];

			//localStorage.setItem("ArtcffeVoucher",Gift_card);
		//console.log("----Gift_card_id----"+Gift_card_id+"--Card_balance-----"+Card_balance+"--DiscountPercentageFlag-"+DiscountPercentageFlag);
			
		//	alert(Gift_card_id+"---"+Card_balance)
			var purchase_amt = '<?php echo $_SESSION['Grand_total']; ?>';
			var redeem_amt1 = $("#redeem_amt").val();
			
			var redeem_amt = 0;
			var redeem_voucher_amt = 0;
			
			if(redeem_amt1 != "")
			{
				redeem_amt = redeem_amt1.split(',').join('');
			}
			
			var redeem_voucher_amt1 = $("#redeem_voucher_amt").val();
			if(redeem_voucher_amt1 != "")
			{
				redeem_voucher_amt = redeem_voucher_amt1.split(',').join('');
			}
			
		//	console.log("----purchase_amt----"+purchase_amt+"--redeem_amt-----"+redeem_amt+"--redeem_voucher_amt-"+redeem_voucher_amt+"--Card_balance-"+Card_balance);
			
			var new_purchase_amt = parseInt(purchase_amt) - (parseInt(redeem_amt)+ parseInt(redeem_voucher_amt)+ parseInt(Card_balance));
			
			if(new_purchase_amt < 0){
				new_purchase_amt = 0;
			}			
			var new_purchase_amt2 = CommaFormatted(parseFloat(new_purchase_amt).toFixed(2));
			
			$("#giftCard_amt").attr("readonly",'true');
				$("#total_bill_amount").val(new_purchase_amt2);
				$("#gift_card_voucher").val(Gift_card_id);
				
				$("#giftCard_amt").val(CommaFormatted(parseFloat(Card_balance).toFixed(2)));
				
		}
		
		function setVoucher(Gift_card)
		{
				
			var fields = Gift_card.split("_");
		
			var Gift_card_id = fields[0];
			var Card_balance = fields[1];
			var DiscountPercentageFlag = fields[2];

			//localStorage.setItem("ArtcffeVoucher",Gift_card);
		//	console.log("----Gift_card_id----"+Gift_card_id+"--Card_balance-----"+Card_balance+"--DiscountPercentageFlag-"+DiscountPercentageFlag);
			
		//	alert(Gift_card_id+"---"+Card_balance)
			var purchase_amt = '<?php echo $_SESSION['Grand_total']; ?>';
			var redeem_amt1 = $("#redeem_amt").val();
			
			var redeem_amt;
			redeem_amt = redeem_amt1.split(',').join('');
			
			var giftCard_amt22 = 0;
			//**** gift card sandeep 29-09-2020 *******	
			if($("#giftCard_amt").val() > 0)
			{
				var giftCard_amt21 = $("#giftCard_amt").val();
				giftCard_amt22 = giftCard_amt21.split(',').join('');
			}
		//	console.log("--redeem_amt---"+redeem_amt);
			//alert(purchase_amt+"---"+DiscountPercentageFlag+"----"+redeem_amt+"---"+Card_balance);
			/* parseFloat */
			
			/* 25-06-2020 */
			 if(DiscountPercentageFlag==1 || DiscountPercentageFlag==3){
				 
				 var TotalGrand = parseInt(Card_balance) + parseInt(redeem_amt)+ parseInt(giftCard_amt22);
				 
			 } else {
				 
			//	var TotalGrand1 = parseFloat(purchase_amt) - parseFloat(redeem_amt);
			//	console.log("--TotalGrand1---"+TotalGrand1);
			//	var Card_balance1 = parseInt((TotalGrand1 * Card_balance)/100);
				
				if(DiscountPercentageFlag == 21)//Product voucher discount 'AMIT KAMBLE'
				{
					// var Card_balance1 = parseFloat(Card_balance)-parseFloat(redeem_amt);
					var Card_balance1 = parseFloat(Card_balance);
				}
				else
				{
					var Card_balance1 = parseInt((purchase_amt * Card_balance)/100);
				}
				
			//	console.log("--Card_balance1---"+Card_balance1);				
				var TotalGrand = Card_balance1+ parseFloat(redeem_amt) + parseFloat(giftCard_amt22);
			}
			/* 25-06-2020 */
			
			
			
		//	console.log("--TotalGrand---"+TotalGrand+"---purchase_amt----"+purchase_amt);
			
			
			if(TotalGrand > purchase_amt)
			{
				$("#redeem_voucher").removeAttr("required");
				$("#voucher_label").hide();
				$(".voucher_label2").hide();
				$("#point_redeem").removeAttr("readonly");
				$("#redeem_voucher").val(0);
				$("#redeem_voucher_amt").val(0);
				// $("#Payment").attr("disabled", false);
				//**** gift card sandeep 29-09-2020 *******	
					/* if(DiscountPercentageFlag==3){
						var msg = 'Total purchase amount is less than voucher value, please try other voucher';
					  $('#Gift_card_msg').show();
					  $('#Gift_card_msg').css("color", "red");
					  $('#Gift_card_msg').html(msg);
					  setTimeout(function() {
							$('#GiftCard_msg11').hide();
					  }, 3000);
					}
					else  */
					//if(DiscountPercentageFlag!=3)
					//{
					var msg = 'Total purchase amount is less than voucher value, please try other voucher';
					  $('#Gift_card_msg').show();
					  $('#Gift_card_msg').css("color", "red");
					  $('#Gift_card_msg').html(msg);
					  setTimeout(function() {
							$('#Gift_card_msg').hide();
					  }, 3000);
					//}  
				return false;
			}
				// alert(parseInt(purchase_amt)+"--"+redeem_amt+"--"+ parseInt(TotalGrand));
			
			
			// var new_purchase_amt = parseInt(purchase_amt) - parseInt(TotalGrand);
			/* 25-06-2020 */
			var new_purchase_amt = parseFloat(purchase_amt) - parseFloat(TotalGrand);
			/* 25-06-2020 */
				
			//console.log("---new_purchase_amt-----"+new_purchase_amt);
			
			
			if(new_purchase_amt < 0){
				new_purchase_amt = 0;
			}			
			var new_purchase_amt2 = CommaFormatted(parseFloat(new_purchase_amt).toFixed(2));
		//**** gift card sandeep 29-09-2020 *******	
			/* if(DiscountPercentageFlag == 3){
				$("#giftCard_amt").attr("readonly",'true');
				$("#total_bill_amount").val(new_purchase_amt2);
				$("#gift_card_voucher").val(Gift_card_id);
				
				$("#giftCard_amt").val(CommaFormatted(parseFloat(Card_balance).toFixed(2)));
				
				return true;
			} */
			
		//**** gift card sandeep 29-09-2020 *******
		
		//	console.log("---new_purchase_amt2-----"+new_purchase_amt2);
			
			  $("#ContinuetoCart").attr("disabled", false);
				if(new_purchase_amt2 <= 0 ){
					
					$("#point_redeem").attr("readonly",true);
					$("#ContinuetoCart").attr("disabled", false);
					
					
					/* Ravi-13-08-2020 */
						$("#CreateToken_button").css("display","none");
						$("#verfify_button").css("display","none");
						$("#cal_redeem_amt_verify").css("display","none");
						 
					/* Ravi-13-08-2020 */		   
							  
					
				} else {
					$("#point_redeem").attr("readonly",false);
					$("#ContinuetoCart").attr("disabled", true);
					
					/* Ravi-13-08-2020 */
						$("#CreateToken_button").css("display","");
						$("#verfify_button").css("display","");
						$("#cal_redeem_amt_verify").css("display","");
					/* Ravi-13-08-2020 */
					
				}
			
			/* parseFloat(Redeem_amount).toFixed(2) */
			$("#redeem_voucher").val(Gift_card_id);
			// $("#redeem_voucher_amt").val(Card_balance.toFixed(2));
			// $("#redeem_voucher_amt").val(parseInt(Card_balance).toFixed(2));
			// $("#redeem_voucher_amt").val(CommaFormatted(parseFloat(Card_balance).toFixed(2)));
			// $("#redeem_voucher_amt").val(Card_balance);
			$("#Redeemed_discount_voucher").val(Gift_card_id);
			// $("#VoucherDiscountAmt").val(parseInt(Card_balance).toFixed(2));
			
			/* 25-06-2020 */
				if(DiscountPercentageFlag==1){
					$("#redeem_voucher_amt").val(CommaFormatted(parseFloat(Card_balance).toFixed(2)));
					$("#VoucherDiscountAmt").val(parseFloat(Card_balance).toFixed(2));
					
					
				} else{
					$("#redeem_voucher_amt").val(CommaFormatted(parseFloat(Card_balance1).toFixed(2)));
					$("#VoucherDiscountAmt").val(parseFloat(Card_balance).toFixed(2));
					
				}
				
				
				$("#discount_voucher_percentage").val(DiscountPercentageFlag);
				$("#discount_voucher_percentage_value").val(parseFloat(Card_balance).toFixed(2));
				
			/* 25-06-2020 */
			
			$("#redeem_voucher_amt").attr("readonly",'true');
			$("#total_bill_amount").val(new_purchase_amt2);
			$("#close_modal2").text("Apply");
			// $("#Payment").attr("disabled", false);
		}
	/* -----------setVoucher------29-05-2020--------------- */
	
	
	/* -----------Cart_redeem_amt------29-05-2020--------------- */
	
		function cal_redeem_amt(redeemBY) {
           
		   var bal = '<?php echo $Current_point_balance1; ?>';
            // var purchase_amt = '<?php echo $_SESSION['Grand_total']; ?>';
            var purchase_amt =  $("#total_bill_amount").val();
            // var redeem_voucher_amt =  $("#redeem_voucher_amt").val();
            var ratio_value = '<?php echo $Redemptionratio;?>';
            var reedem = $("#point_redeem").val();
            var redeem_voucher_amt1 = $("#redeem_voucher_amt").val();
            var giftCard_amt1 = $("#giftCard_amt").val();
            var grand_total = '<?php echo $_SESSION['Grand_total']; ?>';
           
		   
		   var redeem_voucher_amt;
			redeem_voucher_amt = redeem_voucher_amt1.split(',').join('');
			
			var giftCard_amt;
			giftCard_amt = giftCard_amt1.split(',').join('');
			
			//console.log("--redeem_voucher_amt---"+redeem_voucher_amt);
		   
			var Tot_purAmt=0
			
			Tot_purAmt=(<?php echo $_SESSION['Grand_total']; ?>-redeem_voucher_amt) - giftCard_amt;
			
			
			//console.log("----Tot_purAmt------"+Tot_purAmt);
		   
			//alert('bal'+bal);
            //alert('purchase_amt'+purchase_amt);
           // alert('ratio_value'+ratio_value);
            //alert('grand_total'+grand_total);
            //alert('reedem'+reedem);

			if(reedem){
				reedem=reedem;
			} else {
				reedem=0;
			}
			if(redeem_voucher_amt){
				redeem_voucher_amt=redeem_voucher_amt;
			} else {
				redeem_voucher_amt=0;
			}
			if(giftCard_amt){
				giftCard_amt=giftCard_amt;
			} else {
				giftCard_amt=0;
			}
			
			//console.log("----redeem_voucher_amt------"+redeem_voucher_amt);
			
			
			// grand_total=grand_total+redeem_voucher_amt;
			
			//console.log("----grand_total------"+redeem_voucher_amt);
			
            $.ajax({

                  type: "POST",
                  data: {

                        Current_balance: bal,
                        grand_total: grand_total,
                        redeem_voucher_amt: redeem_voucher_amt,
                        giftCard_amt: giftCard_amt,
                        Redeem_points: reedem,
                        ratio_value: ratio_value,
                        redeemBY: redeemBY
                  },
                  url: "<?php echo base_url()?>index.php/Express_checkout/cal_redeem_amt_contrl/",
                  datatype: "json",
                  success: function(data) {
                       // alert("---Error_flag-----"+data.Error_flag);
                       // alert("---Grand_total-----"+data.Grand_total);
					   
					   $("#PaymentMethodBy").val(0);
					   
                        if (data.Error_flag == 0) {
							
							
							var redAmt = CommaFormatted(parseFloat(data.EquiRedeem).toFixed(2));
							var BillAmt = CommaFormatted(parseFloat(data.Grand_total).toFixed(2));
                              $('#redeem_amt').val(redAmt);
                             // $('#redeem_amt').val(data.EquiRedeem.toFixed(2));
                              //$('#total_bill_amount').val(data.Grand_total.toFixed(2));
							  
							   // console.log("---BillAmt-----"+BillAmt);
							   
							   if(BillAmt == '0' || BillAmt =='0.00' ){
								   
								   $("#CreateToken_button").css("display","none");
								   $("#verfify_button").css("display","none");
								   
								   
								   
							   } else {
								   
								   $("#CreateToken_button").css("display","");
								   $("#verfify_button").css("display","");
							   }
							  
								$('#total_bill_amount').val(BillAmt);
							  
								if(BillAmt <= 0 ){
									
									$("#ContinuetoCart").attr("disabled", true);
									
								} else {
									
									$("#ContinuetoCart").attr("disabled", false);
								}
                        }
                        if (data.Error_flag == 1) {
                              var msg = 'Equivalent Redeem Amount is Greater than Total Bill Amount';
                              $('#point_redeem_div').show();
                              $('#point_redeem_div').css("color", "red");
                              $('#point_redeem_div').html(msg);
                              setTimeout(function() {
                                    $('#point_redeem_div').hide();
                              }, 3000);
                              $("#point_redeem").focus();


                              $('#redeem_amt').val(0);
                              $('#point_redeem').val(0);
                              // $('#total_bill_amount').val(grand_total);
                              // $('#total_bill_amount').val(parseFloat(grand_total).toFixed(2));
                              $('#total_bill_amount').val(parseFloat(Tot_purAmt).toFixed(2));
                        }
                        if (data.Error_flag == 2) {
                              var msg = 'Insufficient Point Balance';
                              $('#point_redeem_div').show();
                              $('#point_redeem_div').css("color", "red");
                              $('#point_redeem_div').html(msg);
								setTimeout(function() {
                                    $('#point_redeem_div').hide();
                              }, 3000);
                              $("#point_redeem").focus();


                              $('#redeem_amt').val(0);
                              $('#point_redeem').val(0);
                              // $('#total_bill_amount').val(grand_total);
							  // $('#total_bill_amount').val(parseFloat(grand_total).toFixed(2));
							  $('#total_bill_amount').val(parseFloat(Tot_purAmt).toFixed(2));
                        }

                        if (data.Error_flag == 3) {
                              $('#redeem_amt').val(0);
                              $('#point_redeem').val(0);
                              // $('#total_bill_amount').val(grand_total);
							  $('#total_bill_amount').val(parseFloat(grand_total).toFixed(2));
                        }
						if (data.Error_flag == 4) {
							
							 var msg = 'Your Point balance is less than Redeemtion limit ( '+ data.Redeemtion_limit +' ) . ';
                              $('#point_redeem_div').show();
                              $('#point_redeem_div').css("color", "red");
                              $('#point_redeem_div').html(msg);
                              setTimeout(function() {
                                    $('#point_redeem_div').hide();
                              }, 3000);
                              $("#point_redeem").focus();
							
                              $('#redeem_amt').val(0);
                              $('#point_redeem').val(0);
                              // $('#total_bill_amount').val(grand_total);
						//	  $('#total_bill_amount').val(parseFloat(grand_total).toFixed(2));
							  $('#total_bill_amount').val(parseFloat(Tot_purAmt).toFixed(2));
                        }
						if (data.Error_flag == 5) {
							
							 var msg = 'You can not redeem more than '+ data.Redeemtion_limit +' . ';
                              $('#point_redeem_div').show();
                              $('#point_redeem_div').css("color", "red");
                              $('#point_redeem_div').html(msg);
                              setTimeout(function() {
                                    $('#point_redeem_div').hide();
                              }, 3000);
                              $("#point_redeem").focus();
							
                              $('#redeem_amt').val(0);
                              $('#point_redeem').val(0);
                              // $('#total_bill_amount').val(grand_total);
							//  $('#total_bill_amount').val(parseFloat(grand_total).toFixed(2));
							  $('#total_bill_amount').val(parseFloat(Tot_purAmt).toFixed(2));
                        }
					}
            });
			
      }
	/* -----------Cart_redeem_amt------29-05-2020--------------- */
	
	
	/* -----------Call_API------29-05-2020--------------- */
	
	
	
	// alert('<?php echo $delivery_outlet_details->goods_till_number; ?>');
		function Call_API()
		{
			
			var goods_till_number= '<?php echo $delivery_outlet_details->goods_till_number; ?>';
			var payment_auth_key = '<?php echo $delivery_outlet_details->Mpesa_auth_key; ?>';
			var dial_code = '<?php echo $dial_code; ?>';
			// var Final_Grand_total= "<?php echo $_SESSION['Grand_total']; ?>"; 
			// var Final_Grand_total= "<?php echo $_SESSION['Final_Grand_total']; ?>"; 
			// var Final_Grand_total= "<?php echo $total_bill_amount; ?>";
			var Final_Grand_total=$("#total_bill_amount").val();
			Final_Grand_total = Final_Grand_total.split(',').join('');
			
			var Seller_api_url2= "<?php echo $delivery_outlet_details->Seller_api_url2; ?>ValidateB2BPayment";
			var Seller_mpesastkpush_api_url= "<?php echo $delivery_outlet_details->Seller_api_url2; ?>mpesastkpush";
			var Trans_id=$("#Trans_id").val();
			
			
			/* 	alert(Final_Grand_total);
				alert(goods_till_number);
				alert(Seller_api_url2);
				alert(Trans_id);
				return false;  */
			
			$("#mPesaTable").css("display","");
			$("#Trans_id_error").html('');
			
			if(Trans_id=="" || Trans_id==0)
			{
				$("#Trans_id_error").html('Enter MPESA Phone No. as 7xxxxxxxx');
				return false;
			}
			$("#verfify_button").html('<font color="green">Verifying</font>');
			$("#verfify_button").attr("disabled", true);
			
			
			
			var loaderModal = $('#loader-modal');
				loaderModal.find('.modal-body').html('<div class="loadingSpinner"><div class="spinner-wave"><div></div><div></div><div></div><div></div><div></div></div><span class="text-center"><b>Please, wait...</b></span></div>');
				
				loaderModal.modal('show');
				
				
			
			
			
			
			$.ajax({
				type: "POST",
				data: {Final_Grand_total: Final_Grand_total, goods_till_number:goods_till_number,Trans_id:Trans_id,Seller_api_url2:Seller_api_url2,payment_auth_key:payment_auth_key,dial_code:dial_code,Seller_mpesastkpush_api_url:Seller_mpesastkpush_api_url},
				url: "<?php echo base_url()?>index.php/Shopping/Verify_mpesa",
				success: function(data)
				{
					console.log(data.response);			
					// console.log(data.BalanceDue);
					loaderModal.modal('hide');	
					var response2 = JSON.parse(data.response);
					// var response2 = JSON.parse(JSON.stringify(data));
					console.log(response2);
					//response2.MpesaPaidAmount = 1190;
					$("#BillAmount").val(response2.PaidAmount); 
					$("#BillRefNumber").val(response2.BillRefNumber); 
					$("#Paid_by_MPESA").val(response2.PaidAmount); // Nilesh 04-7-2020
					$("#Mpesa_TransID").val(response2.TransID); 
					// var h = CommaFormatted(parseFloat(response2.MpesaPaidAmount).toFixed(2));
					var h = response2.BalanceDue;
					//console.log(h);
					$("#BillAmount2").html(h); //response2.MpesaPaidAmount 
					if(response2.ResultCode =='9999' || data.response == false){
						$("#name").html('Incorrect MPesa Code');
					} else {
						$("#name").html(response2.ResultDesc); 
					}
					
					
					
				//	console.log(response2.BalanceDue);	
					
					/* 28-05-2020 */
					
						var new_purchase_amt11 = parseInt(Final_Grand_total) - h;
						// $("#total_bill_amount").val(new_purchase_amt11);
						
					
					/* 28-05-2020 */
					
					
					//$("#CardSubmit").show();
					
					$("#CardSubmit").css("display","");					
					$("#name_block").show();
					$("#amt_block").show();
					$("#reenter_block").show();					
					if(response2.ResultCode =='9999' || data.response == false)
					{
						$("#verfify_button").html('<font color="red">Failed..</font>');
						$("#CardSubmit").css("display","none");
						$("#reenter_block").show();						
						$("#total_bill_amount").val(Final_Grand_total);
						$("#point_redeem").attr("readOnly","");
						
					}
					else
					{
						$("#PaidByMPESA").css("display","");   // Nilesh 9-7-2020
						$("#CreateToken_button").css("display","none");  // Nilesh 9-7-2020
						$("#reenter_block").hide();
						$("#verfify_button").html('<font color="green">Successfull..</font>');						
						$("#point_redeem").attr("readOnly","readOnly");
						// $("#ContinuetoCart").attr("disabled", true);
						$("#Discount_vouchers").attr("disabled", true);
						$("#cal_redeem_amt_verify").css("display","none");
						$("#total_bill_amount").val(0);
						
						$("#PaymentMethodBy").val(1);
						
						ApplyPaymentRule(5);
						
					}
					 
					/*  alert('Final_Grand_total '+parseFloat(Final_Grand_total));
					 alert('MpesaPaidAmount '+parseFloat(MpesaPaidAmount)); */
					 
					var MpesaPaidAmount = response2.PaidAmount;		
					
					
					
				//	 console.log("MpesaPaidAmount--"+parseFloat(MpesaPaidAmount));
				//	 console.log("Final_Grand_total--"+parseFloat(Final_Grand_total));			
					if(parseFloat(Final_Grand_total) < parseFloat(MpesaPaidAmount))
					{
						$("#reenter_block").show();
						$("#CardSubmit").css("display","none");
						$("#compa_block").html('<font color="red">MPesa Paid Amount is Greater than Ordered Amount due!<br>You may need to order more Items to match Paid amount</font>'); 						
						$("#total_bill_amount").val(Final_Grand_total);
						
						$("#point_redeem").attr("readOnly","");
						// $("#ContinuetoCart").attr("disabled", false);
						$("#Discount_vouchers").attr("disabled", false);
						$("#cal_redeem_amt_verify").css("display","");
						
					}
					if(parseFloat(Final_Grand_total) > parseFloat(MpesaPaidAmount))
					{
						$("#reenter_block").show();
						$("#CardSubmit").css("display","none");
						if(response2.ResultCode =='9999' || data.response == false)
						{
							$("#compa_block").html('<font color="red"></font>'); 
						}else {
							$("#compa_block").html('<font color="red">MPesa Paid Amount is not equal to Ordered Amount due!</font>'); 
						}
						
						$("#total_bill_amount").val(Final_Grand_total);
						
						$("#point_redeem").attr("readOnly","");
						// $("#ContinuetoCart").attr("disabled", false);
						$("#Discount_vouchers").attr("disabled", false);
						
						
										
					}
				}
			});
		}
	
	/* -----------Call_API------29-05-2020--------------- */
	
	/* -----------Re-Enter------30-05-2020--------------- */	
		function re_enter()
		{
			// $("#CardSubmit").hide();
			$("#CardSubmit").css("display","none");
			$("#name_block").hide();
			$("#amt_block").hide();
			$("#reenter_block").hide();
			
			$("#verfify_button").html('Verify');
			$("#verfify_button").attr("disabled", false);
			$('#compa_block').html('<font></font>');
						
		}
	/* -----------Re-Enter------30-05-2020--------------- */
	
	/* -----------Form Validation------03-06-2020--------------- */
		function Validate_form(){
			
		//	LocalArtData = JSON.parse(localStorage.getItem("LocalArtcaffeData")); 
		//	console.log(LocalArtData);
			
			var total_bill_amount = $("#total_bill_amount").val();				
			if(parseFloat(total_bill_amount) > 0 ){
				
				var msg = 'Please pay Balance Due!!';
                              $('#total_bill_amount_error').show();
                              $('#total_bill_amount_error').css("color", "red");
                              $('#total_bill_amount_error').html(msg);
								setTimeout(function() {
                                    $('#total_bill_amount_error').hide();
                              }, 8000);
                             
				return false;				
			}
			
			return true;
			
			
			/* setTimeout(function() 
			{
				$('#myModal').modal('show'); 
			}, 0);
			setTimeout(function() 
			{ 
				$('#myModal').modal('hide'); 
			},20000000000); */
			
			
			
			
		}		
		
		
		$("#SubmitForm").on("submit", function(){		
			
			var Validate= Validate_form();
			console.log(Validate);
			
			// return false;
			
			if( Validate == true){
				
				var loaderModal = $('#loader-modal');
				loaderModal.find('.modal-body').html('<div class="loadingSpinner"><div class="spinner-wave"><div></div><div></div><div></div><div></div><div></div></div><span class="text-center"><b>Please, wait...</b></span></div>');
				
				loaderModal.modal('show');
				
				setTimeout(function() {
					loaderModal.modal('hide');	
					
				},20000000000);
				
			} else{
				
				return false;
			}
			
			
			
			
			
			
			
		  });//submit
	/* -----------Form Validation------03-06-2020--------------- */
  
	/* -----------getLocalStorage------08-07-2020--------------- 
		
		
		$( document ).ready(function() {
			console.log( "ready!" );
			
			 /* localStorage.clear(); 
			
			
			
			var retrievedObject = JSON.parse(localStorage.getItem('LocalArtcaffeData'));
			if(retrievedObject){
				
			$("#point_redeem").attr("readOnly","");
			$("#cal_redeem_amt_verify").css("display","none");
			$("#verfify_button").html('<font color="green">Successfull..</font>');
			$("#mPesaTable").css("display","block");
			$("#name_block").css("display","block");
			$("#amt_block").css("display","block");
			
			$("#verfify_button").attr("disabled",true); 
			
			
				console.log(retrievedObject);
				console.log(retrievedObject[0].redPts);
				
				/* Set Values ***
				$("#point_redeem").val(retrievedObject[0].redPts);
				$("#Loyalty_discount").val(retrievedObject[0].LoyalDiscount);
				$("#redeem_voucher_amt").val(retrievedObject[0].redVoucher_amt);
				$("#redeem_amt").val(retrievedObject[0].redAmt);
				$("#BillAmount").val(retrievedObject[0].BillAmount);
				$("#Mpesa_TransID").val(retrievedObject[0].Mpesa_TransID);
				$("#VoucherDiscountAmt").val(retrievedObject[0].VoucherDiscountAmt);
				$("#Redeemed_discount_voucher").val(retrievedObject[0].Redeemed_discount_voucher);
				$("#redeem_by_voucher").val(retrievedObject[0].redeem_by_voucher);
				$("#redeem_voucher").val(retrievedObject[0].redeem_voucher);
				$("#discount_voucher_percentage").val(retrievedObject[0].discount_voucher_percentage);
				$("#discount_voucher_percentage_value").val(retrievedObject[0].discount_voucher_percentage_value);
				$("#Trans_id").val(retrievedObject[0].Trans_id);
				$("#name").text(retrievedObject[0].name);
				$("#BillAmount2").text(retrievedObject[0].BillAmount2);
				$("#total_bill_amount").val(retrievedObject[0].total_bill_amount);
				$(".select-styled").text(retrievedObject[0].SelectedVoucher);
			}
			
			
			
		});

		
		
	/* -----------getLocalStorage------08-07-2020--------------- */
  
  
  
	/* -----------setLocalStorage------08-07-2020--------------- */
	function setLocalStorage()
	{
		var redPts = $("#point_redeem").val();
		var LoyalDiscount = $("#Loyalty_discount").val();
		var redVoucher_amt = $("#redeem_voucher_amt").val();

		var gift_card_voucher = $("#gift_card_voucher").val();
		var giftCard_amt = $("#giftCard_amt").val();
		
		var redAmt = $("#redeem_amt").val();
		var BillAmount = $("#BillAmount").val();
		var Mpesa_TransID = $("#Mpesa_TransID").val();
		var VoucherDiscountAmt = $("#VoucherDiscountAmt").val();
		var Redeemed_discount_voucher = $("#Redeemed_discount_voucher").val();
		var redeem_by_voucher = $("#redeem_by_voucher").val();
		var redeem_voucher = $("#redeem_voucher").val();
		var discount_voucher_percentage = $("#discount_voucher_percentage").val();
		var discount_voucher_percentage_value = $("#discount_voucher_percentage_value").val();
		var Trans_id = $("#Trans_id").val();		
		var name = $("#name").text();
		var BillAmount2 = $("#BillAmount2").text();
		var total_bill_amount = $("#total_bill_amount").val();
		
		
		
		// var SelectedVoucher = $('ul .select-options').find('li.active').data('rel');
		var SelectedVoucher = $('.select-styled#discount').text();
		
		
		/*var SelectedVoucher = $("#Discount_vouchers option:selected").text();//$('#Discount_vouchers').val();
			SelectedVoucher = SelectedVoucher.trim();
			
		var SelectedGiftVoucher = $("#gift_card_id option:selected").text();//$('#Discount_vouchers').val();
			SelectedGiftVoucher = SelectedGiftVoucher.trim();*/
		// alert(SelectedVoucher);
		
		var SelectedGiftVoucher = $('.select-styled#gift').text();
		//alert(SelectedVoucher.trim());
   
		// var SelectedVoucher= $(this).attr('id', 'newId');
		
		//alert(redPts+"----"+LoyalDiscount+"--"+redVoucher_amt+"--"+redAmt);	
		
		// return false;
		// $("#verfify_button").html('<font color="green">Successfull..</font>');
		
		var LocalArr = new Array();	
		LocalArr.push({redPts: redPts, LoyalDiscount: LoyalDiscount, redVoucher_amt:redVoucher_amt, redAmt:redAmt, BillAmount:BillAmount, Mpesa_TransID:Mpesa_TransID, VoucherDiscountAmt:VoucherDiscountAmt, Redeemed_discount_voucher:Redeemed_discount_voucher, redeem_by_voucher:redeem_by_voucher, redeem_voucher:redeem_voucher, discount_voucher_percentage:discount_voucher_percentage, discount_voucher_percentage_value:discount_voucher_percentage_value, Trans_id:Trans_id, name:name, BillAmount2:BillAmount2,total_bill_amount:total_bill_amount,SelectedVoucher:SelectedVoucher,gift_card_voucher:gift_card_voucher,giftCard_amt:giftCard_amt,SelectedGiftVoucher:SelectedGiftVoucher});
		console.log(LocalArr);
		localStorage.setItem("LocalArtcaffeData", JSON.stringify(LocalArr));
	}
	/* -----------setLocalStorage------08-07-2020--------------- */
	
/************************Nilesh 09-07-2020*************************/
	function CreateToken()
	{
		var Final_Grand_total=$("#total_bill_amount").val();
		
		$("#CreateToken_button").html('<font color="green">Pay now</font>');
		$("#CreateToken_button").attr("disabled", true);
	
		$.ajax({
			type: "POST",
			data: {Final_Grand_total: Final_Grand_total},
			url: "<?php echo base_url()?>index.php/Shopping/CreateToken",
			success: function(data)
			{
				json = eval("(" + data + ")");
				// alert(json['Result'][0]);
				if((json['Result'][0]) == 000)
				{
					ApplyPaymentRule(3);
					
					$("#point_redeem").attr("readOnly","readOnly");
					$("#Discount_vouchers").attr("disabled", true);
					$("#Trans_id").attr("readOnly","readOnly");
					var loaderModal = $('#loader-modal');
					
					loaderModal.find('.modal-body').html('<div class="loadingSpinner"><div class="spinner-wave"><div></div><div></div><div></div><div></div><div></div></div><span class="text-center"><b>Loading DPO Page...</b></span></div>');
					loaderModal.modal('show');
					
					$("#PaymentMethodBy").val(1);					
					
					var TransToken = json['TransToken'][0];
					window.location.href = '<?php echo $Company_Details->Payment_url; ?>'+TransToken;
					
					
				}
				else 
				{
					
					$("#PaymentMethodBy").val(0);
					// if((json['Result']) == 0)
					$("#CreateToken_button").html('<font color="red">Failed..</font>');
					$("#CreateToken_button").attr("disabled", false);
					$("#CreateToken_button").html('Pay now</font>');
					// $("#CreateToken_button").html('<font color="red">Failed..</font>');
					var msg1 = 'Unable to Process, Try again Later';
					$('.help-block').show();
					$('.help-block').css("color","red");
					$('.help-block').html(msg1);
					setTimeout(function(){ $('.help-block').hide(); }, 6000);
					// $("#CreateToken_button").attr("disabled", false);
				}	
			}
		});
	}
	$( document ).ready(function() 
	{
		<!-------------ravi---------------->
		
			var retrievedObject = JSON.parse(localStorage.getItem('LocalArtcaffeData'));
			if(retrievedObject){
				
			
				console.log(retrievedObject);
				console.log(retrievedObject[0].redPts);
				
				
				$("#point_redeem").val(retrievedObject[0].redPts);
				$("#Loyalty_discount").val(retrievedObject[0].LoyalDiscount);
				$("#redeem_voucher_amt").val(retrievedObject[0].redVoucher_amt);
				$("#redeem_amt").val(retrievedObject[0].redAmt);
				$("#BillAmount").val(retrievedObject[0].BillAmount);
				$("#VoucherDiscountAmt").val(retrievedObject[0].VoucherDiscountAmt);
				$("#Redeemed_discount_voucher").val(retrievedObject[0].Redeemed_discount_voucher);
				$("#redeem_by_voucher").val(retrievedObject[0].redeem_by_voucher);
				$("#redeem_voucher").val(retrievedObject[0].redeem_voucher);
				$("#discount_voucher_percentage").val(retrievedObject[0].discount_voucher_percentage);
				$("#discount_voucher_percentage_value").val(retrievedObject[0].discount_voucher_percentage_value);
				
				
				$("#gift_card_voucher").val(retrievedObject[0].gift_card_voucher);
				$("#giftCard_amt").val(retrievedObject[0].giftCard_amt);
				
		
				$("#BillAmount2").text(retrievedObject[0].BillAmount2);
				$("#total_bill_amount").val(retrievedObject[0].total_bill_amount);
				$(".select-styled#discount").text(retrievedObject[0].SelectedVoucher);
				//$("#Discount_vouchers").text(retrievedObject[0].SelectedVoucher);
				$(".select-styled#gift").text(retrievedObject[0].SelectedGiftVoucher);
				
				if(retrievedObject[0].Mpesa_TransID !=0)
				{
					$("#mPesaTable").css("display","block");
					$("#name_block").css("display","block");
					$("#amt_block").css("display","block");
					$("#verfify_button").attr("disabled",true); 
					$("#verfify_button").html('<font color="green">Successfull..</font>');
					$("#Mpesa_TransID").val(retrievedObject[0].Mpesa_TransID);
					$("#Trans_id").val(retrievedObject[0].Trans_id);
					$("#name").text(retrievedObject[0].name);
				}
			} 

		<!-------------ravi---------------->
		
	/**************Nilesh*****************/
		var TransactionToken = '<?php echo $RedirectTransactionToken; ?>';
		var CCDapproval = '<?php echo $RedirectCCDapproval; ?>';
		var DPOCreditAmt = '<?php echo $DPOCreditAmt; ?>';
		if(TransactionToken != "" && CCDapproval !="")
		{
			$("#total_bill_amount").val(0);
			$("#RedirectTransactionToken").val(TransactionToken);
			$("#RedirectCCDapproval").val(CCDapproval);
			$("#DPOCreditAmt").val(DPOCreditAmt);
			$("#Discount_vouchers").attr("disabled", true);
			$("#point_redeem").attr("readOnly","readOnly");
			$("#cal_redeem_amt_verify").css("display","none");
			$("#Trans_id").attr("readOnly","readOnly");
			$("#verfify_button").css("display","none");
			$("#CreateToken_button").css("display","none"); 
		}
	/**************Nilesh*****************/
	});
/**********************Nilesh 09-07-2020***********************/
  </script>
  <style>
  .select-options li{
	word-break: break-word !IMPORTANT;
    width: 227px !IMPORTANT;
    margin-left: 10px !IMPORTANT;
	text-indent: 0px !IMPORTANT;
  }
  .select-styled{
	  border-bottom:none !IMPORTANT;
  }
  .select{
	  height: 50px !IMPORTANT;
  }
  </style>
  
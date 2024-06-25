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
		<?php echo form_open_multipart('Shopping/CheckoutPayment',array('onsubmit'=>'return Validate_form();')); ?>
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
			<div class="accordion" id="accordion">
				<!-- Accordion item 1 -->
				<div class="item">
					<div class="accordion-header">
						<button type="button" class="btn" data-toggle="collapse" data-target="#collapse1" aria-expanded="false">
							Redeem Voucher
						</button>
					</div>
					<div id="collapse1" class="collapse" data-parent="#accordion">
						<div class="card-body">
							<select class="form-control" name="Discount_vouchers" id="Discount_vouchers">
								<option value="0_0">SELECT</option>
								<?php 
									if($DiscountVouchers){
										
										foreach($DiscountVouchers as $v){
										?>
											<option value="<?php echo $v['Gift_card_id']."_".$v['Card_balance']; ?>">										
											<?php echo $v['Gift_card_id']; ?>: <?php echo $Symbol_of_currency; ?> <?php echo number_format($v['Card_balance'],2); ?>
											</option>
										<?php }
									} 
								?>
							</select>
							<div id="Gift_card_msg"></div>
						</div>
					</div>
				</div>
				<!-- Accordion item 2 -->
				<div class="item">
					<div class="accordion-header">
						<button type="button" class="btn" data-toggle="collapse" data-target="#collapse2" aria-expanded="false">
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
						<button type="button" class="btn" data-toggle="collapse" data-target="#collapse3" aria-expanded="false">
							MPESA Transaction
						</button>
					</div>
					<div id="collapse3" class="collapse" data-parent="#accordion">
						<div class="card-body">
							<div class="point-field">
								<input type="text" name="Trans_id" id="Trans_id" class="form-control"/>
								<button type="button" onclick="Call_API();" id="verfify_button" >VERIFY</button>
							</div>
									<div style="color:red;font-size:12px;" id="Trans_id_error"></div>
									<div style="color:red;font-size:12px;" id="Verify_mpesa_error"></div>
								<table id="mPesaTable" class="table" align="center" style="width:100%;display:none">		
										<tr id="name_block" style="display:none;">
											<th><strong id="Medium_font">Name:</strong></th>
											<td id="name"></td>
										</tr>
										<tr id="amt_block" style="display:none;">
											<th><strong id="Medium_font">Transaction Amount:</strong></th>
											<td id="BillAmount2"></td>
										</tr>
										<tr>
										<th colspan="2" id="compa_block"></th>
											
										</tr>
										<tr  id="reenter_block" style="display:none;">
									
										<td colspan="2" align="center">
											<button type="button"  class="btn btn-light" onclick="javascript:re_enter();" >
												Re-Enter
											</button>		
										</td>
										</tr>
								</table>
								
								<div class="lipa-wrap">
									<div class="lipa-img">
										<img src="<?php echo base_url(); ?>assets/img/lipa.png" alt=""/>
									</div>
									<div class="buy-good">
										<p>Buy goods</p>
										<h3><?php echo $delivery_outlet_details->goods_till_number; ?></h3>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="checkout-total">
			
			
				<?php if($DiscountAmt > 0) {  ?>
					<p id="Loyalty_discount_div">Loyalty discount <?php echo round($DiscountPercentageValue); ?>
							<?php if($DiscountRuleSet==1 ){
									echo"%";
								} else if($DiscountRuleSet==2 ) {
								 echo $Symbol_of_currency;
								}
							 ?>
							<span class="float-right"><?php echo $Symbol_of_currency; ?> 
							<input type="text" id="Loyalty_discount" name="Loyalty_discount"  
								 placeholder="Loyalty discount" class="txt" value="<?php echo number_format($DiscountAmt,2); ?>" readonly></span>
						</p>
					
				<?php } ?>	
			
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
			<?php if($Outlet_status_flag==1) {?>
			<div class="checkout-btn-wrap">
				<p style="color:red;text-align:center;display:none" id="total_bill_amount_error"></p>
				<input type="submit" id="Payment" class="cust-btn btn-block btn-green" value="CHECK OUT" />
				<input type="hidden" name="BillAmount" id="BillAmount" value="0">
				<input type="hidden" name="Mpesa_TransID" id="Mpesa_TransID" value="0">
				<input type="hidden" name="VoucherDiscountAmt" id="VoucherDiscountAmt" value="0">
				<input type="hidden" name="Redeemed_discount_voucher" id="Redeemed_discount_voucher" value="0">
				<input type="hidden" name="redeem_by_voucher" id="redeem_by_voucher" value="1">
				<input type="hidden" name="redeem_voucher" id="redeem_voucher" value="0">
			</div>
			<?php } else { ?>
				<div class="checkout-btn-wrap">
					<p style="text-align:center;">Outlet not available... Please try again later!</p>					
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
		
		<div class="container" >
			<div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
			  <div class="modal-dialog modal-sm" style="margin-top: 65%;">
				<!-- Modal content-->
				<div class="modal-content" id="loader_model">
				   <div class="modal-body" style="padding: 10px 0px;;">
					 <img src="<?php echo base_url(); ?>assets/img/loading.gif" alt="" class="img-rounded img-responsive" width="80">
				   </div>       
				</div>    
				<!-- Modal content-->
			  </div>
			</div>       
		</div>
		
		
		<style>
		.point-field input.form-control{
			background: white !IMPORTANT;
			color: #7E746B !IMPORTANT;
		}
		.txt{
			width: 100px;
			border: none;
			background: transparent;
			color: #fff;
			text-align: right;
		}
		</style>
   <script type="text/javascript">
   
	
	function Call_loader()
	{
		setTimeout(function() 
		{
			$('#myModal').modal('show'); 
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide'); 
		},200000000000);
		
		// window.location.reload();
	}
   
   
   
	
	$('select').each(function(){

      var $this = $(this), numberOfOptions = $(this).children('option').length;
    
      $this.addClass('select-hidden'); 
      $this.wrap('<div class="select"></div>');
      $this.after('<div class="select-styled"></div>');
  
      var $styledSelect = $this.next('div.select-styled');
      $styledSelect.text($this.children('option').eq(0).text());
    
      var $list = $('<ul />', {
          'class': 'select-options'
      }).insertAfter($styledSelect);
    
      for (var i = 0; i < numberOfOptions; i++) {
          $('<li />', {
              text: $this.children('option').eq(i).text(),
              rel: $this.children('option').eq(i).val()
          }).appendTo($list);
      }
    
      var $listItems = $list.children('li');
    
      $styledSelect.click(function(e) {
		   // alert('Click on SELECT');
		var total_bill_amount = $("#total_bill_amount").val();
		
		if(total_bill_amount != 0) { 
				
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
          $list.hide();
		  
		  console.log($this.val());
		  
		 
		  
			/* --------setVoucher---------29-05-2020--------------- */
					if($this.val() != '0_0'){
						setVoucher($this.val());
					} else {
						setVoucher('0_0');
					}
				
				/* --------setVoucher---------29-05-2020--------------- */
			
		  
		  
      });
    
      $(document).click(function() {
          $styledSelect.removeClass('active');
          $list.hide();
      });
  
  }); 
  
  
  
	/* -----------------29-05-2020--------------- 
		$(function () 
		{	
			// show_voucher_div(1);
			
			var Cart_redeem_point = '<?php echo $Cart_redeem_point; ?>';
			var ratio_value2 = '<?php echo $Redemptionratio;?>';
			var grand_total2 = '<?php echo $_SESSION['Grand_total']; ?>';
			// var Redeem_amount = '<?php echo $_SESSION['Redeem_amount']; ?>';
			var Redeem_amount =0;
			// var redeem_by_voucher = '<?php echo $_SESSION['redeem_by_voucher']; ?>';
			if(Cart_redeem_point != 0)
			{
				$("#point_redeem").val(Cart_redeem_point);
				// console.log("-----Redeem_amount----"+Redeem_amount);
				var EquiRedeem2 = parseFloat(Redeem_amount).toFixed(2);
				var EquiRedeem3 = CommaFormatted(parseFloat(Redeem_amount).toFixed(2)); 
				$("#redeem_amt").val(EquiRedeem3);
				var Total_bill2 = (grand_total2 - EquiRedeem2).toFixed(2);
				if(Total_bill2 < 0)
				{
					//$("#redeem_by").show();
					document.getElementById("inlineRadio3").checked = true;
					show_redeem_div(2,0);					
					$("#redeem_amt").val(0);
					Total_bill2 = grand_total2;					
				}
				// $("#total_bill_amount").val(Total_bill2);
				var Total_bill4 = CommaFormatted(parseFloat(Total_bill2).toFixed(2));
				$('#total_bill_amount').val(Total_bill4);
			}
			else
			{
				$('#total_bill_amount').val(CommaFormatted(parseFloat(grand_total2).toFixed(2)));
			}
		});
	/* -----------------29-05-2020--------------- */
  
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
	
	
	/* -----------setVoucher------29-05-2020--------------- */
		/* function setVoucher(Gift_card_id,Card_balance) */
		function setVoucher(Gift_card)
		{
			
			var fields = Gift_card.split("_");
		
			var Gift_card_id = fields[0];
			var Card_balance = fields[1];
			
			console.log(Gift_card_id+"---"+Card_balance);
			
		//	alert(Gift_card_id+"---"+Card_balance)
			var purchase_amt = '<?php echo $_SESSION['Grand_total']; ?>';
			var redeem_amt1 = $("#redeem_amt").val();
			
			console.log("--Card_balance---"+Card_balance);
			console.log("--purchase_amt---"+purchase_amt);
			console.log("--redeem_amt---"+redeem_amt1);
			
			
			var redeem_amt;
			redeem_amt = redeem_amt1.split(',').join('');
			
			console.log("--redeem_amt---"+redeem_amt);
			
			/* parseFloat */
			var TotalGrand = parseInt(Card_balance) + parseInt(redeem_amt);
			
			console.log("--TotalGrand---"+TotalGrand);
			
			
			if(TotalGrand > purchase_amt)
			{
				$("#redeem_voucher").removeAttr("required");
				$("#voucher_label").hide();
				$(".voucher_label2").hide();
				$("#point_redeem").removeAttr("readonly");
				$("#redeem_voucher").val(0);
				$("#redeem_voucher_amt").val(0);
				// $("#Payment").attr("disabled", false);
				
				
				
				
					
				
					var msg = 'Total purchase amount is less than voucher value, please try other voucher';
						  $('#Gift_card_msg').show();
						  $('#Gift_card_msg').css("color", "red");
						  $('#Gift_card_msg').html(msg);
						  setTimeout(function() {
								$('#Gift_card_msg').hide();
						  }, 3000);
						  
				return false;
			}
				// alert(parseInt(purchase_amt)+"--"+redeem_amt+"--"+ parseInt(TotalGrand));
			var new_purchase_amt = parseInt(purchase_amt) - parseInt(TotalGrand);
			
			if(new_purchase_amt < 0){
				new_purchase_amt = 0;
			}
			
			var new_purchase_amt2 = CommaFormatted(parseFloat(new_purchase_amt).toFixed(2));
			
			
				console.log("---new_purchase_amt2-----"+new_purchase_amt2);
									  
				
			  
			
			
			  $("#ContinuetoCart").attr("disabled", false);
				if(new_purchase_amt2 <= 0 ){
					
					$("#point_redeem").attr("readonly",true);
					$("#ContinuetoCart").attr("disabled", false);
					
				} else {
					$("#point_redeem").attr("readonly",false);
					$("#ContinuetoCart").attr("disabled", true);
					
				}
			
			/* parseFloat(Redeem_amount).toFixed(2) */
			$("#redeem_voucher").val(Gift_card_id);
			// $("#redeem_voucher_amt").val(Card_balance.toFixed(2));
			// $("#redeem_voucher_amt").val(parseInt(Card_balance).toFixed(2));
			$("#redeem_voucher_amt").val(CommaFormatted(parseFloat(Card_balance).toFixed(2)));
			// $("#redeem_voucher_amt").val(Card_balance);
			$("#Redeemed_discount_voucher").val(Gift_card_id);
			$("#VoucherDiscountAmt").val(parseInt(Card_balance).toFixed(2));
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
            var grand_total = '<?php echo $_SESSION['Grand_total']; ?>';
           
		   
		   var redeem_voucher_amt;
			redeem_voucher_amt = redeem_voucher_amt1.split(',').join('');
			
			console.log("--redeem_voucher_amt---"+redeem_voucher_amt);
		   
			var Tot_purAmt=0
			
			Tot_purAmt=(<?php echo $_SESSION['Grand_total']; ?>-redeem_voucher_amt);
			
			
			console.log("----Tot_purAmt------"+Tot_purAmt);
		   
			/* alert('bal'+bal);
            alert('purchase_amt'+purchase_amt);
            alert('ratio_value'+ratio_value);
            alert('grand_total'+grand_total);
            alert('reedem'+reedem); */

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
			
			console.log("----redeem_voucher_amt------"+redeem_voucher_amt);
			
			
			// grand_total=grand_total+redeem_voucher_amt;
			
			console.log("----grand_total------"+redeem_voucher_amt);
			
            $.ajax({

                  type: "POST",
                  data: {

                        Current_balance: bal,
                        grand_total: grand_total,
                        redeem_voucher_amt: redeem_voucher_amt,
                        Redeem_points: reedem,
                        ratio_value: ratio_value,
                        redeemBY: redeemBY
                  },
                  url: "<?php echo base_url()?>index.php/Express_checkout/cal_redeem_amt_contrl/",
                  datatype: "json",
                  success: function(data) {
                       // alert("---Error_flag-----"+data.Error_flag);
                        if (data.Error_flag == 0) {
							
							
							var redAmt = CommaFormatted(parseFloat(data.EquiRedeem).toFixed(2));
							var BillAmt = CommaFormatted(parseFloat(data.Grand_total).toFixed(2));
                              $('#redeem_amt').val(redAmt);
                             // $('#redeem_amt').val(data.EquiRedeem.toFixed(2));
                              //$('#total_bill_amount').val(data.Grand_total.toFixed(2));
							  
							   // console.log("---Error_flag-----"+BillAmt);
							  
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
                  }
            });
      }
	/* -----------Cart_redeem_amt------29-05-2020--------------- */
	
	
	/* -----------Call_API------29-05-2020--------------- */
	
	// alert('<?php echo $delivery_outlet_details->goods_till_number; ?>');
		function Call_API()
		{
			
			var goods_till_number= '<?php echo $delivery_outlet_details->goods_till_number; ?>';
			// var Final_Grand_total= "<?php echo $_SESSION['Grand_total']; ?>"; 
			// var Final_Grand_total= "<?php echo $_SESSION['Final_Grand_total']; ?>"; 
			// var Final_Grand_total= "<?php echo $total_bill_amount; ?>";
			var Final_Grand_total=$("#total_bill_amount").val();
			
			var Seller_api_url2= "<?php echo $delivery_outlet_details->Seller_api_url2; ?>ValidateB2BPayment";
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
				$("#Trans_id_error").html('Please Enter M-PESA Transaction ID');
				return false;
			}
			$("#verfify_button").html('<font color="green">Verifying</font>');
			$("#verfify_button").attr("disabled", true);
			$.ajax({
				type: "POST",
				data: {Final_Grand_total: Final_Grand_total, goods_till_number:goods_till_number,Trans_id:Trans_id,Seller_api_url2:Seller_api_url2},
				url: "<?php echo base_url()?>index.php/Shopping/Verify_mpesa",
				success: function(data)
				{
					console.log(data.response);			
					// console.log(data.BalanceDue);			
					
					var response2 = JSON.parse(data.response);
					//response2.MpesaPaidAmount = 1190;
					$("#BillAmount").val(response2.MpesaPaidAmount); 
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
					
					
					
					console.log(response2.BalanceDue);	
					
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
						$("#reenter_block").hide();
						$("#verfify_button").html('<font color="green">Successfull..</font>');						
						$("#point_redeem").attr("readOnly","readOnly");
						// $("#ContinuetoCart").attr("disabled", true);
						$("#Discount_vouchers").attr("disabled", true);
						$("#cal_redeem_amt_verify").css("display","none");
						$("#total_bill_amount").val(0);
						
					}
					 
					/*  alert('Final_Grand_total '+parseFloat(Final_Grand_total));
					 alert('MpesaPaidAmount '+parseFloat(MpesaPaidAmount)); */
					 
					var MpesaPaidAmount = response2.MpesaPaidAmount;		
					
					
					
					 /* console.log(parseFloat(MpesaPaidAmount));
					 console.log(parseFloat(Final_Grand_total)); */			
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
			var total_bill_amount = $("#total_bill_amount").val();				
			if(parseFloat(total_bill_amount) > 0 ){
				
				var msg = 'Please pay Balance Due!!';
                              $('#total_bill_amount_error').show();
                              $('#total_bill_amount_error').css("color", "red");
                              $('#total_bill_amount_error').html(msg);
								setTimeout(function() {
                                    $('#total_bill_amount_error').hide();
                              }, 3000);
                             
				return false;				
			}
			
			
			setTimeout(function() 
			{
				$('#myModal').modal('show'); 
			}, 0);
			setTimeout(function() 
			{ 
				$('#myModal').modal('hide'); 
			},20000000000);
			
			
			return true;
			
			
			
		}
	/* -----------Form Validation------03-06-2020--------------- */
  
  
  </script>
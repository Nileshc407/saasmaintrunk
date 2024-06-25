<!DOCTYPE html>
<html lang="en">

<head>
      <title><?php echo $title?></title>
      <?php $this->load->view('front/header/header'); 
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?>
</head>

<body>
      <?php 
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
		/* window.location.href='<?php echo base_url(); ?>index.php/Shopping/select_outlet?delivery_type='+delivery_type; */

      // echo"---delivery_outlet---".$delivery_outlet."---<br>";
	  $delivery_type=$_SESSION['delivery_type'];
      ?>

	

	<form method="post" onsubmit="return redeem_check();"
            action="<?php echo base_url()?>index.php/Shopping/checkout2">
		<div id="application_theme" class="section pricing-section" style="min-height:500px;">
			<div class="container">
				<div class="section-header">
					<p><a href="<?php echo base_url(); ?>index.php/Shopping/select_outlet?delivery_type=<?php echo $_SESSION['delivery_type']; ?>&delivery_outlet=<?php echo $_SESSION['delivery_outlet']; ?>"
                                          style="color:#ffffff;"><img
                                                src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png"
                                                id="arrow"></a></p>
					<p id="Extra_large_font">Cart Details</p>
				</div>

				<div class="row pricing-tables">

					<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;"><!-- Main Card -->
						<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
						<?php if(!empty($cart_check)) { ?>	<!-- 1 card -->

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
							
							
							/* 
							?>


                                          <div class="pricing-details">
                                                <div class="row">
                                                      <div class="col-md-12">
                                                            <div class="row ">
                                                                  <div class="col-xs-4"
                                                                        style="padding: 2px 8px 0px 10px">
                                                                        <img src="<?php echo $Product_details->Thumbnail_image1; ?>"
                                                                              alt="<?php echo $Product_details->Merchandize_item_name; ?>"
                                                                              class="img-rounded img-responsive"
                                                                              width="70" height="70">
                                                                  </div>
                                                                  <div class="col-xs-8 text-left" style="width: 65%;">
                                                                        <address>
																			<?php
																				// echo"<br>---Combo_meal_flag----".$Product_details->Combo_meal_flag;				
																				if($Product_details->Combo_meal_flag ==1 ) {
																					
																					$MerchandizeIteName = explode('+', $Product_details->Merchandize_item_name);
																					$itemName= $MerchandizeIteName[0];
																				} else {
																					
																					$itemName= $Product_details->Merchandize_item_name;
																				}
																			?>
                                                                              <strong
                                                                                    id="Medium_font"><?php echo $itemName; 
																					
																					if($item["Main_item"] != NULL)
																					{
																						foreach($item["Main_item"] as $b3){

																							if($b3["Merchandize_item_name"] != NULL)
																							{
																								echo "+".$b3["Merchandize_item_name"];
																							}
																						}
																					}?></strong><br>
                                                                        </address>
                                                                        <address>
                                                                              <strong id="Medium_font">
                                                                                    <?php echo $item["options"]["remark2"];?>
                                                                              </strong><br>
                                                                        </address>

                                                                       <address> 
																			<strong id="Medium_font">Unit Price </strong>
																			<strong id="Value_font" style="float: right;" >
																			*/ ?>
																			<?php
																				$grand_total = $grand_total + $item['subtotal'];
																				// echo $Symbol_of_currency.' '.number_format( $item['price'], 2);
																				?>
																				
																			<?php /*	</strong><br>
																		</address>
																		<address> 
																			<strong id="Medium_font">Condiments Price </strong>
																			<strong id="Value_font" style="float: right;" ><?php
																				 echo $Symbol_of_currency.' '.number_format( ($item['MainItem_TotalPrice'] + $item['SideCondiments_TotalPrice']) * $item['qty'], 2);
																				?>
																			</strong><br>
																		</address>
																		<address> 
																			<strong id="Medium_font">Sub Total</strong>
																			<strong id="Value_font" style="float: right;" ><?php
																				// $grand_total = $grand_total + $item['subtotal'];
																			 echo $Symbol_of_currency.' '. number_format((float)$item['subtotal'], 2);
																				?>
																			</strong><br>
																		</address>
                                                                        <address>
                                                                              <?php /* ?><a
                                                                                    href="<?php echo base_url()?>index.php/Shopping/remove/?rowid=<?php echo $item['rowid']; ?>">
                                                                                    <strong id="Medium_font">Remove
                                                                                    </strong> <img
                                                                                          src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/remove.png"
                                                                                          alt=""
                                                                                          class="img-rounded img-responsive"
                                                                                          width="20">
                                                                              </a><?php ******** ?>

                                                                              <a href="#"
                                                                                    onclick="delete_item('<?php echo $item['rowid']; ?>','<?php echo $Product_details->Merchandize_item_name; ?>')">
                                                                                    <strong id="Medium_font">Remove
                                                                                    </strong> <img
                                                                                          src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/remove.png"
                                                                                          alt=""
                                                                                          class="img-rounded img-responsive"
                                                                                          width="20">
                                                                              </a>
                                                                              <?php
													echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
													echo form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']);
													echo form_hidden('cart[' . $item['id'] . '][name]', $Product_details->Merchandize_item_name);
													echo form_hidden('cart[' . $item['id'] . '][price]', $Product_details->Billing_price);
												?>
                                                                              &nbsp;&nbsp;&nbsp;&nbsp;<strong
                                                                                    id="Medium_font">Quantity: </strong>
                                                                              <strong
                                                                                    id="Value_font"><?php echo $item['qty']; ?>
                                                                              </strong>
                                                                        </address>
											</div>
                                                            </div>
                                                      </div>
                                                </div>
                                          </div> <hr />
                                          <?php  */
										  
										 } ?>
										  
										  
												<div class="pricing-details relative">
												
													<div class="row">
																		
														<div class="col-xs-12" align="center" style="width:100%;">
																<div style="overflow-x:auto;">
																	<table style="table-layout: fixed ;width: 100% ;">
																															
																	</table>
																</div>
														</div>
												
													</div>
												
													<div class="row">
														<div class="col-xs-4 main-xs-6 text-left" style="width:50%">
															<strong id="Medium_font">Cart Total</strong>
														</div>
														
														<div class="col-xs-4 main-xs-6 text-right" style="width:40%">
															 <span id="Value_font">&nbsp;<?php echo $Symbol_of_currency; ?>&nbsp;<?php echo  number_format($grand_total+$_SESSION['Total_Shipping_Cost'],2); ?></span>
														</div>
													</div>
													
													
												</div>
									<hr>
										  
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
						$_SESSION['Grand_total']=($grand_total+$_SESSION['Total_Shipping_Cost']) - $DiscountAmt;
						
						
 
					?>
					<!-- 4 card -->
					<div class="pricing-details">
						<div class="row">
							<div class="col-md-12" style="width:100%;padding: 0 !IMPORTANT;margin: 0 !IMPORTANT;">
								<div class="col-xs-12" align="center" style="width:100%;padding: 0 !IMPORTANT;margin: 0 !IMPORTANT;">
									<div style="overflow-x:auto;">
										<table style="table-layout: fixed ;width: 100% ;">
											<!--<tr>
												<td colspan="2" align="center">
													<hr /><span id="Extra_large_font">Details</span><hr />
												</td>
											</tr> -->
											<!--<tr>
												<td><strong
														id="Medium_font">Sub-Total</strong>
												</td>
												<td><span
														id="Value_font">:&nbsp;<?php //echo $Symbol_of_currency; ?>&nbsp;<?php ///echo $_SESSION['Sub_total']; ?></span>
												</td>
											</tr>-->
											<?php
												// var_dump($_SESSION['delivery_type']);
											/* if($_SESSION['delivery_type']==29){ ?>
											<tr>
												<td><strong id="Medium_font">Delivery
														Cost</strong></td>
												<td><span
														id="Value_font">:&nbsp;<?php echo $Symbol_of_currency; ?>&nbsp;<?php echo number_format($_SESSION['Total_Shipping_Cost'],2); ?></span>
												</td>
											</tr>
										<?php } */ ?>
										<?php /* if($DiscountAmt > 0) {  ?>
										<tr>
											
											<th><strong id="Medium_font">Loyalty Discount</strong></th>
											<td><span
														id="Value_font">:<?php echo $Symbol_of_currency; ?>&nbsp;<?php echo number_format($DiscountAmt,2); ?></span></td>
											<td>&nbsp;</td>
										</tr>
									<?php } */ ?>
											<!--<tr>
												<td><strong id="Medium_font">Total
														Cost</strong></td>
												<td>
												
												<span id="Value_font">:&nbsp;<?php //echo $Symbol_of_currency; ?>&nbsp;<?php
											
													//echo number_format($_SESSION['Grand_total'],2); ?>
											
													<?php /* ?>	
													( ~ <?php
													// echo"-Redemptionratio--".$Redemptionratio."--<br>";
													// echo"-Grand_total--".number_format($_SESSION['Grand_total'],2) ."--<br>";
													$Grand_total=ceil($_SESSION['Grand_total'] * $Redemptionratio);
													// echo"-Grand_total--".$Grand_total."--<br>";
											
													echo floor($Grand_total).' '.$Company_Details->Currency_name; ?> ) 
													<?php */ ?>
											
												</span>
											
											</td>
											</tr> 
											
											id="voucher_label" style="display:none"
											-->
											
											<tr > 												
												<td>
													<strong id="Medium_font"> Redeem Vouchers</strong>
												</td>
												<td>
												
													<strong id="Medium_font" style="float: right;"> 
													
														<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="JavaScript:getDiscountVouchers()" data-toggle="tooltip" data-placement="top" style="width:50px;float: right;">Select</button>
													<input type="hidden" class="txt" id="redeem_voucher" name="redeem_voucher" size="10"  onblur="get_voucher_amt(this.value);" placeholder="Enter Voucher">
														<!------<a href="#" onclick="JavaScript:getDiscountVouchers()" data-toggle="tooltip" data-placement="top" title="view my vouchers"  id="button1" class="b-items__item__add-to-cart" style="padding: 8px;">Select </a>---->
													</strong>
													
														
														<!--<span id="Small_font">&nbsp;
															<input type="text" class="txt" id="redeem_voucher" name="redeem_voucher" size="10"  onblur="get_voucher_amt(this.value);" placeholder="Enter Voucher">														
														</span>-->
														
												</td>
											</tr>
											
											<?php if($Company_Details->Loyalty_enabled==1) { ?>
												<!--<tr>
												
													<td><strong id="Medium_font">Wish to
															Redeem ?</strong></td>
															
													<td>:&nbsp;<span id="Small_font">
															<input type="radio"
																name="redeem_by"
																id="inlineRadio2"
																value="1"
																onclick="show_redeem_div(this.value,'1');"
																<?php if($Cart_redeem_point != 0){ ?> checked <?php } ?>>Yes
															&nbsp;&nbsp;
															<input type="radio"
																<?php if($Cart_redeem_point == 0){ ?> checked <?php } ?>
																name="redeem_by"
																id="inlineRadio3"
																value="2"
																onclick="show_redeem_div(this.value,'0');cal_redeem_amt(this.value);">No
													</td>
												</tr>-->
												<!----id="Points_redeem_div_1" style="display:none;"--->
												<tr>

													<td><strong id="Medium_font">Redeem
															<?php echo $Company_Details->Currency_name; ?></strong><br>
														(<strong id="Small_font">Current </strong>
														
														<span id="Value_font">&nbsp;<?php echo $Current_point_balance1.' '.$Company_Details->Currency_name; ?></span>)
													</td>
													<td>:<span id="Value_font">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
																type="text"
																id="point_redeem"
																class="txt"
																name="point_redeem"
																size="6"
																onblur="cal_redeem_amt(1);"
																onkeyup="this.value=this.value.replace(/\D/g,'')"
																placeholder="Enter <?php echo $Company_Details->Currency_name; ?>" style="width: 66px;"></span>
																
																<button type="button" id="button1" class="b-items__item__add-to-cart" onclick="cal_redeem_amt(1);" style="width:50px;float: right;">Verify</button>
													</td>
												</tr>
												
												
												<!--<tr id="Points_redeem_div_2"
													style="display:none;">

													<td><strong id="Medium_font">Current
															Balance</strong></td>
													<td>:<span
															id="Value_font">&nbsp;<?php echo $Current_point_balance1.' '.$Company_Details->Currency_name; ?></span>
													</td>
												</tr>-->
												<!--<tr id="Points_redeem_div_3" style="display:none;">

													<td><strong id="Medium_font">Points Redeemed
															Amt</strong></td>
													<td>:<span id="Value_font"><?php echo $Symbol_of_currency; ?>&nbsp;<input
																type='text'
																name='redeem_amt'
																class="txt"
																id='redeem_amt'
																value="0" size='6'
																readOnly> </span>
													</td>
												</tr> -->
												
											<?php } ?>
												
											<!--<tr> 												
												<td>
													<strong id="Medium_font">Use Voucher ?</strong>
												</td>
												<td>:&nbsp;<span id="Small_font">
														<input type="radio"
															name="redeem_by_voucher"
															id="inlineRadio4"
															value="1" onclick="show_voucher_div(this.value);" >Yes
														&nbsp;&nbsp;
														<input type="radio"
															<?php if($Cart_redeem_point == 0){ ?> checked <?php } ?>
															name="redeem_by_voucher"
															id="inlineRadio5"
															value="2" onclick="show_voucher_div(this.value);">No
															</span>
												</td>
												
												
											</tr> 
											
											<tr> 												
												<td colspan="2">
													<div id="redeem_voucher_div"></div>
												</td>
											</tr>
											<!--<tr id="voucher_label2" style="display:none"> 												
												<td>
													<strong id="Medium_font">Voucher Applied</strong>
												</td>
												<td>:&nbsp;
														<strong id="Value_font"><?php echo $Symbol_of_currency; ?></strong>
														<input type="text" id="redeem_voucher_amt" class="txt" name="redeem_voucher_amt"  
														 placeholder="Balance" readonly> 
												</td>
											</tr>-->
											
												<!--<tr id="Points_redeem_div_4" style="display:none;">

													<td><strong id="Medium_font">Total
															Due Amount</strong></td>
													<td>:<span id="Value_font"><?php echo $Symbol_of_currency; ?>&nbsp;<input
																type='text'
																id='total_bill_amount'
																class="txt"
																name='total_bill_amount'
																size='6'
																readOnly></span>
													</td>
												</tr> -->
										</table>
										<div id="point_redeem_div" style="float:right;"> </div>
									</div>
								</div>

							</div>
						</div>
					</div>
					
                                          <?php /* ?>
                                          <div class="pricing-details">
                                                <div class="row">
                                                      <div class="col-md-12 text-right">
                                                            <strong id="Medium_font" style="    margin-right: 3%;">Wish
                                                                  to Redeem&nbsp;&nbsp;:
                                                                  <span id="Small_font">
                                                                        <input type="radio" name="redeem_by"
                                                                              id="inlineRadio2" value="1"
                                                                              onclick="show_redeem_div(this.value,'1');"
                                                                              <?php if($Cart_redeem_point != 0){ echo 'checked="checked"';} ?>>Yes
                                                                        &nbsp;&nbsp;
                                                                        <input type="radio"
                                                                              <?php if($Cart_redeem_point == 0){ echo 'checked="checked"';} ?>
                                                                              name="redeem_by" id="inlineRadio3" checked
                                                                              value="0"
                                                                              onclick="show_redeem_div(this.value,'0');cal_redeem_amt(this.value);">No
                                                                  </span>
                                                            </strong><br>

                                                            <div class="col-xs-12 text-right" id="Points_redeem_div"
                                                                  style="display:none;">

                                                                  <span align="left" style="line-height: 27px;">
                                                                        <strong id="Medium_font">Redeem
                                                                              Points</strong><br>
                                                                        <strong id="Medium_font">Current
                                                                              Point</strong><br>
                                                                        <strong id="Medium_font">Equivalent
                                                                              Point</strong><br>
                                                                        <strong id="Medium_font">Total</strong>
                                                                  </span>

                                                                  <span align="left" id="Points_redeem_details">
                                                                        <span id="Value_font">:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input
                                                                                    type="text" id="point_redeem"
                                                                                    class="txt" name="point_redeem"
                                                                                    size="6" onblur="cal_redeem_amt(1);"
                                                                                    onkeyup="this.value=this.value.replace(/\D/g,'')"></span><br>

                                                                        <span
                                                                              id="Value_font">:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $Cust_current_bal - $Cust_Blocked_points; ?></span><br>

                                                                        <span id="Value_font">:&nbsp;<?php echo $Symbol_of_currency; ?>&nbsp;<input
                                                                                    type='text' name='redeem_amt'
                                                                                    class="txt" id='redeem_amt'
                                                                                    value="0" size='6' readOnly>
                                                                        </span><br>

                                                                        <span id="Value_font">:&nbsp;<?php echo $Symbol_of_currency; ?>&nbsp;<input
                                                                                    type='text' id='total_bill_amount'
                                                                                    class="txt" name='total_bill_amount'
                                                                                    size='6' readOnly> </span>
                                                                  </span>

                                                            </div>
                                                            <div id="point_redeem_div" style="float:right;"></div>


                                                      </div>
                                                </div>
                                          </div>
                                          <hr>
                                          <?php */ ?>

                                          <!-- Cart Details -->
										  
										  
										  
										  
											<br>
											<br>
											<br>
										  
										  

											<div class="row pricing-tables" style="text-align: left;padding: 10px;">
												<?php if($DiscountAmt > 0) {  ?>
													<div class="row" style="width:100%">
														<div class="col-xs-6" style="width:70%">
															<strong id="Medium_font">Loyalty Discount </strong> <span id="Medium_font">(<?php echo round($DiscountPercentageValue); ?>
															<?php if($DiscountRuleSet==1 ){
																	echo"%";
																} else if($DiscountRuleSet==2 ) {
																 echo $Symbol_of_currency;
																}
															 ?>
															)</span> 
														</div>
														<div class="col-xs-6 text-right" style="width:19%">
															
															<span id="Value_font"><?php echo $Symbol_of_currency; ?>&nbsp;<?php echo number_format($DiscountAmt,2); ?></span>
															
														</div>
													</div>
												<?php } ?>
												
												
														
												
													<div class="row" id="voucher_label2" style="width:100%;display:none" >
														<div class="col-xs-6" style="width:70%">
															<strong id="Medium_font">Voucher Applied</strong>
														</div>
														<div class="col-xs-6 text-right">
															
															<span id="Value_font"><?php echo $Symbol_of_currency; ?></strong>
																<input type="text" id="redeem_voucher_amt" class="txt" name="redeem_voucher_amt"  
																 placeholder="Balance" value="0.00" style="width: 60px;" readonly> 
															
														</div>
													</div>
													<div class="row" style="width:100%">
														<div class="col-xs-6" style="width:70%">
															<strong id="Medium_font">Redeem Amt</strong>
														</div>
														<div class="col-xs-6 text-right">
															
															<span id="Value_font"><?php echo $Symbol_of_currency; ?>&nbsp;<input
																type='text'
																name='redeem_amt'
																class="txt"
																id='redeem_amt'
																value="0.00"
																size='6'
																readOnly style="width: 60px;"> </span>
															
														</div>
													</div>
													
													<div class="row" style="width:100%">
														<div class="col-xs-6" style="width:70%">
															<strong id="Medium_font">Total Due</strong>
														</div>
														<div class="col-xs-6 text-right">
															
															<strong id="Value_font"><?php echo $Symbol_of_currency; ?>&nbsp;<input
																		type='text'
																		id='total_bill_amount'
																		class="txt"
																		name='total_bill_amount'
																		size='6'
																		readOnly style="width: 60px;"></strong>
															
														</div>
													</div>
													<hr>
                                                <div class="row" style="width:100%">
                                                      <div class="col-xs-6" style="width:50%">
                                                            <button type="button" id="button1"
                                                                  class="b-items__item__add-to-cart"
                                                                  onclick="return Go_to_cart_details(<?php echo $_SESSION['delivery_type']; ?>,<?php echo $_SESSION['delivery_outlet']; ?>);">Back</button>
                                                      </div>

                                                      <div class="col-xs-6 text-right" style="width:50%">
                                                            <!--<span id="button" class="b-items__item__add-to-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to cart</span>
											 
															checkout_cart_details?delivery_type=0&delivery_outlet=142&Address_type=0
															-->
                                                            <input type="hidden" name="delivery_type"
                                                                  value="<?php echo $_SESSION['delivery_type']; ?>" />
                                                            <input type="hidden" name="delivery_outlet"
                                                                  value="<?php echo $_SESSION['delivery_outlet']; ?>" />
                                                            <input type="hidden" name="Address_type"
                                                                  value="<?php echo $_SESSION['Address_type']; ?>" />
                                                            <button type="submit" id="Payment"> Proceed</button>
                                                      </div>
                                                </div>
                                          </div>
                                          <hr>
      </form>
      <!-- 6th Sub -->
	<?php 
	
	} else {
		
	/* if(empty($cart_check)) */
	?>

			  <div class="pricing-details">
					<div class="row">
						  <div class="col-md-12">
								<address>
									  <button type="button" id="button" class="b-items__item__add-to-cart"
											onclick="return Go_to_Shopping();">Menu</button>
								</address>
						  </div>
					</div>
			  </div>

      <?php } ?>

      </div>
      <!-- End -->
      </div>



      </div>
      </div>
      </div>


		<!-- Discount Vouchers Modal -->
	<div id="vouchers_modal" class="modal fade" role="dialog" style="overflow:auto;">
		<div class="modal-dialog modal-sm" style="margin-top: 10%;" id="Show_vouchers">
		
			<div class="modal-content" >
				<div class="modal-header">
				  <h6 class="modal-title"><b>Discount Vouchers</b></h4>
				</div>
				<div class="modal-body">
					<div class="table-responsive" id="Show_item_info">
						<div class="table-responsive">
							<table class="table table-hover">
								<!--<thead>
									<tr>
										<th>Select</th><th> Voucher Number </th><th>Value (in <?php echo $Symbol_of_currency; ?>)</th><th> Valid Till </th>
									</tr>
								</thead> -->
								<tbody>
								<?php 
									// if(count($DiscountVouchers) > 0){
									if($DiscountVouchers){
										foreach($DiscountVouchers as $v){
											/* $v['Card_balance'] */
								?>
									<tr onclick="SelectRow(<?php echo $v['Gift_card_id']; ?>,<?php echo number_format($v['Card_balance'],2); ?>)">
										<th>
											<span id="Small_font">Apply:&nbsp;</span> <input type='radio' id="radio_<?php echo $v['Gift_card_id']; ?>" name='radio_voucher' onclick='setVoucher("<?php echo $v['Gift_card_id']; ?>","<?php echo number_format($v['Card_balance'],2); ?>")'>
										</th>
										<th> <span id="Small_font">Code: &nbsp;</span><?php echo $v['Gift_card_id']; ?>
											<br> <span id="Small_font">Value (in <?php echo $Symbol_of_currency; ?>): &nbsp;</span>
											<?php echo number_format($v['Card_balance'],2); ?>
											<br> <span id="Small_font">Validity:&nbsp;</span> <?php echo $v['Valid_till']; ?> </th>
										
									</tr>
								<?php }
									/* <th> <?php echo $v['Card_balance']; ?> </th>
										<th> <?php echo $v['Valid_till']; ?> </th> */
								} else { ?>
									
										
										<tr>
											<th colspan="2" class="text-center" style="border-top:none;">
												<span id="Small_font">No Vouchers available!</span>
											</th>
											
											
										</tr>	
										
										
										
									
								<?php } ?>		
								</tbody>
							</table>	
						</div>
					</div>
				</div>
				<div class="modal-footer">
				<button type="button" aria-label="Close" id="close_modal2" align="center" >Close&nbsp;<i class="fa fa-forward" aria-hidden="true"></i></button>
				</div>

			</div>
		</div>
	</div>
	<!--Discount Vouchers Modal -->	



      <!-- Loader -->
      <div class="container">
            <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static"
                  data-keyboard="false">
                  <div class="modal-dialog modal-sm" style="margin-top: 65%;">
                        <!-- Modal content-->
                        <div class="modal-content" id="loader_model">
                              <div class="modal-body" style="padding: 10px 0px;;">
                                    <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif"
                                          alt="" class="img-rounded img-responsive" width="80">
                              </div>
                        </div>
                  </div>
            </div>
      </div>
      <!-- Loader -->

      <?php $this->load->view('front/header/footer');?>
      <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/jquery-confirm.css" />
      <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-confirm.js"></script>

      <script>
      /* Shopping/checkout_cart_details?delivery_type=0&delivery_outlet=142&Address_type=0 */



      function SelectRow(RowID,Card_balance){
		  $('#radio_'+RowID).prop('checked', true);
		  setVoucher(RowID,Card_balance,2);
	  }

      function Go_to_cart_details(delivery_type,delivery_outlet) {
            setTimeout(function() {
                  $('#myModal').modal('show');
                  window.location.href =
                        '<?php echo base_url(); ?>index.php/Shopping/select_outlet?delivery_type=' +
                        delivery_type + '&delivery_outlet=' + delivery_outlet;

            }, 0);
            setTimeout(function() {
                  $('#myModal').modal('hide');

            }, 2000);
      }
	  
	  
	  
	/* $(function () 
    {	
			/* 11-04-2020
			 $("#Points_redeem_div_1").show();
				show_redeem_div(1,'1');
				show_voucher_div(1);
			/* 11-04-2020 ********
	
	
	
        var Cart_redeem_point = '<?php echo $Cart_redeem_point; ?>';
        var ratio_value2 = '<?php echo $Redemptionratio;?>';
        var grand_total2 = '<?php echo $_SESSION['Grand_total']; ?>';
		var Redeem_amount = '<?php echo number_format($_SESSION['Redeem_amount'],2); ?>';
		var redeem_by_voucher = '<?php echo $_SESSION['redeem_by_voucher']; ?>';
		console.log("-----Cart_redeem_point----"+Cart_redeem_point);
		console.log("-----ratio_value2----"+ratio_value2);
		console.log("-----grand_total2----"+grand_total2);
		 console.log("-----Redeem_amount----"+Redeem_amount);
		console.log("-----redeem_by_voucher----"+redeem_by_voucher);
        if(Cart_redeem_point != 0)
        {
            /* $("#redeem_label").show();
            $("#point_redeem").show();
            $("#Equivalent").show(); ***********
			
			$("#Points_redeem_div_1").show();
			$("#Points_redeem_div_2").show();
			$("#Points_redeem_div_3").show();
			$("#Points_redeem_div_4").show();
            $("#point_redeem").val(Cart_redeem_point);

            // var EquiRedeem2 = (Cart_redeem_point/ratio_value2).toFixed(2);
			var EquiRedeem2 = Redeem_amount;
            $("#redeem_amt").val(EquiRedeem2);
			
			console.log("-----EquiRedeem2----"+EquiRedeem2);

            // var Total_bill2 = (grand_total2 - EquiRedeem2).toFixed(2);
            var Total_bill2 = parseFloat(grand_total2 - EquiRedeem2).toFixed(2);
			
			console.log("-----Total_bill2----"+Total_bill2);
			if(Total_bill2 < 0)
			{
				//$("#redeem_by").show();
				document.getElementById("inlineRadio3").checked = true;
				show_redeem_div(2,0);
				
				$("#redeem_amt").val(0);

				Total_bill2 = grand_total2;
				
			}
             $("#total_bill_amount").val(Total_bill2);
        }
        else
        {
			$("#Points_redeem_div_1").hide();
			$("#Points_redeem_div_2").hide();
			$("#Points_redeem_div_3").hide();
			$("#Points_redeem_div_4").hide();
            $("#total_bill_amount").val(grand_total2);
        }
    }); */
	
	
	
	$(function () 
    {	
		show_voucher_div(1);
		
        var Cart_redeem_point = '<?php echo $Cart_redeem_point; ?>';
        var ratio_value2 = '<?php echo $Redemptionratio;?>';
        var grand_total2 = '<?php echo $_SESSION['Grand_total']; ?>';
		var Redeem_amount = '<?php echo $_SESSION['Redeem_amount']; ?>';
		var redeem_by_voucher = '<?php echo $_SESSION['redeem_by_voucher']; ?>';
		// console.log(Cart_redeem_point);
		// console.log(Redeem_amount);
		// console.log("-----redeem_by_voucher----"+redeem_by_voucher);
        if(Cart_redeem_point != 0)
        {
            /* $("#redeem_label").show();
            $("#point_redeem").show();
            $("#Equivalent").show(); */
			
			$("#Points_redeem_div_1").show();
			$("#Points_redeem_div_2").show();
			$("#Points_redeem_div_3").show();
			$("#Points_redeem_div_4").show();
            $("#point_redeem").val(Cart_redeem_point);

            // var EquiRedeem2 = (Cart_redeem_point/ratio_value2).toFixed(2);
			var EquiRedeem2 = Redeem_amount;
            $("#redeem_amt").val(EquiRedeem2);

            var Total_bill2 = (grand_total2 - EquiRedeem2).toFixed(2);
			if(Total_bill2 < 0)
			{
				//$("#redeem_by").show();
				document.getElementById("inlineRadio3").checked = true;
				show_redeem_div(2,0);
				
				$("#redeem_amt").val(0);

				Total_bill2 = grand_total2;
				
			}
            $("#total_bill_amount").val(Total_bill2);
        }
        else
        {
			// $("#Points_redeem_div_1").hide();
			$("#Points_redeem_div_1").show();
			$("#Points_redeem_div_2").hide();
			$("#Points_redeem_div_3").hide();
			$("#Points_redeem_div_4").hide();
            $("#total_bill_amount").val(grand_total2);
        }
    });

      function Go_to_Shopping() {
            setTimeout(function() {
                  $('#myModal').modal('show');
                  window.location.href = '<?php echo base_url(); ?>index.php/Shopping';
            }, 0);
            setTimeout(function() {
                  $('#myModal').modal('hide');

            }, 2000);
      }

      function show_redeem_div(redeem_flag, div_flag) {

            var purchase_amt = '<?php echo $_SESSION['
            Grand_total ']; ?>';
            if (div_flag == 1 && redeem_flag == 1) {
                  // $("#point_redeem").attr("required","required");id="Points_redeem_div_1" style="display:none;"
                  $("#Points_redeem_div_1").show();
                  $("#Points_redeem_div_2").show();
                  $("#Points_redeem_div_3").show();
                  $("#Points_redeem_div_4").show();
            } else if (div_flag == 0 && redeem_flag == 2) {
                  // $("#point_redeem").removeAttr("required");
                  // $("#Points_redeem_div").hide();
                  $("#Points_redeem_div_1").hide();
                  $("#Points_redeem_div_2").hide();
                  $("#Points_redeem_div_3").hide();
                  $("#Points_redeem_div_4").hide();
                  // $("#point_redeem").val(0);
                  $("#total_bill_amount").val(purchase_amt);
            }
      }

      function cal_redeem_amt(redeemBY) {
            var bal = '<?php echo $Current_point_balance1; ?>';
            var purchase_amt = '<?php echo $_SESSION['Grand_total']; ?>';
            var ratio_value = '<?php echo $Redemptionratio;?>';
            var reedem = $("#point_redeem").val();
            var redeem_voucher_amt = $("#redeem_voucher_amt").val();
            var grand_total = '<?php echo $_SESSION['Grand_total']; ?>';
            /*  alert('bal'+bal);
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
							
							
							
                              $('#redeem_amt').val(data.EquiRedeem.toFixed(2));
                              $('#total_bill_amount').val(data.Grand_total);
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
                              $('#total_bill_amount').val(grand_total);
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
                              $('#total_bill_amount').val(grand_total);
                        }

                        if (data.Error_flag == 3) {
                              $('#redeem_amt').val(0);
                              $('#point_redeem').val(0);
                              $('#total_bill_amount').val(grand_total);
                        }
                  }
            });
      }

      function redeem_check() {
		  
            if ($('#inlineRadio2').prop('checked')) {
				
                  var point_redeem = $('#point_redeem').val();
                  var Currency_name = '<?php echo $Company_Details->Currency_name; ?> ';
                  var enteredredeempts = '<?php echo ceil($_SESSION['Grand_total'] * $Redemptionratio); ?> ';
					// console.log(point_redeem+"--enteredredeempts--"+enteredredeempts)
					if ( parseInt(point_redeem) > parseInt(enteredredeempts) ) {
                        // alert('here....');
                        var msg = 'Please enter redeem ' + Currency_name + ' less than or equal to ' + enteredredeempts + ' ';
                        $('#point_redeem_div').show();
                        $('#point_redeem_div').css("color", "red");
                        $('#point_redeem_div').html(msg);
                        setTimeout(function() {
                              $('#point_redeem_div').hide();
                        }, 3000);
                        $("#point_redeem").focus();
                        return false;
						
                  } else if (point_redeem == "") {
                        // alert('here....');
                        var msg = 'Please enter redeem ' + Currency_name + '';
                        $('#point_redeem_div').show();
                        $('#point_redeem_div').css("color", "red");
                        $('#point_redeem_div').html(msg);
                        setTimeout(function() {
                              $('#point_redeem_div').hide();
                        }, 3000);
                        $("#point_redeem").focus();
						
                        return false;
						
                  } 			 
				  else {
					  
                        if (parseInt(point_redeem) == 0) {
                              var msg = 'Please redeem ' + Currency_name + ' greater than 0';
                              $('#point_redeem_div').show();
                              $('#point_redeem_div').css("color", "red");
                              $('#point_redeem_div').html(msg);
                              setTimeout(function() {
                                    $('#point_redeem_div').hide();
                              }, 3000);
                              $("#point_redeem").focus();
                              return false;
                        }

                        setTimeout(function() {
                              $('#myModal').modal('show');
                        }, 0);
                        setTimeout(function() {
                              $('#myModal').modal('hide');

                        }, 2000);


                  }
				  
            } else {
                  setTimeout(function() {
                        $('#myModal').modal('show');
                  }, 0);
                  setTimeout(function() {
                        $('#myModal').modal('hide');

                  }, 2000);

                  return true;
            }

      }
      </script>
      <script>
      function delete_item(rowid, Item_name) {
            $.confirm({
                  title: 'Item Delete Confirmation',
                  content: 'Are you sure to delete ' + Item_name + ' item from the cart.',
                  icon: 'fa fa-question-circle',
                  animation: 'scale',
                  closeAnimation: 'scale',
                  opacity: 0.5,
                  buttons: {
                        'confirm': {
                              text: 'OK',
                              btnClass: 'btn-default',
                              action: function() {
                                    $.confirm({
                                          title: 'Item will be deleted from the cart.',
                                          content: 'Please click on OK to Continue.',
                                          icon: 'fa fa-warning',
                                          animation: 'scale',
                                          closeAnimation: 'zoom',
                                          buttons: {
                                                confirm: {
                                                      text: 'OK',
                                                      btnClass: 'btn-default',
                                                      action: function() {

                                                            setTimeout(function() {
                                                                  $('#myModal')
                                                                        .modal(
                                                                              'show'
                                                                              );
                                                            }, 0);
                                                            setTimeout(function() {
                                                                  $('#myModal')
                                                                        .modal(
                                                                              'hide'
                                                                              );
                                                            }, 2000);

                                                            $.ajax({
                                                                  type: "POST",
                                                                  data: {
                                                                        rowid: rowid
                                                                  },
                                                                  // url: "<?php echo base_url()?>index.php/Redemption_Catalogue/delete_item_catalogue",
                                                                  url: "<?php echo base_url()?>index.php/Shopping/remove",
                                                                  success: function(data) 
																		{
																			
																			location.reload(true);
																						
																			/* window.location.href ='<?php echo base_url(); ?>index.php/Shopping/checkout_cart_details?delivery_type=' +
                                                                              delivery_type +
                                                                              '&delivery_outlet=' +
                                                                              delivery_outlet +
                                                                              '&Address_type=' +
                                                                              Address_type; */ 
                                                                  }
                                                            });
                                                      }
                                                },
                                                cancel: function() {
                                                      //$.alert('you clicked on <strong>cancel</strong>');
                                                }
                                          }
                                    });
                              }
                        },
                        cancel: function() {},
                  }
            });

      }
	  
	  
	  
	  
	  
	  	
//******** discount voucher ******************

function getDiscountVouchers()
{
	// alert("called me");
	// $('#vouchers_modal').show();	
	// $("#vouchers_modal").addClass("in");	
	
	// $('#vouchers_modal').modal('show');
	$('#vouchers_modal').modal('show');
}
$("#close_modal").click(function(e)
{
	$('#vouchers_modal').modal('hide');
});

$("#close_modal2").click(function(e)
{
	$('#vouchers_modal').modal('hide');
});

 
function setVoucher(Gift_card_id,Card_balance)
{
//	alert(Gift_card_id+"---"+Card_balance)
	var purchase_amt = '<?php echo $_SESSION['Grand_total']; ?>';
	var redeem_amt = $("#redeem_amt").val();
	var TotalGrand = parseInt(Card_balance) + parseInt(redeem_amt);
	if(TotalGrand > purchase_amt)
	{
		$("#redeem_voucher").removeAttr("required");
		$("#voucher_label").hide();
		$(".voucher_label2").hide();
		$("#point_redeem").removeAttr("readonly");
		$("#redeem_voucher").val(0);
		$("#redeem_voucher_amt").val("");
		// $("#Payment").attr("disabled", false);
		
		var Title = "Application Information";
		var msg = 'Total purchase amount is less than voucher value, please try other voucher';
		runjs(Title,msg);
		
		return false;
	}
		// alert(parseInt(purchase_amt)+"--"+redeem_amt+"--"+ parseInt(TotalGrand));
	var new_purchase_amt = parseInt(purchase_amt) - parseInt(TotalGrand);
	
	if(new_purchase_amt < 0){
		new_purchase_amt = 0;
	}
	

	
	$("#redeem_voucher").val(Gift_card_id);
	$("#redeem_voucher_amt").val(Card_balance);
	$("#redeem_voucher_amt").attr("readonly",'true');
	$("#total_bill_amount").val(new_purchase_amt.toFixed(2));
	$("#close_modal2").text("Apply");
	// $("#Payment").attr("disabled", false);
}

function show_voucher_div(voucherFlag)
{
	
	var purchase_amt = '<?php echo $_SESSION['Grand_total']; ?>';
	let redeem_voucher_amt = $("#redeem_amt").val();
	
	/* alert(voucherFlag);
	alert('purchase_amt---'+purchase_amt);
	alert('redeem_voucher_amt---'+redeem_voucher_amt); */
	
	
	if(redeem_voucher_amt > 0)
	{
		var purchase_amt = parseInt(purchase_amt) - parseInt(redeem_voucher_amt);
		
		if(purchase_amt < 0)
		{
			purchase_amt = 0;
		}
	}
	
	if(voucherFlag == 1)
	{
		$("#redeem_voucher").attr("required","required");
		$("#voucher_label").show();
		$("#voucher_label2").show();
		$("#Points_redeem_div_4").show();
		// $("#point_redeem").attr("readonly","true");
		// $("#Payment").attr("disabled", true);
	}
	else if(voucherFlag == 2)
	{
		$("#redeem_voucher").removeAttr("required");
		$("#voucher_label").hide();
		$("#voucher_label2").hide();
		$("#Points_redeem_div_4").show();
		$("#point_redeem").removeAttr("readonly");
		$("#redeem_voucher").val(0);
		$("#redeem_voucher_amt").val("");
		$("#total_bill_amount").val(parseFloat(purchase_amt).toFixed(2));
		// $("#Payment").attr("disabled", false);
	}
}

function get_voucher_amt(GiftCard)
{
	var purchase_amt = $("#total_bill_amount").val();
	// alert("---purchase_amt--------"+purchase_amt);
	if(GiftCard != "")
	{
	$.ajax({
		type:"POST",
		data:{GiftCardId:GiftCard,Grand_total:purchase_amt},
		url:"<?php echo base_url()?>index.php/Shopping/get_gift_voucher_amt/",
		success:function(opt){
		
				if(opt == 0)
				{
					$("#redeem_voucher").val("");
					/* var Title = "Application Information";
					var msg = 'Invalid Voucher Or Voucher Amount is More than Total Bill Amount';
					runjs(Title,msg);
					return false; */
					
					 var msg = 'Invalid voucher or amount is greater than bill amount';
                              $('#redeem_voucher_div').show();
                              $('#redeem_voucher_div').css("color", "red");
                              $('#redeem_voucher_div').html(msg);
                              setTimeout(function() {
                                    $('#redeem_voucher_div').hide();
                              }, 3000);
                              $("#redeem_voucher").focus();
				}				
				if(opt > 0)
				{
					var new_purchase_amt = (parseInt(purchase_amt) - parseInt(opt)).toFixed(2);
					$("#redeem_voucher_amt").val(opt);
					$("#total_bill_amount").val(new_purchase_amt);
					// $("#Payment").attr("disabled", false);
				}
				
			}
		});
	} else {
		
			var msg = 'Please enter voucher number';
			  $('#redeem_voucher_div').show();
			  $('#redeem_voucher_div').css("color", "red");
			  $('#redeem_voucher_div').html(msg);
			  setTimeout(function() {
					$('#redeem_voucher_div').hide();
			  }, 3000);
			  $("#redeem_voucher").focus();
			  return false;
	}
}
//******** discount voucher ******************
	  
	  
      </script>
      <style>
	  
	  
	#close_modal2,#Payment 
	{
		color:<?php echo $Button_font_details[0]['Button_font_color'];?>;
		font-family:<?php echo $Button_font_details[0]['Button_font_family'];?>;
		font-size:<?php echo $Button_font_details[0]['Button_font_size'];?>;
		background:<?php echo $Button_font_details[0]['Button_background_color'];?>;
		border-radius:7px;
		margin:0px;
		border: 1px solid <?php echo $Button_font_details[0]['Button_border_color'];?>;
		width: 115px;
	}
      .btn-default {
            color: <?php echo $Button_font_details[0]['Button_font_color'];
            ?> !IMPORTANT;
            font-family: <?php echo $Button_font_details[0]['Button_font_family'];
            ?> !IMPORTANT;
            font-size: <?php echo $Button_font_details[0]['Button_font_size'];
            ?> !IMPORTANT;
            background: <?php echo $Button_font_details[0]['Button_background_color'];
            ?> !IMPORTANT;
            border-radius: 7px !IMPORTANT;

            border: 1px solid <?php echo $Button_font_details[0]['Button_border_color'];
            ?> !IMPORTANT;
            width: 115px !IMPORTANT;
      }

      input[type='radio']:after {
            content: " ";
            display: inline-block;
            position: relative;

            margin: 0 5px 4px 0;
            width: 13px;
            height: 13px;
            border-radius: 11px;
            border: 1.8px solid #ef888e;
            background-color: white;



            /*content: " ";
    display: inline-block;
    position: relative;
    top: 5px;
    margin: 0 5px 4px 0;
    width: 13px;
    height: 13px;
    border-radius: 11px;
    border: 1.8px solid #ef888e;
    background-color: transparent; */
      }

      input[type='radio']:checked:after {

            width: 15px;
            height: 15px;
            border-radius: 15px;
            top: -2px;
            left: -1px;
            position: relative;
            background-color: #ef888e;
            content: '';
            display: inline-block;
            visibility: visible;
            border: 2px solid white;

            /* border-radius: 11px;
    width: 7px;
    height: 7px;
    position: absolute;
    top: 8px;
    left: 8.8px;
    content: " ";
    display: block;
    background: #ef888e; */


      }

      .pricing-table .pricing-details ul li {
            padding: 10px;
            font-size: 12px;
            border-bottom: 1px solid #eee;
            color: #ffffff;
            font-weight: 600;
      }

      .pricing-table {
            padding: 12px 12px 0 12px;
            margin-bottom: 0 !important;
            background: #fff;
      }

      .footer-xs {
            padding: 10px;
            color: #000;
            width: 33.33%;
            border-right: 1px solid #eee;
      }

      .main-xs-3 {
            width: 26%;
            padding: 10px 10px 0 10px;
      }

      .main-xs-6 {
            width: 50%;
            padding: 10px 10px 0 10px;
      }

      #action {
            margin-bottom: 5px;
            width: 235%;
            color: #ff3399;
      }

      #bill {
            color: #ff3399;
            font-weight: bold;
      }

      #bill1 {

            margin-right: 5%;
      }

      .txt {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            border-left-color: -moz-use-text-color;
            border-left-style: none;
            border-left-width: medium;
            border-top-color: -moz-use-text-color;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border-top-style: none;
            border-top-width: medium;
            margin-left: 0;
            outline-color: -moz-use-text-color;
            outline-style: none;
            outline-width: medium;
            padding-bottom: 2%;
            padding-left: 1%;
            padding-right: 1%;
            padding-top: 4%;
            width: 100px;
      }
      </style>
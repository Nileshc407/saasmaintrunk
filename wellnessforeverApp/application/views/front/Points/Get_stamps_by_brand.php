<?php 
$this->load->view('front/header/header'); 
$this->load->view('front/header/menu');   
$ci_object = &get_instance(); 
$ci_object->load->model('Igain_model');
$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);



?>


<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;">
			<!--<img style="height: 44px;" src="<?php echo base_url(); ?>assets/img/default-black-top.png">-->
			</div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
				<div class="leftRight"><button onclick="location.href = '<?php echo base_url(); ?>index.php/Cust_home/select_stamp_brand';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
				<div><h1>Your Stamp Collections</h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>

<main class="padTop padBottom">
	<div class="container">
		<div class="row">
           
			<div class="col-12 stampVoucherWrapper">
					<?php 
					//print_r($brandStampDetails);
					$totalcnt = count($brandStampDetails);
					if($brandStampDetails){
						$Buy_item;
						$count=0;
						$countarray=array();
						$Merchandize_item_name;						
						$j=0;
						$UnusedGiftCardCount=0;
						
						foreach($brandStampDetails as $stamp ) {
							
							$Merchandize_item_name= $stamp->Merchandize_item_name; 
							$Offer_code= $stamp->Offer_code; 
							$Offer_id= $stamp->Offer_id; 
							$Offer_name= $stamp->Offer_name; 
							$Offer_description= $stamp->Offer_description; 
							$Buy_item= $stamp->Buy_item; 
							$Free_item= $stamp->Free_item; 
							$Till_date= $stamp->Till_date; 
							$Trans_date = $stamp->Trans_date; 
							$TotalQty = $stamp->TotalQty; 
							$countarray[]=$stamp->Buy_item-$stamp->TotalQty;
							// $count=$Buy_item-$TotalQty;
							// echo "---Trans_date-----".$stamp->Trans_date."----<br>";
							
							
							$UnusedGiftCardCount= $ci_object->Igain_model->Fetch_Seller_Stamp_unused_voucher($session_data['enroll'],$session_data['Company_id'],$Enroll_details->Card_id,$stamp->Seller_id,$Offer_code);
							
							// echo "---UnusedGiftCardCount-----".$UnusedGiftCardCount."----<br>";
							 // echo"--Offer_code---".$stamp->Offer_code."--TotalQty---".$stamp->TotalQty."---Buy_item---".$stamp->Buy_item."----Free_item---".$stamp->Free_item."---<br>";
							
							if($j % 2 == 0){
								$css="dark-bg";
							} else {
								$css="";
							}
							
						
						
						
							$Buy_item_count = fmod($TotalQty, $Buy_item);
						?>
							
							<?php if($totalcnt > 1) { ?>
							
								<h1><?php echo $Offer_description; ?></h1>
							<?php } else { ?>
								<h1><?php echo $Offer_description; ?></h1>
							<?php } ?>
							
							<?php
								$data=array();
								for($i=0;$i<$Buy_item;$i++) {
									$data[]=$i.',';
								}	
								$break_after = 2;

									$counter = 0;   
									$totalNumber = count($data);   
									$nwcnt=$totalNumber-1;
									foreach ($data as $item) {
										
										if ($counter % $break_after == 0) {
											
											echo '<div class="row">';
										} 
										
										/* if($counter >= $TotalQty){ */
										if($counter >= $Buy_item_count){
												
																										
											?>
											 
											 
											
											
												<div class="col-6 pl-2">
													<div class="stampHldr disable">
														<div class="d-flex align-items-center proHldr">
															<div class="flex-grow-1 proName">
																<?php echo $Offer_name; ?>
															</div>
															<div class="proImg"><img src="<?php echo base_url(); ?>assets/img/ice-cup.png"></div>
														</div>
														<div class="dateMain">
															<!--<div class="d-flex align-items-center">
																<div class="dateIcon"><img src="<?php echo base_url(); ?>assets/img/date-icon.svg"></div>
																<div class="date"><?php //echo date('d M Y',strtotime($stamp->Trans_date)); ?></div>
															</div>-->
														</div>
													</div>
												</div>
											 
											
											 
										<?php } else { ?>
												
												<div class="col-6 pr-2">
													<div class="stampHldr">
														<div class="d-flex align-items-center proHldr">
															<div class="flex-grow-1 proName">
																<?php echo $Offer_name; ?>
															</div>
															<div class="proImg"><img src="<?php echo base_url(); ?>assets/img/ice-cup.png"></div>
														</div>
														<div class="dateMain">
															<div class="d-flex align-items-center">
																<div class="dateIcon"><img src="<?php echo base_url(); ?>assets/img/date-icon.svg"></div>
																<?php if($stamp->Trans_date) { ?>
																	<div class="date"><?php echo date('d M Y',strtotime($stamp->Trans_date)); ?></div><?php } ?>
															</div>
														</div>
													</div>
												</div>
												
												
											<?php 															
											} 
											?>
											
											
												
										<?php  

										if ($counter % $break_after == ($break_after-1) || $counter == $totalNumber-1) {
											echo '</div>';
										}
										++$counter;

									}


									 ?>	
							
							
									<hr>
							
										<?php 
										 
										 // $TotalQty=5;
										 // $UnusedGiftCardCount=2;
											$totalFreeItem=floor($TotalQty/$Buy_item);
												// $totalFreeItem1=$UnusedGiftCardCount;
												// echo "---totalFreeItem-----".$totalFreeItem."----<br>";
												// echo "---totalFreeItem1-----".$totalFreeItem1."----<br>";
												 // $totalFreeItem=2;
												if($totalFreeItem > 0 && $UnusedGiftCardCount > 0 ){ ?>
													
													<a href="<?php echo base_url(); ?>index.php/Cust_home/My_vouchers" style="text-align: center!important;display:inline;"><h1>You have <?php echo $UnusedGiftCardCount; ?> Free vouchers</h1></a>
												<?php }
										 
												$data1=array();
												for($i=0;$i<$Free_item;$i++) {
													$data1[]=$i.',';
												}
												
													
													/* $break_after = 2;

													$counter = 0;   
													$totalNumber = count($data1);   
													$nwcnt=$totalNumber-1;
													foreach ($data1 as $item) {
														
														if ($counter % $break_after == 0) {
															echo '<div class="row">';
														}										
																
														// if($Buy_item >= $TotalQty){	
														if($Buy_item >= $Buy_item_count){	
														
															  ?>
															
															
															
															
															<div class="col-6 pr-2">
																<div class="stampHldr disable">
																	<div class="d-flex align-items-center proHldr">
																		<div class="flex-grow-1 proName">
																			<?php echo $Offer_name; ?>
																		</div>
																		<div class="proImg"><img src="<?php echo base_url(); ?>assets/img/ice-cup.png"></div>
																	</div>
																	<div class="dateMain">
																		<div class="d-flex align-items-center">
																			<div class="dateIcon"><img src="<?php echo base_url(); ?>assets/img/date-icon.svg"></div>
																			<div class="date"><?php echo date('d M Y',strtotime($Till_date)); ?></div>
																		</div>
																	</div>
																</div>
																<b style="text-align: center;">FREE</b>
															</div>
															  
														<?php }  else {
																
																
															?>
															
															
																<div class="col-6 pl-2">
																	<div class="stampHldr">
																		<div class="d-flex align-items-center proHldr">
																			<div class="flex-grow-1 proName">
																				<?php echo $Offer_name; ?>
																			</div>
																			<div class="proImg"><img src="<?php echo base_url(); ?>assets/brand-<?php echo $brndID; ?>img/ice-cup.png"></div>
																		</div>
																		<div class="dateMain">
																			<div class="d-flex align-items-center">
																				<div class="dateIcon"><img src="<?php echo base_url(); ?>assets/img/date-icon.svg"></div>
																				<div class="date"><?php echo date('d M Y',strtotime($Till_date)); ?></div>
																			</div>
																		</div>
																	</div>
																</div>
															<?php  
															 }  ?>
															
															
																
														<?php
														if ($counter % $break_after == ($break_after-1) || $counter == $totalNumber-1) {
															echo '</div>';
														}
														++$counter;

													} */

												
										?>
									
									
								
								

								

								
									
									
								
							
							
						
						<?php 
						$j++;
						}
						
					} else { ?> 
						<div class="row">
							<div class="col-12 pr-2">
								<h6 class="text-center dark-bg p-2"><b>No records found</b></h6>
							</div>
						</div>
						
					<?php 
					}
					?>

		  
               
            </div>
			
			
			
			
			
			
			
			
			
		</div>
	</div>
</main>
	
<?php $this->load->view('front/header/footer');  ?>
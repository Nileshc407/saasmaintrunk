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
				<div class="leftRight"><button onclick="location.href = '<?php echo base_url().'index.php/Cust_home/select_stamp_brand'; ?>';" ><img src="<?php echo base_url(); ?>assets/img/back-icon.svg"></button></div>
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
					// print_r($brandStampDetails);
					$totalcnt = count($brandStampDetails);
						if($brandStampDetails){
							
							foreach($brandStampDetails as $stamp ) {
								
								$Offer_description= $stamp->Offer_description;
							}
						}

						
					?>
			<?php if($totalcnt >= 1) { ?>
                <h1><?php echo $Offer_description; ?></h1>
				<?php }
				?>
               
					<?php 
					print_r($brandStampDetails);
					if($brandStampDetails){
						
						$Buy_item;
						$count=0;
						$countarray=array();
						$Merchandize_item_name;
						
						$j=0;
						$UnusedGiftCardCount=0;
						
						
						foreach($brandStampDetails as $stamp ) {
							
							// $Merchandize_item_name= $stamp->Merchandize_item_name; 
							$Offer_code= $stamp->Offer_code; 
							$Offer_id= $stamp->Offer_id; 
							$Offer_name= $stamp->Offer_name; 
							$Offer_description= $stamp->Offer_description; 
							$Buy_item= $stamp->Buy_item; 
							$Free_item= $stamp->Free_item; 
							$TotalQty = $stamp->TotalQty; 
							$Till_date = $stamp->Till_date; 
							$countarray[]=$stamp->Buy_item-$stamp->TotalQty;
							// $count=$Buy_item-$TotalQty;
							// echo "---Seller_id-----".$stamp->Seller_id."----<br>";
							
							
							$UnusedGiftCardCount= $ci_object->Igain_model->Fetch_Seller_Stamp_unused_voucher($enroll,$Company_id,$Enroll_details->Card_id,$stamp->Seller_id,$Offer_code);
							
							// echo "---UnusedGiftCardCount-----".$UnusedGiftCardCount."----<br>";
							 // echo"--Offer_code---".$stamp->Offer_code."--TotalQty---".$stamp->TotalQty."---Buy_item---".$stamp->Buy_item."----Free_item---".$stamp->Free_item."---<br>";
						
						
						// $Buy_item_count=$TotalQty/$Buy_item;
						
						$Buy_item_count = fmod($TotalQty, $Buy_item);
						

						
						?>
							 <div class="row">
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
												<div class="date"><?php echo date('d M Y',strtotime($Till_date)); ?></div>
											</div>
										</div>
									</div>
								</div>
							  
							</div>
						<?php 
					}
						
				}
			?>   

                <h1>You have 3 Free vouchers</h1>

                <div class="row">
                    <div class="col-6 pr-2">
                        <div class="stampHldr disable">
                            <div class="d-flex align-items-center proHldr">
                                <div class="flex-grow-1 proName">
                                    Chocolate <br/>Vanilla Sundae
                                </div>
                                <div class="proImg"><img src="img/ice-cup.png"></div>
                            </div>
                            <div class="dateMain">
                                <div class="d-flex align-items-center">
                                    <div class="dateIcon"><img src="img/date-icon.svg"></div>
                                    <div class="date">20 September 2021</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

               
                
            </div>
		</div>
	</div>
</main>
	
<?php $this->load->view('front/header/footer');  ?>
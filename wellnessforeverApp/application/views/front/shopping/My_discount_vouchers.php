<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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
    // print_r($General_details);
    // echo"--Ecommerce_flag---".$Ecommerce_flag."--<br>";
    // echo"--Symbol_of_currency---".$Symbol_of_currency."--<br>";
    // die;
    if($Ecommerce_flag==1) {						
            $cart_check = $this->cart->contents();
            // var_dump($cart_check);
            if(!empty($cart_check)) {
                    $cart = $this->cart->contents(); 
                    $grand_total = 0; 
                    $item_count = COUNT($cart); 

                    /* foreach ($cart as $item) {
                            $grand_total = $grand_total + $item['subtotal'];
                    } */
                    // echo "<b>".$Symbol_of_currency." ".number_format((float)$grand_total, 2)."</b>"; 
                    /* foreach ($this->cart->contents() as $item) { 
                            $Product_details = $this->Shopping_model->get_products_details($item['id']);
                    } */ 
            }
    }
    if($item_count <= 0 ) {
            $item_count=0;
    }
    else {
            $item_count = $item_count;
    }						
    if($Ecommerce_flag==1)
    {
            $wishlist = $this->wishlist->get_content();
            if(!empty($wishlist)) {

                    $wishlist = $this->wishlist->get_content();
                    $item_count2 = COUNT($wishlist); 

                    foreach ($wishlist as $item2) {

                            $Product_details2 = $this->Shopping_model->get_products_details($item2['id']);
                    }
            } 
    }
    if($item_count2 <= 0 ) {
            $item_count2=0;
    }
    else {
            $item_count2 = $item_count2;
    }

    // echo"--item_count2---".$item_count2."--<br>"; id=""
?> 
	<?php $this->load->view('front/header/menu'); ?>
    <div id="application_theme" class="section pricing-section" style="min-height:500px;" >
		<div class="container">
			<div class="section-header">          
				<p><a href="<?php echo base_url(); ?>index.php/Cust_home/front_home" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font">My Vouchers</p>
			</div>
			
			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
				
					<!-- 1st Card -->
						<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
							<div class="pricing-details">
								<?php 
								if($MyDiscountVouchers !=NULL)
								{
									// var_dump($Orders);
									foreach($MyDiscountVouchers as $row)
									{
										$Validity = $row->Valid_till;
										
									?>															
									
									<div class="row" >
										<div class="col-md-12">
										
											<div class="row " id="Flydubai">
												
													<table id="myTable" align="center" class="text-left"> 
														<tr>
															<td>
																<strong id="Medium_font">Voucher No. </strong>
															</td>
															<td>
																:&nbsp;<span style="margin-bottom: 0; font-size: 10px;"><strong id="Small_font"><?php echo $row->Gift_card_id; ?></strong></span>&nbsp;<br>
															</td>																			
														</tr>
														
														<tr>
															<td>
																<strong id="Medium_font">Voucher Value. </strong>
															</td>
															<td>
																:&nbsp;<span style="margin-bottom: 0; font-size: 10px;"><strong id="Small_font"> <?php echo number_format($row->Card_value,2); ?>(<?php echo $Symbol_of_currency; ?>)</strong></span>&nbsp;<br>
															</td>																			
														</tr>
													
														<tr>
															<td>
																<strong id="Medium_font">Received Date</strong>
															</td>
															<td>
																:&nbsp;<span style="margin-bottom: 0; font-size: 10px;"><strong id="Small_font"><?php echo date('d M, Y',strtotime($row->Create_date)); ?></strong></span>
															</td>																			
														</tr>
														<tr>
															<td>
																<strong id="Medium_font">Validity</strong>
															</td>
															<td>
																:&nbsp;<span style="margin-bottom: 0; font-size: 10px;"><strong id="Small_font"><?php echo date('d M, Y',strtotime($row->Valid_till)); ?></strong></span>
															</td>																			
														</tr>
														<tr>
															<td>
																<strong id="Medium_font">Status</strong>
															</td>
															<td>
																:&nbsp;<span style="margin-bottom: 0; font-size: 10px;">
																	<strong id="Small_font"><?php if($row->Card_balance > 0){ echo "<b style='color:green;'>Issued</b>"; } else { echo "<b style='color:red;'>Used</b>"; } ?></strong>
																</span>
																	
															</td>																			
														</tr>
													</table>
													
													
											
											</div>
											
										</div>
									</div>
									<hr style="background:white;">
									
									<?php 
										
									}
								}
								else
								{ ?>
									<div class="row" >
										<div class="col-md-12">
											<div class="row " id="Flydubai">		
												<div class="col-xs-12 text-center" id="detail_purchase_one">
													<strong id="Medium_font">No Records Found</strong><br />	
												</div>
											</div>											
										</div>
									</div><hr>
								<?php
								} ?>
							</div>
						</div>
					
					
					
				</div>

			</div>
		</div>
    </div>

	
	<!-- Loader -->	
    <div class="container" >
        <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm" style="margin-top: 65%;">
              <!-- Modal content-->
              <div class="modal-content" id="loader_model">
                    <div class="modal-body" style="padding: 10px 0px;;">
                      <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
                    </div>							
              </div>						  
            </div>
        </div>					  
    </div>
<!-- Loader -->
    <?php $this->load->view('front/header/footer');?>
	



<style>
	
	.pricing-table .pricing-details ul li {
		padding: 10px;
		font-size: 12px;
		border-bottom: 1px solid #eee;
		color: #ffffff;
		font-weight: 600;
	}
	
	.pricing-table
	{
		padding: 12px 12px 0 12px;
		margin-bottom: 0 !important;
		background: #fff;
	}
	
	
	
	
	
	
	.main-xs-6
	{
		width: 48%;
		padding: 10px 10px 0 10px;
	}
	
	
	
	#button{
		margin: 7%;
		width:115px;
	}
	
	#action{
		margin-bottom: 5px; 
		width: 235%;
		color: #ff3399;
	}	
	
	#prodname{
		color: #7d7c7c;
		font-size:13px;
	}
	#img{
		float: right;
		width: 10%;
		margin: -18px -15px auto;
	}
	
	
	
	#detail_purchase {
		line-height: 160%;
		width: 10%;
		margin-top: 10px;
	}
	
</style>
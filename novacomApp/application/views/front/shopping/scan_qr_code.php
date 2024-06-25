<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Scann QR Code</title>	
<?php $this->load->view('front/header/header');
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?> 	
</head>
<body>
	<?php 
		if($Ecommerce_flag==1) {						
			$cart_check = $this->cart->contents();
			// var_dump($cart_check);
			if(!empty($cart_check)) {
				$cart = $this->cart->contents(); 
				$grand_total = 0; 
				$item_count = COUNT($cart);
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
	?> 
    <div id="application_theme" class="section pricing-section" style="min-height:650px;">
		<div class="container">
			<div class="section-header">
				<p><a href="<?php echo base_url(); ?>index.php/Cust_home/load_shopping" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font">Scan QR Code</p>
			</div>

			<div class="row pricing-tables">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">				
					<!-- Main Card -->
					<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">
						<!-- 1 card -->
						<div class="pricing-details">
							<div class="row">
								<div class="col-md-12" align="center">
									<div class="row" align="center">									
										<div class="col-xs-12 text-center"  style="width:100%">
											<img src="<?php echo base_url().''.$Photograph='qr_code_profiles/'.$enroll.'profile.png'; ?>" alt="" class="rounded img-responsive" width="200">											
										</div>										
									</div> 
								</div>
							</div>
							<hr />
									
						</div>		
						<!-- End -->
					</div>

			</div>
		</div>
    </div>
    </div>

			
	
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
	
	address{font-size: 13px;}
	
	.main-xs-3
	{
		width: 26%;
		padding: 10px 10px 0 10px;
	}
	
	.main-xs-6
	{
		width: 48%;
		padding: 10px 10px 0 10px;
	}
</style>
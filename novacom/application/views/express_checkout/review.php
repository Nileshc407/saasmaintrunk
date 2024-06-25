<?php
$this->load->view('header/header');
$ci_object = &get_instance();
$ci_object->load->library('session');
$session_data = $this->session->userdata('shopping_cart');
$shopping_cart = $session_data['shopping_cart'];
?>
<?php  	echo'Company_Redeemtion_ratio---'.$Redemptionratio = $Company_Redemptionratio.'------------';
		//echo 'Customer_point_redeem----'.$_SESSION['Redeem_points'];
		echo'Redeemtion Amount---'.$Redemamt = $Redeem_amount;
?>
	<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>

	<section class="content-header">
		<h1>Checkout - Order Review</h1>
	</section>

	<!-- Main content -->
	<section class="content">
        <div class="row">
			
			<div class="col-md-12 clearfix" id="checkout">
				
				<div class="box">
				
					<ul class="nav nav-pills nav-justified">
						<li class="disabled"><a href="#"><i class="fa fa-map-marker"></i><br>Your Details</a></li>
						<li class="disabled"><a href="#"><i class="fa fa-shopping-cart"></i><br>Cart Details</a></li>
						<li class="disabled"><a href="#"><i class="fa fa-money"></i><br>Payment Method</a></li>						
						<li class="active"><a href="#"><i class="fa fa-eye"></i><br>Review Order</a></li>
						<li class="disabled"><a href="#"><i class="fa fa-check"></i><br>Order Confirmed</a></li>
					</ul>

					<div class="content">
						
						<div class="table-responsive">
							<table class="table" style="border: 1px solid #ddd;">
								<thead>
									<tr>
										<th>Product Name</th>
										<th>Price</th>
										<th>Quantity</th>
										<th>Sub-Total</th>
									</tr>
								</thead>
								
								<tbody>
								
									<?php
									foreach($shopping_cart['items'] as $cart_item) {
									?>
									
										<tr>
											<td><?php echo $cart_item['name']; ?></td>
											<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo number_format($cart_item['price'],2); ?></td>
											<td><?php echo $cart_item['qty']; ?></td>
											<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo round($cart_item['qty'] * $cart_item['price'],2); ?></td>
										</tr>
										
									<?php
									}
									?>
									
								</tbody>
							</table>

						</div>
						
					</div>
						
					<div class="content">
					
						<div class="col-md-4 column clearfix">
							<p><strong>Billing Information</strong></p>
							<p>
								<?php
								echo $cart['first_name'] . ' ' . $cart['last_name'] . '<br />' .
									$cart['email'] . '<br />'.
									$cart['phone_number'] . '<br />';
								?>
							</p>
						</div>
							
						 <div class="col-md-4 column clearfix">
							<p><strong>Shipping Information</strong></p>
							<p>
								<?php
								echo $cart['shipping_name'] . '<br />' .
									$cart['shipping_street'] . '<br />' .
									$cart['shipping_city'] . ', ' . $cart['shipping_state'] . '  ' . $cart['shipping_zip'] . '<br />' .
									$cart['shipping_country_name'];
								?>
							</p>
						</div> 
							
						<div class="col-md-4 column clearfix">
							<div class="table-responsive">
								<table class="table" style="border: 1px solid #ddd;">
									<tbody>
										<tr>
											<td><strong> Subtotal</strong></td>
											<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo $Subtotal = number_format($cart['shopping_cart']['subtotal'],2); ?></td>
										</tr>
										<tr>
											<td><strong>Redeem</strong></td>
											<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php //echo number_format($cart['shopping_cart']['shipping'],2); 
											echo $Redemamt; ?></td>
										</tr>
										<!--<tr>
											<td><strong>Handling</strong></td>
											<td><b><?php //echo $Symbol_of_currency; ?></b>&nbsp;<?php //echo number_format($cart['shopping_cart']['handling'],2); ?></td>
										</tr>
										<tr>
											<td><strong>Tax</strong></td>
											<td><b><?php //echo $Symbol_of_currency; ?></b>&nbsp;<?php //echo number_format($cart['shopping_cart']['tax'],2); ?></td>
										</tr>
										<tr>-->
											<td><strong>Grand Total</strong></td>
											<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php //echo $cart['shopping_cart']['grand_total'];
												echo $Subtotal - $Redemamt ; ?></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						
					</div>

					<div class="box-footer clearfix">
					
						<div class="pull-right">
							<a class="btn btn-template-main" href="<?php echo site_url('express_checkout/DoExpressCheckoutPayment'); ?>">
								Complete Order
							</a>
						</div>
						
					</div>
						
				</div>
			
			</div>
			
		</div>
	</section>
		
<?php $this->load->view('header/loader');?> 
<?php $this->load->view('header/footer');?>
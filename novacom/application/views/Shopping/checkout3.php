<?php
$this->load->view('header/header');
$cart_check = $this->cart->contents();

$ci_object = &get_instance();
$ci_object->load->model('shopping/Shopping_model');
?>

	<link href="<?php echo base_url()?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url()?>assets/shopping2/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
    <link href="<?php echo base_url()?>assets/shopping2/css/custom.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>

	<section class="content-header">
		<h1>Checkout - Order Review</h1>
	</section>

	<!-- Main content -->
	<section class="content">
        <div class="row">
		
			<?php if(empty($cart_check)) { ?>
				<div class="col-md-12">
					<p class="text-muted lead text-center">Your Shopping Cart is Empty. Please click on Continue shopping to Add items to Cart.</p>
					<p class="text-center">
						<a href="<?php echo base_url()?>index.php/Shopping/view_cart" class="btn btn-template-main">
							<i class="fa fa-chevron-left"></i>&nbsp;Continue shopping
						</a>
					</p>
				</div>
			<?php } ?>
			
			<?php if ($cart = $this->cart->contents()) { $grand_total = 0; $i = 1; $item_count = COUNT($cart); ?>
			
			<div class="col-md-9 clearfix" id="checkout">
				
				<div class="box">
					<form method="post" action="<?php echo base_url()?>index.php/Shopping/place_order">

						<ul class="nav nav-pills nav-justified">
							<li><a href="<?php echo base_url()?>index.php/Shopping/checkout"><i class="fa fa-map-marker"></i><br>Address</a></li>
							<li><a href="<?php echo base_url()?>index.php/Shopping/checkout2"><i class="fa fa-money"></i><br>Payment Method</a></li>
							<li class="active"><a href="#"><i class="fa fa-eye"></i><br>Checkout</a></li>
						</ul>

						<div class="content">
							
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th colspan="2">Product</th>
											<th>Quantity</th>
											<th>Unit price</th>
											<th colspan="2">Total</th>
										</tr>
									</thead>
									
									<tbody>
									
										<?php 
										$order_sub_total = 0; $shipping_cost = 99; $tax = 0;
										foreach ($cart as $item) 
										{									
											$Product_details = $ci_object->Shopping_model->get_products_details($item['id']);
											?>
									
											<tr>
												<td>
													<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $Product_details->serial; ?>">
														<img src="<?php echo $this->config->item('base_url2').$Product_details->picture; ?>" alt="<?php echo $Product_details->name; ?>">
													</a>
												</td>
												
												<td>
													<a href="<?php echo base_url()?>index.php/Shopping/product_details/?product_id=<?php echo $Product_details->serial; ?>"><?php echo $Product_details->name; ?></a>
												</td>
												
												<td class="text-center"><?php echo $item['qty']; ?></td>
												
												<td>$<?php echo number_format((float)$Product_details->price, 2); ?></td>
																								
												<td>
													<?php
													$grand_total = $grand_total + $item['subtotal'];
													echo "$".number_format((float)$item['subtotal'], 2);
													
													echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
													echo form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']);
													echo form_hidden('cart[' . $item['id'] . '][name]', $Product_details->name);
													echo form_hidden('cart[' . $item['id'] . '][price]', $Product_details->price);										
													
													$order_sub_total = $order_sub_total + $item['subtotal'];
													
													?>
												</td>
											</tr>
										
										<?php } ?>
										
									</tbody>
									<tfoot>
										<tr>
											<th colspan="5">Total</th>
											<th colspan="2">$<?php echo number_format((float)$grand_total, 2); ?></th>
										</tr>
									</tfoot>
								</table>

							</div>
							
						</div>

						<div class="box-footer">
							<div class="pull-left">
								<a href="<?php echo base_url()?>index.php/Shopping/checkout2" class="btn btn-default">
									<i class="fa fa-chevron-left"></i>&nbsp;Back to Payment Method
								</a>
							</div>
							<div class="pull-right">
								<button type="submit" class="btn btn-template-main">
									Place an order&nbsp;<i class="fa fa-chevron-right"></i>
								</button>
								
								<input type="hidden" name="firstname" value="<?php echo $firstname; ?>" />
								<input type="hidden" name="lastname" value="<?php echo $lastname; ?>" />
								<input type="hidden" name="address" value="<?php echo $address; ?>" />
								<input type="hidden" name="city" value="<?php echo $city; ?>" />
								<input type="hidden" name="zip" value="<?php echo $zip; ?>" />
								<input type="hidden" name="state" value="<?php echo $state; ?>" />
								<input type="hidden" name="country" value="<?php echo $country; ?>" />
								<input type="hidden" name="phone" value="<?php echo $phone; ?>" />
								<input type="hidden" name="email" value="<?php echo $email; ?>" />
								<input type="hidden" name="payment_method" value="<?php echo $payment_method; ?>" />
								<input type="hidden" name="Enrollment_id" value="<?php echo $Enrollment_id; ?>" />
								
								<?php $order_total = $order_sub_total + $shipping_cost + $tax; ?>
								<input type="hidden" name="Order_total" value="<?php echo number_format((float)$order_total, 2); ?>" />
							</div>
						</div>
					</form>
				</div>
			
			</div>
			
			<div class="col-md-3">
			
				<div class="box" id="order-summary">
					<div class="box-header">
						<h3>Order summary</h3>
					</div>
					<p class="text-muted">Shipping and additional costs are calculated based on the values you have entered.</p>

					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<td>Order subtotal</td>
									<th>$<?php echo number_format((float)$order_sub_total, 2); ?></th>
								</tr>
								<tr>
									<td>Shipping and handling</td>
									<th>$<?php echo number_format((float)$shipping_cost, 2); ?></th>
								</tr>
								<tr>
									<td>Tax</td>
									<th>$<?php echo number_format((float)$tax, 2); ?></th>
								</tr>
								<tr class="total">
									<td>Total</td>
									<th>
										$<?php echo number_format((float)$order_total, 2); ?>
									</th>
								</tr>
							</tbody>
						</table>
					</div>

				</div>

			</div>
			
			<?php } ?>
			
		</div>
	</section>
		
<?php $this->load->view('header/loader');?> 
<?php $this->load->view('header/footer');?>
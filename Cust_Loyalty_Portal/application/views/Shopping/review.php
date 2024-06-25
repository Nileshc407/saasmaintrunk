<?php

$this->load->view('header/header');
$ci_object = &get_instance();
$ci_object->load->library('session');
$session_data = $this->session->userdata('shopping_cart');
$shopping_cart = $session_data['shopping_cart'];

$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];

// var_dump($session_data['shopping_cart']);
?>

<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>

<section class="content-header">
        <h1>Checkout - Order Review</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">

        <div class="col-md-12 clearfix" id="checkout">
            
            <?php
            if(@$this->session->flashdata('error_code'))
            {
            ?>
                <script>
                    var Title = "Application Information";
                    var msg = '<?php echo $this->session->flashdata('error_code'); ?>';
                    runjs(Title,msg);
                </script>
            <?php
            }
            ?>

            <div class="box">

                <ul class="nav nav-pills nav-justified">
                                     						
                    <li class="active"><a href="#"><i class="fa fa-eye"></i> &nbsp; Review Order</a></li>
                </ul>

                <div class="content">

                    <div class="table-responsive">
                        <table class="table" style="border: 1px solid #ddd;">
                            <thead>
								<tr>
									<th>Product Name</th>
									<th>Size</th>
									<th>Price</th>
									<th>Quantity</th>
									 <th>Sub-Total</th>
								</tr>
                            </thead>

                            <tbody>

                                    <?php
									 foreach($this->cart->contents() as $cart_item) {
									?>

                                            <tr>
                                                    <td><?php echo $cart_item['name']; ?>
													</td>
                                                    <td>
												<?php 
													if($cart_item['options']['Item_size'] == 1)
													{
													  $size = "Small";
													}
													elseif($cart_item['options']['Item_size'] == 2)
													{	
														$size = "Medium";
													}
													elseif($cart_item['options']['Item_size'] == 3)
													{
														$size = "Large";
													}
													elseif($cart_item['options']['Item_size'] == 4)
													{
														$size = "Extra Large";
													}
													else
													{
														$size = "-";
													}
													echo $size;
												?>
											</td>
												<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo number_format($cart_item['price'],2); ?></td>
												<td><?php echo $cart_item['qty']; ?></td>
												<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo number_format($cart_item['qty'] * $cart_item['price'],2); ?></td>
                                            </tr>

                                    <?php
                                    }
                                    ?>

                            </tbody>
                        </table>

                    </div>

                </div>

                        <div class="content">


                                 <div class="col-md-8 column clearfix">
                                        <p><strong>Shipping Information</strong></p>
                                        <p>
                                            <?php
                                            if($New_shipping_details != "")
                                            {
                                                echo $New_shipping_details['firstname1'] . ' ' . $New_shipping_details['lastname1'] . '<br />' .
                                                     $New_shipping_details['address1'] . '<br />' .
                                                    $New_shipping_details['zip1'] . ', ' .   $New_shipping_details['phone1'] . "<br />" .
                                                     $New_shipping_details['email1']; 
                                            }
                                            else
                                            {
                                                echo $Enroll_details->First_name . ' ' . $Enroll_details->Last_name . '<br />' .
                                                     $Enroll_details->Current_address . '<br />' .
                                                     $Enroll_details->Zipcode . '<br />' .
                                                     $Enroll_details->Phone_no . "<br />" .
                                                     $Enroll_details->User_email_id; 
                                                    //$cart['shipping_country_name'];
                                            }
											$_SESSION["Redeem_amount"]=$Redeem_amount;
											$_SESSION["Final_Grand_total"]=$_SESSION['Grand_total']-$_SESSION["Redeem_amount"];
                                            ?>
                                        </p>
                                </div> 

                                <div class="col-md-4 column clearfix">
									<div class="table-responsive">
										<table class="table" style="border: 1px solid #ddd;">
											<tbody>
												<tr>
													<td><strong> Subtotal</strong></td>
													<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo number_format($subtotal,2); ?></td>
												</tr>
												<tr>
													<td><strong> Total Shipping Cost</strong></td>
													<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo number_format($_SESSION['Total_Shipping_Cost'],2); ?></td>
												</tr>
												<tr>
													<td><strong>Redeemed Amount</strong></td>
													<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php echo number_format($_SESSION["Redeem_amount"],2); ?></td>
												</tr>
												<tr>
													<td><strong>Grand Total</strong></td>
													<td><b><?php echo $Symbol_of_currency; ?></b>&nbsp;<?php  echo number_format($_SESSION['Final_Grand_total'],2); ?></td>
												</tr>
											</tbody>
										</table>
									</div>
                                </div>

                        </div>

						<hr>
						<div class="box-footer" style="padding:10px;margin-top:10px;background: #fff;border-top:none">
							<div class="row" >
								<div class="col-md-6 col-xs-6">	
									<a href="<?php echo base_url()?>index.php/Shopping/checkout2" class="btn btn-default">
									<i class="fa fa-backward" aria-hidden="true"></i>&nbsp; Payment </a>
								</div>
								<div class="col-md-6 col-xs-6" align="right" >	


										 <?php if($PaymentMethod == 3) { ?>                                    
                                        <a class="btn btn-template-main" href="javascript:void(0);" onclick="place_order(1);">
                                                Place Order
                                        </a>
                                    
                                    <?php } else { ?>                                    
                                        <a class="btn btn-template-main" href="javascript:void(0);" onclick="place_order(2);">
                                                Place Order
                                        </a>
                                    
                                    <?php } ?> 
								
													
										
								</div>
							</div>
							
						</div>

                </div>

            </div>

        </div>
</section>
		
<?php $this->load->view('header/loader');?> 
<?php $this->load->view('header/footer');?>
<script>
function place_order(flag)
{
	show_loader();
	if(flag==1)
	{
		window.location='<?php echo site_url('express_checkout/DoExpressCheckoutPayment'); ?>';
	}
	else
	{
		window.location='<?php echo site_url('shopping/CheckoutPayment'); ?>';
	}
}
</script>

<style>
<?php if($smartphone_flag == 1) { ?>


@media only screen and (min-width: 320px) {
  #checkout .nav li {
    height: 8%; 
	}
}
@media only screen and (min-width: 375px) {
   #checkout .nav li {
    height: 8%; 
	}
}
@media only screen and (min-width: 425px) {
   #checkout .nav li {
    height: 8%; 
	}
}
@media only screen and (min-width: 768px) {
  #checkout .nav li {
    height: 9%; 
	}
}
@media only screen and (min-width: 1024px) {
   #checkout .nav li {
    height: 10%; 
	}
}
@media only screen and (min-width: 1440px) {
   #checkout .nav li {
    height: 10%; 
	}
}

@media only screen and (min-width: 368px){
	#checkout .nav li {
    height: 14%;
	}
}
<?php } ?>
</style>
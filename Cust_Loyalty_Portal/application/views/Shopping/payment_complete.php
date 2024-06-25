<?php
$this->load->view('header/header');
$ci_object = &get_instance();
$ci_object->load->library('session');
$session_data = $this->session->userdata('shopping_cart');
$shopping_cart = $session_data['shopping_cart'];
?>

	<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>

	<section class="content-header">
		<h1>Order Confirmed</h1>
	</section>

	<!-- Main content -->
	<section class="content">
        <div class="row">
			
			<div class="col-md-12 clearfix text-center">
				
				<div class="box">
				
					<ul class="nav nav-pills nav-justified">
						<!--<li class="disabled"><a href="#"><i class="fa fa-map-marker"></i><br>Your Details</a></li>
						<li class="disabled"><a href="#"><i class="fa fa-shopping-cart"></i><br>Cart Details</a></li>
						<li class="disabled"><a href="#"><i class="fa fa-money"></i><br>Payment Method</a></li>	
                                                <li class="disabled"><a href="#"><i class="fa fa-credit-card"></i><br>Card Details</a></li>
						<li class="disabled"><a href="#"><i class="fa fa-eye"></i><br>Review Order</a></li>-->
						<li class="active"><a href="#"><i class="fa fa-check"></i><br>Order Confirmed</a></li>
					</ul>

					<div class="content">
						
						<h1 class="text-success text-center">
							<i class="glyphicon glyphicon-ok"></i>
						</h1>
						
						<!--<h4 class="text-center">
							Thank you for your Purchase.
						</h4>
						
						<p>A Confirmation Email has been sent to <b><?php //echo $Enroll_details->User_email_id; ?></b></p>
						
						<?php /* <p><b>Transaction ID : #<?php echo $transaction_id; ?></b></p> */ ?>
						
						<a href="<?php echo base_url()?>index.php/Shopping/" class="btn btn-template-main">
							Continue Shopping
						</a> -->
						
					<script>
						var email='<?php echo $Enroll_details->User_email_id; ?>';
						BootstrapDialog.show({
							closable: false,
							title: 'Application Information',
							message: 'Thank you for your Purchase.  A Confirmation Email has been sent to '+email+'. ',
							buttons: [{
								label: 'OK',
								action: function(dialog) {
									window.location='<?php echo base_url()?>index.php/Shopping';
								}
							}]
						});
						runjs(Title,msg);
						
					</script>
						
					</div>
						
				</div>
			
			</div>
			
		</div>
	</section>

<?php $this->load->view('header/footer');?>
<?php $this->load->view('header/header'); ?>

	<link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>

	<section class="content-header">
		<h1>Checkout - Order Cancelled</h1>
	</section>

	<!-- Main content -->
	<section class="content">
        <div class="row">
		
			<div class="col-md-12">
				<p class="text-muted lead text-center">The payment has not been processed at this point because we cancelled the payment.</p>
				<p class="text-center">
					<a href="<?php echo base_url()?>index.php/Shopping/" class="btn btn-template-main">
						<i class="fa fa-chevron-left"></i>&nbsp;Shopping Cart
					</a>
				</p>
			</div>
			
		</div>
	</section>
		
<?php $this->load->view('header/footer');?>
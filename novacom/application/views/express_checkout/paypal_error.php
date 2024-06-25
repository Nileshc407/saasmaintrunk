<?php $this->load->view('header/header'); ?>
	
		
<section class="content-header">
	<h1>Checkout - PayPal Error</h1>
</section>		
		
<!-- Main content -->
<section class="content">
	<div id="content">
		<div class="row">
		
			<div class="col-md-12 clearfix text-center" id="checkout">
				
				<div class="well alert-danger" id="paypal_errors">
					<?php
					foreach($errors as $error)
					{
						echo '<p>';
						echo '<strong>Error Code:</strong> ' . $error[0]['L_ERRORCODE'];
						echo '<br /><strong>Error Message:</strong> ' . $error[0]['L_LONGMESSAGE'];
						echo '</p>';
					}
					?>
				</div>
				
				<a href="<?php echo base_url()?>index.php/Shopping/checkout" class="btn btn-default">
					<i class="fa fa-chevron-left"></i>&nbsp;Start Over
				</a>
			
			</div>
			
		</div>
	</div>
</section>

<?php $this->load->view('header/footer');?>
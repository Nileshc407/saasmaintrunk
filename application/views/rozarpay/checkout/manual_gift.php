<?php $this->load->view('header/header'); ?>

<div class="content-i">
    <div class="content-box" style="min-height: 550px !IMPORTANT;">
        <div class="row">
            <div class="col-sm-12">
                <div class="element-wrapper">
                    <h6 class="element-header">TopUp E-Gifting Catalogue Account</h6>
                    <div class="element-box">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									 <span>TopUp Amount : <b><?php echo $currency.' '.number_format($amount,2); ?></b></span>
								</div>
								<div class="form-group">
									<span>On Successful Payment ,</span><br/>
									 <span>Updated Balance : <b><?php echo $Symbol_currency.' '.number_format($New_balance,2); ?></b></span>
								</div>						
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<span>Equivalent to (approx)  : <b><?php echo $Symbol_currency.' '.$Local_currency_amount; ?></b></span> 
								</div>	
								<div class="form-group">
									<br/>
									<span>Equivalent Points  : <b><?php echo $New_equivalent_points; ?></b></span> 
								</div>							
							</div>
						</div>
					</div>
                    </div>
                </div>
            </div>
			<center><button id="rzp-button1" class="btn btn-primary">PROCEED TO PAY</button></center><br><br><br><br><br><br>
        </div>
    </div>	

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<form name='razorpayform' action="verify_gift.php" method="POST">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
</form>
<?php $this->load->view('header/footer'); ?>
<script>
var options = <?php echo $json?>;
options.handler = function (response){
    document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
    document.getElementById('razorpay_signature').value = response.razorpay_signature;
    // document.razorpayform.submit();
};
options.theme.image_padding = false;
options.modal = {
    ondismiss: function() {
        console.log("This code runs when the popup is closed");
    },
    escape: true,
    backdropclose: false
};
var rzp = new Razorpay(options);
document.getElementById('rzp-button1').onclick = function(e){
    rzp.open();
    e.preventDefault();
}
</script>
<style>
.button {
  background-color: #1b55e2; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}
</style>
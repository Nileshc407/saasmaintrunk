<?php
$this->load->view('header/header');
$cart_check = $this->cart->contents();
$session_data = $this->session->userdata('cust_logged_in');
$smartphone_flag = $session_data['smartphone_flag'];
if($Enroll_details->Payment_card_no != "")
{
    $Original_Payment_card_no = $Enroll_details->Payment_card_no;
    $len = strlen($Enroll_details->Payment_card_no);
    if($len==16)
    {
        $result = substr($Enroll_details->Payment_card_no, 0, 12);
    }
    else if($len >  16)
    {
        $result = substr($Enroll_details->Payment_card_no, 0, 16);
    }
    else
    {
        $result = substr($Enroll_details->Payment_card_no, 0, 8);
    }

    $converted = preg_replace("/[\S]/", "X", $result);
    if($len==16)
    {
        $remaining = substr($Enroll_details->Payment_card_no,12,$len);
    }
    else if($len >  16)
    {
        $remaining = substr($Enroll_details->Payment_card_no,16,$len);
    }
    else
    {
        $remaining = substr($Enroll_details->Payment_card_no,8,$len);
    }
    
    $Card_no = $converted.''.$remaining;
    //$Card_no = $Enroll_details->Payment_card_no;
}
else
{
    $Card_no = "";
}
?>
	
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/animate.css" rel="stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/style.default.css" rel="stylesheet" id="theme-stylesheet">
    <link href="<?php echo $this->config->item('base_url2')?>assets/shopping2/css/custom.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,500,700,800' rel='stylesheet' type='text/css'>
	
		
<section class="content-header">
	<h1>Checkout - Card Details</h1>
</section>		
		
<!-- Main content -->
<section class="content">
	<div id="content">
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
			
			<?php if ($cart = $this->cart->contents()) { ?>
		
			<div class="col-md-12 clearfix" id="checkout">
				
				<div class="box">
				
					<form method="post" action="<?php echo base_url()?>index.php/Shopping/UpdatepaymentInfo">

						<ul class="nav nav-pills nav-justified">
							<!--<li><a href="<?php echo base_url()?>index.php/Shopping/checkout"> <i class="fa fa-map-marker"></i><br>Shipping Details</a></li>
							<li><a href="<?php echo base_url()?>index.php/Shopping/checkout_cart_details"><i class="fa fa-shopping-cart"></i><br>Cart Details</a></li>
							<li><a href="<?php echo base_url()?>index.php/Shopping/checkout2"><i class="fa fa-money"></i><br>Payment Method</a></li>-->
							<li class="active"><a href="#"><i class="fa fa-credit-card"></i>&nbsp; Card Details</a></li>
							
							<!--<li class="disabled"><a href="#"><i class="fa fa-eye"></i><br>Review Order</a></li>
							<li class="disabled"><a href="#"><i class="fa fa-check"></i><br>Order Confirmed</a></li>-->
						</ul>

						<div class="content">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label for="firstname">Name on Card</label>
										<input type="text" class="form-control" name="Payment_card_name" id="Payment_card_name" value="<?php if($Enroll_details->Payment_card_name !="") { echo $Enroll_details->Payment_card_name; }?>" onkeyup="this.value=this.value.replace(/[^a-z ]/g,'');">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group has-feedback">
                                        <label for="lastname">Card No.</label> 
                                            <?php /* <div class="input-group">										
                                            <input type="text" class="form-control" readonly name="Payment_card_no" id="Payment_card_no" value="<?php echo $Card_no; ?>">
                                                                            
                                                <?php if($Card_no != ""){ ?>
                                                <span class="input-group-addon" id="EditChkbx">
                                                <input type="checkbox" id="Edit_card_no" onclick="return change_card_no();">
                                            </span>
																	<?php } ?>
														</div> */ ?>
							<?php   
							if($Card_no != "")
							{ ?>                                       
                            <input type="text" class="form-control"  name="Payment_card_no" id="Payment_card_no" value="<?php echo $Card_no; ?>" readonly onkeyup="this.value=this.value.replace(/\D/g,'')">
							<?php
							}
							else 
							{ ?>
                            <input type="text" class="form-control"  name="Payment_card_no" id="Payment_card_no" onkeyup="this.value=this.value.replace(/\D/g,'')" value="" > 
					<?php   } ?>
                            <?php if($Card_no != ""){ ?>
							<a href="javascript:void(0);" id="EditCard" onclick="return change_card_no();" style="text-decoration: underline;">Edit</a>  <?php } ?>
							<?php if($Card_no ==""){ ?>
							
							<a href="javascript:void(0);" id="SaveCard122" onclick="save_card_no();" style="text-decoration: underline;">Save</a> &nbsp; | &nbsp;
                            
							<a href="javascript:void(0);" onclick="save_cancel1();" style="text-decoration: underline;">Cancel</a>
                              <?php } ?>   
							
							<a href="javascript:void(0);" id="SaveCard" onclick="save_card_no();" style="text-decoration: underline;display: none;">Save</a>&nbsp; | &nbsp;
                            
							<a href="javascript:void(0);" id="SaveCard1" onclick="save_cancel();" style="text-decoration: underline; display: none;">Cancel</a>
                                                                              
                            <div class="help-block" style="float: right;"></div>
								</div>
							</div>
						</div>
							<!-- /.row -->

							<div class="row">
								<div class="col-sm-6 col-md-3">
									<div class="form-group">
										<label for="city">CVV</label> 
										<input type="text" class="form-control" name="Card_CVV" id="Card_CVV" value="<?php if($Enroll_details->Card_CVV !="") { echo $Enroll_details->Card_CVV; } ?>" onkeyup="this.value=this.value.replace(/\D/g,'')">
									</div>
								</div>
								<div class="col-sm-6 col-md-3"> 
									<div class="form-group">
										<label for="zip">Expiry Month</label>
										<input type="text" class="form-control" placeholder="MM" name="card_ending_month" id="card_ending_month" value="<?php if($Enroll_details->Card_end_month != "") { echo $Enroll_details->Card_end_month; } ?>" onkeyup="this.value=this.value.replace(/\D/g,'')">
									</div>
								</div> 
								<div class="col-sm-6 col-md-3">
									<div class="form-group">
										<label for="state">Expiry Year</label>
										<input type="text" class="form-control" placeholder="YY" name="card_ending_year" id="card_ending_year" value="<?php if($Enroll_details->Card_end_year != "") { echo $Enroll_details->Card_end_year; } ?>" onkeyup="this.value=this.value.replace(/\D/g,'')">
									</div>
								</div>

							</div>
							<!-- /.row -->
						</div>

						<!--<div class="box-footer">
							<div class="pull-left">
								
                                                                
                                        <a href="<?php //echo base_url()?>index.php/Shopping/checkout2" class="btn btn-default">
									<i class="fa fa-chevron-left"></i>&nbsp;Back to Payment Method
								</a>
							</div>
							<div class="pull-right">
                                                            
                                <button type="submit" class="btn btn-template-main" id="Review">
                            Continue to Review Order &nbsp;<i class="fa fa-chevron-right"></i>
                                                            </button> 
                                                            
							</div>
						</div>-->
						
						
						
						<hr>
						<div class="box-footer" style="padding:0px;margin-top:10px;background: #fff;border-top:none">
							<div class="row" >
								<div class="col-md-6 col-xs-6">	
									<a href="<?php echo base_url()?>index.php/Shopping/checkout2" class="btn btn-default">
									<i class="fa fa-backward" aria-hidden="true"></i>&nbsp; Payment </a>
								</div>
								<div class="col-md-6 col-xs-6" align="right" >							
								
									<button type="submit" class="btn btn-template-main" id="Review">
									Review Order &nbsp;<i class="fa fa-forward" aria-hidden="true"></i>
                                                            </button> 				
										
								</div>
							</div>
							
						</div>
						
						
						
						
					</form>
				</div>
			
			</div>
                    
			<?php } ?>
			
		</div>
	</div>
</section>

<?php $this->load->view('header/footer');?>

<script>
function change_card_no()
{
    $.ajax(
    {
        type: "POST",
        data: { Payment_card_no:"" },
        url: "<?php echo base_url()?>index.php/Shopping/GetCardNo",
        dataType: "json", 
        success: function(json)
        {
            $('#Payment_card_no').attr("readonly",false);
            $('#Payment_card_no').val(json['Payment_card_no']);
            $('#EditCard').hide();
            $('#SaveCard').show();
            $('#SaveCard1').show();
        }
    });
}

function save_card_no()
{
    var Paymentcardno = $('#Payment_card_no').val();
	
    $.ajax(
    {
        type: "POST",
        data: { Payment_card_no:Paymentcardno },
        url: "<?php echo base_url() ?>index.php/Shopping/UpdateCardNo",
        dataType: "json", 
        success: function(json)
        {
            if(json['card_update_flag'] == 1)
            {
                var msg1 = 'Card Number Updated Successfuly..!!';
                $('.help-block').show();
                $('.help-block').css("color","green");
                $('.help-block').html(msg1);
                setTimeout(function(){ $('.help-block').hide(); }, 3000);
                $('#Payment_card_no').val(json['Payment_card_no']);
                $('#Payment_card_no').attr("readonly",true);
                $('#EditCard').show();
                $('#SaveCard').hide();
            }
            else
            {
                var msg1 = 'Error Updating Card Number. Please try again..!!';
                $('.help-block').show();
                $('.help-block').css("color","red");
                $('.help-block').html(msg1);
                setTimeout(function(){ $('.help-block').hide(); }, 3000);
                $('#Payment_card_no').val(json['Payment_card_no']);
                $('#Payment_card_no').attr("readonly",true);
                $('#EditCard').show();
                $('#SaveCard').hide();
            }
        }
    });
}

function save_cancel()
{
    var Card_no = '<?php echo $Card_no; ?>';
    $('#Payment_card_no').attr("readonly",true);
    $('#Payment_card_no').val(Card_no);
    $('#EditCard').show();
    $('#SaveCard').hide();
}


$('#Review').click(function()
{
   if($("#Payment_card_name").val() == "" ||  $("#Payment_card_no").val() == "" || $("#Card_CVV").val() == "" || $("#card_ending_month").val() == "" || $("#card_ending_year").val() == "") 
	{
		var Title = "Application Information";
		var msg = 'Please Fill Card Details';
		runjs(Title,msg);
		return false;
	}     
});
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


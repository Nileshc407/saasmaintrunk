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
	// echo"--Ecommerce_flag---".$Ecommerce_flag."--<br>"; 
		$cart_check = $this->cart->contents();
			// var_dump($cart_check);
			if(!empty($cart_check)) {
				$cart = $this->cart->contents(); 
				$grand_total = 0; 
				$item_count = COUNT($cart); 
			}
		
		if($item_count <= 0 ) {
			$item_count=0;
		}
		else {
			$item_count = $item_count;
		}				
		
		$wishlist = $this->wishlist->get_content();
		if(!empty($wishlist)) {
			
			$wishlist = $this->wishlist->get_content();
			$item_count2 = COUNT($wishlist); 
			
			foreach ($wishlist as $item2) {
				
				$Product_details2 = $this->Shopping_model->get_products_details($item2['id']);
			}
		}		
		if($item_count2 <= 0 ) {
			$item_count2=0;
		}
		else {
			$item_count2 = $item_count2;
		}
		// $cart_check="";
		// echo"--item_count2---".$item_count2."--<br>"; id=""
		
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

    <!-- Start Pricing Table Section -->
    <div id="application_theme" class="section pricing-section" style="min-height:500px;">
		<div class="container">
			<div class="section-header">          
				<p><a href="<?php echo base_url(); ?>index.php/Shopping/checkout2" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
				<p id="Extra_large_font">Card Details</p>
			</div>

        <div class="row pricing-tables">
          <div class="col-md-4 col-sm-6 col-xs-12">
            
          </div>
			
          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
		  
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head"> 
                <?php if ($cart = $this->cart->contents()) { ?>

                <form method="post" action="<?php echo base_url()?>index.php/Shopping/UpdatepaymentInfo">
                        <div class="pricing-details">
                                <ul>
                                    <li id="Medium_font">Name on Card  <div id="Payment_card_name_div" style="float:right;"></div>								
                                      <input type="text" name="Payment_card_name" id="Payment_card_name" value="<?php if($Enroll_details->Payment_card_name !="") { echo $Enroll_details->Payment_card_name; }?>" >

                                    </li>
                                    <li id="Medium_font">Card No <div id="Payment_card_no_div" style="float: right;"></div>
                                        <strong>
                                            <?php  if($Card_no != "") { ?>                                       
                                                <input type="text"   name="Payment_card_no" id="Payment_card_no"  value="<?php echo $Card_no; ?>" readonly onkeyup="this.value=this.value.replace(/\D/g,'')">
                                            <?php } else { ?>
                                                <input type="text"  name="Payment_card_no" id="Payment_card_no" onkeyup="this.value=this.value.replace(/\D/g,'')" value="" > 
                                            <?php   } ?>
                                                <?php if($Card_no != ""){ ?>
                                            <a href="javascript:void(0);" id="EditCard" onclick="return change_card_no();" style="text-decoration: underline;"><font id="Small_font">Edit</font></a>  <?php } ?>
                                              <?php if($Card_no ==""){ ?>
                                            <a href="javascript:void(0);" id="SaveCard122" onclick="save_card_no();" style="text-decoration: underline;"><font id="Small_font">Save</font></a> &nbsp;  &nbsp;
                                            <a href="javascript:void(0);" onclick="save_cancel1();" style="text-decoration: underline;"><font id="Small_font">Cancel</font></a>
                                                <?php } ?>  
                                            <a href="javascript:void(0);" id="SaveCard" onclick="save_card_no();" style="text-decoration: underline;display: none;"><font id="Small_font">Save</font></a>&nbsp;  &nbsp;
                                            <a href="javascript:void(0);" id="SaveCard1" onclick="save_cancel();" style="text-decoration: underline; display: none;"><font id="Small_font">Cancel</font></a> 
                                        </strong> 
                                    </li>
                                    <li id="Medium_font">CVV <div id="Card_CVV_div" style="float:right;"></div>
                                        <input type="text" name="Card_CVV" id="Card_CVV" value="<?php if($Enroll_details->Card_CVV !="") { echo $Enroll_details->Card_CVV; } ?>" onkeyup="this.value=this.value.replace(/\D/g,'')">
                                    </li>
                                    <li id="Medium_font">Expiry Month <div id="card_ending_month_div" style="float:right;"></div>
                                        <input type="text" placeholder="MM" name="card_ending_month" id="card_ending_month" value="<?php if($Enroll_details->Card_end_month != "") { echo $Enroll_details->Card_end_month; } ?>" onkeyup="this.value=this.value.replace(/\D/g,'')">
                                    </li>
                                    <li id="Medium_font">Expiry Year <div id="card_ending_year_div" style="float:right;"></div>
                                        <input type="text" placeholder="YY" name="card_ending_year" id="card_ending_year" value="<?php if($Enroll_details->Card_end_year != "") { echo $Enroll_details->Card_end_year; } ?>" onkeyup="this.value=this.value.replace(/\D/g,'')">
                                    </li>
                                </ul>
                        </div>
                        <div class="pricing-details">
                            <div class="row">
                                <div class="col-xs-4 main-xs-6 text-left" style="width: 50%;">
                                    <button type="button" id="button1" class="b-items__item__add-to-cart" onclick="return Go_to_payment();" >Back</button>
                                </div>
                                <div class="col-xs-4 main-xs-6 text-right" style="width: 50%;">
                                    <button type="submit"   class="b-items__item__add-to-cart" id="Review" >
                                        Proceed
                                    </button>
                                </div>
                            </div>
                        </div>

                </form>
                 <?php } ?>				 
                 <?php if(empty($cart_check)) { ?>				 
                    <div class="pricing-details">
                        <div class="row">
                                <div class="col-md-12">			
                                    <address>
                                        <button type="button" id="Review" class="b-items__item__add-to-cart" onclick="return Go_to_Shopping();">Menu</button>
                                    </address>
                                </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
	 </div>
        <div class="col-md-4 col-sm-6 col-xs-12">           
        </div>

        </div>
      </div>
    </div>
    <!-- End Pricing Table Section -->
	
	
    
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
<script>
    
    $('#Review').click(function()
    {
        setTimeout(function() 
        {
                $('#myModal').modal('show');	
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
        },2000);
    });
    
    
    function Go_to_payment()
    { 
        setTimeout(function() 
        {
                $('#myModal').modal('show');	
                window.location.href='<?php echo base_url()?>index.php/Shopping/checkout2';
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
            
        },2000);
    }
    function Go_to_Shopping()
    { 
        setTimeout(function() 
        {
                $('#myModal').modal('show');
                window.location.href='<?php echo base_url(); ?>index.php/Shopping';
        }, 0);
        setTimeout(function() 
        { 
            $('#myModal').modal('hide');
            
        },2000);
    }
    
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
            $('input[name=Payment_card_no]').attr("readonly",false);
            $('input[name=Payment_card_no]').val(json['Payment_card_no']);
            $('#EditCard').hide();
            $('#SaveCard').show();
            $('#SaveCard1').show();
        }
    });
}

function save_card_no()
{
    var Paymentcardno = $('input[name=Payment_card_no]').val();
	
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
               // var msg1 = 'Card Number Updated Successfuly..!!';
               
                /* $('.help-block').show();
                $('.help-block').css("color","<?php echo $Small_font_details[0]['Small_font_color']; ?>");
                $('.help-block').css("font-family","<?php echo $Small_font_details[0]['Small_font_family']; ?>");
                $('.help-block').css("font-size","<?php echo $Small_font_details[0]['Small_font_size']; ?>");
                $('.help-block').html(msg1); */
              
                var msg1 = 'Card Number Updated Successfuly..!!';
                $('#Payment_card_no_div').show();
				$('#Payment_card_no_div').css("color","<?php echo $Small_font_details[0]['Small_font_color']; ?>");
				$('#Payment_card_no_div').css("font-family","<?php echo $Small_font_details[0]['Small_font_family']; ?>");
				$('#Payment_card_no_div').css("font-size","<?php echo $Small_font_details[0]['Small_font_size']; ?>");
				$('#Payment_card_no_div').html(msg1);
				setTimeout(function(){ $('#Payment_card_no_div').hide(); }, 3000);
				$( "#Payment_card_no").focus();
                
                setTimeout(function(){ $('.help-block').hide(); }, 3000);
                $('input[name=Payment_card_no]').val(json['Payment_card_no']);
                $('input[name=Payment_card_no]').attr("readonly",true);
                $('#EditCard').show();
                $('#SaveCard').hide();
                $('#SaveCard1').hide();
            }
            else
            {
                /* var msg1 = 'Error Updating Card Number. Please try again..!!';
                $('.help-block').show();
                $('.help-block').css("color","red");
                $('.help-block').html(msg1);
                setTimeout(function(){ $('.help-block').hide(); }, 3000); */
    
                var msg1 = 'Error Updating Card Number. Please try again..!!';
                $('#Payment_card_no_div').show();
		$('#Payment_card_no_div').css("color","red");
		$('#Payment_card_no_div').html(msg1);
		setTimeout(function(){ $('#Payment_card_no_div').hide(); }, 3000);
		$( "#Payment_card_no").focus();
                
                $('input[name=Payment_card_no]').val(json['Payment_card_no']);
                $('input[name=Payment_card_no]').attr("readonly",true);
                $('#EditCard').show();
                $('#SaveCard1').show();
                $('#SaveCard').hide();
            }
        }
    });
}

function save_cancel()
{
    var Card_no = '<?php echo $Card_no; ?>';
    $('input[name=Payment_card_no]').attr("readonly",true);
    $('input[name=Payment_card_no]').val(Card_no);
    $('#EditCard').show();
    $('#SaveCard').hide();
}


$('#Review').click(function()
{
	
	if($("#Payment_card_name").val() == "" )
	{
		var msg = 'Please enter card on name';
		$('#Payment_card_name_div').show();
		$('#Payment_card_name_div').css("color","red");
		$('#Payment_card_name_div').html(msg);
		setTimeout(function(){ $('#Payment_card_name_div').hide(); }, 3000);
		$( "#Payment_card_name").focus();
		return false;
	}
        if($("#Payment_card_no").val() == "" )
	{
		var msg = 'Please enter card number';
		$('#Payment_card_no_div').show();
		$('#Payment_card_no_div').css("color","red");
		$('#Payment_card_no_div').html(msg);
		setTimeout(function(){ $('#Payment_card_no_div').hide(); }, 3000);
		$( "#Payment_card_no").focus();
		return false;
	}
        if($("#Card_CVV").val() == "" )
	{
		var msg = 'Please enter card CVV Number';
		$('#Card_CVV_div').show();
		$('#Card_CVV_div').css("color","red");
		$('#Card_CVV_div').html(msg);
		setTimeout(function(){ $('#Card_CVV_div').hide(); }, 3000);
		$( "#Card_CVV").focus();
		return false;
	}
        if($("#card_ending_month").val() == "" )
	{
		var msg = 'Please enter card expairy Month';
		$('#card_ending_month_div').show();
		$('#card_ending_month_div').css("color","red");
		$('#card_ending_month_div').html(msg);
		setTimeout(function(){ $('#card_ending_month_div').hide(); }, 3000);
		$( "#card_ending_month").focus();
		return false;
	}
        if($("#card_ending_year").val() == "" )
	{
		var msg = 'Please enter card expairy year';
		$('#card_ending_year_div').show();
		$('#card_ending_year_div').css("color","red");
		$('#card_ending_year_div').html(msg);
		setTimeout(function(){ $('#card_ending_year_div').hide(); }, 3000);
		$( "#card_ending_year").focus();
		return false;
	}
	
	return true;
});
</script>
<style>

	#Payment_card_name, #card_ending_year, #card_ending_month,#Card_CVV,#Payment_card_no{
		border-left: none;
		border-right: none;
		border-top: none;
		padding:1%;
		outline: none;
		width: 100%;
		
	}
	
	
	::placeholder{
		color:#858a8a;
	}
</style>
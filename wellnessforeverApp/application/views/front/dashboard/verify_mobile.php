<?php $this->load->view('front/header/header'); ?>

<?php
	$Current_point_balance = ($Enroll_details->Total_balance-$Enroll_details->Debit_points);
	if($Current_point_balance<0){
		$Current_point_balance=0;
	}else{
		$Current_point_balance=$Current_point_balance;
	}
	
?>
	
		
<header>
	<div class="container">
		<div class="row">
			<div class="col-12" style="height: 22px;">
			<!--<img style="height: 44px;" src="<?php echo base_url(); ?>assets/img/default-black-top.png">-->
			</div>
			<div class="col-12 d-flex justify-content-between align-items-center hedMain">
			
				<div class="leftRight"><button id="sidebarCollapse" ></div>
				<div><h1>Verify Mobile</h1></div>
				<div class="leftRight">&nbsp;</div>
			</div>
		</div>
	</div>
</header>
			
				
<main class="padTop padBottom">
	<div class="container">
		<div class="row">
			<div class="col-12 specialOfferWrapper">
				
				
				<div class="d-flex justify-content-center align-items-center container">
					<div class="card">
						<h5 class="m-0">Verify your phone number</h5>
							
							<div class="d-flex flex-row mt-4 ml-2">
								<form method="post" id="OTP_form" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">	<span class="mobile-text">Enter your OTP code here</b></span><br><br>
									<input type="tel" class="form-control" maxlength="1" id="digit-1" name="digit-1" class="form-control" autofocus  data-next="digit-2" style="font-size: 20px;border: 1px solid;margin-right: 5%;float: left;width:20%" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="Verifiy_pin();">
									<input type="tel" class="form-control" maxlength="1" id="digit-2" name="digit-2" data-next="digit-3" style="font-size: 20px;border: 1px solid;margin-right: 5%;float: left;width:20%" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="Verifiy_pin();">
									<input type="tel" class="form-control" maxlength="1" id="digit-3" name="digit-3" data-next="digit-4"  style="font-size: 20px;border: 1px solid;margin-right: 5%;float: left;width:20%" onkeyup="this.value=this.value.replace(/\D/g,'')" onchange="Verifiy_pin();">
									<input type="tel" class="form-control" maxlength="1" id="digit-4" name="digit-4"  data-next="digit-5" style="font-size: 20px;border: 1px solid;margin-right: 5%;float: left;width:20%" onkeyup="this.value=this.value.replace(/\D/g,'')">
								</form>
								
							</div>
							<div class="help-block" style="float: center;"></div>
							<div class="text-center mt-5">
								<!-----onclick="Verifiy_pin();"--->
								<button type="button" class="redBtn w-100 text-center" value="submit" name="submit" onclick="Submit_form();">Submit</button>
							</div>
							<div class="text-center mt-5">
								<span class="d-block mobile-text">Didn't receive the OTP?</span>
								<a href="JavaScript:void(0);" onclick="Resend_opt();"><span class="font-weight-bold text-danger cursor">Resend</span></a>
							</div>
					</div>
				</div>
								
								
								
			</div>
		</div>
	</div>
</main>				
	
<?php /* ?>
<footer>
	<ul class="iconMenu d-flex align-items-center">
		<li><a class="home <?php echo $homecss; ?>" href="<?php echo base_url(); ?>index.php/Cust_home/front_home">&nbsp;</a></li>
		<li><a class="user <?php echo $usercss; ?>" href="<?php echo base_url(); ?>index.php/Cust_home/myprofile">&nbsp;</a></li>
		<li><a class="points <?php echo $pointscss; ?>" href="<?php echo base_url(); ?>index.php/Cust_home/redeem_history">&nbsp;</a></li>
		<li><a class="noti <?php echo $noticss; ?>" href="<?php echo base_url(); ?>index.php/Cust_home/mailbox">&nbsp;</a></li>
	</ul>
</footer><?php */ ?>
<div class="overlay"></div>	
<!--<script src="<?php echo base_url(); ?>assets/js/jquery-3.5.1.slim.min.js"></script>
<script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script> -->

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/slick.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/common.js"></script>
	
<script src="<?php echo base_url(); ?>assets/js/intlTelInput.js"></script>
 
</body>
</html>

<?php //$this->load->view('front/header/footer');  ?>


<script type="text/javascript">
	$('.digit-group').find('input').each(function() {
		$(this).attr('maxlength', 1);
		$(this).on('keyup', function(e) {
			var parent = $($(this).parent());
			
			
			
			
			
			// alert("KeyValue---"+e.key);
			
			
			if(e.key >= 0 || e.key <= 9)
			{
				// alert("222---");
				var next = parent.find('input#' + $(this).data('next'));
				
				if(next.length) {
					$(next).select();
				} else {
					if(parent.data('autosubmit')) {
						parent.submit();
					}
				}
				
			} else {
				
				// alert("111---");
				var prev = parent.find('input#' + $(this).data('previous'));
				
				if(prev.length) {
					
					$(prev).select();
				}
				
			} 
		});
	});
	
function Verifiy_pin()
{	

	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var Enrollement_id = '<?php echo $Enroll_details->Enrollement_id; ?>';
	// alert("Company_id---"+Company_id);
	// alert("Enrollement_id---"+Enrollement_id);
	var digit1 = $('#digit-1').val();
	var digit2 = $('#digit-2').val();
	var digit3 = $('#digit-3').val();
	var digit4 = $('#digit-4').val();
	// alert("digit1---"+digit1+"--digit2---"+digit2+"--digit3---"+digit3+"--digit4---"+digit4);
	var Pin = digit1+digit2+digit3+digit4;
	// alert("Pin---"+Pin);
	var Pin_length = Pin.length;
	// alert("Pin_length---"+Pin_length);
	if(Pin_length !=4)
	{
		var msg1 = 'Enter 4 digit code';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg1);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
		return;
	}
	$.ajax({
		type: "POST",
		data: { Enrollement_id: Enrollement_id, Company_id:Company_id, Pin:Pin},
		url: "<?php echo base_url()?>index.php/Cust_home/Verifiy_otp",
		success: function(data)
		{		

			// alert("data---"+data);
			if(data == 0)
			{
				$("#digit-1").val("");					
				$("#digit-2").val("");					
				$("#digit-3").val("");					
				$("#digit-4").val("");					
				var msg1 = 'Enter valid OTP code';
				$('.help-block').show();
				$('.help-block').css("color","red");
				$('.help-block').html(msg1);
				setTimeout(function(){ $('.help-block').hide(); }, 3000);
			}
			else if(data == 1)
			{
				var msg1 = 'Success';
				$('.help-block').show();
				$('.help-block').css("color","green");
				$('.help-block').html(msg1);
				setTimeout(function(){ $('.help-block').hide(); }, 3000);
				
				// window.location.href = "<?php echo base_url(); ?>index.php/Cust_home/validate_opt?otp="+Pin;
			}
		}
	});
}

function Submit_form()
{	

	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var Enrollement_id = '<?php echo $Enroll_details->Enrollement_id; ?>';
	// alert("Company_id---"+Company_id);
	// alert("Enrollement_id---"+Enrollement_id);
	var digit1 = $('#digit-1').val();
	var digit2 = $('#digit-2').val();
	var digit3 = $('#digit-3').val();
	var digit4 = $('#digit-4').val();
	// alert("digit1---"+digit1+"--digit2---"+digit2+"--digit3---"+digit3+"--digit4---"+digit4);
	var Pin = digit1+digit2+digit3+digit4;
	// alert("Pin---"+Pin);
	var Pin_length = Pin.length;
	// alert("Pin_length---"+Pin_length);
	if(Pin_length !=4)
	{
		var msg1 = 'Enter 4 digit code';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg1);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
		return;
	}
	$.ajax({
		type: "POST",
		data: { Enrollement_id: Enrollement_id, Company_id:Company_id, Pin:Pin},
		url: "<?php echo base_url()?>index.php/Cust_home/Verifiy_otp",
		success: function(data)
		{		

			// alert("data---"+data);
			if(data == 0)
			{
				$("#digit-1").val("");					
				$("#digit-2").val("");					
				$("#digit-3").val("");					
				$("#digit-4").val("");					
				var msg1 = 'Enter valid OTP code';
				$('.help-block').show();
				$('.help-block').css("color","red");
				$('.help-block').html(msg1);
				setTimeout(function(){ $('.help-block').hide(); }, 3000);
			}
			else if(data == 1)
			{
				/* var msg1 = 'Success';
				$('.help-block').show();
				$('.help-block').css("color","green");
				$('.help-block').html(msg1);
				setTimeout(function(){ $('.help-block').hide(); }, 3000); */
				
				window.location.href = "<?php echo base_url(); ?>index.php/Cust_home/validate_opt?Pin="+Pin;
			}
		}
	});
}
function Resend_opt()
{	

	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var Enrollement_id = '<?php echo $Enroll_details->Enrollement_id; ?>';
	
	$.ajax({
		type: "POST",
		data: { Enrollement_id: Enrollement_id, Company_id:Company_id},
		url: "<?php echo base_url()?>index.php/Cust_home/resend_opt",
		success: function(data)
		{		

			// alert("data---"+data);
			if(data == 0)
			{
				$("#digit-1").val("");					
				$("#digit-2").val("");					
				$("#digit-3").val("");					
				$("#digit-4").val("");					
				var msg1 = 'Unable to send OTP code. Please try again later';
				$('.help-block').show();
				$('.help-block').css("color","red");
				$('.help-block').html(msg1);
				setTimeout(function(){ $('.help-block').hide(); }, 3000);
			}
			else if(data == 1)
			{
				 var msg1 = 'Mobile verification OTP code is sent on registered mobile number.';
				$('.help-block').show();
				$('.help-block').css("color","green");
				$('.help-block').html(msg1);
				setTimeout(function(){ $('.help-block').hide(); }, 3000); 
				
				// window.location.href = "<?php echo base_url(); ?>index.php/Cust_home/validate_opt?Pin="+Pin;
			}
		}
	});
}


   </script>
   
   <script>
   var input = document.getElementById("digit-1");
   input.addEventListener("keydown", function (e) {
	   
	   
	   
		var digit1 = $('#digit-1').val();
		var digit2 = $('#digit-2').val();
		var digit3 = $('#digit-3').val();
		var digit4 = $('#digit-4').val();
		var Pin = digit1+digit2+digit3+digit4;
		var Pin_length = Pin.length;
	   
	   
	   
	   // alert("Verifiy_pin---"+e.key);
	   if(e.key >= 0 || e.key <= 9){
		   
		   $('#digit-1').val(e.key);
		   
			if(Pin_length==4){
			   
			   Verifiy_pin();
			}
		   
		   
		    
	   } else {
		   
		   // $('#digit-1').val("");
	   }
	});
	var input2 = document.getElementById("digit-2");
   input2.addEventListener("keydown", function (e) {
	   
	   var digit1 = $('#digit-1').val();
		var digit2 = $('#digit-2').val();
		var digit3 = $('#digit-3').val();
		var digit4 = $('#digit-4').val();
		var Pin = digit1+digit2+digit3+digit4;
		var Pin_length = Pin.length;
	   if(e.key >= 0 || e.key <= 9){
		   
		   $('#digit-2').val(e.key);
		    if(Pin_length==4){
			   
			   Verifiy_pin();
			}
	   } else {
		   // $('#digit-2').val("");
	   }
	}); 
	var input3 = document.getElementById("digit-3");
   input3.addEventListener("keydown", function (e) {
	   var digit1 = $('#digit-1').val();
		var digit2 = $('#digit-2').val();
		var digit3 = $('#digit-3').val();
		var digit4 = $('#digit-4').val();
		var Pin = digit1+digit2+digit3+digit4;
		var Pin_length = Pin.length;
	   if(e.key >= 0 || e.key <= 9){
		   
		   $('#digit-3').val(e.key);
		    if(Pin_length==4){
			   
			   Verifiy_pin();
			}
	   } else {
		   // $('#digit-3').val("");
	   }
	}); 
	var input4 = document.getElementById("digit-4");
   input4.addEventListener("keydown", function (e) {
	   // alert("Verifiy_pin---"+e.key);
	   if(e.key >= 0 || e.key <= 9){
		   
		   $('#digit-4').val(e.key);
		 
			   
			   Verifiy_pin();
			
	   } else {
		   // $('#digit-4').val("");
	   }
	});
</script>
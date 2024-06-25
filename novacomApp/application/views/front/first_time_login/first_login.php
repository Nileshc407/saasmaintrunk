<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if($icon_src=="white") { $icon_src1="black"; } else { $icon_src1=$icon_src; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>First Time Login</title>	
	<?php $this->load->view('front/header/header'); ?> 	
</head>
<body>
<?php echo form_open_multipart('Cust_home/first_time_login', array( 'id' => 'loginForm', 'name' => 'loginForm')); ?>  
    <!-- Start Pricing Table Section -->
    <div id="application_theme" class="section pricing-section" style="min-height: 500px;">
      <div class="container">
		<div class="section-header">
		   <br/><br/><p id="Extra_large_font" style="margin-left: -3%;">First Time Login</p>
		</div>

        <div class="row pricing-tables">
          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s">
                <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/user.png" class="img-responsive" style="width:40%; border-radius:50%; border: 4px solid <?php echo $Button_font_details[0]['Button_border_color'];?>;" >
              <div class="pricing-details">
                <div class="pricing-details" >
                    
                    <ul style="padding:0px;margin-bottom: 0px;text-align: left;">            
                        
                        <br>
                        <label><span style="font-size: 12px; font-style: italic; color: red;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/right-hand.png" style="width:80%;"> </span> Password Policy</label><br>                            
                        <span id="6_characters" ></span> <img id="6_characters_img" src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/cross.png" style="width: 10%;"> Password is minimum 6 characters<br>
                        <span id="One_Capital" ></span><img id="One_Capital_img" src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/cross.png" style="width: 10%;">  One Upper Case Letter<br>
                        <span id="One_Lower" ></span><img id="One_Lower_img" src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/cross.png" style="width: 10%;">  One Lower Case Letter<br>
                        <span id="Special_Character" ></span> <img id="Special_Character_img" src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/cross.png" style="width: 10%;"> Special Character <br>
                        <span id="One_Number" ></span> <img id="One_Number_img" src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/cross.png" style="width: 10%;"> One Number <br>                              
                                  
                    </ul>   
                    <br>
					<ul>              
						<li>New Password : <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/eye.png" style="width: 10%;" onclick="showHide();">				  
							<strong>
								<input type="password" id="New_Password" name="New_Password" placeholder="Enter new password" >
							</strong> 
							
						</li>
						<div id="new_password_div"></div>
						<li>Confirm Password : <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/eye.png" style="width: 10%;" onclick="showHide1();">
							<strong>                           
								<input type="password" id="Confirm_New_Password" name="Confirm_New_Password" placeholder="Enter confirm new password">                            
							</strong>                        
						</li>
						<div id="Password_match" style="float:right;"></div>
					</ul>
				</div>
                  
				<div id="gj-counter-box">
					<h1 id="gj-counter-num"></h1>
				</div>
				<div id="Password_success" style="float:right;"></div>
				<br>
				<button id="button" type="submit"> Save</button>
				<input type="hidden" name="Login_data" value="<?php echo $Login_data; ?>" />
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 <!-- End Pricing Table Section 
	<div class="footer">
		<div class="row" id="foot1">
			<div class="col-xs-12 text-center">
				<strong>Powered By <a target="_blank" href="<?php echo $partner_Company_Website; ?>" title="<?php echo $partner_Company_name; ?>"><?php echo $partner_Company_name; ?></a></strong><br>
				<strong>Copyright &copy; 2015-2020 <a href="#" target="_blank"><?php echo $partner_Company_name; ?></a>.</strong> All rights reserved. 
			</div>			
		</div>
	</div>
 Loader -->	
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
<?php echo form_close(); ?>
    <?php $this->load->view('front/header/footer');?> 
    <?php
	if(@$this->session->flashdata('invalid_error_code'))
	{
	?>
		<script> 
			var msg1 = '<?php echo $this->session->flashdata('invalid_error_code'); ?>';
			$('#Password_success').show();
			$('#Password_success').html(msg1);
			
		   /* setTimeout(function(){ 
					$('#Password_success').hide(); 
					 gjCountAndRedirect(10, document.URL);
			}, 3000); */
			
			
			setTimeout(function() 
			{
					$('#myModal').modal('show');	
			}, 0);
			setTimeout(function() 
			{ 
					$('#myModal').modal('hide');	
					gjCountAndRedirect(3, document.URL);
			},3000); 
		</script>
	<?php
	}
	?>
	
<script>                               
function gjCountAndRedirect(secounds, url) {

var url = '<?php echo base_url()?>index.php/Cust_home/front_home';
  $('#gj-counter-num').text(secounds);

  $('#gj-counter-box').show();

  var interval = setInterval(function() {

    secounds = secounds - 1;

    $('#gj-counter-num').text(secounds);

    if (secounds == 0) {

      clearInterval(interval);
      window.location = url;
      $('#gj-counter-box').hide();

    }

  }, 1000);

  $('#gj-counter-box').click(function() {
    clearInterval(interval);
    window.location = url;

  });
}

// USE EXAMPLE
/*$(document).ready(function() {
  //call
  gjCountAndRedirect(10, document.URL);
});
*/
</script>
<style>
	a {
            color: #7d7c7c;
	}	
	#New_Password,#Confirm_New_Password{
		border-left: none;
		border-right: none;
		border-top: none;
		padding: 5% 0 0 0px;
		outline: none;
		width: 100%;
		margin-left: 1%;
	}
	         
        @keyframes gjPulse {
  0% {
    width: 90px;
    height: 90px;
  }
  25% {
    width: 105px;
    height: 105px;
  }
  50% {
    width: 130px;
    height: 130px;
  }
  75% {
    width: 110px;
    height: 110px;
  }
  100% {
    width: 90px;
    height: 90px;
  }
}
#gj-counter-box {
  margin: auto;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  opacity: 0.2;
  width: 90px;
  height: 90px;
  background-color: rgb(183, 0, 0);
  border-radius: 50%;
  border: 6px solid white;
  visibility: none;
  display: none;
  animation: gjPulse 1s linear infinite;
}

#gj-counter-box:hover {
  opacity: 1;
  cursor: pointer;
}

#gj-counter-num {
  position: relative;
  text-align: center;
  margin: 0px;
  padding: 0px;
  top: 50%;
  transform: translate(0%, -50%);
  color: white;
}
</style>
<script>

function showHide() {
    if ($("#New_Password").attr("type") == "password") {
      $("#New_Password").attr("type", "text");

    } else {
      $("#New_Password").attr("type", "password");
    }
  }
function showHide1() {
    if ($("#Confirm_New_Password").attr("type") == "password") {
      $("#Confirm_New_Password").attr("type", "text");

    } else {
      $("#Confirm_New_Password").attr("type", "password");
    }
  }

Validate_array = new Array();

$("#button").click(function()
{   
   // alert('button');
   // return false;
   
   /* setTimeout(function() 
	{
		$('#myModal').modal('show');	
	}, 0);
	setTimeout(function() 
	{ 
			$('#myModal').modal('hide');
	},2000);  */
        
	var ucase = new RegExp("[A-Z]+");
	var lcase = new RegExp("[a-z]+");
	var num = new RegExp("[0-9]+");
	// var special = new RegExp("/^[a-zA-Z0-9- ]*$/");
	var new_password=$("#New_Password").val();
	var Confirm_Password=$("#Confirm_New_Password").val();
	var Error_count=0;
	
        if(new_password.length >= 6 )
        {			
            document.getElementById("6_characters_img").src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/correct.png";
            $("#6_characters_img").css("width","10%");
        }
        else
        {			
            document.getElementById("6_characters_img").src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/cross.png";
            $("#6_characters_img").css("width","10%");
            Error_count++; 
            
            var msg1 = 'Please check the password policy.';
            $('#new_password_div').show();  
			$('#new_password_div').css("color","red");			
            $('#new_password_div').html(msg1);
            setTimeout(function(){ $('#new_password_div').hide(); }, 3000);
           
        }
        if(num.test(new_password) == true )
        {
            document.getElementById("One_Number_img").src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/correct.png";
            $("#One_Number_img").css("width","10%");			
        }
        else
        {										
            document.getElementById("One_Number_img").src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/cross.png";
            $("#One_Number_img").css("width","10%");
            Error_count++;
            
            var msg1 = 'Please check the password policy.';
            $('#new_password_div').show();   
			$('#new_password_div').css("color","red");				
            $('#new_password_div').html(msg1);
            setTimeout(function(){ $('#new_password_div').hide(); }, 3000);
        }
        if(ucase.test(new_password) == true )
        {
            document.getElementById("One_Capital_img").src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/correct.png";
            $("#One_Number_img").css("width","10%");			
        }
        else
        {
            document.getElementById("One_Capital_img").src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/cross.png";
            $("#One_Capital_img").css("width","10%");	
            Error_count++;
            
            var msg1 = 'Please check the password policy.';
            $('#new_password_div').show();  
			$('#new_password_div').css("color","red");				
            $('#new_password_div').html(msg1);
            setTimeout(function(){ $('#new_password_div').hide(); }, 3000);
        }		
        if (/^[a-zA-Z0-9- ]*$/.test(new_password) == false) 
        {
            document.getElementById("Special_Character_img").src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/correct.png";
            $("#Special_Character_img").css("width","10%");
        }
        else
        {
            document.getElementById("Special_Character_img").src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/cross.png";
            $("#Special_Character_img").css("width","10%");
            Error_count++;
            
            var msg1 = 'Please check the password policy.';
            $('#new_password_div').show();  
			$('#new_password_div').css("color","red");	
            $('#new_password_div').html(msg1);
            setTimeout(function(){ $('#new_password_div').hide(); }, 3000);
        }
        if(lcase.test(new_password) == true  )
        {
            document.getElementById("One_Lower_img").src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/correct.png";
            $("#One_Lower_img").css("width","10%");			
        }
        else
        {
            document.getElementById("One_Lower_img").src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src1; ?>/cross.png";
            $("#One_Lower_img").css("width","10%");
            Error_count++;
            
            var msg1 = 'Please check the password policy.';
            $('#new_password_div').show();     
			$('#new_password_div').css("color","red");	
            $('#new_password_div').html(msg1);
            setTimeout(function(){ $('#new_password_div').hide(); }, 3000);
        }		
	if(Error_count == 0)
	{
		var n = Confirm_Password.localeCompare(new_password);
		if( n == 0 )
		{
			//$('#show_loader').modal('show');
			return true;			
		}
		else
		{
			var msg1 = 'New password and confirm new password did not match.';
			$('#Password_match').show();
			$('#Password_match').css("color","red");	
			$('#Password_match').html(msg1);
			setTimeout(function(){ $('#Password_match').hide(); }, 3000);
			// document.getElementById("password_match").style.display="";
			//$('#password_match').modal('show');
			return false;
		}
		
		setTimeout(function() 
		{
				$('#myModal').modal('show');	
		}, 0);
		setTimeout(function() 
		{ 
				$('#myModal').modal('hide');	
		},3000);
		
		return true;
	}
	else
	{
		return false;
	}
});
</script>
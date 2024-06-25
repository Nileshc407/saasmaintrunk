<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Profile</title>	
<?php $this->load->view('front/header/header'); 
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?> 
</head>
<body>
<form  name="Change_Pswd" method="POST" action="<?php echo base_url()?>index.php/Cust_home/changepassword" enctype="multipart/form-data" onsubmit="return Change_password('old_Password.value,new_Password.value,confirm_Password.value');">	
<div id="application_theme" class="section pricing-section" style="min-height: 550px;">
	<div class="container">
		<div class="section-header">          
			<p><a href="<?php echo base_url();?>index.php/Cust_home/profile" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font" style="margin-left: -3%;">Change Password</p>
		</div>
		<div class="row pricing-tables">
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
				<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">   	
					<div class="pricing-details">
						<ul>
						  <li id="Medium_font">Your password should be a minimum of 6 characters with at least one number, one special characters, one upper case & one lower case letter. </li> 
						   <li id="Small_font" class="text-left">
								
								<strong id="Value_font"> <input type="password" name="old_Password" id="old_Password" class="txt" placeholder="Enter old password"> </strong>
								<div class="help-block" style="float:center;"></div>
							</li>
						 
							<li id="Small_font" class="text-left">  
								<strong id="Value_font">  
									<input type="password"  name="new_Password"  id="new_Password" placeholder="Enter new password" class="txt" > 
								</strong> 
								<div class="help-block2" style="float:center;"></div>
								<strong><br> <input type="checkbox" id="showHide"> Show Password </strong>	 
							</li>
							<li id="Small_font" class="text-left">
								<strong id="Value_font">
									<input type="password"  name="confirm_Password"   id="confirm_Password" placeholder="Enter confirm password" class="txt">
								</strong> 
								<div class="help-block1" style="float:center;"></div>
							</li>
						</ul>
					</div>
					<address>
						<button type="submit"  onclick="Change_password('old_Password.value,new_Password.value,confirm_Password.value');" id="button">Submit</button>
					</address>
					<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>">
					<input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>">
				</div>
			</div>
		</div>    
	</div>
</div>
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
			<!-- Modal content-->
		  </div>
	 </div>       
</div>
<!-- Loader -->
</form>
<?php $this->load->view('front/header/footer'); ?> 
<style>
	
	.pricing-table .pricing-details ul li 
	{
		padding: 10px;
		font-size: 13px;
		border-bottom: 1px solid #eee;
		color: #7d7c7c;
		text-align: center;
	}
	.pricing-table .pricing-details span {
		display: inline-block;
		font-size: 13px;
		font-weight: 400;
		color: #000000;
		margin-bottom: 20px;
	}
	
	h1, h2, h3, h4, h5, h6 {
		margin-top: 10px;
	}
	.custom-form 
	{
  
  font-family: 'Roboto', sans-serif;
  font-weight: 400;
  font-size: 16px;
  max-width: 360px;
  margin: 40px auto 40px;
  background: #fff;
  padding: 40px;
  border-radius: 4px;
  .btn-primary {
    background-color: #8e44ad;
    border-color: #8e44ad;
  }
  .form-group {
    position: relative;
    padding-top: 16px;
    margin-bottom: 16px;
    .animated-label {
      position: absolute;
      top: 20px;
      left: 0;
      bottom: 0;
      z-index: 2;
      width: 100%;
      font-weight: 300;
      opacity: 0.5;
      cursor: text;
      transition: 0.2s ease all;
      margin: 0;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
      &:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 45%;
        height: 2px;
        width: 10px;
        visibility: hidden;
        background-color:#8e44ad;
        transition: 0.2s ease all;
      }
    }
    &.not-empty {
      .animated-label {
        top: 0;
        font-size: 12px;
      }
    }
    .form-control {
      position: relative;
      z-index: 1;
      border-radius: 0;
      border-width: 0 0 1px;
      border-bottom-color: rgba(0,0,0,0.25);
      height: auto;
      padding: 3px 0 5px;
      &:focus {
        box-shadow: none;
        border-bottom-color: rgba(0,0,0,0.12);
        ~ .animated-label {
          top: 0;
          opacity: 1;
          color: #8e44ad;
          font-size: 12px;
          &:after {
            visibility: visible;
            width: 100%;
            left: 0;
          }
        }
      }
    }
  }
}

	#txt{
		border-left: none;
		border-right: none;
		border-top: none;
		padding: 4% 1% 2% 1%;
		outline: none;
		width: 100%;
		margin-left: 0%;
		
	}
	.txt{
		border-left: none;
		border-left: none;
		border-top: none;
		padding: 4% 1% 2% 1%;
		outline: none;
		width: 100%;
		margin-left: 0%;
		
	}
	<?php /*#showHide {
  width: 15px;
  height: 15px;
  float: left;
} */ ?>
#showHideLabel {
  float: left;
  padding-left: 5px;
}
input[type=checkbox]
{
  -webkit-appearance:checkbox;
}
@media only screen and (min-width: 320px) {
    .showPwd {
        
		margin-left:46.5%;
    }
}
@media only screen and (min-width: 768px) {
    .showPwd {
        margin-left:23.5%;
    }
}
</style>
<script>
$(document).ready(function() {
  $("#showHide").click(function() {
	if ($("#new_Password").attr("type") == "password") {
      $("#new_Password").attr("type", "text");

    } else {
      $("#new_Password").attr("type", "password");
    }
  });
});

function Change_password(old_Password,new_password,Confirm_Password)
{ 
	var ucase = new RegExp("[A-Z]+");
	var lcase = new RegExp("[a-z]+");
	var num = new RegExp("[0-9]+");
	var new_password=$("#new_Password").val();
	var Confirm_Password=$("#confirm_Password").val();
	var Error_count=0;
	
		if( $('#old_Password').val() == "" || $('#old_Password').val() == null )
		{
			var msg = 'Please Fill Out Field.';
			$('.help-block').show();
			$('.help-block').css("color","red");
			$('.help-block').html(msg);
			setTimeout(function(){ $('.help-block').hide(); }, 3000);
			return false;
		}
		else if($('#new_Password').val() == "" && $('#confirm_Password').val() == "")
		{
			var msg2 = 'Please Fill Out Field.';
			$('.help-block2').show();
			$('.help-block2').css("color","red");
			$('.help-block2').html(msg2);
			setTimeout(function(){ $('.help-block2').hide(); }, 3000);
			return false;
		}
		else if( $('#new_Password').val() !=  $('#confirm_Password').val())
		{
			$("#confirm_Password").val("");	
			var msg1 = 'Confirm Password should be same as New Password.';
			$('.help-block1').show();
			$('.help-block1').css("color","red");
			$('.help-block1').html(msg1);
			setTimeout(function(){ $('.help-block1').hide(); }, 3000);
			return false;
		}		
		if(new_password.length >= 6 )
		{}
		else
		{				
			Error_count++;
			// $("#new_Password").val("");	
			// $("#confirm_Password").val("");		
			var msg2 = 'Your Password is Week..Please Enter Strong Password.';
			$('.help-block2').show();
			$('.help-block2').css("color","red");
			$('.help-block2').html(msg2);
			setTimeout(function(){ $('.help-block2').hide(); }, 3000);
		}
		if(num.test(new_password) == true )
		{}
		else
		{											
			Error_count++;
			// $("#new_Password").val("");	
			// $("#confirm_Password").val("");		
			var msg2 = 'Your Password is Week..Please Enter Strong Password.';
			$('.help-block2').show();
			$('.help-block2').css("color","red");
			$('.help-block2').html(msg2);
			setTimeout(function(){ $('.help-block2').hide(); }, 3000);
		}
		if(ucase.test(new_password) == true )
		{}
		else
		{	
			Error_count++;
			// $("#new_Password").val("");	
			// $("#confirm_Password").val("");		
			var msg2 = 'Your Password is Week..Please Enter Strong Password.';
			$('.help-block2').show();
			$('.help-block2').css("color","red");
			$('.help-block2').html(msg2);
			setTimeout(function(){ $('.help-block2').hide(); }, 3000);
		}		
		if (/^[a-zA-Z0-9- ]*$/.test(new_password) == false) 
		{}
		else
		{	
			Error_count++;
			// $("#new_Password").val("");	
			// $("#confirm_Password").val("");		
			var msg2 = 'Your Password is Week..Please Enter Strong Password.';
			$('.help-block2').show();
			$('.help-block2').css("color","red");
			$('.help-block2').html(msg2);
			setTimeout(function(){ $('.help-block2').hide(); }, 3000);
		}
		if(lcase.test(new_password) == true  )
		{}
		else
		{	
			Error_count++;
			// $("#new_Password").val("");	
			// $("#confirm_Password").val("");		
			var msg2 = 'Your Password is Week..Please Enter Strong Password.';
			$('.help-block2').show();
			$('.help-block2').css("color","red");
			$('.help-block2').html(msg2);
			setTimeout(function(){ $('.help-block2').hide(); }, 3000);
		}	
	if(Error_count == 0)
	{	
		var n = Confirm_Password.localeCompare(new_password);
		if( n == 0 )
		{
			setTimeout(function() 
			{
				$('#myModal').modal('show'); 
			}, 0);
			setTimeout(function() 
			{ 
				$('#myModal').modal('hide'); 
			},2000);
			
			// document.Change_Pswd.submit();
			
			return true;	
		}
		else
		{
			return false;
		}
		return true;
	}
	else
	{
		return false;
	}
}
$('#old_Password').blur(function()
{	
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var Enrollment_id = '<?php echo $Enroll_details->Enrollement_id; ?>';
	var old_Password = $('#old_Password').val();
	
	if( $("#old_Password").val() == "" )
	{
		var msg = 'Old Password does not Match.';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { old_Password: old_Password, Company_id:Company_id,Enrollment_id: Enrollment_id},
			url: "<?php echo base_url()?>index.php/Cust_home/checkoldpassword",
			success: function(data)
			{				
				if(data == 0)
				{ 
					$("#old_Password").val("");	
					var msg1 = 'Password not Match..Please Enter Correct Password.';
					$('.help-block').show();
					$('.help-block').css("color","red");
					$('.help-block').html(msg1);
					setTimeout(function(){ $('.help-block').hide(); }, 3000);
				}
				else
				{
				}
			}
		});
	}
});
</script>
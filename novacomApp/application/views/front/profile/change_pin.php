<!DOCTYPE html>
<html lang="en">
<head>
<title>Profile</title>	
<?php $this->load->view('front/header/header'); 
if($icon_src=="green") { $foot_icon="white"; } else { $foot_icon=$icon_src; } ?> 
</head>
<body>
 <form name="Change_Pin" method="POST" action="<?php echo base_url()?>index.php/Cust_home/changepin" enctype="multipart/form-data" onsubmit="return Change_pin('old_pin.value,new_pin.value,confirm_pin.value');">	
<div id="application_theme" class="section pricing-section" style="min-height: 550px;">
    <div class="container">
		<div class="section-header">          
			<p><a href="<?=base_url()?>index.php/Cust_home/profile" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font" style="margin-left: -3%;">Change Pin</p>
		</div>
        <div class="row pricing-tables">
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
				<div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">      
				  <div class="pricing-details">
					<ul>
					  <li id="Small_font" class="text-left">
						<strong id="Value_font">
							<input type="password" name="old_pin" id="old_pin" placeholder="Enter old pin" class="txt" maxlength="4" onkeyup="this.value=this.value.replace(/\D/g,'')">
						</strong>
						<div class="help-block" style="float:center;"></div>
					  </li>
					  <li id="Small_font" class="text-left">
						<strong id="Value_font">
							<input type="password" name="new_pin" id="new_pin" placeholder="Enter new pin" class="txt" maxlength="4" onkeyup="this.value=this.value.replace(/\D/g,'')">
						</strong>
							<div class="help-block2" style="float:center;"></div>
							<strong><br> <input type="checkbox" id="showHide"> Show Pin </strong>						
						<div class="help-block2" style="float:center;"></div>
					  </li>
					  <li id="Small_font" class="text-left">
						<strong id="Value_font">
							<input type="password" class="txt" name="confirm_pin" placeholder="Enter confirm pin" id="confirm_pin" maxlength="4" onkeyup="this.value=this.value.replace(/\D/g,'')">
						</strong>
						<div class="help-block1" style="float:center;"></div>
					  </li>
					</ul>
				  </div>
				  <address>
					<button type="submit" id="button">Submit</button>
				 </address>
					<input type="hidden" name="Enrollment_id" value="<?php echo $Enroll_details->Enrollement_id; ?>">
					<input type="hidden" name="Company_id" value="<?php echo $Enroll_details->Company_id; ?>">
				</div>
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
			<!-- Modal content-->
		  </div>
	 </div>       
</div>
<!-- Loader -->
</form>
<?php $this->load->view('front/header/footer'); ?> 
<style>
	
	.pricing-table .pricing-details ul li {
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
	
	.custom-form {
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
	.X{
		color:#1fa07f;
	}
	
	#icon{
		width: 6%;
		margin-top: 2%;
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
</style>
<script>
$(document).ready(function() {
  $("#showHide").click(function() {
	if ($("#new_pin").attr("type") == "password") {
      $("#new_pin").attr("type", "text");

    } else {
      $("#new_pin").attr("type", "password");
    }
  });
});
$('#old_pin').blur(function()
{	
	var Company_id = '<?php echo $Enroll_details->Company_id; ?>';
	var Enrollment_id = '<?php echo $Enroll_details->Enrollement_id; ?>';
	var old_pin = $('#old_pin').val();
	
	if( $("#old_pin").val() == "" )
	{
		var msg = 'Old Pin does not Match.';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
	}
	else
	{
		$.ajax({
			type: "POST",
			data: { old_pin: old_pin, Company_id:Company_id,Enrollment_id: Enrollment_id},
			url: "<?php echo base_url()?>index.php/Cust_home/checkoldpin",
			success: function(data)
			{			
				if(data == 0)
				{
					$("#old_pin").val("");
					var msg1 = 'Pin not Match..Please Enter Correct Pin';
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
function Change_pin(old_pin,new_pin,confirm_pin)
{
	
	if( $('#old_pin').val() == "")
	{
		var msg = 'Please enter old Pin.';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
		return false;
	}
	else if( $('#new_pin').val() !=  $('#confirm_pin').val())
	{
		$('#confirm_pin').val('');
		var msg = 'Confirm Pin should be same as New Pin.';
		$('.help-block1').show();
		$('.help-block1').css("color","red");
		$('.help-block1').html(msg);
		setTimeout(function(){ $('.help-block1').hide(); }, 3000);
		return false;
	}
	else if($('#new_pin').val() == "" && $('#confirm_pin').val() == "")
	{
		var msg = 'New Pin should not be blank.';
		$('.help-block2').show();
		$('.help-block2').css("color","red");
		$('.help-block2').html(msg);
		setTimeout(function(){ $('.help-block2').hide(); }, 3000);
		return false;
	}
	else 
	{
		setTimeout(function() 
		{
			$('#myModal').modal('show'); 
		}, 0);
		setTimeout(function() 
		{ 
			$('#myModal').modal('hide'); 
		},2000);
		
		// document.Change_Pin.submit();
	}
}
</script>
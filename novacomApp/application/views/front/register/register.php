<!DOCTYPE html>
<html lang="en">
<head>
<title>Registration</title>	
<?php $this->load->view('front/header/header'); ?>
</style>
</head>	
<body>
<form method="post" id="CreateAccount" action="<?php echo base_url()?>index.php/Cust_home/Create_Account" enctype="multipart/form-data" onsubmit="return form_submit();">	
<div id="application_theme" class="section pricing-section" style="min-height: 550px;">
    <div class="container">
        <div class="section-header">    
			<p><a href="<?=base_url()?>index.php/Login" style="color:#ffffff;"><img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/cross.png" id="arrow"></a></p>
			<p id="Extra_large_font" style="margin-left: -3%;">New member Sign Up</p>
        </div>
        <div class="row pricing-tables">
          <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -31px;">
            <div class="pricing-table wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.3s" id="front_head">      
				<div class="pricing-details"> 
					<ul>
						<li align="left" class="text-left">							
							<strong id="Value_font">
								<input type="text" name="firstName" id="firstName" placeholder="Enter first name" class="txt" onkeyup="this.value=this.value.replace(/[0-9]+/g, '')">
							</strong>	
							<div class="help-block" style="float: center;"></div>							
						</li>				
																  
						<li align="left" class="text-left">					
							<strong id="Value_font">
								<input type="text" name="Last_name" id="Last_name" placeholder="Enter last name" class="txt" onkeyup="this.value=this.value.replace(/[0-9]+/g, '')">
							</strong>	
							<div class="help-block1" style="float: center;"></div>							
						</li> 
											
						<li align="left"  class="text-left">					
							<strong id="Value_font">
								<input type="text" id="userEmailId" name="userEmailId" placeholder="Enter email id" class="txt" id="userEmailId" >
							</strong>
							<div class="help-block2" style="float: center;"></div>
						</li>
						
						<li align="left" class="text-left">
							<span style="font-size: 9px; font-style: italic; color: red;">(* Enter Phone No without Dial Code)</span><br/>						
							<strong id="Value_font">
								<input type="tel" name="Phone_no" placeholder="Enter phone no." class="txt" id="Phone_no" value="<?php echo $phnumber; ?>" onkeyup="this.value=this.value.replace(/\D/g,'')">
							</strong> 
							<div class="help-block3" style="float: center;"></div>
						</li>

						<li align="left"  class="text-left">					
							<strong id="Value_font">
								<input class="txt" id="datepicker1" name="dob" placeholder="Select date of birth">
							</strong>
							<div class="help-block4" style="float: center;"></div>
						</li>					
					</ul>						
			</div>
				<input type="hidden" id="Company_id" name="Company_id" value="3" />
				<input type="hidden" id="dial_code" name="dial_code" value="91" />
				<input type="hidden" id="Cust_Base_url" name="Cust_Base_url" value="<?php echo base_url()?>" />
				<button type="submit" id="button">Register</button>	
            </div>
		</div>	 
	</div>
	</div>
</div>
<!-- Loader --> 
<div class="container" >
	 <div class="modal fade" id="myModal" role="dialog" align="center" data-backdrop="static" data-keyboard="false">
		  <div class="modal-dialog modal-sm" style="margin-top: 65%;">			
			<div class="modal-content" id="loader_model">
			   <div class="modal-body" style="padding: 10px 0px;;">
				 <img src="<?php echo base_url(); ?>assets/icons/<?php echo $icon_src; ?>/loading.gif" alt="" class="img-rounded img-responsive" width="80">
			   </div>       
			</div>    			
		  </div>
	 </div>       
</div>
<!-- Loader -->
<form>
<?php 
$Company_id=3;
$this->load->view('front/header/footer'); ?> 
<style>	
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
	::placeholder{
		color:#858a8a;
	}	
	#datepicker1
	{
		color:<?=$Value_font_details[0]['Value_font_color']; ?>;
		font-family:<?=$Value_font_details[0]['Value_font_family']; ?>;
		font-size:<?=$Value_font_details[0]['Value_font_size']; ?>
	}
	::-moz-placeholder {
    color:<?php echo $Placeholder_font_details[0]['Placeholder_font_color'];?>;
    font-family:<?php echo $Placeholder_font_details[0]['Placeholder_font_family'];?>;
    font-size:<?php echo $Placeholder_font_details[0]['Placeholder_font_size'];?>;
    opacity: 1;
		/* Firefox */
	}
	::-webkit-input-placeholder {
    color:<?php echo $Placeholder_font_details[0]['Placeholder_font_color'];?>;
    font-family:<?php echo $Placeholder_font_details[0]['Placeholder_font_family'];?>;
    font-size:<?php echo $Placeholder_font_details[0]['Placeholder_font_size'];?>;
    opacity: 1;
		/* Chrome */
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() { 
    $( "#datepicker1" ).datepicker({
      changeMonth: true,
	  yearRange: "-80:+0",
      changeYear: true
    });
  });
function form_submit()
{
	if( $("#firstName").val() == "" )
	{	
		var msg1 = 'Please Enter first Name';
		$('.help-block').show();
		$('.help-block').css("color","red");
		$('.help-block').html(msg1);
		setTimeout(function(){ $('.help-block').hide(); }, 3000);
		return false;
	}
	if( $("#Last_name").val() == "" )
	{	
		var msg1 = 'Please Enter Last Name';
		$('.help-block1').show();
		$('.help-block1').css("color","red");
		$('.help-block1').html(msg1);
		setTimeout(function(){ $('.help-block1').hide(); }, 3000);
		return false;
	}
	if( $("#userEmailId").val() == "" )
	{	
		var msg1 = 'Please Enter Email Id';
		$('.help-block2').show();
		$('.help-block2').css("color","red");
		$('.help-block2').html(msg1);
		setTimeout(function(){ $('.help-block2').hide(); }, 3000);
		return false;
	}
	var userEmailId = $("#userEmailId").val();
		
	var n = userEmailId.indexOf("@"); 
	var n1 = userEmailId.lastIndexOf("."); 	
	
	if(n < 0 || n1 < 0 || n1 < n)
	{
		$("#userEmailId").val("");
		var msg1 = 'Please Enter Valid Email Id';
		$('.help-block2').show();
		$('.help-block2').css("color","red");
		$('.help-block2').html(msg1);
		setTimeout(function(){ $('.help-block2').hide(); }, 3000);
		return false;
	}
	if( $("#Phone_no").val() == "" )
	{
		var msg1 = 'Please Enter Phone Number';
		$('.help-block3').show();
		$('.help-block3').css("color","red");
		$('.help-block3').html(msg1);
		setTimeout(function(){ $('.help-block3').hide(); }, 3000);
		return false;
	}
	if( $("#datepicker1").val() == "" )
	{
		var msg1 = 'Please Select Date of Birth';
		$('.help-block4').show();
		$('.help-block4').css("color","red");
		$('.help-block4').html(msg1);
		setTimeout(function(){ $('.help-block4').hide(); }, 3000);
		return false;
	}
	setTimeout(function() 
	{
		$('#myModal').modal('show'); 
	}, 0);
	
	setTimeout(function() 
	{ 
		$('#myModal').modal('hide'); 
	},2000);
}
/************************************************************************/	
</script>